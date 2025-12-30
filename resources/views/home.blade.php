@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Kartu Total Surat Masuk -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $jumlahsm }}</h3>
                    <p>Total Surat Masuk</p>
                </div>
                <div class="icon">
                    <i class="fas fa-envelope-open-text"></i>
                </div>
                <a href="{{ url('/suratmasuk') }}" class="small-box-footer">
                    Selengkapnya <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- Kartu Total Surat Keluar -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $jumlahsk }}</h3>
                    <p>Total Surat Keluar</p>
                </div>
                <div class="icon">
                    <i class="fas fa-paper-plane"></i>
                </div>
                <a href="{{ url('/suratkeluar') }}" class="small-box-footer">
                    Selengkapnya <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- Kartu Total Agenda -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $jumlahagenda }}</h3>
                    <p>Total Agenda</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <a href="{{ url('/agenda') }}" class="small-box-footer">
                    Selengkapnya <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- Kartu Total Disposisi -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $jumlahdispo }}</h3>
                    <p>Total Disposisi</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-signature"></i>
                 fungicide                </a>
            </div>
        </div>
    </div>

    <!-- Container untuk kedua grafik agar berdampingan -->
    <div class="row mt-4">
        <!-- Grafik Visualisasi Data Dokumen Tahun Sekarang (Bar Chart) - Dipindahkan ke kiri -->
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Visualisasi Data Dokumen (Tahun Ini: {{ date('Y') }})</h3>
                </div>
                <div class="card-body">
                    <canvas id="currentYearDocumentPieChart" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Grafik Visualisasi Data Dokumen Keseluruhan (Pie Chart) - Dipindahkan ke kanan -->
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Visualisasi Data Dokumen (Keseluruhan)</h3>
                </div>
                <div class="card-body">
                    <canvas id="documentPieChart" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Data Keseluruhan ---
        const jumlahsm = {{ $jumlahsm }};
        const jumlahsk = {{ $jumlahsk }};
        const jumlahagenda = {{ $jumlahagenda }};
        const jumlahdispo = {{ $jumlahdispo }};

        // --- Data Tahun Sekarang ---
        const jumlahsmTahunIni = {{ $jumlahsmTahunIni ?? 0 }};
        const jumlahskTahunIni = {{ $jumlahskTahunIni ?? 0 }};
        const jumlahagendaTahunIni = {{ $jumlahagendaTahunIni ?? 0 }};
        const jumlahdispoTahunIni = {{ $jumlahdispoTahunIni ?? 0 }};

        // --- DEBUGGING: Cek apakah data sudah benar dan skrip berjalan ---
        console.log('Skrip Chart.js dimuat.');
        console.log('Jumlah Surat Masuk (Keseluruhan):', jumlahsm);
        console.log('Jumlah Surat Keluar (Keseluruhan):', jumlahsk);
        console.log('Jumlah Agenda (Keseluruhan):', jumlahagenda);
        console.log('Jumlah Disposisi (Keseluruhan):', jumlahdispo);
        console.log('Jumlah Surat Masuk (Tahun Ini):', jumlahsmTahunIni);
        console.log('Jumlah Surat Keluar (Tahun Ini):', jumlahskTahunIni);
        console.log('Jumlah Agenda (Tahun Ini):', jumlahagendaTahunIni);
        console.log('Jumlah Disposisi (Tahun Ini):', jumlahdispoTahunIni);
        // --- Akhir DEBUGGING ---

        // --- Grafik Keseluruhan (Pie Chart) ---
        const ctxOverall = document.getElementById('documentPieChart').getContext('2d');
        if (ctxOverall) {
            new Chart(ctxOverall, {
                type: 'pie', // Jenis grafik: pie
                data: {
                    labels: ['Surat Masuk', 'Surat Keluar', 'Agenda', 'Disposisi'],
                    datasets: [{
                        label: 'Jumlah Dokumen',
                        data: [jumlahsm, jumlahsk, jumlahagenda, jumlahdispo],
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(255, 206, 86, 0.7)',
                            'rgba(255, 99, 132, 0.7)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top' },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) { label += ': '; }
                                    if (context.parsed !== null) { label += context.parsed; }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        } else {
            console.error('Elemen canvas dengan ID "documentPieChart" tidak ditemukan.');
        }

        // --- Grafik Tahun Sekarang (Bar Chart) ---
        const ctxCurrentYear = document.getElementById('currentYearDocumentPieChart').getContext('2d');
        if (ctxCurrentYear) {
            new Chart(ctxCurrentYear, {
                type: 'bar', // Jenis grafik: bar
                data: {
                    labels: ['Surat Masuk', 'Surat Keluar', 'Agenda', 'Disposisi'],
                    datasets: [{
                        label: 'Jumlah Dokumen Tahun Ini',
                        data: [jumlahsmTahunIni, jumlahskTahunIni, jumlahagendaTahunIni, jumlahdispoTahunIni],
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(255, 206, 86, 0.7)',
                            'rgba(255, 99, 132, 0.7)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) { label += context.parsed.y; }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        } else {
            console.error('Elemen canvas dengan ID "currentYearDocumentPieChart" tidak ditemukan.');
        }
    });
</script>
@endsection
