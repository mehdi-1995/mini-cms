<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ایجاد پست جدید
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <form action="{{ $vm->storeRout() }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 font-medium mb-2">عنوان</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label for="content" class="block text-gray-700 font-medium mb-2">محتوا</label>
                    <textarea name="content" id="content" rows="6"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('content') }}</textarea>
                </div>

                <div class="flex justify-end">
                    <a href="{{ $vm->indexRout() }}"
                        class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500 ml-2">انصراف</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">💾
                      ذخیره به عنوان پیش نویس </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
