<?php

use Illuminate\Database\Seeder;
use App\Models\Classe;

class ClassesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
        * @return void
        */
    public function run()
    {
        factory(Classe::class, 200)->create();
    }
}
