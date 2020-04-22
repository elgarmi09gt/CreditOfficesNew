<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AgencesUemoa extends Migration
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
            Schema::connection($BD[$i])->create('agences', function (Blueprint $table) {
                $table->unsignedBigInteger('id');
                $table->string('agence');
                $table->string('adresse');
                $table->string('codeRegion');
                $table->string('region');
                $table->unsignedBigInteger('idE');
                $table->unsignedBigInteger('idPays');
                $table->timestamps();
                $table->primary(['id','codeRegion','idE','idPays']);
                $table->foreign('idE')->references('id')->on('entreprises')->onDelete('cascade');
                $table->foreign('idPays')->references('idPays')->on('entreprises')->onDelete('cascade');
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
            Schema::connection($BD[$i])->dropIfExists('agences');
        }

    }
}
