<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->get();
        $roles = Role::pluck('name');

        return view('users.index', compact('users','roles'));
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
            'role' => 'required|string',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'jabatan' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'media' => 'required|string|max:255',
            'riwayat' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {
            // Upload foto jika ada
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $randomName = 'photo_user_' . uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();
                $photoPath = $request->file('photo')->storeAs('users', $randomName, 'public');
            }

                // Proses penyimpanan user
                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'jabatan' => $validated['jabatan'],
                    'status' => $validated['status'],
                    'media' => $validated['media'],
                    'riwayat_berita' => $validated['riwayat'],
                    'photo' => $photoPath,
                    'password' => Hash::make('password'), // Default password
                ]);

            // Assign role (gunakan jika pakai Spatie Permission)
            $user->assignRole($validated['role']);

            DB::commit();

            return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan.');
        } catch (\Throwable $e) {
            DB::rollBack();

            // Hapus foto yang sudah terupload jika ada
            if ($photoPath) {
                Storage::disk('public')->delete($photoPath);
            }

            return back()->withErrors(['error' => 'Gagal menyimpan data pengguna.'])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'role' => 'required|string',
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'jabatan' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'media' => 'required|string|max:255',
            'riwayat' => 'required|numeric',
        ]);

        DB::transaction(function () use ($request, $user) {
            $data = $request->only(['name', 'email', 'jabatan', 'status', 'media', 'riwayat']);

            if ($request->hasFile('photo')) {
                if ($user->photo_path && Storage::exists($user->photo_path)) {
                    Storage::delete($user->photo_path);
                }

                $filename = 'photo_user_' . uniqid() . '.' . $request->photo->getClientOriginalExtension();
                $path = $request->file('photo')->storeAs('users', $filename, 'public');

                $data['photo'] = $path;
            }

            $user->update($data);

            $user->syncRoles([$request->role]);
        });

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        if ($user->photo_path && Storage::exists($user->photo_path)) {
                    Storage::delete($user->photo_path);
        }

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
