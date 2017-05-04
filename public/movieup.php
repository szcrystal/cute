<?php

    //print_r($_SERVER);
//    exit();
//phpinfo();

	//$path = '/vagrant/cute/vendor/google';
//    $path = '/var/www/vhosts/emerald.cu.cc/turquoise/google-api/src';
//    $rel = set_include_path(get_include_path() . PATH_SEPARATOR . $path);
//    echo $rel;
	//ini_set('error_reporting', E_ALL);
    //error_reporting(-1);
    
    //aaa($aaa);
    
    
//    Google_Client();
//    echo "aaa";
//    exit;
$path = '/var/www/vhosts/emerald.cu.cc/turquoise/google-api/src';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

$path2 = '/var/www/vhosts/emerald.cu.cc/turquoise/google-api/vendor';
set_include_path(get_include_path() . PATH_SEPARATOR . $path2);

//require_once 'Google/autoload.php';
require_once 'aaa.php';
require_once 'autoload.php';
//require_once 'Google/Service/YouTube.php';
session_start();
aaa();
echo __DIR__;
//echo "<br>";
//echo $_SERVER['DOCUMENT_ROOT'];

	
        
    $key = 'AIzaSyBYJdFgn76FsGpxNSSY2G4qPYESVygzzMo';
    $client_id = '362243100375-26aq37mme2dsip9lgbfauvp5k1m530k5.apps.googleusercontent.com';
    $client_secret = '8qRz5fqzuKJlGW1CQFePJ573';
    
    
    $client = new Google_Client();
    
    $client->setDeveloperKey($key);
    //$client->setClientId($client_id);
    //$client->setClientSecret($client_secret);
    
    $client->setScopes('https://www.googleapis.com/auth/youtube');
    $redirect = filter_var('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'], FILTER_SANITIZE_URL);
        //$redirect = filter_var('http://' . 'szc.cu.cc', FILTER_SANITIZE_URL);
    
    $client->setRedirectUri($redirect);
        
//        echo $client->getAccessToken();
//        echo $client->createAuthUrl();
//		exit;

    $youtube = new Google_Service_YouTube($client);
        
//        echo base_path();
//        exit;
        
        $videoResponse = $youtube->videos->listVideos('snippet', array(
            'id' => 'video_id' 
        ));

        print_r($videoResponse);
        //exit;
    
        
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
          
          try {
            // REPLACE this value with the path to the file you are uploading.
            $videoPath = $_SERVER['DOCUMENT_ROOT'] . "/movie/cloud2.mp4";

            // Create a snippet with title, description, tags and category ID
            // Create an asset resource and set its snippet metadata and type.
            // This example sets the video's title, description, keyword tags, and
            // video category.
            $snippet = new Google_Service_YouTube_VideoSnippet();
            $snippet->setTitle("Test title");
            $snippet->setDescription("Test description");
            $snippet->setTags(array("tag1", "tag2"));

            // Numeric video category. See
            // https://developers.google.com/youtube/v3/docs/videoCategories/list 
            $snippet->setCategoryId("22");

            // Set the video's status to "public". Valid statuses are "public",
            // "private" and "unlisted".
            $status = new Google_Service_YouTube_VideoStatus();
            $status->privacyStatus = "public";

            // Associate the snippet and status objects with a new video resource.
            $video = new Google_Service_YouTube_Video();
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
            $media = new Google_Http_MediaFileUpload($client, $insertRequest, 'video/*', NULL, true, $chunkSizeBytes);
            
            //
            $media->setFileSize(filesize($videoPath));
            
            //Read the media file and upload it chunk by chunk.
            $status = false;
            $handle = fopen($videoPath, "rb");
            
            while (!$status && !feof($handle)) {
            	$chunk = fread($handle, $chunkSizeBytes);
                $status = $media->nextChunk($chunk);
            }

            fclose($handle);

            // If you want to make other calls after the file upload, set setDefer back to false
            $client->setDefer(false);


			$htmlBody = "<h3>Video Uploaded</h3><ul>";
            $htmlBody .= sprintf('<li>%s (%s)</li>', $status['snippet']['title'], $status['id']);
            $htmlBody .= '</ul>';

          }
          catch (Google_Service_Exception $e) {
            $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>', htmlspecialchars($e->getMessage()));
          }
          catch (Google_Exception $e) {
            $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>', htmlspecialchars($e->getMessage()));
          }
          
          $_SESSION['token'] = $client->getAccessToken();
        }
        else {
            //If the user hasn't authorized the app, initiate the OAuth flow
            $state = mt_rand();
            $client->setState($state);
            $_SESSION['state'] = $state;

            $authUrl = $client->createAuthUrl();
            $htmlBody = "<h3>Authorization Required</h3>";
            $htmlBody .= "<p>You need to <a href=\"" . $authUrl . "\">authorize access</a> before proceeding.<p>";
        }
    
    
        echo $htmlBody;


    
    
    
