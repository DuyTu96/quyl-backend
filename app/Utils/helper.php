<?php
if(!function_exists("pr"))
{
	function pr($data = NULL)
	{
		echo "<pre>";print_r($data);echo "</pre>";
	}
}

if(!function_exists("prd"))
{
	function prd($data = NULL)
	{
		echo "<pre>";print_r($data);echo "</pre>";die;
	}
}

if(!function_exists("tableObject"))
{
	function tableObject($table = NULL)
	{
		if(empty($table))
		{
			return array();
		}

		$columns = DB::select('SHOW COLUMNS FROM '.$table);

		$result = new stdClass;
		foreach($columns as $key=>$val)
		{
			$result->{$val->Field} = '';
		}
		return $result;
	}
}

if(!function_exists('image_link'))
{
	function image_link($folder,$name)
	{
		$storagePath = storage_path('app/public/customers/default.png');
		
		$url = storage_path('app/public/'.$folder.'/'.$name);
		if(!empty($name) && file_exists($url)){
			$storagePath = storage_path('app/public/'.$folder.'/'.$name);
		}
		
        return Image::make($storagePath)->response();
	}
}