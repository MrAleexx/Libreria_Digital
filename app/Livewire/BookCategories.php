<?php
// app/Livewire/BookCategories.php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Book;
use App\Models\Category;

class BookCategories extends Component
{
    public Book $book;
    public $selectedCategories = [];
    public $categories = [];

    public function mount(Book $book)
    {
        $this->book = $book;
        $this->selectedCategories = $book->categories->pluck('id')->toArray();
        $this->loadCategories();
    }

    public function loadCategories()
    {
        $this->categories = Category::active()
            ->with(['children' => function ($query) {
                $query->active()->orderBy('sort_order');
            }])
            ->main()
            ->orderBy('sort_order')
            ->get();
    }

    public function save()
    {
        $this->book->syncCategories($this->selectedCategories);

        session()->flash('message', 'Categorías actualizadas correctamente.');
    }

    public function render()
    {
        return view('livewire.book-categories');
    }
}
