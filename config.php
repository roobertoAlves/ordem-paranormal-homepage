<?php
// Configurações básicas
define('BASE_PATH', __DIR__);
define('APP_PATH', BASE_PATH . '/app');
spl_autoload_register(function($class){ $class = str_replace('\\', '/', $class); $file = BASE_PATH . '/' . $class . '.php'; if(file_exists($file)) require $file; });
?>