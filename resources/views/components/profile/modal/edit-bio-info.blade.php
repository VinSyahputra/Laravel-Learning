<x-ui.modal x-data="{ open: false }" @open-profile-bio-modal.window="open = true" :isOpen="false" class="max-w-[700px]">
    @if ($errors->hasAny(['name', 'gender', 'birth_date', 'phone_dial_code', 'phone_number', 'identity_card_number', 'bio', 'email']))
        <script>document.addEventListener('alpine:init', () => { setTimeout(() => window.dispatchEvent(new CustomEvent('open-profile-bio-modal')), 50) })</script>
    @endif
    <div
        class="no-scrollbar relative w-full max-w-[700px] overflow-y-auto rounded-3xl bg-white p-4 dark:bg-gray-900 lg:p-11">
        <div class="px-2 pr-14">
            <h4 class="mb-2 text-2xl font-semibold text-gray-800 dark:text-white/90">
                Edit Bio Information
            </h4>
            <p class="mb-6 text-sm text-gray-500 dark:text-gray-400 lg:mb-7">
                Update your personal details to keep your profile up-to-date.
            </p>
        </div>
        <form class="flex flex-col" action="{{ route('profile.update') }}" method="POST">
            @csrf
            <input type="hidden" name="section" value="bio">
            <div class="custom-scrollbar overflow-y-auto p-2">
                <div class="grid grid-cols-1 gap-x-6 gap-y-5 lg:grid-cols-2">
                    <div class="col-span-2 lg:col-span-1">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Name
                        </label>
                        <input type="text" name="name" value="{{ old('name', $data?->name) }}"
                            class="dark:bg-dark-900 h-11 w-full rounded-lg border {{ $errors->has('name') ? 'border-red-400 focus:ring-red-500/10 focus:border-red-400' : 'border-gray-300 focus:border-brand-300 focus:ring-brand-500/10' }} bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:outline-hidden focus:ring-3 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" value="{{ old('name') }}" />
                        @error('name')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-2 lg:col-span-1">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Identity Card Number
                        </label>
                        <input type="text" name="identity_card_number" value="{{ old('identity_card_number', $data?->identity_card_number) }}"
                            class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border {{ $errors->has('identity_card_number') ? 'border-red-400 focus:ring-red-500/10 focus:border-red-400' : 'border-gray-300 focus:border-brand-300 focus:ring-brand-500/10' }} bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:outline-hidden focus:ring-3 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                        @error('identity_card_number')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-2 lg:col-span-1">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Gender
                        </label>
                        <select name="gender"
                            class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                            <option value="male" @selected(old('gender', $data?->gender) === 'male')>Male</option>
                            <option value="female" @selected(old('gender', $data?->gender) === 'female')>Female</option>
                            <option value="other" @selected(old('gender', $data?->gender) === 'other')>Other</option>
                        </select>
                    </div>

                    <div class="col-span-2 lg:col-span-1">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Birth Date
                        </label>
                        <input type="date" name="birth_date" value="{{ old('birth_date', $data?->birth_date?->format('Y-m-d')) }}"
                            class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border {{ $errors->has('birth_date') ? 'border-red-400 focus:ring-red-500/10 focus:border-red-400' : 'border-gray-300 focus:border-brand-300 focus:ring-brand-500/10' }} bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:outline-hidden focus:ring-3 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                        @error('birth_date')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-2 lg:col-span-1">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Email Address
                        </label>
                        <input type="email" name="email" value="{{ old('email', $data?->email) }}"
                            class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border {{ $errors->has('email') ? 'border-red-400 focus:ring-red-500/10 focus:border-red-400' : 'border-gray-300 focus:border-brand-300 focus:ring-brand-500/10' }} bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:outline-hidden focus:ring-3 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                        @error('email')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-2 lg:col-span-1">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Phone
                        </label>
                        <div class="flex">
                            <select name="phone_dial_code"
                                class="dark:bg-dark-900 h-11 w-[80px] shrink-0 appearance-none rounded-l-lg border border-r-0 border-gray-300 bg-transparent px-3 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-800">
                                @php $activeDial = old('phone_dial_code', $data?->phone_dial_code); @endphp
                                <option value="+1" @selected($activeDial === '+1')>🇺🇸 +1</option>
                                <option value="+7" @selected($activeDial === '+7')>🇷🇺 +7</option>
                                <option value="+20" @selected($activeDial === '+20')>🇪🇬 +20</option>
                                <option value="+27" @selected($activeDial === '+27')>🇿🇦 +27</option>
                                <option value="+30" @selected($activeDial === '+30')>🇬🇷 +30</option>
                                <option value="+31" @selected($activeDial === '+31')>🇳🇱 +31</option>
                                <option value="+32" @selected($activeDial === '+32')>🇧🇪 +32</option>
                                <option value="+33" @selected($activeDial === '+33')>🇫🇷 +33</option>
                                <option value="+34" @selected($activeDial === '+34')>🇪🇸 +34</option>
                                <option value="+36" @selected($activeDial === '+36')>🇭🇺 +36</option>
                                <option value="+39" @selected($activeDial === '+39')>🇮🇹 +39</option>
                                <option value="+40" @selected($activeDial === '+40')>🇷🇴 +40</option>
                                <option value="+41" @selected($activeDial === '+41')>🇨🇭 +41</option>
                                <option value="+43" @selected($activeDial === '+43')>🇦🇹 +43</option>
                                <option value="+44" @selected($activeDial === '+44')>🇬🇧 +44</option>
                                <option value="+45" @selected($activeDial === '+45')>🇩🇰 +45</option>
                                <option value="+46" @selected($activeDial === '+46')>🇸🇪 +46</option>
                                <option value="+47" @selected($activeDial === '+47')>🇳🇴 +47</option>
                                <option value="+48" @selected($activeDial === '+48')>🇵🇱 +48</option>
                                <option value="+49" @selected($activeDial === '+49')>🇩🇪 +49</option>
                                <option value="+51" @selected($activeDial === '+51')>🇵🇪 +51</option>
                                <option value="+52" @selected($activeDial === '+52')>🇲🇽 +52</option>
                                <option value="+54" @selected($activeDial === '+54')>🇦🇷 +54</option>
                                <option value="+55" @selected($activeDial === '+55')>🇧🇷 +55</option>
                                <option value="+56" @selected($activeDial === '+56')>🇨🇱 +56</option>
                                <option value="+57" @selected($activeDial === '+57')>🇨🇴 +57</option>
                                <option value="+60" @selected($activeDial === '+60')>🇲🇾 +60</option>
                                <option value="+61" @selected($activeDial === '+61')>🇦🇺 +61</option>
                                <option value="+62" @selected($activeDial === '+62')>🇮🇩 +62</option>
                                <option value="+63" @selected($activeDial === '+63')>🇵🇭 +63</option>
                                <option value="+64" @selected($activeDial === '+64')>🇳🇿 +64</option>
                                <option value="+65" @selected($activeDial === '+65')>🇸🇬 +65</option>
                                <option value="+66" @selected($activeDial === '+66')>🇹🇭 +66</option>
                                <option value="+81" @selected($activeDial === '+81')>🇯🇵 +81</option>
                                <option value="+82" @selected($activeDial === '+82')>🇰🇷 +82</option>
                                <option value="+84" @selected($activeDial === '+84')>🇻🇳 +84</option>
                                <option value="+86" @selected($activeDial === '+86')>🇨🇳 +86</option>
                                <option value="+90" @selected($activeDial === '+90')>🇹🇷 +90</option>
                                <option value="+91" @selected($activeDial === '+91')>🇮🇳 +91</option>
                                <option value="+92" @selected($activeDial === '+92')>🇵🇰 +92</option>
                                <option value="+93" @selected($activeDial === '+93')>🇦🇫 +93</option>
                                <option value="+94" @selected($activeDial === '+94')>🇱🇰 +94</option>
                                <option value="+95" @selected($activeDial === '+95')>🇲🇲 +95</option>
                                <option value="+98" @selected($activeDial === '+98')>🇮🇷 +98</option>
                                <option value="+212" @selected($activeDial === '+212')>🇲🇦 +212</option>
                                <option value="+213" @selected($activeDial === '+213')>🇩🇿 +213</option>
                                <option value="+216" @selected($activeDial === '+216')>🇹🇳 +216</option>
                                <option value="+218" @selected($activeDial === '+218')>🇱🇾 +218</option>
                                <option value="+220" @selected($activeDial === '+220')>🇬🇲 +220</option>
                                <option value="+221" @selected($activeDial === '+221')>🇸🇳 +221</option>
                                <option value="+234" @selected($activeDial === '+234')>🇳🇬 +234</option>
                                <option value="+254" @selected($activeDial === '+254')>🇰🇪 +254</option>
                                <option value="+255" @selected($activeDial === '+255')>🇹🇿 +255</option>
                                <option value="+256" @selected($activeDial === '+256')>🇺🇬 +256</option>
                                <option value="+260" @selected($activeDial === '+260')>🇿🇲 +260</option>
                                <option value="+263" @selected($activeDial === '+263')>🇿🇼 +263</option>
                                <option value="+351" @selected($activeDial === '+351')>🇵🇹 +351</option>
                                <option value="+352" @selected($activeDial === '+352')>🇱🇺 +352</option>
                                <option value="+353" @selected($activeDial === '+353')>🇮🇪 +353</option>
                                <option value="+354" @selected($activeDial === '+354')>🇮🇸 +354</option>
                                <option value="+358" @selected($activeDial === '+358')>🇫🇮 +358</option>
                                <option value="+380" @selected($activeDial === '+380')>🇺🇦 +380</option>
                                <option value="+381" @selected($activeDial === '+381')>🇷🇸 +381</option>
                                <option value="+385" @selected($activeDial === '+385')>🇭🇷 +385</option>
                                <option value="+386" @selected($activeDial === '+386')>🇸🇮 +386</option>
                                <option value="+420" @selected($activeDial === '+420')>🇨🇿 +420</option>
                                <option value="+421" @selected($activeDial === '+421')>🇸🇰 +421</option>
                                <option value="+966" @selected($activeDial === '+966')>🇸🇦 +966</option>
                                <option value="+971" @selected($activeDial === '+971')>🇦🇪 +971</option>
                                <option value="+972" @selected($activeDial === '+972')>🇮🇱 +972</option>
                                <option value="+973" @selected($activeDial === '+973')>🇧🇭 +973</option>
                                <option value="+974" @selected($activeDial === '+974')>🇶🇦 +974</option>
                                <option value="+975" @selected($activeDial === '+975')>🇧🇹 +975</option>
                                <option value="+976" @selected($activeDial === '+976')>🇲🇳 +976</option>
                                <option value="+977" @selected($activeDial === '+977')>🇳🇵 +977</option>
                            </select>
                            <input type="tel" name="phone_number" value="{{ old('phone_number', $data?->phone_number) }}"
                                class="dark:bg-dark-900 h-11 w-full appearance-none rounded-r-lg border {{ $errors->has('phone_number') ? 'border-red-400 focus:ring-red-500/10 focus:border-red-400' : 'border-gray-300 focus:border-brand-300 focus:ring-brand-500/10' }} bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:outline-hidden focus:ring-3 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800"
                                placeholder="Phone number" />
                        </div>
                        @error('phone_number')
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
