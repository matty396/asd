<?php

namespace App\services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageService
{
    public function uploadImageToLocalStore($image): string
    {
        $filenameToStore = '';
        if (!is_null($image)) {
            $base64Image = $image;
            $fileName = 'eco_' . date('Y-m-d') . '_' . rand(0, 9999);
            if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
                $base64Image = mb_substr($base64Image, mb_strpos($base64Image, ',') + 1);
                $base64Image = str_replace(' ', '+', $base64Image);
                $type = mb_strtolower($type[1]); // jpg, png, gif
                if (!\in_array($type, array('jpg', 'jpeg', 'png'), true)) {
                    throw new \Exception('invalid image type');
                }
                $base64Image = base64_decode($base64Image, true);
                if (false === $base64Image) {
                    throw new \Exception('base64_decode failed');
                }
            } else {
                throw new \Exception('did not match data URI with image data');
            }

            //Image::configure(['driver' => 'imagick']);
            $filenameToStore = $fileName . ".{$type}";
            $bigImg = Image::make($base64Image)->resize(1024, 768, function ($constraint) {
                $constraint->aspectRatio();
            });
            $mediumImg = Image::make($base64Image)->resize(640, 468, function ($constraint) {
                $constraint->aspectRatio();
            });
            $smallImg = Image::make($base64Image)->resize(150, 120, function ($constraint) {
                $constraint->aspectRatio();
            });
            //Upload File to local or s3
            Storage::disk('public')->put('eco/big_' . $filenameToStore, $bigImg->encode(), 'public');
            Storage::disk('public')->put('eco/medium_' . $filenameToStore, $mediumImg->encode(), 'public');
            Storage::disk('public')->put('eco/small_' . $filenameToStore, $smallImg->encode(), 'public');
        }
        //Store $filenameToStore in the database
        return $filenameToStore;
    }

    public function deleteImageToLocalStore($imagen): string
    {
        $result = false;
        if (Storage::disk('public')->delete('eco/small_' . $imagen)) {
            $result = true;
        }
        if (Storage::disk('public')->delete('eco/medium_' . $imagen)) {
            $result = true;
        }
        if (Storage::disk('public')->delete('eco/big_' . $imagen)) {
            $result = true;
        }
        return $result;
    }
}
