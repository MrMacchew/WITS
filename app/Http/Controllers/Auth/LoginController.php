<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use SimpleXMLElement;
use Illuminate\Support\Str;



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

    // use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function login(Request $request)
    {
       // dd(Auth::check());
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        return redirect(url('/'));
    }

    public function saml(Request $request) {
        $saml = array();
        $xml_string = base64_decode($request->get('SAMLResponse'));
        $elements = new SimpleXMLElement($xml_string);
        $result = $elements->children('saml', true)[1]->AttributeStatement;//->Attribute[0]->attributes();
//        dd($result->asXML());
        foreach($result as $v) {
            foreach($v as $i => $val) {
                if($val->AttributeValue->count() > 1) {
                    foreach($val->AttributeValue as $attr) {
                        $saml[$val->attributes()['Name']->__toString()][] = $attr->__toString();
                    }
                } else {
                    $saml[$val->attributes()['Name']->__toString()] = $val->AttributeValue->__toString();
                }
            }
        }

        // dd(json_encode($saml));

        //does user exist?
        $user = User::where('email', '=', $saml['email'])->first();

        //if user doesn't exist create User
        if(!$user) {
            $user = User::create(['user' => $saml['sAMAccountName'], 'password' => Str::random(16),
                'email' => $saml['email'], 'first_name' => $saml['FirstName'], 'last_name' => $saml['LastName']]);
            $user->assignRole('user');

        }

        Auth::loginUsingId($user->id);

        // Redirect Home
        return redirect('/dashboard');
    }
}
