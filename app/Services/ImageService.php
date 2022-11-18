<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;
use App\Repositories\ImageRepository;
use Image;

class ImageService
{
    public function __construct(
        protected ImageRepository $imageRepository
    ) { }

    public function add($name, $file)
    {
        $image = $this->addUploadedImage($name, $file);
        $thumbImage = $this->addThumb($name, $file);



        dd('Done!', $image, $thumbImage);
    }

    protected function addThumb($name, $file)
    {
        return $this->addImage(
            $name,
            $file,
            "app/test/thumbs",
            true
        );
    }

    protected function addUploadedImage($name, $file)
    {
        return $this->addImage(
            $name,
            $file,
            "app/test/uploads"
        );
    }

    protected function saveImage($file, $filePath, $isThumb = false)
    {
        $imgFile = Image::make($file->getRealPath());

        if ($isThumb === true) {
            $imgFile->resize(150, 150, function ($constraint) {
                $constraint->aspectRatio();
            });
        }
        
        return $imgFile->save($filePath);
    }

    protected function addImage(
        $name,
        $file,
        $storagePath = 'app',
        $isThumb = false
    ) {
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $uploadPath = storage_path($storagePath);
        $filePath = "$uploadPath/$filename";

        $imgFile = $this->saveImage($file, $filePath, $isThumb);

        $params = [
            'name' => $name,
            'url' => $storagePath
        ];
        $row = $this->imageRepository->add($params);
        return $row;
    }
}
