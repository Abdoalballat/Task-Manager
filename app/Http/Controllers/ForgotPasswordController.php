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
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rules\Numeric;

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

                // Mail::to($user->email)->send(new email($otp_code));
                return redirect()->route('verify.otp',['email'=>$user->email])->with('Otp Has Been sent to your email.');
            }
        else 
        {
            return redirect()->route('login')->with('Failed','wrong email');
        }
    }

public function verify_otp(Request $request)
    {
        $key = 'verify-otp:' . $request->ip() . '|' . $request->email;

    if (RateLimiter::tooManyAttempts($key, 3)) {
        $seconds = RateLimiter::availableIn($key);
        return back()->with('Failed', "لقد تجاوزت عدد المحاولات المسموح بها. يرجى الانتظار {$seconds} ثانية.");
    }
        
        $validated_data = $request->validate([
            'email'    => 'required|string|email',
            'otp_code' => 'required|numeric',
        ]);
        $user = Login::where('email', $validated_data['email'])->firstOrFail();
        
        if (!$user) {
            return redirect()->route('showForgotForm')->with('Failed', 'User not found.');
            }
            
            if ($user->otpcode != $validated_data['otp_code']) {
            return back()->with('Failed', 'Invalid OTP code.');
        }

        if (Carbon::now()->greaterThan(Carbon::parse($user->otp_expires_at))) {
            //             dd(['validated_data'=>$validated_data['otp_code'],
            // 'user code'=>$user->otpcode]);
            return redirect()->route('showForgotForm')->with('Failed', 'OTP has expired.');
        }
    else{
        // إبطال الكود لمنع إعادة استخدامه
        $user->update([
            'otp_code' => null,
            'otp_expires_at' => null,
        ]);

        session(['reset_password_email' => $user->email]);

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
