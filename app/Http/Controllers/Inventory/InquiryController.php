<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\InquiryReplyMail;
use App\Models\ActivityLog;

class InquiryController extends Controller
{   
    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();
          ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Deleted an inquiry'
        ]);
        return redirect()->back()->with('success', 'Inquiry deleted successfully.');
    }

    public function markAsRead($id)
    {
        $inquiry = Inquiry::findOrFail($id);
        $inquiry->update(['is_read' => true]);

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Mark as read inquiry of ' .$inquiry->name
        ]);

        return back()->with('message', 'Inquiry marked as read.');
    }

    
    public function reply(Request $request)
    {
        $request->validate([
            'inquiry_id' => 'required|exists:inquiries,id',
            'email' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        // Send email
            Mail::to($request->email)->send(new InquiryReplyMail(
                $request->subject,
                $request->message,
                \App\Models\Inquiry::findOrFail($request->inquiry_id)
            ));

            ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Send a reply mail to the  inquiry of ' .$request->email
            ]);

        return back()->with('success', 'Reply sent successfully!');
    }

    public function index(Request $request)
    {

        $inquiries = Inquiry::when($request->input('search'), function ($query) use ($request) {
            $query->whereLike('name', '%' . $request->input('search') . '%');
            $query->orWhereLike('subject', '%' . $request->input('search') . '%');
            $query->orWhereLike('email', '%' . $request->input('search') . '%');
        })->when($request->input('order'), function ($query) use ($request){
            $query->orderBy($request->input('order'),$request->input('sort'));
        }, function ($query){
            $query->orderBy('created_at','desc');
        })
            ->paginate(10)
            ->appends($request->except('page'));

         ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Visited Inquiry page'
        ]);

        return view('inventory.inquiry', [
            'inquiries' => $inquiries
        ]);
    }

    public function inquire(Request $request)
    {

        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'name' => 'required|string',
                'subject' => 'required|string',
                'email' => 'required|email',
                'message' => 'required|string',
            ]);

            Inquiry::create($validated);

            DB::commit();

            return redirect()->back()->with(['message' => 'Inquiry Sent!']);

        } catch (\Exception $e) {

            DB::rollBack();
            return redirect()->back()->withErrors(['message' => 'Something went wrong while sending inquiry']);
        }

    }
}
