@extends('layouts.app')

@section('title', '403 - Forbidden')

@section('content')
<div class="flex flex-col items-center justify-center min-h-screen text-center">
    <h1 class="text-6xl font-bold text-red-500">403</h1>
    <p class="mt-4 text-lg text-gray-600">
        You do not have permission to access this page.
    </p>

    <a href="{{ url('/') }}"
       class="mt-6 px-4 py-2 bg-blue-600 text-white rounded">
        Back to Home
    </a>
</div>
@endsection