<?php

namespace App\Http\Controllers\DashBoard;

use App\MovieCombine;
use App\Category;
use App\Article;
use App\User;
use App\Music;
use App\MovieBranchRel;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MovieController extends Controller
{
	public function __construct(MovieCombine $movieCombine, Article $article, User $user, Category $category, Music $music, MovieBranchRel $mvRel)
    {
    	
        $this -> middleware('adminauth');
        //$this -> middleware('log', ['only' => ['getIndex']]);
        
        $this->movieCombine = $movieCombine;
        $this-> article = $article;
        $this->user = $user;
        $this->category = $category;
        $this->music = $music;
        $this->mvRel = $mvRel;
        
        
        $this->perPage = 10;
        
	}



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mvObjs = MovieCombine::orderBy('id', 'desc')->paginate($this->perPage);
        $users = $this->user->all();
        $cateModel = $this->category;
        
        //$status = $this->articlePost->where(['base_id'=>15])->first()->open_date;
        
        return view('dashboard.movie.index', ['mvObjs'=>$mvObjs, 'users'=>$users, 'cateModel'=>$cateModel]);
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
        $mvCombine = $this->movieCombine->find($id);
        
        $memo = '';
        if($mvCombine->rel_id != 99999) {
        	$memo = $this->mvRel->find($mvCombine->rel_id)->memo;
        }
        
        //$cateModel = $this->category->find('');
        $cates = $this->category->all();
        
        $atcls = $this->article;
        
        $modelName = User::find($mvCombine->model_id)->name;
        
    	return view('dashboard.movie.form', ['mvCombine'=>$mvCombine, 'cates'=>$cates, 'atcls'=>$atcls, 'modelName'=>$modelName, 'memo'=>$memo, 'id'=>$id, 'edit'=>1]);
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
