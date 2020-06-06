<?php

namespace system\lib\imageManager\Imagick\Commands;

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
        $image->getCore()->clear();

        // destroy backups
        foreach ($image->getBackups() as $backup) {
            $backup->clear();
        }

        return true;
    }
}
