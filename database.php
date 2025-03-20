<?php
try{
    $pdo = new PDO('mysql:host=localhost; dbname=gestion_db','root','');
    echo("connected");
    
}catch(PDOException $e){
    echo "Database Error Connection : " . $e->getMessage();
    die();
}
?>
