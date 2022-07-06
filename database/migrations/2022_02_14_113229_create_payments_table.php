<?php

use App\Constants\PaymentStatus;
use App\Constants\PaymentType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('unique_code')->unique()->nullable();
            $table->foreignId('sale_id');
            $table->timestamp('due_date')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->string('amount')->nullable();
            $table->enum('type', PaymentType::toArray())->nullable();
            $table->enum('status', PaymentStatus::toArray())->default(PaymentStatus::UNPAID);
            $table->string('attachment')->nullable();
            $table->timestamps();
            $table->foreign('sale_id')->references('id')->on('sales')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
