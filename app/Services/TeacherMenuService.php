<?php

namespace App\Services;

use App\Repositories\Contracts\MenuRepositoryInterface;
use App\Services\Contracts\MenuServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TeacherMenuService implements MenuServiceInterface
{
    public function __construct(private readonly MenuRepositoryInterface $repository)
    {
    }

    public function all(): array
    {
        return $this->repository->getPageMap();
    }

    public function getByKey(string $key): array
    {
        $pages = $this->all();

        if (! array_key_exists($key, $pages)) {
            throw (new ModelNotFoundException())->setModel(self::class, [$key]);
        }

        return [
            'key' => $key,
            'title' => $pages[$key],
        ];
    }
}
