<?php


namespace Torpedo\Image;


class ImageResizer
{

    public function resize(string $imageContent, int $boundingBoxSize)
    {
        $image = new \Imagick();
        $image->readImageBlob($imageContent);
        $image->resizeImage($boundingBoxSize, $boundingBoxSize, \Imagick::FILTER_LANCZOS, 1, true);
        $image->setImageFormat("png");
        return $image->getImageBlob();
    }
}
