<?php
use illuminate\Support\Facades\Config;


function uploadImage($folder,$image){
    $extension = strtolower($image->extension());
    $filename = time().rand(100,999). '.'.$extension;
    $image->getClientOriginalName = $filename;
    $path = $image->move($folder,$filename);

    return $path;
}
