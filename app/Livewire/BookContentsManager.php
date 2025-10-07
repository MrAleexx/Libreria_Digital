<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Book;
use App\Models\BookContent;

class BookContentsManager extends Component
{
    public $book;
    public $contents = [];
    public $showForm = false;
    public $showImportForm = false;
    public $editingIndex = null;
    public $importText = '';
    public $selectedItems = [];
    public $selectAll = false;

    public $form = [
        'chapter_title' => '',
        'chapter_number' => null,
        'description' => '',
        'sort_order' => 0,
        'level' => 0 // 0 = Tema principal, 1 = Subtema, 2 = Sub-subtema, etc.
    ];

    protected $rules = [
        'form.chapter_title' => 'required|string|max:200',
        'form.chapter_number' => 'nullable|integer|min:1',
        'form.description' => 'nullable|string',
        'form.sort_order' => 'required|integer|min:0',
        'form.level' => 'required|integer|min:0|max:4',
        'importText' => 'nullable|string|min:10'
    ];

    public function mount(Book $book)
    {
        $this->book = $book;
        $this->loadContents();
    }

    public function loadContents()
    {
        $this->contents = $this->book->contents()
            ->orderBy('sort_order')
            ->get()
            ->toArray();

        $this->selectedItems = [];
        $this->selectAll = false;
    }

    // Plantilla específica para libro de prompts educativos
    public function generatePromptBookTemplate()
    {
        $template = [
            ['chapter_title' => 'Índice General', 'description' => 'Tabla de contenidos', 'level' => 0],
            ['chapter_title' => 'Créditos', 'description' => 'Agradecimientos y créditos', 'level' => 0],
            ['chapter_title' => 'Dedicatoria', 'description' => 'Dedicatoria del autor', 'level' => 0],
            ['chapter_title' => 'Autores', 'description' => 'Información sobre los autores', 'level' => 0],
            ['chapter_title' => 'Presentación', 'description' => 'Presentación del libro', 'level' => 0],
            ['chapter_title' => '1. Ingresando a trabajar con ChatGPT', 'description' => 'Introducción a ChatGPT', 'level' => 0],
            ['chapter_title' => '2. ¿Qué es un Prompt?', 'description' => 'Definición de prompts', 'level' => 0],
            ['chapter_title' => '3. ¿Qué es un Prompt Maestro?', 'description' => 'Concepto de prompts maestros', 'level' => 0],
            ['chapter_title' => '4. Cómo usar los prompts en ChatGPT', 'description' => 'Guía de uso', 'level' => 0],
            ['chapter_title' => '5. Nivel Inicial', 'description' => 'Educación inicial', 'level' => 0],
            ['chapter_title' => 'Banco de Prompts por Áreas Curriculares (140)', 'description' => 'Prompts por áreas', 'level' => 1],
            ['chapter_title' => 'Personal Social', 'description' => 'Área personal social', 'level' => 2],
            ['chapter_title' => 'Psicomotriz', 'description' => 'Área psicomotriz', 'level' => 2],
            ['chapter_title' => 'Comunicación', 'description' => 'Área de comunicación', 'level' => 2],
            ['chapter_title' => 'Castellano como Segunda Lengua', 'description' => 'Lengua adicional', 'level' => 2],
            ['chapter_title' => 'Descubrimiento del Mundo', 'description' => 'Exploración del mundo', 'level' => 2],
            ['chapter_title' => 'Matemática', 'description' => 'Área matemática', 'level' => 2],
            ['chapter_title' => 'Ciencia y Tecnología', 'description' => 'Ciencia y tecnología', 'level' => 2],
            ['chapter_title' => 'Banco de Prompts Maestros – Educación Inicial (180)', 'description' => 'Prompts maestros inicial', 'level' => 1],
            ['chapter_title' => 'Unidades Didácticas', 'description' => 'Unidades de aprendizaje', 'level' => 2],
            ['chapter_title' => 'Sesiones de Clase', 'description' => 'Planificación de sesiones', 'level' => 2],
            ['chapter_title' => 'Evaluaciones', 'description' => 'Instrumentos de evaluación', 'level' => 2],
            ['chapter_title' => 'Estrategias y Presentaciones', 'description' => 'Estrategias educativas', 'level' => 2],
            ['chapter_title' => 'Rúbricas', 'description' => 'Rúbricas de evaluación', 'level' => 2],
            ['chapter_title' => 'Otras Actividades', 'description' => 'Actividades complementarias', 'level' => 2],
            ['chapter_title' => '6. Nivel Primaria', 'description' => 'Educación primaria', 'level' => 0],
            ['chapter_title' => 'Banco de Prompts por Áreas Curriculares (180)', 'description' => 'Prompts primaria', 'level' => 1],
            ['chapter_title' => 'Banco de Prompts Maestros – Educación Primaria (180)', 'description' => 'Prompts maestros primaria', 'level' => 1],
            ['chapter_title' => '7. Nivel Secundaria', 'description' => 'Educación secundaria', 'level' => 0],
            ['chapter_title' => 'Banco de Prompts por Áreas Curriculares (200)', 'description' => 'Prompts secundaria', 'level' => 1],
            ['chapter_title' => 'Banco de Prompts Maestros – Educación Secundaria (180)', 'description' => 'Prompts maestros secundaria', 'level' => 1],
            ['chapter_title' => '8. Nivel Básica Alternativa', 'description' => 'Educación alternativa', 'level' => 0],
            ['chapter_title' => 'Banco de Prompts por Áreas Curriculares (200)', 'description' => 'Prompts alternativa', 'level' => 1],
            ['chapter_title' => 'Banco de Prompts Maestros – Educación Básica Alternativa (180)', 'description' => 'Prompts maestros alternativa', 'level' => 1],
            ['chapter_title' => 'Conclusión', 'description' => 'Conclusiones finales', 'level' => 0],
            ['chapter_title' => 'Recomendaciones', 'description' => 'Recomendaciones', 'level' => 1],
        ];

        $this->applyTemplate($template, "Plantilla de Libro de Prompts Educativos aplicada exitosamente.");
    }

