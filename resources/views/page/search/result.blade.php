<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4 text-gray-800">
            Hasil Pencarian:
            <span class="text-green-600">"{{ $query }}"</span>
        </h1>

        @if ($results->isEmpty())
            <div class="bg-yellow-100 text-yellow-800 p-4 rounded-lg">
                Tidak ada hasil yang ditemukan untuk kata kunci
                <strong>"{{ $query }}"</strong>.
            </div>
        @else
            <div class="grid gap-4">
                @foreach ($results as $result)
                    <a href="{{ $result->link }}"
                        class="block border border-gray-200 hover:border-green-400 rounded-lg p-4 shadow-sm hover:shadow-md transition duration-200 bg-white">
                        <div class="flex justify-between items-center mb-2">
                            <h2 class="font-semibold text-lg text-gray-800">{{ $result->title }}</h2>
                            <span
                                class="text-xs px-2 py-1 rounded-full bg-green-100 text-green-700">{{ $result->category }}</span>
                        </div>
                        <p class="text-sm text-gray-600">{{ $result->detail ?? '-' }}</p>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
    
</x-app-layout>
