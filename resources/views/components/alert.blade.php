@php
    if (session()->has('success')) {
        $type = 'success';
    } elseif (session()->has('error')) {
        $type = 'danger';
    } elseif ($errors->any()) {
        $type = 'danger';
    } else {
        $type = $type ?? 'info';
    }

    $colors = [
        'success' => 'bg-green-100 border-green-400 text-green-700',
        'danger' => 'bg-red-100 border-red-400 text-red-700',
        'warning' => 'bg-yellow-100 border-yellow-400 text-yellow-700',
        'info' => 'bg-blue-100 border-blue-400 text-blue-700',
    ];
@endphp

@if (session()->has('success') || session()->has('error') || $errors->any())
    <div {{ $attributes->merge(['class' => "p-4 rounded border {$colors[$type]} mb-4"]) }}>
        @if (session()->has('success'))
            <p>{{ session('success') }}</p>
        @endif

        @if (session()->has('error'))
            <p>{{ session('error') }}</p>
        @endif

        @if ($errors->any())
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
    </div>
@endif
