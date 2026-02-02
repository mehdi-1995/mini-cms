<x-base-layout>
    <div class="min-h-screen flex">
        <aside class="w-64 bg-gray-900 text-white p-4">
            <h2 class="text-xl font-bold mb-4">Admin Panel</h2>

            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="block hover:bg-gray-700 p-2 rounded">Dashboard</a>
                <a href="{{ route('admin.roles.index') }}" class="block hover:bg-gray-700 p-2 rounded">Roles</a>
                <a href="{{ route('admin.users.index') }}" class="block hover:bg-gray-700 p-2 rounded">Users</a>
            </nav>

            <form method="POST" action="{{ route('admin.logout') }}" class="mt-6">
                @csrf
                <button class="w-full bg-red-600 p-2 rounded">Logout</button>
            </form>
        </aside>

        <main class="flex-1 p-6">
            {{ $slot }}
        </main>
    </div>
</x-base-layout>
