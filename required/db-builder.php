<?php
/*******************************************************************************
 * BUILD DEFAULT DATABASE
 ******************************************************************************/
function build_database(){
    site_table();
    user_table();
    navigation_table();
}


function site_table(){
    global $db;
    
    $db->query("CREATE TABLE IF NOT EXISTS site (
        `site_id` INT NOT NULL AUTO_INCREMENT,
        PRIMARY KEY(site_id),
        `site_title` VARCHAR(64),
        `site_subtitle` VARCHAR(128),
        `site_description` TEXT,
        `site_keywords` TEXT,
        `site_author` VARCHAR(64),
        `site_author_email` VARCHAR(128),
        `site_theme` VARCHAR(64) DEFAULT 'default',
        `site_date_created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `site_last_modified` DATE
    )");
    
    $db->execute();
}

function user_table(){
    global $db;
    
    $db->query("CREATE TABLE IF NOT EXISTS user (
        `user_id` INT NOT NULL AUTO_INCREMENT,
        PRIMARY KEY(user_id),
        `user_name` VARCHAR(64) NOT NULL,
        `user_email` VARCHAR(64) NOT NULL,
        `user_alias` VARCHAR(32) NOT NULL,
        `user_pass` VARCHAR(289) NOT NULL,
        `user_online` BOOL NOT NULL DEFAULT FALSE,
        `user_last_online` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `user_account_level` INT NOT NULL DEFAULT 1,
        `user_salt` VARCHAR(64)
    )");
    
    $db->execute();
}

function navigation_table(){
    global $db;
    
    $db->query("CREATE TABLE IF NOT EXISTS nav (
        `nav_id` INT NOT NULL AUTO_INCREMENT,
        PRIMARY KEY(nav_id),
        `nav_name` VARCHAR(64) NOT NULL,
        `nav_page_ids` TEXT NOT NULL
    )");
    
    $db->execute();
}