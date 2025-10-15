<?php
// app/Http/Controllers/Admin/AdminController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use App\Models\User;
use App\Models\UserDownload;
use App\Models\Category;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = $this->getDashboardStats();
        return view('admin.dashboard', compact('stats'));
    }

    private function getDashboardStats()
    {
        $today = now();
        $lastWeek = $today->copy()->subDays(7);
        $lastMonth = $today->copy()->subDays(30);

        return [
            // Stats básicos
            'total_books' => Book::count(),
            'total_users' => User::count(),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),

            // Stats para biblioteca digital
            'total_downloads' => UserDownload::count(),
            'today_downloads' => UserDownload::whereDate('downloaded_at', $today)->count(),
            'users_with_temp_passwords' => User::withTempPassword()->count(),

            // Stats para gráficos
            'downloads_last_7_days' => $this->getDownloadsLast7Days(),
            'books_by_category' => $this->getBooksByCategory(),
            'user_registrations' => $this->getUserRegistrations(),
            'popular_books' => Book::mostDownloaded(5)->get(),

            // Órdenes recientes
            'recent_orders' => Order::with('user')->latest()->take(5)->get(),
        ];
    }

    private function getDownloadsLast7Days()
    {
        $downloads = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $downloads[$date] = UserDownload::whereDate('downloaded_at', $date)->count();
        }
        return $downloads;
    }

    private function getBooksByCategory()
    {
        return Category::withCount('books')
            ->having('books_count', '>', 0)
            ->orderBy('books_count', 'desc')
            ->limit(8)
            ->get()
            ->pluck('books_count', 'name')
            ->toArray();
    }

    private function getUserRegistrations()
    {
        $registrations = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $registrations[$date->format('M Y')] = User::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }
        return $registrations;
    }

    public function contacts()
    {
        return view('admin.shared.work-in-progress', [
            'pageTitle' => 'Gestión de Contactos'
        ]);
    }
}
