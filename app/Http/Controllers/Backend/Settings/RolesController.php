<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use Yajra\DataTables\DataTables;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $reqDatatable  = $this->requestDatatables($request->input());

            $roles = new Role();

            if ($reqDatatable['orderable']) {
                foreach ($reqDatatable['orderable'] as $order) {
                    if($order['column'] == 'rownum') {
                        $roles = $roles->orderBy('id', $order['dir']);
                    } else {
                        if(!empty($val['column'])){
                            $roles = $roles->orderBy($order['column'], $order['dir']);
                        }else{
                            $roles = $roles->orderBy('id', 'desc');
                        }
                    }
                }
            } else {
                $roles = $roles->orderBy('id', 'desc');
            }

            $datatables = DataTables::of($roles);

            if (isset($reqDatatable['orderable']['rownum'])) {
                if ($reqDatatable['orderable']['rownum']['dir'] == 'desc') {
                    $rownum      = abs($roles->count() - ($reqDatatable['start'] * $reqDatatable['length']));
                    $is_increase = false;
                } else {
                    $rownum = ($reqDatatable['start'] * $reqDatatable['length']) + 1;
                    $is_increase = true;
                }
            } else {
                $rownum      = ($reqDatatable['start'] * $reqDatatable['length']) + 1;
                $is_increase = true;
            }

            return $datatables
                ->addColumn('rownum', function() use (&$rownum, $is_increase) {
                    if ($is_increase == true) {
                        return $rownum++;
                    } else {
                        return $rownum--;
                    }
                })
                ->addColumn('is_active', function($data){
                    $id = $data->id;
                    $isActive = $data->is_active;

                    return view('backend.pages.settings.roles.list.active', compact('id', 'isActive'));
                })
                ->editColumn('created_at', function($data){
                    return date('d F Y H:i:s', strtotime($data->created_at));
                })
                ->editColumn('updated_at', function($data){
                    return date('d F Y H:i:s', strtotime($data->updated_at));
                })
                ->addColumn('action', function($data){
                    $html = '<div class="dropdown dropdown-inline mr-1"><a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown" aria-expanded="false"><i class="flaticon2-menu-1 icon-2x"></i></a><div class="dropdown-menu dropdown-menu-sm dropdown-menu-right"><ul class="nav nav-hoverable flex-column">';
                        //* EDIT
                        $html .= '<li class="nav-item"><a class="nav-link" href="'. url('admin-cms/settings/roles/edit/'.$data->id) .'"><i class="flaticon2-edit nav-icon"></i><span class="nav-text">Edit</span></a></li>';

                        //* DELETE
                        $html .= '<li class="nav-item"><a class="nav-link btn-delete" href="'. url('admin-cms/settings/roles/delete/'.$data->id) .'"><i class="flaticon2-delete nav-icon"></i><span class="nav-text">Delete</span></a></li>';
                    $html .= '</ul></div></div>';

                    return $html;
                })
                ->rawColumns(['action'])
                ->toJson(true);
        }

        return view('backend.pages.settings.roles.index');
    }

    public function create()
    {
        return view('backend.pages.settings.roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles'
        ]);

        $input = $request->all();

        try{
            DB::beginTransaction();

            $insert = Role::create([
                'name' => $input['name'],
                'is_active' => true
            ]);

            DB::commit();

            return redirect('admin-cms/settings/roles')->with(['success' => 'Role has been created successfully']);
        }catch(Exception $e){
            DB::rollBack();

            return redirect()->back()->with(['error' => 'Something went wrong, please try again']);
        }
    }

    public function edit($id)
    {
        $data = Role::find($id);

        return view('backend.pages.settings.roles.edit', compact('data'));
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,'.$id,
        ]);

        $input = $request->all();

        try{
            DB::beginTransaction();

            $update = Role::where('id', $id)->update([
                'name'=> $input['name']
            ]);

            DB::commit();

            return redirect('admin-cms/settings/roles')->with(['success' => 'Role has been updated successfully']);
        }catch(Exception $e){
            DB::rollBack();

            return redirect()->back()->with(['error' => 'Something went wrong, please try again']);
        }
    }

    public function changeStatus(Request $request)
    {
        $input = $request->all();
        $isAjax = $request->ajax() ? true : false;
        $user   = Auth::user();

        unset($input['_token']);

        if($isAjax){
            $id = $input['id'];
            $isError = true;

            $status = $input['status'] == '0' ? false : true;

            try {
                DB::beginTransaction();

                $update = Role::where('id', $id)->update([
                    'is_active' => $status
                ]);

                DB::commit();

                return response([
                    'success' => true,
                    'code' => 200,
                    'message' => 'Status has been changed successfully'
                ]);
            }catch(Exception $e){
                DB::rollBack();

                return response([
                    'success' => false,
                    'code' => 500,
                    'message' => 'Something went wrong'
                ]);
            }
        }
    }

    public function delete($id)
    {
        try{
            DB::beginTransaction();

            $delete = Role::where('id', $id)->delete();

            DB::commit();

            return redirect('admin-cms/settings/roles')->with(['success' => 'Role has been deleted successfully']);
        }catch(Exception $e){
            DB::rollBack();

            return redirect()->back()->with(['error' => 'Something went wrong, please try again']);
        }
    }
}
