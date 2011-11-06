<?php
    /* Last updated with phpFlickr 2.3.2
     *
     * Edit these variables to reflect the values you need. $default_redirect 
     * and $permissions are only important if you are linking here instead of
     * using phpFlickr::auth() from another page or if you set the remember_uri
     * argument to false.
     */
     
	if($_SERVER['DEPLOYED_ENVIRONMENT'] == "local") {
		$api_key                 = "955fca735e5786ff004677fd6a912b70";
		$api_secret              = "27dc9c6fa3937a49";	
	} elseif($_SERVER['DEPLOYED_ENVIRONMENT'] == "pagoda") {
		$api_key                 = "2347f081c76968c43df0183cce464c3e";
		$api_secret              = "17098355f61296ac";		
	}
     
    $default_redirect        = "/app";
    $permissions             = "write";
    $path_to_phpFlickr_class = "./";

    ob_start();
    require_once($path_to_phpFlickr_class . "phpFlickr.php");
	if(isset($_SESSION['phpFlickr_auth_token'])) {
		unset($_SESSION['phpFlickr_auth_token']);
	}
     
	if ( isset($_SESSION['phpFlickr_auth_redirect']) && !empty($_SESSION['phpFlickr_auth_redirect']) ) {
		$redirect = $_SESSION['phpFlickr_auth_redirect'];
		unset($_SESSION['phpFlickr_auth_redirect']);
	}
    
    $f = new phpFlickr($api_key, $api_secret);
 
    if (empty($_GET['frob'])) {
        $f->auth($permissions, false);
    } else {
        $f->auth_getToken($_GET['frob']);
	}
    
    if (empty($redirect)) {
		header("Location: " . $default_redirect);
    } else {
		header("Location: " . $redirect);
    }
 
?>