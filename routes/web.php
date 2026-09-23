<?php

use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::middleware(['auth','role:admin'])->group(function(){

    Route::controller(ProjectController::class)->group(function(){
    Route::get('/projects','index')->name('projects.index');
    Route::get('/projects/create','create')->name('projects.create');
    Route::post('/projects','store')->name('projects.store');
    Route::get('/projects/{project}','show')->name('projects.show');
    Route::delete('/projects/{project}','destroy')->name('projects.destroy');
    });
    
    
    Route::controller(TaskController::class)->group(function(){
        Route::patch('/tasks/{task}','update')->name('tasks.update');
    Route::post('/projects/{project}/tasks','store')->name('projects.tasks.store');
    Route::delete('/tasks/{task}','destroy')->name('tasks.destroy');
    });
    
    Route::controller(LoginController::class)->group(function(){
        Route::get('/index','index')->name('users.index');
        Route::get('/show/{id}','show')->name('users.show');
        Route::get('/users/create','create')->name('users.create');
        Route::post('/users', 'register')->name('users.register');
        
        });
        });
    Route::middleware(['auth','role:employee,admin'])->group(function(){
    Route::patch('/tasks/{task}',[TaskController::class,'update'])->name('tasks.update');
    });


    Route::middleware(['auth','role:employee'])->group(function(){
    Route::get('/my_tasks',[TaskController::class,'my_tasks'])->name('my_tasks');
    });

Route::controller(ForgotPasswordController::class)->group(function(){
    Route::get('/forgot-password', 'showForgotForm')->name('showForgotForm');
    Route::post('/send-otp', 'sendOtp')->middleware('throttle:3,1')->name('send.otp');
    Route::get('/verify-otp', 'showVerifyOtpForm')->name('password.reset'); //not sets
    Route::post('/verify-otp', 'verify_otp')->name('verify.otp');
    Route::get('/reset-password', 'showResetForm')->name('password.reset.form');
    Route::post('/reset-password', 'resetPassword')->name('password.update');
});


Route::controller(LoginController::class)->group(function(){
    Route::get('/loginpage','showLoginForm')->name('login');
    Route::post('/login','login')->name('login,post');
    Route::post('/logout','logout')->name('logout');
});
