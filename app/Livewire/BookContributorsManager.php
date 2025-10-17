<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Book;
use App\Models\BookContributor;

class BookContributorsManager extends Component
{
    public $bookId;
    public $book;
    public $contributors = [];
    public $showForm = false;
    public $editingIndex = null;

    public $form = [
        'contributor_type' => 'author',
        'full_name' => '',
        'email' => '',
        'sequence_number' => 1,
        'biographical_note' => ''
    ];

    protected $rules = [
        'form.contributor_type' => 'required|in:author,editor,translator,illustrator',
        'form.full_name' => 'required|string|max:255',
        'form.email' => 'nullable|email',
        'form.sequence_number' => 'required|integer|min:1',
        'form.biographical_note' => 'nullable|string'
    ];

    public function mount($bookId = null)
    {
        if ($bookId) {
            $this->bookId = $bookId;
            $this->book = Book::with('contributors')->find($bookId);
            $this->loadContributors();
        } else {
            // Para creación, inicializar array vacío
            $this->contributors = [];
        }
    }

    public function loadContributors()
    {
        if ($this->book) {
            $this->contributors = $this->book->contributors()
                ->orderBy('sequence_number')
                ->get()
                ->toArray();
        } else {
            $this->contributors = [];
        }
    }

    public function addContributor()
    {
        $this->validate();

        // Si no hay libro (creación), guardar en array temporal
        if (!$this->book) {
            $this->contributors[] = array_merge($this->form, ['id' => uniqid()]);
            $this->resetForm();
            $this->showForm = false;
            session()->flash('message', 'Contribuidor agregado (se guardará al crear el libro).');
            return;
        }

        // Si hay libro, guardar en base de datos
        try {
            BookContributor::create(array_merge($this->form, [
                'book_id' => $this->book->id
            ]));

            $this->resetForm();
            $this->loadContributors();
            $this->showForm = false;

            session()->flash('message', 'Contribuidor agregado exitosamente.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al agregar contribuidor: ' . $e->getMessage());
        }
    }

    public function editContributor($index)
    {
        if (!isset($this->contributors[$index])) {
            return;
        }

        $contributor = $this->contributors[$index];
        $this->form = [
            'contributor_type' => $contributor['contributor_type'],
            'full_name' => $contributor['full_name'],
            'email' => $contributor['email'],
            'sequence_number' => $contributor['sequence_number'],
            'biographical_note' => $contributor['biographical_note']
        ];
        $this->editingIndex = $index;
        $this->showForm = true;
    }

    public function updateContributor()
    {
        $this->validate();

        // Si no hay libro (creación), actualizar array temporal
        if (!$this->book || !$this->book->exists) {
            if (isset($this->contributors[$this->editingIndex])) {
                $this->contributors[$this->editingIndex] = array_merge(
                    $this->form,
                    ['id' => $this->contributors[$this->editingIndex]['id']]
                );
            }
            $this->resetForm();
            $this->showForm = false;
            session()->flash('message', 'Contribuidor actualizado.');
            return;
        }

        // Si hay libro, actualizar en base de datos
        try {
            $contributor = BookContributor::find($this->contributors[$this->editingIndex]['id']);
            if ($contributor) {
                $contributor->update($this->form);
            }

            $this->resetForm();
            $this->loadContributors();
            $this->showForm = false;

            session()->flash('message', 'Contribuidor actualizado exitosamente.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al actualizar contribuidor: ' . $e->getMessage());
        }
    }

    public function deleteContributor($index)
    {
        if (!isset($this->contributors[$index])) {
            return;
        }

        // Si no hay libro (creación), eliminar del array temporal
        if (!$this->book || !$this->book->exists) {
            array_splice($this->contributors, $index, 1);
            session()->flash('message', 'Contribuidor eliminado.');
            return;
        }

        // Si hay libro, eliminar de base de datos
        try {
            $contributor = BookContributor::find($this->contributors[$index]['id']);
            if ($contributor) {
                $contributor->delete();
            }

            $this->loadContributors();
            session()->flash('message', 'Contribuidor eliminado exitosamente.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al eliminar contribuidor: ' . $e->getMessage());
        }
    }

    public function resetForm()
    {
        $this->form = [
            'contributor_type' => 'author',
            'full_name' => '',
            'email' => '',
            'sequence_number' => count($this->contributors) + 1,
            'biographical_note' => ''
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
        return view('livewire.book-contributors-manager');
    }
}
