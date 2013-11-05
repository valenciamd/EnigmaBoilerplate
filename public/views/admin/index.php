<?php

    $user = new User();
    
    /* Redirect to Login Page if user not authenticated
    if(!$user->isLoggedIn()):
        header("Location: {$router->url}admin/login/");
    endif;
    */