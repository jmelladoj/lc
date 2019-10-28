<?php
/**
 * @see https://github.com/artesaos/seotools
 */

return [
    'meta' => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults'       => [
            'title'        => "Prevención LebenCo. - Juntos por la seguridad de tu trabajo", // set false to total remove
            'titleBefore'  => false, // Put defaults.title before page title, like 'It's Over 9000! - Dashboard'
            'description'  => 'Estudio de estrategias para el crecimiento autónomo de Emprendimientos, Pymes y Empresas, fomentando la Prevención de Riesgos Laborales y Salud Ocupacional.', // set false to total remove
            'separator'    => ' - ',
            'keywords'     => ['derecho a saber',
                                'reglamento especial para subcontratista',
                                'investigación de accidente e incidente',
                                'protocolo',
                                'documentos de prevención',
                                'minsal',
                                'procedimiento',
                                'condición sanitaria',
                                'músculo esquelético',
                                'reglamento interno',
                                'ingreso de personal',
                                'silicosis',
                                'charla',
                                'capacitación',
                                'sistema de gestión',
                                'matriz de riesgos',
                                'fiscalización',
                                'plan de emergencia',
                                'enfermedad profesional',
                                'obligación subsidiaria',
                                'zona de seguridad',
                                'programa de prevención',
                                'tipo de multa',
                                'vía de evacuación',
                                'inducción',
                                'accidente grave',
                                'comité paritario',
                                'tipos de riesgos',
                                'accidente laboral',
                                'radiación UV',
                                'cronograma de actividades',
                                'accidente de trayecto',
                                'DS 594',
                                'instructivo',
                                'comunidad pyme',
                                'Ley 16744',
                                'ficha de seguridad',
                                'hecho por pymes',
                                'DS 49',
                                'análisis seguro de trabajo',
                                'documento a pedido',
                                'DS 54',
                                'manejo manual de cargas',
                                'tipificador',
                                'asesor en prevención',
                                'amonestación'],
            'canonical'    => null, // Set null for using Url::current(), set false to total remove
            'robots'       => true, // Set to 'all', 'none' or any combination of index/noindex and follow/nofollow
        ],
        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google'    => null,
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null,
        ],

        'add_notranslate_class' => false,
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title'       => 'Prevención LebenCo. - Juntos por la seguridad de tu trabajo', // set false to total remove
            'description' => 'Estudio de estrategias para el crecimiento autónomo de Emprendimientos, Pymes y Empresas, fomentando la Prevención de Riesgos Laborales y Salud Ocupacional.', // set false to total remove
            'url'         => false, // Set null for using Url::current(), set false to total remove
            'type'        => false,
            'site_name'   => false,
            'images'      => [],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
            //'card'        => 'summary',
            //'site'        => '@LuizVinicius73',
        ],
    ],
    'json-ld' => [
        /*
         * The default configurations to be used by the json-ld generator.
         */
        'defaults' => [
            'title'       => 'Prevención LebenCo. - Juntos por la seguridad de tu trabajo', // set false to total remove
            'description' => 'Estudio de estrategias para el crecimiento autónomo de Emprendimientos, Pymes y Empresas, fomentando la Prevención de Riesgos Laborales y Salud Ocupacional.', // set false to total remove
            'url'         => false, // Set null for using Url::current(), set false to total remove
            'type'        => 'WebPage',
            'images'      => [],
        ],
    ],
];
