<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropIdSousSecteurColumnOnLigneservicesUemoaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $BD = array('bic_bd_umoa_test', 'bic_uemoa');

        for ($i = 0; $i < count($BD); $i++) {
            Schema::connection($BD[$i])->table('ligneservices', function (Blueprint $table) {
                $table->dropForeign('ligneservices_idSousect_foreign');
                $table->dropColumn('idSousect');
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
        $BD = array('bic_bd_umoa_test', 'bic_uemoa');

        for ($i = 0; $i < count($BD); $i++) {
            Schema::connection($BD[$i])->table('ligneservices', function (Blueprint $table) {
                $table->unsignedBigInteger('idSousect')->after('idService');
                $table->foreign('idSousect')->references('id')->on('soussecteurs')->onDelete('cascade');
            });
        }
    }
}
