<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ویرایش پست
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <form action="{{ $vm->updateRoute() }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="title" class="block text-gray-700 font-medium mb-2">عنوان</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $vm->title()) }}"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label for="content" class="block text-gray-700 font-medium mb-2">محتوا</label>
                    <textarea name="content" id="content" rows="6"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('content', $vm->content()) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="inline-flex items-center">

                        <input type="checkbox" name="publish_action" value="1" class="form-checkbox">
                        <span class="ml-2 text-gray-700">ارسال برای انتشار</span>

                    </label>
                </div>




                <div class="flex justify-end">
                    <a href="{{ $vm->indexRoute() }}"
                        class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500 ml-2">انصراف</a>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">ذخیره</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
