<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Validator;
use App\Person;
use Carbon\Carbon;
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

    public function filterUserDataTable($request)
    {
        $search = mb_strtolower($request->search,'UTF-8');
        $users = User::with('person.document','person.types');

        if (!is_null($search) && !empty($search)) {
            $users
            ->where('username','like','%'.$search.'%')
            ->orWhere('email','like','%'.$search.'%')
            ->orWhere('created_at','like','%'.$search.'%')
            ->orWhereHas('person',function ($query) use ($search) {
                $query
                ->where('firstname','%'.$search.'%')
                ->orWhere('lastname','%'.$search.'%')
                ->orWhere('nro_document','%'.$search.'%')
                ->orWhere('birthday','%'.$search.'%')
                ->orWhere('local_phone','%'.$search.'%')
                ->orWhere('movil_phone','%'.$search.'%')
                ->orWhere('mail_contact','%'.$search.'%')
                ->orWhereHas('document',function ($subQuery) use ($search) {
                    $subQuery->where('name','%'.$search.'%');
                });
            });
        }
        return $users->orderBy('id','DESC')->paginate($request->sort);
    }

    public function ValidateUser($user,$person)
    {
        if($person['id'] > 0)
        {
            // persona registrada
            $validator = Validator::make($person, [
                'name'          => 'required',
                'lastname'      => 'required',
                'document'      => 'required'
            ])->validate();
        }else{
            // persona nueva
            $validator = Validator::make($person, [
                'lastname'      => 'required',
                'document'      => 'required',
                'birthday'      => 'required',
                'nro_document'  => 'required|unique:people'
            ])->validate();
        }

        if($user['id'] == 0)
        {
            // usuario nuevo
            $validator = Validator::make($user, [
                'username'  =>  'required|unique:users|min:4|max:50',
                'email'     =>  'required|email|unique:users',
                'password'  =>  'required|min:4'
            ])->validate();
        }
    }

    public function store(Request $request)
    {
        $this->ValidateUser($request->userData,$request->personData);
        if($request->personData['id'] == 0){
            $person = Person::create([
                'firstname'     => $request->personData['firstname'],
                'lastname'      => $request->personData['lastname'], 
                'document_id'   => $request->personData['document']['id'],
                'nro_document'  => $request->personData['nro_document'],
                'local_phone'   => $request->personData['local_phone'],
                'movil_phone'   => $request->personData['movil_phone'],
                'direction'     => mb_strtolower($request->personData['direction'],'UTF-8'),
                'mail_contact'  => mb_strtolower($request->personData['direction'],'UTF-8'),
                'birthday'      => Carbon::parse($request->personData['birthday'])->toDateString(),
            ]);
        }else{
            $person = Person::findOrFail($request->personData['id']);
        }
        $user = User::create([
            'username'  => mb_strtolower($request->userData['username'],'UTF-8'),
            'email'     => mb_strtolower($request->userData['email'],'UTF-8'),
            'password'  => bcrypt($request->userData['password']),
            'person_id' => $person->id
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
        $person = Person::findOrFail($request->personData['id']);
        $person->update([
            'firstname'     => $request->personData['firstname'],
            'lastname'      => $request->personData['lastname'], 
            'document_id'   => $request->personData['document']['id'],
            'nro_document'  => $request->personData['nro_document'],
            'local_phone'   => $request->personData['local_phone'],
            'movil_phone'   => $request->personData['movil_phone'],
            'direction'     => mb_strtolower($request->personData['direction'],'UTF-8'),
            'mail_contact'  => mb_strtolower($request->personData['direction'],'UTF-8'),
            'birthday'      => Carbon::parse($request->personData['birthday'])->toDateString(),
        ]);
        if (isset($request->userData['password'])) {
            $user->update(['password'  => bcrypt($request->userData['password'])]);
        }
        return;
    }

    public function destroy(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->delete();
        return;
    }
}
