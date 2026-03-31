<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // Sheet-aligned HR fields
            $table->date('rec_date')->nullable()->after('employee_no');
            $table->date('join_date')->nullable()->after('rec_date');
            $table->string('name_with_initials')->nullable()->after('full_name');

            // Family / relationship / HR support fields
            $table->string('close_relation')->nullable()->after('religion');
            $table->string('relationship')->nullable()->after('close_relation');
            $table->string('cr_contact')->nullable()->after('relationship');

            // Education / qualification / experience
            $table->string('education')->nullable()->after('cr_contact');
            $table->string('other_qualification')->nullable()->after('education');
            $table->text('previous_experience')->nullable()->after('other_qualification');
            $table->string('experience_period')->nullable()->after('previous_experience');

            // Document / compliance checklist
            $table->boolean('doc_m_um')->default(false)->after('experience_period');
            $table->boolean('doc_pension')->default(false)->after('doc_m_um');
            $table->boolean('doc_i_al')->default(false)->after('doc_pension');
            $table->boolean('doc_2_ca')->default(false)->after('doc_i_al');
            $table->boolean('doc_3_wcl')->default(false)->after('doc_2_ca');
            $table->boolean('doc_4_nic_c')->default(false)->after('doc_3_wcl');
            $table->boolean('doc_5_bc')->default(false)->after('doc_4_nic_c');
            $table->boolean('doc_6_gnc')->default(false)->after('doc_5_bc');
            $table->boolean('doc_7_pr')->default(false)->after('doc_6_gnc');
            $table->boolean('doc_8_ec')->default(false)->after('doc_7_pr');
            $table->boolean('doc_9_qc')->default(false)->after('doc_8_ec');
            $table->boolean('doc_10_chc')->default(false)->after('doc_9_qc');
            $table->boolean('doc_11_po')->default(false)->after('doc_10_chc');
            $table->boolean('doc_12_fp')->default(false)->after('doc_11_po');
            $table->boolean('doc_13_ba')->default(false)->after('doc_12_fp');
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn([
                'rec_date',
                'join_date',
                'name_with_initials',
                'close_relation',
                'relationship',
                'cr_contact',
                'education',
                'other_qualification',
                'previous_experience',
                'experience_period',
                'doc_m_um',
                'doc_pension',
                'doc_i_al',
                'doc_2_ca',
                'doc_3_wcl',
                'doc_4_nic_c',
                'doc_5_bc',
                'doc_6_gnc',
                'doc_7_pr',
                'doc_8_ec',
                'doc_9_qc',
                'doc_10_chc',
                'doc_11_po',
                'doc_12_fp',
                'doc_13_ba',
            ]);
        });
    }
};