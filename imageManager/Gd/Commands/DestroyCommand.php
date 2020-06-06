<?php

namespace system\lib\imageManager\Gd\Commands;

class DestroyCommand extends \system\lib\imageManager\Commands\AbstractCommand
{
    /**
     * Destroys current image core and frees up memory
     *
     * @param  \system\lib\imageManager\Image $image
     * @return boolean
     */
    public function execute($image)
    {
        // destroy image core
        imagedestroy($image->getCore());

        // destroy backups
        foreach ($image->getBackups() as $backup) {
            imagedestroy($backup);
        }

        return true;
    }
}
