<?php

use Intervention\Image\Facades\Image as Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;
use League\Flysystem\Filesystem;
use Obs\ObsClient;
use Zing\Flysystem\Obs\ObsAdapter;
use Aws\S3\S3Client;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


// This Function use for OBS imageUpload
/*function imageUpload ($image, $imageDirectory, $imageNameString = null, $width = null, $height = null, $modelFileUrl = null)
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

            // $images = Image::make($image)->save($imageUrl,65);

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
                'SourceFile' => $image,
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
}*/

// This Function use for AWS imageUpload
function imageUpload($image, $imageDirectory, $imageNameString = null, $width = null, $height = null, $modelFileUrl = null)
{
    if ($image) {

        /*// Check if the model file URL exists in the S3 bucket and delete it if it does
        if ($modelFileUrl) {
            $filePath = parse_url($modelFileUrl, PHP_URL_PATH);
            $filePath = ltrim($filePath, '/');
            if ($filePath && Storage::disk('s3')->exists($filePath)) {
                dd('ok');
                try {
                    Storage::disk('s3')->delete($filePath);
                    \Log::info("File deleted successfully: " . $filePath);
                } catch (\Exception $e) {
                    \Log::error("Error deleting file: " . $e->getMessage());
                }
            } else {
                \Log::error("File does not exist at path: " . $filePath);
            }

        }*/


        // Define the S3 folder path and ensure it has a trailing slash
        $folderPath = 'backend/assets/uploaded-files/' . rtrim($imageDirectory, '/');
        /*if (!Storage::disk('s3')->exists($folderPath)) {
            Storage::disk('s3')->put($folderPath . '/.keep', '');
        }*/

        // Generate unique image name
        $imageNameString = $imageNameString ?? pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $imageNameString = str_replace(' ', '-', $imageNameString);
        $imageName = $imageNameString . '-' . time() . '-' . rand(10, 1000000000000000) . '.' . $image->getClientOriginalExtension();
        $s3FilePath = $folderPath . '/' . $imageName;

        // Check for .ico extension to directly move it
        if ($image->getClientOriginalExtension() == 'ico') {
            $image->move($folderPath, $imageName);
        } else {
            // Configure AWS S3 client using environment variables
            $s3Client = new S3Client([
                'version' => 'latest',
                'region' => env('AWS_DEFAULT_REGION'),
                'credentials' => [
                    'key' => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                ],
            ]);

            /*// Upload to S3 bucket
            $result = $s3Client->putObject([
                'Bucket' => env('AWS_BUCKET'),
                'Key' => $s3FilePath,
                'SourceFile' => $image->getRealPath(),
            ]);

            // Set image URL to the S3 public URL
            $imageUrl = $result['ObjectURL'];*/

            // Upload to S3 bucket
            $s3Client->putObject([
                'Bucket' => env('AWS_BUCKET'),
                'Key' => $s3FilePath,
                'SourceFile' => $image->getRealPath(),
            ]);

            // Return only the relative path
            $imageUrl = $s3FilePath;
        }

    } else {
        $imageUrl = $modelFileUrl;
        // $imageUrl = $modelFileUrl ? parse_url($modelFileUrl, PHP_URL_PATH) : null;
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
    // dd($nameString);
    if ($fileObject)
    {
        if (isset($modelFileUrl))
        {
            if (file_exists($modelFileUrl))
            {
                unlink($modelFileUrl);
            }
        }
        $fileName       = mt_rand(1,5555555555555555555).'.'.$fileObject->extension();
        $fileDirectory  = 'backend/assets/uploaded-files/'.$directory;
        // $fileObject->move($fileDirectory, $fileName);

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

        // dd($nameString);

        // if ($nameString == 'question') {
        //     # code...
        //     $result = $client->putObject([
        //         'Bucket' => 'biddabari-bucket',
        //         'Key' => $fileDirectory.'/'.$fileName,
        //         'SourceFile' => $fileObject,
        //         ]);
        // }elseif($nameString == 'section-content'){
            # code...
            $result = $client->putObject([
                'Bucket' => 'biddabari-bucket',
                'Key' => $fileDirectory.'/'.$fileName,
                'SourceFile' => $fileObject,
                ]);
        // }else {
        //     # code...
        //     $result = $client->putObject([
        //         'Bucket' => 'biddabari-bucket',
        //         'Key' => $fileDirectory.$fileName,
        //         'SourceFile' => $fileDirectory.$fileName,
        //         ]);
        // }


            if (file_exists($fileDirectory.$fileName))
            {
                unlink($fileDirectory.$fileName);
            }


            // if ($nameString == 'question') {
            //     return $fileDirectory.'/'.$fileName;
            // }elseif ($nameString == 'section-content') {
                return $fileDirectory.'/'.$fileName;
            // }else {
            //     # code...
            //     return $fileDirectory.$fileName;
            // }
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

/*function file_exists_obs($url)
{
    if ($url != null) {
        # code...
        //$exists = Storage::disk('obs')->has($url);

        return $url;
    }else{
        return false;
    }

}*/


function file_exists_s3($url)
{
    if ($url != null) {
        // Check if the file exists in the S3 bucket
        // $exists = Storage::disk('s3')->exists($url);

        return $url;
    } else {
        return false;
    }
}
