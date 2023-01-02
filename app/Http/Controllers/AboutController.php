<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\AboutRepository;
use App\Http\Resources\AboutResource;
use App\Validators\AboutValidator;

class AboutController extends Controller
{
    protected $resource = AboutResource::class;

    public function __construct(
        protected AboutRepository $aboutRepository,
        protected AboutValidator $aboutValidator
    ) { }

    public function get(Request $request)
    {
        $rows = $this->aboutRepository->getAll();
        $row = $rows[0] ?? null;

        return $this->getResponse($row);
    }

    public function edit(Request $request, int $id)
    {
        $params = $request->all();
        $this->aboutValidator->verifyEdit($id, $params);

        $isUpdated = $this->aboutRepository->edit($id, $params);
        $row = null;

        if ($isUpdated == true) {
            $row = $this->aboutRepository->get($id);
        }

        return $this->getResponse($row);
    }
}
