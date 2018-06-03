<?php


namespace Core\Request;

use Core\Helpers\ArrayHelper;

class Request
{
    private $routePath;
    private $postData;
    private $files;
    private $getData;

    public function __construct($routePath, $postData, $getData, $files)
    {
        $this->routePath = explode('?', $routePath)[0];
        $this->postData = $postData;
        $this->files = $files;
        $this->getData = $getData;
    }

    public function routePath(): string
    {
        return $this->routePath;
    }

    public function post($key = null, $default = null)
    {
        return ArrayHelper::extract($this->postData, $key) ?? $default;
    }

    public function get($key = null, $default = null)
    {
        return ArrayHelper::extract($this->getData, $key) ?? $default;
    }

    private function fromFileData($name, $class)
    {
        $file_data = ArrayHelper::extract($this->files, $name);
        if ($file_data && $file_data['size']) {
            return new $class($file_data);
        }

        return null;
    }

    public function file($name): ?UploadedFile
    {
        return $this->fromFileData($name, UploadedFile::class);
    }

    public function image($name): ?UploadedImage
    {
        return $this->fromFileData($name, UploadedImage::class);
    }
}
