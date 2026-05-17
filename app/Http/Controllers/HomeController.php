<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('pages.home');
    }
    public function aboutUs()
    {
        return view('pages.about');
    }
    public function Team()
    {
        return view('pages.teams');
    }
    public function Courses()
    {
        return view('pages.courses');
    }
    public function contactUs()
    {
        return view('pages.contact-us');
    }
    public function termsCondition()
    {
        return view('pages.terms');
    }
    public function Privacy()
    {
        return view('pages.privacy-policy');
    }
    public function Licensing()
    {
        return view('pages.licensing');
    }
   
}
