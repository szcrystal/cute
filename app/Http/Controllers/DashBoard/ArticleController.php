<?php

namespace App\Http\Controllers\DashBoard;

use App\Admin;
use App\User;
use App\Article;
use App\Tag;
use App\TagRelation;
use App\Category;
use App\MovieCombine;

use Auth;
use Storage;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
	public function __construct(Admin $admin, Article $article, Tag $tag, User $user, Category $category, TagRelation $tagRelation, MovieCombine $mvCombine)
    {
    	
        $this -> middleware('adminauth');
        //$this -> middleware('log', ['only' => ['getIndex']]);
        
        $this -> admin = $admin;
        $this-> article = $article;
        $this->tag = $tag;
        
        $this->user = $user;
        $this->category = $category;
        $this->tagRelation = $tagRelation;
        
        $this->mvCombine = $mvCombine;
        
        $this->perPage = 20;
        
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
        $atclObjs = Article::orderBy('id', 'desc')->paginate($this->perPage);
        $users = $this->user->all();
        $cateModel = $this->category;
        
        //$status = $this->articlePost->where(['base_id'=>15])->first()->open_date;
        
        return view('dashboard.article.index', ['atclObjs'=>$atclObjs, 'users'=>$users, 'cateModel'=>$cateModel]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    	$mvId = $request->input('mvId');
        $cates = $this->category->all();
        
        $mv = $this->mvCombine->find($mvId);
//        $mvPath = Storage::url($mv->movie_path);
//        $modelId = $mv->model_id;
        $modelName = $this->user->find($mv->model_id)->name;
        
        $allTags = $this->tag->get()->map(function($item){
        	return $item->name;
        })->all();
        
        
    	return view('dashboard.article.form', ['cates'=>$cates, 'mv'=>$mv, 'mvId'=>$mvId, 'modelName'=>$modelName, 'allTags'=>$allTags/*, 'users'=>$users*/]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$editId = $request->input('edit_id');
        
        $rules = [
        	'title' => 'required|max:255',
            //'slug' => 'required|unique:articles,slug,'.$editId.'|max:255',
        ];
        $this->validate($request, $rules);
        
        $data = $request->all(); //requestから配列として$dataにする
        
        $rand = mt_rand();
        
        if($request->file('post_thumb') != '') {
            $filename = $request->file('post_thumb')->getClientOriginalName();
            
            $aId = $editId ? $editId : $rand;
            $pre = time() . '-';
            $filename = 'article/' .$aId . '/thumbnail/' . $pre . $filename;
            //if (App::environment('local'))
            $path = $request->file('post_thumb')->storeAs('public', $filename);
            //else
            //$path = Storage::disk('s3')->putFileAs($filename, $request->file('thumbnail'), 'public');
            //$path = $request->file('thumbnail')->storeAs('', $filename, 's3');
        
            $data['post_thumb'] = $filename;
        }
        
        
        // Total
        if(! isset($data['open_status'])) {
        	$data['open_status'] = 1;
        }
        else {
        	$data['open_status'] = 0;
        }
        
        if($editId !== NULL ) { //update（編集）の時
        	$status = '記事が更新されました！';
            $atcl = $this->article->find($request->input('edit_id'));
        }
        else { //新規追加の時
            $status = '記事が追加されました！';
            //$data['model_id'] = 1;
            $data['view_count'] = 0;
            $data['yt_up'] = 0;
            $data['sns_up'] = 0;
            
        	$atcl = $this->article;
        }

        
        $atcl->fill($data);
        $atcl->save();
        $atclId = $atcl->id;
        
        //Storage 仮フォルダをidにネームし直す
        if(Storage::exists('public/article/'. $rand)) {
            Storage::move('public/article/'. $rand, 'public/article/'. $atclId);
            
            $data['post_thumb'] = str_replace($rand, $atclId, $data['post_thumb']);
            
            $atcl->post_thumb = str_replace($rand, $atclId, $atcl->post_thumb);
            $atcl->save();
            
            //if(isset($itemId)) {
//                $this->article->find($atclId)->map(function($obj) use($atclId, $rand) {
//                    $obj->post_thumb = str_replace($rand, $atclId, $obj->post_thumb);
//                    //$obj->link_imgpath = str_replace($rand, $atclId, $obj->link_imgpath);
//                    $obj->save();
//                });
            //}
        }
        
        
        //タグのsave動作
        if(isset($data['tags'])) {
            $tagArr = $data['tags'];
        
            foreach($tagArr as $tag) {
                
                //Tagセット
                $setTag = Tag::firstOrCreate(['name'=>$tag]); //既存を取得 or なければ作成
                
                if(!$setTag->slug) { //新規作成時slugは一旦NULLでcreateされるので、その後idをセットする
                    $setTag->slug = $setTag->id;
                    $setTag->save();
                }
                
                $tagId = $setTag->id;
                $tagName = $tag;


                //tagIdがRelationになければセット ->firstOrCreate() ->updateOrCreate()
                $tagRel = $this->tagRelation->where(['tag_id'=>$tagId, 'atcl_id'=>$atclId])->get();
                
                if($tagRel->isEmpty()) {
                    $this->tagRelation->create([
                        'tag_id' => $tagId,
                        'atcl_id' => $atclId,
                    ]);
                }

                //tagIdを配列に入れる　削除確認用
                $tagIds[] = $tagId;
            }
        
            //編集時のみ削除されたタグを消す
            if(isset($editId)) {
                //元々relationにあったtagがなくなった場合：今回取得したtagIdの中にrelationのtagIdがない場合をin_arrayにて確認
                $tagRels = $this->tagRelation->where('atcl_id', $atclId)->get();
                
                foreach($tagRels as $tagRel) {
                    if(! in_array($tagRel->tag_id, $tagIds)) {
                        $tagRel->delete();
                    }
                }
            }
        }
        
        
        return redirect('dashboard/articles/'. $atclId)->with('status', $status);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $atcl = $this->article->find($id);
        $cates = $this->category->all();
        
        $mvId = $atcl->movie_id;
        $mv = $this->mvCombine->find($mvId);
        
        
        //$mvPath = Storage::url($mv->movie_path);
        //$modelId = $mv->model_id;
        $modelName = $this->user->find($atcl->model_id)->name;
        
        $tagNames = $this->tagRelation->where(['atcl_id'=>$id])->get()->map(function($item) {
            return $this->tag->find($item->tag_id)->name;
        })->all();
        
        $allTags = $this->tag->get()->map(function($item){
        	return $item->name;
        })->all();
        
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
        
    	return view('dashboard.article.form', ['atcl'=>$atcl, 'mv'=>$mv, 'modelName'=>$modelName, 'tagNames'=>$tagNames, 'allTags'=>$allTags, 'cates'=>$cates, 'mvId'=>$mvId, 'id'=>$id, 'edit'=>1]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = $this->article->find($id);
        
        
        
        
        
        //$cates = $this->category->all();
        //$users = $this->user->where('active',1)->get();
        
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
        
    	return view('dashboard.article.form', ['article'=>$article,/* 'cates'=>$cates, 'users'=>$users,*/ 'id'=>$id, 'edit'=>1]);
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
        $title = $this->article->find($id)->title;
        
        $atcls = $this->article->where('cate_id', $id)->get()->map(function($atcl){
        	$atcl->cate_id = 0;
            $atcl->save();
        });
        
        $atclDel = $this->article->destroy($id);
        
        $status = $atclDel ? 'カテゴリー「'.$title.'」が削除されました' : '記事「'.$title.'」が削除出来ませんでした';
        
        return redirect('dashboard/articles')->with('status', $status);
    }
}
