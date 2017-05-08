<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Plank\Mediable\Media;
use Plank\Mediable\MediaUploader;

class MediaApiController extends Controller
{
    /**
     * Get the list of images for Media Manager.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $images = Media::orderBy('created_at', 'desc')->get();
        return response()->json(['data' => $images], 200);
    }

    /**
     * Upload a given image coming from Request object and using Intervention to generate
     * thumb and main image and making the Media entry as well.
     *
     * @param Request $request
     * @param MediaUploader $mediaUploader
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function uploadMediaImage(Request $request, MediaUploader $mediaUploader)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'file|image'
        ]);

        // if there are validation errors, show that
        if ($validator->fails()) {
            return response(['message' => $validator->errors()], 433);
        }

        $file = $request->file('file');
        $folder = 'uploads/' . Carbon::now()->year . '/' . Carbon::now()->month . '/';
        $uniqid = uniqid();
        $mainFileName = $uniqid . '.' . $file->getClientOriginalExtension();
        $thumbFileName = $uniqid . '_thumb.' . $file->getClientOriginalExtension();

        // checking if the folder exist
        // if not, create the folder
        if (!file_exists(public_path($folder))) {
            mkdir(public_path($folder), 0755, true);
        }

        $mainImage = Image::make($request->file('file'))
            ->resize(1080, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->save(public_path($folder) . $mainFileName);

        // making the media entry
        $media = $mediaUploader->fromSource(public_path($folder) . $mainFileName)
            ->toDirectory($folder)
            ->upload();

        $thumbImage = Image::make($request->file('file'))
            ->resize(400, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->save(public_path($folder) . $thumbFileName);

        return response()->json(['data' => $media], 201);
    }

    public function imageMetaData(Request $request)
    {
        $media = Media::find($request->input('currentImageId'));

        if (!$media) {
            return response('Image not found', 400);
        }

        $metaData = [
            'alt' => ($request->has('alt')) ? $request->input('alt') : '',
            'caption' => ($request->has('caption')) ? $request->input('caption') : '',
        ];
        $media->meta_data = json_encode($metaData);
        $media->save();

        return $media;
    }
}
