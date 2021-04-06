<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Intervention\Image\Facades\Image;
use App\Services\FileUploadServices;
use App\Services\CheckExtensionServices;



class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'img_name' => ['required','file', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2000'],
            'self_introduction' => ['string', 'max:255'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    { 
        //引数 $data から name='img_name'を取得(アップロードするファイル情報)
        if(!empty($data['img_name'])){

            $imageFile = $data['img_name'];
    
            //$imageFileからファイル名を取得(拡張子あり)
            // $filenameWithExt = $imageFile->getClientOriginalName();
    
            // //拡張子を除いたファイル名を取得
            // $fileName = pathinfo($filenameWithExt, PATHINFO_FILENAME);
    
            // //拡張子を取得
            // $extension = $imageFile->getClientOriginalExtension();
    
            // //ファイル名＿時間＿拡張子として設定
            // $fileNameToStore = $fileName.'_'.time().'.'.$extension
    
            // //画像ファイル取得
            // $fileData = file_get_contents($imageFile -> getRealPath());
    
            $list = FileUploadServices::fileUpload($imageFile); //上記省略
    
            list($extension, $fileNameToStore, $fileData) = $list; //上記省略
    
            $data_url = CheckExtensionServices::checkExtension($fileData, $extension);
    
            //画像をリサイズして保存する
            $image = Image::make($data_url);        
            $image->resize(400,400)->save(storage_path() . '/app/public/images/' . $fileNameToStore );

            
    
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'self_introduction'=>$data['self_introduction'],
                'sex'=>$data['sex'],
                'img_name' => $fileNameToStore,
           ]);
        } else {
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'self_introduction'=>$data['self_introduction'],
                'sex'=>$data['sex'],
           ]);
        }
    }
}
