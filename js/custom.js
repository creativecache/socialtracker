$(window).on('load', function() {
	if(!!$.cookie('instagramUser') || !!$.cookie('facebookUser') || !!$.cookie('twitterUser')) {
		$('#fc-input-screen').hide();
		runAllAccounts();
	} else {
		$('#fc-input-screen').show();
		$('#fc-screen-close').hide();
	}
});

$(document).ready(function() {

// Menu Toggle
	$('#fc-screen-menu').click(function() {
		$('#fc-input-screen').fadeIn();
		$('#fc-screen-close').show();
	});

	$('#fc-screen-close').click(function() {
		$('#fc-input-screen').fadeOut();
	});

// Cookies
	$('#fc-input-screen input[type="text"]').keypress(function(e) {
		if(e.which == 13) {
			numberOfAccounts = 0;
			inputButtonClick();
		}
	});

	$('#fc-input-screen input[type="button"]').click(function() {
		inputButtonClick();
	});

	$('#fc-clear-values').click(function(e) {
		e.preventDefault();
		$.removeCookie('facebookUser');
		$.removeCookie('instagramUser');
		$.removeCookie('twitterUser');
		hideWarning();
		numberOfAccounts = 0;
		runAllAccounts();
		$('#fc-screen-close').hide();
	});

// Input Warning
	$('#fc-input-screen input[type="text"]').click(function() {
		$('.warning').css('visibility', 'hidden').html('&nbsp;');
	});

// Input Character Restrictions
	$('.fc-social-input').keypress(function(e) {
		var keycode = (event.keyCode ? event.keyCode : event.which);
		var regex = new RegExp('[a-zA-Z0-9._/\n/]');
		var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
		if (regex.test(str) || (keycode == '13')) {
			hideWarning();
			return true;
		} else {
			e.preventDefault();
			$('.warning').css('visibility', 'visible').html('Character is not allowed!');
			return false;
		}
	});

	FB.api(
    	"/" + fbUser,
    	function (response) {
      		if (response && !response.error) {
        		/* handle the result */
      		}
    	}
	);

});

var numberOfAccounts = 0;

function instagramUser() {
	$('#instagram span').empty();
	if(!!$.cookie('instagramUser')) {
		numberOfAccounts++;
		$('#instagram').show();
		$('#instagram span').append('<a href="https://www.instagram.com/' + $.cookie('instagramUser') +'" target="_blank">@' + $.cookie('instagramUser') + '</a>');
	} else {
		$('#instagram').hide();
	}
	$('.fc-social-input input[name="instagram"]').val($.cookie('instagramUser'));
}

function facebookUser() {
	$('#facebook span').empty();
	if(!!$.cookie('facebookUser')) {
		numberOfAccounts++;
		$('#facebook').show();
		$('#facebook span').append('<a href="https://www.facebook.com/' + $.cookie('facebookUser') +'" target="_blank">@' + $.cookie('facebookUser') + '</a>');
	} else {
		$('#facebook').hide();
	}
	$('.fc-social-input input[name="facebook"]').val($.cookie('facebookUser'));
}

function twitterUser() {
	$('#twitter span').empty();
	if(!!$.cookie('twitterUser')) {
		numberOfAccounts++;
		$('#twitter').show();
		$('#twitter span').append('<a href="https://www.twitter.com/' + $.cookie('twitterUser') +'" target="_blank">@' + $.cookie('twitterUser') + '</a>');
	} else {
		$('#twitter').hide();
	}
	$('.fc-social-input input[name="twitter"]').val($.cookie('twitterUser'));
}

function inputButtonClick() {
	var fbUser = $('input[name="facebook"]').val(),
	instaUser = $('input[name="instagram"]').val(),
	twUser = $('input[name="twitter"]').val();
	$.cookie('facebookUser', fbUser);
	$.cookie('instagramUser', instaUser);
	$.cookie('twitterUser', twUser);

	if(!!$.cookie('instagramUser') || !!$.cookie('facebookUser') || !!$.cookie('twitterUser')) {
		$('#fc-input-screen').fadeOut();
		numberOfAccounts = 0;
		runAllAccounts();
		location.reload();
	} else {
		$('.warning').css('visibility', 'visible').html('Please fill in at least one username!');
		return false;
	}
}

function runAllAccounts() {
	instagramUser();
	facebookUser();
	twitterUser();
	addClasses();
	console.log(numberOfAccounts);
}

function addClasses() {
	if (numberOfAccounts == 1) {
		$('.fc-social-media').removeClass('two-social three-social');
		$('.fc-social-media').addClass('one-social');
	} else if (numberOfAccounts == 2) {
		$('.fc-social-media').removeClass('one-social three-social');
		$('.fc-social-media').addClass('two-social');
	} else if (numberOfAccounts == 3) {
		$('.fc-social-media').removeClass('one-social two-social');
		$('.fc-social-media').addClass('three-social');
	} else {
		$('.fc-social-media').removeClass('one-social two-social three-social');
	}
}

function hideWarning() {
	$('.warning').css('visibility', 'hidden').html('&nbsp;');
}