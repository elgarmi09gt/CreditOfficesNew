<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LignebilansUemoa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $BD = array('bic_uemoa','bic_bd_umoa_test');

        for ($i = 0; $i < count($BD); $i++) {
            Schema::connection($BD[$i])->create('lignebilans', function (Blueprint $table) {
                $table->unsignedBigInteger('idRubrique');
                $table->unsignedBigInteger('idEntreprise');
                $table->unsignedBigInteger('idPays');
                $table->year('exercice');
                $table->decimal('brute', 15, 3);
                $table->decimal('provision', 15, 3);
                $table->timestamps();
                $table->primary(['idRubrique','idEntreprise','idPays','exercice']);
                $table->foreign('idRubrique')->references('id')->on('rubriques')->onDelete('cascade');
                $table->foreign('idEntreprise')->references('id')->on('entreprises')->onDelete('cascade');
                $table->foreign('idPays')->references('idPays')->on('entreprises')->onDelete('cascade');

            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $BD = array('bic_uemoa','bic_bd_umoa_test');

        for ($i = 0; $i < count($BD); $i++) {
        Schema::connection($BD[$i])->dropIfExists('lignebilans');
}

    }
}
