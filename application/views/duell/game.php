<div id="wrapper">
  <h2 style="text-align:center;"><?php if($oGame->round == 0) echo "In&Phi;Ma-Duell"; else echo $oLevel->title;?></h2>
  <div id="screen">
    <ol id="words">
    <?php foreach($oLevel->answers as $oAnswer) : ?>
      <li id="answer-<?= $oAnswer->id ?>" word="<?= $oAnswer->title ?>" points="<?= $oAnswer->points ?>">
        <label class="solution">
          <span class="type"></span>
          <span class="placeholder">
            .............................
          </span>
        </label>
        <label class="points">--</label>
      </li>
    <?php endforeach; ?>
    </ol>
  </div>
  <div id="jquery_jplayer1"></div>
  <div id="jquery_jplayer2"></div>
</div>
  <div id="stats">
    <div id="team1">
      <div class="points"><?php echo $oPoints['team_a'];?></div>
    	<div class="miss x1">X</div>
    	<div class="miss x2">X</div>
    	<div class="miss x3">X</div>
      <div class="team_name"><?php echo $team_a;?></div>
    </div>
    <div id="team2">
      <div class="points"><?php echo $oPoints['team_b'];?></div>
    	<div class="miss x1">X</div>
    	<div class="miss x2">X</div>
    	<div class="miss x3">X</div>
      <div class="team_name"><?php echo $team_b;?></div>
    </div>
  </div>

<div id="footer">
Spiel Nr. <?= $oGame->id ?><br/>
<a href="<?= base_url() ?>duell/tool/<?php echo $oGame->session;?>">Backend</a>
</div>
