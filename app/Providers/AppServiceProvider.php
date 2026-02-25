<?php

namespace App\Providers;

use App\Repositories\AdminMenuRepository;
use App\Repositories\Contracts\MenuRepositoryInterface;
use App\Repositories\MasterMenuRepository;
use App\Repositories\StudentMenuRepository;
use App\Repositories\TeacherMenuRepository;
use App\Services\AdminMenuService;
use App\Services\MasterMenuService;
use App\Services\StudentMenuService;
use App\Services\TeacherMenuService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->when(MasterMenuService::class)
            ->needs(MenuRepositoryInterface::class)
            ->give(MasterMenuRepository::class);

        $this->app->when(TeacherMenuService::class)
            ->needs(MenuRepositoryInterface::class)
            ->give(TeacherMenuRepository::class);

        $this->app->when(StudentMenuService::class)
            ->needs(MenuRepositoryInterface::class)
            ->give(StudentMenuRepository::class);

        $this->app->when(AdminMenuService::class)
            ->needs(MenuRepositoryInterface::class)
            ->give(AdminMenuRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
