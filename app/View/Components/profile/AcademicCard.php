<?php

namespace App\View\Components\profile;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AcademicCard extends Component
{
    public function __construct(public readonly mixed $data = null) {}

    public function render(): View|Closure|string
    {
        return view('components.profile.academic-card');
    }
}
