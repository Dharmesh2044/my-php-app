<?php
// Jo password aap rakhna chahte hain, yahan likhein
$my_password = "aapka_naya_password_yahan"; 

// Hash generate ho raha hai
$hashed_password = password_hash($my_password, PASSWORD_DEFAULT);

echo "Aapka Password: " . $my_password . "<br>";
echo "Database mein ye paste karein: <b>" . $hashed_password . "</b>";
?>