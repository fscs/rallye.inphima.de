<div class="col-lg-12">
  <?php
  if($oGame->round > 0 ){
  ?>
  <h3><?= $oLevel->title ?></h3>
  <table class="table">
  <tr><th>Antwort</th><th>Punkte</th><th>Punkte</th></tr>
  <?php foreach ($oLevel->answers as $oAnswer) : ?>
  <tr data-answer="<?= $oAnswer->id ?>" data-session="<?= $oGame->session ?>">
   <td><?= $oAnswer->title ?></td>
    <td><?= $oAnswer->points ?></td>
    <td>
      <button data-team="a" type="button" class="btn btn-success update_points" <?php if($oAnswer->played) echo"disabled='disabled'";?>>Team A</button>
      <button data-team="b" type="button" class="btn btn-success update_points" <?php if($oAnswer->played) echo"disabled='disabled'";?>>Team B</button>
      <!--<button data-team="c" type="button" class="btn btn-success update_points">Team A&amp;B</button>-->
      <button type="button" class="btn btn-info show_answer" <?php if($oAnswer->played) echo"disabled='disabled'";?>>auflösen</button>
    </td>
  </tr>
  <?php endforeach; ?>
  </table>
<?php
}
else{
?>
  <h3>Spielvorbereitungen</h3>
<?php
}?>
</div>
<div class="col-lg-6">
<table>
  <tr>
      <th style="text-align:center;">Team A</th>
      <th></th>
      <th style="text-align:center;">Team B</th>
  </tr>
  <?php
  if($oGame->round > 0 ){
  ?>
  <tr>
    <td>
      <button type="button" class="btn btn-danger wrong_answer" data-option="-1" data-session="<?= $oGame->session ?>">falsche Antwort</button>
    </td>
    <td>
    <--->
    </td>
    <td>
      <button type="button" class="btn btn-danger wrong_answer" data-option="-2" data-session="<?= $oGame->session ?>">falsche Antwort</button>
    </td>
  </tr>
  <?php
  }
  else{
  ?>
  <tr>
    <td>
      <select data-team="a" data-session="<?= $oGame->session ?>" class="team_selector">
        <option value="">bitte wählen</option>
        <?php foreach ($aNewGroups as $oGroup) : ?>
          <option value="<?= $oGroup->id ?>"><?= $oGroup->name ?></option>
        <?php endforeach; ?>
      </select>
    </td>
    <td></td>
    <td>
      <select data-team="b" data-session="<?= $oGame->session ?>" class="team_selector">
        <option value="">bitte wählen</option>
        <?php foreach ($aNewGroups as $oGroup) : ?>
          <option value="<?= $oGroup->id ?>"><?= $oGroup->name ?></option>
        <?php endforeach; ?>
      </select>
    </td>
  </tr>
  <?php
  }
  ?>
</table>
</div>
<div class="col-lg-6">
  <table>
<tr>
  <th>Runde:</th>
  <td><?php echo $oGame->round;?> / 15 </td>
</tr>
<tr>
<td colspan="2">
<form action="<?= base_url() ?>duell/tool/<?= $oGame->session?>" method="POST">
  <input type="hidden" value="-3" name="show_answer">
  <?php
  if($oGame->round > 0 && $oGame->round < 15){
  ?>
  <input type="submit" class="btn btn-info" value="zum n&auml;chsten Level">
  <?php
  }
  elseif($oGame->round >= 15){
  ?>
  <button class="btn" disabled="disabled">Spiel zuende</button>
  <?php
  }
  else{
  ?>
  <input type="submit" class="btn btn-info" value="Spiel starten">
  <?php
  }
  ?>
</form>
</td>
</tr>
</table></div>
