@if (session('success') || session('error'))
<div
    x-data="{
        show: true,
        type: '{{ session('error') ? 'error' : 'success' }}',
        message: '{{ session('error') ?? session('success') }}',
        progress: 100,
        timer: null,
        init() {
            this.timer = setInterval(() => {
                this.progress -= (100 / 50);
                if (this.progress <= 0) {
                    this.close();
                }
            }, 100);
        },
        close() {
            clearInterval(this.timer);
            this.show = false;
        }
    }"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-4"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-4"
    class="fixed bottom-6 right-6 z-[9999] w-full max-w-sm overflow-hidden rounded-2xl shadow-lg border"
    :class="{
        'bg-white dark:bg-gray-900 border-green-200 dark:border-green-800': type === 'success',
        'bg-white dark:bg-gray-900 border-red-200 dark:border-red-800': type === 'error'
    }"
>
    <div class="flex items-start gap-3 p-4">
        <!-- Icon -->
        <div class="mt-0.5 flex-shrink-0 flex h-8 w-8 items-center justify-center rounded-full"
            :class="{
                'bg-green-100 dark:bg-green-900/40': type === 'success',
                'bg-red-100 dark:bg-red-900/40': type === 'error'
            }">
            <!-- Success icon -->
            <svg x-show="type === 'success'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                class="text-green-500">
                <path d="M20 6 9 17l-5-5"/>
            </svg>
            <!-- Error icon -->
            <svg x-show="type === 'error'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                class="text-red-500">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" x2="12" y1="8" y2="12"/>
                <line x1="12" x2="12.01" y1="16" y2="16"/>
            </svg>
        </div>

        <!-- Content -->
        <div class="flex-1 min-w-0">
            <p class="text-sm font-semibold"
                :class="{
                    'text-green-700 dark:text-green-400': type === 'success',
                    'text-red-700 dark:text-red-400': type === 'error'
                }"
                x-text="type === 'success' ? 'Success' : 'Error'">
            </p>
            <p class="mt-0.5 text-sm text-gray-600 dark:text-gray-400" x-text="message"></p>
        </div>

        <!-- Close button -->
        <button @click="close()" type="button"
            class="flex-shrink-0 ml-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 6 6 18M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <!-- Progress bar -->
    <div class="h-1 w-full"
        :class="{
            'bg-green-100 dark:bg-green-900/30': type === 'success',
            'bg-red-100 dark:bg-red-900/30': type === 'error'
        }">
        <div class="h-full transition-all duration-100"
            :class="{
                'bg-green-500': type === 'success',
                'bg-red-500': type === 'error'
            }"
            :style="'width: ' + progress + '%'">
        </div>
    </div>
</div>
@endif
