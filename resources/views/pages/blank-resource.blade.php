@extends('layouts.app')

@section('content')
    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
        <h1 class="text-xl font-semibold text-gray-800 dark:text-white/90">{{ $title ?? 'Blank Resource Page' }}</h1>
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">This is a dummy blank view for {{ $group ?? 'Resource' }}.</p>
        <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">Resource key: {{ $key ?? '-' }}</p>
    </div>
@endsection
