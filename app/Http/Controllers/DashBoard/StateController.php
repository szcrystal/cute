<?php

namespace App\Http\Controllers\DashBoard;

use App\State;
use App\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StateController extends Controller
{
    public function __construct(Admin $admin, State $state)
    {
    	
        $this -> middleware('adminauth');
        //$this -> middleware('log', ['only' => ['getIndex']]);
        
        $this -> admin = $admin;
        $this->state = $state;
        
        $this->perPage = 50;
        
        // URLの生成
		//$url = route('dashboard');
        
        /* ************************************** */
        //env()ヘルパー：環境変数（$_SERVER）の値を取得 .env内の値も$_SERVERに入る
	}
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $states = State::orderBy('id', 'desc')->paginate($this->perPage);
        
        
        //$status = $this->articlePost->where(['base_id'=>15])->first()->open_date;
        
        return view('dashboard.state.index', ['states'=>$states]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.state.form');
    }
    
    public function show($stateId) //Edit Page ---
    {
        $state = $this->state->find($stateId);
        
    	return view('dashboard.state.form', ['state'=>$state, 'stateId'=>$stateId, 'edit'=>1]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $editId = $request->has('edit_id') ? $request->input('edit_id') : 0;
        
        $rules = [
            //'name' => 'required|same_tag:'.$editId.','.$groupId.'|max:255', //same_tag-> on AppServiceProvider
            'name' => 'required|unique:states,name,'.$editId.'|max:255',
            'slug' => 'required|unique:states,slug,'.$editId.'|max:255', /* |unique:admins 注意:unique */
        ];
        
        $messages = [
            'name.unique' => '「県名」が既に存在します。',
            'slug.unique' => '「スラッグ」が既に存在します。',
        ];
        
        $this->validate($request, $rules, $messages);
        
        $data = $request->all();

        if($editId) { //update（編集）の時
            $stateModel = $this->state->find($editId);
            $upText = '都道府県が更新されました';
        }
        else { //新規追加の時
        	$stateModel = $this->state;
            $upText = '都道府県が追加されました';
        }
        
        $stateModel->fill($data); //モデルにセット
        $stateModel->save(); //モデルからsave
        
        $id = $stateModel->id;

        return redirect('dashboard/states/'. $id)->with('status', $upText);
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
        $name = $this->state->find($id)->name;

        
        $stateDel = $this->state->destroy($id);
        
        $status = $stateDel ? '「'.$name.'」が削除されました' : '「'.$name.'」が削除出来ませんでした';
        
        return redirect('dashboard/states')->with('status', $status);
    }
}
