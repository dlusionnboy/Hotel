<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Agoenxz21\Datatables\Datatable;
use App\Models\KamarstatusModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class KamarstatusController extends BaseController

{
    public function index()
    {
        return view('Kamarstatus/table');
    }
    public function all(){
        $pm = new KamarstatusModel();
        $pm ->select('id, status, keterangan, urutan, aktif');

        return (new Datatable($pm))
            ->setFieldFilter(['id', 'status', 'keterangan', 'urutan', 'aktif'])
            ->draw();
    }
    public function show($id){
        $r = (new KamarstatusModel())->where('id',$id)->first();
        if($r == null)throw PageNotFoundException::forPageNotFound();

        return $this->response->setJSON($r);
}
public function store(){
    $pm = new KamarstatusModel();

    $id = $pm->insert([
        'status'                => $this->request->getVar('status'),
        'keterangan'            => $this->request->getVar('keterangan'),
        'urutan'                => $this->request->getVar('urutan'),
        'aktif'                 => $this->request->getVar('aktif'),
    ]);
    return $this->response->setJSON(['id' => $id])
    ->setStatusCode(intval($id) > 0 ? 200 : 406);
}
public function update(){
    $pm = new KamarstatusModel();
    $id = (int)$this->request->getVar('id');
    
    if($pm->find($id) == null)
    throw PageNotFoundException::forPageNotFound();
    
    $hasil = $pm ->update($id, [
        'status'             => $this->request->getVar('status'),
        'keterangan'         => $this->request->getVar('keterangan'),
        'urutan'             => $this->request->getVar('urutan'),
        'aktif'              => $this->request->getVar('aktif'),
    ]);
    return $this->response->setJSON(['result' =>$hasil]);
}
public function delete(){
    $pm = new KamarstatusModel();
    $id = $this->request->getVar('id');
    $hasil = $pm->delete($id);
    return $this->response->setJSON(['result' => $hasil]);
}
}