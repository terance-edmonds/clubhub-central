<?php

class Storage
{
    private $prefix = "session-";

    public function setPrefix($value)
    {
        $this->prefix = $value;
    }

    public function set($key, $value)
    {
        $_SESSION[$this->prefix . $key] = $value;
    }

    public function get($key)
    {
        if (!empty($_SESSION[$this->prefix . $key])) return $_SESSION[$this->prefix . $key];

        return null;
    }
}
