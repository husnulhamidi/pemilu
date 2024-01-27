<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\SubDistrict;

class KecamatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = 'Daftar Kecamatan Dapil 1';
        $accessMenu = $this->accessMenu();
        return view('pages.kecamatan.index',compact('page_title','accessMenu'));

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

        $Voter = SubDistrict::where('DistrictID',10210024)->whereIn('SubDistrictID',[102100240047,102100240013,102100240001,102100240020,102100240037,102100240040])->get(); 
    
        return Datatables::of($Voter)->make(true);
    }

    public function submit(Request $req)
    {
        try {
            $id = $req['id'];
            unset($req['id']);
            $check = SubDistrict::find($id);
            $post = array(
                'no'        => $req['no_urut'],
                'nama'      => $req['nama'],
                'partai'    => $req['partai']
            );
            if(!empty($check)){
                $post['updated_by'] = auth()->user()->id;
                $mare = SubDistrict::find($id)->update($post);
                $lastid_ = $id;
            }else{
                $post['created_by'] = auth()->user()->id;
                $save = SubDistrict::create($post);
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
            $result = SubDistrict::findOrfail($id);
            
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
            $delete = SubDistrict::find($id);
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


}
