<?php

namespace App\Http\Controllers\Admin\Person;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Helpers\ResponseFormatter;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    protected $title = 'User Management';
    protected $breadcrumb = [['url' => '/dashboard', 'title' => 'Dashboard'], ['url' => '/user/role', 'title' => 'Roles']];

    public function __construct()
    {
        parent::__construct();
        $this->middleware('permission:Roles');
    }

    public function index()
    {
        $abilities = Permission::all()->map(function ($permission) {
            $nameParts = explode('-', $permission->name);
            return $nameParts[0];
        })->unique();
        return $this->render('admin.users.roles.index', [
            'menus' => $this->getMenus(),
            'abilities' => $abilities,
        ]);
    }

    /**
     * Retrieve data for the roles datatable.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        if ($request->ajax()) {
            $roles = Role::select('roles.*')->latest();

            $datatable = new DataTables;

            return $datatable->eloquent($roles)
                ->addColumn('action', function ($role) {
                    return $this->getActionColumn($role);
                })
                ->addColumn('created_at', function ($role) {
                    return $role->created_at->format('Y-m-d H:i:s');
                })
                ->addColumn('updated_at', function ($role) {
                    return $role->updated_at->format('Y-m-d H:i:s');
                })
                ->addColumn('name', function ($role) {
                    return strtolower($role->name);
                })
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->toJson();
        }
    }

    private function getActionColumn($role)
    {
        $arrowIcon = $this->getArrowIcon();
        $editMenuItem = '';
        $deleteMenuItem = '';

        if ($this->user->can('Roles-update')) {
            $editMenuItem = '
                <div class="menu-item px-3">
                    <a href="#" class="menu-link px-3" id="edit-role-button" data-id="' . $role->id . '" data-kt-docs-table-filter="edit_row" data-bs-toggle="modal" data-bs-target="#edit-role-modal">
                        Edit
                    </a>
                </div>
            ';
        }

        if ($this->user->can('Roles-delete')) {
            $deleteMenuItem = '
                <div class="menu-item px-3">
                    <a href="#" class="menu-link px-3"  data-id="' . $role->id . '" data-name="' . $role->name . '" id="delete-role-button" data-kt-docs-table-filter="delete_row">
                        Hapus
                    </a>
                </div>
            ';
        }

        if ($editMenuItem == '' && $deleteMenuItem == '') {
            return '
                <span class="badge badge-secondary">Tidak Ada Aksi</span>
            ';
        } else {
            return '
            <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                Aksi
                <span class="svg-icon fs-5 m-0">
                    ' . $arrowIcon . '
                </span>
            </a>
            <!--begin::Menu-->
            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                ' . $editMenuItem . '
                ' . $deleteMenuItem . '
            </div>
            <!--end::Menu-->
        ';
        }
    }

    private function processPermissions($paramPermission)
    {
        $permissions = $paramPermission;
        $processedPermissions = [];

        foreach ($permissions as $permission) {
            if (strpos($permission, '-read') !== false) {
                $processedPermissions[] = explode('-read', $permission)[0];
            }
        }

        // Merge original and processed permissions
        $finalPermissions = array_merge($permissions, $processedPermissions);

        return $finalPermissions;
    }

    /**
     * Store a newly created role in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->middleware('permission:Roles-create');

        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required'
        ]);

        // Check if the role already exists
        $roleExist = $this->checkRoleAvailability($request->name);
        if ($roleExist) {
            return ResponseFormatter::error('Role already exist.', 'Role already exist.', 422);
        }

        try {
            // Create the role
            $role = Role::create(['name' => $request->name]);
            $finalPermissions = $this->processPermissions($request->permission);
            // Sync Permissions
            $role->syncPermissions($finalPermissions);

            return ResponseFormatter::success($role, 'Role created successfully');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Retrieve the role with the specified ID and its associated permissions.
     *
     * @param int $id The ID of the role to retrieve.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the role and its permissions.
     */
    public function edit($id)
    {
        $role = Role::with('permissions')->findOrFail($id);

        return response()->json($role);
    }

    /**
     * Update the role with the specified ID.
     *
     * @param int $id The ID of the role to update.
     * @param \Illuminate\Http\Request $request The HTTP request object.
     * @return \Illuminate\Http\JsonResponse The JSON response indicating the success or failure of the update.
     */
    public function update($id, Request $request)
    {
        $this->middleware('permission:Roles-update');

        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required'
        ]);

        try {
            // Find Role By id
            $role = Role::findOrFail($id);
            // Update Role
            $role->update([
                'name' => $request->name,
            ]);

            // Sync Permissions
            $finalPermissions = $this->processPermissions($request->permission);
            $role->syncPermissions($finalPermissions);

            Cache::forget('menus_' . $role->name);

            return ResponseFormatter::success($role, 'Role updated successfully');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Delete a user by ID.
     *
     * @param int $id The ID of the user to delete.
     * @return \Illuminate\Http\JsonResponse The JSON response indicating the success or failure of the deletion.
     */
    public function delete($id)
    {
        $this->middleware('permission:Roles-delete');

        $role = Role::findOrFail($id);

        // Check if the role is being used by a user
        if ($role->users()->count() > 0) {
            return ResponseFormatter::error('This role is currently being used by a user and cannot be deleted.', 422);
        }

        try {
            // Delete the role
            $role->delete();
            Cache::forget('menus_' . $role->name);

            return ResponseFormatter::success('Role deleted successfully.', 'Role deleted successfully.');
        } catch (\Exception $e) {
            return ResponseFormatter::error('error', $e->getMessage(), 422);
        }
    }
}
