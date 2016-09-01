<?php

namespace Torpedo\API;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * ApiResponse is like JsonResponse, but it won't convert empty arrays into empty objects
 */
class ApiResponse extends JsonResponse
{

    /**
     * Sets the data to be sent as json.
     * @param mixed $data
     * @return JsonResponse
     */
    public function setData($data = array())
    {
        // Encode <, >, ', &, and " for RFC4627-compliant JSON, which may also be embedded into HTML.
        $this->data = json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
        return $this->update();
    }
}