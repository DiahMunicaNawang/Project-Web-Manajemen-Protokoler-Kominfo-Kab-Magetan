<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MenusModel;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    protected $user;
    protected $data = [];
    protected $breadcrumb = [];
    protected $title = '';

    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->shareData();
            $this->user = auth()->user();
            return $next($request);
        });
    }

    public function shareData()
    {
        // insert menu to data array
        $this->data['breadcrumb'] = $this->breadcrumb;
        $this->data['title'] = $this->title;
        view()->share($this->data);
    }

    /**
     * Render view with data (usage same aas view() function)
     *
     * @param string $view view path from resources/views
     * @param array $data
     * @return void
     */
    function render($view, ?array $data = [])
    {
        return view($view, Arr::collapse([$this->data, $data]));
    }

    public function getMenus()
    {
        $permissionNames = auth()->user()->getAllPermissions()->pluck('name');

        $menus = Cache::rememberForever(
            'menus_' . $this->user->getRoleNames()->first(),
            function () use ($permissionNames) {
                // Get all active parent menus
                $menus = MenusModel::with(['childrens' => function ($query) {
                    $query->where('status', 1)->orderBy('order', 'asc');
                }])
                    ->where('parent_id', null)
                    ->where('status', 1)
                    ->orderBy('order', 'asc')
                    ->get();

                // Filter the menus
                return $menus->map(function ($menu) use ($permissionNames) {
                    // Filter children based on permission names
                    $menu->childrens = $menu->childrens->filter(function ($child) use ($permissionNames) {
                        return $permissionNames->contains($child->name);
                    });

                    // If the menu has no children after filtering, check if it itself should be included
                    if ($menu->childrens->isEmpty()) {
                        return $permissionNames->contains($menu->name) ? $menu : null;
                    }

                    // Include parent menu if it has any accessible children
                    return $menu;
                })->filter();
            }
        );

        return $menus;
    }
    public function getBreadcrumb($slug)
    {
        $breadcrumb = MenusModel::with('parent')->where('slug', $slug)->first();

        return $breadcrumb;
    }

    protected function getArrowIcon()
    {
        return '
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" he11ight="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <polygon points="0 0 24 0 24 24 0 24"></polygon>
                <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="currentColor" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999)"></path>
                </g>
            </svg>';
    }


    public function checkEmailAvailability($email, $id = null)
    {
        $query = User::where('email', $email);

        if ($id !== null) {
            $query->where('id', '<>', $id);
        }

        $userExists = $query->exists();

        return !$userExists;
    }

    public function checkRoleAvailability($roleName)
    {
        $role = Role::where('name', $roleName)->first();

        if ($role) {
            return true;
        }

        return false;
    }

    public function deleteFileWhenFailedToStoreOrSuccessDelete($filePath)
    {
        $fullPath = public_path($filePath);

        // Validate if $fullPath exists and is within the expected directory
        if (File::exists($fullPath) && strpos($fullPath, public_path()) === 0) {
            File::delete($fullPath);

            $directory = dirname($fullPath);

            if ($directory !== public_path()) {
                if (strpos($directory, public_path()) === 0) {
                    File::deleteDirectory($directory);
                    Log::info($this->user->name . " deleted: " . $directory);
                } else {
                    // \Log::info($this->user->name . " Attempted to delete unexpected directory: $directory");
                }
            }
        } else {
            // \Log::warning($this->user->name . " Attempted to delete unexpected file: $fullPath");
        }
    }
}
