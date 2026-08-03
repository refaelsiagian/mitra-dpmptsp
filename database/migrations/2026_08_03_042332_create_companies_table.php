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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->enum('pelaku_usaha_type', ['orang-perseorangan', 'badan-usaha', 'kantor-perwakilan', 'badan-usaha-luar-negeri']);
            $table->string('pelaku_usaha_detail')->nullable();
            $table->string('perseorangan_nik')->nullable();
            $table->string('nib_number');
            $table->text('nib_link')->nullable();
            $table->string('npwp_number');
            $table->text('npwp_link')->nullable();
            $table->boolean('is_npwp_same_as_nik')->default(false);
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
