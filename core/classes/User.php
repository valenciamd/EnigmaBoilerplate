<?php
/***************************************************************************************************
 * USER CLASS
 ***************************************************************************************************
 * Handles the creation and actions of all users.
 * 
 * Each user has their own instance of the User class as well as a PHP Session and (optionally)
 * two validation Cookies, which are set on login.
 **************************************************************************************************/

class User{
    private $id;
    private $name;                                                                                  // User's Full Name
    private $email;                                                                                 // User's Email Address
    private $alias;                                                                                 // User's Alias (Username)
    private $loggedIn = false;                                                                      // User's Login Status (Default : false)
    private $admin = false;                                                                       // Is User Admin? (Default : false)
    
    private $error = false;                                                                         // User Error Handler (Default : false)
    
    
    public function __construct() {                                                                 /* Constructor Function */
        if(!$this->checkSession())                                                                  // Check if User's Details are stored in a PHP Session
            $this->checkCookies();                                                                  // Check if User's Details are stored in a PHP Cookie
    }
    
    public function checkSession(){                                                                 /* Check Session Function */
        if(isset($_SESSION['user'])):                                                               // If User Session has been set
            $this->assignData($_SESSION['user']);                                                   // Assign data stored in User Session to the User Object
            return true;                                                                            // @return True
        else:                                                                                       // If User Session has not been set
            return false;                                                                           // @return false
        endif;
    }
    
    public function checkCookies(){                                                                 /* Check if User Cookies have been stored */
        if(isset($_COOKIE[COOKIE_USERNAME]) && isset($_COOKIE[COOKIE_PASSWORD])):                   // If Username and Password Cookies are set
            $this->loginWithCookies();                                                              // Log user in using Cookies
        else:                                                                                       // If Username and Password Cookies are not set
            return false;                                                                           // @return false
        endif;
    }
    
    public function isLoggedIn(){                                                                   /* Return Login Status of User */
        return $this->loggedIn;                                                                     // @return boolean
    }
    
    public function assignData(array $data){                                                        /* Assign data to User Object from Array */
        if(is_array($data)):                                                                        // If Data is an Array
            $this->id       = $data['user_id'];
            $this->name     = $data['user_name'];                                                       // Assign Name from Data
            $this->email    = $data['user_email'];                                                     // Assign Email from Data
            $this->alias    = $data['user_alias'];                                                     // Assign Alias from Array
            $this->loggedIn = true;                                                                 // Set Logged in to True
            $_SESSION['user'] = array(                                                              // Assign data to PHP Session
                'user_id'       => $this->id,
                'user_name'     => $this->name,
                'user_email'    => $this->email,
                'user_alias'    => $this->alias
            );
        else:                                                                                       // If Data is not an Array
            return false;                                                                           //@return false
        endif;
    }
    
