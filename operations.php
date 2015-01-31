<?php

require_once 'Zend/Loader.php';
Zend_Loader::loadClass('Zend_Gdata_YouTube');
Zend_Loader::loadClass('Zend_Gdata_AuthSub');
Zend_Loader::loadClass('Zend_Gdata_App_Exception');
session_start();
setLogging('on');

generateUrlInformation();if (!isset($_POST['operation'])) {
    if (isset($_GET['token'])) {
        updateAuthSubToken($_GET['token']);
    } else {
        if (loggingEnabled()) {
            logMessage('reached operations.php without $_POST or $_GET variables set', 'error');
            
            header('Location: index.php');
            die();
        }
    }
}$operation = $_POST['operation'];switch ($operation) {    case 'create_upload_form':
        createUploadForm($_POST['videoTitle'],
                         $_POST['videoDescription'],
                         $_POST['videoCategory'],
                         $_POST['videoTags']);
        break;    case 'edit_meta_data':
        editVideoData($_POST['newVideoTitle'],
                      $_POST['newVideoDescription'],
                      $_POST['newVideoCategory'],
                      $_POST['newVideoTags'],
                      $_POST['videoId']);
        break;    case 'check_upload_status':
        checkUpload($_POST['videoId']);
        break;    case 'delete_video':
        deleteVideo($_POST['videoId']);
        break;    case 'auth_sub_request':
        generateAuthSubRequestLink();
        break;    case 'auth_sub_token_upgrade':
        updateAuthSubToken($_GET['token']);
        break;    case 'clear_session_var':
        clearSessionVar($_POST['name']);
        break;    case 'retrieve_playlists':
        retrievePlaylists();
        break;    case 'create_playlist':
        createPlaylist($_POST['playlistTitle'], $_POST['playlistDescription']);
        break;    case 'delete_playlist':
        deletePlaylist($_POST['playlistTitle']);
        break;    case 'update_playlist':
        updatePlaylist($_POST['newPlaylistTitle'],
                       $_POST['newPlaylistDescription'],
                       $_POST['oldPlaylistTitle']);
        break;    case (strcmp(substr($operation, 0, 7), 'search_') == 0):
   
        $searchType = substr($operation, 7);
        searchVideos($searchType, $_POST['searchTerm'], $_POST['startIndex'],
            $_POST['maxResults']);
        break;    case 'show_video':
        echoVideoPlayer($_POST['videoId']);
        break;    default:
        unsupportedOperation($_POST);
        break;
}
function searchVideos($searchType, $searchTerm, $startIndex, $maxResults)
{
    $youTubeService = new Zend_Gdata_YouTube();
    $query = $youTubeService->newVideoQuery();
    $query->setQuery($searchTerm);
    $query->setStartIndex($startIndex);
    $query->setMaxResults($maxResults);    switch ($searchType) {
        case 'most_viewed':
            $query->setFeedType('most viewed');
            $query->setTime('this_week');
            $feed = $youTubeService->getVideoFeed($query);
            break;
        case 'most_recent':
            $query->setFeedType('most recent');
            $query->setTime('this_week');
            $feed = $youTubeService->getVideoFeed($query);
            break;
        case 'recently_featured':
            $query->setFeedType('recently featured');
            $feed = $youTubeService->getVideoFeed($query);
            break;
        case 'top_rated':
            $query->setFeedType('top rated');
            $query->setTime('this_week');
            $feed = $youTubeService->getVideoFeed($query);
            break;
        case 'username':
            $feed = $youTubeService->getUserUploads($searchTerm);
            break;
        case 'all':
            $feed = $youTubeService->getVideoFeed($query);
            break;
        case 'owner':
            $httpClient = getAuthSubHttpClient();
            $youTubeService = new Zend_Gdata_YouTube($httpClient);
            try {
                $feed = $youTubeService->getUserUploads('default');
                if (loggingEnabled()) {
                    logMessage($httpClient->getLastRequest(), 'request');
                    logMessage($httpClient->getLastResponse()->getBody(),
                        'response');
                }
            } catch (Zend_Gdata_App_HttpException $httpException) {
                print 'ERROR ' . $httpException->getMessage()
                    . ' HTTP details<br /><textarea cols="100" rows="20">'
                    . $httpException->getRawResponseBody()
                    . '</textarea><br /><br />';
                return;
            } catch (Zend_Gdata_App_Exception $e) {
                print 'ERROR - Could not retrieve users video feed: '
                    . $e->getMessage() . '<br />';
                return;
            }
            echoVideoList($feed, true);
            return;        default:
            echo 'ERROR - Unknown search type - \'' . $searchType . '\'';
            return;
    }    if (loggingEnabled()) {
        $httpClient = $youTubeService->getHttpClient();
        logMessage($httpClient->getLastRequest(), 'request');
        logMessage($httpClient->getLastResponse()->getBody(), 'response');
    }
    echoVideoList($feed);
}
function findFlashUrl($entry)
{
    foreach ($entry->mediaGroup->content as $content) {
        if ($content->type === 'application/x-shockwave-flash') {
            return $content->url;
        }
    }
    return null;
}function checkUpload($videoId)
{
    $httpClient = getAuthSubHttpClient();
    $youTubeService = new Zend_Gdata_YouTube($httpClient);    $feed = $youTubeService->getuserUploads('default');
    $message = 'No further status information available yet.';    foreach($feed as $videoEntry) {
        if ($videoEntry->getVideoId() == $videoId) {
            try {
                $control = $videoEntry->getControl();
            } catch (Zend_Gdata_App_Exception $e) {
                print 'ERROR - not able to retrieve control element '
                    . $e->getMessage();
                return;
            }            if ($control instanceof Zend_Gdata_App_Extension_Control) {
                if (($control->getDraft() != null) &&
                    ($control->getDraft()->getText() == 'yes')) {
                    $state = $videoEntry->getVideoState();
                    if ($state instanceof Zend_Gdata_YouTube_Extension_State) {
                        $message = 'Upload status: ' . $state->getName() . ' '
                            . $state->getText();
                    } else {
                        print $message;
                    }
                }
            }
        }
    }
    print $message;
}function generateUrlInformation()
{
    if (!isset($_SESSION['operationsUrl']) || !isset($_SESSION['homeUrl'])) {
        $_SESSION['operationsUrl'] = 'http://vtwig.com/operations.php';
        $path = explode('/', $_SERVER['PHP_SELF']);
        $path[count($path)-1] = 'youtube_index.php';
        $_SESSION['homeUrl'] = 'http://vtwig.com/index.php';
    }
}function logMessage($message, $messageType)
{
    if (!isset($_SESSION['log_maxLogEntries'])) {
        $_SESSION['log_maxLogEntries'] = 20;
    }    if (!isset($_SESSION['log_currentCounter'])) {
        $_SESSION['log_currentCounter'] = 0;
    }    $currentCounter = $_SESSION['log_currentCounter'];
    $currentCounter++;    if ($currentCounter > $_SESSION['log_maxLogEntries']) {
        $_SESSION['log_currentCounter'] = 0;
    }    $logLocation = 'log_entry_'. $currentCounter . '_' . $messageType;
    $_SESSION[$logLocation] = $message;
    $_SESSION['log_currentCounter'] = $currentCounter;
}
function editVideoData($newVideoTitle, $newVideoDescription, $newVideoCategory, $newVideoTags, $videoId)
{
    $httpClient = getAuthSubHttpClient();
    $youTubeService = new Zend_Gdata_YouTube($httpClient);
    $feed = $youTubeService->getVideoFeed('https://gdata.youtube.com/feeds/users/default/uploads');
    $videoEntryToUpdate = null;    foreach($feed as $entry) {
        if ($entry->getVideoId() == $videoId) {
            $videoEntryToUpdate = $entry;
            break;
        }
    }    if (!$videoEntryToUpdate instanceof Zend_Gdata_YouTube_VideoEntry) {
        print 'ERROR - Could not find a video entry with id ' . $videoId
            . '<br />' . printCacheWarning();
        return;
    }    try {
        $putUrl = $videoEntryToUpdate->getEditLink()->getHref();
    } catch (Zend_Gdata_App_Exception $e) {
        print 'ERROR - Could not obtain video entry\'s edit link: '
            . $e->getMessage() . '<br />';
        return;
    }    $videoEntryToUpdate->setVideoTitle($newVideoTitle);
    $videoEntryToUpdate->setVideoDescription($newVideoDescription);
    $videoEntryToUpdate->setVideoCategory($newVideoCategory);    $videoTagsArray = explode(' ', trim($newVideoTags)); 
    foreach($videoTagsArray as $key => $value) {
        if (strlen($value) < 2) {
            unset($videoTagsArray[$key]);
        }
    }    $videoEntryToUpdate->setVideoTags(implode(', ', $videoTagsArray));    try {
        $updatedEntry = $youTubeService->updateEntry($videoEntryToUpdate, $putUrl);
        if (loggingEnabled()) {
            logMessage($httpClient->getLastRequest(), 'request');
            logMessage($httpClient->getLastResponse()->getBody(), 'response');
        }
    } catch (Zend_Gdata_App_HttpException $httpException) {
        print 'ERROR ' . $httpException->getMessage()
            . ' HTTP details<br /><textarea cols="100" rows="20">'
            . $httpException->getRawResponseBody()
            . '</textarea><br /><br />';
        return;
    } catch (Zend_Gdata_App_Exception $e) {
        print 'ERROR - Could not post video meta-data: ' . $e->getMessage();
        return;
    }
        print 'Entry updated successfully.<br /><a href="#" onclick="'
            . 'ytVideoApp.presentFeed(\'search_owner\', 5, 0, \'none\'); '
            . 'ytVideoApp.refreshSearchResults();" >'
            . '(refresh your video listing)</a><br />'
            . printCacheWarning();
}function createUploadForm($videoTitle, $videoDescription, $videoCategory, $videoTags, $nextUrl = null)
{
    $httpClient = getAuthSubHttpClient();
    $youTubeService = new Zend_Gdata_YouTube($httpClient);
    $newVideoEntry = new Zend_Gdata_YouTube_VideoEntry();    $newVideoEntry->setVideoTitle($videoTitle);
    $newVideoEntry->setVideoDescription($videoDescription);
    $videoCategory = strtoupper(substr($videoCategory, 0, 1))
        . substr($videoCategory, 1);
    $newVideoEntry->setVideoCategory($videoCategory);
    $videoTagsArray = explode(' ', trim($videoTags));
    $newVideoEntry->setVideoTags(implode(', ', $videoTagsArray));    $tokenHandlerUrl = 'https://gdata.youtube.com/action/GetUploadToken';
    try {
        $tokenArray = $youTubeService->getFormUploadToken($newVideoEntry, $tokenHandlerUrl);
        if (loggingEnabled()) {
            logMessage($httpClient->getLastRequest(), 'request');
            logMessage($httpClient->getLastResponse()->getBody(), 'response');
        }
    } catch (Zend_Gdata_App_HttpException $httpException) {
        print 'ERROR ' . $httpException->getMessage()
            . ' HTTP details<br /><textarea cols="100" rows="20">'
            . $httpException->getRawResponseBody()
            . '</textarea><br /><br />';
        return;
    } catch (Zend_Gdata_App_Exception $e) {
        print 'ERROR - Could not retrieve token for syndicated upload. '
            . $e->getMessage()
            . '<br /><br />';
        return;
    }    $tokenValue = $tokenArray['token'];
    $postUrl = $tokenArray['url'];
    if (!$nextUrl) {
    
		include 'core/init.php';
		$article_id=get_article_id();
        $nextUrl ='http://vtwig.com/video_temp.php?article='.$article_id;
	
    }
		echo $article_id=(int)$_GET['article'];
    print <<< END
        <br /><div id="video_browse_box"><form action="${postUrl}?nexturl=${nextUrl}"
        method="post" enctype="multipart/form-data">
        <input id="you_browse_button" name="file" type="file"/>
        <input name="token" type="hidden" value="${tokenValue}"/>
        <input id="you_submit_button_2" class="button_style1" value="Upload Video File" type="submit" />
        </form>
		<br />
		Once you click on "Upload Video File" please wait patiently while the file is being uploaded...
		</div>
END;
}function deleteVideo($videoId)
{	
    $httpClient = getAuthSubHttpClient();
    $youTubeService = new Zend_Gdata_YouTube($httpClient);
    $feed = $youTubeService->getVideoFeed('https://gdata.youtube.com/feeds/users/default/uploads');
    $videoEntryToDelete = null;    foreach($feed as $entry) {
        if ($entry->getVideoId() == $videoId) {
            $videoEntryToDelete = $entry;
            break;
        }
    }
    if (!$videoEntryToDelete instanceof Zend_Gdata_YouTube_VideoEntry) {
        print 'ERROR - Could not find a video entry with id ' . $videoId . '<br />';
        return;
    }    try {
        $httpResponse = $youTubeService->delete($videoEntryToDelete);
        if (loggingEnabled()) {
            logMessage($httpClient->getLastRequest(), 'request');
            logMessage($httpClient->getLastResponse()->getBody(), 'response');
        }    } catch (Zend_Gdata_App_HttpException $httpException) {
        print 'ERROR ' . $httpException->getMessage()
         . ' HTTP details<br /><textarea cols="100" rows="20">'
         . $httpException->getRawResponseBody()
         . '</textarea><br /><br />';
        return;
    } catch (Zend_Gdata_App_Exception $e) {
        print 'ERROR - Could not delete video: '. $e->getMessage();
        return;
    }    print 'Entry deleted succesfully.<br />' . $httpResponse->getBody()
        . '<br /><a href="#" onclick="'
        . 'ytVideoApp.presentFeed(\'search_owner\', 5, 0, \'none\');"'
        . '">(refresh your video listing)</a><br />'
        . printCacheWarning();
}
function setLogging($loggingOption, $maxLogItems = 10)
{
    switch ($loggingOption) {
        case 'on' :
            $_SESSION['logging'] = 'on';
            $_SESSION['log_currentCounter'] = 0;
            $_SESSION['log_maxLogEntries'] = $maxLogItems;
            break;        case 'off':
            $_SESSION['logging'] = 'off';
            break;
    }
}
function loggingEnabled()
{
    if ($_SESSION['logging'] == 'on') {
        return true;
    }
}function clearSessionVar($name)
{
    if (isset($_SESSION[$name])) {
        unset($_SESSION[$name]);
    }
    header('Location: youtube_index.php');
    
}function generateAuthSubRequestLink($nextUrl = null)
{
    $scope = 'https://gdata.youtube.com';
    $secure = false;
    $session = true;    if (!$nextUrl) {
        generateUrlInformation();
        $nextUrl = $_SESSION['operationsUrl'];
    }    $url = Zend_Gdata_AuthSub::getAuthSubTokenUri($nextUrl, $scope, $secure, $session);
    echo '<a href="' . $url
        . '"><strong>Click here to authenticate with YouTube</strong></a>';
}
function updateAuthSubToken($singleUseToken)
{
    try {
        $sessionToken = Zend_Gdata_AuthSub::getAuthSubSessionToken($singleUseToken);
    } catch (Zend_Gdata_App_Exception $e) {
        print 'ERROR - Token upgrade for ' . $singleUseToken
            . ' failed : ' . $e->getMessage();
        return;
    }    $_SESSION['sessionToken'] = $sessionToken;
    generateUrlInformation();
    header('Location: ' . $_SESSION['homeUrl']);
}function getAuthSubHttpClient()
{
    try {
        $httpClient = Zend_Gdata_AuthSub::getHttpClient($_SESSION['sessionToken']);
    } catch (Zend_Gdata_App_Exception $e) {
        print 'ERROR - Could not obtain authenticated Http client object. '
            . $e->getMessage();
        return;
    }
    $httpClient->setHeaders('X-GData-Key', 'key='. $_SESSION['developerKey']);
    return $httpClient;
}
function echoThumbnails($feed)
{
    foreach ($feed as $entry) {
        $videoId = $entry->getVideoId();
        $firstThumbnail = htmlspecialchars(
            $entry->mediaGroup->thumbnail[0]->url);
        echo '<img id="' . $videoId . '" class="thumbnail" src="'
            . $firstThumbnail .'" width="130" height="97" onclick="'
            . 'ytVideoApp.presentVideo(\'' . $videoId . '\', 1);" '
            . 'title="click to watch: ' .
            htmlspecialchars($entry->getVideoTitle()) . '" />';
     }
}function echoVideoList($feed, $authenticated = false)
{
    $table = '<table id="videoResultList" class="videoList"><tbody>';
    $results = 0;    foreach ($feed as $entry) {
        $videoId = $entry->getVideoId();
        $thumbnailUrl = 'notfound.jpg';
        if (count($entry->mediaGroup->thumbnail) > 0) {
            $thumbnailUrl = htmlspecialchars(
                $entry->mediaGroup->thumbnail[0]->url);
        }        $videoTitle = htmlspecialchars($entry->getVideoTitle());
        $videoDescription = htmlspecialchars($entry->getVideoDescription());
        $videoCategory = htmlspecialchars($entry->getVideoCategory());
        $videoTags = $entry->getVideoTags();        $table .= '<tr id="video_' . $videoId . '">'
                . '<td width="130"><img onclick="ytVideoApp.presentVideo(\''
                . $videoId. '\')" src="' . $thumbnailUrl. '" /></td>'
                . '<td><a href="#" onclick="ytVideoApp.presentVideo(\''
                . $videoId . '\')">'. stripslashes($videoTitle) . '</a>'
                . '<p class="videoDescription">'
                . stripslashes($videoDescription) . '</p>'
                . '<p class="videoCategory">category: ' . $videoCategory
                . '</p><p class="videoTags">tagged: '
                . htmlspecialchars(implode(', ', $videoTags)) . '</p>';          if ($authenticated) {
              $table .= '<p class="edit">'
                     . '<a onclick="ytVideoApp.presentMetaDataEditForm(\''
                     . addslashes($videoTitle) . '\', \''
                     . addslashes($videoDescription) . '\', \''
                     . $videoCategory . '\', \''
                     . addslashes(implode(', ', $videoTags)) . '\', \''
                     . $videoId . '\');" href="#">edit video data</a> | '
                     . '<a href="#" onclick="ytVideoApp.confirmDeletion(\''
                     . $videoId
                     . '\');">delete this video</a></p><br clear="all">';
          }    $table .= '</td></tr>';
    $results++;
    }    if ($results < 1) {
        echo '<br />No results found<br /><br />';
    } else {
        echo $table .'</tbody></table><br />';
    }
}function echoVideoPlayer($videoId)
{
    $youTubeService = new Zend_Gdata_YouTube();    try {
        $entry = $youTubeService->getVideoEntry($videoId);
    } catch (Zend_Gdata_App_HttpException $httpException) {
        print 'ERROR ' . $httpException->getMessage()
            . ' HTTP details<br /><textarea cols="100" rows="20">'
            . $httpException->getRawResponseBody()
            . '</textarea><br /><br />';
        return;
    }    $videoTitle = htmlspecialchars($entry->getVideoTitle());
    $videoUrl = htmlspecialchars(findFlashUrl($entry));
    $relatedVideoFeed = getRelatedVideos($entry->getVideoId());
    $topRatedFeed = getTopRatedVideosByUser($entry->author[0]->name);    print <<<END
        <b>$videoTitle</b><br />
        <object width="425" height="350">
        <param name="movie" value="${videoUrl}&autoplay=1"></param>
        <param name="wmode" value="transparent"></param>
        <embed src="${videoUrl}&autoplay=1" type="application/x-shockwave-flash" wmode="transparent"
        width="425" height="350"></embed>
        </object>
END;    echo '<br />';
    echoVideoMetadata($entry);
    echo '<br /><b>Related:</b><br />';
    echoThumbnails($relatedVideoFeed);
    echo '<br /><b>Top rated videos by user:</b><br />';
    echoThumbnails($topRatedFeed);
}function getRelatedVideos($videoId)
{
    $youTubeService = new Zend_Gdata_YouTube();
    $ytQuery = $youTubeService->newVideoQuery();    $ytQuery->setFeedType('related', $videoId);
    
    $ytQuery->setOrderBy('rating');    $ytQuery->setMaxResults(5);
    
    $ytQuery->setFormat(5);
    return $youTubeService->getVideoFeed($ytQuery);
}function getTopRatedVideosByUser($user)
{
    $userVideosUrl = 'https://gdata.youtube.com/feeds/users/' .
                   $user . '/uploads';
    $youTubeService = new Zend_Gdata_YouTube();
    $ytQuery = $youTubeService->newVideoQuery($userVideosUrl);    $ytQuery->setOrderBy('rating');    $ytQuery->setMaxResults(5);
  
    $ytQuery->setFormat(5);
    return $youTubeService->getVideoFeed($ytQuery);
}function echoVideoMetadata($entry)
{
    $title = htmlspecialchars($entry->getVideoTitle());
    $description = htmlspecialchars($entry->getVideoDescription());
    $authorUsername = htmlspecialchars($entry->author[0]->name);
    $authorUrl = 'http://www.youtube.com/profile?user=' .
                 $authorUsername;
    $tags = htmlspecialchars(implode(', ', $entry->getVideoTags()));
    $duration = htmlspecialchars($entry->getVideoDuration());
    $watchPage = htmlspecialchars($entry->getVideoWatchPageUrl());
    $viewCount = htmlspecialchars($entry->getVideoViewCount());
    $rating = 0;
    if (isset($entry->rating->average)) {
        $rating = $entry->rating->average;
    }
    $numRaters = 0;
    if (isset($entry->rating->numRaters)) {
        $numRaters = $entry->rating->numRaters;
    }
    $flashUrl = htmlspecialchars(findFlashUrl($entry));
    print <<<END
        <b>Title:</b> ${title}<br />
        <b>Description:</b> ${description}<br />
        <b>Author:</b> <a href="${authorUrl}">${authorUsername}</a><br />
        <b>Tags:</b> ${tags}<br />
        <b>Duration:</b> ${duration} seconds<br />
        <b>View count:</b> ${viewCount}<br />
        <b>Rating:</b> ${rating} (${numRaters} ratings)<br />
        <b>Flash:</b> <a href="${flashUrl}">${flashUrl}</a><br />
        <b>Watch page:</b> <a href="${watchPage}">${watchPage}</a> <br />
END;
}function printCacheWarning()
{
    return '<p class="note">'
         . 'Please note that the change may not be reflected in the API '
         . 'immediately due to caching.<br/>'
         . 'Please refer to the API documentation for more details.</p>';
}function retrievePlaylists()
{
    $httpClient = getAuthSubHttpClient();
    $youTubeService = new Zend_Gdata_YouTube($httpClient);
    $feed = $youTubeService->getPlaylistListFeed('default');    if (loggingEnabled()) {
        logMessage($httpClient->getLastRequest(), 'request');
        logMessage($httpClient->getLastResponse()->getBody(), 'response');
    }    if (!$feed instanceof Zend_Gdata_YouTube_PlaylistListFeed) {
        print 'ERROR - Could not retrieve playlists<br />'.
        printCacheWarning();
        return;
    }    $playlistEntries = '<ul>';
    $entriesFound = 0;
    foreach($feed as $entry) {
        $playlistTitle = $entry->getTitleValue();
        $playlistDescription = $entry->getDescription()->getText();
        $playlistEntries .=  '<li><h3>' . $playlistTitle
            . '</h3>' . $playlistDescription . ' | '
            . '<a href="#" onclick="ytVideoApp.prepareUpdatePlaylistForm(\''
            . $playlistTitle . '\', \'' . $playlistDescription
            . '\'); ">update</a> | '
            . '<a href="#" onclick="ytVideoApp.confirmPlaylistDeletion(\''
            . $playlistTitle . '\');">delete</a></li>';
        $entriesFound++;
    }    $playlistEntries .= '</ul><br /><a href="#" '
                        . 'onclick="ytVideoApp.prepareCreatePlaylistForm(); '
                        . 'return false;">'
                        . 'Add new playlist</a><br />'
                        . '<div id="addNewPlaylist"></div>';    if (loggingEnabled()) {
        logMessage($httpClient->getLastRequest(), 'request');
        logMessage($httpClient->getLastResponse()->getBody(), 'response');
    }
    if ($entriesFound > 0) {
        print $playlistEntries;
    } else {
        print 'No playlists found';
    }
}function createPlaylist($playlistTitle, $playlistDescription)
{
    $httpClient = getAuthSubHttpClient();
    $youTubeService = new Zend_Gdata_YouTube($httpClient);
    $feed = $youTubeService->getPlaylistListFeed('default');
    if (loggingEnabled()) {
        logMessage($httpClient->getLastRequest(), 'request');
        logMessage($httpClient->getLastResponse()->getBody(), 'response');
    }    $newPlaylist = $youTubeService->newPlaylistListEntry();
    $newPlaylist->description = $youTubeService->newDescription()->setText($playlistDescription);
    $newPlaylist->title = $youTubeService->newTitle()->setText($playlistDescription);    if (!$feed instanceof Zend_Gdata_YouTube_PlaylistListFeed) {
        print 'ERROR - Could not retrieve playlists<br />'
            . printCacheWarning();
        return;
    }    $playlistFeedUrl = 'https://gdata.youtube.com/feeds/users/default/playlists';    try {
        $updatedEntry = $youTubeService->insertEntry($newPlaylist, $playlistFeedUrl);
        if (loggingEnabled()) {
            logMessage($httpClient->getLastRequest(), 'request');
            logMessage($httpClient->getLastResponse()->getBody(), 'response');
        }
    } catch (Zend_Gdata_App_HttpException $httpException) {
        print 'ERROR ' . $httpException->getMessage()
            . ' HTTP details<br /><textarea cols="100" rows="20">'
            . $httpException->getRawResponseBody()
            . '</textarea><br /><br />';
        return;
    } catch (Zend_Gdata_App_Exception $e) {
        print 'ERROR - Could not create new playlist: ' . $e->getMessage();
        return;
    }    print 'Playlist added succesfully.<br /><a href="#" onclick="'
        . 'ytVideoApp.retrievePlaylists();"'
        . '">(refresh your playlist listing)</a><br />'
        . printCacheWarning();
}function deletePlaylist($playlistTitle)
{
    $httpClient = getAuthSubHttpClient();
    $youTubeService = new Zend_Gdata_YouTube($httpClient);
    $feed = $youTubeService->getPlaylistListFeed('default');
    if (loggingEnabled()) {
        logMessage($httpClient->getLastRequest(), 'request');
        logMessage($httpClient->getLastResponse()->getBody(), 'response');
    }    $playlistEntryToDelete = null;    foreach($feed as $playlistEntry) {
        if ($playlistEntry->getTitleValue() == $playlistTitle) {
            $playlistEntryToDelete = $playlistEntry;
            break;
        }
    }    if (!$playlistEntryToDelete instanceof Zend_Gdata_YouTube_PlaylistListEntry) {
        print 'ERROR - Could not retrieve playlist to be deleted<br />'
            . printCacheWarning();
            return;
    }    try {
        $response = $playlistEntryToDelete->delete();
        if (loggingEnabled()) {
            logMessage($httpClient->getLastRequest(), 'request');
            logMessage($httpClient->getLastResponse()->getBody(), 'response');
        }
    } catch (Zend_Gdata_App_HttpException $httpException) {
        print 'ERROR ' . $httpException->getMessage()
            . ' HTTP details<br /><textarea cols="100" rows="20">'
            . $httpException->getRawResponseBody()
            . '</textarea><br /><br />';
        return;
    } catch (Zend_Gdata_App_Exception $e) {
        print 'ERROR - Could not delete the playlist: ' . $e->getMessage();
        return;
    }    print 'Playlist deleted succesfully.<br />'
        . '<a href="#" onclick="ytVideoApp.retrievePlaylists();">'
        . '(refresh your playlist listing)</a><br />' . printCacheWarning();
}
function updatePlaylist($newPlaylistTitle, $newPlaylistDescription, $oldPlaylistTitle)
{
    $httpClient = getAuthSubHttpClient();
    $youTubeService = new Zend_Gdata_YouTube($httpClient);
    $feed = $youTubeService->getPlaylistListFeed('default');    if (loggingEnabled()) {
        logMessage($httpClient->getLastRequest(), 'request');
        logMessage($httpClient->getLastResponse()->getBody(), 'response');
    }    $playlistEntryToDelete = null;    foreach($feed as $playlistEntry) {
        if ($playlistEntry->getTitleValue() == $oldplaylistTitle) {
            $playlistEntryToDelete = $playlistEntry;
            break;
        }
    }    if (!$playlistEntryToDelete instanceof Zend_Gdata_YouTube_PlaylistListEntry) {
        print 'ERROR - Could not retrieve playlist to be updated<br />'
            . printCacheWarning();
            return;
    }    try {
        $response = $playlistEntryToDelete->delete();
        if (loggingEnabled()) {
            logMessage($httpClient->getLastRequest(), 'request');
            logMessage($httpClient->getLastResponse()->getBody(), 'response');
        }
    } catch (Zend_Gdata_App_HttpException $httpException) {
        print 'ERROR ' . $httpException->getMessage()
            . ' HTTP details<br /><textarea cols="100" rows="20">'
            . $httpException->getRawResponseBody()
            . '</textarea><br /><br />';
            return;
    } catch (Zend_Gdata_App_Exception $e) {
        print 'ERROR - Could not delete the playlist: ' . $e->getMessage();
        return;
    }    print 'Playlist deleted succesfully.<br /><a href="#" onclick="' .
          'ytVideoApp.retrievePlaylists();"'.
          '">(refresh your playlist listing)</a><br />'.
          printCacheWarning();
}
function unsupportedOperation($_POST)
{
    $message = 'ERROR An unsupported operation has been called - post variables received '
             . print_r($_POST, true);    if (loggingEnabled()) {
        logMessage($message, 'error');
    }
    print $message;
}?>