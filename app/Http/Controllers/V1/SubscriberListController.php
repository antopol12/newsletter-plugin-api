<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Serializer\DataArraySerializer as SerializerDataArraySerializer;
use NewsletterPluginApi\Entities\Newsletter;
use NewsletterPluginApi\Entities\SubscriberList;
use Illuminate\Http\Response;
use League\Fractal\Manager as MapperDataManager;

class SubscriberListController extends Controller
{
    /**
     * @return string[]
     */
    protected function mapperKeysSubscriberLists()
    {
        return [
            "id"   => "id",
            "name" => "name"
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function findEmpty()
    {
        $arrayLists = [];
        for ($idList = 1; $idList <= 40; $idList++) {
            $SubscriberLists = SubscriberList::where("list_" . $idList, 1)->get();
            if (count($SubscriberLists) <= 0) {
                $arrayLists[] = ["id" => $idList];
            }
        }

        return $this->Response(
            true,
            $arrayLists,
            Response::HTTP_OK,
            ""
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function findByNewsletterSent()
    {
        $arrayLists = [];
        $Newsletters = Newsletter::where("status", "sending")->get();
        /** @var Newsletter $Newsletter */
        foreach ($Newsletters as $Newsletter) {
            $arrayLists = array_merge($arrayLists, $Newsletter->getLists());
        }

        return $this->Response(
            true,
            $arrayLists,
            Response::HTTP_OK,
            ""
        );
    }
}
