<?php
use illuminate\Support\Facades\Config;


function uploadImage($folder,$image){
    $extension = strtolower($image->extension());
    $filename = time().rand(100,999). '.'.$extension;
    $image->getClientOriginalName = $filename;
    $path = $image->move($folder,$filename);

    return $path;
}

function get_cols_where($model,$columns_names = array(),$where=array(),$order_field,$order_type){
    $data = $model->select($columns_names)->where($where)->orderBy($order_field,$order_type)->get();
    return $data;
}
function get_cols_where_p($model,$columns_names = array(),$where=array(),$order_field,$order_type,$pagination_counter){
    $data = $model->select($columns_names)->where($where)->orderBy($order_field,$order_type)->paginate($pagination_counter);
    return $data;
}

function get_field_value($model, $field_name,$where= array()){
    $data = $model->where($where)->value($field_name);
    return $data;
}
