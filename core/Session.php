<?php


namespace Core;

class Session
{
    private static $instance;
    private $data = [];
    private $oneOff = [];

    private function __construct()
    {
        $this->data = $_SESSION;
    }

    public static function instance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function set($key, $value)
    {
        $this->data[$key] = $value;
        $_SESSION[$key] = $value;
    }

    public function remove($key)
    {
        unset($this->data[$key]);
        unset($_SESSION[$key]);
    }

    public function get($key)
    {
        $data = $this->data[$key];
        if (in_array($key, $this->oneOff)) {
            $this->remove($key);
        }
        return $data;
    }

    public function oneOffMessage($key, $value)
    {
        $this->set($key, $value);
        $this->oneOff[] = $key;
    }

    public static function start()
    {
        session_start();
    }
}
