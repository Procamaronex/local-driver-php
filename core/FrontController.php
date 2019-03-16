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
                    require_once 'controllers/' . $controller . 'Controller.php';
                    $controller = ucwords($controller) . 'Controller';
                    $controller = new $controller;
                    if(method_exists($controller, 'index')):
                        $r = $controller->index();
                        if(!is_object($r)):
                            echo $r;
                        endif;
                    else:
                        Version();
                    endif;
                else:
                    Version();
                endif;
            } else {
                $controller = $_REQUEST['c'];
                $accion     = isset($_REQUEST['a']) ? $_REQUEST['a'] : 'index';
                if(file_exists('controllers/' . ucwords($controller) . 'Controller.php')):
                    require_once 'controllers/' . ucwords($controller) . 'Controller.php';
                    $controller = ucwords($controller) . 'Controller';
                    $controller = new $controller;
                    if(method_exists($controller, $accion)):
                        $r = call_user_func(array($controller, $accion),request());
                        if(!is_object($r)):
                            echo $r;
                        endif;
                    else:
                        error(['M',$accion,$_REQUEST['c']]);
                    endif;
                else:
                    error(['C',$controller]);
                endif;
            }
        }
    }
?>