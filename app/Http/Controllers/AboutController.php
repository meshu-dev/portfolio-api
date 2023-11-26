<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\AboutResource;
use App\Http\Requests\AboutRequest;
use App\Repositories\AboutRepository;

class AboutController extends Controller
{
    public function __construct(
        protected AboutRepository $aboutRepository
    ) {
    }

    public function add(AboutRequest $request)
    {
        $params = $request->except('user');
        $params['user_id'] = $request->get('user')->id;

        $row = $this->aboutRepository->add($params);

        return new AboutResource($row);
    }

    public function get(Request $request, int $id)
    {
        $userId = $request->get('user')->id;
        $row = $this->aboutRepository->get($userId, $id);

        return new AboutResource($row);
    }

    public function getAll(Request $request)
    {
        $userId = $request->get('user')->id;
        $params = $request->except('user');

        $rows = $this->aboutRepository->getAll($userId, $params);

        return AboutResource::collection($rows);
    }

    public function edit(AboutRequest $request, int $id)
    {
        $userId = $request->get('user')->id;
        $params = $request->except('user');

        $this->aboutRepository->edit($userId, $id, $params);
        $row = $this->aboutRepository->get($id);

        return new AboutResource($row);
    }

    public function delete(Request $request, int $id)
    {
        $userId = $request->get('user')->id;
        $this->aboutRepository->delete($userId, $id);

        return response()->json([], 204);
    }
}
