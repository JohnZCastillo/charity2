<?php

namespace App\View\Components;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\Account;
use App\Models\Item;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Donation extends Component
{
    /**
     * Create a new component instance.
     */
    protected $items;
    protected $recipients;

    public function __construct()
    {
        $this->items = Item::select(['id', 'name'])
            ->where('deleted', false)
            ->orderBy('name')
            ->get();

        $this->recipients = Account::select(['id', 'name'])
            ->where('type', UserType::RECIPIENT->value)
            ->where('status', UserStatus::ENABLED->value)
            ->orderBy('name')
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.donation', [
            'items' => $this->items,
            'recipients' => $this->recipients,
        ]);
    }
}
