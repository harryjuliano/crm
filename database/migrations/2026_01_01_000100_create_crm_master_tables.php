<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('legal_name')->nullable();
            $table->string('tax_no')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('country')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('logo')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('sales_areas', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('customer_groups', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('industries', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('lead_sources', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('service_categories', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('tax_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->enum('tax_type', ['ppn', 'pph', 'non_tax'])->default('non_tax');
            $table->decimal('rate', 8, 4)->default(0);
            $table->boolean('is_inclusive')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('code')->unique();
            $table->string('sku')->nullable();
            $table->string('barcode')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('specification')->nullable();
            $table->foreignId('unit_id')->constrained()->restrictOnDelete();
            $table->foreignId('tax_code_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('standard_price', 18, 2)->default(0);
            $table->decimal('minimum_price', 18, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('scope_of_work')->nullable();
            $table->foreignId('unit_id')->constrained()->restrictOnDelete();
            $table->foreignId('tax_code_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('standard_price', 18, 2)->default(0);
            $table->decimal('minimum_price', 18, 2)->default(0);
            $table->string('estimated_duration')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('price_lists', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->foreignId('customer_group_id')->nullable()->constrained()->nullOnDelete();
            $table->string('currency_code', 10)->default('IDR');
            $table->date('valid_from')->nullable();
            $table->date('valid_to')->nullable();
            $table->enum('status', ['draft', 'active', 'inactive'])->default('draft');
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('price_list_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('price_list_id')->constrained()->cascadeOnDelete();
            $table->enum('item_type', ['product', 'service']);
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('price', 18, 2);
            $table->decimal('min_qty', 18, 2)->default(1);
            $table->decimal('discount_percent', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('price_list_items');
        Schema::dropIfExists('price_lists');
        Schema::dropIfExists('services');
        Schema::dropIfExists('products');
        Schema::dropIfExists('tax_codes');
        Schema::dropIfExists('service_categories');
        Schema::dropIfExists('product_categories');
        Schema::dropIfExists('units');
        Schema::dropIfExists('lead_sources');
        Schema::dropIfExists('industries');
        Schema::dropIfExists('customer_groups');
        Schema::dropIfExists('sales_areas');
        Schema::dropIfExists('branches');
        Schema::dropIfExists('companies');
    }
};
