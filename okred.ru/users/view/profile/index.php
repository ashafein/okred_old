<div class="profile">
  <div class="avatar">
    <img border="0" alt="" src="/_images/logowithbg.png">
  </div>
  <div class="info"> 

   <h1>
    <a href="/users/profile/<?php echo $user['nickname'] ?>">
      <?php echo $user['nickname'] ?>
      <?php if(!empty($user['gender'])): ?>
      <img src="/_images/<?php echo (strpos($user['gender'], "Муж") === false)?'gender_woman':'gender_man' ?>.png">
    <?php endif; ?>
  </a> 
</h1>
Имя: 
<?php echo !empty($user['fio'])?$user['fio']:'<не указано>' ?>
<br/>
Телефон: 
<?php echo !empty($user['telephone'])?$user['telephone']:'<не указан>' ?>
<br/>
</div>
<br class="clear">

</div>