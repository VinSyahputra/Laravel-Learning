@props(['hasBothRoles' => false, 'initialRole' => 'teacher'])

@if($hasBothRoles)
<div
    x-data="{
        role: '{{ $initialRole }}',
        isLoading: false,
        init() {
            // Check sessionStorage for persisted role
            const storedRole = sessionStorage.getItem('active_role');
            if (storedRole && (storedRole === 'teacher' || storedRole === 'student')) {
                this.role = storedRole;
            }
        },
        async switchRole(newRole) {
            if (this.role === newRole || this.isLoading) return;

            this.isLoading = true;

            try {
                const response = await fetch('{{ route('role.switch') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content || '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ role: newRole })
                });

                const data = await response.json();

                if (data.success) {
                    // Store in sessionStorage
                    sessionStorage.setItem('active_role', newRole);
                    this.role = newRole;

                    // Reload page to update sidebar menu
                    window.location.reload();
                } else {
                    console.error('Failed to switch role:', data.message);
                    alert('Failed to switch role. Please try again.');
                }
            } catch (error) {
                console.error('Error switching role:', error);
                alert('Error switching role. Please try again.');
            } finally {
                this.isLoading = false;
            }
        }
    }"
    class="flex items-center justify-center"
>
    <div class="relative bg-gray-200 rounded-full p-1 flex items-center w-[100px] xl:w-[240px]" :class="{ 'opacity-75': isLoading }">

        <!-- Active Background -->
        <div
            class="absolute top-1 bottom-1 w-[50px] xl:w-1/2 bg-white rounded-full shadow transition-all duration-300"
            :class="role === 'teacher' ? 'left-1' : 'left-1/2'"
        ></div>

        <!-- Teacher Button -->
        <button
            @click="switchRole('teacher')"
            class="relative z-10 w-[50px] xl:w-1/2 flex items-center justify-center gap-2 py-2 rounded-full transition"
            :class="role === 'teacher' ? 'text-blue-600 font-semibold' : 'text-gray-500'"
            :disabled="isLoading"
        >
            <!-- Teacher SVG -->
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-5 h-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 14l9-5-9-5-9 5 9 5z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 14l6.16-3.422A12.083 12.083 0 0112 20.055
                    12.083 12.083 0 015.84 10.578L12 14z"/>
            </svg>
            <span class="hidden xl:block">Teacher</span>
        </button>

        <!-- Student Button -->
        <button
            @click="switchRole('student')"
            class="relative z-10 w-[50px] xl:w-1/2 flex items-center justify-center gap-2 py-2 rounded-full transition"
            :class="role === 'student' ? 'text-green-600 font-semibold' : 'text-gray-500'"
            :disabled="isLoading"
        >
            <!-- Student SVG -->
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-5 h-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5.121 17.804A9 9 0 1118.364 4.56
                    9 9 0 015.12 17.804z"/>
            </svg>
            <span class="hidden xl:block">Student</span>
        </button>

    </div>
</div>
@endif
