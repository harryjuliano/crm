<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('quotation_no')->unique();
            $table->integer('revision_no')->default(0);
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('opportunity_id')->nullable()->index()->constrained()->nullOnDelete();
            $table->foreignId('customer_id')->index()->constrained()->restrictOnDelete();
            $table->foreignId('customer_contact_id')->nullable()->constrained('customer_contacts')->nullOnDelete();
            $table->foreignId('billing_address_id')->nullable()->constrained('customer_addresses')->nullOnDelete();
            $table->foreignId('shipping_address_id')->nullable()->constrained('customer_addresses')->nullOnDelete();
            $table->date('quotation_date')->index();
            $table->date('valid_until')->nullable();
            $table->string('currency_code', 10)->default('IDR');
            $table->decimal('exchange_rate', 18, 6)->default(1);
            $table->integer('payment_term_days')->default(0);
            $table->foreignId('tax_code_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('subtotal', 18, 2)->default(0);
            $table->decimal('discount_amount', 18, 2)->default(0);
            $table->decimal('tax_amount', 18, 2)->default(0);
            $table->decimal('grand_total', 18, 2)->default(0);
            $table->enum('status', ['draft', 'waiting_approval', 'approved', 'sent', 'revised', 'accepted', 'rejected', 'expired', 'cancelled'])->default('draft')->index();
            $table->enum('approval_status', ['not_required', 'pending', 'approved', 'rejected'])->default('not_required')->index();
            $table->boolean('is_price_special')->default(false);
            $table->text('terms_conditions')->nullable();
            $table->text('notes')->nullable();
            $table->text('internal_notes')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('quotation_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->constrained()->cascadeOnDelete();
            $table->integer('sort_order')->default(0);
            $table->enum('item_type', ['product', 'service']);
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();
            $table->string('item_code')->nullable();
            $table->string('item_name');
            $table->text('description')->nullable();
            $table->decimal('qty', 18, 2)->default(1);
            $table->foreignId('unit_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('unit_price', 18, 2)->default(0);
            $table->decimal('discount_percent', 8, 2)->default(0);
            $table->decimal('discount_amount', 18, 2)->default(0);
            $table->foreignId('tax_code_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('tax_percent', 8, 4)->default(0);
            $table->decimal('tax_amount', 18, 2)->default(0);
            $table->decimal('line_total', 18, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('quotation_revisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->constrained()->cascadeOnDelete();
            $table->integer('revision_no');
            $table->text('revision_reason');
            $table->longText('snapshot_json');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('approvals', function (Blueprint $table) {
            $table->id();
            $table->morphs('approvable');
            $table->string('document_no')->nullable();
            $table->string('module_name');
            $table->foreignId('request_by')->constrained('users')->cascadeOnDelete();
            $table->dateTime('request_at');
            $table->integer('current_step')->default(1);
            $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled'])->default('pending');
            $table->foreignId('final_approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('final_approved_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });

        Schema::create('approval_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('approval_id')->constrained()->cascadeOnDelete();
            $table->integer('step_no');
            $table->foreignId('approver_user_id')->constrained('users')->cascadeOnDelete();
            $table->string('approver_role')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'skipped'])->default('pending');
            $table->dateTime('action_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id();
            $table->string('sales_order_no')->unique();
            $table->foreignId('quotation_id')->nullable()->index()->constrained()->nullOnDelete();
            $table->foreignId('customer_id')->index()->constrained()->restrictOnDelete();
            $table->foreignId('customer_contact_id')->nullable()->constrained('customer_contacts')->nullOnDelete();
            $table->foreignId('billing_address_id')->nullable()->constrained('customer_addresses')->nullOnDelete();
            $table->foreignId('shipping_address_id')->nullable()->constrained('customer_addresses')->nullOnDelete();
            $table->date('order_date');
            $table->date('delivery_date')->nullable();
            $table->string('currency_code', 10)->default('IDR');
            $table->integer('payment_term_days')->default(0);
            $table->decimal('subtotal', 18, 2)->default(0);
            $table->decimal('discount_amount', 18, 2)->default(0);
            $table->decimal('tax_amount', 18, 2)->default(0);
            $table->decimal('grand_total', 18, 2)->default(0);
            $table->enum('status', ['draft', 'confirmed', 'in_process', 'partially_delivered', 'completed', 'closed', 'cancelled'])->default('draft')->index();
            $table->text('notes')->nullable();
            $table->string('customer_po_no')->nullable();
            $table->date('customer_po_date')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sales_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('quotation_item_id')->nullable()->constrained('quotation_items')->nullOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('item_code')->nullable();
            $table->string('item_name');
            $table->text('description')->nullable();
            $table->decimal('qty_order', 18, 2);
            $table->decimal('qty_delivered', 18, 2)->default(0);
            $table->foreignId('unit_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('unit_price', 18, 2);
            $table->decimal('discount_percent', 8, 2)->default(0);
            $table->decimal('discount_amount', 18, 2)->default(0);
            $table->foreignId('tax_code_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('tax_amount', 18, 2)->default(0);
            $table->decimal('line_total', 18, 2);
            $table->timestamps();
        });

        Schema::create('service_orders', function (Blueprint $table) {
            $table->id();
            $table->string('service_order_no')->unique();
            $table->foreignId('quotation_id')->nullable()->index()->constrained()->nullOnDelete();
            $table->foreignId('customer_id')->index()->constrained()->restrictOnDelete();
            $table->foreignId('customer_contact_id')->nullable()->constrained('customer_contacts')->nullOnDelete();
            $table->foreignId('service_address_id')->nullable()->constrained('customer_addresses')->nullOnDelete();
            $table->date('order_date');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('currency_code', 10)->default('IDR');
            $table->integer('payment_term_days')->default(0);
            $table->decimal('subtotal', 18, 2)->default(0);
            $table->decimal('discount_amount', 18, 2)->default(0);
            $table->decimal('tax_amount', 18, 2)->default(0);
            $table->decimal('grand_total', 18, 2)->default(0);
            $table->enum('status', ['draft', 'confirmed', 'scheduled', 'on_progress', 'completed', 'closed', 'cancelled'])->default('draft')->index();
            $table->text('scope_of_work')->nullable();
            $table->text('notes')->nullable();
            $table->string('customer_po_no')->nullable();
            $table->date('customer_po_date')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('service_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('quotation_item_id')->nullable()->constrained('quotation_items')->nullOnDelete();
            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();
            $table->string('item_code')->nullable();
            $table->string('item_name');
            $table->text('description')->nullable();
            $table->decimal('qty_order', 18, 2);
            $table->decimal('qty_completed', 18, 2)->default(0);
            $table->foreignId('unit_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('unit_price', 18, 2);
            $table->decimal('discount_percent', 8, 2)->default(0);
            $table->decimal('discount_amount', 18, 2)->default(0);
            $table->foreignId('tax_code_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('tax_amount', 18, 2)->default(0);
            $table->decimal('line_total', 18, 2);
            $table->timestamps();
        });

        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->string('delivery_no')->unique();
            $table->foreignId('sales_order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained()->restrictOnDelete();
            $table->date('delivery_date');
            $table->foreignId('delivery_address_id')->nullable()->constrained('customer_addresses')->nullOnDelete();
            $table->string('recipient_name')->nullable();
            $table->string('recipient_phone')->nullable();
            $table->enum('status', ['draft', 'shipped', 'delivered', 'accepted', 'cancelled'])->default('draft');
            $table->text('notes')->nullable();
            $table->string('proof_file')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('delivery_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('delivery_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sales_order_item_id')->constrained()->restrictOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('item_name');
            $table->decimal('qty_delivery', 18, 2);
            $table->foreignId('unit_id')->nullable()->constrained()->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('service_reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_no')->unique();
            $table->foreignId('service_order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained()->restrictOnDelete();
            $table->date('report_date');
            $table->dateTime('start_datetime')->nullable();
            $table->dateTime('end_datetime')->nullable();
            $table->text('summary')->nullable();
            $table->text('work_result')->nullable();
            $table->text('customer_feedback')->nullable();
            $table->string('customer_representative')->nullable();
            $table->boolean('customer_accepted')->default(false);
            $table->dateTime('accepted_at')->nullable();
            $table->enum('status', ['draft', 'submitted', 'accepted', 'revised', 'cancelled'])->default('draft');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->unique();
            $table->enum('invoice_type', ['product', 'service', 'mixed'])->default('mixed');
            $table->foreignId('sales_order_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('service_order_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('quotation_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('customer_id')->index()->constrained()->restrictOnDelete();
            $table->foreignId('customer_contact_id')->nullable()->constrained('customer_contacts')->nullOnDelete();
            $table->foreignId('billing_address_id')->nullable()->constrained('customer_addresses')->nullOnDelete();
            $table->date('invoice_date');
            $table->date('due_date')->index();
            $table->string('currency_code', 10)->default('IDR');
            $table->integer('payment_term_days')->default(0);
            $table->decimal('subtotal', 18, 2)->default(0);
            $table->decimal('discount_amount', 18, 2)->default(0);
            $table->decimal('tax_amount', 18, 2)->default(0);
            $table->decimal('grand_total', 18, 2)->default(0);
            $table->decimal('paid_amount', 18, 2)->default(0);
            $table->decimal('balance_amount', 18, 2)->default(0);
            $table->enum('status', ['draft', 'posted', 'sent', 'partially_paid', 'paid', 'overdue', 'void', 'cancelled'])->default('draft')->index();
            $table->timestamp('posted_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->text('notes')->nullable();
            $table->text('internal_notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained()->cascadeOnDelete();
            $table->enum('source_type', ['sales_order_item', 'service_order_item', 'manual'])->default('manual');
            $table->unsignedBigInteger('source_id')->nullable();
            $table->enum('item_type', ['product', 'service']);
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();
            $table->string('item_code')->nullable();
            $table->string('item_name');
            $table->text('description')->nullable();
            $table->decimal('qty', 18, 2);
            $table->foreignId('unit_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('unit_price', 18, 2);
            $table->decimal('discount_percent', 8, 2)->default(0);
            $table->decimal('discount_amount', 18, 2)->default(0);
            $table->foreignId('tax_code_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('tax_amount', 18, 2)->default(0);
            $table->decimal('line_total', 18, 2);
            $table->timestamps();
        });

        Schema::create('invoice_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained()->cascadeOnDelete();
            $table->date('payment_date');
            $table->string('reference_no')->nullable();
            $table->enum('payment_method', ['cash', 'transfer', 'giro', 'card', 'other'])->default('transfer');
            $table->decimal('amount', 18, 2);
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_payments');
        Schema::dropIfExists('invoice_items');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('service_reports');
        Schema::dropIfExists('delivery_items');
        Schema::dropIfExists('deliveries');
        Schema::dropIfExists('service_order_items');
        Schema::dropIfExists('service_orders');
        Schema::dropIfExists('sales_order_items');
        Schema::dropIfExists('sales_orders');
        Schema::dropIfExists('approval_steps');
        Schema::dropIfExists('approvals');
        Schema::dropIfExists('quotation_revisions');
        Schema::dropIfExists('quotation_items');
        Schema::dropIfExists('quotations');
    }
};
