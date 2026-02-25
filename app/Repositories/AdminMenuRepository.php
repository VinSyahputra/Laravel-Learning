<?php

namespace App\Repositories;

use App\Repositories\Contracts\MenuRepositoryInterface;

class AdminMenuRepository implements MenuRepositoryInterface
{
    public function getPageMap(): array
    {
        return [
            'option/generals' => 'Generals',
            'log-viewer' => 'Log Viewer',
            'email-tester' => 'Email Tester',
            'queue-cron' => 'Queue Cron',
            'users' => 'List User',
            'roles' => 'Roles',
            'permissions' => 'Permissions',
        ];
    }
}
