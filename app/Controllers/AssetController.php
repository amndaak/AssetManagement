<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PerangkatModel;
use App\Models\MutasiModel;

class AssetController extends BaseController
{
    protected $perangkatModel;
    protected $mutasiModel;

    public function __construct()
    {
        $this->perangkatModel = new PerangkatModel();
        $this->mutasiModel = new MutasiModel();
    }

    public function index()
    {
        $data['perangkat'] = $this->perangkatModel->where('status', 'tersedia')->findAll();
        return view('formmutasi', $data);
    }

    public function simpanMutasi()
    {
        $id_perangkat_list = $this->request->getPost('id_perangkat');
        $status = 'dibawa';
        $user = $this->request->getPost('user');
        $keterangan_list = $this->request->getPost('keterangan');

        foreach($id_perangkat_list as $id_perangkat){
            $keterangan = $keterangan_list[$id_perangkat] ?? '';
        
            $this->mutasiModel->insert([
                'id_perangkat'=>$id_perangkat,
                'user'=>$user,
                'status'=>$status,
                'keterangan'=>$keterangan,
                'waktu'=>date('Y-m-d H:i:s')
            ]);

            $this->perangkatModel->update($id_perangkat, ['status'=>'tidak tersedia']);
        }
        return redirect()->to('/');
    }
}