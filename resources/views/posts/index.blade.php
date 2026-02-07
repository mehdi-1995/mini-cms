<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            پست‌ها
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-end mb-4">
            @if ($vm->canCreate())
                <a href="{{ $vm->createRoute() }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    ایجاد پست جدید
                </a>
            @endif
        </div>

        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">عنوان
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            نویسنده</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            وضعیت</th>
                        @if ($vm->canManagePosts())
                            <th
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                عملیات
                            </th>
                        @else
                            <th
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            </th>
                        @endif
                    </tr>
                </thead>
                <tbody id="posts-body" class="bg-white divide-y divide-gray-200">
                    @foreach ($rows as $row)
                        <tr>
                            <td class="px-6 py-4 text-right">{{ $row->title() }}</td>
                            <td class="px-6 py-4 text-right">{{ $row->authorName() }}</td>
                            <td class="px-6 py-4 text-right">
                                @if ($row->isPublished())
                                    <span class="text-green-600 font-semibold">منتشر شده</span>
                                @else
                                    <span class="text-red-600 font-semibold">پیش‌نویس</span>
                                @endif
                            </td>
                            @if ($vm->canManagePosts())
                                @if ($row->canUpdate())
                                    <td class="px-6 py-4 text-center space-x-2">
                                        <a href="{{ $row->editRoute() }}"
                                            class="px-2 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500">ویرایش</a>
                                        <form action="{{ $row->destroyRoute() }}" method="POST"
                                            class="inline-block" onsubmit="return confirm('آیا مطمئن هستید؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700">حذف</button>
                                        </form>
                                    </td>
                                @endif
                            @else
                                <td class="px-6 py-4 text-center text-gray-300">—</td>
                            @endif
                        </tr>
                    @endforeach
                    @if ($posts->isEmpty())
                        <tr>
                            <td colspan="4" class="text-center py-4 text-gray-500">هیچ پستی وجود ندارد.</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            {{-- Load More (AJAX) — غیرفعال شده، pagination شماره‌ای برای پنل ادمین مناسب‌تر است --}}
            {{-- @if ($posts->hasMorePages())
                <div class="flex justify-center mt-8">
                    <button id="load-more" data-next-page="{{ $posts->currentPage() + 1 }}"
                        class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                        نمایش بیشتر
                    </button>
                </div>
            @endif --}}

            <div class="flex flex-col items-center mt-4 gap-3">
                {{-- {{ $vm->paginator()->links('pagination::simple-tailwind') }} --}}
                {{ $vm->paginator()->links('vendor.pagination.custom') }}
            </div>

        </div>
    </div>

    {{-- Load More (AJAX) — غیرفعال شده، pagination شماره‌ای برای پنل ادمین مناسب‌تر است --}}
    {{-- <script>
        document.getElementById('load-more')?.addEventListener('click', function() {
            const button = this;
            const page = button.dataset.nextPage;

            // UX: جلوگیری از کلیک مجدد
            button.disabled = true;
            const originalText = button.textContent;
            button.textContent = 'در حال بارگذاری...';

            fetch(`?page=${page}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');

                    const newRows = doc.querySelectorAll('#posts-body tr');
                    const tbody = document.getElementById('posts-body');

                    newRows.forEach(row => {
                        row.classList.add('fade-in');
                        tbody.appendChild(row);
                    });

                    // دکمه صفحه بعد
                    const newButton = doc.getElementById('load-more');

                    if (newButton) {
                        button.dataset.nextPage = newButton.dataset.nextPage;
                        button.disabled = false;
                        button.textContent = originalText;
                    } else {
                        button.outerHTML =
                            '<span class="text-gray-500 mt-4 block">پست دیگری وجود ندارد</span>';
                    }
                })
                .catch(() => {
                    button.disabled = false;
                    button.textContent = originalText;
                    alert('خطا در دریافت اطلاعات');
                });
        });
    </script> --}}

</x-app-layout>
