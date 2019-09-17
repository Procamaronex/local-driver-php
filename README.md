# php-mvc
MVC BASE IN PHP ( MVC, POO ,PDO)


ACCESS CONTROLLERS

TO ACCESS THE CONTROLLERS YOU NEED TO SEND BY THE URL
THE VARIABLE c AND THE VARIABLE a

    c = controller
    a = action

# Example UserController.php

    http://localhost/?c=user

    class UserController{
        public function index(){
            return "Hello this Method is by Default";
        }
    }
# view

    http://localhost/?c=user

    class UserController{
        public function index(){
            return view("name_your_view.php");
        }
    }
# search

     http://localhost/?c=User&a=search

    class UserController{
        public function search(){
            return "Hello World";
        }
    }
# search by id

     http://localhost/?c=user&a=search&id=1902

    class UserController{
        public function search(Request $request){
            $id = $request->input('id');
            return "Your id is ".$id ;
        }
    }
# getUser

     http://localhost/?c=user&a=getUser&id=1902

    class UserController{
        public function getUser(Request $request){
            $id = $request->input('id');
            $data =  DB("SELECT * FROM User u WHERE u.id=?",[$id]);
            return response()->json($data);
        }
    }
# getUser with storeProcedure

     http://localhost/?c=user&a=getUser&id=1902

    class UserController{
        public function getUser(Request $request){
            $id = $request->input('id');
            $data =  DB("CALL yourStoreProcedure(?)",[$id]);
            return response()->json($data);
        }
    }

# METHODS NEW 
* jsonSave(filePath,dataJson);
* jsonList(filePath,itemsFilter)
* jsonList(filePath)
* getFilter(dataArray,itemsFilter,paramsDB)
* getFilter(dataArray,itemsFilter)