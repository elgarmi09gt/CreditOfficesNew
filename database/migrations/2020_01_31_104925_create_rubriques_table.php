<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRubriquesTable extends Migration
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
            Schema::connection($BD[$i])->create('rubriques', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('codeRubrique');
                $table->text('rubrique');
                $table->unsignedBigInteger('idSousclasse')->index();
                $table->timestamps();
                $table->foreign('idSousclasse')->references('id')->on('sousclasses')->onDelete('cascade');
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
            Schema::connection($BD[$i])->dropIfExists('rubriques');
        }
    }
}
