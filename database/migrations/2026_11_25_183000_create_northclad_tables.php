<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('role')->default('staff')->after('phone'); // admin, manager, staff
            $table->boolean('is_active')->default(true)->after('role');
        });

        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable()->default('MN');
            $table->string('zip')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('icon')->nullable();
            $table->string('summary');
            $table->longText('description');
            $table->decimal('starting_price', 12, 2)->nullable();
            $table->string('image_url')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sku')->unique();
            $table->string('category')->nullable();
            $table->text('description')->nullable();
            $table->decimal('unit_cost', 12, 2)->default(0);
            $table->decimal('unit_price', 12, 2)->default(0);
            $table->integer('stock_qty')->default(0);
            $table->string('unit')->default('ea');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_number')->unique();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('status')->default('lead'); // lead, quoted, scheduled, in_progress, completed, cancelled
            $table->string('priority')->default('normal');
            $table->string('site_address')->nullable();
            $table->decimal('sqft', 10, 2)->nullable();
            $table->decimal('estimated_value', 12, 2)->default(0);
            $table->decimal('actual_value', 12, 2)->default(0);
            $table->date('start_date')->nullable();
            $table->date('target_date')->nullable();
            $table->date('completed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();
            $table->string('status')->default('draft'); // draft, sent, partial, paid, void
            $table->date('issue_date');
            $table->date('due_date')->nullable();
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('tax', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->decimal('amount_paid', 12, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->string('method')->default('check'); // check, card, ach, cash, other
            $table->string('reference')->nullable();
            $table->date('paid_at');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->string('type')->default('consultation'); // consultation, site_visit, install, punch_list, follow_up
            $table->string('status')->default('scheduled');
            $table->dateTime('starts_at');
            $table->dateTime('ends_at')->nullable();
            $table->string('location')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('excerpt');
            $table->longText('body');
            $table->string('cover_image')->nullable();
            $table->string('author_name')->default('Northclad Field Team');
            $table->boolean('is_published')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('knowledge_articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category'); // issues, guides, admin, troubleshooting
            $table->string('summary');
            $table->longText('body');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('subject')->nullable();
            $table->text('message');
            $table->string('status')->default('new');
            $table->timestamps();
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('group')->default('general');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('knowledge_articles');
        Schema::dropIfExists('blog_posts');
        Schema::dropIfExists('appointments');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('products');
        Schema::dropIfExists('services');
        Schema::dropIfExists('customers');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'role', 'is_active']);
        });
    }
};
