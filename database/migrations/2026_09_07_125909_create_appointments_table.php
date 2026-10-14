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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->string('client_name');
            $table->string('client_email');
            $table->string('client_phone');
            $table->string('service');
            $table->date('preferred_date');
            $table->time('preferred_time');
            $table->text('message')->nullable();
            $table->string('status')->default('pending');
            $table->boolean('email_sent')->default(false);
            $table->boolean('whatsapp_sent')->default(false);
            $table->text('email_error')->nullable();
            $table->text('whatsapp_error')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
