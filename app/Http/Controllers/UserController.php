<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Organization;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Auth;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public $userModel;
    public function __construct()
    {
        $this->userModel = new User;

    }
    public function index()
    {

        $title = "Users";
        if (request()->ajax()) {
            return $this->userModel->loadDatatable();
        }

        return view('admin.users.index', compact('title'));
    }
    public function permission($id)
    {
        $title = "Change Permission";
        $user = User::find(intval($id));
        $user_permissions = $user->getPermissionNames()->toArray();
        $permissions = Permission::get();
        return view('admin.users.permission', compact('title', 'user', 'permissions', 'user_permissions'));

    }
    public function updatePermission(Request $request, $id)
    {

        $id = intval($id);
        $user_id = intval($request->id);
        if ($id != $user_id) {
            return back()->with('error', 'Something is wrong try again!');
        }
        // return "err";

        if (Auth::user()->hasRole('super-admin')) {
            $user = User::find($user_id);
        }
        else {
            $user = User::where('organization_id', Auth::user()->organization_id)->where('id', $user_id)->first();
        }

        if (!$user) {
            return back()->with('error', 'Something is wrong try again!');
        }

        $role = Role::find($user->role_id);
        return $role;

        $role->syncPermissions($request->permissionCheckBox);

        // $permissions = Permission::get();
        // foreach ($permissions as $key => $permission) {
        //     $user->revokePermissionTo($permission->name);
        // }

        // foreach ($request->permissionCheckBox as $key => $checkbox) {
        //     $permission = Permission::find($checkbox);
        //     $user->givePermissionTo($permission->name);
        // }

        return back()->with('success', 'Setting has been updated successfully!');
    // return $request->all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Create Account";

        // return Auth::user()->roles;
        // if (Auth::user()->hasRole('super-admin')) {
        //     $roles = Role::all();
        // }
        // else {
        //     $roles = Role::where('organization_id', Auth::user()->organization_id)->get();
        // }

        $roles = Role::
            where('organization_id', Auth::user()->organization_id)
            ->when(Auth::user()->hasRole('admin'), function ($query) {
            $query->where('name', '!=', 'super-admin');
        })->get();
        

        // return $roles;

        return view('admin.users.create', compact('title', 'roles'));


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => 'required|string|max:255|unique:users',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'confirmed'],
            'role' => ['required', 'numeric'],
        ]);

        $role = $request->role;

        $role = Role::where('id', $role)
            ->where('organization_id', Auth::user()
            ->organization_id)->where('name', 'NOT LIKE', '%super%')->first();
        if (!$role) {
            return back()->with('error', 'Something is wrong try again!');
        }

        // return $request->all();

        $user = new User;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->organization_id = Auth::user()->organization_id;
        $user->save();


        // return $role->name;
        $user->assignRole($role->name);

        return back()->with('success', 'User created successfully!');

    }
    public function trash()
    {

        $title = "Users Trash";
        if (request()->ajax()) {
            return $this->userModel->loadDatatableTrash();
        }
        return view('admin.users.trash', compact('title'));

    }
    public function restore(Request $request)
    {

        // return "end";
        $id = $request->id;
        $user = User::onlyTrashed()->find(intval($id));
        $user->restore();
        return response()->json("success");
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {


        $user_id = intval($id);

        if (Auth::user()->hasRole('super-admin')) {
            $user = User::find($user_id);
        }
        else {
            $user = User::where('organization_id', Auth::user()->organization_id)->where('id', $user_id)->first();
        }

        $role = Role::where('organization_id', Auth::user()->organization_id);
        if (!Auth::user()->hasRole('super-admin')) {
            $role->where('name', 'NOT LIKE', '%super%');
        }

        $roles = $role->get();

        if (!$roles) {
            return back()->with('error', 'Something is wrong try again!');
        }



        if (!$user) {
            return back()->with('error', 'Something is wrong try again!');
        }
        $title = "Edit Account";
        return view('admin.users.edit', compact('title', 'roles', 'user'));


        return $user;

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user_id = intval($id);

        if ($request->password) {
            $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users,username,' . $user_id,
                'email' => 'required|string|email|max:255|unique:users,email,' . $user_id,
                'password' => 'required', 'string', 'min:8', 'confirmed',
                'role' => 'required|numeric',
            ]);

        }
        else {
            $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users,username,' . $user_id,
                'email' => 'required|string|email|max:255|unique:users,email,' . $user_id,
                'role' => 'required|numeric',
            ]);
        }
        $role = Role::where('organization_id', Auth::user()->organization_id)
            ->where('id', $request->role);
        if (!Auth::user()->hasRole('super-admin')) {
            $role->where('name', 'NOT LIKE', '%super%');
        }

        $role = $role->first();

        if (!$role) {
            return back()->with('error', 'Something is wrong try again!');
        }

        $user = User::find($user_id);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->organization_id = Auth::user()->organization_id;

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->save();



        $user_role = $user->roles[0]->name;

        if ($role->name != $user_role) {
            $user->removeRole($user_role);
            $user->assignRole($role->name);
        }
        return back()->with('success', 'user has been updated successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $user = User::find(intval($id));
        if ($request->type_status == "delete") {
            $user->forceDelete();
        }
        else {
            $user->delete();
        }
        return response()->json("success");
    }
    public function profile()
    {
        // return Auth::user();
        $title = "Profile Setting";
        if (Auth::user()->hasRole('super-admin')) {
            $roles = Role::get();
        }
        else if (Auth::user()->hasRole('admin')) {
            $roles = Role::where('name', '!=', 'super-admin')->get();
        }
        else if (Auth::user()->hasRole('user')) {
            $roles = Role::where('name', '=', 'user')->get();
        }
        return view('admin.users.profile', compact('title', 'roles'));
    }
    public function profileUpdate(Request $request)
    {

        $user_id = intval(Auth::user()->id);

        $user = User::find($user_id);

        if (!$user) {
            return back()->with('error', 'Something is wrong try again!');
        }

        if (Auth::user()->hasRole('user')) {

            $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users,username,' . $user_id,
                'email' => 'required|string|email|max:255|unique:users,email,' . $user_id,
            ]);

            $user->name = $request->name;
            $user->username = $request->username;
            $input->email = $request->email;
            $user->save();
            return back()->with('success', 'Profile setting has been updated successfully');


        }
        else {
            $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users,username,' . $user_id,
                'email' => 'required|string|email|max:255|unique:users,email,' . $user_id,
                'organization' => 'required',
                'role' => 'required|numeric',
            ]);

            // return "working";




            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->save();

            $organization = Organization::find($user->organization_id);
            if ($organization) {
                $organization->name = $request->organization;
                $organization->save();
            }

            $role = Role::find($request->role);
            $user_role = $user->roles[0]->name;
            if ($role->name != $user_role) {
                $user->assignRole($role->name);
                $user->removeRole($user_role);
            }
            return back()->with('success', 'Profile setting has been updated successfully');

        }



    }
    public function ChangePassword()
    {
        $title = "Change Password";
        if (Auth::user()->hasRole('super-admin')) {
            $roles = Role::get();
        }
        else if (Auth::user()->hasRole('admin')) {
            $roles = Role::where('name', '!=', 'super-admin')->get();
        }
        else if (Auth::user()->hasRole('user')) {
            $roles = Role::where('name', '=', 'user')->get();
        }
        return view('admin.users.profile', compact('title', 'roles'));
    }
    public function UpdatePassword(Request $request)
    {
        $user_id = intval(Auth::user()->id);
        $user = User::find($user_id);
        if (!$user) {
            return back()->with('error', 'Something is wrong try again!');
        }
        $request->validate([
            'password' => 'required',
            'confirm_password' => 'same:password',
        ]);
        $request->password;
        $user->password = bcrypt($request->password);
        $user->save();
        return back()->with('success', 'Password has been updated successfully');


    }
}
