<?php

namespace system\lib\imageManager\Imagick\Commands;

use system\lib\imageManager\Size;

class GetSizeCommand extends \system\lib\imageManager\Commands\AbstractCommand
{
    /**
     * Reads size of given image instance in pixels
     *
     * @param  \system\lib\imageManager\Image $image
     * @return boolean
     */
    public function execute($image)
    {
        /** @var \Imagick $core */
        $core = $image->getCore();

        $this->setOutput(new Size(
            $core->getImageWidth(),
            $core->getImageHeight()
        ));

        return true;
    }
}
