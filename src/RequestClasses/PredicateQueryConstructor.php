<?php
namespace LukeNZ\Ephemeris\RequestClasses;
use LukeNZ\Ephemeris\SatelliteIdentifiers\SatelliteIdentificationContract;

class PredicateQueryConstructor
{
    protected $client, $query;

    public function __construct($client, $requestController, $requestClass) {
        $this->client = $client;
        $this->query['controller'] = $requestController;
        $this->query['action'] = 'query';
        $this->query['class'] = $requestClass;
    }

    public function satellite(SatelliteIdentificationContract $satelliteIdentifiers) {
        if (is_array($satelliteIdentifiers)) {

        } else {
            $query['predicates'][$satelliteIdentifiers->getPredicateName()] = $satelliteIdentifiers->identify();
        }
    }

    public function modelDefinitions() {
        $this->query['action'] = 'modeldef';
    }

    protected function buildQuery() {
        $query = $this->query['controller'] . '/' . $this->query['action'] . '/' . $this->query['class'] . '/class/';

        if (isset($query['predicates'])) {
            foreach ($query['predicates'] as $key => $value) {
                $query .= $key . '/' . $value . '/';
            }
        }

        $query .= 'format/' . $this->client->responseFormat;

        return $query;
    }

    public function fetch() {
        return $this->client->httpRequest($this->buildQuery());
    }
}