<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLigneservicesTable extends Migration
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
            Schema::connection($BD[$i])->create('ligneservices', function (Blueprint $table) {
                $table->unsignedBigInteger('idEntreprise');
                $table->unsignedBigInteger('idService');
                $table->unsignedBigInteger('idSousecteur');
                $table->string('type');
                $table->timestamps();
                
                $table->primary(['idService','idSousecteur','idEntreprise']);
                $table->foreign('idService')->references('id')->on('services')->onDelete('cascade');
                $table->foreign('idSousecteur')->references('id')->on('soussecteurs')->onDelete('cascade');
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
            Schema::connection($BD[$i])->dropIfExists('ligneservices');
        }
    }
}
