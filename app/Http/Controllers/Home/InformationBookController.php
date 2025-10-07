<?php

namespace App\Http\Controllers\Home;

use App\Models\Book;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InformationBookController extends Controller
{
    public function show(Book $book)
    {
        return view('book.information', compact('book'));
    }
}
