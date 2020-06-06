<?php

namespace system\lib\imageManager\Gd\Commands;

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

        return imagegammacorrect($image->getCore(), 1, $gamma);
    }
}
