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
        Schema::create('scheduled_mails', function (Blueprint $table) {
            $table->id();

            $table->string('subject');
            $table->text('content');
            $table->string('status')->default('draft'); //--->TODO: enum ScheduledMailStatus
            $table->json('filters')->nullable();

            $table->timestamps();

            $table->foreignId('mail_group_id')->constrained();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scheduled_mails');
    }
};
