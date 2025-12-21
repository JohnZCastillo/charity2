<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\HomeContent;
use Illuminate\Support\Facades\Storage;
use App\Models\AboutContent;
use Illuminate\Support\Facades\Log;
use App\Models\ActivityLog;
use App\Models\NavigationContent;
use App\Models\PaymentMethod;
use Exception;

class EditorController extends Controller
{
    public function index()
    {
        try{
            $user = User::findOrFail(1);
            $home = HomeContent::first();

            $paymentMethods = PaymentMethod::all();

            
            if ($home) {
                $home->team_members = $home->team_members ?? [];
                $home->section_cards = $home->section_cards ?? [];
                $home->additional_sections = $home->additional_sections ?? [];
            }
        
            $sections = AboutContent::orderBy('order')->get();
            ActivityLog::create([
                'user_id' => auth()->user()->id,
                'activity' => 'Visited Editor page.'
            ]);


            return view('inventory.editor', [
                'user' => $user,
                'home' => $home,
                'sections' => $sections,
                'paymentMethods' => $paymentMethods
            ]);
        }catch(Exception $e){
            dd($e->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
            'main_title' => 'nullable|string|max:255',
            'sub_title' => 'nullable|string',
            'cta_button' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:50',
            'contact_email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'about_us' => 'nullable|string',
            'about_title' => 'nullable|string|max:255',
            'about_subtitle' => 'nullable|string|max:255',
            'about_description' => 'nullable|string',
            'section_title' => 'nullable|string|max:255',
            'section_subtitle' => 'nullable|string|max:255',
            'section_cards' => 'nullable|array',
            'section_cards.*.title' => 'nullable|string|max:255',
            'section_cards.*.description' => 'nullable|string',
            'team_title' => 'nullable|string|max:255',
            'team_members' => 'nullable|array',
            'team_members.*.name' => 'nullable|string|max:255',
            'team_members.*.image' => 'nullable|file|image|max:2048',
            'system_title' => 'nullable|string|max:255',
            'system_logo' => 'nullable|file|image|max:2048',
            'additional_sections' => 'nullable|array',
            'additional_sections.*.title' => 'nullable|string|max:255',
            'additional_sections.*.subtitle' => 'nullable|string|max:255',
            'additional_sections.*.description' => 'nullable|string',
            'additional_sections.*.image' => 'nullable|file|image|max:2048',
            'hero_images'   => 'nullable|array', // must be an array
            'hero_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5048', // each file
            'about_images' => 'nullable|array',
            'about_images.*' => 'nullable|file|image|max:2048',


        ]);

        $data = $validated;

        // Handle logo
        if ($request->hasFile('system_logo')) {
            $logo = $request->file('system_logo');
            $logoName = time() . '_' . uniqid() . '.' . $logo->getClientOriginalExtension();

            // Move to public/logos folder
            $logo->move(public_path('logos'), $logoName);

            $data['system_logo'] = "/logos/{$logoName}";
        } else {
            $existing = HomeContent::find(1);
            $data['system_logo'] = $existing?->system_logo;
        }

        // Team members
        $team_members = [];
        foreach ($request->input('team_members', []) as $index => $member) {
            $imagePath = $member['existing_image'] ?? '';

            if ($request->hasFile("team_members.$index.image")) {
                $image = $request->file("team_members.$index.image");
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                // Move to public/team folder
                $image->move(public_path('team'), $imageName);

                $imagePath = "/team/{$imageName}";
            }

            $team_members[] = [
                'name' => $member['name'] ?? '',
                'image' => $imagePath,
            ];
        }
        $data['team_members'] = $team_members;


        // Additional Sections
        $additional_sections = [];
        foreach ($request->input('additional_sections', []) as $index => $section) {
            $imagePath = $section['existing_image'] ?? '';
            if ($request->hasFile("additional_sections.$index.image")) {
                $imagePath = $request->file("additional_sections.$index.image")->store('additional_sections', 'public');
                $imagePath = "/storage/{$imagePath}";
            }
            $additional_sections[] = [
                'title' => $section['title'] ?? '',
                'subtitle' => $section['subtitle'] ?? '',
                'description' => $section['description'] ?? '',
                'image' => $imagePath,
            ];
        }
        $data['additional_sections'] = $additional_sections;

        $data['section_cards'] = $request->input('section_cards', []);

        // Handle Hero Images (multiple)
        if ($request->hasFile('hero_images')) {
            $heroPaths = [];
            foreach ($request->file('hero_images') as $file) {
                $path = $file->store('hero', 'public');
                $heroPaths[] = "/storage/{$path}";
            }
            $data['hero_images'] = $heroPaths;
        } else {
            $data['hero_images'] = $request->input('existing_hero_images', []);
        }

        // About Images
        $aboutImagePaths = [];

        if ($request->hasFile('about_images')) {
            foreach ($request->file('about_images') as $imgFile) {
                $path = $imgFile->store('about_images', 'public');
                $aboutImagePaths[] = "/storage/{$path}";
            }
        } else {
            // retain existing images if no new uploads
            $existing = HomeContent::find(1);
            $aboutImagePaths = $existing?->about_images ?? [];
        }

        $data['about_images'] = $aboutImagePaths;

         HomeContent::updateOrCreate(['id' => 1], $data);

          ActivityLog::create([
             'user_id' => auth()->user()->id,
            'activity' => 'Updated elements at Editor page.'
        ]);
        return redirect()->back()->with('message', 'Home Page updated successfully!');
        } catch (\Exception $e) {
            Log::error('Home page update error: '.$e->getMessage());
            return redirect()->back()->with('error', 'Failed to update Home Page. Please try again.');
        }
    }
}
