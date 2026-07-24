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
    Schema::create('parcel_lockers', function (Blueprint $table) {
        $table->id();
        $table->string('locker_number')->unique();
        $table->enum('size', ['Small', 'Medium', 'Large']);
        $table->enum('status', ['Available', 'Occupied', 'Maintenance'])->default('Available');
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parcel_lockers');
    }
};
