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
        $submissions = Submission::with('user')->latest()->get();
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

            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => '6Lce1ZIrAAAAALxpz_-1EnQ7vbNAAXcXmsKDRbb2',
                'response' => $request->input('g-recaptcha-response'),
                'remoteip' => $request->ip(),
            ]);

            if (!$response->json('success')) {
                return back()->withErrors(['g-recaptcha-response' => 'Verifikasi CAPTCHA gagal.'])->withInput();
            }

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'no_hp' => 'required|numeric|phone:ID',
            'judul' => 'required|string|max:255',
            'isi' => 'required|string'
        ]);

        DB::beginTransaction();

        try {
            try{
                $submission = Submission::create([
                    'judul' => $validated['judul'],
                    'isi' => $validated['isi'],
                    'id_user' => $validated['user_id'],
                    'nama_pengaju' => $validated['name'],
                    'nomor_hp_pengaju' => $validated['no_hp'],
                    'status' => 'pending',
                ]);
            }catch (NumberParseException $e) {
                return back()->withErrors(['no_hp' => 'Nomor telepon tidak valid.'])->withInput();
            }
            DB::commit();

            return redirect()->route('anggota')->with('success', 'Pengajuan berhasil ditambahkan.');
        } catch (\Throwable $e) {
            DB::rollBack();
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
