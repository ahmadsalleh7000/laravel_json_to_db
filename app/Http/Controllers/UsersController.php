<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListUsersRequest;
use App\Models\Transaction;

class UsersController extends Controller
{
    // get users with transactions
    public function index(ListUsersRequest $request)
    {
        $validated = $request->validated();
        $transactions = collect(Transaction::When(request()->provider,function($q) use ($validated){
            $q->where("provider",trim($validated['provider']));
        })->When(request()->statusCode,function($q) use ($validated){
            $q->filterByStatus($validated['statusCode']);
        })->When(request()->balanceMin,function($q) use ($validated){
            $q->rangeMin($validated['balanceMin']);
        })->When(request()->balanceMax,function($q) use ($validated){
            $q->rangeMax($validated['balanceMax']);
        })->When(request()->currency,function($q) use ($validated){
            $q->currency($validated['currency']);
        })->get())->groupBy("email");

        return response()->json($transactions);
    }
}