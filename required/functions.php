<?php
/*******************************************************************************
 * DEFAULT FUNCTIONS
 ******************************************************************************/

/*******************************************************************************
 * CHECK THAT PHP VERSION MEETS REQUIREMENT
 ******************************************************************************/
function check_php_version(){
    global $required_php_version, $sofware_version, $framework_name;
    
    $php_version = phpversion();
    if(version_compare($required_php_version, $php_version, '>')){
        die(sprintf('Your server is running PHP version %1$s but %2$s %3$s requires at least %4$s.', $php_version, $sofware_version, $framework_name, $required_php_version));
    }
}

/*******************************************************************************
 * CHECK THAT MYSQL IS INSTALLED
 ******************************************************************************/
function check_mysql_installed(){
    global $software_version, $framework_name;
    
    if(!extension_loaded('mysql')){
        die(sprintf('Your PHP installation appears to be missing the MySQL extension which is required by %1$s %2$s.', $framework_name, $software_version));
    }
}

/*******************************************************************************
 * TURN REGISTER GLOBALS OFF
 ******************************************************************************/
function unregister_globals(){
    if(!ini_get('register_globals'))
        return;

    if(isset( $_REQUEST['GLOBALS']))
        die('GLOBALS overwrite attempt detected');

    // Variables that shouldn't be unset
    $no_unset = array( 'GLOBALS', '_GET', '_POST', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES', 'table_prefix' );

    $input = array_merge( $_GET, $_POST, $_COOKIE, $_SERVER, $_ENV, $_FILES, isset( $_SESSION ) && is_array( $_SESSION ) ? $_SESSION : array() );
    foreach($input as $k => $v):
        if(!in_array($k, $no_unset) && isset($GLOBALS[$k]))
        {
            unset($GLOBALS[$k]);
        }
    endforeach;
}

/*******************************************************************************
 * TURN MAGIC QUOTES OFF
 ******************************************************************************/
function remove_magic_quotes(){
    if (get_magic_quotes_gpc()) {
        $process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
        while (list($key, $val) = each($process)) {
            foreach ($val as $k => $v) {
                unset($process[$key][$k]);
                if (is_array($v)) {
                    $process[$key][stripslashes($k)] = $v;
                    $process[] = &$process[$key][stripslashes($k)];
                } else {
                    $process[$key][stripslashes($k)] = stripslashes($v);
                }
            }
        }
        unset($process);
    }
}

/*******************************************************************************
 * DEFINE COOKIES
 ******************************************************************************/
function define_cookies(){
    // Username
    $u_cookie_name = sha1("USERNAME|" . AUTH_KEY . "|" . AUTH_SALT);
    define("COOKIE_USERNAME", $u_cookie_name);
    
    // Password
    $p_cookie_name = sha1("PASSWORD|" . AUTH_KEY . "|" . AUTH_SALT);
    define("COOKIE_PASSWORD", $p_cookie_name);
}

/*******************************************************************************
 * GENERATE A RANDOM SALT
 ******************************************************************************/
function generateSalt(){
    $length = 16;
    base64_encode(mcrypt_create_iv(ceil(0.75*$length), MCRYPT_DEV_URANDOM));
}

/*******************************************************************************
 * SAFELY ENCODE A STRING
 ******************************************************************************/
function safe_encode($string, $salt){
    $string = strrev($string . $salt);
    $string = sha1($string);
    return $string;
}

function check_email_exists($email){
    global $db;
    
    $db->query("
        SELECT * 
        FROM user
        WHERE user_email = :email
    ");
    
    $db->bind(':email', $email);
    
    if($result = $db->result()):
        return $result;
    else:
        return false;
    endif;
}

function check_user_exists($username){
    global $db;
    
    $db->query("
        SELECT *
        FROM user
        WHERE user_alias = :alias
    ");
    
    $db->bind(':alias', $username);
    
    if($result = $db->result()):
        return $result;
    else:
        return false;
    endif;
}