    // Generar plantilla genérica
    public function generateGenericTemplate()
    {
        $template = [
            ['chapter_title' => 'Portada', 'description' => 'Portada del libro', 'level' => 0],
            ['chapter_title' => 'Créditos', 'description' => 'Agradecimientos y créditos', 'level' => 0],
            ['chapter_title' => 'Dedicatoria', 'description' => 'Dedicatoria del autor', 'level' => 0],
            ['chapter_title' => 'Prólogo', 'description' => 'Prólogo o introducción', 'level' => 0],
            ['chapter_title' => 'Índice General', 'description' => 'Tabla de contenidos', 'level' => 0],
            ['chapter_title' => 'Introducción', 'description' => 'Introducción general', 'level' => 0],
            ['chapter_title' => 'Capítulo 1: Conceptos Básicos', 'description' => 'Fundamentos teóricos', 'level' => 0],
            ['chapter_title' => '1.1 Fundamentos Teóricos', 'description' => 'Bases conceptuales', 'level' => 1],
            ['chapter_title' => '1.2 Marco Conceptual', 'description' => 'Definiciones básicas', 'level' => 1],
            ['chapter_title' => 'Capítulo 2: Desarrollo de Contenidos', 'description' => 'Desarrollo principal', 'level' => 0],
            ['chapter_title' => '2.1 Metodología', 'description' => 'Enfoque metodológico', 'level' => 1],
            ['chapter_title' => '2.2 Proceso de Desarrollo', 'description' => 'Etapas del desarrollo', 'level' => 1],
            ['chapter_title' => 'Capítulo 3: Aplicaciones Prácticas', 'description' => 'Casos prácticos', 'level' => 0],
            ['chapter_title' => '3.1 Ejemplos Prácticos', 'description' => 'Casos de estudio', 'level' => 1],
            ['chapter_title' => '3.2 Ejercicios Resueltos', 'description' => 'Problemas y soluciones', 'level' => 1],
            ['chapter_title' => 'Capítulo 4: Resultados y Análisis', 'description' => 'Análisis de resultados', 'level' => 0],
            ['chapter_title' => '4.1 Análisis de Datos', 'description' => 'Procesamiento de información', 'level' => 1],
            ['chapter_title' => '4.2 Interpretación de Resultados', 'description' => 'Conclusiones del análisis', 'level' => 1],
            ['chapter_title' => 'Conclusiones', 'description' => 'Conclusiones finales', 'level' => 0],
            ['chapter_title' => 'Recomendaciones', 'description' => 'Recomendaciones', 'level' => 1],
            ['chapter_title' => 'Bibliografía', 'description' => 'Referencias bibliográficas', 'level' => 0],
            ['chapter_title' => 'Anexos', 'description' => 'Material complementario', 'level' => 0],
            ['chapter_title' => 'Anexo A: Documentación', 'description' => 'Documentos complementarios', 'level' => 1],
            ['chapter_title' => 'Anexo B: Herramientas', 'description' => 'Instrumentos de trabajo', 'level' => 1],
        ];

        $this->applyTemplate($template, "Plantilla genérica aplicada exitosamente.");
    }

