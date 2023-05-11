<?php
require "SessionInterface.php";

class SessionManager implements SessionInterface
{
    public function __construct()
    {
        if(session_status() === PHP_SESSION_NONE)
        {
            session_start();
        }
    }

    public function get($key)
    {
        if(array_key_exists($key, $_SESSION))
        {
            return $_SESSION[$key];
        }
        return null;
    }

    public function set($key, $value): SessionInterface
    {
        $_SESSION[$key] = $value;
        return $this;
    }

    public function clear(): void
    {
        session_unset();
    }

    public function has($key): bool
    {
        return array_key_exists($key, $_SESSION);
    }

    public function remove($key): void
    {
        if (array_key_exists($key, $_SESSION)) {
            unset($_SESSION[$key]);
        }
    }
}

?>