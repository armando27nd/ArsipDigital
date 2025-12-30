<!DOCTYPE html>
<html>
<head>
    <title>Lembar Disposisi - {{ $disposisi->no_registrasi }}</title>
    <link rel="stylesheet" href="{{ asset('css/cetak-disposisi.css') }}">
    <style>
        /* Menghilangkan margin bawah default dari tabel */
        table {
            margin-bottom: 0 !important;
        }
        /* Menghilangkan border atas pada tabel instruksi agar menyatu */
        .table-instruksi, .table-catatan {
            border-top: none !important;
        }
    </style>
</head>

<body @if(!isset($is_preview)) onload="window.print()" @endif>
    <div class="container-disposisi">

        <div class="header-kop">
            <img src="{{ asset('logo-header.png') }}" alt="Logo Kabupaten Tangerang" class="logo-kop">
            <div class="header-text">
                <h3>PEMERINTAH KABUPATEN TANGERANG</h2>
                <h2><strong>DINAS TENAGA KERJA</strong></h3>
                <p style="font-size:12px;">JL. RAYA PARAHU RT. 05 RW. 001. DESA PARAHU. KECAMATAN SUKAMULYA</p>
                <p style="font-size:12px;">KABUPATEN TANGERANG - BANTEN Telp. (021) 59433197</p>
                <p style="font-size:12px;">Kode Pos: 15896</p>
            </div>
        </div>

        <div class="judul-disposisi">
            LEMBAR DISPOSISI
        </div>

        <table class="table-info">
            <tbody>
                <tr>
                    <!-- Kolom Kiri Gabungan -->
                    <td style="width: 50%; vertical-align: top; padding: 0; border-right: 1px solid #000;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <tbody>
                                <tr>
                                    <td style="width: 30%; border: none; padding: 5px;">Surat dari</td>
                                    <td style="border: none; padding: 5px;">: {{ $disposisi->asal ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 30%; border: none; padding: 5px;">No. Surat</td>
                                    <td style="border: none; padding: 5px;">: {{ $disposisi->no_dan_tanggal ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 30%; border: none; padding: 5px;">Tgl. Surat</td>
                                    <td style="border: none; padding: 5px;">: {{ $disposisi->tanggal ? \Carbon\Carbon::parse($disposisi->tanggal)->translatedFormat('d F Y') : '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <!-- Kolom Kanan Gabungan -->
                    <td style="width: 50%; vertical-align: top; padding: 0;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <tbody>
                                <tr>
                                    <td style="width: 30%; border: none; padding: 5px;">Diterima Tgl</td>
                                    <td style="border: none; padding: 5px;">: {{ $disposisi->created_at->translatedFormat('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 30%; border: none; padding: 5px;">No. Agenda</td>
                                    <td style="border: none; padding: 5px;">: {{ $disposisi->no_registrasi ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 30%; border: none; padding: 5px;">Sifat</td>
                                    <td style="border: none; padding: 5px;">:
                                        <span class="checkbox-label">
                                            <input type="checkbox" {{ ($disposisi->sifat ?? null) == 'sangat_segera' ? 'checked' : '' }} > Sangat Segera
                                        </span>
                                        <span class="checkbox-label">
                                            <input type="checkbox" {{ ($disposisi->sifat ?? null) == 'segera' ? 'checked' : '' }} > Segera
                                        </span>
                                        <span class="checkbox-label">
                                            <input type="checkbox" {{ ($disposisi->sifat ?? null) == 'rahasia' ? 'checked' : '' }}> Rahasia
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <!-- Baris untuk 'Hal' -->
                <tr>
                    <td colspan="2" style="padding: 5px; border-top: 1px solid #000;">Hal: {{ $disposisi->perihal ?? '-' }}</td>
                </tr>
            </tbody>
        </table>

        <!-- ====================================================== -->
        <!--  BAGIAN INSTRUKSI DIPERBARUI SESUAI PERMINTAAN KLIEN   -->
        <!-- ====================================================== -->
        <table class="table-instruksi">
            <tr>
                <td>
                    <strong>Diteruskan kepada Sdr:</strong>
                    <div style="min-height: 80px; padding-top: 5px;">
                        {{ $disposisi->diteruskan ?? '-' }}
                    </div>
                </td>
            </tr>
        </table>

        <table class="table-catatan">
             <tr>
                <td>
                    <strong>Catatan:</strong>
                    <div style="min-height: 60px; padding-top: 5px;">
                        {{ $disposisi->catatan ?? '-' }}
                    </div>
                </td>
            </tr>
        </table>

        <!-- Bagian Paraf Section sudah dihapus sesuai permintaan -->

    </div>
</body>
</html>
