<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\login;
use Hash;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\email;

class ForgotPasswordController extends Controller
{
        public function showForgotForm(){
        return view('auth.forgot-password');
    }
    public function sendotp(request $request)
    {
        $credentials =$request->validate([
            'email'=>'string|required|email'
        ]);
        $user =login::where('email', $credentials['email'])->first();
        if($user)
            {
                $otp_code =rand(100000,999999);
                $otp_expierd =Carbon::now()->addMinutes(10);
                $user->update([
                'otpcode'=> $otp_code,
                'otp_expires_at' =>$otp_expierd,
                ]);

                Mail::to($user->email)->send(new email($otp_code));
                return redirect()->route('verify.otp',['email'=>$user->email])->with('Otp Has Been sent to your email.');
            }
        else 
        {
            return redirect()->route('login.page')->with('Faield','wrong email');
        }
    }

    public function verify_otp(request $request)
    {
        $validated_data =$request->validate([
            'email'=>'string|required|email'
            ,'otp_code'=>'required',
        ]);
        $user =login::where('email',$validated_data['email'])->first();
        if(!$user){
            return redirect()->route('showForgotForm')->with('Failed', 'User not found.');
        }
        $otp_code =login::where('email',$validated_data['otp_code']);
        if(!$otp_code)
            {
            return back()->with('Failed', 'Invalid OTP code.');
            }
        if (Carbon::now()->greaterThan($user->otp_expires_at))
            {
            return redirect()->route('showForgotForm')->with('Failed', 'OTP has expired.');
            }
        else
        {
            session(['reset_password_email' =>$user->email]);
            return redirect()->route('password.reset.form');
        }
    }
    public function showVerifyOtpForm(request $request)
    {
        if(!$request->has('email')|| empty($request->email))
            {
            return redirect()->route('showForgotForm')->with('Failed', 'Please enter your email first.');
            }
            return view('auth.verify-otp');
    }
    
    public function resetpassword(request $request)
    {
        $validated_session=session('reset_password_email');
        if(!$validated_session)
            {
                return redirect()->route('showForgotForm')->with('error', 'Session expired. Please try again.');
            }
        $validated_data =$request->validate([
            'password' =>'string|min:8|required|confirmed'
        ]);
        $user=login::where('email',$validated_session)->first();
        if(!$user)
            {
                return redirect()->route('showForgotForm')->with('error', 'Coudnt find email');
            }
        else
            {
                $user->update([
                    'password'=> Hash::make($validated_data['password']),
                    'otpcode' =>null,
                    'otp_expires_at' =>null,
                ]);
                session()->forget('reset_password_email');
                return redirect()->route('login')->with('success','password has been updated');
            }
    }
    public function showResetForm(){
            if (!session('reset_password_email')) {
            return redirect()->route('showForgotForm')->with('error', 'Unauthorized access.');
            }
            return view('auth.reset-password');    
            }
}
