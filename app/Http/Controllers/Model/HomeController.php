<?php

namespace App\Http\Controllers\Model;

use App\User;
use App\Category;
use App\CategoryItem;
use App\MovieBranch;
use App\MovieCombine;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;

use FFMpeg;

class HomeController extends Controller
{
	public function __construct(User $user, Category $category, CategoryItem $cateItem, MovieBranch $mvBranch, MovieCombine $mvCombine)
    {
    	
        //$this -> middleware('auth');
        //$this -> middleware('log', ['only' => ['getIndex']]);
        
        $this-> user = $user;
        
        $this-> category = $category;
        $this-> cateItem = $cateItem;

        $this -> mvBranch = $mvBranch;
        $this-> mvCombine = $mvCombine;
        
        
        $this->perPage = 20;
        
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	//cate選択
        $cates = $this->category->all();
        
        //$file = '/vagrant/cute/sub1.ass';
        //$cont = file_get_contents($file);
//        $cont = file($file);
//        $last = end($cont);
//        $last = str_replace("\n", '', $last);
//        $last .= "aaaaa";

//			$cont = file_get_contents($file);
//        	$cont = rtrim($cont, "\n");
//            $cont .= "aaaaa";
//        
//            echo $cont;
//            exit;
        
//        echo $last;
//        exit;
        
//        array_splice($cont, -1, 1, $last);
//        
//        $cont = implode("", $cont);
//        file_put_contents('/vagrant/cute/storage/app/public/contribute/1.ass', $cont);
//        print_r($cont);
//        
//        exit;
		
//        $ffprobe = FFMpeg\FFProbe::create();
//		$mvInfo = $ffprobe->streams(base_path().'/storage/app/private/whiteout.mp4') // extracts streams informations
//                        ->videos() // filters video streams
//                        ->first(); // returns the first video stream
//            
//            $width = $mvInfo ->get('width');
//            $height = $mvInfo ->get('height');
//        
//            echo $width .'/'.$height;
//            exit;
        
        
        return view('model.index', ['cates'=>$cates,]);
    }
    
    public function postItem(Request $request) //カテゴリーが渡されて表示
    {
        
        
    }
    
