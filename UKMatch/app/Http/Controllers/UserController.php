<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\LevelModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar User',
            'list' => ['Home', 'User']
        ];

        $page = (object)[
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];

        $activeMenu = 'user';
        $levelList = LevelModel::all();

        return view('user.index', compact('breadcrumb', 'page', 'activeMenu', 'levelList'));
    }

    public function list(Request $request)
    {
        $users = UserModel::with(['level:id_level,level_nama'])
            ->select('user_id', 'username', 'nama', 'id_level');

        if ($request->id_level) {
            $users->where('id_level', $request->id_level);
        }

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('level_nama', function ($user) {
                return $user->level ? $user->level->level_nama : '-';
            })
            ->addColumn('aksi', function ($item) {
                $btn = '<a href="' . url('/user/' . $item->user_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/user/' . $item->user_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/user/' . $item->user_id) . '">';
                $btn .= csrf_field() . method_field('DELETE');
                $btn .= '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\')">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah User',
            'list' => ['Home', 'User', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Form Tambah User'
        ];

        $activeMenu = 'user';
        $levelList = LevelModel::all();

        return view('user.create', compact('breadcrumb', 'page', 'activeMenu', 'levelList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:20|unique:m_user,username',
            'nama' => 'required|string|max:100',
            'password' => 'required|min:5',
            'id_level' => 'required|exists:m_level,id_level'
        ]);

        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make($request->password),
            'id_level' => $request->id_level
        ]);

        return redirect('/user')->with('success', 'Data user berhasil disimpan');
    }

    public function show(string $id)
    {
        $user = UserModel::with('level')->findOrFail($id);

        $breadcrumb = (object)[
            'title' => 'Detail User',
            'list' => ['Home', 'User', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail User'
        ];

        $activeMenu = 'user';

        return view('user.show', compact('breadcrumb', 'page', 'activeMenu', 'user'));
    }

    public function edit(string $id)
    {
        $user = UserModel::findOrFail($id);

        $breadcrumb = (object)[
            'title' => 'Edit User',
            'list' => ['Home', 'User', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit User'
        ];

        $activeMenu = 'user';
        $levelList = LevelModel::all();

        return view('user.edit', compact('breadcrumb', 'page', 'activeMenu', 'user', 'levelList'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'username' => 'required|string|max:20|unique:m_user,username,' . $id . ',user_id',
            'nama' => 'required|string|max:100',
            'password' => 'nullable|min:5',
            'id_level' => 'required|exists:m_level,id_level'
        ]);

        $user = UserModel::findOrFail($id);

        $updateData = [
            'username' => $request->username,
            'nama' => $request->nama,
            'id_level' => $request->id_level
        ];

        if ($request->password) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect('/user')->with('success', 'Data user berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $check = UserModel::find($id);
        if (!$check) {
            return redirect('/user')->with('error', 'Data user tidak ditemukan');
        }

        try {
            UserModel::destroy($id);
            return redirect('/user')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/user')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}