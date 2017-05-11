<?php

namespace App\Http\Controllers\DashBoard;

use App\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//use vendor\google\apiclient\src;
use Abraham\TwitterOAuth\TwitterOAuth;

use Auth;
use Mail;

class HomeController extends Controller
{

	public function __construct(Admin $admin)
    {
        $this -> middleware('adminauth'/*, ['except' => ['getRegister','postRegister']]*/);
        //$this->middleware('auth:admin', ['except' => 'getLogout']);
        //$this -> middleware('log', ['only' => ['getIndex']]);
        
        $this -> admin = $admin;
        
        $this->perPage = 20;

	}
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $adminUser = Auth::guard('admin')->user();
        
//        Mail::raw('Text to e-mail', function($message)
//        {
//            $message->from('info@cutecampus.jp', 'CuteCampus')
//            		->to('info@cutecampus.jp');
//        });


		
        
        return view('dashboard.index', ['name'=>$adminUser->name,]);
    }
    
//    private function sendMail($data)
//    {
//    	$data['is_user'] = 1;
//        Mail::send('emails.contact', $data, function($message) use ($data) //引数について　http://readouble.com/laravel/5/1/ja/mail.html
//        {
//            //$dataは連想配列としてviewに渡され、その配列のkey名を変数としてview内で取得出来る
//            $message -> from('info@cutecampus.jp', 'CuteCampus')
//                     -> to($data['user_email'], $data['user_name'])
//                     -> subject('お問い合わせの送信が完了しました');
//            //$message->attach($pathToFile);
//        });
//        
//        //for Admin
//        $data['is_user'] = 0;
//        //if(! env('MAIL_CHECK', 0)) { //本番時 env('MAIL_CHECK')がfalseの時
//            Mail::send('emails.contact', $data, function($message) use ($data)
//            {
//                $message -> from(env('ADMIN_EMAIL'), env('ADMIN_NAME'))
//                         -> to(env('ADMIN_EMAIL'), env('ADMIN_NAME'))
//                         -> subject('お問い合わせがありました - '. config('app.name', 'MovieReview'). ' -');
//            });
//    }
    
    
    public function getRegister ($id='')
    {
    	$editId = 0;
        $admin = NULL;
        
    	if($id) {
        	$editId = $id;
            $admin = $this->admin->find($id);
        }
        
    	$admins = $this->admin->paginate($this->perPage);
        
    	return view('dashboard.register', ['admins'=>$admins, 'admin'=>$admin, 'editId'=>$editId]);
    }
    
    public function postRegister(Request $request)
    {
    	$editId = $request->input('edit_id');
        $valueId = '';
        if($editId) {
        	$valueId = ','. $editId;
        }
        
    	$rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:admins,email'.$valueId, /* |unique:admins 注意:unique */
            'password' => 'required|min:8',
        ];
        
        $this->validate($request, $rules);
        
        $data = $request->all(); //requestから配列として$dataにする
        
        if($data['edit_id']) {
        	$adminModel = $this->admin->find($data['edit_id']);
        }
        else {
        	$adminModel = $this->admin;
        }
        
        $data['password'] = bcrypt($data['password']);
        $data['authority'] = 99;
        
        $adminModel->fill($data);
        $adminModel->save();
        
        //Save&手動ログイン：以下でも可 :Eroquent ORM database/seeds/UserTableSeeder内にもあるので注意
