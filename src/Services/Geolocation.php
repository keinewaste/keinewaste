<?php
namespace KeineWaste\Services;

class Geolocation {
    /** @var  string $apiKey */
    protected $apiKey;

    /** @var  string $baseUrl */
    protected $baseUrl = "https://maps.googleapis.com/maps/api/distancematrix/json?";

    function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @param string $from
     * @param string[] $destinations
     *
     * @return array
     */
    public function getDistances($from, $destinations)
    {
        $results = json_decode(file_get_contents($this->baseUrl . http_build_query([
            'origins' => $from,
            'destinations' => implode('|', $destinations),
            'mode' => 'driving',
            'language' => 'en-EN',
            'key' => $this->apiKey,
        ])), true);

        $output = [];
        foreach ($destinations as $destId => $address) {
            $output[$destId] = $results['rows'][0]['elements'][$destId];
            $output[$destId]['address'] = $address;
        }

        return $output;
    }


    /**
     * @param string   $from
     * @param string[] $destinations
     * @param integer  $radius
     *
     * @return array
     */
    public function getInRadius($from, $destinations, $radius)
    {
        // !!!!!!!!!!!!!!
        // this code is bullshit, I know
        // but it works
        // !!!!!!!!!!!!!!

        // @todo: add ids
        $distances = $this->getDistances($from, array_values($destinations));
        $ids = array_keys($destinations);

        foreach ($distances as $key => &$dist) {
            $dist['id'] = $ids[$key];
        }

        return array_filter($distances, function ($val) use ($radius) {
            return $val['distance']['value'] < $radius;
        });
    }

}