<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PerangkatModel;
use App\Models\MutasiModel;
use Config\Database;
use Config\Services;

class AdminController extends BaseController
{
    protected $perangkatModel;
    protected $mutasiModel;
    protected $db;
    protected $session;

    public function __construct()
    {
        $this->perangkatModel = new PerangkatModel();
        $this->mutasiModel = new MutasiModel();
        $this->db = Database::connect();

        $this->session = Services::session();
        helper('form');
    }

    public function index()
    {
        return view('login');
    }

    public function auth()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $admin = $this->db->table('admin')->where('username', $username)->get()->getRowArray();
        if ($admin && password_verify($password, $admin['password'])){
            $this->session->set('admin', $admin);
            return redirect()->to('/dashboard');
        }
        else{
            $this->session->setFlashdata('error', 'username atau password salah');
            return redirect()->to('/');
        }
    }

    public function logout()
    {
        $this->session->remove('admin');
        return redirect()->to('/');
    }

    public function dashboard()
    {
        if(!session()->get('admin')){
            return redirect()->to('/');
        }

        $data['mutasi']=$this->mutasiModel->findAll();
        return view('dashboard', $data);
    }

    public function editMutasi($id)
    {
        $mutasi = $this->mutasiModel->find($id);
        $id_perangkat = $mutasi['id_perangkat'];
        $status_baru = $this->request->getPost('status');

        $this->mutasiModel->update($id, [
            'status'=>$status_baru,
            'waktu'=>date('Y-m-d H:i:s')
        ]);

        if ($status_baru === 'dibawa' || $status_baru === 'terpasang'){
            $this->perangkatModel->update($id_perangkat, ['status'=>'tidak tersedia']);
        }
        elseif ($status_baru === 'kembali'){
            $this->perangkatModel->update($id_perangkat, ['status'=>'tersedia']);
        }
        return redirect()->to('/dashboard');
    }
}
