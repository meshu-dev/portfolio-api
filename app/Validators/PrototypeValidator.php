<?php
namespace App\Validators;

use App\Exceptions\ValidationException;

class PrototypeValidator extends ApiValidator
{
    protected $existsRules = [
        'id' => 'required|exists:App\Models\Prototype,id'
    ];

    protected $rules = [
        'name' => [
            'required',
            'min:3',
            'max:100'
        ],
        'description' => 'required',
        'typeId' => 'required|exists:App\Models\Type,id',
        'repositoryIds' => 'required|array',
        'technologyIds' => 'required|array'
    ];

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

    protected function addUniqueRule($id = 0)
    {
        $this->rules['name'][] = $this->getUniqueRule('prototypes', $id);
    }
}
