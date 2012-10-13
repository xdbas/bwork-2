<?php
$config['default_controller'] = 'home';
$config['default_action'] = 'index';

$config['default_view_extensions'] = array('php', 'html', 'xml');
$config['default_view_extension'] = 'php';

$config['controller_path'] = APPLICATION_PATH.'controllers'.DIRECTORY_SEPARATOR;
$config['model_path'] = APPLICATION_PATH.'models'.DIRECTORY_SEPARATOR;
$config['vo_path'] = $config['model_path'].'vo'.DIRECTORY_SEPARATOR;
$config['scripts_path'] = APPLICATION_PATH.'view'.DIRECTORY_SEPARATOR.'scripts'.DIRECTORY_SEPARATOR;
$config['layouts_path'] = APPLICATION_PATH.'view'.DIRECTORY_SEPARATOR.'layouts'.DIRECTORY_SEPARATOR;
$config['module_path'] = APPLICATION_PATH . 'modules' . DIRECTORY_SEPARATOR;

$config['sub_url'] = '/bwork-2/';

$config['database']['host'] = '127.0.0.1';
$config['database']['dbname'] = 'deb12070n2_zer0';
$config['database']['username'] = 'deb12070n2_zer0';
$config['database']['password'] = 'kotskop';
$config['database']['port'] = '3306';