<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Exp;
use Yajra\DataTables\DataTables;
use Exception;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        if($request->method() == 'POST'){
            $reqDatatable  = $this->requestDatatables($request->input());

            $users = User::with(['role']);

            if ($reqDatatable['orderable']) {
                foreach ($reqDatatable['orderable'] as $order) {
                    if($order['column'] == 'rownum') {
                        $users = $users->orderBy('id', $order['dir']);
                    } else {
                        if(!empty($val['column'])){
                            $users = $users->orderBy($order['column'], $order['dir']);
                        }else{
                            $users = $users->orderBy('id', 'desc');
                        }
                    }
                }
            } else {
                $users = $users->orderBy('id', 'desc');
            }

            $datatables = DataTables::of($users);

            if (isset($reqDatatable['orderable']['rownum'])) {
                if ($reqDatatable['orderable']['rownum']['dir'] == 'desc') {
                    $rownum      = abs($users->count() - ($reqDatatable['start'] * $reqDatatable['length']));
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
                ->addColumn('role', function($data){
                    return $data->role->name;
                })
                ->addColumn('is_active', function($data){
                    $id = $data->id;
                    $isActive = $data->is_active;

                    return view('backend.pages.settings.users.list.active', compact('id', 'isActive'));
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
                        $html .= '<li class="nav-item"><a class="nav-link" href="'. url('admin-cms/settings/users/edit/'.$data->id) .'"><i class="flaticon2-edit nav-icon"></i><span class="nav-text">Edit</span></a></li>';

                        //* DELETE
                        $html .= '<li class="nav-item"><a class="nav-link btn-delete" href="'. url('admin-cms/settings/users/delete/'.$data->id) .'"><i class="flaticon2-delete nav-icon"></i><span class="nav-text">Delete</span></a></li>';
                    $html .= '</ul></div></div>';

                    return $html;
                })
                ->rawColumns(['action'])
                ->toJson(true);
        }

        return view('backend.pages.settings.users.index');
    }

    public function create()
    {
        $roles = Role::get();

        return view('backend.pages.settings.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|unique:users|email',
            'name' => 'required',
            'role_id' => 'required',
            'password' => 'required|min:6',
            'password_confirmation' => 'required_with:password|same:password|min:6'
        ]);

        $input = $request->all();

        try{
            DB::beginTransaction();

            $insert = User::create([
                'email'=> $input['email'],
                'name'=> $input['name'],
                'password'=> bcrypt($input['password']),
                'role_id' => $input['role_id'],
                'is_active' => true
            ]);

            DB::commit();

            return redirect('admin-cms/settings/users')->with(['success' => 'User has been created successfully']);
        }catch(Exception $e){
            DB::rollBack();

            return redirect()->back()->with(['error' => 'Something went wrong, please try again']);
        }
    }

    public function edit($id)
    {
        $data = User::find($id);

        $roles = Role::get();

        return view('backend.pages.settings.users.edit', compact('data', 'roles'));
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'email' => 'required|unique:users,email,'.$id.'|email',
            'name' => 'required',
            'role_id' => 'required',
            'password' => '',
            'password_confirmation' => 'same:password'
        ]);

        $input = $request->all();

        try{
            DB::beginTransaction();

            if(!empty($input['password'])){
                $data = [
                    'email'=> $input['email'],
                    'name'=> $input['name'],
                    'password'=> bcrypt($input['password']),
                    'role_id' => $input['role_id'],
                ];
            }else{
                $data = [
                    'email'=> $input['email'],
                    'name'=> $input['name'],
                    'role_id' => $input['role_id'],
                ];
            }

            $update = User::where('id', $id)->update($data);

            DB::commit();

            return redirect('admin-cms/settings/users')->with(['success' => 'User has been updated successfully']);
        }catch(Exception $e){
            DB::rollBack();

            return redirect()->back()->with(['error' => 'Something went wrong, please try again']);
        }
    }

    public function delete($id)
    {
        try{
            DB::beginTransaction();

            $update = User::where('id', $id)->delete();

            DB::commit();

            return redirect('admin-cms/settings/users')->with(['success' => 'User has been deleted successfully']);
        }catch(Exception $e){
            DB::rollBack();

            return redirect()->back()->with(['error' => 'Something went wrong, please try again']);
        }
    }
}
