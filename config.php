<?php
/*******************************************************************************
 * CONFIGURATION FILE
 *******************************************************************************
 * Contains the default configuration for the site.
 * Details should be modified to fit your server set up. 
 ******************************************************************************/

/*******************************************************************************
 * ENVIRONMENT SET UP
 ******************************************************************************/
define("PRODUCTION_ENV", FALSE);                                                                    // Set to TRUE when on Production

/*******************************************************************************
 * ROOT DIRECTORIES
 ******************************************************************************/
if(PRODUCTION_ENV):                                                                                 /* Production Environment */
    define("SITE_ROOT", '/');                                                                       // Set to your root URL eg. '/'
    define("DOCUMENT_ROOT", '/public_html/');                                                       // Set to your root folder eg 'public_html'
else:                                                                                               /* Development Environment */
    define("SITE_ROOT", '/salons/');                                                                // Set to your root URL eg. '/'
    define("DOCUMENT_ROOT", '/');                                                                   // Set to your root folder eg 'public_html'
endif;

/*******************************************************************************
 * DATABASE SET UP
 ******************************************************************************/
if(PRODUCTION_ENV):                                                                                 /* Production Environment */
    define("DB_HOST");                                                                              // Database Host
    define("DB_USER");                                                                              // Database Username
    define("DB_PASS");                                                                              // Database Password
    define("DB_NAME");                                                                              // Database Name
else:                                                                                               /* Development Environment */
    define("DB_HOST", 'localhost');                                                                 // Database Host
    define("DB_USER", 'root');                                                                      // Database Username
    define("DB_PASS", '');                                                                          // Database Password
    define("DB_NAME", 'salons');                                                                    // Database Name
endif;

/*******************************************************************************
 * SECURITY AND AUTHENTICATION (NOT CURRENTLY USED - USEFUL FOR FUTURE)
 ******************************************************************************/
define('AUTH_KEY',         "436e016e7807a07223ecadb7b44ef29b1b5ba92c");                             // Authentication Key
define('SECURE_AUTH_KEY',  "0e35ac5f2f1a64228a911396460a8af4cf518beb");                             // SSL Authentication Key
define('LOGGED_IN_KEY',    "cd465e043030b441397bfc7302a2e26a8db02795");                             // Logged In Key
define('NONCE_KEY',        "e25eeca25e8a262cebd077b35549cd358aadbd42");                             // Nonce Key
define('AUTH_SALT',        "563b195ddd6d2cc2cb5c6cf9ec40923cc1812f89");                             // Authentication Salt
define('SECURE_AUTH_SALT', "e526a97abbe0510e3cff04d80264eddacaca8d14");                             // SSL Authentication Salt
define('LOGGED_IN_SALT',   "859bb2281ed880e1ca52affcc2e62367126a97b3");                             // Logged In Salt
define('NONCE_SALT',       "dc176e1cb1ca009efdc46707d9c77386493d7f98");                             // Nonce Salt

/*******************************************************************************
 * ABSOLUTE PATH TO REQUIRED DIRECTORY
 ******************************************************************************/
if (!defined('ABSPATH')) define('ABSPATH', dirname(__FILE__) . '/');

/*******************************************************************************
 * SET UP VARIABLES AND REQUIRED DIRECTORIES
 ******************************************************************************/
require_once(ABSPATH . 'settings.php');