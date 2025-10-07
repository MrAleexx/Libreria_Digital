<?php

namespace App\Http\Controllers\Admin;

// app/Http/Controllers/Admin/AdminController.php
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use App\Models\User;
use App\Models\Claims;
use App\Models\Contacts;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_books' => Book::count(),
            'total_users' => User::count(),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'recent_orders' => Order::with('user')->latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }



    public function contacts()
    {
        return view('admin.shared.work-in-progress', [
            'pageTitle' => 'Gestión de Contactos'
        ]);

    }
}
