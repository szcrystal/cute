<?php

namespace App\Http\Controllers\DashBoard;

use App\Admin;
use App\User;
use App\Article;
use App\Tag;
use App\TagRelation;
use App\State;
use App\FeatureCategory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeatureController extends Controller
{

    public function __construct(Article $article, Admin $admin, User $user, Tag $tag, TagRelation $tagRelation, State $state, FeatureCategory $featureCate)
    {
    	
        $this -> middleware('adminauth');
        //$this -> middleware('log', ['only' => ['getIndex']]);
        
        $this -> admin = $admin;
        $this->user = $user;
        $this->article = $article;
        $this->tag = $tag;
        $this->tagRelation = $tagRelation;
        $this->state = $state;
        $this->featureCate = $featureCate;
        
        $this->perPage = 20;
        
	}
    
    public function index()
    {
        $features = Article::where('feature',1)->orderBy('id', 'desc')->paginate($this->perPage);
//        $users = $this->user->all();
        $cateModel = $this->featureCate;
        
        //$status = $this->articlePost->where(['base_id'=>15])->first()->open_date;
        
        return view('dashboard.feature.index', ['features'=>$features, 'cateModel'=>$cateModel]);
    }
    
    public function show($ftId) //Edit Page
    {
        $feature = $this->article->find($ftId);
        
        $states = $this->state->all();
        
        $cates = $this->featureCate->where('status',1)->get();
        
        $tagNames = $this->tagRelation->where(['atcl_id'=>$ftId])->get()->map(function($item) {
            return $this->tag->find($item->tag_id)->name;
        })->all();
        
        $allTags = $this->tag->get()->map(function($item){
        	return $item->name;
        })->all();
        
        
    	return view('dashboard.feature.form', ['feature'=>$feature, 'states'=>$states, 'tagNames'=>$tagNames, 'allTags'=>$allTags, 'ftId'=>$ftId, 'cates'=>$cates, 'edit'=>1]);
    }



    public function create()
    {
    	$states = $this->state->all();
        
        $cates = $this->featureCate->where('status',1)->get();
        
    	$allTags = $this->tag->get()->map(function($item){
        	return $item->name;
        })->all();
        
        return view('dashboard.feature.form', ['allTags'=>$allTags, 'states'=>$states, 'cates'=>$cates]);
    }


    public function store(Request $request)
    {
        $editId = $request->input('edit_id') !== null ? $request->input('edit_id') : 0;
        
        return redirect()->action(
    		'DashBoard\ArticleController@store'
		);
        
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
            $ft = $this->article->find($editId);
        }
        else { //新規追加の時
            $status = '特集記事が追加されました！';
            $data['yt_up'] = 0;
            $data['tw_up'] = 0;
            $data['fb_up'] = 0;
            
            $data['view_count'] = 0;
            
        	$ft = $this->article;
        }
        
        $data['cate_id'] = 99999;
        $data['feature'] = 1;

        
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
