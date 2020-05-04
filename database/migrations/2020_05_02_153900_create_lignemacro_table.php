<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLignemacroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $BD = array('bic_bd_test', 'bic_beninbd', 'bic_bissaubd', 'bic_burkinabd', 'bic_coteivoirbd', 'bic_malibd',
            'bic_nigerbd', 'bic_senegalbd', 'bic_togobd');

        for ($i = 0; $i < count($BD); $i++) {
            Schema::connection($BD[$i])->create('lignemacro', function (Blueprint $table) {
                $table->unsignedBigInteger('idMacro');
                $table->year('exercice');
                $table->decimal('brute', 15, 3);
                $table->timestamps();
                $table->primary(['idMacro', 'exercice']);
                $table->foreign('idMacro')->references('id')->on('macro_agregat')->onDelete('cascade');
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
            Schema::connection($BD[$i])->dropIfExists('lignemacro');
        }
    }
}