//		$admin = Admin::create([
//            'name' => $data['name'],
//			'email' => $data['email'],
//			'password' => bcrypt($data['password']),
//            //'admin' => 99,
//		]);
        
        if($editId)
        	$status = '管理者情報を更新しました！';
        else
	        $status = '管理者:'.$data['name'].'さんが追加されました。';
        
        return redirect('dashboard/register')->with('status', $status);
    }
    
    
    public function getLogout(Request $request) {
    	//$request->session()->pull('admin');
        Auth::guard('admin')->logout();
        return redirect('dashboard/login'); //->intended('/')
        
    }
    
    
    public function getMovieup(Request $request)
    {
    	//API Key: AIzaSyBYJdFgn76FsGpxNSSY2G4qPYESVygzzMo
        
        //$path = '/vagrant/cute/vendor/google';
//        $path = '/vagrant/cute/google-api/src';
//		set_include_path(get_include_path() . PATH_SEPARATOR . $path);
//        
//        //require_once 'apiclient/src/Google/autoload.php';
//        require_once 'Google/Client.php';
//        require_once 'Google/Service/Resource.php';

session_start(); //必要

		// --- Google側のOAuth設定でリダイレクトURLと下記のリダイレクトを一致させる必要がある ---
        
        $key = 'AIzaSyBYJdFgn76FsGpxNSSY2G4qPYESVygzzMo';
        $client_id = '362243100375-n8beqqfeu29qfcac18rjdvnv8thblogk.apps.googleusercontent.com';
        $client_secret = 'bQZyhPR9f8O0UwjWauoFKSri';

        $client = new \Google_Client();
        
        //$client->setDeveloperKey($key);
        $client->setClientId($client_id);
		$client->setClientSecret($client_secret);
        
        $client->setScopes('https://www.googleapis.com/auth/youtube');
        //$redirect = filter_var('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'], FILTER_SANITIZE_URL);
        $redirect = filter_var('http://' . $_SERVER['HTTP_HOST'] . '/dashboard/movieup', FILTER_SANITIZE_URL);
        
        $client->setRedirectUri($redirect);
        
//        echo $client->getAccessToken();
//        echo $client->createAuthUrl();
//		exit;

        $youtube = new \Google_Service_YouTube($client);
        
//        echo base_path();
//        exit;
        
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
            $videoPath = base_path() . "/public/movie/cloud2.mp4";
            

            // Create a snippet with title, description, tags and category ID
            // Create an asset resource and set its snippet metadata and type.
            // This example sets the video's title, description, keyword tags, and
            // video category.
            $snippet = new \Google_Service_YouTube_VideoSnippet();
            $snippet->setTitle("Test title");
            $snippet->setDescription("Test description");
            $snippet->setTags(array("tag1", "tag2"));


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
        
        
        }
        else {
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
        
        
    	return view('dashboard.sns.movieup', ['htmlBody'=>$htmlBody]);
    }
    
    
    
    public function getTwtup(Request $request)
    {
    	$videoPath = base_path() . "/public/movie/cloud2.mp4";
    	$fileSize = filesize($videoPath);
        
        $name = 'opal@frank.fam.cx';
        $pass = 'ccorenge33';
        
    	$url = 'https://upload.twitter.com/1.1/media/upload.json';
    	
        $consumer_key = '';
        $consumer_secret = '';
        $access_token = '';
        $access_token_secret = '';
        

		//use Abraham\TwitterOAuth\TwitterOAuth; を先頭につけると以下でクラス取得可能
        //$toa = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);
        //self::$CONSUMER_KEYという書き方もあり ->static変数
        
        //composer show abraham/twitteroauth にてautoload psr-4の名前空間が確認できる　そこから以下でクラス取得可能
        //先頭の逆スラッシュはヘッドで記載のnamespace(名前空間)を解除する
        $toa = new \Abraham\TwitterOAuth\TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);
        
        var_dump($toa);
        exit;
 
		//投稿
		$res = $toa->OAuthRequest(self::$TWITTER_API, "POST", array("status"=>"$postMsg"));
 
		// レスポンス表示
		var_dump($res);
        exit;
        
        /*
        $post_data = array(
          'command'=>'INIT',
          'media_type' => 'video/mp4', 動画の場合video/mp4固定（mp4のみ対応の為）
          'total_bytes' => $fileSize, 動画のファイルサイズ
        );
        
        $context = stream_context_create(array(
            'http' => array(
              'method'  => 'POST',
              'header' => "Content-type: application/x-www-form-urlencoded",
              'header'  => sprintf("Authorization: Basic %s", base64_encode($name.':'.$pass)). " Content-type: application/x-www-form-urlencoded",
              'content' => http_build_query($post_data, "", "&"),
              'timeout' => 10,
            ),
        ));
        
        $ret = file_get_contents($url, false, $context);
        $htmlBody = $rel;
        */
        
    	return view('dashboard.sns.twtup', ['htmlBody'=>$htmlBody]);
    }
    
    public function getFbup(Request $request)
    {
    	//https://developers.facebook.com/docs/php/howto/example_upload_video
        
        
    	$fb = new \Facebook\Facebook([
          'app_id' => '{app-id}',
          'app_secret' => '{app-secret}',
          'default_graph_version' => 'v2.2',
        ]);
        
        var_dump($fb);
        exit;
        
        $data = [
          'title' => 'My Foo Video',
          'description' => 'This video is full of foo and bar action.',
          'source' => $fb->videoToUpload('/path/to/foo_bar.mp4'),
        ];
        
        try {
          $response = $fb->post('/me/videos', $data, 'user-access-token');
        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
          // When Graph returns an error
          echo 'Graph returned an error: ' . $e->getMessage();
          exit;
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {
          // When validation fails or other local issues
          echo 'Facebook SDK returned an error: ' . $e->getMessage();
          exit;
        }

        $graphNode = $response->getGraphNode();
        var_dump($graphNode);

        echo 'Video ID: ' . $graphNode['id'];
        
        $htmlBody = 'Video ID: ' . $graphNode['id'];
        
        return view('dashboard.sns.fbup', ['htmlBody'=>$htmlBody]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
