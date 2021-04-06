<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\User;
use App\Reaction;
use App\Constants\Status;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::all();
        // $user_ids = DB::table('users')->pluck('id'); //user_idを全部取得
        
        // $authUserSex = Auth::user()->sex;
        // if($authUserSex === 0 ) {
        //   $target_gender = 1;
        // }
            
        // if($authUserSex === 1) {
        //   $target_gender = 0;
        // }
        
        // $target = DB::table('users')->where('sex', $target_gender)->find('id');
        
        // $target_ids = User::where('sex', $target_gender)->pluck('id');


        // $matching_ids = Reaction::whereIn('to_user_id', $user_ids)
        // ->where('status', Status::LIKE)
        // ->where('from_user_id', Auth::id())
        // ->pluck('to_user_id');
        
        

        // $notLikeusers = User::where('id', $matching_ids)
        // ->where('sex', $target_gender)
        // ->pluck('id');
        
        
        $userCount = $users->count(); 
        $from_user_id = Auth::id(); 

        return view('home', compact('users', 'userCount', 'from_user_id')); // 追加
    }
}
