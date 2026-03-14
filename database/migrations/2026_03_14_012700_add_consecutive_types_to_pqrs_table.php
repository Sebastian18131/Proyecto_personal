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
        Schema::table('p_q_r_s', function (Blueprint $table) {
            $table->string('radicado')->nullable()->after('id');
            $table->enum('type', ['entrada', 'salida', 'interna'])->default('entrada')->after('radicado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('p_q_r_s', function (Blueprint $table) {
            $table->dropColumn(['radicado', 'type']);
        });
    }
};
