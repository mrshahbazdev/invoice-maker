<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Template;
use App\Models\Business;
use Illuminate\Support\Str;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $businesses = Business::all();

        foreach ($businesses as $business) {
            $templates = [
                // Template 1 (Already existing 'Default', we'll just add more)
                [
                    'name' => 'Minimalist Professional',
                    'primary_color' => '#1f2937',
                    'font_family' => 'Helvetica, sans-serif',
                    'header_style' => 'simple',
                    'show_tax' => true,
                    'show_discount' => true,
                    'is_default' => true,
                    'payment_terms' => 'Please pay within 15 days.',
                    'footer_message' => 'Thank you for your business!',
                    'enable_qr' => true,
                ],
                // Template 2
                [
                    'name' => 'Creative Studio Orange',
                    'primary_color' => '#f97316',
                    'font_family' => 'Arial, sans-serif',
                    'header_style' => 'bold',
                    'show_tax' => true,
                    'show_discount' => true,
                    'is_default' => false,
                    'payment_terms' => 'Net 30 days. Late fees apply.',
                    'footer_message' => 'We appreciate your creative collaboration.',
                    'enable_qr' => true,
                ],
                // Template 3
                [
                    'name' => 'Tech Startup Blue',
                    'primary_color' => '#3b82f6',
                    'font_family' => 'Courier New, monospace',
                    'header_style' => 'center',
                    'show_tax' => true,
                    'show_discount' => false,
                    'is_default' => false,
                    'payment_terms' => 'Payable upon receipt.',
                    'footer_message' => 'Built with code & coffee.',
                    'enable_qr' => true,
                ],
                // Template 4
                [
                    'name' => 'Elegant Emerald',
                    'primary_color' => '#10b981',
                    'font_family' => 'Georgia, serif',
                    'header_style' => 'simple',
                    'show_tax' => true,
                    'show_discount' => true,
                    'is_default' => false,
                    'payment_terms' => 'Due in 7 days.',
                    'footer_message' => 'Partnering for your success.',
                    'enable_qr' => false,
                ],
                // Template 5
                [
                    'name' => 'Corporate Navy',
                    'primary_color' => '#1e3a8a',
                    'font_family' => 'Times New Roman, serif',
                    'header_style' => 'bold',
                    'show_tax' => true,
                    'show_discount' => true,
                    'is_default' => false,
                    'payment_terms' => 'Standard Net 30 terms.',
                    'footer_message' => 'Reliable & Professional Service.',
                    'enable_qr' => true,
                ],
                // Template 6
                [
                    'name' => 'Modern Purple',
                    'primary_color' => '#8b5cf6',
                    'font_family' => 'Trebuchet MS, sans-serif',
                    'header_style' => 'center',
                    'show_tax' => false,
                    'show_discount' => true,
                    'is_default' => false,
                    'payment_terms' => 'Payment due before starting project phase 2.',
                    'footer_message' => 'Designing the future.',
                    'enable_qr' => true,
                ],
                // Template 7
                [
                    'name' => 'Sunset Red',
                    'primary_color' => '#ef4444',
                    'font_family' => 'Verdana, sans-serif',
                    'header_style' => 'simple',
                    'show_tax' => true,
                    'show_discount' => false,
                    'is_default' => false,
                    'payment_terms' => 'Please initiate wire transfer immediately.',
                    'footer_message' => 'Fast and secure.',
                    'enable_qr' => false,
                ],
                // Template 8
                [
                    'name' => 'Boutique Rose',
                    'primary_color' => '#f43f5e',
                    'font_family' => 'Palatino, serif',
                    'header_style' => 'bold',
                    'show_tax' => true,
                    'show_discount' => true,
                    'is_default' => false,
                    'payment_terms' => 'Payable via credit card link below.',
                    'footer_message' => 'Thank you for shopping local!',
                    'enable_qr' => true,
                ],
                // Template 9
                [
                    'name' => 'Midnight Black',
                    'primary_color' => '#000000',
                    'font_family' => 'Impact, sans-serif',
                    'header_style' => 'center',
                    'show_tax' => true,
                    'show_discount' => true,
                    'is_default' => false,
                    'payment_terms' => 'Strictly 14 days.',
                    'footer_message' => 'Premium Quality Delivered.',
                    'enable_qr' => true,
                ],
                // Template 10
                [
                    'name' => 'Eco Green',
                    'primary_color' => '#65a30d',
                    'font_family' => 'Arial, Helvetica, sans-serif',
                    'header_style' => 'simple',
                    'show_tax' => true,
                    'show_discount' => true,
                    'is_default' => false,
                    'payment_terms' => 'Pay to our eco-friendly digital wallet.',
                    'footer_message' => 'Save paper. Keep this digital!',
                    'enable_qr' => true,
                ]
            ];

            foreach ($templates as $tmpl) {
                // Check if template exists to avoid duplicates if run multiple times
                Template::firstOrCreate([
                    'business_id' => $business->id,
                    'name' => $tmpl['name']
                ], $tmpl);
            }
        }
    }
}
