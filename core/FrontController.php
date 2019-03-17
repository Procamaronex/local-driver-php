<?php
    session_start();
    class FrontController{

        public function __construct(){
            require_once 'core/utility.php';
        }
        public function run(){
            $controller = "Index";
            if (!isset($_REQUEST['c'])) {
                if(file_exists('controllers/' . ucwords($controller) . 'Controller.php')) :
                    $this->handle($controller,'index');
                else:
                    Version();
                endif;
            } else {
                $controller = $_REQUEST['c'];
                $action     = isset($_REQUEST['a']) ? $_REQUEST['a'] : 'index';
                if(file_exists('controllers/' . ucwords($controller) . 'Controller.php')):
                    $this->handle($controller,$action);
                else:
                    error(['C',$controller]);
                endif;
            }
        }
        private function handle($controller,$action){
            require_once 'controllers/' . ucwords($controller) . 'Controller.php';
            $controller = ucwords($controller) . 'Controller';
            $controller = new $controller;
            if(method_exists($controller, $action)):
                $r = call_user_func(array($controller, $action),request());
                if(is_array($r)):
                    var_dump($r);
                elseif(!is_object($r)):
                    echo $r;
                endif;
            else:
                error(['M',$action,$_REQUEST['c']]);
            endif;
        }
    }
?>