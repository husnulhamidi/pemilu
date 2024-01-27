<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Caleg;

class CalegController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = 'Daftar Caleg';
        $accessMenu = $this->accessMenu();
        return view('pages.caleg.index',compact('page_title','accessMenu'));

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

        $Voter = Caleg::all(); 
    
        return Datatables::of($Voter)->make(true);
    }

    public function submit(Request $req)
    {
        try {
            $id = $req['id'];
            unset($req['id']);
            $check = Caleg::find($id);
            $post = array(
                'no'        => $req['no_urut'],
                'nama'      => $req['nama'],
                'partai'    => $req['partai']
            );
            if(!empty($check)){
                $post['updated_by'] = auth()->user()->id;
                $mare = Caleg::find($id)->update($post);
                $lastid_ = $id;
            }else{
                $post['created_by'] = auth()->user()->id;
                $save = Caleg::create($post);
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
            $result = Caleg::findOrfail($id);
            
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
            $delete = Caleg::find($id);
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
