<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create(['nombre' => 'Juan Mellado', 
                      'run' => '18.685.728-3' ,
                      'email' => 'j.melladojimenez@hotmail.com', 
                      'password' => bcrypt('123456'), 
                      'tipo_usuario' => 1]);

        User::create(['nombre' => 'Enrique Rebolledo', 
                        'run' => '15.616.452-6' ,
                        'email' => 'prevencionlebenco@gmail.com', 
                        'password' => bcrypt('123456'), 
                        'tipo_usuario' => 1]);
    }
}
