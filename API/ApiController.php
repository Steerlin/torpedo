<?php

namespace Torpedo\API;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController extends Controller
{
    /**
     * @param null $data
     * @param int $status
     * @param array $headers
     * @return JsonResponse
     */
    public function renderJson($data = null, $status = 200, $headers = array())
    {
        return new ApiResponse($data, $status, $headers);
    }
}