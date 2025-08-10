<?php

namespace App\Http\Controllers;

use App\Models\Apbn;
use App\Models\Information;
use App\Models\Penduduk;
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
        $informations = Information::latest()->take(3)->get();

        $penduduks = Penduduk::all()->keyBy('label');
        $apbns = Apbn::all()->keyBy('label');

        return view('company.beranda', compact('informations', 'penduduks', 'apbns'));
    }

    public function information()
    {
        $informations = Information::all();

        return view('company.informasi', compact('informations'));
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
