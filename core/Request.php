<?php  
	class Request{

		protected $results;

		public function __construct(){
			$this->results = [];
		}

		public function all(){
			return array_merge($this->body(),$this->input());
		}

		public function body($param = []){
			$this->results =  (array)json_decode(file_get_contents('php://input'));
			return (!empty($param))? $this->results[$param] ?? 'Body Content \''.$param.'\' Not exits' : $this->results ?? [];
		}

		public function input($param = []){
			$params = [];
			foreach ($_REQUEST as $key => $value){if($key !== 'module' && $key !== 'action'){ $this->results[$key] = $value;}}
			return (!empty($param))? $this->results[$param] ?? 'name=\''.$param.'\' Not exits' : $this->results ?? [];
		}

		public function inputs($param = []){
			return $this->input($param);
		}

		public function getHeader($param = []){
			$params = [];
			foreach (apache_request_headers() as $key => $value){
				$this->results[$key] = $value;
			}
			return (!empty($param))? $this->results[$param] ?? [] : json_decode(response()->json($this->results));
		}

		public function isMethod($metodo){
			return  (strtoupper($metodo) === $_SERVER['REQUEST_METHOD']);
		}

		public function isAjax(){
			return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
		}
	}
?>