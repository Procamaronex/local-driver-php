<?php  
	class DriverService {

		public static function list($entity){
			$data =  DB("SELECT * FROM ".$entity);
			return $data;
		}
	}
?>