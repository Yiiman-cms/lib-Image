<?php

namespace system\lib\imageManager\Imagick\Commands;

class OpacityCommand extends \system\lib\imageManager\Commands\AbstractCommand
{
    /**
     * Defines opacity of an image
     *
     * @param  \system\lib\imageManager\Image $image
     * @return boolean
     */
    public function execute($image)
    {
        $transparency = $this->argument(0)->between(0, 100)->required()->value();
        
        $transparency = $transparency > 0 ? (100 / $transparency) : 1000;

        return $image->getCore()->evaluateImage(\Imagick::EVALUATE_DIVIDE, $transparency, \Imagick::CHANNEL_ALPHA);
    }
}
