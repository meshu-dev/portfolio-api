<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function getImage(Request $request, string $filename)
    {
        $storagePath = storage_path('app/test/uploads');
        $filePath = "$storagePath/$filename";
        
        return $this->getFileResponse($filePath);
    }

    public function getThumb(Request $request, string $filename)
    {
        $storagePath = storage_path('app/test/thumbs');
        $filePath = "$storagePath/$filename";
        
        return $this->getFileResponse($filePath);
    }

    private function getFileResponse($filePath)
    { 
        if (file_exists($filePath) === true) {
            return response()->file(
                $filePath,
                ['Content-Type' => $this->getFileContentType($filePath)]
            );
        }
        abort(404);
    }

    private function getFileContentType($filename)
    {
        list(,$extension) = explode('.', $filename);

        switch ($extension) {
            case 'jpeg':
            case 'jpg';
                $type = 'image/jpeg';
                break;
            case 'gif':
                $type = 'image/gif';
                break;
            case 'png':
                $type = 'image/png';
                break;
        }

        return $type;
    }
}
