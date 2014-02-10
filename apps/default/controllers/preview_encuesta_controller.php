<?php

	class preview_encuestaController extends ApplicationController {
		
		
		public function initialize() {

			$this->setTemplateAfter("adminiziolite");

		}
		
		
		public function add_resultados_encAction($id){
			
			$formulario_encuesta = $this->FormularioEncuesta->find(" id_encuesta = '$id' ");
			$encuesta = $this->Encuesta->findFirst(" id = '$id' ");
			
            $this->setParamToView("formulario_encuesta", $formulario_encuesta);
			$this->setParamToView("encuesta", $encuesta);
			//$this->setParamToView("preguntas", $preguntas);
					
        }
		
		public function resultadosAction(){
					
        }
		
		public function add_resultados_encuestasAction(){
			
			 $this->setResponse('view');
			 $lista=$_REQUEST['lista'];
			 $preguntas=$_REQUEST['preguntas'];
			 $tipo_pregunta=$_REQUEST['tipo_pregunta'];
			 $id_encuesta=$_REQUEST['id_encuesta'];
			 //$id_encuesta=$id;
			 
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
					echo "<script>redireccionar_action('graficosxml/grafico1/?id_encuesta=$enc->id');</script>";
	
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
		
		
	}
	
?>