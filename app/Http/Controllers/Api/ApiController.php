<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    /**
     * @var integer HTTP status code - 200 by default
     */
    protected $statusCode = 200;

    /**
     * Gets the value of statusCode.
     *
     * @return integer
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Sets the value of statusCode.
     *
     * @param integer $statusCode the status code
     *
     * @return self
     */
    protected function setStatusCode(int $statusCode): ApiController
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Returns a JSON response
     *
     * @param $data
     * @param array $headers
     *
     * @return JsonResponse
     */
    public function response($data, $headers = []): JsonResponse
    {
        if (!empty($data)) {
            $data['status'] = $this->getStatusCode();
        }
    
        return new JsonResponse($data, $this->getStatusCode(), $headers);
    }

    /**
     * Sets an error message and returns a JSON response
     *
     * @param string $message
     * @param array $errors
     * @return JsonResponse
     */
    public function respondWithErrors(string $message, $errors = []): JsonResponse
    {
        $data = [
            'success'   => false,
            'data'      => $errors
        ];

        if (!empty($message)) {
            $data['message'] = $message;
        }

        return $this->response($data);
    }

    /**
     * Sets an error message and returns a JSON response
     *
     * @param $result
     * @param string $success
     * @param array $headers
     * @return JsonResponse
     */
    public function respondWithSuccess($result, string $success, $headers = []): JsonResponse
    {
        $data = [
            'success'   => true,
            'data'      => $result
        ];

        if (!empty($success)) {
            $data['message'] = $success;
        }

        return $this->response($data, $headers);
    }

    /**
     * Returns a 401 Unauthorized http response
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    public function respondUnauthorized($message = 'Not authorized!'): JsonResponse
    {
        return $this->setStatusCode(401)->respondWithErrors($message);
    }

    /**
     * Returns a 422 Unprocessable Entity
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    public function respondValidationError($message = 'Validation errors'): JsonResponse
    {
        return $this->setStatusCode(422)->respondWithErrors($message);
    }

    /**
     * Returns a 404 Not Found
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    public function respondNotFound($message = 'Not found!'): JsonResponse
    {
        return $this->setStatusCode(404)->respondWithErrors($message);
    }

}
