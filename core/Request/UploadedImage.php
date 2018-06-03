<?php


namespace Core\Request;

use Intervention\Image\Image;
use Intervention\Image\ImageManager;

class UploadedImage extends UploadedFile
{
    private $image;

    public function __construct($data)
    {
        parent::__construct($data);
        $manager = new ImageManager(['driver' => 'gd']);
        $this->image = $manager->make($this->tmpName());
    }

    public function image(): Image
    {
        return $this->image;
    }
}
