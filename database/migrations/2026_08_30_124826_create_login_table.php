<?php

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
use HasUuids;
    public function up(): void
    {
        Schema::create('login', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('username');
            $table->string('role');
            $table->string('password');
            $table->string('email');
            $table->integer('otpcode')->nullable();
            $table->timestamp('otp_expires_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('login');
    }
};
