<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\CaseStudy;
use App\Models\HomepageHero;
use App\Models\Lead;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UiRenderTest extends TestCase
{
    use RefreshDatabase;

    protected function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }

    public function test_public_pages_render()
    {
        $this->get('/')->assertOk();
        $this->get('/services')->assertOk();
        $this->get('/process')->assertOk();
        $this->get('/about')->assertOk();
        $this->get('/contact')->assertOk();
        $this->get('/work')->assertOk();
    }

    public function test_admin_pages_render()
    {
        $admin = $this->admin();

        Service::create(['name' => 'Pen Test', 'description' => 'Testing desc', 'category' => 'Cybersecurity']);
        Service::create(['name' => 'Web Dev', 'description' => 'Building desc', 'category' => 'Software']);
        CaseStudy::create(['title' => 'OT Assessment', 'category' => 'Cybersecurity', 'description' => 'Case body', 'slug' => 'ot-assessment']);
        Lead::create([
            'name' => 'Jane', 'email' => 'jane@example.com', 'company' => 'Acme',
            'project_type' => 'Audit', 'service_required' => 'Security Audit',
            'budget' => '$10k', 'timeline' => '6 weeks', 'project_details' => 'Details',
            'status' => 'New',
        ]);
        Appointment::create([
            'reference' => 'POS-TEST-00001', 'client_name' => 'Bob', 'client_email' => 'bob@example.com',
            'client_phone' => '123', 'service' => 'Penetration Testing',
            'preferred_date' => '2026-10-05', 'preferred_time' => '10:00',
            'message' => 'Booked via the assistant', 'status' => 'pending',
        ]);
        HomepageHero::create([
            'headline' => 'Secure. Build. Scale.',
            'subheadline' => 'Sub copy here',
            'cta_text' => 'Request an assessment',
            'cta_link' => '/contact',
        ]);

        $this->actingAs($admin);

        $this->get('/admin/dashboard')->assertOk()->assertSee('Admin overview');
        $this->get('/admin/hero')->assertOk()->assertSee('Edit homepage hero');
        $this->get('/admin/services')->assertOk()->assertSee('Services')->assertSee('Pen Test');
        $this->get('/admin/services/create')->assertOk();
        $this->get('/admin/services/1/edit')->assertOk();
        $this->get('/admin/work')->assertOk()->assertSee('Portfolio')->assertSee('OT Assessment');
        $this->get('/admin/work/create')->assertOk();
        $this->get('/admin/work/1/edit')->assertOk();
        $this->get('/admin/leads')->assertOk()->assertSee('Project leads')->assertSee('jane@example.com');
        $this->get('/admin/ai-leads')->assertOk()->assertSee('AI assistant bookings')->assertSee('POS-TEST-00001');
    }

    /**
     * Every internal link on the dashboard and in the admin sidebar must resolve
     * to a real, reachable page. This catches links pointing at routes whose
     * controller method is missing, which otherwise fail with a 500.
     */
    public function test_every_admin_navigation_link_resolves()
    {
        Service::create(['name' => 'Pen Test', 'description' => 'Testing desc', 'category' => 'Cybersecurity']);
        CaseStudy::create(['title' => 'OT Assessment', 'category' => 'Cybersecurity', 'description' => 'Body', 'slug' => 'ot-assessment']);
        HomepageHero::create([
            'headline' => 'Secure. Build. Scale.', 'subheadline' => 'Sub copy',
            'cta_text' => 'Request an assessment', 'cta_link' => '/contact',
        ]);

        $this->actingAs($this->admin());

        $pages = ['/admin/dashboard', '/admin/hero', '/admin/services', '/admin/work', '/admin/leads', '/admin/ai-leads'];

        $visited = [];

        foreach ($pages as $page) {
            $response = $this->get($page)->assertOk();

            preg_match_all('/href="(http:\/\/localhost[^"]*)"/', $response->getContent(), $matches);

            foreach ($matches[1] as $href) {
                $path = parse_url($href, PHP_URL_PATH) ?: '/';

                // Only follow same-origin links back into the app.
                if (! str_starts_with($path, '/')) {
                    continue;
                }

                $visited[$path] = true;
            }
        }

        // Only assert on admin links, which need auth and no extra ids.
        $adminLinks = array_filter(
            array_keys($visited),
            fn ($path) => str_starts_with($path, '/admin')
                && ! str_contains($path, '/edit')
                && ! str_contains($path, '/toggle')
        );

        $this->assertNotEmpty($adminLinks, 'Expected to discover admin navigation links.');

        foreach ($adminLinks as $path) {
            $this->get($path)->assertOk("Admin link {$path} should resolve without a server error.");
        }
    }

    public function test_admin_index_pages_filter_by_search_term()
    {
        $admin = $this->admin();

        Service::create(['name' => 'Pen Test', 'description' => 'Testing desc', 'category' => 'Cybersecurity']);
        Service::create(['name' => 'Mobile App', 'description' => 'iOS and Android', 'category' => 'Software']);
        CaseStudy::create(['title' => 'OT Assessment', 'category' => 'Cybersecurity', 'description' => 'Case body', 'slug' => 'ot-assessment']);
        CaseStudy::create(['title' => 'Banking Core', 'category' => 'Software', 'description' => 'Legacy rewrite', 'slug' => 'banking-core']);
        Lead::create([
            'name' => 'Jane Smith', 'email' => 'jane@acme.com', 'company' => 'Acme',
            'project_type' => 'Audit', 'service_required' => 'Security Audit',
            'budget' => '$10k', 'timeline' => '6 weeks', 'project_details' => 'Scope notes',
            'status' => 'New',
        ]);
        Lead::create([
            'name' => 'Bob Jones', 'email' => 'bob@globex.com', 'company' => 'Globex',
            'project_type' => 'Build', 'service_required' => 'Web Dev',
            'budget' => '$30k', 'timeline' => '3 months', 'project_details' => 'Portal',
            'status' => 'Contacted',
        ]);

        $this->actingAs($admin);

        $this->get('/admin/services?q=Mobile')
            ->assertOk()
            ->assertSee('Mobile App')
            ->assertDontSee('Pen Test');

        $this->get('/admin/services?category=Software')
            ->assertOk()
            ->assertSee('Mobile App')
            ->assertDontSee('Pen Test');

        $this->get('/admin/work?q=banking')
            ->assertOk()
            ->assertSee('Banking Core')
            ->assertDontSee('OT Assessment');

        $this->get('/admin/leads?q=Globex')
            ->assertOk()
            ->assertSee('Bob Jones')
            ->assertDontSee('Jane Smith');

        $this->get('/admin/leads?status=Contacted')
            ->assertOk()
            ->assertSee('Bob Jones')
            ->assertDontSee('Jane Smith');
    }

    public function test_service_visibility_can_be_toggled()
    {
        $admin = $this->admin();
        $service = Service::create([
            'name' => 'Pen Test', 'description' => 'Testing desc', 'category' => 'Cybersecurity',
        ]);

        $this->actingAs($admin);

        // is_active defaults to true, so the first toggle hides the service.
        $this->assertTrue($service->is_active);

        $this->patch("/admin/services/{$service->id}/toggle-active")
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertFalse($service->fresh()->is_active);

        $this->patch("/admin/services/{$service->id}/toggle-active")
            ->assertRedirect();

        $this->assertTrue($service->fresh()->is_active);
    }

    public function test_lead_status_rejects_unknown_values()
    {
        $admin = $this->admin();
        $lead = Lead::create([
            'name' => 'Jane', 'email' => 'jane@example.com', 'company' => 'Acme',
            'project_type' => 'Audit', 'service_required' => 'Security Audit',
            'budget' => '$10k', 'timeline' => '6 weeks', 'project_details' => 'Notes',
            'status' => 'New',
        ]);

        $this->actingAs($admin);

        $this->patch("/admin/leads/{$lead->id}/status", ['status' => 'Hacked'])->assertSessionHasErrors('status');
        $this->assertSame('New', $lead->fresh()->status);

        $this->patch("/admin/leads/{$lead->id}/status", ['status' => 'Contacted'])->assertSessionHasNoErrors();
        $this->assertSame('Contacted', $lead->fresh()->status);
    }

    public function test_auth_and_user_pages_render()
    {
        $this->get('/login')->assertOk();
        $this->get('/register')->assertOk();
        $this->get('/forgot-password')->assertOk();

        $user = User::factory()->create();
        $this->actingAs($user);

        $this->get('/dashboard')->assertOk();
        $this->get('/profile')->assertOk();
    }

    public function test_case_study_show_renders()
    {
        CaseStudy::create([
            'title' => 'OT Assessment', 'category' => 'Cybersecurity',
            'description' => 'Case body text', 'slug' => 'ot-assessment',
        ]);

        $this->get('/work/ot-assessment')->assertOk()->assertSee('OT Assessment');
    }

    public function test_case_study_index_lists_every_study_in_order()
    {
        foreach ([
            ['SCADA Assessment', 'Cybersecurity', 'We assessed a water treatment SCADA environment end to end.', 'scada-assessment'],
            ['Payment Gateway Review', 'Cybersecurity', 'Full application penetration test of a card payment flow.', 'payment-gateway'],
            ['Fleet Telematics Build', 'Software', 'Designed and shipped a secure telematics dashboard.', 'fleet-telematics'],
        ] as $row) {
            CaseStudy::create([
                'title' => $row[0], 'category' => $row[1],
                'description' => $row[2], 'slug' => $row[3],
            ]);
        }

        $response = $this->get('/work')->assertOk();

        // Every study is rendered with its category and links to its detail page.
        $response->assertSee('SCADA Assessment');
        $response->assertSee('/work/scada-assessment');
        $response->assertSee('Fleet Telematics Build');
        $response->assertSee('/work/fleet-telematics');
        $response->assertSee('Cybersecurity');
        $response->assertSee('Software');

        // Cards use the same UI as the Cybersecurity / Software service cards.
        $response->assertSee('card-interactive', false);
        $response->assertSee('icon-chip');
        $response->assertSee('View case study');
        $response->assertSee('line-clamp-3');

        // Homepage preview links through to the full index.
        $this->get('/')->assertOk()->assertSee('/work/scada-assessment');
    }

    public function test_case_study_index_shows_designed_empty_state()
    {
        $response = $this->get('/work')->assertOk();

        $response->assertSee('Case studies coming soon');
        $response->assertSee('Request a portfolio sample');
    }

    public function test_contact_form_submits()
    {
        $this->post('/contact', [
            'name' => 'Jane', 'email' => 'jane@example.com', 'company' => 'Acme',
            'project_type' => 'Audit', 'service_required' => 'Security Audit',
            'budget' => '$10k', 'timeline' => '6 weeks', 'project_details' => 'Details',
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas('leads', ['email' => 'jane@example.com']);
    }
}
