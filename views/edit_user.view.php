<?php include('partials/_nav.php');?>
<div id="main-content">
  <div class="container">
    <div class="row">
      <?php if(!empty($_GET['id']) && $_GET['id'] === get_session('user_id')): ?>
      <div class="col-md-6 col-md-offset-3">
         <div class="panel panel-info">
           <div class="panel-heading">
             <h3 class="panel-title">Compléter mon profile</h3>
           </div>
           <div class="panel-body">
             <?php include('partials/_errors.php');?>
             <form data-parsley-validate method="post" autocomplete="off">
               <div class="row">
                 <div class="col-md-12">
                   <div class="form-group">
                       <label for="name">Nom<span class="text-danger"> *</span></label>
                       <input type="text" name="name" class="form-control" id="name" placeholder="Ouedraogo" value="<?= get_input('name') ? get_input('name') : e($user->name); ?>" required="required" />
                    </div>
                 </div>
               </div>
               <div class="row">
                 <div class="col-md-6">
                   <div class="form-group">
                       <label for="pseudo">Pseudo<span class="text-danger"> *</span></label>
                       <input type="text" name="pseudo" class="form-control"  id="pseudo" data-parsley-trigger="change" data-parsley-minlength="3" placeholder="Naruto" value="<?= get_input('pseudo') ? get_input('pseudo') : e($user->pseudo);?>" required="required" />
                    </div>
                 </div>
                 <div class="col-md-6">
                   <div class="form-group">
                       <label for="city">Ville<span class="text-danger"> *</span></label>
                       <input type="text" name="city" class="form-control" id="city" placeholder="Paris" value="<?= get_input('city') ? get_input('city') : e($user->city);?>" required="required" />
                    </div>
                 </div>
               </div>
               <div class="row">
                 <div class="col-md-6">
                   <div class="form-group">
                       <label for="country">Pays<span class="text-danger"> *</span></label>
                       <input type="text" name="country" class="form-control" id="country" placeholder="U.S.A" value="<?= get_input('country') ? get_input('country') : e($user->country)?>" required="required" />
                    </div>
                 </div>
                 <div class="col-md-6">
                   <div class="form-group">
                       <label for="sex">Sexe<span class="text-danger"> *</span></label>
                       <select required="required" name="sex" class="form-control">
                         <option value="H" <?= $user->sex == "H" ? "selected" : "" ?>>
                           Homme
                         </option>
                         <option value="F" <?= $user->sex == "F" ? "selected" : ""?>>
                           Femme
                         </option>
                       </select>
                    </div>
                 </div>
               </div>
               <div class="row">
                 <div class="col-md-12">
                   <div class="form-group">
                     <label for="avatar">modifier mon avatar</label>
                     <input type="file" name="avatar" id="avatar" />
                   </div>
                 </div>
                 </div>
               <div class="row">
                 <div class="col-md-6">
                   <div class="form-group">
                       <label for="twitter">Twitter</label>
                       <input type="text" name="twitter" class="form-control" id="twitter" placeholder="@doe" value="<?= get_input('twitter') ? get_input('twitter') : e($user->twitter)?>" />
                    </div>
                 </div>
                 <div class="col-md-6">
                   <div class="form-group">
                       <label for="github">Github</label>
                       <input type="text" name="github" class="form-control" id="github" placeholder="doe"  value="<?= get_input('github') ? get_input('github') : e($user->github)?>"/>
                    </div>
                 </div>
                 </div>
               <div class="row">
                 <div class="col-md-12">
                   <div class="form-group">
                       <label for="available_for_hiring">
                       <input type="checkbox" name="available_for_hiring"  id="available_for_hiring" <?= $user->available_for_hiring ? "checked" : "" ?>/>
                       Disponible pour emploi ?
                       </label>
                    </div>
                 </div>
               </div>
               <div class="row">
                 <div class="col-md-12">
                   <div class="form-group">
                       <label for="bio">Biographie<span class="text-danger"> *</span></label>
                       <textarea cols="30" rows="10" name="bio" class="form-control" id="bio" placeholder="petite biographie" required="required"><?= get_input('bio') ? get_input('bio') : e($user->bio)?></textarea>
                    </div>
                 </div>
               </div>
               <button type="submit" class="btn btn-block btn-info" name="update"><span class="glyphicon glyphicon-ok-sign"></span> Valider</button>
             </form>
           </div>
         </div>
       </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<script src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="libraries/uploadify/jquery.uploadify.min.js"></script>
<script type="text/javascript" src="libraries/alertifyjs/alertify.min.js"></script>
<script src="assets/js/app.js"></script>
<script type="text/javascript" src="libraries/parsley/parsley.min.js"></script>
<script type="text/javascript" src="libraries/parsley/i18n/fr.js"></script>
 <script type="text/javascript">
 <?php $timestamp = time(); ?>
   $(function (){
    $('#avatar').uploadify({
      'fileObjName'  : 'avatar',
      'fileTypeDesc' : 'Images files',
      'fileTypeExts' : '*.gif; *.jpg; *.jpeg; *.png;',
      'buttonText'   : 'parcourir',
      'formData'      : {
          'timestamp' : '<?php echo $timestamp;?>',
          'token'     : '<?php echo md5('unique_salt' . $timestamp);?>',
          'user_id'   : '<?= get_session('user_id') ?>',
          '<?php echo session_name();?>' : '<?php echo session_id();?>'
        },
      'swf'        : 'libraries/uploadify/uploadify.swf',
      'uploader'   : 'libraries/uploadify/uploadify.php',
      'onUploadError' : function(file, errorCode, errorMsg, errorString) {
        alertify.error('Une erreur s\'est produite pendant l\'upload du fichier veillez ressayer svp..');
        },
      'onUploadSuccess' : function(file, data, response){
        alertify.success('Votre avatar a été uploadé avec succès');
        window.location = '/profile.php';
      }
     });
   });
 </script>
</body>
</html>
