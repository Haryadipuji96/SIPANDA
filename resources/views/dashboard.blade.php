<x-app-layout>
    <div class="py-6 px-4">
        <!-- Header -->
        <div class="mb-6">
            <h1 id="greeting" class="text-3xl font-extrabold text-gray-800">Selamat Datang, {{ Auth::user()->name }} 👋</h1>
           <p id="dailyQuote" class="text-gray-500 mt-1">Ringkasan data terbaru di Bank Data Arsip Kampus</p>
        </div>

        <!-- Statistik Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="p-5 bg-gradient-to-r from-green-400 to-blue-500 text-white rounded-xl shadow-lg transform hover:scale-105 transition duration-300">
                <p class="text-sm">Total Data</p>
                <h2 class="text-2xl font-bold">1,245</h2>
            </div>
            <div class="p-5 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-xl shadow-lg transform hover:scale-105 transition duration-300">
                <p class="text-sm">User Aktif</p>
                <h2 class="text-2xl font-bold">87</h2>
            </div>
            <div class="p-5 bg-gradient-to-r from-yellow-400 to-orange-500 text-white rounded-xl shadow-lg transform hover:scale-105 transition duration-300">
                <p class="text-sm">Kategori</p>
                <h2 class="text-2xl font-bold">12</h2>
            </div>
            <div class="p-5 bg-gradient-to-r from-gray-700 to-gray-900 text-white rounded-xl shadow-lg transform hover:scale-105 transition duration-300">
                <p class="text-sm">Update Terakhir</p>
                <h2 class="text-2xl font-bold">02 Okt 2025</h2>
            </div>
        </div>

        <!-- Grafik & Data Terbaru -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            <!-- Grafik -->
            <div class="p-5 bg-white rounded-xl shadow-lg">
                <h3 class="font-semibold mb-2 text-gray-700">Statistik Data</h3>
                <canvas id="chartData"></canvas>
            </div>

            <!-- Data terbaru -->
            <div class="p-5 bg-white rounded-xl shadow-lg">
                <h3 class="font-semibold mb-2 text-gray-700">Data Terbaru</h3>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left border-b">
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Data Penduduk 2025</td>
                            <td>Penduduk</td>
                            <td>01 Okt 2025</td>
                        </tr>
                        <tr>
                            <td>Laporan Keuangan Q3</td>
                            <td>Keuangan</td>
                            <td>30 Sep 2025</td>
                        </tr>
                    </tbody>
                </table>
                <a href="{{ route('dashboard') }}" class="text-orange-500 text-sm mt-2 inline-block">Lihat Semua →</a>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
const quotes = [
    "“Pendidikan adalah senjata paling ampuh untuk mengubah dunia.” – Nelson Mandela",
    "“Belajar tanpa berpikir itu sia-sia, berpikir tanpa belajar itu berbahaya.” – Confucius",
    "“Kesuksesan adalah hasil dari persiapan, kerja keras, dan belajar dari kegagalan.” – Colin Powell",
    "“Ilmu pengetahuan adalah harta yang paling berharga.” – Mahatma Gandhi",
    "“Orang yang berhenti belajar akan menjadi tua, baik umur 20 atau 80.” – Henry Ford",
    "“Kampus bukan hanya tempat belajar, tapi tempat menginspirasi perubahan.”",
    "“Setiap hari adalah kesempatan baru untuk belajar sesuatu yang baru.”"
];

// Ambil tanggal hari ini
const today = new Date();
const dayIndex = today.getDate() % quotes.length; // agar index tidak out of range

// Set quote ke p tag
document.getElementById('dailyQuote').innerText = quotes[dayIndex];
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('chartData');
new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['Penduduk', 'Keuangan', 'Agenda', 'Event'],
        datasets: [{
            data: [300, 150, 100, 200],
            borderWidth: 1,
            backgroundColor: ['#10B981','#3B82F6','#FBBF24','#EF4444']
        }]
    }
});

// Fungsi greeting berdasarkan waktu
const greetingEl = document.getElementById('greeting');
const now = new Date();
const hour = now.getHours();
let greeting = "Selamat Datang";

if(hour >= 4 && hour < 12) greeting = "Selamat Pagi";
else if(hour >= 12 && hour < 15) greeting = "Selamat Siang";
else if(hour >= 15 && hour < 18) greeting = "Selamat Sore";
else greeting = "Selamat Malam";

greetingEl.innerHTML = `${greeting}, {{ Auth::user()->name }} 👋`;
</script>
