<?

use OneBit\HLClass;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("tools");
?>

<?
/*$idCity = HLClass::getCity("Самара");
$arCourses = HLClass::getCourses($idCity);
$arShedule = HLClass::getSchedule($arCourses);*/
print_r(HLClass::getCoursesByCityAndDate("Самара", new \Bitrix\Main\Type\DateTime()));
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>