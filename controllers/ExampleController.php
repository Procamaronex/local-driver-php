<?php  
	
	require_once 'models/ExampleModel.php';

	class ExampleController{

		public function index(){
			$name = "Ronny Matute";
			$date = date("d-m-Y");
			return view("example.php",compact('name','date'));
		}

		public function list(Request $request){
			if($request->isMethod("POST")){
				$data = ExampleModel::list("persons");
				return response()->json($data);
			}
			return response()->error("Not Authorized",401);
		}

		public function example(Request $request){
			if($request->isAjax()){
				$data = DB("Call myStoreProcedure(?,?)",[$param1,$param2]);
				return response()->json($data);
			}
			return response()->error("Not Authorized",401);
		}
	}
?>