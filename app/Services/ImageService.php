<?php

namespace App\Services;

use App\Repositories\ImageRepository;
use App\Repositories\ImageThumbnailRepository;
use Image;

class ImageService
{
    public function __construct(
        protected ImageRepository $imageRepository,
        protected ImageThumbnailRepository $imageThumbnailRepository
    ) {
    }

    public function add($name, $file, $includeThumb = false)
    {
        $image = $this->addUploadedImage($name, $file);

        if ($includeThumb === true) {
            $thumbImage = $this->addThumb($image->id, $name, $file);
        }

        return $image;
    }

    public function delete($imageId)
    {
        $this->imageThumbnailRepository->deleteByImageId($imageId);
        $this->imageRepository->delete($imageId);
    }

    protected function addThumb($imageId, $name, $file)
    {
        $path = 'app/test/thumbs';
        $image = $this->addImage($name, $file, $path, true);
        $url = $this->getUrlPath('thumb', $image->basename);

        $params = [
            'image_id' => $imageId,
            'url' => $url
        ];

        return $this->imageThumbnailRepository->add($params);
    }

    protected function addUploadedImage($name, $file)
    {
        $path = 'app/test/uploads';
        $image = $this->addImage($name, $file, $path);
        $url = $this->getUrlPath('image', $image->basename);

        $params = ['url' => $url];

        return $this->imageRepository->add($params);
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
        return $imgFile;
    }

    protected function getUrlPath($routeName, $filename)
    {
        $url = route($routeName, ['filename' => $filename]);
        $url = parse_url($url, PHP_URL_PATH);

        return $url;
    }
}
