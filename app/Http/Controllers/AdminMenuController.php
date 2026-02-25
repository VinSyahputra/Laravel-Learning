<?php

namespace App\Http\Controllers;

use App\Services\AdminMenuService;

class AdminMenuController extends Controller
{
    public function __construct(private readonly AdminMenuService $service)
    {
    }

    public function index()
    {
        return view('pages.blank-resource', [
            'title' => 'Admin Tools',
            'group' => 'Admin',
            'key' => 'index',
        ]);
    }

    public function show(string $page)
    {
        $resource = $this->service->getByKey($page);

        return view('pages.blank-resource', [
            'title' => $resource['title'],
            'group' => 'Admin',
            'key' => $resource['key'],
        ]);
    }
}
