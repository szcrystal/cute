<?php

namespace App\Http\Controllers\DashBoard;

use App\Admin;
use App\User;
use App\Article;
use App\Tag;
use App\TagRelation;
use App\Category;
use App\MovieCombine;

use Abraham\TwitterOAuth\TwitterOAuth;

use Auth;
use Storage;
use Mail;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
	public function __construct(Admin $admin, Article $article, Tag $tag, User $user, Category $category, TagRelation $tagRelation, MovieCombine $mvCombine)
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
        
        $this->perPage = 20;
        
        // URLの生成
		//$url = route('dashboard');
        
        /* ************************************** */
        //env()ヘルパー：環境変数（$_SERVER）の値を取得 .env内の値も$_SERVERに入る
	}
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $atclObjs = Article::orderBy('id', 'desc')->paginate($this->perPage);
        $users = $this->user->all();
        $cateModel = $this->category;
        
        //$status = $this->articlePost->where(['base_id'=>15])->first()->open_date;
        
        return view('dashboard.article.index', ['atclObjs'=>$atclObjs, 'users'=>$users, 'cateModel'=>$cateModel]);
    }
    
    public function show($id)
    {
        $atcl = $this->article->find($id);
        $cates = $this->category->all();
        
        $mvId = $atcl->movie_id;
        $mv = $this->mvCombine->find($mvId);
        
        
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
        
    	return view('dashboard.article.form', ['atcl'=>$atcl, 'mv'=>$mv, 'modelName'=>$modelName, 'tagNames'=>$tagNames, 'allTags'=>$allTags, 'cates'=>$cates, 'mvId'=>$mvId, 'id'=>$id, 'edit'=>1]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    	$mvId = $request->input('mvId');
        $cates = $this->category->all();
        
        $mv = $this->mvCombine->find($mvId);
//        $mvPath = Storage::url($mv->movie_path);
//        $modelId = $mv->model_id;
        $modelName = $this->user->find($mv->model_id)->name;
        
        $allTags = $this->tag->get()->map(function($item){
        	return $item->name;
        })->all();
        
        
    	return view('dashboard.article.form', ['cates'=>$cates, 'mv'=>$mv, 'mvId'=>$mvId, 'modelName'=>$modelName, 'allTags'=>$allTags/*, 'users'=>$users*/]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$editId = $request->input('edit_id');
        
        $rules = [
        	'title' => 'required|max:255',
            //'slug' => 'required|unique:articles,slug,'.$editId.'|max:255',
        ];
        $this->validate($request, $rules);
        
        $data = $request->all(); //requestから配列として$dataにする
        
        if(isset($data['ytUp'])) {
        	//$this->postYtUp($data);
            $data['atclId'] = $editId;
            return redirect('dashboard/articles/ytup')->with('data', $data);
//            return redirect('dashboard/articles/ytup')->action(
//                'DashBoard\ArticleController@postYtUp', ['data' => $data]
//            );
        }
        
        $rand = mt_rand();
        
        if($request->file('post_thumb') != '') {
            $filename = $request->file('post_thumb')->getClientOriginalName();
            
            $aId = $editId ? $editId : $rand;
            $pre = time() . '-';
            $filename = 'article/' .$aId . '/thumbnail/' . $pre . $filename;
            //if (App::environment('local'))
            $path = $request->file('post_thumb')->storeAs('public', $filename);
            //else
            //$path = Storage::disk('s3')->putFileAs($filename, $request->file('thumbnail'), 'public');
            //$path = $request->file('thumbnail')->storeAs('', $filename, 's3');
        
            $data['post_thumb'] = $filename;
        }
        
        
        // Total
        if(! isset($data['open_status'])) {
        	$data['open_status'] = 1;
        }
        else {
        	$data['open_status'] = 0;
        }
        
        if($editId !== NULL ) { //update（編集）の時
        	$status = '記事が更新されました！';
            $atcl = $this->article->find($request->input('edit_id'));
        }
        else { //新規追加の時
            $status = '記事が追加されました！';
            //$data['model_id'] = 1;
            $data['view_count'] = 0;
            $data['yt_up'] = 0;
            $data['sns_up'] = 0;
            
        	$atcl = $this->article;
        }

        
        $atcl->fill($data);
        $atcl->save();
        $atclId = $atcl->id;
        
        //Storage 仮フォルダをidにネームし直す
        if(Storage::exists('public/article/'. $rand)) {
            Storage::move('public/article/'. $rand, 'public/article/'. $atclId);
            
            $data['post_thumb'] = str_replace($rand, $atclId, $data['post_thumb']);
            
            $atcl->post_thumb = str_replace($rand, $atclId, $atcl->post_thumb);
            $atcl->save();
            
            //if(isset($itemId)) {
//                $this->article->find($atclId)->map(function($obj) use($atclId, $rand) {
//                    $obj->post_thumb = str_replace($rand, $atclId, $obj->post_thumb);
//                    //$obj->link_imgpath = str_replace($rand, $atclId, $obj->link_imgpath);
//                    $obj->save();
//                });
            //}
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
        
        
        return redirect('dashboard/articles/'. $atclId)->with('status', $status);
    }
    
    
    public function getSnsUp($atclId)
    {
    	$atcl = $this->article->find($atclId);
        
        $mvId = $atcl->movie_id;
        $mv = $this->mvCombine->find($mvId);
        
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
    
    public function postSnsUp(Request $request, $atclId)
    {
    	$data = $request->all();
        
        $mv = $this->mvCombine->find($data['movie_id']);
        $data['mvPath'] = $mv->movie_path;
        $data['modelId'] = $mv->model_id;
        
        
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
        
        $data = session('data');
        
        $atclId = $data['atcl_id'];
        
        $tagArr = array('cute.campus');
        
        if(isset($data['tags'])) {
        	$tagArr = array_merge($tagArr, $data['tags']);
        }
        //array_unshift($tagArr, 'cute.campus');

		session_start(); //必要

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
            $chunkSizeBytes = 1 * 1024 * 1024;

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


            $htmlBody = "<h3>Video Uploaded</h3><ul>";
            $htmlBody .= sprintf('<li>%s (%s)</li>',
                $status['snippet']['title'],
                $status['id']);

            $htmlBody .= '</ul>';

          }
          catch (Google_Service_Exception $e) {
            $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
                htmlspecialchars($e->getMessage()));
          }
          catch (Google_Exception $e) {
            $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
                htmlspecialchars($e->getMessage()));
          }

          $_SESSION['token'] = $client->getAccessToken();
        
        	//atcl save
        	$atclModel = $this->article->find($atclId);
            $atclModel->yt_up = 1;
            $atclModel->yt_id = $status['id'];
            $atclModel->save();
            
        }
        else { //Up前のAuhorized確認
            // If the user hasn't authorized the app, initiate the OAuth flow
            $state = mt_rand();
            $client->setState($state);
            $_SESSION['state'] = $state;

            $authUrl = $client->createAuthUrl();
            $htmlBody = "<h3>Authorization Required</h3>";
            $htmlBody .= "<p>You need to <a href=\"" . $authUrl . "\">authorize access</a> before proceeding.<p>";
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

        
        $status = $htmlBody;
        return redirect('dashboard/articles/snsup/'. $atclId)->with('ytStatus', $status);
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
    
    
    
    
    
    
    public function getTwFbUp(Request $request)
    {

		$data = session('data');
        
        $atclId = $data['atcl_id'];
        $modelId = $data['modelId'];
//        $name = 'opal@frank.fam.cx';
//        $pass = 'ccorenge33';


		$name = 'cute_campus'; //y.yamasaki@crepus.jp
        $pass = '14092ugaAC';
        
    	//$url = 'https://upload.twitter.com/1.1/media/upload.json';
    	
        $consumer_key = 'a50OiN3f4hoxXFSS2zK2j6mTK';
        $consumer_secret = 'DKKhv9U1755hu0zzxbklyPA3GpuAsTTqedoNCFTUKyACshPuOE';
        $access_token = '2515940671-scGnBAVUnURLykOpp0C9uxsmOz6zg1iTkILVqZa';
        $access_token_secret = '7LMe9izK6Cu514gNnn3Kfl2f9QCtoFr5PLBg8oj0A9XTy';
        

		//use Abraham\TwitterOAuth\TwitterOAuth; を先頭につけると以下でクラス取得可能
        //$toa = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);
        //self::$CONSUMER_KEYという書き方もあり ->static変数
        
        //composer show abraham/twitteroauth にてautoload psr-4の名前空間が確認できる　そこから以下でクラス取得可能
        //先頭の逆スラッシュはヘッドで記載のnamespace(名前空間)を解除する
        $connection = new \Abraham\TwitterOAuth\TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);
        $connection->setTimeouts(10,800);

//        var_dump($connection);
//        exit;

		//define(‘UPDRAFTPLUS_IPV4_ONLY’, true);
        //set_time_limit(0);
        
        $postMsg = $data['title']."\n".$data['tw_comment'];
        $fileName = last(explode('/', $data['mvPath']));
        //$fileName = '3s.mp4';
        //exit;
        
        $path = base_path() . "/storage/app/". $data['mvPath'];
        $cdCmd = 'cd ' . base_path() .'/storage/app/public/movie/'. $modelId .' && ';
        
        //if(Storage::exist)
        exec($cdCmd . 'ffmpeg -i '. $fileName . ' -to 20 -s 320x180 -strict -2 '. 'tw_'.$fileName .' -y', $out, $status);
        echo 'twitter: '.$status;
        
        $videoPath = base_path() . "/storage/app/public/movie/". $modelId. '/tw_'.$fileName;
        $fileSize = filesize($videoPath);
        
        //$imgPath = base_path() . "/storage/app/public/movie/2/items_1.jpg";
    	
//        $file = file_get_contents($videoPath);
//        var_dump($file['media_type']);
//        exit;
        
 
		//投稿
        $media_id = $connection->upload("media/upload", array("media" => $videoPath, "total_bytes"=>$fileSize, "media_type"=>'video/mp4', "media_category"=>'tweet_video'), true);
//        var_dump($media_id);
//        exit;
        
        $parameters = array(
            'status' => $postMsg,
            'media_ids' => $media_id->media_id_string,
        );
		
        $result = $connection->post("statuses/update", $parameters);
        
        //$result = $toa->OAuthRequest(self::$TWITTER_API, "POST", array("status"=>$postMsg));
 
		// レスポンス表示
		//var_dump($result->errors[0]->message);
        //exit;
        
        if(isset($result->errors)) {
        	$status[] = 'Twitter Error !';
        }
        else {
        	$atclModel = $this->article->fine($atclId);
            $atclModel->tw_up = 1;
            $atclModel->save();
            
        	$status[] = 'TwitterにUPされました !';
        }


        
/*
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
            
            $token = '';
        }
        
        
        
        //var_dump($fb);
        //exit;
        
        $fileName = 'main.mp4';
        $videoPath = base_path() . "/storage/app/public/movie/". $modelId. '/tw_'.$fileName;
        
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
        if($errorFb == '') {
        	$status[] = $errorFb;
        }
        else {
            $status[] = 'FaceBook OK :[Video ID] ' . $graphNode['id'];
            
            $atclModel = $this->article->fine($atclId);
            $atclModel->fb_up = 1;
            $atclModel->save();
        }

        
        //return view('dashboard.sns.fbup', ['htmlBody'=>$htmlBody]);
*/
        
        
        
        
        
        return redirect('dashboard/articles/snsup/'. $atclId)->with('twStatus', $status);
        

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
