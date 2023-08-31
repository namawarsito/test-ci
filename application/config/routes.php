<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = 'welcome';

// route login
$route['login'] = 'login';

// route dashboard
$route['dashboard'] = 'dashboard';


$route['404_override'] = 'welcome/notfound';
$route['translate_uri_dashes'] = FALSE;
