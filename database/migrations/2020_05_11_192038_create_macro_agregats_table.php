<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMacroAgregatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $BD = array('bic_bd_test', 'bic_beninbd', 'bic_bissaubd', 'bic_burkinabd', 'bic_coteivoirbd',
            'bic_malibd', 'bic_nigerbd', 'bic_senegalbd', 'bic_togobd');

        for ($i = 0; $i < count($BD); $i++) {
            Schema::connection($BD[$i])->create('macro_agregats', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('codeMacro');
                $table->unsignedBigInteger('idSousecteur');
                $table->string('macro');
                $table->text('unite_mesure');
                $table->text('magnitude');
                $table->timestamps();

                $table->foreign('idSousecteur')->references('id')->on('soussecteur_macros')->onDelete('cascade');
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
        $BD = array('bic_bd_test', 'bic_beninbd', 'bic_bissaubd', 'bic_burkinabd', 'bic_coteivoirbd', 'bic_malibd',
            'bic_nigerbd', 'bic_senegalbd', 'bic_togobd');

        for ($i = 0; $i < count($BD); $i++) {
            Schema::connection($BD[$i])->dropIfExists('macro_agregats');
        }
    }
}
