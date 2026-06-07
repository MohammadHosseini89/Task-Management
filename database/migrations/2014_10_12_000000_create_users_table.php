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
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->enum('status',['active','disabled']);
            $table->string('jobid')->nullable();
            $table->boolean('is_superuser')->default(0);
            $table->boolean('route1')->default(0);
            $table->boolean('route2')->default(0); 
            $table->boolean('route3')->default(0);
            $table->boolean('route4')->default(0);
            $table->boolean('route5')->default(0);
            $table->boolean('route6')->default(0);
            $table->boolean('route7')->default(0); 
            $table->boolean('route8')->default(0);
            $table->boolean('route9')->default(0);
            $table->boolean('route10')->default(0);
            $table->boolean('route11')->default(0);
            $table->boolean('route12')->default(0);
            $table->boolean('route13')->default(0);
            $table->boolean('route14')->default(0);
            $table->boolean('route15')->default(0);
            $table->boolean('route16')->default(0);
            $table->boolean('route17')->default(0);
            $table->boolean('route18')->default(0);
            $table->boolean('is_reserve1')->default(0);
            $table->boolean('is_reserve2')->default(0);
            $table->boolean('is_reserve3')->default(0);
            $table->boolean('is_reserve4')->default(0);
            $table->boolean('is_reserve5')->default(0);
            $table->boolean('is_reserve6')->default(0);
            $table->boolean('is_reserve7')->default(0);
            $table->boolean('is_reserve8')->default(0);
            $table->boolean('is_reserve9')->default(0);
            $table->boolean('is_reserve10')->default(0);
            $table->string('string_reserve1')->nullable();
            $table->string('string_reserve2')->nullable();
            $table->string('string_reserve3')->nullable();
            $table->string('string_reserve4')->nullable();
            $table->string('string_reserve5')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
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
