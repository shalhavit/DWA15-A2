<?php

/* Load the external library TwitterOAuth to manage the authorization
 * tasks and access to the twitter API
 */
require('twitteroauth/autoload.php');
use Abraham\TwitterOAuth\TwitterOAuth;

/* Useful tools for debug and security */
require_once('tools.php');

/*
 * Dropdown validation
 */
$arrayTweets = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10');

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

/*
 * Credentials
 * Set access tokens here - see: https://dev.twitter.com/apps/
 */
define('CONSUMER_KEY', 'UV3AWLJwI3j8oG4tPe8hSScF8');
define('CONSUMER_SECRET', 'phx2hLunL0z35Pn9LdPddsERJF1sifRR0e5GL5FSuPcwZLv6xe');
$oauth_token = "47572670-JD710GMVYP5BQkbQ9orUieBsd35Q4xf5XlL0RwUEC";
$oauth_token_secret = "3bxCHxJihBb57lQBV6ncjoU3w4gAYicr5gdtIDPxoWdCN";

/*
 * In this function we use an instance of TwitterOAuth Class to
 * open a connection, handshake credentials and obtain the methods to
 * operate on the new instance '$connection'
 */
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);

// Initial get JSON response from Twitter API
$userTimeline = $connection->get('statuses/home_timeline', array('count' => $numTweets));

// Using the filter feature to search last week tweets by user
if (isset($_GET['filter']) and ($_GET['filter']!= '')) {
    $filter = $_GET['filter'];
    $userTimeline = $connection->get('search/tweets', array('q' => $filter, 'count' => $numTweets));
    $arrayUserTimeline = json_decode(json_encode($userTimeline->statuses), true);
}
else {
    $filter = '';
    $arrayUserTimeline = json_decode(json_encode($userTimeline), true);
}

// Messages classes for css injection
if(count($arrayUserTimeline) == 0) {
    $alertType = 'alert-danger';
    $labelResponse = 'User not found or without tweets published';
} else {
    $alertType = 'alert-info';
    $labelResponse = '@'.sanitize($filter);
}

// EOF
