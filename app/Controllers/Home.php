<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // If logged in and is admin, redirect to admin panel
        if (session()->get('isLoggedIn') && session()->get('role') === 'admin') {
            return redirect()->to('/admin');
        }
        
        $data['title'] = 'CornAI - Sistem Pakar Deteksi Penyakit Jagung';
        return view('home', $data);
    }
}