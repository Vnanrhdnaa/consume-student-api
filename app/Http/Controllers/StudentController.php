<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Libraries\BaseApi;

class StudentController extends Controller
{

    public function index(Request $request)
    {
        //mengambil data dari input search
        $search = $request->search;
        // memanggil libraries BaseApi method nya index dengan mengirim parameter1 berupa path data dari API nya, parameter2 data untuk mengisi search_nama API nya. ringkas nya: (ngirim request search_nama baseapi nya)
        $data = (new BaseApi)->index('/api/students', ['search_nama' => $search]);
        // ambil response jsonnya
        $students = $data->json();
       // dd($students);
        //kirim hasil pengambilan data ke blade index. $students ['data']] fungsi nya untuk
        return view ('index')->with(['students' => $students ['data']]);
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $data = [
            'nama' => $request->nama,
            'nis' => $request->nis,
            'rombel' => $request->rombel,
            'rayon' => $request->rayon,
        ];
        $proses =  (new BaseApi)->store('/api/students/tambah-data', $data);
        if ($proses->failed()) {
            $errors = $proses->json('data');
            return redirect()->back()->with(['errors' => $errors]);
        }else {
            return redirect('/')->with('success', 'Berhasil menambahkan data baru ke students API');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // proses ambil data api ke route REST API /students/{id}
        $data = (new BaseApi)->edit('/api/students/' .$id);
        if ($data->failed()) {
            // kalau gagal proses $data diatas, ambil deksripsi error dari json property data
            $errors = $data->json('data');
            // balikin ke halaman awal, sama errors nya
            return redirect()->back()->with(['errors' => $errors]);
        }else {
            // kalau berhasil, ambil data dari json nya
            $student = $data->json(['data']);
            // alihin ke blade edit dengan mengirim data $student diatas agar bisa digunakan pada blade
            return view('edit')->with(['student' => $student]);
        }
    }

    public function update(Request $request, string $id)
    {
        // data yang akan dikirim ($request ke REST API nya)
        $payload = [
            'nama' => $request->nama,
            'nis' => $request->nis,
            'rombel' => $request->rombel,
            'rayon' => $request->rayon,
        ];
        // panggil method update dari BaseApi, kirim endpoint (route update dari REST API nya) dan data ($payload diatas)
        $proses = (new BaseApi)->update('/api/students/update/' .$id, $payload);
        if ($proses->failed()) {
            // kalau gagal, balikin lagi sama pesan errors dari json nya
            $errors = $proses->json('data');
            return redirect()->back()->with(['errors' => $errors]);
        }else {
            // berhasil, balikin ke halaman paling awal dengan pesan
            return redirect('/')->with('success', 'Berhasil mengubah data siswa dari API');
        }
    }

    public function destroy($id)
    {
        $proses = (new BaseApi)->delete('/api/students/delete/' .$id);
        if ($proses->failed()) {
            $errors = $proses->json('data');
            return redirect()->back()->with(['errors' => $errors]);
        }else {
            return redirect('/')->with('success', 'Berhasil hapus data sementara dari API');
        }
    }

    public function trash()
    {
        $proses = (new BaseApi)->trash('/api/students/show/trash/');
        if ($proses->failed()) {
            $errors = $proses->json('data');
            return redirect()->back()->with(['errors' => $errors]);
        }else {
            $studentsTrash = $proses->json('data');
            return view('trash')->with(['studentsTrash' => $studentsTrash]);
        }
    }
    public function permanent($id)
    {
        $proses = (new BaseApi)->permanent('/api/students/trash/delete/permanent' .$id);
        if ($proses->failed()) {
            $errors = $proses->json('data');
            return redirect()->back()->with(['errors' => $errors]);
        }else {
            return redirect()->back()->with('success', 'Berhasil menghapus data secara permanent');
        }
    }
    public function restore($id)
    {
        $proses = (new BaseApi)->restore('/api/students/trash/restore/' .$id);
        if ($proses->failed()) {
            $errors = $proses->json('data');
            return redirect()->back()->with(['errors' => $errors]);
        }else {
            return redirect('/')->with('success', 'Berhasil mengembalikan data dari sampah!');
        }
    }
}

