<?php

namespace App\Http\Controllers;

use App\Models\Information;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\Request;

class CompanyProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalUsers = User::count();
        $totalSubmissions = Submission::count();
        $totalNews = 25; // jika masih statis, atau kamu bisa ganti dengan count dari berita
        $informations = Information::latest()->take(4)->get();

        return view('company.beranda', compact('totalUsers', 'totalSubmissions', 'totalNews', 'informations'));
    }

    public function information()
    {
        $informations = Information::all();

        return view('company.informasi', compact('informations'));
    }

    public function anggota()
    {
        $users = User::all();

        return view('company.anggota', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Information $informasi)
    {
        return view('company.detailInformasi', compact('informasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
