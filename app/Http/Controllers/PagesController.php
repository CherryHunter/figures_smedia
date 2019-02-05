<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Figure;

class PagesController extends Controller
{

    public function index(){
      $figures = Figure::orderBy('id','desc')->paginate(9);
      return view('pages.index')->with('figures', $figures);
      /* $title = 'Welcome to Laravel';
      return view('pages.index')->with('title', $title);
      */
    }

    public function top10(){
      $figures = Figure::orderBy('popularity','desc')->take(10)->get();
      return view('pages.top10')->with('figures', $figures);
    }

    public function notifications(){
      $figures = Figure::orderBy('popularity','desc')->take(10)->get();
      return view('pages.notifications')->with('figures', $figures);
    }

}
