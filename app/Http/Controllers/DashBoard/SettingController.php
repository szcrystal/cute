<?php

namespace App\Http\Controllers\DashBoard;

use App\Setting;
use App\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function __construct(Admin $admin, Setting $setting)
    {
    	
        $this -> middleware('adminauth');
        //$this -> middleware('log', ['only' => ['getIndex']]);
        
        $this -> admin = $admin;
        $this->setting = $setting;
        
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
        $setting = Setting::get()->first();
        
        
        //$status = $this->articlePost->where(['base_id'=>15])->first()->open_date;
        
        return view('dashboard.setting.form', ['setting'=>$setting]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view('dashboard.state.form');
    }
    
    public function show($stateId) //Edit Page ---
    {
        //$state = $this->state->find($stateId);
    	//return view('dashboard.state.form', ['state'=>$state, 'stateId'=>$stateId, 'edit'=>1]);
    }


    public function store(Request $request)
    {
        //$editId = $request->has('edit_id') ? $request->input('edit_id') : 0;
        
        $rules = [
            //'name' => 'required|same_tag:'.$editId.','.$groupId.'|max:255', //same_tag-> on AppServiceProvider
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            //'slug' => 'required|unique:states,slug,'.$editId.'|max:255', /* |unique:admins 注意:unique */
        ];
        
        $messages = [
            'name.required' => '「管理者名」は必須です。',
            //'emailrequired' => '「管理者メール」は必須です。',
        ];
        
        $this->validate($request, $rules, $messages);
        
        $data = $request->all();

        
        $settingModel = $this->setting->get()->first();
        $upText = 'サイト設定が更新されました';
        
        
        $settingModel->fill($data); //モデルにセット
        $settingModel->save(); //モデルからsave
        
        $id = $settingModel->id;

        return redirect('dashboard/settings/')->with('status', $upText);
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
