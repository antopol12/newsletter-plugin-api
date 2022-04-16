<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Serializer\DataArraySerializer as SerializerDataArraySerializer;
use App\Http\Controllers\Transformers\NewsletterTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use League\Fractal\Manager as MapperDataManager;
use League\Fractal\Resource\Collection;
use NewsletterPluginApi\Entities\Newsletter;
use NewsletterPluginApi\Exceptions\Repositories\NewsletterNotFound;
use NewsletterPluginApi\V1\Newsletters\Conditions\ByEmptyList as NewsletterByEmptyList;
use NewsletterPluginApi\V1\Newsletters\Conditions\ByLists as NewsletterByLists;
use NewsletterPluginApi\V1\Newsletters\Services\CreateNewsletterByCondition;

class NewsletterController extends Controller
{
    /**
     * @param NewsletterTransformer $NewsletterTransformer
     * @param MapperDataManager     $MapperDataManager
     */
    public function __construct(NewsletterTransformer $NewsletterTransformer, MapperDataManager $MapperDataManager)
    {
        $this->NewsletterTransformer = $NewsletterTransformer;
        $this->MapperDataManager = $MapperDataManager->setSerializer(new SerializerDataArraySerializer());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $Request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\BadRequest
     */
    public function create(Request $Request)
    {
        $dataRequest = $Request->all();
        $Newsletter = (new CreateNewsletterByCondition(new NewsletterByLists()))->__invoke($dataRequest);
        $data = new Collection([$Newsletter], $this->NewsletterTransformer);

        return $this->Response(
            true,
            $this->MapperDataManager->createData($data)->toArray(),
            Response::HTTP_OK,
            ""
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $Request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\BadRequest
     */
    public function createByEmptyList(Request $Request)
    {
        $dataRequest = $Request->all();
        $Newsletter = (new CreateNewsletterByCondition(new NewsletterByEmptyList()))->__invoke($dataRequest);
        $data = new Collection([$Newsletter], $this->NewsletterTransformer);

        return $this->Response(
            true,
            $this->MapperDataManager->createData($data)->toArray(),
            Response::HTTP_OK,
            ""
        );
    }

    /**
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws NewsletterNotFound
     */
    public function show($id)
    {
        $Newsletter = Newsletter::where("id", $id)->get();

        if(count($Newsletter)<1)
            throw new NewsletterNotFound("newsletter {$id} not found");

        $data = new Collection($Newsletter, $this->NewsletterTransformer);

        return $this->Response(
            true,
            $this->MapperDataManager->createData($data)->toArray(),
            Response::HTTP_OK,
            ""
        );
    }
}
