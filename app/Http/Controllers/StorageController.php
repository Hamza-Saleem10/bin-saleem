<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{
    public function show($foldername, $filename)
    {
        $imageName = $foldername . '/' . $filename;
        $file_path = public_path('storage/'.$imageName);
        
        if (!file_exists($file_path)) {
            abort(404);
        }

        return response()->file(public_path('storage/'.$imageName));
    }
}
