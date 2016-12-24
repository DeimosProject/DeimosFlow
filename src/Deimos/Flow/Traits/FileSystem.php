<?php

namespace Deimos\Flow\Traits;

trait FileSystem
{

    /**
     * @param $path
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    public function createDirectory($path)
    {
        if (!@mkdir($path, 0777, true) && !is_dir($path))
        {
            throw new \InvalidArgumentException($path);
        }

        return realpath($path) . '/';
    }

}