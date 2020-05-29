<?php

define("ROOT", dirname(__FILE__) . DIRECTORY_SEPARATOR);
define("CONTROLLERS", ROOT . "controllers" . DIRECTORY_SEPARATOR);

define("DEFAULT_CONTROLLER", "indexController");
define("DEFAULT_ACTION", "index");



# Routing

# разделяем url на составляющие
$uri = prepareURI($_SERVER["REQUEST_URI"]);

 var_dump($uri);

# определяем контроллер и action по url : Zuwer\controller_name\action_name\param1\param2\param3
route($uri);

function prepareURI($uri) 
{
    # Удаляем символы / с начала и конца строки
    $trimmed = trim($uri, "/");
    
    # Делим строку
    return explode("/", $trimmed);
}

function route($uriParts) {
    $controllerName = DEFAULT_CONTROLLER; # Стандартно используем DEFAULT_CONTROLLER
    $actionName = "";
    $params = [];

    # Если передан контролер
    if(!empty($uriParts[0]))
    {
        # Если существует контроллер, указанный в url, то используем его
        if(file_exists(CONTROLLERS . $uriParts[0] . "Controller" . ".php")) {
            $controllerName = $uriParts[0] . "Controller";
        }
        # Если передан action
        if(!empty($uriParts[1])) {
            $actionName = $uriParts[1];
            unset($uriParts[0], $uriParts[1]);
            $params = $uriParts;
        }
    }

    $controllerFullPath = CONTROLLERS . $controllerName . ".php";

    // print $controllerName;

    require_once($controllerFullPath);
    $controller = new $controllerName();
    executeActionIfExists($controller, $actionName, $params);
}

// controller - obj
// actionName - string
// Вызавает action у контроллера, если action существует, если action не существует, вызывается метод index, иначе ошибка
function executeActionIfExists($controller, $actionName, $params) {
    if(method_exists($controller, $actionName)) 
    {
        // print "custom action: " . $actionName;
        $controller->$actionName($params);
    }
    elseif(method_exists($controller, DEFAULT_ACTION)) {
        // print "default action";
        $da = DEFAULT_ACTION;
        $controller->$da($params);
    }
    else {
        die("Controller ".get_class($controller)." doesn't have method: ".$actionName." or default method: ".DEFAULT_ACTION);
    }
}