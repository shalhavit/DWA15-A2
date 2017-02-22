<?php
require('twitteroauth/autoload.php');
use Abraham\TwitterOAuth\TwitterOAuth;

require_once('tools.php');

// Number of tweets to display
$arrayTweets = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10');

// Dropdown validation
function getNumberTweets($number) {
    return isset($_GET[$number]) ? $_GET[$number] : '';
}

function isValidIndex($index, $array) {
    return ($index >= 1) && ($index < (count($array) + 1));
}

// Get the number of tweets to display
$numTweets = getNumberTweets('numTweets');

$valid = (isValidIndex($numTweets, $arrayTweets)) ? true : false;
if(!$valid){
    $numTweets = '7';
}

function getConnectionWithAccessToken($oauth_token, $oauth_token_secret) {
    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);
    return $connection;
}

/* Credentials*/
/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
// define('CONSUMER_KEY', '6Zc3z8ZQ0W32EHKsarnutUiP8');
// define('CONSUMER_SECRET', 'Ux9smFppL2nRfzgd5E5u8MxFw14DrNQ3MDAaBWT7U5LXhJavyr');
// $oauth_token = "740315600-eBNa0g4eKdmghiHetwvdllXzkLFS0Tc9vVzgq8gl";
// $oauth_token_secret = "iLAEXItdFdEJa34C7nvrkAOzUHKwGOT3tZ2mEG5WsuGOm";

define('CONSUMER_KEY', 'e9P4iCeCWD4a6Lp8oHh7gRK6t');
define('CONSUMER_SECRET', 'fDIAbecxazDtl4g32juRLSdUUDGio2xBUL8DWBzs7Wxr74RbyH');
$oauth_token = "99417201-PwydObaVey6cfTUksMoPcT6XttgNiJXKxxrLvph3k";
$oauth_token_secret = "1gxt4CXeUAYgCgMnuJq1h2tOpdPB78GrhjRjZGvveJ6Jw";

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);

// $content = $connection->get("account/verify_credentials");
// dump($content);

// $followers = $connection->get("followers/list");
// dump($followers);
$user_timeline = $connection->get('statuses/home_timeline', array('count' => $numTweets));

if (isset($_GET['filter']) and ($_GET['filter']!= '')) {
    $filter = $_GET['filter'];
    $user_timeline = $connection->get('search/tweets', array('q' => $filter, 'count' => $numTweets));
    $array_user_timeline = json_decode(json_encode($user_timeline->statuses), true);
}
else {
    $filter = '';
    $array_user_timeline = json_decode(json_encode($user_timeline), true);
}

if(count($array_user_timeline) == 0) {
    $alertType = 'alert-danger';
    $labelResponse = 'User not found or without tweets published';
} else {
    $alertType = 'alert-info';
    $labelResponse = '@'.sanitize($filter);
}

// EOF
