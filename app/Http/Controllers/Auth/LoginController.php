<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use \App\Models\User;
use Auth;
use Illuminate\Http\Request;

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
    protected $redirectTo = RouteServiceProvider::HOME;

        // protected $username;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        // $this->username = $this->getLoginMode();

    }

     public function login(Request $request)

    {   

        $input = $request->all();

  

        $this->validate($request, [

            'email' => 'required',

            'password' => 'required',

        ]);

  

        $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if(auth()->attempt(array($fieldType => $input['email'], 'password' => $input['password'])))

        {

            return redirect()->route('home');

        }else{

            return redirect()->route('login')

                ->with('error','Invalid login credentials.');

        }

          

    }

    //  public function getLoginMode()
    // {
    //     $login = request()->input('email');
    //     // $user = User::where('email', $login)->orWhere('username', $login)->first();
    //     // if (!$user) {
    //     //     return redirect()->back()->withErrors(['email' => 'Invalid login credentials']);
    //     // }



    //     $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    //     request()->merge([$fieldType => $login]);
    //     return $fieldType;
    // }

    // public function username()
    // {
    //     return $this->username;
    // }
}
