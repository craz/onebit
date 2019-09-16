<?php
define('ADMIN_ID',1);

if ($emailForm = !COption::GetOptionString('main', 'email_from')){
    define('ADMIN_EMAIL','admin@'.SITE_SERVER_NAME);
}else{
    define('ADMIN_EMAIL',$emailForm);
}
/** =============== Константы веб-форм **/
define('FROM_DENUNCIATION_ID',1); //ID Web-формы
define('PERIOD_SEND_LOG_DENUNCIATION', 15); //Период проверки и отправки результатов руководителю
define('LOOP_FILE_LOG_PATH', '/../logs/updateIBE.log'); //для cli цикла - путь до лога с изменениями инфоблока
/** =============== Константы HL блоков */
define('HL_CITY_ID',3);
define('HL_COURSES_ID',4);
define('HL_SCHEDULE_ID',5);