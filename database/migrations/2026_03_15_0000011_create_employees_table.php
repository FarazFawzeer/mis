<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_no')->nullable()->unique();
            $table->string('full_name');
            $table->string('nic')->nullable()->unique();
            $table->string('phone')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('department')->nullable();
            $table->string('designation')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
