<?php


namespace App\MrCs\Services\Import\External;


use Illuminate\Support\Facades\Storage;

class SftpService
{
    /**
     * @param $file_path
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getFile($file_path)
    {
        return Storage::disk('sftp')->get($file_path);
    }

    /**
     * @param $file_path
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function saveFile($file_path)
    {
        Storage::disk('public')
            ->put('importedCSV.csv',
                $this->getFile($file_path));
    }
}
