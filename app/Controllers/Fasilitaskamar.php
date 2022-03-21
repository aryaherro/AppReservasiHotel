<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Fasilitaskamar extends BaseController
{
    public function index()
    {
        // membuat data dengan index JudulHalaman dan mengirim ke views
        $data['JudulHalaman']='Fasilitas Kamar';

        // membuat data index introText dan mengirim ke views
        $data['introText']='<p>Berikut ini adalah daftar fasilitas kamar, silahkan lakukan pengelolaan  fasilitas kamar</p>';
        
        $data['listFasilitas']=$this->fasilitaskamar->find();

        // memanggil file tampil-fasilitas-hotel.php di folder app\views\admin
        return view('admin/tampil-fasilitas-kamar',$data);
    }


    public function tambah(){
        // 1. membuat data dengan index JudulHalaman & intro dan mengirim ke views
        $data['JudulHalaman']='Penambahan Fasilitas Kamar';
        $data['introText']='<p>Silahkan masukan data fasilitas kamar pada form dibawah ini !</p>';

        // 2. load helper form    
        helper(['form']);
        
        // 3. buat aturan form 
        $aturanForm=[
            'txtNamaFasilitas'=>'required',
            'txtDeskrkipsiFasilitas'=>'required'
        ];

        // 4. mengecek apakah tombol simpan diklik ?
        if($this->validate($aturanForm)){
            $foto=$this->request->getFile('txtFotoFasilitas');
            $foto->move('uploads');
            $data=[
                'nama_fasilitas'=> $this->request->getPost('txtNamaFasilitas'),
                'deskripsi_fasilitas' => $this->request->getPost('txtDeskrkipsiFasilitas'),
                'foto_fasilitas'=> $foto->getClientName()
            ];
            $this->fasilitaskamar->save($data);
            return redirect()->to(site_url('/fasilitas-kamar'))->with('info','<div class="alert alert-success">Data berhasil disimpan</div>');
        }

        return view('admin/tambah-fasilitas-kamar',$data);
    } 

    public function hapus($id_fasilitas_kamar){
        $syarat=[
            'id_fasilitas_kamar'=>$id_fasilitas_kamar
        ];

        // ambil nama file yang akan digapus
        $fileInfo=$this->fasilitaskamar->where($syarat)->find()[0];

        if(file_exists('uploads/'.$fileInfo['foto_fasilitas'])){
            unlink('uploads/'.$fileInfo['foto_fasilitas']);

            $this->fasilitaskamar->where($syarat)->delete();
            
            return redirect()->to(site_url('/fasilitas-kamar'))->with('info','<div class="alert alert-success">Data berhasil dihapus</div>');
        }
    }

    public function edit($id_fasilitas_kamar=null){
        
        // 1. Menyiapakan judulHalaman dan intro text

        $data['JudulHalaman']='Perubahan Fasilitas Kamar';
        $data['introText']='<p>Untuk merubah data fasilitas kamar silahkan lakukan perubahan pada form dibawah ini</p>';

        // 2. hanya dijalankan ketika memilih tombol edit
        if($id_fasilitas_kamar!=null){
            // mencari data fasilitas berdasarkan primary key
            $syarat=[
                'id_fasilitas_kamar' => $id_fasilitas_kamar
            ];
            $data['detailFasilitasKamar']=$this->fasilitaskamar->where($syarat)->find()[0];
        }

        // 3. loading helper form
        helper(['form']);
        
        // 4. mengatur form
        $aturanForm=[
            'txtNamaFasilitas'=>'required',
            'txtDeskrkipsiFasilitas'=>'required'
        ];

        // 5. dijalankan saat tombol update ditekan dan semua kolom diisi
        if($this->validate($aturanForm)){

            $foto=$this->request->getFile('txtFotoFasilitas');

            if($foto->isValid()){
                $foto->move('uploads');
                $data=[
                    'nama_fasilitas'=> $this->request->getPost('txtNamaFasilitas'),
                    'deskripsi_fasilitas' => $this->request->getPost('txtDeskrkipsiFasilitas'),
                    'foto_fasilitas'=> $foto->getClientName()
                ];
                unlink('uploads/'.$this->request->getPost('txtFotoFasilitas'));
            } else {
                $data=[
                    'nama_fasilitas'=> $this->request->getPost('txtNamaFasilitas'),
                    'deskripsi_fasilitas' => $this->request->getPost('txtDeskrkipsiFasilitas')
                ];
            }
            
            $this->fasilitaskamar->update($this->request->getPost('txtIdFasilitasKamar'),$data);

            return redirect()->to(site_url('/fasilitas-kamar'))->with('info','<div class="alert alert-success">Data berhasil diupdate</div>');
        } 
        
        return view('admin/edit-fasilitas-kamar',$data);
        
    }




}
