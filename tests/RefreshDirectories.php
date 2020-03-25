<?php


namespace Mtkh\Repo\Tests;


trait RefreshDirectories
{
    /**
     * remove hierarchical directory on project
     *
     * @param $path
     */
    protected function removeDirectory($path)
    {
        if (is_dir($path)) {
            $files = glob($path . '/*');
            foreach ($files as $file) {
                is_dir($file) ? $this->removeDirectory($file) : unlink($file);
            }
            rmdir($path);
            return;
        }
    }
}
