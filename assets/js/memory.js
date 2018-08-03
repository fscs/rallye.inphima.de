var gameStarted = 0;
var foundPairs = 0;
var madeErrors = 0;
var status = 0;
var tile1;
var tile2;
$.fn.handleClick = function(clickedTile) {
	if (gameStarted == 0) {
		$('#gameCountdown').countdown('resume');
		gameStarted = 1;
	}
	if (status == 0) {
		clickedTile.unbind('click');
		clickedTile.removeClass('closed').addClass('open');
		tile1 = clickedTile;
		status = 1;
	} else if (status == 1) {
		clickedTile.unbind('click');
		clickedTile.removeClass('closed').addClass('open');
		tile2 = clickedTile;
		if (tile1.attr('tile') == tile2.attr('tile')) {
			// match found
			foundPairs++;
			$('#foundPairs').html(foundPairs);
			if (foundPairs == totalPairs) {
				showWinScreen();
			}
			status = 0;
		} else {
			// not a match
			$('.tile.closed').unbind('click');
			madeErrors++;
			$('#madeErrors').html(madeErrors);
			setTimeout("$('#errorButton').trigger('click');", 500);
			setTimeout(closeTiles,2000);
			setTimeout("$.fancybox.close();",3000);
			status = 0;
		}
	}

};

function showWinScreen() {
	periods = $('#gameCountdown').countdown('getTimes');
	$('#gameCountdown').countdown('pause');
	secondsleft = periods[5]*60 + periods[6];
	totalPoints = foundPairs * 100 + 99 - madeErrors + 10 * secondsleft;
	$('#win_points').html(totalPoints);
	$('#win_timeleft').html(secondsleft);
	$('#win_errors').html(madeErrors);
	$("#winButton").trigger('click');
	$('#save_result').data('points',totalPoints);
}

function showLoseScreen() {
	$('.tile').unbind('click');
	totalPoints = foundPairs * 100 + 99 - madeErrors;
	$('#lose_points').html(totalPoints);
	$('#lose_errors').html(madeErrors);
	$('#lose_pairs').html(foundPairs);
	$("#loseButton").trigger('click');
	$('#save_result').data('points',totalPoints);
}

function closeTiles() {
	tile1.addClass('closed');
	tile2.addClass('closed');
	$('.tile.closed').bind('click', function() {
		$.fn.handleClick($(this))
	});
	tile1 = false;
	tile2 = false;
}

$(document).ready(function() {
	$('#gameCountdown').countdown({until: +totalTime, format: 'MS', layout:'<strong>{mnn}:{snn} {ml}</strong>',onExpiry: showLoseScreen});
	$('#gameCountdown').countdown('pause');
	$('.tile.closed').bind('click', function() {
		$.fn.handleClick($(this));
	});
	$('.close-fb').bind('click', function() { $.fancybox.close(); return false;});
	$('.close-fb.restart').bind('click', function() { $.fancybox.close(); window.location.href = window.location.href;});
	$(".fancybox").fancybox({'padding': 20,'hideOnOverlayClick':false,'showCloseButton':false});	
	$('#save_result').bind('click',function(){window.location.href = $(this).data('url') + $(this).data('points')})
});
