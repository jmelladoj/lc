<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CategoriasUsuarioTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CategoriasDocumentosTableSeeder::class);
        $this->call(PaginasTableSeeder::class);
        $this->call(ProfesionesTableSeeder::class);
        $this->call(RubrosTableSeeder::class);
    }
}
