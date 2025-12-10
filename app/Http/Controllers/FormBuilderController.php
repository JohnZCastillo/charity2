<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\FormResponse;
use Illuminate\Support\Str;
use App\Models\ActivityLog;

class FormBuilderController extends Controller
{
    //
    public function index()
    {
        $forms = Form::latest()->get();
         ActivityLog::create([
             'user_id' => auth()->user()->id,
            'activity' => 'Visited Form Builder page.'
        ]);
        return view('inventory.form-index', compact('forms'));
    }
    public function create()
    {
        ActivityLog::create([
             'user_id' => auth()->user()->id,
            'activity' => 'Visited Create Form page.'
        ]);
        return view('inventory.form-builder');
    }
    
  public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'form_structure' => 'required|json',
            'response_limit' => 'nullable|integer|min:1',
        ]);

        Form::create([
            'title' => $request->title,
            'structure' => json_decode($request->form_structure, true),
            'response_limit' => $request->response_limit,
        ]);

         ActivityLog::create([
             'user_id' => auth()->user()->id,
            'activity' => 'Created new form, '.$request->title
        ]);

        return redirect()->route('form-builder.index')->with('success', 'Form saved successfully!');
    }


    public function show(Form $form)
    {   
         ActivityLog::create([
             'user_id' => auth()->user()->id,
            'activity' => 'Viewed a form.'
        ]);
        return view('inventory.show-form', compact('form'));
    }

    public function publicShow(Request $request, $id)
    {

        $eventID = $request->query('event_id', null);

        $form = \App\Models\Form::find($id);

        if (!$form) {
            return response()->view('inventory.form-not-found', [], 404);
        }

        return view('inventory.public-show-form', compact('form', 'eventID'));
    }


    public function destroy($id)
    {
        $form = Form::findOrFail($id);
        $form->delete();
         ActivityLog::create([
             'user_id' => auth()->user()->id,
            'activity' => 'Deleted a form.'
        ]);
        return redirect()->route('form-builder.index')->with('success', 'Form deleted successfully.');
    }

    public function submit(Request $request, $formId)
    {

        $form = Form::findOrFail($formId);
       
    // ✅ Enforce response limit if set
        if ($form->response_limit !== null && $form->responses()->count() >= $form->response_limit) {
            $submittedCount = $form->responses()->count();
            return back()->withErrors([
                'form_limit' => "This form has reached its response limit of {$form->response_limit} submissions. Current count: {$submittedCount}."
            ]);
       }
    
        $fields = is_array($form->structure) ? $form->structure : json_decode($form->structure, true);
        $responses = [];
    
        $mimeTypes = [
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png'  => 'image/png',
            'pdf'  => 'application/pdf',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'doc'  => 'application/msword',
        ];
    
        foreach ($fields as $field) {
            $key = 'field_' . $field['id'];
            $label = $field['label'] ?? $key;
            $type = $field['type'] ?? 'text';
    
            if ($type === 'upload' && $request->hasFile($key)) {
                $file = $request->file($key);
                $ext = strtolower($file->getClientOriginalExtension());
    
                if (!empty($field['maxSize']) && $file->getSize() > ($field['maxSize'] * 1024 * 1024)) {
                    return back()->withErrors([$key => "File exceeds max size of {$field['maxSize']}MB."]);
                }
    
                $allowedExts = $field['options'] ?? [];
                if (!in_array($ext, $allowedExts)) {
                    return back()->withErrors([$key => 'File type not allowed. Allowed: ' . implode(', ', $allowedExts)]);
                }
    
                if (isset($mimeTypes[$ext]) && $file->getMimeType() !== $mimeTypes[$ext]) {
                    return back()->withErrors([$key => "Invalid file format. Expected: " . $mimeTypes[$ext]]);
                }
    
                $safeTitle = \Str::slug($form->title ?? 'untitled');
                $folder = "forms/{$safeTitle}";
                $publicFolder = public_path($folder);
    
                if (!file_exists($publicFolder)) {
                    mkdir($publicFolder, 0755, true);
                }
    
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move($publicFolder, $filename);
    
                $responses[$label] = "{$folder}/{$filename}";
            } elseif ($type === 'checkbox') {
                $responses[$label] = $request->input($key, []);
            } else {
                $responses[$label] = $request->input($key);
            }
        }
    
        // ✅ Save response to DB
        FormResponse::create([
            'form_id' => $form->id,
            'response' => $responses,
            'event_id' => $request->input('event_id', null)
        ]);
    
        return back()->with('submitted', $responses);
    }
    

    public function responses(Request $request, $id)
    {
        $form = Form::with([
            'responses' => function($qb) use($request){
                $qb->when($request->query('event_id', false), function($qb) use($request){
                    return $qb->where('event_id', $request->query('event_id'));
                });
            },
        ])->findOrFail($id);

         ActivityLog::create([
             'user_id' => auth()->user()->id,
            'activity' => 'Viewed Form Responses.'
        ]);

        return view('inventory.form-responses', compact('form'));
    }

    public function edit($id)
    {
        $form = Form::findOrFail($id);
        $structure = is_array($form->structure) ? $form->structure : json_decode($form->structure, true);
         ActivityLog::create([
             'user_id' => auth()->user()->id,
            'activity' => 'Viewed edit form, ' .$form->title
        ]);
        return view('inventory.edit-form-builder', compact('form', 'structure'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'response_limit' => 'nullable|integer|min:1',
            'form_structure' => 'required|json',
        ]);
    
        $form = Form::findOrFail($id);
        $form->update([
            'title' => $request->title,
            'response_limit' => $request->response_limit,
            'structure' => json_decode($request->form_structure, true),
        ]);
         ActivityLog::create([
             'user_id' => auth()->user()->id,
            'activity' => 'Updated the form.' .$form->title
        ]);
        return redirect()->route('form-builder.index')->with('success', 'Form updated successfully!');
    }
    


}

