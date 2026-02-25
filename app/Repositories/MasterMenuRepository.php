<?php

namespace App\Repositories;

use App\Repositories\Contracts\MenuRepositoryInterface;

class MasterMenuRepository implements MenuRepositoryInterface
{
    public function getPageMap(): array
    {
        return [
            'dashboard' => 'Dashboard',
            'profile' => 'My Information',
        ];
    }
}
