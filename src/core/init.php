<?php

set_include_path(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'classes');
spl_autoload_extensions('.php');
spl_autoload_register();

require_once 'SimplePie_Autoloader.php';

session_start();
