<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\TypeResource;
use App\Http\Requests\TypeRequest;
use App\Repositories\TypeRepository;

class TypeController extends Controller
{
    public function __construct(
        protected TypeRepository $typeRepository
    ) {
    }

    public function add(TypeRequest $request)
    {
        $user = auth()->user();

        $params = $request->all();
        $params['user_id'] = $user->id;

        $row = $this->typeRepository->add($params);

        return new TypeResource($row);
    }

    public function get(Request $request, int $id)
    {
        $row = $this->typeRepository->get($id);

        return new TypeResource($row);
    }

    public function getAll(Request $request)
    {
        $params = $request->all();
        $rows = $this->typeRepository->getAll($params);

        return TypeResource::collection($rows);
    }

    public function edit(TypeRequest $request, int $id)
    {
        $params = $request->all();

        $isUpdated = $this->typeRepository->edit($id, $params);
        $row = null;

        if ($isUpdated == true) {
            $row = $this->typeRepository->get($id);
        }

        return new TypeResource($row);
    }

    public function delete(Request $request, int $id)
    {
        $this->typeRepository->delete($id);

        return response()->json([], 204);
    }
}
