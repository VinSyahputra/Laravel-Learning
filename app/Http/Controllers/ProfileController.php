<?php

namespace App\Http\Controllers;

use App\Services\ProfileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    public function __construct(
        private readonly ProfileService $profileService,
    ) {}

    public function index()
    {
        $data = $this->profileService->getProfileData(Auth::user());

        return view('pages.profile', [
            'title'           => 'My Information',
            'data_bio'        => $data['profile'],
            'data_social'     => $data['social_links'] ?? null,
            'data_address'    => $data['address'] ?? null,
            'data_academic'   => $data['academics'] ?? null,
            'data_experience' => $data['experiences'] ?? null,
            'data_account'    => $data['user'] ?? null,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $section = $request->input('section');

        $rules = match ($section) {
            'bio' => [
                'name'                  => ['required', 'string', 'max:255'],
                'gender'                => ['nullable', 'in:male,female,other'],
                'birth_date'            => ['nullable', 'date'],
                'phone_dial_code'       => ['nullable', 'string', 'max:10'],
                'phone_number'          => ['nullable', 'string', 'max:20'],
                'identity_card_number'  => ['nullable', 'string', 'max:50'],
                'bio'                   => ['nullable', 'string', 'max:500'],
            ],
            'social' => [
                'facebook_url'  => ['nullable', 'url', 'max:255'],
                'x_url'         => ['nullable', 'url', 'max:255'],
                'linkedin_url'  => ['nullable', 'url', 'max:255'],
                'instagram_url' => ['nullable', 'url', 'max:255'],
            ],
            'address' => [
                'country'     => ['nullable', 'string', 'max:100'],
                'city_state'  => ['nullable', 'string', 'max:150'],
                'postal_code' => ['nullable', 'string', 'max:20'],
                'tax_id'      => ['nullable', 'string', 'max:50'],
            ],
            'academic' => [
                'entries'                  => ['required', 'array', 'min:1'],
                'entries.*.institution'    => ['required', 'string', 'max:255'],
                'entries.*.degree'         => ['required', 'string'],
                'entries.*.field'          => ['nullable', 'string', 'max:150'],
                'entries.*.year_start'     => ['nullable', 'integer', 'digits:4'],
                'entries.*.year_end'       => ['nullable', 'integer', 'digits:4'],
            ],
            'experience' => [
                'entries'                  => ['required', 'array', 'min:1'],
                'entries.*.company'        => ['required', 'string', 'max:255'],
                'entries.*.role'           => ['required', 'string', 'max:150'],
                'entries.*.period_start'   => ['nullable', 'string'],
                'entries.*.period_end'     => ['nullable', 'string'],
                'entries.*.current'        => ['nullable', 'boolean'],
                'entries.*.description'    => ['nullable', 'string', 'max:1000'],
            ],
            'account' => [
                'current_password'          => ['required', 'string', 'current_password'],
                'new_password'              => ['required', 'string', 'confirmed', Password::min(8)],
                'new_password_confirmation' => ['required', 'string'],
            ],
            default => [],
        };

        if (empty($rules)) {
            return back()->withErrors(['section' => 'Unknown profile section.']);
        }

        $validated = $request->validate($rules);

        try {
            $this->profileService->update(Auth::user(), $section, $validated);
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }

        return back()->with('success', 'Profile updated successfully.');
    }

    public function uploadAvatar(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar' => ['required', 'image', 'max:2048'], // Max 2MB
        ]);

        $user = Auth::user();

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');

            // Delete old avatar file if exists
            if ($user->avatar) {
                \Storage::disk('public')->delete($user->avatar);
            }

            $user->update(['avatar' => $avatarPath]);
        }

        return back()->with('success', 'Avatar updated successfully.');
    }

    public function deleteAcademic(int $id): RedirectResponse
    {
        $record = Auth::user()->academics()->findOrFail($id);
        $record->delete();

        return back()->with('success', 'Academic record deleted successfully.');
    }

    public function deleteExperience(int $id): RedirectResponse
    {
        $record = Auth::user()->experiences()->findOrFail($id);
        $record->delete();

        return back()->with('success', 'Work experience deleted successfully.');
    }
}

