<?php

namespace system\lib\imageManager\Imagick\Commands;

class ContrastCommand extends \system\lib\imageManager\Commands\AbstractCommand
{
    /**
     * Changes contrast of image
     *
     * @param  \system\lib\imageManager\Image $image
     * @return boolean
     */
    public function execute($image)
    {
        $level = $this->argument(0)->between(-100, 100)->required()->value();

        return $image->getCore()->sigmoidalContrastImage($level > 0, $level / 4, 0);
    }
}
