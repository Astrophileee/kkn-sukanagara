<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use libphonenumber\NumberParseException;

class SubmissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $submissions = Submission::all();
        return view('submissions.index', compact('submissions'));
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
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'rt_rw' => 'required|string|max:255',
            'pekerjaan' => 'required|string|max:255',
            'status_desa' => 'required|string|max:255',
            'jenis_pengaduan' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'waktu' => 'required|string|max:255',
            'kronologi' => 'required|string|max:255',
            'pihak_terlibat' => 'required|string|max:255',
            'dampak' => 'required|string|max:255',
            'harapan' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();

        try {

            $photoPath = null;
            if ($request->hasFile('photo')) {
                $randomName = 'photo_pengaduan_' . uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();
                $photoPath = $request->file('photo')->storeAs('submissions', $randomName, 'public');
            }

            $submission = Submission::create([
                'photo' => $photoPath,
                'nama' => $validated['nama'],
                'nik' => $validated['nik'],
                'alamat' => $validated['alamat'],
                'rt' => $validated['rt_rw'],
                'pekerjaan' => $validated['pekerjaan'],
                'status_desa' => $validated['status_desa'],
                'jenis' => $validated['jenis_pengaduan'],
                'lokasi' => $validated['lokasi'],
                'waktu' => $validated['waktu'],
                'kronologi' => $validated['kronologi'],
                'pihak' => $validated['pihak_terlibat'],
                'dampak' => $validated['dampak'],
                'harapan' => $validated['harapan'],
                'status' => 'pending',
            ]);
            DB::commit();

            return redirect()->route('kontak')->with('success', 'Pengaduan berhasil ditambahkan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e->getMessage(), $e->getTraceAsString());
            return back()->withErrors(['error' => 'Gagal menyimpan data pengajuan.'])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Submission $submission)
    {
        return view('submissions.detail', compact('submission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Submission $submissions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Submission $submission)
    {
        logger($request->all());
        $request->validate([
            'status' => 'required|in:pending,reject,accept',
        ]);

        $submission->status = $request->status;
        $submission->save();

        return response()->json(['message' => 'Status berhasil diperbarui.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Submission $submissions)
    {
        //
    }
}
