<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class OrdersTable extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $paymentFilter = '';
    public $dateFrom = '';
    public $dateTo = '';
    public $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'paymentFilter' => ['except' => ''],
        'dateFrom' => ['except' => ''],
        'dateTo' => ['except' => ''],
        'perPage' => ['except' => 10]
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingPaymentFilter()
    {
        $this->resetPage();
    }

    public function updatingDateFrom()
    {
        $this->resetPage();
    }

    public function updatingDateTo()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->statusFilter = '';
        $this->paymentFilter = '';
        $this->dateFrom = '';
        $this->dateTo = '';
        $this->resetPage();
    }

    public function render()
    {
        $query = Order::with(['user', 'payment', 'orderDetails'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('user', function ($userQuery) {
                        $userQuery->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('email', 'like', '%' . $this->search . '%');
                    })
                        ->orWhere('id', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->paymentFilter, function ($query) {
                if ($this->paymentFilter === 'no_payment') {
                    $query->doesntHave('payment');
                } else {
                    $query->whereHas('payment', function ($q) {
                        $q->where('status', $this->paymentFilter);
                    });
                }
            })
            ->when($this->dateFrom, function ($query) {
                $query->whereDate('order_date', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function ($query) {
                $query->whereDate('order_date', '<=', $this->dateTo);
            })
            ->orderBy('order_date', 'desc');

        $orders = $query->paginate($this->perPage);

        $statuses = [
            'pending' => 'Pendiente',
            'processing' => 'Procesando',
            'shipped' => 'Enviado',
            'delivered' => 'Entregado',
            'cancelled' => 'Cancelado',
            'paid' => 'Pagado'
        ];

        $paymentStatuses = [
            'pending' => 'Pendiente',
            'confirmed' => 'Confirmado',
            'rejected' => 'Rechazado',
            'no_payment' => 'Sin pago'
        ];

        return view('livewire.admin.orders-table', [
            'orders' => $orders,
            'statuses' => $statuses,
            'paymentStatuses' => $paymentStatuses,
            'totalOrders' => Order::count(),
            'filteredCount' => $query->count(),
            'hasPages' => $orders->hasPages() && $orders->total() > $orders->perPage()
        ]);
    }
}
