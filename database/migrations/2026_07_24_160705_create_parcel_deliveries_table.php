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
    Schema::create('parcel_deliveries', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        
        $table->foreignId('locker_id')->nullable()->constrained('parcel_lockers')->nullOnDelete(); 
        
        $table->string('courier_company');
        $table->string('tracking_number')->nullable();
        $table->string('pickup_code', 6); 
        
        $table->enum('status', ['Pending Pickup', 'Picked Up'])->default('Pending Pickup');
        
        $table->timestamp('delivered_at')->useCurrent(); 
        $table->timestamp('picked_up_at')->nullable(); 
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parcel_deliveries');
    }
};
