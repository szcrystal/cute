<?php

namespace App\Http\Controllers\DashBoard;

use App\MovieCombine;
use App\Category;
use App\Article;
use App\User;
use App\Music;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MovieController extends Controller
{
	public function __construct(MovieCombine $movieCombine, Article $article, User $user, Category $category, Music $music)
    {
    	
        $this -> middleware('adminauth');
        //$this -> middleware('log', ['only' => ['getIndex']]);
        
        $this->movieCombine = $movieCombine;
        $this-> article = $article;
        $this->user = $user;
        $this->category = $category;
        $this->music = $music;
        
        
        $this->perPage = 20;
        
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
        $cates = $this->category->all();
        
        $modelName = User::find($mvCombine->model_id)->name;
        
    	return view('dashboard.movie.form', ['mvCombine'=>$mvCombine, 'cates'=>$cates, 'modelName'=>$modelName, 'id'=>$id, 'edit'=>1]);
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
    
    public function getMusic()
    {
    	$musics = $this -> music-> all();
    	return view('dashboard.movie.addMusic', ['musics'=>$musics]);
    }
    
    //Music編集
    public function getEditMusic($musicId)
    {
    	$music = $this->music->find($musicId);
    	return view('dashboard.movie.editMusic', ['music'=>$music, 'musicId'=>$musicId]);
    }
    //Music編集(post)
    public function postEditMusic(Request $request, $musicId)
    {
    	$rules = [
            'name' => 'required|max:255',
        ];
        $this->validate($request, $rules);
        
        $data = $request->all();
        
        if($request->file('music_file') != '') {
            $filename = $request->file('music_file')->getClientOriginalName();
            //$pre = time() . '-';
            $filename = 'music/'/* . $pre*/ . $filename;
            $path = $request->file('music_file')->storeAs('public', $filename);
        
            $data['file'] = $filename;
        }
        
    	$music = $this->music->find($musicId);
        $music->fill($data);
        $music->save();
        
        
        return view('dashboard.movie.editMusic', ['music'=>$music, 'musicId'=>$musicId, 'status'=>'Musicが更新されました']);
    }
    
    //Music追加
    public function createMusic(Request $request)
    {
    	$rules = [
            'name' => 'required|max:255',
//            'admin_email' => 'required|email|max:255', /* |unique:admins 注意:unique */
//            'admin_password' => 'required|min:6',
        ];
        
        $this->validate($request, $rules);
        
        $data = $request->all(); //requestから配列として$dataにする
        
        if($request->file('music_file') != '') {
            $filename = $request->file('music_file')->getClientOriginalName();
            //$pre = time() . '-';
            $filename = 'music/'/* . $pre*/ . $filename;
            $path = $request->file('music_file')->storeAs('public', $filename);
        
            $data['file'] = $filename;
        }

        
        $this->music->fill($data);
        $this->music->save();
        
        return redirect('dashboard/movies/music')->with('status', 'Musicが追加されました');
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
