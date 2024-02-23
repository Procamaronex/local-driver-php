<?php  
	
	require_once 'models/DriverService.php';

	class DriverController{

		public function index(){
			$name = "Ronny Matute Granizo";
			$date = date("d-m-Y");
			return view(['header.php', "driver.php", 'upload.php', 'footer.php'],compact('name','date'));
		}

		public function ficheros() {

			$archivos = scandir($_ENV['REPOSITORY'] ?? 'store');
			$response =  array();
			foreach ($archivos as $archivo) {
				if($archivo != "." && $archivo != ".." && $archivo != 'index.php') {
					array_push($response, ['name' => $archivo]);
				}

			}

			return response()->json($response);
		}

		public function upload(Request $request) {
			$directorio_destino = $_ENV['REPOSITORY'] ?? 'store';
			$response =  array();

			if (isset($_FILES['file'])) {
				$archivo_destino = $directorio_destino . '/' . basename($_FILES['file']['name']);
				if (move_uploaded_file($_FILES['file']['tmp_name'], $archivo_destino)) {
					$response = [ 'message' => "El archivo ha sido subido con éxito.", 'suscess' => true ];
				} else {
					$response = [ 'message' => "Hubo un error al subir el archivo.", 'suscess' => false ];
				}
			} else {
				$response = [ 'message' => "No se recibió ningún archivo.", 'suscess' => false ];
			}

			return response()->json($response);
		}
	}
?>