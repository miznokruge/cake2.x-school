<?php

/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
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
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
Router::connect('/', array('controller' => 'dashboard', 'action' => 'index'));
//Router::connect('/logout', array('controller' => 'users', 'action' => 'logout'));
//Router::connect('/leavestakens/*', array('controller' => 'LeavesTakens'));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
//Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

/**
 * Load all plugin routes.  See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
//CakePlugin::routes();

/*
 *
 *
 *
 */

Router::connect('/login', array('controller' => 'users', 'action' => 'login'));
Router::connect('/logout', array('controller' => 'users', 'action' => 'logout'));
Router::connect('/forgotPassword', array('controller' => 'users', 'action' => 'forgotPassword'));
Router::connect('/activatePassword/*', array('controller' => 'users', 'action' => 'activatePassword'));
Router::connect('/register', array('controller' => 'users', 'action' => 'register'));
Router::connect('/register/employer', array('controller' => 'users', 'action' => 'register_employer'));
Router::connect('/changePassword', array('controller' => 'users', 'action' => 'changePassword'));
Router::connect('/changeUserPassword/*', array('controller' => 'users', 'action' => 'changeUserPassword'));
Router::connect('/addUser', array('controller' => 'users', 'action' => 'addUser'));
Router::connect('/editUser/*', array('controller' => 'users', 'action' => 'editUser'));
Router::connect('/update_profile/*', array('controller' => 'users', 'action' => 'update_profile'));
Router::connect('/deleteUser/*', array('controller' => 'users', 'action' => 'deleteUser'));
Router::connect('/viewUser/*', array('controller' => 'users', 'action' => 'viewUser'));
Router::connect('/userVerification/*', array('controller' => 'users', 'action' => 'userVerification'));
Router::connect('/allUsers', array('controller' => 'users', 'action' => 'index'));
Router::connect('/dashboard', array('controller' => 'users', 'action' => 'myprofile'));
Router::connect('/permissions', array('controller' => 'UserGroupPermissions', 'action' => 'index'));
Router::connect('/generate_all_permissions', array('controller' => 'UserGroupPermissions', 'action' => 'generate_all_permissions'));
Router::connect('/update_permission', array('controller' => 'UserGroupPermissions', 'action' => 'update'));
Router::connect('/accessDenied', array('controller' => 'users', 'action' => 'accessDenied'));
Router::connect('/myprofile', array('controller' => 'users', 'action' => 'myprofile'));
Router::connect('/allGroups', array('controller' => 'user_groups', 'action' => 'index'));
Router::connect('/addGroup', array('controller' => 'user_groups', 'action' => 'addGroup'));
Router::connect('/editGroup/*', array('controller' => 'user_groups', 'action' => 'editGroup'));
Router::connect('/deleteGroup/*', array('controller' => 'user_groups', 'action' => 'deleteGroup'));
Router::connect('/emailVerification', array('controller' => 'users', 'action' => 'emailVerification'));

CakePlugin::routes();
Router::connect('/social_login/*', array('plugin' => 'Usermgmt', 'controller' => 'users', 'action' => 'social_login'));
Router::connect('/social_endpoint/*', array('plugin' => 'Usermgmt', 'controller' => 'users', 'action' => 'social_endpoint'));


/**
 * Load the CakePHP default routes. Remove this if you do not want to use
 * the built-in default routes.
 */
require CAKE . 'Config' . DS . 'routes.php';
