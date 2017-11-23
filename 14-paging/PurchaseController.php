<?php

namespace App\Http\Controllers;

use App\Purchase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return Auth::user()->purchases()->orderBy('date', 'desc')->paginate(15);
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'date' => 'required|date',
            'price' => 'required|numeric',
            'description' => 'required'
        ]);

        // Instantiate model
        $purchase = new Purchase;

        // Assign data to model
        $purchase->user_id = Auth::id();
        $purchase->date = $request->date;
        $purchase->price = $request->price;
        $purchase->description = $request->description;

        // Save purchase
        $purchase->save();
    }

    public function update(Request $request, $id)
    {
        // Find the purchase
        $purchase = Auth::user()->purchases()->find($id);

        // Return 404 if can't find purchase
        if (! $purchase) {
            return new Response('', 404);
        }

        // Validate the request
        $request->validate([
            'date' => 'required|date',
            'price' => 'required|numeric',
            'description' => 'required'
        ]);

        // Assign data to model
        $purchase->user_id = Auth::id();
        $purchase->date = $request->date;
        $purchase->price = $request->price;
        $purchase->description = $request->description;

        // Save the purchase
        $purchase->save();
    }

    public function destroy($id)
    {
        // Find the purchase
        $purchase = Auth::user()->purchases()->find($id);

        // Return 404 if can't find the purchase
        if (! $purchase) {
            return new Response('', 404);
        }

        // Delete the purchase
        $purchase->delete();
    }
}
