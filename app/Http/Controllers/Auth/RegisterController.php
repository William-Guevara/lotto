<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'confirmed']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    // PROVISIONALMENTE SE DEBEN CREAR LOS ROLES DE FORMA MANUAL Y ASIGNAR AQUÍ DE FORMA ESTÁTICA EL ROL Y LA INSTITUCIÓN A LA CUAL PERTENECE EL USUARIO
    // LOS USUARIOS DE MANTENIMIENTO SIEMPRE TENDRÁN UN ROL = 1 Y UNA INSTITUCIÓN EN NULO
    protected function create(array $data)
    {
 
        return User::create([
            'email'=> $data['email'],
            'email2'=> null,
            'fname'=> $data['fname'],
            'lname'=> $data['lname'],
            'address'=> $data['address'],
            'city'=> $data['city'],
            'state'=> $data['state'],
            'zip_code'=> $data['zip_code'],
            'country'=> 1,//$data['country'],
            'phone'=> $data['phone'],
            'fax'=> $data['fax'],
            'gender'=> $data['gender'],
            'newsletter'=> $data['newsletter'],
            'language'=> $data['language'],
            'password' => Hash::make($data['password'])
        ]);
    }
}
