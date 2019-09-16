<?php

namespace OneBit;

use Bitrix\Main\Diag\Debug;

\Bitrix\Main\Loader::includeModule('iblock');

/**
 * Класс для обработки событий связанных с ЭЛЕМЕНТАМИ Ифоблоков
 * Class CIBlockElementHandler
 * @package OneBit
 */
class CIBlockElementHandler
{
    const PATH_TO_LOG = 'local/utils/logs';

    /**
     * Обработчик OnAfterIBlockElementUpdate
     * Событие "OnAfterIBlockElementUpdate" вызывается после попытки изменения элемента информационного блока методом
     * CIBlockElement::Update. Работает вне зависимости от того были ли созданы/изменены элементы непосредственно,
     * поэтому необходимо дополнительно проверять параметр: RESULT_MESSAGE.
     * @param $fields
     */
    public function OnAfterIBlockElementUpdateHandler($fields)
    {
        $dateChange = date('Y-m-d\TH-i-s');
        $logfile = self::PATH_TO_LOG . '/updateIBE.log';
        $user = User::getNameAndLoginById($fields['MODIFIED_BY']);
        $logInfo = 'Пользователь ' . $user['login'] . '[' . $user['FI'] . '] изменил элемент инфоблока с именем "';
        $logInfo .= $fields["NAME"] . '" [ID=' . $fields['ID'] . "]. Время изменения: " . $dateChange;
        Debug::writeToFile($logInfo, 'Изменение ИБ [ID=' . $fields['IBLOCK_ID'] . "]", $logfile
        );
    }
}