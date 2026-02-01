<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            داشبورد
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- کارت‌های آمار --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <div class="bg-white shadow rounded-lg p-5 text-center hover:scale-105 transition">
                <h3 class="text-lg font-semibold mb-2">کل پست‌ها</h3>
                <p class="text-3xl font-bold text-blue-600">{{ $totalPosts }}</p>
            </div>

            <div class="bg-white shadow rounded-lg p-5 text-center hover:scale-105 transition">
                <h3 class="text-lg font-semibold mb-2">پست‌های منتشر شده</h3>
                <p class="text-3xl font-bold text-green-600">{{ $publishedPosts }}</p>
            </div>

            <div class="bg-white shadow rounded-lg p-5 text-center hover:scale-105 transition">
                <h3 class="text-lg font-semibold mb-2">پست‌های پیش‌نویس</h3>
                <p class="text-3xl font-bold text-red-600">{{ $draftPosts }}</p>
            </div>

            <div class="bg-white shadow rounded-lg p-5 text-center hover:scale-105 transition">
                <h3 class="text-lg font-semibold mb-2">کل کاربران</h3>
                <p class="text-3xl font-bold text-purple-600">{{ $totalUsers }}</p>
            </div>
        </div>

        {{-- خوش آمدگویی --}}
        <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
            <h3 class="text-lg font-medium mb-4">خوش آمدید {{ Auth::user()->name ?? '' }}</h3>
            <p>این داشبورد اصلی پروژه شما است. از منوی بالا می‌توانید به مدیریت پست‌ها و سایر امکانات دسترسی داشته
                باشید.</p>
        </div>

        {{-- دکمه ایجاد پست جدید --}}
        <div class="flex justify-between mb-4">
            <a href="{{ route('home') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">
                صفحه اصلی
            </a>

            <a href="{{ route('posts.create') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                ایجاد پست جدید
            </a>
        </div>

        {{-- آخرین پست‌ها --}}
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">آخرین پست‌ها</h3>

            @if ($latestPosts->isEmpty())
                <p class="text-gray-500">هیچ پستی وجود ندارد.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    عنوان</th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    وضعیت</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    عملیات</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($latestPosts as $post)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-right">{{ $post->title }}</td>
                                    <td class="px-6 py-4 text-right">
                                        @if ($post->published)
                                            <span class="text-green-600 font-semibold">منتشر شده</span>
                                        @else
                                            <span class="text-red-600 font-semibold">پیش‌نویس</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center space-x-2">
                                        <a href="{{ route('posts.edit', $post->id) }}"
                                            class="px-2 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500">ویرایش</a>
                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                            class="inline-block" onsubmit="return confirm('آیا مطمئن هستید؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700">حذف</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
