<?php

	class EncuestaController extends ApplicationController {



		/**

		 * Inicializa el Controlador Login

		 *

		 */



		public function initialize() {

			$this->setTemplateAfter("adminiziolite");

		}



		/**

		 * Index por defecto del Controlador

		 *

		 */

		 

		public function indexAction(){

		

		}

		

		/**

		 * Aqui sale el formulario de Iniciar Sesión

		 *

		 */

		 

		public function LoginAction(){


		}
		
		public function agregarAction(){
					
        }
		
		public function resultadosAction(){
					
        }
		
		
		public function addAction(){

			$this->setResponse('view');
			$sw=0;
			$encuesta  = new Encuesta();
			$fecha_creacion=date("Y-m-d H:i:s");

			$encuesta->id			  = '';
			$encuesta->descripcion     = $_REQUEST["descripcion"];
			$encuesta->encabezado      = $_REQUEST["encabezado"];
			$encuesta->tamano_fuente   = $_REQUEST["tamano"];
			$encuesta->tipo_fuente     = $_REQUEST["fuente_id"];
			$encuesta->color_fuente    = $_REQUEST["color"];
			$encuesta->fecha_creacion  = $fecha_creacion;
			$encuesta->fecha_cierre  	= $_REQUEST["fecha_cierre"];
			$encuesta->usuarios_id     = $_REQUEST["usuarios_id"];
			$encuesta->estado          = $_REQUEST["estado"];
			
			if($sw==0){		
						
				if($encuesta->save()){
					
					Flash::success(Router::getController()." Guardada Satisfactoriamente");
					echo "<script>redireccionar_action('preguntas/agregar/');</script>";
	
				}else{
				
					Flash::error("Error: No se pudo Guardar el registro...");	
					
					foreach($encuesta->getMessages() as $message){
							  Flash::error($message->getMessage());
					}	  
					
				}
			}
					

		}
		
		public function add_resultados_encAction($id){
			
			$formulario_encuesta = $this->FormularioEncuesta->find(" id_encuesta = '$id' ");
			$encuesta = $this->Encuesta->findFirst(" id = '$id' ");
			
            $this->setParamToView("formulario_encuesta", $formulario_encuesta);
			$this->setParamToView("encuesta", $encuesta);
			//$this->setParamToView("preguntas", $preguntas);
					
        }
		
		public function add_resultados_encuestasAction(){
			
			 $this->setResponse('view');
			 $lista=$_REQUEST['lista'];
			 $preguntas=$_REQUEST['preguntas'];
			 $tipo_pregunta=$_REQUEST['tipo_pregunta'];
			 $id_encuesta=$_REQUEST['id_encuesta'];
			 
			 $enc= $this->Encuesta->findFirst("id='$id_encuesta'");
			 
			 $hoy = date("Y-m-d");
			 
			 if(($hoy<=$enc->fecha_cierre)&&($enc->estado=='0')){
			 /*Calculo el tamaño del array, para luego recorrerlos cuantas veces sea necesario en el for, y hacer el respectivo
			 insert en la tabla resultados_encuestas */
			 $tamano=sizeof($preguntas);
						  
			
			 $res_enc  = new ResultadosEncuestas();
			 
			 
			 for($i=0;$i<$tamano;$i++){
			 	
			 $sw=0;
			 $res_enc->id=  '0';	
			 $res_enc->id_encuesta      =  $id_encuesta[0] ;
			 $res_enc->id_pregunta      =  $preguntas[$i] ;
			 $res_enc->id_tipo_pregunta =  $tipo_pregunta[$i] ;
			 $res_enc->respuesta        =  $lista[$i];
			 
					
			 if($sw==0){		
						
				if($res_enc->save()){
					
					Flash::success(Router::getController()." Guardada Satisfactoriamente");
					echo "<script>redireccionar_action('encuesta/resultados');</script>";
	
				}else{
				
					Flash::error("Error: No se pudieron guardar los resultados...");	
					
						foreach($res_enc->getMessages() as $message){
								  Flash::error($message->getMessage());
						}
			        }
			     }
		      }
		    
			}else{
			       Flash::error("Lo sentimos: Pero la encuesta no está habilitada, comuniquese con el administrador del sistema.");
		  }
		}
		
		
		
		public function modificarAction($id){
			//$this->setResponse("ajax");
			
			if( isset($id) ){
					
				$id_encuesta = $id;
						
				$enc = $this->Encuesta->findFirst(" id = '$id_encuesta' ");
			
						
				Tag::displayTo("id",$enc->id);
				Tag::displayTo("descripcion",$enc->descripcion);
				Tag::displayTo("encabezado",$enc->encabezado);
				Tag::displayTo("tamano_fuente",$enc->tamano_fuente);
				Tag::displayTo("tipo_fuente",$enc->tipo_fuente);
				Tag::displayTo("color_fuente",$enc->color_fuente);
				Tag::displayTo("fecha_creacion",$enc->fecha_creacion);
				Tag::displayTo("fecha_cierre",$enc->fecha_cierre);
				Tag::displayTo("estado",$enc->estado);
							
				
			}else{
					Flash::error("Parametro Incorrecto Volver a Buscar Solicitud para modificar.");
				}
		}
		
		public function updateAction(){
			//primero instanciamos clase clientes
			
			$this->setResponse("view");
			$id = $_REQUEST["id"];
			//cargamos el objeto mediantes los metodos setters
			$encuesta = $this->Encuesta->findFirst("id = '$id'");
			
			$encuesta->descripcion     = $_REQUEST["descripcion"];
			$encuesta->encabezado      = $_REQUEST["encabezado"];
			$encuesta->tamano_fuente   = $_REQUEST["tamano"];
			$encuesta->tipo_fuente     = $_REQUEST["fuente_id"];
			$encuesta->color_fuente    = $_REQUEST["color"];
			$encuesta->fecha_cierre  	= $_REQUEST["fecha_cierre"];
			$encuesta->usuarios_id  	 = $_REQUEST["usuarios_id"];
			$encuesta->estado          = $_REQUEST["estado"];
											
			if($encuesta->save()){
				Flash::success("Se actualizo correctamente el registro");
				echo "<script>redireccionar_action('encuesta/modificar/$encuesta->id');</script>";
				
			}else{
				Flash::error("Error: No se pudo actualizar registro");	
			}
					
					
	    }
		
		public function eliminarAction($id){
			//$this->setResponse("ajax");
			if( isset($id) ){
				
				$enc = $this->Encuesta->findFirst(" id = '$id' ");
			
						
				Tag::displayTo("id",$enc->id);
				Tag::displayTo("descripcion",$enc->descripcion);
				Tag::displayTo("encabezado",$enc->encabezado);
				Tag::displayTo("tamano_fuente",$enc->descripcion);
				Tag::displayTo("tipo_fuente",$enc->descripcion);
				Tag::displayTo("color_fuente",$enc->descripcion);
				Tag::displayTo("fecha_creacion",$enc->fecha_creacion);
				Tag::displayTo("fecha_cierre",$enc->fecha_cierre);
				Tag::displayTo("estado",$enc->estado);
				
			}else{
					Flash::error("Parametro Incorrecto Volver a Buscar ".strtoupper(Router::getController())." para modificar.");
				}
		}
		
		public function deleteAction(){
			//primero instanciamos clase clientes
			$this->setResponse("view");
			
			$id_encuesta=$_REQUEST['id'];
			$id_usuario=$_REQUEST['usuarios_id'];
			
			$db = DbBase::rawConnect();
				
			if($this->Encuesta->findFirst(" id = '$id_encuesta' and usuarios_id='$id_usuario'")==0 ){
				
				$sw=1;
				Flash::error("Usted no está autorizado para eliminar la encuesta....");
				
			}			
			
			
			if($sw==0){
				
				$enc = $this->Encuesta->findFirst(" id = '$id_encuesta' and usuarios_id='$id_usuario'");
				
				if($enc->delete()){
					Flash::success("Se elimino correctamente el registro");
					
				}else{
					Flash::error("Error: No se pudo borrar registro");	
				}
			}//fin todo bien sw==0;
					
	    }
		 

		public function not_found($controller, $action){

				 $this->set_response('view');

				 Flash::error("No esta definida la accion $action, redireccionando");

				 return $this->redirect('administrador');

				 

		 }
		 
		public function buscarAction(){
		
		}
		
		
		
		public function find_buscarAction(){
			$this->setResponse("view");
		}
		
		public function find_detalle_buscarAction(){
			$this->setResponse("view");
		}

		
		public function validarAction($id,$opcion){
			
			$this->setResponse("view");
			
			$sw=0;
			$enc = new Encuesta();
			if( $this->Encuesta->count(" id = '$id' ") > 0 ){
				$enc = $this->Encuesta->findFirst(" id = '$id' ");
				echo "<script>jQuery(\"#".$opcion."_id\").val(\"\");jQuery(\"#".$opcion."_id\").val(\"$enc->id\");jQuery(\"#$opcion\").val(\"\");jQuery(\"#$opcion\").val(\"".$enc->encabezado."\");</script>";
				
			}else{
				Flash::error("No se Encontro Solicitud");
				echo "<script>jQuery(\"#".$opcion."_id\").val(\"\");jQuery(\"#$opcion\").val(\"\");</script>";
			}
			
			
			//public $scaffold = false;
			
			
			
		}

		/**

		 * Esta accion es ejecutada por application/before_filter en caso

		 * de que el usuario trate de entrar a una accion a la cual

		 * no tiene permiso

		 *

		 */

		public function no_accesoAction(){

				$this->set_response('view');

				 Flash::error("No esta definida la accion $action, redireccionando");

				 return $this->redirect('administrador');

		}

			

		/**

		 * Validacion si el login y el password son correctos

		 */

		public function validaAction(){
			
				$this->setResponse('view');

				$Usuario = new Admin();
				$usuario = $Usuario->findFirst("username = '".$_REQUEST['login']."'
							and password = '".md5($_REQUEST['password'])."'");
				
				
				if($usuario){
				
					$Empresa = new Empresa();
					$emp = $Empresa->findFirst("id = '".$_REQUEST['empresa']."'");
					
					$empleado = $this->Empleado->findFirst(" id = '$usuario->empleado_id' ");
					
					if(!$emp){
						Flash::error('Usuario/Clave incorrectos');
						Flash::error('POR FAVOR ESCOJA UNA EMPRESA/O CREE UNA EMPRESA PREVIAMENTE');
						return false;
					}
					
					 $db = DbBase::rawConnect();
			  		 $db->query("select * from access_list where role = '$usuario->role' ");
					 
					 if($db->numRows()==0 ){
						   Flash::notice("otra cosa");
						     Flash::notice("Rol no existe en la tabla de permisos '$usuario->role'");
						   $authLog = new Logger("File", "auth_failed.txt");
						   $authLog->log("Rol no existe en la tabla de permisos '$usuario->role'");
						   return false;
					  } 
					
					/**
					 * Almaceno en la variable de session el id del usuario
					 * autenticado
					 */
					Session::set('admin_username'      , $usuario->username);
					Session::set('tipo_usuario'        , $usuario->tipo_usuario);
					Session::set('usuarios_id'         , $usuario->id);
					Session::set('nombre_completo'     , $empleado->nombre_completo);
					Session::set('usuario_autenticado' , true);
					Session::set('id_empresa'          , $emp->id);
					Session::set('nombre_empresa'      , $emp->nombre_empresa);
					Session::set('kardex_id_default'   , $emp->kardex_id_default);
					Session::set('id_empleado'         , $empleado->id);
					Session::set('nombre_empleado'     , $empleado->nombre_completo);
					Session::set('regimen'             , $emp->regimen_id);
					Session::set('role'                , $usuario->role);
					Session::set('cobro_tarifa'        , $emp->cobro_tarifa);
					
					/**

					 * Lo redireccionos al formulario de clientes

					 */
						Flash::success('Logueado');
						//$this->setResponse("ajax");
						echo "<script>redireccionar_action('home/aplicaciones');</script>";

				} else {

					Flash::error('Usuario/Clave incorrectos');

					//return $this->routeTo('action: login');

				}



		}

		/*

		* Salir Sale del sistema y cierra todas las variables 

		* de las sessiones activas para este hilo de conexion

		*/

		

		public function salirAction(){

			

				Session::unsetData('admin_username');

				Session::unsetData('role');

				Session::unsetData('usuarios_id');

				Session::unsetData('nombre_completo');

				Session::unsetData('usuario_autenticado');

		

			Flash::notice('Has salido Gracias');

			return $this->routeTo('action: login');

		}

				

		public function showAction($id){
          
            $formulario_encuesta = $this->FormularioEncuesta->find(" id = '$id' ");
			$encuesta = $this->Encuesta->findFirst(" id = '$id' ");
			
            $this->setParamToView("formulario_encuesta", $formulario_encuesta);
			$this->setParamToView("encuesta", $encuesta);
			//$this->setParamToView("preguntas", $preguntas);
		
	
		}


	}



?>