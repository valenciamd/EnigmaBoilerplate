<?php
// Include Global Database
global $db, $user;
// Select Template File
$this->template->buildFromTemplates('admin/form');
// Set Page Title
$this->template->getPage()->setTitle('Admin - Reset Password');

// Add Site Head Template
$this->template->addTemplateBit('head', 'global/head');
// Add Content Template

$url = $_SERVER['REQUEST_URI'];
$url = explode('?', $url);
$url = explode('/', $url[0]);

if(isset($_POST['reset_password'])):
    $this->template->addTemplateBit('content', 'admin/reset-password/confirm');
elseif(isset($_POST['validate_pin'])):
        $this->template->addTemplateBit('content', 'admin/reset-password/new');
else:
    if(isset($url[4]) && $url[4] !== ''):
        $this->template->addTemplateBit('content', 'admin/reset-password/pin');
    else:
        $this->template->addTemplateBit('content', 'admin/reset-password/email');
    endif;
endif;

// Add Site Data to Template
$siteQuery = $db->query("SELECT * FROM site");
$siteCache = $db->cacheQuery();
$this->template->getPage()->addTag('template', array('SQL', $siteCache));

if(isset($_POST['login_admin'])):
    $user->login($_POST);
    if($user->isLoggedIn()):
        $errorCache = $db->cacheData('');
    else:
        $errorCache = $db->cacheData($user->getError());
        //var_dump($user->getError());
    endif;
else:
    $errorCache = $db->cacheData(array('message' => ''));
endif;

$this->template->getPage()->addTag('error', array('DATA', $errorCache));

// Parse Template Output (Add Data to Template Tags)
$this->template->parseOutput();
// Render Template to Page
print $this->template->getPage()->getContent();