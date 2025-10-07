<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    private const PDF_NOT_AVAILABLE = 'El archivo PDF no está disponible';
    private const FILE_NOT_FOUND = 'El archivo no se encuentra en el servidor';
    private const ACCESS_DENIED = 'No tienes acceso a este libro';

    public function index()
    {
        $purchasedItems = OrderDetail::whereHas('order', function ($query) {
            $query->where('user_id', Auth::id())
                ->where('status', 'paid');
        })->with(['book', 'order'])->get();

        return view('book.book', compact('purchasedItems'));
    }

    public function show(Book $book)
    {
        if ($book->is_free) {
            return view('book.reader', compact('book'));
        }

        $hasPurchased = OrderDetail::whereHas('order', function ($query) {
            $query->where('user_id', Auth::id())
                ->where('status', 'paid');
        })->where('book_id', $book->id)->exists();

        if (!$hasPurchased) {
            abort(403, self::ACCESS_DENIED);
        }

        return view('book.reader', compact('book'));
    }

    public function downloadPdf(Book $book)
    {
        if ($book->is_free) {
            if (!$book->pdf_file) {
                abort(404, self::PDF_NOT_AVAILABLE);
            }

            $filePath = storage_path('app/public/' . $book->pdf_file);

            if (!file_exists($filePath)) {
                abort(404, self::FILE_NOT_FOUND);
            }

            return response()->download($filePath, $book->title . '.pdf');
        }

        $hasPurchased = OrderDetail::whereHas('order', function ($query) {
            $query->where('user_id', Auth::id())
                ->where('status', 'paid');
        })->where('book_id', $book->id)->exists();

        if (!$hasPurchased) {
            abort(403, self::ACCESS_DENIED);
        }

        if (!$book->pdf_file) {
            abort(404, self::PDF_NOT_AVAILABLE);
        }

        $filePath = storage_path('app/public/' . $book->pdf_file);

        if (!file_exists($filePath)) {
            abort(404, self::FILE_NOT_FOUND);
        }

        return response()->download($filePath, $book->title . '.pdf');
    }

    public function viewPdf(Book $book)
    {
        if ($book->is_free) {
            if (!$book->pdf_file) {
                abort(404, self::PDF_NOT_AVAILABLE);
            }

            $filePath = public_path('storage/' . $book->pdf_file);

            if (!file_exists($filePath)) {
                abort(404, self::FILE_NOT_FOUND);
            }

            return response()->file($filePath, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $book->title . '.pdf"'
            ]);
        }

        $hasPurchased = OrderDetail::whereHas('order', function ($query) {
            $query->where('user_id', Auth::id())
                ->where('status', 'paid');
        })->where('book_id', $book->id)->exists();

        if (!$hasPurchased) {
            abort(403, self::ACCESS_DENIED);
        }

        if (!$book->pdf_file) {
            abort(404, self::PDF_NOT_AVAILABLE);
        }

        $filePath = public_path('storage/' . $book->pdf_file);

        if (!file_exists($filePath)) {
            abort(404, self::FILE_NOT_FOUND);
        }

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $book->title . '.pdf"'
        ]);
    }
}
