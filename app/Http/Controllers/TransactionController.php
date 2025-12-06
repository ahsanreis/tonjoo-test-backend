<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        if (request()->isMethod('get')) {
            return view('pages.add-data-transaction');
        }
    }
}
