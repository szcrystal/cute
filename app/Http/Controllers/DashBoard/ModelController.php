<?php

namespace App\Http\Controllers\DashBoard;

use App\Admin;
use App\User;
use App\ModelSnap;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ModelController extends Controller
{
	public function __construct(Admin $admin, User $user, ModelSnap $modelSnap)
    {
        $this -> middleware('adminauth'/*, ['except' => ['getRegister','postRegister']]*/);
        //$this->middleware('auth:admin', ['except' => 'getLogout']);
        //$this -> middleware('log', ['only' => ['getIndex']]);
        
        $this -> admin = $admin;
        $this -> user = $user;
        $this -> modelSnap = $modelSnap;
        
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
    
    
    public function show($modelId) //Edit Page
    {
        $model = $this->user->find($modelId);
        
        $snaps = $this->modelSnap->where('model_id', $modelId)->get();
        
//        print_r($snaps[0]->ask);
//        exit;
        
        return view('dashboard.model.form', ['modelId'=>$modelId, 'model'=>$model, 'snaps'=>$snaps]);
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
        $modelId = $request->input('model_id') ? $request->input('model_id') : 0;
        
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
        
        
        
        
        
        if($modelId ) { //update（編集）の時
            $mdModel = $this->user->find($modelId);
            
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
        
        
        
        
        //Snap Save
        foreach($data['snap_count'] as $count) {
        
//        	echo $data['del_snap'][0];
//            exit;
            
        	
            if(isset($data['del_snap'][$count]) && $data['del_snap'][$count]) {
            	//echo $count . '/' .$data['del_snap'][$count];
            	//exit;
                
            	$snapModel = $this->modelSnap->where(['model_id'=>$modelId, 'number'=>$count+1])->first();
                $snapModel ->delete();
                //exit;
                
//                $snapModel = $this->modelSnap->create(
//                    [
//                        'model_id'=>$modelId,
//                        'number'=> $count+1,
//                    ]
//                );
            
            }
            else {
        	
                $snapModel = $this->modelSnap->updateOrCreate(
                    ['model_id'=>$modelId, 'number'=>$count+1],
                    [
                        'model_id'=>$modelId,
                        //'snap_path' =>'',
                        'ask' => $data['ask'][$count],
                        'answer' => $data['answer'][$count],
                        'number'=> $count+1,
                    ]
                );
                
                if(isset($data['snap_thumb'][$count])) {
                
                    $filename = $data['snap_thumb'][$count]->getClientOriginalName();
                    
                    //$aId = $editId ? $editId : $rand;
                    //$pre = time() . '-';
                    $filename = 'model/' . $modelId . '/snap/'/* . $pre*/ . $filename;
                    //if (App::environment('local'))
                    $path = $data['snap_thumb'][$count]->storeAs('public', $filename);
                    //else
                    //$path = Storage::disk('s3')->putFileAs($filename, $request->file('thumbnail'), 'public');
                    //$path = $request->file('thumbnail')->storeAs('', $filename, 's3');
                
                    //$data['model_thumb'] = $filename;
                    
                    $snapModel->snap_path = $filename;
                    $snapModel->save();
                }
            }
            
        } //foreach
        
        $num = 1;
        $snaps = $this->modelSnap->where(['model_id'=>$modelId])->get();
//            $snaps = $this->modelSnap->where(['model_id'=>$modelId])->get()->map(function($obj) use($num){
//            	
//                return true;
//            });
        
        foreach($snaps as $snap) {
            $snap->number = $num;
            $snap->save();
            $num++;
        }

    	//return view('dashboard.article.form', ['thisClass'=>$this, 'tags'=>$tags, 'status'=>'記事が更新されました。']);
        return redirect('dashboard/models/'.$modelId)->with('status', $status);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

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
