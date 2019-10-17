<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use DB;
use Auth;
use Session;
use Hash;
use Input;
use DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $users = User::all();
      $roles = Role::all();
      return view('admin.users.index', compact('users','roles'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      if (Auth::user()->hasRole(['member','author']))
      {
          return redirect()->route('admin.dashboard');
      }
      $roles = Role::all();
      return view('admin.users.create', compact('roles'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      if (Auth::user()->hasRole(['member','author']))
      {
          return redirect()->route('admin.dashboard');
      }
      $this->validateWith([
        'name' => 'required|max:255',
        'email' => 'required|email|unique:users'
      ]);
      if (!empty($request->password)) {
        $password = trim($request->password);
      } else {
        # set the manual password
        $length = 10;
        $keyspace = '123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }
        $password = $str;
      }
      $users = new User();
      $users->name = $request->name;
      $users->email = $request->email;
      $users->password = Hash::make($password);
      $users->save();
      if ($request->roles) {
        $users->syncRoles(explode(',', $request->roles));
      }
      return redirect()->route('users.show', $users->id)->withSuccess('Success, Data Berhasil Disimpan!');
      // if () {
      //
      // } else {
      //   Session::flash('danger', 'Sorry a problem occurred while creating this user.');
      //   return redirect()->route('users.create');
      // }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $users = User::where('id', $id)->with('roles')->first();
      return view("admin.users.show")->withUsers($users);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $roles = Role::all();
      $users = User::where('id', $id)->with('roles.users')->first();
      return view("admin.users.edit", compact('roles','users'));
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
        'name' => 'required|max:255',
        'email' => 'required|email|unique:users,email,'.$id
      ]);
      $users = User::findOrFail($id);
      $users->name = $request->name;
      $users->email = $request->email;
      if ($request->password_options == 'auto') {
        $length = 10;
        $keyspace = '123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }
        $users->password = Hash::make($str);
      } elseif ($request->password_options == 'manual') {
        $users->password = Hash::make($request->password);
      }
      $users->save();

      $users->syncRoles(explode(',', $request->roles));
      return redirect()->route('users.show', $id)->withSuccess('Success, Data berhasil diperbarui !');
      // if () {
      //   return redirect()->route('users.show', $id);
      // } else {
      //   Session::flash('error', 'There was a problem saving the updated user info to the database. Try again later.');
      //   return redirect()->route('users.edit', $id);
      // }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      if (Auth::user()->hasRole(['member','author']))
      {
          return redirect()->route('admin.dashboard');
      }
     $users = User::findOrFail($id);
     $users->delete();
    }

    public function api_data() {
      $users = User::all();
      return Datatables::of($users)

          // ->addColumn('opdz', function($users) use ($opds)  {
          //     foreach ($opds as $opd) {
          //       if ($opd->id == $users->opd_id) {
          //       $return =
          //           $opd->name;
          //     return $return;
          //       }
          //     }
          //   })

          ->addColumn('action', function($users){
            return  '<a href="'.route('users.edit', $users->id).'" class="btn btn-info m-r-5"><i class="fa fa-edit"></i></a>'.
                    '<a href="'.route('users.show', $users->id).'" class="btn btn-primary m-r-5"><i class="fa fa-eye"></i></a>'.
                    '<a href="'.route('users.destroy', $users->id).'" class="btn btn-danger m-r-5 hapus" title="'.$users->name.'"><i class="fa fa-trash"></i></a>';
          })
          ->addIndexColumn()
          ->make(true);
    }
}
