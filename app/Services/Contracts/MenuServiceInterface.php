<?php

namespace App\Services\Contracts;

interface MenuServiceInterface
{
    public function all(): array;

    public function getByKey(string $key): array;
}
