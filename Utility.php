<?php

class Utility {

  public static function prepareSecret($secret) {
  
    return Utility::md5Secret(trim($secret), "EGA", 10);
  }
  
  private static function md5Secret($input, $salt, $round){
	
	if($round != 1)
	{
		return Utility::md5Secret(md5($input.$salt), $salt, $round-1);
	}
	else
	{
		return md5($input.$salt);
	}
  }
}

?>