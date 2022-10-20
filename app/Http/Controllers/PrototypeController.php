<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PrototypeRepository;
use App\Http\Resources\PrototypeListResource;
use App\Http\Resources\PrototypeResource;
use App\Validators\PrototypeValidator;

class PrototypeController extends Controller
{
    protected $resource = PrototypeResource::class;

    public function __construct(
        protected PrototypeRepository $prototypeRepository,
        protected PrototypeValidator $prototypeValidator
    ) { }

    public function add(Request $request)
    {
        $params = $request->all();
        $this->prototypeValidator->verifyAdd($params);
        
        $row = $this->prototypeRepository->add($params);

        return $this->getResponse($row, 201);
    }

    public function get(Request $request, int $id)
    {
        $this->prototypeValidator->verifyExists($id);

        $row = $this->prototypeRepository->get($id);

        return $this->getResponse($row);
    }

    public function getAll(Request $request)
    {
        $params = $request->all();
        $rows = $this->prototypeRepository->getAll($params);

        $this->resource = PrototypeListResource::class;
        return $this->getResponse($rows, 200);
    }

    public function edit(Request $request, int $id)
    {
        $params = $request->all();
        $this->prototypeValidator->verifyEdit($id, $params);

        $isUpdated = $this->prototypeRepository->edit($id, $params);
        $row = null;

        if ($isUpdated == true) {
            $row = $this->prototypeRepository->get($id);
        }

        return $this->getResponse($row);
    }

    public function delete(Request $request, int $id)
    {
        $this->prototypeValidator->verifyExists($id);

        $this->prototypeRepository->delete($id);

        return $this->getResponse([], 204);
    }
}
