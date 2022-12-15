<?php
namespace App\Validators;

use App\Exceptions\ValidationException;

class ProjectValidator extends ApiValidator
{
    protected $existsRules = [
        'id' => 'required|exists:App\Models\Project,id'
    ];

    protected $rules = [
        'name' => [
            'required',
            'max:100'
        ],
        'description' => 'required',
        'typeId' => 'required',
        'repositoryIds' => 'required',
        'technologyIds' => 'required'
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
        $this->rules['name'][] = $this->getUniqueRule('projects', $id);
    }
}
