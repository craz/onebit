<?php

use Bitrix\Main\EventManager;

$eventManager = EventManager::getInstance();


/** @var Bitrix\Main\EventManager $eventManager */
$eventManager->addEventHandler(
    'iblock', "OnAfterIBlockElementUpdate", [
        "\\OneBit\\CIBlockElementHandler",
        "OnAfterIBlockElementUpdateHandler",
    ], false, 1);