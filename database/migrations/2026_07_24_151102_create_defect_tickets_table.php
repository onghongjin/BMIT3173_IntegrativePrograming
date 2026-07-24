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
        Schema::create('defect_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->enum('category', ['plumbing', 'electrical', 'structural', 'others']);
            $table->string('location');
            $table->text('description');
            $table->string('photo_path')->nullable(); 
            $table->string('assigned_to')->nullable(); 

            $table->enum('status', ['pending', 'assigned', 'in_progress', 'resolved', 'closed'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('defect_tickets');
    }
};
