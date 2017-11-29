<?php

	$user_name = 'Creative Cache';
	$insta_username = $_COOKIE['instagramUser'];
	$fb_username = 'thecreativecache';
	$tw_username = $_COOKIE['twitterUser'];

	$insta_data = file_get_contents('https://www.instagram.com/'.$insta_username);
	preg_match('/\"followed_by\"\:\s?\{\"count\"\:\s?([0-9]+)/', $insta_data ,$m);
	$insta_followers = number_format($m[1]);

	$fb = @json_decode(file_get_contents('https://graph.facebook.com/'.$fb_username));
	$fb_fans = number_format($fb->fan_count);

	// Twitter Followers Count
	$url = "https://twitter.com/".$tw_username;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	$data = curl_exec($ch);
	curl_close($ch);
	$pattern = "/followers_count&quot;:(\d+),&quot;/";
	if(preg_match($pattern, $data, $count)) {
		$tw_followers = number_format($count[1]);
	}

?>