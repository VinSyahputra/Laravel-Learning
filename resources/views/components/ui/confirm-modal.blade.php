<div
    x-data="{
        open: false,
        action: '',
        title: '',
        message: '',
        confirm(action, title, message) {
            this.action = action;
            this.title = title;
            this.message = message;
            this.open = true;
        }
    }"
    @confirm-delete.window="confirm($event.detail.action, $event.detail.title, $event.detail.message)"
    x-show="open"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-[9998] flex items-center justify-center"
    style="display: none;">

    <!-- Backdrop -->
    <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" @click="open = false"></div>

    <!-- Modal -->
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="relative z-10 w-full max-w-sm rounded-2xl bg-white p-8 shadow-xl dark:bg-gray-900">

        <!-- Icon -->
        <div class="mb-5 flex justify-center">
            <div class="flex h-14 w-14 items-center justify-center rounded-full bg-red-100 dark:bg-red-500/10">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                    class="text-red-500">
                    <path d="M3 6h18M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6M10 11v6M14 11v6M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                </svg>
            </div>
        </div>

        <!-- Title -->
        <h4 class="mb-2 text-center text-xl font-semibold text-gray-800 dark:text-white/90"
            x-text="title">
        </h4>

        <!-- Message -->
        <p class="mb-7 text-center text-sm text-gray-500 dark:text-gray-400"
            x-text="message">
        </p>

        <!-- Buttons -->
        <div class="flex items-center justify-center gap-3">
            <button @click="open = false" type="button"
                class="flex w-full justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03]">
                Cancel
            </button>
            <form :action="action" method="POST" x-ref="deleteForm">
                @csrf
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit"
                    class="flex w-full justify-center rounded-lg bg-red-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-red-600">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>
