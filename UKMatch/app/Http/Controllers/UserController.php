<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\LevelModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
        $users = UserModel::with(['level:id_level,level_nama'])->select('user_id', 'username', 'nama', 'id_level');

        if ($request->id_level) {
            $users->where('id_level', $request->id_level);
        }

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('level_nama', function ($user) {
                return $user->level ? $user->level->level_nama : '-';
            })
            ->addColumn('aksi', function ($item) {
                //  $btn = '<a href="' . url('/user/' . $item->user_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                // $btn .= '<a href="' . url('/user/' . $item->user_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                //  $btn .= '<form class="d-inline-block" method="POST" action="' . url('/user/' . $item->user_id) . '">';
                // $btn .= csrf_field() . method_field('DELETE');
                // $btn .= '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\')">Hapus</button></form>';
                $btn = '<button onclick="modalAction(\'' . url('/user/' . $item->user_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $item->user_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $item->user_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
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

    // Menampilkan form create via Ajax
    public function create_ajax()
    {
        $level = LevelModel::select('id_level', 'level_nama')->get();
        return view('user.create_ajax')->with('level', $level);
    }

    public function store_ajax(Request $request)
    {
        $rules = [
            'id_level' => 'required|integer',
            'username' => 'required|string|min:3|unique:m_user,username',
            'nama'     => 'required|string|max:100',
            'password' => 'required|min:6'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Validasi Gagal',
                    'errors' => $validator->errors(),
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            UserModel::create($request->all());

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status'  => true,
                    'message' => 'Data user berhasil disimpan'
                ]);
            }

            return redirect('/user')->with('success', 'Data user berhasil disimpan');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Gagal menyimpan data',
                    'error'   => $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Gagal menyimpan data');
        }
    }

    //menampilkan halaman form edit user ajax
    public function edit_ajax(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::select('id_level', 'level_nama')->get();

        return view('user.edit_ajax', ['user' => $user, 'level' => $level]);
    }

    public function update_ajax($id, Request $request)
    {
        try {
            // Validasi data
            $validator = Validator::make($request->all(), [
                'id_level' => 'required|numeric',
                'username' => 'required|min:3|max:20',
                'nama' => 'required|min:3|max:100',
                'password' => 'nullable|min:6|max:20'
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }
    
            // Update data user
            $user = UserModel::find($id);
            $data = $request->except('password');
            
            if ($request->password) {
                $data['password'] = bcrypt($request->password);
            }
            
            $user->update($data);
    
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diupdate'
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: '.$e->getMessage()
            ], 500);
        }
    }
    
    public function show_ajax($id)
    {
        $user = UserModel::with('level')->find($id);
    
        // Pastikan data ditemukan
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }
    
        // Kembalikan data user dalam bentuk view HTML
        return view('user.show_ajax', compact('user'));
    }
    
    
public function confirm_ajax(string $id){
    $user = UserModel::find($id);

    return view('user.confirm_ajax', ['user' => $user]);
}


public function delete_ajax(Request $request, $id)
{
// cek apakah request dari ajax
if ($request->ajax() || $request->wantsJson()) {
    $user = UserModel::find($id);
    if ($user) {
        $user->delete();
        return response()->json([
            'status'  => true,
            'message' => 'Data berhasil dihapus'
        ]);
    } else {
        return response()->json([
            'status'  => false,
            'message' => 'Data tidak ditemukan'
        ]);
    }
}
return redirect('/');
}

}
