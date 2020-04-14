<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\ImageRequest;
use App\Http\Resources\ImageResource;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Handlers\ImageUploadHandler;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    public function store(ImageRequest $request, ImageUploadHandler $uploader, Image $image) {
        $user = $request->user();
        $size = $request->type == 'avatar' ? 416 : 1080;
        $result = $uploader->save($request->image, Str::plural($request->type), $user->id, $size);

        $image->path = $result['path'];
        $image->type = $request->type;
        $image->user_id = $user->id;
        $image->save();

        return new ImageResource($image);
    }
}
