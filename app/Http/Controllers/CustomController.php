<?php

namespace App\Http\Controllers;

use App\Article;
use App\State;
use App\Category;
use App\FeatureCategory;
use App\User;


use Illuminate\Http\Request;

class CustomController extends Controller
{
    public function __construct(Article $article, State $state/*, Category $category, Tag $tag, TotalizeAll $totalizeAll*/)
    {
    	
    	$this->article = $article;
        $this->state = $state;
//        $this->category = $category;
//        $this->tag = $tag;
//        $this->totalizeAll = $totalizeAll;
        
	}
    
    
    static function changeDate($arg, $rel=0)
    {
    	if(!$rel)
	        return date('Y/m/d H:i', strtotime($arg));
        else
        	return date('Y/m/d', strtotime($arg));
    }
    
    static function getAtclUrl($atclId)
    {
    	$atcl = Article::find($atclId);
        $stateSlug = State::find($atcl->state_id)->slug;
        
        
        if($atcl->feature) {
        	$cateSlug = FeatureCategory::find($atcl->cate_id)->slug;
        	$url = $stateSlug . '/feature/'. $cateSlug . '/' .$atclId;
        }
        else {
        	$cateSlug = Category::find($atcl->cate_id)->slug;
        	$url = $stateSlug . '/'. $cateSlug . '/' .$atclId;
        }
        
        return $url;
    }
    
    static function getFeatureCateUrl($cateId, $requestPath)
    {
    	$cateSlug = FeatureCategory::find($cateId)->slug;
        
    	//$path = Request::path();
        $path = explode('/', $requestPath);
        
        $state = State::where('slug', $path[0])->first();
        
        if(isset($state)) {
            $stateSlug = $state->slug . '/';
        }
        else {
            $stateSlug = 'all/';
        }
        
        $url = $stateSlug . 'feature/' . $cateSlug;
        
        return $url;
    }
    
    static function getModelUrl($modelId)
    {
    	$model = User::find($modelId);
        $stateSlug = State::find($model->state_id)->slug;
        
        $url = $stateSlug . '/model/' . $modelId;
        
        return $url;
    }
    
    
    
    
    static function getArgForView($slug, $type)
    {
//    	$posts = Article::where('open_status', 1)
//               ->orderBy('open_date', 'desc')
//               ->take(30)
//               ->get();

//        foreach($rankObjs as $obj) {
//        	$objId[] = $obj->post_id;
//            //$rankObj[] = $this->articlePost->find($obj->post_id);
//        }
//    
//    	$ranks = $this->articlePost ->find($objId)->where('open_status', 1)->take(20);
        
        //非Openのグループidを取る
//        $tgIds = TagGroup::where('open_status', 0)->get()->map(function($tg){
//            return $tg->id;
//        })->all();
//        
//        //人気タグ
//        $tagLeftRanks = Tag::whereNotIn('group_id', $tgIds)->where('view_count','>',0)->orderBy('view_count', 'desc')->take(10)->get();
//        
//        //Category
//        $cateLeft = Category::all(); //open_status
		
        $rightRanks = '';
        
        //TOP20
        if($type == 'tag') {
        	$tag = Tag::where('slug', $slug)->first();
            $atclIds = TagRelation::where('tag_id', $tag->id)->get()->map(function($tr){
            	$atcl = Article::find($tr->atcl_id);
                if($atcl) {
                    if($atcl->open_status && ! $atcl->del_status && $atcl->owner_id > 0) {
                        return $tr->atcl_id;
                    }
                }
            })->all();
            
            $rightRanks = TotalizeAll::whereIn('atcl_id', $atclIds)->orderBy('total_count', 'desc')->take(20)->get();

        }
        else if($type == 'cate') {
        	$cate = Category::where('slug', $slug)->first();
        	
            $atclIds = Article::where(['open_status'=>1, 'del_status'=>0, 'cate_id'=>$cate->id])->whereNotIn('owner_id', [0])
                ->get()->map(function($al){
                    return $al->id;
                })->all();
            
            $rightRanks = TotalizeAll::whereIn('atcl_id', $atclIds)->orderBy('total_count', 'desc')->take(20)->get();
            
        }
        else { //all
            $atclIds = Article::where([
                ['open_status','=',1], ['del_status', '=', '0'], ['owner_id', '>', '0']
            ])
            ->get()->map(function($al){
                return $al->id;
            })->all();
            
            $rightRanks = TotalizeAll::whereIn('atcl_id', $atclIds)->orderBy('total_count', 'desc')->take(20)->get();

        }
        
        //return compact('tagLeftRanks', 'cateLeft', 'rightRanks');
        return $rightRanks;
    }
    
    static function getLeftbar() {
    	//非Openのグループidを取る
        $tgIds = TagGroup::where('open_status', 0)->get()->map(function($tg){
            return $tg->id;
        })->all();
        
        //人気タグ
        $tagLeftRanks = Tag::whereNotIn('group_id', $tgIds)->where('view_count','>',0)->orderBy('view_count', 'desc')->take(10)->get();
        
        //Category
        $cateLeft = Category::all(); //open_status
        
        return compact('tagLeftRanks', 'cateLeft');
    }
    
    static function shortStr($str, $length)
    {
    	if(mb_strlen($str) > $length) {
        	$continue = '…';
            $str = mb_substr($str, 0, $length);
            $str = $str . $continue;
        }

        return $str;
    }
    
    
    static function fixList()
    {
    	$fixes = Fix::where('not_open', 0)->get();
        
        return $fixes;
    }
    
    static function isOld()
    {
    	return count(old()) > 0;
    }
    
    static function isOldSelected($name, $obj, $objs)
    {
    	$selected = '';
        if(CustomController::isOld()) {
        	if(old($name) == $obj)
            	$selected = ' selected';
        }
        else {
        	if(isset($objs) && $objs->$name == $obj) {
            	$selected = ' selected';
            }
        }
        
        return $selected;
    }
    
    static function isOldChecked($name, $objs)
    {
    	$checked = '';
        if(CustomController::isOld()) {
        	if(old($name))
            	$checked = ' checked';
        }
        else {
        	//isset($article) && $article->del_status
        	if(isset($objs) && $objs->$name) {
            	$checked = ' checked';
            }
        }
        
        return $checked;
    }
    
    static function isAgent($agent)
    {
        $ua_sp = array('iPhone','iPod','Mobile ','Mobile;','Windows Phone','IEMobile');
        $ua_tab = array('iPad','Kindle','Sony Tablet','Nexus 7','Android Tablet');
        $all_agent = array_merge($ua_sp, $ua_tab);
        
        switch($agent) {
            case 'sp':
                $agent = $ua_sp;
                break;
        
            case 'tab':
                $agent = $ua_tab;
                break;
            
            case 'all':
                $agent = $all_agent;
                break;
                
            default:
                //$agent = '';
                break;
        }
           
        if(is_array($agent)) {
            $agent = implode('|', $agent);
        }
        
        return preg_match('/'. $agent .'/', $_SERVER['HTTP_USER_AGENT']);
    }
    
    static function isDev()
    {
    	return env('ENVIRONMENT') == 'dev';
    }
}
