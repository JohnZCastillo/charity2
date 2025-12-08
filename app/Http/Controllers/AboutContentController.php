<?php

namespace App\Http\Controllers;

use App\Models\AboutContent;
use Illuminate\Http\Request;
use App\Models\ActivityLog;

class AboutContentController extends Controller
{
    public function index()
    {
        return response()->json(AboutContent::orderBy('order')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'content_list' => 'nullable|array',
            'image' => 'nullable|image|max:6048',
            'group' => 'required|string|max:100',
            'type' => 'required|string|max:50',
            'order' => 'nullable|integer',
        ]);

        // Handle list content → save as newline-separated string
        if ($request->type === 'list' && $request->filled('content_list')) {
            $validated['content'] = implode("\n", array_filter($request->content_list));
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('about_images', 'public');
            $validated['image'] = "/storage/{$path}";
        }

        AboutContent::create($validated);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => 'About section added.'
        ]);

        return back()->with('success', 'About section added.');
    }

    public function update(Request $request, $id)
    {
        $section = AboutContent::findOrFail($id);

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'content_list' => 'nullable|array',
            'image' => 'nullable|image|max:2048',
            'group' => 'required|string|max:100',
            'type' => 'required|string|max:50',
        ]);

        // Handle list content → save as newline-separated string
        if ($request->type === 'list' && $request->filled('content_list')) {
            $validated['content'] = implode("\n", array_filter($request->content_list));
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('about_images', 'public');
            $validated['image'] = "/storage/{$path}";
        }

        $section->update($validated);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => 'About section updated.'
        ]);

        return response()->json(['status' => 'success']);
    }

    public function destroy($id)
    {
        AboutContent::destroy($id);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => 'About section element deleted.'
        ]);

        return response()->json(['status' => 'deleted']);
    }

    public function reorder(Request $request)
    {
        $orderData = $request->input('order');

        foreach ($orderData as $item) {
            AboutContent::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => 'About section reordered.'
        ]);

        return response()->json(['status' => 'success']);
    }
}
