<?php

namespace App\Http\Controllers\Admin\Person;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\Persons;

class PersonController extends Controller
{
    protected $title = 'User Management';
    protected $breadcrumb = [['url' => '/dashboard', 'title' => 'Dashboard'], ['url' => '/user/list', 'title' => 'Pengaturan Pengguna']];

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return $this->render('admin.users.list.index', [
            'roles' => Role::all(),
            'menus' => $this->getMenus(),
        ]);
    }

    public function allUsers()
    {
        $users = Persons::all();
        return response()->json($users);
    }

    /**
     * Retrieve data for the user list.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        if ($request->ajax()) {
            // Select latest users with their roles and permissions
            $users = User::with('person')->select('users.*');

            // Create an instance of DataTables
            $dataTable = new DataTables;

            return $dataTable->eloquent($users)
                ->addColumn('action', function ($user) {
                    return $this->getActionColumn($user);
                })
                ->addColumn('photo', function ($user) {
                    return $this->getUserPhoto($user);
                })
                ->addColumn('roles', function ($user) {
                    $roles = $user->roles->first()->name;
                    return strtolower($roles);
                })
                ->filterColumn('name', function ($query, $keyword) {
                    $query->where('name', 'like', "%{$keyword}%");
                })
                ->filterColumn('roles', function ($query, $keyword) {
                    $query->whereHas('roles', function ($query) use ($keyword) {
                        $query->where('name', 'like', "%{$keyword}%");
                    });
                })
                ->addIndexColumn()
                ->rawColumns(['action', 'photo'])
                ->toJson();
        }
    }


    private function getUserPhoto($user)
    {
        $name = $user->name;
        $photo = asset($user->person->photo);
        $fileExist = file_exists(public_path($user->person->photo));

        if ($photo != url('/') . '/' && $fileExist) {
            return '
            <div class="d-flex align-items-center">
                <div class="symbol symbol-50px symbol-circle">
                    <a href="' . $photo . '">
                        <img class="symbol-label" src="' . $photo . '" alt="" />
                    </a>
                </div>
            </div>';
        } else {
            return '
            <div class="d-flex align-items-center">
                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                    <div class="symbol-label fs-3 bg-light-danger text-danger">' . $name[0] . '</div>
                </div>
            </div>
        ';
        }
    }

    private function getActionColumn($user)
    {
        $arrowIcon = $this->getArrowIcon();
        $editMenuItem = '';
        $deleteMenuItem = '';

        if ($this->user->can('User List-update')) {
            $editMenuItem = '
                <div class="menu-item px-3">
                    <a href="#" class="menu-link px-3" id="edit-user-button" data-id="' . $user->id . '" data-kt-docs-table-filter="edit_row" data-bs-toggle="modal" data-bs-target="#edit-user-modal">
                        Edit
                    </a>
                </div>
            ';
        }

        if ($this->user->can('User List-delete')) {
            $deleteMenuItem = '
                 <div class="menu-item px-3">
                    <a href="#" class="menu-link px-3" data-id="' . $user->id . '" data-name="' . $user->name . '" id="delete-user-button" data-kt-docs-table-filter="delete_row">
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

    /**
     * Store a newly created user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request data
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'nip' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'phone' => 'min:7|max:999999999999999|numeric',
            'password' => 'required|min:6|max:16',
        ]);

        // Check if the email is available
        $emailAvailable = $this->checkEmailAvailability($request->email);
        if (!$emailAvailable) {
            return ResponseFormatter::error('error', 'Email tidak tersedia', 422);
        }

        try {
            // Create a new user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);

            // Create a new registrant
            Persons::create([
                'nip' => substr($request->nip, 0, 18),
                'photo' => $request->photo,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'address' => $request->address,
                'user_id' => $user->id,
                'registered_at' => now(),
            ]);

            // Assign the role to the user
            $user->assignRole($request->role);

            return ResponseFormatter::success('success', 'Berhasil Menambahkan Data User.');
        } catch (\Exception $e) {
            return ResponseFormatter::error('error', $e->getMessage(), 422);
        }
    }

    /**
     * Edit a user by their ID.
     *
     * @param int $id The ID of the user to edit.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the user data.
     */
    public function edit($id)
    {
        $user = User::with(['person', 'roles'])->findOrFail($id);

        $photo = file_exists(public_path($user->person->photo))
        ? json_encode([
            'path' => $user->person->photo,
            'name' => basename($user->person->photo),
            'size' => filesize(public_path($user->person->photo)),
        ])
        : null;

        return response()->json([
            'user' => $user,
            'photo' => $photo,
        ]);
    }

    /**
     * Update a user.
     *
     * @param int $id The ID of the user to update.
     * @param Request $request The request object containing the updated user data.
     * @return \Illuminate\Http\JsonResponse The JSON response indicating the result of the update operation.
     */
    public function update(Request $request, $id)
    {
        // Validation rules for the request data
        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'phone' => 'min:7|max:999999999999999|numeric',
            'password' => 'required|min:6|max:16',
        ]);

        // Find the user by ID
        $user = User::findOrFail($id);
        // Check if the email has changed
        if ($user->email != $request->email) {
            // Check email availability
            $emailAvailable = $this->checkEmailAvailability($request->email, $id);
            if (!$emailAvailable) {
                return ResponseFormatter::error('error', 'Email tidak tersedia', 422);
            }
        }

        try {
            DB::beginTransaction();

            // Update the user data
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);

            // Update the registrant data if exists
            $person = Persons::where('user_id', $user->id)->first();
            if ($person) {
                $person->update([
                    'nip' => substr($request->nip, 0, 18),
                    'photo' => $request->photo,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $request->phone,
                    'gender' => $request->gender,
                    'address' => $request->address,
                ]);
            }

            $user->syncRoles($request->role);

            DB::commit();
            return ResponseFormatter::success('success', 'Berhasil mengubah user.');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormatter::error('error', $e->getMessage(), 422);
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
        $user = User::findOrFail($id);
        try {
            $user->person->delete();
            $user->delete();
            return ResponseFormatter::success('success', 'Berhasil menghapus data User.');
        } catch (\Exception $e) {
            return ResponseFormatter::error('error', $e->getMessage(), 422);
        }
    }

    /**
     * Delete multiple users by their IDs.
     *
     * @param string $ids The comma-separated IDs of the users to be deleted.
     * @return \Illuminate\Http\JsonResponse The JSON response indicating the success or failure of the deletion.
     */
    public function multipleDelete($ids)
    {
        try {
            $ids = explode(',', $ids);
            User::whereIn('id', $ids)->each(function ($user) {
                $user->person()->delete();
                $user->delete();
            });

            return ResponseFormatter::success('Berhasil menghapus data User.');
        } catch (\Exception $e) {
            return ResponseFormatter::error('error', $e->getMessage(), 422);
        }
    }
}
