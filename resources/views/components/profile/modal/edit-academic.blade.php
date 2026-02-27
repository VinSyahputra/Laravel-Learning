<x-ui.modal x-data="{ open: false }" @open-profile-academic-modal.window="open = true" :isOpen="false" class="max-w-[700px]">
    @if ($errors->hasAny(['entries', 'entries.*', 'entries.*.institution', 'entries.*.degree', 'entries.*.field', 'entries.*.year_start', 'entries.*.year_end']))
        <script>document.addEventListener('alpine:init', () => { setTimeout(() => window.dispatchEvent(new CustomEvent('open-profile-academic-modal')), 50) })</script>
    @endif
    <div
        class="no-scrollbar relative w-full max-w-[700px] overflow-y-auto rounded-3xl bg-white p-4 dark:bg-gray-900 lg:p-11">
        <div class="px-2 pr-14">
            <h4 class="mb-2 text-2xl font-semibold text-gray-800 dark:text-white/90">
                Edit Academic History
            </h4>
            <p class="mb-6 text-sm text-gray-500 dark:text-gray-400 lg:mb-7">
                Add or update your educational background.
            </p>
        </div>
        @php
            $oldEntries = old('entries');
            $academicEntries = $oldEntries
                ? collect($oldEntries)->map(fn($e) => [
                    'institution' => $e['institution'] ?? '',
                    'degree'      => $e['degree']      ?? '',
                    'field'       => $e['field']        ?? '',
                    'year_start'  => $e['year_start']  ?? '',
                    'year_end'    => $e['year_end']    ?? '',
                ])->values()->all()
                : (($data && $data->isNotEmpty())
                    ? $data->map(fn($a) => [
                        'institution' => $a->institution,
                        'degree'      => $a->degree,
                        'field'       => $a->field_of_study,
                        'year_start'  => (string) $a->year_start,
                        'year_end'    => (string) $a->year_end,
                    ])->values()->all()
                    : [['institution' => '', 'degree' => '', 'field' => '', 'year_start' => '', 'year_end' => '']]);
        @endphp
        <form class="flex flex-col" action="{{ route('profile.update') }}" method="POST"
            x-data="academicForm">
            @csrf
            <input type="hidden" name="section" value="academic">
            @if ($errors->hasAny(['entries', 'entries.*', 'entries.*.institution', 'entries.*.degree']))
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
                            <div class="col-span-2">
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Institution</label>
                                <input type="text" x-model="entry.institution" :name="`entries[${index}][institution]`" placeholder="e.g. Harvard University"
                                    class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                            </div>

                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Degree</label>
                                <select x-model="entry.degree" :name="`entries[${index}][degree]`"
                                    class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-800">
                                    <option value="">Select degree</option>
                                    <option value="High School">High School</option>
                                    <option value="Diploma">Diploma</option>
                                    <option value="Associate">Associate</option>
                                    <option value="Bachelor">Bachelor</option>
                                    <option value="Master">Master</option>
                                    <option value="Doctorate">Doctorate</option>
                                    <option value="Certificate">Certificate</option>
                                </select>
                            </div>

                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Field of Study</label>
                                <input type="text" x-model="entry.field" :name="`entries[${index}][field]`" placeholder="e.g. Computer Science"
                                    class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                            </div>

                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Start Year</label>
                                <input type="number" x-model="entry.year_start" :name="`entries[${index}][year_start]`" placeholder="e.g. 2018" min="1900" :max="new Date().getFullYear()"
                                    class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                            </div>

                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">End Year</label>
                                <input type="number" x-model="entry.year_end" :name="`entries[${index}][year_end]`" placeholder="e.g. 2022 or leave blank if ongoing" min="1900" :max="new Date().getFullYear() + 10"
                                    class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
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
                    Add Another Education
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
        Alpine.data('academicForm', () => ({
            entries: @json($academicEntries),
            addEntry() {
                this.entries.push({ institution: '', degree: '', field: '', year_start: '', year_end: '' });
            },
            removeEntry(index) {
                if (this.entries.length > 1) this.entries.splice(index, 1);
            }
        }));
    });
</script>
