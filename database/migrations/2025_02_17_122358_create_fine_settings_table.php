<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('fine_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('late_fee')->default(500);
            $table->unsignedBigInteger('lost_fee')->default(50000);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fine_settings');
    }
};
