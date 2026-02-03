<x-admin-layout>
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">➕ ایجاد کاربر جدید</h1>

        {{-- Errors --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.users.store') }}" method="POST" class="flex flex-col gap-6">
            @csrf

            {{-- Name --}}
            <div>
                <label class="block mb-1 font-semibold">نام</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2"
                    placeholder="نام کاربر">
            </div>

            {{-- Email --}}
            <div>
                <label class="block mb-1 font-semibold">ایمیل</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded px-3 py-2"
                    placeholder="email@example.com">
            </div>

            {{-- Password --}}
            <div>
                <label class="block mb-1 font-semibold">رمز عبور</label>
                <input type="password" name="password" class="w-full border rounded px-3 py-2"
                    placeholder="حداقل ۸ کاراکتر">
            </div>

            {{-- Password Confirmation --}}
            <div>
                <label class="block mb-1 font-semibold">تکرار رمز عبور</label>
                <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2">
            </div>

            {{-- Roles Dropdown --}}
            <div x-data="{
                open: false,
                selected: @js(old('roles', []))
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

            {{-- Buttons --}}
            <div class="flex gap-3 pt-4">
                <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    💾 ذخیره
                </button>

                <a href="{{ route('admin.users.index') }}" class="px-5 py-2 bg-gray-300 rounded hover:bg-gray-400">
                    بازگشت
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>
