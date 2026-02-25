<?php

namespace App\Repositories;

use App\Repositories\Contracts\MenuRepositoryInterface;

class TeacherMenuRepository implements MenuRepositoryInterface
{
    public function getPageMap(): array
    {
        return [
            'my-class' => 'My Class',
            'classes' => 'List of Classes',
            'quiz' => 'Quiz',
            'questions' => 'Questions',
            'raports' => 'Raports',
        ];
    }
}
