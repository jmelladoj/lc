<?php

use App\Profesion;
use Illuminate\Database\Seeder;

class ProfesionesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Estudiante
        Profesion::create([ 'nombre' => 'Técnico en Prevención', 'tipo_persona' => 3]);
        Profesion::create([ 'nombre' => 'Ingeniero en Prevención', 'tipo_persona' => 3]);

        //Persona
        Profesion::create([ 'nombre' => 'Técnico en Prevención', 'tipo_persona' => 1]);
        Profesion::create([ 'nombre' => 'Ingeniero en Prevención', 'tipo_persona' => 1]);
        Profesion::create([ 'nombre' => 'Responsable Asignado', 'tipo_persona' => 1]);

        //Pyme
        Profesion::create([ 'nombre' => 'Contratista', 'tipo_persona' => 2]);
        Profesion::create([ 'nombre' => 'Constructora', 'tipo_persona' => 2]);
        Profesion::create([ 'nombre' => 'Control y mitigación', 'tipo_persona' => 2]);
        Profesion::create([ 'nombre' => 'Distribuidor', 'tipo_persona' => 2]);
        Profesion::create([ 'nombre' => 'Fábricas', 'tipo_persona' => 2]);
        Profesion::create([ 'nombre' => 'Industrial', 'tipo_persona' => 2]);
        Profesion::create([ 'nombre' => 'Maderero', 'tipo_persona' => 2]);
        Profesion::create([ 'nombre' => 'Maestranza', 'tipo_persona' => 2]);
        Profesion::create([ 'nombre' => 'Reciclaje', 'tipo_persona' => 2]);
        Profesion::create([ 'nombre' => 'Transporte', 'tipo_persona' => 2]);
    }
}
