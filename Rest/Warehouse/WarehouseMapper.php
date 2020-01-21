<?php
namespace Sales\V1\Rest\Warehouse;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\AdapterDbSelect;
use Zend\Session\Container;
use Zend\Session\SessionManager;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Delete;
use Zend\Crypt\Password\Bcrypt;
use Sales\V1\Rest\CommonFunctions\CommonFunctionsMapper;

class WarehouseMapper {

	protected $mapper;
	public function __construct(AdapterInterface $adapter) {
		// date_default_timezone_set("Asia/Manila");
		$this->adapter=$adapter;
		$this->commonfunctions  = new CommonFunctionsMapper($this->adapter);
	}

	/*public function fetchOne($param) {
		$from=$param->from;
		$action=$param->action;
		$returnval=$this->$from($param);
		return $returnval; 
	}*/
	public function fetchOne($param) {
			$action=$param->action;
			$from=$param->from;
			/*if($from=='add_user_login'){*/
				$validateToken=$this->commonfunctions->validateToken();
				
				if($validateToken->success=='1'){
					$returnval=$this->$from($param);
					return $returnval;
				}else{
					return $validateToken;
				}
			/*}else{
				$returnval=$this->$from($param);
				return $returnval;
			}*/
  	    
	}
	public function indexing($param) {
		
	}

	public function warehouseadd($param){
	$userData=$param->userData;
	// $userid=$userData['user_id'];
	// $usertype=$userData['user_type'];
	// $idCustomer=$userData['idCustomer'];

		$userid=$param->userid;
	$usertype=$param->usertype;
	$idCustomer=$param->idcustomer;

		if($param->action=='list'){
			if($usertype>0){
			$qry="SELECT wm.idWarehouse as idWarehouse,wm.warehouseName as warehouseName,wm.warehouseMobileno as warehouseMobileno,wm.warehouseEmail as warehouseEmail,wm.status
			FROM warehouse_master as wm WHERE idLevel='$usertype'";
			}else{
				$qry="SELECT wm.idWarehouse as idWarehouse,wm.warehouseName as warehouseName,wm.warehouseMobileno as warehouseMobileno,wm.warehouseEmail as warehouseEmail,wm.status
			FROM warehouse_master as wm";
			}


			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();

			$qry1="SELECT IF(hm.title !='',hm.title,'') AS H1 FROM territorytitle_master hm where hm.idTerritoryTitle=1";
			$result1=$this->adapter->query($qry1,array());
			$resultset1=$result1->toArray();

			$qry2="SELECT IF(hm.title !='',hm.title,'') AS H2 FROM territorytitle_master hm where hm.idTerritoryTitle=2";
			$result2=$this->adapter->query($qry2,array());
			$resultset2=$result2->toArray();

			$qry3="SELECT IF(hm.title !='',hm.title,'') AS H3 FROM territorytitle_master hm where hm.idTerritoryTitle=3";
			$result3=$this->adapter->query($qry3,array());
			$resultset3=$result3->toArray();

			$qry4="SELECT IF(hm.title !='',hm.title,'') AS H4 FROM territorytitle_master hm where hm.idTerritoryTitle=4";
			$result4=$this->adapter->query($qry4,array());
			$resultset4=$result4->toArray();

			$qry5="SELECT IF(hm.title !='',hm.title,'') AS H5 FROM territorytitle_master hm where hm.idTerritoryTitle=5";
			$result5=$this->adapter->query($qry5,array());
			$resultset5=$result5->toArray();

			$qry6="SELECT IF(hm.title !='',hm.title,'') AS H6 FROM territorytitle_master hm where hm.idTerritoryTitle=6";
			$result6=$this->adapter->query($qry6,array());
			$resultset6=$result6->toArray();

			$qry7="SELECT IF(hm.title !='',hm.title,'') AS H7 FROM territorytitle_master hm where hm.idTerritoryTitle=7";
			$result7=$this->adapter->query($qry7,array());
			$resultset7=$result7->toArray();

			$qry8="SELECT IF(hm.title !='',hm.title,'') AS H8 FROM territorytitle_master hm where hm.idTerritoryTitle=8";
			$result8=$this->adapter->query($qry8,array());
			$resultset8=$result8->toArray();

			$qry9="SELECT IF(hm.title !='',hm.title,'') AS H9 FROM territorytitle_master hm where hm.idTerritoryTitle=9";
			$result9=$this->adapter->query($qry9,array());
			$resultset9=$result9->toArray();

			$qry10="SELECT IF(hm.title !='',hm.title,'') AS H10 FROM territorytitle_master hm where hm.idTerritoryTitle=10";
			$result10=$this->adapter->query($qry10,array());
			$resultset10=$result10->toArray();

			if($resultset1){
				$ret_arr=['code'=>'1','content'=>$resultset,'contentlist1'=>$resultset1,'contentlist2'=>$resultset2,'contentlist3'=>$resultset3,'contentlist4'=>$resultset4,'contentlist5'=>$resultset5,'contentlist6'=>$resultset6,'contentlist7'=>$resultset7,'contentlist8'=>$resultset8,'contentlist9'=>$resultset9,'contentlist10'=>$resultset10,'status'=>true,'message'=>'No of records'.count($resultset)];
			} else {
				$ret_arr=['code'=>'2','content'=>'','status'=>false,'message'=>'No records to view'];
			}
		}
		else if($param->action=='add'){
			$fiedls=$param->Form;
			$type=$param->type;
			$custype=$fiedls['customername'];
			$qrycus="SELECT cs_type FROM  customer where idCustomer='$custype'";
			$resultcus=$this->adapter->query($qrycus,array());
			$resultsetcus=$resultcus->toArray();
			
			$factory=$param->factory_id;
			$qryEmail="SELECT * FROM  warehouse_master where warehouseEmail=?";
			$resultEmail=$this->adapter->query($qryEmail,array($fiedls['ware_email']));
			$resultsetEmail=$resultEmail->toArray();

			$qryMobile="SELECT * FROM  warehouse_master where warehouseMobileno=?";
			$resultMobile=$this->adapter->query($qryMobile,array($fiedls['ware_mob']));
			$resultsetMobile=$resultMobile->toArray();

				$qry="SELECT * FROM  warehouse_master where warehouseName=?";
			$result=$this->adapter->query($qry,array($fiedls['warehouse_name']));
			$resultset=$result->toArray();

            if (count($resultset)>0) 
            {
            	$ret_arr=['code'=>'3','status'=>false,'message'=>'Warehouse name already exists'];
            }
            else if(count($resultsetMobile)>0)
            {
              $ret_arr=['code'=>'3','status'=>false,'message'=>'Mobile number already exists'];
            }
            else if(count($resultsetEmail)>0)
            {
               $ret_arr=['code'=>'3','status'=>false,'message'=>'Email id already exists'];	
            }
			else{
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['warehouseName']=$fiedls['warehouse_name'];
					$datainsert['warehouseMobileno']=$fiedls['ware_mob'];
					$datainsert['warehouseEmail']=$fiedls['ware_email'];
					$datainsert['status']=$fiedls['whstatus'];
					if($type==1){
					$datainsert['idCustomer']=$fiedls['customername'];
					}else{
					$datainsert['idCustomer']=$idCustomer;
					}
					if($type==1){
					$datainsert['idLevel']=$resultsetcus[0]['cs_type'];
					}else{
					$datainsert['idLevel']=$usertype;
					}
					$datainsert['t1']=($fiedls['H1']!='' && $fiedls['H1']!=undefined )?$fiedls['H1']:0;
					$datainsert['t2']=($fiedls['H2']!='' && $fiedls['H2']!=undefined )?$fiedls['H2']:0;
					$datainsert['t3']=($fiedls['H3']!='' && $fiedls['H3']!=undefined )?$fiedls['H3']:0;
					$datainsert['t4']=($fiedls['H4']!='' && $fiedls['H4']!=undefined )?$fiedls['H4']:0;
					$datainsert['t5']=($fiedls['H5']!='' && $fiedls['H5']!=undefined )?$fiedls['H5']:0;
					$datainsert['t6']=($fiedls['H6']!='' && $fiedls['H6']!=undefined )?$fiedls['H6']:0;
					$datainsert['t7']=($fiedls['H7']!='' && $fiedls['H7']!=undefined )?$fiedls['H7']:0;
					$datainsert['t8']=($fiedls['H8']!='' && $fiedls['H8']!=undefined )?$fiedls['H8']:0;
					$datainsert['t9']=($fiedls['H9']!='' && $fiedls['H9']!=undefined )?$fiedls['H9']:0;
					$datainsert['t10']=($fiedls['H10']!='' && $fiedls['H10']!=undefined )?$fiedls['H10']:0;
					
					if($usertype==0){
					$datainsert['idWarehousetype']=$fiedls['warehousetype'];
				}else{
					$datainsert['idWarehousetype']=1;
				}
					$datainsert['created_by']=$userid;
					$datainsert['created_at']=date('Y-m-d H:i:s');			

					$insert=new Insert('warehouse_master');
					$insert->values($datainsert);
					$statement=$this->adapter->createStatement();
					$insert->prepareStatement($this->adapter, $statement);
					$insertresult=$statement->execute();
					$warehouseid=$this->adapter->getDriver()->getLastGeneratedValue();

					foreach ($factory as $key => $value) {
						$datainsert1['idWarehouse']=$warehouseid;
						$datainsert1['idFactory']=$value;
						$insert1=new Insert('warehouse_products');
						$insert1->values($datainsert1);
						$statement1=$this->adapter->createStatement();
						$insert1->prepareStatement($this->adapter, $statement1);
						$insertresult1=$statement1->execute();	
					}	
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				}catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			} 
		}else if($param->action=='editview'){
			$editid=$param->id;
			$qry1="SELECT wm.idWarehouse,wm.warehouseName as wname,wm.idCustomer as custname,wm.warehouseMobileno as wmob,wm.warehouseEmail as wemail,wm.idWarehousetype,wm.status,tm1.territoryValue as t1,tm2.territoryValue as t2,tm3.territoryValue as t3,tm4.territoryValue as t4,tm5.territoryValue as t5,tm6.territoryValue as t6,tm7.territoryValue as t7,tm8.territoryValue as t8,tm9.territoryValue as t9,tm10.territoryValue as t10,wm.t1 as tm1,wm.t2 as tm2,wm.t3 as tm3,wm.t4 as tm4,wm.t5 as tm5,wm.t6 as tm6,wm.t7 as tm7,wm.t8 as tm8,wm.t9 as tm9,wm.t10 as tm10,wm.idWarehousetype FROM warehouse_master as wm 
			LEFT JOIN territory_master as tm1 ON tm1.idTerritory=wm.t1
			LEFT JOIN territory_master as tm2 ON tm2.idTerritory=wm.t2
			LEFT JOIN territory_master as tm3 ON tm3.idTerritory=wm.t3
			LEFT JOIN territory_master as tm4 ON tm4.idTerritory=wm.t4
			LEFT JOIN territory_master as tm5 ON tm5.idTerritory=wm.t5
			LEFT JOIN territory_master as tm6 ON tm6.idTerritory=wm.t6
			LEFT JOIN territory_master as tm7 ON tm7.idTerritory=wm.t7
			LEFT JOIN territory_master as tm8 ON tm8.idTerritory=wm.t8
			LEFT JOIN territory_master as tm9 ON tm9.idTerritory=wm.t9
			LEFT JOIN territory_master as tm10 ON tm10.idTerritory=wm.t10
			where wm.idWarehouse=?";
			$result1=$this->adapter->query($qry1,array($editid));
			$resultset1=$result1->toArray();
			 $customer_name="";
			if ($resultset1[0]['idWarehousetype']==1) {
				$qryCustomer="SELECT cs_name FROM customer WHERE idCustomer='".$resultset1[0]['custname']."'";
			$resultCustomer=$this->adapter->query($qryCustomer,array());
			$resultsetCustomer=$resultCustomer->toArray();
            $customer_name=$resultsetCustomer[0]['cs_name'];
			}
            
			

			$qrywarehouse="SELECT idWarehouseProduct,idFactory FROM warehouse_products where idWarehouse=?";
			$resultwarehouse=$this->adapter->query($qrywarehouse,array($editid));
			$resultsetwarehouse=$resultwarehouse->toArray();

			for($i=0;$i<count($resultsetwarehouse);$i++)
			{
				$checkedfactryid[]=$resultsetwarehouse[$i]['idFactory'];
			}

			$qry_factory="SELECT idFactory,factoryName FROM `factory_master` WHERE status=1";
			$result_factory=$this->adapter->query($qry_factory,array());
			$resultset_factory=$result_factory->toArray();
			 
				for ($j = 0; $j < count($resultset_factory); $j++){
					$factory[$j]['idFactory']=$resultset_factory[$j]['idFactory'];
					$factory[$j]['factoryName']=$resultset_factory[$j]['factoryName'];
					$factory[$j]['checked']=false;
				}
			

			for($i=0;$i<count($resultsetwarehouse);$i++) 
			{ 
				for ($j = 0; $j < count($factory); $j++){
					if($resultsetwarehouse[$i]['idFactory']==$factory[$j]['idFactory']) 
					{
						$factory[$j]['checked']=true;
					} 


				}
			}
			$qry="SELECT 
						A.idTerritoryTitle as id,
						A.title,
						'0' as default_territory,
						A.hierarchy as ter_name
						FROM territorytitle_master A WHERE A.title!=''";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		if(!$resultset) {
			$resultset=[];
		} else {
			for($i=0;$i<count($resultset);$i++) {
				$t1=$resultset1[$i]['tm1'];
				$t2=$resultset1[$i]['tm2'];
				$t3=$resultset1[$i]['tm3'];
				$t4=$resultset1[$i]['tm4'];
				$t5=$resultset1[$i]['tm5'];
				$t6=$resultset1[$i]['tm6'];
				$t7=$resultset1[$i]['tm7'];
				$t8=$resultset1[$i]['tm8'];
				$t9=$resultset1[$i]['tm9'];
				$t10=$resultset1[$i]['tm10'];
				$qry_geo="SELECT B.t1,A.idTerritory as id,A.idTerritoryTitle,A.territoryValue,A.territoryCode,A.status
			FROM territorymapping_master B 
            LEFT JOIN territory_master as A ON A.idTerritory=B.t1 GROUP By B.t1";
			$result_geo=$this->adapter->query($qry_geo,array());
			$resultset_geo1=$result_geo->toArray();
			
			if($t1){
			$qry_geo="SELECT B.t2,A.idTerritory as id,A.idTerritoryTitle,A.territoryValue,A.territoryCode,A.status
				FROM territorymapping_master B 
                LEFT JOIN territory_master as A ON A.idTerritory=B.t2
                where B.t1='$t1' AND B.t2!='' GROUP By B.t2";
				$result_geo=$this->adapter->query($qry_geo,array());
				$resultset_geo2=$result_geo->toArray();
			}
			if($t2){
				$qry_geo="SELECT B.t3,A.idTerritory as id,A.idTerritoryTitle,A.territoryValue,A.territoryCode,A.status
				FROM territorymapping_master B 
                LEFT JOIN territory_master as A ON A.idTerritory=B.t3
                where B.t1='$t1' AND B.t2='$t2' AND B.t3!='' GROUP By B.t3";
				$result_geo=$this->adapter->query($qry_geo,array());
				$resultset_geo3=$result_geo->toArray();
			}
			if($t3){
				$qry_geo="SELECT B.t4,A.idTerritory as id,A.idTerritoryTitle,A.territoryValue,A.territoryCode,A.status
				FROM territorymapping_master B 
                LEFT JOIN territory_master as A ON A.idTerritory=B.t4
                where B.t1='$t1' AND B.t2='$t2' AND B.t3='$t3' AND B.t4!=''  GROUP By B.t4";
				$result_geo=$this->adapter->query($qry_geo,array());
				$resultset_geo4=$result_geo->toArray();
			}

			
			if($t4){
				$qry_geo="SELECT B.t5,A.idTerritory as id,A.idTerritoryTitle,A.territoryValue,A.territoryCode,A.status
				FROM territorymapping_master B 
                LEFT JOIN territory_master as A ON A.idTerritory=B.t5
                where B.t1='$t1' AND B.t2='$t2' AND B.t3='$t3' AND B.t4='$t4' AND B.t5!='' GROUP By B.t5";
				$result_geo=$this->adapter->query($qry_geo,array());
				$resultset_geo5=$result_geo->toArray();

			}
			if($t5){
				$qry_geo="SELECT B.t6,A.idTerritory as id,A.idTerritoryTitle,A.territoryValue,A.territoryCode,A.status
				FROM territorymapping_master B 
                LEFT JOIN territory_master as A ON A.idTerritory=B.t6
                where B.t1='$t1' AND B.t2='$t2' AND B.t3='$t3' AND B.t4='$t4' AND B.t5='$t5' AND B.t6!='' GROUP By B.t6";
				$result_geo=$this->adapter->query($qry_geo,array());
				$resultset_geo6=$result_geo->toArray();
			}
			if($t6){
				$qry_geo="SELECT B.t7,A.idTerritory as id,A.idTerritoryTitle,A.territoryValue,A.territoryCode,A.status
				FROM territorymapping_master B 
                LEFT JOIN territory_master as A ON A.idTerritory=B.t7
                where B.t1='$t1' AND B.t2='$t2' AND B.t3='$t3' AND B.t4='$t4' AND B.t5='$t5' AND B.t6='$t6' AND B.t7!=''  GROUP By B.t7";
				$result_geo=$this->adapter->query($qry_geo,array());
				$resultset_geo7=$result_geo->toArray();
			}
			if($t7){
				$qry_geo="SELECT B.t8,A.idTerritory as id,A.idTerritoryTitle,A.territoryValue,A.territoryCode,A.status
				FROM territorymapping_master B 
                LEFT JOIN territory_master as A ON A.idTerritory=B.t8
                where B.t1='$t1' AND B.t2='$t2' AND B.t3='$t3' AND B.t4='$t4' AND B.t5='$t5' AND B.t6='$t6' AND B.t7='$t7' AND B.t8!=''  GROUP By B.t8";
				$result_geo=$this->adapter->query($qry_geo,array());
				$resultset_geo8=$result_geo->toArray();
			}
			if($t8){
				$qry_geo="SELECT B.t9,A.idTerritory as id,A.idTerritoryTitle,A.territoryValue,A.territoryCode,A.status
				FROM territorymapping_master B 
                LEFT JOIN territory_master as A ON A.idTerritory=B.t9
                where B.t1='$t1' AND B.t2='$t2' AND B.t3='$t3' AND B.t4='$t4' AND B.t5='$t5' AND B.t6='$t6' AND B.t7='$t7' AND B.t8='$t8' AND B.t9!=''  GROUP By B.t9";
				$result_geo=$this->adapter->query($qry_geo,array());
				$resultset_geo9=$result_geo->toArray();
			}
			if($t9){
				$qry_geo="SELECT B.t10,A.idTerritory as id,A.idTerritoryTitle,A.territoryValue,A.territoryCode,A.status
				FROM territorymapping_master B 
                LEFT JOIN territory_master as A ON A.idTerritory=B.t10
                where B.t1='$t1' AND B.t2='$t2' AND B.t3='$t3' AND B.t4='$t4' AND B.t5='$t5' AND B.t6='$t6' AND B.t7='$t7' AND B.t8='$t8' AND B.t9='$t9' AND B.t10!=''  GROUP By B.t10";
				$result_geo=$this->adapter->query($qry_geo,array());
				$resultset_geo10=$result_geo->toArray();
			}


				
			/*if(!$resultset_geo1) {
				$resultset[$i]['territory_status']="2";
				$resultset[$i]['territory_value']="";
			} else {*/
				if($i==0){
				$resultset[$i]['territory_status']="1";
				$resultset[$i]['territory_value']=$resultset_geo1;
				}
				if($i==1){
				$resultset[$i]['territory_status']="1";
				$resultset[$i]['territory_value']=$resultset_geo2;
				}
				if($i==2){
				$resultset[$i]['territory_status']="1";
				$resultset[$i]['territory_value']=$resultset_geo3;
				}
				if($i==3){
				$resultset[$i]['territory_status']="1";
				$resultset[$i]['territory_value']=$resultset_geo4;
				}
				if($i==4){
				$resultset[$i]['territory_status']="1";
				$resultset[$i]['territory_value']=$resultset_geo5;
				}
				if($i==5){
				$resultset[$i]['territory_status']="1";
				$resultset[$i]['territory_value']=$resultset_geo6;
				}
				if($i==6){
				$resultset[$i]['territory_status']="1";
				$resultset[$i]['territory_value']=$resultset_geo7;
				}
				if($i==7){
				$resultset[$i]['territory_status']="1";
				$resultset[$i]['territory_value']=$resultset_geo8;
				}
				if($i==8){
				$resultset[$i]['territory_status']="1";
				$resultset[$i]['territory_value']=$resultset_geo9;
				}
				if($i==9){
				$resultset[$i]['territory_status']="1";
				$resultset[$i]['territory_value']=$resultset_geo10;
				}
				//}
			}
			//print_r($resultset);exit;
		}
			$qryview="SELECT wp.idWarehouseProduct as id , fm.factoryName as factoryName FROM warehouse_products as wp LEFT JOIN factory_master as fm ON fm.idFactory=wp.idFactory where wp.idWarehouse=? GROUP BY wp.idFactory ORDER BY wp.idFactory";
			$resultview=$this->adapter->query($qryview,array($editid));
			$resultsetview=$resultview->toArray();
			if(!$resultset1){
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			}else{
				$ret_arr=['code'=>'2','content'=>$resultset1,'terytitle'=>$resultset,'status'=>true,'contentwarehouseid'=>$resultsetwarehouse,'checkedfactory'=>$factory,'chekfactoryid'=>$checkedfactryid,'customer_name'=>$customer_name,'factoryview'=>$resultsetview,'message'=>'Record available'];
			}

		}
		else if($param->action=='update'){
			
			$fiedls=$param->Form;
			$editid=$param->idWarehouse;
			$factory=$param->checkfactid;
			$allfactory=$param->allfactory;
			$type=$param->type;
			
			$custype=$fiedls['custname'];
			$qrycus="SELECT cs_type FROM  customer where idCustomer='$custype'";
			$resultcus=$this->adapter->query($qrycus,array());
			$resultsetcus=$resultcus->toArray();
			 
			$qryEmail="SELECT * FROM  warehouse_master where warehouseEmail=? AND idWarehouse!='$editid'";
			$resultEmail=$this->adapter->query($qryEmail,array($fiedls['ware_email']));
			$resultsetEmail=$resultEmail->toArray();

			$qryMobile="SELECT * FROM  warehouse_master where warehouseMobileno=? AND idWarehouse!='$editid'";
			$resultMobile=$this->adapter->query($qryMobile,array($fiedls['ware_mob']));
			$resultsetMobile=$resultMobile->toArray();

				$qry="SELECT * FROM  warehouse_master where warehouseName=? AND idWarehouse!='$editid'";
			$result=$this->adapter->query($qry,array($fiedls['warehouse_name']));
			$resultset=$result->toArray();

            if (count($resultset)>0) 
            {
            	$ret_arr=['code'=>'3','status'=>false,'message'=>'Warehouse name already exists'];
            }
            else if(count($resultsetMobile)>0)
            {
              $ret_arr=['code'=>'3','status'=>false,'message'=>'Mobile number already exists'];
            }
            else if(count($resultsetEmail)>0)
            {
               $ret_arr=['code'=>'3','status'=>false,'message'=>'Email id already exists'];	
            }
			else {
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$data['warehouseName']=$fiedls['wname'];
					$data['warehouseMobileno']=$fiedls['wmob'];
					$data['warehouseEmail']=$fiedls['wemail'];
					$data['status']=$fiedls['whstatus'];
					if($usertype==0){
					if($type==1){
					$data['idCustomer']=$fiedls['custname'];
					}else{
					$data['idCustomer']=$idCustomer;
					}
					}else{
					$data['idCustomer']=$idCustomer;
					}
					if($usertype==0){
					if($type==1){
					$data['idLevel']=$resultsetcus[0]['cs_type'];
					}else{
					$data['idLevel']=$usertype;
					}
				}else{
					$data['idLevel']=$usertype;
					}
					$data['t1']=($fiedls['H1']!='' && $fiedls['H1']!=undefined )?$fiedls['H1']:0;
					$data['t2']=($fiedls['H2']!='' && $fiedls['H2']!=undefined )?$fiedls['H2']:0;
					$data['t3']=($fiedls['H3']!='' && $fiedls['H3']!=undefined )?$fiedls['H3']:0;
					$data['t4']=($fiedls['H4']!='' && $fiedls['H4']!=undefined )?$fiedls['H4']:0;
					$data['t5']=($fiedls['H5']!='' && $fiedls['H5']!=undefined )?$fiedls['H5']:0;
					$data['t6']=($fiedls['H6']!='' && $fiedls['H6']!=undefined )?$fiedls['H6']:0;
					$data['t7']=($fiedls['H7']!='' && $fiedls['H7']!=undefined )?$fiedls['H7']:0;
					$data['t8']=($fiedls['H8']!='' && $fiedls['H8']!=undefined )?$fiedls['H8']:0;
					$data['t9']=($fiedls['H9']!='' && $fiedls['H9']!=undefined )?$fiedls['H9']:0;
					$data['t10']=($fiedls['H10']!='' && $fiedls['H10']!=undefined )?$fiedls['H10']:0;
					/*$data['t1']=$fiedls['H1'];
					$data['t2']=$fiedls['H2'];
					$data['t3']=$fiedls['H3'];
					$data['t4']=$fiedls['H4'];
					$data['t5']=$fiedls['H5'];
					$data['t6']=$fiedls['H6'];
					$data['t7']=$fiedls['H7'];
					$data['t8']=$fiedls['H8'];
					$data['t9']=$fiedls['H9'];
					$data['t10']=$fiedls['H10'];*/
					if($usertype==0){
					$data['idWarehousetype']=$fiedls['warehousetype'];
				}else{
					$data['idWarehousetype']=1;
				}
					$data['updated_by']=$userid;
					$data['updated_at']=date('Y-m-d H:i:s');
					
					$sql = new Sql($this->adapter);
					$update = $sql->update();
					$update->table('warehouse_master');
					$update->set($data);
					$update->where( array('idWarehouse' => $editid));
					$statement  = $sql->prepareStatementForSqlObject($update);
					$results    = $statement->execute();
					$factoryinserts['idWarehouse']=$editid;

					for($i=0;$i<count($factory);$i++){
						for($j=0;$j<count($allfactory);$j++)
						{
							if($factory[$i]==$allfactory[$j]['idFactory']){
								$finalinsertdata[$i]['idFactory']=$allfactory[$j]['idFactory'];
							}
					
						}
					}

					$delete = new Delete('warehouse_products');
					$delete->where(['idWarehouse=?' => $editid]);
					$statement=$this->adapter->createStatement();
					$delete->prepareStatement($this->adapter, $statement);
					$resultset=$statement->execute();

					for($i=0;$i<count($finalinsertdata);$i++)
					{

						$factoryinserts['idFactory']=$finalinsertdata[$i]['idFactory'];
                        $insertcat=new Insert('warehouse_products');
                        $insertcat->values($factoryinserts);
					    $statementcat=$this->adapter->createStatement();
					    $insertcat->prepareStatement($this->adapter, $statementcat);
					    $insertresultcat=$statementcat->execute();
					}


					$this->adapter->getDriver()->getConnection()->commit();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
				} catch (\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			} 
		}else if($param->action=='getcustomer') {

			$qry="SELECT idCustomer,cs_name FROM customer a";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}
		
		return $ret_arr;
	}

	public function getterritoryfunction($param){

		if($param->action=='getfactoryType'){

			$qry="SELECT idFactory,factoryName FROM  factory_master a WHERE status=1 ORDER BY factoryName ";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}

		}else if($param->action=='getprocat') {
			$factoryid=$param->factid;
			$factory=implode(',', $factoryid);
			$qry="SELECT cat.idCategory,cat.category,fm.idFactory FROM factory_master as fm 
			LEFT JOIN factory_products as fp ON fp.idFactory=fm.idFactory
			LEFT JOIN category as cat ON cat.idCategory=fp.idCategory
			WHERE fp.idFactory IN($factory)";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='getsubCategory') {
			$factoryid=$param->factid;
			$procatid=$param->catid;
			$factory=implode(',', $factoryid);
			$category=implode(',', $procatid);
			$qry="SELECT cat.idCategory,cat.category,sc.subcategory,sc.idSubCategory,fm.idFactory FROM factory_master as fm 
			LEFT JOIN factory_products as fp ON fp.idFactory=fm.idFactory
			LEFT JOIN category as cat ON cat.idCategory=fp.idCategory
			LEFT JOIN subcategory as sc ON sc.idSubCategory=fp.idSubCategory
			WHERE fp.idFactory IN($factory) and fp.idCategory IN($category)";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='getproduct') {
			$factoryid=$param->factid;
			$procatid=$param->catid;
			$subcatid=$param->subcatid;
			$factory=implode(',', $factoryid);
			$category=implode(',', $procatid);
			$subcategory=implode(',', $subcatid);
			$qry="SELECT fm.idFactory,cat.idCategory,cat.category,sc.subcategory,sc.idSubCategory,pd.idProduct,pd.productName,pd.productCode FROM factory_master as fm 
			LEFT JOIN factory_products as fp ON fp.idFactory=fm.idFactory
			LEFT JOIN category as cat ON cat.idCategory=fp.idCategory
			LEFT JOIN subcategory as sc ON sc.idSubCategory=fp.idSubCategory
			LEFT JOIN product_details as pd ON pd.idProduct=fp.idProduct
			WHERE fp.idFactory IN($factory) and fp.idCategory IN($category) and fp.idSubCategory IN($subcategory)";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='getsubCategoryType') {
			$subcatid=$param->subid;
			$subcat=implode(',', $subcatid);
			$qry="SELECT idSubCategory,idCategory,subcategory FROM subcategory a WHERE idCategory IN($subcat)";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='getproductType') {
			$subid=$param->subcategryid;
			$catid=$param->categryid;
			$subcategry=implode(',', $subid);
			$categry=implode(',', $catid);

			$qry="SELECT idProduct,idCategory,idSubCategory,productName,productCode FROM product_details a WHERE idCategory IN($categry) and idSubCategory IN($subcategry)";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			
			
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='product') {
			
			
			$qry="SELECT idProduct,productName,productCode FROM product_details a WHERE status='1'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			
			
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='hsncode') {

			$productid=$param->product_id;
			if($productid){
			$qry="SELECT idProduct,idHsncode FROM product_details a WHERE idProduct IN ($productid) AND status='1'";
			}else{
			$qry="SELECT idProduct,idHsncode FROM product_details a WHERE status='1'";
			}
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();

		
			
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'contenthsn'=>$resultsethsn,'status'=>true,'message'=>'Record available'];
			}
		}
		return $ret_arr;
	}
	function taxsplit($param){
		if($param->action=='list') {
			$taxsplit=$param->taxsplit;
		
		  		$qrytax="SELECT taxtype,cgst,sgst,igst,utgst FROM tax_split";
			$resulttax=$this->adapter->query($qrytax,array());
			$resultsettax=$resulttax->toArray();
			if(!$resultsettax){
				for($i=0;$i<count($taxsplit);$i++)
			 	{
			 		
				 	$tax[$i]['taxtype']=$taxsplit[$i];
				 	$tax[$i]['cgst']=0;
				 	$tax[$i]['sgst']=0;
				 	$tax[$i]['igst']=0;
				 	$tax[$i]['utgst']=0;
				}
			
		  	
			}else
			{
				$qry="SELECT taxtype,cgst,sgst,igst,utgst FROM tax_split";

			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			
			for($i=0;$i<count($resultset);$i++)
					
			 	{
			 		//echo "hai";
				 	$tax[$i]['taxtype']=$resultset[$i]['taxtype'];
				 	$tax[$i]['cgst']=($resultset[$i]['cgst'])?$resultset[$i]['cgst']:0;
				 	$tax[$i]['sgst']=($resultset[$i]['sgst'])?$resultset[$i]['sgst']:0;
				 	$tax[$i]['igst']=($resultset[$i]['igst'])?$resultset[$i]['igst']:0;
				 	$tax[$i]['utgst']=($resultset[$i]['utgst'])?$resultset[$i]['utgst']:0;
				}
			}



			if(!$resultsettax) {
				$ret_arr=['code'=>'1','content'=>$tax,'status'=>true,'message'=>'Record available'];
			} else{
				$ret_arr=['code'=>'2','content'=>$tax,'status'=>true,'message'=>'Record available'];
			}

          return $ret_arr;

		}else if($param->action=='add'){
			$taxspl=$param->tax;
			$cgst=$param->cgs;
			$sgst=$param->sgs;
			$igst=$param->igs;
			$utgst=$param->utgs;
			$qry="SELECT * FROM tax_split  where taxtype=?";
			$result=$this->adapter->query($qry,array($param->tax));
			$resultset=$result->toArray();
			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$delete = new Delete('tax_split');
					//$delete->where(['idProduct=?' => $editid]);
					$statement=$this->adapter->createStatement();
					$delete->prepareStatement($this->adapter, $statement);
					$resultset=$statement->execute();
					for($i=0;$i<count($taxspl);$i++){
						$datainsert['cgst']=$cgst[$i]; 
						$datainsert['sgst']=$sgst[$i]; 
						$datainsert['igst']=$igst[$i]; 
						$datainsert['utgst']=$utgst[$i]; 
						$datainsert['taxtype']=$taxspl[$i]; 
						$datainsert['created_by']='1';
						$datainsert['created_at']=date('Y-m-d H:i:s');
						
						$insert=new Insert('tax_split');
						$insert->values($datainsert);
						$statement=$this->adapter->createStatement();
						$insert->prepareStatement($this->adapter, $statement);
						$insertresult=$statement->execute();
            		}
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				} catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again...'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			} else {
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
			}
		}

		return $ret_arr;
	}


	function servicedropdown($param){
		if($param->action=='serviceclass'){
			$qry="SELECT idServiceClass,serviceClass FROM  service_class a ";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}
		if($param->action=='warehouse'){
			$qry="SELECT idWarehouse,warehouseName FROM  warehouse_master a ";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}
		return $ret_arr;
	}
	function inventory_norms($param){
		if($param->action=='list') {
				$warehouse_id=$param->warid;

				$qrywarid="SELECT idWarehouse FROM inventorynorms";
			 	$resultwarid=$this->adapter->query($qrywarid,array());
			 	$resultsetwarid=$resultwarid->toArray();   

				$qrypid="SELECT idInventoryNorms FROM inventorynorms WHERE idWarehouse='$warehouse_id'";
				$resultid=$this->adapter->query($qrypid,array());
			 	$resultsetid=$resultid->toArray();

			 	$qryproduct="SELECT idInventoryNorms FROM inventorynorms WHERE idWarehouse='$warehouse_id'";
				$resultproduct=$this->adapter->query($qryproduct,array());
				$resultsetproduct=$resultproduct->toArray();

				$qrywar="SELECT * FROM inventorynorms WHERE idWarehouse='$warehouse_id'";
				$resultwar=$this->adapter->query($qrywar,array());
				$resultsetwar=$resultwar->toArray(); 

			 	$qry="SELECT T3.idProduct,T1.idFactory,T3.productName,T4.productPrimaryCount,T4.productSize,T4.idPrimaryPackaging,T5.primarypackname 
					 	FROM warehouse_products as T1 
						LEFT JOIN factory_products as T2 ON T1.idFactory=T2.idFactory
						LEFT JOIN product_details as T3 ON T3.idProduct=T2.idProduct
		                LEFT JOIN product_size as T4 ON T4.idProduct=T2.idProduct
		                LEFT JOIN primary_packaging as T5 ON T5.idPrimaryPackaging=T4.idPrimaryPackaging
						WHERE T1.idWarehouse='$warehouse_id'";

				$result=$this->adapter->query($qry,array());
			 	$resultset=$result->toArray();  
			 for($i=0;$i<count($resultset);$i++)
			 	{
				 	$all_inventory[$i]['productName']=$resultset[$i]['productName'];
				 	$all_inventory[$i]['productSize']=$resultset[$i]['productSize'];
				 	$all_inventory[$i]['primarypackname']=$resultset[$i]['primarypackname'];
				 	$all_inventory[$i]['productPrimaryCount']=$resultset[$i]['productPrimaryCount'];
				 	$all_inventory[$i]['idPrimaryPackaging']=$resultset[$i]['idPrimaryPackaging'];
				 	$all_inventory[$i]['idProduct']=$resultset[$i]['idProduct'];
				 	$all_inventory[$i]['idFactory']=$resultset[$i]['idFactory'];
				 	$all_inventory[$i]['idInventoryNorms']=0;
				 	$all_inventory[$i]['idWarehouse']=0;
				 	$all_inventory[$i]['re_level']='';
				 	$all_inventory[$i]['re_qty']='';
				 	$all_inventory[$i]['re_max_stock']='';
				 	$all_inventory[$i]['re_min_stock']='';
				 	$all_inventory[$i]['re_days']='';
				}
				$inventoryqry="SELECT T3.idProduct,T1.idInventoryNorms,T1.idWarehouse,T1.re_level,T1.re_qty,T1.re_max_stock,T1.re_min_stock,T1.re_days,T3.productName,T3.productSize,T3.productUnit FROM inventorynorms as T1
	    		LEFT JOIN product_details as T3 ON T3.idProduct=T1.idProduct
	    		WHERE T1.idWarehouse='$warehouse_id'";

	             $resultinventory=$this->adapter->query($inventoryqry,array());
				 $resultsetinventory=$resultinventory->toArray(); 
                if($resultsetinventory)
                {
               	  for($i=0;$i<count($resultsetinventory);$i++)
			      {  
			      	$all_inventory[$i]['idInventoryNorms']=$resultsetinventory[$i]['idInventoryNorms'];
			 	    $all_inventory[$i]['idWarehouse']=$resultsetinventory[$i]['idWarehouse'];
				 	$all_inventory[$i]['re_level']=$resultsetinventory[$i]['re_level'];
				 	$all_inventory[$i]['re_qty']=$resultsetinventory[$i]['re_qty'];
				 	$all_inventory[$i]['re_max_stock']=$resultsetinventory[$i]['re_max_stock'];
				 	$all_inventory[$i]['re_min_stock']=$resultsetinventory[$i]['re_min_stock'];
				 	$all_inventory[$i]['re_days']=$resultsetinventory[$i]['re_days'];
			      } 
                }
			if(!$resultset) {
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			} else {
				$ret_arr=['code'=>'1','status'=>true,'content' =>$all_inventory,'contentwarid' =>$resultsetwarid,'contentid' =>$resultsetid,'productid' =>$resultsetproduct,'message'=>'System config information'];
			}
		}
		else if($param->action=='add'){
			$fiedls=$param->Form;
			$warehouse=$fiedls['warehouse'];
			$inventory_id=$param->inventory;
			$product=$param->product;
			$warid=$param->houseid;
			$level=$param->level;
			$qty=$param->qty;
			$max_stk=$param->max_stk;
			$min_stk=$param->min_stk;
			$no_days=$param->days;
		  	$qry="SELECT idWarehouse FROM inventorynorms WHERE idWarehouse='$warehouse'";
			$result=$this->adapter->query($qry,array($fiedls['warehouse']));
			$resultset=$result->toArray();
			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					// $delete = new Delete('inventorynorms');
					// $delete->where(['idWarehouse=?' => $warehouse]);
					// $statement=$this->adapter->createStatement();
					// $delete->prepareStatement($this->adapter, $statement);
					// $resultset=$statement->execute();
					for($i=0;$i<count($product);$i++){
						$datainsert['idWarehouse']=$fiedls['warehouse'];
						$datainsert['idProduct']=$product[$i]['idProduct'];
						$datainsert['idProdSize']=$product[$i]['productSize'];
						$datainsert['idPackage']=$product[$i]['idPrimaryPackaging'];
						$datainsert['re_level']=$level[$i]; 
						$datainsert['re_qty']=$qty[$i]; 
						$datainsert['re_max_stock']=$max_stk[$i]; 
						$datainsert['re_min_stock']=$min_stk[$i]; 
						$datainsert['re_days']=$no_days[$i]; 	
						$insert=new Insert('inventorynorms');
						$insert->values($datainsert);
						$statement=$this->adapter->createStatement();
						$insert->prepareStatement($this->adapter, $statement);
						$insertresult=$statement->execute();
            		}

					$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				} catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again...'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			} else {
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					
					$delete = new Delete('inventorynorms');
					$delete->where(['idWarehouse=?' => $warehouse]);
					$statement=$this->adapter->createStatement();
					$delete->prepareStatement($this->adapter, $statement);
					$resultset=$statement->execute();
					for($i=0;$i<count($product);$i++){
						$datainsert['idWarehouse']=$fiedls['warehouse'];
						$datainsert['idProduct']=$product[$i]['idProduct'];
						$datainsert['idProdSize']=$product[$i]['productSize'];
						$datainsert['idPackage']=$product[$i]['idPrimaryPackaging'];
						$datainsert['re_level']=$level[$i]; 
						$datainsert['re_qty']=$qty[$i]; 
						$datainsert['re_max_stock']=$max_stk[$i]; 
						$datainsert['re_min_stock']=$min_stk[$i]; 
						$datainsert['re_days']=$no_days[$i]; 	
								
						$insert=new Insert('inventorynorms');
						$insert->values($datainsert);
						$statement=$this->adapter->createStatement();
						$insert->prepareStatement($this->adapter, $statement);
						$insertresult=$statement->execute();
            		}
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				} catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again...'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			}
		}
		return $ret_arr;
	}

	function getgeographyfunction($param){
		if($param->action=='getHiearchy1') {
			$qry="SELECT idGeography, geoValue, geoCode FROM  geography a WHERE idGeographyTitle='1' and status='1'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='getHiearchy2') {
			$qry="SELECT idGeography, geoValue, geoCode FROM  geography a WHERE idGeographyTitle='2' and status='1'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='getHiearchy3') {
			$qry="SELECT idGeography, geoValue, geoCode FROM  geography a WHERE idGeographyTitle='3' and status='1'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='getHiearchy4') {
			$qry="SELECT idGeography, geoValue, geoCode FROM  geography a WHERE idGeographyTitle='4' and status='1'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='getHiearchy5') {
			$qry="SELECT idGeography, geoValue, geoCode FROM  geography a WHERE idGeographyTitle='5' and status='1'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='getHiearchy6') {
			$qry="SELECT idGeography, geoValue, geoCode FROM  geography a WHERE idGeographyTitle='6' and status='1'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='getHiearchy7') {
			$qry="SELECT idGeography, geoValue, geoCode FROM  geography a WHERE idGeographyTitle='7' and status='1'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='getHiearchy8') {
			$qry="SELECT idGeography, geoValue, geoCode FROM  geography a WHERE idGeographyTitle='8' and status='1'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}
		else if($param->action=='getHiearchy9') {
			$qry="SELECT idGeography, geoValue, geoCode FROM  geography a WHERE idGeographyTitle='9' and status='1'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}
		else if($param->action=='getHiearchy10') {
			$qry="SELECT idGeography, geoValue, geoCode FROM  geography a WHERE idGeographyTitle='10' and status='1'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}
		if($resultset){
			$ret_arr=['code'=>'1','content'=>$resultset,'status'=>true,'message'=>'No of records'.count($resultset)];
		} else {
			$ret_arr=['code'=>'2','content'=>'','status'=>false,'message'=>'No records to view'];
		}
		return $ret_arr;
	}


	public function accountmasterlist($param){
		if($param->action=='list') {
			$qry="SELECT a.idAccount as id,a.company as companyname,a.personName as persnname,a.accountEmail as email,a.accountMobileNo1 as mobno1,accountMobileNo2 as mobno2,a.status FROM account_master a ";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();

			$qry1="SELECT IF(hm.title !='',hm.title,'H1') AS H1 FROM geographytitle_master hm where hm.idGeographyTitle=1";
			$result1=$this->adapter->query($qry1,array());
			$resultset1=$result1->toArray();
            
			$qry2="SELECT IF(hm.title !='',hm.title,'H2') AS H2 FROM geographytitle_master hm where hm.idGeographyTitle=2";
			$result2=$this->adapter->query($qry2,array());
			$resultset2=$result2->toArray();

			$qry3="SELECT IF(hm.title !='',hm.title,'H3') AS H3 FROM geographytitle_master hm where hm.idGeographyTitle=3";
			$result3=$this->adapter->query($qry3,array());
			$resultset3=$result3->toArray();

			$qry4="SELECT IF(hm.title !='',hm.title,'H4') AS H4 FROM geographytitle_master hm where hm.idGeographyTitle=4";
			$result4=$this->adapter->query($qry4,array());
			$resultset4=$result4->toArray();

			$qry5="SELECT IF(hm.title !='',hm.title,'H5') AS H5 FROM geographytitle_master hm where hm.idGeographyTitle=5";
			$result5=$this->adapter->query($qry5,array());
			$resultset5=$result5->toArray();

			$qry6="SELECT IF(hm.title !='',hm.title,'H6') AS H6 FROM geographytitle_master hm where hm.idGeographyTitle=6";
			$result6=$this->adapter->query($qry6,array());
			$resultset6=$result6->toArray();

			$qry7="SELECT IF(hm.title !='',hm.title,'H7') AS H7 FROM geographytitle_master hm where hm.idGeographyTitle=7";
			$result7=$this->adapter->query($qry7,array());
			$resultset7=$result7->toArray();

			$qry8="SELECT IF(hm.title !='',hm.title,'H8') AS H8 FROM geographytitle_master hm where hm.idGeographyTitle=8";
			$result8=$this->adapter->query($qry8,array());
			$resultset8=$result8->toArray();

			$qry9="SELECT IF(hm.title !='',hm.title,'H9') AS H9 FROM geographytitle_master hm where hm.idGeographyTitle=9";
			$result9=$this->adapter->query($qry9,array());
			$resultset9=$result9->toArray();

			$qry10="SELECT IF(hm.title !='',hm.title,'H10') AS H10 FROM geographytitle_master hm where hm.idGeographyTitle=10";
			$result10=$this->adapter->query($qry10,array());
			$resultset10=$result10->toArray();
			
			
			if($resultset1){
				$ret_arr=['code'=>'1','content'=>$resultset,'contentlist1'=>$resultset1,'contentlist2'=>$resultset2,'contentlist3'=>$resultset3,'contentlist4'=>$resultset4,'contentlist5'=>$resultset5,'contentlist6'=>$resultset6,'contentlist7'=>$resultset7,'contentlist8'=>$resultset8,'contentlist9'=>$resultset9,'contentlist10'=>$resultset10,'status'=>true,'message'=>'No of records'.count($resultset)];
			} else {
				$ret_arr=['code'=>'2','content'=>'','status'=>false,'message'=>'No records to view'];
			}
		}
		else if($param->action=='add'){
			$fiedls=$param->Form;
			$qry="SELECT * FROM account_master  where company=?";
			$result=$this->adapter->query($qry,array($param->companyname));
			$resultset=$result->toArray();
			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['company']=$fiedls['companyname'];
					$datainsert['personName']=$fiedls['persnname'];
					$datainsert['accountMobileNo1']=$fiedls['mobile_no1'];
					$datainsert['accountMobileNo2']=$fiedls['mobile_no2']; 
					$datainsert['accountEmail']=$fiedls['email'];
					$datainsert['companyAddress']=$fiedls['address'];
					$datainsert['companyPincode']=$fiedls['pincode'];
					$datainsert['companyLandmark']= $fiedls['landmark'];
					$datainsert['g1']= $fiedls['geography1'];
					$datainsert['g2']=$fiedls['geography2'];
					$datainsert['g3']=$fiedls['geography3'];
					$datainsert['g4']=$fiedls['geography4'];
					$datainsert['g5']=$fiedls['geography5'];
					$datainsert['g6']=$fiedls['geography6'];
					$datainsert['g7']=$fiedls['geography7'];
					$datainsert['g8']=$fiedls['geography8'];
					$datainsert['g9']=$fiedls['geography9'];
					$datainsert['g10']=$fiedls['geography10'];
					$datainsert['status']=$fiedls['selectedstatus'];
					$datainsert['created_by']='1';
					$datainsert['created_at']=date('Y-m-d H:i:s');
					$insert=new Insert('account_master');
					$insert->values($datainsert);
					$statement=$this->adapter->createStatement();
					$insert->prepareStatement($this->adapter, $statement);
					$insertresult=$statement->execute();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				} catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again...'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			} else {
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
			}
		}
		else if($param->action=='editview') {
			$editid=$param->id;
			$qry="SELECT a.*,a.idAccount as id,a.company as companyname,a.personName as persnname,a.accountMobileNo1 as mobile_no1,a.accountMobileNo2 as mobile_no2,a.accountEmail as email,a.companyAddress as address,a.companyPincode as pincode,a.companyLandmark as landmark,HT1.geoValue as geography1,HT2.geoValue as geography2,HT3.geoValue as geography3,HT4.geoValue as geography4,HT5.geoValue as geography5,HT6.geoValue as geography6,HT7.geoValue as geography7,HT8.geoValue as geography8,HT9.geoValue as geography9,HT10.geoValue as geography10,a.g1 as g1,a.g2 as g2,a.g3 as g3,a.g4 as g4,a.g5 as g5,a.g6 as g6,a.g7 as g7,a.g8 as g8,a.g9 as g9,a.g10 as g10,a.status as selectedstatus
			FROM account_master a 
			LEFT JOIN geography HT1 ON HT1.idGeographyTitle=a.g1 
			LEFT JOIN geography HT2 ON HT2.idGeographyTitle=a.g2 
			LEFT JOIN geography HT3 ON HT3.idGeographyTitle=a.g3 
			LEFT JOIN geography HT4 ON HT4.idGeographyTitle=a.g4 
			LEFT JOIN geography HT5 ON HT5.idGeographyTitle=a.g5 
			LEFT JOIN geography HT6 ON HT6.idGeographyTitle=a.g6 
			LEFT JOIN geography HT7 ON HT7.idGeographyTitle=a.g7 
			LEFT JOIN geography HT8 ON HT8.idGeographyTitle=a.g8
			LEFT JOIN geography HT9 ON HT9.idGeographyTitle=a.g9 
			LEFT JOIN geography HT10 ON HT10.idGeographyTitle=a.g10
			where a.idAccount=?";
			$result=$this->adapter->query($qry,array($editid));
			$resultset=$result->toArray();
			if(!$resultset){
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}
		else if($param->action=='update') {
			$fiedls=$param->Form;
			$editid=$fiedls['id'];
			
			$qry="SELECT a.idAccount,a.company FROM account_master a where a.company=? and a.idAccount!='$editid'";
			$result=$this->adapter->query($qry,array($fiedls['companyname']));
			$resultset=$result->toArray();
			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try{
					$datainsert['company']=$fiedls['companyname'];
					$datainsert['personName']=$fiedls['persnname'];
					$datainsert['accountMobileNo1']=$fiedls['mobile_no1'];
					$datainsert['accountMobileNo2']=$fiedls['mobile_no2']; 
					$datainsert['accountEmail']=$fiedls['email'];
					$datainsert['companyAddress']=$fiedls['address'];
					$datainsert['companyPincode']=$fiedls['pincode'];
					$datainsert['companyLandmark']= $fiedls['landmark'];
					$datainsert['g1']= $fiedls['g1'];
					$datainsert['g2']=$fiedls['g2'];
					$datainsert['g3']=$fiedls['g3'];
					$datainsert['g4']=$fiedls['g4'];
					$datainsert['g5']=$fiedls['g5'];
					$datainsert['g6']=$fiedls['g6'];
					$datainsert['g7']=$fiedls['g7'];
					$datainsert['g8']=$fiedls['g8'];
					$datainsert['g9']=$fiedls['g9'];
					$datainsert['g10']=$fiedls['g10'];
					$datainsert['status']=$fiedls['selectedstatus'];
					$datainsert['updated_by']=1;
					$datainsert['updated_at']=date('Y-m-d H:i:s');
					$sql = new Sql($this->adapter);
					$update = $sql->update();
					$update->table('account_master');
					$update->set($datainsert);
					$update->where(array('idAccount' => $editid));
					$statement  = $sql->prepareStatementForSqlObject($update);
					$results    = $statement->execute();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				} catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			} else {
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
			}
		}
		else {
			$ret_arr=['code'=>'3','content'=>'','status'=>false,'message'=>'Please contact the administrator'];
		}
		return $ret_arr;
	}

	function serviceadd($param){
		if($param->action=='list') {
			$qry="SELECT sm.serviceName as serviceName,sm.idService as id,sm.status as status
			   FROM service_master sm ";

			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();

			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}

          return $ret_arr;

		}else if($param->action=='add'){
			$fiedls=$param->Form;
			$qry="SELECT * FROM service_master  where serviceName=?";
			$result=$this->adapter->query($qry,array($param->sername));
			$resultset=$result->toArray();
			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['serviceCat']=$fiedls['sercategory'];
					$datainsert['serviceSubcat']=$fiedls['sersubcat'];
					$datainsert['serviceName']=$fiedls['sername'];
					$datainsert['serviceUnit']=$fiedls['servceunit'];
					$datainsert['serviceNature']=$fiedls['natservce'];
					$datainsert['serviceFrequecy']= $fiedls['serfrequency'];
					$datainsert['serviceSeason']= $fiedls['serperiod'];
					$datainsert['serviceClass']=$fiedls['serclass'];
					$datainsert['status']=$fiedls['servicestatus'];
					$datainsert['created_by']='1';
					$datainsert['created_at']=date('Y-m-d H:i:s');
					$insert=new Insert('service_master');
					$insert->values($datainsert);
					$statement=$this->adapter->createStatement();
					$insert->prepareStatement($this->adapter, $statement);
					$insertresult=$statement->execute();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				} catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again...'];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			} else {
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
			}

		}else if($param->action=='editview') {
			$editid=$param->id;
			$qry="SELECT sm.idService as id,sm.serviceName as sername,sm.serviceNature as natservce_selected,sm.serviceUnit as serunit,sm.serviceFrequecy as serfrequency,sm.serviceSeason as serperiod,sm.status as servicestatus,c.category as category,s.subcategory as subcategory,sc.serviceClass as serviceClass,sm.serviceSubcat as sersubcat,sm.serviceCat as sercat,sm.serviceClass as serclass,
			case 
			when sm.serviceUnit=1 then 'Order based' 
			when sm.serviceUnit=2 then 'Manpower based'
			when sm.serviceUnit=3 then 'Duration based'
			when sm.serviceUnit=4 then 'Variable based'
			when sm.serviceUnit=5 then 'Activation based' 
			end as serviceUnit,
			case 
			when sm.serviceNature=1 then 'Standard'
			when sm.serviceNature=2 then 'Customized'
			when sm.serviceNature=3 then 'Variable'
			end as serviceNature,
			case 
			when sm.serviceFrequecy=1 then 'No of days'
			when sm.serviceFrequecy=2 then 'Week'
			when sm.serviceFrequecy=3 then 'Month'
			when sm.serviceFrequecy=4 then 'Year'
			end as serviceFrequecy,
			case 
			when sm.serviceSeason=1 then 'Month'
			when sm.serviceSeason=2 then 'Week'
			when sm.serviceSeason=3 then 'Year'
			when sm.serviceSeason=4 then 'Specific days'
			when sm.serviceSeason=5 then 'Hours'
			end as serviceSeason
			FROM service_master sm 
			LEFT JOIN category c ON sm.serviceCat=c.idCategory
			LEFT JOIN subcategory s ON sm.serviceSubcat=s.idSubCategory 
			LEFT JOIN service_class sc ON sm.serviceClass=sc.idServiceClass
			where sm.idService=?";
			$result=$this->adapter->query($qry,array($editid));
			$resultset=$result->toArray();
			if(!$resultset){
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}
		else if($param->action=='update') {
			$fiedls=$param->Form;
		
			$editid=$fiedls['id'];
			$qry="SELECT a.idService,a.serviceName FROM service_master a where a.serviceName=? and a.idService!='$editid'";
			$result=$this->adapter->query($qry,array($fiedls['sername']));
			$resultset=$result->toArray();
			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try{
					$datainsert['serviceCat']=$fiedls['sercat'];
					$datainsert['serviceSubcat']=$fiedls['sersubcat'];
					$datainsert['serviceName']=$fiedls['sername'];
					$datainsert['serviceUnit']=$fiedls['serunit'];
					$datainsert['serviceNature']=$fiedls['natservce_selected'];
					$datainsert['serviceFrequecy']= $fiedls['serfrequency'];
					$datainsert['serviceSeason']= $fiedls['serperiod'];
					$datainsert['serviceClass']=$fiedls['serclass'];
					$datainsert['status']=$fiedls['servicestatus'];
					$datainsert['updated_by']=1;
					$datainsert['updated_at']=date('Y-m-d H:i:s');
					$sql = new Sql($this->adapter);
					$update = $sql->update();
					$update->table('service_master');
					$update->set($datainsert);
					$update->where(array('idService' => $editid));
					$statement  = $sql->prepareStatementForSqlObject($update);
					$results    = $statement->execute();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				} catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			} else {
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
			}
		}
		else {
			$ret_arr=['code'=>'3','content'=>'','status'=>false,'message'=>'Please contact the administrator'];
		}
		return $ret_arr;
	}
	public function getterritoryvalue($param){
		if($param->action=='getHiearchy1'){

			$qry="SELECT idTerritory, territoryValue, territoryCode FROM  territory_master a WHERE idTerritoryTitle='1' and status='1'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}

		} else if($param->action=='getHiearchy2'){

			$ter1id=$param->ter1_id;
			if($ter1id)
			{
			$qry="SELECT a.t2, b.idTerritory, b.territoryValue FROM `territorymapping_master` as a LEFT JOIN territory_master AS b ON b.idTerritory=a.t2 WHERE a.t1='$ter1id' and status='1'";
		}else{
			$qry="SELECT  a.idTerritory, a.territoryValue FROM `territory_master` as a  WHERE a.idTerritoryTitle='2' and status='1'";
		}
			
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'ter1id'=>$ter1id,'status'=>true,'message'=>'Record available'];
			}

		} else if($param->action=='getHiearchy3'){
			$ter1id=$param->ter1_id;
			$ter2id=$param->ter2_id;
		
			if($ter2id)
			{
			$qry="SELECT a.t3, b.idTerritory, b.territoryValue FROM `territorymapping_master` as a LEFT JOIN territory_master AS b ON b.idTerritory=a.t3 WHERE a.t1='$ter1id' and a.t2='$ter2id' and status='1'";
		}else{
			$qry="SELECT  a.idTerritory, a.territoryValue FROM `territory_master` as a  WHERE a.idTerritoryTitle='3' and status='1'";
		}
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'ter2id'=>$ter2id,'status'=>true,'message'=>'Record available'];
			}

		}else if($param->action=='getHiearchy4'){
			$ter1id=$param->ter1_id;
			$ter2id=$param->ter2_id;
			$ter3id=$param->ter3_id;
			if($ter3id)
			{
			$qry="SELECT a.t4, b.idTerritory, b.territoryValue FROM `territorymapping_master` as a LEFT JOIN territory_master AS b ON b.idTerritory=a.t4 WHERE a.t1='$ter1id' and a.t2='$ter2id' and a.t3='$ter3id' and status='1'";
			}else{
			$qry="SELECT  a.idTerritory, a.territoryValue FROM `territory_master` as a  WHERE a.idTerritoryTitle='4' and status='1'";
			}
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'ter3id'=>$ter3id,'status'=>true,'message'=>'Record available'];
			}

		}else if($param->action=='getHiearchy5'){
			$ter1id=$param->ter1_id;
			$ter2id=$param->ter2_id;
			$ter3id=$param->ter3_id;
			$ter4id=$param->ter4_id;
			if($ter4id)
			{
			$qry="SELECT a.t5, b.idTerritory, b.territoryValue FROM `territorymapping_master` as a LEFT JOIN territory_master AS b ON b.idTerritory=a.t5 WHERE a.t1='$ter1id' and a.t2='$ter2id' and a.t3='$ter3id' and a.t4='$ter4id' and status='1'";
			}else{
			$qry="SELECT  a.idTerritory, a.territoryValue FROM `territory_master` as a  WHERE a.idTerritoryTitle='5' and status='1'";
			}
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'ter4id'=>$ter4id,'status'=>true,'message'=>'Record available'];
			}

		}else if($param->action=='getHiearchy6'){
			$ter1id=$param->ter1_id;
			$ter2id=$param->ter2_id;
			$ter3id=$param->ter3_id;
			$ter4id=$param->ter4_id;
			$ter5id=$param->ter5_id;
			if($ter5id)
			{
			$qry="SELECT a.t6, b.idTerritory, b.territoryValue FROM `territorymapping_master` as a LEFT JOIN territory_master AS b ON b.idTerritory=a.t6 WHERE a.t1='$ter1id' and a.t2='$ter2id' and a.t3='$ter3id' and a.t4='$ter4id' and a.t5='$ter5id' and status='1'";
			}else{
			$qry="SELECT  a.idTerritory, a.territoryValue FROM `territory_master` as a  WHERE a.idTerritoryTitle='6' and status='1'";
			}
			
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'ter5id'=>$ter5id,'status'=>true,'message'=>'Record available'];
			}

		}else if($param->action=='getHiearchy7'){
			$ter1id=$param->ter1_id;
			$ter2id=$param->ter2_id;
			$ter3id=$param->ter3_id;
			$ter4id=$param->ter4_id;
			$ter5id=$param->ter5_id;
			$ter6id=$param->ter6_id;
			if($ter6id)
			{
			$qry="SELECT a.t7, b.idTerritory, b.territoryValue FROM `territorymapping_master` as a LEFT JOIN territory_master AS b ON b.idTerritory=a.t7 WHERE a.t1='$ter1id' and a.t2='$ter2id' and a.t3='$ter3id' and a.t4='$ter4id' and a.t5='$ter5id' and a.t6='$ter6id' and status='1'";
			}else{
			$qry="SELECT  a.idTerritory, a.territoryValue FROM `territory_master` as a  WHERE a.idTerritoryTitle='7' and status='1'";
			}
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'ter6id'=>$ter6id,'status'=>true,'message'=>'Record available'];
			}

		}else if($param->action=='getHiearchy8'){
			$ter1id=$param->ter1_id;
			$ter2id=$param->ter2_id;
			$ter3id=$param->ter3_id;
			$ter4id=$param->ter4_id;
			$ter5id=$param->ter5_id;
			$ter6id=$param->ter6_id;
			$ter7id=$param->ter7_id;
			if($ter7id)
			{
			$qry="SELECT a.t8, b.idTerritory, b.territoryValue FROM `territorymapping_master` as a LEFT JOIN territory_master AS b ON b.idTerritory=a.t8 WHERE a.t1='$ter1id' and a.t2='$ter2id' and a.t3='$ter3id' and a.t4='$ter4id' and a.t5='$ter5id' and a.t6='$ter6id' and a.t7='$ter7id' and status='1'";
			}else{
			$qry="SELECT  a.idTerritory, a.territoryValue FROM `territory_master` as a  WHERE a.idTerritoryTitle='8' and status='1'";
			}
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'ter7id'=>$ter7id,'status'=>true,'message'=>'Record available'];
			}

		}else if($param->action=='getHiearchy9'){
			$ter1id=$param->ter1_id;
			$ter2id=$param->ter2_id;
			$ter3id=$param->ter3_id;
			$ter4id=$param->ter4_id;
			$ter5id=$param->ter5_id;
			$ter6id=$param->ter6_id;
			$ter7id=$param->ter7_id;
			$ter8id=$param->ter8_id;
			if($ter8id)
			{
			$qry="SELECT a.t9, b.idTerritory, b.territoryValue FROM `territorymapping_master` as a LEFT JOIN territory_master AS b ON b.idTerritory=a.t9 WHERE a.t1='$ter1id' and a.t2='$ter2id' and a.t3='$ter3id' and a.t4='$ter4id' and a.t5='$ter5id' and a.t6='$ter6id' and a.t7='$ter7id' and a.t8='$ter8id' and status='1'";
			}else{
			$qry="SELECT  a.idTerritory, a.territoryValue FROM `territory_master` as a  WHERE a.idTerritoryTitle='9' and status='1'";
			}
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'ter8id'=>$ter8id,'status'=>true,'message'=>'Record available'];
			}

		}else if($param->action=='getHiearchy10'){
			$ter1id=$param->ter1_id;
			$ter2id=$param->ter2_id;
			$ter3id=$param->ter3_id;
			$ter4id=$param->ter4_id;
			$ter5id=$param->ter5_id;
			$ter6id=$param->ter6_id;
			$ter7id=$param->ter7_id;
			$ter8id=$param->ter8_id;
			$ter9id=$param->ter9_id;
			if($ter9id)
			{
			$qry="SELECT a.t10, b.idTerritory, b.territoryValue FROM `territorymapping_master` as a LEFT JOIN territory_master AS b ON b.idTerritory=a.t10 WHERE a.t1='$ter1id' and a.t2='$ter2id' and a.t3='$ter3id' and a.t4='$ter4id' and a.t5='$ter5id' and a.t6='$ter6id' and a.t7='$ter7id' and a.t8='$ter8id' and a.t9='$ter9id' and status='1'";
			}else{
			$qry="SELECT  a.idTerritory, a.territoryValue FROM `territory_master` as a  WHERE a.idTerritoryTitle='10' and status='1'";
			}
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'ter9id'=>$ter9id,'status'=>true,'message'=>'Record available'];
			}

		} else if($param->action=='servicecat'){
			$qry="SELECT idCategory,category FROM category WHERE idCategory in (SELECT serviceCat FROM `service_master` WHERE  status='1') group by `idCategory`";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}
		
		return $ret_arr;
	}
