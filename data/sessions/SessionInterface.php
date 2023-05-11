<?php

interface SessionInterface
{
    public function get($key);

    public function set($key, $value): self;
    
    public function remove($key): void;
    
    public function clear(): void;
    
    public function has($key): bool;
}

?>