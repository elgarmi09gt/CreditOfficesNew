<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $BD = array('bic_bd_test', 'bic_beninbd', 'bic_bissaubd', 'bic_burkinabd', 'bic_coteivoirbd', 'bic_malibd','bic_nigerbd', 'bic_senegalbd', 'bic_togobd', 'bic_uemoa','bic_bd_umoa_test');
   
        for ($i=0; $i < count($BD); $i++) {
            Schema::connection($BD[$i])->create('classes', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('codeClasse');
                $table->text('classe');
                $table->string('nature');
                $table->string('systemeClasse');
                $table->enum('typeClasse',['old','new'])->default('new');
                $table->bigInteger('idSupclasse')->unsigned()->index();
                $table->timestamps();
                $table->foreign('idSupclasse')->references('id')->on('supclasses')->onDelete('cascade');
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
        $BD = array('bic_bd_test', 'bic_beninbd', 'bic_bissaubd', 'bic_burkinabd', 'bic_coteivoirbd', 'bic_malibd', 'bic_nigerbd', 'bic_senegalbd', 'bic_togobd', 'bic_uemoa','bic_bd_umoa_test');
   
        for ($i=0; $i < count($BD); $i++) {
            Schema::connection($BD[$i])->dropIfExists('classes');
        }
    }
}
