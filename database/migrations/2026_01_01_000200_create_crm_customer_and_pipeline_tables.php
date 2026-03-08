<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('customer_group_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('industry_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('sales_area_id')->nullable()->constrained()->nullOnDelete();
            $table->string('customer_code')->unique();
            $table->enum('customer_type', ['company', 'individual'])->default('company');
            $table->string('name');
            $table->string('legal_name')->nullable();
            $table->string('tax_no')->nullable();
            $table->string('registration_no')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('website')->nullable();
            $table->integer('payment_term_days')->default(0);
            $table->decimal('credit_limit', 18, 2)->default(0);
            $table->string('currency_code', 10)->default('IDR');
            $table->foreignId('tax_code_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('is_taxable')->default(true);
            $table->enum('status', ['active', 'inactive', 'blacklisted'])->default('active')->index();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('source_lead_id')->nullable();
            $table->unsignedBigInteger('converted_from_lead_id')->nullable();
            $table->foreignId('owner_user_id')->nullable()->constrained('users')->nullOnDelete()->index();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index('name');
        });

        Schema::create('customer_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('position')->nullable();
            $table->string('department')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->string('label');
            $table->enum('address_type', ['billing', 'shipping', 'office', 'project_site', 'other'])->default('office');
            $table->string('recipient_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('address_line1');
            $table->string('address_line2')->nullable();
            $table->string('village')->nullable();
            $table->string('district')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('country')->nullable();
            $table->string('postal_code')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });

        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('lead_no')->unique();
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedBigInteger('lead_source_id')->nullable()->index();
            $table->foreign('lead_source_id', 'fk_leads_lead_source_id')
                ->references('id')
                ->on('lead_sources')
                ->nullOnDelete();
            $table->foreignId('sales_area_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete()->index();
            $table->string('name');
            $table->string('company_name')->nullable();
            $table->enum('lead_type', ['company', 'individual'])->default('company');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->foreignId('industry_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('estimated_value', 18, 2)->default(0);
            $table->enum('interest_type', ['product', 'service', 'mixed'])->default('mixed');
            $table->text('need_summary')->nullable();
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->enum('status', ['new', 'contacted', 'qualified', 'unqualified', 'converted', 'lost'])->default('new')->index();
            $table->integer('qualification_score')->default(0);
            $table->text('lost_reason')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('converted_customer_id')->nullable();
            $table->timestamp('converted_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index('created_at');
        });

        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('activity_no')->nullable();
            $table->morphs('relatable');
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('contact_id')->nullable()->constrained('customer_contacts')->nullOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('activity_type', ['call', 'email', 'whatsapp', 'meeting', 'visit', 'demo', 'presentation', 'follow_up', 'reminder', 'other']);
            $table->string('subject');
            $table->text('description')->nullable();
            $table->dateTime('activity_at');
            $table->text('result_summary')->nullable();
            $table->text('next_action')->nullable();
            $table->dateTime('next_follow_up_at')->nullable();
            $table->enum('status', ['planned', 'done', 'cancelled', 'overdue'])->default('planned');
            $table->enum('outcome', ['positive', 'neutral', 'negative'])->nullable();
            $table->timestamps();
        });

        Schema::create('opportunities', function (Blueprint $table) {
            $table->id();
            $table->string('opportunity_no')->unique();
            $table->foreignId('lead_id')->nullable()->constrained()->nullOnDelete()->index();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete()->index();
            $table->foreignId('customer_contact_id')->nullable()->constrained('customer_contacts')->nullOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete()->index();
            $table->foreignId('sales_area_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('opportunity_type', ['product', 'service', 'mixed'])->default('mixed');
            $table->decimal('estimated_value', 18, 2)->default(0);
            $table->integer('probability')->default(0);
            $table->date('expected_close_date')->nullable()->index();
            $table->enum('stage', ['qualification', 'need_analysis', 'proposal', 'negotiation', 'waiting_approval', 'won', 'lost'])->default('qualification')->index();
            $table->enum('status', ['open', 'won', 'lost', 'cancelled'])->default('open')->index();
            $table->text('competitor_info')->nullable();
            $table->text('lost_reason')->nullable();
            $table->text('risk_note')->nullable();
            $table->enum('source', ['lead', 'customer_request', 'repeat_order', 'referral', 'other'])->nullable();
            $table->timestamp('won_at')->nullable();
            $table->timestamp('lost_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('opportunity_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('opportunity_id')->constrained()->cascadeOnDelete();
            $table->enum('item_type', ['product', 'service']);
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();
            $table->text('description')->nullable();
            $table->decimal('qty', 18, 2)->default(1);
            $table->foreignId('unit_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('estimated_price', 18, 2)->default(0);
            $table->decimal('estimated_discount_percent', 8, 2)->default(0);
            $table->foreignId('estimated_tax_code_id')->nullable()->constrained('tax_codes')->nullOnDelete();
            $table->decimal('subtotal', 18, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('opportunity_items');
        Schema::dropIfExists('opportunities');
        Schema::dropIfExists('activities');
        Schema::dropIfExists('leads');
        Schema::dropIfExists('customer_addresses');
        Schema::dropIfExists('customer_contacts');
        Schema::dropIfExists('customers');
    }
};