    public function postMovie(Request $request)
    {
    	
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = $request->all();
        
        //$cateId = $data['cate_id'];
        $cateId = $request->input('cate_id');
        $cateName = $this->category->find($cateId)->name;
        $items = $this->cateItem->where('cate_id',$cateId)->get();
        
        
        return view('model.form', ['items'=>$items, 'cateId'=>$cateId, 'cateName'=>$cateName]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'movie.*' => 'required|file|filled',
            'subtext.*' => 'required|max:25',
        ];
        
        $messages = [
            'movie.*.required' => '「動画」は必須です。',
            'movie.*.filled' => '「動画」は必須です。',
        	'subtext.*.required' => '「字幕テキスト」は必須です。',
        	'subtext.*.max' => '「字幕テキスト」は25文字以内です。',
        ];
        
        //$this->validate($request, $rules, $messages);
        
    	$data = $request->all();
        
        //return back()->withInput()->withErrors(array('画像の取得ができませんでした'));
        
        
        $counts = $data['count'];
        $movie = $data['movie'];
        $subtext = $data['subtext'];
        
        $modelId = 2;
        $cateId = $data['cate_id'];
        
        $pre = time();
        $basePath = 'contribute/' .$modelId . '/' . $pre . '/';
        
        $orgAss = base_path() .'/storage/app/private/org.ass';
        $whitePath = base_path() . '/storage/app/private/whiteout.mp4';
        
        $orgName = array();
        $mvSubName = array();
        $durations = array();
        
        $cdCmd = 'cd ' . base_path() .'/storage/app/public/' .$basePath .' && ';
        
        

        
        
        //空入力確認　空File確認 -> jsで
    	//字幕文字数制限？ -> isで
        //縦サイズ禁止制限
        
        
    	
        
        
        //MovieUp
        foreach($counts as $count) {
            //if($request->file($movie[$count]) !== NULL) {
            if(isset($movie[$count])) {
            	
                //各動画の秒数が足りてるか確認　多ければ切り取る動作
                
                
                
                //$filename = $request->file($movie[$count])->getClientOriginalName();
                $orgName[$count] = 'upmv_' . $movie[$count]->getClientOriginalName();
                
                $filename = $basePath . $orgName[$count];

                //if (App::environment('local'))
                //$movie_path = $request->file($movie[$count])->storeAs('public', $filename);
                $movie_path = $movie[$count]->storeAs('public', $filename);
                
                //else
                //$path = Storage::disk('s3')->putFileAs($filename, $request->file('thumbnail'), 'public');
                //$path = $request->file('thumbnail')->storeAs('', $filename, 's3');

                $ffprobe = FFMpeg\FFProbe::create();
                $duration = $ffprobe->format(base_path().'/storage/app/'. $movie_path)->get('duration'); //asset('storage/'. $music->file)
                $durations[] = $duration;
                //exit;
            
            }
            else {
            	$movie_path = '';
            }
            
            //break;
        }
        
        //exit;
        
//        $sum = array_sum($durations);
//        echo $sum;
//        exit;
        
        
        
        //artisan
        
        foreach($counts as $count) {
            
            $ass = 'sub_' . $count .'.ass';
            
            //assにテキスト注入
            $cont = file_get_contents($orgAss);
            $cont = rtrim($cont, "\n");
            $cont .= $subtext[$count];
            
            Storage::put('public/'. $basePath . $ass, $cont);
            //file_put_contents('/vagrant/cute/storage/app/public/contribute/' . $ass, $cont);
            

            $mf = $orgName[$count]; //upされたfile名
            $mvSubName[$count] = 'mv_' .$count .'.mp4'; //subtextを入れたfile名
            
            
			
          	$ffprobe = FFMpeg\FFProbe::create();
        	$mvInfo = $ffprobe->streams(base_path().'/storage/app/public/'. $basePath. $mf) // extracts streams informations
                        ->videos() // filters video streams
                        ->first(); // returns the first video stream
            
            $width = $mvInfo ->get('width');
            $height = $mvInfo ->get('height');
            $res = ($width/16)*9; //16:9でのheight
            
            $pad = (720/$height)*$width;
            $pad = (1280-$pad)/2;
            
            if($res != $height) { //16:9でなければpadを入れてアスペクト変更
            	exec($cdCmd . 'ffmpeg -i '. $mf. ' -vf "scale=-1:720,pad=1280:0:'.$pad.':0:black" -strict -2 '. 'temp'. $mf .' -y', $out, $status);
                echo 'pad: '. $status;
                
                $mf = 'temp'. $mf;
            }
            else if ($width != 1280) { //横1280でなければサイズ変更
                exec($cdCmd . 'ffmpeg -i '. $mf. ' -s 1280x720 -strict -2 '. 'temp'. $mf .' -y', $out, $status);
            	echo 'size: '. $status;
                
                $mf = 'temp'. $mf;
            }
            

            
			//subtext入れ
            exec($cdCmd . 'ffmpeg -i '. $mf . ' -vf ass='.$ass.' -strict -2 ' . $mvSubName[$count] .' -y', $out, $status);
            
            
            //print_r($out);
            echo 'SubText: '. $status;
            
            //break;
        }
        
        
        //exit;
        
        //File結合 No Music
        $inputs = array();
        foreach($mvSubName as $val) {
        	$inputs[] = ' -i ' .$val;
        }
        
        $input = implode('', $inputs);
        $input .= ' -i ' . $whitePath;
        
        $c = count($mvSubName);
        $c++; //whiteout分 +1
        
        exec($cdCmd . 'ffmpeg'. $input . ' -filter_complex "concat=n='.$c.':v=1:a=1" -strict -2 '. $pre.'.mp4', $out, $status);
        
        echo 'last:'.$status;
        
        
        
        
        //Music加工
        
        //MusicPath ここのパスを後で取得する必要がある---------
        $music = base_path() . '/storage/app/public/music/sound.m4a';
        
        //$sum = $data['sum']; //DBから取得する秒数の合計
        $sum = array_sum($durations); //upされた動画の秒数合計 + whiteoutの3秒

        exec($cdCmd . 'ffmpeg -i '.$music .' -y -to '. ($sum+2) .' -af "afade=t=out:st='. $sum .':d=1" -strict -2 audio.m4a', $out, $status);
        echo 'music: '.$status;
        
        //file + music結合
        exec($cdCmd . 'ffmpeg -i '.$pre.'.mp4 -i audio.m4a -c copy -map 0:0 -map 0:1 -map 1:0 complete.mp4', $out, $status);
        echo 'comp: '.$status;
        
        
        //完成した動画をStorage移動 & Save
        $compPath = 'public/movie/'.$modelId.'/'.$pre.'.mp4';
        Storage::move('public/' .$basePath.'complete.mp4', $compPath);
        
        $this->mvCombine->create(
        	[
        		'model_id'=>$modelId,
                'cate_id' => $cateId,
                'movie_path' => $compPath,
                'atcl_status' => 0,
                'area' => '',
            ]
        );
        
        
        
        exit;
        return view('model.form', ['items'=>$items, 'cateName'=>$cateName]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//    	$modelId = 2;
//        $cateId = 1;
//        $pre = 1495159506;
//        $basePath = 'contribute/' .$modelId . '/' . $pre . '/';
//        
//        //完成した動画をStorage移動 & Save
//        $compPath = 'public/movie/'.$modelId.'/'.$pre.'.mp4';
//        Storage::move('public/' .$basePath.'complete.mp4', $compPath);
//        
//        $this->mvCombine->create(
//        	[
//        		'model_id'=>$modelId,
//                'cate_id' => $cateId,
//                'movie_path' => $compPath,
//                'atcl_status' => 0,
//                'area' => '',
//            ]
//        );
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
