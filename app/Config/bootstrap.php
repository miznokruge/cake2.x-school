<?php

/**
 * This file is loaded automatically by the app/webroot/index.php file after core.php
 *
 * This file should load/create any application wide configuration settings, such as
 * Caching, Logging, loading additional configuration files.
 *
 * You should also use this file to include any files that provide global functions/constants
 * that your application uses.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
// Setup a 'default' cache configuration for use in the application.
Cache::config('default', array('engine' => 'File'));

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 *
 * App::build(array(
 *     'Plugin' => array('/full/path/to/plugins/', '/next/full/path/to/plugins/'),
 *     'Model' =>  array('/full/path/to/models/', '/next/full/path/to/models/'),
 *     'View' => array('/full/path/to/views/', '/next/full/path/to/views/'),
 *     'Controller' => array('/full/path/to/controllers/', '/next/full/path/to/controllers/'),
 *     'Model/Datasource' => array('/full/path/to/datasources/', '/next/full/path/to/datasources/'),
 *     'Model/Behavior' => array('/full/path/to/behaviors/', '/next/full/path/to/behaviors/'),
 *     'Controller/Component' => array('/full/path/to/components/', '/next/full/path/to/components/'),
 *     'View/Helper' => array('/full/path/to/helpers/', '/next/full/path/to/helpers/'),
 *     'Vendor' => array('/full/path/to/vendors/', '/next/full/path/to/vendors/'),
 *     'Console/Command' => array('/full/path/to/shells/', '/next/full/path/to/shells/'),
 *     'locales' => array('/full/path/to/locale/', '/next/full/path/to/locale/')
 * ));
 *
 */
/**
 * Custom Inflector rules, can be set to correctly pluralize or singularize table, model, controller names or whatever other
 * string is passed to the inflection functions
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */
/**
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. make sure you read the documentation on CakePlugin to use more
 * advanced ways of loading plugins
 *
 * CakePlugin::loadAll(); // Loads all plugins at once
 * CakePlugin::load('DebugKit'); //Loads a single plugin named DebugKit
 *
 */
App::uses('CakeLog', 'Log');
//CakeLog::config('activity', array(
//    'engine' => 'FileLog',
//    'types' => array('notice', 'info', 'debug'),
//    'file' => 'activity',
//));
CakeLog::config('error', array(
    'engine' => 'FileLog',
    'types' => array('error'),
    'file' => 'error',
));



#LOAD PLUGIN START
CakePlugin::load('AclExtras');
CakePlugin::load('AclManagement', array('routes' => true));
CakePlugin::load('AuditLog');
CakePlugin::load('Utils');
Cakeplugin::load('BoostCake');
CakePlugin::load('CakeSoftDelete');
CakePlugin::load('DatabaseLogger');
CakePlugin::load('Facebook');
CakePlugin::load('Notification');
CakePlugin::load('OAuth');
CakePlugin::load('TrelloApi');
CakePlugin::load('HybridAuth');

#==== user management =======

function UsermgmtInIt($controller) {
    /*
      setting default time zone for your site
     */
    date_default_timezone_set("Asia/Jakarta");


    App::import('Helper', 'Html');
    $html = new HtmlHelper(new View(null));



    if (!defined("SITE_URL")) {
        define("SITE_URL", $html->url('/', true));
    }

    if (!defined("LOGIN_URL")) {
        define("LOGIN_URL", $html->url('/login/', true));
    }


    /*
      set true if new registrations are allowed
     */
    if (!defined("SITE_REGISTRATION")) {
        define("SITE_REGISTRATION", true);
    }

    /*
      set true if you want send registration mail to user
     */
    if (!defined("SEND_REGISTRATION_MAIL")) {
        define("SEND_REGISTRATION_MAIL", true);
    }

    /*
      set true if you want verify user's email id, site will send email confirmation link to user's email id
      sett false you do not want verify user's email id, in this case user becomes active after registration with out email verification
     */
    if (!defined("EMAIL_VERIFICATION")) {
        define("EMAIL_VERIFICATION", true);
    }


    /*
      set email address for sending emails
     */
    if (!defined("EMAIL_FROM_ADDRESS")) {
        define("EMAIL_FROM_ADDRESS", 'cs@superquiz.com');
    }

    /*
      set site name for sending emails
     */
    if (!defined("EMAIL_FROM_NAME")) {
        define("EMAIL_FROM_NAME", 'GCRM Team');
    }

    /*
      set login redirect url, it means when user gets logged in then site will redirect to this url.
     */
    if (!defined("LOGIN_REDIRECT_URL")) {
        define("LOGIN_REDIRECT_URL", '/');
    }

    /*
      set logout redirect url, it means when user gets logged out then site will redirect to this url.
     */
    if (!defined("LOGOUT_REDIRECT_URL")) {
        define("LOGOUT_REDIRECT_URL", '/login');
    }

    /*
      set true if you want to enable permissions on your site
     */
    if (!defined("PERMISSIONS")) {
        define("PERMISSIONS", true);
    }

    /*
      set true if you want to check permissions for admin also
     */
    if (!defined("ADMIN_PERMISSIONS")) {
        define("ADMIN_PERMISSIONS", false);
    }

    /*
      set default group id here for registration
     */
    if (!defined("DEFAULT_GROUP_ID")) {
        define("DEFAULT_GROUP_ID", 2);
    }

    /*
      set Admin group id here
     */
    if (!defined("ADMIN_GROUP_ID")) {
        define("ADMIN_GROUP_ID", 1);
    }

    /*
      set Guest group id here
     */
    if (!defined("GUEST_GROUP_ID")) {
        define("GUEST_GROUP_ID", 3);
    }
    /*
      set true if you want captcha support on register form
     */
    if (!defined("USE_RECAPTCHA")) {
        define("USE_RECAPTCHA", false);
    }
    /*
      set Admin group id here
     */
    if (!defined("PRIVATE_KEY_FROM_RECAPTCHA")) {
        define("PRIVATE_KEY_FROM_RECAPTCHA", '');
    }
    /*
      set Admin group id here
     */
    if (!defined("PUBLIC_KEY_FROM_RECAPTCHA")) {
        define("PUBLIC_KEY_FROM_RECAPTCHA", '');
    }
    /*
      set login cookie name
     */
    if (!defined("LOGIN_COOKIE_NAME")) {
        define("LOGIN_COOKIE_NAME", 'UsermgmtCookie');
    }
    Cache::config('UserMgmt', array(
        'engine' => 'File',
        'duration' => '+3 months',
        'path' => CACHE,
        'prefix' => 'UserMgmt_'
    ));
}
