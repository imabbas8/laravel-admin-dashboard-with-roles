<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Organization;
use Spatie\Permission\Traits\HasRoles;
use DataTables;
use Carbon\Carbon;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;
    protected $guarded = [];
    use SoftDeletes;



    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'payment_status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
    public function loadDatatable()
    {

        if (Auth::user()->hasRole('super-admin')) {
            $datatables = User::orderBy('id', 'ASC')->get();
        }
        else {
            $datatables = User::
                where('organization_id', Auth::user()->organization_id)
                ->where('name', 'NOT LIKE', '%super%')
                ->orderBy('id', 'ASC')->get();
        }
        // $id = Auth::user()
        return DataTables::of($datatables)
            ->editColumn('created_at', function ($row) {
            $date = Carbon::parse($row->created_at)->format('M-d-Y  h:i:A');
            return $date;
        })->addColumn('role', function (User $user) {

            return $user->roles->map(function ($role) {
                    return $role->name;
                }
                )->implode('<br>');
            })
            ->addColumn('organization', function (User $user) {
            if ($user->organization != NULL) {
                return $user->organization->name;
            }
        })
            ->removeColumn('updated_at')
            ->removeColumn('deleted_at')
            ->addColumn('action', function ($row) {



            $btn = "";

            if (Auth::user()->can('admin.user-permission')) {
                $btn .= '<div class="menu-item px-3">
                                    <a href="' . route('admin.user-permission', $row->id) . '" class="menu-link px-3" data-kt-docs-table-filter="edit_row">
                                        Permission
                                    </a>
                                </div>';
            }
            if (Auth::user()->can('admin.user-edit')) {
                $btn .= ' <div class="menu-item px-3">
                                    <a href="' . route('admin.user-edit', $row->id) . '" class="menu-link px-3" data-kt-docs-table-filter="edit_row">
                                        Edit
                                    </a>
                                </div>';
            }

            if (Auth::user()->can('admin.user-delete')) {

                $btn .= '<div class="menu-item px-3">
                                    <a href="#" data-id="' . $row->id . '" data-type_status="trash" class="menu-link px-3" data-kt-docs-table-filter="delete_row">
                                        Trash
                                    </a>
                                </div>';
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

    public function loadDatatableTrash()
    {

        if (Auth::user()->hasRole('super-admin')) {
            $datatables = User::onlyTrashed()->orderBy('id', 'ASC')->get();
        }
        else {
            $datatables = User::onlyTrashed()
                ->where('organization_id', Auth::user()->organization_id)
                ->where('name', 'NOT LIKE', '%super%')
                ->orderBy('id', 'ASC')->get();
        }
        // $id = Auth::user()
        return DataTables::of($datatables)
            ->editColumn('created_at', function ($row) {
            $date = Carbon::parse($row->created_at)->format('M-d-Y  h:i:A');
            return $date;
        })->addColumn('role', function (User $user) {
            return $user->roles->map(function ($role) {
                    return $role->name;
                }
                )->implode('<br>');
            })
            ->addColumn('organization', function (User $user) {
            if ($user->organization != NULL) {
                return $user->organization->name;
            }
        })
            ->removeColumn('updated_at')
            ->removeColumn('deleted_at')
            ->addColumn('action', function ($row) {

            $btn = "";
            if (Auth::user()->can('admin.user-trash-restore')) {

                $btn .= '<div class="menu-item px-3">
                                    <a href="#" data-id="' . $row->id . '" class="menu-link px-3" data-kt-docs-table-filter="delete_row">
                                        Restore
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
                               
                                
                            </div>';
            return $btn;
        })->toJson();

    }
}
