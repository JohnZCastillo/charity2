<?php

namespace App\View\Components;

use App\Models\Item;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StockInForm extends Component
{

    protected  $items;

    public function __construct()
    {
        $this->items = Item::select(['id', 'name'])
            ->where('deleted', false)
            ->orderBy('name')
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.stock-in-form',[
            'items' => $this->items
        ]);
    }
}
