<?php

namespace Fedn\Http\Controllers\Auth;

use Fedn\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Fedn\Models\Role;
use Fedn\Models\User;
use Fedn\Models\UserMeta;
use Fedn\Http\Requests\BindFormRequest;
use Laravel\Socialite\Facades\Socialite;
use Auth;
use Hash;
use Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
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
     * @param  array $data
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

    public function loginWithQQ()
    {
        return Socialite::with('qq')->redirect();
    }

    public function handleQQLogin()
    {

        // check user with openid
        $sUser = Socialite::with('qq')->user();

        $user = User::whereHas('metas', function ($query) use ($sUser) {
            $query->where('key', 'qq_openId')
                ->where('value', $sUser->getId());
        })->with('roles')->first();

        if ($user) {
            Auth::login($user);

            if ($user->hasRole(1) || $user->hasRole(2)) {
                return redirect()->to('/admin');
            }
            return redirect()->intended('/');
        } else {
            $metas = [
                'nickname' => $sUser->getNickname(),
                'qq_openId' => $sUser->getId(),
                'avatar' => $sUser->getAvatar(),
                'qq_accessToken' => $sUser->accessTokenResponseBody['access_token'],
                'qq_refreshToken' => $sUser->accessTokenResponseBody['refresh_token']
            ];

            session(['metas' => $metas]);

            //return view('auth.bind', ['user'=>$user]);
            return redirect()->action('Auth\LoginController@socialBind');
        }
    }

    public function socialBind()
    {
        return view('auth.bind');
    }

    public function bindAccount(BindFormRequest $req)
    {
        $isNew = $req->has('name') ? true : false;

        $metas = session('metas');

        if ($isNew) {
            $data = [
                'name' => $req->get('name', null),
                'email' => $req->get('email', null),
                'password' => Hash::make($req->get('password', '')),
                'nickname' => $metas['nickname']
            ];

            $user = User::create($data);
        } else {
            $email = $req->get('email', null);
            $password = $req->get('password', null);

            $user = User::with('metas')->where('email', $email)->first();

            if (!$user) {
                redirect()->back()->withErrors('本站帐户登陆失败，请检查后重试', 'default');
            }

            foreach ($user->metas() as $meta) {
                if ($meta->key = 'qq_openId') {
                    redirect()->back()->withErrors('您的本站帐号已经绑定了其它QQ号', 'default');
                }
            }

            if (!Hash::check($password, $user->password)) {
                redirect()->back()->withErrors('本站帐户登陆失败，请检查后重试', 'default');
            }
        }

        $user->roles()->attach([4, 5]);

        $user->metas()->saveMany([
            new UserMeta(['key' => 'avatar', 'value' => $metas['avatar']]),
            new UserMeta(['key' => 'qq_openId', 'value' => $metas['qq_openId']]),
            new UserMeta(['key' => 'qq_accessToken', 'value' => $metas['qq_accessToken']]),
            new UserMeta(['key' => 'qq_refreshToken', 'value' => $metas['qq_refreshToken']])
        ]);

        Auth::login($user, $req->get('remember', false));
        request()->session()->forget('metas');
        return redirect()->to('/');
    }
}
