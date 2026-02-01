<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            صفحه اصلی
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- خوش آمدگویی --}}
        <div class="text-center mb-6">
            <h1 class="mb-4 text-2xl font-bold">خوش آمدید به مینی CMS!</h1>
            <p class="mb-4 text-gray-700">این یک سیستم مدیریت محتوا سبک با قابلیت Role و Permission است.</p>

            {{-- دکمه‌های ناوبری --}}
            @auth
                <div class="flex justify-center gap-3 flex-wrap">
                    <a href="{{ route('posts.index') }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">مشاهده پست‌ها</a>
                    <a href="{{ route('dashboard') }}"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">داشبورد</a>
                    <a href="{{ route('home') }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">خانه</a>
                </div>
            @endauth
        </div>

        {{-- کارت‌های دسترسی سریع --}}
        @auth
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white shadow-sm rounded-lg p-6 restaurant-card hover:translate-y-[-3px] transition">
                    <h5 class="text-lg font-semibold mb-2">پست‌ها</h5>
                    <p class="text-gray-600 mb-3">ایجاد، ویرایش و مدیریت پست‌ها</p>
                    <a href="{{ route('posts.index') }}"
                        class="px-3 py-1 border border-blue-600 text-blue-600 rounded hover:bg-blue-50 transition">مشاهده</a>
                </div>

                <div class="bg-white shadow-sm rounded-lg p-6 restaurant-card hover:translate-y-[-3px] transition">
                    <h5 class="text-lg font-semibold mb-2">کاربران</h5>
                    <p class="text-gray-600 mb-3">مدیریت کاربران و نقش‌ها</p>
                    <a href="#"
                        class="px-3 py-1 border border-gray-400 text-gray-400 rounded cursor-not-allowed">مشاهده</a>
                </div>

                <div class="bg-white shadow-sm rounded-lg p-6 restaurant-card hover:translate-y-[-3px] transition">
                    <h5 class="text-lg font-semibold mb-2">تنظیمات</h5>
                    <p class="text-gray-600 mb-3">پیکربندی سیستم و دسترسی‌ها</p>
                    <a href="#"
                        class="px-3 py-1 border border-gray-400 text-gray-400 rounded cursor-not-allowed">مشاهده</a>
                </div>
            </div>
        @endauth
        @guest
            <div class="mt-6">
                <h3 class="text-lg font-semibold mb-4">آخرین پست‌ها</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @forelse ($posts as $post)
                        <div class="bg-white p-4 rounded shadow">
                            <h3 class="font-semibold text-lg mb-2">{{ $post->title }}</h3>
                            <p class="text-gray-600 text-sm mb-2">
                                {{ Str::limit($post->content, 120) }}
                            </p>
                            <a href="{{ route('posts.show', $post) }}" class="text-blue-600 hover:underline">
                                ادامه مطلب
                            </a>
                        </div>
                    @empty
                        <p class="text-gray-500 col-span-3">هیچ پستی برای نمایش وجود ندارد.</p>
                    @endforelse
                </div>

                <div class="mt-6">
                    {{ $posts->links() }}
                </div>
            @endguest
        </div>
</x-app-layout>
