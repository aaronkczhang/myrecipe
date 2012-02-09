<?php
class File{
	/**
	 * A method for validate the format of the upload file 
	 * 
	 * @param $file:$_FILES["file"],the file which is selct to upload 
	 *        $size:the biggest size of the file can have
	 * @return 1 if validation approved
	 *         0 if file is not valid.
	 *        
	 **/
    public static function validateFile($file,$recipeid,$size,$dir){
    	//$dir = "../webroot/upload"; //image folder
    	$isvalid = 0;
		$filename = $file["name"];
		$path_info = pathinfo($filename);
		$flag = $path_info['extension'];
    	$file_tn = time().'_'.$recipeid.'.'.$flag;   //add timestamp and recipeid to the filename
        if ((($file["type"] == "image/gif")|| ($file["type"] == "image/jpeg")|| ($file["type"] == "image/pjpeg"))&& ($file["size"] < $size))//640k=655360 
        {
    	    if ($file["error"] > 0){
    		    echo "Error: " . $file["error"] . "<br />";
    	    }
    	    else{
    	    	$isvalid=1;
    		    echo "Upload: " . $file["name"] . "<br />";
    		    echo "Type: " . $file["type"] . "<br />";
    		    echo "Size: " . ($file["size"] / 1024) . " Kb<br />";
    		    echo "Stored in: " . $file["tmp_name"];
    	    }
        }
        if (file_exists($dir . $file_tn))
        {
        	$isvalid=0;
        	echo $file["name"] . " already exists. ";
        }

        return $isvalid;
	}
	
	/**
	 * A method for  upload the file 
	 * 
	 * @param $file:$_FILES["file"]the file which is selected to upload
	 *       
	 * @return filename if upload success.
	 *         null if upload fail
	 *        
	 **/
	public static function uploadFile($file,$recipeid,$dir){
		//$dir = "../webroot/upload"; //image folder
        if(is_dir($dir)){
			$filename = $file["name"];
			$path_info = pathinfo($filename);
			$flag = $path_info['extension'];
        	$file_tn = time().'_'.$recipeid.'.'.$flag;
        	if(move_uploaded_file($file["tmp_name"],$dir .$file_tn)){
        		echo "Stored in: " . $dir . $file_tn;
        		return $file_tn;
        	}
        	else {
        		echo "upload file fail";
        		return null;
        	}
        	
        }
        echo "so such upload directory";
		return null;
		
	}
	
	
	/**
	 * A method for  delete the file 
	 * 
	 * @param $filename:$_FILES["file"] the filename which is selected to delete
	 *       
	 * @return filename if delete success.
	 *         null if delete fail
	 *        
	 **/
    public static function deleteFile($filename,$dir){
       // $dir = "../webroot/upload"; //folder
        if(is_dir($dir)){
        	if(is_file($filename)){
        		if(unlink($filename)){
        			echo "{$filename} has been deleted.";
        			return $filename;
        		}
        		else{
        			echo "{$filename} has not been deleted.";
        			return null;
        		}
        	}
        	else{
        		echo "{$dir} is not a directory. delete fail.";
        		return null;
        	}
        }
    }

}