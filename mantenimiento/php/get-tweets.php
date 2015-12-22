<?php
require_once("twitteroauth/twitteroauth/twitteroauth.php"); //Path to twitteroauth library
 
$twitteruser = "@icemd";
$notweets = 30;
$consumerkey = "BVZ77ZuD1nDs7jEsRFYNDA";
$consumersecret = "xV5K4MwSL366zRTEsFzRVwnc6aHiaPO4wWVYFYCwQ";
$accesstoken = "1562505392-aLJFz1sy6ZNUMid8H1TyNUY7hkoxkSqmcKNymel";
$accesstokensecret = "TM5cLPTQ717NnzoW8UZKIPG6FjgwSjwBvJFWvyijFT8";
 
function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
  $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
  return $connection;
}
 
$connection = getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
 
$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitteruser."&count=".$notweets);
 
echo json_encode($tweets);
?>