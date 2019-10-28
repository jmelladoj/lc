<?php

use App\CategoriaDocumento;
use Illuminate\Database\Seeder;

class CategoriasDocumentosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        CategoriaDocumento::create(['nombre' => 'Protocolos']);
        CategoriaDocumento::create(['nombre' => 'Procedimientos de trabajo (PTS)']);
        CategoriaDocumento::create(['nombre' => 'Matrices de riesgo']);
        CategoriaDocumento::create(['nombre' => 'Registros']);
        CategoriaDocumento::create(['nombre' => 'Reglamentos internos']);
        CategoriaDocumento::create(['nombre' => 'Fichas de seguridad']);
        CategoriaDocumento::create(['nombre' => 'Listas de chequeo']);
        CategoriaDocumento::create(['nombre' => 'Material de apoyo']);
        CategoriaDocumento::create(['nombre' => 'Comité Paritario']);
        CategoriaDocumento::create(['nombre' => 'Instructivos']);
        CategoriaDocumento::create(['nombre' => 'Planes de emergencias']);
        CategoriaDocumento::create(['nombre' => 'Otros']);
    }
}
