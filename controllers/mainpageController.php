<?php

require_once(ROOT. "models". DIRECTORY_SEPARATOR. "mainpage". DIRECTORY_SEPARATOR . "mainpageModel.php");

class mainpageController # Контроллер главной сайта
{ 
    public function index() 
    {
        $manufacturers = mainpageModel::getManufacturers();
        // print "<br>Главная";
        // print "Производители: <br>";
        // var_dump($manufacturers);
        $newProducts = mainpageModel::getNewProducts();
        // print "Новые: <br>";
        // var_dump($newProducts);
        // print "<br> param1: " . $param1[0];
        // print "<br> param2: " . $param1[1];

        require_once(VIEWS . "mainpageView.php");
    }
}