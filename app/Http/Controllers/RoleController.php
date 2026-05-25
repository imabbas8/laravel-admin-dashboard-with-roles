<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DataTables;
use Carbon\Carbon;
use Auth;
use App\Models\User;
use App\Models\Organization;
use DB;
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if (request()->ajax()) {
            // if ($user->hasRole('super-admin')) {
            //     $datatables = Role::get();

            // }
            // else {

            //     $datatables = Role::where('organization_id', $user->organization_id)->get();
            // }
            $datatables = Role::
                where('organization_id', $user->organization_id)
                ->when($user->hasRole('admin'), function ($query) {
                $query->where('name', '!=', 'super-admin');
            })
                ->get();
            return DataTables::of($datatables)
                ->editColumn('created_at', function ($row) {
                $date = Carbon::parse($row->created_at)->format('M-d-Y  h:i:A');
                return $date;
            })->addColumn('action', function ($row) {



                $btn = "";

                if (Auth::user()->can('admin.role-edit')) {
                    $btn .= ' <div class="menu-item px-3">
                                    <a href="#" data-id="' . $row->id . '" 
                                    data-type_status="edit" class="menu-link px-3" data-kt-docs-table-filter="edit_row"
                                    onclick="editRole(this)"
                                    >
                                        Edit
                                    </a>
                                </div>';
                }

                if (Auth::user()->can('admin.role-delete')) {

                    // $btn .= '<div class="menu-item px-3">
                    //                 <a href="#" data-id="' . $row->id . '" data-type_status="trash" class="menu-link px-3" data-kt-docs-table-filter="delete_row">
                    //                     Trash
                    //                 </a>
                    //             </div>';
                    $btn .= '<div class="menu-item px-3">
                                    <a href="#" data-id="' . $row->id . '" data-type_status="delete" class="menu-link px-3" data-kt-docs-table-filter="delete_row">
                                        Delete
                                    </a>
                                </div>';
                }



                $btn = '<a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                                Actions
                                <span class="svg-icon fs-5 m-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                            <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="currentColor" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999)"></path>
                                        </g>
                                    </svg>
                                </span>
                            </a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                
                                ' . $btn . '
                               
                                
                            </div>
                            <!--end::Menu-->';
                return $btn;
            })->toJson();
        }

        $permission = Permission::
            where('name', 'NOT LIKE', '%update%')
            ->where('name', 'NOT LIKE', '%store%');


        if (!Auth::user()->hasRole('super-admin')) {
            $permission->where('name', 'NOT LIKE', '%super%');

        }
        $permissions = $permission->get();

        // return $permissions;
        return view('admin.roles.index', compact('permissions'));
    }
    public function UserList($id)
    {
        $title = "User list by Roles";
        $id = intval($id);
        $user = Auth::user();
        if ($user->hasRole('super-admin')) {
            $users = User::with('organization')
                ->with('roles')->whereRelation('roles', 'id', '=', $id)->get();
        }
        else {
            $users = User::where('organization_id', $user->organization_id)
                ->with('organization')
                ->with('roles')->whereRelation('roles', 'id', '=', $id)->get();
        }
        
        return view('admin.roles.users', compact('title', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // return $request->all();

        $permissionCheckBox = collect($request->permissionCheckBox)
            ->map(fn($id) => (int)$id)
            ->toArray();

        $name = $request->name;

        $roles = Role::
            where('name', $name)
            ->where('organization_id', Auth::user()->organization_id)
            ->where('guard_name', 'web')
            ->first();

        // DB::table('role_has_permissions')->where('role_id', $roles->id)->delete();


        if ($roles) {
            return redirect()->route('admin.role-list')->with('error', 'Role already exists');
        }

        $role = Role::firstOrCreate([
            'name' => $name,
            'organization_id' => Auth::user()->organization_id,
            'guard_name' => 'web',
        ]);


        $role->syncPermissions($permissionCheckBox);

        // $data = [];
        // foreach ($permissionCheckBox as $perm_id) {
        //     $data[] = [
        //         'role_id' => $role->id,
        //         'permission_id' => $perm_id,
        //     ];
        // }

        // DB::table('role_has_permissions')->insert($data);



        // return $role;
        if ($role) {
            return redirect()->route('admin.role-list')->with('success', 'Role created successfully');
        }
        return redirect()->route('admin.role-list')->with('error', 'Role creation failed');
    //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

     $permission = Permission::
            where('name', 'NOT LIKE', '%update%')
            ->where('name', 'NOT LIKE', '%store%');


        if (!Auth::user()->hasRole('super-admin')) {
            $permission->where('name', 'NOT LIKE', '%super%');

        }
        $permissions = $permission->get();
        



        $role_has_permission = DB::table('role_has_permissions')->where('role_id', $id)->get()->toArray();
        $role_has_permissions = [];
        foreach ($role_has_permission as $role_has) {
            $role_has_permissions[] = intval($role_has->permission_id);
        }

        $role = Role::where('id', $id)->where('organization_id', Auth::user()->organization_id)->first();
        return response()->json(['permissions' => $permissions, 'role' => $role, 'role_has_permissions' => $role_has_permissions]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $permissionCheckBox = collect($request->permissionCheckBoxs)
            ->map(fn($id) => (int)$id)
            ->toArray();
        $id = $request->id;
        $name = $request->name;
        $role = Role::where('id', $id)->where('organization_id', Auth::user()->organization_id)->first();
        if ($role) {
            $role->name = $name;
            $role->save();
            // return response()->json($role);

            $role->syncPermissions($permissionCheckBox);

            return redirect()->route('admin.role-list')->with('success', 'Role updated successfully');

        }

        return redirect()->route('admin.role-list')->with('error', 'Role not found');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $role = Role::find(intval($id));
        if ($request->type_status == "delete") {
            $role->forceDelete();
        }
        else {
            $role->delete();
        }
        return response()->json("success");

    }
    public function permissionRefresh()
    {
        return "working";
    }
}
