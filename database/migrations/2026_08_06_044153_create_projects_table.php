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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('type');
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('ruang_lingkup')->nullable();
            $table->decimal('estimated_value', 20, 2)->nullable();
            $table->boolean('is_budget_negotiable')->default(false);
            $table->string('location')->nullable();
            $table->date('offer_end_date')->nullable();
            $table->date('project_start_date')->nullable();
            $table->date('project_end_date')->nullable();
            $table->enum('status', ['draft', 'published', 'closed'])->default('published');
            
            // Flexible JSON columns
            $table->json('metrics')->nullable();
            $table->json('requirements')->nullable();
            $table->json('offerings')->nullable();
            $table->json('attachments')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
