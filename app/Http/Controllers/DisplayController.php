<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class DisplayController extends Controller
{
    function display(){
        $find = Payment::all();
        return view('display',['data'=>$find]);

    }
}
