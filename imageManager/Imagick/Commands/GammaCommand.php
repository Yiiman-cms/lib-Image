<?php

namespace system\lib\imageManager\Imagick\Commands;

class GammaCommand extends \system\lib\imageManager\Commands\AbstractCommand
{
    /**
     * Applies gamma correction to a given image
     *
     * @param  \system\lib\imageManager\Image $image
     * @return boolean
     */
    public function execute($image)
    {
        $gamma = $this->argument(0)->type('numeric')->required()->value();

        return $image->getCore()->gammaImage($gamma);
    }
}
