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
        Schema::create('users', function (Blueprint $table) {
            $table->id()->unique();
            $table->timestamps();
$table->string('name')->nullable();
$table->string('email')->unique();
$table->string('username')->nullable();
$table->boolean('email_verified')->default(0);
$table->string('country')->nullable();
$table->string('password');
$table->string('profile_image')->nullable();
$table->integer('verification_code')->nullable();
$table->boolean('verified')->default(0);
$table->enum('status', ['active', 'suspended', 'banned'])->default('banned');
$table->string('skills')->nullable();
$table->string('bio')->nullable();
$table->enum('type', ['client', 'freelancer', 'admin'])->default('client');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
