<?php

namespace App\Http\Controllers;

use App\Services\TeacherMenuService;

class TeacherMenuController extends Controller
{
    public function __construct(private readonly TeacherMenuService $service)
    {
    }

    public function index()
    {
        return view('pages.blank-resource', [
            'title' => 'Teacher Menu',
            'group' => 'Teacher',
            'key' => 'index',
        ]);
    }

    public function show(string $page)
    {
        $resource = $this->service->getByKey($page);

        return view('pages.blank-resource', [
            'title' => $resource['title'],
            'group' => 'Teacher',
            'key' => $resource['key'],
        ]);
    }
}
