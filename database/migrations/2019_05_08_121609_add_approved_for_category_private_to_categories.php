<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApprovedForCategoryPrivateToCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function($table) {
            $table->decimal('approved_for_category_private', 10,2)->after('approved_for_category')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('approved_for_category_private', 'categories')) {

            Schema::table('categories', function($table) {
                $table->dropColumn('approved_for_category_private');
            });
        }
    }
}
