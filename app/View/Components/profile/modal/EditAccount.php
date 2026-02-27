<?php

namespace App\View\Components\profile\modal;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EditAccount extends Component
{
    public function __construct(public readonly mixed $data = null) {}

    public function render(): View|Closure|string
    {
        return view('components.profile.modal.edit-account');
    }
}
