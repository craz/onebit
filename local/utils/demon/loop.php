<?

use Bitrix\Main\Diag\Debug;
use Bitrix\Main\IO\File;
use OneBit\WebForms;
/**Переопределяем для использования ядра Битрикс**/
$_SERVER['DOCUMENT_ROOT'] = realpath(__DIR__ . '/../../..');
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

require_once dirname(__FILE__) . '/../../../vendor/autoload.php';

$fileWithLog = dirname(__FILE__) . LOOP_FILE_LOG_PATH;

$loop = React\EventLoop\Factory::create();
/**Запускаем таймер**/
$loop->addPeriodicTimer(PERIOD_SEND_LOG_DENUNCIATION, function () use ($fileWithLog) {

    if (File::isFileExists($fileWithLog) && File::getFileContents($fileWithLog)) {
        $fields["FILE_LOG"] = $fileWithLog;
        $fields["THEME"] = "Передача файла с логом изменений инфоблоков руководству";
        $fields["EMAIL"] = ADMIN_EMAIL;
        /** @var integer $resultFormId - результат формы*/
        if ($resultFormId = WebForms::addResultToFormDenunciation($fields)) {
            if (WebForms::sendMailFormDenunciation($resultFormId)) {
                File::putFileContents($fileWithLog, '');
                Debug::writeToFile("Файл отправлен руководителю в " . date('Y-m-d\TH-i-s'));
            }
        }

    }
}
);

$loop->run();