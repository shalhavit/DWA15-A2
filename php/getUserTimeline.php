<?php
require('php-twitter-text-formatter/TwitterTextFormatter.php');
// Use the class TwitterTextFormatter
use Netgloo\TwitterTextFormatter;

// // Print each tweet using TwitterTextFormatter to get the HTML text
echo "<ul>";
foreach ($user_timeline as $user_tweet) {
    echo "<li>";
    echo TwitterTextFormatter::format_text($user_tweet) . "<br/>";

    //     // Print also the tweet's image if is set
    if (isset($user_tweet->entities->media)) {
        $media_url = $user_tweet->entities->media[0]->media_url;
        // dump($media_url);
        echo "<img src='{$media_url}' width='150px' />";
    }

    echo "</li>";
}
echo "</ul>";
