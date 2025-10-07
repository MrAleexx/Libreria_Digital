<?php

namespace App\Http\Controllers\Home;

use App\Models\Book;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeBookController extends Controller
{
    public function __invoke()
    {
        $books = Book::all();
        return view('books', compact('books'));
    }
}
