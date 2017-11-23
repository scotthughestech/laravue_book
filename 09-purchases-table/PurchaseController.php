<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return [
            [
                'date' => '2017-11-21',
                'price' => '25',
                'description' => 'Dog Food'
            ],
            [
                'date' => '2017-11-21',
                'price' => '50',
                'description' => 'Restaurant Bill'
            ],
            [
                'date' => '2017-11-20',
                'price' => '37',
                'description' => 'Gasoline'
            ]
        ];
    }
}
