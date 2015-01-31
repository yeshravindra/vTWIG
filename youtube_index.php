<?php
session_start();
include 'core/init.php';
protect_page();
include "widgets/header.php";
$article_id=(int)$_GET['article'];
$edit=check_if_article_belongs_to_user($article_id);
if ($edit==false){
	header('Location:view_article.php?article='.$article_id);
	//header('Location:not_found.php');
	die();
}
insert_article_id($article_id);
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Gdata
 * @copyright  Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */

/**
 * PHP sample code for the YouTube data API.  Utilizes the Zend Framework
 * Zend_Gdata component to communicate with the YouTube data API.
 *
 * Requires the Zend Framework Zend_Gdata component and PHP >= 5.1.4
 * This sample is run from within a web browser.  These files are required:
 * session_details.php - a script to view log output and session variables
 * operations.php - the main logic, which interfaces with the YouTube API
 * index.php - the HTML to represent the web UI, contains some PHP
 * video_app.css - the CSS to define the interface style
 * video_app.js - the JavaScript used to provide the video list AJAX interface
 *
 * NOTE: If using in production, some additional precautions with regards
 * to filtering the input data should be used.  This code is designed only
 * for demonstration purposes.
 */


/**
 * Set your developer key here.
 *
 * NOTE: In a production application you may want to store this information in
 * an external file.
 */
$_SESSION['developerKey'] = 'AI39si4F4NnAvdh4CdRsRA2cIFVkB_-Zxi2lz8GRE-4JZN-9MpwUU4M3g2x1oFnh9LQjXV6RC2YiZg9X9ZYZgQssRoYZfU8_UQ';

/**
 * Convert HTTP status into normal text.
 *
 * @param number $status HTTP status received after posting syndicated upload
 * @param string $code Alphanumeric description of error
 * @param string $videoId (optional) Video id received back to which the status
 *        code refers to
 */

function uploadStatus($status, $code = null, $videoId = null, $article_id)
{		
	echo '<div id="video_uploading_done">';
    switch ($status) {
        case $status < 400:
            echo  '<p style="color:#506488;font:1.3em constania;">Success ! Entry created <br/> </p><a href="#" onclick=" ytVideoApp.checkUploadDetails(\''.$videoId .'\'); " style="color:#506488;font:13px constania;">Check details. </a>';
			echo '<a href="view_article.php?article='.$article_id.'" style="color:#506488;font:13px constania;"> Return back to article.</a>';
				include 'view_article.php?article='.$article_id;
            break;
        default:
            echo 'There seems to have been an error: '. $code .
                 '<a href="#" onclick=" ytVideoApp.checkUploadDetails(\''.
                 $videoId . '\'); ">(check details)</a>';
    }
	echo '</div>';
}

/**
 * Helper function to check whether a session token has been set
 *
 * @return boolean Returns true if a session token has been set
 */
function authenticated()
{		$_SESSION['sessionToken']='1/YOsqC7ruHvNZoYbU_YrJHwMoqm3EgVJJe5KoPt2ANzk';
    if (isset($_SESSION['sessionToken'])) {
        return true;
    }
}

/**
 * Helper function to print a list of authenticated actions for a user.
 */
function printAuthenticatedActions()
{
    print <<<END
        <div id="actions">
        <ul>
        <a href="#" onclick="ytVideoApp.prepareUploadForm();
        return false;"class="button_style1" style="position:absolute;left:100px;top:50px;display:block;width:300px;
	height:100px;text-align:center;"><div id="upload_arrow"><img src="templates/media/upload_image.gif" /></div><div style="position:relative;left:0px;top:15px;font-size:14px;">Upload Video</div><div id="thanks_you_logo"><img src="templates/media/yotube_logo.gif" /></div></a><br />
        <div id="syndicatedUploadDiv"></div><div id="syndicatedUploadStatusDiv"></div>
        </ul>
		</div>
END;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
  <title>vTwig YouTube Channel</title>
  <link href="video_app.css" type="text/css" rel="stylesheet" />
  <script src="video_app.js" type="text/javascript"></script>
</head>

<body>
  <div id="main">
        <h2 style="position:absolute;top:10px;left:30px;color:#506488;font:20px constania;width:300px;">Upload a Video to your article</h2>
	
    <br />
    
    <br clear="all" />
    <?php
        // if $_GET['status'] is populated then we have a response
        // about a syndicated upload from YouTube's servers
        if (isset($_GET['status'])) {
            (isset($_GET['code']) ? $code = $_GET['code'] : $code = null);
            (isset($_GET['id']) ? $id = $_GET['id'] : $id = null);
            print '<div id="generalStatus">' .
                  uploadStatus($_GET['status'], $code, $id, $article_id) .
                  '<div id="detailedUploadStatus" style="display:inline-block;display:inline;position:relative;top:100px;left:200px;z-index:100;color:#506488;font:13px constania;"></div></div>';
         }
    ?>
    <!-- General status -->
    <?php
        if (authenticated()) {
            printAuthenticatedActions();
        }
    ?>
    <!-- end General status -->
    <br clear="all" />
</div>
</body>
</html>