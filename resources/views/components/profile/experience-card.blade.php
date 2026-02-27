<div x-data="{ saveProfile() { console.log('Saving experience...'); } }">
    <div class="p-5 mb-6 border border-gray-200 rounded-2xl dark:border-gray-800 lg:p-6">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
            <div class="w-full">
                <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90 lg:mb-6">Work Experience</h4>

                <div class="space-y-5">
                    @forelse ($data ?? [] as $item)
                        <div class="flex items-start gap-4 group">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-50 dark:bg-brand-500/10">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="text-brand-500">
                                    <rect width="20" height="14" x="2" y="7" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-800 dark:text-white/90">{{ $item->company }}</p>
                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">{{ $item->job_title }}</p>
                                <p class="mt-0.5 text-xs text-gray-400 dark:text-gray-500">
                                    {{ $item->period_start?->format('M Y') }} –
                                    {{ $item->is_current ? 'Present' : $item->period_end?->format('M Y') }}
                                </p>
                                @if ($item->description)
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $item->description }}</p>
                                @endif
                            </div>
                            <button type="button"
                                @click="$dispatch('confirm-delete', {
                                    action: '{{ route('profile.experience.delete', $item->id) }}',
                                    title: 'Delete Work Experience',
                                    message: 'Are you sure you want to delete {{ addslashes($item->company) }}? This action cannot be undone.'
                                })"
                                class="flex h-8 w-8 items-center justify-center rounded-full text-red-400 hover:bg-red-50 hover:text-red-500 transition-all dark:hover:bg-red-500/10">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 6h18M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6M10 11v6M14 11v6M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                                </svg>
                            </button>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400 dark:text-gray-500">No work experience added yet.</p>
                    @endforelse
                </div>
            </div>

            <button @click="$dispatch('open-profile-experience-modal')"
                class="shadow-theme-xs flex w-full shrink-0 items-center justify-center gap-2 rounded-full border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-800 lg:inline-flex lg:w-auto dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M15.0911 2.78206C14.2125 1.90338 12.7878 1.90338 11.9092 2.78206L4.57524 10.116C4.26682 10.4244 4.0547 10.8158 3.96468 11.2426L3.31231 14.3352C3.25997 14.5833 3.33653 14.841 3.51583 15.0203C3.69512 15.1996 3.95286 15.2761 4.20096 15.2238L7.29355 14.5714C7.72031 14.4814 8.11172 14.2693 8.42013 13.9609L15.7541 6.62695C16.6327 5.74827 16.6327 4.32365 15.7541 3.44497L15.0911 2.78206ZM12.9698 3.84272C13.2627 3.54982 13.7376 3.54982 14.0305 3.84272L14.6934 4.50563C14.9863 4.79852 14.9863 5.2734 14.6934 5.56629L14.044 6.21573L12.3204 4.49215L12.9698 3.84272ZM11.2597 5.55281L5.6359 11.1766C5.53309 11.2794 5.46238 11.4099 5.43238 11.5522L5.01758 13.5185L6.98394 13.1037C7.1262 13.0737 7.25666 13.003 7.35947 12.9002L12.9833 7.27639L11.2597 5.55281Z"
                        fill="" />
                </svg>
                Edit
            </button>
        </div>
    </div>

    <!-- Edit Experience Modal -->
    <x-profile.modal.edit-experience :data="$data" />
</div>
