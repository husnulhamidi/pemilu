<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
Use Exception;

use App\Models\Invoice;
use App\Models\InvoiceChecklistKelengkapan;
use App\Models\Library;
use App\Models\SysVendor;

class AutocompleteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datalist(Request $req)
    {
        $field = $req->input('field');
        try {
                $result = Invoice::select($field.' as label')->where($req->input('field'),'like', '%'.$req->input('keyword').'%')
                ->groupBy($req->input('field'))
                ->limit(10)
                ->get();

                $data = "";   
                
                foreach ($result as $key => $val) {
                    $data .= '<option value="'.$val->label.'">'.$val->label.'</option>';
                }
                
                echo $data; 
        } catch (\Throwable $ex) {
            $return = array(
                'success' => "false",
                'message' =>  $message = $ex->getMessage() .' in file ' .$ex->getFile() .' at line ' .$ex->getLine(),
            );
            return $return;
        }
        
          
        
    }

    public function datalistKet(Request $req)
    {
        
        try {
                $result = InvoiceChecklistKelengkapan::select('keterangan')->where($req->input('field'),'like', '%'.$req->input('keyword').'%')
                ->groupBy($req->input('field'))
                ->limit(10)
                ->get();

                $data = "";   
                foreach ($result as $key => $val) {
                    $data .= '<option value="'.$val->keterangan.'">'.$val->keterangan.'</option>';
                }
                 
                echo $data; 
        } catch (\Throwable $ex) {
            //$ex->getMessage() .' in file ' .$ex->getFile() .' at line ' .$ex->getLine();
            $return = array(
                'success' => "false",
                'message' =>  $ex->getMessage(),
            );
            return $return;
        }
           
    }

    public function datalistVendor(Request $req){
        try {
           
            $vendor = SysVendor::where('vendor','like', '%'.$req->input('keyword').'%')->where('status_code','active')->get();
    
            $data =array();
            $data = '<option value="">-- Pilih Vendor --</option>';
            $i=0;
            foreach ($vendor as $key) {
                $i++;
                $selected="";
                $data .= '<option value="'.$key->vendor.'">'.$key->vendor.'</option>';
            }
            
            $return = array(
                'success' => "true",
                'message' => "load vendor berhasil",
                'data' => $data
            );
            return $return;
        } catch (\Throwable $th) {
            $return = array(
                'success' => "false",
                'message' => $th->getMessage(),
                'data' => array()
            );
            return $return;
        }
    }

    



}
