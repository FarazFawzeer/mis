<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // Personal Information
            $table->date('dob')->nullable()->after('full_name');
            $table->integer('age')->nullable()->after('dob');
            $table->text('address')->nullable()->after('email');
            $table->string('district')->nullable()->after('address');
            $table->string('gs_division')->nullable()->after('district');
            $table->string('police_station')->nullable()->after('gs_division');
            $table->string('nationality')->nullable()->after('police_station');
            $table->string('religion')->nullable()->after('nationality');

            // Job Information
            $table->string('service_number')->nullable()->after('religion');
            $table->string('rank')->nullable()->after('service_number');
            $table->string('site_location')->nullable()->after('rank');
            $table->string('vo')->nullable()->after('site_location');

            // Bank & Salary Information
            $table->string('bank_name')->nullable()->after('vo');
            $table->string('account_number')->nullable()->after('bank_name');
            $table->string('branch')->nullable()->after('account_number');
            $table->decimal('salary', 12, 2)->nullable()->after('branch');
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn([
                'dob',
                'age',
                'address',
                'district',
                'gs_division',
                'police_station',
                'nationality',
                'religion',
                'service_number',
                'rank',
                'site_location',
                'vo',
                'bank_name',
                'account_number',
                'branch',
                'salary',
            ]);
        });
    }
};