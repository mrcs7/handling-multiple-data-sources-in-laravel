<?php


namespace App\MrCs\Services;


use App\MrCs\Enums\Upload\UploadPath;

class UploadService
{
    /**
     * @param $file
     * @return false
     */
    public function upload($file)
    {
        try {
            $fileName = $this->generateUploadedFileName($file);

            $filePath = $this->generateUploadedFilePath();

            $uploaded = $file->move(storage_path($filePath), $fileName);

            return $filePath.'/'.$fileName;
        } catch (\Exception $e) {

            return false;
        }
    }

    /**
     * @param $file
     * @return string|string[]
     */
    public function generateUploadedFileName($file)
    {
        $fileName = $config['fileName'] ?? null;
        $originalFileName = $file->getClientOriginalName();
        $fileExtension = $file->getClientOriginalExtension();
        $fileName = substr($originalFileName, 0, strrpos($originalFileName, '.'));
        $fileName = str_replace(' ', '-', now()->timestamp.'-'.$fileName.'.'.$fileExtension);
        return $fileName;
    }

    /**
     * @return string
     */
    public function generateUploadedFilePath()
    {
        return UploadPath::IMPORT_PATH.'/'.now()->year.'/'.now()->month.'/'.now()->day;

    }

}
