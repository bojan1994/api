<?php

namespace Src\Controller;

use Src\Objects\Statistics;

class StatisticsController
{
    /**
     * @var $db
     * @var $requestMethod
     * @var $statisticId
     * @var $statistics
     */
    private $db, $requestMethod, $statisticId, $statistics;

    /**
     * StatisticsController constructor
     *
     * @param $db
     * @param $requestMethod
     * @param $statisticId
     */
    public function __construct($db, $requestMethod, $statisticId)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->statisticId = $statisticId;

        $this->statistics = new Statistics($db);
    }

    /**
     * Process request with different endpoints
     */
    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->statisticId) {
                    $response = $this->getStatisticsById($this->statisticId);
                } else {
                    $response = $this->getAllStatistics();
                };
                break;
            case 'POST':
                $response = $this->createStatisticsFromRequest();
                break;
            case 'PUT':
                $response = $this->updateStatisticsFromRequest($this->statisticId);
                break;
            case 'DELETE':
                $response = $this->deleteStatistics($this->statisticId);
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    /**
     * Get all statistics
     *
     * @return array
     */
    private function getAllStatistics()
    {
        $result = $this->statistics->get();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode([
            'error' => false,
            'message' => '',
            'data' => $result,
        ]);
        return $response;
    }

    /**
     * Get statistics by id
     *
     * @param $id
     * @return array
     */
    private function getStatisticsById($id)
    {
        $result = $this->statistics->getById($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode([
            'error' => false,
            'message' => '',
            'data' => $result,
        ]);
        return $response;
    }

    /**
     * Store new statistics from request
     *
     * @return array
     */
    private function createStatisticsFromRequest()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (! $this->validateStatistics($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->statistics->store($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;
        return $response;
    }

    /**
     * Update statistics from request
     *
     * @param $id
     * @return array
     */
    private function updateStatisticsFromRequest($id)
    {
        $result = $this->statistics->getById($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (! $this->validateStatistics($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->statistics->update($id, $input);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }

    /**
     * Delete statistics by id
     *
     * @param $id
     * @return array
     */
    private function deleteStatistics($id)
    {
        $result = $this->statistics->getById($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $this->statistics->delete($id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }

    /**
     * Statistics input fields validation
     *
     * @param $input
     * @return bool
     */
    private function validateStatistics($input)
    {
        if (! isset($input['google_analytics'])) {
            return false;
        }
        if (! isset($input['positive_guys'])) {
            return false;
        }
        return true;
    }

    /**
     * Unprocessable Entity response
     *
     * @return array
     */
    private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }

    /**
     * Not found response
     *
     * @return array
     */
    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }
}