    private function applyTemplate($template, $successMessage)
    {
        BookContent::where('book_id', $this->book->id)->delete();

        foreach ($template as $index => $chapter) {

            BookContent::create([
                'book_id' => $this->book->id,
                'chapter_title' => $chapter['chapter_title'],
                'description' => $chapter['description'],
                'sort_order' => $index,
                'chapter_number' => $this->extractChapterNumber($chapter['chapter_title']),
                'level' => $chapter['level'] // ← ESTA ES LA LÍNEA CLAVE
            ]);
        }

        $this->loadContents();
        $this->dispatch('template-applied', message: $successMessage);
    }

    // Importar desde texto plano
    public function importFromText()
    {
        $this->validate([
            'importText' => 'required|string|min:10'
        ]);

        $chapters = $this->extractChaptersFromText($this->importText);
        $this->processImportedChapters($chapters);

        $this->importText = '';
        $this->showImportForm = false;
        $this->dispatch('import-success', message: 'Índice importado exitosamente desde texto.');
    }

    // Extraer capítulos del texto
    private function extractChaptersFromText($text)
    {
        $lines = explode("\n", $text);
        $chapters = [];

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;

            $chapters[] = [
                'title' => $line,
            ];
        }

        return $chapters;
    }

    private function extractChapterNumber($title)
    {
        if (preg_match('/^(\d+)\./', $title, $matches)) {
            return intval($matches[1]);
        }
        if (preg_match('/Capítulo\s+(\d+)/i', $title, $matches)) {
            return intval($matches[1]);
        }
        return null;
    }

    private function generateDescription($title)
    {
        $lowerTitle = strtolower($title);

        if (str_contains($lowerTitle, 'crédito')) return 'Agradecimientos y créditos';
        if (str_contains($lowerTitle, 'dedicatoria')) return 'Dedicatoria del autor';
        if (str_contains($lowerTitle, 'autor')) return 'Información sobre los autores';
        if (str_contains($lowerTitle, 'presentación') || str_contains($lowerTitle, 'prólogo')) return 'Introducción del libro';
        if (str_contains($lowerTitle, 'índice')) return 'Tabla de contenidos';
        if (str_contains($lowerTitle, 'conclusión')) return 'Conclusiones finales';
        if (str_contains($lowerTitle, 'bibliografía') || str_contains($lowerTitle, 'referencia')) return 'Referencias bibliográficas';
        if (str_contains($lowerTitle, 'anexo')) return 'Material complementario';
        if (str_contains($lowerTitle, 'portada')) return 'Portada del libro';

        return 'Contenido del libro';
    }

    // Métodos para la vista previa
    public function calculateIndentation($title)
    {
        // Determinar nivel de indentación basado en el título
        if (is_numeric($title[0])) {
            $parts = explode('.', $title);
            return count($parts) - 1;
        }

        if (preg_match('/^[A-Z][a-z]+/', $title) && !preg_match('/^(Índice|Créditos|Dedicatoria|Autores|Presentación|Conclusión)/', $title)) {
            return 1;
        }

        return 0;
    }

    public function cleanTitle($title)
    {
        // Limpiar título para vista previa
        return trim($title);
    }

    // Selección múltiple
    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedItems = collect($this->contents)->pluck('id')->toArray();
        } else {
            $this->selectedItems = [];
        }
    }

    public function updatedSelectedItems()
    {
        $this->selectAll = count($this->selectedItems) === count($this->contents);
    }

    public function deleteSelected()
    {
        if (empty($this->selectedItems)) {
            $this->dispatch('no-selection', message: 'Por favor selecciona elementos para eliminar.');
            return;
        }

        BookContent::where('book_id', $this->book->id)
            ->whereIn('id', $this->selectedItems)
            ->delete();

        $this->loadContents();
        $this->dispatch('selected-deleted', message: count($this->selectedItems) . ' elemento(s) eliminado(s) exitosamente.');
    }

    public function clearIndex()
    {
        BookContent::where('book_id', $this->book->id)->delete();
        $this->loadContents();
        $this->dispatch('index-cleared', message: 'Índice eliminado completamente.');
    }

    // Exportar a texto formateado
    public function exportToText()
    {
        $text = "ÍNDICE\n\n";

        foreach ($this->contents as $content) {
            $text .= "{$content['chapter_title']}\n";
        }

        // Copiar al portapapeles usando JavaScript
        $this->dispatch('copy-to-clipboard', text: $text);
        $this->dispatch('export-success', message: 'Índice copiado al portapapeles.');
    }

    // Métodos básicos CRUD
    public function addContent()
    {
        $this->validate([
            'form.chapter_title' => 'required|string|max:200',
            'form.sort_order' => 'required|integer|min:0',
            'form.level' => 'required|integer|min:0|max:4'
        ]);

        BookContent::create(array_merge($this->form, [
            'book_id' => $this->book->id
        ]));

        $this->resetForm();
        $this->loadContents();
        $this->showForm = false;

        $this->dispatch('content-added', message: 'Elemento agregado exitosamente.');
    }

    public function editContent($index)
    {
        if (!isset($this->contents[$index])) {
            return;
        }

        $content = $this->contents[$index];

        $this->form = [
            'chapter_title' => $content['chapter_title'] ?? '',
            'chapter_number' => $content['chapter_number'] ?? null,
            'description' => $content['description'] ?? '',
            'sort_order' => $content['sort_order'] ?? 0,
            'level' => $content['level'] ?? 0 // Asegurar que se carga el nivel
        ];

        $this->editingIndex = $index;
        $this->showForm = true;
    }

    public function updateContent()
    {
        $this->validate([
            'form.chapter_title' => 'required|string|max:200',
            'form.sort_order' => 'required|integer|min:0',
            'form.level' => 'required|integer|min:0|max:4'
        ]);

        $content = BookContent::find($this->contents[$this->editingIndex]['id']);
        $content->update($this->form);

        $this->resetForm();
        $this->loadContents();
        $this->showForm = false;

        $this->dispatch('content-updated', message: 'Elemento actualizado exitosamente.');
    }

    public function deleteContent($index)
    {
        if (!isset($this->contents[$index])) {
            return;
        }

        $contentId = $this->contents[$index]['id'];
        BookContent::where('id', $contentId)->delete();

        $this->loadContents();
        $this->dispatch('content-deleted', message: 'Elemento eliminado exitosamente.');
    }



    // Método para calcular automáticamente el nivel basado en el título
    public function calculateLevel($title)
    {
        $title = trim($title);

        // Si empieza con espacios o tabs, es un subtema
        if (preg_match('/^\s+/', $title)) {
            $spaces = strlen($title) - strlen(ltrim($title));
            return min(3, intval($spaces / 2)); // Cada 2 espacios = 1 nivel
        }

        // Si es un número con punto (1., 2., etc.) es nivel 0
        if (preg_match('/^\d+\./', $title)) {
            return 0;
        }

        // Si es texto sin sangría, es nivel 0
        return 0;
    }

    // En el método de importación, usar calculateLevel
    private function processImportedChapters($chapters)
    {
        BookContent::where('book_id', $this->book->id)->delete();

        foreach ($chapters as $index => $chapter) {
            BookContent::create([
                'book_id' => $this->book->id,
                'chapter_title' => trim($chapter['title']),
                'chapter_number' => $this->extractChapterNumber($chapter['title']),
                'sort_order' => $index,
                'level' => $this->calculateLevel($chapter['title']),
                'description' => $this->generateDescription($chapter['title'])
            ]);
        }

        $this->loadContents();
    }

    public function resetForm()
    {
        $this->form = [
            'chapter_title' => '',
            'chapter_number' => null,
            'description' => '',
            'sort_order' => count($this->contents),
            'level' => 0
        ];
        $this->editingIndex = null;
        $this->resetErrorBag();
    }

    public function cancelEdit()
    {
        $this->resetForm();
        $this->showForm = false;
    }

    public function render()
    {
        return view('livewire.book-contents-manager');
    }
}
