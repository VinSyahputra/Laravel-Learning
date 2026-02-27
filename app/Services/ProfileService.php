<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserAcademic;
use App\Models\UserExperience;
use Illuminate\Support\Facades\Hash;

class ProfileService
{

    /**
    * Retrieves all profile-related data for the given user.
    */

    public function getProfileData(User $user): array
    {
        $user->loadMissing(['profile', 'socialLinks', 'address', 'academics', 'experiences']);

        // Attach user-table fields onto the profile model so views have one source
        $profile = $user->profile ?? new \App\Models\UserProfile();
        $profile->name  = $user->name;
        $profile->email = $user->email;

        return [
            'user'         => $user,
            'profile'      => $profile,
            'social_links' => $user->socialLinks,
            'address'      => $user->address,
            'academics'    => $user->academics->sortBy('sort_order')->values(),
            'experiences'  => $user->experiences->sortBy('sort_order')->values(),
        ];
    }

    /**
     * Dispatch update to the correct section handler based on the section key.
     */
    public function update(User $user, string $section, array $data): void
    {
        match ($section) {
            'bio'        => $this->updateBio($user, $data),
            'social'     => $this->updateSocial($user, $data),
            'address'    => $this->updateAddress($user, $data),
            'academic'   => $this->updateAcademic($user, $data),
            'experience' => $this->updateExperience($user, $data),
            'account'    => $this->updatePassword($user, $data),
            default      => throw new \InvalidArgumentException("Unknown profile section: {$section}"),
        };
    }


    /**
     * Bio: updates users.name + user_profiles row.
     */
    private function updateBio(User $user, array $data): void
    {
        $user->update(['name' => $data['name']]);

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'gender'               => $data['gender']               ?? null,
                'birth_date'           => $data['birth_date']           ?? null,
                'phone_dial_code'      => $data['phone_dial_code']      ?? null,
                'phone_number'         => $data['phone_number']         ?? null,
                'identity_card_number' => $data['identity_card_number'] ?? null,
                'bio'                  => $data['bio']                  ?? null,
            ]
        );
    }

    /**
     * Social: updates user_social_links row.
     */
    private function updateSocial(User $user, array $data): void
    {
        $user->socialLinks()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'facebook_url'  => $data['facebook_url']  ?? null,
                'x_url'         => $data['x_url']         ?? null,
                'linkedin_url'  => $data['linkedin_url']  ?? null,
                'instagram_url' => $data['instagram_url'] ?? null,
            ]
        );
    }

    /**
     * Address: updates user_addresses row.
     */
    private function updateAddress(User $user, array $data): void
    {
        $user->address()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'country'     => $data['country']     ?? null,
                'city_state'  => $data['city_state']  ?? null,
                'postal_code' => $data['postal_code'] ?? null,
                'tax_id'      => $data['tax_id']      ?? null,
            ]
        );
    }

    /**
     * Academic: replaces all rows for this user with the submitted entries.
     * Accepts entries[] array from the multi-row form.
     */
    private function updateAcademic(User $user, array $data): void
    {
        $user->academics()->delete();

        foreach ($data['entries'] ?? [] as $index => $entry) {
            UserAcademic::create([
                'user_id'       => $user->id,
                'institution'   => $entry['institution']   ?? '',
                'degree'        => $entry['degree']        ?? '',
                'field_of_study'=> $entry['field']         ?? null,
                'year_start'    => $entry['year_start']    ?? null,
                'year_end'      => $entry['year_end']      ?? null,
                'sort_order'    => $index,
            ]);
        }
    }

    /**
     * Experience: replaces all rows for this user with the submitted entries.
     * Accepts entries[] array from the multi-row form.
     */
    private function updateExperience(User $user, array $data): void
    {
        $user->experiences()->delete();

        foreach ($data['entries'] ?? [] as $index => $entry) {
            UserExperience::create([
                'user_id'      => $user->id,
                'company'      => $entry['company']      ?? '',
                'job_title'    => $entry['role']         ?? '',
                'period_start' => $entry['period_start'] ? date('Y-m-01', strtotime($entry['period_start'])) : null,
                'period_end'   => (!empty($entry['current'])) ? null : (isset($entry['period_end']) ? date('Y-m-01', strtotime($entry['period_end'])) : null),
                'is_current'   => !empty($entry['current']),
                'description'  => $entry['description']  ?? null,
                'sort_order'   => $index,
            ]);
        }
    }

    /**
     * Account: updates user password after verifying current password.
     */
    private function updatePassword(User $user, array $data): void
    {
        $user->update([
            'password' => Hash::make($data['new_password']),
        ]);
    }
}
