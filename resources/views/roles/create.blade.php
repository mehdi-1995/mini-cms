<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ایجاد نقش جدید
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <form action="{{ route('admin.roles.store') }}" method="POST">
                @csrf

                {{-- نام نقش --}}
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-medium mb-2">نام نقش</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                        dir="auto" required>
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- دسترسی‌ها --}}
                {{-- <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">دسترسی‌ها</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2">
                        @foreach ($permissions as $permission)
                            <label class="inline-flex items-center space-x-2">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                    class="form-checkbox h-4 w-4 text-blue-600">
                                <span class="text-gray-700">{{ $permission->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div> --}}

                {{-- انتخاب گارد --}}
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">گارد</label>
                    <select name="guard_name" id="guard-select" required
                        class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-500">
                        <option value="">انتخاب گارد</option>
                        @foreach ($guards as $guard)
                            <option value="{{ $guard }}">{{ $guard }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- دسترسی‌ها --}}
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">
                        دسترسی‌ها
                    </label>

                    <div id="permissions-box"
                        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2 text-sm text-gray-500">
                        ابتدا یک گارد انتخاب کنید
                    </div>
                </div>

                {{-- دکمه‌ها --}}
                <div class="flex justify-end gap-2">
                    <a href="{{ route('admin.roles.index') }}"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition">بازگشت</a>
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">ایجاد
                        نقش</button>
                </div>
            </form>
        </div>
    </div>


    {{-- JS --}}
    <script>
        const guardSelect = document.getElementById('guard-select');
        const permissionsBox = document.getElementById('permissions-box');

        guardSelect.addEventListener('change', async function() {
            const guard = this.value;
            permissionsBox.innerHTML = 'در حال بارگذاری...';

            if (!guard) {
                permissionsBox.innerHTML = 'ابتدا یک گارد انتخاب کنید';
                return;
            }

            const response = await fetch(
                `{{ route('admin.roles.permissions', ':guard') }}`
                .replace(':guard', guard)
            );

            const permissions = await response.json();

            if (permissions.length === 0) {
                permissionsBox.innerHTML = 'هیچ دسترسی‌ای برای این گارد وجود ندارد';
                return;
            }

            permissionsBox.innerHTML = '';

            permissions.forEach(permission => {
                permissionsBox.innerHTML += `
                    <label class="inline-flex items-center space-x-2">
                        <input
                            type="checkbox"
                            name="permissions[]"
                            value="${permission.name}"
                            class="form-checkbox h-4 w-4 text-blue-600"
                        >
                        <span>${permission.name}</span>
                    </label>
                `;
            });
        });
    </script>

</x-admin-layout>
