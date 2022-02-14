<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;

class imageController extends Controller
{
    public function upload_img(Request $request){

        $image = $request->file('image');
        $input['imagename'] = time().'.'.$image->extension();

        $destinationPath = public_path('images/user-profile');
        $img = Image::make($image->path());
        $img->resize(240,180, function($constraint){
            $constraint->aspectRatio();
        })->save($destinationPath.'/'.$input['imagename']);

        return 'success';
    }
    // http://10.7.200.229/apiweb/images/user-profile/application-detail.PNG
}
