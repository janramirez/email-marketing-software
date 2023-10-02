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
        Schema::create('blasts', function (Blueprint $table) {
            $table->id();

            $table->string('subject');
            $table->text('content');
            $table->json('filters')->nullable();
            
            $table->string('status')->default('draft'); //-> TODO: BlastStatus enum -->default(BlastStatus::Draft->value);
            $table->dateTime('sent_at')->nullable();
            
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            $table->timestamps();

            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blasts');
    }
};
