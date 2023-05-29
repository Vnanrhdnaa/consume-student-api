<?php
//perbedaan helpres dan libraries
//helpres : bikin api
//libraries : pake api
namespace App\Http\Libraries;
// namespace untuk mengatur posisi file
use Illuminate\Support\Facades\Http;

class BaseApi
{
    //variable yang cuman bisa diakses di class ini dan turunan nya
    protected $baseUrl;
    //constractor fungsinya untuk menyiapkan isi data, dijalankan otomatis tanpa dipanggil
    public function __construct()
    {
        // variable $baseUrl yang diatas diisi nilainya dari isian file .env bagian API_HOST 
        // variable ini diisi otomatis ketika file/class BaseApi dipanggil di controller
        $this->baseUrl = "http://127.0.0.1:2222";
    }
    private function client()
    {
        // koneksikan ip dari variable $baseUrl ke depedency Http
        // menggunakan depedency Http karna project API nya berbasis web ( protocol Http)
        return Http::baseUrl($this->baseUrl);
    }
    public function index(String $endpoint, Array $data = [])
    {
        //manggil ke function client yang diatas, terus manggil  path yang dari $endpoint yang dikirim controller nya, kalau ada data yang mau dicari (params di postman) diambil dari parameter $data
        return $this->client()->get($endpoint, $data);
    }
    
    public function store(String $endpoint, Array $data = [])
    {
        // pake post() karena buat route tambah data di project REST API nya pake ::post
        return $this->client()->post($endpoint, $data);
    }
    public function edit(String $endpoint, Array $data = [])
    {
        return $this->client()->get($endpoint, $data);
    }

    public function update(String $endpoint, Array $data = [])
    {
        return $this->client()->patch($endpoint, $data);
    }

    public function delete(String $endpoint, Array $data = [])
    {
        return $this->client()->delete($endpoint, $data);
    }

    public function trash(String $endpoint, Array $data = [])
    {
        return $this->client()->get($endpoint, $data);
    }

    public function restore(String $endpoint, Array $data = [])
    {
        return $this->client()->get($endpoint, $data);
    }
    
    public function permanent(String $endpoint, Array $data = [])
    {
        return $this->client()->get($endpoint, $data);
    }
}