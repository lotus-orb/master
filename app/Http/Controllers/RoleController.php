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
      return view('admin.roles.index')->withRoles($roles)->withPermissions($permissions);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $permissions = Permission::all();
      return view('admin.roles.create')->withPermissions($permissions);
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
      return redirect()->route('roles.show', $roles->id);
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
      return view('admin.roles.show')->withRoles($roles);
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
      return view('admin.roles.edit')->withRoles($roles)->withPermissions($permissions);
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
      return redirect()->route('roles.show', $id);
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
      return redirect()->route('roles.index')->with('alert-success','Data berhasi dihapus!');
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
            return  '<a href="roles/'.$roles->id.'/edit" class="btn btn-info m-r-5"><i class="fa fa-edit"></i></a>'.
                    '<a href="roles/'.$roles->id.'" class="btn btn-primary m-r-5"><i class="fa fa-eye"></i></a>'.
                    '<form method="POST" action="'. route('roles.destroy', $roles->id) .'" style="display:inline-block !important;">
                        '.csrf_field().'
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="btn btn-danger" type="submit"><i class="fa fa-trash m-r-5"></i></button>
                    </form>';
          })
          ->addIndexColumn()
          ->make(true);
    }
}