//factory Details
	public function factory($param){
          $userData=$param->userData;
            $userid=$userData['user_id'];
            $usertype=$userData['user_type'];
            $idCustomer=$userData['idCustomer'];
		if($param->action=='list') {
			$qry="SELECT * FROM  factory_master";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();


			$qry1="SELECT IF(hm.title !='',hm.title,'') AS H1 FROM territorytitle_master hm where hm.idTerritoryTitle=1";
			$result1=$this->adapter->query($qry1,array());
			$resultset1=$result1->toArray();

			$qry2="SELECT IF(hm.title !='',hm.title,'') AS H2 FROM territorytitle_master hm where hm.idTerritoryTitle=2";
			$result2=$this->adapter->query($qry2,array());
			$resultset2=$result2->toArray();

			$qry3="SELECT IF(hm.title !='',hm.title,'') AS H3 FROM territorytitle_master hm where hm.idTerritoryTitle=3";
			$result3=$this->adapter->query($qry3,array());
			$resultset3=$result3->toArray();

			$qry4="SELECT IF(hm.title !='',hm.title,'') AS H4 FROM territorytitle_master hm where hm.idTerritoryTitle=4";
			$result4=$this->adapter->query($qry4,array());
			$resultset4=$result4->toArray();

			$qry5="SELECT IF(hm.title !='',hm.title,'') AS H5 FROM territorytitle_master hm where hm.idTerritoryTitle=5";
			$result5=$this->adapter->query($qry5,array());
			$resultset5=$result5->toArray();

			$qry6="SELECT IF(hm.title !='',hm.title,'') AS H6 FROM territorytitle_master hm where hm.idTerritoryTitle=6";
			$result6=$this->adapter->query($qry6,array());
			$resultset6=$result6->toArray();

			$qry7="SELECT IF(hm.title !='',hm.title,'') AS H7 FROM territorytitle_master hm where hm.idTerritoryTitle=7";
			$result7=$this->adapter->query($qry7,array());
			$resultset7=$result7->toArray();

			$qry8="SELECT IF(hm.title !='',hm.title,'') AS H8 FROM territorytitle_master hm where hm.idTerritoryTitle=8";
			$result8=$this->adapter->query($qry8,array());
			$resultset8=$result8->toArray();

			$qry9="SELECT IF(hm.title !='',hm.title,'') AS H9 FROM territorytitle_master hm where hm.idTerritoryTitle=9";
			$result9=$this->adapter->query($qry9,array());
			$resultset9=$result9->toArray();

			$qry10="SELECT IF(hm.title !='',hm.title,'') AS H10 FROM territorytitle_master hm where hm.idTerritoryTitle=10";
			$result10=$this->adapter->query($qry10,array());
			$resultset10=$result10->toArray();
			
			
			if($resultset1){
				$ret_arr=['code'=>'1','content'=>$resultset,'contentlist1'=>$resultset1,'contentlist2'=>$resultset2,'contentlist3'=>$resultset3,'contentlist4'=>$resultset4,'contentlist5'=>$resultset5,'contentlist6'=>$resultset6,'contentlist7'=>$resultset7,'contentlist8'=>$resultset8,'contentlist9'=>$resultset9,'contentlist10'=>$resultset10,'status'=>true,'message'=>'No of records'.count($resultset)];
			} else {
				$ret_arr=['code'=>'2','content'=>'','status'=>false,'message'=>'No records to view'];
			}
		}
		else if($param->action=='add'){
			$fiedls=$param->Form;
			$product_type=$param->product_type;//all product
			$product=$param->product_id;//checked prod id
			$ter_title=$param->tery_title;//checked prod id

			for ($i = 0; $i < count($product); $i++){
				for ($j = 0; $j < count($product_type); $j++){
					if($product_type[$j]['idProduct']==$product[$i])
					{
						$products[$i]['catid']=$product_type[$j]['idCategory'];
						$products[$i]['subcatid']=$product_type[$j]['idSubCategory'];
						$products[$i]['proid']=$product_type[$j]['idProduct'];
					}
				}
			}
			$qry="SELECT * FROM factory_master  where factoryName=?";
			$result=$this->adapter->query($qry,array($fiedls['name']));
			$resultset=$result->toArray();
			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['factoryName']=$fiedls['name'];
					$datainsert['factoryMobileno']=$fiedls['mobile'];
					$datainsert['factoryEmail']=$fiedls['email'];
					$datainsert['status']=$fiedls['factstatus'];
					for ($i=0; $i <count($ter_title) ; $i++) { 
				$ttl=$ter_title[$i]['ter_name'];
				$j=$i+1;
				$tt='t'.$j;
				
				$datainsert[$tt]=$fiedls[$ttl];
				//echo $datainsert[$tt][0];
			}
					$datainsert['created_by']='1';
					$datainsert['created_at']=date('Y-m-d H:i:s');
					$insert=new Insert('factory_master');
					$insert->values($datainsert);
					$statement=$this->adapter->createStatement();
					$insert->prepareStatement($this->adapter, $statement);
					$insertresult=$statement->execute();
					$question_id=$this->adapter->getDriver()->getLastGeneratedValue();
					for ($i = 0; $i < count($products); $i++) {
						$datainsert1['idFactory']=$question_id;
						$datainsert1['idCategory']=$products[$i]['catid'];
						$datainsert1['idSubCategory']=$products[$i]['subcatid'];
						$datainsert1['idProduct']=$products[$i]['proid'];
							
						$insert1=new Insert('factory_products');
						$insert1->values($datainsert1);
						$statement1=$this->adapter->createStatement();
						$insert1->prepareStatement($this->adapter, $statement1);
						$insertresult1=$statement1->execute();
					}
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				}catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			} else {
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
			}

		} 
		else if($param->action=='editview')
		{
			$editid=$param->id;
			$tery_title=$param->tery_title;
           
			$qry="SELECT a.*,a.idFactory as id,a.factoryName as factory_name,a.factoryMobileno as mobile_no,a.factoryEmail as factory_email,HT1.territoryValue as territory1Sel,HT2.territoryValue as territory2Sel,HT3.territoryValue as territory3Sel,HT4.territoryValue as territory4Sel,HT5.territoryValue as territory5Sel,HT6.territoryValue as territory6Sel,HT7.territoryValue as territory7Sel,HT8.territoryValue as territory8Sel,HT9.territoryValue as territory9Sel,HT10.territoryValue as territory10Sel
			FROM factory_master a 
			LEFT JOIN territory_master HT1 ON HT1.idTerritory=a.t1 
			LEFT JOIN territory_master HT2 ON HT2.idTerritory=a.t2 
			LEFT JOIN territory_master HT3 ON HT3.idTerritory=a.t3 
			LEFT JOIN territory_master HT4 ON HT4.idTerritory=a.t4 
			LEFT JOIN territory_master HT5 ON HT5.idTerritory=a.t5 
			LEFT JOIN territory_master HT6 ON HT6.idTerritory=a.t6 
			LEFT JOIN territory_master HT7 ON HT7.idTerritory=a.t7 
			LEFT JOIN territory_master HT8 ON HT8.idTerritory=a.t8
			LEFT JOIN territory_master HT9 ON HT9.idTerritory=a.t9 
			LEFT JOIN territory_master HT10 ON HT10.idTerritory=a.t10
			where a.idFactory=?";
               // $qry="SELECT * FROM factory_master where idFactory=?";
			$result=$this->adapter->query($qry,array($editid));
			$resultset=$result->toArray();
			$qrytery="SELECT * FROM factory_master a where a.idFactory=?";
               // $qry="SELECT * FROM factory_master where idFactory=?";
			$resulttery=$this->adapter->query($qrytery,array($editid));
			$resultsettery=$resulttery->toArray();


		 
			$territory=[$resultsettery[0][t1],
			$resultsettery[0][t2],
			$resultsettery[0][t3],
			$resultsettery[0][t4],
			$resultsettery[0][t5],
			$resultsettery[0][t6],
			$resultsettery[0][t7],
			$resultsettery[0][t8],
			$resultsettery[0][t9],
            $resultsettery[0][t10]
		];
		for($i=0;$i<count($tery_title);$i++)
		{
          $tery_title[$i]['default_territory']=$territory[$i];
		}
		
              //get checked category id
			$qrycatid="SELECT idCategory FROM factory_products where idFactory=? group by idCategory";
			$resultcatid=$this->adapter->query($qrycatid,array($editid));
			$resultsetcatid=$resultcatid->toArray();
			if(count($resultsetcatid)>0) 
			{
				for($i=0;$i<count($resultsetcatid);$i++)
				{
					$checkedcategoryid[]=$resultsetcatid[$i]['idCategory'];
				}
			}
			else
			{
				$checkedcategoryid=[];
			}
              
              //get checked subcategory id
			$qrysubcatid="SELECT `idSubCategory` FROM factory_products where idFactory=? group by `idSubCategory`";
			$resultsubcatid=$this->adapter->query($qrysubcatid,array($editid));
			$resultsetsubcatid=$resultsubcatid->toArray();
			if (count($resultsetsubcatid)>0) 
			{
				for($i=0;$i<count($resultsetsubcatid);$i++)
				{
				$checkedsubcategoryid[]=$resultsetsubcatid[$i]['idSubCategory'];

				}
			}
			else
			{
				$checkedsubcategoryid=[];
			}
			   
             //get checked product id
			$qryprodid="SELECT `idProduct` FROM factory_products where idFactory=? group by `idProduct`";
			$resultprodid=$this->adapter->query($qryprodid,array($editid));
			$resultsetprodid=$resultprodid->toArray();
			if (count($resultsetprodid)>0) 
			{
				for($i=0;$i<count($resultsetprodid);$i++)
				{
					$checkedproductid[]=$resultsetprodid[$i]['idProduct'];

				}
			}
			else
			{
				$checkedproductid=[];
			}
		    
               // all factory data get
				$qryfactory="SELECT idFactoryProduct,idCategory,idSubCategory,idProduct FROM factory_products where idFactory=?";
				$resultfactory=$this->adapter->query($qryfactory,array($editid));
				$resultsetfactory=$resultfactory->toArray();
			

                //All category
			$qry_category="SELECT idCategory,category FROM `category` WHERE status='1'";
			$result_category=$this->adapter->query($qry_category,array());
			$resultset_category=$result_category->toArray();
			 if(count($resultset_category)>0)
			 {
				for ($j = 0; $j < count($resultset_category); $j++)
				{
					$categorystatus[$j]['idCategory']=$resultset_category[$j]['idCategory'];
					$categorystatus[$j]['category']=$resultset_category[$j]['category'];
					$categorystatus[$j]['checked']=false;
				}

				// set the checked category checked true
				for($i=0;$i<count($resultsetfactory);$i++) 
				{ 
					for ($j = 0; $j < count($categorystatus); $j++)
					{
						if($resultsetfactory[$i]['idCategory']==$categorystatus[$j]['idCategory']) 
						{
							$categorystatus[$j]['checked']=true;
						} 
					}
				}
			 }
			 else
			 {
			 	$categorystatus=[];
			 }
				
			
			     //All subcategory
			$qry_subcategory="SELECT idSubCategory,idCategory,subcategory FROM subcategory a WHERE idCategory In(SELECT idCategory FROM factory_products WHERE idFactory='$editid') AND status='1'";
			$result_subcategory=$this->adapter->query($qry_subcategory,array());
			$resultset_subcategory=$result_subcategory->toArray();
            // set all subcategory checked by default false
            if (count($resultset_subcategory)>0) 
            {
				for($i=0;$i<count($resultsetfactory);$i++) 
				{ 
					for ($j = 0; $j < count($resultset_subcategory); $j++)
					{
					$subcategorystatus[$j]['idSubCategory']=$resultset_subcategory[$j]['idSubCategory'];
					$subcategorystatus[$j]['subcategory']=$resultset_subcategory[$j]['subcategory'];
						//echo $resultset_subcategory[$j]['idSubCategory'];
					$subcategorystatus[$j]['checked']=false;
					}
				}
				//set checked subcategory checked status true
				for($i=0;$i<count($resultsetfactory);$i++) 
				{ 
					for ($j = 0; $j < count($subcategorystatus); $j++){
					if($resultsetfactory[$i]['idSubCategory']==$subcategorystatus[$j]['idSubCategory']) 
					{
						$subcategorystatus[$j]['checked']=true;
					} 
					}
				}
            }
            else
            {
            	$subcategorystatus=[];
            }
			
				//All Product
			$qry_product="SELECT idProduct,idSubCategory,idCategory,productName,productBrand FROM product_details a WHERE idSubCategory In(SELECT idSubCategory FROM factory_products WHERE idFactory='$editid') AND status='1'";
			$result_product=$this->adapter->query($qry_product,array());
			$resultset_product=$result_product->toArray();
              //set all product checked by default false
			for($i=0;$i<count($resultsetfactory);$i++) 
			{ 
				for ($j = 0; $j < count($resultset_product); $j++){
					$productstatus[$j]['idProduct']=$resultset_product[$j]['idProduct'];
					$productstatus[$j]['productName']=$resultset_product[$j]['productName'];
					$productstatus[$j]['productBrand']=$resultset_product[$j]['productBrand'];
					$productstatus[$j]['idSubCategory']=$resultset_product[$j]['idSubCategory'];
					$productstatus[$j]['idCategory']=$resultset_product[$j]['idCategory'];
			    		//echo $resultset_subcategory[$j]['idSubCategory'];
					$productstatus[$j]['checked']=false;
				}
			}
			//set checked product checked status true
			for($i=0;$i<count($resultsetfactory);$i++) 
			{ 
				for ($j = 0; $j < count($productstatus); $j++){
					if($resultsetfactory[$i]['idProduct']==$productstatus[$j]['idProduct']) 
					{

						$productstatus[$j]['checked']=true;
					} 
				}
			}



			$qryview="SELECT a.*,a.idFactoryProduct as id , c.category as category , b.subcategory as subcategory , d.productName as product , d.productBrand as code FROM factory_products as a
			LEFT JOIN category as c ON c.idCategory=a.idCategory
			LEFT JOIN subcategory as b ON b.idSubCategory=a.idSubCategory
			LEFT JOIN product_details as d ON d.idProduct=a.idProduct
			where  a.idFactory=?
			";
			$resultview=$this->adapter->query($qryview,array($editid));
			$resultsetview=$resultview->toArray();

			$qry="SELECT 
						A.idTerritoryTitle as id,
						A.title,
						'0' as default_territory,
						A.hierarchy as ter_name
						FROM territorytitle_master A WHERE A.title!=''";
		$result=$this->adapter->query($qry,array());
		$resultset_terytitle=$result->toArray();
		if(!$resultset_terytitle) {
			$resultset_terytitle=[];
		} else {
			for($i=0;$i<count($resultset_terytitle);$i++) {
				$t1=$resultset[$i]['t1'];
				$t2=$resultset[$i]['t2'];
				$t3=$resultset[$i]['t3'];
				$t4=$resultset[$i]['t4'];
				$t5=$resultset[$i]['t5'];
				$t6=$resultset[$i]['t6'];
				$t7=$resultset[$i]['t7'];
				$t8=$resultset[$i]['t8'];
				$t9=$resultset[$i]['t9'];
				$t10=$resultset[$i]['t10'];
			$qry_geo="SELECT B.t1,A.idTerritory as id,A.idTerritoryTitle,A.territoryValue,A.territoryCode,A.status
			FROM territorymapping_master B 
            LEFT JOIN territory_master as A ON A.idTerritory=B.t1 GROUP By B.t1";
			$result_geo=$this->adapter->query($qry_geo,array());
			$resultset_geo1=$result_geo->toArray();
			
			if($t1){
			$qry_geo="SELECT B.t2,A.idTerritory as id,A.idTerritoryTitle,A.territoryValue,A.territoryCode,A.status
				FROM territorymapping_master B 
                LEFT JOIN territory_master as A ON A.idTerritory=B.t2
                where B.t1='$t1' AND B.t2!='' GROUP By B.t2";
				$result_geo=$this->adapter->query($qry_geo,array());
				$resultset_geo2=$result_geo->toArray();
			}
			if($t2){
				$qry_geo="SELECT B.t3,A.idTerritory as id,A.idTerritoryTitle,A.territoryValue,A.territoryCode,A.status
				FROM territorymapping_master B 
                LEFT JOIN territory_master as A ON A.idTerritory=B.t3
                where B.t1='$t1' AND B.t2='$t2' AND B.t3!='' GROUP By B.t3";
				$result_geo=$this->adapter->query($qry_geo,array());
				$resultset_geo3=$result_geo->toArray();
			}
			if($t3){
				$qry_geo="SELECT B.t4,A.idTerritory as id,A.idTerritoryTitle,A.territoryValue,A.territoryCode,A.status
				FROM territorymapping_master B 
                LEFT JOIN territory_master as A ON A.idTerritory=B.t4
                where B.t1='$t1' AND B.t2='$t2' AND B.t3='$t3' AND B.t4!=''  GROUP By B.t4";
				$result_geo=$this->adapter->query($qry_geo,array());
				$resultset_geo4=$result_geo->toArray();
			}

			
			if($t4){
				$qry_geo="SELECT B.t5,A.idTerritory as id,A.idTerritoryTitle,A.territoryValue,A.territoryCode,A.status
				FROM territorymapping_master B 
                LEFT JOIN territory_master as A ON A.idTerritory=B.t5
                where B.t1='$t1' AND B.t2='$t2' AND B.t3='$t3' AND B.t4='$t4' AND B.t5!='' GROUP By B.t5";
				$result_geo=$this->adapter->query($qry_geo,array());
				$resultset_geo5=$result_geo->toArray();

			}
			if($t5){
				$qry_geo="SELECT B.t6,A.idTerritory as id,A.idTerritoryTitle,A.territoryValue,A.territoryCode,A.status
				FROM territorymapping_master B 
                LEFT JOIN territory_master as A ON A.idTerritory=B.t6
                where B.t1='$t1' AND B.t2='$t2' AND B.t3='$t3' AND B.t4='$t4' AND B.t5='$t5' AND B.t6!='' GROUP By B.t6";
				$result_geo=$this->adapter->query($qry_geo,array());
				$resultset_geo6=$result_geo->toArray();
			}
			if($t6){
				$qry_geo="SELECT B.t7,A.idTerritory as id,A.idTerritoryTitle,A.territoryValue,A.territoryCode,A.status
				FROM territorymapping_master B 
                LEFT JOIN territory_master as A ON A.idTerritory=B.t7
                where B.t1='$t1' AND B.t2='$t2' AND B.t3='$t3' AND B.t4='$t4' AND B.t5='$t5' AND B.t6='$t6' AND B.t7!=''  GROUP By B.t7";
				$result_geo=$this->adapter->query($qry_geo,array());
				$resultset_geo7=$result_geo->toArray();
			}
			if($t7){
				$qry_geo="SELECT B.t8,A.idTerritory as id,A.idTerritoryTitle,A.territoryValue,A.territoryCode,A.status
				FROM territorymapping_master B 
                LEFT JOIN territory_master as A ON A.idTerritory=B.t8
                where B.t1='$t1' AND B.t2='$t2' AND B.t3='$t3' AND B.t4='$t4' AND B.t5='$t5' AND B.t6='$t6' AND B.t7='$t7' AND B.t8!=''  GROUP By B.t8";
				$result_geo=$this->adapter->query($qry_geo,array());
				$resultset_geo8=$result_geo->toArray();
			}
			if($t8){
				$qry_geo="SELECT B.t9,A.idTerritory as id,A.idTerritoryTitle,A.territoryValue,A.territoryCode,A.status
				FROM territorymapping_master B 
                LEFT JOIN territory_master as A ON A.idTerritory=B.t9
                where B.t1='$t1' AND B.t2='$t2' AND B.t3='$t3' AND B.t4='$t4' AND B.t5='$t5' AND B.t6='$t6' AND B.t7='$t7' AND B.t8='$t8' AND B.t9!=''  GROUP By B.t9";
				$result_geo=$this->adapter->query($qry_geo,array());
				$resultset_geo9=$result_geo->toArray();
			}
			if($t9){
				$qry_geo="SELECT B.t10,A.idTerritory as id,A.idTerritoryTitle,A.territoryValue,A.territoryCode,A.status
				FROM territorymapping_master B 
                LEFT JOIN territory_master as A ON A.idTerritory=B.t10
                where B.t1='$t1' AND B.t2='$t2' AND B.t3='$t3' AND B.t4='$t4' AND B.t5='$t5' AND B.t6='$t6' AND B.t7='$t7' AND B.t8='$t8' AND B.t9='$t9' AND B.t10!=''  GROUP By B.t10";
				$result_geo=$this->adapter->query($qry_geo,array());
				$resultset_geo10=$result_geo->toArray();
			}
				
				/*print_r($resultset_geo5);
				print_r($resultset_geo6);*/
			/*if(!$resultset_geo1) {
				$resultset[$i]['territory_status']="2";
				$resultset[$i]['territory_value']="";
			} else {*/
				if($i==0){
				$resultset_terytitle[$i]['territory_status']=(count($resultset_geo1)>0)?1:0;
				$resultset_terytitle[$i]['territory_value']=(count($resultset_geo1)>0)?$resultset_geo1:"";
				}
				if($i==1){
				$resultset_terytitle[$i]['territory_status']=(count($resultset_geo2)>0)?1:0;
				$resultset_terytitle[$i]['territory_value']=(count($resultset_geo2)>0)?$resultset_geo2:"";
				}
				if($i==2){
				$resultset_terytitle[$i]['territory_status']=(count($resultset_geo3)>0)?1:0;
				$resultset_terytitle[$i]['territory_value']=(count($resultset_geo3)>0)?$resultset_geo3:"";
				}
				if($i==3){
				$resultset_terytitle[$i]['territory_status']=(count($resultset_geo4)>0)?1:0;
				$resultset_terytitle[$i]['territory_value']=(count($resultset_geo4)>0)?$resultset_geo4:"";
				}
				if($i==4){
				$resultset_terytitle[$i]['territory_status']=(count($resultset_geo5)>0)?1:0;
				$resultset_terytitle[$i]['territory_value']=(count($resultset_geo5)>0)?$resultset_geo5:"";
				}
				if($i==5){
				$resultset_terytitle[$i]['territory_status']=(count($resultset_geo6)>0)?1:0;
				$resultset_terytitle[$i]['territory_value']=(count($resultset_geo6)>0)?$resultset_geo6:"";
				}
				if($i==6){
				$resultset_terytitle[$i]['territory_status']=(count($resultset_geo7)>0)?1:0;
				$resultset_terytitle[$i]['territory_value']=(count($resultset_geo7)>0)?$resultset_geo7:"";
				}
				if($i==7){
				$resultset_terytitle[$i]['territory_status']=(count($resultset_geo8)>0)?1:0;
				$resultset_terytitle[$i]['territory_value']=(count($resultset_geo8)>0)?$resultset_geo8:"";
				}
				if($i==8){
				$resultset_terytitle[$i]['territory_status']=(count($resultset_geo9)>0)?1:0;
				$resultset_terytitle[$i]['territory_value']=(count($resultset_geo9)>0)?$resultset_geo9:"";
				}
				if($i==9){
				$resultset_terytitle[$i]['territory_status']=(count($resultset_geo10)>0)?1:0;
				$resultset_terytitle[$i]['territory_value']=(count($resultset_geo10)>0)?$resultset_geo10:"";
				}
				//}
			}
			//print_r($resultset);exit;
		}

			if(!$resultset) 
			{
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			} 
			else 
			{
				$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'terytitle' =>$resultset_terytitle,'contentfactoryid'=>$resultsetfactory,'checkedcategory'=>$categorystatus,'checkedsubcategory'=>$subcategorystatus,'checkedproductid'=>$checkedproductid,'resultview'=>$resultsetview,'checkedproduct'=>$productstatus,'checkedcatid'=>$checkedcategoryid,'checkedsubcatid'=>$checkedsubcategoryid,'factoryview'=>$resultsetview,'tertitle'=>$tery_title,'message'=>'data available'];
			}
		}
		else if($param->action=='update'){
		
			$fiedls=$param->Form;
			$editid=$param->id;
			$categorys=$param->categryid;
			$subcategorys=$param->subcategryid;
			$products=$param->prodid;
			$allproducts=$param->allproduct;
        

			$qry="SELECT * FROM factory_master where idFactory=?";
			$result=$this->adapter->query($qry,array($editid));
			$resultset=$result->toArray();

			if($resultset) {
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$data['factoryName']=$fiedls['factoryName'];
					$data['factoryMobileno']=$fiedls['factoryMobileno'];
					$data['factoryEmail']=$fiedls['factoryEmail'];
					$data['status']=$fiedls['factstatus'];
					$data['t1']=($fiedls['H1']!='' && $fiedls['H1']!=undefined)?$fiedls['H1']:0;
					$data['t2']=($fiedls['H2']!='' && $fiedls['H2']!=undefined)?$fiedls['H2']:0;
					$data['t3']=($fiedls['H3']!='' && $fiedls['H3']!=undefined)?$fiedls['H3']:0;
					$data['t4']=($fiedls['H4']!='' && $fiedls['H4']!=undefined)?$fiedls['H4']:0;
					$data['t5']=($fiedls['H5']!='' && $fiedls['H5']!=undefined)?$fiedls['H5']:0;
					$data['t6']=($fiedls['H6']!='' && $fiedls['H6']!=undefined)?$fiedls['H6']:0;
					$data['t7']=($fiedls['H7']!='' && $fiedls['H7']!=undefined)?$fiedls['H7']:0;
					$data['t8']=($fiedls['H8']!='' && $fiedls['H8']!=undefined)?$fiedls['H8']:0;
					$data['t9']=($fiedls['H9']!='' && $fiedls['H9']!=undefined)?$fiedls['H9']:0;
					$data['t10']=($fiedls['H10']!='' && $fiedls['H10']!=undefined)?$fiedls['H10']:0;
					$data['updated_by']='1';
					$data['updated_at']=date('Y-m-d H:i:s');
					$sql = new Sql($this->adapter);
					$update = $sql->update();
					$update->table('factory_master');
					$update->set($data);
					$update->where( array('idFactory' => $editid));
					$statement  = $sql->prepareStatementForSqlObject($update);
					$results    = $statement->execute();

					$delete = new Delete('factory_products');
					$delete->where(['idFactory=?' => $editid]);
					$statement=$this->adapter->createStatement();
					$delete->prepareStatement($this->adapter, $statement);
					$resultset=$statement->execute();

					$categoryinserts['idFactory']=$editid;
					for($i=0;$i<count($products);$i++){

						for($j=0;$j<count($allproducts);$j++)
						{

							if($products[$i]==$allproducts[$j]['idProduct']){
								$finalinsertdata[$i]['idCategory']=$allproducts[$j]['idCategory'];
								$finalinsertdata[$i]['idSubCategory']=$allproducts[$j]['idSubCategory'];
								$finalinsertdata[$i]['idProduct']=$allproducts[$j]['idProduct'];
							}
						}
					}
					

					for($i=0;$i<count($finalinsertdata);$i++)
					{
						$categoryinserts['idCategory']=$finalinsertdata[$i]['idCategory'];
						$categoryinserts['idSubCategory']=$finalinsertdata[$i]['idSubCategory'];
						$categoryinserts['idProduct']=$finalinsertdata[$i]['idProduct'];
						$insertcat=new Insert('factory_products');
						$insertcat->values($categoryinserts);
						$statementcat=$this->adapter->createStatement();
						$insertcat->prepareStatement($this->adapter, $statementcat);
						$insertresultcat=$statementcat->execute();
					}

					$this->adapter->getDriver()->getConnection()->commit();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
				} catch (\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			} else {
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
			}
		} 
		
		return $ret_arr;
	}

	public function getcatsubcatproduct($param){
		if($param->action=='getCategoryType') {
			$qry="SELECT idCategory, category,status FROM  category a WHERE status='1' ORDER BY category";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}
		
		else if($param->action=='getsubCategoryType') {

			$catid=$param->cat_id; //checked category id
			$subcatid=$param->subcat_id; //checked subcategory id
			$procatid=$param->pro_id; //checked product id
			$uncheckcat=$param->uncheckcat; //unchecked category id
            //implode the al, the above id purpose of query to get data 
			$cat=($catid)?implode(',', $catid):'';
			$subcat=($subcatid)?implode(',', $subcatid):'';
			$pro=($procatid)?implode(',', $procatid):'';
			$catcondition=$cat?"idCategory IN ($catid)":'';
			$subcatcondition=$subcat?" and idSubCategory IN ($subcatid)":'';
             //get all subcategory and product id corresponding category id
			if(count($catid)>0)
			{

				$qry="SELECT idSubCategory,idCategory,subcategory,status FROM subcategory a WHERE  idCategory IN ($cat) AND status=1";
				$result=$this->adapter->query($qry,array());
				$resultset=$result->toArray();

				if(count($subcatid)>0)
				{

					for($i=0;$i<count($subcatid);$i++) 
					{ 
						for ($j=0; $j<count($resultset);$j++)
						{
							$substatus[$j]['idSubCategory']=$resultset[$j]['idSubCategory'];
							$substatus[$j]['subcategory']=$resultset[$j]['subcategory'];
							$substatus[$j]['checked']=false;
						}
					}
			  

			    // sub category with checked and unchecked data
					for($i=0;$i<count($subcatid);$i++) 
					{ 

						for ($j=0;$j<count($resultset);$j++)
						{

                        //echo $subcatid[$i]['idSubCategory']."-".$resultset[$j]['idSubCategory'];
							if($subcatid[$i]==$resultset[$j]['idSubCategory']) 
							{

								$substatus[$j]['checked']=true;

			    	
							} 
						}
					}
				}
				else
				{
					for ($j=0; $j<count($resultset);$j++)
					{
						$substatus[$j]['idSubCategory']=$resultset[$j]['idSubCategory'];
						$substatus[$j]['subcategory']=$resultset[$j]['subcategory'];
						$substatus[$j]['checked']=false;
					}
				}
			}else
			{
				$substatus=[];
			}
             //get all product data corresponding category and sub category id
			if($cat!='' && $subcat!=''){

				$qryproduct="SELECT idProduct,idCategory,idSubCategory,productName,productBrand FROM product_details a WHERE idCategory IN($cat) and idSubCategory IN($subcat) AND status='1'";
				$resultproduct=$this->adapter->query($qryproduct,array());
				$resultsetproduct=$resultproduct->toArray();

				if($procatid){
					for($i=0;$i<count($procatid);$i++) 
					{ 

						for ($j = 0; $j < count($resultsetproduct); $j++){

							$prostatus[$j]['idCategory']=$resultsetproduct[$j]['idCategory'];
							$prostatus[$j]['idSubCategory']=$resultsetproduct[$j]['idSubCategory'];
							$prostatus[$j]['idProduct']=$resultsetproduct[$j]['idProduct'];
							$prostatus[$j]['productName']=$resultsetproduct[$j]['productName'];
							$prostatus[$j]['productBrand']=$resultsetproduct[$j]['productBrand'];
							$prostatus[$j]['checked']=false;
						}
					}
			    // checked and unchecked product data
					for($i=0;$i<count($procatid);$i++) 
					{ 

						for ($j = 0; $j < count($resultsetproduct); $j++){
							if($procatid[$i]==$resultsetproduct[$j]['idProduct']) 
							{
								$prostatus[$j]['checked']=true;
							} 
						}
					}
				}else
				{
					for ($j = 0; $j < count($resultsetproduct); $j++){
						$prostatus[$j]['idCategory']=$resultsetproduct[$j]['idCategory'];
						$prostatus[$j]['idSubCategory']=$resultsetproduct[$j]['idSubCategory'];
						$prostatus[$j]['idProduct']=$resultsetproduct[$j]['idProduct'];
						$prostatus[$j]['productName']=$resultsetproduct[$j]['productName'];
						$prostatus[$j]['productBrand']=$resultsetproduct[$j]['productBrand'];
						$prostatus[$j]['checked']=false;
					}
				}
			}else
			{
				$prostatus=[];	
			}
				
			//get new checked subcategory id
			
			if(count($subcatid)>0)
			{
				$qrynewsubcat="SELECT idSubCategory FROM subcategory a WHERE  idCategory IN($cat) AND status='1'";
				$resultnewsubcat=$this->adapter->query($qrynewsubcat,array());
				$resultsetnewsubcat=$resultnewsubcat->toArray();
	              for($i=0;$i<count($resultsetnewsubcat);$i++)
				{
					for($j=0;$j<count($subcatid);$j++)
					{
	                  if($resultsetnewsubcat[$i]['idSubCategory']==$subcatid[$j])
	                  {
	                    $newsubcat[]=$resultsetnewsubcat[$i]['idSubCategory'];
	                  }
					}
				}

			}
			else
			{
               $newsubcat=$subcatid;
			}
			
			//get new checked product id
			
			if(count($procatid)>0)
			{
				  $qrynewproduct="SELECT idProduct FROM product_details a WHERE  idCategory IN($cat) and idSubCategory IN($subcat) AND status='1'";
			$resultnewproduct=$this->adapter->query($qrynewproduct,array());
			$resultsetnewproduct=$resultnewproduct->toArray();
				for($i=0;$i<count($resultsetnewproduct);$i++)
				{
					for($j=0;$j<count($procatid);$j++)
					{
					  if($resultsetnewproduct[$i]['idProduct']==$procatid[$j])
					  {
					    $newproduct[]=$resultsetnewproduct[$i]['idProduct'];
					  }
					}
				}
			}
			else
			{
				$newproduct=$procatid;
			}
			

			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'pro_status'=>$prostatus,'sub_status'=>$substatus,'catcheckid'=>$catid,'subcatcheckid'=>$newsubcat,'procheckid'=>$newproduct,'status'=>true,'message'=>'Record available'];
			}
		}
		
		else if($param->action=='getproductType') {
			$subid=$param->subcategryid;
			$catid=$param->categryid;
			$subcategry=implode(',', $subid);
			$categry=implode(',', $catid);

			$qry="SELECT idProduct,idCategory,idSubCategory,productName,productBrand FROM product_details a WHERE idCategory IN($categry) and idSubCategory IN($subcategry) AND status='1'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}
		return $ret_arr;
	}
	function servicepartner($param){
		if($param->action=='list') {
			$qry="SELECT * FROM  service_partner";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();

			$qry1="SELECT IF(hm.title !='',hm.title,'H1') AS H1 FROM territorytitle_master hm where hm.idTerritoryTitle=1";
			$result1=$this->adapter->query($qry1,array());
			$resultset1=$result1->toArray();

			$qry2="SELECT IF(hm.title !='',hm.title,'H2') AS H2 FROM territorytitle_master hm where hm.idTerritoryTitle=2";
			$result2=$this->adapter->query($qry2,array());
			$resultset2=$result2->toArray();

			$qry3="SELECT IF(hm.title !='',hm.title,'H3') AS H3 FROM territorytitle_master hm where hm.idTerritoryTitle=3";
			$result3=$this->adapter->query($qry3,array());
			$resultset3=$result3->toArray();

			$qry4="SELECT IF(hm.title !='',hm.title,'H4') AS H4 FROM territorytitle_master hm where hm.idTerritoryTitle=4";
			$result4=$this->adapter->query($qry4,array());
			$resultset4=$result4->toArray();

			$qry5="SELECT IF(hm.title !='',hm.title,'H5') AS H5 FROM territorytitle_master hm where hm.idTerritoryTitle=5";
			$result5=$this->adapter->query($qry5,array());
			$resultset5=$result5->toArray();

			$qry6="SELECT IF(hm.title !='',hm.title,'H6') AS H6 FROM territorytitle_master hm where hm.idTerritoryTitle=6";
			$result6=$this->adapter->query($qry6,array());
			$resultset6=$result6->toArray();

			$qry7="SELECT IF(hm.title !='',hm.title,'H7') AS H7 FROM territorytitle_master hm where hm.idTerritoryTitle=7";
			$result7=$this->adapter->query($qry7,array());
			$resultset7=$result7->toArray();

			$qry8="SELECT IF(hm.title !='',hm.title,'H8') AS H8 FROM territorytitle_master hm where hm.idTerritoryTitle=8";
			$result8=$this->adapter->query($qry8,array());
			$resultset8=$result8->toArray();

			$qry9="SELECT IF(hm.title !='',hm.title,'H9') AS H9 FROM territorytitle_master hm where hm.idTerritoryTitle=9";
			$result9=$this->adapter->query($qry9,array());
			$resultset9=$result9->toArray();

			$qry10="SELECT IF(hm.title !='',hm.title,'H10') AS H10 FROM territorytitle_master hm where hm.idTerritoryTitle=10";
			$result10=$this->adapter->query($qry10,array());
			$resultset10=$result10->toArray();


			
			
			if($resultset1){
				$ret_arr=['code'=>'1','content'=>$resultset,'contentlist1'=>$resultset1,'contentlist2'=>$resultset2,'contentlist3'=>$resultset3,'contentlist4'=>$resultset4,'contentlist5'=>$resultset5,'contentlist6'=>$resultset6,'contentlist7'=>$resultset7,'contentlist8'=>$resultset8,'contentlist9'=>$resultset9,'contentlist10'=>$resultset10,'status'=>true,'message'=>'No of records'.count($resultset)];
			} else {
				$ret_arr=['code'=>'2','content'=>'','status'=>false,'message'=>'No records to view'];
			}
		}else if($param->action=='add'){
			$fiedls=$param->Form;
			$title=$param->title;
			$ter_title=$param->tery_title;
			
			$rendid=$param->rend_id;
			$partid=$param->part_id;
			$catid=$param->cat_id;
			$part=($partid)?implode(',', $partid):'';
			$rend=($rendid)?implode(',', $rendid):'';
			$cat=($catid)?implode(',', $catid):'';
			
			
			$qry="SELECT * FROM service_partner  where ContactName=?";
			$result=$this->adapter->query($qry,array($param->name));
			$resultset=$result->toArray();
			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					
					$datainsert['ContactName']=$fiedls['name'];
					$datainsert['ContactEmail']=$fiedls['email'];
					$datainsert['ContactMobile']=$fiedls['mobile'];
					for ($i=0; $i <count($title) ; $i++) { 
				$gtl=$title[$i]['title'];
				$j=$i+1;
				$gg='g'.$j;
				//echo $gg;
				$datainsert[$gg]=$fiedls[$gtl];
			}
			for ($i=0; $i <count($ter_title) ; $i++) { 
				$ttl=$ter_title[$i]['ter_name'];
				$j=$i+1;
				$tt='t'.$j;
				
				$datainsert[$tt]=$fiedls[$ttl];
				//echo $datainsert[$tt][0];
			}
					
					$datainsert['ServiceRendered']= $rend;
					$datainsert['ServicePartner']= $part;
					$datainsert['ServiceCategory']=$cat;
					$datainsert['status']=$fiedls['servicestatus'];
					$datainsert['created_by']='1';
					$datainsert['created_at']=date('Y-m-d H:i:s');
					
					$insert=new Insert('service_partner');
					$insert->values($datainsert);
					$statement=$this->adapter->createStatement();
					$insert->prepareStatement($this->adapter, $statement);
					$insertresult=$statement->execute();
					
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				} catch(\Exception $e) {

					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again...'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			} else {
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
			}

		}else if($param->action=='editview') {
			$editid=$param->id;
			$title=$param->title;
			$tery_title=$param->tery_title;
			

			$qryedit= "SELECT a.*,a.idServicePartner as id,a.ContactName as contactname,a.ContactEmail as contactemail,a.ContactMobile as contactmobile,a.status as servicestatus FROM service_partner as a WHERE a.idServicePartner=?";
			$resultedit=$this->adapter->query($qryedit,array($editid));
			$resultsetedit=$resultedit->toArray();
			$geography=[$resultsetedit[0][g1],
			$resultsetedit[0][g2],
			$resultsetedit[0][g3],
			$resultsetedit[0][g4],
			$resultsetedit[0][g5],
			$resultsetedit[0][g6],
			$resultsetedit[0][g7],
			$resultsetedit[0][g8],
			$resultsetedit[0][g9],
            $resultsetedit[0][g10]
		];
		for($i=0;$i<count($title);$i++)
		{
          $title[$i]['default_status']=$geography[$i];
		}
		$territory=[$resultsetedit[0][t1],
			$resultsetedit[0][t2],
			$resultsetedit[0][t3],
			$resultsetedit[0][t4],
			$resultsetedit[0][t5],
			$resultsetedit[0][t6],
			$resultsetedit[0][t7],
			$resultsetedit[0][t8],
			$resultsetedit[0][t9],
            $resultsetedit[0][t10]
		];
		for($i=0;$i<count($tery_title);$i++)
		{
          $tery_title[$i]['default_territory']=$territory[$i];
		}

			
			$qry="SELECT a.*,a.idServicePartner as id,a.ContactName as contactname,a.ContactEmail as contactemail,a.ContactMobile as contactmobile,a.status as servicestatus,a.ServiceRendered as rend,a.ServicePartner as part,a.ServiceCategory,GT1.geoValue as geography1,GT2.geoValue as geography2,GT3.geoValue as geography3,GT4.geoValue as geography4,GT5.geoValue as geography5,GT6.geoValue as geography6,GT7.geoValue as geography7,GT8.geoValue as geography8,GT9.geoValue as geography9,GT10.geoValue as geography10,a.g1 as g1,a.g2 as g2,a.g3 as g3,a.g4 as g4,a.g5 as g5,a.g6 as g6,a.g7 as g7,a.g8 as g8,a.g9 as g9,a.g10 as g10,HT1.territoryValue as territory1Sel,HT2.territoryValue as territory2Sel,HT3.territoryValue as territory3Sel,HT4.territoryValue as territory4Sel,HT5.territoryValue as territory5Sel,HT6.territoryValue as territory6Sel,HT7.territoryValue as territory7Sel,HT8.territoryValue as territory8Sel,HT9.territoryValue as territory9Sel,HT10.territoryValue as territory10Sel
			FROM service_partner a 
			LEFT JOIN geography GT1 ON GT1.idGeography=a.g1 
			LEFT JOIN geography GT2 ON GT2.idGeography=a.g2 
			LEFT JOIN geography GT3 ON GT3.idGeography=a.g3 
			LEFT JOIN geography GT4 ON GT4.idGeography=a.g4 
			LEFT JOIN geography GT5 ON GT5.idGeography=a.g5 
			LEFT JOIN geography GT6 ON GT6.idGeography=a.g6 
			LEFT JOIN geography GT7 ON GT7.idGeography=a.g7 
			LEFT JOIN geography GT8 ON GT8.idGeography=a.g8
			LEFT JOIN geography GT9 ON GT9.idGeography=a.g9 
			LEFT JOIN geography GT10 ON GT10.idGeography=a.g10
			LEFT JOIN territory_master HT1 ON HT1.idTerritory=a.t1 
			LEFT JOIN territory_master HT2 ON HT2.idTerritory=a.t2 
			LEFT JOIN territory_master HT3 ON HT3.idTerritory=a.t3 
			LEFT JOIN territory_master HT4 ON HT4.idTerritory=a.t4 
			LEFT JOIN territory_master HT5 ON HT5.idTerritory=a.t5 
			LEFT JOIN territory_master HT6 ON HT6.idTerritory=a.t6 
			LEFT JOIN territory_master HT7 ON HT7.idTerritory=a.t7 
			LEFT JOIN territory_master HT8 ON HT8.idTerritory=a.t8
			LEFT JOIN territory_master HT9 ON HT9.idTerritory=a.t9 
			LEFT JOIN territory_master HT10 ON HT10.idTerritory=a.t10
			where a.idServicePartner=?";
			
			$result=$this->adapter->query($qry,array($editid));
			$resultset=$result->toArray();

			$rend=$resultset[0]['rend'];
			$part=$resultset[0]['part'];
			$cats=$resultset[0]['ServiceCategory'];
			$rended=($rend)?explode(',',$rend):'';
			$partner=($part)?explode(',',$part):'';
			$cat=($cats)?explode(',',$cats):'';
	
			//Service Rendered Statically 4

			$rendstatus=array(array("val"=>1,"name"=>"Sales","checked"=>false),
				array("val"=>2,"name"=>"Service Fulfillment","checked"=>false),
				array("val"=>3,"name"=>"Collections","checked"=>false),
				array("val"=>4,"name"=>"Distribution","checked"=>false));

			$partstatus=array(array("val"=>1,"name"=>"Sales Partner","checked"=>false),
				array("val"=>2,"name"=>"Service Fulfillment Partner","checked"=>false),
				array("val"=>3,"name"=>"Collections Partner","checked"=>false),
				array("val"=>4,"name"=>"Distribution Partner","checked"=>false));

            // set the checked category checked true
			for($i=0;$i<count($rendstatus);$i++) 
			{ 
				for ($j = 0; $j < count($rended); $j++){
					//echo $rendstatus[$i]['val']."-".$rended[$j].",";
					if($rendstatus[$i]['val']==$rended[$j]) 
					{
						$rendstatus[$i]['checked']=true;
					} 
				}
			}
		
			for($i=0;$i<count($partstatus);$i++) 
			{ 
				for ($j = 0; $j < count($partner); $j++){
					//echo $rendstatus[$i]['val']."-".$rended[$j].",";
					if($partstatus[$i]['val']==$partner[$j]) 
					{
						$partstatus[$i]['checked']=true;
					} 
				}
			}
			$qry_category="SELECT sm.serviceCat,c.category FROM `service_master` as sm left join category as c on c.idCategory=sm.serviceCat group by serviceCat";
			$result_category=$this->adapter->query($qry_category,array());
			$resultset_category=$result_category->toArray();
			for($i=0;$i<count($resultset_category);$i++) 
			{ 
				
					$categorystatus[$i]['idCategory']=$resultset_category[$i]['serviceCat'];
                    $categorystatus[$i]['category']=$resultset_category[$i]['category'];
					$categorystatus[$i]['checked']=false;
				
			}
            // set the checked category checked true
			for($i=0;$i<count($categorystatus);$i++) 
			{ 
				for ($j = 0; $j < count($cat); $j++){
					if($categorystatus[$i]['idCategory']==$cat[$j]) 
					{
						$categorystatus[$i]['checked']=true;
					} 
				}
			}
			
			$qryrend="SELECT idServicePartner,ServiceRendered FROM service_partner where idServicePartner=?";
			$resultrend=$this->adapter->query($qryrend,array($editid));
			$resultsetrend=$resultrend->toArray();

			$servicerendered=$resultsetrend[0]['ServiceRendered'];
			$checkedrenderid=($servicerendered)?explode(',',$servicerendered):'';

			$qrypart="SELECT idServicePartner,ServicePartner FROM service_partner where idServicePartner=?";
			$resultpart=$this->adapter->query($qrypart,array($editid));
			$resultsetpart=$resultpart->toArray();

			$servicepartner=$resultsetpart[0]['ServicePartner'];
			$checkedpartnerid=($servicepartner)?explode(',',$servicepartner):'';

			$qrycategry="SELECT idServicePartner,ServiceCategory FROM service_partner where idServicePartner=?";
			$resultcategry=$this->adapter->query($qrycategry,array($editid));
			$resultsetcategry=$resultcategry->toArray();

			$servicecategory=$resultsetcategry[0]['ServiceCategory'];
			$checkedcategoryid=($servicecategory)?explode(',',$servicecategory):'';

		
		$qrycat="SELECT category FROM category where idCategory IN ($cats)";
			$resultcat=$this->adapter->query($qrycat,array());
			$resultsetcat=$resultcat->toArray();
			// Geography Heading
			
			$qry1="SELECT IF(hm.title !='',hm.title,'H1') AS H1 FROM geographytitle_master hm where hm.idGeographyTitle=1";
			$result1=$this->adapter->query($qry1,array());
			$resultset1=$result1->toArray();

			$qry2="SELECT IF(hm.title !='',hm.title,'H2') AS H2 FROM geographytitle_master hm where hm.idGeographyTitle=2";
			$result2=$this->adapter->query($qry2,array());
			$resultset2=$result2->toArray();

			$qry3="SELECT IF(hm.title !='',hm.title,'H3') AS H3 FROM geographytitle_master hm where hm.idGeographyTitle=3";
			$result3=$this->adapter->query($qry3,array());
			$resultset3=$result3->toArray();

			$qry4="SELECT IF(hm.title !='',hm.title,'H4') AS H4 FROM geographytitle_master hm where hm.idGeographyTitle=4";
			$result4=$this->adapter->query($qry4,array());
			$resultset4=$result4->toArray();

			$qry5="SELECT IF(hm.title !='',hm.title,'H5') AS H5 FROM geographytitle_master hm where hm.idGeographyTitle=5";
			$result5=$this->adapter->query($qry5,array());
			$resultset5=$result5->toArray();

			$qry6="SELECT IF(hm.title !='',hm.title,'H6') AS H6 FROM geographytitle_master hm where hm.idGeographyTitle=6";
			$result6=$this->adapter->query($qry6,array());
			$resultset6=$result6->toArray();

			$qry7="SELECT IF(hm.title !='',hm.title,'H7') AS H7 FROM geographytitle_master hm where hm.idGeographyTitle=7";
			$result7=$this->adapter->query($qry7,array());
			$resultset7=$result7->toArray();

			$qry8="SELECT IF(hm.title !='',hm.title,'H8') AS H8 FROM geographytitle_master hm where hm.idGeographyTitle=8";
			$result8=$this->adapter->query($qry8,array());
			$resultset8=$result8->toArray();

			$qry9="SELECT IF(hm.title !='',hm.title,'H9') AS H9 FROM geographytitle_master hm where hm.idGeographyTitle=9";
			$result9=$this->adapter->query($qry9,array());
			$resultset9=$result9->toArray();

			$qry10="SELECT IF(hm.title !='',hm.title,'H10') AS H10 FROM geographytitle_master hm where hm.idGeographyTitle=10";
			$result10=$this->adapter->query($qry10,array());
			$resultset10=$result10->toArray();
			if(!$resultset){
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else { 
				$ret_arr=['code'=>'2','content'=>$resultset,'contentedit'=>$resultsetedit,'contentlist1'=>$resultset1,'contentlist2'=>$resultset2,'contentlist3'=>$resultset3,'contentlist4'=>$resultset4,'contentlist5'=>$resultset5,'contentlist6'=>$resultset6,'contentlist7'=>$resultset7,'contentlist8'=>$resultset8,'contentlist9'=>$resultset9,'contentlist10'=>$resultset10,'rend'=>$rended,'part'=>$partner,'cat'=>$resultsetcat,'part_id'=>$partstatus,'rend_id'=>$rendstatus,'cat_id'=>$categorystatus,'rendcheckid'=>$checkedrenderid,'partcheckid'=>$checkedpartnerid,'catcheckid'=>$checkedcategoryid,'geotitle'=>$title,'tertitle'=>$tery_title,'status'=>true,'message'=>'Record available'];
			}
		}
		else if($param->action=='update') {
			$fiedls=$param->Form;
			$rendid=$param->rend_id;
			$partid=$param->part_id;
			$catid=$param->cat_id;
			$title=$param->geo;
			$terytitle=$param->tery;
			$part=($partid)?implode(',', $partid):'';
			$rend=($rendid)?implode(',', $rendid):'';
			$cat=($catid)?implode(',', $catid):'';
			$editid=$fiedls['id'];
			$qry="SELECT a.idServicePartner,a.ContactMobile FROM service_partner a where a.ContactMobile=? and a.idServicePartner!='$editid'";
			$result=$this->adapter->query($qry,array($fiedls['contactmobile']));
			$resultset=$result->toArray();
			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try{
					$datainsert['ContactName']=$fiedls['contactname'];
					$datainsert['ContactEmail']=$fiedls['contactemail'];
					$datainsert['ContactMobile']=$fiedls['contactmobile'];
					for ($i=0; $i <count($title) ; $i++) { 
				$gtl=$title[$i]['default_status'];
				$j=$i+1;
				$gg='g'.$j;
				//echo $gg;
				$datainsert[$gg]=$gtl;
			}
			for ($i=0; $i <count($terytitle) ; $i++) { 
				$ttl=$terytitle[$i]['default_territory'];
				$j=$i+1;
				$tt='t'.$j;
				//echo $gg;
				$datainsert[$tt]=$ttl;
			}
					$datainsert['ServiceRendered']= $rend;
					$datainsert['ServicePartner']= $part;
					$datainsert['ServiceCategory']=$cat;
					
					$datainsert['status']=$fiedls['servicestatus'];
					$datainsert['updated_by']=1;
					$datainsert['updated_at']=date('Y-m-d H:i:s');
					$sql = new Sql($this->adapter);
					$update = $sql->update();
					$update->table('service_partner');
					$update->set($datainsert);
					$update->where(array('idServicePartner' => $editid));
					$statement  = $sql->prepareStatementForSqlObject($update);
					$results    = $statement->execute();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				} catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			} else {
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
			}
		}
		else {
			$ret_arr=['code'=>'3','content'=>'','status'=>false,'message'=>'Please contact the administrator'];
		}
		return $ret_arr;
	}
	public function customer_hierarchy($param) {
		if($param->action=="title") {
			$qry="SELECT 
						A.idGeographyTitle as id,
						A.title,
						'0' as default_status,
						A.geography as geo_name
						FROM geographytitle_master A";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		if(!$resultset) {
			$ret_arr=['code'=>'2','status'=>false,'message'=>'No records found'];
		} else {
			for($i=0;$i<count($resultset);$i++) {
				$title_id=$resultset[$i]['id'];
				$qry_geo="SELECT 
				A.idGeography as id,
				A.idGeographyTitle,
				A.geoValue,
				A.geoCode,
				A.status
				FROM geography A where A.idGeographyTitle=?";
				$result_geo=$this->adapter->query($qry_geo,array($title_id));
				$resultset_geo=$result_geo->toArray();
				
				if(!$resultset_geo) {
				$resultset[$i]['hierarchy_status']="2";
				$resultset[$i]['hierarchy_value']="";
				} else {
				$resultset[$i]['hierarchy_status']="1";
				$resultset[$i]['hierarchy_value']=$resultset_geo;
				}
			}
			$ret_arr=['code'=>'1','status'=>true,'message'=>'Title records','content' =>$resultset];
		}
		} else {
			$ret_arr=['code'=>'2','status'=>false,'message'=>'Something wrong please try again'];
		}
		return $ret_arr;
	}
	public function customer_territory($param) {
		if($param->action=="title") {
			$qry="SELECT 
						A.idTerritoryTitle as id,
						A.title,
						'0' as default_territory,
						A.hierarchy as ter_name
						FROM territorytitle_master A WHERE A.title!=''";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		if(!$resultset) {
			$ret_arr=['code'=>'2','status'=>false,'message'=>'No records found'];
		} else {
			for($i=0;$i<count($resultset);$i++) {
				$title_id=$resultset[$i]['id'];
				$qry_geo="SELECT B.t1,A.idTerritory as id,A.idTerritoryTitle,A.territoryValue,A.territoryCode,A.status
				FROM territorymapping_master B 
                LEFT JOIN territory_master as A ON A.idTerritory=B.t1
                where B.t1=? GROUP By B.t1";
                /*$qry_geo="SELECT 
				A.idTerritory as id,
				A.idTerritoryTitle,
				A.territoryValue,
				A.territoryCode,
				A.status
				FROM territory_master A where A.idTerritoryTitle=? and A.status=1";*/
				$result_geo=$this->adapter->query($qry_geo,array($title_id));
				$resultset_geo=$result_geo->toArray();
				
				if(!$resultset_geo) {
				$resultset[$i]['territory_status']="2";
				$resultset[$i]['territory_value']="";
				} else {
				$resultset[$i]['territory_status']="1";
				$resultset[$i]['territory_value']=$resultset_geo;
				}
			}
			$ret_arr=['code'=>'1','status'=>true,'message'=>'Title records','content' =>$resultset];
		}
		} else {
			$ret_arr=['code'=>'2','status'=>false,'message'=>'Something wrong please try again'];
		}
		return $ret_arr;
	}

	public function get_selected_territory($param) {
		if($param->action=="geo") {
			$selected_id=$param->territory_id;
			$ter_name=$param->ter_name;
			$qrygeo="SELECT A.idTerritoryTitle as id,A.hierarchy FROM territorytitle_master A where A.hierarchy=?";
			$resultgeo=$this->adapter->query($qrygeo,array($ter_name));
			$resultsetgeo=$resultgeo->toArray();
			$current_state=0;
			if($resultsetgeo!=null) {
				$hierarchy=$resultsetgeo[0]['hierarchy'];
			switch($hierarchy) {
				case "H1":
				$qry="SELECT A.t2 as id,B.territoryValue FROM territorymapping_master A,territory_master B  where A.t1=? and A.t2=B.idTerritory GROUP BY A.t2";
				$result=$this->adapter->query($qry,array($selected_id));
				$resultset=$result->toArray();
				$current_state=1;
				break;
				case "H2":
				$qry="SELECT A.t3 as id,B.territoryValue FROM territorymapping_master A,territory_master B where A.t2=? and A.t3=B.idTerritory GROUP BY A.t3";
				$result=$this->adapter->query($qry,array($selected_id));
				$resultset=$result->toArray();
				$current_state=2;
				break;
				case "H3":
				$qry="SELECT A.t4 as id,B.territoryValue FROM territorymapping_master A,territory_master B where A.t3=? and A.t4=B.idTerritory GROUP BY A.t4";
				$result=$this->adapter->query($qry,array($selected_id));
				$resultset=$result->toArray();
				$current_state=3;
				break;
				case "H4":
				$qry="SELECT A.t5 as id,B.territoryValue FROM territorymapping_master A,territory_master B where A.t4=? and A.t5=B.idTerritory GROUP BY A.t5";
				$result=$this->adapter->query($qry,array($selected_id));
				$resultset=$result->toArray();
				$current_state=4;
				break;
				case "H5":
				$qry="SELECT A.t6 as id,B.territoryValue FROM territorymapping_master A,territory_master B where A.t5=? and A.t6=B.idTerritory GROUP BY A.t6";
				$result=$this->adapter->query($qry,array($selected_id));
				$resultset=$result->toArray();
				$current_state=5;
				break;
				case "H6":
				$qry="SELECT A.t7 as id,B.territoryValue FROM territorymapping_master A,territory_master B where A.t6=?  and A.t7=B.idTerritory GROUP BY A.t7";
				$result=$this->adapter->query($qry,array($selected_id));
				$resultset=$result->toArray();
				$current_state=6;
				break;
				case "H7":
				$qry="SELECT A.t8 as id,B.territoryValue FROM territorymapping_master A,territory_master B where A.t7=?  and A.t8=B.idTerritory GROUP BY A.t8";
				$result=$this->adapter->query($qry,array($selected_id));
				$resultset=$result->toArray();
				$current_state=7;
				break;
				case "H8":
				$qry="SELECT A.t9 as id,B.territoryValue FROM territorymapping_master A,territory_master B where A.t8=?  and A.t9=B.idTerritory GROUP BY A.t9";
				$result=$this->adapter->query($qry,array($selected_id));
				$resultset=$result->toArray();
				$current_state=8;
				break;
				case "H9":
				$qry="SELECT A.t10 as id,B.territoryValue FROM territorymapping_master A,territory_master B where A.t9=? and A.t10=B.idTerritory GROUP BY A.t10";
				$result=$this->adapter->query($qry,array($selected_id));
				$resultset=$result->toArray();
				$current_state=9;
				break;
			}
			if(!$resultset) {
				$ret_arr=['code'=>'2','status'=>false,'message'=>'No records found'];
			} else {
				$ret_arr=['code'=>'1','status'=>true,'message'=>'Title records','content' =>$resultset,'current_status' =>$current_state];
			}
		}
		} else {
			$ret_arr=['code'=>'2','status'=>false,'message'=>'Something wrong please try again'];
		}
		return $ret_arr;
	}
	public function get_selected_hierarchy($param) {
		if($param->action=="geo") {
			$selected_id=$param->selected_id;
			$geo_name=$param->geo_name;
			$qrygeo="SELECT A.idGeographyTitle as id,A.geography FROM geographytitle_master A where A.geography=?";
			$resultgeo=$this->adapter->query($qrygeo,array($geo_name));
			$resultsetgeo=$resultgeo->toArray();
			$current_state=0;
			if($resultsetgeo!=null) {
				$geography=$resultsetgeo[0]['geography'];
			switch($geography) {
				case "H1":
				$qry="SELECT A.g2 as id,B.geoValue FROM geographymapping_master A,geography B  where A.g1=? and A.g2=B.idGeography GROUP BY A.g2";
				$result=$this->adapter->query($qry,array($selected_id));
				$resultset=$result->toArray();
				$current_state=1;
				break;
				case "H2":
				$qry="SELECT A.g3 as id,B.geoValue FROM geographymapping_master A,geography B where A.g2=? and A.g3=B.idGeography GROUP BY A.g3";
				$result=$this->adapter->query($qry,array($selected_id));
				$resultset=$result->toArray();
				$current_state=2;
				break;
				case "H3":
				$qry="SELECT A.g4 as id,B.geoValue FROM geographymapping_master A,geography B where A.g3=? and A.g4=B.idGeography GROUP BY A.g4";
				$result=$this->adapter->query($qry,array($selected_id));
				$resultset=$result->toArray();
				$current_state=3;
				break;
				case "H4":
				$qry="SELECT A.g5 as id,B.geoValue FROM geographymapping_master A,geography B where A.g4=? and A.g5=B.idGeography GROUP BY A.g5";
				$result=$this->adapter->query($qry,array($selected_id));
				$resultset=$result->toArray();
				$current_state=4;
				break;
				case "H5":
				$qry="SELECT A.g6 as id,B.geoValue FROM geographymapping_master A,geography B where A.g5=? and A.g6=B.idGeography GROUP BY A.g6";
				$result=$this->adapter->query($qry,array($selected_id));
				$resultset=$result->toArray();
				$current_state=5;
				break;
				case "H6":
				$qry="SELECT A.g7 as id,B.geoValue FROM geographymapping_master A,geography B where A.g6=?  and A.g7=B.idGeography GROUP BY A.g7";
				$result=$this->adapter->query($qry,array($selected_id));
				$resultset=$result->toArray();
				$current_state=6;
				break;
				case "H7":
				$qry="SELECT A.g8 as id,B.geoValue FROM geographymapping_master A,geography B where A.g7=?  and A.g8=B.idGeography GROUP BY A.g8";
				$result=$this->adapter->query($qry,array($selected_id));
				$resultset=$result->toArray();
				$current_state=7;
				break;
				case "H8":
				$qry="SELECT A.g9 as id,B.geoValue FROM geographymapping_master A,geography B where A.g8=?  and A.g9=B.idGeography GROUP BY A.g9";
				$result=$this->adapter->query($qry,array($selected_id));
				$resultset=$result->toArray();
				$current_state=8;
				break;
				case "H9":
				$qry="SELECT A.g10 as id,B.geoValue FROM geographymapping_master A,geography B where A.g9=? and A.g10=B.idGeography GROUP BY A.g10";
				$result=$this->adapter->query($qry,array($selected_id));
				$resultset=$result->toArray();
				$current_state=9;
				break;
			}
			if(!$resultset) {
				$ret_arr=['code'=>'2','status'=>false,'message'=>'No records found'];
			} else {
				$ret_arr=['code'=>'1','status'=>true,'message'=>'Title records','content' =>$resultset,'current_status' =>$current_state];
			}
		}
		} else {
			$ret_arr=['code'=>'2','status'=>false,'message'=>'Something wrong please try again'];
		}
		return $ret_arr;
	}

