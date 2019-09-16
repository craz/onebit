<?php


namespace OneBit;


use \Bitrix\Main\Diag\Debug;
use \Bitrix\Main\IO\File;

\CModule::IncludeModule("form");

/**
 * Класс обеспечивает работу с веб-формами Битрикс
 * Class WebForms
 * @package OneBit
 */
class WebForms
{
    /**
     * Производит запись результатов
     * @param array $fields FILE_LOG, THEME, EMAIL
     * @param int $addingUser от кого добавлять результат
     * @return bool|int
     */
    static public function addResultToFormDenunciation(array $fields, $addingUser = ADMIN_ID, $agent=false)
    {
        $arLogfile = \CFile::MakeFileArray($fields["FILE_LOG"]);
        $arValues = [
            "form_text_1"     => $fields["THEME"],
            "form_email_2"    => $fields["EMAIL"],
            "form_file_3"     => $arLogfile,
            "form_textarea_4" => File::getFileContents($arLogfile["tmp_name"]),
        ];
        if ($agent){
            $resultId = \CFormResult::Add(FROM_DENUNCIATION_ID, $arValues,"N");
            return $resultId;
        }elseif ($resultId = \CFormResult::Add(FROM_DENUNCIATION_ID, $arValues, "N", $addingUser)) {
            return $resultId;
        } else {
            Debug::writeToFile("Произошла ошибка записи результата формы");
        }
        return false;
    }

    /**
     * Отправка почтового собщения с рузультатом заполнения формы
     * @param $id - результат заполнения формы
     * @return bool
     */
    static function sendMailFormDenunciation($id)
    {
        if (\CFormResult::Mail($id)) {
            return true;
        } else {
            Debug::writeToFile("Произошла ошибка отправки результата формы по почте");
        }
    }
}