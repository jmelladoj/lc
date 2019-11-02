<?php

use App\Rubro;
use Illuminate\Database\Seeder;

class RubrosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Rubro::create([ 'nombre' => 'Agentes biológicos']);
        Rubro::create([ 'nombre' => 'Áridos']);
        Rubro::create([ 'nombre' => 'Aserradero']);
        Rubro::create([ 'nombre' => 'Carga por carretera']);
        Rubro::create([ 'nombre' => 'Casas prefabricadas']);
        Rubro::create([ 'nombre' => 'Cemento']);
        Rubro::create([ 'nombre' => 'Chatarra']);
        Rubro::create([ 'nombre' => 'Climatización']);
        Rubro::create([ 'nombre' => 'Combustible']);
        Rubro::create([ 'nombre' => 'Comercializadoras']);

        Rubro::create([ 'nombre' => 'Condominios']);
        Rubro::create([ 'nombre' => 'Control de incendios']);
        Rubro::create([ 'nombre' => 'Control de plagas']);
        Rubro::create([ 'nombre' => 'Demolición y obras civiles']);
        Rubro::create([ 'nombre' => 'Desabolladoras']);
        Rubro::create([ 'nombre' => 'Embotelladora']);
        Rubro::create([ 'nombre' => 'Enfierradura']);
        Rubro::create([ 'nombre' => 'Establecimientos de salud']);
        Rubro::create([ 'nombre' => 'Establecimientos educacionales']);
        Rubro::create([ 'nombre' => 'Extractiva']);

        Rubro::create([ 'nombre' => 'Estructura metálica']);
        Rubro::create([ 'nombre' => 'Fábrica  de estructuras metálicas']);
        Rubro::create([ 'nombre' => 'Fábrica de hormigón vibrado y ladrillos']);
        Rubro::create([ 'nombre' => 'Fábrica de mármol y cerámicos']);
        Rubro::create([ 'nombre' => 'Fábrica de muebles']);
        Rubro::create([ 'nombre' => 'Fábrica de vidrios']);
        Rubro::create([ 'nombre' => 'Forestal']);
        Rubro::create([ 'nombre' => 'Hormigones']);
        Rubro::create([ 'nombre' => 'Imprentas']);
        Rubro::create([ 'nombre' => 'Instalación eléctrica']);

        Rubro::create([ 'nombre' => 'Instalación gas']);
        Rubro::create([ 'nombre' => 'Instalación sanitaria']);
        Rubro::create([ 'nombre' => 'Instalaciones contra incendios']);
        Rubro::create([ 'nombre' => 'Jardinería y entorno']);
        Rubro::create([ 'nombre' => 'Maestranza']);
        Rubro::create([ 'nombre' => 'Maquinaria']);
        Rubro::create([ 'nombre' => 'Moldaje']);
        Rubro::create([ 'nombre' => 'Montaje']);
        Rubro::create([ 'nombre' => 'Movimiento de tierras']);
        Rubro::create([ 'nombre' => 'Mudanza']);

        Rubro::create([ 'nombre' => 'Obras viales']);
        Rubro::create([ 'nombre' => 'Otras fabricaciones']);
        Rubro::create([ 'nombre' => 'Pesquera']);
        Rubro::create([ 'nombre' => 'Pinturas']);
        Rubro::create([ 'nombre' => 'Químicos y residuos']);
        Rubro::create([ 'nombre' => 'Seguridad privada']);
        Rubro::create([ 'nombre' => 'Suministro de personal']);
        Rubro::create([ 'nombre' => 'Tabiquería']);
        Rubro::create([ 'nombre' => 'Taller mecánico']);
        Rubro::create([ 'nombre' => 'Textil']);

        Rubro::create([ 'nombre' => 'Vehículos menores']);
        Rubro::create([ 'nombre' => 'Vertederos']);
    }
}
