<?php

namespace App\Http\Controllers;

use App\Models\NavigationContent;
use App\Http\Requests\StoreNavigationContentRequest;
use App\Http\Requests\UpdateNavigationContentRequest;
use Exception;
use Illuminate\Support\Arr;

class NavigationContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNavigationContentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(NavigationContent $navigationContent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NavigationContent $navigationContent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNavigationContentRequest $request, $id)
    {


        try{

        
        $validated = $request->validate([
            'email' => 'required',
            'mobile' => 'required',
            'social' => 'required'
        ]);

        $navigationContent = NavigationContent::findOrFail($id);

        $navigationContent->email = $validated['email'];
        $navigationContent->mobile = $validated['mobile'];

        $navigationIcons = [];

        foreach($navigationContent->socials as $social){

            $targetSocial = Arr::first($validated['social'], function ($value, $key) use($social) {
                return $social->id == $key;
            });

            if($targetSocial){
                $social->link = $targetSocial;
            }

            $navigationIcons[] = $social;
        }
      
        $navigationContent->socials = $navigationIcons;

        $navigationContent->save();

        return redirect()->back();

        }catch(Exception $e){
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NavigationContent $navigationContent)
    {
        //
    }
}
