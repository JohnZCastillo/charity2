<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\EventImage;
use Illuminate\Http\Request;

class EventImageController extends Controller
{

    public function deleteImage(EventImage $eventImage)
    {
        try {
            $eventImage->delete();

            return redirect()->back();

        }catch (\Exception $e){
            return redirect()->back()->withErrors(['message' => 'Something went wrong while deleting image']);
        }
    }
}
