<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMacroAgregatsUemoaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $BD = array('bic_uemoa','bic_bd_umoa_test');

        for ($i = 0; $i < count($BD); $i++) {
            Schema::connection($BD[$i])->create('macro_agregats', function (Blueprint $table) {
                $table->unsignedBigInteger('id');
                $table->string('codeMacro');
                $table->unsignedBigInteger('idSousecteur');
                $table->unsignedBigInteger('idPays');
                $table->string('macro');
                $table->text('unite_mesure');
                $table->text('magnitude');
                $table->timestamps();
                $table->primary(['id','idPays']);

                $table->foreign('idSousecteur')->references('id')->on('soussecteur_macros')->onDelete('cascade');
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
        $BD = array('bic_uemoa','bic_bd_umoa_test');

        for ($i = 0; $i < count($BD); $i++) {
            Schema::connection($BD[$i])->dropIfExists('macro_agregats');
        }
    }
}
