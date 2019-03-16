<?php
	if (! function_exists('DB')) {
		function DB($sql,$parametros=[]){
			return response()->select($sql,$parametros);
		}
	}

	if (! function_exists('view')) {
		function view($view,$var_array = array()){
			return response()->view($view,$var_array);
		}
	}

	if (!function_exists('request')){
		function request(){
			require_once 'Request.php';
			return new Request();
		}
	}

	if(!function_exists('response')){
		function response(){
			require_once 'Response.php';
			return new Response();
		}
	}

	if(!function_exists('getSession')){
		function getSession($key){
			return (isset($_SESSION[$key]))?$_SESSION[$key]:NULL;
		}
	}

	if(!function_exists('flushSession')){
		function flushSession($key){
			(isset($_SESSION[$key]) && !empty($_SESSION[$key]))?$_SESSION[$key] = NULL:NULL;
		}
	}

	if(!function_exists('getWith')){
		function getWith($key=''){
			$with = (isset($_SESSION['with'][$key]))?$_SESSION['with'][$key]:NULL;
			flushSession('with');
			return $with;
		}
	}

	if(!function_exists('isWith')){
		function isWith($key){
			return (isset($_SESSION['with'][$key]))?$_SESSION['with'][$key]:NULL;
		}
	}

	if(!function_exists('Version')){
		function Version(){
			echo "<span style='color:#2D8848'>============================================</span><br><span style='color:#992F1E;font-weight:bold'>&nbsp;&nbsp;MVC BASE IN PHP v. 1.0 | By. Ronny Matute Granizo</span><br><span style='color:#2D8848'>============================================</span><br>";
		}
	}
	if(!function_exists('error')){
		function error($a=array()){
			echo "<br><span style='color:#2D8848'>==================================================================</span><br><span style='color:#992F1E;font-weight:bold'>";
			switch($a[0]):
				case 'M':echo "Error, al parecer no existe el metodo [".$a[1]."] en el controlador [".$a[2]."Controller.php]";break;
				case 'C':echo "Error, al parecer no existe el controlador [".$a[1]."Controller.php] en el directorio [controllers]";break;
				case 'V':echo "Error, al parecer no existe la vista [".$a[1]."] en el directorio [views]";break;
			endswitch;
			echo "</span><br><span style='color:#2D8848'>==================================================================</span><br>";
		}
	}
?>