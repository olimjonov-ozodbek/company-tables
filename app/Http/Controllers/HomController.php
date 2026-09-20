<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomController extends Controller
{
    public function index()
    {
        return view('app'); 
    } 
    
    public function members()
    {
        $members=[
            // 'Aliyev Vali',
            // 'Tolanaov Polat',
            // 'Sharxiyev Parfi'
        ];
        return view('members', compact('members'));
    }
}
