<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Agoenxz21\Datatables\Datatable;
use App\Models\TipetarifModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class TipetarifController extends BaseController

{
    public function index()
    {
        return view('Tipetarif/table');
    }
    public function all(){
        $pm = new TipetarifModel();
        $pm ->select('id, tipe, keterangan, urutan, aktif');

        return (new Datatable($pm))
            ->setFieldFilter(['id','tipe', 'keterangan', 'urutan', 'aktif'])
            ->draw();
    }
    public function show($id){
        $r = (new TipetarifModel())->where('id',$id)->first();
        if($r == null)throw PageNotFoundException::forPageNotFound();

        return $this->response->setJSON($r);
}
public function store(){
    $pm = new TipetarifModel();

    $id = $pm->insert([
        'tipe'          => $this->request->getVar('tipe'),
        'keterangan'    => $this->request->getVar('keterangan'),
        'urutan'        => $this->request->getVar('urutan'),
        'aktif'    => $this->request->getVar('aktif'),
    ]);
    return $this->response->setJSON(['id' => $id])
    ->setStatusCode(intval($id) > 0 ? 200 : 406);
}
public function update(){
    $pm = new TipetarifModel();
    $id = (int)$this->request->getVar('id');
    
    if($pm->find($id) == null)
    throw PageNotFoundException::forPageNotFound();
    
    $hasil = $pm ->update($id, [
        'tipe'          => $this->request->getVar('tipe'),
        'keterangan'    => $this->request->getVar('keterangan'),
        'urutan'        => $this->request->getVar('urutan'),
        'aktif'         => $this->request->getVar('aktif'),
    ]);
    return $this->response->setJSON(['result' =>$hasil]);
}
public function delete(){
    $pm = new TipetarifModel();
    $id = $this->request->getVar('id');
    $hasil = $pm->delete($id);
    return $this->response->setJSON(['result' => $hasil]);
}
}