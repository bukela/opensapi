<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToNarrative extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('narratives', function (Blueprint $table) {
            $table->text('difference_planned_involved')->after('target_group_indirect')->nullable();
            $table->text('user_selection_method')->after('target_group_indirect')->nullable();
            $table->text('project_realisation_problems')->after('target_group_indirect')->nullable();
            $table->text('project_realisation_partners')->after('target_group_indirect')->nullable();
            $table->text('project_promotion')->after('target_group_indirect')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

            Schema::table('narratives', function($table) {
                $table->dropColumn([
                    'difference_planned_involved',
                    'user_selection_method',
                    'project_realisation_problems',
                    'project_realisation_partners',
                    'project_promotion'
                    ]);
            });
    }
}
