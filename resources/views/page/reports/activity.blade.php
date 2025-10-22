{{-- <x-app-layout>
    <div class="p-6 max-w-6xl mx-auto bg-white rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">📊 Laporan Aktivitas User</h1>

        <!-- Info Pengguna -->
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            <p><strong>Nama:</strong> {{ auth()->user()->name }}</p>
            <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
            <p><strong>Role:</strong> {{ ucfirst(auth()->user()->role ?? '-') }}</p>
            <p><strong>Login Terakhir:</strong> {{ auth()->user()->last_login_at ? auth()->user()->last_login_at->format('d M Y H:i') : 'Belum pernah login' }}</p>
        </div>

        <!-- Filter -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="font-semibold text-lg">Grafik Aktivitas Login</h2>
            <select id="filter" class="border rounded px-2 py-1 text-sm">
                <option value="weekly">Per Minggu</option>
                <option value="monthly" selected>Per Bulan</option>
            </select>
        </div>

        <!-- Grafik -->
        <canvas id="loginChart" class="w-full h-64"></canvas>

        <!-- Tabel Aktivitas -->
        <h2 class="font-semibold text-lg mt-8 mb-3">Riwayat Login</h2>
        <table class="w-full border border-gray-200 text-sm rounded">
            <thead class="bg-green-600 text-white">
                <tr>
                    <th class="px-3 py-2 border text-left">Tanggal</th>
                    <th class="px-3 py-2 border text-left">Waktu</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $logins = collect([
                        now()->subDays(6),
                        now()->subDays(4),
                        now()->subDays(2),
                        now()
                    ]);
                @endphp

                @foreach ($logins as $login)
                    <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-gray-200' }}">
                        <td class="px-3 py-2 border">{{ $login->format('d M Y') }}</td>
                        <td class="px-3 py-2 border">{{ $login->format('H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('loginChart');
        const filterSelect = document.getElementById('filter');

        const weeklyData = {
            labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            datasets: [{
                label: 'Login per Hari',
                data: [2, 1, 3, 4, 1, 0, 2],
                borderColor: 'rgb(34, 197, 94)',
                backgroundColor: 'rgba(34, 197, 94, 0.2)',
                fill: true,
                tension: 0.3
            }]
        };

        const monthlyData = {
            labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
            datasets: [{
                label: 'Login per Minggu',
                data: [5, 8, 4, 7],
                borderColor: 'rgb(34, 197, 94)',
                backgroundColor: 'rgba(34, 197, 94, 0.2)',
                fill: true,
                tension: 0.3
            }]
        };

        let chart = new Chart(ctx, {
            type: 'line',
            data: monthlyData
        });

        filterSelect.addEventListener('change', () => {
            chart.data = filterSelect.value === 'weekly' ? weeklyData : monthlyData;
            chart.update();
        });
    </script>
</x-app-layout> --}}
