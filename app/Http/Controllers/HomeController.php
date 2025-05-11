<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;

class HomeController extends Controller
{
    public function welcome()
    {
        $publishedComplaints = Complaint::where('is_published', true)->get();
        return view('welcome', compact('publishedComplaints'));
    }
}
