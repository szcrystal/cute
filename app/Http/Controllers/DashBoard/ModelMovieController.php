<?php

namespace App\Http\Controllers\DashBoard;

use App\User;
use App\Category;
use App\CategoryItem;
use App\MovieBranch;
use App\MovieBranchRel;
use App\MovieCombine;
use App\Music;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;
use FFMpeg;

class ModelMovieController extends Controller
{
	public function __construct(User $user, Category $category, CategoryItem $cateItem, MovieBranch $mvBranch, MovieBranchRel $mvBranchRel, MovieCombine $mvCombine, Music $music)
    {
    	
        //$this -> middleware('auth');
        //$this -> middleware('log', ['only' => ['getIndex']]);
        
        $this-> user = $user;
        
        $this-> category = $category;
        $this-> cateItem = $cateItem;

        $this -> mvBranch = $mvBranch;
        $this-> mvBranchRel = $mvBranchRel;
        $this-> mvCombine = $mvCombine;
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
        //$relObjs = $this-> mvBranchRel->where('combine_status',0)->paginate($this->perPage);
        $relObjs = $this-> mvBranchRel->where('complete', 1)->orderBy('id', 'desc')->paginate($this->perPage);
        
        $cateModel = $this->category;
        $users = $this->user;
        
        $branches = $this -> mvBranch;
        
        return view('dashboard.modelMovie.index', ['relObjs'=>$relObjs, 'cateModel'=>$cateModel, 'users'=>$users, 'branches'=>$branches]);
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($relId)
    {
        $branches = $this->mvBranch->where('rel_id', $relId)->get();
        
        $rel = $this-> mvBranchRel->find($relId);
        $modelName = $this->user->find($rel->model_id)->name;
        $cateName = $this->category->find($rel->cate_id)->name;
        
        $combine = $this->mvCombine->where('rel_id', $relId)->first();
        
        $musics = $this->music->all();
        
        
    	return view('dashboard.modelMovie.form', ['branches'=>$branches, 'modelName'=>$modelName, 'cateName'=>$cateName, 'rel'=>$rel, 'relId'=>$relId, 'combine'=>$combine, 'musics'=>$musics]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	//$mId = $request->has('music_id') ? $request->input('music_id') : 0;
    	
        $sec = $request->input('moviesec');
        $sec = array_sum($sec);
        
        $rules = [
            //'movie.*' => 'required|file|filled',
            'music_id' => 'required|secondcheck:'.$sec,
            'filter_id' => 'required',
            'subtext.*' => 'max:20',
            //'moviesec' => 'sometimes|secondcheck:'.$mId .'|music_id',
        ];
        
        $messages = [
        	'music_id.required' => '「Music」は必須です。',
            'filter_id.required' => '「フィルター」は必須です。',
        	'subtext.*.max' => '「字幕テキスト」は20文字以内です。',
            'music_id.secondcheck' => '「音楽ファイル」の秒数が動画合計秒数に足りてません。',
        ];
        
        $this->validate($request, $rules, $messages);
        
    	$data = $request->all();
        //exit;
        
        //return back()->withInput()->withErrors(array('画像の取得ができませんでした'));
        
        
        //$counts = $data['count'];
        //$movie = $data['movie'];
        $subtext = $data['subtext'];
        
        

		//get Obj
        $rel = $this-> mvBranchRel->find($data['rel_id']);
        $branches = $this->mvBranch->where('rel_id', $data['rel_id'])->orderBy('number', 'asc')->get();
		
        $modelId = $rel->model_id;
        $cateId = $rel->cate_id;
        
        $pre = $rel->folder_name;
        $basePath = 'contribute/' .$modelId . '/' . $pre . '/';
        
        $privatePath = base_path() .'/storage/app/private/';
        $orgAss = $privatePath . 'org.ass';
        $whitePath = $privatePath . 'whiteout.mp4';
        
        $orgName = array();
        $mvSubName = array();
        $durations = array();
        
        $cdCmd = 'cd ' . base_path() .'/storage/app/public/' .$basePath .' && ';
        
        
        //artisan ==============================
        
        //サイズを統一し、subtextを入れる
        foreach($branches as $branch) {
        	
            $num = $branch->number;
            
            $ass = 'sub_' . $num .'.ass';
            
            //ここでsubtextをDBに入れ直す
            $branch->sub_text = $subtext[$num-1];
            $branch->save();
            
            //assにテキスト注入
            $cont = file_get_contents($orgAss);
            $cont = rtrim($cont, "\n");
            $cont .= $subtext[$num-1];
            
            
            Storage::put('public/'. $basePath . $ass, $cont);
            //file_put_contents('/vagrant/cute/storage/app/public/contribute/' . $ass, $cont);
            

            $mf = $branch->org_name; //upされたfile名
            $mvSubName[$num] = 'mv_' .$num .'.mp4'; //subtextを入れたfile名
            
            
			//iphoneからの4:3を16:9にする
          	$ffprobe = FFMpeg\FFProbe::create();
        	$mvInfo = $ffprobe->streams(base_path().'/storage/app/public/'. $basePath. $mf) // extracts streams informations
                        ->videos() // filters video streams
                        ->first(); // returns the first video stream
            
            $width = $mvInfo ->get('width');
            $height = $mvInfo ->get('height');
            $res = ($width/16)*9; //16:9でのheight
            
            $pad = (720/$height)*$width; //規定サイズ：高さ720にした場合の横幅 1280x720 or 960x540
            $pad = (1280-$pad)/2; //上記の横幅からpad分を算出
            
            if($res != $height) { //16:9でなければpadを入れてアスペクト変更
            	exec($cdCmd . 'ffmpeg -i '. $mf. ' -vf "scale=-1:720,pad=1280:0:'.$pad.':0:black" -strict -2 '. 'temp_'. $mf .' -y', $out, $status);
                if($status) {
                	$es = 'set pad error(1001): '. $status;
	                return back()->withInput()->withErrors(array($es));
    	            //return redirect('mypage/'.$getId.'create')->withInput()->withErrors(array('画像の取得ができませんでした'));
                }
                
                $mf = 'temp_'. $mf;
            }
            else if ($width != 1280) { //横1280でなければサイズ変更
                exec($cdCmd . 'ffmpeg -i '. $mf. ' -s 1280x720 -strict -2 '. 'temp_'. $mf .' -y', $out, $status);
                
                if($status) {
                	$es = 'set size error(1002): '. $status;
	                return back()->withInput()->withErrors(array($es));
                }
                
                $mf = 'temp_'. $mf;
            }
            
			//subtext入れ
            exec($cdCmd . 'ffmpeg -i '. $mf . ' -vf ass='.$ass.' -strict -2 ' . $mvSubName[$num] .' -y', $out, $status);
            //print_r($out);
            if($status) {
                $es = 'set subtext error(1003): '. $status;
                return back()->withInput()->withErrors(array($es));
            }
            
            //break;
        } //foreach
        
        
        //exit;
        
        //File結合 No Music
        $inputs = array(); //ffmpeg -i の文字列を作成
        foreach($mvSubName as $val) {
        	$inputs[] = ' -i ' .$val;
        }
        
        $input = implode('', $inputs);
        //$input .= ' -i ' . $whitePath;
        
        $c = count($mvSubName);
        //$c++; //whiteout分 +1 > ここでは入れない。filter後にwhiteoutを入れるので
        
        exec($cdCmd . 'ffmpeg'. $input . ' -filter_complex "concat=n='.$c.':v=1:a=1" -strict -2 '. $pre.'.mp4 -y', $out, $status);
        if($status) {
            $es = 'combine error no music(1004): '. $status;
            return back()->withInput()->withErrors($es);
        }

        
        
        //Filter掛け --------
        $filter = [
        	1=> '',
        	2=> ' -vf hue=s=0', //モノクロ
            3=> ' -vf hue=h=5:s=1.7:b=1', //古ぼけ ORG h=10s=1.5b=3
            4=> ' -vf hue=b=2', //明るく
            5=> ' -vf hue=b=-1', //暗く
            6=> ' -vf hue=s=1.5', //濃く
        ];
        
        //exec($cdCmd . 'ffmpeg -i '. $pre.'.mp4' . ' -vf '.$filter[$data['filter_id']].' -strict -2 '. 'com_'.$pre.'.mp4', $out, $status);
        exec($cdCmd . 'ffmpeg -i '. $pre.'.mp4' . $filter[$data['filter_id']].' -strict -2 '. 'com_'.$pre.'.mp4 -y', $out, $status);
        if($status) {
            $es = 'set filter error(1005): '. $status;
            return back()->withInput()->withErrors(array($es));
        }
        
        
        //Whiteout追加 ステレオ音声にもここでする---------
        //exec($cdCmd . 'ffmpeg -i '.'com_'.$pre.'.mp4 -i '. $whitePath . ' -filter_complex "concat=n=2:v=1:a=1" -strict -2 '. $pre.'.mp4 -y', $out, $status);
        exec($cdCmd . 'ffmpeg -i '.'com_'.$pre.'.mp4 -i '. $whitePath . ' -ac 2 -filter_complex "concat=n=2:v=1:a=1" -strict -2 '. $pre.'.mp4 -y', $out, $status);
        if($status) {
            $es = 'white combine error(1006): '. $status;
            return back()->withInput()->withErrors(array($es));
        }
        
        
        
        //Music加工
        //MusicPath ここのパスを後で取得する必要がある---------
        $music = $this->music->find($data['music_id'])->file;
        $music = base_path() . '/storage/app/public/'. $music;
        
        //$sum = $data['sum']; //DBから取得する秒数の合計
        //$sum = array_sum($durations); //upされた動画の秒数合計 + whiteoutの3秒
        $sum = $branches->sum('duration');

        exec($cdCmd . 'ffmpeg -i '.$music .' -to '. ($sum+2) .' -af "afade=t=out:st='. $sum .':d=1,volume=-12dB" -strict -2 audio.m4a -y', $out, $status);
        //-acodec aac OR -c:a aac aaacコーデックの場合は-strict -2 が必要
        if($status) {
            $out[] = 'make music error(1007): '. $status;
            return back()->withInput()->withErrors(array($out));
        }
        
        
        //file + music結合
        //exec($cdCmd . 'ffmpeg -i '.$pre.'.mp4 -i audio.m4a -c:a copy -map 0:0 -map 0:1 -map 1:0 complete.mp4 -y', $out, $status); //org strictなし
        exec($cdCmd . 'ffmpeg -i '.$pre.'.mp4 -i audio.m4a -filter_complex "[0:a][1:a]amerge=inputs=2[a]" -map 0:v -map "[a]" -c:v h264 -c:a aac -movflags faststart -strict -2 complete.mp4 -y', $out, $status);
        if($status) {
            $es = 'complete error(1008): '. $status;
            return back()->withInput()->withErrors(array($es));
        }
        
        
        //完成した動画をStorage移動 & DBSave
        $compPath = 'public/movie/'.$modelId.'/'.$pre.'.mp4';
        if(Storage::exists($compPath)) {
        	Storage::delete($compPath);
        }
        Storage::move('public/' .$basePath.'complete.mp4', $compPath); //moveだと既存ファイルを上書き出来ない
        //storeがいいのかも
        
        //結合DB
        $combine = $this->mvCombine->updateOrCreate(
        //$combine = $this->mvCombine->firstOrCreate(
        	['movie_path' => $compPath],
        	[
        		'model_id'=>$modelId,
                'cate_id' => $cateId,
                'rel_id' => $rel->id,
                'music_id' => $data['music_id'],
                'filter_id' => $data['filter_id'],
                'movie_path' => $compPath,
                //'atcl_status' => 0,
                'area' => '',
            ]
        );
        
        //Rel DB
        $rel->combine_status = 1;
        $rel->save();
        
        //不要動画を消すか ------
        exec($cdCmd . 'rm -rf mv_* sub_* temp_* com_* audio.m4a complete.mp4 '.$pre.'.mp4', $out, $status);
        if($status) {
            $es = 'delete error(1009): '. $status;
            return back()->withInput()->withErrors(array($es));
        }
        //--------------------
        
        $status = '動画が完成しました。';
        
        //exit;
        return redirect('dashboard/movies/'.$combine->id)->with('status', $status);
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
