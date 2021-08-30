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



  //authenticate user login
  function auth_admin($username,$password){
	   if($username == '' || $password== ''){
		   return false;
		 }
		 $db = $GLOBALS['db'];
     $stmt = $db->prepare('SELECT password FROM admins WHERE username = :username');
			$stmt->execute(array(':username' => $username));
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
  function login($username,$password){
     $exp = 60*30;//set the cookie expiration to 30 minutes for security
     set_pws_cookie('admin',$username,$exp);
     $_SESSION['admin'] = $username; 
     redirect("index.php");
    
  }

  

  function logout(){
	  //set $exp to negative sets the back in time, which means it is expired.
    session_destroy();
    set_pws_cookie('admin','invalid',-3600);
    session_destroy();
    redirect("index.php");
  
}


  
  //set an md5 hashed cookie to provide basic security
  function set_pws_cookie($name,$cookieData,$exp){
    $hashedCookie = md5($cookieData);
    setcookie($name,$hashedCookie,time()+$exp);
  }


  function is_logged_in(){
    if(isset($_SESSION['admin'])){
       return true;
    }
	else{
	   return false;
	}
  }

  //check whether is logged in, to restrict access to other pages
  function check_login(){
    if(is_logged_in()){
       //continue
    }
	else{
	    redirect("login.php");
	}
  }


?>