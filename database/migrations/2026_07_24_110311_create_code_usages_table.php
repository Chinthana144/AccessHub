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
        Schema::create('code_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('camp_id');
            $table->string('username');
            $table->string('password');
            $table->string('profile');
            $table->string('mac_address')->nullable();
            $table->dateTime('first_login_at')->nullable();
            $table->dateTime('expire_at')->nullable();
            $table->tinyInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('code_usages');
    }
};
