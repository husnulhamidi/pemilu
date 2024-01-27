<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;

use App\Models\User;
use App\Models\SysRole;
use App\Models\SysMenu;
use App\Models\SysMenuAction;
use App\Models\SysRoleMenuAction;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = 'Roles';
        $accessMenu = $this->accessMenu();
        return view('pages.system.role.index',compact('page_title','accessMenu'));

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
        
        $role = SysRole::All();
        return Datatables::of($role)->make(true);
    }

    public function store(Request $req)
    {
        try {
            $id = $req['id'];
            unset($req['id']);
           
            $post = array(
                'role' => $req['role'],
            );
            if($id!=""){
                $savaRole = SysRole::find($id)->update($post);
                $lastid_ = $id;
            }else{
                $savaRole = SysRole::create($post);
                $lastid_ = $savaRole->id;
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
                'message' => "Terjadi Kesalahan. Data gagal disimpan !",
                'id' => ""
            );
            return $return;
        }
    }

    public function submit(Request $req)
    {
        try {
            $id = $req['id'];
            unset($req['id']);
            $MenuAccess = explode(',',$req->input('MenuAccess'));

            $post = array(
                // 'is_disposisi' => $req['is_disposisi'],
                // 'is_back_document' => $req['is_back_document'],
                // 'is_confirm_document' => $req['is_confirm_document'],
                // 'is_update_document' => $req['is_update_document'],
                'is_update_text' => $req['is_update_text'],
            );
            if($id!=""){
                $savaRole = SysRole::find($id)->update($post);
                $lastid_ = $id;
            }else{
                $savaRole = SysRole::create($post);
                $lastid_ = $savaRole->id;
            }

            if($savaRole){
                if(count($MenuAccess) > 0 && $MenuAccess[0]!='' && intval($id) > 0){
                    SysRoleMenuAction::where('role_id',$id)->delete();

                    for($i=0; $i<count($MenuAccess); $i++){
                        if($MenuAccess[$i]!='' && $MenuAccess[$i]!='on'){
                            $insert = array(
                                'role_id'        => $id,
                                'menu_action_id' => $MenuAccess[$i],
                                'created_by' => auth()->user()->id,
                            );
                            SysRoleMenuAction::create($insert);

                        }
                    }
                }
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
                'message' => "Terjadi Kesalahan. Data gagal disimpan !",
                'id' => ""
            );
            return $return;
        }
    }

    public function show(Request $req)
    {
        $id = $req->id;
        $hu = SysRole::findOrfail($id);
        if(!empty($hu)){
            $return= $hu;
        }else{
            $return= array();
        }
        return $return;
    }

    public function destroy(Request $req)
    {
        $id = $req->input('id');
        $delete = SysRole::find($id)->delete();
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

    public function roleAccess(Request $req){
        $role_id = $req->input('role_id');
        $data = SysMenu::
        with(['submenu' => function ($builder) use ($role_id) {
            $builder->with(['menu_action' => function ($builder) use ($role_id) {
                $builder->with(['action']);
                $builder->with(['role_menu_access' => function ($builder) use ($role_id) {
                    $builder->where('role_id',$role_id);
                }]);
            }]);
        },
        'menu_action' => function ($builder) use ($role_id) {
            $builder->with(['action']);
            $builder->with(['role_menu_access' => function ($builder) use ($role_id) {
                $builder->where('role_id',$role_id);
            }]);
        }])
        ->where([['is_parent', '=', '1'], ['status_code', '=', 'active']])
        ->orderBy('order','ASC')
        ->get();

        return view('pages.system.role.form_role_access',compact('data'));
    }



}
