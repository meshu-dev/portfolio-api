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
        $params = $request->except('user');
        $params['user_id'] = $request->get('user')->id;

        $row = $this->typeRepository->add($params);

        return new TypeResource($row);
    }

    public function get(Request $request, int $id)
    {
        $userId = $request->get('user')->id;
        $row    = $this->typeRepository->get($userId, $id);

        return new TypeResource($row);
    }

    public function getAll(Request $request)
    {
        $userId = $request->get('user')->id;
        $params = $request->except('user');

        $rows = $this->typeRepository->getAll($userId, $params);

        return TypeResource::collection($rows);
    }

    public function edit(TypeRequest $request, int $id)
    {
        $userId = $request->get('user')->id;
        $params = $request->except('user');

        $this->typeRepository->edit($userId, $id, $params);
        $row = $this->typeRepository->get($userId, $id);

        return new TypeResource($row);
    }

    public function delete(Request $request, int $id)
    {
        $userId = $request->get('user')->id;
        $this->typeRepository->delete($userId, $id);

        return response()->json([], 204);
    }
}
