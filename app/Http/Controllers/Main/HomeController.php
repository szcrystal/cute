<?php

namespace App\Http\Controllers\Main;

use App\Article;
use App\Category;
use App\FeatureCategory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
	public function __construct(Article $article, Category $category, FeatureCategory $featureCate)
    {
        //$this->middleware('search');
        
        $this->article = $article;
        $this->category = $category;
        $this->featureCate = $featureCate;
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
    public function index()
    {
        //$atcls = Article::where(['open_status'=>1, 'feature'=>0])->orderBy('open_date','DESC')->get();
        //->paginate($this->perPage);
        
        $atcls = array();
        
		$cates = $this->category->all();
        
        foreach($cates as $cate) {
        	$as = $this->article->where(['open_status'=>1, 'feature'=>0, 'cate_id'=>$cate->id])->orderBy('created_at','DESC')->get()->all();
            
            if(count($as) > 0) {
            	$atcls[$cate->name] = $as;
            }
        }
//        $atcls = $this->article->where(['open_status'=>1, 'feature'=>0])->orderBy('created_at','DESC')->get();
//        $atcls = $atcls->groupBy('cate_id')->toArray();
        
//        print_r($atcls);
//        exit;
        
        
        $fCates = $this->featureCate->where('status', 1)->get()->map(function($obj){
        	return $obj->id;
        })->all();
        
        $features = $this->article->where('feature', 1)->whereIn('cate_id', $fCates)->orderBy('created_at','DESC')->take(3)->get();
        
    	
    	return view('main.index', ['atcls'=>$atcls, 'cates'=>$cates, 'features'=>$features]);

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
