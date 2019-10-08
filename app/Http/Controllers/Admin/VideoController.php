<?php

namespace App\Http\Controllers\Admin;

use App\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class VideoController extends Controller
{

    public function deletevideo(Request $request)
    {
        if (isset($request->articleid)){
//            unlink('/media/article/'. $request->articleid . '/video/' . $request->videoname);
            Storage::disk('media')->delete('article/'. $request->articleid . '/video/' . $request->videoname);
        }else{
//            unlink('product/'. $request->articleid . '/video/' . $request->videoname);
            Storage::disk('media')->delete('product/'. $request->articleid . '/video/' . $request->videoname);
        }
        Video::where('id', $request->videoid)->delete();
    }


    public function getvideos(Request $request)
    {
        if (isset($request->articleid)){
            return Video::where('article_id', $request->articleid)->get();
        }
        return Video::where('product_id', $request->productid)->get();
    }






    public function uploadvideo($id, $flag, Request $request)
    {
        return self::chunk($request, $id, $flag);
    }

    protected function chunk($request, $id, $flag)
    {
        // create the file receiver
        $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));
        // check if the upload is success, throw exception or return response you need
        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }
        // receive the file
        $save = $receiver->receive();

        // check if the upload has finished (in chunk mode it will send smaller files)
        if ($save->isFinished()) {
            // save the file and return any response you need, current example uses `move` function. If you are
            // not using move, you need to manually delete the file by unlink($save->getFile()->getPathname())

            return self::saveVideo($save->getFile(), $id, $flag);
        }
        // we are in chunk mode, lets send the current progress
        /** @var AbstractHandler $handler */
        $handler = $save->handler();
        return response()->json([
            "done" => $handler->getPercentageDone(),
            'status' => true
        ]);
    }

    protected static function saveVideo(UploadedFile $file, $id, $flag)
    {

        $fileName = self::createFilename($file);

        $video = new Video();
        $video->name = $fileName;
        $video->article_id = $id;
        $video->save();

        $mime = str_replace('/', '-', $file->getMimeType());
        $filePath = '/media/'. $flag .'/' . $id . '/video/';
        $finalPath = public_path($filePath);

        // move the file name
        $file->move($finalPath, $fileName);
        return response()->json([
            'path' => $filePath,
            'name' => $fileName,
            'mime_type' => $mime
        ]);
    }

    static function createFilename(UploadedFile $file)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = rand(100000, 999999) . '.' . $extension;

        return $filename;
    }

}
