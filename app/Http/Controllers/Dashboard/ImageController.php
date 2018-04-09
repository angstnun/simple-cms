<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Image;

class ImageController extends Controller
{
	//Images will be stored in the public directory /storage/site

    public function upload(Request $request)
    {
    	$path_file = Storage::putFile('public/site', $request->file('file'));
    	$path_file = str_replace('public', 'storage', $path_file);
		$this->saveImage(ImageController::getImageFilename($path_file));
		return json_encode(array('location' => $path_file));
    }

    private function isPublicDirectory($path)
    {
    	return in_array($path, Storage::directories('public'));
    }

    private function saveImage($filename)
    {
    	$image = new Image();
    	$image->filename = $filename;
    	$image->save();
    }

    public static function getImageFilename($path)
    {
    	for($i=strlen($path)-1;$i>=0;$i--) if($path[$i] == '/') return substr($path, $i+1);
    }
	
	public static function getImageList()
	{
		$images = DB::table('images')->select('title', 'filename AS value')->get();
		for($i=0;$i<count($images);$i++) $images[$i]->value = 'storage/site/' . $images[$i]->value;
		return $images;
	}
}
