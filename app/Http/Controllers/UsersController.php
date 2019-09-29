<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Validator;
use App\Person;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            ->orWhereHas('person',function ($query) use ($search) {
                $query
                ->where('firstname','like','%'.$search.'%')
                ->orWhere('lastname','like','%'.$search.'%')
                ->orWhere('nro_document','like','%'.$search.'%')
                ->orWhere('birthday','like','%'.$search.'%')
                ->orWhere('local_phone','like','%'.$search.'%')
                ->orWhere('movil_phone','like','%'.$search.'%')
                ->orWhere('mail_contact','like','%'.$search.'%')
                ->orWhereHas('document',function ($subQuery) use ($search) {
                    $subQuery->where('name','like','%'.$search.'%');
                });
            });
        }
        return $users->orderBy('updated_at','DESC')->paginate($request->sort);
    }

    public function ValidateUser($user,$person)
    {
        if($person['id'] > 0)
        {
            // persona registrada
            $validator = Validator::make($person, [
                'firstname'     => 'required',
                'lastname'      => 'required',
                'document'      => 'required'
            ])->validate();
        }else{
            // persona nueva
            $validator = Validator::make($person, [
                'firstname'     => 'required',
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

    public function vUser($user)
    {
        if($user['id'] > 0)
        {
            $validator = Validator::make($user, [
                'username'  =>  'required',
                'email'     =>  'required',
                'password'  =>  'nullable|min:4'
            ])->validate();
        }
    }

    public function vPerson($person)
    {
        if($person['id'] > 0)
        {
            $validator = Validator::make($person, [
                'firstname'     => 'required',
                'lastname'      => 'required',
                'document'      => 'required',
                'birthday'      => 'required',
                'nro_document'  => 'required'
            ])->validate();
        }
    }

    public function store(Request $request)
    {
        if (isset($request->personData['img_document'])) {
            $expl1 = explode(',', $request->personData['img_document']);
            $decoded = base64_decode($expl1[1]);
            $expl2 = explode('/',$expl1[0]);
            $expl3 = explode(';',$expl2[1]);
            $extension = $expl3[0];
            $filename = 'documents/'.$request->personData['nro_document'].'.'.$extension;
            $path = Storage::put($filename, $decoded, 'public');
        }

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
                'img_document' => (isset($filename))?$filename:'documents/default.png'
            ]);

        }else{
            $person = Person::findOrFail($request->personData['id']);
            $person->update(['img_document' => (isset($filename))?$filename:'documents/default.png']);
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
        if (isset($request->personData['img_document'])) {
            $expl1 = explode(',', $request->personData['img_document']);
            $decoded = base64_decode($expl1[1]);
            $expl2 = explode('/',$expl1[0]);
            $expl3 = explode(';',$expl2[1]);
            $extension = $expl3[0];
            $filename = 'documents/'.$request->personData['nro_document'].'.'.$extension;
            $path = Storage::put($filename, $decoded, 'public');
        }

        if($request->userData['id']>0)
        {
            $this->vUser($request->userData);
            $user = User::findOrFail($request->userData['id']);
            $user->update([
                'username'  => mb_strtolower($request->userData['username'],'UTF-8'),
                'email'     => $request->userData['email'], 
            ]);
        }
        if($request->personData['id']>0)
        {
            $this->vPerson($request->personData);
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
                'img_document' => (isset($filename))?$filename:'documents/default.png'
            ]);
        }
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

    public function profile(Request $request, $username='')
    {
        if(!Auth::User()->is_admin()) $username = Auth::User()->username;

        $usuario=($username == '')?Auth::User():User::where('username',$username)->first();
        return(!$request->ajax())?view('users.profile'):$usuario->load('person.document','person.types');
    }
}
