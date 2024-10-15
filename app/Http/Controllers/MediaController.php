<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class MediaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /* 
    --------------------------------------------------------------
    | Store File In server and return the path
    --------------------------------------------------------------
    */
    public function store(Request $request, $folderName, $name)
    {
        $request->validate([
            'files.*' => 'required|file|mimes:jpeg,png,jpg,gif,svg,mp4,webm,ogg,mp3,wav,flac,zip,rar|max:2048',
        ]);

        $file = $request->file('files');
        $path = $this->uploadFile($folderName, $name, $file);

        return response()->json([
            'message' => 'File uploaded successfully',
            'path' => $path
        ]);
    }

    /* 
    --------------------------------------------------------------
    | Store Multiple Files In server For CKEDITOR
    | and return path of files
    --------------------------------------------------------------
    */
    public function ckEditorUpload(Request $request, $folderName)
    {
        if ($request->hasFile('upload')) {
                $originName = $request->file('upload')->getClientOriginalName();
                $fileName = str::slug(pathinfo($originName, PATHINFO_FILENAME));
                $extension = $request->file('upload')->getClientOriginalExtension();
                $fileName = $fileName . '.' . $extension;
                $folderName = Str::slug($folderName);
                $uuid = (string) Str::uuid();
                $path = '/uploads/' . $folderName . '/ck-editor/' . $uuid;

                // Ensure directory exists with proper permissions
                if (!File::isDirectory(public_path($path))) {
                    File::makeDirectory(public_path($path), 0777, true, true);
                }

                $request->file('upload')->move(public_path($path), $fileName);

                $url = asset($path . '/' . $fileName);
                return response()->json(['fileName' => $fileName, 'uploaded' => 1, 'url' => $url]);
            }
    }

    /* 
    --------------------------------------------------------------
    | Remove File From server when dropzone trigger removeFile event,
    | first Check if file exists and delete, 
    | file must be in uploads directory
    --------------------------------------------------------------
    */
    public function removeFile(Request $request)
    {
        try {
            $path = $request->input('file_path');
            $path = str_replace(url('/'), '', $path);
            $path = public_path($path);
            // Validate if the path is within the uploads directory
            if (strpos($path, public_path('uploads')) !== false) {
                if (File::exists($path)) {
                    File::delete($path);
                    $directory = dirname($path);
                    if (is_dir($directory)) {
                        File::deleteDirectory($directory);
                    }
                }
            } else {
                Log::error('Attempted to delete a file outside the uploads directory: ' . $path);
            }

            return response()->json([
                'message' => 'File deleted successfully'
            ]);
        } catch (\Exception $e) {
            // Log the error message
            Log::error('File deletion error: ' . $e->getMessage());
        }
    }

 
    /**
     * Uploads a file to the specified folder. If the folder does not exist, it will be created.
     * The file will be stored in a subdirectory named after the file ID.
     *
     * @param string $folderName The name of the folder to upload the file to.
     * @param string $name The name of the file.
     * @param \Illuminate\Http\UploadedFile $file The file to be uploaded.
     * @return string|null The path to the uploaded file, or null if an error occurred.
     */
    private function uploadFile($folderName, $name, $file)
    {
        try {
            $fileId = (string) Str::uuid();
            $fileName = $file->getClientOriginalName();
            $folderName = Str::slug($folderName);
            $name = Str::slug($name);

            $path = 'uploads/' . $folderName . '/' . $name;
            if($name == 'cover' || $name == 'certificate') {
                $dirPath = $path;
            } else {
                $dirPath = $path . '/' . $fileId;
            }
            
            // Delete the old directory if it exists
            if (File::isDirectory(public_path($dirPath))) {
                File::deleteDirectory(public_path($dirPath));
            }

            // Ensure directory exists with proper permissions
            if (!File::isDirectory(public_path($dirPath))) {
                File::makeDirectory(public_path($dirPath), 0777, true, true);
            }

            // Move the file, handling potential errors
            if (!$file->move(public_path($dirPath), $fileName)) {
                return ResponseFormatter::error('Failed to move uploaded file.');
            }

            $path = $dirPath . '/' . $fileName;
            return $path;
        } catch (\Exception $e) {
            // Log or display error message
            Log::error('File upload error: ' . $e->getMessage());
        }
    }
}
