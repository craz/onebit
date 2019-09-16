<?php


namespace OneBit;

/**
 * Класс для работы с пользователями сайта
 * Class User
 * @package OneBit
 */
class User
{

    /**
     * Возвращает информацию о пользователе
     * @param $id ИД пользователя
     * @return array - login, строка фамилия и имя
     */
    static public function getNameAndLoginById($id){
        $user = \CUser::GetByID($id);
        $userFields = $user->Fetch();
        $result["login"] = $userFields["LOGIN"];
        $result["FI"] = $userFields["LAST_NAME"]." ".$userFields["NAME"];
        return $result;
    }
}