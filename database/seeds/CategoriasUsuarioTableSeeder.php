<?php

use App\CategoriaUsuario;
use Illuminate\Database\Seeder;

class CategoriasUsuarioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        CategoriaUsuario::create(['nombre' => 'Nuevo', 'nivel' => 'nivel 1', 'gasto_inicio' => 0, 'gasto_fin' => 5000, 'color' => '#e8ecd1']);
        CategoriaUsuario::create(['nombre' => 'Principiante', 'nivel' => 'nivel 2', 'gasto_inicio' => 5001, 'gasto_fin' => 11250, 'color' => '#8ab733']);
        CategoriaUsuario::create(['nombre' => 'Amateur', 'nivel' => 'nivel 3', 'gasto_inicio' => 11251, 'gasto_fin' => 18750, 'color' => '#3f8a24', 'bonificacion' => 500]);
        CategoriaUsuario::create(['nombre' => 'Amateur', 'nivel' => 'nivel 4', 'gasto_inicio' => 18751, 'gasto_fin' => 27500, 'color' => '#3f8a24']);
        CategoriaUsuario::create(['nombre' => 'Adelantado', 'nivel' => 'nivel 5', 'gasto_inicio' => 27501, 'gasto_fin' => 37500, 'color' => '#e8ecd1', 'bonificacion' => 1000]);
        CategoriaUsuario::create(['nombre' => 'Adelantado', 'nivel' => 'nivel 6', 'gasto_inicio' => 37501, 'gasto_fin' => 48750, 'color' => '#e8ecd1']);
        CategoriaUsuario::create(['nombre' => 'Adelantado', 'nivel' => 'nivel 7', 'gasto_inicio' => 48751, 'gasto_fin' => 61250, 'color' => '#e8ecd1']);
        CategoriaUsuario::create(['nombre' => 'Calificado', 'nivel' => 'nivel 8', 'gasto_inicio' => 61251, 'gasto_fin' => 75000, 'color' => '#8ab733', 'bonificacion' => 1500]);
        CategoriaUsuario::create(['nombre' => 'Calificado', 'nivel' => 'nivel 9', 'gasto_inicio' => 75001, 'gasto_fin' => 90000, 'color' => '#8ab733']);
        CategoriaUsuario::create(['nombre' => 'Calificado', 'nivel' => 'nivel 10', 'gasto_inicio' => 90001, 'gasto_fin' => 106250, 'color' => '#8ab733']);
        CategoriaUsuario::create(['nombre' => 'Calificado', 'nivel' => 'nivel 11', 'gasto_inicio' => 106251, 'gasto_fin' => 123750, 'color' => '#8ab733']);
        CategoriaUsuario::create(['nombre' => 'Experimentado', 'nivel' => 'nivel 12', 'gasto_inicio' => 123751, 'gasto_fin' => 142500, 'color' => '#3f8a24', 'bonificacion' => 2000]);
        CategoriaUsuario::create(['nombre' => 'Experimentado', 'nivel' => 'nivel 13', 'gasto_inicio' => 142501, 'gasto_fin' => 162500, 'color' => '#3f8a24']);
        CategoriaUsuario::create(['nombre' => 'Experimentado', 'nivel' => 'nivel 14', 'gasto_inicio' => 162501, 'gasto_fin' => 183750, 'color' => '#3f8a24']);
        CategoriaUsuario::create(['nombre' => 'Experimentado', 'nivel' => 'nivel 15', 'gasto_inicio' => 183751, 'gasto_fin' => 206250, 'color' => '#3f8a24']);
        CategoriaUsuario::create(['nombre' => 'Experimentado', 'nivel' => 'nivel 16', 'gasto_inicio' => 206251, 'gasto_fin' => 230000, 'color' => '#3f8a24']);
        CategoriaUsuario::create(['nombre' => 'Avanzado', 'nivel' => 'nivel 17', 'gasto_inicio' => 230001, 'gasto_fin' => 255000, 'color' => '#e8ecd1', 'bonificacion' => 2500]);
        CategoriaUsuario::create(['nombre' => 'Avanzado', 'nivel' => 'nivel 18', 'gasto_inicio' => 255001, 'gasto_fin' => 281250, 'color' => '#e8ecd1']);
        CategoriaUsuario::create(['nombre' => 'Avanzado', 'nivel' => 'nivel 19', 'gasto_inicio' => 281251, 'gasto_fin' => 308750, 'color' => '#e8ecd1']);
        CategoriaUsuario::create(['nombre' => 'Avanzado', 'nivel' => 'nivel 20', 'gasto_inicio' => 308751, 'gasto_fin' => 337500, 'color' => '#e8ecd1']);
        CategoriaUsuario::create(['nombre' => 'Avanzado', 'nivel' => 'nivel 21', 'gasto_inicio' => 337501, 'gasto_fin' => 367500, 'color' => '#e8ecd1']);
        CategoriaUsuario::create(['nombre' => 'Avanzado', 'nivel' => 'nivel 22', 'gasto_inicio' => 367501, 'gasto_fin' => 398750, 'color' => '#e8ecd1']);
        CategoriaUsuario::create(['nombre' => 'Especialista', 'nivel' => 'nivel 23', 'gasto_inicio' => 398751, 'gasto_fin' => 431250, 'color' => '#8ab733', 'bonificacion' => 3000]);
        CategoriaUsuario::create(['nombre' => 'Especialista', 'nivel' => 'nivel 24', 'gasto_inicio' => 431251, 'gasto_fin' => 465000, 'color' => '#8ab733']);
        CategoriaUsuario::create(['nombre' => 'Especialista', 'nivel' => 'nivel 25', 'gasto_inicio' => 465001, 'gasto_fin' => 500000, 'color' => '#8ab733']);
        CategoriaUsuario::create(['nombre' => 'Especialista', 'nivel' => 'nivel 26', 'gasto_inicio' => 500001, 'gasto_fin' => 536250, 'color' => '#8ab733']);
        CategoriaUsuario::create(['nombre' => 'Especialista', 'nivel' => 'nivel 27', 'gasto_inicio' => 536251, 'gasto_fin' => 573750, 'color' => '#8ab733']);
        CategoriaUsuario::create(['nombre' => 'Especialista', 'nivel' => 'nivel 28', 'gasto_inicio' => 573751, 'gasto_fin' => 612500, 'color' => '#8ab733']);
        CategoriaUsuario::create(['nombre' => 'Especialista', 'nivel' => 'nivel 29', 'gasto_inicio' => 612501, 'gasto_fin' => 652500, 'color' => '#8ab733']);
        CategoriaUsuario::create(['nombre' => 'Experto', 'nivel' => 'nivel 30', 'gasto_inicio' => 652501, 'gasto_fin' => 693750, 'color' => '#3f8a24', 'bonificacion' => 3500]);
        CategoriaUsuario::create(['nombre' => 'Experto', 'nivel' => 'nivel 31', 'gasto_inicio' => 693751, 'gasto_fin' => 736250, 'color' => '#3f8a24']);
        CategoriaUsuario::create(['nombre' => 'Experto', 'nivel' => 'nivel 32', 'gasto_inicio' => 736251, 'gasto_fin' => 780000, 'color' => '#3f8a24']);
        CategoriaUsuario::create(['nombre' => 'Experto', 'nivel' => 'nivel 33', 'gasto_inicio' => 780001, 'gasto_fin' => 825000, 'color' => '#3f8a24']);
        CategoriaUsuario::create(['nombre' => 'Experto', 'nivel' => 'nivel 34', 'gasto_inicio' => 825001, 'gasto_fin' => 871250, 'color' => '#3f8a24']);
        CategoriaUsuario::create(['nombre' => 'Experto', 'nivel' => 'nivel 35', 'gasto_inicio' => 871251, 'gasto_fin' => 918750, 'color' => '#3f8a24']);
        CategoriaUsuario::create(['nombre' => 'Experto', 'nivel' => 'nivel 36', 'gasto_inicio' => 918751, 'gasto_fin' => 967500, 'color' => '#3f8a24']);
        CategoriaUsuario::create(['nombre' => 'Experto', 'nivel' => 'nivel 37', 'gasto_inicio' => 967501, 'gasto_fin' => 1017500, 'color' => '#3f8a24']);
        CategoriaUsuario::create(['nombre' => 'Experto pro', 'nivel' => 'nivel 38', 'gasto_inicio' => 1017501, 'gasto_fin' => 1068750, 'color' => '#d4af37', 'bonificacion' => 4000]);
        CategoriaUsuario::create(['nombre' => 'Experto pro', 'nivel' => 'nivel 39', 'gasto_inicio' => 1068751, 'gasto_fin' => 1121250, 'color' => '#d4af37']);
        CategoriaUsuario::create(['nombre' => 'Experto pro', 'nivel' => 'nivel 40', 'gasto_inicio' => 1121251, 'gasto_fin' => 1175000, 'color' => '#d4af37']);
        CategoriaUsuario::create(['nombre' => 'Experto pro', 'nivel' => 'nivel 41', 'gasto_inicio' => 1175001, 'gasto_fin' => 1230000, 'color' => '#d4af37']);
        CategoriaUsuario::create(['nombre' => 'Experto pro', 'nivel' => 'nivel 42', 'gasto_inicio' => 1230001, 'gasto_fin' => 1286250, 'color' => '#d4af37']);
        CategoriaUsuario::create(['nombre' => 'Experto pro', 'nivel' => 'nivel 43', 'gasto_inicio' => 1286251, 'gasto_fin' => 1343750, 'color' => '#d4af37']);
        CategoriaUsuario::create(['nombre' => 'Experto pro', 'nivel' => 'nivel 44', 'gasto_inicio' => 1343751, 'gasto_fin' => 1402500, 'color' => '#d4af37']);
        CategoriaUsuario::create(['nombre' => 'Experto pro', 'nivel' => 'nivel 45', 'gasto_inicio' => 1402501, 'gasto_fin' => 1462500, 'color' => '#d4af37']);
        CategoriaUsuario::create(['nombre' => 'Experto pro', 'nivel' => 'nivel 46', 'gasto_inicio' => 1462501, 'gasto_fin' => 1523750, 'color' => '#d4af37']);
        CategoriaUsuario::create(['nombre' => 'Experto pro', 'nivel' => 'nivel 47', 'gasto_inicio' => 1523751, 'gasto_fin' => 1586250, 'color' => '#d4af37']);
        CategoriaUsuario::create(['nombre' => 'Experto pro', 'nivel' => 'nivel 48', 'gasto_inicio' => 1586251, 'gasto_fin' => 1650000, 'color' => '#d4af37']);
        CategoriaUsuario::create(['nombre' => 'Experto pro', 'nivel' => 'nivel 49', 'gasto_inicio' => 1650001, 'gasto_fin' => 1715000, 'color' => '#d4af37']);
        CategoriaUsuario::create(['nombre' => 'Súper Experto pro', 'nivel' => 'nivel 50', 'gasto_inicio' => 1715001, 'gasto_fin' => 999999999, 'color' => '#d4af37']);
    }
}
