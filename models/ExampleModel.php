<?php  
	class ExampleModel{

		public static function list($entity){
			$data =  DB("SELECT * FROM ".$entity);
			return $data;
		}
	}
?>