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
        Schema::create('borrow_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('equipment_id')->constrained('shared_equipments')->cascadeOnDelete();

            $table->dateTime('borrowed_at')->nullable();
            $table->dateTime('due_at');
            $table->dateTime('returned_at')->nullable();

            $table->enum('status', ['reserved', 'in_use', 'returned', 'overdue'])->default('reserved');
            $table->text('admin_remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrow_records');
    }
};
