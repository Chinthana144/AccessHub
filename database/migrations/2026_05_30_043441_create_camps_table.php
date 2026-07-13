<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('camps', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('contactPerson');
            $table->string('contactNo');
            $table->string('mikrotikHost');
            $table->string('mikrotikPort');
            $table->string('mikrotikUsername');
            $table->string('mikrotikPassword');
            $table->string('sheetID');
            $table->tinyInteger('is_upload');
            $table->tinyInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('camps');
    }
};
