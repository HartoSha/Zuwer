<?php
class indexController {
    public function index($param1) {
        print "Index html";
        // var_dump($param1);
        print "<br> param1: " . $param1;
        
    }
    public function catalog($param1) {
        print "Catalog";
    }
}