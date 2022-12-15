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
        'name' => 'required|max:100|unique:App\Models\Repository,name'
    ];

    public function __construct(protected RepositoryService $repositoryService) { }

    public function verifyEdit(int $id, array $params): ValidationException|bool
    {
        $this->rules['name'] = [
            $this->rules['name'],
            $this->getUniqueRule('repositories', $id)
        ];

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
}
