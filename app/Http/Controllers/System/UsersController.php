<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use DataTables;

use App\Models\User;
use App\Models\SysRole;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = 'Users';
        $role = SysRole::All();
        $accessMenu = $this->accessMenu();
        return view('pages.system.user.index',compact('page_title','role','accessMenu'));

    }

    private function accessMenu(){
        $result = array(
            'add'           => checkAccess('add'),
            'update'        => checkAccess('update'),
            'delete'        => checkAccess('delete')
        );
        return $result;
    }

    public function ajaxData(Request $request)
    {
        
        $RefUniKompetensi = DB::table('users as u')
                            ->join('sys_roles as r','r.id','=','u.role_id')
                            ->select('u.*','r.role')
                            ->whereIn('u.status_code',['active','inactive'])
                            ->get();
        return Datatables::of($RefUniKompetensi)->make(true);
    }

    public function submit(Request $req)
    {
        try {
            $id = $req['id'];
            unset($req['id']);
            $post = array(
                'nip' => $req['nip'],
                'name' => $req['nama'],
                'email' => $req['email'],
                'role_id' => $req['role_id'],
                'group_id' => $req['role_id'],
                'status_code' => $req['status_code'],
            );
            if($id!=""){
                if($req['password']!=""){
                    $post['password'] = Hash::make($req['password']);
                }
                //$post['updated_by'] = auth()->user()->id;
                $savaUser = User::find($id)->update($post);
                $lastid_ = $id;
            }else{
                if($req['password']!=""){
                    $post['password'] = Hash::make($req['password']);
                }else{
                    $post['password'] = Hash::make(12345678);
                }
                //$post['created_by'] =auth()->user()->id;
                $save = User::create($post);
                $lastid_ = $save->id;
            }

            $return = array(
                'success' => "true",
                'message' => "Data berhasil di simpan.",
                'id' => $lastid_
            );
            return $return;
        } catch (Exception $e) {       // Rollback Transaction
            DB::rollback();
            $return = array(
                'success' => "false",
                'message' => "Terjadi Kesalahan",
                'id' => ""
            );
            return $return;
        }
    }

    public function show(Request $req)
    {
        $id = $req->id;
        $hu = User::findOrfail($id);
        if(!empty($hu)){
            $return= $hu;
        }else{
            $return= array();
        }
        return $return;
    }

    public function destroy(Request $req)
    {
        $id = $req->id;
        $delete = User::find($id)->update(['status_code'=>'nullified']);
        if ($delete){
            $ret = "true";
            $message = 'Data berhasil di hapus.';
        }else{
            $ret = "false";
            $message = 'Data gagal di hapus. Refresh dan coba kembali. Jika masih error hubungi Administrator.';
        }
        $return = array(
            'success' => $ret,
            'message' => $message
        );
        return $return;
    }

    public function updateProfile(Request $req)
    {
        $userID = auth()->user()->id;
        $user = User::findOrfail($userID);
        
        if (!empty($user)){
            $passUpdate =  array(
                'password' => Hash::make($req['password']),
                'last_updated'  =>date('Y-m-d')
            );
            User::where('id',$userID)->update($passUpdate);
            $ret = "true";
            $message = 'Password berhasil diupdate.';
        }else{
            $ret = "false";
            $message = 'Password gagal diupdate. Refresh dan coba kembali. Jika masih error hubungi Administrator.';
        }
        $return = array(
            'success' => $ret,
            'message' => $message
        );
        return $return;
    }

    public function submitUpdatepassword(Request $req)
    {
        try {
            //code...
            $userID = auth()->user()->id;
            $user = User::findOrfail($userID);
            $password = $req->input('password_up');
            if (!empty($user)){
                $passUpdate =  array(
                    'password' => Hash::make($password),
                    'last_updated'  =>date('Y-m-d')
                );
                User::find($userID)->update($passUpdate);
                $ret = "true";
                $message = 'Password berhasil diupdate.';
            }else{
                $ret = "false";
                $message = 'Password gagal diupdate. Refresh dan coba kembali. Jika masih error hubungi Administrator.';
            }
            $return = array(
                'success' => $ret,
                'message' => $message
            );
            return $return;
        } catch (\Throwable $th) {
            $return = array(
                'success' => "false",
                'message' => $th->getMessage()
            );
        }
    }



}
