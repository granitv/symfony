<?php


namespace App\Service;


use Symfony\Component\HttpFoundation\File\Exception\FileException;

class FormsManager
{
    static function handleFileUpload($file,String $path) {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $newFilename = uniqid().'.'.$file->guessExtension();
        try {
            $file->move(
                $path,
                $newFilename
            );
        } catch (FileException $e) {
        }
        return $newFilename;
    }
}