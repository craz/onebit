<?php


namespace OneBit;

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Type\DateTime;

class HLClass
{
    /**
     * Получаем id города по его названию
     * @param $cityName
     * @return mixed
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    static public function getCity($cityName){
        $arCityHLBlock = HL\HighloadBlockTable::getById(HL_CITY_ID)->fetch();
        $obCityEntity = HL\HighloadBlockTable::compileEntity($arCityHLBlock);
        $strCityEntityDataClass= $obCityEntity->getDataClass();
        $selectCity = ['ID'];
        $filterCity = ['UF_NAME'=>$cityName];
        $rsDataCity = $strCityEntityDataClass::getList([
            'select'=>$selectCity,
            'order'=>['ID'=>'ASC'],
            'limit'=>'500',
            'filter'=>$filterCity
        ])->fetch();
        return $rsDataCity["ID"];
    }

    /**
     * Получаем все курсы в городе
     * @param $cityID
     * @return array
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    static public function getCourses($cityID){
        $arCoursesHLBlock = HL\HighloadBlockTable::getById(HL_COURSES_ID)->fetch();
        $obCoursesEntity = HL\HighloadBlockTable::compileEntity($arCoursesHLBlock);
        $strCoursesEntityDataClass= $obCoursesEntity->getDataClass();
        $selectCourses = ['ID'];
        $filterCourses = ['UF_CITIES'=>$cityID];
        $rsDataCourse = $strCoursesEntityDataClass::getList([
            'select'=>$selectCourses,
            'order'=>['ID'=>'ASC'],
            'limit'=>'500',
            'filter'=>$filterCourses
        ])->fetchAll();
        return $rsDataCourse;
    }

    static public function getSchedule($arCourses,DateTime $dateTime){
        $arScheduleHLBlock = HL\HighloadBlockTable::getById(HL_SCHEDULE_ID)->fetch();
        $obScheduleEntity = HL\HighloadBlockTable::compileEntity($arScheduleHLBlock);
        $strScheduleEntityDataClass= $obScheduleEntity->getDataClass();
        $selectSchedule = ["*"];
        $filterSchedule = ['>=UF_ACTIVE_FROM'=>$dateTime, "@UF_COURSES_ID"=>$arCourses];
        $rsDataSchedule = $strScheduleEntityDataClass::getList([
            'select'=>$selectSchedule,
            'order'=>['ID'=>'ASC'],
            'limit'=>'500',
            'filter'=>$filterSchedule
        ])->fetchAll();
        return $rsDataSchedule;
    }

    static public function getCoursesByCityAndDate($cityName, DateTime $dateTime){
        $cityID = self::getCity($cityName);
        $arCourses = self::getCourses($cityID);
        $arSchedule = self::getSchedule($arCourses,$dateTime);
        return $arSchedule;
    }
}