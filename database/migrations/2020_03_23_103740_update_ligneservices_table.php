<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLigneservicesTable extends Migration
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
            Schema::connection($BD[$i])->table('ligneservices', function (Blueprint $table) {
                $table->dropForeign('ligneservices_idservice_foreign');
                $table->renameColumn('idService','idSouservice');
                $table->foreign('idSouservice')->references('id')->on('sousservices')->onDelete('cascade');
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
            Schema::connection($BD[$i])->table('ligneservices', function (Blueprint $table) {
                $table->dropForeign('ligneservices_idSouservice_foreign');
                $table->renameColumn('idSouservice','idService');
                $table->foreign('idService')->references('id')->on('services')->onDelete('cascade');
            });
        }
    }
}
