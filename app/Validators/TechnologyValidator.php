<?php
namespace App\Validators;

use Illuminate\Validation\Rule;
use App\Exceptions\ValidationException;
use App\Services\TechnologyService;

class TechnologyValidator extends ApiValidator
{
    protected $existsRules = [
        'id' => 'required|exists:App\Models\Technology,id'
    ];

    protected $rules = [
        'name' => 'required|max:100'
    ];

    public function __construct(protected TechnologyService $technologyService) { }

    public function verifyEdit(int $id, array $params): ValidationException|bool
    {
        $this->rules['name'] = [
            $this->rules['name'],
            $this->getUniqueRule('technologies', $id)
        ];

        return parent::verifyEdit($id, $params);
    }

    public function verifyDelete(int $id): ValidationException|bool
    {
        $this->verifyExists($id);
        
        $isUsed = $this->technologyService->isUsed($id);

        if ($isUsed === true) {
            throw new ValidationException(
                ['id' => "Technology can't be deleted as it's associated with projects and prototypes"]
            );
        }
        return true;
    }
}
