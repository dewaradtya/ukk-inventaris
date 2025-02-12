<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('fines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrowing_id')->constrained('borrowings')->onDelete('cascade');
            $table->unsignedBigInteger('fine_amount');
            $table->unsignedBigInteger('paid_amount')->default(0);
            $table->string('payment_proof')->nullable();
            $table->enum('status', ['unpaid', 'partial', 'paid'])->default('unpaid');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fines');
    }
};
