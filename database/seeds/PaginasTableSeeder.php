<?php

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
             'contenido' => '<h1 style="text-align:right">Prevenci&oacute;n LebenCo.</h1><p style="text-align:right"><em>&iexcl;m&aacute;s que una biblioteca digital!</em></p><h2 style="text-align:justify">Nuestra misi&oacute;n</h2><p>&nbsp;&nbsp;&nbsp;&nbsp; Reencantar a las personas con el verdadero prop&oacute;sito de la Prevenci&oacute;n de Riesgos Laboral.</p><p style="text-align:justify">&nbsp;</p><h2 style="text-align:justify">Nuestra visi&oacute;n</h2><p style="text-align:justify">&nbsp;&nbsp;&nbsp;&nbsp; Desarrollar una comunidad colaborativa y ocupada de la Prevenci&oacute;n de Riesgos Laboral en Chile.</p><p style="text-align:justify">&nbsp;</p><h2 style="text-align:justify">&iquest;Por qu&eacute; confiar en nosotros?</h2><p style="text-align:justify">&nbsp;&nbsp;&nbsp;&nbsp; Porque nos ocupamos diariamente en identificar las confusiones e incertidumbres que en general las personas tienen respecto a este importante rubro. Por esto, decidimos hacernos presentes y crear una plataforma de comunicaci&oacute;n pensada en facilitar la implementaci&oacute;n de la Prevenci&oacute;n de Riesgos Laborales junto a ti, en tu trabajo y/o empresa.</p><p style="text-align:justify">&iexcl;Vamos!, participe en este desarrollo colectivo pensado para que su Seguridad Laboral, sea parte de todos.</p><p style="text-align:justify">&nbsp;</p><h2 style="text-align:justify">Historia</h2><p style="text-align:justify">&nbsp;&nbsp;&nbsp;&nbsp; Prevenci&oacute;n LebenCo. Nace en 2017 producto de la colaboraci&oacute;n de personas an&oacute;nimas y de las propias experiencias obtenidas del equipo LebenCo. en esta materia. En 2018 se logra sumar a personas y empresas de distintos rubros que aportan valiosos datos e informaci&oacute;n esencial para desarrollar estrategias y contenido de apoyo a la gesti&oacute;n de la Prevenci&oacute;n de Riesgos Laborales.</p><p style="text-align:justify">A principios de 2019 y producto de la colaboraci&oacute;n de m&uacute;ltiples esfuerzos, se concluye el desarrollo de la plataforma web, logrando presentar el primer sitio colaborativo del rubro llamado &ldquo;prevenci&oacute;nlebenco.cl&rdquo;, el cual queremos mejorar y desarrollar junto a ti. &nbsp;</p><p style="text-align:justify">&nbsp;</p><p style="text-align:right">&hellip;Gracias por confiar en nosotros.</p>']
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
    }
}
