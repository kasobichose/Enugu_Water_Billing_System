<?php
  //a library of commonly used functions through this program

  /*holds current page the user is in
  *Global variables have global scope throughout the program
  *Make the homepage the default page
  */
  $GLOBALS['page'] = "index";

 // set user current page
 function set_page($page){
	 $GLOBALS['page'] = $page;
  }

  function set_msg($msg){
    $_SESSION['msg'] = $msg;
  }

  function get_page(){
    return $GLOBALS['page'];
  }

  function get_msg(){
  	if(isset($_SESSION['msg'])){
      return $_SESSION['msg'];
    }
    else{
    	return "";
    }
  }

 function load_header(){
	  require("views/tpl.header.php");
	  }
	
	function load_footer(){
	  require("views/tpl.footer.php");
	}
	
	function load_page(){
		$page = get_page();
		require_once("views/tpl.".$page.".php");
}
	function render_page(){
		 load_header();
		 load_page();
    load_footer();
	}
	
	function redirect($page){
	  header("Location:$page");
	  exit;
	}
	
	
	/*This function prevents SQL injection and XSS attack by
	* stripping the user input of slashes and tags which can
	* be used for these attacks
	*/
  function clean_inputs(){
    if(get_magic_quotes_gpc()){
      $in = array(&$_GET, &$_POST, &$_COOKIE, &$_SESSION);
      while(list($k,$v) = each($in)){
        foreach($v as $key => $val){
          if(!is_array($val)){
            $in[$k][$key] = stripslashes(striptags($val));
            continue;
          }
          $in[] = & $in[$k][$key];
        }
      }
    }
    unset($in);
  }

  function gen_userid(){
	    while(true){
	    	//generate a random six digit id  and check if no user already has the id
	    	$userid = mt_rand(111111,999999);
	    	if(userid_valid($userid)){
	    		break;
	    	}
	    }  
	    return $userid;
	}

  function userid_valid($id){
   	   $stmt = $GLOBALS['db']->prepare('SELECT userid FROM users WHERE userid = :userid');
	   $stmt->execute(array(':userid' => $id));
			if($stmt->rowCount()>0){
				//id already in use
				return false;
			}
			else{
				return true;
			}
   }

  function gen_password(){
	  $length = 8;
	  $password ="";
	  $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	  for($i=0;$i<$length;$i++){
		 //select a random char from $chars and append to $password
	    $password.=$chars[mt_rand(0,strlen($chars)-1)];
	 }
	 return $password;
	}

  //authenticate user login
  function auth_user($userid,$password){
	   if($userid == '' || $password == ''){
		   return false;
		   }
	   //check if user is prepaid customer
		  $db = $GLOBALS['db'];
          $stmt = $db->prepare('SELECT password FROM users WHERE userid = :userid');
			$stmt->execute(array(':userid' => $userid));
			if($stmt->rowCount()>0){
			  $row = $stmt->fetch();
			  if(md5($password)==$row['password']){
				  return true;
				}
			  else{
			    return false;
			  }
			}
			else{
			  return false;
			}
		
  }

   //login user for 1 year.
  function login($userid){
     $exp = 60*60*24*366; //set the cookie expiration to a year
     set_pws_cookie('userid',$userid,$exp);
     $_SESSION['userid'] = $userid; //set the session so we can track user actions.
     redirect("index.php");
    
  }

  function logout(){
	  //set $exp to negative sets the back in time, which means it is expired.
    session_destroy();
    set_pws_cookie('userid','invalid',-3600);
    redirect("index.php");  
}

  //set an md5 hashed cookie to provide basic security
  function set_pws_cookie($name,$cookieData,$exp){
    $hashedCookie = md5($cookieData);
    setcookie($name,$hashedCookie,time()+$exp);
  }

  //check whether is logged in, to restrict access to certain pages
  function is_logged_in(){
    if(isset($_SESSION['userid'])){
	    return true;
	  }
	  else{
	    return false;
	  }
  }
   function gen_ppr(){
     while(true){
	    	$ppr = temp_ppr();
	    	if(ppr_valid($ppr)){
	    		break;
	    	}
	 }  
	 return $ppr;
	}


   function temp_ppr(){
	 $ppr ="";
	 $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	 for($i=0;$i<2;$i++){
	    $ppr.=$chars[mt_rand(0,strlen($chars)-1)];
	 }

	 $nums = "0123456789";
	 for($i=0;$i<6;$i++){
	    $ppr.=$nums[mt_rand(0,strlen($nums)-1)];
	 }
	 return $ppr;
  }


  function ppr_valid($ppr){
  	   $db = $GLOBALS['db'];
   	   $stmt = $db->prepare('SELECT ppr FROM prepaid_invoice WHERE ppr = :ppr');
	    $stmt->execute(array(':ppr' => $ppr));
			 if($stmt->rowCount()>0){
				//id already in use
				return false;
			}
			else{
				return true;
			}
   }


?>