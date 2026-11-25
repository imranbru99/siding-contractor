<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\BlogPost;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\KnowledgeArticle;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['admin', 'manager', 'staff'] as $role) {
            Role::findOrCreate($role);
        }

        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Northclad Admin',
                'phone' => '(612) 555-0100',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );
        $admin->syncRoles(['admin']);

        $manager = User::query()->updateOrCreate(
            ['email' => 'manager@northclad.example'],
            [
                'name' => 'Jordan Hale',
                'phone' => '(612) 555-0101',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'is_active' => true,
            ]
        );
        $manager->syncRoles(['manager']);

        $staff = User::query()->updateOrCreate(
            ['email' => 'crew@northclad.example'],
            [
                'name' => 'Casey Nguyen',
                'phone' => '(612) 555-0102',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'is_active' => true,
            ]
        );
        $staff->syncRoles(['staff']);

        $settings = [
            'company_name' => 'Northclad Siding Co.',
            'tagline' => 'Weather-tight cladding for Twin Cities homes',
            'company_phone' => '(612) 555-0184',
            'company_email' => 'hello@northclad.example',
            'company_address' => '1840 Marshall St NE, Minneapolis, MN 55413',
            'whatsapp_number' => '16125550184',
            'service_area' => 'Minneapolis–Saint Paul metro — Minneapolis, Saint Paul, Edina, Bloomington, Plymouth, Maple Grove, and surrounding suburbs',
        ];
        foreach ($settings as $key => $value) {
            Setting::setValue($key, $value, 'company');
        }

        $services = [
            [
                'title' => 'Fiber Cement Siding',
                'slug' => 'fiber-cement-siding',
                'icon' => 'shield',
                'summary' => 'James Hardie-style fiber cement installs with rainscreen options and Minnesota freeze–thaw detailing.',
                'description' => '<p>Northclad installs fiber cement lap, panel, and board-and-batten systems with continuous WRB, proper flashings, and manufacturer-approved fasteners.</p><p>Ideal for homeowners who want paint-grade durability without the maintenance of wood.</p>',
                'starting_price' => 14500,
                'image_url' => 'https://images.unsplash.com/photo-1600573472591-ee6981cf4219?auto=format&fit=crop&w=1400&q=80',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Vinyl Siding & Insulated Vinyl',
                'slug' => 'vinyl-siding',
                'icon' => 'home',
                'summary' => 'Insulated and premium vinyl systems that cut drafts and refresh curb appeal on a tighter budget.',
                'description' => '<p>We specify insulated vinyl where energy upgrades matter and standard premium vinyl for clean, low-maintenance envelopes.</p>',
                'starting_price' => 9800,
                'image_url' => 'https://images.unsplash.com/photo-1523217582562-09f1bebaf6bf?auto=format&fit=crop&w=1400&q=80',
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Wood & Engineered Wood Siding',
                'slug' => 'wood-engineered-wood-siding',
                'icon' => 'tree',
                'summary' => 'Cedar, pine, and engineered wood profiles with stain or paint systems built for northern exposure.',
                'description' => '<p>When architecture calls for natural texture, we install wood and engineered products with breathable finishes and ventilated cavities where appropriate.</p>',
                'starting_price' => 16800,
                'image_url' => 'https://images.unsplash.com/photo-1494526585095-c41746248156?auto=format&fit=crop&w=1400&q=80',
                'is_featured' => false,
                'sort_order' => 3,
            ],
            [
                'title' => 'Metal Panel & Standing Seam Accents',
                'slug' => 'metal-panel-accents',
                'icon' => 'sparkles',
                'summary' => 'Architectural metal cladding for modern facades, garage accents, and mixed-material exteriors.',
                'description' => '<p>We integrate metal panels with fiber cement or wood so transitions stay watertight and visually intentional.</p>',
                'starting_price' => 12200,
                'image_url' => 'https://images.unsplash.com/photo-1628624747186-a941c476b7ef?auto=format&fit=crop&w=1400&q=80',
                'is_featured' => true,
                'sort_order' => 4,
            ],
            [
                'title' => 'Siding Repair & Storm Restoration',
                'slug' => 'siding-repair-storm-restoration',
                'icon' => 'wrench',
                'summary' => 'Hail, wind, and moisture damage repairs — matched materials, documented for insurance when needed.',
                'description' => '<p>From localized panel swaps to full elevations after storms, Northclad documents damage, matches profiles, and reseals openings properly.</p>',
                'starting_price' => 2800,
                'image_url' => 'https://images.unsplash.com/photo-1575517111478-7f6afd0973db?auto=format&fit=crop&w=1400&q=80',
                'is_featured' => true,
                'sort_order' => 5,
            ],
            [
                'title' => 'Multifamily & Light Commercial Cladding',
                'slug' => 'multifamily-commercial-cladding',
                'icon' => 'building',
                'summary' => 'Phased cladding for duplexes, townhomes, and small commercial buildings with minimal tenant disruption.',
                'description' => '<p>Northclad coordinates access, staging, and phased elevations so property managers keep units occupied while exteriors get renewed.</p>',
                'starting_price' => 42000,
                'image_url' => 'https://images.unsplash.com/photo-1600047509358-9dc75507daeb?auto=format&fit=crop&w=1400&q=80',
                'is_featured' => false,
                'sort_order' => 6,
            ],
        ];
        foreach ($services as $service) {
            Service::query()->updateOrCreate(['slug' => $service['slug']], $service);
        }

        $products = [
            ['name' => 'Fiber Cement Lap 8.25"', 'sku' => 'FC-LAP-825', 'category' => 'fiber_cement', 'unit_cost' => 2.85, 'unit_price' => 4.95, 'stock_qty' => 3200, 'unit' => 'lf'],
            ['name' => 'Fiber Cement Trim 5/4x4', 'sku' => 'FC-TRIM-54', 'category' => 'fiber_cement', 'unit_cost' => 3.40, 'unit_price' => 5.90, 'stock_qty' => 980, 'unit' => 'lf'],
            ['name' => 'Insulated Vinyl Panel Bundle', 'sku' => 'VIN-INS-01', 'category' => 'vinyl', 'unit_cost' => 118, 'unit_price' => 189, 'stock_qty' => 64, 'unit' => 'bundle'],
            ['name' => 'Housewrap Roll 9ft x 100ft', 'sku' => 'WRB-9X100', 'category' => 'moisture', 'unit_cost' => 72, 'unit_price' => 118, 'stock_qty' => 42, 'unit' => 'roll'],
            ['name' => 'Flashing Tape 4"', 'sku' => 'FLASH-T4', 'category' => 'moisture', 'unit_cost' => 18, 'unit_price' => 32, 'stock_qty' => 160, 'unit' => 'roll'],
            ['name' => 'Cedar Lap 1x6 Select', 'sku' => 'WD-CED-16', 'category' => 'wood', 'unit_cost' => 4.10, 'unit_price' => 6.80, 'stock_qty' => 1400, 'unit' => 'lf'],
            ['name' => 'Standing Seam Metal Panel', 'sku' => 'MTL-SS-16', 'category' => 'metal', 'unit_cost' => 6.20, 'unit_price' => 10.40, 'stock_qty' => 520, 'unit' => 'lf'],
            ['name' => 'Siding Fastener Box (Stainless)', 'sku' => 'FAST-SS-BOX', 'category' => 'hardware', 'unit_cost' => 28, 'unit_price' => 46, 'stock_qty' => 210, 'unit' => 'box'],
        ];
        foreach ($products as $product) {
            Product::query()->updateOrCreate(
                ['sku' => $product['sku']],
                array_merge($product, ['description' => 'Northclad stock for siding crews.', 'is_active' => true])
            );
        }

        $customers = collect([
            ['name' => 'Elena Brooks', 'email' => 'elena.brooks@example.com', 'phone' => '(612) 555-2211', 'city' => 'Minneapolis', 'address' => '2841 Emerson Ave S', 'zip' => '55408'],
            ['name' => 'Marcus & Priya Chen', 'email' => 'chen.home@example.com', 'phone' => '(651) 555-8830', 'city' => 'Saint Paul', 'address' => '1124 Summit Ave', 'zip' => '55105'],
            ['name' => 'Derek Olsen', 'email' => 'derek.olsen@example.com', 'phone' => '(952) 555-4412', 'city' => 'Edina', 'address' => '4801 Tracy Ave', 'zip' => '55424'],
            ['name' => 'Aisha Rahman', 'email' => 'aisha.rahman@example.com', 'phone' => '(763) 555-7788', 'city' => 'Plymouth', 'address' => '3902 Dunkirk Ln N', 'zip' => '55446'],
            ['name' => 'Tom & Leah Vargas', 'email' => 'vargas.family@example.com', 'phone' => '(952) 555-9090', 'city' => 'Bloomington', 'address' => '8501 Portland Ave S', 'zip' => '55420'],
        ])->map(function (array $data) {
            return Customer::query()->updateOrCreate(
                ['email' => $data['email']],
                array_merge($data, ['state' => 'MN', 'notes' => 'Demo homeowner lead for Northclad.'])
            );
        });

        $projectDefs = [
            ['number' => 'NC-2401', 'title' => 'Emerson Ave fiber cement reclad', 'status' => 'completed', 'sqft' => 2100, 'est' => 38500, 'act' => 40200],
            ['number' => 'NC-2408', 'title' => 'Summit Ave wood + metal accents', 'status' => 'in_progress', 'sqft' => 1850, 'est' => 52000, 'act' => 26000],
            ['number' => 'NC-2412', 'title' => 'Edina insulated vinyl refresh', 'status' => 'scheduled', 'sqft' => 1600, 'est' => 17800, 'act' => 0],
            ['number' => 'NC-2415', 'title' => 'Plymouth hail repair west elevation', 'status' => 'quoted', 'sqft' => 620, 'est' => 9400, 'act' => 0],
            ['number' => 'NC-2419', 'title' => 'Bloomington duplex cladding phase 1', 'status' => 'lead', 'sqft' => 3400, 'est' => 78000, 'act' => 0],
        ];

        $projects = collect();
        foreach ($projectDefs as $i => $def) {
            $customer = $customers[$i];
            $projects->push(Project::query()->updateOrCreate(
                ['project_number' => $def['number']],
                [
                    'customer_id' => $customer->id,
                    'assigned_to' => $i % 2 === 0 ? $manager->id : $staff->id,
                    'title' => $def['title'],
                    'description' => 'Demo siding project seeded for Northclad ERP.',
                    'status' => $def['status'],
                    'priority' => $i === 1 ? 'high' : 'normal',
                    'site_address' => $customer->address.', '.$customer->city.', MN',
                    'sqft' => $def['sqft'],
                    'estimated_value' => $def['est'],
                    'actual_value' => $def['act'],
                    'start_date' => now()->subDays(40 - ($i * 5)),
                    'target_date' => now()->addDays(20 + ($i * 7)),
                    'completed_at' => $def['status'] === 'completed' ? now()->subDays(10) : null,
                ]
            ));
        }

        $invoice1 = Invoice::query()->updateOrCreate(
            ['invoice_number' => 'INV-3101'],
            [
                'customer_id' => $customers[0]->id,
                'project_id' => $projects[0]->id,
                'status' => 'paid',
                'issue_date' => now()->subMonths(2),
                'due_date' => now()->subMonths(1)->subDays(15),
                'subtotal' => 37500,
                'tax' => 2700,
                'total' => 40200,
                'amount_paid' => 40200,
                'notes' => 'Final payment for Emerson Ave fiber cement reclad.',
            ]
        );
        Payment::query()->updateOrCreate(
            ['invoice_id' => $invoice1->id, 'reference' => 'CHK-61021'],
            [
                'amount' => 20000,
                'method' => 'check',
                'paid_at' => now()->subMonths(2)->addDays(3),
            ]
        );
        Payment::query()->updateOrCreate(
            ['invoice_id' => $invoice1->id, 'reference' => 'ACH-88102'],
            [
                'amount' => 20200,
                'method' => 'ach',
                'paid_at' => now()->subMonths(1)->subDays(10),
            ]
        );

        $invoice2 = Invoice::query()->updateOrCreate(
            ['invoice_number' => 'INV-3108'],
            [
                'customer_id' => $customers[1]->id,
                'project_id' => $projects[1]->id,
                'status' => 'partial',
                'issue_date' => now()->subDays(18),
                'due_date' => now()->addDays(12),
                'subtotal' => 26000,
                'tax' => 2000,
                'total' => 28000,
                'amount_paid' => 14000,
                'notes' => 'Deposit + progress billing for Summit Ave mixed cladding.',
            ]
        );
        Payment::query()->updateOrCreate(
            ['invoice_id' => $invoice2->id, 'reference' => 'CARD-4481'],
            [
                'amount' => 14000,
                'method' => 'card',
                'paid_at' => now()->subDays(16),
            ]
        );

        Appointment::query()->updateOrCreate(
            ['title' => 'Summit Ave WRB inspection', 'starts_at' => now()->addDays(2)->setTime(9, 0)],
            [
                'customer_id' => $customers[1]->id,
                'project_id' => $projects[1]->id,
                'assigned_to' => $manager->id,
                'type' => 'site_visit',
                'status' => 'confirmed',
                'ends_at' => now()->addDays(2)->setTime(10, 30),
                'location' => $customers[1]->address,
            ]
        );
        Appointment::query()->updateOrCreate(
            ['title' => 'Plymouth hail consult', 'starts_at' => now()->addDays(5)->setTime(14, 0)],
            [
                'customer_id' => $customers[3]->id,
                'project_id' => $projects[3]->id,
                'assigned_to' => $staff->id,
                'type' => 'consultation',
                'status' => 'scheduled',
                'ends_at' => now()->addDays(5)->setTime(15, 0),
                'location' => $customers[3]->address,
            ]
        );

        $posts = [
            [
                'title' => 'Why Minnesota siding fails at window openings first',
                'slug' => 'minnesota-siding-fails-window-openings',
                'excerpt' => 'Ice, wind-driven rain, and weak flashing — how Northclad sequences WRB and pan flashings before the first course goes up.',
                'cover_image' => 'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?auto=format&fit=crop&w=1400&q=80',
                'body' => '<p>Most Twin Cities reclads we diagnose start with stained drywall near windows, not failed field boards. Water finds the weakest transition.</p><p>Our rule: pan flash, tape, housewrap shingled correctly, then cladding. Pretty siding over a wet opening is temporary.</p>',
            ],
            [
                'title' => 'Fiber cement vs vinyl for Minneapolis winters',
                'slug' => 'fiber-cement-vs-vinyl-minneapolis',
                'excerpt' => 'Cost, paint cycles, impact resistance, and insulated options — a homeowner checklist for north metro climates.',
                'cover_image' => 'https://images.unsplash.com/photo-1613977257363-707ba9348227?auto=format&fit=crop&w=1400&q=80',
                'body' => '<p>Vinyl wins on upfront cost and insulated packages. Fiber cement wins on paint fidelity and impact toughness against hail and landscaping abuse.</p><p>Northclad helps you price both paths with the same moisture detailing so the envelope is solid either way.</p>',
            ],
            [
                'title' => 'Rainscreen gaps that actually breathe in cold climates',
                'slug' => 'rainscreen-gaps-cold-climates',
                'excerpt' => 'Ventilated cavities, insect screens, and when a full rainscreen pays for itself on fiber cement installs.',
                'cover_image' => 'https://images.unsplash.com/photo-1558036117-15d82a90b9b1?auto=format&fit=crop&w=1400&q=80',
                'body' => '<p>A drained and ventilated cavity helps cladding dry after wind-driven rain. We size gaps and screens so pests stay out while moisture can leave.</p>',
            ],
        ];
        foreach ($posts as $post) {
            BlogPost::query()->updateOrCreate(
                ['slug' => $post['slug']],
                array_merge($post, [
                    'author_name' => 'Northclad Field Team',
                    'is_published' => true,
                    'published_at' => now()->subDays(rand(3, 40)),
                ])
            );
        }

        $articles = [
            [
                'title' => 'Bubbling paint and soft sheathing behind siding',
                'slug' => 'bubbling-paint-soft-sheathing',
                'category' => 'issues',
                'summary' => 'What to check when paint fails early or sheathing feels soft.',
                'body' => '<ol><li>Inspect window and door flashings for reverse laps.</li><li>Look for missing kickout flashing at roof-to-wall.</li><li>Probe suspect sheathing before ordering new cladding.</li><li>Plan WRB replacement if water has been trapped long-term.</li></ol>',
                'sort_order' => 1,
            ],
            [
                'title' => 'Siding install sequence checklist',
                'slug' => 'siding-install-sequence',
                'category' => 'guides',
                'summary' => 'From tear-off to trim — the Northclad order of operations.',
                'body' => '<p>1) Protect landscaping 2) Tear-off &amp; inspect sheathing 3) WRB 4) Openings &amp; flashings 5) Starter &amp; courses 6) Penetrations 7) Trim &amp; caulk 8) Final clean &amp; walkthrough.</p>',
                'sort_order' => 1,
            ],
            [
                'title' => 'Admin: creating a siding job in Filament ERP',
                'slug' => 'admin-creating-a-siding-job',
                'category' => 'admin',
                'summary' => 'How staff open projects, assign crew, and link invoices.',
                'body' => '<p>Navigate to <strong>Jobs / Projects</strong>, create a record with customer and wall square footage, then schedule an estimate appointment and draft an invoice from Finance.</p>',
                'sort_order' => 1,
            ],
            [
                'title' => 'Invoice balance not updating after payment',
                'slug' => 'invoice-balance-not-updating',
                'category' => 'troubleshooting',
                'summary' => 'Quick ERP checks when amount_paid looks wrong.',
                'body' => '<p>Confirm the payment is linked to the correct invoice, that status is partial/paid, and that amount_paid equals the sum of payment rows. Re-save the invoice if needed.</p>',
                'sort_order' => 1,
            ],
            [
                'title' => 'Ice dams and roof-to-wall cladding damage',
                'slug' => 'ice-dams-roof-wall-damage',
                'category' => 'issues',
                'summary' => 'How ice dams soak siding and what detailing prevents repeat failures.',
                'body' => '<p>Install kickout flashings, maintain free drainage behind cladding, and coordinate attic insulation/ventilation with the roofing trade so meltwater does not re-enter at the wall.</p>',
                'sort_order' => 2,
            ],
            [
                'title' => 'Homeowner prep before tear-off day',
                'slug' => 'homeowner-prep-tearoff-day',
                'category' => 'guides',
                'summary' => 'Clear access, move patio furniture, protect plantings.',
                'body' => '<p>Clear driveway for dumpsters and lifts, move fragile plantings 3–4 feet from walls, and unlock gates. Northclad sets protection for decks and HVAC condensers before tear-off begins.</p>',
                'sort_order' => 2,
            ],
        ];
        foreach ($articles as $article) {
            KnowledgeArticle::query()->updateOrCreate(
                ['slug' => $article['slug']],
                array_merge($article, ['is_published' => true])
            );
        }
    }
}
