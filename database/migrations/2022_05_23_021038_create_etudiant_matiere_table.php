<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etudiant_matiere', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('matiere_id');
            $table->foreign('matiere_id')
                ->references('id')
                ->on('matieres')
                ->onDelete('cascade');

            $table->unsignedBigInteger('etudiant_id');
            $table->foreign('etudiant_id')
                ->references('id')
                ->on('etudiants')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('etudiant_matiere');
    }
};
