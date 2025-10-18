<?php
namespace App\Controllers;
use App\Factory\ViewFactory;
class HomeController{ public function index(){ ViewFactory::render('home.php'); } }
?>