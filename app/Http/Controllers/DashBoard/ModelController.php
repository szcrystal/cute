<?php

namespace App\Http\Controllers\DashBoard;

use App\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ModelController extends Controller
{
	public function __construct(Admin $admin)
    {
        $this -> middleware('adminauth'/*, ['except' => ['getRegister','postRegister']]*/);
        //$this->middleware('auth:admin', ['except' => 'getLogout']);
        //$this -> middleware('log', ['only' => ['getIndex']]);
        
        $this -> admin = $admin;
        
        $this->perPage = 20;

	}
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.model.form');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'cate_id' => 'required',
            'title' => 'required|max:255', /* |unique:admins 注意:unique */
            'movie_site' => 'required|max:255',
            'password' => 'required|min:8',
            //'movie_url' => 'required|max:255|unique:articles,movie_url'.$except,
        ];
        
        //$this->validate($request, $rules);
        
        $data = $request->all();
        
        
        
        if($request->input('model_id') !== NULL ) { //update（編集）の時
            $mdModel = $this->admin->find($request->input('model_id'));
            
            if($data['password'] == '') {
            	$data['password'] = $mdModel->password;
            }
            else {
            	$data['password'] = bcrypt($data['password']);
            }
            
            
            $status = '動画情報が更新されました！';
        }
        else { //新規追加の時
            $data['password'] = bcrypt($data['password']);
            $status = '動画情報が追加されました！';
            
        	$mdModel = $this->admin;
        }
        
        $data['authority'] = 0;
        
        $mdModel->fill($data); //モデルにセット
        $mdModel->save(); //モデルからsave
        
        
        $id = $mdModel->id;
    	//return view('dashboard.article.form', ['thisClass'=>$this, 'tags'=>$tags, 'status'=>'記事が更新されました。']);
        return redirect('dashboard/model/'.$id.'/edit')->with('status', $status);

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
    	$model = $this->admin->find($id);
        return view('dashboard.model.form', ['modelId'=>$id, 'model'=>$model]);
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
