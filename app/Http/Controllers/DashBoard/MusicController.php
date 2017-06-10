<?php

namespace App\Http\Controllers\DashBoard;

use App\Music;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use FFMpeg;
use Storage;

class MusicController extends Controller
{
	public function __construct(Music $music)
    {
        $this -> middleware('adminauth');
        //$this -> middleware('log', ['only' => ['getIndex']]);
        
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
        $musics = Music::orderBy('id', 'desc')->paginate($this->perPage);
        
        //Storage::url($mvCombine -> movie_path)
        
        $ffprobe = FFMpeg\FFProbe::create();
//        $s = $ffprobe
//            ->format(asset('storage/music/sound2.m4a'))
//            ->get('duration');
//        
//        echo floor($s);
//        exit;
        
    	return view('dashboard.music.index', ['musics'=>$musics, 'ffprobe'=>$ffprobe]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.music.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$editId = $request->has('edit_id') ? $request->input('edit_id') : 0;
        
        $rules = [
            'name' => 'required|unique:musics,name,'.$editId.'|max:255',
            'music_file' => 'required|mimetypes:audio/mpeg,audio/x-m4a', //mimetypes:audio/mpeg,audio/quicktime  audio/mpeg,audio/x-m4a
        ];
        $messages = [
            'music_file.mimetypes' => '「ファイル」は .mp3 か .m4a をUPして下さい。',
            //'slug.unique' => '「スラッグ」が既に存在します。',
        ];
        
        $this->validate($request, $rules, $messages);
        
        $data = $request->all();
        
        if(isset($data['music_file'])) {
            $filename = $data['music_file']->getClientOriginalName();
            $filename = str_replace(' ', '_', $filename);
           
            //$pre = time() . '-';
            $filename = 'music/'/* . $pre*/ . $filename;
            $path = $data['music_file']->storeAs('public', $filename);
        
            $data['file'] = $filename;
        }
        
        if($editId) { //update（編集）の時
        	$status = 'Musicが更新されました！';
            $music = $this->music->find($editId);
        }
        else { //新規追加の時
            $status = 'Musicが追加されました！';
        	$music = $this->music;
        }
        
        $music->fill($data);
        $music->save();
        $musicId = $music->id;
        
        //return view('dashboard.music.form', ['music'=>$music, 'musicId'=>$musicId, 'status'=>$status]);
        return redirect('dashboard/musics/'.$musicId)->with('status', $status);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($musicId)
    {
        $music = $this->music->find($musicId);
    	return view('dashboard.music.form', ['music'=>$music, 'musicId'=>$musicId]);
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
        $title = $this->music->find($id)->name;
        
        
        $del = $this->music->destroy($id);
        
        $status = $del ? '「'.$title.'」が削除されました' : '「'.$title.'」が削除出来ませんでした';
        
        return redirect('dashboard/musics')->with('status', $status);
    }
}
