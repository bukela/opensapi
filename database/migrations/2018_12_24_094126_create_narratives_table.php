<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNarrativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('narratives', function (Blueprint $table) {
            $table->increments('id');
            $table->string('contract_number')->nullable();
            $table->integer('project_id');
            $table->string('project_title');
            $table->string('organization_name');
            $table->decimal('project_value', 10,2)->nullable();
            $table->decimal('project_funds', 10,2)->nullable();
            $table->decimal('project_spent', 10,2)->nullable();
            $table->text('application_area')->nullable();
            $table->string('authorized_person')->nullable();
            $table->string('coordinator')->nullable();
            $table->text('short_description')->nullable();
            $table->text('accomplished_goals')->nullable();
            $table->text('goal_explanation')->nullable();
            $table->text('expected_results')->nullable();
            $table->text('target_group_direct')->nullable();
            $table->text('target_group_indirect')->nullable();
            $table->text('other')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('narratives');
    }
}
