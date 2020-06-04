<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use File;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = '/register/menu';

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
            'nama' => 'required|alpha',
            'nama_dapur' => 'required|alpha|unique:users',
            'email' => 'required|email|unique:users',
            'No_HP' => 'required|unique:users',
            'KTP' => 'required',
            'password' => 'required|min:8|regex:/^(?=.*[a-zA-Z])(?=.*\d).{8,}$/|confirmed'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $request = request();

        $profileImage = $request->file('KTP');
        $profileImageSaveAsName = time() . Auth::id() . "-profile." . $profileImage->getClientOriginalExtension();

        $upload_path = 'profile_images/';
        $profile_image_url = $upload_path . $profileImageSaveAsName;
        $success = $profileImage->move($upload_path, $profileImageSaveAsName);

        return User::create([
            'role' => 'seller',
            'nama' => $data['nama'],
            'nama_dapur' => $data['nama_dapur'],
            'No_HP' => $data['No_HP'],
            'alamat' => $data['alamat'],
            'KTP' => $profile_image_url,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
