<?

use Bitrix\Main\Application;
use OneBit\Agents\LogSenderAgent;

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true){
    die("prolog not defined");
}

/**Общие константы проекта **/
if (file_exists(Application::getDocumentRoot() . "/local/php_interface/include/constants.php")) {
    require_once(Application::getDocumentRoot() . "/local/php_interface/include/constants.php");
}
/** обработка событий Битрикс */
if (file_exists(Application::getDocumentRoot(). "/local/php_interface/include/handlers.php")) {
    require_once(Application::getDocumentRoot() . "/local/php_interface/include/handlers.php");
}
/** фукнции */
if (file_exists(Application::getDocumentRoot() . "/local/php_interface/include/functions.php")) {
    require_once(Application::getDocumentRoot() . "/local/php_interface/include/functions.php");
}

OneBit\Agents\LogSenderAgent::sendLogDenunciation();


