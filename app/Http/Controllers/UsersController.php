<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Validator;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('users.index');
    }

    public function userDataTable(Request $request)
    {
    	$users = $this->filterUserDataTable($request);
    	return [
            'pagination' => [
                'total'         => $users->total(),
                'current_page'  => $users->currentPage(),
                'per_page'      => $users->perPage(),
                'last_page'     => $users->lastPage(),
                'from'          => $users->firstItem(),
                'to'            => $users->lastItem(),
            ],
            'table' => $users
        ];
    }

    /* PAGINACION Y FILTRO */    
    public function filterUserDataTable($request)
    {
        $users = User::where('id','!=',0);

        if (!empty($request->search)) {
            $users
            ->where('username','like','%'.$request->search.'%')
            ->orWhere('email','like','%'.$request->search.'%')
            ->orWhere('created_at','like','%'.$request->search.'%');
        }

        return $users->orderBy('updated_at','DESC')->paginate($request->sort);
    }

    public function ValidateUser($user)
    {
        $validator = Validator::make($user, [
            'username'  =>  'required|unique:users|min:4|max:10',
            'email'     =>  'required|email|unique:users',
            'password'  =>  'required|min:4'
        ])->validate();
    }

    public function store(Request $request)
    {
        $this->ValidateUser($request->userData);
        /* CREO USUARIO */
        $user = User::create([
            'username'  => mb_strtolower($request->userData['username'],'UTF-8'),
            'email'     => $request->userData['email'], 
            'password'  => bcrypt($request->userData['password']),
        ]);
        return;
    }

    public function update(Request $request)
    {
        $user = User::findOrFail($request->userData['id']);
        $user->update([
            'username'  => mb_strtolower($request->userData['username'],'UTF-8'),
            'email'     => $request->userData['email'], 
        ]);

        if (isset($request->userData['password'])) {
            $user->update(['password'  => bcrypt($request->userData['password'])]);
        }
    }

    public function destroy(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->delete();
        return;
    }
}
