<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Models\ModulesList;
class ModulesListController extends Controller
{
    public function index()
    {
        $routes = \Route::getRoutes();

        // return $route

        foreach ($routes as $route) {
            $str = strpos($route->getName(), "admin.");
            if ($str !== false) {
                $route_name = $route->getName();
                $permission_get = Permission::updateOrCreate([
                    'name' => $route_name
                ]);
                
                // echo $route_name . "<br>";
                // $permission = Permission::create(['name' => $route_name]);
            }

        }

        $modulesPath = base_path('modules'); // modules folder
        foreach (glob($modulesPath . '/*', GLOB_ONLYDIR) as $module) {
            ModulesList::updateOrCreate([
                'name' => basename($module)
            ]);
            $moduleNames =  basename($module);

        }

    $permissions = Permission::all();
    $modules = ModulesList::all();

        return view('admin.modules.index', compact('permissions', 'modules'));

        

    }
}
