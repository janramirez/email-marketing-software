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
        Schema::create('mail_group_subscribers', function (Blueprint $table) {
            $table->id();

            $table->string('status')->nullable()->default(null);

            $table->foreignId('mail_group_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subscriber_id')->constrained()->cascadeOnDelete();

            $table->dateTime('subscribed_at')->useCurrent();

            $table->unique(['mail_group_id', 'subscriber_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mail_group_subscribers');
    }
};
