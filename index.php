<!DOCTYPE html>
<html lang="en-US">
<head>
	<title>Creative Cache Social Tracker</title>
	<meta charset="UTF-8" />
	<meta name="author" content="Creative Cache" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

	<!-- CSS Styles -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat|Open+Sans" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/styles.css" />

	<!-- Scripts -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="js/jquery.cookie.js"></script>
	<script src="js/custom.js"></script>
</head>
<body>
	<?php
		error_reporting(0);

		$user_name = 'Creative Cache';
		$insta_username = $_COOKIE['instagramUser'];
		$fb_username = $_COOKIE['facebookUser'];
		$tw_username = $_COOKIE['twitterUser'];

		//Instagram Folowers Count
		$insta_data = file_get_contents('https://www.instagram.com/'.$insta_username);
		preg_match('/\"followed_by\"\:\s?\{\"count\"\:\s?([0-9]+)/', $insta_data ,$m);
		$insta_followers = number_format($m[1]);

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

		//Facebook Followers Count
		$access_token = '1844366165817582|C6NPFF-0oweBQ-rZlBCLkJFDK7c';
		$appid = '1844366165817582';
		$appsecret = '286d4ba3798375e3147a4bf58873a7ae';

		if ($fb_username == null) {

		} else {
			$result = json_decode(file_get_contents('https://graph.facebook.com/'.$fb_username.'?fields=fan_count&access_token=1844366165817582|C6NPFF-0oweBQ-rZlBCLkJFDK7c'));
			if($result->fan_count) {
				$fb_fans = $result->fan_count;
			} else {
				$fb_fans = 0;
			}
		}

	?>

	<table id="fc-input-screen">
		<tr>
			<td>
				<h3>Add Social Usernames</h3>
				<span class="warning">&nbsp;</span>
				<div class="fc-social-input">
					<i class="fa fa-instagram fa-fw" aria-hidden="true"></i>
					<input type="text" name="instagram" placeholder="creative.cache" pattern="[A-Za-z0-9._]" />
				</div>
				<div class="fc-social-input">
					<i class="fa fa-facebook fa-fw" aria-hidden="true"></i>
					<input type="text" name="facebook" placeholder="thecreativecache" />
				</div>
				<div class="fc-social-input">
					<i class="fa fa-twitter fa-fw" aria-hidden="true"></i>
					<input type="text" name="twitter" placeholder="creative_cache" />
				</div>
				<input type="button" name="submit" value="Submit" /><br/>
				<a href="" id="fc-clear-values">Clear Stored Usernames</a>
				<div id="fc-screen-close">
					<i class="fa fa-times fa-fw" aria-hidden="true"></i>
				</div>
			</td>
		</tr>
	</table>

	<table id="fc-main-container">
		<tr>
			<td class="fc-social-media" id="instagram">
				<table>
					<tr>
						<td>
							<h2><i class="fa fa-instagram" aria-hidden="true"></i></h2>
							<p><?php print($insta_followers);?></p>
							<span></span>
						</td>
					</tr>
				</table>	
			</td>
			<td class="fc-social-media" id="facebook">
				<table>
					<tr>
						<td>
							<h2><i class="fa fa-facebook" aria-hidden="true"></i></h2>
							<p><?php print intval($fb_fans);?></p>
							<span></span>
						</td>
					</tr>
				</table>
			</td>
			<td class="fc-social-media" id="twitter">
				<table>
					<tr>
						<td>
							<h2><i class="fa fa-twitter" aria-hidden="true"></i></h2>
							<p><?php print($tw_followers);?></p>
							<span></span>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<div id="fc-screen-menu">
		<i class="fa fa-bars fa-fw" aria-hidden="true"></i>
	</div>
</body>
</html>