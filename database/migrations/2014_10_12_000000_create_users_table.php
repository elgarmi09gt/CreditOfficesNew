<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         $BD = ['bic_bd_test','bic_beninbd','bic_bissaubd','bic_burkinabd','bic_coteivoirbd','bic_malibd','bic_nigerbd','bic_senegalbd','bic_togobd','bic_uemoa','bic_bd_umoa_test'];
   
        for ($i=0; $i < count($BD); $i++) { 
            # code...
            Schema::connection($BD[$i])->create('users', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();
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
        // Nom de toutes les bases de données configuré si 
        // la structure ne change pas que seul les données changent
         $BD = array('bic_bd_test', 'bic_beninbd', 'bic_bissaubd', 'bic_burkinabd', 'bic_coteivoirbd', 'bic_malibd', 'bic_nigerbd', 'bic_senegalbd', 'bic_togobd', 'bic_uemoa','bic_bd_umoa_test');

        for ($i=0; $i < count($BD); $i++) {
            Schema::connection($BD[$i])->dropIfExists('users');
        }
    }
}
