<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index() {
        $value = 9;
        $formatted = str_pad($value, 2, '0', STR_PAD_LEFT);
        echo $formatted;
    }
}
