<?php include('partials/_nav.php');?>
<?php include('partials/_flash.php');?>

<div id="main-content">
    <div class="container">

     <h1>Liste des membres</h1>
  <?php foreach (array_chunk($members, 4) as $member_set): ?>
    <div class="row members">
     <?php foreach ($member_set as $member): ?>
       <div class="col-md-3 member-block">
         <a href="profile.php?id=<?=$member->id?>">
           <img src="<?= $member->avatar ? $member->avatar : get_avatar_url(e($member->email)) ?>" alt="<?=e($member->pseudo)?>" class="avatar img-polaroid">
         </a>
         <h4 class="member-block-membername">
           <a href="profile.php?id=<?=$member->id?>">
             <?=e($member->pseudo)?>
           </a>
         </h4>
       </div>
     <?php endforeach;?>
    </div>
  <?php endforeach;?>
    </div>
</div>

<?php include('partials/_footer.php');?>
