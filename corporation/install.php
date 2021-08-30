<?php
//create conn to db. Make sure you have a db 'pws'.
// Change db login details if the are not the default given here.
define('DBHOST','localhost');
define('DBUSER','root');
define('DBPASS','');
define('DBNAME','pws');
$db=new PDO("mysql:host=".DBHOST.";
    dbname=".DBNAME,DBUSER,DBPASS);
$db->setAttribute(PDO::ATTR_ERRMODE,
    PDO::ERRMODE_EXCEPTION);


try{
$db->query("
  CREATE TABLE admins(
  id int auto_increment not null primary key,
  username varchar(50),
  password varchar(50)
  )");
  $usr = "Admin";
  $psd =   md5('Admin');
$db->query("INSERT INTO  admins(username,password) VALUES('$usr','$psd')");
}
catch(PDOException $e){
  echo $e->getMessage();
}
echo "Admin db setup successfully <a href='index.php'>Go Home</a>";
?>