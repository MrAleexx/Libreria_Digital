<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        // Insertar el libro ejemplo del Manual del Docente Innovador
        $bookId = DB::table('books')->insertGetId([
            'title' => 'Manual del Docente Innovador aplicando IA Generativa',
            'publisher' => 'Pedro Alex Taya Yactayo',
            'publisher_address' => 'test',
            'publisher_email' => 'tes@test.com',
            'publisher_city' => 'Perú',
            'isbn' => '9786120313879',
            'isbn13' => '978-612',
            'deposito_legal' => '2025-09348',
            'language' => 'es',
            'pages' => 112,
            'file_size' => NULL,
            'file_format' => 'PDF',
            'publication' => '2025-09-30',
            'publication_url' => 'https://a.co/d/6PzR4rD',
            'edition' => '1er',
            'price' => 10.00,
            'is_free' => false,
            'image' => 'https://isbn.bnp.gob.pe/files/titulos/160765.jpg',
            'pdf_file' => 'books/pdfs/prE3o0Es4eSL2YhBsIS5snTk9e3PvLiLL8es3e90.pdf',
            'description' => 'La educación es un viaje que nunca se detiene. Cada día, en cada aula, los docentes tienen en sus manos la oportunidad de sembrar curiosidad, encender la imaginación y acompañar a sus estudiantes en la construcción de sus sueños. Sin embargo, también sabemos que enseñar no siempre es fácil: requiere creatividad, tiempo, recursos y, sobre todo, mucha pasión.
Este libro nace justamente de esa necesidad de apoyar al maestro en su tarea diaria. Aquí encontrarás un banco de 1,440 prompts maestros para EBR/EBA, diseñados como pequeñas llaves que abren puertas a nuevas formas de planificar, enseñar y evaluar. Cada prompt es una invitación a mirar la clase con otros ojos, a experimentar estrategias distintas y a descubrir cómo la inteligencia artificial puede ser un aliado creativo y cercano.
Lo que tienes entre tus manos no es un manual frío, sino un compañero de camino. Está pensado para acompañarte mientras preparas una unidad, diseñas una sesión, elaboras una rúbrica o buscas ideas frescas para motivar a tus estudiantes. La IA Generativa aquí no sustituye tu voz ni tu experiencia; al contrario, las potencia y las multiplica, claro si permites que la IA ingrese en tu día a día.
Este libro une dos mundos: la sensibilidad pedagógica de quienes llevan décadas dedicados a la educación y la fuerza de la tecnología actual. En esa unión florece una propuesta innovadora, práctica y profundamente humana.
Este libro reúne prompts maestros para Educación Básica Regular (EBR) y Educación Básica Alternativa (EBA) en Perú, alineados al Currículo Nacional de la Educación Básica (RM N.° 281-2016-ED), al Programa Curricular de EBA Ciclos Inicial–Intermedio (2019) y al Programa Curricular de EBA Ciclo Avanzado (2019). Su objetivo es apoyar al docente en el diseño de unidades, sesiones, evaluaciones, estrategias, rúbricas y diversas actividades contextualizadas a las necesidades de niños, jóvenes y adultos.
Que cada página te recuerde que enseñar es transformar y que cada transformación comienza con un pequeño impulso de inspiración.',
            'reading_age' => 'De 14 a 18 años',
            'is_new' => 1,
            'active' => 1,
            'downloadable' => 1,
            'pre_order' => 0,
            'published_at' => '2025-10-01 23:49:00',
            'created_at' => '2025-09-12 16:46:46',
            'updated_at' => '2025-10-01 23:49:39',
        ]);

        // Insertar los contribuidores (autores)
        DB::table('book_contributors')->insert([
            [
                'book_id' => $bookId,
                'contributor_type' => 'author',
                'full_name' => 'Pedro Alex Taya Yactayo',
                'email' => 'ataya@mattinnovasolution.com',
                'sequence_number' => 1,
                'biographical_note' => 'Autor Principal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'book_id' => $bookId,
                'contributor_type' => 'author',
                'full_name' => 'Tania Elizabeth Urcia Casas',
                'email' => 'test@test.com',
                'sequence_number' => 2,
                'biographical_note' => 'test',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Insertar el contenido completo basado en tu backup (35 items)
        $contents = [
            ['Créditos', NULL, NULL, NULL, 'Agradecimientos y créditos', 1, 0],
            ['Dedicatoria', NULL, NULL, NULL, 'Dedicatoria del autor', 2, 0],
            ['Autores', NULL, NULL, NULL, 'Información sobre los autores', 3, 0],
            ['Presentación', NULL, NULL, NULL, 'Presentación del libro', 4, 0],
            ['1. Ingresando a trabajar con ChatGPT', 1, NULL, NULL, 'Introducción a ChatGPT', 5, 0],
            ['2. ¿Qué es un Prompt?', 2, NULL, NULL, 'Definición de prompts', 6, 0],
            ['3. ¿Qué es un Prompt Maestro?', 3, NULL, NULL, 'Concepto de prompts maestros', 7, 0],
            ['4. Cómo usar los prompts en ChatGPT', 4, NULL, NULL, 'Guía de uso', 8, 0],
            ['5. Nivel Inicial', 5, NULL, NULL, 'Educación inicial', 9, 0],
            ['Banco de Prompts por Áreas Curriculares (140)', NULL, NULL, NULL, 'Prompts por áreas', 10, 1],
            ['Personal Social', NULL, NULL, NULL, 'Área personal social', 11, 2],
            ['Psicomotriz', NULL, NULL, NULL, 'Área psicomotriz', 12, 2],
            ['Comunicación', NULL, NULL, NULL, 'Área de comunicación', 13, 2],
            ['Castellano como Segunda Lengua', NULL, NULL, NULL, 'Lengua adicional', 14, 2],
            ['Descubrimiento del Mundo', NULL, NULL, NULL, 'Exploración del mundo', 15, 2],
            ['Matemática', NULL, NULL, NULL, 'Área matemática', 16, 2],
            ['Ciencia y Tecnología', NULL, NULL, NULL, 'Ciencia y tecnología', 17, 2],
            ['Banco de Prompts Maestros – Educación Inicial (180)', NULL, NULL, NULL, 'Prompts maestros inicial', 18, 1],
            ['Unidades Didácticas', NULL, NULL, NULL, 'Unidades de aprendizaje', 19, 2],
            ['Sesiones de Clase', NULL, NULL, NULL, 'Planificación de sesiones', 20, 2],
            ['Evaluaciones', NULL, NULL, NULL, 'Instrumentos de evaluación', 21, 2],
            ['Estrategias y Presentaciones', NULL, NULL, NULL, 'Estrategias educativas', 22, 2],
            ['Rúbricas', NULL, NULL, NULL, 'Rúbricas de evaluación', 23, 2],
            ['Otras Actividades', NULL, NULL, NULL, 'Actividades complementarias', 24, 2],
            ['6. Nivel Primaria', 6, NULL, NULL, 'Educación primaria', 25, 0],
            ['Banco de Prompts por Áreas Curriculares (180)', NULL, NULL, NULL, 'Prompts primaria', 26, 1],
            ['Banco de Prompts Maestros – Educación Primaria (180)', NULL, NULL, NULL, 'Prompts maestros primaria', 27, 1],
            ['7. Nivel Secundaria', 7, NULL, NULL, 'Educación secundaria', 28, 0],
            ['Banco de Prompts por Áreas Curriculares (200)', NULL, NULL, NULL, 'Prompts secundaria', 29, 1],
            ['Banco de Prompts Maestros – Educación Secundaria (180)', NULL, NULL, NULL, 'Prompts maestros secundaria', 30, 1],
            ['8. Nivel Básica Alternativa', 8, NULL, NULL, 'Educación alternativa', 31, 0],
            ['Banco de Prompts por Áreas Curriculares (200)', NULL, NULL, NULL, 'Prompts alternativa', 32, 1],
            ['Banco de Prompts Maestros – Educación Básica Alternativa (180)', NULL, NULL, NULL, 'Prompts maestros alternativa', 33, 1],
            ['Conclusión', NULL, NULL, NULL, 'Conclusiones finales', 34, 0],
            ['Recomendaciones', NULL, NULL, NULL, 'Recomendaciones', 35, 1],
        ];

        foreach ($contents as $content) {
            DB::table('book_contents')->insert([
                'book_id' => $bookId,
                'chapter_title' => $content[0],
                'chapter_number' => $content[1],
                'page_start' => $content[2],
                'page_end' => $content[3],
                'description' => $content[4],
                'sort_order' => $content[5],
                'level' => $content[6],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
