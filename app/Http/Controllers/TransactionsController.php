<?php

namespace App\Http\Controllers;

use App\Models\Transaction;

class TransactionsController extends Controller
{
   
    // get all transactions
    public function index()
    {
        return view("transactions",[
            "transactions"=>Transaction::all()
        ]);
    }

}