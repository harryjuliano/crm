<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable()->unique()->after('email');
            $table->string('phone')->nullable()->after('username');
            $table->string('employee_no')->nullable()->after('phone');
            $table->foreignId('branch_id')->nullable()->after('employee_no')->constrained('branches')->nullOnDelete();
            $table->boolean('is_active')->default(true)->after('branch_id');
            $table->timestamp('last_login_at')->nullable()->after('is_active');
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('branch_id');
            $table->dropColumn([
                'username',
                'phone',
                'employee_no',
                'is_active',
                'last_login_at',
                'deleted_at',
            ]);
        });
    }
};
