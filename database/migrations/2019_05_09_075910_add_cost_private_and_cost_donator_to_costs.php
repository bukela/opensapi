<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCostPrivateAndCostDonatorToCosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('costs', function($table) {
            $table->decimal('spent_donator', 10,2)->after('project_id')->nullable();
            $table->decimal('spent_private', 10,2)->after('project_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('costs', function($table) {
            $table->dropColumn([
                'spent_donator',
                'spent_private'
                ]);
        });
    }
}
