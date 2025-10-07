<?php

namespace App\Livewire\Admin;

use App\Models\Claims;
use Livewire\Component;
use Livewire\WithPagination;

class ClaimsTable extends Component
{
    use WithPagination;

    public $search = '';
    public $tipoFilter = '';
    public $dateFilter = '';
    public $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'tipoFilter' => ['except' => ''],
        'dateFilter' => ['except' => ''],
        'perPage' => ['except' => 10]
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingTipoFilter()
    {
        $this->resetPage();
    }

    public function updatingDateFilter()
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
        $this->tipoFilter = '';
        $this->dateFilter = '';
        $this->resetPage();
    }

    public function render()
    {
        $query = Claims::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('dni', 'like', '%' . $this->search . '%')
                        ->orWhere('subject', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->tipoFilter, function ($query) {
                $query->where('tipo_reclamo', $this->tipoFilter);
            })
            ->when($this->dateFilter, function ($query) {
                if ($this->dateFilter === 'today') {
                    $query->whereDate('created_at', today());
                } elseif ($this->dateFilter === 'week') {
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                } elseif ($this->dateFilter === 'month') {
                    $query->whereMonth('created_at', now()->month)
                        ->whereYear('created_at', now()->year);
                }
            })
            ->orderBy('created_at', 'desc');

        $claims = $query->paginate($this->perPage);

        $tipos = [
            'problema_descarga' => 'Problema descarga',
            'cobro_indebido' => 'Cobro indebido',
            'acceso_cuenta' => 'Acceso a cuenta',
            'otro' => 'Otro',
        ];

        return view('livewire.admin.claims-table', [
            'claims' => $claims,
            'tipos' => $tipos,
            'totalClaims' => Claims::count(),
            'filteredCount' => $query->count(),
            'hasPages' => $claims->hasPages() && $claims->total() > $claims->perPage()
        ]);
    }
}
