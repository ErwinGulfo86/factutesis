
<?php

	class LibrosController extends ApplicationController {
	
	
	
		public function initialize() {
		  // $this->setTemplateAfter("a_bit_boxy");
		   //$this->setTemplateAfter("menu_azul");
		   	$temp=$this->Admin->findFirst(" id = '".Session::get("usuarios_id")."' ")->plantilla;
			$this->setTemplateAfter("$temp");
		}

		
		
		public function pedido_clientesAction(){
			//$this->setResponse("view");
		}
		
		public function pedido_clientes_jsonAction(){
			
			$this->setResponse("view");
		}
		
		public function pedido_clientes_pdfAction(){
			$this->setResponse("view");
		}
		
		/*INGRESOS DIARIOS*/
		
		public function ingresos_diariosAction(){
			//$this->setResponse("view");
		}
		
		public function ingresos_diarios_jsonAction(){
			
			$this->setResponse("view");
		}
		
		public function ingresos_diarios_pdfAction(){
			$this->setResponse("view");
		}
		
		
		public function generalAction(){
			$inventario  = new Kardex();
			//tipo kardex
			// 1 - producto
			// 2 - servicios					
			$inventario = $this->Kardex->find("tipo_kardex_id = '1' and visible_pos = 0 ","order: nombre_producto ASC");
			$this->setParamToView("inventario", $inventario);
		}
		
		
		public function general_pdfAction(){
			$this->setResponse("view");
		}
		
		public function general_excelAction(){
			$this->setResponse("view");
		}
		
		
		public function inventario_bodegasAction(){
			//$this->setResponse("view");
		}
		
		public function inventario_bodegas_jsonAction(){
			$this->setResponse("ajax");
		}
		
		public function inventario_bodegas_pdfAction(){
			$this->setResponse("view");
		}
		

		public function indexAction(){
		
		}



		public function remisionesAction(){
		
		}
		
		
		
		public function detalle_remisionesAction(){
				
				$this->setResponse('view');
				
				$remisiones  = new Remisiones();
				
				//$finicial = $_REQUEST['finicial'];
				//$ffinal = $_REQUEST['ffinal'];
				$yyyy = $_REQUEST['yyyy'];
				$mes = $_REQUEST['mes'];
				$empresa_id = $_REQUEST['empresa_id'];
				$sql2 = "YEAR( fecha ) = $yyyy and MONTH( fecha ) = $mes ";
				
				//fecha >= '$finicial' and fecha <= '$ffinal'
				
				if(  isset($yyyy)&&isset($mes)  ){

					$remisiones = $this->Remisiones->find(" $sql2 and empresa_id = '$empresa_id' ");
          			$this->setParamToView("remisiones", $remisiones);
					
				}else{
					Flash::success("El campo fecha inicial no fue seleccionado");	
					Flash::success("El campo fecha final no fue seleccionado");	
				}
		
		}
		
		
		
		public function devolucionesAction(){
			
			
		}
		
		
		
		
		public function detalle_devolucionesAction(){
				
				$this->setResponse('view');
				
				$remisiones  = new Devoluciones();
				
				//$finicial = $_REQUEST['finicial'];
				//$ffinal = $_REQUEST['ffinal'];
				$yyyy = $_REQUEST['yyyy'];
				$mes = $_REQUEST['mes'];
				$empresa_id = $_REQUEST['empresa_id'];
				$sql2 = " YEAR( fecha ) = $yyyy and MOnTH( fecha ) = $mes ";
				
				//fecha >= '$finicial' AND fecha <= '$ffinal' 
				
				if( isset($yyyy)&&isset($mes) ){
				
					$devoluciones = $this->Devoluciones->find(" $sql2 and empresa_id = '$empresa_id'");
	          		$this->setParamToView("devoluciones", $devoluciones);
				}else{
					Flash::success("El campo fecha inicial no fue seleccionado");	
					Flash::success("El campo fecha final no fue seleccionado");	
				}
		
		}
		
		public function facturaAction(){
			
			
		}
		
		public function detalle_facturasAction(){
				
				$this->setResponse('view');
				
				$facturas  = new Factura();
				
				//$finicial = $_REQUEST['finicial'];
				//$ffinal = $_REQUEST['ffinal'];
				$empresa_id = $_REQUEST['empresa_id'];
				
				$yyyy = $_REQUEST['yyyy'];
				$mes = $_REQUEST['mes'];
				
				/*if( isset($finicial)&&isset($ffinal) ){
				
					$facturas = $this->Factura->find(" fecha >= '$finicial' AND fecha <= '$ffinal' and empresa_id = '".Session::get("id_empresa")."'");
	          		$this->setParamToView("facturas", $facturas);
				}else{
					Flash::success("El campo fecha inicial no fue seleccionado");	
					Flash::success("El campo fecha final no fue seleccionado");	
				}*/
				
				$sql='';
				$sql = "";
				$sql1 = "and {#EstadoCuenta}.anulado = '0' ";
				//$sql2 = "and {#Factura}.fecha >= '$finicial' AND {#Factura}.fecha <= '$ffinal'";
				$sql2 = "and YEAR( {#Factura}.fecha ) = $yyyy and MOnTH( {#Factura}.fecha ) = $mes ";
				$query = new ActiveRecordJoin(array(
						"entities" => array("EstadoCuenta","Factura","Clientes","Direccion","Empresa"),
					 	"fields"=>array(
										"{#Factura}.id",
										"{#Factura}.prefijo",
										"{#Factura}.consecutivo",
										"{#Factura}.fecha",
										"{#Factura}.empresa_id",
										"{#Factura}.vencimiento",
										"{#Clientes}.razon_social",
										"{#Direccion}.direccion",
										"DATEDIFF( {#Factura}.vencimiento , ".date("Y-m-d")." ) as atraso",
										"{#EstadoCuenta}.total",
										"{#EstadoCuenta}.anticipo",
										"{#EstadoCuenta}.pagado",
										"{#EstadoCuenta}.descontado",										
										),
						"conditions"=>(" {#Factura}.empresa_id = '$empresa_id' $sql $sql1 $sql2")
				));
				//Flash::error($query->getSqlQuery());
			 $this->setParamToView('facturas',$query->getResultSet());
			 $this->setParamToView('sql',$query->getResultSet());
		
		}
		
		public function historico_clientes_buscarAction(){
			
			
		}
		
		public function trae_detalle_clientesAction(){
				
				//$this->setResponse('view');
				
				$facturas  = new Factura();
				
				$id = $_REQUEST['clientes_id'];
				$empresa_id = $_REQUEST['empresa_id'];
				
					
	          		
				
				if(isset($id)){
				
					$facturas = $this->Factura->find(" clientes_id = '$id' and empresa_id = '$empresa_id' and anulado = 0 ");
	          		$this->setParamToView("facturas", $facturas);
					
				}
				
				if(isset($id)){
				
					$remisiones = $this->Remisiones->find(" clientes_id='$id' and empresa_id = '$empresa_id' and anulado = 0 ");
	          		$this->setParamToView("remisiones", $remisiones);
					
				}
				
				if(isset($id)){
				
					$devoluciones = $this->Devoluciones->find(" clientes_id='$id' and empresa_id = '$empresa_id' and anulado = 0 ");
	          		$this->setParamToView("devoluciones", $devoluciones);
					
				}
				
				$this->setParamToView("clientes", $this->Clientes->findFirst(" id = '$id' "));
				$this->setParamToView('empresa',$this->Empresa->findFirst(" id = '".$empresa_id."' "));
		
		}
		
		public function trae_clientesAction(){
			
			$this->setResponse('ajax');
			//$this->setTemplateAfter("default");

		}
		
		
		public function trae_clientes_detallesAction(){
			
			$this->setResponse('view');
			
			
			$sql = '';
			if( isset( $_REQUEST['codigo']       )==true ) { if( $_REQUEST['codigo'] != ''       ) { $sql .= " and {#Clientes}.id = '".$_REQUEST['codigo']."'";                 } }
			if( isset( $_REQUEST['nit']          )==true ) { if( $_REQUEST['nit'] != ''          ) { $sql .= " and {#Clientes}.nit like '".$_REQUEST['nit']."%'";                   } }
			if( isset( $_REQUEST['razon_social'] )==true ) { if( $_REQUEST['razon_social'] != '' ) { $sql .= " and {#Clientes}.razon_social like '%".str_replace(' ',"%",utf8_decode($_REQUEST['razon_social']))."%'"; } }
			//if( isset( $_REQUEST['direccion'] )==true ) { if( $_REQUEST['direccion'] != '' ) { $sql .= " and {#Direccion}.direccion like '%".str_replace(' ',"%",$_REQUEST['direccion'])."%'"; } }
			//if( isset( $_REQUEST['orderby']      )==true ) { if( $_REQUEST['orderby'] != ''      ) { $sql .= " order by ".$_REQUEST['orderby']." ";       } }
			
			$query = new ActiveRecordJoin(array(
						"entities" => array("Clientes"),
					 	"fields"=>array(
										"{#Clientes}.razon_social",
										"{#Clientes}.id",
										"{#Clientes}.nit",
												
										),
						"conditions"=>(" 1=1 $sql")
				));
			
			//$clientes = $this->Clientes->findAllBySql($sql);
			//Flash::error($sql);
			$this->setParamToView('clientes',$query->getResultSet());
		
		}
		
		
		
		public function carteraAction(){
			
				//$sql2 = '';
				$sql2 = " and YEAR({#Factura}.fecha ) = '' ";
				$sql3 = '';
				
				if(isset($_REQUEST["empresa_id"])){
					$empresa_id = $this->Empresa->findFirst(" id = '".$_REQUEST["empresa_id"]."' ")->id;
				}else{
					$empresa_id = $this->Empresa->findFirst()->id;
				}
				
				if(isset($_REQUEST["yyyy"])){
					$yyyy = $_REQUEST["yyyy"];
					if($yyyy != ''){
						$sql2 = " and YEAR({#Factura}.fecha ) = '$yyyy' ";
					}
				}
				
				if(isset($_REQUEST["mes"])){
					$mes = $_REQUEST["mes"];
					if($mes != ''){
						$sql3 = " and MONTH({#Factura}.fecha) = '$mes' ";
					}
				}
				
				$sql='';
				$sql = " and ( {#EstadoCuenta}.total - {#EstadoCuenta}.anticipo - {#EstadoCuenta}.pagado ) <> 0";
				$sql1 = " and {#EstadoCuenta}.anulado = '0' ";
				
				
				$query = new ActiveRecordJoin(array(
						"entities" => array("EstadoCuenta","Factura","Clientes","Direccion"),
					 	"fields"=>array(
										"{#Factura}.id",
										"{#Factura}.prefijo",
										"{#Factura}.consecutivo",
										"{#Factura}.fecha",
										"{#Factura}.empresa_id",
										"{#Factura}.vencimiento",
										"{#Clientes}.razon_social",
										"{#Direccion}.direccion",
										"DATEDIFF( {#Factura}.vencimiento , ".date("Y-m-d")." ) as atraso",
										"{#EstadoCuenta}.total",
										"{#EstadoCuenta}.anticipo",
										"{#EstadoCuenta}.pagado",
										"{#EstadoCuenta}.descontado",										
										),
						"conditions"=>(" {#Factura}.empresa_id = '".$empresa_id."' $sql $sql1 $sql2 $sql3 ")
				));
				//Flash::error($query->getSqlQuery());
			 $this->setParamToView('facturas',$query->getResultSet());
			 $this->setParamToView('empresa',$this->Empresa->findFirst(" id = '".$empresa_id."' "));	
			
		}
		
		
		public function recibos_cajaAction(){
			
			
		}
		
		
		
		public function detalle_recibos_cajaAction(){
				
				$this->setResponse('view');
				
				
				//$finicial = $_REQUEST['finicial'];
				//$ffinal = $_REQUEST['ffinal'];
				
				$yyyy = $_REQUEST['yyyy'];
				$mes = $_REQUEST['mes'];
				$empresa_id = $_REQUEST['empresa_id'];
				
		
				//consulta de anticipos de clientes
				
				$sql='';
				$sql = "";
				$sql1 = " and {#Anticipos}.anulado = '0' ";
				//$sql2 = " and {#Anticipos}.fecha >= '$finicial' AND {#Anticipos}.fecha <= '$ffinal' ";
				$sql2 = "and YEAR( {#Anticipos}.fecha ) = $yyyy and MOnTH( {#Anticipos}.fecha ) = $mes ";
				$query = new ActiveRecordJoin(array(
						"entities" => array("Anticipos","Clientes","Empresa","TipoDocumento"),
					 	"fields"=>array(
										"{#Anticipos}.id",
										"{#Anticipos}.prefijo",
										"{#Anticipos}.consecutivo",
										"{#Anticipos}.fecha",
										"{#Anticipos}.total",
										"{#Clientes}.razon_social"
										),
						"conditions"=>(" {#Anticipos}.empresa_id = '$empresa_id' $sql $sql1 $sql2")
				));
				//Flash::error($query->getSqlQuery());
			 	$this->setParamToView('anticipos',$query->getResultSet());
				
				//consulta de recibos de caja
				
				$sql='';
				$sql = "";
				$sql1 = " and {#RecibosCaja}.anulado = '0' ";
				//$sql2 = " and {#RecibosCaja}.fecha >= '$finicial' AND {#RecibosCaja}.fecha <= '$ffinal' ";
				$sql2 = "and YEAR( {#RecibosCaja}.fecha ) = $yyyy and MOnTH( {#RecibosCaja}.fecha ) = $mes ";
				$query = new ActiveRecordJoin(array(
						"entities" => array("RecibosCaja","Clientes","Empresa","TipoDocumento"),
					 	"fields"=>array(
										"{#RecibosCaja}.id",
										"{#RecibosCaja}.prefijo",
										"{#RecibosCaja}.consecutivo",
										"{#RecibosCaja}.fecha",
										"{#Clientes}.razon_social"
										),
						"conditions"=>(" {#RecibosCaja}.empresa_id = '$empresa_id' $sql $sql1 $sql2")
				));
				//Flash::error($query->getSqlQuery());
			 $this->setParamToView('recibos_caja',$query->getResultSet());
		
		}
		
		
		
		
		
		public function recibos_caja_diarioAction(){
			
				
			
		}
		
		
		
		public function detalle_recibos_caja_diarioAction(){
				
				$this->setResponse('view');
				
				
				$finicial = $_REQUEST['finicial'];
				//$ffinal = $_REQUEST['ffinal'];
				$empresa_id = $_REQUEST['empresa_id'];
				
		
				//consulta de anticipos de clientes
				
				$sql='';
				$sql = "";
				$sql1 = " and {#Anticipos}.anulado = '0' ";
				$sql2 = " and {#Anticipos}.fecha = '$finicial' ";
				$query = new ActiveRecordJoin(array(
						"entities" => array("Anticipos","Clientes","Empresa","TipoDocumento"),
					 	"fields"=>array(
										"{#Anticipos}.id",
										"{#Anticipos}.prefijo",
										"{#Anticipos}.consecutivo",
										"{#Anticipos}.fecha",
										"{#Anticipos}.total",
										"{#Clientes}.razon_social"
										),
						"conditions"=>(" {#Anticipos}.empresa_id = '$empresa_id' $sql $sql1 $sql2")
				));
				//Flash::error($query->getSqlQuery());
			 	$this->setParamToView('anticipos',$query->getResultSet());
				
				//consulta de recibos de caja
				
				$sql='';
				$sql = "";
				$sql1 = " and {#RecibosCaja}.anulado = '0' ";
				$sql2 = " and {#RecibosCaja}.fecha = '$finicial'  ";
				$query = new ActiveRecordJoin(array(
						"entities" => array("RecibosCaja","Clientes","Empresa","TipoDocumento"),
					 	"fields"=>array(
										"{#RecibosCaja}.id",
										"{#RecibosCaja}.prefijo",
										"{#RecibosCaja}.consecutivo",
										"{#RecibosCaja}.fecha",
										"{#Clientes}.razon_social"
										),
						"conditions"=>(" {#RecibosCaja}.empresa_id = '$empresa_id' $sql $sql1 $sql2")
				));
				//Flash::error($query->getSqlQuery());
			 $this->setParamToView('recibos_caja',$query->getResultSet());
		
		}
		
		
		public function ver_pagosAction(){
				
				$this->setResponse('view');
				
				
				$factura_id = $_REQUEST['factura_id'];
				//$ffinal = $_REQUEST['ffinal'];
				$empresa_id = $_REQUEST['empresa_id'];
				
		
				//consulta de anticipos de clientes
				
				$sql='';
				$sql = "";
				$sql1 = " and {#Anticipos}.anulado = '0' and {#AnticiposFactura}.anulado = '0'";
				$sql2 = " and {#AnticiposFactura}.factura_id = '$factura_id' ";
				
				$query = new ActiveRecordJoin(array(
						"entities" => array("AnticiposFactura","Anticipos"),
					 	"fields"=>array(
										"{#Anticipos}.id",
										"{#Anticipos}.prefijo",
										"{#Anticipos}.consecutivo",
										"{#Anticipos}.fecha",
										"{#Anticipos}.total",
										"{#AnticiposFactura}.valor"
										),
						"conditions"=>(" {#Anticipos}.empresa_id = '$empresa_id' $sql $sql1 $sql2")
				));
				//Flash::error($query->getSqlQuery());
			 	$this->setParamToView('anticipos',$query->getResultSet());
				
				//consulta de recibos de caja
				
				$sql='';
				$sql = "";
				$sql1 = " and {#RecibosCaja}.anulado = '0' and {#DetalleRecibosCaja}.anulado = '0' ";
				$sql2 = " and {#DetalleRecibosCaja}.factura_id = '$factura_id'  ";
				$query = new ActiveRecordJoin(array(
						"entities" => array("RecibosCaja","DetalleRecibosCaja"),
					 	"fields"=>array(
										"{#RecibosCaja}.id",
										"{#RecibosCaja}.prefijo",
										"{#RecibosCaja}.consecutivo",
										"{#RecibosCaja}.fecha",
										"{#DetalleRecibosCaja}.total",
										"{#DetalleRecibosCaja}.descuento"
									
										),
						"conditions"=>(" {#RecibosCaja}.empresa_id = '$empresa_id' $sql $sql1 $sql2")
				));
				//Flash::error($query->getSqlQuery());
			 $this->setParamToView('recibos_caja',$query->getResultSet());
		
		}
		
		
		
		
		public function detalle_ingresos_diariosAction(){
				
				$this->setResponse('view');
				
				
				$finicial = $_REQUEST['finicial'];
				//$ffinal = $_REQUEST['ffinal'];
				$empresa_id = $_REQUEST['empresa_id'];
				
		
				//consulta de anticipos de clientes
				
				$sql='';
				$sql = "";
				$sql1 = " and {#Anticipos}.anulado = '0' ";
				$sql2 = " and {#Anticipos}.fecha = '$finicial' ";
				$query = new ActiveRecordJoin(array(
						"entities" => array("Anticipos","Clientes","Empresa","TipoDocumento"),
					 	"fields"=>array(
										"{#Anticipos}.id",
										"{#Anticipos}.prefijo",
										"{#Anticipos}.consecutivo",
										"{#Anticipos}.fecha",
										"{#Anticipos}.total",
										"{#Clientes}.razon_social"
										),
						"conditions"=>(" {#Anticipos}.empresa_id = '$empresa_id' $sql $sql1 $sql2")
				));
				//Flash::error($query->getSqlQuery());
			 	$this->setParamToView('anticipos',$query->getResultSet());
				
				//consulta de recibos de caja
				
				$sql='';
				$sql = "";
				$sql1 = " and {#RecibosCaja}.anulado = '0' ";
				$sql2 = " and {#RecibosCaja}.fecha = '$finicial'  ";
				$query = new ActiveRecordJoin(array(
						"entities" => array("RecibosCaja","Clientes","Empresa","TipoDocumento"),
					 	"fields"=>array(
										"{#RecibosCaja}.id",
										"{#RecibosCaja}.prefijo",
										"{#RecibosCaja}.consecutivo",
										"{#RecibosCaja}.fecha",
										"{#Clientes}.razon_social"
										),
						"conditions"=>(" {#RecibosCaja}.empresa_id = '$empresa_id' $sql $sql1 $sql2")
				));
				//Flash::error($query->getSqlQuery());
			 $this->setParamToView('recibos_caja',$query->getResultSet());
			 
			 /*egresos diarios*/
			 
			 	$sql='';
				$sql = "";
				$sql1 = " and {#Egresos}.anulado = '0' ";
				$sql2 = " and {#Egresos}.fecha = '$finicial'  ";
				$query = new ActiveRecordJoin(array(
						"entities" => array("Egresos","DetalleEgresos","Proveedores","Empresa","FormaPago"),
						"groupFields" => array(
										"{#DetalleEgresos}.id",
										"{#Egresos}.id",
										"{#Egresos}.prefijo",
										"{#Egresos}.consecutivo",
										"{#Egresos}.fecha",
										"{#FormaPago}.forma_pago",
										"{#DetalleEgresos}.concepto",
										"{#Proveedores}.razon_social"
										),
						"sumatory" => array("{#DetalleEgresos}.total"),
					 	/*"fields"=>array(
										"{#RecibosCaja}.id",
										"{#RecibosCaja}.prefijo",
										"{#RecibosCaja}.consecutivo",
										"{#RecibosCaja}.fecha",
										"{#Clientes}.razon_social"
										),*/
						"conditions"=>(" {#Egresos}.empresa_id = '$empresa_id' $sql $sql1 $sql2")
				));
				//Flash::error($query->getSqlQuery());
			 $this->setParamToView('egresos',$query->getResultSet());
		
		}
		
		
		
		public function historico_facturasAction(){
		
				$sql2 = '';
				$sql3 = '';
				$sql4 = '';
				
				if(isset($_REQUEST["empresa_id"])){
					$empresa_id = $this->Empresa->findFirst(" id = '".$_REQUEST["empresa_id"]."' ")->id;
				}else{
					$empresa_id = $this->Empresa->findFirst()->id;
				}
				
				/*if(isset($_REQUEST["desde"])){
					$desde = $_REQUEST["desde"];
					if($desde != ''){
						$sql2 = " and {#Factura}.fecha >= '$desde' ";
					}
				}
				
				if(isset($_REQUEST["hasta"])){
					$hasta = $_REQUEST["hasta"];
					if($hasta != ''){
						$sql3 = " and {#Factura}.fecha <= '$hasta' ";
					}
				}*/
				
				if(isset($_REQUEST["yyyy"])){
					$yyyy = $_REQUEST["yyyy"];
					if($yyyy != ''){
						$sql2 = " and YEAR( {#Factura}.fecha )  = '$yyyy' ";
					}
				}
				
				if(isset($_REQUEST["mes"])){
					$mes = $_REQUEST["mes"];
					if($mes != ''){
						$sql3 = " and MONTH ( {#Factura}.fecha ) = '$mes' ";
					}
				}
				
				if(isset($_REQUEST["clientes_id"])){
					$clientes_id = $_REQUEST["clientes_id"];
					if($clientes_id != ''){
						$sql4 = " and {#Factura}.clientes_id = '$clientes_id' ";
					}
				}else{
						$sql4 = " and {#Factura}.clientes_id = '' ";
				}
				
				$sql='';
				//$sql = " and ( {#EstadoCuenta}.total - {#EstadoCuenta}.anticipo - {#EstadoCuenta}.pagado ) <> 0";
				//$sql2 = "and YEAR( {#Factura}.fecha ) = $yyyy and MOTH( {#Factura}.fecha ) = $mes ";
				$sql1 = " and {#EstadoCuenta}.anulado = '0' ";
				
				
				$query = new ActiveRecordJoin(array(
						"entities" => array("EstadoCuenta","Factura","Clientes","Direccion"),
					 	"fields"=>array(
										"{#Factura}.id",
										"{#Factura}.prefijo",
										"{#Factura}.consecutivo",
										"{#Factura}.fecha",
										"{#Factura}.empresa_id",
										"{#Factura}.vencimiento",
										"{#Clientes}.razon_social",
										"{#Direccion}.direccion",
										"DATEDIFF( {#Factura}.vencimiento , ".date("Y-m-d")." ) as atraso",
										"{#EstadoCuenta}.total",
										"{#EstadoCuenta}.anticipo",
										"{#EstadoCuenta}.pagado",
										"{#EstadoCuenta}.descontado",										
										),
						"conditions"=>(" {#Factura}.empresa_id = '".$empresa_id."' $sql $sql1 $sql2 $sql3 $sql4")
				));
				//Flash::error($query->getSqlQuery());
			 $this->setParamToView('facturas',$query->getResultSet());
			 $this->setParamToView('empresa',$this->Empresa->findFirst(" id = '".$empresa_id."' "));	
			
			
		}
		
		
		
		
		
		public function kardexAction(){
		
		}
		
		
		public function detalle_kardexAction(){
				
			$this->setResponse("view");	
			
			$sql = '';
			
			if( isset( $_REQUEST['empresa_id']   )==true ) { if( $_REQUEST['empresa_id'] != ''   ) { $sql .= " and {#SaldoRemisiones}.empresa_id like '%".$_REQUEST['empresa_id']."%'";                   } }	
			if( isset( $_REQUEST['nit']          )==true ) { if( $_REQUEST['nit'] != ''          ) { $sql .= " and {#Clientes}.nit like '".$_REQUEST['nit']."%'";                   } }
			if( isset( $_REQUEST['razon_social'] )==true ) { if( $_REQUEST['razon_social'] != '' ) { $sql .= " and {#Clientes}.razon_social like '%".str_replace(' ',"%",utf8_decode($_REQUEST['razon_social']))."%'"; } }
			
			$query = new ActiveRecordJoin(array(
						"entities" => array("Clientes","SaldoRemisiones"),
						"groupFields" => array(
							"{#Clientes}.razon_social",
							"{#Clientes}.id",
							"{#Clientes}.nit",
							"{#SaldoRemisiones}.empresa_id"
						),
						"conditions" => "{#SaldoRemisiones}.anulado = 0 and ( {#SaldoRemisiones}.cantidad - {#SaldoRemisiones}.devueltos ) <> 0 $sql "
						
				));
				
				$this->setParamToView("detalles", $query->getResultSet());
				$this->setParamToView("sql", $query->getSqlQuery());
				//Flash::error($query->getSqlQuery());
		
		
		}
		
	

		public function ingresosAction(){
		
		}
		
		
		
	
			
   }
   
?>