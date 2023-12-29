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
        Schema::create('Livro_Autor', function (Blueprint $table) {
            $table->integer('Livro_Codl')->unsigned();
            $table->integer('Autor_CodAu')->unsigned();
            
            $table->foreign('Livro_Codl')->references('Codl')->on('Livro')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('Autor_CodAu')->references('CodAu')->on('Autor')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Livro_Autor');
    }
};
