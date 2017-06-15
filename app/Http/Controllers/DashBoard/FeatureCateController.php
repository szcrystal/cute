<?php

namespace App\Http\Controllers\DashBoard;

use App\FeatureCategory;
use App\Article;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeatureCateController extends Controller
{
    public function __construct(FeatureCategory $featureCate, Article $article)
    {
    	$this->featureCate = $featureCate;
        $this->article = $article;
        
        $this->perPage = 30;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cates = FeatureCategory::orderBy('id', 'desc')->paginate($this->perPage);
        
        $atclModel = $this->article->where('feature', 1)->get();
        
        return view('dashboard.featureCate.index', ['cates'=>$cates, 'atclModel'=>$atclModel]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	//$itemCount = $this->itemCount;
        
        return view('dashboard.featureCate.form', []);
    }
    
    public function show($id)
    {
        $cate = $this->featureCate->find($id);
        
    	return view('dashboard.featureCate.form', ['cate'=>$cate, 'id'=>$id, 'edit'=>1]);
    }



    public function store(Request $request)
    {
        $editId = $request->has('edit_id') ? $request->input('edit_id') : 0;
        
        $rules = [
            'name' => 'required|unique:feature_categories,name,'.$editId.'|max:255',
            'slug' => 'required|unique:feature_categories,slug,'.$editId.'|max:255', /* 注意:unique */

        ];
        
        $messages = [
            'name.required' => '「カテゴリー名」は必須です。',
            'name.unique' => '「カテゴリー名」が既に存在します。',
            'slug.unique' => '「スラッグ」が既に存在します。',
        ];
        
        $this->validate($request, $rules, $messages);
        
        $data = $request->all(); //requestから配列として$dataにする
        
        if(! isset($data['status'])) { //checkbox
        	$data['status'] = 1;
        }
        else {
        	$data['status'] = 0;
        }
        

        if($editId) { //update（編集）の時
        	$status = 'カテゴリーが更新されました！';
            $cateModel = $this->featureCate->find($editId);
        }
        else { //新規追加の時
            $status = 'カテゴリーが追加されました！';
            $data['view_count'] = 0;
        	$cateModel = $this->featureCate;
        }
        
        $cateModel->fill($data); //モデルにセット
        $cateModel->save(); //モデルからsave
        
        $cateId = $cateModel->id;
        
        
        return redirect('dashboard/featurecates/'.$cateId)->with('status', $status);
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
        $name = $this->category->find($id)->name;
        
        $atcls = $this->article->where('cate_id', $id)->get()->map(function($atcl){
        	$atcl->cate_id = 0;
            $atcl->save();
        });
        
        $cateDel = $this->category->destroy($id);
        
        $status = $cateDel ? 'カテゴリー「'.$name.'」が削除されました' : '記事「'.$name.'」が削除出来ませんでした';
        
        return redirect('dashboard/cates')->with('status', $status);
    }
}
