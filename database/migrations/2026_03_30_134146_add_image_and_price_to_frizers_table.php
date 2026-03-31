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
    Schema::table('frizers', function (Blueprint $table) {
        $table->string('slika')->nullable();
        $table->decimal('cena', 8, 2)->nullable();
    });
}

public function down(): void
{
    Schema::table('frizers', function (Blueprint $table) {
        $table->dropColumn(['slika', 'cena']);
    });
}
};
