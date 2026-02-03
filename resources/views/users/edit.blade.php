<x-admin-layout>
    <div class="max-w-4xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold mb-6">✏️ ویرایش کاربر</h1>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block mb-1 font-semibold">نام</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block mb-1 font-semibold">ایمیل</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="w-full border rounded px-3 py-2">
            </div>

            <div x-data="{ resetPassword: false }" class="space-y-4">
                <label class="flex items-center gap-2 font-semibold cursor-pointer">
                    <input type="checkbox" x-model="resetPassword">
                    تنظیم رمز عبور جدید
                </label>

                <div x-show="resetPassword" x-transition class="space-y-4">
                    <div>
                        <label class="block mb-1 text-sm">رمز عبور جدید</label>
                        <input type="password" name="password" autocomplete="new-password"
                            class="w-full border rounded px-3 py-2">
                    </div>

                    <div>
                        <label class="block mb-1 text-sm">تکرار رمز عبور جدید</label>
                        <input type="password" name="password_confirmation" autocomplete="new-password"
                            class="w-full border rounded px-3 py-2">
                    </div>
                </div>
            </div>

            <div x-data="{
                open: false,
                selected: @js(old('roles', $user->roles->pluck('name')->toArray()))
            }" class="relative">
                <label class="block mb-1 font-semibold">نقش‌ها</label>

                <button type="button" @click="open = !open"
                    class="w-full border rounded px-3 py-2 text-right bg-white flex justify-between items-center">
                    <span x-text="selected.length ? selected.join(' , ') : 'انتخاب نقش‌ها'"></span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="open" @click.outside="open = false"
                    class="mt-2 w-full bg-white border rounded shadow max-h-52 overflow-y-auto">
                    @foreach ($roles as $role)
                        <label class="flex items-center px-3 py-2 hover:bg-gray-100 cursor-pointer">
                            <input type="checkbox" class="ml-2" value="{{ $role->name }}" name="roles[]"
                                :checked="selected.includes('{{ $role->name }}')"
                                @change="
                        if ($event.target.checked) {
                            selected.push('{{ $role->name }}')
                        } else {
                            selected = selected.filter(r => r !== '{{ $role->name }}')
                        }
                    ">
                            {{ $role->name }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex gap-3">
                <button class="px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    💾 بروزرسانی
                </button>
                <a href="{{ route('admin.users.index') }}" class="px-5 py-2 bg-gray-300 rounded">بازگشت</a>
            </div>
        </form>
    </div>
</x-admin-layout>
