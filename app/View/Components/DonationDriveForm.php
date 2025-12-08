<?php

namespace App\View\Components;

use App\Models\DonationDrive;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DonationDriveForm extends Component
{
    protected DonationDrive $donationDrive;

    public function __construct(DonationDrive $donationDrive)
    {
        $this->donationDrive = $donationDrive;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.donation-drive-form', [
            'donation' => $this->donationDrive,
        ]);
    }
}
