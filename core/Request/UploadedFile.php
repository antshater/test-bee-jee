<?php


namespace Core\Request;

class UploadedFile
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function move($path)
    {
        move_uploaded_file($this->tmpName(), $path);
    }

    public function md5()
    {
        return md5_file($this->tmpName());
    }

    public function tmpName()
    {
        return $this->data['tmp_name'];
    }

    public function extension()
    {
        $exploded = explode('.', $this->data['name']);
        return array_pop($exploded);
    }
}
