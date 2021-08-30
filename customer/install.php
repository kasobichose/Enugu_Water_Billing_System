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
CREATE TABLE users(
  id int auto_increment not null primary key,
  firstname varchar(50),
  middlename varchar(50),
  lastname varchar(50),
  userid int(11),
  billtype varchar(10),
  usgtype varchar(20),
  mntbill int(10),
  c_addr text,
  h_addr text,
  email varchar(100),
  phone varchar(255),
  password varchar(50)
  );

  CREATE TABLE banks(
  id int auto_increment not null primary key,
  bank_name varchar(50),
  pbrn varchar(50)
  );

 CREATE TABLE postpaid_invoice(
  id int auto_increment not null primary key,
  cust_name varchar(50),
  cust_id varchar(10),
  h_addr text,
  ppr varchar(10),
  month varchar(20),
  bill_amt int(6),
  bank_charges int(6),
  total_amt int(6),
  tx_status varchar(10),
  tx_date varchar(50)
  );

 CREATE TABLE prepaid_invoice(
  id int auto_increment not null primary key,
  cust_name varchar(50),
  cust_id varchar(10),
  h_addr text,
  ppr varchar(10),
  card_unit int(6),
  bank_charges int(6),
  total_amt int(6),
  tx_status varchar(10),
  tx_date varchar(50)
  );

 CREATE TABLE postpaid_receipt(
  id int auto_increment not null primary key,
  cust_name varchar(50),
  cust_id varchar(10),
  h_addr text,
  ppr varchar(10),
  month varchar(20),
  bill_amt int(6),
  bank_charges int(6),
  total_amt int(6),
  bank varchar(50),
  banker varchar(50),
  tx_date varchar(50)
  );
 CREATE TABLE prepaid_receipt(
  id int auto_increment not null primary key,
  cust_name varchar(50),
  cust_id varchar(10),
  h_addr text,
  ppr varchar(10),
  card_unit int(6),
  bank_charges int(6),
  total_amt int(6),
  bank varchar(20),
  banker varchar(100),
  cardpin int(15),
  tx_date varchar(50)
  );
");

//Here you can see login details for the banks.
//pbrn stands for PWS Bank Reference Number.

  $psd1 =   md5('XW224952');
  $psd2 =  md5('WC490163');
  $psd3 = md5('ZQ416009');
  $psd4 = md5('AC853209');

$db->query("INSERT INTO banks (bank_name,pbrn) VALUES ('UBA','$psd1')");
$db->query("INSERT INTO banks (bank_name,pbrn) VALUES ('First Bank','$psd2')");
$db->query("INSERT INTO banks (bank_name,pbrn) VALUES ('Fidelity Bank','$psd3')");
$db->query("INSERT INTO banks (bank_name,pbrn) VALUES ('Zenith Bank','$psd4')");
}
catch(PDOException $e){
  echo $e->getMessage();
}
echo "db setup successfully <a href='index.php'>Go Home</a>";
?>