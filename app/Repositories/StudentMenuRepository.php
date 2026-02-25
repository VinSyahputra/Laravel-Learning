<?php

namespace App\Repositories;

use App\Repositories\Contracts\MenuRepositoryInterface;

class StudentMenuRepository implements MenuRepositoryInterface
{
    public function getPageMap(): array
    {
        return [
            'my-class' => 'My Class',
            'classes' => 'List of Classes',
            'certificates' => 'Certificates',
            'raports' => 'Raports',
        ];
    }
}
