<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomeContent;

class HomeContentController extends Controller
{
   public function updateQrCode(Request $request)
{
    $request->validate([
        'qr_code_path' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
    ]);

    $home = HomeContent::firstOrCreate([]);

    // Upload QR image if provided
    if ($request->hasFile('qr_code_path')) {
        $file = $request->file('qr_code_path');
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        // Move to public/uploads/qrcodes
        $file->move(public_path('uploads/qrcodes'), $filename);

        $home->qr_code_path = 'uploads/qrcodes/' . $filename;
    } elseif ($request->filled('existing_qr_code_path')) {
        $home->qr_code_path = $request->input('existing_qr_code_path');
    }

    $home->save();

    return response()->json([
        'success' => true,
        'message' => 'QR Code updated successfully!',
        'qr_code_path' => asset($home->qr_code_path)
    ]);
}

}
