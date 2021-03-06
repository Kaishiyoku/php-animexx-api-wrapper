<?php

namespace Kaishiyoku\AnimexxApi\Responses;

use Illuminate\Support\Collection;
use Kaishiyoku\AnimexxApi\AnimexxApi;
use Kaishiyoku\AnimexxApi\Models\Misc\Meta;
use Kaishiyoku\AnimexxApi\Models\SerialEvent;
use Kaishiyoku\AnimexxApi\Responses\Traits\WithMeta;

class SerialEventsResponse
{
    use WithMeta;

    /**
     * @var Collection<SerialEvent>
     */
    private $serialEvents;

    /**
     * SerialEventsResponse constructor.
     */
    public function __construct()
    {
        $this->serialEvents = new Collection();
    }

    /**
     * @param array      $json
     * @param AnimexxApi $animexxApi
     * @return SerialEventsResponse
     */
    public static function fromJson(array $json, AnimexxApi $animexxApi): SerialEventsResponse
    {
        $serialEventsResponse = new SerialEventsResponse();
        $serialEventsResponse->meta = Meta::fromJson($json['meta']);

        $serialEvents = new Collection();

        arrEach(function ($serialEventData) use (&$serialEvents, $animexxApi) {
            $serialEvents->push(SerialEvent::fromJson($serialEventData, $animexxApi));
        }, $json['data']);

        $serialEventsResponse->serialEvents = $serialEvents;

        return $serialEventsResponse;
    }

    /**
     * @return Collection
     */
    public function getSerialEvents(): Collection
    {
        return $this->serialEvents;
    }

    /**
     * @return Meta
     */
    public function getMeta(): Meta
    {
        return $this->meta;
    }
}
