<?php

namespace App\Http\Controllers\DashBoard;

use App\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

use Auth;
use Closure;

class LoginController extends Controller
{
	public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::guard('admin')->check())
            return redirect('dashboard');
        else
	    	return view('dashboard.login');
    }
    
    public function postLogin(Request $request)
    {
    	$rules = [
            'email' => 'required|email|max:255',
            'password' => 'required|min:8',
        ];
        
        $this->validate($request, $rules); //errorなら自動で$errorが返されてリダイレクト、通過で自動で次の処理へ
        
        $data = $request->all();
        
        $remember = isset($data['remember']) ? true : false;
		
        
        if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']], $remember)) {
        	
            return redirect()->intended('dashboard');
        }
        else {
        	$error[] = 'メールアドレスとパスワードを確認して下さい。';
            //return redirect('dashboard/login') -> withErrors('メールアドレスとパスワードを確認して下さい。');
            return redirect() -> back() -> withErrors($error);
	    }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
