<?php

namespace App\Http\Controllers;

use App\Models\Apbn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApbnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
        public function index()
    {
        $apbns = Apbn::all();
        return view('apbns.index', compact('apbns'));
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
    public function show(Apbn $apbn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Apbn $apbn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Apbn $apbn)
    {
        $validated = $request->validate([
            'total' => 'required',
        ]);
        $total = preg_replace('/\D/', '', $request->total);

        DB::beginTransaction();

        try {
            $apbn->update([
                'total' => $total,
            ]);

            DB::commit();

            return redirect()->route('apbns.index')->with('success', 'Data APBN berhasil diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal memperbarui data APBN.'])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apbn $apbn)
    {
        //
    }
}
