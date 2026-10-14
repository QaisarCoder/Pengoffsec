<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\HomepageHero;
use App\Models\CaseStudy;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing services to ensure exactly 10 are added
        Service::truncate();

        // Cybersecurity Services
        $cyber = [
            ['OT/IT Security Services', 'Comprehensive protection for operational and information technology environments.', 'Cybersecurity'],
            ['Network Analysis', 'Deep packet inspection and traffic analysis to identify anomalies.', 'Cybersecurity'],
            ['Penetration Testing', 'Simulated attacks to uncover vulnerabilities before malicious actors do.', 'Cybersecurity'],
            ['Security Assessment', 'High-level review of your security posture.', 'Cybersecurity'],
            ['Security Audit', 'Systematic evaluation of information security compliance.', 'Cybersecurity'],
            ['OT Infrastructure Security Assessment', 'Specialized security testing for industrial control systems.', 'Cybersecurity'],
            ['GRC (Governance, Risk & Compliance)', 'Aligning your technology with industry security standards.', 'Cybersecurity'],
        ];

        // Software Services
        $software = [
            ['Web Application Development', 'Scalable, secure, and modern web platforms.', 'Software'],
            ['Mobile Application Development', 'Native and cross-platform mobile experiences.', 'Software'],
            ['Desktop Application Development', 'High-performance desktop solutions for specialized tasks.', 'Software'],
        ];

        foreach (array_merge($cyber, $software) as $service) {
            Service::create([
                'name' => $service[0],
                'description' => $service[1],
                'category' => $service[2],
                'is_active' => true,
            ]);
        }

        // Seed default HomepageHero if none exists
        if (HomepageHero::count() === 0) {
            HomepageHero::create([
                'headline' => 'Secure. Build. Scale.',
                'subheadline' => 'PengOffSec builds secure digital products and helps businesses protect the technology they depend on.',
                'cta_text' => 'Request an assessment',
                'cta_link' => '/contact',
            ]);
        }

        // Seed sample CaseStudies if none exist
        if (CaseStudy::count() === 0) {
            CaseStudy::create([
                'title' => 'OT/IT Infrastructure Hardening',
                'category' => 'Cybersecurity',
                'description' => 'Comprehensive security assessment and hardening for industrial control systems and enterprise networks.',
                'slug' => 'ot-it-infrastructure-hardening',
            ]);
            CaseStudy::create([
                'title' => 'Secure Cloud Platform Architecture',
                'category' => 'Software',
                'description' => 'Architected and deployed a scalable, zero-trust cloud application platform with automated compliance checks.',
                'slug' => 'secure-cloud-platform-architecture',
            ]);
        }
    }
}
