<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ویرایش پست
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">

            {{-- ===== Edit Form ===== --}}
            <form action="{{ $vm->updateRoute() }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">عنوان</label>
                    <input type="text" name="title" value="{{ old('title', $vm->title()) }}"
                        class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">محتوا</label>
                    <textarea name="content" rows="6" class="w-full border rounded px-3 py-2">{{ old('content', $vm->content()) }}</textarea>
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ $vm->indexRoute() }}" class="px-4 py-2 bg-gray-400 text-white rounded">
                        انصراف
                    </a>

                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        ذخیره
                    </button>
                </div>
            </form>

            {{-- ===== Workflow Actions ===== --}}
            <div class="flex gap-2 mb-6">

                @if ($vm->canSubmit())
                    <form action="{{ route('posts.submit', $vm->post()) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                            ارسال برای بررسی
                        </button>
                    </form>
                @endif

                @if ($vm->canPublish())
                    <form action="{{ route('posts.publish', $vm->post()) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                            انتشار
                        </button>
                @endif

            </div>

        </div>
    </div>
</x-app-layout>
