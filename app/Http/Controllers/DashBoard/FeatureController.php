<?php

namespace App\Http\Controllers\DashBoard;

use App\Admin;
use App\User;
use App\Feature;
use App\MovieCombine;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeatureController extends Controller
{

    public function __construct(Feature $feature, Admin $admin, User $user, MovieCombine $mvCombine)
    {
    	
        $this -> middleware('adminauth');
        //$this -> middleware('log', ['only' => ['getIndex']]);
        
        $this -> admin = $admin;
        $this->user = $user;
        $this->feature = $feature;
        $this->mvCombine = $mvCombine;
        
        $this->perPage = 20;
        
	}
    
    public function index()
    {
        $features = Feature::orderBy('id', 'desc')->paginate($this->perPage);
//        $users = $this->user->all();
//        $cateModel = $this->category;
        
        //$status = $this->articlePost->where(['base_id'=>15])->first()->open_date;
        
        return view('dashboard.feature.index', ['features'=>$features]);
    }
    
    public function show($ftId) //Edit Page
    {
        $feature = $this->feature->find($ftId);
//        $cates = $this->category->all();
//        
//        $mvId = $atcl->movie_id;
//        $mv = $this->mvCombine->find($mvId);
//        
//        
//        //$mvPath = Storage::url($mv->movie_path);
//        //$modelId = $mv->model_id;
//        $modelName = $this->user->find($atcl->model_id)->name;
//        
//        $tagNames = $this->tagRelation->where(['atcl_id'=>$id])->get()->map(function($item) {
//            return $this->tag->find($item->tag_id)->name;
//        })->all();
//        
//        $allTags = $this->tag->get()->map(function($item){
//        	return $item->name;
//        })->all();
        
//        $atclTag = array();
//        $n = 0;
//        while($n < 3) {
//        	$name = 'tag_'.$n+1;
//            $atclTag[] = explode(',', $article->tag_{$n+1});
//            $n++;
//        }
//        
//        print_r($atclTag);
//        exit();
        
        //$tags = $this->getTags();
        
//        echo $article->tag_1. "aaaaa";
//        foreach($tags[0] as $tag)
//        	echo $tag-> id."<br>";
//        exit();
        
    	return view('dashboard.feature.form', ['feature'=>$feature, 'ftId'=>$ftId, 'edit'=>1]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public function create(Request $request) //New Add
//    {
//    	$mvId = $request->input('ftId');
////        $cates = $this->category->all();
////        
////        $mv = $this->mvCombine->find($mvId);
//////        $mvPath = Storage::url($mv->movie_path);
//////        $modelId = $mv->model_id;
////        $modelName = $this->user->find($mv->model_id)->name;
////        
////        $allTags = $this->tag->get()->map(function($item){
////        	return $item->name;
////        })->all();
//        
//        
//    	
//    }


    public function create()
    {
        return view('dashboard.feature.form', []);
    }


    public function store(Request $request)
    {
        $editId = $request->input('edit_id') !== null ? $request->input('edit_id') : 0;
        
        $rules = [
        	'title' => 'required|max:255',
            //'slug' => 'required|unique:articles,slug,'.$editId.'|max:255',
        ];
        $this->validate($request, $rules);
        
        $data = $request->all(); //requestから配列として$dataにする
        

        //$rand = mt_rand();
        
//        if($request->file('post_thumb') != '') {
//            $filename = $request->file('post_thumb')->getClientOriginalName();
//            
//            $aId = $editId ? $editId : $rand;
//            $pre = time() . '-';
//            $filename = 'article/' .$aId . '/thumbnail/' . $pre . $filename;
//            //if (App::environment('local'))
//            $path = $request->file('post_thumb')->storeAs('public', $filename);
//            //else
//            //$path = Storage::disk('s3')->putFileAs($filename, $request->file('thumbnail'), 'public');
//            //$path = $request->file('thumbnail')->storeAs('', $filename, 's3');
//        
//            $data['post_thumb'] = $filename;
//        }
        
        
        // Total
        if(isset($data['open_status'])) {
        	$data['open_status'] = 0;
        }
        else {
        	$data['open_status'] = 1;
        }
        
        if($editId) { //update（編集）の時
        	$status = '特集記事が更新されました！';
            $ft = $this->feature->find($editId);
        }
        else { //新規追加の時
            $status = '特集記事が追加されました！';
            //$data['model_id'] = 1;
            $data['view_count'] = 0;
            
        	$ft = $this->feature;
        }

        
        $ft->fill($data);
        $ft->save();
        $ftId = $ft->id;
        
        if(isset($data['post_movie'])) {
            
            //$filename = $request->file('post_thumb')->getClientOriginalName();
            $filename = $data['post_movie']->getClientOriginalName();
            
            //$aId = $editId ? $editId : $rand;
            //$pre = time() . '-';
            $filename = 'feature/' . $ftId . '/movie/'/* . $pre*/ . $filename;
            //if (App::environment('local'))
            $path = $data['post_movie']->storeAs('public', $filename);
            //else
            //$path = Storage::disk('s3')->putFileAs($filename, $request->file('thumbnail'), 'public');
            //$path = $request->file('thumbnail')->storeAs('', $filename, 's3');
            
            $ft->movie_path = $path;
            $ft->save();
        }
        
        
        if(isset($data['post_thumb'])) {
            
            $filename = $data['post_thumb']->getClientOriginalName();
            
            //$pre = time() . '-';
            $filename = 'feature/' . $ftId . '/thumbnail/'/* . $pre*/ . $filename;
            //if (App::environment('local'))
            $path =  $data['post_thumb']->storeAs('public', $filename);
            //else
            //$path = Storage::disk('s3')->putFileAs($filename, $request->file('thumbnail'), 'public');
            //$path = $request->file('thumbnail')->storeAs('', $filename, 's3');
        
            
            $ft->thumb_path = $path;
            $ft->save();
        }
        
        
        
        
        return redirect('dashboard/features/'. $ftId)->with('status', $status);
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
