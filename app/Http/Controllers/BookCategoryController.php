<?php
// app/Http/Controllers/BookCategoryController.php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookCategoryController extends Controller
{
    // Mostrar formulario para gestionar categorías de un libro
    public function edit(Book $book)
    {
        $categories = Category::active()
            ->with('children')
            ->main()
            ->orderBy('sort_order')
            ->get();

        $bookCategories = $book->categories->pluck('id')->toArray();

        return view('admin.books.categories', compact('book', 'categories', 'bookCategories'));
    }

    // Actualizar categorías de un libro
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id'
        ]);

        $book->syncCategories($request->categories ?? []);

        return redirect()
            ->route('admin.books.edit', $book)
            ->with('success', 'Categorías actualizadas correctamente.');
    }

    // API para obtener categorías de un libro (para Livewire/AJAX)
    public function getBookCategories(Book $book)
    {
        return response()->json([
            'categories' => $book->categories->pluck('id')
        ]);
    }
}
