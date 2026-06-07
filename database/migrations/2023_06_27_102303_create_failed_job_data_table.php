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
        Schema::create('failed_job_data', function (Blueprint $table) {
            $table->id();
            $table->text('connection')->nullable();
            $table->text('queue')->nullable();
            $table->text('payload')->nullable();
            $table->text('exception')->nullable();
            $table->text('failed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('failed_job_data');
    }
};
