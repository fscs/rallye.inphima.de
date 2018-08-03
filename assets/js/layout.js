// Duell View

$('#new_duell').bind('click',function(){
	$.post(base_url+'duell/createGame',function(response){
		var sessionID = response;
		window.location = base_url+'duell/game/'+sessionID;
		window.open(base_url+'duell/tool/'+sessionID,'_blank');
	});
});

// Duell Admin View

$('.show_answer').bind('click',function(){
	var that = $(this);
	var th = that.parents('tr');
	var answer = th.data('answer');
	var session = th.data('session');
	$.post(base_url+'duell/showAnswer/'+session+"/"+answer,function(response){
		th.find('button').prop('disabled',true);
	});
});
$('.wrong_answer').bind('click',function(){
	var that = $(this);
	var th = that.parents('tr');
	var answer = that.data('option');
	var session = that.data('session');
	$.post(base_url+'duell/showAnswer/'+session+"/"+answer);
});

$('.update_points').bind('click',function(){
	var that = $(this);
	var th = that.parents('tr');
	var answer = th.data('answer');
	var session = th.data('session');
	var team = that.data('team');
	$.post(base_url+'duell/addPoints/'+session+"/"+answer+"/"+team,function(response){
		th.find('button').prop('disabled',true);
	});
});

$('.team_selector').bind('change',function(){
	var that = $(this);
	var session = that.data('session');
	var team = that.data('team');
	var team_id = that.val();
	$.post(base_url+'duell/setTeam/'+session+"/"+team+"/"+team_id);
})