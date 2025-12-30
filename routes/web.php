<?php

use Illuminate\Support\Facades\Route;

// Route login dan logout
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login')->name('login.post');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::middleware(['auth'])->group(function () {
    // Route khusus ke home
    Route::get('/', 'HomeController@index')->name('home');

    Route::get('/disposisi/agenda', 'DisposisiController@agenda');
    Route::put('/disposisi/agenda_store', 'DisposisiController@agenda_store');

    // Aktifkan dan sesuaikan route LaporanController
    // Route ini sekarang menangani tampilan awal dan hasil filter
    Route::get('/laporan', 'LaporanController@index')->name('laporan.index');
    Route::get('/laporan/print', 'LaporanController@pdf')->name('laporan.pdf');
    Route::get('/laporan/excel', 'LaporanController@excel')->name('laporan.excel');

    // !route untuk laporan arsip pdf dan excel
    Route::get('/arsip', 'ArsipController@index')->name('arsip.index');
    // Route::get('/arsip/cetak', 'ArsipController@cetak')->name('arsip.cetak');
    // Route baru untuk PDF dan Excel
    Route::get('/arsip/pdf', 'ArsipController@exportPdf')->name('arsip.pdf');
    Route::get('/arsip/excel', 'ArsipController@exportExcel')->name('arsip.excel');

    // !Route Surat Masuk dan Surat Keluar
    Route::get('/surat-masuk', 'SuratMasukController@index')->name('surat-masuk.index');
    Route::get('/surat-masuk/create', 'SuratMasukController@create')->name('surat-masuk.create');
    Route::post('/surat-masuk/store', 'SuratMasukController@store')->name('surat-masuk.store');
    Route::get('/surat-masuk/edit/{id}', 'SuratMasukController@edit')->name('surat-masuk.edit');
    Route::put('/surat-masuk/update/{id}', 'SuratMasukController@update')->name('surat-masuk.update');
    Route::get('/surat-masuk/hapus/{id}', 'SuratMasukController@destroy')->name('surat-masuk.destroy');
    // !Route Surat Keluar
    Route::get('/surat-keluar', 'SuratKeluarController@index')->name('surat-keluar.index');
    Route::get('/surat-keluar/create', 'SuratKeluarController@create')->name('surat-keluar.create');
    Route::post('/surat-keluar/store', 'SuratKeluarController@store')->name('surat-keluar.store');
    Route::get('/surat-keluar/edit/{id}', 'SuratKeluarController@edit')->name('surat-keluar.edit');
    Route::put('/surat-keluar/update/{id}', 'SuratKeluarController@update')->name('surat-keluar.update');
    Route::get('/surat-keluar/hapus/{id}', 'SuratKeluarController@destroy')->name('surat-keluar.destroy');

    Route::prefix('agenda')->name('agenda.')->middleware('role:admin,user')->group(function () {
        Route::get('/', 'AgendaController@index')->name('index');

        // Rute ini yang akan dipanggil oleh tombol "Agendakan"
        Route::get('/create/{disposisi}', 'AgendaController@create')->name('create');
        Route::post('/store', 'AgendaController@store')->name('store');
        Route::get('/{agenda}/edit', 'AgendaController@edit')->name('edit');
        Route::put('/{agenda}', 'AgendaController@update')->name('update');

        Route::delete('/{agenda}', 'AgendaController@destroy')->name('destroy');

        Route::get('/cetak', 'AgendaController@cetak')->name('cetak');
    });
    // Resource disposisi untuk user biasa (hanya index, create, store, show, cetak)
    Route::prefix('user')->name('user.')->middleware('role:user')->group(function () {
        Route::get('/disposisi', 'DisposisiController@index')->name('disposisi.index');
        Route::get('/disposisi/tambah', 'DisposisiController@create')->name('disposisi.tambah');
        Route::post('/disposisi/store', 'DisposisiController@store')->name('disposisi.proses');
        Route::get('/disposisi/{id}', 'DisposisiController@show')->name('disposisi.show');
        Route::get('/disposisi/{id}/cetak', 'DisposisiController@cetak')->name('disposisi.cetak');
    });

    // Resource disposisi untuk admin (lengkap: index, create, store, show, edit, update dan cetak)
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::resource('disposisi', 'DisposisiController')->except(['destroy']);
        Route::resource('users', 'UserController');
        Route::get('/disposisi/{id}/cetak', 'DisposisiController@cetak')->name('disposisi.cetak');
    });
});
