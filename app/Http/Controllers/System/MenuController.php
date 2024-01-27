<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Illuminate\Validation\ValidationException;
use App\Models\SysMenu;
use App\Models\User;
use App\Models\SysRole;
use App\Models\SysAction;
use App\Models\SysMenuAction;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = 'Menu';
        $parent = SysMenu::whereNull('parent_id')->orderBy('order','ASC')->get();
        $accessMenu = $this->accessMenu();
        return view('pages.system.menu.index',compact('page_title','parent','accessMenu'));

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
        
        $menu = SysMenu::with('parent')->get();
        return Datatables::of($menu)->make(true);
    }

    public function submit(Request $req)
    {
        try {
            $id = $req['id'];
            unset($req['id']);
            $post = array(
                'parent_id' => $req['MenuParentID'],
                'order' => $req['MenuOrder'],
                'title' => $req['MenuName'],
                'page' => $req['MenuModule'],
                'icon' => $req['MenuIcon'],
                'bullet'=>$req['MenuModule']!=""?null:'line',
                'arrow'=>$req['MenuModule']!=""?null:1,
                'root' => 1,
                'is_parent' => $req['IsParent']
            );
            $check = SysMenu::find($id);
            if(!empty($check)){
                $post['updated_by'] = auth()->user()->id;
                $post['updated_at'] = date('Y-m-d H:i:s');
                SysMenu::find($id)->update($post);
                $MenuID = $id;
            }else{
                $post['created_by'] = auth()->user()->id;
                $post['created_at'] = date('Y-m-d H:i:s');
                $save = SysMenu::create($post);
                $MenuID = $save->id;
            } 

            $ActionID = explode(',',@$req['MenuActionID']);
            if(count($ActionID) > 0 && $ActionID[0]!=''){
                $update = array(
                    'status_code' => 'nullified'
                );
                SysMenuAction::where('menu_id',$MenuID)->update($update);
            
                for($i=0; $i<count($ActionID); $i++){
                    if($ActionID[$i]!='' && $ActionID[$i]!='on'){
 
                    $check_action = SysMenuAction::where('menu_id',$MenuID)->where('action_id',$ActionID[$i])->first();
                        if(!empty($check_action)){
                            $data = array(
                                'menu_id' => $MenuID,
                                'action_id' => $ActionID[$i],
                                'status_code' => 'active',
                                'updated_by' => auth()->user()->id,
                                'updated_at' => date('Y-m-d H:i:s')
                            );
                            SysMenuAction::where('menu_id',$MenuID)->where('action_id',$ActionID[$i])->update($data);
                        }else{
                            $data = array(
                                'menu_id' => $MenuID,
                                'action_id' => $ActionID[$i],
                                'status_code' => 'active',
                                'created_by' => auth()->user()->id,
                                'created_at' => date('Y-m-d H:i:s')
                            );
                            SysMenuAction::create($data);
                        }
                    }
                }
            }

            $return = array(
                'success' => "true",
                'message' => "Data berhasil di simpan.",
                'id' => $MenuID
            );
            return $return;
        } catch (Exception $e) {       // Rollback Transaction
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
        $id = $req->id;
        $hu = SysMenu::findOrfail($id);
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

    public function menuAction(Request $req){
        $menuID =  $req->input('MenuID')?$req->input('MenuID'):0;
        $data =  SysAction::select('sys_actions.id','sys_actions.action_name','sys_actions.action_function','sma.menu_id')
                 ->leftJoin('sys_menu_actions as sma', function($query) use ($menuID)  {
                    $query->on('sma.action_id', '=','sys_actions.id');
                    $query->on('sma.status_code',DB::raw('"active"'));
                    $query->on('sma.menu_id','=',DB::raw($menuID));
                 })
                 ->where('sys_actions.status_code', 'active')
                 ->orderBy('sys_actions.id','ASC')
                 ->get();
        //return response()->json($data);
        return view('pages.system.menu.action',compact('data'));
     

    }





}
