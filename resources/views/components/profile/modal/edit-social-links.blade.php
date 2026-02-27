<x-ui.modal x-data="{ open: false }" @open-profile-social-modal.window="open = true" :isOpen="false" class="max-w-[700px]">
    @if ($errors->hasAny(['facebook_url', 'x_url', 'linkedin_url', 'instagram_url']))
        <script>document.addEventListener('alpine:init', () => { setTimeout(() => window.dispatchEvent(new CustomEvent('open-profile-social-modal')), 50) })</script>
    @endif
    <div
        class="no-scrollbar relative w-full max-w-[700px] overflow-y-auto rounded-3xl bg-white p-4 dark:bg-gray-900 lg:p-11">
        <div class="px-2 pr-14">
            <h4 class="mb-2 text-2xl font-semibold text-gray-800 dark:text-white/90">
                Edit Social Links
            </h4>
            <p class="mb-6 text-sm text-gray-500 dark:text-gray-400 lg:mb-7">
                Update your social media links.
            </p>
        </div>
        <form class="flex flex-col" action="{{ route('profile.update') }}" method="POST">
            @csrf
            <input type="hidden" name="section" value="social">
            <div class="custom-scrollbar overflow-y-auto p-2">
                <div class="grid grid-cols-1 gap-x-6 gap-y-5 lg:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Facebook
                        </label>
                        <input type="text" name="facebook_url" value="{{ old('facebook_url', $data?->facebook_url) }}"
                            class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border {{ $errors->has('facebook_url') ? 'border-red-400 focus:ring-red-500/10 focus:border-red-400' : 'border-gray-300 focus:border-brand-300 focus:ring-brand-500/10' }} bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:outline-hidden focus:ring-3 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                        @error('facebook_url')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            X.com
                        </label>
                        <input type="text" name="x_url" value="{{ old('x_url', $data?->x_url) }}"
                            class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border {{ $errors->has('x_url') ? 'border-red-400 focus:ring-red-500/10 focus:border-red-400' : 'border-gray-300 focus:border-brand-300 focus:ring-brand-500/10' }} bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:outline-hidden focus:ring-3 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                        @error('x_url')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Linkedin
                        </label>
                        <input type="text" name="linkedin_url" value="{{ old('linkedin_url', $data?->linkedin_url) }}"
                            class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border {{ $errors->has('linkedin_url') ? 'border-red-400 focus:ring-red-500/10 focus:border-red-400' : 'border-gray-300 focus:border-brand-300 focus:ring-brand-500/10' }} bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:outline-hidden focus:ring-3 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                        @error('linkedin_url')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Instagram
                        </label>
                        <input type="text" name="instagram_url" value="{{ old('instagram_url', $data?->instagram_url) }}"
                            class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border {{ $errors->has('instagram_url') ? 'border-red-400 focus:ring-red-500/10 focus:border-red-400' : 'border-gray-300 focus:border-brand-300 focus:ring-brand-500/10' }} bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:outline-hidden focus:ring-3 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                        @error('instagram_url')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3 px-2 mt-6 lg:justify-end">
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
