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
        Schema::create('codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('camp_id');
            $table->foreignId('sheet_id');
            $table->date('issue_date');
            $table->dateTime('submit_datetime');
            $table->string('username');
            $table->string('password');
            $table->string('customer_name');
            $table->string('room_no')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('note')->nullable();
            $table->tinyInteger('status');
            $table->foreignId('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('codes');
    }
};
