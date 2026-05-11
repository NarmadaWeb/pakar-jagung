<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ─── Public Pages (Tanpa Login) ─────────────────────────────
$routes->get('/', 'Home::index');

// ─── Auth Routes (Public) ───────────────────────────────────
$routes->get('/', 'Home::index');
$routes->get('login', 'Auth::index');
$routes->get('login-admin', 'Auth::loginAdmin');
$routes->get('auth/register', 'Auth::register');
$routes->get('register', 'Auth::register');
$routes->get('lupa-password', 'Auth::lupaPassword');
$routes->post('auth/admin-login', 'Auth::prosesLoginAdmin');
$routes->post('admin/login', 'Auth::prosesLoginAdmin');
$routes->post('auth/login', 'Auth::prosesLogin');
$routes->post('auth/proses-login', 'Auth::prosesLogin');
$routes->post('auth/register', 'Auth::prosesRegister');
$routes->post('auth/proses-register', 'Auth::prosesRegister');
$routes->post('lupa-password', 'Auth::kirimResetPassword');
$routes->get('reset-password/(:any)', 'Auth::resetPassword/$1');
$routes->post('reset-password', 'Auth::prosesResetPassword');
$routes->get('logout', 'Auth::logout');

// ─── Halaman Statis Public ───────────────────────────────────
$routes->get('library', 'Pages::library');
$routes->get('tentang', 'Pages::tentang');
$routes->get('kontak', 'Pages::kontak');
$routes->get('faq', 'Pages::faq');
$routes->get('panduan', 'Pages::panduan');
$routes->get('privasi', 'Pages::privasi');
$routes->get('syarat', 'Pages::syarat');

// ─── User Dashboard (Perlu Login) ───────────────────────────
$routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth']);

// ─── Deteksi / Diagnosa (Perlu Login) ───────────────────────
$routes->get('deteksi', 'Deteksi::index', ['filter' => 'auth']);
$routes->post('deteksi/proses', 'Deteksi::proses', ['filter' => 'auth']);
$routes->get('deteksi/hasil', 'Deteksi::hasil', ['filter' => 'auth']);
$routes->post('deteksi/simpan', 'Deteksi::simpanRiwayat', ['filter' => 'auth']);
$routes->get('deteksi/batal', 'Deteksi::batal', ['filter' => 'auth']);

// ─── Riwayat User (Perlu Login) ──────────────────────────────
$routes->get('riwayat', 'Pages::riwayat', ['filter' => 'auth']);
$routes->get('riwayat/detail/(:num)', 'Pages::riwayatDetail/$1', ['filter' => 'auth']);
$routes->get('riwayat/hapus/(:num)', 'Pages::hapusRiwayat/$1', ['filter' => 'auth']);
$routes->post('riwayat/hapus/(:num)', 'Pages::hapusRiwayat/$1', ['filter' => 'auth']);
$routes->post('riwayat/hapus-semua', 'Pages::hapusSemuaRiwayat', ['filter' => 'auth']);
$routes->get('riwayat/hapus-semua', 'Pages::hapusSemuaRiwayat', ['filter' => 'auth']);

// ─── Profile User (Perlu Login) ─────────────────────────────
$routes->get('profile', 'Pages::profile', ['filter' => 'auth']);

// ─── Admin Routes ───────────────────────────────────────────
$routes->get('admin', 'Pages::admin', ['filter' => 'adminauth']);
$routes->get('admin/login', 'Auth::loginAdmin');
$routes->post('admin/login', 'Auth::prosesLoginAdmin');

// ─── Admin: Kelola Pengguna ──────────────────────────────────
$routes->get('admin/pengguna', 'Pages::pengguna', ['filter' => 'adminauth']);
$routes->get('admin/pengguna/delete/(:num)', 'Pages::deletePengguna/$1', ['filter' => 'adminauth']);

// ─── Admin: Riwayat Sistem ───────────────────────────────────
$routes->get('admin/riwayat', 'Pages::adminRiwayat', ['filter' => 'adminauth']);
$routes->get('admin/riwayat/hapus/(:num)', 'Pages::hapusAdminRiwayat/$1', ['filter' => 'adminauth']);
$routes->get('admin/riwayat/hapus-semua', 'Pages::hapusSemuaAdminRiwayat', ['filter' => 'adminauth']);

// ─── Admin: Library (Kelola Penyakit) ───────────────────────
$routes->get('admin/library', 'Pages::adminLibrary', ['filter' => 'adminauth']);

// ─── Admin: Kelola Data master (CRUD) ────────────────────────
$routes->get('penyakit', 'Penyakit::index', ['filter' => 'adminauth']);
$routes->get('penyakit/add', 'Penyakit::add', ['filter' => 'adminauth']);
$routes->post('penyakit/add', 'Penyakit::add', ['filter' => 'adminauth']);
$routes->get('penyakit/edit/(:num)', 'Penyakit::edit/$1', ['filter' => 'adminauth']);
$routes->post('penyakit/edit/(:num)', 'Penyakit::edit/$1', ['filter' => 'adminauth']);
$routes->get('penyakit/delete/(:num)', 'Penyakit::delete/$1', ['filter' => 'adminauth']);
$routes->post('penyakit/delete/(:num)', 'Penyakit::delete/$1', ['filter' => 'adminauth']);
$routes->get('penyakit/detail/(:num)', 'Penyakit::detail/$1', ['filter' => 'adminauth']);

$routes->get('gejala', 'Gejala::index', ['filter' => 'adminauth']);
$routes->get('gejala/add', 'Gejala::add', ['filter' => 'adminauth']);
$routes->post('gejala/add', 'Gejala::add', ['filter' => 'adminauth']);
$routes->get('gejala/edit/(:num)', 'Gejala::edit/$1', ['filter' => 'adminauth']);
$routes->post('gejala/edit/(:num)', 'Gejala::edit/$1', ['filter' => 'adminauth']);
$routes->get('gejala/delete/(:num)', 'Gejala::delete/$1', ['filter' => 'adminauth']);
$routes->post('gejala/delete/(:num)', 'Gejala::delete/$1', ['filter' => 'adminauth']);

$routes->get('basis-pengetahuan', 'BasisPengetahuan::index', ['filter' => 'adminauth']);
$routes->get('basis-pengetahuan/add', 'BasisPengetahuan::add', ['filter' => 'adminauth']);
$routes->post('basis-pengetahuan/add', 'BasisPengetahuan::add', ['filter' => 'adminauth']);
$routes->get('basis-pengetahuan/edit/(:num)', 'BasisPengetahuan::edit/$1', ['filter' => 'adminauth']);
$routes->post('basis-pengetahuan/edit/(:num)', 'BasisPengetahuan::edit/$1', ['filter' => 'adminauth']);
$routes->get('basis-pengetahuan/delete/(:num)', 'BasisPengetahuan::delete/$1', ['filter' => 'adminauth']);
$routes->post('basis-pengetahuan/delete/(:num)', 'BasisPengetahuan::delete/$1', ['filter' => 'adminauth']);