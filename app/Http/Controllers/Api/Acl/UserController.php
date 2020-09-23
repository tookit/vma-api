<?php

namespace App\Http\Controllers\Api\Acl;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

use App\Models\User as Model;
use App\Http\Resources\Acl\UserResource as Resource;
use App\Http\Requests\Acl\UserRequest as ValidateRequest;
use Spatie\QueryBuilder\AllowedFilter;



class UserController extends Controller
{
    /**
     * Display a listing of users.
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $builder = QueryBuilder::for(Model::class)
            ->with(['roles'])
            ->allowedFilters([
                AllowedFilter::exact('active'),
                AllowedFilter::exact('name'),
            ]);
        return Resource::collection(

            $request->get('pageSize') !== '-1'
                ?
                $builder->paginate($request->get('pageSize'), ['*'], 'page')
                :
                $builder->get()

        );
    }

    public function me()
    {
        $me = Auth::guard('api')->user();
        return new Resource($me);

    }

    /**
     * create a new user.
     *
     * @param  \App\Http\Requests\Acl\UserRequest $request
     * @return \App\Http\Resources\Acl\UserResource
     */
    public function store(ValidateRequest $request): Resource
    {
        return new Resource(Model::create($request->validated()));
    }

    /**
     * Display the specified user.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): Resource
    {
        $item = Model::findOrFail($id);
        return new Resource($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ValidateRequest $request, $id)
    {
        $item = Model::findOrFail($id);
        $item->update($request->validated());
        return new Resource($item);
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Model::findOrFail($id);
        $item->delete();
        return new Resource($item);
    }
}