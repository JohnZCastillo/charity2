<?php

namespace App\View\Components;

use App\Models\EventImage;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EventImageForm extends Component
{

    protected EventImage $image;

    public function __construct(EventImage $image)
    {
        $this->image = $image;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.event-image-form',[
            'image' => $this->image
        ]);
    }
}
