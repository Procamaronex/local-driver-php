<?php

	class IndexController {

		public function index(){
			$titulo = 'BIENVENIDO A TU REPOSITORIO LOCAL';

			// return view("escamas.php", compact('titulo'));
			// return view("home-test.php", compact('titulo'));
			// return view("home-test2.php", compact('titulo'));
			return view("home.php", compact('titulo'));
		}

        public function github_handler(Request $request) {
			return error_log("entre");
            // var_dump($request);
        }
	}
?>
