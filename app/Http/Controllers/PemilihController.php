<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use DataTables;
use App\Imports\VotersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Voter;

class PemilihController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = 'Daftar Pemilih';
        $accessMenu = $this->accessMenu();
        return view('pages.pemilih.index',compact('page_title','accessMenu'));

    }

    private function accessMenu(){

        $result = array(
            'add'           => true,
            'update'        => true,
            'delete'        => true
        );
        return $result;
    }

    public function ajaxData(Request $request)
    {

        $Voter = Voter::all(); 
    
        return Datatables::of($Voter)->make(true);
    }

    public function submit(Request $req)
    {
        try {
            $id = $req['id'];
            unset($req['id']);
            $check = Voter::find($id);
            $post = array(
                'nama' => $req['nama'],
                'nik' => $req['nik'],
                'telp' => $req['telp'],
                'umur' => $req['umur'],
                'status' => $req['status'],
                'alamat' => $req['alamat']
            );
            if(!empty($check)){
                $post['updated_by'] = auth()->user()->id;
                $mare = Voter::find($id)->update($post);
                $lastid_ = $id;
            }else{
                $post['created_by'] = auth()->user()->id;
                $save = Voter::create($post);
                $lastid_ = $save->id;
            }

            $return = array(
                'success' => "true",
                'message' => "Data berhasil di simpan.",
                'id' => $lastid_
            );
            return $return;
        } catch (\Throwable $e) {       
            // Rollback Transaction
            DB::rollback();
            $return = array(
                'success' => "false",
                'message' => $e->getMessage(),
                'id' => ""
            );
            return $return;
        }
    }

    public function show(Request $req)
    {
        
        try {
            $return = array();
            $id = $req->id;
            $result = Voter::findOrfail($id);
            
            return $result;
        } catch (\Throwable $th)
        { 
            $return = array(
                'success' => "false",
                'message' => $th->getMessage(),
                'id' => ""
            );
            return $return;
        }
    }
    public function destroy(Request $req)
    {
        
        try {
            
            $id = $req->input('id');
            $delete = Voter::find($id);
            $delete->delete();
            $return = array(
                'success' => "true",
                'message' => 'Data berhasil di hapus.'
            );
            return $return;
        } catch (\Throwable $ex) {
            $return = array(
                'success' => "false",
                'message' => $ex->getMessage(),
            );
            return $return;
        }
       
    }

    public function importExcel(Request $request) 
	{
		$this->validate($request, [
			'dokumen_pemilih' => 'required|mimes:csv,xls,xlsx'
		]);
        
		$nama_file = rand().$request->file('dokumen_pemilih')->getClientOriginalName();
 		$request->file('dokumen_pemilih')->move('files/import',$nama_file);

        try {
            Excel::import(new VotersImport, public_path('/files/import/'.$nama_file));

            return [
                'success' => true,
                'message' => 'Data berhasil di simpan.'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
	}


}