function materialreceipt($param){
	$userData=$param->userData;
	$userid=$userData['user_id'];
	$usertype=$userData['user_type'];
	$idcustomer=$userData['idCustomer'];
	if($param->action=='getwarehousetype'){
			$qry="SELECT wm.idWarehouse as idWarehouse,wm.warehouseName as warehouseName
			FROM warehouse_master as wm WHERE idLevel='$usertype' AND idCustomer='$idcustomer' AND status=1";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='getsldetails'){
		$warid=$param->warid;
		// $proid=$param->proid;
			$qry="SELECT t1.idWarehouse, t1.idProduct,t4.po_no,t4.invoice_no,t3.productName,t2.warehouseName,t1.sku_accept_qty as qty FROM whouse_stock_items as t1 LEFT JOIN warehouse_master as t2 ON t2.idWarehouse=t1.idWarehouse LEFT JOIN product_details as t3 on t3.idProduct=t1.idProduct LEFT JOIN whouse_stock as t4 ON t4.idWhStock=t1.idWhStock WHERE t1.idWhStock='$warid' AND t3.productserialNo=1 GROUP BY t1.idProduct";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			// $qrysl="SELECT t1.idProduct,t1.idProductsize,t1.idWhStock FROM product_stock_serialno as t1
			// LEFT JOIN whouse_stock_items as t2 ON t2.idProduct=t1.idProduct WHERE t1.idWhStock='$warid' group by idProductsize";
			// $resultsl=$this->adapter->query($qrysl,array());
			// $resultsetsl=$resultsl->toArray();
	
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='getsize'){
			$warid=$param->warid;
			$proid=$param->proid;
			
			$qry="SELECT t1.idProduct,
t3.productName,
t3.productCount,
t1.sku_accept_qty as qty ,
t1.idProdSize,
t5.productSize,
t3.productserialnoNumeric as sl_numeric,
t3.productserialnoAuto as sl_auto,
t5.idPrimaryPackaging,
t5.idSecondaryPackaging,
t5.productPrimaryCount,
t5.productSecondaryCount,
sp.secondarypackname,
pp.primarypackname
FROM whouse_stock_items as t1
LEFT JOIN warehouse_master as t2 ON t2.idWarehouse=t1.idWarehouse 
LEFT JOIN product_details as t3 on t3.idProduct=t1.idProduct 
LEFT JOIN product_size as t5 on t5.idProductsize=t1.idProdSize 
LEFT JOIN primary_packaging as pp on pp.idPrimaryPackaging=t5.idPrimaryPackaging
LEFT JOIN secondary_packaging as sp on sp.idSecondaryPackaging=t5.idSecondaryPackaging
LEFT JOIN whouse_stock as t4 ON t4.idWhStock=t1.idWhStock 
WHERE t1.idWhStock='$warid' AND t1.idProduct='$proid'";

			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();

			$qrysl="SELECT t1.idProduct,t1.idProductsize,t1.idWhStock FROM product_stock_serialno as t1
			LEFT JOIN whouse_stock_items as t2 ON t2.idProduct=t1.idProduct WHERE t1.idWhStock='$warid' GROUP BY idProduct";
			$resultsl=$this->adapter->query($qrysl,array());
			$resultsetsl=$resultsl->toArray();

			 //$product=array();
			$k=0;
$product=[];
			 if(count($resultsetsl)>0){
			for($i=0;$i<count($resultset);$i++) 
			{ 
				// for ($j = 0; $j < count($resultsetsl); $j++){
					
				// 	if($resultset[$i]['idProdSize']!=$resultsetsl[$j]['idProductsize']) 
				// 	{
						
						$product[$k]['idProduct']=$resultset[$i]['idProduct'];
						$product[$k]['idProdSize']=$resultset[$i]['idProdSize'];
						$product[$k]['productSize']=$resultset[$i]['productSize'];
						$product[$k]['productCount']=$resultset[$i]['productCount'];
						$product[$k]['primarypackname']=$resultset[$i]['primarypackname'];
						$product[$k]['productName']=$resultset[$i]['productName'];
						$product[$k]['qty']=$resultset[$i]['qty'];
						$product[$k]['sl_numeric']=$resultset[$i]['sl_numeric'];
						$product[$k]['sl_auto']=$resultset[$i]['sl_auto'];
						$k++;
				// 	 }
				
				// }

			}
			}else{
		 		$product=$resultset;
		 		$product = array_map("unserialize", array_unique(array_map("serialize", $product)));
			}
			

			if(!$product) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$product,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='getqty'){
			$warid=$param->warid;
			$proid=$param->proid;
			$sizeid=$param->sizeid;
			
			$qry="SELECT  t1.idProduct,t3.productName,
(t1.sku_accept_qty*t5.productPrimaryCount) as qty ,
t1.sku_accept_qty,
t1.idProdSize,
t5.productSize,
t3.productserialnoNumeric as sl_numeric,
t3.productserialnoAuto as sl_auto ,
pp.primarypackname as packagename,
t5.productPrimaryCount 
FROM whouse_stock_items as t1 
				LEFT JOIN warehouse_master as t2 ON t2.idWarehouse=t1.idWarehouse 
				LEFT JOIN product_details as t3 on t3.idProduct=t1.idProduct 
				LEFT JOIN product_size as t5 on t5.idProductsize=t1.idProdSize 
				LEFT JOIN whouse_stock as t4 ON t4.idWhStock=t1.idWhStock
				LEFT JOIN primary_packaging as pp ON pp.idPrimaryPackaging=t5.idPrimaryPackaging
			WHERE t1.idWhStock='$warid' AND t1.idProduct='$proid' AND t1.idProdSize='$sizeid'";

			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();


			$qrysl="SELECT t1.idProduct,t1.idProductsize,t1.idWhStock FROM product_stock_serialno as t1
			LEFT JOIN whouse_stock_items as t2 ON t2.idProduct=t1.idProduct WHERE t1.idWhStock='$warid' GROUP BY idProduct";
			$resultsl=$this->adapter->query($qrysl,array());
			$resultsetsl=$resultsl->toArray();

			 //$product=array();
			

			 if(count($resultsetsl)>0){
			for($i=0;$i<count($resultset);$i++) 
			{ 
				for ($j = 0; $j < count($resultsetsl); $j++){
					
					if($resultset[$i]['idProdSize']!=$resultsetsl[$j]['idProductsize']) 
					{
						$product[$i]['idProduct']=$resultset[$i]['idProduct'];
						$product[$i]['idProdSize']=$resultset[$i]['idProdSize'];
						$product[$i]['packagename']=$resultset[$i]['packagename'];
						$product[$i]['productName']=$resultset[$i]['productName'];
						$product[$i]['qty']=$resultset[$i]['qty'];
						$product[$i]['sl_numeric']=$resultset[$i]['sl_numeric'];
						$product[$i]['sl_auto']=$resultset[$i]['sl_auto'];
					 }
				
				}

			}
			}else{
		 		$product=$resultset;
			}
			
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$product,'status'=>true,'message'=>'Record available'];
			}
		}
		else if($param->action=='getPOnumber'){
			$wareId=$param->WarehouseId;
			$qry="SELECT fo.idWarehouse as idWarehouse,fo.po_number as POnumber
			FROM factory_order as fo where fo.idWarehouse='$wareId' group by fo.po_number,fo.idWarehouse";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}

		}else if($param->action=='getPOdetail'){
			$POnumber=$param->PONum;
			$WareId=$param->WId;
			$qry="SELECT fm.factoryName as factryname,
			fm.idFactory as idFactory,DATE_FORMAT(fo.po_date,'%d-%m-%Y') as POdate,
			pd.idProduct as idProduct,pd.productShelflife as shelflife,
			pd.productShelf as shelfcount,pd.productName as productName,
			pd.productserialNo as required_status,
			pd.productserialnoNumeric as sl_numeric,
			pd.expireDate as expirydate,
			pd.productserialnoAuto as sl_auto,
			ps.idProductsize as idProductsize,
			ps.productSize as productSize,
			pp.primarypackname as primarypackname,
			ps.productPrimaryCount as primaycount,
			foi.item_qty as item_qty,
			foi.idFactryOrdItem as idFactryOrdItem,
			'0' as earlyRechieved,
			'0' as batchno
			FROM factory_order as fo
			LEFT JOIN factory_order_items as foi ON foi.idFactoryOrder=fo.idFactoryOrder
			LEFT JOIN product_details as pd ON pd.idProduct=foi.idProduct
			LEFT JOIN product_size as ps ON ps.idProductsize=foi.idProdSize
			LEFT JOIN primary_packaging as pp ON pp.idPrimaryPackaging=ps.idPrimaryPackaging
			LEFT JOIN factory_master as fm ON fm.idFactory=fo.idFactory 
			where fo.po_number='$POnumber' and fo.idWarehouse='$WareId'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			
            for ($i=0; $i <count($resultset) ; $i++) 
            { 

            	$qryEarlyrecieve="SELECT sum(wsi.sku_accept_qty) as earlyrecieve FROM `whouse_stock` as ws LEFT JOIN whouse_stock_items as wsi ON wsi.idWhStock=ws.idWhStock WHERE ws.po_no='".$POnumber."' and ws.idWarehouse='".$WareId."' AND wsi.idProduct='".$resultset[$i]['idProduct']."' AND wsi.idProdSize='".$resultset[$i]['idProductsize']."'";
				$resultEarlyrecieve=$this->adapter->query($qryEarlyrecieve,array());
				$resultsetEarlyrecieve=$resultEarlyrecieve->toArray();
				$resultset[$i]['earlyRechieved']=$resultsetEarlyrecieve[0]['earlyrecieve'];
				$resultset[$i]['batchno']='BT'.date('dmyhis').'H'.rand(500,999).'N';
            }
			
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}

		}else if($param->action=='list'){
         	$userData=$param->userData;

         	$idCustomer=$userData['idCustomer'];
				$qry="SELECT ws.grn_no as grn_no,
				ws.po_no as po_no,
				DATE_FORMAT(ws.entry_date,'%d-%m-%Y') as entry_date,
				wm.warehouseName as warehouseName,
				fm.factoryName as factoryName,
				ws.idWarehouse as idWarehouse,
				ws.idWhStock as idWhStock,
				0 as serialno,
				ws.po_date FROM whouse_stock as ws 
				LEFT JOIN warehouse_master as wm ON wm.idWarehouse=ws.idWarehouse 
				LEFT JOIN factory_master as fm ON fm.idFactory=ws.idFactory 
				WHERE  ws.idCustomer='$idCustomer'";
				
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(count($resultset)>0)
			{
				for ($i=0; $i <count($resultset); $i++) 
				{ 
					//get number of serialno want to be genarated
					$qrySlno="SELECT wsi.idProduct,wsi.sku_accept_qty,ps.productPrimaryCount,(wsi.sku_accept_qty*ps.productPrimaryCount) 
					as totalserialno FROM `whouse_stock` as ws LEFT JOIN whouse_stock_items 
					as wsi ON wsi.idWhStock=ws.idWhStock LEFT JOIN product_details as prd on 
					prd.idProduct=wsi.idProduct LEFT JOIN product_size as ps on 
					ps.idProductsize=wsi.idProdSize WHERE ws.idWhStock='".$resultset[$i]['idWhStock']."' AND prd.productserialNo=1";
				$resultSlno=$this->adapter->query($qrySlno,array());
				$resultsetSlno=$resultSlno->toArray();
                

				
				$total=0;
				   if (count($resultsetSlno)>0) 
				   {
				   	 for ($j=0; $j < count($resultsetSlno); $j++) 
					{ 
						$total=$total+$resultsetSlno[$j]['totalserialno'];
					}
					//already genarated serial numbers
				$qrySlnoAlready="SELECT count(*) as alreadySLNO FROM `product_stock_serialno` WHERE idWhStock='".$resultset[$i]['idWhStock']."'";
				$resultSlnoAlready=$this->adapter->query($qrySlnoAlready,array());
				$resultsetSlnoAlready=$resultSlnoAlready->toArray();
						if($total==$resultsetSlnoAlready[0]['alreadySLNO'])
						{
						  $resultset[$i]['serialno']=0; // all serial number already genarated
						}
						else
						{
							 $resultset[$i]['serialno']=1; 
						}
				   }
				   
				}
			}

			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
           
		}else if($param->action=='add'){
			
				$fiedls=$param->Form;
				$curntsupply=$param->curntsupply;
				$userid=$param->id;
				$usertype=$param->usertype;
				$batchNo=$param->batchNo;
				$acptQty=$param->acptQty;
				$rejctQty=$param->rejctQty;
				$pndngQty=$param->pndngQty;
				$mfDate=$param->mfDate;
				$expDate=$param->expDate;
				$Comments=$param->Comments;
				$products=$param->products;
			
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['idWarehouse']=$fiedls['warename'];
					$datainsert['idFactory']=$fiedls['idFactory'];
					$datainsert['idTpVechile']=$fiedls['vehicleno'];
					$datainsert['grn_no']=$fiedls['grnno'];
					$datainsert['dc_no']=$fiedls['dcno'];
					$datainsert['po_no']=$fiedls['poNum'];
					$datainsert['invoice_no']=$fiedls['invoiceno'];
					$datainsert['po_date']=date('Y-m-d',strtotime($fiedls['podate']));
					$datainsert['entry_date']=date('Y-m-d',strtotime($fiedls['materialdate']));
				    $datainsert['idCustomer']=($idcustomer)?$idcustomer:0;
					$datainsert['idLevel']=$usertype;
						/*$datainsert['handling_charges']=$fiedls['handcharge'];
					$datainsert['handling_status']=$fiedls['handstatus'];*/
					$insert=new Insert('whouse_stock');
					$insert->values($datainsert);
					$statement=$this->adapter->createStatement();
					$insert->prepareStatement($this->adapter, $statement);
					$insertresult=$statement->execute();
					$warehouseid=$this->adapter->getDriver()->getLastGeneratedValue();


					for($i=0;$i<count($products);$i++){
				
						if($curntsupply[$i]){

						
						$datainsert1['idWhStock']=$warehouseid;
						$datainsert1['idCustomer']=($idcustomer)?$idcustomer:0;
						$datainsert1['idLevel']=$usertype;
						$datainsert1['idProduct']=$products[$i]['idProduct'];
						$datainsert1['idProdSize']=$products[$i]['idProductsize'];
						//$datainsert1['offer']=$value;
						//$datainsert1['offer_join_id']=$value;
						$datainsert1['idWarehouse']=$fiedls['warename'];
						$datainsert1['idFactryOrdItem']=$products[$i]['idFactryOrdItem'];
						$datainsert1['sku_current_supply']=$curntsupply[$i];
						$datainsert1['sku_reject_qty']=$rejctQty[$i];
						$datainsert1['sku_accept_qty']=$acptQty[$i];
						$datainsert1['sku_pending_qty']=$pndngQty[$i];
						$datainsert1['sku_mf_date']=($mfDate[$i]!='')?date('Y-m-d',strtotime($mfDate[$i])):0;
						$datainsert1['sku_expiry_date']=($expDate[$i]!='')?date('Y-m-d',strtotime($expDate[$i])):0;
						$datainsert1['sku_batch_no']=$batchNo[$i];
						$datainsert1['sku_comments']=$Comments[$i];
						$datainsert1['sku_entry_date']=date('Y-m-d H:i:s');
						$insert1=new Insert('whouse_stock_items');
						$insert1->values($datainsert1);
						$statement1=$this->adapter->createStatement();
						$insert1->prepareStatement($this->adapter, $statement1);
						$insertresult1=$statement1->execute();	
					}

					
					}	

				$qrySlno="SELECT wsi.idProduct,wsi.sku_accept_qty,ps.productPrimaryCount,(wsi.sku_accept_qty*ps.productPrimaryCount) 
					as totalserialno FROM `whouse_stock` as ws LEFT JOIN whouse_stock_items 
					as wsi ON wsi.idWhStock=ws.idWhStock LEFT JOIN product_details as prd on 
					prd.idProduct=wsi.idProduct LEFT JOIN product_size as ps on 
					ps.idProductsize=wsi.idProdSize WHERE ws.idWhStock='$warehouseid' AND prd.productserialNo=1";
				$resultSlno=$this->adapter->query($qrySlno,array());
				$resultsetSlno=$resultSlno->toArray();
				$total=0;
				if(count($resultsetSlno)>0)
				{
					for ($i=0; $i < count($resultsetSlno); $i++) 
					{ 
						$total=$total+$resultsetSlno[$i]['totalserialno'];
					}
				}
				
				
	
					    
                    $ret_arr=['code'=>'2','content'=>$datainsert1, 'totalsl'=>$total,'status'=>true,'message'=>'Updated successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				}catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
					
			
		}else if($param->action=='editview'){
			$wId=$param->wid;
			$wStockid=$param->wstockid;
			$poNo=$param->pono;
			$tittleview="SELECT ws.po_no as po_no,wm.warehouseName as warehouseName,ws.invoice_no as invoice_no,ws.dc_no as dc_no,ws.idTpVechile as idTpVechile,DATE_FORMAT(ws.po_date,'%d-%m-%Y') as po_date,ws.grn_no as grn_no,fm.factoryName as factoryName,DATE_FORMAT(ws.entry_date,'%d-%m-%Y') as entry_date
				FROM whouse_stock as ws 
				LEFT JOIN warehouse_master as wm ON wm.idWarehouse=ws.idWarehouse
				LEFT JOIN factory_master as fm ON fm.idFactory=ws.idFactory
				where ws.idWarehouse='$wId' and ws.idWhStock='$wStockid' and ws.po_date='$poNo'";
			$result1=$this->adapter->query($tittleview,array());
			$resultset1=$result1->toArray();

			$productqry="SELECT pd.productName as productName,ps.productSize as productSize,pp.primarypackname as primarypackname,ps.productPrimaryCount as primaycount,wsi.sku_current_supply as curntsuply,wsi.sku_reject_qty as rejectqty,wsi.sku_accept_qty as acceptqty,wsi.sku_pending_qty as pendgqty,wsi.sku_batch_no as batchno,wsi.sku_comments as comments,DATE_FORMAT(wsi.sku_mf_date,'%d-%m-%Y') as mfdate,DATE_FORMAT(wsi.sku_expiry_date,'%d-%m-%Y') as exdate,pd.idProduct,ps.idProductsize,wsi.idWhStockItem,ws.idWhStock
						FROM whouse_stock as ws
						LEFT JOIN whouse_stock_items as wsi ON wsi.idWhStock=ws.idWhStock
						LEFT JOIN product_details as pd ON pd.idProduct=wsi.idProduct
						LEFT JOIN product_size as ps ON ps.idProductsize=wsi.idProdSize
						LEFT JOIN primary_packaging as pp ON pp.idPrimaryPackaging=ps.idPrimaryPackaging
						where ws.idWarehouse='$wId' and ws.idWhStock='$wStockid' and ws.po_date='$poNo'";
			$result=$this->adapter->query($productqry,array());
			$resultset=$result->toArray();			
			if(!$resultset1){
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			}else{
				$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset1,'contents'=>$resultset,'message'=>'System config information'];
			}
		}else if($param->action=='delete'){
				$fields=$param->data;
				$editid=$fields['materialid'];
				$delete = new Delete('whouse_stock');
				$delete->where(['idWhStock=?' => $editid]);
				$statement=$this->adapter->createStatement();
				$delete->prepareStatement($this->adapter, $statement);
				$resultset=$statement->execute();

				$delete1 = new Delete('whouse_stock_items');
				$delete1->where(['idWhStock=?' => $editid]);
				$statement1=$this->adapter->createStatement();
				$delete1->prepareStatement($this->adapter, $statement1);
				$resultset1=$statement1->execute();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Deleted Successfully'];
			}


		}
		return $ret_arr;
	}

	function warehousedamage($param){
		if($param->action=='getproducts'){
			$qry="SELECT pd.productName as productName,pd.idProduct as idProduct
			FROM product_details as pd where pd.status='1'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='getsl'){
			$proid=$param->proid;
			$qry="SELECT pd.productserialNo
			FROM product_details as pd where pd.idProduct='$proid'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='getunits'){
			$qry="SELECT pp.primarypackname as primarypackname,pp.idPrimaryPackaging as idPrimaryPackaging
			FROM primary_packaging as pp where pp.status='1'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='getsize'){
			$idproduct=$param->proid;
			$idunit=$param->unitid;
			$qry="SELECT ps.productSize as productSize,ps.idProductsize as idProductsize
			FROM product_size as ps 
			LEFT JOIN product_details as pd ON pd.idProduct=ps.idProduct
			where ps.idProduct='$idproduct' and ps.idPrimaryPackaging='$idunit' AND ps.status=1";

			
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='editgetsize'){
			$qry="SELECT ps.productSize as productSize,ps.idProductsize as idProductsize
			FROM product_size as ps ";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='editmfdate'){
			$qry="SELECT DATE_FORMAT(wsi.sku_mf_date,'%d-%m-%Y') as mfdate
			FROM whouse_stock as ws  
			LEFT JOIN whouse_stock_items as wsi ON wsi.idWhStock=ws.idWhStock ";

			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='getmfdate'){
			$idproduct=$param->proid;
			$idwarehouse=$param->wid;
			$idsize=$param->sizeid;
			$qry="SELECT wsi.idWhStockItem as idWhStockItem,DATE_FORMAT(wsi.sku_mf_date,'%d-%m-%Y') as mfdate
			FROM whouse_stock_items as wsi where wsi.idProduct='$idproduct' and wsi.idProdSize='$idsize' and wsi.idWarehouse='$idwarehouse'";

			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='getbatchno'){
			$idproduct=$param->proid;
			$idwarehouse=$param->wid;
			$idsize=$param->sizeid;
			$promfdate=$param->mfdate;
			$qry="SELECT wsi.idWhStockItem as idWhStockItem,wsi.sku_batch_no as batchno,wsi.sku_mf_date
			FROM whouse_stock_items as wsi where wsi.idProduct='$idproduct' and wsi.idProdSize='$idsize' and wsi.idWarehouse='$idwarehouse' and wsi.idWhStockItem='$promfdate'";

			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='list'){
			$userData=$param->userData;
			$userid=$userData['user_id'];
			$usertype=$userData['user_type'];
			$idCustomer=$userData['idCustomer'];
			$qry="SELECT wsd.idDamage as idDamage,pd.productName as productName,ps.productSize as productSize,pp.primarypackname as primarypackname,DATE_FORMAT(wsd.dmg_mf_date,'%d-%m-%Y') as mfdate,wsd.dmg_prod_qty as damageqty,wm.warehouseName as warehouseName,wm.idWarehouse as idWarehouse
			FROM whouse_stock_damge as wsd 
			LEFT JOIN product_details as pd ON pd.idProduct=wsd.idProduct
			LEFT JOIN product_size as ps ON ps.idProductsize=wsd.idProdSize
			LEFT JOIN primary_packaging as pp ON pp.idPrimaryPackaging=ps.idPrimaryPackaging
			LEFT JOIN warehouse_master as wm ON wm.idWarehouse=wsd.idWarehouse WHERE wsd.created_by='$userid'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();

			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}


		}
		else if($param->action=='add'){
			$fiedls=$param->Form;
			$batchNo=$param->batchno;
			$whsItem=$param->whsItem;
			$mfdate=$param->mfdate;
			$serialids=$param->serialids;
			$userData=$param->userData;
			$userid=$userData['user_id'];
			$usertype=$userData['user_type'];
			$idCustomer=$userData['idCustomer'];
			$proserialno=array();
			for ($i=0; $i <count($serialids) ; $i++) { 
				if($serialids[$i]['status']==true){
					array_push($proserialno,$serialids[$i]['idProductserialno']);
				}
			}
					$slno=implode(',',$proserialno);
			


			/*$getPrdctUnits="SELECT productPrimaryCount from product_size where idProduct='".$fiedls['proname']."' and idProductsize='".$fiedls['prosize']."'"; */

			$qry="SELECT * FROM  whouse_stock_damge where idDamage=?";
			$result=$this->adapter->query($qry,array($fiedls['idDamage']));
			$resultset=$result->toArray();
			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['idWarehouse']=$fiedls['prowarename'];
					//$datainsert['idLevel']=$fiedls['idFactory'];
					//$datainsert['idCustomer']=$fiedls['vehicleno'];
					$datainsert['idProduct']=$fiedls['proname'];
					$datainsert['idProdSize']=$fiedls['prosize'];
					$datainsert['dmg_prod_unit']=$fiedls['prounit'];
					//$datainsert['dmg_prod_qty']=($fiedls['proqty']/$fiedls['prounit']);
					$datainsert['dmg_prod_qty']=$fiedls['proqty'];
					$datainsert['dmg_batch_no']=$batchNo;
					//$datainsert['idWhStockItem']=$fiedls['proqty'];
					$datainsert['dmg_mf_date']=date('Y-m-d',strtotime($mfdate));
					$datainsert['dmg_reason']=$fiedls['proreason'];
					$datainsert['dmg_remarks']=$fiedls['proremarks'];
					$datainsert['idWhStockItem']=$whsItem;
					$datainsert['idProductserialno']=$slno;
					$datainsert['created_by']=$userid;
					$datainsert['dmg_entry_date']=date('Y-m-d H:i:s');
					
					
					$insert=new Insert('whouse_stock_damge');
					$insert->values($datainsert);
					$statement=$this->adapter->createStatement();
					$insert->prepareStatement($this->adapter, $statement);
					$insertresult=$statement->execute();
					$warehouseid=$this->adapter->getDriver()->getLastGeneratedValue();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				}catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			} else {
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
			}


		}else if($param->action=='editview')
		    {
			     $editid=$param->damageid;
			     $qry="SELECT wsd.idDamage as idDamage,pd.productName as productName,ps.productSize as productSize,pp.primarypackname as primarypackname,DATE_FORMAT(wsd.dmg_mf_date,'%d-%m-%Y') as mfdate,wsd.dmg_prod_qty as damageqty,wm.warehouseName as warehouseName,wsd.dmg_batch_no as batchno,wsd.dmg_reason as reason,wsd.dmg_remarks as remarks,pd.idProduct as proid,wm.idWarehouse as warehouseid,pp.idPrimaryPackaging as prounit,ps.idProductsize as prosize,DATE_FORMAT(wsd.dmg_mf_date,'%d-%m-%Y') as promfdate,wsd.dmg_batch_no as probatchno,wsd.dmg_prod_qty as proqty,wsd.dmg_reason as proreason,wsd.dmg_remarks as proremarks ,wsd.idWhStockItem
			FROM whouse_stock_damge as wsd 
			LEFT JOIN product_details as pd ON pd.idProduct=wsd.idProduct
			LEFT JOIN product_size as ps ON ps.idProductsize=wsd.idProdSize
			LEFT JOIN primary_packaging as pp ON pp.idPrimaryPackaging=ps.idPrimaryPackaging
			LEFT JOIN warehouse_master as wm ON wm.idWarehouse=wsd.idWarehouse 
			WHERE  wsd.idDamage=?";

			     $result=$this->adapter->query($qry,array($editid));
			     $resultset=$result->toArray();
			    
			     if(!$resultset)
			     {
				   $ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			     } 
			     else 
			     {
				   $ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			     }
		    }else if($param->action=='update'){
		    	$fiedls=$param->Form;
		    	$whsItem=$param->whsItem;
			    $editid=$fiedls['idDamage'];
		    	

			$qry="SELECT * FROM  whouse_stock_damge where idDamage=?";
			$result=$this->adapter->query($qry,array($editid));
			$resultset=$result->toArray();
			if($resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					
					$data['idWarehouse']=$fiedls['warehouseid'];
					//$datainsert['idLevel']=$fiedls['idFactory'];
					//$datainsert['idCustomer']=$fiedls['vehicleno'];
					$data['idProduct']=$fiedls['proid'];
					$data['idProdSize']=$fiedls['prosize'];
					$data['dmg_prod_unit']=$fiedls['prounit'];
					//$datainsert['dmg_prod_qty']=($fiedls['proqty']/$fiedls['prounit']);
					$data['dmg_prod_qty']=$fiedls['proqty'];
					$data['dmg_batch_no']=$fiedls['probatchno'];
					$data['idWhStockItem']=$whsItem;
					//$datainsert['idWhStockItem']=$fiedls['proqty'];
					$data['dmg_mf_date']=date('Y-m-d',strtotime($fiedls['promfdate']));
					$data['dmg_reason']=$fiedls['proreason'];
					$data['dmg_remarks']=$fiedls['proremarks'];
					$data['dmg_entry_date']=date('Y-m-d H:i:s');
					
					
					$sql = new Sql($this->adapter);
					$update = $sql->update();
					$update->table('whouse_stock_damge');
					$update->set($data);
					$update->where( array('idDamage' => $editid));
					$statement  = $sql->prepareStatementForSqlObject($update);
					$results    = $statement->execute();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				}catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			} else {
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
			}

		    }else if($param->action=='delete'){

		    	$editid=$param->damageid;
		    	$qry="SELECT idProductserialno FROM  whouse_stock_damge where idDamage=?";
			$result=$this->adapter->query($qry,array($editid));
			$resultset=$result->toArray();

			$slno=explode(',',$resultset[0]['idProductserialno']);
				for ($i=0; $i < count($slno); $i++) { 
					$idserialno=$slno[$i];
						$updateserialNo['status']=2;
						$sql = new Sql($this->adapter);
						$update = $sql->update();
						$update->table('product_stock_serialno');
						$update->set($updateserialNo);
						$update->where(array('idProductserialno' =>$idserialno));
						$statement = $sql->prepareStatementForSqlObject($update);
						$results = $statement->execute();
				}

	    		$delete = new Delete('whouse_stock_damge');
				$delete->where(['idDamage=?' => $editid]);
				$statement=$this->adapter->createStatement();
				$delete->prepareStatement($this->adapter, $statement);
				$resultset=$statement->execute();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Deleted Successfully'];
			}


		    }
	return $ret_arr;
	}
	function productslno($param){
		 if($param->action=='add'){
			$qty=$param->qty;
			$slno=$param->slno;
			$proid=$param->proid;
			$size=$param->size;
			$warid=$param->warid;
			$sl_no=($slno)?implode(',',$slno):'';

			$qry="SELECT * FROM  product_stock_serialno WHERE serialno in('$sl_no')";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			$qryWHcheck="SELECT * FROM  product_stock_serialno WHERE idWhStock='".$warid."' AND idProduct='".$proid."' AND idProductsize='".$size."'";
			$resultWHcheck=$this->adapter->query($qryWHcheck,array());
			$resultsetWHcheck=$resultWHcheck->toArray();
			
			if(!$resultset AND !$resultsetWHcheck){

				$qryWH="SELECT idWhStockItem FROM  whouse_stock_items WHERE idWhStock='".$warid."' AND idProduct='".$proid."' AND idProdSize='".$size."'";
			$resultWH=$this->adapter->query($qryWH,array());
			$resultsetWH=$resultWH->toArray();
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {

					for($i=0;$i<count($slno);$i++){

						$datainsert['serialno']=$slno[$i]; 
						$datainsert['idProduct']=$proid; 
						$datainsert['idProductsize']=$size; 
						$datainsert['idWhStock']=$warid; 
						$datainsert['idWhStockItem']=$resultsetWH[0]['idWhStockItem']; 
						$datainsert['created_by']='1';
						$datainsert['created_at']=date('Y-m-d H:i:s');
						
						$insert=new Insert('product_stock_serialno');
						$insert->values($datainsert);
						$statement=$this->adapter->createStatement();
						$insert->prepareStatement($this->adapter, $statement);
						$insertresult=$statement->execute();
            		}
            		$qrySlno="SELECT wsi.idProduct,wsi.sku_accept_qty,ps.productPrimaryCount,(wsi.sku_accept_qty*ps.productPrimaryCount) 
					as totalserialno FROM `whouse_stock` as ws LEFT JOIN whouse_stock_items 
					as wsi ON wsi.idWhStock=ws.idWhStock LEFT JOIN product_details as prd on 
					prd.idProduct=wsi.idProduct LEFT JOIN product_size as ps on 
					ps.idProductsize=wsi.idProdSize WHERE ws.idWhStock='$warid'";
					
				$resultSlno=$this->adapter->query($qrySlno,array());
				$resultsetSlno=$resultSlno->toArray();
				$total=0;
				for ($i=0; $i < count($resultsetSlno); $i++) { 
					$total=$total+$resultsetSlno[$i]['totalserialno'];
				}
				
				$qrychecksl="SELECT count(*) as sltotal FROM  product_stock_serialno WHERE idWhStock='$warid'";
				
			$resultcheck=$this->adapter->query($qrychecksl,array());
			$resultsetcheck=$resultcheck->toArray();
			
			$serialstatus=0;
			if($total==$resultsetcheck[0]['sltotal']){
				$serialstatus=1;
			}else{
				$serialstatus=2;
			}
			
					$ret_arr=['code'=>'2','status'=>true,'serialstatus'=>$serialstatus,'message'=>'Added successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				}catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			} else {
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
			}


		}
	return $ret_arr;
	}
	public function transportnotes($param) {
		
		if($param->action=='list'){
			$customer=$param->customer;
			$enddate=$param->enddate;
			$startdate=$param->startdate;
			$qry="SELECT COUNT(t1.idCustomer) as total_acc,SUM(t1.reimburse_amount) as total_val ,t1.idCustomer FROM dispatch_vehicle as t1 WHERE t1.idCustomer='$customer' AND t1.creditnote_status!=0 AND (t1.deliveryDate BETWEEN '$startdate' AND '$enddate')";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			

			$qrynotes="SELECT t1.cs_name,COUNT(t2.idCustomer) as cus_count FROM customer as t1
			LEFT JOIN credit_notes_all_types as t2 ON t2.idCustomer=t1.idCustomer
			WHERE t1.idCustomer='$customer'";

			$resultnotes=$this->adapter->query($qrynotes,array());
			$resultsetnotes=$resultnotes->toArray();

			$qrypending="SELECT COUNT(t1.creditnote_status) as pendingstatus,SUM(t1.reimburse_amount) AS pending FROM dispatch_vehicle as t1 WHERE t1.idCustomer='$customer' AND t1.creditnote_status=1";

			$resultpending=$this->adapter->query($qrypending,array());
			$resultsetpending=$resultpending->toArray();

		
			if($resultset[0]['total_acc']==0) {
				
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not available'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'contentnotes'=>$resultsetnotes,'pending'=>$resultsetpending,'status'=>true,'message'=>'Record available'];

			}
		}
		else if($param->action=='view'){
			$customer=$param->customer;
			$startdate=date('Y-m-d',strtotime($param->startdate));
			$enddate=date('Y-m-d',strtotime($param->enddate));

			$qry="SELECT t1.idDispatchVehicle,t1.idCustomer,t1.reimburse_amount,t1.creditnote_status, t1.dc_no,t2.cs_name FROM dispatch_vehicle as t1 
			LEFT JOIN customer as t2 ON t2.idCustomer=t1.idCustomer WHERE t1.idCustomer='$customer' AND t1.creditnote_status!=0 AND (t1.deliveryDate BETWEEN '$startdate' AND '$enddate')";

			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
		
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];

			}
		}else if($param->action=='add') 
     		{
			$customer=$param->customer;
			$amount=$param->amount;
			$credit_note=$param->credit_note;
			$vehicleid=$param->vehicleid;
			
			
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {

					for($i=0;$i<count($customer);$i++){
						$datainsert['idCustomer']=$customer[$i];
						$datainsert['credit_note']=$credit_note[$i];
						$datainsert['credit_amnt']=$amount[$i];
						$datainsert['credit_date']=date('Y-m-d H:i:s');
						$datainsert['type']=1;
						$datainsert['status']=0;
						
						$insert=new Insert('credit_notes_all_types');
						$insert->values($datainsert);
						$statement=$this->adapter->createStatement();
						$insert->prepareStatement($this->adapter, $statement);
						$insertresult=$statement->execute();
					}
					$this->adapter->getDriver()->getConnection()->commit();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
				    } catch (\Exception $e) 
				    {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				    }
				    //update data
				    $this->adapter->getDriver()->getConnection()->beginTransaction();
				    try {

					for($i=0;$i<count($vehicleid);$i++){
					$dataupdate['creditnote_status']=2;
					$sql = new Sql($this->adapter );
					$update = $sql->update();
					$update->table('dispatch_vehicle');
					$update->set($dataupdate);
					$update->where( array('idDispatchVehicle' => $vehicleid));
					$statement  = $sql->prepareStatementForSqlObject($update);
					$results    = $statement->execute();
					}
					
					$this->adapter->getDriver()->getConnection()->commit();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
				    } catch (\Exception $e) 
				    {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				     }
			 
		    }
		return $ret_arr;
	}

	public function adhocnotes($param) {
		if($param->action=='list'){
			$customer=$param->customer_id;
			

			$qry="SELECT 0 as creditcode,cs.cs_name,t1.geoValue as country,t2.geoValue as state,t3.geoValue as City,t4.geoValue as Pincode,t5.geoValue as Zone,t6.geoValue as Hub,t7.geoValue as Region,t8.geoValue as Area,t9.geoValue as Street,t10.geoValue as Outlet FROM `customer`as cs
			LEFT JOIN geography as t1 ON t1.idGeography=cs.g1
			LEFT JOIN geography as t2 ON t2.idGeography=cs.g2
			LEFT JOIN geography as t3 ON t3.idGeography=cs.g3
			LEFT JOIN geography as t4 ON t4.idGeography=cs.g4
			LEFT JOIN geography as t5 ON t5.idGeography=cs.g5
			LEFT JOIN geography as t6 ON t6.idGeography=cs.g6
			LEFT JOIN geography as t7 ON t7.idGeography=cs.g7
			LEFT JOIN geography as t8 ON t8.idGeography=cs.g8
			LEFT JOIN geography as t9 ON t9.idGeography=cs.g9
			LEFT JOIN geography as t10 ON t10.idGeography=cs.g10
			WHERE idCustomer='$customer'";

			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			$address='';
			if ($resultset[0]['country']!='') 
			{
				$address=$address.''.$resultset[0]['country'];
			}
			if ($resultset[0]['state']!='') 
			{
				$address=$address.','.$resultset[0]['state'];
			}
			if ($resultset[0]['City']!='') 
			{
				$address=$address.','.$resultset[0]['City'];
			}			
			
			if ($resultset[0]['Outlet']!='') 
			{
				$address=$address.','.$resultset[0]['Outlet'];
			}
			if ($resultset[0]['Street']!='') 
			{
				$address=$address.','.$resultset[0]['Street'];
			}
			if ($resultset[0]['Area']!='') 
			{
				$address=$address.','.$resultset[0]['Area'];
			}
			if ($resultset[0]['Region']!='') 
			{
				$address=$address.','.$resultset[0]['Region'];
			}
			if ($resultset[0]['Hub']!='') 
			{
				$address=$address.','.$resultset[0]['Hub'];
			}
			if ($resultset[0]['Zone']!='') 
			{
				$address=$address.','.$resultset[0]['Zone'];
			}
			if ($resultset[0]['Pincode']!='') 
			{
				$address=$address.','.$resultset[0]['Pincode'];
			}
            $resultset[0]['address']=$address;


/*
			$qrycode="SELECT c.cs_name,cl.c_no from customer as c  LEFT JOIN  credit_details
	as cl  ON cl.idCustomer=c.idCustomer where c.idCustomer='$customer' order by cl.idCredit desc limit 1";
	$resultcode=$this->adapter->query($qrycode,array());
	$resultsetcode=$resultcode->toArray();
	$name=$resultsetcode[0]['cs_name'];
	if($resultsetcode[0]['c_no']=='' || $resultsetcode[0]['c_no']==NULL){
		$code="$name/"."ACC/"."01";
	}else{
		$splitCode=explode('/',$selQry[0]['c_no']);
		$start=$splitCode[2];
		$start++;
		$start=sprintf("%02d", $start);
		$code="$name/ACC/".$start;
	}	*/

$qrycode="	SELECT count(*) as Creditcount FROM `credit_details` WHERE idCustomer='$customer'";
	$resultcode=$this->adapter->query($qrycode,array());
	$resultsetcode=$resultcode->toArray();

     $start=$resultsetcode[0]['Creditcount']+1;
			$name=CC;
	$splitCode=$resultset[0]['cs_name'];
	// $start=$splitCode[2];
	// $start++;
	// $start=sprintf("%02d", $start);
	$code="$name/$splitCode/".$start;	
	$resultset[0]['creditcode']=$code;
		
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];

			}
	}else if($param->action=='add') 
     		{
			$customer=$param->customerid;
			$amount=$param->credit_amt;
			$credit_note=$param->credit_note;
			$custype=$param->custype;
			$credit_desript=$param->credit_desript;
			
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {

						$datainsert['c_no']=$credit_note;
						$datainsert['c_amnt']=$amount;
						$datainsert['c_date']=date('Y-m-d');
						$datainsert['description']=$credit_desript;
						$datainsert['idCustomer']=$customer;
						$datainsert['creditId']=$custype;
					
						$insert=new Insert('credit_details');
						$insert->values($datainsert);
						$statement=$this->adapter->createStatement();
						$insert->prepareStatement($this->adapter, $statement);
						$insertresult=$statement->execute();
					$this->adapter->getDriver()->getConnection()->commit();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
				    } catch (\Exception $e) 
				    {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				    }
				    //update data
				    $this->adapter->getDriver()->getConnection()->beginTransaction();
				    try {

					for($i=0;$i<count($vehicleid);$i++){
					$dataupdate['creditnote_status']=2;
					$sql = new Sql($this->adapter );
					$update = $sql->update();
					$update->table('dispatch_vehicle');
					$update->set($dataupdate);
					$update->where( array('idDispatchVehicle' => $vehicleid));
					$statement  = $sql->prepareStatementForSqlObject($update);
					$results    = $statement->execute();
					}
					
					$this->adapter->getDriver()->getConnection()->commit();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
				    } catch (\Exception $e) 
				    {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				     }
			 
		    }
		return $ret_arr;
	}
	public function stockregisterwarhouse($param) {
	$userData=$param->userData;
	$userid=$userData['user_id'];
	$usertype=$userData['user_type'];
	$idCustomer=$userData['idCustomer'];


		 if($param->action=='warehousedetails'){
		 	$userData=$param->userData;
            $usertype=$userData['user_type'];
			$idCustomer=$userData['idCustomer'];

		 	$total=0;
		 	$qrywar="SELECT t1.idWarehouse,t1.warehouseName,0 as ttlqty FROM warehouse_master as t1 WHERE t1.idCustomer='$idCustomer' AND t1.status=1";
		 	$resultwar=$this->adapter->query($qrywar,array());
		 	$resultset=$resultwar->toArray();

		 	for ($i=0; $i < count($resultset); $i++) { 
		 		$idWarehouse=$resultset[$i]['idWarehouse'];
		 		$qrywarcheck="SELECT t1.idWarehouse FROM whouse_stock as t1 WHERE t1.idWarehouse='$idWarehouse'";
		 	$resultwarcheck=$this->adapter->query($qrywarcheck,array());
		 	$resultsetcheck=$resultwarcheck->toArray();
		 	if($resultsetcheck){
		 		$dataArray = array();
		 		$stockEntry="SELECT 'stockEntry' as dataType, WHSI.sku_accept_qty as proQty, WHSI.sku_entry_date as entryDate, WHS.po_no as PORefernce, WHS.grn_no as DocRefernce 
		 		from whouse_stock_items as 
		 		WHSI LEFT JOIN whouse_stock as WHS ON WHS.idWhStock=WHSI.idWhStock 
		 		where WHSI.idWarehouse='$idWarehouse'";
		 		$resultstockEntry=$this->adapter->query($stockEntry,array());
		 		$resultsetstockEntry=$resultstockEntry->toArray();
		 		if(0<count($resultsetstockEntry)){
		 			foreach($resultsetstockEntry AS $var){
		 				array_push($dataArray,$var);
		 			}
		 		}
		 		$qrycus="SELECT COR.rtnQty as proQty,DC.idCustomer,DC.idWarehouse from customer_order_return as COR
		 		LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer  where DC.idCustomer='$idCustomer'";
		 		$resultcus=$this->adapter->query($qrycus,array());
		 		$resultsetcus=$resultcus->toArray();
		 		$Customer=$resultsetcus[0]['idCustomer'];
		 		$war=$resultsetcus[0]['idWarehouse'];
		 		if($Customer){
		 			$cstReturnQty="SELECT 'returncustomer' as dataType,COR.rtnQty as proQty, COR.rtnDate as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce 
		 			from customer_order_return as COR
		 			LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
		 			LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
		 			LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
		 			LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
		 			where WHSI.idWarehouse='$war'";
		 			$ReceiveQty="SELECT 'receive' as dataType, COR.rtnQty as proQty, COR.rtnDate as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce 
		 			from customer_order_return as COR
		 			LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
		 			LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
		 			LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
		 			LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
		 			where WHSI.idWarehouse='$idWarehouse'";	
		 			$resultcstReceiveQty=$this->adapter->query($ReceiveQty,array());
		 			$resultsetcstReceiveQty=$resultcstReceiveQty->toArray();
		 			
		 		}else{
		 			$cstReturnQty="SELECT 'return' as dataType, COR.rtnQty as proQty, COR.rtnDate as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce 
		 			from customer_order_return as COR
		 			LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
		 			LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
		 			LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
		 			LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
		 			where WHSI.idWarehouse='$idWarehouse'";
		 		}
		 		$resultcstReturnQty=$this->adapter->query($cstReturnQty,array());
		 		$resultsetcstReturnQty=$resultcstReturnQty->toArray();
		 		if(0<count($resultsetcstReturnQty)){
		 			foreach($resultsetcstReturnQty AS $var){
		 				array_push($dataArray,$var);
		 			}
		 		}
		 		if(0<count($resultsetcstReceiveQty)){
		 			foreach($resultsetcstReceiveQty AS $var){
		 				array_push($dataArray,$var);
		 			}
		 		}
		 		$dispatchQty="SELECT 'dispatch' as dataType, DPB.qty as proQty, DV.deliveryDate as entryDate, O.poNumber as PORefernce, DC.invoiceNo as DocRefernce 
		 		from dispatch_product_batch as DPB 
		 		LEFT JOIN dispatch_product as DP ON DP.idDispatchProduct=DPB.idDispatchProduct 
		 		LEFT JOIN dispatch_customer as DC ON DC.idDispatchcustomer=DP.idDispatchcustomer 
		 		LEFT JOIN dispatch_vehicle as DV ON DV.idDispatchVehicle=DC.idDispatchVehicle 
		 		LEFT JOIN orders as O ON O.idOrder=DC.idOrder 
		 		LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
		 		where WHSI.idWarehouse='$idWarehouse'";
		 		$resultdispatchQty=$this->adapter->query($dispatchQty,array());
		 		$resultsetdispatchQty=$resultdispatchQty->toArray();
		 		if(0<count($resultsetdispatchQty)){
		 			foreach($resultsetdispatchQty AS $var)
		 			{
		 				array_push($dataArray,$var);
		 			}
		 		}
		 		$cstReplcMnt="SELECT 'replace' as dataType, COR.replaceQty as proQty, COR.replaceDate as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce 
		 		from customer_order_replacement as COR
		 		LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
		 		LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
		 		LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
		 		LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
		 		where WHSI.idWarehouse='$idWarehouse'";
		 		$resultcstReplcMnt=$this->adapter->query($cstReplcMnt,array());
		 		$resultsetcstReplcMnt=$resultcstReplcMnt->toArray();
		 		if(0<count($resultsetcstReplcMnt)){
		 			foreach($resultsetcstReplcMnt AS $var){
		 				array_push($dataArray,$var);
		 			}
		 		}
		 		$cstMisng="SELECT 'missing' as dataType, COR.missing_qty as proQty, COR.missing_entry_date as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce 
		 		from customer_order_missing as COR
		 		LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
		 		LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
		 		LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
		 		LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
		 		where WHSI.idWarehouse='$idWarehouse'";
		 		$resultcstMisng=$this->adapter->query($cstMisng,array());
		 		$resultsetcstMisng=$resultcstMisng->toArray();
		 		if(0<count($resultsetcstMisng)){
		 			foreach($resultsetcstMisng AS $var){
		 				array_push($dataArray,$var);
		 			}
		 		}
		 		$stkDmg="SELECT 'stockdmg' as dataType, WHSD.dmg_prod_qty as proQty, WHSD.dmg_entry_date as entryDate,PS.productPrimaryCount, WHS.po_no as PORefernce, WHS.grn_no as DocRefernce 
		 		from whouse_stock_damge as WHSD 
		 		LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=WHSD.idWhStockItem 
		 		LEFT JOIN whouse_stock as WHS ON WHSI.idWhStock=WHS.idWhStock 
                LEFT JOIN  product_size as PS ON PS.idProductsize=WHSD.idProdSize  
		 		where WHSD.idWarehouse='$idWarehouse'";
		 		
		 		$resultstkDmg=$this->adapter->query($stkDmg,array());
		 		$resultsetstkDmg=$resultstkDmg->toArray();

		 		
		 	
		 
		 		if(0<count($resultsetstkDmg)){
		 			
		 			foreach($resultsetstkDmg AS $var)
		 			{
		 				array_push($dataArray,$var);
		 			}
		 		}
		 		if ($usertype!=0) {
		 			$cstDmg="SELECT 'damage' as dataType, COR.dmgQty as proQty,COR.idDispatchProductBatch ,PS.productPrimaryCount,COR.dmgRtnDate as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce 
		 		from customer_order_damges as COR
		 		LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
		 		LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
                LEFT JOIN dispatch_product as DP ON DP.idDispatchProduct=DPB.idDispatchProduct 
                LEFT JOIN  product_size as PS ON PS.idProductsize=DP.idProdSize 
		 		LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
		 		LEFT JOIN orders_allocated as OA ON OA.idOrder=O.idOrder  
		 		LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
		 		where WHSI.idWarehouse=OA.idWarehouse and DC.idCustomer='$idCustomer'";
		 		$resultcstDmg=$this->adapter->query($cstDmg,array());
		 		$resultsetcstDmg=$resultcstDmg->toArray();
		 		
		 		}else{
		 			$resultsetcstDmg=[];
		 		}
		 		
		 		if(0<count($resultsetcstDmg)){

		 			foreach($resultsetcstDmg AS $var){
		 				array_push($dataArray,$var);
		 			}
		 		}
		 		
		 		$balanceAmt=0;
		 		//print_r($dataArray);exit;
		 		
		 		foreach($dataArray as $val){
		 			
		 			if($val["dataType"]=='stockEntry' || $val["dataType"]=='return'|| $val["dataType"]=='receive'){
		 				$balanceAmt+=number_format($val["proQty"], 2, '.', '');
		 			}else if($val["dataType"]=='dispatch' || $val["dataType"]=='replace' || $val["dataType"]=='missing'  || $val["dataType"]=='returncustomer'){
		 				$balanceAmt-=number_format($val["proQty"], 2, '.', '');
		 			}else if($val["dataType"]=='stockdmg' || $val["dataType"]=='damage'){
		 				$balanceAmt-=number_format($val["proQty"]/$val["productPrimaryCount"], 2, '.', '');
		 				

		 			}
		 		}
		 		$resultset[$i]['ttlqty']=number_format($balanceAmt, 2, '.', '');
		 		
		 		}

		 	}
		 	
		 	if(!$resultset) {
		 		$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found'];
		 	} else {
		 		$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];

		 	}
		}else if($param->action=='warproductdetails'){
			
			$warid=$param->warid;
			$userData=$param->userData;
            $usertype=$userData['user_type'];
            $idCustomer=$userData['idCustomer'];
			
			$qrypoqty="SELECT t2.idWhStock,t2.idWarehouse,t3.idProduct,t6.primarypackname,t3.idProdSize,SUM(t3.sku_accept_qty) AS qty,t4.productName,t5.productSize,t5.idPrimaryPackaging,t5.productPrimaryCount,t4.productCount FROM whouse_stock as t2
LEFT JOIN whouse_stock_items as t3 ON t3.idWhStock=t2.idWhStock
LEFT JOIN product_details as t4 ON t4.idProduct=t3.idProduct
LEFT JOIN product_size as t5 ON t5.idProductsize=t3.idProdSize
LEFT JOIN primary_packaging as t6 ON t6.idPrimaryPackaging=t5.idPrimaryPackaging
			WHERE t2.idCustomer='$idCustomer' AND t2.idWarehouse='$warid' AND t4.status=1 AND t5.status=1  GROUP BY idProductsize";
			
			$resultpoqty=$this->adapter->query($qrypoqty,array());
			$resultset=$resultpoqty->toArray();
		for ($i=0; $i < count($resultset); $i++) { 
				$idWarehouse=$resultset[$i]['idWarehouse'];
				$prodId=$resultset[$i]['idProduct'];
				$sizId=$resultset[$i]['idProdSize'];
				$dataArray = array();
	$stockEntry="SELECT 'stockEntry' as dataType, WHSI.sku_accept_qty as proQty, WHSI.sku_entry_date as entryDate, WHS.po_no as PORefernce, WHS.grn_no as DocRefernce 
							from whouse_stock_items as 
							WHSI LEFT JOIN whouse_stock as WHS ON WHS.idWhStock=WHSI.idWhStock 
							where WHSI.idProduct='$prodId' and WHSI.idProdSize='$sizId' and WHSI.idWarehouse='$idWarehouse'";
	$resultstockEntry=$this->adapter->query($stockEntry,array());
	$resultsetstockEntry=$resultstockEntry->toArray();
	if(0<count($resultsetstockEntry)){
		foreach($resultsetstockEntry AS $var){
			array_push($dataArray,$var);
		}
	}
	$qrycus="SELECT COR.rtnQty as proQty,DC.idCustomer,DC.idWarehouse from customer_order_return as COR
	LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer  where DC.idCustomer='$idCustomer'";

	$resultcus=$this->adapter->query($qrycus,array());
	$resultsetcus=$resultcus->toArray();
	$Customer=$resultsetcus[0]['idCustomer'];
	$war=$resultsetcus[0]['idWarehouse'];
	if($Customer){
		$cstReturnQty="SELECT 'returncustomer' as dataType,COR.rtnQty as proQty, COR.rtnDate as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce 
							  from customer_order_return as COR
							  LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
							  LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
							  LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
							  LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
							  where WHSI.idProduct='$prodId' and WHSI.idProdSize='$sizId' and WHSI.idWarehouse='$war'";
		$ReceiveQty="SELECT 'receive' as dataType,  COR.rtnQty as proQty, COR.rtnDate as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce 
							  from customer_order_return as COR
							  LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
							  LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
							  LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
							  LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
							  where WHSI.idProduct='$prodId' and WHSI.idProdSize='$sizId' and WHSI.idWarehouse='$idWarehouse'";	
	$resultcstReceiveQty=$this->adapter->query($ReceiveQty,array());
	$resultsetcstReceiveQty=$resultcstReceiveQty->toArray();

	}else{
	$cstReturnQty="SELECT 'return' as dataType, COR.rtnQty as proQty, COR.rtnDate as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce 
							  from customer_order_return as COR
							  LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
							  LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
							  LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
							  LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
							  where WHSI.idProduct='$prodId' and WHSI.idProdSize='$sizId' and WHSI.idWarehouse='$idWarehouse'";
							}
	$resultcstReturnQty=$this->adapter->query($cstReturnQty,array());
	$resultsetcstReturnQty=$resultcstReturnQty->toArray();
	if(0<count($resultsetcstReturnQty)){
		foreach($resultsetcstReturnQty AS $var){
			array_push($dataArray,$var);
		}
	}
	if(0<count($resultsetcstReceiveQty)){
		foreach($resultsetcstReceiveQty AS $var){
			array_push($dataArray,$var);
		}
	}
	$dispatchQty="SELECT 'dispatch' as dataType, DPB.qty as proQty, DV.deliveryDate as entryDate, O.poNumber as PORefernce, DC.invoiceNo as DocRefernce 
						 from dispatch_product_batch as DPB 
						 LEFT JOIN dispatch_product as DP ON DP.idDispatchProduct=DPB.idDispatchProduct 
						 LEFT JOIN dispatch_customer as DC ON DC.idDispatchcustomer=DP.idDispatchcustomer 
						 LEFT JOIN dispatch_vehicle as DV ON DV.idDispatchVehicle=DC.idDispatchVehicle 
						 LEFT JOIN orders as O ON O.idOrder=DC.idOrder 
						 LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
						 where WHSI.idProduct='$prodId' and WHSI.idProdSize='$sizId' and WHSI.idWarehouse='$idWarehouse'";
	$resultdispatchQty=$this->adapter->query($dispatchQty,array());
	$resultsetdispatchQty=$resultdispatchQty->toArray();
	if(0<count($resultsetdispatchQty)){
		foreach($resultsetdispatchQty AS $var)
		{
		array_push($dataArray,$var);
		}
	}
	$cstReplcMnt="SELECT 'replace' as dataType, COR.replaceQty as proQty, COR.replaceDate as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce 
							  from customer_order_replacement as COR
							  LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
							  LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
							  LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
							  LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
							  where WHSI.idProduct='$prodId' and WHSI.idProdSize='$sizId' and WHSI.idWarehouse='$idWarehouse'";
	$resultcstReplcMnt=$this->adapter->query($cstReplcMnt,array());
	$resultsetcstReplcMnt=$resultcstReplcMnt->toArray();
	if(0<count($resultsetcstReplcMnt)){
		foreach($resultsetcstReplcMnt AS $var){
			array_push($dataArray,$var);
		}
	}
	$cstMisng="SELECT 'missing' as dataType, COR.missing_qty as proQty, COR.missing_entry_date as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce 
							  from customer_order_missing as COR
							  LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
							  LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
							  LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
							  LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
							  where WHSI.idProduct='$prodId' and WHSI.idProdSize='$sizId' and WHSI.idWarehouse='$idWarehouse'";
	$resultcstMisng=$this->adapter->query($cstMisng,array());
	$resultsetcstMisng=$resultcstMisng->toArray();
	if(0<count($resultsetcstMisng)){
		foreach($resultsetcstMisng AS $var){
			array_push($dataArray,$var);
		}
	}
	$stkDmg="SELECT 'stockdmg' as dataType, WHSD.dmg_prod_qty as proQty, WHSD.dmg_entry_date as entryDate,PS.productPrimaryCount, WHS.po_no as PORefernce, WHS.grn_no as DocRefernce 
		 		from whouse_stock_damge as WHSD 
		 		LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=WHSD.idWhStockItem 
		 		LEFT JOIN whouse_stock as WHS ON WHSI.idWhStock=WHS.idWhStock 
                LEFT JOIN  product_size as PS ON PS.idProductsize=WHSD.idProdSize 
						where WHSD.idProduct='$prodId' and WHSD.idProdSize='$sizId' and WHSD.idWarehouse='$idWarehouse'";
	$resultstkDmg=$this->adapter->query($stkDmg,array());
	$resultsetstkDmg=$resultstkDmg->toArray();
 		$primarycount=$resultsetstkDmg[0]['productPrimaryCount'];
 	
	if(0<count($resultsetstkDmg)){
		foreach($resultsetstkDmg AS $var)
		{
		array_push($dataArray,$var);
		}
	}
	if ($usertype!=0) {
		$cstDmg="SELECT 'damage' as dataType, COR.dmgQty as proQty,COR.idDispatchProductBatch ,PS.productPrimaryCount,COR.dmgRtnDate as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce 
		 		from customer_order_damges as COR
		 		LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
		 		LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
                LEFT JOIN dispatch_product as DP ON DP.idDispatchProduct=DPB.idDispatchProduct 
                LEFT JOIN  product_size as PS ON PS.idProductsize=DP.idProdSize 
		 		LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
		 		LEFT JOIN orders_allocated as OA ON OA.idOrder=O.idOrder  
		 		LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
							  where WHSI.idProduct='$prodId' and WHSI.idProdSize='$sizId' and WHSI.idWarehouse=OA.idWarehouse and DC.idCustomer='$idCustomer'";
	$resultcstDmg=$this->adapter->query($cstDmg,array());
	$resultsetcstDmg=$resultcstDmg->toArray();
	$primarycount=$resultsetcstDmg[0]['productPrimaryCount'];
	}else{
		$resultsetcstDmg=[];
	}
	
	if(0<count($resultsetcstDmg)){
		foreach($resultsetcstDmg AS $var){
			array_push($dataArray,$var);
		}
	}
	
	$balanceAmt=0;
	
	foreach($dataArray as $val){
		
		if($val["dataType"]=='stockEntry' || $val["dataType"]=='return'|| $val["dataType"]=='receive'){
			 $balanceAmt+=number_format($val["proQty"], 2, '.', '');
		}else if($val["dataType"]=='dispatch' || $val["dataType"]=='replace' || $val["dataType"]=='missing'  || $val["dataType"]=='returncustomer'){
			 $balanceAmt-=number_format($val["proQty"], 2, '.', '');
		}else if($val["dataType"]=='stockdmg' || $val["dataType"]=='damage'){
			 $balanceAmt-=number_format($val["proQty"]/$val["productPrimaryCount"], 2, '.', '');
		}
	}
			
	$resultset[$i]['qty']=number_format($balanceAmt, 2, '.', '');
	

			}
			//print_r($resultsetwar);
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];

			}
		}else if($param->action=='viewpopup'){

			$warid=$param->warid;
			$proid=$param->proid;
			$sizeid=$param->sizeid;
			$mfdate=$param->mfdate;
			$batch_no=$param->batch_no;
            $userData=$param->userData;
            $usertype=$userData['user_type'];
            $idCustomer=$userData['idCustomer'];
            
          

			$qry="SELECT P.idProduct, P.productName, P.productUnit,P.productserialNo, PS.idProductsize, PS.productSize, PT.primarypackname,PS.productPrimaryCount from product_details as P LEFT JOIN product_size as PS ON PS.idProduct=P.idProduct LEFT JOIN primary_packaging as PT ON PT.idPrimaryPackaging=PS.idPrimaryPackaging where P.idProduct='$proid' AND  PS.idProductsize='$sizeid'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			$primarycount=$resultset[0]['productPrimaryCount'];
			$serialnostatus=$resultset[0]['productserialNo'];
			$dataArray = array();
			  if ($userData['user_type']==0 AND $userData['idCustomer']==0) 
            {
            	$stockEntry="SELECT 'stockEntry' as dataType, WHSI.sku_accept_qty as proQty, DATE_FORMAT(WHSI.sku_entry_date,'%d-%m-%Y') as entryDate, WHS.po_no as PORefernce, WHS.grn_no as DocRefernce ,0 as balanceAmt,0 as pricount,0 as idOrder,WHSI.idWhStockItem
						from whouse_stock_items as 
						WHSI LEFT JOIN whouse_stock as WHS ON WHS.idWhStock=WHSI.idWhStock 
						where WHSI.idProduct='$proid' and WHSI.idProdSize='$sizeid' and WHSI.idWarehouse='$warid' and WHSI.sku_mf_date='".date("Y-m-d", strtotime($mfdate))."'";
            }
            else
            {
            	$stockEntry="SELECT 'stockEntry' as dataType, WHSI.sku_accept_qty as proQty, DATE_FORMAT(WHSI.sku_entry_date,'%d-%m-%Y') as entryDate, WHS.po_no as PORefernce, WHS.grn_no as DocRefernce ,0 as balanceAmt,0 as pricount,O.idOrder,WHSI.idWhStockItem from whouse_stock_items as WHSI 
            		LEFT JOIN whouse_stock as WHS ON WHS.idWhStock=WHSI.idWhStock 
            		LEFT JOIN orders as O ON O.poNumber=WHS.po_no 
            		where WHSI.idProduct='$proid' and WHSI.idProdSize='$sizeid' and WHSI.idWarehouse='$warid' and WHSI.sku_mf_date='".date("Y-m-d", strtotime($mfdate))."'";
            }

	
					
	$resultstockEntry=$this->adapter->query($stockEntry,array());
	$resultsetstockEntry=$resultstockEntry->toArray();
	//print_r($resultsetstockEntry);
	if(0<count($resultsetstockEntry)){
		foreach($resultsetstockEntry AS $var){
			array_push($dataArray,$var);
		}
	}

	$dispatchQty="SELECT 'dispatch' as dataType, DPB.qty as proQty,DPB.idWhStockItem, DATE_FORMAT(DV.deliveryDate,'%d-%m-%Y') as entryDate, O.poNumber as PORefernce, DC.invoiceNo as DocRefernce ,0 as balanceAmt,0 as pricount,O.idOrder
					 from dispatch_product_batch as DPB 
					 LEFT JOIN dispatch_product as DP ON DP.idDispatchProduct=DPB.idDispatchProduct 
					 LEFT JOIN dispatch_customer as DC ON DC.idDispatchcustomer=DP.idDispatchcustomer 
					 LEFT JOIN dispatch_vehicle as DV ON DV.idDispatchVehicle=DC.idDispatchVehicle 
					 LEFT JOIN orders as O ON O.idOrder=DC.idOrder 
					 LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
					 where WHSI.idProduct='$proid' and WHSI.idProdSize='$sizeid' and WHSI.idWarehouse='$warid' and WHSI.sku_mf_date = '".date("Y-m-d", strtotime($mfdate))."'";
	$resultdispatchQty=$this->adapter->query($dispatchQty,array());
	$resultsetdispatchQty=$resultdispatchQty->toArray();
	$idorders=$resultsetdispatchQty[0]['idOrder'];

	if(0<count($resultsetdispatchQty)){
		foreach($resultsetdispatchQty AS $var)
		{
		array_push($dataArray,$var);
		}
	}

	$qrycus="SELECT COR.rtnQty as proQty,DC.idCustomer,DC.idWarehouse from customer_order_return as COR
	LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer  where DC.idCustomer='$idCustomer'";

	$resultcus=$this->adapter->query($qrycus,array());
	$resultsetcus=$resultcus->toArray();

	$Customer=$resultsetcus[0]['idCustomer'];
	$war=$resultsetcus[0]['idWarehouse'];
	if($Customer){
		$cstReturnQty="SELECT 'returncustomer' as dataType,COR.rtnQty as proQty,  DATE_FORMAT(COR.rtnDate,'%d-%m-%Y') as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce ,0 as pricount,O.idOrder
							  from customer_order_return as COR
							  LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
							  LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
							  LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
							  LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
							   where WHSI.idProduct='$proid' and WHSI.idProdSize='$sizeid' and WHSI.idWarehouse='$war' and WHSI.sku_mf_date='".date("Y-m-d", strtotime($mfdate))."'";

		$ReceiveQty="SELECT 'receive' as dataType,  COR.rtnQty as proQty,  DATE_FORMAT(COR.rtnDate,'%d-%m-%Y') as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce ,0 as balanceAmt,0 as pricount,O.idOrder
						  from customer_order_return as COR
						  LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
						  LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
						  LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
						  LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
						  where WHSI.idProduct='$proid' and WHSI.idProdSize='$sizeid' and WHSI.idWarehouse='$warid' and WHSI.sku_mf_date='".date("Y-m-d", strtotime($mfdate))."'";	
		$resultcstReceiveQty=$this->adapter->query($ReceiveQty,array());
		$resultsetcstReceiveQty=$resultcstReceiveQty->toArray();
	}else{
		$cstReturnQty="SELECT 'return' as dataType, COR.rtnQty as proQty,  DATE_FORMAT(COR.rtnDate,'%d-%m-%Y') as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce ,0 as balanceAmt,0 as pricount,O.idOrder
						  from customer_order_return as COR
						  LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
						  LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
						  LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
						  LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
						  where WHSI.idProduct='$proid' and WHSI.idProdSize='$sizeid' and WHSI.idWarehouse='$warid' and WHSI.sku_mf_date='".date("Y-m-d", strtotime($mfdate))."'";
	}

	$resultcstReturnQty=$this->adapter->query($cstReturnQty,array());
	$resultsetcstReturnQty=$resultcstReturnQty->toArray();
	if(0<count($resultsetcstReturnQty)){
		foreach($resultsetcstReturnQty AS $var){
			array_push($dataArray,$var);
		}
	}
	if(0<count($resultsetcstReceiveQty)){
		foreach($resultsetcstReceiveQty AS $var){
			array_push($dataArray,$var);
		}
	}
	
	$cstReplcMnt="SELECT 'replace' as dataType, COR.replaceQty as proQty,  DATE_FORMAT(COR.replaceDate,'%d-%m-%Y') as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce ,0 as balanceAmt,0 as pricount,O.idOrder
						  from customer_order_replacement as COR
						  LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
						  LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
						  LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
						  LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
						  where WHSI.idProduct='$proid' and WHSI.idProdSize='$sizeid' and WHSI.idWarehouse='$warid' and WHSI.sku_mf_date='".date("Y-m-d", strtotime($mfdate))."'";
	$resultcstReplcMnt=$this->adapter->query($cstReplcMnt,array());
	$resultsetcstReplcMnt=$resultcstReplcMnt->toArray();
	if(0<count($resultsetcstReplcMnt)){
		foreach($resultsetcstReplcMnt AS $var){
			array_push($dataArray,$var);
		}
	}
	$cstMisng="SELECT 'missing' as dataType, COR.missing_qty as proQty,  DATE_FORMAT(COR.missing_entry_date,'%d-%m-%Y') as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce ,0 as balanceAmt,0 as pricount,O.idOrder
					  from customer_order_missing as COR
					  LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
					  LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
					  LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
					  LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
					  where WHSI.idProduct='$proid' and WHSI.idProdSize='$sizeid' and WHSI.idWarehouse='$warid' and WHSI.sku_mf_date='".date("Y-m-d", strtotime($mfdate))."'";
	$resultcstMisng=$this->adapter->query($cstMisng,array());
	$resultsetcstMisng=$resultcstMisng->toArray();
	if(0<count($resultsetcstMisng)){
		foreach($resultsetcstMisng AS $var){
			array_push($dataArray,$var);
		}
	}
	$stkDmg="SELECT 'stockdmg' as dataType,WHSD.idDamage as idwhdamage, WHSD.dmg_prod_qty as proQty,  DATE_FORMAT(WHSD.dmg_entry_date,'%d-%m-%Y') as entryDate, WHS.po_no as PORefernce, WHS.grn_no as DocRefernce,0 as balanceAmt ,0 as pricount
					from whouse_stock_damge as WHSD 
					LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=WHSD.idWhStockItem 
					LEFT JOIN whouse_stock as WHS ON WHSI.idWhStock=WHS.idWhStock 
					where WHSD.idProduct='$proid' and WHSD.idProdSize='$sizeid' and WHSD.idWarehouse='$warid' and WHSI.sku_mf_date ='".date("Y-m-d", strtotime($mfdate))."'";

	$resultstkDmg=$this->adapter->query($stkDmg,array());
	$resultsetstkDmg=$resultstkDmg->toArray();

	if(0<count($resultsetstkDmg)){
		foreach($resultsetstkDmg AS $var)
		{
		array_push($dataArray,$var);
		}
	}
	if ($usertype!=0) {
		$cstDmg="SELECT 'damage' as dataType,COR.idCustOrderDmgsRtn as idDamage,COR.dmgQty as proQty,  DATE_FORMAT(COR.dmgRtnDate,'%d-%m-%Y') as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce ,0 as balanceAmt,0 as pricount,O.idOrder
				  from customer_order_damges as COR
				  LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
				  LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
				  LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
                  LEFT JOIN orders_allocated as OA ON OA.idOrder=O.idOrder  
				  LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem  
				  where WHSI.idProduct='$proid' and WHSI.idProdSize='$sizeid' and WHSI.idWarehouse=OA.idWarehouse and WHSI.sku_mf_date='".date("Y-m-d", strtotime($mfdate))."' and DC.idCustomer='$idCustomer'";
				 
	$resultcstDmg=$this->adapter->query($cstDmg,array());
	$resultsetcstDmg=$resultcstDmg->toArray();
	}else{
		$resultsetcstDmg=[];
	}
	
	if(0<count($resultsetcstDmg)){
		foreach($resultsetcstDmg AS $var){
			array_push($dataArray,$var);
		}
	}
	$balanceAmt=0;
	
	foreach($dataArray as $key => $val ){
		
		if($val["dataType"]=='stockEntry' || $val["dataType"]=='return'|| $val["dataType"]=='receive'){
		$balanceAmt+=number_format($val["proQty"], 2, '.', '');
		}else if($val["dataType"]=='dispatch' || $val["dataType"]=='replace' || $val["dataType"]=='missing' || $val["dataType"]=='returncustomer'){
		$balanceAmt-=number_format($val["proQty"], 2, '.', '');
		}else if($val["dataType"]=='damage' || $val["dataType"]=='stockdmg'){
		$balanceAmt-=number_format($val["proQty"]/$primarycount, 2, '.', '');
		$damagequantity=$val["proQty"]/$primarycount;
		}
		$dataArray[$key]['balanceAmt']=number_format($balanceAmt, 2, '.', '');
		$dataArray[$key]['pricount']=ceil($damagequantity);
		$dataArray[$key]['entryDate']=date("d-m-Y", strtotime($dataArray[$key]['entryDate']));
		$dataArray[$key]['warid']=$warid;
		$dataArray[$key]['proid']=$proid;
		$dataArray[$key]['sizeid']=$sizeid;
		$dataArray[$key]['mfdate']=$mfdate;
		$dataArray[$key]['batch_no']=$batch_no;
		$dataArray[$key]['serialnostatus']=$serialnostatus;
		$dataArray[$key]['idorder']=$val["idOrder"];
	}		
	//print_r($dataArray);exit;
			if(!$dataArray) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found'];
			} else {
				$ret_arr=['code'=>'2','content'=>$dataArray,'primarycount'=>$primarycount,'status'=>true,'message'=>'Record available'];

			}
		}
		return $ret_arr;
	}

	public function stockserialno($param)
	{
	$userData=$param->userData;
	$userid=$userData['user_id'];
	$usertype=$userData['user_type'];
	$idCustomer=$userData['idCustomer'];


		if($param->action=='viewserial'){

			$warid=$param->warid; //idWhStock
			$proid=$param->proid;
			$sizeid=$param->sizeid;
			$mfdate=$param->mfdate;
			$batch_no=$param->batch_no;
			$datatype=$param->datatype;
            $dataUser=$param->userData;
            $idorder=$param->idorder;
            $idWhItem=$param->idWhItem;
           
            // admin login get stock serial numbers
          if ($dataUser['user_type']==0 AND $dataUser['idCustomer']==0) 
          {
          	$qry="SELECT idWhStock,idProdSize,idProduct FROM `whouse_stock_items` WHERE sku_batch_no='$batch_no'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			$whstockid=$resultset[0]['idWhStock'];

			$qrysl="SELECT serialno FROM `product_stock_serialno` WHERE idWhStock='$whstockid' AND idProduct='$proid' AND idProductsize='$sizeid'";
			
			$resultsl=$this->adapter->query($qrysl,array());
			$resultsetsl=$resultsl->toArray();
          }
          else
          {
          	// customer login get stock serial numbers

			$qryidSerialno="SELECT serialno FROM `product_stock_serialno` WHERE idWhStockItem='$idWhItem'  AND idProduct='$proid' AND idProductsize='$sizeid'";

			$resultidSerialno=$this->adapter->query($qryidSerialno,array());
			$resultsetidSerialno=$resultidSerialno->toArray();

			$resultsetsl=$resultsetidSerialno;

			//$idSerialnos=explode("|",$resultsetidSerialno[0]['idSerialno']);

			/*for ($i=0; $i < count($idSerialnos); $i++) 
			{ 
				$qrysl="SELECT serialno FROM `product_stock_serialno` WHERE idProductserialno='".$idSerialnos[$i]."' ";

				$resultsl=$this->adapter->query($qrysl,array());
				$slnos=$resultsl->toArray();
				$resultsetsl[]=$slnos[0];
			}*/

          }
    

			if(!$resultsetsl) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultsetsl,'status'=>true,'message'=>'Record available'];

			}
		}else if($param->action=='returnserial'){

			$warid=$param->warid;
			$proid=$param->proid;
			$sizeid=$param->sizeid;
			$mfdate=$param->mfdate;
			$batch_no=$param->batch_no;
			$datatype=$param->datatype;
			$orderid=$param->orderid;
		$userData=$param->userData;

			$qry="SELECT idOrderallocate FROM `orders_allocated` WHERE idOrder='$orderid'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();

			$allocateid=$resultset[0]['idOrderallocate'];

			$qryorder="SELECT idOrderallocateditems FROM `orders_allocated_items` WHERE idOrderallocated='$allocateid' AND idProduct='$proid' AND idProductsize='$sizeid'";
			
			$resultorder=$this->adapter->query($qryorder,array());
			$resultsetorder=$resultorder->toArray();
				
		
				$orderallocatedid= $resultsetorder[0]['idOrderallocateditems'];
				$qryidslno="SELECT dpb.idDispatchProductBatch,wsi.idWhStockItem,cor.idSrialno FROM `whouse_stock_items` as wsi 
LEFT JOIN dispatch_product_batch as dpb ON dpb.idWhStockItem=wsi.idWhStockItem 
LEFT JOIN customer_order_return as cor ON cor.idDispatchProductBatch=dpb.idDispatchProductBatch
WHERE `sku_batch_no`='$batch_no' AND idCustomer='".$userData['idCustomer']."' AND idLevel='".$userData['idLevel']."' ";
		
			$resultidslno=$this->adapter->query($qryidslno,array());
			$resultsetidslno=$resultidslno->toArray();
        $slidnos=($resultsetidslno[0]['idSrialno']!='')?explode('|',$resultsetidslno[0]['idSrialno']):'';

         for ($i=0; $i < count($slidnos); $i++) 
         { 
         	
         	$qrysl="SELECT serialno FROM `product_stock_serialno` WHERE  idProductserialno='".$slidnos[$i]."' ";
		
			$resultsl=$this->adapter->query($qrysl,array());
			$resslno=$resultsl->toArray();
			$resultsetsl[]=$resslno[0];
			
         }
			// $qrysl="SELECT serialno FROM `product_stock_serialno` WHERE idOrderallocateditems='$orderallocatedid' and status=3 ";
		
			// $resultsl=$this->adapter->query($qrysl,array());
			// $resultsetsl=$resultsl->toArray();

			if(!$resultsetsl) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultsetsl,'status'=>true,'message'=>'Record available'];

			}
		}else if($param->action=='replaceSerial'){

			$warid=$param->warid;
			$proid=$param->proid;
			$sizeid=$param->sizeid;
			$mfdate=$param->mfdate;
			$batch_no=$param->batch_no;
			$datatype=$param->datatype;
			$orderid=$param->orderid;
		$userData=$param->userData;

			$qry="SELECT idOrderallocate FROM `orders_allocated` WHERE idOrder='$orderid'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();

			$allocateid=$resultset[0]['idOrderallocate'];

			$qryorder="SELECT idOrderallocateditems FROM `orders_allocated_items` WHERE idOrderallocated='$allocateid' AND idProduct='$proid' AND idProductsize='$sizeid'";
			
			$resultorder=$this->adapter->query($qryorder,array());
			$resultsetorder=$resultorder->toArray();
				
		
				$orderallocatedid= $resultsetorder[0]['idOrderallocateditems'];
				$qryidslno="SELECT dpb.idDispatchProductBatch,wsi.idWhStockItem,cor.idSrialno FROM `whouse_stock_items` as wsi 
			LEFT JOIN dispatch_product_batch as dpb ON dpb.idWhStockItem=wsi.idWhStockItem 
			LEFT JOIN customer_order_replacement as cor ON cor.idDispatchProductBatch=dpb.idDispatchProductBatch
			WHERE `sku_batch_no`='$batch_no' AND idCustomer='".$userData['idCustomer']."' AND idLevel='".$userData['idLevel']."' ";
		
			$resultidslno=$this->adapter->query($qryidslno,array());
			$resultsetidslno=$resultidslno->toArray();
        $slidnos=($resultsetidslno[0]['idSrialno']!='')?explode('|',$resultsetidslno[0]['idSrialno']):'';

         for ($i=0; $i < count($slidnos); $i++) 
         { 
         	
         	$qrysl="SELECT serialno FROM `product_stock_serialno` WHERE  idProductserialno='".$slidnos[$i]."' ";
		
			$resultsl=$this->adapter->query($qrysl,array());
			$resslno=$resultsl->toArray();
			$resultsetsl[]=$resslno[0];
			
         }
			// $qrysl="SELECT serialno FROM `product_stock_serialno` WHERE idOrderallocateditems='$orderallocatedid' and status=3 ";
		
			// $resultsl=$this->adapter->query($qrysl,array());
			// $resultsetsl=$resultsl->toArray();

			if(!$resultsetsl) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultsetsl,'status'=>true,'message'=>'Record available'];

			}
		}else if($param->action=='dispatchserial'){

			$warid=$param->warid;
			$proid=$param->proid;
			$sizeid=$param->sizeid;
			$mfdate=$param->mfdate;
			$batch_no=$param->batch_no;
			$datatype=$param->datatype;
			$orderid=$param->orderid;
			$idWhStockItem=$param->idWhItem;

$qryidSerialno="SELECT idSerialno FROM `order_picklist_items` WHERE idWhStockItem in(SELECT idWhStockItem FROM `whouse_stock_items` WHERE idWarehouse='$warid' AND sku_batch_no='$batch_no') AND idOrder='$orderid' AND idProduct='$proid' AND idProdSize='$sizeid'";
$resultidSerialno=$this->adapter->query($qryidSerialno,array());
$resultsetidSerialno=$resultidSerialno->toArray();
$idSerialnos=explode("|",$resultsetidSerialno[0]['idSerialno']);
for ($i=0; $i < count($idSerialnos); $i++) 
{ 
	$qrysl="SELECT serialno FROM `product_stock_serialno` WHERE idProductserialno='".$idSerialnos[$i]."' ";
		
			$resultsl=$this->adapter->query($qrysl,array());
			$resultsetsl=$resultsl->toArray();
			$slnos[]=$resultsetsl[0];
}
            //old qry from vaithi
			$qry="SELECT idOrderallocate FROM `orders_allocated` WHERE idOrder='$orderid'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
				

			$allocateid=$resultset[0]['idOrderallocate'];

			$qryorder="SELECT idOrderallocateditems FROM `orders_allocated_items` WHERE idOrderallocated='$allocateid' AND idProduct='$proid' AND idProductsize='$sizeid'";
			
			$resultorder=$this->adapter->query($qryorder,array());
			$resultsetorder=$resultorder->toArray();
				
		
				$orderallocatedid= $resultsetorder[0]['idOrderallocateditems'];

			$qrypick="SELECT idSerialno FROM `order_picklist_items` WHERE idOrder='$orderid' AND idWhStockItem='$idWhStockItem' ";
			
		
			$resultslpick=$this->adapter->query($qrypick,array());
			$resultsetslpick=$resultslpick->toArray();
			

/*			$qryidslno="SELECT dpb.idDispatchProductBatch,wsi.idWhStockItem,cor.idSrialno FROM `whouse_stock_items` as wsi 
LEFT JOIN dispatch_product_batch as dpb ON dpb.idWhStockItem=wsi.idWhStockItem 
LEFT JOIN customer_order_return as cor ON cor.idDispatchProductBatch=dpb.idDispatchProductBatch
WHERE `sku_batch_no`='$batch_no' AND idCustomer='".$userData['idCustomer']."' AND idLevel='".$userData['idLevel']."' ";
		
			$resultidslno=$this->adapter->query($qryidslno,array());
			$resultsetidslno=$resultidslno->toArray();*/


        $slidnos=($resultsetslpick[0]['idSerialno']!='')?explode('|',$resultsetslpick[0]['idSerialno']):'';

         for ($i=0; $i < count($slidnos); $i++) 
         { 
         	
         	
         	$qrysl="SELECT serialno FROM `product_stock_serialno` WHERE  idProductserialno='".$slidnos[$i]."' ";
         	
			$resultsl=$this->adapter->query($qrysl,array());
			$resslno=$resultsl->toArray();
			$resultsetsl_no[]=$resslno[0];
			
         }

		
			if(!$resultsetsl_no) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultsetsl_no,'slno'=>$slnos,'status'=>true,'message'=>'Record available'];

			}
		}
		else if($param->action=='Warehousedamageserial'){

			$dmgid=$param->dmgid;

				$qry="SELECT idProductserialno FROM `whouse_stock_damge` WHERE idDamage='$dmgid'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();

			$serialids=explode(',',$resultset[0]['idProductserialno']);

         for ($i=0; $i < count($serialids); $i++) 
         { 
         	
         	$qrysl="SELECT serialno FROM `product_stock_serialno` WHERE  idProductserialno='".$serialids[$i]."' ";
		
			$resultsl=$this->adapter->query($qrysl,array());
			$resslno=$resultsl->toArray();
			$resultsetsl[]=$resslno[0];
			
         }


			
			if(!$resultsetsl) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultsetsl,'status'=>true,'message'=>'Record available'];

			}
		}
		else if($param->action=='damageserial'){

			$dmgid=$param->dmgid;
			$qry="SELECT idSerialno FROM `customer_order_damges` WHERE idCustOrderDmgsRtn='$dmgid'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();

			$slidnos=explode(',',$resultset[0]['idSerialno']);
		
			
         for ($i=0; $i < count($slidnos); $i++) 
         { 
         	
         	$qrysl="SELECT serialno FROM `product_stock_serialno` WHERE  idProductserialno='".$slidnos[$i]."' ";
		
			$resultsl=$this->adapter->query($qrysl,array());
			$resslno=$resultsl->toArray();
			$resultsetsl[]=$resslno[0];
			
         }
			if(!$resultsetsl) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultsetsl,'status'=>true,'message'=>'Record available'];

			}
		}
		else if($param->action=="returnCusserial")
		{
           
            $idWarehouse=$param->warid;
            $idProduct=$param->proid;
            $idProductzise=$param->sizeid;
            $batch_no=$param->batch_no;
            $mfdate=$param->mfdate;
            $userData=$param->userData;
            $orderid=$param->orderid;
            $qrySLID="SELECT dpb.idDispatchProductBatch,dc.idDispatchcustomer,cor.idSrialno FROM `dispatch_customer` as dc 
            LEFT JOIN dispatch_product as dp ON dc.idDispatchcustomer=dp.idDispatchcustomer 
            LEFT JOIN dispatch_product_batch as dpb ON dpb.idDispatchProduct=dp.idDispatchProduct
            LEFT JOIN customer_order_return as cor ON cor.idDispatchProductBatch=dpb.idDispatchProductBatch
            WHERE dc.idOrder='$orderid' AND dc.idCustomer='".$userData['idCustomer']."' AND dp.idProduct='$idProduct' AND dp.idProdSize='$idProductzise'";
            $resultSLID=$this->adapter->query($qrySLID,array());
            $resultsetSLID=$resultSLID->toArray();
            $SLID=($resultsetSLID)?explode('|',$resultsetSLID[0]['idSrialno']):'';
           
            
            for ($i=0; $i < count($SLID); $i++) 
            { 
            	
            		$qry="SELECT idProductserialno,serialno FROM `product_stock_serialno` WHERE idProductserialno='".$SLID[$i]."'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			$data[]=$resultset[0];			

            }
          
            if (count($data)>0) 
            {
            	$ret_arr=['code'=>'2','content'=>$data,'status'=>true,'message'=>'Record available'];
            }
            else
            {
            	$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found'];
            }
            
		}
		return $ret_arr;
	}

	public function stockregisterproduct($param) {
		//print_r($param);exit;
	


		if($param->action=='productdetails'){
			$userData=$param->userData;
			$userid=$userData['user_id'];
			$usertype=$userData['user_type'];
			$idCustomer=$userData['idCustomer'];
			

			$qry="SELECT P.idProduct, P.productName, P.productUnit, PS.idProductsize, PS.productSize, PT.primarypackname, 0 as ttlqty,P.productCount,PS.productPrimaryCount from product_details as P LEFT JOIN product_size as PS ON PS.idProduct=P.idProduct LEFT JOIN primary_packaging as PT ON PT.idPrimaryPackaging=PS.idPrimaryPackaging where P.status=1 AND PS.status=1 order by P.productName, PS.productSize asc";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();

			
			for ($i=0; $i < count($resultset); $i++) { 
				$prodId=$resultset[$i]['idProduct'];
				$sizId=$resultset[$i]['idProductsize'];
				$primarycount=$resultset[$i]['productPrimaryCount'];
				$dataArray = array();
	$stockEntry="SELECT 'stockEntry' as dataType, WHSI.sku_accept_qty as proQty, WHSI.sku_entry_date as entryDate, WHS.po_no as PORefernce, WHS.grn_no as DocRefernce 
							from whouse_stock_items as 
							WHSI LEFT JOIN whouse_stock as WHS ON WHS.idWhStock=WHSI.idWhStock 
							where WHSI.idProduct='$prodId' and WHSI.idProdSize='$sizId' and WHSI.idWarehouse IN (SELECT idWarehouse from warehouse_master where idCustomer='$idCustomer')";
	$resultstockEntry=$this->adapter->query($stockEntry,array());
	$resultsetstockEntry=$resultstockEntry->toArray();
	if(0<count($resultsetstockEntry)){
		foreach($resultsetstockEntry AS $var){
			array_push($dataArray,$var);
		}
	}
	$qrycus="SELECT COR.rtnQty as proQty,DC.idCustomer,DC.idWarehouse from customer_order_return as COR
	LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer  where DC.idCustomer='$idCustomer'";

	$resultcus=$this->adapter->query($qrycus,array());
	$resultsetcus=$resultcus->toArray();
	$Customer=$resultsetcus[0]['idCustomer'];
	$war=$resultsetcus[0]['idWarehouse'];
	if($Customer){

		$cstReturnQty="SELECT 'returncustomer' as dataType,COR.rtnQty as proQty, COR.rtnDate as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce 
							  from customer_order_return as COR
							  LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
							  LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
							  LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
							  LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
							   where WHSI.idProduct='$prodId' and WHSI.idProdSize='$sizId' and WHSI.idWarehouse='$war'";
							  
		$ReceiveQty="SELECT 'receive' as dataType, COR.rtnQty as proQty, COR.rtnDate as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce 
							  from customer_order_return as COR
							  LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
							  LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
							  LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
							  LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
							  where WHSI.idProduct='$prodId' and WHSI.idProdSize='$sizId' and WHSI.idWarehouse IN (SELECT idWarehouse from warehouse_master where idCustomer='$idCustomer')";	
		$resultcstReceiveQty=$this->adapter->query($ReceiveQty,array());
		$resultsetcstReceiveQty=$resultcstReceiveQty->toArray();
		
	}
	else{

	$cstReturnQty="SELECT 'return' as dataType, COR.rtnQty as proQty, COR.rtnDate as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce 
							  from customer_order_return as COR
							  LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
							  LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
							  LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
							  LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
							  where WHSI.idProduct='$prodId' and WHSI.idProdSize='$sizId' and WHSI.idWarehouse IN (SELECT idWarehouse from warehouse_master where idCustomer='$idCustomer')";
}
	$resultcstReturnQty=$this->adapter->query($cstReturnQty,array());
	$resultsetcstReturnQty=$resultcstReturnQty->toArray();
	if(0<count($resultsetcstReturnQty)){
		foreach($resultsetcstReturnQty AS $var){
			array_push($dataArray,$var);
		}
	}
	if(0<count($resultsetcstReceiveQty)){
		foreach($resultsetcstReceiveQty AS $var){
			array_push($dataArray,$var);
		}
	}
	$dispatchQty="SELECT 'dispatch' as dataType, DPB.qty as proQty, DV.deliveryDate as entryDate, O.poNumber as PORefernce, DC.invoiceNo as DocRefernce 
						 from dispatch_product_batch as DPB 
						 LEFT JOIN dispatch_product as DP ON DP.idDispatchProduct=DPB.idDispatchProduct 
						 LEFT JOIN dispatch_customer as DC ON DC.idDispatchcustomer=DP.idDispatchcustomer 
						 LEFT JOIN dispatch_vehicle as DV ON DV.idDispatchVehicle=DC.idDispatchVehicle 
						 LEFT JOIN orders as O ON O.idOrder=DC.idOrder 
						 LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
						 where WHSI.idProduct='$prodId' and WHSI.idProdSize='$sizId' and WHSI.idWarehouse IN (SELECT idWarehouse from warehouse_master where idCustomer='$idCustomer')";
	$resultdispatchQty=$this->adapter->query($dispatchQty,array());
	$resultsetdispatchQty=$resultdispatchQty->toArray();
	if(0<count($resultsetdispatchQty)){
		foreach($resultsetdispatchQty AS $var)
		{
		array_push($dataArray,$var);
		}
	}
	$cstReplcMnt="SELECT 'replace' as dataType, COR.replaceQty as proQty, COR.replaceDate as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce 
							  from customer_order_replacement as COR
							  LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
							  LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
							  LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
							  LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
							  where WHSI.idProduct='$prodId' and WHSI.idProdSize='$sizId' and WHSI.idWarehouse IN (SELECT idWarehouse from warehouse_master where idCustomer='$idCustomer')";
	$resultcstReplcMnt=$this->adapter->query($cstReplcMnt,array());
	$resultsetcstReplcMnt=$resultcstReplcMnt->toArray();
	if(0<count($resultsetcstReplcMnt)){
		foreach($resultsetcstReplcMnt AS $var){
			array_push($dataArray,$var);
		}
	}
	$cstMisng="SELECT 'missing' as dataType, COR.missing_qty as proQty, COR.missing_entry_date as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce 
							  from customer_order_missing as COR
							  LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
							  LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
							  LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
							  LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
							  where WHSI.idProduct='$prodId' and WHSI.idProdSize='$sizId' and WHSI.idWarehouse IN (SELECT idWarehouse from warehouse_master where idCustomer='$idCustomer')";
	$resultcstMisng=$this->adapter->query($cstMisng,array());
	$resultsetcstMisng=$resultcstMisng->toArray();
	if(0<count($resultsetcstMisng)){
		foreach($resultsetcstMisng AS $var){
			array_push($dataArray,$var);
		}
	}
	$stkDmg="SELECT 'stockdmg' as dataType, WHSD.dmg_prod_qty as proQty, WHSD.dmg_entry_date as entryDate, WHS.po_no as PORefernce, WHS.grn_no as DocRefernce 
						from whouse_stock_damge as WHSD 
						LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=WHSD.idWhStockItem 
						LEFT JOIN whouse_stock as WHS ON WHSI.idWhStock=WHS.idWhStock 
						where WHSD.idProduct='$prodId' and WHSD.idProdSize='$sizId' and WHSD.idWarehouse IN (SELECT idWarehouse from warehouse_master where idCustomer='$idCustomer')";
	$resultstkDmg=$this->adapter->query($stkDmg,array());
	$resultsetstkDmg=$resultstkDmg->toArray();
	
	if(0<count($resultsetstkDmg)){
		foreach($resultsetstkDmg AS $var)
		{
		array_push($dataArray,$var);
		}
	}

	if ($usertype!=0) {
		$cstDmg="SELECT 'damage' as dataType, COR.dmgQty as proQty, COR.dmgRtnDate as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce 
							  from customer_order_damges as COR
							  LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
							  LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
							  LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
							  LEFT JOIN orders_allocated as OA ON OA.idOrder=O.idOrder  
							  LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
							  where WHSI.idProduct='$prodId' and WHSI.idProdSize='$sizId' and WHSI.idWarehouse=OA.idWarehouse and DC.idCustomer='$idCustomer'";
	$resultcstDmg=$this->adapter->query($cstDmg,array());
	$resultsetcstDmg=$resultcstDmg->toArray();
	}else{
		$resultsetcstDmg=[];
	}
	
	if(0<count($resultsetcstDmg)){
		foreach($resultsetcstDmg AS $var){
			array_push($dataArray,$var);
		}
	}
	
	$balanceAmt=0;
	
	foreach($dataArray as $val){
		
		if($val["dataType"]=='stockEntry' || $val["dataType"]=='return' || $val["dataType"]=='receive'){
			 $balanceAmt+=number_format($val["proQty"], 2, '.', '');
		}else if($val["dataType"]=='dispatch' || $val["dataType"]=='replace' || $val["dataType"]=='missing'  || $val["dataType"]=='returncustomer'){
			 $balanceAmt-=number_format($val["proQty"], 2, '.', '');
		}else if($val["dataType"]=='stockdmg' || $val["dataType"]=='damage'){
			 $balanceAmt-=number_format($val["proQty"]/$primarycount, 2, '.', '');
		}

	}
	$resultset[$i]['ttlqty']=number_format($balanceAmt, 2, '.', '');

			}



			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];

			}
		}else if($param->action=='prowardetails'){
			$userData=$param->userData;
			$userid=$userData['user_id'];
			$usertype=$userData['user_type'];
			$idCustomer=$userData['idCustomer'];
			$prodId=$param->proid;
			$sizId=$param->sizeid;
			$qrypoqty="SELECT t1.idWarehouse,t1.warehouseName,0 as qty ,0 as idProduct,0 as idProdSize FROM warehouse_master as t1 WHERE t1.idCustomer='$idCustomer' AND t1.status='1'";
			$resultpoqty=$this->adapter->query($qrypoqty,array());
			$resultset=$resultpoqty->toArray();
		

			
			for ($i=0; $i < count($resultset); $i++) { 
				$idWarehouse=$resultset[$i]['idWarehouse'];
				$dataArray = array();
	$stockEntry="SELECT 'stockEntry' as dataType, WHSI.sku_accept_qty as proQty, WHSI.sku_entry_date as entryDate, WHS.po_no as PORefernce, WHS.grn_no as DocRefernce 
							from whouse_stock_items as 
							WHSI LEFT JOIN whouse_stock as WHS ON WHS.idWhStock=WHSI.idWhStock 
							where WHSI.idProduct='$prodId' and WHSI.idProdSize='$sizId' and WHSI.idWarehouse='$idWarehouse'";
	$resultstockEntry=$this->adapter->query($stockEntry,array());
	$resultsetstockEntry=$resultstockEntry->toArray();
	if(0<count($resultsetstockEntry)){
		foreach($resultsetstockEntry AS $var){
			array_push($dataArray,$var);
		}
	}
	$qrycus="SELECT COR.rtnQty as proQty,DC.idCustomer,DC.idWarehouse from customer_order_return as COR
	LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer  where DC.idCustomer='$idCustomer'";

	$resultcus=$this->adapter->query($qrycus,array());
	$resultsetcus=$resultcus->toArray();
	$Customer=$resultsetcus[0]['idCustomer'];
	$war=$resultsetcus[0]['idWarehouse'];
	if($Customer){
		$cstReturnQty="SELECT 'returncustomer' as dataType,COR.rtnQty as proQty, COR.rtnDate as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce 
							  from customer_order_return as COR
							  LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
							  LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
							  LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
							  LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
							   where WHSI.idProduct='$prodId' and WHSI.idProdSize='$sizId' and WHSI.idWarehouse='$war'";
							 
		$ReceiveQty="SELECT 'receive' as dataType, COR.rtnQty as proQty, COR.rtnDate as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce 
							  from customer_order_return as COR
							  LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
							  LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
							  LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
							  LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
							  where WHSI.idProduct='$prodId' and WHSI.idProdSize='$sizId' and WHSI.idWarehouse='$idWarehouse'";	
	$resultcstReceiveQty=$this->adapter->query($ReceiveQty,array());
	$resultsetcstReceiveQty=$resultcstReceiveQty->toArray();
							  				   
	}else{
	$cstReturnQty="SELECT 'return' as dataType, COR.rtnQty as proQty, COR.rtnDate as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce 
							  from customer_order_return as COR
							  LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
							  LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
							  LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
							  LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
							  where WHSI.idProduct='$prodId' and WHSI.idProdSize='$sizId' and WHSI.idWarehouse='$idWarehouse'";
							}
	$resultcstReturnQty=$this->adapter->query($cstReturnQty,array());
	$resultsetcstReturnQty=$resultcstReturnQty->toArray();
	if(0<count($resultsetcstReturnQty)){
		foreach($resultsetcstReturnQty AS $var){
			array_push($dataArray,$var);
		}
	}
	if(0<count($resultsetcstReceiveQty)){
		foreach($resultsetcstReceiveQty AS $var){
			array_push($dataArray,$var);
		}
	}
	$dispatchQty="SELECT 'dispatch' as dataType, DPB.qty as proQty, DV.deliveryDate as entryDate, O.poNumber as PORefernce, DC.invoiceNo as DocRefernce 
						 from dispatch_product_batch as DPB 
						 LEFT JOIN dispatch_product as DP ON DP.idDispatchProduct=DPB.idDispatchProduct 
						 LEFT JOIN dispatch_customer as DC ON DC.idDispatchcustomer=DP.idDispatchcustomer 
						 LEFT JOIN dispatch_vehicle as DV ON DV.idDispatchVehicle=DC.idDispatchVehicle 
						 LEFT JOIN orders as O ON O.idOrder=DC.idOrder 
						 LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
						 where WHSI.idProduct='$prodId' and WHSI.idProdSize='$sizId' and WHSI.idWarehouse='$idWarehouse'";
	$resultdispatchQty=$this->adapter->query($dispatchQty,array());
	$resultsetdispatchQty=$resultdispatchQty->toArray();
	if(0<count($resultsetdispatchQty)){
		foreach($resultsetdispatchQty AS $var)
		{
		array_push($dataArray,$var);
		}
	}
	$cstReplcMnt="SELECT 'replace' as dataType, COR.replaceQty as proQty, COR.replaceDate as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce 
							  from customer_order_replacement as COR
							  LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
							  LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
							  LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
							  LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
							  where WHSI.idProduct='$prodId' and WHSI.idProdSize='$sizId' and WHSI.idWarehouse='$idWarehouse'";
	$resultcstReplcMnt=$this->adapter->query($cstReplcMnt,array());
	$resultsetcstReplcMnt=$resultcstReplcMnt->toArray();
	if(0<count($resultsetcstReplcMnt)){
		foreach($resultsetcstReplcMnt AS $var){
			array_push($dataArray,$var);
		}
	}
	$cstMisng="SELECT 'missing' as dataType, COR.missing_qty as proQty, COR.missing_entry_date as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce 
							  from customer_order_missing as COR
							  LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
							  LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
							  LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
							  LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
							  where WHSI.idProduct='$prodId' and WHSI.idProdSize='$sizId' and WHSI.idWarehouse='$idWarehouse'";
	$resultcstMisng=$this->adapter->query($cstMisng,array());
	$resultsetcstMisng=$resultcstMisng->toArray();
	if(0<count($resultsetcstMisng)){
		foreach($resultsetcstMisng AS $var){
			array_push($dataArray,$var);
		}
	}
	$stkDmg="SELECT 'stockdmg' as dataType, WHSD.dmg_prod_qty as proQty, WHSD.dmg_entry_date as entryDate,PS.productPrimaryCount, WHS.po_no as PORefernce, WHS.grn_no as DocRefernce 
		 		from whouse_stock_damge as WHSD 
		 		LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=WHSD.idWhStockItem 
		 		LEFT JOIN whouse_stock as WHS ON WHSI.idWhStock=WHS.idWhStock 
                LEFT JOIN  product_size as PS ON PS.idProductsize=WHSD.idProdSize  
						where WHSD.idProduct='$prodId' and WHSD.idProdSize='$sizId' and WHSD.idWarehouse='$idWarehouse'";
	$resultstkDmg=$this->adapter->query($stkDmg,array());
	$resultsetstkDmg=$resultstkDmg->toArray();
	$primarycount=$resultsetstkDmg[0]['productPrimaryCount'];

	if(0<count($resultsetstkDmg)){
		foreach($resultsetstkDmg AS $var)
		{
		array_push($dataArray,$var);
		}
	}
	if ($usertype!=0) {
		$cstDmg="SELECT 'damage' as dataType, COR.dmgQty as proQty,COR.idDispatchProductBatch ,PS.productPrimaryCount,COR.dmgRtnDate as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce 
		 		from customer_order_damges as COR
		 		LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
		 		LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
                LEFT JOIN dispatch_product as DP ON DP.idDispatchProduct=DPB.idDispatchProduct 
                LEFT JOIN  product_size as PS ON PS.idProductsize=DP.idProdSize 
		 		LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
		 		LEFT JOIN orders_allocated as OA ON OA.idOrder=O.idOrder  
		 		LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
							  where WHSI.idProduct='$prodId' and WHSI.idProdSize='$sizId' and WHSI.idWarehouse=OA.idWarehouse and DC.idCustomer='$idCustomer'";
	$resultcstDmg=$this->adapter->query($cstDmg,array());
	$resultsetcstDmg=$resultcstDmg->toArray();
	$primarycount=$resultsetcstDmg[0]['productPrimaryCount'];
	}else{
	$resultsetcstDmg=[];	
	}
	if(0<count($resultsetcstDmg)){
		foreach($resultsetcstDmg AS $var){
			array_push($dataArray,$var);
		}
	}
	
	$balanceAmt=0;
	
	foreach($dataArray as $val){
		
		if($val["dataType"]=='stockEntry' || $val["dataType"]=='return'|| $val["dataType"]=='receive'){
			 $balanceAmt+=number_format($val["proQty"], 2, '.', '');
		}else if($val["dataType"]=='dispatch' || $val["dataType"]=='replace' || $val["dataType"]=='missing'  || $val["dataType"]=='returncustomer'){
			 $balanceAmt-=number_format($val["proQty"], 2, '.', '');
		}else if($val["dataType"]=='stockdmg' || $val["dataType"]=='damage'){
			 $balanceAmt-=number_format($val["proQty"]/$val["productPrimaryCount"], 2, '.', '');
		}

	}
	$resultset[$i]['qty']=number_format($balanceAmt, 2, '.', '');;
	$resultset[$i]['idProduct']=$prodId;
	$resultset[$i]['idProdSize']=$sizId;

			}
			//print_r($resultset);
		
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];

			}
		}
		else if($param->action=='proMRdetails'){
			
			$warid=$param->warid;
			$proid=$param->proid;
			$sizeid=$param->sizeid;
			$userData=$param->userData;
			$userid=$userData['user_id'];
			$usertype=$userData['user_type'];
			$idCustomer=$userData['idCustomer'];
			
			$qrypoqty="SELECT DATE_FORMAT(sku_mf_date, '%d-%m-%Y') as sku_mf_date, 
			DATE_FORMAT(sku_expiry_date, '%d-%m-%Y') as sku_expiry_date, 
			sum(sku_accept_qty) as stckQty, 
			sku_batch_no ,
			idWarehouse,
			idProduct,
			idProdSize,
			0 as qty,
			idWhStockItem
			from whouse_stock_items 
			where idProduct='$proid' and idProdSize='$sizeid' and idWarehouse='$warid' 
			group by sku_mf_date order by sku_mf_date asc";
			
			$resultpoqty=$this->adapter->query($qrypoqty,array());
			$resultset=$resultpoqty->toArray();
			//print_r($resultset);

			for ($i=0; $i < count($resultset); $i++) { 
				$prodId=$resultset[$i]['idProduct'];
				$sizId=$resultset[$i]['idProdSize'];
				$warehseId=$resultset[$i]['idWarehouse'];
				$mfDate=$resultset[$i]['sku_mf_date'];
				$dataArray = array();
	$stockEntry="SELECT 'stockEntry' as dataType, WHSI.sku_accept_qty as proQty, WHSI.sku_entry_date as entryDate, WHS.po_no as PORefernce, WHS.grn_no as DocRefernce 
							from whouse_stock_items as 
							WHSI LEFT JOIN whouse_stock as WHS ON WHS.idWhStock=WHSI.idWhStock 
							where WHSI.idProduct='".$prodId."' and WHSI.idProdSize='".$sizId."' and WHSI.idWarehouse='".$warehseId."' and WHSI.sku_mf_date='".date("Y-m-d", strtotime($mfDate))."'";
	$resultstockEntry=$this->adapter->query($stockEntry,array());
	$resultsetstockEntry=$resultstockEntry->toArray();
	if(0<count($resultsetstockEntry)){
		foreach($resultsetstockEntry AS $var){
			array_push($dataArray,$var);
		}
	}
	$qrycus="SELECT COR.rtnQty as proQty,DC.idCustomer,DC.idWarehouse from customer_order_return as COR
	LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer  where DC.idCustomer='$idCustomer'";

	$resultcus=$this->adapter->query($qrycus,array());
	$resultsetcus=$resultcus->toArray();
	$Customer=$resultsetcus[0]['idCustomer'];
	$war=$resultsetcus[0]['idWarehouse'];
	if($Customer){
		$cstReturnQty="SELECT 'returncustomer' as dataType,COR.rtnQty as proQty, COR.rtnDate as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce 
							  from customer_order_return as COR
							  LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
							  LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
							  LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
							  LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
							  where WHSI.idProduct='".$prodId."' and WHSI.idProdSize='".$sizId."' and WHSI.idWarehouse='$war' and WHSI.sku_mf_date='".date("Y-m-d", strtotime($mfDate))."'";
		$ReceiveQty="SELECT 'receive' as dataType,  COR.rtnQty as proQty, COR.rtnDate as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce 
							  from customer_order_return as COR
							  LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
							  LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
							  LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
							  LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
							  where WHSI.idProduct='".$prodId."' and WHSI.idProdSize='".$sizId."' and WHSI.idWarehouse='".$warehseId."' and WHSI.sku_mf_date='".date("Y-m-d", strtotime($mfDate))."'";	
		$resultcstReceiveQty=$this->adapter->query($ReceiveQty,array());
		$resultsetcstReceiveQty=$resultcstReceiveQty->toArray();
	}else{
	$cstReturnQty="SELECT 'return' as dataType, COR.rtnQty as proQty, COR.rtnDate as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce 
							  from customer_order_return as COR
							  LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
							  LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
							  LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
							  LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
							  where WHSI.idProduct='".$prodId."' and WHSI.idProdSize='".$sizId."' and WHSI.idWarehouse='".$warehseId."' and WHSI.sku_mf_date='".date("Y-m-d", strtotime($mfDate))."'";
							}
	$resultcstReturnQty=$this->adapter->query($cstReturnQty,array());
	$resultsetcstReturnQty=$resultcstReturnQty->toArray();
	if(0<count($resultsetcstReturnQty)){
		foreach($resultsetcstReturnQty AS $var){
			array_push($dataArray,$var);
		}
	}
	if(0<count($resultsetcstReceiveQty)){
		foreach($resultsetcstReceiveQty AS $var){
			array_push($dataArray,$var);
		}
	}
	$dispatchQty="SELECT 'dispatch' as dataType, DPB.qty as proQty, DV.deliveryDate as entryDate, O.poNumber as PORefernce, DC.invoiceNo as DocRefernce 
						 from dispatch_product_batch as DPB 
						 LEFT JOIN dispatch_product as DP ON DP.idDispatchProduct=DPB.idDispatchProduct 
						 LEFT JOIN dispatch_customer as DC ON DC.idDispatchcustomer=DP.idDispatchcustomer 
						 LEFT JOIN dispatch_vehicle as DV ON DV.idDispatchVehicle=DC.idDispatchVehicle 
						 LEFT JOIN orders as O ON O.idOrder=DC.idOrder 
						 LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
						 where WHSI.idProduct='".$prodId."' and WHSI.idProdSize='".$sizId."' and WHSI.idWarehouse='".$warehseId."' and WHSI.sku_mf_date = '".date("Y-m-d", strtotime($mfDate))."'";
	$resultdispatchQty=$this->adapter->query($dispatchQty,array());
	$resultsetdispatchQty=$resultdispatchQty->toArray();
	if(0<count($resultsetdispatchQty)){
		foreach($resultsetdispatchQty AS $var)
		{
		array_push($dataArray,$var);
		}
	}
	$cstReplcMnt="SELECT 'replace' as dataType, COR.replaceQty as proQty, COR.replaceDate as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce 
							  from customer_order_replacement as COR
							  LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
							  LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
							  LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
							  LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
							  where WHSI.idProduct='".$prodId."' and WHSI.idProdSize='".$sizId."' and WHSI.idWarehouse='".$warehseId."' and WHSI.sku_mf_date='".date("Y-m-d", strtotime($mfDate))."'";
	$resultcstReplcMnt=$this->adapter->query($cstReplcMnt,array());
	$resultsetcstReplcMnt=$resultcstReplcMnt->toArray();
	if(0<count($resultsetcstReplcMnt)){
		foreach($resultsetcstReplcMnt AS $var){
			array_push($dataArray,$var);
		}
	}
	$cstMisng="SELECT 'missing' as dataType, COR.missing_qty as proQty, COR.missing_entry_date as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce 
							  from customer_order_missing as COR
							  LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
							  LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
							  LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
							  LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
							  where WHSI.idProduct='".$prodId."' and WHSI.idProdSize='".$sizId."' and WHSI.idWarehouse='".$warehseId."' and WHSI.sku_mf_date='".date("Y-m-d", strtotime($mfDate))."'";
	$resultcstMisng=$this->adapter->query($cstMisng,array());
	$resultsetcstMisng=$resultcstMisng->toArray();
	if(0<count($resultsetcstMisng)){
		foreach($resultsetcstMisng AS $var){
			array_push($dataArray,$var);
		}
	}
	$stkDmg="SELECT 'stockdmg' as dataType, WHSD.dmg_prod_qty as proQty, WHSD.dmg_entry_date as entryDate,PS.productPrimaryCount, WHS.po_no as PORefernce, WHS.grn_no as DocRefernce 
		 		from whouse_stock_damge as WHSD 
		 		LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=WHSD.idWhStockItem 
		 		LEFT JOIN whouse_stock as WHS ON WHSI.idWhStock=WHS.idWhStock 
                LEFT JOIN  product_size as PS ON PS.idProductsize=WHSD.idProdSize 
						where WHSD.idProduct='".$prodId."' and WHSD.idProdSize='".$sizId."' and WHSD.idWarehouse='".$warehseId."' and WHSI.sku_mf_date ='".date("Y-m-d", strtotime($mfDate))."'";
	$resultstkDmg=$this->adapter->query($stkDmg,array());
	$resultsetstkDmg=$resultstkDmg->toArray();
	$primarycount=$resultsetstkDmg[0]['productPrimaryCount'];

	if(0<count($resultsetstkDmg)){
		foreach($resultsetstkDmg AS $var)
		{
		array_push($dataArray,$var);
		}
	}
	if ($usertype!=0) {
	$cstDmg="SELECT 'damage' as dataType, COR.dmgQty as proQty,COR.idDispatchProductBatch ,PS.productPrimaryCount,COR.dmgRtnDate as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce 
		 		from customer_order_damges as COR
		 		LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
		 		LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
                LEFT JOIN dispatch_product as DP ON DP.idDispatchProduct=DPB.idDispatchProduct 
                LEFT JOIN  product_size as PS ON PS.idProductsize=DP.idProdSize 
		 		LEFT JOIN orders as O ON DC.idOrder=O.idOrder 
		 		LEFT JOIN orders_allocated as OA ON OA.idOrder=O.idOrder   
		 		LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
							  where WHSI.idProduct='".$prodId."' AND WHSI.idProdSize='".$sizId."' AND WHSI.idWarehouse=OA.idWarehouse AND WHSI.sku_mf_date='".date("Y-m-d", strtotime($mfDate))."'  and DC.idCustomer='$idCustomer'";
							  
	$resultcstDmg=$this->adapter->query($cstDmg,array());
	$resultsetcstDmg=$resultcstDmg->toArray();
	$primarycount=$resultsetcstDmg[0]['productPrimaryCount'];
	}else{
		$resultsetcstDmg=[];
	}
	if(0<count($resultsetcstDmg)){
		foreach($resultsetcstDmg AS $var){
			array_push($dataArray,$var);
		}
	}
	
	$balanceAmt=0;
	
	foreach($dataArray as $val){
		 if($val["dataType"]=='stockEntry' || $val["dataType"]=='return'|| $val["dataType"]=='receive'){
			 $balanceAmt+=number_format($val["proQty"], 2, '.', '');
		}else if($val["dataType"]=='dispatch' || $val["dataType"]=='replace' || $val["dataType"]=='missing' || $val["dataType"]=='returncustomer'){
			 $balanceAmt-=number_format($val["proQty"], 2, '.', '');
		}else if($val["dataType"]=='stockdmg' || $val["dataType"]=='damage'){
			 $balanceAmt-=number_format($val["proQty"]/$val["productPrimaryCount"], 2, '.', '');
		}
	
	}
	$resultset[$i]['qty']=number_format($balanceAmt, 2, '.', '');

			}
			//print_r($resultset);
		
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];

			}
		}
		return $ret_arr;
	}

	public function serialnoAccept($param)
	{
      $idWHStock=$param->warid;
      if($param->action=="getSerialno")
      {
      	
      	$qryORD="SELECT ord.idOrder FROM `whouse_stock`as ws 
      	 LEFT JOIN orders as ord ON ord.poNumber=ws.po_no 
      	  WHERE ws.idWhStock='$idWHStock'";	
		$resultORD=$this->adapter->query($qryORD,array());
		$resultsetORD=$resultORD->toArray();

		$ordid=$resultsetORD[0]['idOrder'];
        
        $qrySerailno="SELECT PS.*,WHS.sku_batch_no from product_stock_serialno AS PS
        	LEFT JOIN whouse_stock_items AS WHS ON WHS.idWhStockItem=PS.idWhStockItem
        WHERE PS.idOrder='$ordid'";	
		$resultSerailno=$this->adapter->query($qrySerailno,array());
		$resultsetSerailno=$resultSerailno->toArray();
		

		if (count($resultsetSerailno)>0) 
	   {
	   	$ret_arr=['code'=>'2','content'=>$resultsetSerailno,'status'=>true,'message'=>'Record available'];
	   }
	   else
	   {
	    $ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found'];
	   }
      }
      else if($param->action=="add")
      {
        $slno=$param->slno;
        $usertype=$param->userData['user_type'];
        $userid=$param->userData['user_id'];
         $customerid=$param->userData['idCustomer'];
         

        for ($i=0; $i <count($slno) ; $i++) 
        { 
        	
			$qrySerailnoexist="SELECT * from product_stock_serialno WHERE idWhStock='$idWHStock' AND serialno='".$slno[$i]['serialno']."'";	
			$resultSerailnoexist=$this->adapter->query($qrySerailnoexist,array());
			$resultsetSerailnoexist=$resultSerailnoexist->toArray();
		
			$this->adapter->getDriver()->getConnection()->beginTransaction();
			if (count($resultsetSerailnoexist)==0) 
			{
				$proid=$slno[$i]['idProduct'];
				$batchno=$slno[$i]['sku_batch_no'];
				$size=$slno[$i]['idProductsize'];
				$qryWH="SELECT idWhStockItem FROM  whouse_stock_items WHERE idWhStock='".$idWHStock."' AND idProduct='".$proid."' AND idProdSize='".$size."' AND sku_batch_no='".$batchno."'";
			$resultWH=$this->adapter->query($qryWH,array());
			$resultsetWH=$resultWH->toArray();

			    
				try {
					
				
						$datainsert['idWhStock']=$idWHStock;
						$datainsert['idProduct']=$slno[$i]['idProduct'];
						$datainsert['idProductsize']=$slno[$i]['idProductsize'];
						$datainsert['serialno']=$slno[$i]['serialno'];
						$datainsert['idWhStockItem']=$resultsetWH[0]['idWhStockItem']; 
						$datainsert['idCustomer']=$customerid;
						$datainsert['idLevel']=$usertype; 
						$datainsert['created_by']=$userid; 
						$datainsert['created_at']=date('Y-m-d H:i:s');	 
						
						$insert=new Insert('product_stock_serialno');
						$insert->values($datainsert);
						$statement=$this->adapter->createStatement();
						$insert->prepareStatement($this->adapter, $statement);
						$insertresult=$statement->execute();
            

					$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				} catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again...'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				} 
			} //close alreadexist
			else{
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Already exist...'.$e];
				$this->adapter->getDriver()->getConnection()->rollBack();
			}
			
        } //close for loop
        
       
      }
      return $ret_arr;
	}

	public function PJPdefinition($param) {
		if($param->action=='list'){
			$salesshr=$param->salesshr;
			$employee=$param->employee;
			$custype=$param->custype;
			$cycledays=$param->cycledays;
			$startdate=$param->startdate;
			$lastrowdate=array();
			$firstrowdate=array();
			$checkdate=array();
            $chkcount=0;
			for($k=0;$k<$cycledays;$k++)
			{
				$getAddDate=date('d-m-Y', strtotime($startdate.'+1 day'));
				$getAddDay=date('D', strtotime($getAddDate));
				$startdate=date('d-M',strtotime($getAddDate));
				$convertdate=date('Y-m-d', strtotime($startdate));
				
				
				$cmpnyLeave="SELECT * FROM company_leave WHERE leave_date='$convertdate'";
				$resultcmpnyLeave=$this->adapter->query($cmpnyLeave,array());
				$resultsetcmpnyLeave=$resultcmpnyLeave->toArray();

				$empLeave="SELECT * FROM employee_leave WHERE from_date<='$convertdate' AND  to_date>='$convertdate' AND idTeamMember='$employee'";
				$resultempLeave=$this->adapter->query($empLeave,array());
				$resultsetempLeave=$resultempLeave->toArray();
					if(!$resultsetcmpnyLeave && !$resultsetempLeave && $getAddDay!='Sun'){
						array_push($lastrowdate,$getAddDay);				 		
						array_push($firstrowdate,$startdate);
						array_push($checkdate,$getAddDate);
                         $checkbox[$chkcount]['date']=$getAddDate;
                         $checkbox[$chkcount]['status']=0;
						$chkcount++;

					}else{
						$cycledays++;
					}
				} 
			
				$qry="SELECT c.idCustomer,c.cs_name,CL.custType,ST.segmentName,G.geoValue FROM customer as c
						LEFT JOIN customertype as CL ON CL.idCustomerType=c.cs_type
                        LEFT JOIN segment_type as ST ON ST.idsegmentType=c.cs_segment_type
                        LEFT JOIN geography as G ON G.idGeography=c.G3
						where c.sales_hrchy_name='$employee' AND c.cs_type='$custype' AND cs_status=1";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
				for($i=0; $i<count($resultset); $i++){
				$resultset[$i]['checkdate']=$checkbox;
				$cus=$resultset[$i]['idCustomer'];
				$qrycus="SELECT COUNT(idCustomer) as customers FROM customer WHERE cs_serviceby='$cus'";

				$resultcus=$this->adapter->query($qrycus,array());
				$resultsetcus=$resultcus->toArray();
				$resultset[$i]['servicecustomer']=$resultsetcus[0]['customers'];
                 //get sub service provide customer for that given customer
				$qrycusdata="SELECT idCustomer,cs_name,'' as checkdate FROM customer WHERE cs_serviceby='$cus'";
				$resultcusdata=$this->adapter->query($qrycusdata,array());
				$resultsetcusdata=$resultcusdata->toArray();
                   for ($k=0; $k < count($resultsetcusdata); $k++) 
                   { 
                   	  $resultsetcusdata[$k]['checkdate']=$checkbox;
                   }
				$resultset[$i]['subcustomer']=$resultsetcusdata;
				}

				


			if(!$lastrowdate) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'lastrowdate'=>$lastrowdate,'firstrowdate'=>$firstrowdate,'checkdate'=>$checkdate,'checkbox'=>$checkbox,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='get_sales_hierarchy'){
			$qry="SELECT sh.saleshierarchyType AS salesType, sh.saleshierarchyName AS saleshrname,sh.idSaleshierarchy AS idsales
			FROM sales_hierarchy AS sh 
			WHERE sh.saleshierarchyName!=''";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='get_employee') {
			$salesid=$param->salesid;
			$qry="SELECT idTeamMember,code,name FROM team_member_master where idSaleshierarchy='$salesid'";
			
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='get_cus_level') {
			$empid=$param->empid;
			$userid=$param->userid;
			$user_type=$param->user_type;
			$qry="SELECT * FROM customer AS CS
			LEFT JOIN customertype AS CL ON CL.idCustomerType=CS.cs_type 
			WHERE CS.sales_hrchy_name='$empid'and cs_status=1 AND CL.idCustomerType>$user_type GROUP BY CL.idCustomerType";
			
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='get_servicecustomer') {
			$cusid=$param->cusid;
			$userid=$param->userid;
			$user_type=$param->user_type;
			$qry="SELECT CS.idCustomer,CS.cs_name,0 as status,'' as chkdates FROM customer AS CS
			WHERE CS.cs_serviceby='$cusid'and CS.cs_status=1";
			
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			foreach ($resultset as $key => $value) {
				$resultset[$key]['status']=false;
			}

			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}
		return $ret_arr;
	}

	public function pjpAdd($param)
	{
       //print_r($param);
       $userid=$param->userid;
       $user_type=$param->user_type;
       $data=$param->data;
       $slhid=$param->slh;
       $idemp=$param->idemp;
       $ctype=$param->ctype;
       $cycledays=$param->cycledays;
       $startdate=date('Y-m-d',strtotime($param->startdate));

       $this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					
				
						$pjpinsert['idSalesHierarchy']=$slhid;
						$pjpinsert['idTeamMember']=$idemp;
						$pjpinsert['idLevel']=$ctype;
						$pjpinsert['cycle_days']=$cycledays;
						$pjpinsert['start_date']=$startdate;						
							
						$insert=new Insert('pjp_detail');
						$insert->values($pjpinsert);
						$statement=$this->adapter->createStatement();
						$insert->prepareStatement($this->adapter, $statement);
						$insertresult=$statement->execute();
                       $pjpid=$this->adapter->getDriver()->getLastGeneratedValue();
						for ($i=0; $i < count($data); $i++) 
						{ 
							for ($j=0; $j < count($data[$i]['checkdate']); $j++) 
							{ 
							    if ($data[$i]['checkdate'][$j]['status']==1) 
							    {
							    	$idcus=$data[$i]['idCustomer'];
							    	$chdate=date('Y-m-d',strtotime($data[$i]['checkdate'][$j]['date']));

									$pjplistinsert['idpjpdetail']=$pjpid;
									$pjplistinsert['idCustomer']=$idcus;
									$pjplistinsert['cycle_day']=$chdate;
									$pjplistinsert['idTeamMember']=$idemp;
								
									$insertPJPCUS=new Insert('pjp_detail_list');
									$insertPJPCUS->values($pjplistinsert);
									$statementPJPCUS=$this->adapter->createStatement();
									$insertPJPCUS->prepareStatement($this->adapter, $statementPJPCUS);
									$insertresultPJPCUS=$statementPJPCUS->execute();	
							    } 
							}

						}
						for ($i=0; $i < count($data); $i++) 
						{
							for ($k=0; $k < count($data[$i]['subcustomer']); $k++) 
							{ 
								$idsubcus=$data[$i]['subcustomer'][$k]['idCustomer'];
								//print_r($idsubcus);
								for ($l=0; $l < count($data[$i]['subcustomer'][$k]['checkdate']); $l++) 
								{ 
									//print_r($idsubcus);
									if ($data[$i]['subcustomer'][$k]['checkdate'][$l]['status']==1) 
									{
                                        
										$chsubdate=date('Y-m-d',strtotime($data[$i]['subcustomer'][$k]['checkdate'][$l]['date']));

										$pjpsublistinsert['idpjpdetail']=$pjpid;
										$pjpsublistinsert['idCustomer']=$idsubcus;
										$pjpsublistinsert['cycle_day']=$chsubdate;
										$pjpsublistinsert['idTeamMember']=$idemp;
  
										$insertPJPSUBCUS=new Insert('pjp_detail_list');
										$insertPJPSUBCUS->values($pjpsublistinsert);
										$statementPJPSUBCUS=$this->adapter->createStatement();
										$insertPJPSUBCUS->prepareStatement($this->adapter, $statementPJPSUBCUS);
										$insertresultPJPSUBCUS=$statementPJPSUBCUS->execute();	
									}  
								}
							}
						}

					$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				} catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again...'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				} 
        return $ret_arr;
	}
	public function pjpUpdate($param)
	{
		
		$userid=$param->userid;
		$user_type=$param->user_type;
		$data=$param->data;
		$idemp=$param->idemp;
		/*$slhid=$param->slh;
		$ctype=$param->ctype;
		$cycledays=$param->cycledays;
		$startdate=date('Y-m-d',strtotime($param->startdate));*/
        $editid=$param->editid;

				/*$deletePJP = new Delete('pjp_detail');
				$deletePJP->where(['idpjpdetail=?' => $editid]);
				$statementPJP=$this->adapter->createStatement();
				$deletePJP->prepareStatement($this->adapter, $statementPJP);
				$resultsetPJP=$statementPJP->execute();*/

				$deletePJPLIST = new Delete('pjp_detail_list');
				$deletePJPLIST->where(['idpjpdetail=?' => $editid]);
				$statementPJPLIST=$this->adapter->createStatement();
				$deletePJPLIST->prepareStatement($this->adapter, $statementPJPLIST);
				$resultsetPJPLIST=$statementPJPLIST->execute();

				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					
				
						/*$pjpinsert['idSalesHierarchy']=$slhid;
						$pjpinsert['idTeamMember']=$idemp;
						$pjpinsert['idLevel']=$ctype;
						$pjpinsert['cycle_days']=$cycledays;
						$pjpinsert['start_date']=$startdate;						
							
						$insert=new Insert('pjp_detail');
						$insert->values($pjpinsert);
						$statement=$this->adapter->createStatement();
						$insert->prepareStatement($this->adapter, $statement);
						$insertresult=$statement->execute();
                       $pjpid=$this->adapter->getDriver()->getLastGeneratedValue();*/
                       
						for ($i=0; $i < count($data); $i++) 
						{ 
							for ($j=0; $j < count($data[$i]['checkdate']); $j++) 
							{ 
							    if ($data[$i]['checkdate'][$j]['status']==1) 
							    {
							    	$idcus=$data[$i]['idCustomer'];
							    	$chdate=date('Y-m-d',strtotime($data[$i]['checkdate'][$j]['date']));

									$pjplistinsert['idpjpdetail']=$editid;
									$pjplistinsert['idCustomer']=$idcus;
									$pjplistinsert['cycle_day']=$chdate;
									$pjplistinsert['idTeamMember']=$idemp;
								
									$insertPJPCUS=new Insert('pjp_detail_list');
									$insertPJPCUS->values($pjplistinsert);
									$statementPJPCUS=$this->adapter->createStatement();
									$insertPJPCUS->prepareStatement($this->adapter, $statementPJPCUS);
									$insertresultPJPCUS=$statementPJPCUS->execute();	
							    } 
							}

						}
						for ($i=0; $i < count($data); $i++) 
						{
							for ($k=0; $k < count($data[$i]['subcustomer']); $k++) 
							{ 
								$idsubcus=$data[$i]['subcustomer'][$k]['idCustomer'];
								//print_r($idsubcus);
								for ($l=0; $l < count($data[$i]['subcustomer'][$k]['checkdate']); $l++) 
								{ 
									//print_r($idsubcus);
									if ($data[$i]['subcustomer'][$k]['checkdate'][$l]['status']==1) 
									{
                                        
										$chsubdate=date('Y-m-d',strtotime($data[$i]['subcustomer'][$k]['checkdate'][$l]['date']));

										$pjpsublistinsert['idpjpdetail']=$editid;
										$pjpsublistinsert['idCustomer']=$idsubcus;
										$pjpsublistinsert['cycle_day']=$chsubdate;
										$pjpsublistinsert['idTeamMember']=$idemp;
  
										$insertPJPSUBCUS=new Insert('pjp_detail_list');
										$insertPJPSUBCUS->values($pjpsublistinsert);
										$statementPJPSUBCUS=$this->adapter->createStatement();
										$insertPJPSUBCUS->prepareStatement($this->adapter, $statementPJPSUBCUS);
										$insertresultPJPSUBCUS=$statementPJPSUBCUS->execute();	
									}  
								}
							}
						}

					$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				} catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again...'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				} 
        return $ret_arr;

	}
	public function SerialWhDamage($param)
	{
				if($param->action=="list")
				{
					$proid=$param->proid;
					$sizeid=$param->sizeid;
					$whitem=$param->whitem;
					$idOrderItem=$param->idOrderItem;
					$qty=$param->qty;
					$userData=$param->userData;
					$batchno=$param->batchno;

					

				/*	$qryPrimaryQty="SELECT ps.productPrimaryCount,pp.primarypackname FROM `product_size` as ps LEFT JOIN primary_packaging as pp on pp.idPrimaryPackaging=ps.idPrimaryPackaging WHERE ps.idProduct='$proid' AND ps.idProductsize='$sizeid'";
					$resultPrimaryQty=$this->adapter->query($qryPrimaryQty,array());
					$resultsetPrimaryQty=$resultPrimaryQty->toArray();
					$ppname=$resultsetPrimaryQty[0]['primarypackname'];
					$ppcount=$resultsetPrimaryQty[0]['productPrimaryCount'];	

					$totalQty=$ppcount*$qty;*/
					$totalQty=$qty;
		//All serial number data	
					/*$qryorders="SELECT idProductserialno,serialno,status FROM `product_stock_serialno` WHERE idWhStock in(SELECT idWhStock FROM whouse_stock_items WHERE idWhStockItem='$whitem') AND idProduct='$proid' AND idProductsize='$sizeid' AND status!=1 AND status!=5 AND status!=4 AND status!=6";*/
					$qryorders="SELECT idProductserialno,serialno,status FROM `product_stock_serialno` WHERE idWhStockItem='$whitem' AND idProduct='$proid' AND idProductsize='$sizeid' AND status!=1 AND status!=5 AND status!=4 AND status!=6";
				 
					$resultorders=$this->adapter->query($qryorders,array());
					$resultsetALLSL=$resultorders->toArray();

				//print_r($resultsetALLSL);exit;

			
		$k=0;


	
			for ($m=0; $m < count($resultsetALLSL); $m++) 
			{ 
				
					$resultsetorders[$k]['idProductserialno']=$resultsetALLSL[$m]['idProductserialno'];
					$resultsetorders[$k]['serialno']=$resultsetALLSL[$m]['serialno'];
					$resultsetorders[$k]['status']=false;
					$resultsetorders[$k]['requiredstatus']=false;
					$resultsetorders[$k]['serialstatus']=$resultsetALLSL[$m]['status'];

			$k++;

			}


		//set status true for check the number of qty return serial number			
		for ($i=0; $i < $totalQty; $i++) 
		{
			if(count($resultsetorders)>$i){
				$resultsetorders[$i]['status']=true;
				$resultsetorders[$i]['requiredstatus']=true;
			}
		}

		$sllength-count($resultsetALLSL);
		if(count($resultsetorders)>0)
		{
			$ret_arr=['code'=>'2','status'=>true,'content' =>$resultsetorders,'totalQty'=>$totalQty,'allocateid' => $orderallocatedid,'sllength'=>$sllength,'message'=>'records available'];
		}
		else
		{
			$ret_arr=['code'=>'1','status'=>false,'message'=>'no records..'];
		}
		}
		return $ret_arr;	
    }

     public function updateSerialnowhDamage($param)
	{
      
       $fields=$param->FORM;
       $sno=$param->srno;
       $idWhStockItem=$param->whitem;
      $checkedsno=$param->checkedSNO;
    
      
       for ($i=0; $i < count($sno); $i++) 
       { 
       	$j=$i+1;
       	$a='serialcheck'.$j;
       	
       	// if ($fields[$a]==true) 
       	// {
       	if($sno[$i]['status']==true){
       		 	
        $idserialno=$sno[$i]['idProductserialno'];
       		 	$this->adapter->getDriver()->getConnection()->beginTransaction();
					try {
						$updateserialNo['status']=5;
						$updateserialNo['idWhStockItem']=$idWhStockItem;
						//$updateserialNo['idOrderallocateditems']=$idorderallocateitem;
						
						$sql = new Sql($this->adapter);
						$update = $sql->update();
						$update->table('product_stock_serialno');
						$update->set($updateserialNo);
						$update->where(array('idProductserialno' =>$idserialno));
						$statement = $sql->prepareStatementForSqlObject($update);
						$results = $statement->execute();
						$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
						$this->adapter->getDriver()->getConnection()->commit();

					}catch(\Exception $e) {
						$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
						$this->adapter->getDriver()->getConnection()->rollBack();
					}
       	// }
           }
       }

       return $ret_arr;
	}

		public function unpickWhDMGSerialno($param)
		{
			
		  $slno=($param->pickslno)?implode(',',$param->pickslno):'';
		  $slno2=$param->pickslno;
		  $sno=$param->sno;
		  //print_r($sno);exit;
		  /*for ($i=0; $i <count($slno2) ; $i++) 
		  { 
		  	
		  	$finalslno[]=$slno2[$i];
		  
		  }*/

		  $this->adapter->getDriver()->getConnection()->beginTransaction();
					try{
						
				for ($i=0; $i <count($sno); $i++) 
				{ 
       			if($sno[$i]['status']==true){
       				   $idserialno=$sno[$i]['idProductserialno'];
					$dataupdate['status']=$sno[$i]['serialstatus'];

					$sql = new Sql($this->adapter);
					$update = $sql->update();
					$update->table('product_stock_serialno');
					$update->set($dataupdate);
					$update->where(array('idProductserialno' =>$idserialno));
					$statement  = $sql->prepareStatementForSqlObject($update);
					$results    = $statement->execute();
				}
				
				}
				
				$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
				$this->adapter->getDriver()->getConnection()->commit();
			} catch(\Exception $e) {
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
				$this->adapter->getDriver()->getConnection()->rollBack();
			}
			return $ret_arr;
}

