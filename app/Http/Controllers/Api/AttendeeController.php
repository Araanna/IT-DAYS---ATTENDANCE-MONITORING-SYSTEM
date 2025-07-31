<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendee;

class AttendeeController extends Controller
{
    public function index()
    {
        $attendees = Attendee::all();

        return response()->json([
            'message' => 'All attendees fetched successfully.',
            'data' => $attendees
        ]);
    }
}
