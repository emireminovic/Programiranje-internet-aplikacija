<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('termins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('frizer_id')->constrained('frizers')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('datum');
            $table->time('vreme');
            $table->string('status')->default('slobodan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('termins');
    }
};