<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
use Illuminate\Support\Facades\File;
use App\Jobs\ProcessImage;

class ImageController extends Controller
{
    private function getData($resource)
    {
        $fileName = $resource->getClientOriginalName();
        $filePath = public_path('uploads/'. $fileName);
        $resource->move(public_path('uploads/'), $fileName);

        $data = array_map('str_getcsv',
            file($filePath));

        File::delete($filePath);
        $values = [];
        foreach ($data as $item)
        {
            $value = explode('|', array_shift($item));

            if(count($value) >= 2)
            {
                $url = preg_replace('/\s+/', '', $value[1]);
                $result = $this->validateImage($url);
                if($result)
                {
                    $record = Image::where('picture_title', '=', $value[0])->first();
                    $values[] = [
                        'id' => ($record) ? $record->id : null,
                        'picture_title' => $value[0],
                        'picture_url' => $url,
                        'download_url' => $result,
                        'picture_description' => (array_key_exists(2, $value)) ? $value[2] : ''
                    ];
                }
            }
        }
        return $values;
    }

    private function validateImage($imageUrl)
    {
        if(filter_var($imageUrl, FILTER_VALIDATE_URL) !== false)
        {
            $headers = get_headers($imageUrl, 1);
            $type = $headers["Content-Type"];
            if(substr($type, 0, 5) === 'image')
            {
                $file = $this->downloadImage($imageUrl);
                return $file;
            }
            return false;
        }
        return false;
    }

    private function downloadImage($url)
    {
        $filePath = 'download/' . uniqid();
        ProcessImage::dispatch($filePath, $url);
        return $filePath;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $images = Image::all();

            return response()
                ->json($images, 200);
        } catch (\Exception $e)
        {
            return response()
                ->json([
                    'Error' => get_class($e),
                    'Message' => $e->getMessage()
                ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            if ($request->hasFile('file'))
            {
                $file = $request->file('file');
                $data = $this->getData($file);

                $images = [];
                foreach ($data as $item) {
                    $images[] = Image::updateOrCreate(
                        ['id' => $item['id']],
                        $item);
                }

                return response()
                    ->json($images, 200);
            }
            else
            {
                return response()
                    ->json('File is required', 400);
            }
        } catch (\Exception $e)
        {
            return response()
                ->json([
                    'Error' => get_class($e),
                    'Message' => $e->getMessage()
                ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $image = Image::find($id);

            return response()
                ->json($image, 200);
        } catch (\Exception $e)
        {
            return response()
                ->json([
                    'Error' => get_class($e),
                    'Message' => $e->getMessage()
                ], 500);
        }
    }

}
