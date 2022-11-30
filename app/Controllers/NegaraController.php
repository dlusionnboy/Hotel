<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Agoenxz21\Datatables\Datatable;
use App\Models\NegaraModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class NegaraController extends BaseController

{
    public function index()
    {
        return view('Negara/table');
    }
    public function all(){
        $pm = new NegaraModel();
        $pm ->select('id, negara');

        return (new Datatable($pm))
            ->setFieldFilter(['id', 'negara'])
            ->draw();
    }
    public function show($id){
        $r = (new NegaraModel())->where('id',$id)->first();
        if($r == null)throw PageNotFoundException::forPageNotFound();

        return $this->response->setJSON($r);
}
public function store(){
    $pm = new NegaraModel();

    $id = $pm->insert([
        'negara'             => $this->request->getVar('negara'),
    ]);
    return $this->response->setJSON(['id' => $id])
    ->setStatusCode(intval($id) > 0 ? 200 : 406);
}
public function update(){
    $pm = new NegaraModel();
    $id = (int)$this->request->getVar('id');
    
    if($pm->find($id) == null)
    throw PageNotFoundException::forPageNotFound();
    
    $hasil = $pm ->update($id, [
        'negara'             => $this->request->getVar('negara'),
    ]);
    return $this->response->setJSON(['result' =>$hasil]);
}
public function delete(){
    $pm = new NegaraModel();
    $id = $this->request->getVar('id');
    $hasil = $pm->delete($id);
    return $this->response->setJSON(['result' => $hasil]);
}
}