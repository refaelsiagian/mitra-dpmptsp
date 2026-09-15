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
        Schema::create('rabs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('proposal_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('title')->default('Rencana Anggaran Biaya (RAB)');
            $table->decimal('total_amount', 20, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('rab_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rab_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->decimal('total_amount', 20, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('rab_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rab_category_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->decimal('volume', 10, 2)->default(0);
            $table->string('unit')->nullable(); // satuan unit
            $table->decimal('unit_price', 20, 2)->default(0); // harga per unit
            $table->decimal('total_price', 20, 2)->default(0); // total harga
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rab_items');
        Schema::dropIfExists('rab_categories');
        Schema::dropIfExists('rabs');
    }
};
