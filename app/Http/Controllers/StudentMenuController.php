<?php

namespace App\Http\Controllers;

use App\Services\StudentMenuService;

class StudentMenuController extends Controller
{
    public function __construct(private readonly StudentMenuService $service)
    {
    }

    public function index()
    {
        return view('pages.blank-resource', [
            'title' => 'Student Menu',
            'group' => 'Student',
            'key' => 'index',
        ]);
    }

    public function show(string $page)
    {
        $resource = $this->service->getByKey($page);

        return view('pages.blank-resource', [
            'title' => $resource['title'],
            'group' => 'Student',
            'key' => $resource['key'],
        ]);
    }
}
