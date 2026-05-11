<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ─── Public Pages (Tanpa Login) ─────────────────────────────
$routes->get('/', 'Home::index');

// ─── Auth Routes (Public) ───────────────────────────────────
$routes->get('login-admin', 'Auth::loginAdmin');
$routes->post('auth/admin-login', 'Auth::prosesLoginAdmin');
$routes->post('admin/login', 'Auth::prosesLoginAdmin');
$routes->get('logout', 'Auth::logout');
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
// Removed as user login is disabled

// ─── Deteksi / Diagnosa (Public) ───────────────────────
$routes->get('deteksi', 'Deteksi::index');
$routes->post('deteksi/proses', 'Deteksi::proses');
$routes->get('deteksi/hasil', 'Deteksi::hasil');
$routes->post('deteksi/simpan', 'Deteksi::simpanRiwayat');
$routes->get('deteksi/batal', 'Deteksi::batal');

// ─── Riwayat User (Public) ──────────────────────────────
$routes->get('riwayat', 'Pages::riwayat');
$routes->get('riwayat/detail/(:num)', 'Pages::riwayatDetail/$1');
$routes->get('riwayat/hapus/(:num)', 'Pages::hapusRiwayat/$1');
$routes->post('riwayat/hapus/(:num)', 'Pages::hapusRiwayat/$1');
$routes->post('riwayat/hapus-semua', 'Pages::hapusSemuaRiwayat');
$routes->get('riwayat/hapus-semua', 'Pages::hapusSemuaRiwayat');

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