<?php
ob_start();
session_start();

// Determine document root - handle both web and CLI contexts
$docRoot = isset($_SERVER['DOCUMENT_ROOT']) && !empty($_SERVER['DOCUMENT_ROOT']) 
    ? $_SERVER['DOCUMENT_ROOT'] 
    : dirname(__DIR__);

require $docRoot.'/vendor/autoload.php';
use \PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Load SQL configuration file based on HTTP_HOST
// Handle cases where HTTP_HOST includes port (e.g., localhost:8000)
$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
// Remove port if present
$host = preg_replace('/:\d+$/', '', $host);
if ($host === '127.0.0.1' || $host === '::1') {
    $host = 'localhost';
}

// Try to load config file with fallback options
$configFile = $docRoot.'/_core/sql_'.$host.'.php';
if (!file_exists($configFile)) {
    // Fallback 1: local development
    $configFile = $docRoot.'/_core/sql_localhost.php';
    if (!file_exists($configFile)) {
        // Fallback 2: generic sql.php
        $configFile = $docRoot.'/_core/sql.php';
        if (!file_exists($configFile)) {
            die('Database configuration file not found. Please create _core/sql_'.$host.'.php');
        }
    }
}
require_once $configFile;

if (!function_exists('km_env')) {
    function km_env($key)
    {
        $candidates = array(
            getenv($key),
            $_ENV[$key] ?? false,
            $_SERVER[$key] ?? false,
        );

        foreach ($candidates as $value) {
            if ($value !== false && $value !== null && $value !== '') {
                return (string) $value;
            }
        }

        return false;
    }
}

if (!function_exists('km_apply_db_env_overrides')) {
    function km_apply_db_env_overrides()
    {
        $map = array(
            'DB_HOST' => 'host',
            'DB_PORT' => 'port',
            'DB_NAME' => 'db',
            'DB_USER' => 'username',
            'DB_PASS' => 'password',
        );

        foreach ($map as $envKey => $configKey) {
            $value = km_env($envKey);
            if ($value !== false) {
                $GLOBALS['config']['mysql'][$configKey] = $value;
            }
        }
    }
}
km_apply_db_env_overrides();

spl_autoload_register(function($class) use ($docRoot){

	if ((class_exists($class,FALSE)) || (strpos($class, 'PHPExcel') === 0)) {
		$pClassFilePath = $docRoot . '/' .
                          str_replace('_',DIRECTORY_SEPARATOR,$class) .
                          '.php';
           require_once $pClassFilePath;
        } 
        else if ((class_exists($class,FALSE)) || (strpos($class, 'Dompdf') === 0)) 
        {
          $prefixLength = 6;
          $file = str_replace('\\', DIRECTORY_SEPARATOR, substr($class, $prefixLength));
          $file = realpath(__DIR__ . (empty($file) ? '' : DIRECTORY_SEPARATOR) . $file . '.php');
          
          $pClassFilePath = $docRoot . '/' .
          str_replace('\\',DIRECTORY_SEPARATOR,$class) . '.php';
          require_once $pClassFilePath;
        } else if ($class === 'Cpdf') {
            require_once __DIR__ . "/../Dompdf/lib/Cpdf.php";
            return;
        }
        else {
        	require_once $docRoot.'/_classes/' . $class . '.php';
        }
	
});
require_once $docRoot.'/_functions/sanitize.php';
require_once $docRoot.'/_functions/functions.php';
require_once $docRoot.'/_core/cookie_session.php';

$str_sessiontimeout = 120; // min
$str_sessiontimeout = ($str_sessiontimeout * 60);
//Session check	
if (isset($_SESSION['LAST_ACTIVITY']) && ((time() - $_SESSION['LAST_ACTIVITY']) > $str_sessiontimeout)) 
{ 
  // last request was more than 30 minates ago 
  session_destroy();   // destroy session data in storage 
  session_unset();     // unset $_SESSION variable for the runtime
  header("location: login.php");
	exit();
}
else $_SESSION['LAST_ACTIVITY'] = time();


// Africa/Mogadishu
$errors = array();
date_default_timezone_set('Africa/Mogadishu');
?>

