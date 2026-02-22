<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Business;
use App\Models\Client;
use App\Models\Product;
use App\Models\Template;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Payment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $business = $this->createDemoUser();

        $this->callWith(TemplateSeeder::class, ['business_id' => $business->id]);

        $this->createClients($business);
        $this->createProducts($business);
        $this->createInvoices($business);
    }

    private function createDemoUser(): Business
    {
        $user = User::updateOrCreate(
            ['email' => 'demo@invoicemaker.com'],
            [
                'name' => 'Demo User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => User::ROLE_OWNER,
            ]
        );

        $business = Business::updateOrCreate(
            ['user_id' => $user->id],
            [
                'name' => 'Demo Business Inc.',
                'email' => 'contact@demobusiness.com',
                'phone' => '+1 (555) 123-4567',
                'address' => '123 Business Street
Suite 100
San Francisco, CA 94102
United States',
                'logo' => null,
                'currency' => 'USD',
                'timezone' => 'America/Los_Angeles',
                'plan' => 'free',
            ]
        );

        $user->update(['business_id' => $business->id]);

        return $business;
    }

    private function createClients(Business $business): void
    {
        $clients = [
            [
                'name' => 'John Smith',
                'email' => 'john.smith@acmecorp.com',
                'phone' => '+1 (555) 234-5678',
                'company_name' => 'Acme Corporation',
                'address' => '456 Corporate Blvd
New York, NY 10001
United States',
                'tax_number' => '123456789',
                'notes' => 'VIP Client - Always pays on time',
                'language' => 'en',
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.j@globalex.com',
                'phone' => '+1 (555) 345-6789',
                'company_name' => 'Global Express Ltd.',
                'address' => '789 International Way
Los Angeles, CA 90001
United States',
                'tax_number' => '987654321',
                'notes' => '',
                'language' => 'en',
            ],
            [
                'name' => 'Michael Chen',
                'email' => 'mchen@techstart.io',
                'phone' => '+1 (555) 456-7890',
                'company_name' => 'TechStart IO',
                'address' => '321 Innovation Drive
Austin, TX 78701
United States',
                'tax_number' => '456123789',
                'notes' => 'Startup client - flexible payment terms',
                'language' => 'en',
            ],
            [
                'name' => 'Emily Rodriguez',
                'email' => 'emily.r@designco.com',
                'phone' => '+1 (555) 567-8901',
                'company_name' => 'Design Co.',
                'address' => '654 Art Street
Chicago, IL 60601
United States',
                'tax_number' => '789456123',
                'notes' => 'Design and branding services',
                'language' => 'en',
            ],
            [
                'name' => 'David Wilson',
                'email' => 'd.wilson@enterprise.net',
                'phone' => '+1 (555) 678-9012',
                'company_name' => 'Enterprise Solutions',
                'address' => '987 Business Park
Miami, FL 33101
United States',
                'tax_number' => '321654987',
                'notes' => 'Long-term contract',
                'language' => 'en',
            ],
            [
                'name' => 'Lisa Anderson',
                'email' => 'lisa.a@retailplus.com',
                'phone' => '+1 (555) 789-0123',
                'company_name' => 'Retail Plus',
                'address' => '147 Commerce Ave
Seattle, WA 98101
United States',
                'tax_number' => '654789321',
                'notes' => '',
                'language' => 'en',
            ],
            [
                'name' => 'Robert Taylor',
                'email' => 'rtaylor@manufacturing.pro',
                'phone' => '+1 (555) 890-1234',
                'company_name' => 'Pro Manufacturing',
                'address' => '258 Factory Road
Detroit, MI 48201
United States',
                'tax_number' => '987321654',
                'notes' => 'Industrial client',
                'language' => 'en',
            ],
            [
                'name' => 'Jennifer Martinez',
                'email' => 'j.martinez@healthcare.org',
                'phone' => '+1 (555) 901-2345',
                'company_name' => 'Healthcare Plus Org',
                'address' => '369 Medical Center Dr
Boston, MA 02101
United States',
                'tax_number' => '147258369',
                'notes' => 'Healthcare industry',
                'language' => 'en',
            ],
            [
                'name' => 'Christopher Lee',
                'email' => 'clee@finserv.com',
                'phone' => '+1 (555) 012-3456',
                'company_name' => 'Financial Services Inc.',
                'address' => '741 Wall Street
New York, NY 10005
United States',
                'tax_number' => '369147258',
                'notes' => 'Financial sector client',
                'language' => 'en',
            ],
            [
                'name' => 'Amanda Brown',
                'email' => 'a.brown@education.edu',
                'phone' => '+1 (555) 123-4567',
                'company_name' => 'EduTech Solutions',
                'address' => '852 Campus Boulevard
Denver, CO 80201
United States',
                'tax_number' => '258369147',
                'notes' => 'Education technology',
                'language' => 'en',
            ],
        ];

        foreach ($clients as $client) {
            Client::updateOrCreate(
                ['email' => $client['email'], 'business_id' => $business->id],
                $client
            );
        }
    }

    private function createProducts(Business $business): void
    {
        $products = [
            [
                'name' => 'Web Development Package',
                'description' => 'Complete website development including responsive design, backend development, and deployment.',
                'price' => 2500.00,
                'unit' => 'project',
                'tax_rate' => 0,
            ],
            [
                'name' => 'Monthly Maintenance',
                'description' => 'Ongoing website maintenance, security updates, and technical support.',
                'price' => 200.00,
                'unit' => 'month',
                'tax_rate' => 0,
            ],
            [
                'name' => 'SEO Optimization',
                'description' => 'Search engine optimization services to improve website rankings.',
                'price' => 500.00,
                'unit' => 'month',
                'tax_rate' => 0,
            ],
            [
                'name' => 'Logo Design',
                'description' => 'Professional logo design with multiple revisions and file formats.',
                'price' => 350.00,
                'unit' => 'project',
                'tax_rate' => 0,
            ],
            [
                'name' => 'Brand Identity Package',
                'description' => 'Complete brand identity including logo, colors, typography, and brand guidelines.',
                'price' => 1500.00,
                'unit' => 'project',
                'tax_rate' => 0,
            ],
            [
                'name' => 'Social Media Management',
                'description' => 'Social media account management, content creation, and engagement.',
                'price' => 400.00,
                'unit' => 'month',
                'tax_rate' => 0,
            ],
            [
                'name' => 'Email Marketing Setup',
                'description' => 'Email marketing platform setup, template design, and campaign automation.',
                'price' => 750.00,
                'unit' => 'project',
                'tax_rate' => 0,
            ],
            [
                'name' => 'Consultation Hour',
                'description' => 'One-hour consultation session for business strategy and digital planning.',
                'price' => 150.00,
                'unit' => 'hour',
                'tax_rate' => 0,
            ],
            [
                'name' => 'Content Writing',
                'description' => 'Professional content writing for websites, blogs, and marketing materials.',
                'price' => 75.00,
                'unit' => 'page',
                'tax_rate' => 0,
            ],
            [
                'name' => 'E-commerce Setup',
                'description' => 'Complete e-commerce website setup with payment integration and product management.',
                'price' => 3000.00,
                'unit' => 'project',
                'tax_rate' => 0,
            ],
            [
                'name' => 'Mobile App Development',
                'description' => 'iOS and Android mobile application development.',
                'price' => 5000.00,
                'unit' => 'project',
                'tax_rate' => 0,
            ],
            [
                'name' => 'UI/UX Design',
                'description' => 'User interface and user experience design for web and mobile applications.',
                'price' => 1200.00,
                'unit' => 'project',
                'tax_rate' => 0,
            ],
            [
                'name' => 'Hosting Setup',
                'description' => 'Server setup, domain configuration, and SSL certificate installation.',
                'price' => 300.00,
                'unit' => 'year',
                'tax_rate' => 0,
            ],
            [
                'name' => 'Analytics Setup',
                'description' => 'Google Analytics and conversion tracking setup with reporting dashboard.',
                'price' => 250.00,
                'unit' => 'project',
                'tax_rate' => 0,
            ],
            [
                'name' => 'Training Session',
                'description' => 'Training for your team to manage and update your website content.',
                'price' => 200.00,
                'unit' => 'session',
                'tax_rate' => 0,
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['name' => $product['name'], 'business_id' => $business->id],
                $product
            );
        }
    }

    private function createInvoices(Business $business): void
    {
        $clients = Client::where('business_id', $business->id)->get();
        $products = Product::where('business_id', $business->id)->get();
        $template = Template::where('business_id', $business->id)->where('is_default', true)->first()
            ?: Template::where('business_id', $business->id)->first();

        if ($clients->isEmpty() || $products->isEmpty() || !$template) {
            return;
        }

        $invoiceData = [
            [
                'client_index' => 0,
                'status' => 'paid',
                'invoice_date' => now()->subDays(60),
                'due_date' => now()->subDays(30),
                'items' => [
                    ['product_index' => 0, 'qty' => 1, 'discount' => 0],
                    ['product_index' => 1, 'qty' => 3, 'discount' => 0],
                ],
                'payment_amount' => 2900,
            ],
            [
                'client_index' => 1,
                'status' => 'paid',
                'invoice_date' => now()->subDays(45),
                'due_date' => now()->subDays(15),
                'items' => [
                    ['product_index' => 2, 'qty' => 2, 'discount' => 50],
                    ['product_index' => 7, 'qty' => 2, 'discount' => 0],
                ],
                'payment_amount' => 900,
            ],
            [
                'client_index' => 2,
                'status' => 'sent',
                'invoice_date' => now()->subDays(10),
                'due_date' => now()->addDays(20),
                'items' => [
                    ['product_index' => 3, 'qty' => 1, 'discount' => 0],
                    ['product_index' => 4, 'qty' => 1, 'discount' => 100],
                ],
                'payment_amount' => 0,
            ],
            [
                'client_index' => 3,
                'status' => 'paid',
                'invoice_date' => now()->subDays(30),
                'due_date' => now(),
                'items' => [
                    ['product_index' => 5, 'qty' => 6, 'discount' => 100],
                ],
                'payment_amount' => 2300,
            ],
            [
                'client_index' => 4,
                'status' => 'overdue',
                'invoice_date' => now()->subDays(60),
                'due_date' => now()->subDays(30),
                'items' => [
                    ['product_index' => 6, 'qty' => 1, 'discount' => 0],
                    ['product_index' => 8, 'qty' => 10, 'discount' => 50],
                ],
                'payment_amount' => 0,
            ],
            [
                'client_index' => 5,
                'status' => 'draft',
                'invoice_date' => now(),
                'due_date' => now()->addDays(30),
                'items' => [
                    ['product_index' => 9, 'qty' => 1, 'discount' => 0],
                    ['product_index' => 5, 'qty' => 1, 'discount' => 0],
                ],
                'payment_amount' => 0,
            ],
            [
                'client_index' => 0,
                'status' => 'paid',
                'invoice_date' => now()->subDays(15),
                'due_date' => now()->addDays(15),
                'items' => [
                    ['product_index' => 5, 'qty' => 1, 'discount' => 0],
                ],
                'payment_amount' => 1200,
            ],
            [
                'client_index' => 6,
                'status' => 'sent',
                'invoice_date' => now()->subDays(5),
                'due_date' => now()->addDays(25),
                'items' => [
                    ['product_index' => 5, 'qty' => 1, 'discount' => 500],
                ],
                'payment_amount' => 0,
            ],
            [
                'client_index' => 7,
                'status' => 'paid',
                'invoice_date' => now()->subDays(20),
                'due_date' => now()->subDays(5),
                'items' => [
                    ['product_index' => 5, 'qty' => 1, 'discount' => 0],
                    ['product_index' => 5, 'qty' => 3, 'discount' => 50],
                ],
                'payment_amount' => 800,
            ],
            [
                'client_index' => 8,
                'status' => 'draft',
                'invoice_date' => now(),
                'due_date' => now()->addDays(30),
                'items' => [
                    ['product_index' => 0, 'qty' => 2, 'discount' => 1000],
                    ['product_index' => 2, 'qty' => 12, 'discount' => 0],
                ],
                'payment_amount' => 0,
            ],
            [
                'client_index' => 1,
                'status' => 'paid',
                'invoice_date' => now()->subDays(50),
                'due_date' => now()->subDays(20),
                'items' => [
                    ['product_index' => 1, 'qty' => 6, 'discount' => 0],
                ],
                'payment_amount' => 1200,
            ],
            [
                'client_index' => 2,
                'status' => 'sent',
                'invoice_date' => now()->subDays(2),
                'due_date' => now()->addDays(28),
                'items' => [
                    ['product_index' => 8, 'qty' => 5, 'discount' => 25],
                    ['product_index' => 5, 'qty' => 2, 'discount' => 0],
                ],
                'payment_amount' => 0,
            ],
            [
                'client_index' => 3,
                'status' => 'paid',
                'invoice_date' => now()->subDays(35),
                'due_date' => now()->subDays(5),
                'items' => [
                    ['product_index' => 3, 'qty' => 2, 'discount' => 0],
                    ['product_index' => 4, 'qty' => 1, 'discount' => 200],
                ],
                'payment_amount' => 2200,
            ],
            [
                'client_index' => 9,
                'status' => 'draft',
                'invoice_date' => now(),
                'due_date' => now()->addDays(30),
                'items' => [
                    ['product_index' => 7, 'qty' => 4, 'discount' => 0],
                ],
                'payment_amount' => 0,
            ],
            [
                'client_index' => 4,
                'status' => 'overdue',
                'invoice_date' => now()->subDays(90),
                'due_date' => now()->subDays(60),
                'items' => [
                    ['product_index' => 9, 'qty' => 1, 'discount' => 0],
                    ['product_index' => 5, 'qty' => 2, 'discount' => 100],
                ],
                'payment_amount' => 0,
            ],
            [
                'client_index' => 5,
                'status' => 'paid',
                'invoice_date' => now()->subDays(25),
                'due_date' => now()->subDays(10),
                'items' => [
                    ['product_index' => 5, 'qty' => 3, 'discount' => 0],
                ],
                'payment_amount' => 1200,
            ],
            [
                'client_index' => 6,
                'status' => 'sent',
                'invoice_date' => now()->subDays(7),
                'due_date' => now()->addDays(23),
                'items' => [
                    ['product_index' => 6, 'qty' => 1, 'discount' => 0],
                    ['product_index' => 5, 'qty' => 1, 'discount' => 150],
                ],
                'payment_amount' => 0,
            ],
            [
                'client_index' => 7,
                'status' => 'paid',
                'invoice_date' => now()->subDays(40),
                'due_date' => now()->subDays(10),
                'items' => [
                    ['product_index' => 2, 'qty' => 6, 'discount' => 0],
                    ['product_index' => 5, 'qty' => 1, 'discount' => 0],
                ],
                'payment_amount' => 3250,
            ],
            [
                'client_index' => 8,
                'status' => 'draft',
                'invoice_date' => now(),
                'due_date' => now()->addDays(30),
                'items' => [
                    ['product_index' => 5, 'qty' => 10, 'discount' => 200],
                ],
                'payment_amount' => 0,
            ],
            [
                'client_index' => 9,
                'status' => 'sent',
                'invoice_date' => now()->subDays(1),
                'due_date' => now()->addDays(29),
                'items' => [
                    ['product_index' => 5, 'qty' => 1, 'discount' => 0],
                    ['product_index' => 4, 'qty' => 1, 'discount' => 0],
                ],
                'payment_amount' => 0,
            ],
        ];

        foreach ($invoiceData as $data) {
            if (!isset($clients[$data['client_index']]))
                continue;

            $client = $clients[$data['client_index']];
            $invoiceNumber = 'INV-' . now()->year . '-' . str_pad((string) (Invoice::where('business_id', $business->id)->count() + 1), 4, '0', STR_PAD_LEFT);

            $subtotal = 0;
            $taxTotal = 0;
            $itemData = [];

            foreach ($data['items'] as $item) {
                if (!isset($products[$item['product_index']]))
                    continue;

                $product = $products[$item['product_index']];
                $itemTotal = $item['qty'] * $product->price;
                $itemTax = $itemTotal * ($product->tax_rate / 100);
                $itemFinalTotal = $itemTotal + $itemTax - $item['discount'];

                $subtotal += $itemTotal;
                $taxTotal += $itemTax;

                $itemData[] = [
                    'description' => $product->name . ' - ' . $product->description,
                    'quantity' => $item['qty'],
                    'unit_price' => $product->price,
                    'tax_rate' => $product->tax_rate,
                    'tax_amount' => $itemTax,
                    'discount' => $item['discount'],
                    'total' => $itemFinalTotal,
                ];
            }

            $grandTotal = $subtotal + $taxTotal;
            $amountPaid = $data['payment_amount'];
            $amountDue = $grandTotal - $amountPaid;

            $invoice = Invoice::create([
                'business_id' => $business->id,
                'client_id' => $client->id,
                'template_id' => $template->id,
                'invoice_number' => $invoiceNumber,
                'status' => $data['status'],
                'invoice_date' => $data['invoice_date'],
                'due_date' => $data['due_date'],
                'subtotal' => $subtotal,
                'tax_total' => $taxTotal,
                'discount' => 0,
                'grand_total' => $grandTotal,
                'amount_paid' => $amountPaid,
                'amount_due' => $amountDue,
            ]);

            foreach ($itemData as $item) {
                InvoiceItem::create(array_merge($item, [
                    'invoice_id' => $invoice->id,
                ]));
            }

            if ($amountPaid > 0) {
                Payment::create([
                    'invoice_id' => $invoice->id,
                    'amount' => $amountPaid,
                    'method' => 'bank_transfer',
                    'date' => $data['invoice_date']->copy()->addDays(15),
                ]);
            }
        }
    }
}
