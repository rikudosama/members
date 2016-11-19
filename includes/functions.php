<?php

//function to sanitize an user input
//fonction d'echapement de code
if (!function_exists('e')) {
	
	function e($string){
      
       if($string){
           return htmlspecialchars($string);
       }
	}
}


//function tout say hello tout the members about the time
//fonction qui salut les membres selon le temps qu'il fait

if(!function_exists('say_hello')){
  function say_hello() {
  $hour = date("H");
   global $db;
  $query = $db->prepare("SELECT name
                          FROM members 
                          WHERE pseudo = :pseudo
                        ");
    $query->execute([
    'pseudo' => $_SESSION['pseudo']
    ]);
    $reponse = $query->fetch();
      $nom = $reponse['name'];
      if ($hour >= 0 && $hour <= 18) {
      echo 'Salut '. $nom ;
      }
      elseif($hour > 18 && $hour <= 23) {
      echo'Bonsoir '. $nom ;
      }
    }
}


//cell count funtion
//retourne le nombre d'enregistrement trouver en respectant une certaine condition
if (! function_exists('cell_count')) {
  
  function cell_count($table, $field_name, $field_value){
      
      global $db;

      $query = $db->prepare("SELECT * FROM $table WHERE $field_name = ?");
      $query->execute([$field_value]);

      return $query->rowCount();
  }
}

//funtion remember_me
if (! function_exists('remember_me')) {
  
  function remember_me($user_id){

    global $db;
      
  //gener un token de mamière aleatoire
  $token = openssl_random_pseudo_bytes(24);
    //generer un selecteur de manirere aleatoire
    // et s'assurer que ce dernier est unique
  do{
     $selector = openssl_random_pseudo_bytes(9);
   }while (cell_count('auth_tokens', 'selector', $selector) > 0);
    //sauvegarder ces infos (user_id, expires(14 jours), token(hashed))
    //en bdd
   $query = $db->prepare("INSERT INTO auth_tokens(expires, selector, user_id, token)
                         VALUES (DATE_ADD(NOW(), INTERVAL 14 DAY), :selector, :user_id, :token)");
   $query->execute([
          'selector' => $selector,
          'user_id' => $user_id,
          'token' => hash('sha256', $token)
    ]);
    //créer un cookie 'auth'(14 jrs expires) httponly=>true
    //contenu: base64_encode(selector).':'.base64_encode(token)
   setcookie('auth', 
    base64_encode($selector).':'.base64_encode($token), 
    time()+1209600, 
    null, 
    null, 
    false, 
    true
    );
  }
}
//auto login funtion
if (! function_exists('auto_login')) {
  
  function auto_login(){
    global $db;
      //on verifie d'abord si le cookie auth exists
       if (! empty($_COOKIE['auth'])) {
            $split = explode(':', $_COOKIE['auth']);
            if(count($split) !== 2){
                return false;
            }
       
       //on recupère via ce cookie le $selector, le $token
            list($selector, $token) = $split;
            
            $query = $db->prepare('SELECT auth_tokens.token, auth_tokens.user_id, 
                                   members.id, members.pseudo, members.avatar, members.email
                                   FROM auth_tokens
                                   LEFT JOIN members
                                   ON auth_tokens.user_id = members.id
                                   WHERE selector = ? AND expires >= CURDATE()');
            $query->execute([base64_decode($selector)]);

            $data = $query->fetch(PDO::FETCH_OBJ);
            
            if($data){
                if(hash_equals($data->token, hash('sha256', base64_decode($token)))){
                  session_regenerate_id(true);

                  $_SESSION['user_id'] = $data->user_id;
                  $_SESSION['pseudo'] = $data->pseudo;
                  $_SESSION['avatar'] = $data->avatar;
                  $_SESSION['email'] = $data->email;

                  return true;
                }
            }
       }
    
    return false;
  }
}
//fonction de redirection amical
//function to redirect the member intention page
if (! function_exists('redirect_intent_or')) {
  
  function redirect_intent_or($default_url){
      
       if($_SESSION['forwarding_url']){
          $url = $_SESSION['forwarding_url'];
       }else{
        $url = $default_url;
       }

    $_SESSION['forwarding_url'] = null;
    redirect('$url');
  }
}


//check if an user is connected
if (! function_exists('is_logged_in')) {
  function is_logged_in(){
    return isset($_SESSION['user_id']) || isset($_SESSION['pseudo']);
  }
}

//get a session value by key
if (! function_exists('get_session')) {
  
  function get_session($key){
      
       if($key){
            return !empty($_SESSION[$key])
             ? e($_SESSION[$key])
            : null;
       }
  }
}

//hash password with blowfish algorithm
if (! function_exists('bcrypt_hash_password')) {
  
  function bcrypt_hash_password($value, $options = array()){
      
       $cost = isset($options['rounds']) ? $options['rounds'] : 10;

       $hash = password_hash($value, PASSWORD_BCRYPT, array('cost' => $cost));

       if ($hash === false) {
         throw new Exception("Brcrypt hash pas supporté.");
         
       }
       return $hash;
  }
}

//Bcrypt verify password
if(! function_exists('bcrypt_verify_password')){
  function bcrypt_verify_password($value, $hashedValue){
    return password_verify($value, $hashedValue);
  }
}

//get avatar url
 if (!function_exists('get_avatar_url')) {
    function get_avatar_url($email){
      return "http://gravatar.com/avatar/".md5(strtolower(trim(e($email))));
    }
 }


//find an user by his id
 //retrouver un membre grace à son Id
if (! function_exists('find_user_by_id')) {
  
  function find_user_by_id($id){
      global $db;

     $query = $db->prepare('SELECT id, name, pseudo, email, city, country, sex, twitter, github, available_for_hiring, bio,avatar FROM members WHERE id = ?');
     $query->execute([$id]);

     $data = $query->fetch(PDO::FETCH_OBJ);

     $query->closeCursor();

     return $data;
  }
}


//la fonction "n'est pas vide" verifie si les champs ont été remplis.
if (! function_exists('not_empty')) {
	
	function not_empty($fields = []){
      
       if (count($fields) != 0) {
       	foreach ($fields as $field ) {
       		if (empty($_POST[$field]) || trim($_POST[$field]) == "") {
       			return false;
       		}
       	}
       	return true;
       }
	}
}

//the functiun that verify if a given email and pseudo are not always in use
//la fonction l'élément est "déja utilisé" elle verifie si les emails et pseudo ne sont pas deja utilisé par d'autres membres.
if (!function_exists('is_already_in_use')) {
	function is_already_in_use($field, $value, $table){
		global $db;

		$q = $db->prepare("SELECT id FROM $table WHERE $field = ?");
		$q->execute([$value]);

		$count = $q->rowCount();

		$q->closeCursor();

		return $count;
	}
}

//the function display the flash messages
//la fonction qui affiche les messages flash
if (!function_exists('set_flash')) {
    	function set_flash($message, $type = 'info'){
    		$_SESSION['notification']['message'] = $message;
    		$_SESSION['notification']['type'] = $type;
    	}
    }

//the function that redirect to a given link
//la function pour redirger les membres à un liens donné
 if (! function_exists('redirect')) {
 	function redirect($page){
 		header('location: ' .$page);
 		exit();
 	}
 }

//function save the input data in a session
//fonction qui enregistre les informations entrées en session
if (! function_exists('save_input_data')) {
  function save_input_data(){
    foreach ($_POST as $key => $value) {
      if (strpos($key, 'password') === false) {

          $_SESSION['input'][$key] = $value;
      }
        
    }
  }
 }

//function to get the sessions information(from save_input_data function)
//fonction qui recupère les information garder en session(depuis save_input_data)
 if (! function_exists('get_input')) {

       function get_input($key){
    
    return !empty($_SESSION['input'][$key])

    ? e($_SESSION['input'][$key])
    : null;
  }
}

//function to clear the input datas
//function pour effacer les infos entrées
  if(!function_exists('clear_input_data')) {

      function clear_input_data(){

        if(isset($_SESSION['input'])) {

           $_SESSION['input'] = [];
        }
      }
  }