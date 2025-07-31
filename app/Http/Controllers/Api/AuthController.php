<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:attendees,email',
            'password' => 'required|string|confirmed|min:6',
            'course' => 'required|string',
            'gender' => 'required|in:Male,Female',
            'year_level_id' => 'required|exists:year_levels,id',
            'role' => 'required|in:Attendee,SBO',
            'position' => 'nullable|string|required_if:role,SBO',
        ]);

        $attendee = Attendee::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'course' => $request->course,
            'gender' => $request->gender,
            'year_level_id' => $request->year_level_id,
            'role' => $request->role,
            'position' => $request->role === 'SBO' ? $request->position : null,
        ]);

        // Auto-create qrcodes folder
        $qrPath = public_path('qrcodes');
        if (!File::exists($qrPath)) {
            File::makeDirectory($qrPath, 0755, true);
        }

        // Generate and save QR code
        $qrCodeName = Str::uuid() . '.png';
        $qrCodePath = 'qrcodes/' . $qrCodeName;
        QrCode::format('png')->size(300)->generate($attendee->id, public_path($qrCodePath));

        $attendee->qr_code_path = $qrCodePath;
        $attendee->save();

        return response()->json([
            'message' => 'Registration successful!',
            'attendee' => $attendee
        ]);
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = Attendee::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function me(Request $request)
    {
        $user = $request->user()->load('yearLevel');

        return response()->json([
            'id' => $user->id,
            'full_name' => $user->full_name,
            'email' => $user->email,
            'course' => $user->course,
            'gender' => $user->gender,
            'year_level' => $user->yearLevel->label ?? null,
            'qr_code_path' => $user->qr_code_path,
            'role' => $user->role,
            'position' => $user->position,
            'has_attended' => $user->has_attended,
        ]);
    }

    public function showQr($id, Request $request)
    {
        $authUser = $request->user();

        if ($authUser->role === 'Attendee' && $authUser->id != $id) {
            return response()->json(['message' => 'Unauthorized to view this QR code.'], 403);
        }

        $attendee = Attendee::with('yearLevel')->findOrFail($id);

        return response()->json([
            'qr_code_path' => $attendee->qr_code_path,
            'full_name' => $attendee->full_name,
            'email' => $attendee->email,
            'course' => $attendee->course,
            'year_level' => $attendee->yearLevel->label ?? null,
            'has_attended' => $attendee->has_attended,
        ]);
    }

    public function attendeesList(Request $request)
    {
        $user = $request->user();

        if ($user->role !== 'SBO') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $attendees = Attendee::with('yearLevel')
            ->where('role', 'Attendee')
            ->get()
            ->map(function ($attendee) {
                return [
                    'id' => $attendee->id,
                    'full_name' => $attendee->full_name,
                    'email' => $attendee->email,
                    'course' => $attendee->course,
                    'gender' => $attendee->gender,
                    'year_level' => $attendee->yearLevel->label ?? null,
                    'qr_code_path' => $attendee->qr_code_path,
                    'has_attended' => $attendee->has_attended,
                ];
            });

        return response()->json($attendees);
    }

    public function scan($id, Request $request)
    {
        $user = $request->user();

        if ($user->role !== 'SBO') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $attendee = Attendee::findOrFail($id);

        if ($attendee->has_attended) {
            return response()->json(['message' => 'Already marked as attended.', 'attendee' => $attendee]);
        }

        $attendee->has_attended = true;
        $attendee->save();

        return response()->json(['message' => 'Attendance marked successfully.', 'attendee' => $attendee]);
    }

    public function scanQr(Request $request, $id)
    {
        $user = $request->user();

        if ($user->role !== 'SBO') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $attendee = Attendee::findOrFail($id);

        if ($attendee->has_attended) {
            return response()->json(['message' => 'Already attended.'], 200);
        }

        $attendee->has_attended = true;
        $attendee->save();

        return response()->json([
            'message' => 'Attendance marked for ' . $attendee->full_name,
            'attendee' => $attendee,
        ]);
    }
}
