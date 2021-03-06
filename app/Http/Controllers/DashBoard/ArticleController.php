<?php

namespace App\Http\Controllers\DashBoard;

use App\Admin;
use App\User;
use App\Article;
use App\Tag;
use App\TagRelation;
use App\Category;
use App\MovieCombine;
use App\TwAccount;
use App\State;
use App\MovieBranchRel;

use Abraham\TwitterOAuth\TwitterOAuth;

use Auth;
use Storage;
use Mail;
use Crypt;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
	public function __construct(Admin $admin, Article $article, Tag $tag, User $user, Category $category, TagRelation $tagRelation, MovieCombine $mvCombine, TwAccount $twAccount, State $state, MovieBranchRel $mvRel)
    {
    	
        $this -> middleware('adminauth');
        //$this -> middleware('log', ['only' => ['getIndex']]);
        
        $this -> admin = $admin;
        $this-> article = $article;
        $this->tag = $tag;
        
        $this->user = $user;
        $this->category = $category;
        $this->tagRelation = $tagRelation;
        
        $this->mvCombine = $mvCombine;
        $this->twAccount = $twAccount;
        $this->state = $state;
        $this->mvRel = $mvRel;
        
        $this->perPage = 20;
        

	}
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $atclObjs = Article::where('feature', 0)->orderBy('id', 'desc')->paginate($this->perPage);
        $users = $this->user->all();
        $cateModel = $this->category;
        $states = $this->state;
        
        //$status = $this->articlePost->where(['base_id'=>15])->first()->open_date;
        
        return view('dashboard.article.index', ['atclObjs'=>$atclObjs, 'users'=>$users, 'cateModel'=>$cateModel, 'states'=>$states]);
    }
    
    public function show($id)
    {
        $atcl = $this->article->find($id);
        $cates = $this->category->all();
        $states = $this->state->all();
        $models = $this->user->all();
        
        $mvId = $atcl->movie_id;
        
        if($mvId) {
        	$mv = $this->mvCombine->find($mvId);
        	$rel = $this->mvRel->find($mv->rel_id);
        }
        else {
        	$mv = null;
            $rel = null;
        }
        
        
        
        //$mvPath = Storage::url($mv->movie_path);
        //$modelId = $mv->model_id;
        $modelName = $this->user->find($atcl->model_id)->name;
        
        $tagNames = $this->tagRelation->where(['atcl_id'=>$id])->get()->map(function($item) {
            return $this->tag->find($item->tag_id)->name;
        })->all();
        
        $allTags = $this->tag->get()->map(function($item){
        	return $item->name;
        })->all();
        
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
        
    	return view('dashboard.article.form', ['atcl'=>$atcl, 'mv'=>$mv, 'modelName'=>$modelName, 'tagNames'=>$tagNames, 'allTags'=>$allTags, 'cates'=>$cates, 'states'=>$states, 'rel'=>$rel, 'mvId'=>$mvId, 'models'=>$models, 'id'=>$id, 'edit'=>1]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    	$mvId = $request->has('mvId') ? $request->input('mvId') : 0;
        $cates = $this->category->all();
        $states = $this->state->all();
        $models = $this->user->all();
        
        $mv = null;
        $rel = null;
        $modelName = '';
        $preCate = null;
        
        if($mvId) {
            $mv = $this->mvCombine->find($mvId);
            $rel = $this->mvRel->find($mv->rel_id);
    //        $mvPath = Storage::url($mv->movie_path);
    //        $modelId = $mv->model_id;
            $modelName = $this->user->find($mv->model_id)->name;
            
            $preCate = $this->category->find($mv->cate_id);
        }
        
        $allTags = $this->tag->get()->map(function($item){
        	return $item->name;
        })->all();
        
        
    	return view('dashboard.article.form', ['cates'=>$cates, 'states'=>$states, 'mv'=>$mv, 'preCate'=>$preCate, 'mvId'=>$mvId, 'modelName'=>$modelName, 'allTags'=>$allTags, 'rel'=>$rel, 'models'=>$models]);
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
        $feature = $request->has('feature') ? 1 : 0;
        
        $rules = [
        	'title' => 'required|max:255',
            'cate_id' => 'required',
        	'state_id' => 'required',
            'post_movie' => 'filenaming',
            'post_thumb' => 'filenaming',
        ];
        
        $messages = [
        	'cate_id.required' => '「カテゴリー」を選択して下さい。',
            'state_id.required' => '「都道府県名」を選択して下さい。',
            'post_thumb.filenaming' => '「サムネイル-ファイル名」は半角英数字、及びハイフンとアンダースコアのみにして下さい。',
        	'post_movie.filenaming' => '「動画-ファイル名」は半角英数字、及びハイフンとアンダースコアのみにして下さい。',
            //'slug.unique' => '「スラッグ」が既に存在します。',
        ];
        
        if(! $feature) {
        	$rules['model_id'] = 'required';
            $messages['model_id.required'] = '「モデル」を選択して下さい。';
        }
        
        $this->validate($request, $rules, $messages);
        
        $data = $request->all();

        
//        if(isset($data['ytUp'])) {
//        	//$this->postYtUp($data);
//            $data['atclId'] = $editId;
//            return redirect('dashboard/articles/ytup')->with('data', $data);
////            return redirect('dashboard/articles/ytup')->action(
////                'DashBoard\ArticleController@postYtUp', ['data' => $data]
////            );
//        }
        
        
        // Feature
        if($feature) {
            $data['feature'] = 1;
            $data['model_id'] = 1;
            //$data['cate_id'] = 0;
            $data['movie_id'] = 0;
        }
        else {
        	$data['feature'] = 0;
        }
        
        //PickUp
        if(! isset($data['pick_up'])) {
        	$data['pick_up'] = 0;
        }
                
        //status
        if(isset($data['open_status'])) { //非公開On
        	$data['open_status'] = 0;
        }
        else {
        	$data['open_status'] = 1;
        }
        
        if($editId) { //update（編集）の時
        	$status = '記事が更新されました！';
            $atcl = $this->article->find($editId);
        }
        else { //新規追加の時
            $status = '記事が追加されました！';
            //$data['model_id'] = 1;
            $data['view_count'] = 0;
            $data['yt_up'] = 0;
            $data['tw_up'] = 0;
            $data['fb_up'] = 0;
            
        	$atcl = $this->article;
        }
        
        $atcl->fill($data);
        $atcl->save();
        $atclId = $atcl->id;
        
        
        if($feature) { //Featureの時にmovie_pathをセット
            if(isset($data['post_movie'])) {
                
                //$filename = $request->file('post_thumb')->getClientOriginalName();
                $filename = $data['post_movie']->getClientOriginalName();
                $filename = str_replace(' ', '_', $filename);
                
                //$aId = $editId ? $editId : $rand;
                //$pre = time() . '-';
                $filename = 'feature/' . $atclId . '/movie/'/* . $pre*/ . $filename;
                //if (App::environment('local'))
                $path = $data['post_movie']->storeAs('public', $filename);
                //else
                //$path = Storage::disk('s3')->putFileAs($filename, $request->file('thumbnail'), 'public');
                //$path = $request->file('thumbnail')->storeAs('', $filename, 's3');
                
                $atcl->movie_path = $path;
                $atcl->save();
            }
        
        }
        else {
        	//mv combineにcateとatcl statusをセット
            if($data['movie_id']) {
                $mv = $this->mvCombine->find($data['movie_id']);
                $mv->cate_id = $atcl->cate_id;
                $mv->atcl_status = 1;
                $mv->save();
            }
        }
        
        //Thumbnail upload
        if(isset($data['post_thumb'])) {
            
            $filename = $data['post_thumb']->getClientOriginalName();
            $filename = str_replace(' ', '_', $filename);
            
            //$pre = time() . '-';
            if($feature) {
            	$filename = 'feature/' . $atclId . '/thumbnail/'/* . $pre*/ . $filename;
            }
            else {
            	$filename = 'article/' .$atclId . '/thumbnail/' . $filename;
            }
            //if (App::environment('local'))
            $path =  $data['post_thumb']->storeAs('public', $filename);
            //else
            //$path = Storage::disk('s3')->putFileAs($filename, $request->file('thumbnail'), 'public');
            //$path = $request->file('thumbnail')->storeAs('', $filename, 's3');
        
            
            $atcl->thumb_path = $path;
            $atcl->save();
        }
        
        
        
        //タグのsave動作
        if(isset($data['tags'])) {
            $tagArr = $data['tags'];
        
            foreach($tagArr as $tag) {
                
                //Tagセット
                $setTag = Tag::firstOrCreate(['name'=>$tag]); //既存を取得 or なければ作成
                
                if(!$setTag->slug) { //新規作成時slugは一旦NULLでcreateされるので、その後idをセットする
                    $setTag->slug = $setTag->id;
                    $setTag->save();
                }
                
                $tagId = $setTag->id;
                $tagName = $tag;


                //tagIdがRelationになければセット ->firstOrCreate() ->updateOrCreate()
                $tagRel = $this->tagRelation->firstOrCreate(
                	['tag_id'=>$tagId, 'atcl_id'=>$atclId]
                );
                /*
                $tagRel = $this->tagRelation->where(['tag_id'=>$tagId, 'atcl_id'=>$atclId])->get();
                if($tagRel->isEmpty()) {
                    $this->tagRelation->create([
                        'tag_id' => $tagId,
                        'atcl_id' => $atclId,
                    ]);
                }
                */

                //tagIdを配列に入れる　削除確認用
                $tagIds[] = $tagId;
            }
        
            //編集時のみ削除されたタグを消す
            if(isset($editId)) {
                //元々relationにあったtagがなくなった場合：今回取得したtagIdの中にrelationのtagIdがない場合をin_arrayにて確認
                $tagRels = $this->tagRelation->where('atcl_id', $atclId)->get();
                
                foreach($tagRels as $tagRel) {
                    if(! in_array($tagRel->tag_id, $tagIds)) {
                        $tagRel->delete();
                    }
                }
            }
        }
        
        
        if($feature) {
        	return redirect('dashboard/features/'. $atclId)->with('status', $status);
        }
        else {
        	return redirect('dashboard/articles/'. $atclId)->with('status', $status);
        }
        
        
//        $rand = mt_rand();
//        if($request->file('post_thumb') != '') {
//            $filename = $request->file('post_thumb')->getClientOriginalName();
//            
//            $aId = $editId ? $editId : $rand;
//            $pre = time() . '-';
//            $filename = 'article/' .$aId . '/thumbnail/' . $pre . $filename;
//            //if (App::environment('local'))
//            $path = $request->file('post_thumb')->storeAs('public', $filename);
//            //else
//            //$path = Storage::disk('s3')->putFileAs($filename, $request->file('thumbnail'), 'public');
//            //$path = $request->file('thumbnail')->storeAs('', $filename, 's3');
//        
//            $data['post_thumb'] = $filename;
//        }

        
        //Storage 仮フォルダをidにネームし直す
//        if(Storage::exists('public/article/'. $rand)) {
//            Storage::move('public/article/'. $rand, 'public/article/'. $atclId);
//            
//            $data['post_thumb'] = str_replace($rand, $atclId, $data['post_thumb']);
//            
//            $atcl->post_thumb = str_replace($rand, $atclId, $atcl->post_thumb);
//            $atcl->save();
//            
//        }
    }
    
    //SNS Upページ Get
    public function getSnsUp($atclId)
    {
    	$atcl = $this->article->find($atclId);
        
        $mvId = $atcl->movie_id;
        
        if($mvId) {
	        $mv = $this->mvCombine->find($mvId);
    	}
        else { //featureの時はmvId:0
            $mv = $this->article->find($atclId);
        }
        
        $users = $this->user->get();
        
        
        //$mvPath = Storage::url($mv->movie_path);
        //$modelId = $mv->model_id;
        $modelName = $this->user->find($atcl->model_id)->name;
        
        $tagNames = $this->tagRelation->where(['atcl_id'=>$atclId])->get()->map(function($item) {
            return $this->tag->find($item->tag_id)->name;
        })->all();
        
//        $allTags = $this->tag->get()->map(function($item){
//        	return $item->name;
//        })->all();
        
        
    	return view('dashboard.article.snsForm', ['atcl'=>$atcl, 'mv'=>$mv, 'modelName'=>$modelName, 'tagNames'=>$tagNames, 'users'=>$users, 'mvId'=>$mvId, 'atclId'=>$atclId, 'edit'=>1]);
    }
    
    //SNS Upページ Post
    public function postSnsUp(Request $request, $atclId)
    {
    	$data = $request->all();
        
        if($data['movie_id']) {
        	$mv = $this->mvCombine->find($data['movie_id']);
            $data['mvPath'] = $mv->movie_path;
            $data['modelId'] = $mv->model_id;
        }
        else { //featureの時はmovie_id = 0
            $atcl = $this->article->find($atclId);
            $data['mvPath'] = $atcl->movie_path;
            $data['modelId'] = $atcl->model_id;
            $data['feature'] = 1;
        }
        
        //$data['mvPath']はhiddenにてある
        //$data['modelId'] = $mv->model_id;
        
        
    	if(isset($data['ytUp'])) {
            return redirect('dashboard/articles/ytup')->with('data', $data);
        }
        else if(isset($data['twFbUp'])) {
        	return redirect('dashboard/articles/twfbup')->with('data', $data);
            //$this->getTwFbUp($data);
        }
    }


    public function getYtUp(Request $request)
    {
    	//API Key: AIzaSyBYJdFgn76FsGpxNSSY2G4qPYESVygzzMo
        
        //$path = '/vagrant/cute/vendor/google';
//        $path = '/vagrant/cute/google-api/src';
//		set_include_path(get_include_path() . PATH_SEPARATOR . $path);
//        //require_once 'apiclient/src/Google/autoload.php';
//        require_once 'Google/Client.php';
//        require_once 'Google/Service/Resource.php';

		//$editId = $request->input('edit_id');
        
        session_start(); //必要
        
        //authorized requireからリダイレクトされた時にlaravelのsessionが消えるのはなぜか？（laravelのsessionと$_SESSIONは別）
        if( $request->session()->has('data') ) { //snsupページからwithでsessionがある時
       	 	$data = session('data');
            //print_r($data);
        }
        else { //Authorize requireされてリダイレクトされた時
        	$data = $_SESSION['datayt']; //googleが最後に$_SESSIONを消している？
//            echo "NO";
//            print_r($data);
        }

        //exit;
//authorizedからのリダイレクトURL
//https://accounts.google.com/o/oauth2/auth?response_type=code&access_type=online&client_id=938943463544-1lgj32og5nice7pddbmo25mj3io7fs9v.apps.googleusercontent.com&redirect_uri=http%3A%2F%2Fcutecampus.jp%2Fdashboard%2Farticles%2Fytup&state=964284452&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fyoutube&approval_prompt=auto
        
        $atclId = $data['atcl_id'];
        
        $tagArr = array('cute.campus');
        
        if(isset($data['tags'])) {
        	$tagArr = array_merge($tagArr, $data['tags']);
        }
        //array_unshift($tagArr, 'cute.campus');

		//session_start(); //必要

		// --- Google側のOAuth設定でリダイレクトURLと下記のリダイレクトを一致させる必要がある ---
        //認証情報作成->OAuthクライアントID->Webアプリケーション
        //ORG
//        $key = 'AIzaSyBYJdFgn76FsGpxNSSY2G4qPYESVygzzMo'; //不要
//        $client_id = '362243100375-n8beqqfeu29qfcac18rjdvnv8thblogk.apps.googleusercontent.com';
//        $client_secret = 'bQZyhPR9f8O0UwjWauoFKSri';

		if(env('ENVIRONMENT') == 'dev') { //ログインを促されるので環境によって分ける
            //szc.dip.jp
            $client_id = '938943463544-ks3dacrb1a150v73i7j3m9t2f3h5dod4.apps.googleusercontent.com';
            $client_secret = 'VoCuh8cDVTxa_RV8aw6W78ww';
        }
        else {
            //Cute
            $client_id = '938943463544-1lgj32og5nice7pddbmo25mj3io7fs9v.apps.googleusercontent.com';
            $client_secret = 'oDvb4iImNWnP1PzByc6MBFDi';
        }

        $client = new \Google_Client();
        
        //$client->setDeveloperKey($key);
        $client->setClientId($client_id);
		$client->setClientSecret($client_secret);
        
        $client->setScopes('https://www.googleapis.com/auth/youtube');
        //$redirect = filter_var('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'], FILTER_SANITIZE_URL);
        $redirect = filter_var('http://' . $_SERVER['HTTP_HOST'] . '/dashboard/articles/ytup', FILTER_SANITIZE_URL);
        
        $client->setRedirectUri($redirect);
        
//        echo $client->getAccessToken();
//        echo $client->createAuthUrl();
//		exit;

        $youtube = new \Google_Service_YouTube($client);
        
//        $videoResponse = $youtube->videos->listVideos('snippet', array(
//            'id' => 'video_id' 
//        ));
//
//        print_r($videoResponse);
//        exit;
        
        
        if (isset($_GET['code'])) {
            if (strval($_SESSION['state']) !== strval($_GET['state'])) {
            	die('The session state did not match.');
            }

            $client->authenticate($_GET['code']);
            $_SESSION['token'] = $client->getAccessToken();
            header('Location: ' . $redirect);
            exit();
        }

        if (isset($_SESSION['token'])) {
            $client->setAccessToken($_SESSION['token']);
        }

        // Check to ensure that the access token was successfully acquired.
        if ($client->getAccessToken()) {
          try{
            // REPLACE this value with the path to the file you are uploading.
            //$videoPath = base_path() . "/storage/app/public/movie/2/main.mp4";
            
            $videoPath = base_path() . "/storage/app/". $data['mvPath'];
            //$videoPath = $_SERVER['DOCUMENT_ROOT'] . "/storage". str_replace('public', '', $data['mvPath']);
            
//            try {
//                $videoPath = base_path() . "/storage/app/". $data['mvPath'];
//            }
//            catch (\Exception $e) {
//                return back()->withInput()->withErrors(array('session-data:'.$data['mvPath']));
//            }

            // Create a snippet with title, description, tags and category ID
            // Create an asset resource and set its snippet metadata and type.
            // This example sets the video's title, description, keyword tags, and
            // video category.
            $snippet = new \Google_Service_YouTube_VideoSnippet();
            //$snippet->setTitle("Test title");
            //$snippet->setDescription("Test description");
            //$snippet->setTags(array("海", "湖", "山"));
            $snippet->setTitle($data['title']);
            $snippet->setDescription($data['description']);
            $snippet->setTags($tagArr);


            // Numeric video category. See
            // https://developers.google.com/youtube/v3/docs/videoCategories/list 
            $snippet->setCategoryId("22");
            
            

            // Set the video's status to "public". Valid statuses are "public",
            // "private" and "unlisted".
            $status = new \Google_Service_YouTube_VideoStatus();
            $status->privacyStatus = "public";
            
            

            // Associate the snippet and status objects with a new video resource.
            $video = new \Google_Service_YouTube_Video();
            $video->setSnippet($snippet);
            $video->setStatus($status);
            

            // Specify the size of each chunk of data, in bytes. Set a higher value for
            // reliable connection as fewer chunks lead to faster uploads. Set a lower
            // value for better recovery on less reliable connections.
            $chunkSizeBytes = 5 * 1024 * 1024;

            // Setting the defer flag to true tells the client to return a request which can be called
            // with ->execute(); instead of making the API call immediately.
            $client->setDefer(true);
            
            

            // Create a request for the API's videos.insert method to create and upload the video.
            $insertRequest = $youtube->videos->insert("status,snippet", $video);
            
            

            // Create a MediaFileUpload object for resumable uploads.
            $media = new \Google_Http_MediaFileUpload(
                $client,
                $insertRequest,
                'video/*',
                null,
                true,
                $chunkSizeBytes
            );
            $media->setFileSize(filesize($videoPath));
            
            //exit;
			
			//--------------------------------------------
            // Read the media file and upload it chunk by chunk.
            $status = false;
            $handle = fopen($videoPath, "rb");
            while (!$status && !feof($handle)) {
              $chunk = fread($handle, $chunkSizeBytes);
              $status = $media->nextChunk($chunk);
            }

            fclose($handle);
            //-------------------------------------------
            


            // If you want to make other calls after the file upload, set setDefer back to false
            $client->setDefer(false);


            $htmlBody = "<h5>YouTubeにUpされました！</h5><ul>";
            $htmlBody .= sprintf('<li>%s (%s)</li>',
                $status['snippet']['title'],
                $status['id']);

            $htmlBody .= '</ul>';
            
            
            //atcl save
        	$atclModel = $this->article->find($atclId);
            $atclModel->yt_up = 1;
            $atclModel->yt_id = $status['id'];
            $atclModel->save();
            
            if(isset($_SESSION['datayt'])) {
            	$_SESSION['datayt'] = '';
            }

          }
          catch (Google_Service_Exception $e) {
            $htmlBody = sprintf('<p>A service error occurred: <code>%s</code></p>',
                htmlspecialchars($e->getMessage()));
          }
          catch (Google_Exception $e) {
            $htmlBody = sprintf('<p>An client error occurred: <code>%s</code></p>',
                htmlspecialchars($e->getMessage()));
          }

          $_SESSION['token'] = $client->getAccessToken();
        
        	
            
        }
        else { //Up前のAuhorized確認
            // If the user hasn't authorized the app, initiate the OAuth flow
            $state = mt_rand();
            $client->setState($state);
            $_SESSION['state'] = $state;
            
            //$_SESSION['datayt'] = array();
            $_SESSION['datayt'] = $data;
            //$request->session()->put('data', $data); //なぜか効かない??
            
            //print_r($_SESSION);
            //exit;

            $authUrl = $client->createAuthUrl();
            $htmlBody = "<p class=\"text-warning\">Authorization Required</p>";
            $htmlBody .= "<p class=\"text-warning\">下記のリンクをクリックしてログインを進めて下さい。<p><a href=\"" . $authUrl . "\">authorize access >></a> ";
        }
    

		/*
        $videoResponse = $youtube->videos->listVideos('snippet', array(
            'id' => 'video_id' 
        ));

        var_dump($videoResponse);
        exit;
        */
        
        //...../ytup?state=1069782776&code=4/Rg7JxgphKaKYlGo89WHuWOT2HumKAQGYdC1DGP2Q2Yg#
    	//return view('dashboard.sns.movieup', ['htmlBody'=>$htmlBody]);

        
        $statusHtml = $htmlBody;
        return redirect('dashboard/articles/snsup/'. $atclId)->with('ytStatus', $statusHtml);
    }

    
    public function getTwFbUp(Request $request)
    {
//        $name = 'opal@frank.fam.cx';
//        $pass = 'ccorenge33';

		$data = session('data');
        
        $atclId = $data['atcl_id'];
        $modelId = $data['modelId'];
        $feature = isset($data['feature']) ? 1 : 0;


		$resultArr = array();
		
        $postMsg = $data['title']."\n".$data['tw_comment']; //$fileName = '3s.mp4';
        $fileName = last(explode('/', $data['mvPath']));
        //$fileName = '3s.mp4';
        //$path = base_path() . "/storage/app/". $data['mvPath'];
        
        $url = 'https://upload.twitter.com/1.1/statuses/update.json';
        $uri = 'https://upload.twitter.com/1.1/media/upload.json';

        $segment_index = 0;
        $chunk = 5 * 1024 * 1024;
        
        $path = '';
        if($feature) {
        	$path = base_path() . "/storage/app/public/feature/". $atclId .'/movie/';
        }
        else {
        	$path = base_path() . "/storage/app/public/movie/" . $modelId .'/';
        }
        
        $videoPath = $path . 'tw_'.$fileName;
        
        
        //Video edit ======
        $cdCmd = 'cd ' . $path .' && ';
        
        //if(! file_exists($videoPath)) {
            //exec($cdCmd . 'ffmpeg -i '. $fileName . ' -to 20 -s 480x270 -strict -2 '. 'tw_'.$fileName .' -y', $out, $status);
            //音声：stereoにしないとTwitterでエラーになる(-ac 2)
            exec($cdCmd . 'ffmpeg -i '. $fileName . ' -ac 2 -s 480x270 -strict -2 '. 'tw_'.$fileName .' -y', $out, $status);
            if($status) {
                $out[] = 'make twitter movie error(1015): '. $status;
                return back()->withInput()->withErrors(array($out));
            }
        //}
        // END ============
        
        //動画ファイルサイズ
        $fileSize = filesize($videoPath);
        //動画のデータファイルをバイナリに変換する。
        $file_data = file_get_contents($videoPath);
        $file_data = base64_encode($file_data);
        $file_size = mb_strlen($file_data);
        
        //modelIdの配列
        $modelIdArr = array(1); //編集部
        if($modelId > 1) { //atclにセットされているmodelId
        	$modelIdArr[] = $modelId;
        }
        
        if(isset($data['addModel_id'])) { //選択した追加モデルid
        	$modelIdArr[] = $data['addModel_id'];
        }

		$accounts = $this->twAccount->whereIn('model_id', $modelIdArr)->get();
        //foreach($accounts as $account) {
        //	echo decrypt($account->pass);
        //}
        //exit;
        
        foreach($accounts as $account) {
        
			/*
            $name = 'cute_campus'; //y.yamasaki@crepus.jp
            //$pass = '14092ugaAC';
            $v = Crypt::encrypt('14092ugaAC');
            $pass = Crypt::decrypt($v);
            
            $consumer_key = 'a50OiN3f4hoxXFSS2zK2j6mTK';
            $consumer_secret = 'DKKhv9U1755hu0zzxbklyPA3GpuAsTTqedoNCFTUKyACshPuOE';
            $access_token = '2515940671-scGnBAVUnURLykOpp0C9uxsmOz6zg1iTkILVqZa';
            $access_token_secret = '7LMe9izK6Cu514gNnn3Kfl2f9QCtoFr5PLBg8oj0A9XTy';
            */
            
            $name = $account->name;
            $pass = decrypt($account->pass);
            
            $consumer_key = $account->consumer_key;
            $consumer_secret = $account->consumer_secret;
            $access_token = $account->access_token;
            $access_token_secret = $account->access_token_secret;
            
            
            if($consumer_key == '' || $consumer_secret == '' || $access_token == '' || $access_token_secret == '') {
            	$resultArr[] = 'Twitter Error ! '. $this->user->find($account->model_id)->name . 'の入力情報が不足しています。';
            	continue;
            }
            

            //use Abraham\TwitterOAuth\TwitterOAuth; を先頭につけると以下でクラス取得可能
            //$toa = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);
            //self::$CONSUMER_KEYという書き方もあり ->static変数
            
            //composer show abraham/twitteroauth にてautoload psr-4の名前空間が確認できる　そこから以下でクラス取得可能
            //先頭の逆スラッシュはヘッドで記載のnamespace(名前空間)を解除する
            $connection = new \Abraham\TwitterOAuth\TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);
            $connection->setTimeouts(10,500);
    //        var_dump($connection);
    //        exit;

    //        $file = file_get_contents($videoPath);
    //        var_dump($file['media_type']);
    //        exit;


            $info = $connection->OAuthRequest($uri, 'POST', array('command' => 'INIT', 'media_type'=>'video/mp4', 'total_bytes'=>$fileSize, 'media_category' => 'tweet_video'));
            $obj = json_decode($info);

            
            //メディアのIDを取得
            $sba = $obj->media_id_string;

            //何回アップロードが必要か
            $maxRound = ceil($file_size / $chunk);

            //APPENDをファイルサイズ分割分だけアップロード
            for($i=0; $i<$maxRound; $i++){
                $file_size_x[$i] = substr($file_data, $chunk*$i, $chunk);
                $connection->OAuthRequest($uri, 'POST', array('command'=>'APPEND', 'media_id' =>$sba, 'segment_index'=>$i, 'media'=>$file_size_x[$i],));
            }
            $info = $connection->OAuthRequest($uri, 'POST', array('command' => 'FINALIZE','media_id' => $sba));
            $obj = json_decode($info);

            
            //アップロードしたデータ情報をファイルサイズ分割分だけ最新化
            for($i=0; $i<$maxRound; $i++){
                sleep($obj->processing_info->check_after_secs);
                $res = $connection->get('media/upload', array('command'=>'STATUS', 'media_id'=>$sba));
            }
            
            
            //投稿 Simple 分割なし
            //$media_id = $connection->upload("media/upload", array("media" => $videoPath, "total_bytes"=>$fileSize, "media_type"=>'video/mp4'), true); //, "media_category"=>'tweet_video'
    //        var_dump($media_id);
    //        exit;
            
            $parameters = array(
                'status' => $postMsg,
                'media_ids' => $sba/*$media_id->media_id_string*/,
            );
            
            $result = $connection->post("statuses/update", $parameters);
            
            //$result = $toa->OAuthRequest(self::$TWITTER_API, "POST", array("status"=>$postMsg));
     
            // レスポンス表示
            //var_dump($result);
            //exit;
            //$status[] = $result;
            
            
            if(isset($result->errors[0]->message)) {
                $resultArr[] = 'Twitter Error ! '.$name .' : ' . $result->errors[0]->message;
            }
            else {
                $atclModel = $this->article->find($atclId);
                $atclModel->tw_up = 1;
                $atclModel->save();
                
                $resultArr[] = 'TwitterにUPされました ! '.$name;
            }
            
        
        } //account foreach

		//var_dump($status);
        //exit;
        

        // FB ========================================================
        //https://developers.facebook.com/docs/php/howto/example_upload_video
        
        
        
        if(env('ENVIRONMENT') == 'dev') {
        	$fb = new \Facebook\Facebook([
              'app_id' => '466002250405349',
              'app_secret' => '05836f0f3849cb3a8a4ede1aaf4d44d6',
              'default_graph_version' => 'v2.9',
            ]);
            
            $token = 'EAAGn05qZAleUBAJGsWXEHEQ91UoBcYY3pm9WRzY8QbcKMVwWZAVvIJJRFywlhOvLnDFUa5SZBPjG82mdV8AFR0eAHohnTVzjQ2GbAkaSKStt53JsZCXzsGVICV82kPaGU8AjMakBowFAIMHe5f3ae94UDWO888PZCJ0XXRo8CZBAZDZD';
        }
        else {
            $fb = new \Facebook\Facebook([
              'app_id' => '211116349398969',
              'app_secret' => '7c8d105958970dc64642ef463f1ec874',
              'default_graph_version' => 'v2.9',
            ]);
            
            $token = 'EAADAAlsDH7kBAH7kMYHZCYodY334V5VZAaDBRhiyLVxutyzUC2kvpyt4sqZBuGOSzpx1AJXOzZCAQRUJXTeAKxquZAOJVWEAkhk4dM8xaF5Xlz5gotu6ikj5csIhPceRzZAeDHeRZAU99Bj6rWwEe0AZApZAS43aJRHZAcj8WPvO8vWwZDZD';
        }
        
        
        
        //var_dump($fb);
        //exit;
        
        //$fileName = 'main.mp4';
        //$videoPath = base_path() . "/storage/app/public/movie/". $modelId. '/tw_'.$fileName;
        
        $data = [
          'title' => $data['title'],
          'description' => $data['tw_comment'],
          'source' => $fb->videoToUpload($videoPath),
        ];
        
        
        $errorFb = '';
        
        try {
          $response = $fb->post('/me/videos', $data, $token); //'user-access-token'
        }
        catch(\Facebook\Exceptions\FacebookResponseException $e) {
          // When Graph returns an error
          //echo 'Graph returned an error: ' . $e->getMessage();
          //exit;
          $errorFb = 'Graph returned an error: ' . $e->getMessage();
        }
        catch(\Facebook\Exceptions\FacebookSDKException $e) {
        	// When validation fails or other local issues
          //echo 'Facebook SDK returned an error: ' . $e->getMessage();
          //exit;
          $errorFb = 'Facebook SDK returned an error: ' . $e->getMessage();
        }

        $graphNode = $response->getGraphNode();
        var_dump($graphNode);
        
        //echo 'Video ID: ' . $graphNode['id'];
        if($errorFb != '') {
        	$resultArr[] = $errorFb;
        }
        else {
            $atclModel = $this->article->find($atclId);
            $atclModel->fb_up = 1;
            $atclModel->save();
            
            $resultArr[] = 'FaceBookにUPされました: ID ' . $graphNode['id'];
        }

        
        //return view('dashboard.sns.fbup', ['htmlBody'=>$htmlBody]);

        
        return redirect('dashboard/articles/snsup/'. $atclId)->with('twStatus', $resultArr);

    }
    
    
    
    
    
    
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



    public function update(Request $request, $id)
    {
        //
    }


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
