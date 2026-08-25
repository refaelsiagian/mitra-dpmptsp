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
        Schema::table('projects', function (Blueprint $table) {
            $table->string('image')->nullable()->after('title');
            
            // Drop old location column
            $table->dropColumn('location');
            
            // Add new location fields
            $table->string('province_id')->nullable()->after('is_budget_negotiable');
            $table->string('regency_id')->nullable()->after('province_id');
            $table->string('district_id')->nullable()->after('regency_id');
            $table->string('village_id')->nullable()->after('district_id');
            $table->text('address')->nullable()->after('village_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['image', 'province_id', 'regency_id', 'district_id', 'village_id', 'address']);
            $table->string('location')->nullable();
        });
    }
};
