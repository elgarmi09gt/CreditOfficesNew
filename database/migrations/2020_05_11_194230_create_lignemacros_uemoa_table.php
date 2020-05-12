<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLignemacrosUemoaTable extends Migration
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
            Schema::connection($BD[$i])->create('lignemacros', function (Blueprint $table) {
                $table->unsignedBigInteger('idMacro');
                $table->unsignedBigInteger('idPays');
                $table->year('exercice');
                $table->decimal('brute', 15, 3);
                $table->timestamps();
                $table->primary(['idMacro', 'idPays', 'exercice']);
                $table->foreign('idMacro')->references('id')->on('macro_agregats')->onDelete('cascade');
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
            Schema::connection($BD[$i])->dropIfExists('lignemacros');
        }
    }
}
