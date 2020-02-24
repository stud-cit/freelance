<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CabinetController extends Controller
{
    //
    protected $info = "Інформаційний сервіс \"WorkDump\" для розміщення онлайн-об'яв на виконання робіт";	// Service description
    protected $icon = "workdump-cabinet.png";		// Service icon (48x48)
    protected $mask = 13;			// Service modes 3,2,0 (1101 bits)

    protected $cabinet_api = "https://cabinet.sumdu.edu.ua/api/";
    protected $cabinet_service = "https://cabinet.sumdu.edu.ua/index/service/";
    protected $cabinet_service_token = "2Vm2JuEq";

    protected $token = "ne2MwAa87M48i6hP1hGZKzTETPH5nQha01ZE0ISEg5FSlgOWTH3b";
    protected $user_token;

    // Получаем параметры GET запроса
    protected $key;
    protected $mode;

    public function cabinetRequest() {
        echo '<p>'.$this->cabinet_api . "getPerson/?key=" . $this->token.'</p>';
        $req = json_decode(file_get_contents($this->cabinet_api . "getPerson/?key=" . $this->token), true);
        $this->key = !empty($req['key']) ? $req['key'] : "";
        $this->mode = !empty($req['mode']) ? $req['mode'] : 0;
        $this->user_token = !empty($req['token']) ? $req['token'] : "";
        echo '<p>key: '.$this->key.'.</p>';
        echo '<p>mode: '.$this->mode.'.</p>';
        if (!empty($key)) {
            switch ($this->mode) {
                case 0:
                    break;
                case 2:
                    header('Content-Type: image/png');
                    readfile($this->icon);
                    exit;
                case 3:
                    echo $this->info;
                    exit;
                case 100;
                    header('X-Cabinet-Support: ' . $this->mask);
                default:
                    exit;
            }
        }
    }


    // В зависимости от режима (mode) возвращаем или иконку, или описание, или специальный заголовок
    public function cabinetLogin()
    {
        $this->cabinetRequest();
        //session_start();


        $person = json_decode(file_get_contents($this->cabinet_api . 'getPerson?key=' . $this->token));
        echo '<p>guid: '.$person->result->guid.'</p>';

        // Если ключ не передается, но он сохранен в сессии, берем из сессии. Ключ храним
        // в сессии для запроса на подтверждение, что пользователь все еще авторизован в кабинете.

/*
        if (empty($this->key) && !empty($_SESSION['key'])) {
            $this->key = $_SESSION['key'];
            echo '<p>session key: '.$this->key.'</p>';
        }
        if (!empty($this->key)) {

            // Отправляем GET запрос на кабинет

            //$person = json_decode(file_get_contents($this->cabinet_api . 'getPerson?key=' . $key . '&token=' . $this->cabinet_service_token), true);
            $person = json_decode(file_get_contents($this->cabinet_api . 'getPerson?key=' . $this->user_token), true);

            echo '<p>person: '.implode($person).'</p>';

            // Если все ОК, пользователь авторизован в кабинете, получаем объект person (JSON)
            // и запоминаем его и ключ в сессии. После этого пользователь авторизован и в сервисе.

            if ($person['status'] == 'OK') {
                $_SESSION['key'] = $this->key;
                $_SESSION['person'] = $person;
            }

            // Иначе либо некорректный ключ (error), либо пользователь вышел из кабинета

            else {
                echo '<pre>' . print_r($person, true) . '</pre>';
                unset($_SESSION['key']);
                unset($_SESSION['person']);
            }
        }*/



        //////
        if (isset($_SESSION['person'])) {

            // Пользователь авторизован

            echo '<h3>Ви увійшли до тестового сервісу</h3>';
            echo '<pre>' . print_r($_SESSION['person'], true) . '</pre>';
            echo '<a href="https://' . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'] . '?logout">Вийти</a>';
        }
        else {

            // Пользователь не авторизован. Показываем ему кнопку "Войти через кабинет"

            echo '<a href="' . $this->cabinet_service . $this->cabinet_service_token . '">Увійти</a>';
        }
        /////

    }


    public function cabinetLogout(){

    // Это реализация команды ВЫХОД, через отправку параметра logout

        if (isset($_REQUEST['logout']) && isset($_SESSION['person'])) {

            // Отправляем GET запрос на кабинет

            $result = json_decode(file_get_contents($this->cabinet_api . 'logout?key=' . $this->key), true);
            echo '<pre>' . print_r($result, true) . '</pre>';
            unset($_SESSION['key']);
            unset($_SESSION['person']);
        }
    }


    // Здесь должен быть код самого сервиса, его логика.

    /*
    if (isset($_SESSION['person'])) {

    // Пользователь авторизован

    echo '<h3>Ви увійшли до тестового сервісу</h3>';
    echo '<pre>' . print_r($_SESSION['person'], true) . '</pre>';
    echo '<a href="https://' . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'] . '?logout">Вийти</a>';
    }
    else {

    // Пользователь не авторизован. Показываем ему кнопку "Войти через кабинет"

    echo '<a href="' . $cabinet_service . $cabinet_service_token . '">Увійти</a>';
    }*/
}
