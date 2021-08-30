<?php
ob_start();
session_start();

define('DBHOST','localhost');
define('DBUSER','root');
define('DBPASS','');
define('DBNAME','pws');
//set the bank charges for payment
define('BANKCHARGES',100);

$db=new PDO("mysql:host=".DBHOST.";
    dbname=".DBNAME,DBUSER,DBPASS);
$db->setAttribute(PDO::ATTR_ERRMODE,
    PDO::ERRMODE_EXCEPTION);
 
/*This function is a native function that auto-loads a class without 
 *the need to manually include the class file.Here youset up the
 look up dirs for auto classloading
*/
function __autoload($class){
  $class=strtolower($class);
  $classpath="controllers/".$class.".php";
  if(file_exists($classpath)){
    require_once $classpath;
    }
  }
if(isset($_SESSION['userid'])){
	$userid = $_SESSION['userid'];
    $stmt = $db->prepare('SELECT firstname FROM users WHERE userid = :userid');
    $stmt->execute(array(':userid' => $userid));
    $row =  $stmt->fetch();
	$_SESSION['username'] = $row['firstname'];
}
?>
