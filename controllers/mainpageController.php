<?php

require_once(ROOT. "models". DIRECTORY_SEPARATOR. "mainpage". DIRECTORY_SEPARATOR . "mainpageModel.php");

class mainpageController # Контроллер главной сайта
{ 
    public function index() 
    {
        $manufacturers = mainpageModel::getManufacturers();
        $newProducts = mainpageModel::getNewProducts();
        require_once(VIEWS . "mainpageView.php");
    }
}