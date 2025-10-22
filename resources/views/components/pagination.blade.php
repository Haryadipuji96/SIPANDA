@if ($data->hasPages())
    <div class="mt-6 flex flex-col sm:flex-row justify-between items-center gap-3 text-sm text-gray-600">
        <div>
            Menampilkan {{ $data->firstItem() }} - {{ $data->lastItem() }} dari {{ $data->total() }} data
        </div>

        <div>
            {{ $data->onEachSide(1)->links('pagination::tailwind') }}
        </div>
    </div>
@endif
