<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            پست‌ها
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-end mb-4">
            <a href="{{ route('posts.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
               ایجاد پست جدید
            </a>
        </div>

        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">عنوان</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">نویسنده</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">وضعیت</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">عملیات</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($posts as $post)
                        <tr>
                            <td class="px-6 py-4 text-right">{{ $post->title }}</td>
                            <td class="px-6 py-4 text-right">{{ $post->user->name ?? 'نامشخص' }}</td>
                            <td class="px-6 py-4 text-right">
                                @if($post->published)
                                    <span class="text-green-600 font-semibold">منتشر شده</span>
                                @else
                                    <span class="text-red-600 font-semibold">پیش‌نویس</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center space-x-2">
                                <a href="{{ route('posts.edit', $post->id) }}" class="px-2 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500">ویرایش</a>
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline-block" onsubmit="return confirm('آیا مطمئن هستید؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @if($posts->isEmpty())
                        <tr>
                            <td colspan="4" class="text-center py-4 text-gray-500">هیچ پستی وجود ندارد.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
