<?php

namespace App\Http\Controllers;

use App\Models\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $informations = Information::all();

        return view('informations.index', compact('informations'));
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
        $validated = $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
                $randomName = 'photo_information_' . uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();
                $photoPath = $request->file('photo')->storeAs('photoInformations', $randomName, 'public');

                // Proses penyimpanan user
                $information = Information::create([
                    'judul' => $validated['judul'],
                    'isi' => $validated['isi'],
                    'photo' => $photoPath
                ]);
            DB::commit();

            return redirect()->route('informations.index')->with('success', 'Informasi berhasil ditambahkan.');
        } catch (\Throwable $e) {
            DB::rollBack();

            // Hapus foto yang sudah terupload jika ada
            if ($photoPath) {
                Storage::disk('public')->delete($photoPath);
            }

            return back()->withErrors(['error' => 'Gagal menyimpan data informasi.'])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Information $information)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Information $information)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Information $information)
    {
        $validated = $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ]);

        DB::transaction(function () use ($request, $information) {
            $data = $request->only(['judul', 'isi']);

                // Hanya proses foto jika ada upload baru
        if ($request->hasFile('photo')) {
            // Hapus foto lama
            if ($information->photo && Storage::disk('public')->exists($information->photo)) {
                Storage::disk('public')->delete($information->photo);
            }

            // Simpan foto baru
            $filename = 'photo_information_' . uniqid() . '.' . $request->photo->getClientOriginalExtension();
            $path = $request->file('photo')->storeAs('informations', $filename, 'public');
            $data['photo'] = $path;
        }

            $information->update($data);
        });

        return redirect()->route('informations.index')->with('success', 'informasi berhasil diperbarui');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Information $information)
    {
        $information->delete();
        if ($information->photo && Storage::disk('public')->exists($information->photo)) {
                Storage::disk('public')->delete($information->photo);
            }

        return redirect()->route('informations.index')->with('success', 'Informasi berhasil dihapus.');
    }
}
