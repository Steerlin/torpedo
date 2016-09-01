<?php


namespace Torpedo\Image;


use Gaufrette\Filesystem;
use ToerismeWerkt\WriteModel\TouristicProduct\Image\ImageKey;
use ToerismeWerkt\WriteModel\TouristicProduct\Image\ImageSize;
use Torpedo\Uuid\Identifier;
use Torpedo\ValueObjects\Images\Base64EncodedImage;

final class ImageUploader
{

    private $imageResizer;

    public function __construct(ImageResizer $imageResizer)
    {
        $this->imageResizer = $imageResizer;
    }

    public function upload(Identifier $identifier, Base64EncodedImage $imageContent, Filesystem $fileSystem)
    {
        $imageContent = $imageContent->decode();

        // store original
        $fileSystem->write(
            $identifier . '_original',
            $imageContent
        );

        array_map(function (ImageSize $touristicProductImageSize) use ($identifier, $imageContent, $fileSystem) {
            $fileSystem->write(
                new ImageKey($identifier, $touristicProductImageSize),
                $this->imageResizer->resize($imageContent,
                    $touristicProductImageSize->getBoundingBoxSize())
            );
        }, ImageSize::all());

    }


}
