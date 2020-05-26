<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropIdpaysFromLignemacroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            $BD = array('bic_bd_umoa_test');

            for ($i = 0; $i < count($BD); $i++) {
                Schema::connection($BD[$i])->table('lignemacros', function (Blueprint $table) {
                    $table->dropForeign('lignemacros_idpays_foreign');
                    $table->dropColumn('idPays');
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
        $BD = array('bic_bd_umoa_test');

        for ($i = 0; $i < count($BD); $i++) {
            Schema::connection($BD[$i])->table('lignemacros', function (Blueprint $table) {
                $table->unsignedBigInteger('idPays')->after('idMacro');
                $table->dropPrimary(['lignemacros_idMacro_primary','lignemacros_exercice_primary']);
                $table->primary(['idMacro', 'idPays', 'exercice']);
                $table->foreign('idPays')->references('id')->on('pays')->onDelete('cascade');
            });
        }
    }
}
