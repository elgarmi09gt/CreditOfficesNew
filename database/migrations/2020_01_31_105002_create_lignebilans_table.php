<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLignebilansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $BD = array('bic_bd_test', 'bic_beninbd', 'bic_bissaubd', 'bic_burkinabd', 'bic_coteivoirbd', 'bic_malibd', 'bic_nigerbd', 'bic_senegalbd', 'bic_togobd');
   
        for ($i=0; $i < count($BD); $i++) {
            Schema::connection($BD[$i])->create('lignebilans', function (Blueprint $table) {
                $table->unsignedBigInteger('idRubrique');
                $table->unsignedBigInteger('idEntreprise');
                $table->year('exercice');
                $table->decimal('brute', 15, 3);
                $table->decimal('provision', 15, 3);
                $table->timestamps();
                $table->primary(['idRubrique','idEntreprise','exercice']);
                $table->foreign('idRubrique')->references('id')->on('rubriques')->onDelete('cascade');
                $table->foreign('idEntreprise')->references('id')->on('entreprises')->onDelete('cascade');
            
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
        $BD = array('bic_bd_test', 'bic_beninbd', 'bic_bissaubd', 'bic_burkinabd', 'bic_coteivoirbd', 'bic_malibd', 'bic_nigerbd', 'bic_senegalbd', 'bic_togobd');
   
        for ($i=0; $i < count($BD); $i++) {
            Schema::connection($BD[$i])->dropIfExists('lignebilans');
        }
    }
}
