<?php

namespace App\Http\Controllers\Main;

use App\Article;
use App\FeatureCategory;
use App\Tag;
use App\TagRelation;
use App\State;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeatureController extends Controller
{
    public function __construct(Article $article, FeatureCategory $featureCate, Tag $tag, TagRelation $tagRel, State $state)
    {
        //$this->middleware('search');
        
        $this->article = $article;
        //$this->category = $category;
        $this->featureCate = $featureCate;
        $this->tag = $tag;
        $this->tagRel = $tagRel;
        $this->state = $state;
//        $this->tagRelation = $tagRelation;
//        $this->tagGroup = $tagGroup;
//        $this->category = $category;
//        $this->item = $item;
//        $this->fix = $fix;
//        $this->totalize = $totalize;
//        $this->totalizeAll = $totalizeAll;
        
        $this->perPage = 12;
        //$this->itemPerPage = 15;
        
    }

    public function index($state = 'all')
    {
    	
        
        
//        $whereArr = ['open_status'=>1, 'feature'=>1];
//        
//        if($state != 'all') {
//        	$stateObj = $this->state->where('slug', $state)->get()->first();
//            
//            //404
//            if(!isset($stateObj)) abort(404);
//            
//            $whereArr['state_id'] = $stateObj->id;
//        }
        
        $features = $this->featureCate->where('status', 1)->orderBy('created_at','DESC')->paginate($this->perPage);
        
        //$features = $this->article->where($whereArr)->whereIn('cate_id', $fCates)->orderBy('created_at','DESC')->paginate($this->perPage);
        
    	return view('main.feature.index', ['features'=>$features]);
    }

    

    public function showCate($state, $cate)
    {
        $fCate = $this->featureCate->where('slug', $cate)->get()->first();
        
        if(! $fCate->status) {
        	abort(404);
        }
        
        //$features = $this->article->where(['open_status'=>1,'feature'=>1, 'cate_id'=>$fCate->id])->orderBy('created_at','DESC')->paginate($this->perPage);
        
        
        $whereArr = ['open_status'=>1, 'feature'=>1, 'cate_id'=>$fCate->id];
        
        if($state != 'all') {
        	$stateObj = $this->state->where('slug', $state)->get()->first();
            
            //404
            if(!isset($stateObj)) abort(404);
            
            $whereArr['state_id'] = $stateObj->id;
        }
        
        
        $cateObj = $this->featureCate->where('slug', $cate)->get()->first();
        
        //404
        if(! isset($cateObj) || ! $cateObj->status) {
        	abort(404);
        }
        
        $features = $this->article->where($whereArr)->orderBy('created_at','DESC')->paginate($this->perPage);
        
        return view('main.feature.index', ['features'=>$features, 'cateObj'=>$cateObj]);
    }
    
    public function showSingle($state, $cate, $id)
    {
    	//404
    	if($state == 'all') abort(404);
        
        $atcl = $this->article->find($id);
        
    	$cateObj = $this->featureCate->find($atcl->cate_id);
        $stateObj = $this->state->find($atcl->state_id);
        
        $tagRels = $this->tagRel->where('atcl_id', $atcl->id)->get()->map(function($obj){
        	return $obj->id;
        })->all();
        
        $tags = $this->tag->find($tagRels);
        
        $feature = 1;
        
        return view('main.home.single', ['atcl'=>$atcl, 'cateObj'=>$cateObj, 'tags'=>$tags, 'feature'=>$feature, 'stateObj'=>$stateObj]);
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
