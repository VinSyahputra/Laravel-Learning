@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="User Profile" />
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
        <h3 class="mb-5 text-lg font-semibold text-gray-800 dark:text-white/90 lg:mb-7">Profile</h3>
        <x-profile.profile-card :data="$data_bio" :user="$data_account" />
        <x-profile.personal-info-card :data="$data_bio" />
        <x-profile.address-card :data="$data_address" />
        <x-profile.academic-card :data="$data_academic" />
        <x-profile.experience-card :data="$data_experience" />
        <x-profile.account-card :data="$data_account" />
    </div>
@endsection
