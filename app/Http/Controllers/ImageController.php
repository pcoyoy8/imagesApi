<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
use Illuminate\Support\Facades\File;

class ImageController extends Controller
{
    private function handleFile($resource)
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

            switch (count($value))
            {
                case 2:
                    $values[] = [
                        'name' => $value[0],
                        'url' => $value[1]
                        ];
                    break;
                case 3:
                    $values[] = [
                        'name' => $value[0],
                        'url' => $value[1],
                        'description' => $value[2]
                    ];
                    break;
                default:
                    break;
            }
        }
        return $values;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $images = Image::all();

        return response()
            ->json($images, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if ($request->hasFile('file'))
        {
            $file = $request->file('file');
            $data = $this->handleFile($file);

            return response()
                ->json($data, 200);
        }
        else
        {
            return response()
                ->json('File is required', 400);
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
        $image = Image::find($id);

        return response()
            ->json($image, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
