<?php

namespace App\View\Components\profile\modal;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EditBioInfo extends Component
{
    public function __construct(public readonly mixed $data = null)
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.profile.modal.edit-bio-info');
    }
}
