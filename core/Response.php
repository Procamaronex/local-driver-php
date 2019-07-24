<?php  
	class Response{
		
		protected $sessionTemp;

		public function __construct(){}

		public function view($view,$var_array = []){
			extract($var_array, EXTR_PREFIX_SAME, "item");
			if(is_array($view)):
				foreach($view as $key => $v):
					require_once __DIR__.'/../views/'.$v;
				endforeach;
			else:
				if(file_exists(__DIR__.'/../views/'.$view)):
					require_once __DIR__.'/../views/'.$view;
				else:
					error(['V',$view]);
				endif;
			endif;
			return $this;
		}

		public function json($txt = array(),$status=200){
			http_response_code($status);
			header('Content-type: application/json');
			return json_encode($txt);
		}

		public function error($txt = array(),$status=500){
			http_response_code($status);
			header('Content-type: application/json');
			return json_encode([
				'error'=>true,
				'http'=>$_SERVER['REQUEST_METHOD'],
				'message'=>$txt
			]);
		}

		public function exitsSession($key){
			return (isset($_SESSION[$key]))?$_SESSION[$key]:NULL;
		}

		public function reload($url){
			header('Location: '.$url);
			return $this;
		}

		public function with(...$args){
			$_SESSION['with'] = $args[0];
			return $this;
		}

		public function select($sql,$parametros=[]){
			require_once 'Conexion.php';
			require_once 'EntidadBase.php';
			try {
	            $db = Conexion::getConexion();
	            try {
		            $sentencia = $db->prepare($sql);
		            $sentencia->execute($parametros);
		            if (preg_match('/\bUPDATE\b/', $sql) || preg_match('/\bINSERT\b/', $sql) || preg_match('/\bupdate\b/', $sql) || preg_match('/\binsert\b/', $sql) || preg_match('/\bDELETE\b/', $sql) || preg_match('/\bdelete\b/', $sql)) {
					    $resultset = $sentencia->rowcount().' row affected';
					}else{
						$resultset = $sentencia->fetchAll(PDO::FETCH_CLASS, 'EntidadBase');
					}
		            return $resultset;
		        } catch (Exception $ex) {
		        	die($ex->getMessage());
		        }
	        } catch (Exception $ex) {
	            die($ex->getMessage());
	        }
		}
	}
?>