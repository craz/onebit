<?php


namespace OneBit\Agents;


use Bitrix\Main\Application;
use Bitrix\Main\Diag\Debug;
use Bitrix\Main\IO\File;
use OneBit\WebForms;

class LogSenderAgent
{
    static public function sendLogDenunciation(){
        global $USER;
        if (!is_object($USER)) {
            $USER = new \CUser;
        }
        $fileWithLog = Application::getDocumentRoot()."/local/utils/logs/updateIBE.log";
        if (File::isFileExists($fileWithLog) && File::getFileContents($fileWithLog)) {
            $fields["FILE_LOG"] = $fileWithLog;
            $fields["THEME"] = "Передача файла с логом изменений инфоблоков руководству";
            $fields["EMAIL"] = ADMIN_EMAIL;
            /** @var integer $resultFormId - результат формы*/
            if ($resultFormId = WebForms::addResultToFormDenunciation($fields,ADMIN_ID,true)) {
                if (WebForms::sendMailFormDenunciation($resultFormId)) {
                    File::putFileContents($fileWithLog, '');
                    Debug::writeToFile("Файл отправлен руководителю в " . date('Y-m-d\TH-i-s'));
                }
            }

        }
        return __METHOD__."();";
    }
}