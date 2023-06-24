<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteFieldsInGoodLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('good_loans', function (Blueprint $table) {
            $table->dropColumn('warehouses_id');
            $table->dropColumn('room_source');
            $table->dropColumn('loan_stock');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('good_loans', function (Blueprint $table) {
            $table->integer('loan_stock');
            $table->integer('room_source');
            $table->integer('warehouses_id');
        });
    }
}
