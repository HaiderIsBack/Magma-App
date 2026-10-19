<?php

namespace App\Controllers;

use Magma\Core\BaseController;
use Magma\Http\Get;

class HomeController extends BaseController {

    #[Get('/')]
    public function index() {
        http_response_code(200);
        echo json_encode([
            "message" => "Congratulations! your app is working"
        ]);
    }
}