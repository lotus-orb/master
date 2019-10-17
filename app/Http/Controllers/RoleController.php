<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Role;
use App\Permission;
use Session;
use DataTables;
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $permissions = Permission::all();
      $roles = Role::all();
      return view('admin.roles.index', compact('permissions', 'roles'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $permissions = Permission::all();
      return view('admin.roles.create', compact('permissions'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validateWith([
        'display_name' => 'required|max:255',
        'name' => 'required|max:100|alpha_dash|unique:roles',
        'description' => 'sometimes|max:255'
      ]);
      $roles = new Role();
      $roles->display_name = $request->display_name;
      $roles->name = $request->name;
      $roles->description = $request->description;
      $roles->save();
      if ($request->permissions) {
        $roles->syncPermissions(explode(',', $request->permissions));
      }
      Session::flash('success', 'Berhasil membuat baru '. $roles->display_name . ' role ke database.');
      return redirect()->route('roles.show', $roles->id)->withSuccess('Success, Data berhasil dibuat !');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $roles = Role::where('id', $id)->with('permissions')->first();
      return view('admin.roles.show', compact('roles'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $roles = Role::where('id', $id)->with('permissions')->first();
      $permissions = Permission::all();
      return view('admin.roles.edit', compact('roles', 'permissions'));
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
      $roles = Role::findOrFail($id);
      $roles->display_name = $request->display_name;
      $roles->description = $request->description;
      $roles->save();
      if ($request->permissions) {
        $roles->syncPermissions(explode(',', $request->permissions));
      }
      Session::flash('success', 'Berhasil update '. $roles->display_name . ' role ke database.');
      return redirect()->route('roles.show', $id)->withSuccess('Success, Data berhasil diperbarui !');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $roles = Role::find($id);
      $roles->delete();
    }

    public function api_roles() {
      $roles = Role::all();
      return Datatables::of($roles)

          // ->addColumn('opdz', function($users) use ($opds)  {
          //     foreach ($opds as $opd) {
          //       if ($opd->id == $users->opd_id) {
          //       $return =
          //           $opd->name;
          //     return $return;
          //       }
          //     }
          //   })

          ->addColumn('action', function($roles){
            return  '<a href="'.route('roles.edit', $roles->id).'" class="btn btn-info m-r-5"><i class="fa fa-edit"></i></a>'.
                    '<a href="'.route('roles.show', $roles->id).'" class="btn btn-primary m-r-5"><i class="fa fa-eye"></i></a>'.
                    '<a href="'.route('roles.destroy', $roles->id).'" class="btn btn-danger m-r-5 hapus" title="'.$roles->display_name.'"><i class="fa fa-trash"></i></a>';
          })
          ->addIndexColumn()
          ->make(true);
    }
}
