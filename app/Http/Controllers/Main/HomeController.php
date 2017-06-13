<?php

namespace App\Http\Controllers\Main;

use App\Article;
use App\Category;
use App\FeatureCategory;
use App\State;
use App\Tag;
use App\TagRelation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
	public function __construct(Article $article, Category $category, FeatureCategory $featureCate, State $state, Tag $tag, TagRelation $tagRel)
    {
        //$this->middleware('search');
        
        $this->article = $article;
        $this->category = $category;
        $this->featureCate = $featureCate;
        $this->state = $state;
        $this->tag = $tag;
        $this->tagRel = $tagRel;
//        $this->tag = $tag;
//        $this->tagRelation = $tagRelation;
//        $this->tagGroup = $tagGroup;
//        $this->category = $category;
//        $this->item = $item;
//        $this->fix = $fix;
//        $this->totalize = $totalize;
//        $this->totalizeAll = $totalizeAll;
        
        $this->perPage = env('PER_PAGE', 20);
        $this->itemPerPage = 15;
        
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($state = null)
    {
        //$atcls = Article::where(['open_status'=>1, 'feature'=>0])->orderBy('open_date','DESC')->get();
        //->paginate($this->perPage);
        
        $cates = $this->category->all();
        
        $whereArr = ['open_status'=>1, 'feature'=>0];
        $whereArrSec = ['open_status'=>1,'feature'=>1];
        
        //新着3件
        $newAtcl = $this->article->where($whereArr)->orderBy('created_at','DESC')->take(3)->get();
        
        $stateObj = null;
        
    	if(isset($state)) {
        	$stateObj = $this->state->where('slug', $state)->get()->first();
            $whereArr['state_id'] = $stateObj->id;
            $whereArrSec['state_id'] = $stateObj->id;
        }
        
        $atcls = array();

        foreach($cates as $cate) { //カテゴリー名をkeyとしてatclのかたまりを配列に入れる
        
        	$whereArr['cate_id'] = $cate->id;
            
        	$as = $this->article->where($whereArr)->orderBy('created_at','DESC')->take(3)->get()->all();
            
            if(count($as) > 0) {
            	$atcls[$cate->name] = $as;
            }
        }
//        $atcls = $this->article->where(['open_status'=>1, 'feature'=>0])->orderBy('created_at','DESC')->get();
//        $atcls = $atcls->groupBy('cate_id')->toArray();
        
        
        $fCates = $this->featureCate->where('status', 1)->get()->map(function($obj){
        	return $obj->id;
        })->all();
        
        //特集
        $features = $this->article->where($whereArrSec)->whereIn('cate_id', $fCates)->orderBy('created_at','DESC')->take(3)->get();
        
    	
    	return view('main.home.index', ['newAtcl'=>$newAtcl, 'atcls'=>$atcls, 'cates'=>$cates, 'features'=>$features, 'stateObj'=>$stateObj]);

    }
    
    
    public function showCate($state = 'all', $cate)
    {
        //$whereArrSec = ['open_status'=>1,'feature'=>1,];
        
        $whereArr = ['open_status'=>1, 'feature'=>0];
        
        if($state != 'all') {
        	$stateObj = $this->state->where('slug', $state)->get()->first();
            
            //404
            if(!isset($stateObj)) abort(404);
            
            $whereArr['state_id'] = $stateObj->id;
        }
        
        
        $cateObj = $this->category->where('slug', $cate)->get()->first();
        
        //404
        if(!isset($cateObj)) abort(404);
        
        $atcls = $this->article->where($whereArr)->orderBy('created_at','DESC')->paginate($this->perPage);

		return view('main.archive.index', ['atcls'=>$atcls, 'cateObj'=>$cateObj]);
        
	}
    
    public function showSingle($state, $cate, $id)
    {
    	//404
    	if($state == 'all') abort(404);
        
        
    	$atcl = $this->article->find($id);
        
        $cateObj = $this->category->find($atcl->cate_id);
        $stateObj = $this->state->find($atcl->state_id);
        
        $tagRels = $this->tagRel->where('atcl_id', $atcl->id)->get()->map(function($obj){
        	return $obj->id;
        })->all();
        
        $tags = $this->tag->find($tagRels);
        
        
        return view('main.home.single', ['atcl'=>$atcl, 'cateObj'=>$cateObj, 'tags'=>$tags, 'stateObj'=>$stateObj]);
    }


    
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
