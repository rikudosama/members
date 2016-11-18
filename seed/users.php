<?php
    require '../config/database.php';
    require '../includes/functions.php';
    require '../vendor/autoload.php';


   $faker = Faker\Factory::create();

   for ($i=1; $i <=150 ; $i++) { 
   	  $query = $db->prepare('INSERT INTO users(firstname, name, pseudo, email, password, active,
   	  	                    created_at, city, country, sex, available_for_hiring, bio)
   	                        VALUES(:firstname, :name, :pseudo, :email, :password, :active,
   	                        :created_at, :city, :country, :sex, :available_for_hiring, :bio)
   	                        ');
   	  $query->execute([
   	  	            'firstname' => $faker->unique()->firstname,
   	  	            'name' =>$faker->unique()->name,
   	  	            'pseudo' => $faker->unique()->userName,
   	  	            'email' =>$faker->unique()->email,
   	  	            'password' => password_hash('123456', PASSWORD_BCRYPT),
   	  	            'active' => 1,
   	  	            'created_at' => $faker->date().' '.$faker->time(),
   	  	            'city' => $faker->city,
   	  	            'country' => $faker->country,
   	  	            'sex' => $faker->randomElement(['H'], 'F'),
   	  	            'available_for_hiring' => $faker->randomElement([0, 1]),
   	  	            'bio' => $faker->paragraph()
   	  	               ]);
   }
  echo "users added !!!!!!";
 ?>