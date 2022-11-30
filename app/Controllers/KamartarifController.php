<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Agoenxz21\Datatables\Datatable;
use App\Models\KamartarifModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class KamartarifController extends BaseController

{
    public function index()
    {
        return view('Kamartarif/table');
    }
    public function all(){
        $pm = new KamartarifModel();
        $pm ->select('id, kamartipe_id, tarif, tgl_mulai, tgl_selesai, tipetarif_id');

        return (new Datatable($pm))
            ->setFieldFilter(['id','kamartipe_id', 'tarif', 'tgl_mulai', 'tgl_selesai', 'tipetarif_id'])
            ->draw();
    }
    public function show($id){
        $r = (new KamartarifModel())->where('id',$id)->first();
        if($r == null)throw PageNotFoundException::forPageNotFound();

        return $this->response->setJSON($r);
}
public function store(){
    $pm = new KamartarifModel();

    $id = $pm->insert([
        'kamartipe_id'       => $this->request->getVar('kamartipe_id'),
        'tarif'              => $this->request->getVar('tarif'),
        'tgl_mulai'          => $this->request->getVar('tgl_mulai'),
        'tgl_selesai'        => $this->request->getVar('tgl_selesai'),
        'tipetarif_id'       => $this->request->getVar('tipetarif_id'),
    ]);
    return $this->response->setJSON(['id' => $id])
    ->setStatusCode(intval($id) > 0 ? 200 : 406);
}
public function update(){
    $pm = new KamartarifModel();
    $id = (int)$this->request->getVar('id');
    
    if($pm->find($id) == null)
    throw PageNotFoundException::forPageNotFound();
    
    $hasil = $pm ->update($id, [
        'kamartipe_id'       => $this->request->getVar('kamartipe_id'),
        'tarif'              => $this->request->getVar('tarif'),
        'tgl_mulai'          => $this->request->getVar('tgl_mulai'),
        'tgl_selesai'        => $this->request->getVar('tgl_selesai'),
        'tipetarif_id'       => $this->request->getVar('tipetarif_id'),
    ]);
    return $this->response->setJSON(['result' =>$hasil]);
}
public function delete(){
    $pm = new KamartarifModel();
    $id = $this->request->getVar('id');
    $hasil = $pm->delete($id);
    return $this->response->setJSON(['result' => $hasil]);
}
}