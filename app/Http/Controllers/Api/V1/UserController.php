<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\Controller;

use App\Http\Requests\Api\V1\User as Request;

use App\Http\Resources\OperationSuccessResource;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserTokenResource;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\Repositories\UserRepositoryInterface;


class UserController extends Controller
{
    private $repository;

    public function __construct()
    {
        $this->repository = app(UserRepositoryInterface::class);
    }

    /**
     * SignUp
     *
     * @response {
     *  "user" => USER DETAIL,
     *  "token" => STRING OF TOKEN,
     *
     * }
     *
     * @group Authenticating requests
     *
     * @param Request\SignUpRequest $request
     * @return UserTokenResource
     *
     */
    public function signUp(Request\SignUpRequest $request): UserTokenResource
    {
        $result = $this->repository->signUp($request->only(["username", "email", "password"]));
        return new UserTokenResource($result);
    }

    /**
     * SignIn
     *
     * @response {
     *  "user" => USER DETAIL,
     *  "token" => STRING OF TOKEN,
     * }
     *
     * @group Authenticating requests
     *
     * @param Request\SignInRequest $request
     * @return UserTokenResource
     */
    public function SignIn(Request\SignInRequest $request): UserTokenResource
    {
        dd( $url = \Illuminate\Support\Facades\Request::root());
        $inputs = $request->all();
        $result = $this->repository->signIn($inputs);
        return new UserTokenResource($result);
    }

    /**
     * Signout
     *
     * @apiResource App\Http\Resources\OperationSuccessResource
     * @apiResourceModel App\Models\User\User
     *
     * @group Authenticating requests
     *
     * @param Request\SignOutRequest $request
     * @return OperationSuccessResource
     */
    public function SignOut(Request\SignOutRequest $request): OperationSuccessResource
    {
        $result = $this->repository->signOut();
        return new OperationSuccessResource(["operation" => "signOut", 'status' => true]);
    }

    /**
     * CurrentUser
     *
     * @authenticated
     * @apiResource App\Http\Resources\User\UserResource
     * @apiResourceModel App\Models\User\User
     *
     * @group Authenticating requests
     *
     * @param Request\CurrentUserRequest $request
     * @return UserResource
     */
    public function currentUser(Request\CurrentUserRequest $request): UserResource
    {
        $result = $this->repository->currentUser();
        return new UserResource($result);
    }

}