public function customerVisitlist($param)
{
   
	$qryCusVisit="SELECT * FROM `pjp_visit_status`";
	$resultCusVisit=$this->adapter->query($qryCusVisit,array());
	$resultsetCusVisit=$resultCusVisit->toArray();
	if (count($resultsetCusVisit)>0) 
	{
	 $ret_arr=['code'=>'2','status'=>true,'message'=>'Data available','content'=>$resultsetCusVisit];
	}else
	{
       $ret_arr=['code'=>'1','status'=>false,'message'=>'No data available'];
	}
	return $ret_arr;
}
public function customerVisitEditView($param)
{
   $idvisit=$param->idVisit;
	$qryCusVisit="SELECT * FROM `pjp_visit_status` WHERE idVisit='$idvisit'";
	$resultCusVisit=$this->adapter->query($qryCusVisit,array());
	$resultsetCusVisit=$resultCusVisit->toArray();
	if (count($resultsetCusVisit)>0) 
	{
	 $ret_arr=['code'=>'2','status'=>true,'message'=>'Data available','content'=>$resultsetCusVisit];
	}else
	{
       $ret_arr=['code'=>'1','status'=>false,'message'=>'No data available'];
	}
	return $ret_arr;
}
public function customerVisitAdd($param)
{
   
   $fields=$param->Form;
   $qryAlreadyExist="SELECT * FROM `pjp_visit_status` WHERE pjp_category='".$fields['category']."'";
	$resultAlreadyExist=$this->adapter->query($qryAlreadyExist,array());
	$resultsetAlreadyExist=$resultAlreadyExist->toArray();
	if (count($resultsetAlreadyExist)>0) 
	{
		$ret_arr=['code'=>'1','status'=>false,'message'=>'Category already exist'];
	}else
	{
	    $this->adapter->getDriver()->getConnection()->beginTransaction();   
				try {
					
						$datainsert['pjp_category']=$fields['category']; 
						$datainsert['pjp_status']=$fields['pstatus']; 
						$datainsert['created_by']=$param->userData['user_id'];
						$datainsert['created_at']=date('Y-m-d H:i:s');
						
						$insert=new Insert('pjp_visit_status');
						$insert->values($datainsert);
						$statement=$this->adapter->createStatement();
						$insert->prepareStatement($this->adapter, $statement);
						$insertresult=$statement->execute();
            
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				} catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again...'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				} 	
	}
  

				return $ret_arr;

}

