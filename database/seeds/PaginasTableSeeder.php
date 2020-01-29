<?php

use App\General;
use App\Pagina;
use Illuminate\Database\Seeder;

class PaginasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Pagina::create(
            ['id' => 1,
            'nombre' => 'Nosotros',
             'contenido' => '<h4 style="text-align: center;">&iexcl;Nuestro lanzamiento oficial se acerca!</h4>
             <p style="text-align: center;">Estamos cada vez m&aacute;s cerca y mientras esto sucede les agradecemos a todos los Contratistas y Sub-contratistas por sumarse a este exitoso servicio:</p>
             <p style="text-align: center;"><strong>Habilitaci&oacute;n de la Pyme con los Documentos Personalizados,</strong></p>
             <p style="text-align: center;"><strong>para el Ingreso a la Empresa Principal y Cursar el Estado de Pago.</strong></p>
             <p style="text-align: center;">S&iacute;guenos enviando un correo a <a href="mailto:prevencionista@prevencionlebenco.cl">prevencionista@prevencionlebenco.cl</a></p>
             <p style="text-align: center;">con tu nombre y N&deg; telef&oacute;nico para contactarnos contigo.</p>
             <p style="text-align: right;">&nbsp;</p>']
        );

        Pagina::create(
            ['id' => 2,
             'nombre' => 'Comunidad Pyme']
        );

        Pagina::create(
            ['id' => 3,
             'nombre' => 'Servicios']
        );

        Pagina::create(
            ['id' => 4,
             'nombre' => 'Login']
        );

        Pagina::create(
            ['id' => 5,
             'nombre' => 'Home usuario intranet']
        );

        General::create([
            'id' => 1
        ]);
    }
}
