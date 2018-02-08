<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->integer('customer_id')->unsigned()->index();
            $table->string('invoice_number')->nullable();
            $table->string('delivery_number')->nullable();
            $table->tinyInteger('sale_status')->nullable()->default(0); // capture suspended sales
            $table->string('payment_mode')->default('cash');
            $table->text('comments')->nullable();
            $table->decimal('sale_total', 12, 2)->default(0);
            $table->string('sale_type')->default('sale'); // allow printing of quotation
            $table->decimal('amount_paid', 12, 2)->default(0);
            $table->decimal('balance_due', 12, 2)->default(0);
            $table->string('payment_status')->nullable();
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
        Schema::dropIfExists('sales');
    }
}
