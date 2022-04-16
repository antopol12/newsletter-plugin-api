<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Serializer\DataArraySerializer as SerializerDataArraySerializer;
use App\Http\Controllers\Transformers\SubscriberTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use League\Fractal\Manager as MapperDataManager;
use League\Fractal\Resource\Collection;
use NewsletterPluginApi\Entities\Subscriber;
use NewsletterPluginApi\Exceptions\Repositories\SubscriberNotFound;
use NewsletterPluginApi\V1\Subscribers\Conditions\ByLists as SubscriberByLists;
use NewsletterPluginApi\V1\Subscribers\Services\CreateSubscriberByCondition;

class SubscriberController extends Controller
{
    /**
     * @param SubscriberTransformer $SubscriberTransformer
     * @param MapperDataManager     $MapperDataManager
     */
    public function __construct(SubscriberTransformer $SubscriberTransformer, MapperDataManager $MapperDataManager)
    {
        $this->SubscriberTransformer = $SubscriberTransformer;
        $this->MapperDataManager = $MapperDataManager->setSerializer(new SerializerDataArraySerializer());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $Request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $Request)
    {
        $dataRequest = $Request->all();
        $Subscriber = (new CreateSubscriberByCondition(new SubscriberByLists()))->__invoke($dataRequest);
        $data = new Collection([$Subscriber], $this->SubscriberTransformer);

        return $this->Response(
            true,
            $this->MapperDataManager->createData($data)->toArray(),
            Response::HTTP_OK,
            ""
        );
    }

    /**
     *
     * @param $idList
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function findByList($idList)
    {
        $Subscribers = Subscriber::where("list_" . $idList, 1)->get();

        $data = new Collection($Subscribers, $this->SubscriberTransformer);

        return $this->Response(
            true,
            $this->MapperDataManager->createData($data)->toArray(),
            Response::HTTP_OK,
            ""
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $idList
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyByList($idList)
    {
        Subscriber::where("list_" . $idList, 1)->delete();

        return $this->Response(
            true,
            [],
            Response::HTTP_OK,
            ""
        );
    }

    /**
     *
     * @param $email
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws SubscriberNotFound
     */
    public function showByEmail($email)
    {
        $Subscriber = Subscriber::where("email", $email)->get();

        if(count($Subscriber)<1)
            throw new SubscriberNotFound("Subscriber {$email} not found");

        $data = new Collection($Subscriber, $this->SubscriberTransformer);

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
     * @throws SubscriberNotFound
     */
    public function show($id)
    {
        $Subscriber = Subscriber::where("id", $id)->get();

        if(count($Subscriber)<1)
            throw new SubscriberNotFound("Subscriber {$id} not found");

        $data = new Collection($Subscriber, $this->SubscriberTransformer);

        return $this->Response(
            true,
            $this->MapperDataManager->createData($data)->toArray(),
            Response::HTTP_OK,
            ""
        );
    }
}
