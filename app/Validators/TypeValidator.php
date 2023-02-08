<?php

namespace App\Validators;

use App\Exceptions\ValidationException;
use App\Services\TypeService;

class TypeValidator extends ApiValidator
{
    protected $existsRules = [
        'id' => 'required|exists:App\Models\Type,id'
    ];

    protected $rules = [
        'name' => [
            'required',
            'min:3',
            'max:100'
        ]
    ];

    public function __construct(protected TypeService $typeService)
    {
    }

    public function verifyAdd(array $params): ValidationException|bool
    {
        $this->addUniqueRule();

        return parent::verifyAdd($params);
    }

    public function verifyEdit(int $id, array $params): ValidationException|bool
    {
        $this->addUniqueRule($id);

        return parent::verifyEdit($id, $params);
    }

    public function verifyDelete(int $id): ValidationException|bool
    {
        $this->verifyExists($id);

        $isUsed = $this->typeService->isUsed($id);

        if ($isUsed === true) {
            throw new ValidationException(
                ['id' => "Type can't be deleted as it's associated with projects and prototypes"]
            );
        }
        return true;
    }

    protected function addUniqueRule($id = 0)
    {
        $this->rules['name'][] = $this->getUniqueRule('types', $id);
    }
}
