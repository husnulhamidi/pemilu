<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
Use Exception;
use App\Models\SysRole;
use App\Models\User;
use Session;

class AuthenticateController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.loginnew');
        //return view('auth.login_tjb');
    }

    public function createtjb()
    {
        
        //return view('auth.login_tjb');
        return view('auth.loginnew');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
        
            $data = [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'status_code' => 'active',
            ];

            if (Auth::Attempt($data)) {
                $role_id = auth()->user()->role_id;
                $role = SysRole::findOrfail($role_id);
                $sess = array(
                    'user_id' => auth()->user()->id,
                    'name_ori' => auth()->user()->name,
                    'role_ori' => $role->role,
                    'role' => $role->role,
                    'plh'=>''
                );
                session($sess);

                return redirect()->intended(RouteServiceProvider::HOME);
            }else{
                Session::flash('error', 'Email atau Password Salah');
                return redirect('/login');
            }

            return redirect()->intended(RouteServiceProvider::HOME);

        } catch (\Throwable $e) {       // Rollback Transaction
           
            Session::flash('error', $e->getMessage());
            return redirect('/login');
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function verifyEmail(Request $req)
    {
        $email = $req->input('email');
      
        $check = User::where('email',$email)->first();

        if (!empty($check)) {
            $status="true";
            $message="<span class='text-success'><i class='far fa-check-circle text-success'></i> email terdaftar</span>";
        }else{
           $status="false";
           $message="<span class='text-danger'><i class='flaticon-circle text-danger'></i> Oppss ! email tidak terdaftar</span>";
        }
        $return = array(
            'status'    => $status,
            'message'   => $message
        );

        return $return;
    }

    
}
