<?php

namespace App\View\Components\profile;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProfileCard extends Component
{
    public function __construct(
        public readonly mixed $data = null,
        public readonly mixed $user = null,
    )
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.profile.profile-card');
    }
}
