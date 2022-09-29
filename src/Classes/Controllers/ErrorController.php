<?php
namespace App\Classes\Controllers;
class ErrorController extends AbstractController {
    public function index()
    {
        return $this->renderView('../../templates/Error/404.phtml', [], []);
    }
}