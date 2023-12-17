<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ProfileResource;
use App\Http\Requests\ProfileRequest;
use App\Repositories\ProfileRepository;

class ProfileController extends Controller
{
    public function __construct(
        protected ProfileRepository $profileRepository
    ) {
    }

    public function add(ProfileRequest $request)
    {
        $params = $request->except('user');
        $params['user_id'] = $request->get('user')->id;

        $row = $this->profileRepository->add($params);

        return new ProfileResource($row);
    }

    public function get(Request $request, int $id)
    {
        $userId = $request->get('user')->id;
        $row = $this->profileRepository->get($userId, $id);

        return new ProfileResource($row);
    }

    public function getByUser(Request $request)
    {
        $userId = $request->get('user')->id;
        $row = $this->profileRepository->getByUserId($userId);

        return new ProfileResource($row);
    }

    public function getAll(Request $request)
    {
        $userId = $request->get('user')->id;
        $params = $request->except('user');

        $rows = $this->profileRepository->getAll($userId, $params);

        return ProfileResource::collection($rows);
    }

    public function edit(AboutRequest $request, int $id)
    {
        $userId = $request->get('user')->id;
        $params = $request->except('user');

        $this->profileRepository->edit($userId, $id, $params);
        $row = $this->profileRepository->get($id);

        return new ProfileResource($row);
    }

    public function delete(Request $request, int $id)
    {
        $userId = $request->get('user')->id;
        $this->profileRepository->delete($userId, $id);

        return response()->json([], 204);
    }
}
