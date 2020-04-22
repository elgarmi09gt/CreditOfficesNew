<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LigneservicesUemoa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $BD = array('bic_uemoa','bic_bd_umoa_test');
   
        for ($i=0; $i < count($BD); $i++) {
            Schema::connection($BD[$i])->create('ligneservices', function (Blueprint $table) {
                $table->unsignedBigInteger('idE');
                $table->unsignedBigInteger('idPays');
                $table->unsignedBigInteger('idService');
                $table->unsignedBigInteger('idSousect');
                $table->string('type');
                $table->timestamps();
                
                $table->primary(['idService','idSousect','idE','idPays']);
                $table->foreign('idService')->references('id')->on('services')->onDelete('cascade');
                $table->foreign('idSousect')->references('id')->on('soussecteurs')->onDelete('cascade');
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
            Schema::connection($BD[$i])->dropIfExists('ligneservices');
        }

    }
}
