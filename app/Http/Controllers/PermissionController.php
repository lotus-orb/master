<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Permission;
use DataTables;
use Session;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $permissions = Permission::orderBy('id', 'desc')->paginate(10);
      return view('admin.permissions.index')->withPermissions($permissions);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('admin.permissions.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      if ($request->permission_type == 'basic') {
        $this->validateWith([
          'display_name' => 'required|max:255',
          'name' => 'required|max:255|alphadash|unique:permissions,name',
          'description' => 'sometimes|max:255'
        ]);
        $permissions = new Permission();
        $permissions->name = $request->name;
        $permissions->display_name = $request->display_name;
        $permissions->description = $request->description;
        $permissions->save();
        Session::flash('success', 'Permission telah berhasil dibuat');
        return redirect()->route('permissions.index');
      } elseif ($request->permission_type == 'crud') {
        $this->validateWith([
          'resource' => 'required|min:3|max:100|alpha'
        ]);
        $crud = explode(',', $request->crud_selected);
        if (count($crud) > 0) {
          foreach ($crud as $x) {
            $slug = strtolower($x) . '-' . strtolower($request->resource);
            $display_name = ucwords($x . " " . $request->resource);
            $descriptions = "Allows a user to " . strtoupper($x) . ' a ' . ucwords($request->resource);
            $permissions = new Permission();
            $permissions->name = $slug;
            $permissions->display_name = $display_name;
            $permissions->description = $description;
            $permissions->save();
          }
          Session::flash('success', 'Permissions semua berhasil dibuat');
          return redirect()->route('permissions.index');
        }
      } else {
        return redirect()->route('permissions.create')->withInput();
      }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $permissions = Permission::findOrFail($id);
      return view('admin.permissions.show')->withPermissions($permissions);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $permissions = Permission::findOrFail($id);
      return view('admin.permissions.edit')->withPermissions($permissions);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $this->validateWith([
        'display_name' => 'required|max:255',
        'description' => 'sometimes|max:255'
      ]);
      $permissions = Permission::findOrFail($id);
      $permissions->display_name = $request->display_name;
      $permissions->description = $request->description;
      $permissions->save();
      Session::flash('success', 'Updated the '. $permissions->display_name . ' permission.');
      return redirect()->route('permissions.show', $id);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $permissions = Permission::find($id);
      $permissions->delete();
    }

    public function api_permissions() {
      $permissions = Permission::all();
      return Datatables::of($permissions)

          // ->addColumn('opdz', function($users) use ($opds)  {
          //     foreach ($opds as $opd) {
          //       if ($opd->id == $users->opd_id) {
          //       $return =
          //           $opd->name;
          //     return $return;
          //       }
          //     }
          //   })

          ->addColumn('action', function($permissions){
            return  '<a href="'.route('permissions.edit', $permissions->id).'" class="btn btn-info m-r-5"><i class="fa fa-edit"></i></a>'.
                    '<a href="'.route('permissions.show', $permissions->id).'" class="btn btn-primary m-r-5"><i class="fa fa-eye"></i></a>'.
                    '<a href="'.route('permissions.destroy', $permissions->id).'" class="btn btn-danger m-r-5 hapus" title="'.$permissions->display_name.'"><i class="fa fa-trash"></i></a>';
          })
          ->addIndexColumn()
          ->make(true);
    }
}
