<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_detail_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_detail_section_id')->constrained('employee_detail_sections')->cascadeOnDelete();
            $table->string('field_label');
            $table->enum('input_type', ['text', 'number', 'date', 'textarea', 'email']);
            $table->text('field_value')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_detail_fields');
    }
};
