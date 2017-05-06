<?php

namespace App\Http\Controllers\DashBoard;

use App\Admin;
use App\User;
use App\Article;
use App\Tag;
use App\TagRelation;
use App\Category;

use Auth;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
	public function __construct(Admin $admin, Article $article, Tag $tag, User $user, Category $category, TagRelation $tagRelation)
    {
    	
        $this -> middleware('adminauth');
        //$this -> middleware('log', ['only' => ['getIndex']]);
        
        $this -> admin = $admin;
        $this-> article = $article;
        $this->tag = $tag;
        
        $this->user = $user;
        $this->category = $category;
        $this->tagRelation = $tagRelation;
        
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
        $article = $this->article->find($id);
        //$cates = $this->category->all();
        //$users = $this->user->where('active',1)->get();
        
        $tags = $this->tag->all();
        
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
        
    	return view('dashboard.article.form', ['article'=>$article, 'tags'=>$tags, 'id'=>$id, 'edit'=>1]);
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
