<?php  
	
	require_once 'models/DriverService.php';

	class DriverController{

		public function index(){
			$name = "Ronny Matute Granizo";
			$date = date("d-m-Y");
			return view(['header.php', "driver.php", 'upload.php', 'footer.php'],compact('name','date'));
		}

		public function ficheros() {

			$repositoryPath = $_ENV['REPOSITORY'] ?? 'store';
    		$archivos = scandir($repositoryPath);

			$response =  array();

			foreach ($archivos as $archivo) {
				if($archivo != "." && $archivo != ".." && $archivo != 'index.php' && !strstr($archivo, 'eliminado')) {
					$parts = explode('.', $archivo);
					$extension = array_pop($parts); // Get the last element as extension
					$name = implode('.', $parts); // Join the remaining parts as name
					
					// $filePath = $repositoryPath . DIRECTORY_SEPARATOR . $archivo;
					// $size = filesize($filePath); // Get file size in bytes
					// $sizeTag = ($size > 1024 * 1024) ? 'MB' : 'KB'; // Check if size is greater than 1MB
					// $sizeFormatted = ($sizeTag === 'MB') ? round($size / (1024 * 1024), 2) : round($size / 1024, 2); // Convert size to MB or KB

					$filePath = $repositoryPath . DIRECTORY_SEPARATOR . $archivo;
					$size = filesize($filePath); // Get file size in bytes
					$sizeTag = 'KB'; // Default size tag

					// Check if size is greater than 1GB
					if ($size > 1024 * 1024 * 1024) {
						$sizeFormatted = round($size / (1024 * 1024 * 1024), 2); // Convert size to GB
						$sizeTag = 'GB';
					} 
					// Check if size is greater than 1MB
					elseif ($size > 1024 * 1024) {
						$sizeFormatted = round($size / (1024 * 1024), 2); // Convert size to MB
						$sizeTag = 'MB';
					} 
					else {
						$sizeFormatted = round($size / 1024, 2); // Convert size to KB
					}

					array_push($response, [
							'original_name' => $archivo,
							'name' => $name,
							'extension' => $extension,
							'size' => $sizeFormatted,
							'size_tag' => $sizeTag
						]
					);
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

		public function renombrarFichero(Request $request) {
			$directorio_destino = $_ENV['REPOSITORY'] ?? 'store';
			$response =  array();

			$fichero = $request->body('fichero');


			$partes = explode('.', $archivo);

			$nombre = implode('.', array_slice($partes, 0, -1)); // Obtiene el nombre del archivo sin la última parte
			$extension = end($partes); // Obtiene la última parte como extensión

			// $archivo_destino = $directorio_destino . '/' . basename($_FILES['file']['name']);

			if (rename($directorio_destino.'/'.$fichero, $directorio_destino.'/eliminado-'.$fichero)) {
				$response = [ 'message' => "El archivo se ha eliminado correctamente.", 'suscess' => true ];
			} else {
				$response = [ 'message' => "No se pudo eliminar el archivo..", 'suscess' => false ];
			}
			

			// $response = [ 'message' => "No se recibió ningún archivo.", 'suscess' => false, 'fichero' => $fichero ];

			return response()->json($response);
		}
	}
?>