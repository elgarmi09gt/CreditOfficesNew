<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntreprisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $BD = array('bic_bd_test', 'bic_beninbd', 'bic_bissaubd', 'bic_burkinabd', 'bic_coteivoirbd', 'bic_malibd', 'bic_nigerbd', 'bic_senegalbd', 'bic_togobd', 'bic_uemoa','bic_bd_umoa_test');
   
        for ($i=0; $i < count($BD); $i++) {
            Schema::connection($BD[$i])->create('entreprises', function (Blueprint $table) {
                $table->unsignedBigInteger('id');
                $table->string('numRegistre');
                $table->string('type');
                $table->string('numEnregistre');
                $table->text('entreprise');
                $table->string('sigle');
                $table->string('adresse');
                $table->string('telephone');
                $table->string('fax');
                $table->text('website');
                $table->string('boitePostale');
                $table->date('dateCreation');
                $table->unsignedBigInteger('idPays');
                $table->timestamps();
                $table->primary(['id','idPays']);
                $table->foreign('idPays')->references('id')->on('pays')->onDelete('cascade');
            
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
        $BD = array('bic_bd_test', 'bic_beninbd', 'bic_bissaubd', 'bic_burkinabd', 'bic_coteivoirbd', 'bic_malibd', 'bic_nigerbd', 'bic_senegalbd', 'bic_togobd', 'bic_uemoa','bic_bd_umoa_test');
   
        for ($i=0; $i < count($BD); $i++) {
            Schema::connection($BD[$i])->dropIfExists('entreprises');
        }
    }
}
