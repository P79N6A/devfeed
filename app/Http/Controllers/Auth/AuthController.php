<?php

namespace Fedn\Http\Controllers\Auth;

use Fedn\Models\Role;
use Fedn\Models\User;
use Fedn\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Laravel\Socialite\Facades\Socialite;
use Auth;
use Hash;
use Validator;

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
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['logout','getLogout']]);
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
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $roleId = Role::where('title', 'Contributor')->firstOrFail()->id;

        $user->roles()->attach($roleId);

        return $user;

    }

    public function loginWithQQ(){
        return Socialite::with('qq')->redirect();
    }

    public function handleQQLogin(){

        // check user with openid
        $sUser = Socialite::with('qq')->user();

        $user = User::whereHas('metas', function($query){
            $query->where('key','qq_id');
        })->first();
        if($user) {
            Auth::login($user);
            return redirect()->intended('/');
        } else {
            $user = new User();
            $user->email = $sUser->getEmail();
            $user->nickname = $sUser->getNickname();

            $metas = [
                'qq_id' => $sUser->getId(),
                'qq_token' => $sUser->accessTokenResponseBody['access_token'],
                'qq_refreshToken' => $sUser->accessTokenResponseBody['refresh_token']
            ];

            return view('auth.bind', ['user'=>$user, 'metas'=>$metas]);
        }
    }

    public function bindAccount(Request $req) {
        dd($req->all());
    }
}
