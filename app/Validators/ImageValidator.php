<?php

namespace App\Validators;

use App\Exceptions\ValidationException;
use App\Services\ImageCheckService;

class ImageValidator extends ApiValidator
{
    protected $existsRules = [
        'id' => 'required|exists:App\Models\Image,id'
    ];

    protected $rules = [
        'image' => 'required|file',
        'thumb' => 'in:true,false'
    ];

    public function __construct(protected ImageCheckService $imageCheckService)
    {
    }

    public function verifyDelete(int $id): ValidationException | bool
    {
        $this->verifyExists($id);

        $isUsed = $this->imageCheckService->isUsed($id);

        if ($isUsed === true) {
            throw new ValidationException(
                ['id' => "Image can't be deleted as it's associated with projects and prototypes"]
            );
        }
        return true;
    }
}
