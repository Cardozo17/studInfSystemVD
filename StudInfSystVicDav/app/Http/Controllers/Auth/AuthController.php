<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('guest', ['except' => 'logout']);
       // $this->middleware('is_admin', ['except' => 'auth/login']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'type' => 'required',
        ]);
    }

     /**
     * Get a validator for an incoming edit User request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validatorEdit(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|confirmed|min:6',
            'type' => 'required',
        ]);
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'type' => $data['type'],
        ]);
    }
    
   public function register(Request $request)
    {
        $validator = $this->validator($request->all());
        
        if ($validator->fails()) 
        {
            $this->throwValidationException(
                $request, $validator
            );
        }
      
        $this->create($request->all());
       
        return redirect('registerUser')->with('message', 'El usuario ha sido creado exitosamente');;
    }

    public function showEditUserWindow()
    {
        return view('auth.edit');
    }

    public function findUserByEmail(Request $request)
    {
        $userEmail= $request->input('email');

        $user= User::where('email', $userEmail)->first();

        if($user==null)
        {   
             return ['error_status' => 'Usuario no encontrado'];
        }

        return $user->toJson();

    }

    public function editUser (Request $request)
    {
        $currentUserEmail= $request->input('email');
        $currentUser= User::where('email', $currentUserEmail)->first();

        if($currentUser== null)
        {
             return ['error_status' => 'EL usuario que desea editar no se encuentra en la base de datos'];    
        }   

        $validator = $this->validatorEdit($request->all());
        
        if ($validator->fails()) 
        {
             return redirect('editUser')->withInput()->withErrors($validator);
        }

        $currentUser->name= $request->input('name');
        $currentUser->email= $request->input('emailToChange');
        $currentUser->password= bcrypt($request->input('password'));
        $currentUser->type= $request->input('type');

        $currentUser->save();

        return redirect('editUser')->with('message', 'El usuario ha sido editado exitosamente');;

    }

}
