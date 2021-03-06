<?php

namespace Stevebauman\Location\Drivers;

use Illuminate\Support\Fluent;
use Stevebauman\Location\Position;

class IpApi extends Driver
{
    /**
     * {@inheritdoc}
     */
    protected function url()
    {
        return 'http://ip-api.com/json/';
    }

    /**
     * {@inheritdoc}
     */
    protected function hydrate(Position $position, Fluent $location)
    {
        $position->countryName = $location->country;
        $position->countryCode = $location->countryCode;
        $position->regionName = $location->regionName;
        $position->cityName = $location->city;
        $position->zipCode = $location->zip;
        $position->latitude = (string) $location->lat;
        $position->longitude = (string) $location->lon;
        // $position->metroCode = (string) $location->metro_code;
        $position->areaCode = $location->region;

        return $position;
    }

    /**
     * {@inheritdoc}
     */
    protected function process($ip)
    {
        try {
            $response = json_decode($this->getUrlContent($this->url().$ip), true);

            return new Fluent($response);
        } catch (\Exception $e) {
            return false;
        }
    }
}
