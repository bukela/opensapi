<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaymentDateToCosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('costs', function($table) {
            $table->date('payment_date')->after('spent')->nullable();
            $table->string('invoice_number')->after('spent')->nullable();
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
                'payment_date',
                'invoice_number'
                ]);
        });
    }
}
