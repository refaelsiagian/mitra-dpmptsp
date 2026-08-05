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
        Schema::create('company_offerings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('category')->nullable(); // e.g., Sub-Pekerjaan, Peluang KSO
            $table->string('title');
            $table->string('highlight_metric')->nullable(); // e.g., MOQ: 10 Ton, Zero CapEx
            $table->string('value_text')->nullable(); // e.g., Rp 1.2M, 70:30
            $table->text('description')->nullable();
            $table->boolean('is_pinned')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_offerings');
    }
};
