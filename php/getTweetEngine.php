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

define('CONSUMER_KEY', 'UV3AWLJwI3j8oG4tPe8hSScF8');
define('CONSUMER_SECRET', 'phx2hLunL0z35Pn9LdPddsERJF1sifRR0e5GL5FSuPcwZLv6xe');
$oauth_token = "47572670-JD710GMVYP5BQkbQ9orUieBsd35Q4xf5XlL0RwUEC";
$oauth_token_secret = "3bxCHxJihBb57lQBV6ncjoU3w4gAYicr5gdtIDPxoWdCN";

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);

$userTimeline = $connection->get('statuses/home_timeline', array('count' => $numTweets));

if (isset($_GET['filter']) and ($_GET['filter']!= '')) {
    $filter = $_GET['filter'];
    $userTimeline = $connection->get('search/tweets', array('q' => $filter, 'count' => $numTweets));
    $arrayUserTimeline = json_decode(json_encode($userTimeline->statuses), true);
}
else {
    $filter = '';
    $arrayUserTimeline = json_decode(json_encode($userTimeline), true);
}

if(count($arrayUserTimeline) == 0) {
    $alertType = 'alert-danger';
    $labelResponse = 'User not found or without tweets published';
} else {
    $alertType = 'alert-info';
    $labelResponse = '@'.sanitize($filter);
}

// EOF
