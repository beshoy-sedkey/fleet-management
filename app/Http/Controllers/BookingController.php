<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function book(Request $request){
        $data = $request->all();
        dd($data);
        $data['seat_number']; 
        $data['route'];
        $data['bus'];
        $data['trip'];
        
    }
    public function get(){
        dd(Booking::all());
    }
}
