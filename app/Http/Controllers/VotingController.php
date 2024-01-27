<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\HasilPemilu;
use App\Models\Caleg;
use App\Models\SubDistrict;
use App\Models\Village;

class VotingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = 'Perolehan Suara';
        $accessMenu = $this->accessMenu();
        $caleg = Caleg::all();
        $kecamatan = SubDistrict::where('DistrictID',10210024)->whereIn('SubDistrictID',[102100240047,102100240013,102100240001,102100240020,102100240037,102100240040])->get(); 
        return view('pages.voting.index',compact('page_title','accessMenu','caleg','kecamatan'));

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

        $Voter = HasilPemilu::with(['subdistrict','village','caleg'])->get(); 
    
        return Datatables::of($Voter)->make(true);
    }

    public function submit(Request $req)
    {
        try {
            $id = $req['id'];
            unset($req['id']);
            $check = HasilPemilu::find($id);
            $post = array(
                'caleg_id'        => $req['caleg_id'],
                'SubDistrictID'   => $req['kecamatan'],
                'VillageID'     => $req['desa'],
                'no_tps'        => $req['no_tps'],
                'suara'         => $req['suara']
            );
            if(!empty($check)){
                $post['updated_by'] = auth()->user()->id;
                $mare = HasilPemilu::find($id)->update($post);
                $lastid_ = $id;
            }else{
                $post['created_by'] = auth()->user()->id;
                $save = HasilPemilu::create($post);
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
            $result = HasilPemilu::findOrfail($id);
            
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
            $delete = HasilPemilu::find($id);
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

    public function comboDesa(Request $req)
    {
        $thn = date('Y');
        $kecamatan_id =  $req->input('kecamatan_id');
        $desa_id =  $req->input('desa_id');
        $village = Village::select('VillageID','VillageName')->where('SubDistrictID',$kecamatan_id)->get();
        $data =array();
        $data = '<option value="">--- Silahkan Pilih ---</option>';
        
        $i=0;
        foreach ($village as $key) {
            $i++;
            $selected="";
            if($desa_id==$key->VillageID){
                $selected="selected";
            }
            $data .= '<option value="'.$key->VillageID.'" '.$selected.'>'.$key->VillageName.'</option>';

        }
        return $data;
    }


}
