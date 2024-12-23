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
        Schema::table('certificates', function (Blueprint $table) {
            $table->enum('gender', ['male', 'female']); // Gender
            $table->string('phone_number'); // Phone Number
            $table->string('city'); // City
            $table->boolean('accept_policy')->default(false); 
            $table->enum('transferred_by', ['trainee', 'other']);
            $table->string('other')->nullable(); 
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->dropColumn([
                'gender',
                'phone_number',
                'city',
                'accept_policy',
                'transferred_by',
                'other'
            ]);
        });
    }
};
