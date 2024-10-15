<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileUpload;
 
class FileUploadController extends Controller
{
    public function index() 
    {
        $fileUplaods = FileUpload::get();
        return view('file-upload', ['fileUploads' => $fileUplaods]);
    }
  
    public function multipleUpload(Request $request) 
    {
        request()->validate([
            'fileuploads' => 'required',
            'fileuploads.*' => 'mimes:doc,pdf,docx,pptx,zip'
        ]);
  
        $files = $request->file('fileuploads');
        foreach($files as $file){
            $fileUpload = new FileUpload;
            $fileUpload->filename = $file->getClientOriginalName();
            $fileUpload->filepath = $file->store('fileuploads');
            $fileUpload->type= $file->getClientOriginalExtension();
            $fileUpload->save();
        }   
  
        return redirect()->route('fileupload.index')->with('success','Files uploaded successfully!');
    }
}
