<?php

namespace App\Http\Controllers\DashBoard;

use App\Admin;
use App\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ModelController extends Controller
{
	public function __construct(Admin $admin, User $user)
    {
        $this -> middleware('adminauth'/*, ['except' => ['getRegister','postRegister']]*/);
        //$this->middleware('auth:admin', ['except' => 'getLogout']);
        //$this -> middleware('log', ['only' => ['getIndex']]);
        
        $this -> admin = $admin;
        $this -> user = $user;
        
        $this->perPage = 20;

	}
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate($this->perPage);
        
        //$cateModel = $this->category;
        //$status = $this->articlePost->where(['base_id'=>15])->first()->open_date;
        
        return view('dashboard.model.index', ['users'=>$users]);
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
    	$valueId = $request->input('model_id') ? ','. $request->input('model_id') : '';
        
        $rules = [
            //'cate_id' => 'required',
            'name' => 'required|max:255', /* |unique:admins 注意:unique */
        	'email' => 'required|email|max:255|unique:users,email'.$valueId,
            //'movie_site' => 'required|max:255',
            //'password' => 'required|min:8',
            //'movie_url' => 'required|max:255|unique:articles,movie_url'.$except,
        ];
        
        $this->validate($request, $rules);
        
        $data = $request->all();
        
        
        if($request->input('model_id') !== NULL ) { //update（編集）の時
            $mdModel = $this->user->find($request->input('model_id'));
            
            //if($data['password'] == '') {
            if(! isset($data['password'])) {
            	$data['password'] = $mdModel->password;
            }
            else {
            	$data['password'] = bcrypt($data['password']);
            }
            
            $status = 'モデルが更新されました！';
        }
        else { //新規追加の時
            $data['password'] = bcrypt($data['password']);
            $status = 'モデルが追加されました！';
            
        	$mdModel = $this->user;
        }
        
        //$data['authority'] = 0;
        
        $mdModel->fill($data); //モデルにセット
        $mdModel->save(); //モデルからsave
        
        
        $modelId = $mdModel->id;
        
        
        if($request->file('model_thumb') != '') {
            
            $filename = $request->file('model_thumb')->getClientOriginalName();
            
            //$aId = $editId ? $editId : $rand;
            //$pre = time() . '-';
            $filename = 'model/' . $modelId . '/thumbnail/'/* . $pre*/ . $filename;
            //if (App::environment('local'))
            $path = $request->file('model_thumb')->storeAs('public', $filename);
            //else
            //$path = Storage::disk('s3')->putFileAs($filename, $request->file('thumbnail'), 'public');
            //$path = $request->file('thumbnail')->storeAs('', $filename, 's3');
        
            $data['model_thumb'] = $filename;
            
            $mdModel->model_thumb = $filename;
            $mdModel->save();
        }

    	//return view('dashboard.article.form', ['thisClass'=>$this, 'tags'=>$tags, 'status'=>'記事が更新されました。']);
        return redirect('dashboard/models/'.$modelId.'/edit')->with('status', $status);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = $this->user->find($id);
        return view('dashboard.model.form', ['modelId'=>$id, 'model'=>$model]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    	$model = $this->user->find($id);
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
