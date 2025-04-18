<?php
namespace App\Http\Controllers;

use App\Models\UkmModel;
use App\Models\KategoriUkmModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UkmController extends Controller
{
    public function index()
{
    $breadcrumb = (object)[
        'title' => 'Daftar UKM',
        'list' => ['Home', 'UKM']
    ];

    $page = (object)[
        'title' => 'Daftar UKM dalam sistem'
    ];

    $activeMenu = 'ukm';
    
    // Tambahkan ini untuk mengambil data kategori UKM
    $kategori_ukm = KategoriUkmModel::all();
    
    return view('ukm.index', compact('breadcrumb', 'page', 'activeMenu', 'kategori_ukm'));
}

    public function list(Request $request)
    {
        $ukm = UkmModel::with('kategori')->select('id_ukm', 'nama_ukm', 'id_kategori', 'email', 'alamat', 'tanggal_berdiri', 'status');

        if ($request->id_kategori) {
            $ukm->where('id_kategori', $request->id_kategori);
        }

        return DataTables::of($ukm)
            ->addIndexColumn()
            ->addColumn('nama_kategori', function ($item) {
                return $item->kategori->nama_kategori ?? '-';
            })
            ->addColumn('aksi', function ($item) {
                $btn = '<a href="' . url('/ukm/' . $item->id_ukm) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/ukm/' . $item->id_ukm . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/ukm/' . $item->id_ukm) . '">';
                $btn .= csrf_field() . method_field('DELETE');
                $btn .= '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin?\')">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah UKM',
            'list' => ['Home', 'UKM', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Form Tambah UKM'
        ];

        $activeMenu = 'ukm';
        $kategoriList = KategoriUkmModel::all();

        return view('ukm.create', compact('breadcrumb', 'page', 'activeMenu', 'kategoriList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_ukm' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori_ukm,id_kategori',
            'email' => 'required|email',
            'alamat' => 'required|string',
            'deskripsi' => 'required|string',
            'tanggal_berdiri' => 'required|date',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        UkmModel::create($request->all());

        return redirect('/ukm')->with('success', 'Data UKM berhasil disimpan');
    }

    public function show(string $id)
    {
        $ukm = UkmModel::with('kategori')->findOrFail($id);

        $breadcrumb = (object)[
            'title' => 'Detail UKM',
            'list' => ['Home', 'UKM', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail UKM'
        ];

        $activeMenu = 'ukm';

        return view('ukm.show', compact('breadcrumb', 'page', 'activeMenu', 'ukm'));
    }

    public function edit(string $id)
    {
        $ukm = UkmModel::findOrFail($id);

        $breadcrumb = (object)[
            'title' => 'Edit UKM',
            'list' => ['Home', 'UKM', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit UKM'
        ];

        $activeMenu = 'ukm';
        $kategoriList = KategoriUkmModel::all();

        return view('ukm.edit', compact('breadcrumb', 'page', 'activeMenu', 'ukm', 'kategoriList'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_ukm' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori_ukm,id_kategori',
            'email' => 'required|email',
            'alamat' => 'required|string',
            'deskripsi' => 'required|string',
            'tanggal_berdiri' => 'required|date',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        $ukm = UkmModel::findOrFail($id);
        $ukm->update($request->all());

        return redirect('/ukm')->with('success', 'Data UKM berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        try {
            UkmModel::destroy($id);
            return redirect('/ukm')->with('success', 'Data UKM berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/ukm')->with('error', 'Gagal menghapus UKM. Data masih terkait dengan tabel lain.');
        }
    }
}