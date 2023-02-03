<?php
namespace App\Validators;

use App\Exceptions\ValidationException;
use App\Services\RepositoryService;

class RepositoryValidator extends ApiValidator
{
    protected $existsRules = [
        'id' => 'required|exists:App\Models\Repository,id'
    ];

    protected $rules = [
        'name' => [
            'required',
            'min:3',
            'max:100'
        ],
        'url' => 'required|url'
    ];

    public function __construct(protected RepositoryService $repositoryService) { }

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
        
        $isUsed = $this->repositoryService->isUsed($id);

        if ($isUsed === true) {
            throw new ValidationException(
                ['id' => "Repository can't be deleted as it's associated with projects and prototypes"]
            );
        }
        return true;
    }

    protected function addUniqueRule($id = 0)
    {
        $this->rules['name'][] = $this->getUniqueRule('repositories', $id);
    }
}
