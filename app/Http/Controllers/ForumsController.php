<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Forum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ForumsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $forums = Forum::with('user')->latest()->get();
        return view('forums.index', compact('forums'));
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
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'id_submission' => 'nullable|exists:submissions,id'
        ]);

        DB::beginTransaction();

        try {
                $photoPath = null;
                if ($request->hasFile('photo')) {
                    $randomName = 'photo_Forum_' . uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();
                    $photoPath = $request->file('photo')->storeAs('photoForums', $randomName, 'public');
                }

                // Proses penyimpanan user
                $forum = Forum::create([
                    'judul' => $validated['judul'],
                    'isi' => $validated['isi'],
                    'photo' => $photoPath,
                    'id_user' => Auth::id(),
                    'id_submission' => $validated['id_submission'] ?? null,
                ]);
            DB::commit();

            return redirect()->route('forums.index')->with('success', 'forum berhasil ditambahkan.');
        } catch (\Throwable $e) {
            DB::rollBack();

            // Hapus foto yang sudah terupload jika ada
            if ($photoPath) {
                Storage::disk('public')->delete($photoPath);
            }

            return back()->withErrors(['error' => 'Gagal menyimpan data forum.'])->withInput();
        }
    }

    public function storeComments(Request $request, Forum $forum)
    {
        if ($request->expectsJson()) {
            try {
                $validated = $request->validate([
                    'isi' => 'required|max:500',
                    'photo' => 'nullable|image|max:2048',
                ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                return response()->json([
                    'errors' => $e->errors(),
                    'message' => 'Validasi gagal'
                ], 422);
            }
        } else {
            $validated = $request->validate([
                'isi' => 'required|max:500',
                'photo' => 'nullable|image|max:2048',
            ]);
        }


        DB::beginTransaction();

        try {
                $photoPath = null;
                if ($request->hasFile('photo')) {
                    $randomName = 'photo_Forum_Comment_' . uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();
                    $photoPath = $request->file('photo')->storeAs('photoForumComments', $randomName, 'public');
                }
                $comment = Comment::create([
                    'isi' => $validated['isi'],
                    'photo' => $photoPath,
                    'id_user' => Auth::id(),
                    'id_forum' => $forum->id
                ]);
            DB::commit();
            $comment->load('user');
            if (!$comment->user) {
                return response()->json([
                    'message' => 'Gagal menyimpan data forum.',
                ], 500);
            }
            return response()->json([
                'html' => view('layouts.partials.comments', ['comment' => $comment])->render()
            ]);

            return redirect()->back()->with('success', 'forum berhasil ditambahkan.');
        } catch (\Throwable $e) {
            DB::rollBack();

            // Hapus foto yang sudah terupload jika ada
            if ($photoPath) {
                Storage::disk('public')->delete($photoPath);
            }
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Gagal menyimpan data forum.',
                ], 500);
            }

            return back()->withErrors(['error' => 'Gagal menyimpan data forum.'])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Forum $forum)
    {
        $forum->load(['user', 'comments.user', 'submission']);

        return view('forums.detail', [
            'forum' => $forum,
            'submission' => $forum->submission,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Forum $forum)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Forum $forum)
    {
        $validated = $request->validate([
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'id_submission' => 'nullable|exists:submissions,id',
        ]);



        DB::transaction(function () use ($request, $forum, $validated) {
            $data = [
                'judul' => $validated['judul'],
                'isi' => $validated['isi'],
                'id_submission' => $validated['id_submission'] ?? null,
            ];

            // Jika user upload foto baru
            if ($request->hasFile('photo')) {
                // Hapus foto lama jika ada
                if ($forum->photo && Storage::disk('public')->exists($forum->photo)) {
                    Storage::disk('public')->delete($forum->photo);
                }

                // Simpan foto baru
                $filename = 'photo_forum_' . uniqid() . '.' . $request->photo->getClientOriginalExtension();
                $path = $request->file('photo')->storeAs('photoForums', $filename, 'public');
                $data['photo'] = $path;
            }

            // Update data ke database
            $forum->update($data);
        });

        return redirect()->back()->with('success', 'Forum berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Forum $forum)
    {
        if ($forum->photo && Storage::disk('public')->exists($forum->photo)) {
            Storage::disk('public')->delete($forum->photo);
        }
        $forum->delete();
        return redirect()->route('forums.index')->with('success', 'Forum berhasil dihapus.');
    }
}
