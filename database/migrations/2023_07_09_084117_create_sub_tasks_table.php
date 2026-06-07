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
        Schema::create('sub_tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_management_model_id');
            $table->boolean('fail_label_for_system')->default(0);
            $table->boolean('success_label_for_system')->default(0);
            $table->text('uuid')->nullable();
            $table->text('uuid_sub_task')->nullable();
            $table->boolean('is_cancel')->default(0);
            $table->boolean('is_complete')->default(0);
            $table->boolean('is_fail')->default(0);
            $table->boolean('is_success')->default(0);
            $table->enum('searchable',['private','public'])->default('private');
            $table->unsignedBigInteger('user_id');
            $table->text('creator');
            $table->text('current_status')->nullable();
            $table->text('label_for_system')->nullable();
            $table->text('label_for_system2')->nullable();
            $table->text('pending_for')->nullable();
            $table->text('visibletousers')->nullable();
            $table->text('visibletoteams')->nullable();
            $table->text('createdbyteam')->nullable();
            $table->text('raisedbyuser')->nullable();
            $table->text('issue');
            $table->text('impact')->nullable();
            $table->text('rc')->nullable();
            $table->text('solution')->nullable();
            $table->text('solution2')->nullable();
            $table->text('solution3')->nullable();
            $table->timestamp('latest_update')->nullable();
            $table->timestamp('due_date')->nullable();
            $table->text('progress')->nullable();
            $table->text('owner')->nullable();
            $table->text('current_processor')->nullable();
            $table->text('owner_team')->nullable();
            $table->text('support')->nullable();
            $table->text('description')->nullable();
            $table->text('feedback')->nullable();
            $table->text('priority')->nullable();
            $table->text('complete_description')->nullable();
            $table->text('cancel_description')->nullable();
            $table->text('fail_description')->nullable();
            $table->timestamp('complete_date')->nullable();
            $table->timestamp('cancel_date')->nullable();
            $table->timestamp('fail_date')->nullable();
            $table->string('string_reserve1')->nullable();
            $table->string('string_reserve2')->nullable();
            $table->string('string_reserve3')->nullable();
            $table->string('string_reserve4')->nullable();
            $table->string('string_reserve5')->nullable();
            $table->string('string_reserve6')->nullable();
            $table->string('string_reserve7')->nullable();
            $table->string('string_reserve8')->nullable();
            $table->string('string_reserve9')->nullable();
            $table->string('string_reserve10')->nullable();
            $table->text('text_reserve1')->nullable();
            $table->text('text_reserve2')->nullable();
            $table->text('text_reserve3')->nullable();
            $table->text('text_reserve4')->nullable();
            $table->text('text_reserve5')->nullable();
            $table->text('text_reserve6')->nullable();
            $table->text('text_reserve7')->nullable();
            $table->text('text_reserve8')->nullable();
            $table->text('text_reserve9')->nullable();
            $table->text('text_reserve10')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_tasks');
    }
};
