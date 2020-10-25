<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index() {
        $activity = auth()->user()->activity();
        return view('activity', compact('activity'));
    }
}
