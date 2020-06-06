<?php

namespace system\lib\imageManager\Imagick\Commands;

class InvertCommand extends \system\lib\imageManager\Commands\AbstractCommand
{
    /**
     * Inverts colors of an image
     *
     * @param  \system\lib\imageManager\Image $image
     * @return boolean
     */
    public function execute($image)
    {
        return $image->getCore()->negateImage(false);
    }
}
