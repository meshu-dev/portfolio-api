<?php
namespace App\Validators;

use Illuminate\Validation\Rule;
use App\Exceptions\ValidationException;
use App\Services\TypeService;

class TypeValidator extends ApiValidator
{
    protected $existsRules = [
        'id' => 'required|exists:App\Models\Type,id'
    ];

    protected $rules = [
        'name' => 'required|max:100'
    ];

    public function __construct(protected TypeService $typeService) { }

    public function verifyEdit(int $id, array $params): ValidationException|bool
    {
        $this->rules['name'] = [
            $this->rules['name'],
            $this->getUniqueRule('types', $id)
        ];

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
}
