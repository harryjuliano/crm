<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('complaint_no')->unique();
            $table->foreignId('customer_id')->index()->constrained()->restrictOnDelete();
            $table->foreignId('customer_contact_id')->nullable()->constrained('customer_contacts')->nullOnDelete();
            $table->foreignId('invoice_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('sales_order_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('service_order_id')->nullable()->constrained()->nullOnDelete();
            $table->date('complaint_date');
            $table->enum('category', ['product_quality', 'service_quality', 'delivery', 'billing', 'communication', 'other'])->default('other');
            $table->enum('severity', ['low', 'medium', 'high', 'critical'])->default('medium')->index();
            $table->string('title');
            $table->text('description');
            $table->text('root_cause')->nullable();
            $table->text('corrective_action')->nullable();
            $table->text('preventive_action')->nullable();
            $table->foreignId('assigned_to')->nullable()->index()->constrained('users')->nullOnDelete();
            $table->date('due_date')->nullable();
            $table->enum('status', ['open', 'investigating', 'action_in_progress', 'resolved', 'closed', 'cancelled'])->default('open')->index();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('complaint_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('complaint_id')->constrained()->cascadeOnDelete();
            $table->dateTime('action_date');
            $table->enum('action_type', ['investigation', 'correction', 'corrective_action', 'preventive_action', 'customer_response', 'internal_note']);
            $table->text('notes');
            $table->foreignId('action_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('customer_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('customer_contact_id')->nullable()->constrained('customer_contacts')->nullOnDelete();
            $table->enum('source_type', ['quotation', 'sales_order', 'service_order', 'invoice', 'general'])->default('general');
            $table->unsignedBigInteger('source_id')->nullable();
            $table->date('feedback_date');
            $table->integer('rating_product')->nullable();
            $table->integer('rating_service')->nullable();
            $table->integer('rating_response')->nullable();
            $table->integer('overall_rating')->nullable();
            $table->text('comments')->nullable();
            $table->text('suggestion')->nullable();
            $table->enum('status', ['open', 'reviewed', 'closed'])->default('open');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('reminders', function (Blueprint $table) {
            $table->id();
            $table->morphs('remindable');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('remind_at');
            $table->enum('status', ['pending', 'done', 'cancelled', 'overdue'])->default('pending');
            $table->dateTime('completed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->morphs('attachable');
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_extension')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->string('mime_type')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('module');
            $table->string('activity');
            $table->text('description')->nullable();
            $table->string('subject_type')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->morphs('auditable');
            $table->enum('event', ['created', 'updated', 'deleted', 'approved', 'rejected', 'status_changed', 'revision']);
            $table->longText('old_values')->nullable();
            $table->longText('new_values')->nullable();
            $table->text('reason')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('document_numberings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('module', ['lead', 'opportunity', 'quotation', 'sales_order', 'service_order', 'delivery', 'service_report', 'invoice', 'complaint']);
            $table->string('prefix');
            $table->string('format_example')->nullable();
            $table->enum('reset_type', ['none', 'monthly', 'yearly'])->default('yearly');
            $table->unsignedBigInteger('current_number')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_numberings');
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('attachments');
        Schema::dropIfExists('reminders');
        Schema::dropIfExists('customer_feedbacks');
        Schema::dropIfExists('complaint_actions');
        Schema::dropIfExists('complaints');
    }
};