public function customerVisitUpdate($param)
{
   
		$fields=$param->Form;
		$editid=$fields['idVisit'];
		$qryAlreadyExist="SELECT * FROM `pjp_visit_status` WHERE pjp_category='".$fields['pjp_category']."' AND idVisit!='".$editid."'";
		$resultAlreadyExist=$this->adapter->query($qryAlreadyExist,array());
		$resultsetAlreadyExist=$resultAlreadyExist->toArray();
		if (count($resultsetAlreadyExist)>0) 
		{
			$ret_arr=['code'=>'1','status'=>false,'message'=>'Category already exist'];
		}else
		{
			$this->adapter->getDriver()->getConnection()->beginTransaction();   
				try {
						$dataUpdate['pjp_category']=$fields['pjp_category']; 
						$dataUpdate['pjp_status']=$fields['pjp_status']; 
						$dataUpdate['updated_at']=date('Y-m-d H:i:s');
						$dataUpdate['updated_by']=$param->userData['user_id'];
					
					$sql = new Sql($this->adapter);
					$update = $sql->update();
					$update->table('pjp_visit_status');
					$update->set($dataUpdate);
					$update->where( array('idVisit' => $editid));
					$statement  = $sql->prepareStatementForSqlObject($update);
					$results    = $statement->execute();
				

					
					$this->adapter->getDriver()->getConnection()->commit();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
				} catch (\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
		}
   

				return $ret_arr;
}
}