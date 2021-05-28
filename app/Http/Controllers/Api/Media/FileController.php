<?php

namespace App\Http\Controllers\Api\Media;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

use App\Models\Media as Model;
use App\Http\Resources\Media\FileResource as Resource;
use App\Http\Requests\Media\FileRequest as ValidateRequest;
use Spatie\QueryBuilder\AllowedFilter;
use Plank\Mediable\Facades\MediaUploader;



class FileController extends Controller
{
    /**
     * Display a listing of files.
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $builder = QueryBuilder::for(Model::class)
            ->allowedFilters([
                'name'
            ]);

        return Resource::collection(

            $request->get('pageSize') !== '-1'
                ?
                $builder->paginate($request->get('pageSize'), ['*'], 'page')
                :
                $builder->get()

        );
    }


    /**
     * create a new file.
     *
     * @param  \App\Http\Requests\Media\FileRequest $request
     * @return \App\Http\Resources\Media\FileResource 
     */
    public function store(ValidateRequest $request): Resource
    {
        $data = $request->validated();
        $item = MediaUploader::fromSource($data['file'])->upload();
        $resoure = new Resource($item);
         return $resoure
            ->additional(
                 [
                     'meta' =>
                        [
                            'message' => 'File uploaded',
                        ]
                 ]
            );
    }


 
}