<?php

namespace App\Http\Controllers;

use App\Services\MasterMenuService;

class MasterMenuController extends Controller
{
    public function __construct(private readonly MasterMenuService $service)
    {
    }

    public function index()
    {
        $page = $this->service->getByKey('dashboard');

        return view('pages.blank-resource', [
            'title' => $page['title'],
            'group' => 'Master',
            'key' => $page['key'],
        ]);
    }

}
