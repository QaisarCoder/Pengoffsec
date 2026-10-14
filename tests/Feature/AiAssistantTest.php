<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AiAssistantTest extends TestCase
{
    use RefreshDatabase;

    private function geminiPayload(array $payload): array
    {
        return [
            'candidates' => [
                ['content' => ['parts' => [['text' => json_encode($payload)]]]],
            ],
        ];
    }

    private function postChat(array $payload = []): \Illuminate\Testing\TestResponse
    {
        return $this->postJson('/api/ai/chat', array_merge([
            'message' => 'hi',
            'history' => [],
            'appointment_state' => [],
        ], $payload));
    }

    public function test_missing_api_key_returns_actionable_error()
    {
        config(['services.gemini.key' => null]);

        $this->postChat()
            ->assertStatus(503)
            ->assertJsonPath('code', 'missing_api_key');
    }

    public function test_it_calls_a_real_gemini_model_id_not_a_fictional_one()
    {
        config(['services.gemini.key' => 'test-key']);

        Http::fake([
            '*' => Http::response($this->geminiPayload(['reply' => 'Hello!']), 200),
        ]);

        $this->postChat()->assertOk();

        Http::assertSent(function ($request) {
            $url = $request->url();

            foreach (['gemini-3.7-flash', 'gpt-', 'claude-'] as $bogus) {
                if (str_contains($url, $bogus)) {
                    return false;
                }
            }

            return (bool) preg_match('#/models/(gemini-[a-z0-9.\-]+):generateContent#', $url);
        });
    }

    public function test_model_config_is_read_from_config()
    {
        config([
            'services.gemini.key' => 'test-key',
            'services.gemini.model' => 'gemini-2.0-flash',
            'services.gemini.fallback_models' => ['gemini-2.5-flash'],
        ]);

        Http::fake(['*' => Http::response($this->geminiPayload(['reply' => 'Hi']), 200)]);

        $this->postChat()->assertOk();

        Http::assertSent(fn ($r) => str_contains($r->url(), 'models/gemini-2.0-flash:generateContent'));
    }

    public function test_it_falls_back_to_another_model_when_primary_404s()
    {
        config([
            'services.gemini.key' => 'test-key',
            'services.gemini.model' => 'primary-model',
            'services.gemini.fallback_models' => ['backup-model'],
        ]);

        Http::fake([
            '*/models/primary-model:*' => Http::response(['error' => 'model not found'], 404),
            '*' => Http::response($this->geminiPayload(['reply' => 'Recovered']), 200),
        ]);

        $response = $this->postChat()->assertOk();

        $this->assertSame('Recovered', $response->json('reply'));
        Http::assertSentCount(2);
    }

    public function test_it_retries_on_server_error_then_succeeds()
    {
        config(['services.gemini.key' => 'test-key']);

        Http::fake([
            '*' => Http::sequence()
                ->push(['error' => 'overloaded'], 503)
                ->push($this->geminiPayload(['reply' => 'Second try worked']), 200),
        ]);

        $this->postChat()->assertOk()->assertJsonPath('reply', 'Second try worked');

        Http::assertSentCount(2);
    }

    public function test_rate_limit_is_reported_clearly()
    {
        config(['services.gemini.key' => 'test-key']);

        // Exhaust every model and every attempt so the final status is 429.
        Http::fake(['*' => Http::response(['error' => 'quota'], 429)]);

        $this->postChat()
            ->assertStatus(503)
            ->assertJsonPath('code', 'rate_limited');
    }

    public function test_consecutive_user_turns_are_merged_for_gemini()
    {
        config(['services.gemini.key' => 'test-key']);

        Http::fake(['*' => Http::response($this->geminiPayload(['reply' => 'ok']), 200)]);

        $this->postChat([
            'message' => 'book with CEO',
            'history' => [
                ['role' => 'user', 'content' => 'i want to book an appointment with CEO'],
                ['role' => 'user', 'content' => 'i want to book an appointment with CEO'],
                ['role' => 'assistant', 'content' => 'Of course. May I have your name?'],
                ['role' => 'user', 'content' => 'Jane Cooper'],
            ],
        ])->assertOk();

        Http::assertSent(function ($request) {
            $contents = $request->data()['contents'];

            // No two adjacent turns may share a role, or Gemini rejects the request.
            for ($i = 1; $i < count($contents); $i++) {
                if ($contents[$i]['role'] === $contents[$i - 1]['role']) {
                    return false;
                }
            }

            // Must open on a user turn.
            return $contents[0]['role'] === 'user' && end($contents)['role'] === 'user';
        });
    }

    public function test_it_handles_json_wrapped_in_markdown_fences()
    {
        config(['services.gemini.key' => 'test-key']);

        Http::fake(['*' => Http::response([
            'candidates' => [['content' => ['parts' => [[
                'text' => "```json\n" . json_encode(['reply' => 'Fenced reply']) . "\n```",
            ]]]]],
        ], 200)]);

        $this->postChat()->assertOk()->assertJsonPath('reply', 'Fenced reply');
    }

    public function test_empty_model_output_does_not_crash()
    {
        config(['services.gemini.key' => 'test-key']);

        Http::fake(['*' => Http::response(['candidates' => []], 200)]);

        $this->postChat()->assertStatus(503)->assertJsonPath('code', 'unavailable');
    }

    public function test_booking_creates_an_appointment_record()
    {
        config(['services.gemini.key' => 'test-key']);
        Service::create(['name' => 'Penetration Testing', 'description' => 'Testing', 'category' => 'Cybersecurity', 'is_active' => true]);

        Http::fake(['*' => Http::response($this->geminiPayload([
            'reply' => 'You are booked in. Reference: POS-X.',
            'appointment_state' => [
                'appointment_intent' => true,
                'client_name' => 'Jane Cooper',
                'client_email' => 'jane@example.com',
                'client_phone' => '+15551234567',
                'service' => 'Penetration Testing',
                'preferred_date' => '2026-11-02',
                'preferred_time' => '10:00',
                'requirements' => 'Meeting the CEO',
                'confirmation_status' => true,
            ],
            'submit' => true,
        ]), 200)]);

        $response = $this->postChat(['message' => 'yes book it'])->assertOk();

        $this->assertTrue($response->json('submit'));
        $this->assertNotNull($response->json('appointment.reference'));

        $this->assertDatabaseHas('appointments', [
            'client_name' => 'Jane Cooper',
            'client_email' => 'jane@example.com',
            'service' => 'Penetration Testing',
            'status' => 'pending',
        ]);

        $this->assertStringStartsWith('POS-', Appointment::first()->reference);
        $this->assertStringContainsString($response->json('appointment.reference'), $response->json('reply'));
    }

    public function test_booking_is_skipped_when_required_fields_are_missing()
    {
        config(['services.gemini.key' => 'test-key']);

        Http::fake(['*' => Http::response($this->geminiPayload([
            'reply' => 'Sure, what is your email?',
            'appointment_state' => [
                'appointment_intent' => true,
                'client_name' => 'Jane',
            ],
            'submit' => true,
        ]), 200)]);

        $this->postChat()->assertOk()->assertJsonPath('appointment', null);

        $this->assertDatabaseCount('appointments', 0);
    }

    public function test_booking_is_skipped_for_an_invalid_email()
    {
        config(['services.gemini.key' => 'test-key']);

        Http::fake(['*' => Http::response($this->geminiPayload([
            'reply' => 'Almost there.',
            'appointment_state' => [
                'appointment_intent' => true,
                'client_name' => 'Jane',
                'client_email' => 'not-an-email',
                'client_phone' => '123',
                'service' => 'Audit',
                'preferred_date' => '2026-11-02',
                'preferred_time' => '10:00',
            ],
            'submit' => true,
        ]), 200)]);

        $this->postChat()->assertOk();

        $this->assertDatabaseCount('appointments', 0);
    }

    public function test_published_services_are_injected_into_the_prompt()
    {
        config(['services.gemini.key' => 'test-key']);
        Service::create([
            'name' => 'OT Infrastructure Security Assessment',
            'description' => 'Specialised testing for industrial control systems.',
            'category' => 'Cybersecurity',
            'is_active' => true,
        ]);

        Http::fake(['*' => Http::response($this->geminiPayload(['reply' => 'ok']), 200)]);

        $this->postChat()->assertOk();

        Http::assertSent(function ($request) {
            $prompt = $request->data()['system_instruction']['parts'][0]['text'];

            return str_contains($prompt, 'OT Infrastructure Security Assessment')
                && str_contains($prompt, 'Specialised testing for industrial control systems.');
        });
    }

    public function test_appointment_state_is_preserved_across_turns()
    {
        config(['services.gemini.key' => 'test-key']);

        Http::fake(['*' => Http::response($this->geminiPayload([
            'reply' => 'Thanks Jane.',
            'appointment_state' => [
                'appointment_intent' => true,
                'client_name' => 'Jane Cooper',
                'client_email' => null,
            ],
        ]), 200)]);

        $response = $this->postChat([
            'appointment_state' => [
                'appointment_intent' => true,
                'client_name' => 'Jane',
                'client_phone' => '+15550000000',
            ],
        ])->assertOk();

        $state = $response->json('appointment_state');

        $this->assertSame('Jane Cooper', $state['client_name']);
        // Previously collected values the model returned null for are not wiped.
        $this->assertSame('+15550000000', $state['client_phone']);
    }

    public function test_message_is_required()
    {
        config(['services.gemini.key' => 'test-key']);

        $this->postJson('/api/ai/chat', ['message' => ''])
            ->assertStatus(422)
            ->assertJsonValidationErrors('message');
    }

    public function test_history_is_capped_to_protect_token_limits()
    {
        config(['services.gemini.key' => 'test-key']);

        Http::fake(['*' => Http::response($this->geminiPayload(['reply' => 'ok']), 200)]);

        // 50 turns passes the max:60 request guard but must be trimmed to the
        // controller's own cap so we never blow the token limit.
        $history = [];
        for ($i = 0; $i < 50; $i++) {
            $history[] = ['role' => $i % 2 === 0 ? 'user' : 'assistant', 'content' => "message {$i}"];
        }

        $this->postChat(['history' => $history])->assertOk();

        Http::assertSent(function ($request) {
            $contents = $request->data()['contents'];

            // At most MAX_HISTORY (20) turns, plus at most one appended user turn.
            return count($contents) <= 21
                && ! in_array('message 0', array_column(array_column($contents, 'parts'), 'text'), true);
        });
    }

    public function test_oversized_history_is_rejected_by_validation()
    {
        config(['services.gemini.key' => 'test-key']);

        $history = [];
        for ($i = 0; $i < 61; $i++) {
            $history[] = ['role' => 'user', 'content' => "message {$i}"];
        }

        $this->postChat(['history' => $history])
            ->assertStatus(422)
            ->assertJsonValidationErrors('history');
    }
}
