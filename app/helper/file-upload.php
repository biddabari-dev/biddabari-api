<?php

use Intervention\Image\Facades\Image as Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;
use League\Flysystem\Filesystem;
use Obs\ObsClient;
use Zing\Flysystem\Obs\ObsAdapter;

function imageUpload ($image, $imageDirectory, $imageNameString = null, $width = null, $height = null, $modelFileUrl = null)
{
    if ($image)
    {
        // if (isset($modelFileUrl))
        // {
        //     if (file_exists($modelFileUrl))
        //     {
        //         unlink($modelFileUrl);
        //     }
        // }
        // $folderPath = public_path('backend/assets/uploaded-files/'.rtrim($imageDirectory));
        // dd($folderPath);
        // if (!File::isDirectory($folderPath))
        // {
        //     File::makeDirectory($folderPath, 0777, true, true);
        // }

        $imageNameString = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);

        $imageNameString = str_replace(' ','-', $imageNameString);

        $imageName = $imageNameString.'-'.time().rand(10,1000000000000000).'.'.$image->getClientOriginalExtension();

        $imageUrl = 'backend/assets/uploaded-files/'.$imageDirectory.$imageName;
        if ($image->getClientOriginalExtension() == 'ico')
        {
            $image->move($imageDirectory, $imageName);
        } else {

            $images = Image::make($image)->save($imageUrl,65);


            $prefix = '';
            $config = [
                'key' => '7NBPYLX5IMJMXEVUAMJR',
                'secret' => 'k8PDyRPK94ZXjtoZExxCqqEXD8HI4jN63qCtJW0Z',
                'bucket' => 'biddabari-bucket',
                'endpoint' => 'obs.as-south-208.rcloud.reddotdigitalit.com',
            ];

            $config['options'] = [
                'url' => '',
                'endpoint' => $config['endpoint'],
                'bucket_endpoint' => 'https://biddabari-bucket.obs.as-south-208.rcloud.reddotdigitalit.com',
                'temporary_url' => '',
            ];

            $client = new ObsClient($config);
            $adapter = new ObsAdapter($client, $config['bucket'], $prefix, null, null, $config['options']);
            $flysystem = new Filesystem($adapter);

            $result = $client->putObject([
                'Bucket' => 'biddabari-bucket',
                'Key' => $imageUrl,
                'SourceFile' => $imageUrl,
                ]);

            if (file_exists($imageUrl))
            {
                unlink(public_path($imageUrl));
            }
        }
    } else {
        $imageUrl = $modelFileUrl;
    }
    return $imageUrl;
}

function userCertificateUpload ($fileObject, $directory, $nameString = null)
{
    if ($fileObject)
    {
        $fileName       = str_replace(' ', '-', $fileObject->getClientOriginalName()).'~'.rand(100,100000).'.'.$fileObject->extension();
        $fileDirectory  = 'backend/assets/uploaded-files/'.$directory;
        $fileObject->move($fileDirectory, $fileName);
        return $fileDirectory.$fileName;
    } else {
        return null;
    }
}

function fileUpload ($fileObject, $directory, $nameString = null, $modelFileUrl = null)
{
    if ($fileObject)
    {
        if (isset($modelFileUrl))
        {
            if (file_exists($modelFileUrl))
            {
                unlink($modelFileUrl);
            }
        }
        $fileName       = $nameString.str_replace(' ', '-', pathinfo($fileObject->getClientOriginalName(), PATHINFO_FILENAME)).'_'.rand(100,100000).'.'.$fileObject->extension();
        $fileDirectory  = 'backend/assets/uploaded-files/'.$directory.'/';
        $fileObject->move($fileDirectory, $fileName);

        $prefix = '';
        $config = [
            'key' => '7NBPYLX5IMJMXEVUAMJR',
            'secret' => 'k8PDyRPK94ZXjtoZExxCqqEXD8HI4jN63qCtJW0Z',
            'bucket' => 'biddabari-bucket',
            'endpoint' => 'obs.as-south-208.rcloud.reddotdigitalit.com',
        ];

        $config['options'] = [
            'url' => '',
            'endpoint' => $config['endpoint'],
            'bucket_endpoint' => 'https://biddabari-bucket.obs.as-south-208.rcloud.reddotdigitalit.com',
            'temporary_url' => '',
        ];

        $client = new ObsClient($config);
        $adapter = new ObsAdapter($client, $config['bucket'], $prefix, null, null, $config['options']);
        $flysystem = new Filesystem($adapter);

        // dd(env('OBS_BUCKET'));

        $result = $client->putObject([
            'Bucket' => 'biddabari-bucket',
            'Key' => $fileDirectory.$fileName,
            'SourceFile' => $fileDirectory.$fileName,
            ]);

            if (file_exists($fileDirectory.$fileName))
            {
                unlink($fileDirectory.$fileName);
            }



        return $fileDirectory.$fileName;
    } else {
        if (isset($modelFileUrl))
        {
            return $modelFileUrl;
        } else {
            return null;
        }
    }
}

function getFileExtension($file)
{
    return $file->extension();
}
function getFileType($file)
{
    return $file->getMimeType();
}

//date related helper functions
function showDate($date = null)
{
    return \Illuminate\Support\Carbon::parse($date)->format('d-m-Y');
}
function showTime($date = null)
{
    return \Illuminate\Support\Carbon::parse($date)->format('g:i A');
}
function showDateTime($date = null)
{
    return \Illuminate\Support\Carbon::parse($date)->format('d-m-Y g:i A');
}
function showDateTime24Hours($date = null)
{
    return \Illuminate\Support\Carbon::parse($date)->format('d-m-Y H:i');
}
function showDateFormatTwo($date = null)
{
    return \Illuminate\Support\Carbon::parse($date)->format('F d, Y');
}
function dateTimeFormatYmdHi($date = null)
{
    return Carbon::parse($date)->format('Y-m-d H:i');
}
function currentDateTimeYmdHi()
{
    return Carbon::now()->format('Y-m-d H:i');
}

function file_exists_obs($url)
{
    if ($url != null) {
        # code...
        $exists = Storage::disk('obs')->has($url);

        return $exists;
    }else{
        return false;
    }

}
