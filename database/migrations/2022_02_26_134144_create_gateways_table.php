<?php

use App\Constants\GatewayStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGatewaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gateways', function (Blueprint $table) {
            $table->id();
            $table->string('payment_id');
            $table->string('transaction_id');
            $table->string('reference_id')->nullable();
            $table->double('amount');
            $table->string('via')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', GatewayStatus::toArray())->default(GatewayStatus::INIT);
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
        Schema::dropIfExists('gateways');
    }
}
