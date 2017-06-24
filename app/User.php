<?php

namespace App;

use Mail;
use Request;
use App\Setting;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Validator;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'state_id',
        'name',
        'full_name',
        'email',
        'password',
        'model_thumb',
        'twitter',
        'instagram',
        'school',
        'per_info',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function sendPasswordResetNotification($token)
    {
        //$this->notify(new ResetPasswordNotification($token));

        $email = Request::input('email');
        
//        $rules = [
//            'email' => 'required|email|exists:users|max:255',
//        ];
//        
//        Validator::validate($request, $rules);
        
        $user = User::where('email', $email)->first();
        $setting = Setting::first();
        
        $data['email'] = $email;
        $data['name'] = $user->name;
        $data['token'] = $token;
        
        $data['admin_email'] = $setting->email;
        $data['admin_name'] = $setting->name;
        $data['footer'] = $setting->mail_footer;
        
        Mail::send('emails.password', $data, function($message) use ($data)
        {
            $message -> from($data['admin_email'], $data['admin_name'])
                     -> to($data['email'], $data['name'])
                     -> subject('Cute.Campus パスワードリセット用リンク');
            //$message->attach($pathToFile);
        });
    }
    
}
