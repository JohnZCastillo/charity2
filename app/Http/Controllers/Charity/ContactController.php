<?php

namespace App\Http\Controllers\Charity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{

    public function index()
    {
        return view('charity.contact-us');
    }
}
