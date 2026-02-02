<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ویرایش نقش: {{ $role->name }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <form action="{{ route('admin.roles.update', $role) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- نام نقش --}}
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-medium mb-2">نام نقش</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $role->name) }}"
                        class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- دسترسی‌ها --}}
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">دسترسی‌ها</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2">
                        @foreach ($permissions as $permission)
                            <label class="inline-flex items-center space-x-2">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                    @if ($role->permissions->contains('id', $permission->id)) checked @endif
                                    class="form-checkbox h-4 w-4 text-blue-600">
                                <span class="text-gray-700">{{ $permission->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- دکمه‌ها --}}
                <div class="flex justify-end gap-2">
                    <a href="{{ route('admin.roles.index') }}"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition">بازگشت</a>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">ذخیره
                        تغییرات</button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
