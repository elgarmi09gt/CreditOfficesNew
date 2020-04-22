<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgencesTable extends Migration
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
            Schema::connection($BD[$i])->create('agences', function (Blueprint $table) {
                $table->unsignedBigInteger('id');
                $table->string('agence');
                $table->string('adresse');
                $table->string('codeRegion');
                $table->string('region');
                $table->unsignedBigInteger('idEntreprise');
                $table->timestamps();
                $table->primary(['id','codeRegion','idEntreprise']);
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
            Schema::connection($BD[$i])->dropIfExists('agences');
        }
    }
}
