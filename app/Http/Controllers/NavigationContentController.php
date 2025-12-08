<?php

namespace App\Http\Controllers;

use App\Models\NavigationContent;
use App\Http\Requests\StoreNavigationContentRequest;
use App\Http\Requests\UpdateNavigationContentRequest;

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


        $validated = $request->validate([
            'email' => 'required',
            'mobile' => 'required',
            'social' => 'required'
        ]);

        $navigationContent = NavigationContent::findOrFail($id);

        $navigationContent->email = $validated['email'];
        $navigationContent->mobile = $validated['mobile'];

        foreach ($validated['social'] as $key => $social) {
              
            $targetSocial = array_find($navigationContent->social, function($target) use($key){
                    return $target->id == $key;
                });

            dd($targetSocial);
        }

        // return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NavigationContent $navigationContent)
    {
        //
    }
}
