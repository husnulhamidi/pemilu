<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailer;
use App\Mail\SendMail;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Rules\IsValidPassword;

class MailController extends Controller
{
    public function index()
    {
        
        $page_title = 'Dashboard';
        $page_description = '';
    
        return view('welcome', compact('page_title', 'page_description'));
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function resetPasswordBackup(Request $req)
    {
        $email = $req->input('email');

        $check = User::where('email',$email)->first();

        if (!empty($check)) {

            $password = substr(md5(mt_rand()), 0, 8);
            $passwordHash = Hash::make($password);

            User::where('email',$email)->update(['password'=>$passwordHash]);

            $data = [
                'title' => 'Reset Password.',
                'url' => env('APP_URL'),
                'password' => $password,
            ];
            Mail::to($email)->send(new SendMail($data));

            Session::flash('success', 'Password berhasil direset, Password baru telah dikirim via email.');
            
        }else{
            Session::flash('error', 'Alamat Email tidak ditemukan !');
        }
    
        return redirect('/forgot-password');
        
    }

    public function resetPassword(Request $request)
    {
        $check = User::where('email', $request->input('email'))->first();
        if (!empty($check)) {
            $token = Str::random(64);
            list($addr,$dom) = explode('@',$request->email);
            
            DB::table('password_resets')->insert([
                'email' => $request->email, 
                'token' => $token, 
                'created_at' => Carbon::parse(date('Y-m-d H:i:s'))->timezone('Asia/Jakarta'),
            ]);

            $data = [
                'url' => route('show-change-password', $token),
            ];
            if($dom=='pln.co.id'){
                Mail::mailer('pln')->to($request->email)->send(new SendMail($data));
            }else{
                Mail::to($request->email)->send(new SendMail($data));
            }
            
    
            Session::flash('success', 'Kami telah mengirimkan email tautan reset password anda!');
        }else{
            Session::flash('error', 'Alamat Email tidak ditemukan !');
        }
    
        return redirect('/forgot-password');
    }

    public function showResetPasswordForm($token) { 
        return view('auth.forgetPasswordLink', ['token' => $token]);
    }

    public function submitResetPasswordForm(Request $request)
    {
        $rules = [
            'email' => 'required|email|exists:password_resets',
            //'password' => 'required|string|min:6|confirmed|',
            'password' => ['required', 'string','min:8'],
            'password_confirmation' => 'required'
        ];
  
        $validator = validator()->make(request()->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }   

        $updatePassword = DB::table('password_resets')->where(
            [
                ['email', '=', $request->email], 
                ['token', '=', $request->token],
                ['created_at', '>', Carbon::now()->subMinutes(5)->toDateTimeString()]
            ]
        )->first();

        if(!empty($updatePassword)){
            $arr_user = array(
                'password' => Hash::make($request->password),
                'last_updated'  => date('Y-m-d')
            );
            User::where('email', $request->email)->update($arr_user);

            DB::table('password_resets')->where(['email'=> $request->email])->delete();
            Session::flash('success', 'Selamat Password Anda telah diubah!');

            return redirect('/');
        }
        
        Session::flash('error', 'Token tidak valid!');
        DB::table('password_resets')->where(['email'=> $request->email])->delete();
        
        return redirect()->back()->withInput($request->all());
    }

}
