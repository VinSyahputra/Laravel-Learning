<x-ui.modal x-data="{ open: false }" @open-profile-experience-modal.window="open = true" :isOpen="false" class="max-w-[700px]">
    @if ($errors->hasAny(['entries', 'entries.*', 'entries.*.company', 'entries.*.role']))
        <script>document.addEventListener('alpine:init', () => { setTimeout(() => window.dispatchEvent(new CustomEvent('open-profile-experience-modal')), 50) })</script>
    @endif
    <div
        class="no-scrollbar relative w-full max-w-[700px] overflow-y-auto rounded-3xl bg-white p-4 dark:bg-gray-900 lg:p-11">
        <div class="px-2 pr-14">
            <h4 class="mb-2 text-2xl font-semibold text-gray-800 dark:text-white/90">
                Edit Work Experience
            </h4>
            <p class="mb-6 text-sm text-gray-500 dark:text-gray-400 lg:mb-7">
                Add or update your professional experience.
            </p>
        </div>
        @php
            $oldEntries = old('entries');
            $experienceEntries = $oldEntries
                ? collect($oldEntries)->map(fn($e) => [
                    'company'      => $e['company']      ?? '',
                    'role'         => $e['role']          ?? '',
                    'period_start' => $e['period_start'] ?? '',
                    'period_end'   => $e['period_end']   ?? '',
                    'current'      => isset($e['current']) && $e['current'] ? true : false,
                    'description'  => $e['description']  ?? '',
                ])->values()->all()
                : (($data && $data->isNotEmpty())
                    ? $data->map(fn($e) => [
                        'company'      => $e->company,
                        'role'         => $e->job_title,
                        'period_start' => $e->period_start?->format('Y-m'),
                        'period_end'   => $e->period_end?->format('Y-m'),
                        'current'      => (bool) $e->is_current,
                        'description'  => $e->description ?? '',
                    ])->values()->all()
                    : [['company' => '', 'role' => '', 'period_start' => '', 'period_end' => '', 'current' => false, 'description' => '']]);
        @endphp
        <form class="flex flex-col" action="{{ route('profile.update') }}" method="POST"
            x-data="experienceForm">
            @csrf
            <input type="hidden" name="section" value="experience">
            @if ($errors->hasAny(['entries', 'entries.*', 'entries.*.company', 'entries.*.role']))
                <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 dark:border-red-800 dark:bg-red-900/20">
                    <p class="text-sm font-medium text-red-700 dark:text-red-400">Please fix the following errors:</p>
                    <ul class="mt-1 list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li class="text-xs text-red-600 dark:text-red-400">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="custom-scrollbar max-h-[460px] overflow-y-auto px-2 space-y-6">
                <template x-for="(entry, index) in entries" :key="index">
                    <div class="relative rounded-2xl border border-gray-200 p-4 dark:border-gray-700">
                        <!-- Remove button -->
                        <button type="button" @click="removeEntry(index)"
                            x-show="entries.length > 1"
                            class="absolute right-3 top-3 flex h-7 w-7 items-center justify-center rounded-full bg-red-50 text-red-500 hover:bg-red-100 dark:bg-red-500/10 dark:hover:bg-red-500/20">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 6 6 18M6 6l12 12"/>
                            </svg>
                        </button>

                        <div class="grid grid-cols-1 gap-x-6 gap-y-4 lg:grid-cols-2">
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Company / Organisation</label>
                                <input type="text" x-model="entry.company" :name="`entries[${index}][company]`" placeholder="e.g. Google LLC"
                                    class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                            </div>

                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Job Title / Role</label>
                                <input type="text" x-model="entry.role" :name="`entries[${index}][role]`" placeholder="e.g. Software Engineer"
                                    class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                            </div>

                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Start Date</label>
                                <input type="month" x-model="entry.period_start" :name="`entries[${index}][period_start]`"
                                    class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-800" />
                            </div>

                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">End Date</label>
                                <input type="month" x-model="entry.period_end" :name="`entries[${index}][period_end]`" :disabled="entry.current"
                                    class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-800 disabled:opacity-40" />
                                <label class="mt-2 flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400 cursor-pointer">
                                    <input type="checkbox" x-model="entry.current" :name="`entries[${index}][current]`" :value="1" class="rounded border-gray-300 text-brand-500 focus:ring-brand-500 dark:border-gray-700" />
                                    Currently working here
                                </label>
                            </div>

                            <div class="col-span-2">
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Description</label>
                                <textarea x-model="entry.description" :name="`entries[${index}][description]`" rows="3" placeholder="Briefly describe your responsibilities..."
                                    class="dark:bg-dark-900 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800"></textarea>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- Add Entry -->
                <button type="button" @click="addEntry()"
                    class="flex w-full items-center justify-center gap-2 rounded-xl border border-dashed border-gray-300 py-3 text-sm font-medium text-gray-500 hover:border-brand-400 hover:text-brand-500 dark:border-gray-700 dark:text-gray-400 dark:hover:border-brand-500 dark:hover:text-brand-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>
                    Add Another Experience
                </button>
            </div>

            <div class="flex items-center gap-3 mt-6 px-2 lg:justify-end">
                <button @click="open = false" type="button"
                    class="flex w-full justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] sm:w-auto">
                    Close
                </button>
                <button type="submit"
                    class="flex w-full justify-center rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 sm:w-auto">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</x-ui.modal>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('experienceForm', () => ({
            entries: @json($experienceEntries),
            addEntry() {
                this.entries.push({ company: '', role: '', period_start: '', period_end: '', current: false, description: '' });
            },
            removeEntry(index) {
                if (this.entries.length > 1) this.entries.splice(index, 1);
            }
        }));
    });
</script>
