<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'whatsapp_number', 'value' => '03292404132', 'type' => 'string'],
            ['key' => 'whatsapp_enabled', 'value' => '1', 'type' => 'boolean'],
            ['key' => 'email_notifications_enabled', 'value' => '1', 'type' => 'boolean'],
            ['key' => 'whatsapp_notifications_enabled', 'value' => '1', 'type' => 'boolean'],
            ['key' => 'contact_email', 'value' => 'hello@pengoffsec.com', 'type' => 'string'],
        ];

        foreach ($settings as $setting) {
            \App\Models\Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
