$(document).ready(function() {
	var placeholder = '....................................';
	var fehler1 = 0;
	var fehler2 = 0;

	$.fn.updateAnswers = function() {
		$.get(base_url+'duell/answer/'+ session_id, {dataType: "xml"}, function(data) {
			var xml = $(data);
			if(xml.find('show').length){
				var show = xml.find('show').text();
				if(show == -1 || show == -2){
					$('#jquery_jplayer2').jPlayer('play');
					if (show == -1) {
						fehler1++;
						$('#team1 .x' + fehler1).addClass('red');
					} else {
						fehler2++;
						$('#team2 .x' + fehler2).addClass('red');
					}
				}
				else if (show == -3){
					window.location.href = window.location.href;
				}
				else{
					var answer = show;
					$('#jquery_jplayer1').jPlayer('play');
					var solution = $('#answer-' + answer).attr('word');
					var points = $('#answer-' + answer).attr('points');
					$('#answer-' + answer + ' label.solution span.placeholder').html(placeholder.substr(0,28-solution.length));
					$('#answer-' + answer + ' label.solution span.type').html(solution).typewriter(500, function() {
						setTimeout("$('#answer-" + answer + " label.points').html(" + points + ").show().typewriter(400)",500);
					});
					setTimeout(function(){
						if(xml.find('points_a').length){
							$('#team1 .points').html(xml.find('points_a').text());
						}
						if(xml.find('points_b').length){
							$('#team2 .points').html(xml.find('points_b').text());
						}
					},1400);

				}
			}
		});
	}
	setInterval($.fn.updateAnswers, 3000);

	$("#jquery_jplayer1").jPlayer({
		ready: function () {
			$(this).jPlayer("setMedia", {
				oga: base_url+"assets/sound/duell-show.ogg"
			});
		},
 		swfPath: "/assets/js",
		supplied: "oga"
	});
	$("#jquery_jplayer2").jPlayer({
		ready: function () {
			$(this).jPlayer("setMedia", {
				oga: base_url+"assets/sound/duell-blank.ogg"
			});
		},
 		swfPath: "/assets/js",
		supplied: "oga"
	});

});