<?php
namespace App\Http\Controllers;

use App\Models\KategoriUkmModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KategoriUkmController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Kategori UKM',
            'list' => ['Beranda', 'Kategori UKM']
        ];

        $page = (object)[
            'title' => 'Daftar Kategori UKM dalam sistem'
        ];

        $activeMenu = 'kategori_ukm';
        
        return view('kategori_ukm.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $kategori = KategoriUkmModel::select('id_kategori', 'nama_kategori', 'created_at', 'updated_at');

        return DataTables::of($kategori)
            ->addIndexColumn()
            ->addColumn('aksi', function ($item) {
                $btn = '<a href="' . url('/kategori_ukm/' . $item->id_kategori) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/kategori_ukm/' . $item->id_kategori . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/kategori_ukm/' . $item->id_kategori) . '">';
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
            'title' => 'Tambah Kategori UKM',
            'list' => ['Beranda', 'Kategori UKM', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Form Tambah Kategori UKM'
        ];

        $activeMenu = 'kategori_ukm';

        return view('kategori_ukm.create', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_ukm,nama_kategori',
        ]);

        KategoriUkmModel::create($request->all());

        return redirect('/kategori_ukm')->with('success', 'Data Kategori UKM berhasil disimpan');
    }

    public function show(string $id)
    {
        $kategori = KategoriUkmModel::findOrFail($id);

        $breadcrumb = (object)[
            'title' => 'Detail Kategori UKM',
            'list' => ['Beranda', 'Kategori UKM', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail Kategori UKM'
        ];

        $activeMenu = 'kategori_ukm';

        return view('kategori_ukm.show', compact('breadcrumb', 'page', 'activeMenu', 'kategori'));
    }

    public function edit(string $id)
    {
        $kategori = KategoriUkmModel::findOrFail($id);

        $breadcrumb = (object)[
            'title' => 'Edit Kategori UKM',
            'list' => ['Beranda', 'Kategori UKM', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit Kategori UKM'
        ];

        $activeMenu = 'kategori_ukm';

        return view('kategori_ukm.edit', compact('breadcrumb', 'page', 'activeMenu', 'kategori'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_ukm,nama_kategori,'.$id.',id_kategori',
        ]);

        $kategori = KategoriUkmModel::findOrFail($id);
        $kategori->update($request->all());

        return redirect('/kategori_ukm')->with('success', 'Data Kategori UKM berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        try {
            $kategori = KategoriUkmModel::findOrFail($id);
            
            // Cek apakah kategori ini digunakan oleh UKM
            if ($kategori->ukm()->exists()) {
                return redirect('/kategori_ukm')->with('error', 'Gagal menghapus kategori. Data masih digunakan oleh UKM.');
            }
            
            $kategori->delete();
            return redirect('/kategori_ukm')->with('success', 'Data Kategori UKM berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/kategori_ukm')->with('error', 'Gagal menghapus kategori. Data masih terkait dengan tabel lain.');
        }
    }
}