    public function loginWithCookies(){
        global $db;                                                                                 // Include Database instance
        $username = $_COOKIE[COOKIE_USERNAME];                                                      // Get Username from Encoded Cookie
        $pass = $_COOKIE[COOKIE_PASSWORD];                                                          // Get Encoded Password from Encoded Cookie
        $db->query("
            SELECT * 
            FROM user                                          
            WHERE username = :user 
            AND password = :pass
        ");
        $db->bind(':user', $username);                                                              // Bind Username to query
        $db->bind(':pass', $pass);                                                                  // Bind Password to query
        $this->assignData($db->result());                                                           // Get data from a single result
    }
    
    public function login(array $details){                                                          /* Login from form */        
        $username = $details['srnm'];                                                               // Retrieve Username from Details
        $pass = $details['psswrd'];                                                                 // Retrieve Password  from Details
        if($user = check_user_exists($username)):                                                   // If the user exists in the database
            $salt = $user['user_salt'];                                                             // Get the Stored Salt
            $pass = safe_encode($pass, $salt);                                                      // Encode Username with Stored Salt
            if($pass === $user['user_pass']):                                                       // If Encoded Password matches Stored Password
                $this->assignData($user);                                                           // Assign Stored Data to User Object
                if($details['set_cookies'] == true):                                                // If User has clicked "Keep me logged in"
                    $this->setCookies($user['user_alias'], $pass);                                  // Assign Login Details to Secure Cookies
                endif;
            else:                                                                                   // If Encoded Password does not match Stored Password
                $this->error = new Error('Login', 'Your Password appears to be incorrect');         // Throw new Error
            endif;
        else:
            $this->error = new Error('Login', 'Your Username appears to be incorrect');
        endif;
    }
    
    public function register(array $details){
        global $db;                                                                                 // Include Database instance
        if(!check_email_exists($details['email'])):                                                                  // If user's email address is unique
            $db->query("
                INSERT INTO user 
                (user_name, user_email, user_alias, user_pass, user_salt) 
                VALUES (:name, :email, :alias, :pass, :salt)
            ");
            $salt = generateSalt();                                                                 // Generate a random salt
            $db->bind(':name', $details['nm']);                                                     // Bind Name to query
            $db->bind(':email', $details['ml']);                                                    // Bind Email to query
            $db->bind(':alias', $details['srnm']);                                                  // Bind Username to query
            $db->bind(':pass', safe_encode($details['psswrd'], $salt));                             // Encode password with generated salt (cannot be reversed)
            $db->bind(':salt', $salt);                                                              // Add salt into database (cannot be used but needs to be checked for validation)
            $db->execute();                                                                         // Run the query
        else:                                                                                       // If Email address already exists
            $this->error = new Error('Register', 'Email Address already taken');                    // Throw Error
            return false;                                                                           // @return false
        endif;
    }
    
    public function setCookies($username, $password){                                               /* Set Login Cookies */
        $time = time()+60*60*24*120;                                                                // Set Cookie Duration
        setcookie(COOKIE_USERNAME, $username, $time, '/');                                          // Set Encoded Username Cookie
        setcookie(COOKIE_PASSWORD, $password, $time, '/');                                          // Set Encoded Password Cookie
    }   
    
    function updateDetails(array $details){                                                         /* Update User's Details (NOT PASSWORD) */
        global $db;                                                                                 // Include Database instance
        $db->query("
            UPDATE user
            SET user_name = :name, user_email = :email
            WHERE user_id = :id
        ");
        $db->bind(':name', $details['name']);                                                       // Bind Name to query
        $db->bind(":email", $details['email']);                                                     // Bind Email to query
        $db->bind(":id", $this->id);                                                                // Bind Id to query
        $db->execute();                                                                             // Run the query
    }
    
    function updatePassword(array $details){                                                        /* Update User's Password */
        global $db;                                                                                 // Include Database Instance
        $old_pass = $details['ldpsswrd'];                                                           // Get Old Password from Details
        $new_pass = $details['nwpsswrd'];                                                           // Get New Password from Details
        $cfm_pass = $details['cnfrmpsswrd'];                                                        // Get Password Confirmation from Details
        if($new_pass === $cfm_pass):                                                                // Passwords match
            if($user = check_user_exists($this->alias)):                                            // If User exists (Always true if User logged in)
                $salt = $user['salt'];                                                              // Get the Stored Salt
                $pass = safe_encode($new_pass, $salt);                                              // Encode Username with Stored Salt
                if($pass === $user['user_pass']):                                                   // Encoded Password matches Stored Password
                    $db->query("
                        UPDATE user
                        SET user_pass = :pass
                        WHERE user_id = :id
                    ");
                    $db->bind(':pass', $pass);                                                      // Bind Encoded Password to query
                    $db->bind(':id', $id);                                                          // Bind Id to query
                    $db->execute();                                                                 // Run the query
                else:                                                                               // Encoded Password does not match Stored Password
                    $this->error = new Error('Update', 'Your Password was incorrect');              // Throw new Error
                endif;
            endif;
        else:                                                                                       // Passwords don't match
            $this->error = new Error('Update', 'The Passwords you entered did not match');          // Throw Error
            return false;                                                                           // @return false
        endif;
    }
    
    public function getError(){
        return $this->error->getError();
    }
}