<?php

namespace App\Http\Controllers;

use App\Helpers\OtpHelper;
use App\Helpers\SlotFinder;
use App\Mail\OtpEmail;
use App\Models\Otp;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class APIController extends Controller
{

    public function slot($date, Request $request)
    {

        $slots = SlotFinder::getAvailableSlot($date, $request->input('appointment'));

        return response()->json($slots);
    }

    public function otp(Request $request){
        try{

        
            $validated = $request->validate([
                'email' => 'required',
            ]);

            $generatedOtp = OtpHelper::generateVerificationCode();

            Otp::create([
                'email' => $validated['email'],
                'code' => $generatedOtp['code'],
                'session_id' =>  Session::getId(),
            ]);
            
            Mail::to($validated['email'])->send(new OtpEmail( $generatedOtp['code']));

            return response()->json(['message' => 'email sent']);

        }catch(Exception $e){
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function verifyOtp(Request $request){
        
        $validated = $request->validate([
            'code' => 'required',
            'email' => 'required',
        ]);

        try{

            $otp = Otp::where('code', $validated['code'])
                ->where('email', $validated['email'])
                ->where('session_id',  Session::getId())
                ->where('used',  false)
                ->where('created_at', '>=', Carbon::now()->subMinutes(5))
                ->firstOrFail();

                $otp->update([
                    'used' => true
                ]);

            return response()->json(['message' => 'valid code']);       

        }catch(Exception $e){
            return response()->json(['message' => 'invalid or expired code'], 400);       
        }
    }
}
