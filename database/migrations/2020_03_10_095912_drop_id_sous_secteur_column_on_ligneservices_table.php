<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropIdSousSecteurColumnOnLigneservicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $BD = array('bic_bd_test','bic_beninbd', 'bic_burkinabd', 'bic_coteivoirbd', 'bic_bissaubd', 'bic_malibd', 'bic_nigerbd', 'bic_senegalbd', 'bic_togobd');

        for ($i = 0; $i < count($BD); $i++) {
            Schema::connection($BD[$i])->table('ligneservices', function (Blueprint $table) {
                $table->dropForeign('ligneservices_idsousecteur_foreign');
                $table->dropColumn('idSousecteur');
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
        $BD = array('bic_bd_test','bic_beninbd', 'bic_burkinabd', 'bic_coteivoirbd', 'bic_bissaubd', 'bic_malibd', 'bic_nigerbd', 'bic_senegalbd', 'bic_togobd');

        for ($i = 0; $i < count($BD); $i++) {
            Schema::connection($BD[$i])->table('ligneservices', function (Blueprint $table) {
                $table->unsignedBigInteger('idSousecteur')->after('idService');
                $table->foreign('idSousecteur')->references('id')->on('soussecteurs')->onDelete('cascade');
            });
        }

    }
}
