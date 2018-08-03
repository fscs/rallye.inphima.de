$(document).ready(function() {
	var current_element = null;
	var points = 0;
	var current_point = 0;
	$(".questions .tile").bind('click',function() {
		var question = $(this).find('p.question').html();
		current_element = $(this);
		//var question = '../assets/img/jeopardy/' + $(this).attr("question");
		var answer = $(this).find('p.answer').html();
		//var answer = '../assets/img/jeopardy/' + $(this).attr("answer");
		current_point = parseInt($(this).find('p.points').text());
		$(this).removeClass('tile').html('');
		$(this).unbind('click');
		$.fancybox([question,answer], {
			'padding'		: 0,
			'autoDimensions': false,
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'overlayOpacity'	: 0.95,
			'overlayColor'		: '#000',
			'changeFade'        : 0,
			'width'				: 600,
			'showNavArrows'		: false, 	
			'showCloseButton'	: false,
			'onClosed' : function() {$('#jquery_jplayer').jPlayer('stop'); $(document).unbind('keydown');}
		});
		$(document).bind('keydown', function(e) {
			var valid = 0;
			if (e.target.tagName !== 'INPUT' && e.target.tagName !== 'TEXTAREA' && e.target.tagName !== 'SELECT') {
				valid = 1;
			}
			if(e.keyCode == 75 && current_element != null){
				current_element.html('<font color="green">Korrekt!</font>');
				$.fancybox.close();
				points += current_point;
				$('#result').text(points);
			} else if((e.keyCode == 70 || e.keyCode == 85) && current_element != null){
				current_element.html('<font color="red">Falsch :(</font>');
				$.fancybox.close();
			}
			if ((e.keyCode == 37 || e.keyCode == 39) && valid) {
				$('#jquery_jplayer').jPlayer('stop');	
			} else if (e.keyCode == 80 && valid) {
				$('#jquery_jplayer').jPlayer('play');
			}
		});
	});
	$('#fancybox-right,#fancybox-left').bind('click.jd',function() {
		$('#jquery_jplayer').jPlayer('stop');
	});


	$("#jquery_jplayer").jPlayer({
		ready: function () {
			$(this).jPlayer("setMedia", {
				oga: base_url+"assets/sound/jeopardy-music.ogg"
			});
		},
 		swfPath: base_url+"assets/js",
		supplied: "oga"
	});
});
