<?php
// app/Livewire/AdminDashboard.php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Book;
use App\Models\User;
use App\Models\Order;
use App\Models\UserDownload;
use App\Models\Category;
use Carbon\Carbon;

class AdminDashboard extends Component
{
    public $stats = [];
    public $selectedPeriod = '7d'; // 7d, 30d, 90d

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $this->stats = [
            'total_books' => Book::count(),
            'total_users' => User::count(),
            'total_downloads' => UserDownload::count(),
            'today_downloads' => UserDownload::whereDate('downloaded_at', today())->count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'active_users' => User::active()->count(),
            'users_with_temp_passwords' => User::withTempPassword()->count(),
            'featured_books' => Book::featured()->count(),
        ];

        $this->stats = array_merge($this->stats, $this->getChartData());
    }

    public function updatedSelectedPeriod()
    {
        $this->loadStats();
    }

    private function getChartData()
    {
        $days = $this->getDaysForPeriod();

        return [
            'downloads_chart' => $this->getDownloadsChartData($days),
            'books_by_category' => $this->getBooksByCategoryData(),
            'user_activity' => $this->getUserActivityData($days),
        ];
    }

    private function getDaysForPeriod()
    {
        return match ($this->selectedPeriod) {
            '7d' => 7,
            '30d' => 30,
            '90d' => 90,
            default => 7,
        };
    }

    private function getDownloadsChartData($days)
    {
        $data = [];
        $labels = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dateStr = $date->format('M j');
            $labels[] = $dateStr;
            $data[] = UserDownload::whereDate('downloaded_at', $date)->count();
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    private function getBooksByCategoryData()
    {
        $categories = Category::withCount('books')
            ->having('books_count', '>', 0)
            ->orderBy('books_count', 'desc')
            ->limit(6)
            ->get();

        return [
            'labels' => $categories->pluck('name')->toArray(),
            'data' => $categories->pluck('books_count')->toArray(),
            'colors' => ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#06B6D4'],
        ];
    }

    private function getUserActivityData($days)
    {
        $data = [];
        $labels = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dateStr = $date->format('M j');
            $labels[] = $dateStr;

            $data[] = [
                'downloads' => UserDownload::whereDate('downloaded_at', $date)->count(),
                'registrations' => User::whereDate('created_at', $date)->count(),
            ];
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    public function render()
    {
        return view('livewire.admin-dashboard');
    }
}
