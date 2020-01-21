<?php
namespace Sales\V1\Rest\Master;
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

class MasterMapper {

	protected $mapper;
	public function __construct(AdapterInterface $adapter) {
		// date_default_timezone_set("Asia/Manila");
		$this->adapter=$adapter;
		$this->commonfunctions  = new CommonFunctionsMapper($this->adapter);
	}

	public function fetchOne($param) {
		$from=$param->from;
		if($from!='login_authentication' && $from!='sys_setting'){
		$validateToken=$this->commonfunctions->validateToken();
			if($validateToken->success){
				
				$action=$param->action;
				$returnval=$this->$from($param);
				return $returnval;
			}else{
				return $validateToken;
			}
		}else{
				$returnval=$this->$from($param);
				return $returnval;
			}
	}

	
	/*public function fetchOne($param) {
		$from=$param->from;
		$action=$param->action;
		$returnval=$this->$from($param);
		return $returnval; 
	}
	*/
	public function indexing($param) {
		
		
	}


public function commonfunctions($param) {
		$action=$param->action;
			if($action=='geography_master') {
				$qry="SELECT gm.idGeographyTitle as gmid,gm.title as name,gm.geography as geography 
				from geographytitle_master gm where gm.title!=''";
				$result=$this->adapter->query($qry,array('1'));
				$resultset=$result->toArray();
				if(!$resultset) {
					$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
				} else {
					$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
				}
			}

			if($action=='territory_master') {
				$qry="SELECT tt.idTerritoryTitle as gmid,tt.title as name,tt.hierarchy as hierarchy 
				from territorytitle_master tt where tt.title!=''";
				$result=$this->adapter->query($qry,array('1'));
				$resultset=$result->toArray();
				if(!$resultset) {
					$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
				} else {
					$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
				}
			}

        	return $ret_arr;
}

public function Geography($param) {
		if($param->action=='add') {		
			$fiedls=$param->Form;
			$userid=$param->userid;
			
			$qry="SELECT * FROM geographytitle_master where geography=?";
			$result=$this->adapter->query($qry,array($fiedls['georaphy1']));
			$resultset=$result->toArray();	
			
			$qry1="SELECT * FROM geographytitle_master";
			$result1=$this->adapter->query($qry1,array());
			$resultset1=$result1->toArray();	

			if(!$resultset1){

				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					for($i=1;$i<=10;$i++){

							$hierarchy_type='H'.$i;
						    $hierarchy_Title=$fiedls['georaphy'.$i];		
							$datainsert['geography']=$hierarchy_type;
							$datainsert['title']=$hierarchy_Title;
							$insert=new Insert('geographytitle_master');
							$insert->values($datainsert);
							$statement=$this->adapter->createStatement();
							$insert->prepareStatement($this->adapter, $statement);
							$insertresult=$statement->execute();		
					} 														
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				} catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			}
		}if($resultset1) {
				$fiedls=$param->Form;
				$userid=$param->userid;

					$this->adapter->getDriver()->getConnection()->beginTransaction();
					try {
						$count_contentid=count($param->content_id);
						for($i=0;$i<$count_contentid;$i++) {

						$hierarchy_Title=$fiedls['georaphy'.$param->content_id[$i]['id']];
					    $datainsert['title']=$hierarchy_Title;
						
						$sql = new Sql($this->adapter);
						$update = $sql->update();
						$update->table('geographytitle_master');
						$update->set($datainsert);
						$update->where( array('idGeographyTitle' =>$param->content_id[$i]['id']));
						$statement  = $sql->prepareStatementForSqlObject($update);
						$results    = $statement->execute();
					}
						$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
						$this->adapter->getDriver()->getConnection()->commit();
					} catch(\Exception $e) {
						$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
						$this->adapter->getDriver()->getConnection()->rollBack();
					}		
			}
			else if($param->action=='editview') {
				$fiedls=$param->Form;
				$userid=$param->userid;
				for($i=1;$i<=10;$i++) {
					$hierarchyName=$fiedls['hierarchy'.$i];	
				}
				$qry="SELECT gm.idGeographyTitle as id,gm.title as name FROM geographytitle_master gm ";
				$result=$this->adapter->query($qry,array($i));
				$resultset=$result->toArray();
				$qry="SELECT a.idGeographyTitle as id FROM geographytitle_master a";
				$resultid=$this->adapter->query($qry,array($i));
				$resultsetid=$resultid->toArray();
				if(!$resultset){
					$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
				} else {
					$ret_arr=['code'=>'2','content'=>$resultset,'contentid'=>$resultsetid, 'status'=>true,'message'=>'Record available'];
				}
			}	
			
		return $ret_arr;
	}	


public function Georaphy_type($param) {

	if($param->action=='list') {
		$qry="SELECT gt.geoValue as value,gt.geoCode as code,gt.status as status,gt.idGeography as id,gm.geography as type,gm.title as name 
			   FROM geography gt 
			   left join geographytitle_master gm on gm.idGeographyTitle=gt.idGeographyTitle";

			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();

			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
            return $ret_arr;

		}else if($param->action=='add') {	
			$fiedls=$param->Form;
			$userid=$param->userid;
			$qry="SELECT * FROM geography where geoValue=? and geoCode=?";
			$result=$this->adapter->query($qry,array($fiedls['georaphy_value'],$fiedls['georaphy_code']));
			$resultset=$result->toArray();
			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['idGeographyTitle']=$fiedls['georaphy_name'];
					$datainsert['geoValue']=$fiedls['georaphy_value'];
					$datainsert['geoCode']=$fiedls['georaphy_code'];
					$datainsert['status']=$fiedls['status'];
					$datainsert['created_at']=date('Y-m-d H:i:s');
					$datainsert['created_by']=1;
					$datainsert['updated_at']=date('Y-m-d H:i:s');
					$datainsert['updated_by']=1;
					$insert=new Insert('geography');
					$insert->values($datainsert);
					$statement=$this->adapter->createStatement();
					$insert->prepareStatement($this->adapter, $statement);
					$insertresult=$statement->execute();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				} catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			} else {
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
			}
		} else if($param->action=='editview') {
			$editid=$param->id;		

		   $qry="SELECT gt.geoValue as value,gt.geoCode as code,gt.status as status,gt.idGeography as id,gt.idGeographyTitle as gmid,gm.geography as geotype,gm.title as name 
			   FROM geography gt 
			   left join geographytitle_master gm on gm.idGeographyTitle=gt.idGeographyTitle where gt.idGeography=?";

			$result=$this->adapter->query($qry,array($editid));
			$resultset=$result->toArray();
			if(!$resultset){
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		} else if($param->action=='update') {

			$fiedls=$param->forms;
			$userid=$param->userid;
			$editid=$fiedls['id'];
			$qry="SELECT * FROM geography where geoValue=? and geoCode=? and idGeography!=?";
			$result=$this->adapter->query($qry,array($fiedls['value'],$fiedls['code'],$editid));
			$resultset=$result->toArray();

			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['idGeography']=$fiedls['id'];
					$datainsert['idGeographyTitle']=$fiedls['gmid'];
					$datainsert['geoValue']=$fiedls['value'];
					$datainsert['geoCode']=$fiedls['code'];
					$datainsert['status']=$fiedls['status'];
					$datainsert['created_at']=date('Y-m-d H:i:s');
					$datainsert['created_by']=1;
					$datainsert['updated_at']=date('Y-m-d H:i:s');
					$datainsert['updated_by']=1;
					$sql = new Sql($this->adapter);
					$update = $sql->update();
					$update->table('geography');
					$update->set($datainsert);
					$update->where( array('idGeography' => $editid));
					$statement  = $sql->prepareStatementForSqlObject($update);
					$results    = $statement->execute();
					$ret_arr=['code'=>'2','status'=>true,'message'=>' Updated successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				} catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			} else {
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
			}
		} else {
			$ret_arr=['code'=>'3','content'=>'','status'=>false,'message'=>'Please contact the administrator'];
		}
		return $ret_arr;
	}

public function Georaphy_mapping($param) {
       if($param->action=='list') {
	  $qry="SELECT IF(gm1.geoValue!='',gm1.geoValue,'-') as g1,IF(gm2.geoValue!='',gm2.geoValue,'-') as g2,IF(gm3.geoValue!='',gm3.geoValue,'-') as g3,IF(gm4.geoValue!='',gm4.geoValue,'-') as g4,IF(gm5.geoValue!='',gm5.geoValue,'-') as g5,IF(gm6.geoValue!='',gm6.geoValue,'-') as g6,IF(gm7.geoValue!='',gm7.geoValue,'-') as g7,IF(gm8.geoValue!='',gm8.geoValue,'-') as g8,IF(gm9.geoValue!='',gm9.geoValue,'-') as g9,IF(gm10.geoValue!='',gm10.geoValue,'-') as g10,idGeographyMapping as id
			FROM geographymapping_master as gmm 
			LEFT JOIN geography as gm1 on gm1.idGeography=gmm.g1
			LEFT JOIN geography as gm2 on gm2.idGeography=gmm.g2
			LEFT JOIN geography as gm3 on gm3.idGeography=gmm.g3
			LEFT JOIN geography as gm4 on gm4.idGeography=gmm.g4
			LEFT JOIN geography as gm5 on gm5.idGeography=gmm.g5
			LEFT JOIN geography as gm6 on gm6.idGeography=gmm.g6
			LEFT JOIN geography as gm7 on gm7.idGeography=gmm.g7
			LEFT JOIN geography as gm8 on gm8.idGeography=gmm.g8
			LEFT JOIN geography as gm9 on gm9.idGeography=gmm.g9
			LEFT JOIN geography as gm10 on gm10.idGeography=gmm.g10";

			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();

	$qry1="SELECT IF(gm.title !='',gm.title,'G1') AS G1 FROM geographytitle_master gm where gm.idGeographyTitle=1";
			$result1=$this->adapter->query($qry1,array());
			$resultset1=$result1->toArray();
        
	$qry2="SELECT IF(gm.title !='',gm.title,'G2') AS G2 FROM geographytitle_master gm where gm.idGeographyTitle=2";
			$result2=$this->adapter->query($qry2,array());
			$resultset2=$result2->toArray();

	$qry3="SELECT IF(gm.title !='',gm.title,'G3') AS G3 FROM geographytitle_master gm where gm.idGeographyTitle=3";
			$result3=$this->adapter->query($qry3,array());
			$resultset3=$result3->toArray();

	$qry4="SELECT IF(gm.title !='',gm.title,'G4') AS G4 FROM geographytitle_master gm where gm.idGeographyTitle=4";
			$result4=$this->adapter->query($qry4,array());
			$resultset4=$result4->toArray();

	$qry5="SELECT IF(gm.title !='',gm.title,'G5') AS G5 FROM geographytitle_master gm where gm.idGeographyTitle=5";
			$result5=$this->adapter->query($qry5,array());
			$resultset5=$result5->toArray();

	$qry6="SELECT IF(gm.title !='',gm.title,'G6') AS G6 FROM geographytitle_master gm where gm.idGeographyTitle=6";
			$result6=$this->adapter->query($qry6,array());
			$resultset6=$result6->toArray();

	$qry7="SELECT IF(gm.title !='',gm.title,'G7') AS G7 FROM geographytitle_master gm where gm.idGeographyTitle=7";
			$result7=$this->adapter->query($qry7,array());
			$resultset7=$result7->toArray();

	$qry8="SELECT IF(gm.title !='',gm.title,'G8') AS G8 FROM geographytitle_master gm where gm.idGeographyTitle=8";
			$result8=$this->adapter->query($qry8,array());
			$resultset8=$result8->toArray();

	$qry9="SELECT IF(gm.title !='',gm.title,'G9') AS G9 FROM geographytitle_master gm where gm.idGeographyTitle=9";
			$result9=$this->adapter->query($qry9,array());
			$resultset9=$result9->toArray();

	$qry10="SELECT IF(gm.title !='',gm.title,'G10') AS G10 FROM geographytitle_master gm where gm.idGeographyTitle=10";
			$result10=$this->adapter->query($qry10,array());
			$resultset10=$result10->toArray();

			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>$resultset,'contentlist1'=>$resultset1,'contentlist2'=>$resultset2,'contentlist3'=>$resultset3,'contentlist4'=>$resultset4,'contentlist5'=>$resultset5,'contentlist6'=>$resultset6,'contentlist7'=>$resultset7,'contentlist8'=>$resultset8,'contentlist9'=>$resultset9,'contentlist10'=>$resultset10,'status'=>true,'message'=>'No of records'.count($resultset)];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'contentlist1'=>$resultset1,'contentlist2'=>$resultset2,'contentlist3'=>$resultset3,'contentlist4'=>$resultset4,'contentlist5'=>$resultset5,'contentlist6'=>$resultset6,'contentlist7'=>$resultset7,'contentlist8'=>$resultset8,'contentlist9'=>$resultset9,'contentlist10'=>$resultset10,'status'=>true,'message'=>'Record available'];
			}
         return $ret_arr;

		}else if($param->action=='add') {
		$userid=$param->userid;
            $qry="SELECT * FROM geographymapping_master where g1=? and g2=? and g3=? and g4=? and g5=? and g6=? 
             and g7=? and g8=? and g9=? and g10=?";
			$result=$this->adapter->query($qry,array($param->geography1,$param->geography2,$param->geography3,$param->geography4,$param->geography5,$param->geography6,$param->geography7,$param->geography8,$param->geography9,$param->geography10));
			$resultset=$result->toArray();

			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {

					$datainsert['g1']=$param->geography1;
					$datainsert['g2']=$param->geography2;
					$datainsert['g3']=$param->geography3;
					$datainsert['g4']=$param->geography4;
					$datainsert['g5']=$param->geography5;
					$datainsert['g6']=$param->geography6;
					$datainsert['g7']=$param->geography7;
					$datainsert['g8']=$param->geography8;
					$datainsert['g9']=$param->geography9;
					$datainsert['g10']=$param->geography10;
					$datainsert['created_at']=date('Y-m-d H:i:s');
					$datainsert['created_by']=1;
					$datainsert['updated_at']=date('Y-m-d H:i:s');
					$datainsert['updated_by']=1;
				    $insert=new Insert('geographymapping_master');
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
		}else if($param->action=='editview'){ 
                 $editid=$param->id;
		$qry="SELECT IF(gm1.idGeography!='' ,gm1.idGeography,'0') as g1,IF(gm2.idGeography!='' ,gm2.idGeography,'0') as g2,IF(gm3.idGeography!='' ,gm3.idGeography,'0') as g3,IF(gm4.idGeography!='' ,gm4.idGeography,'0') as g4,IF(gm5.idGeography!='' ,gm5.idGeography,'0') as g5,IF(gm6.idGeography!='' ,gm6.idGeography,'0') as g6,IF(gm7.idGeography!='' ,gm7.idGeography,'0') as g7,IF(gm8.idGeography!='' ,gm8.idGeography,'0') as g8,IF(gm9.idGeography!='' ,gm9.idGeography,'0') as g9,IF(gm10.idGeography!='' ,gm10.idGeography,'0') as g10,gm1.geoValue as geography1,gm2.geoValue as geography2,gm3.geoValue as geography3,gm4.geoValue as geography4,gm5.geoValue as geography5,gm6.geoValue as geography6,gm7.geoValue as geography7,gm8.geoValue as geography8,gm9.geoValue as geography9,gm10.geoValue as geography10,gmm.idGeographyMapping as id 
		        FROM geographymapping_master as gmm 
				LEFT JOIN geography as gm1 on gm1.idGeography=gmm.g1
				LEFT JOIN geography as gm2 on gm2.idGeography=gmm.g2
				LEFT JOIN geography as gm3 on gm3.idGeography=gmm.g3
				LEFT JOIN geography as gm4 on gm4.idGeography=gmm.g4
				LEFT JOIN geography as gm5 on gm5.idGeography=gmm.g5
				LEFT JOIN geography as gm6 on gm6.idGeography=gmm.g6
				LEFT JOIN geography as gm7 on gm7.idGeography=gmm.g7
				LEFT JOIN geography as gm8 on gm8.idGeography=gmm.g8
				LEFT JOIN geography as gm9 on gm9.idGeography=gmm.g9
				LEFT JOIN geography as gm10 on gm10.idGeography=gmm.g10
			    where idGeographyMapping=?";
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
             $editid=$param->mappingid;  
             $userid=$param->userid;
            $qry="SELECT * FROM geographymapping_master where g1=? and g2=? and g3=? and g4=? and g5=? and g6=? 
             and g7=? and g8=? and g9=? and g10=? and idGeographyMapping !=?";

			$result=$this->adapter->query($qry,array($param->g1,$param->g2,$param->g3,$param->g4,$param->g5,
		 	$param->g6,$param->g7,$param->g8,$param->g9,$param->g10,$editid));

			$resultset=$result->toArray();

				if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try{	
					$datainsert['g1']=$param->g1;
					$datainsert['g2']=$param->g2;
					$datainsert['g3']=$param->g3;
					$datainsert['g4']=$param->g4;
					$datainsert['g5']=$param->g5;
					$datainsert['g6']=$param->g6;
					$datainsert['g7']=$param->g7;
					$datainsert['g8']=$param->g8;
					$datainsert['g9']=$param->g9;
					$datainsert['g10']=$param->g10;
					$datainsert['updated_by']=1;
					$datainsert['updated_at']=date('Y-m-d H:i:s');
					$sql = new Sql($this->adapter);
					$update = $sql->update();
					$update->table('geographymapping_master');
					$update->set($datainsert);
					$update->where(array('idGeographyMapping' => $editid));
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

      return $ret_arr;

	}

public function Territory($param) {

		if($param->action=='add') {
			
			$fiedls=$param->Form;
			$userid=$param->userid;
			
			$qry="SELECT * FROM territorytitle_master where hierarchy=?";
			$result=$this->adapter->query($qry,array($fiedls['territory1']));
			$resultset=$result->toArray();	
			
			$qry1="SELECT * FROM territorytitle_master";
			$result1=$this->adapter->query($qry1,array());
			$resultset1=$result1->toArray();	

			if(!$resultset1){

				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					for($i=1;$i<=10;$i++){

							$hierarchy_type='H'.$i;
						    $hierarchy_Title=$fiedls['territory'.$i];		
							$datainsert['hierarchy']=$hierarchy_type;
							$datainsert['title']=$hierarchy_Title;
							$insert=new Insert('territorytitle_master');
							$insert->values($datainsert);
							$statement=$this->adapter->createStatement();
							$insert->prepareStatement($this->adapter, $statement);
							$insertresult=$statement->execute();		
					} 														
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				} catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			}
		}if($resultset1) {
				$fiedls=$param->Form;
				$userid=$param->userid;

					$this->adapter->getDriver()->getConnection()->beginTransaction();
					try {
						$count_contentid=count($param->content_id);
						for($i=0;$i<$count_contentid;$i++) {

						$hierarchy_Title=$fiedls['territory'.$param->content_id[$i]['id']];
					    $datainsert['title']=$hierarchy_Title;
						
						$sql = new Sql($this->adapter);
						$update = $sql->update();
						$update->table('territorytitle_master');
						$update->set($datainsert);
						$update->where( array('idTerritoryTitle' =>$param->content_id[$i]['id']));
						$statement  = $sql->prepareStatementForSqlObject($update);
						$results    = $statement->execute();
					}
						$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
						$this->adapter->getDriver()->getConnection()->commit();
					} catch(\Exception $e) {
						$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
						$this->adapter->getDriver()->getConnection()->rollBack();
					}		
			}
			else if($param->action=='editview') {
				$fiedls=$param->Form;
				$userid=$param->userid;
				for($i=1;$i<=10;$i++) {
					$hierarchyName=$fiedls['territory'.$i];	
				}
				$qry="SELECT tm.idTerritoryTitle as id,tm.title as name FROM territorytitle_master tm ";
				$result=$this->adapter->query($qry,array($i));
				$resultset=$result->toArray();
				$qry="SELECT a.idTerritoryTitle as id FROM territorytitle_master a";
				$resultid=$this->adapter->query($qry,array($i));
				$resultsetid=$resultid->toArray();
				if(!$resultset){
					$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
				} else {
					$ret_arr=['code'=>'2','content'=>$resultset,'contentid'=>$resultsetid, 'status'=>true,'message'=>'Record available'];
				}
			}	
			
		return $ret_arr;
	}

public function Territory_type($param) {

	if($param->action=='list') {
	  $qry="SELECT tm.territoryValue as value,tm.territoryCode as code,tm.status as status,tm.idTerritory as id,tt.hierarchy as type,tt.title as name 
			   FROM territory_master tm 
			   left join territorytitle_master tt on tt.idTerritoryTitle=tm.idTerritoryTitle";

			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();

			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
            return $ret_arr;

		}else if($param->action=='add') {

			$fiedls=$param->Form;
			$userid=$param->userid;

		    $qry="SELECT * FROM territory_master where territoryCode=? and territoryValue=?";
			$result=$this->adapter->query($qry,array($fiedls['territory_code'],$fiedls['territory_value']));
			$resultset=$result->toArray();

			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['idTerritoryTitle']=$fiedls['territory_name'];
					$datainsert['territoryValue']=$fiedls['territory_value'];
					$datainsert['territoryCode']=$fiedls['territory_code'];
					if($fiedls['territory_name']==2){
						$datainsert['territoryUnion']=$fiedls['territory_union'];
					}else{
						$datainsert['territoryUnion']=2;
					}
					
					$datainsert['status']=$fiedls['status'];
					$datainsert['created_at']=date('Y-m-d H:i:s');
					$datainsert['created_by']=1;
					$datainsert['updated_at']=date('Y-m-d H:i:s');
					$datainsert['updated_by']=1;
					$insert=new Insert('territory_master');
					$insert->values($datainsert);
					$statement=$this->adapter->createStatement();
					$insert->prepareStatement($this->adapter, $statement);
					$insertresult=$statement->execute();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				} catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			} else {
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
			}
		} else if($param->action=='editview') {
			$editid=$param->id;		

		   $qry="SELECT tm.territoryValue as value,tm.territoryCode as code,tm.status as status,tm.idTerritory as id,tt.idTerritoryTitle as gmid,tt.hierarchy as tertype,tt.title as name,tm.territoryUnion as ter_union 
			   FROM territory_master tm 
			   left join territorytitle_master tt on tt.idTerritoryTitle=tm.idTerritoryTitle where tm.idTerritory=?";

			$result=$this->adapter->query($qry,array($editid));
			$resultset=$result->toArray();
			if(!$resultset){
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		} else if($param->action=='update') {

			$fiedls=$param->forms;
			$userid=$param->userid;
			$editid=$fiedls['id'];
			$qry="SELECT * FROM territory_master where territoryValue=? and territoryCode=? and idTerritory	!=?";
			$result=$this->adapter->query($qry,array($fiedls['value'],$fiedls['code'],$editid));
			$resultset=$result->toArray();

			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['idTerritoryTitle']=$fiedls['gmid'];
					$datainsert['territoryValue']=$fiedls['value'];
					$datainsert['territoryCode']=$fiedls['code'];
					if($fiedls['gmid']==2){
                       $datainsert['territoryUnion']=$fiedls['ter_union'];
					}else{
                       $datainsert['territoryUnion']=2;
					}
					
					$datainsert['status']=$fiedls['status'];
					$datainsert['created_at']=date('Y-m-d H:i:s');
					$datainsert['created_by']=1;
					$datainsert['updated_at']=date('Y-m-d H:i:s');
					$datainsert['updated_by']=1;
					$sql = new Sql($this->adapter);
					$update = $sql->update();
					$update->table('territory_master');
					$update->set($datainsert);
					$update->where( array('idTerritory' => $editid));
					$statement  = $sql->prepareStatementForSqlObject($update);
					$results    = $statement->execute();
					$ret_arr=['code'=>'2','status'=>true,'message'=>' Updated successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				} catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			} else {
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
			}
		} else {
			$ret_arr=['code'=>'3','content'=>'','status'=>false,'message'=>'Please contact the administrator'];
		}
		return $ret_arr;
	}

public function Territory_mapping($param) {
       if($param->action=='list') {
   $qry="SELECT IF(tm1.territoryValue!='',tm1.territoryValue,'-') as t1,IF(tm2.territoryValue!='',tm2.territoryValue,'-') as t2,IF(tm3.territoryValue!='',tm3.territoryValue,'-') as t3,IF(tm4.territoryValue!='',tm4.territoryValue,'-') as t4,IF(tm5.territoryValue!='',tm5.territoryValue,'-') as t5,IF(tm6.territoryValue!='',tm6.territoryValue,'-') as t6,IF(tm7.territoryValue!='',tm7.territoryValue,'-') as t7,IF(tm8.territoryValue!='',tm8.territoryValue,'-') as t8,IF(tm9.territoryValue!='',tm9.territoryValue,'-') as t9,IF(tm10.territoryValue!='',tm10.territoryValue,'-') as t10,idTerritoryMapping as id
			FROM territorymapping_master as tmm 
			LEFT JOIN territory_master as tm1 on tm1.idTerritory = tmm.t1
			LEFT JOIN territory_master as tm2 on tm2.idTerritory = tmm.t2
			LEFT JOIN territory_master as tm3 on tm3.idTerritory = tmm.t3
			LEFT JOIN territory_master as tm4 on tm4.idTerritory = tmm.t4
			LEFT JOIN territory_master as tm5 on tm5.idTerritory = tmm.t5
			LEFT JOIN territory_master as tm6 on tm6.idTerritory = tmm.t6
			LEFT JOIN territory_master as tm7 on tm7.idTerritory = tmm.t7
			LEFT JOIN territory_master as tm8 on tm8.idTerritory = tmm.t8
			LEFT JOIN territory_master as tm9 on tm9.idTerritory = tmm.t9
			LEFT JOIN territory_master as tm10 on tm10.idTerritory = tmm.t10";

			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();

	$qry1="SELECT IF(hm.title !='',hm.title,'T1') AS T1 FROM territorytitle_master hm where hm.idTerritoryTitle=1";
			$result1=$this->adapter->query($qry1,array());
			$resultset1=$result1->toArray();
        
	$qry2="SELECT IF(hm.title !='',hm.title,'T2') AS T2 FROM territorytitle_master hm where hm.idTerritoryTitle=2";
			$result2=$this->adapter->query($qry2,array());
			$resultset2=$result2->toArray();

	$qry3="SELECT IF(hm.title !='',hm.title,'T3') AS T3 FROM territorytitle_master hm where hm.idTerritoryTitle=3";
			$result3=$this->adapter->query($qry3,array());
			$resultset3=$result3->toArray();

	$qry4="SELECT IF(hm.title !='',hm.title,'T4') AS T4 FROM territorytitle_master hm where hm.idTerritoryTitle=4";
			$result4=$this->adapter->query($qry4,array());
			$resultset4=$result4->toArray();

	$qry5="SELECT IF(hm.title !='',hm.title,'T5') AS T5 FROM territorytitle_master hm where hm.idTerritoryTitle=5";
			$result5=$this->adapter->query($qry5,array());
			$resultset5=$result5->toArray();

	$qry6="SELECT IF(hm.title !='',hm.title,'T6') AS T6 FROM territorytitle_master hm where hm.idTerritoryTitle=6";
			$result6=$this->adapter->query($qry6,array());
			$resultset6=$result6->toArray();

	$qry7="SELECT IF(hm.title !='',hm.title,'T7') AS T7 FROM territorytitle_master hm where hm.idTerritoryTitle=7";
			$result7=$this->adapter->query($qry7,array());
			$resultset7=$result7->toArray();

	$qry8="SELECT IF(hm.title !='',hm.title,'T8') AS T8 FROM territorytitle_master hm where hm.idTerritoryTitle=8";
			$result8=$this->adapter->query($qry8,array());
			$resultset8=$result8->toArray();

	$qry9="SELECT IF(hm.title !='',hm.title,'T9') AS T9 FROM territorytitle_master hm where hm.idTerritoryTitle=9";
			$result9=$this->adapter->query($qry9,array());
			$resultset9=$result9->toArray();

	$qry10="SELECT IF(hm.title !='',hm.title,'T10') AS T10 FROM territorytitle_master hm where hm.idTerritoryTitle=10";
			$result10=$this->adapter->query($qry10,array());
			$resultset10=$result10->toArray();

			if($resultset) {
				$ret_arr=['code'=>'1','content'=>$resultset,'contentlist1'=>$resultset1,'contentlist2'=>$resultset2,'contentlist3'=>$resultset3,'contentlist4'=>$resultset4,'contentlist5'=>$resultset5,'contentlist6'=>$resultset6,'contentlist7'=>$resultset7,'contentlist8'=>$resultset8,'contentlist9'=>$resultset9,'contentlist10'=>$resultset10,'status'=>true,'message'=>'No of records'.count($resultset)];
			} else{
				$ret_arr=['code'=>'2','content'=>$resultset,'contentlist1'=>$resultset1,'contentlist2'=>$resultset2,'contentlist3'=>$resultset3,'contentlist4'=>$resultset4,'contentlist5'=>$resultset5,'contentlist6'=>$resultset6,'contentlist7'=>$resultset7,'contentlist8'=>$resultset8,'contentlist9'=>$resultset9,'contentlist10'=>$resultset10,'status'=>true,'message'=>'Record available'];
			}

         return $ret_arr;

		}else if($param->action=='add') {
			$userid=$param->userid;
            $qry="SELECT * FROM territorymapping_master where t1=? and t2=? and t3=? and t4=? and t5=? and t6=? 
             and t7=? and t8=? and t9=? and t10=?";
			$result=$this->adapter->query($qry,array($param->territory1,$param->territory2,$param->territory3,$param->territory4,$param->territory5,$param->territory6,$param->territory7,$param->territory8,$param->territory9,$param->territory10));
			$resultset=$result->toArray();

			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {

					$datainsert['t1']=$param->territory1;
					$datainsert['t2']=$param->territory2;
					$datainsert['t3']=$param->territory3;
					$datainsert['t4']=$param->territory4;
					$datainsert['t5']=$param->territory5;
					$datainsert['t6']=$param->territory6;
					$datainsert['t7']=$param->territory7;
					$datainsert['t8']=$param->territory8;
					$datainsert['t9']=$param->territory9;
					$datainsert['t10']=$param->territory10;
					$datainsert['created_at']=date('Y-m-d H:i:s');
					$datainsert['created_by']=1;
					$datainsert['updated_at']=date('Y-m-d H:i:s');
					$datainsert['updated_by']=1;
				    $insert=new Insert('territorymapping_master');
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
		}else if($param->action=='editview'){ 
                 $editid=$param->id;
		$qry="SELECT IF(tm1.idTerritory!='' ,tm1.idTerritory,'0') as t1,IF(tm2.idTerritory!='' ,tm2.idTerritory,'0') as t2,IF(tm3.idTerritory!='' ,tm3.idTerritory,'0') as t3,IF(tm4.idTerritory!='' ,tm4.idTerritory,'0') as t4,IF(tm5.idTerritory!='' ,tm5.idTerritory,'0') as t5,IF(tm6.idTerritory!='' ,tm6.idTerritory,'0') as t6,IF(tm7.idTerritory!='' ,tm7.idTerritory,'0') as t7,IF(tm8.idTerritory!='' ,tm8.idTerritory,'0') as t8,IF(tm9.idTerritory!='' ,tm9.idTerritory,'0') as t9,IF(tm10.idTerritory!='' ,tm10.idTerritory,'0') as t10,tm1.territoryValue as territory1,tm2.territoryValue as territory2,tm3.territoryValue as territory3,tm4.territoryValue as territory4,tm5.territoryValue as territory5,tm6.territoryValue as territory6,tm7.territoryValue as territory7,tm8.territoryValue as territory8,tm9.territoryValue as territory9,tm10.territoryValue as territory10,tmm.idTerritoryMapping as id 
		        FROM territorymapping_master as tmm 
			    LEFT JOIN territory_master as tm1 on tm1.idTerritory=tmm.t1
				LEFT JOIN territory_master as tm2 on tm2.idTerritory=tmm.t2
				LEFT JOIN territory_master as tm3 on tm3.idTerritory=tmm.t3
				LEFT JOIN territory_master as tm4 on tm4.idTerritory=tmm.t4
				LEFT JOIN territory_master as tm5 on tm5.idTerritory=tmm.t5
				LEFT JOIN territory_master as tm6 on tm6.idTerritory=tmm.t6
				LEFT JOIN territory_master as tm7 on tm7.idTerritory=tmm.t7
				LEFT JOIN territory_master as tm8 on tm8.idTerritory=tmm.t8
				LEFT JOIN territory_master as tm9 on tm9.idTerritory=tmm.t9
				LEFT JOIN territory_master as tm10 on tm10.idTerritory=tmm.t10
			    where idTerritoryMapping=?";
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
             $editid=$param->mappingid;  
             $userid=$param->userid;
            $qry="SELECT * FROM territorymapping_master where t1=? and t2=? and t3=? and t4=? and t5=? and t6=? 
             and t7=? and t8=? and t9=? and t10=? and idTerritoryMapping !=?";

			$result=$this->adapter->query($qry,array($param->t1,$param->t2,$param->t3,$param->t4,$param->t5,
		 	$param->t6,$param->t7,$param->t8,$param->t9,$param->t10,$editid));

			$resultset=$result->toArray();

				if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try{	
					$datainsert['t1']=$param->t1;
					$datainsert['t2']=$param->t2;
					$datainsert['t3']=$param->t3;
					$datainsert['t4']=$param->t4;
					$datainsert['t5']=$param->t5;
					$datainsert['t6']=$param->t6;
					$datainsert['t7']=$param->t7;
					$datainsert['t8']=$param->t8;
					$datainsert['t9']=$param->t9;
					$datainsert['t10']=$param->t10;
					$datainsert['updated_by']=1;
					$datainsert['updated_at']=date('Y-m-d H:i:s');
					$sql = new Sql($this->adapter);
					$update = $sql->update();
					$update->table('territorymapping_master');
					$update->set($datainsert);
					$update->where(array('idTerritoryMapping' => $editid));
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

      return $ret_arr;

	}

	public function accountprofile($param){
		    if($param->action=='list') 
		    {
			    $qry="SELECT * FROM maingroup_master";
			    $result=$this->adapter->query($qry,array());
			    $resultset=$result->toArray();
			    if(!$resultset) 
			    {
				  $ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			    } 
			    else 
			    {
				$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'message'=>'System config information'];
			    }
		     }
     		else if($param->action=='add') 
     		{

			$fiedls=$param->Form;
			$company=$fiedls['company'];
			$userid=$param->userid;
			$status=$fiedls['status'];
			$qry="SELECT * FROM maingroup_master a where a.mainGroupName=?";
			$result=$this->adapter->query($qry,array($company));
			$resultset=$result->toArray();
			if(!$resultset) 
			{ 
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['mainGroupName']=$fiedls['company'];
					$datainsert['created_at']=date("Y-m-d H:i:s"); 
					$datainsert['created_by']=1;
					$datainsert['status']=$fiedls['pstatus'];
					$insert=new Insert('maingroup_master');
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
			 } 
			 else 
			 {
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
			  }
		    }  // add if close
            else if($param->action=='editview')
		    {
			     $editid=$param->company_id;
			     $qry="SELECT idMainGroup, mainGroupName,status  FROM maingroup_master where idMainGroup=?";
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
		    }
		    else if($param->action=='update') 
		    {
			$fiedls=$param->Form;
			$editid=$fiedls['idMainGroup'];
			$userid=$param->userid;
			$qry="SELECT * FROM maingroup_master where mainGroupName=? and idMainGroup!=?";
			$result=$this->adapter->query($qry,array($fiedls['mainGroupName'],$editid));
			$resultset=$result->toArray();
			if(!$resultset){
				
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try{
					$datainsert['mainGroupName']=$fiedls['mainGroupName'];
					$datainsert['status']=$fiedls['status'];
					$datainsert['updated_at']=date("Y-m-d H:i:s");
					$datainsert['updated_by']=1;
					$sql = new Sql($this->adapter );
					$update = $sql->update();
					$update->table('maingroup_master');
					$update->set($datainsert);
					$update->where( array('idMainGroup' => $editid));
					$statement  = $sql->prepareStatementForSqlObject($update);
					$results    = $statement->execute();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				}
				catch(\Exception $e){
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			} else {
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
			}
		}

       return $ret_arr;
	}


	public function subsidiaries($param)
	{
    
		    if($param->action=='list') 
		    {
			    $qry="SELECT a.idSubsidaryGroup,a.idMainGroup,a.idSubsidiariestype,a.subsidaryName,a.proposition,a.segment,a.status,b.mainGroupName FROM `subsidarygroup_master` as a LEFT JOIN maingroup_master as b on b.idMainGroup=a.idMainGroup ";
			    $result=$this->adapter->query($qry,array());
			    $resultset=$result->toArray();
			    if(!$resultset) 
			    {
				  $ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			    } 
			    else 
			    {
				$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'message'=>'System config information'];
			    }
		     }
		     if($param->action=='company') 
		    {
			    $qry="SELECT * FROM maingroup_master WHERE status=1";
			    $result=$this->adapter->query($qry,array());
			    $resultset=$result->toArray();
			    if(!$resultset) 
			    {
				  $ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			    } 
			    else 
			    {
				$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'message'=>'System config information'];
			    }
		     }
     		else if($param->action=='add') 
     		{
     		
     		
			
			$fiedls=$param->Form;
			$userid=$param->userid;
			$company=$fiedls['company'];
			$subcompany=$fiedls['subcompany'];
			$status=$fiedls['pstatus'];
			$qry="SELECT * FROM  subsidarygroup_master a where a.subsidaryName=?";
			$result=$this->adapter->query($qry,array($subcompany));
			$resultset=$result->toArray();
			if(!$resultset) 
			{ 
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['idMainGroup']=$fiedls['company'];
					$datainsert['idSubsidiariestype']=$fiedls['companytype'];
					$datainsert['subsidaryName']=$fiedls['subcompany'];
					$datainsert['proposition']=$fiedls['proposition'];
					$datainsert['segment']=$fiedls['segment'];
					$datainsert['created_at']=date("Y-m-d H:i:s"); 
					$datainsert['created_by']=1;
					$datainsert['status']=$fiedls['pstatus'];
					$insert=new Insert('subsidarygroup_master');
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
			 } 
			 else 
			 {
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
			  }
		    }  // add if close
            else if($param->action=='editview')
		    {
			     $editid=$param->company_id;
			     $qry="SELECT a.idSubsidaryGroup,a.idMainGroup,a.idSubsidiariestype,a.subsidaryName,a.proposition,a.segment,a.status,b.mainGroupName FROM `subsidarygroup_master` as a LEFT JOIN maingroup_master as b on b.idMainGroup=a.idMainGroup WHERE  a.idSubsidaryGroup=?";
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
		    }
		    else if($param->action=='update') 
		    {
			$fiedls=$param->Form;
			$userid=$param->userid;
			$company_id=$param->company_id;
			$editid=$fiedls['idSubsidaryGroup'];
			$qry="SELECT * FROM subsidarygroup_master where subsidaryName=? and idSubsidaryGroup!=?";
			$result=$this->adapter->query($qry,array($fiedls['subsidaryName'],$editid));
			$resultset=$result->toArray();
			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try{
					$datainsert['idMainGroup']=$fiedls['idMainGroup'];
					$datainsert['idSubsidiariestype']=$fiedls['idSubsidiariestype'];
					$datainsert['subsidaryName']=$fiedls['subsidaryName'];
					$datainsert['proposition']=$fiedls['proposition'];
					$datainsert['segment']=$fiedls['segment'];
					$datainsert['status']=$fiedls['status'];
					$datainsert['updated_at']=date("Y-m-d H:i:s");
					$datainsert['updated_by']=1;
					$sql = new Sql($this->adapter );
					$update = $sql->update();
					$update->table('subsidarygroup_master');
					$update->set($datainsert);
					$update->where( array('idSubsidaryGroup' => $editid));
					$statement  = $sql->prepareStatementForSqlObject($update);
					$results    = $statement->execute();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				}
				catch(\Exception $e){
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			} else {
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
			}
		}

       return $ret_arr;
	}

	public function categorylist($param){
		  $userData=$param->userData;
            $userid=$param->userid;
            $usertype=$param->usertype;
           // $idCustomer=$userData['idCustomer'];
		if($param->action=='list') {
			$qry="SELECT a.idCategory as id,a.category as name,a.status FROM category a";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if($resultset){
				$ret_arr=['code'=>'1','content'=>$resultset,'status'=>true,'message'=>'No of records'.count($resultset)];
			} else {
				$ret_arr=['code'=>'2','content'=>'','status'=>false,'message'=>'No records to view'];
			}
		}
		else if($param->action=='add'){
			$fiedls=$param->Form;
			$qry="SELECT * FROM category  where category=?";
			$result=$this->adapter->query($qry,array($fiedls['category_name']));
			$resultset=$result->toArray();
			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['category']=$fiedls['category_name'];
					$datainsert['status']=$fiedls['selectedstatus'];
					$datainsert['created_by']=1;
					$datainsert['created_at']=date('Y-m-d H:i:s');
					$insert=new Insert('category');
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
		}
		else if($param->action=='editview') {
			$editid=$param->id;
			$qry="SELECT a.idCategory,a.category as name,a.status FROM category a where a.idCategory=?";
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
			 $userid=$param->userid;
			$editid=$fiedls['idCategory'];
			$qry="SELECT a.idCategory,a.category FROM category a where a.category=? and a.idCategory!=?";
			$result=$this->adapter->query($qry,array($fiedls['name'],$editid));
			$resultset=$result->toArray();
			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try{
					$datainsert['category']=$fiedls['name'];
					$datainsert['status']=$fiedls['status'];
					$datainsert['updated_by']=1;
					$datainsert['updated_at']=date('Y-m-d H:i:s');
					$sql = new Sql($this->adapter);
					$update = $sql->update();
					$update->table('category');
					$update->set($datainsert);
					$update->where(array('idCategory' => $editid));
					$statement  = $sql->prepareStatementForSqlObject($update);
					$results    = $statement->execute();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				} catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
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

public function fulfillmentlist($param){
	if($param->action=='getorderfulfillment') {
		$qry="SELECT T1.idFulfillment AS id, T1.fulfillmentName AS name
				FROM fulfillment_master T1 
				where T1.status=1";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		if(!$resultset) {
			$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		} else {
			$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
		}
	}elseif($param->action=='updateOrderfulfillment'){
		$idFullfil=$param->idFullfil;
		$Orderid=$param->Orderid;
		$qry="SELECT T1.idOrder AS id FROM orders T1 where T1.status=? AND T1.idOrder=?";
		$result=$this->adapter->query($qry,array('1',$Orderid));
		$resultset=$result->toArray();
		
		if($resultset){
			$this->adapter->getDriver()->getConnection()->beginTransaction();
			try{
				$dataupdate['idOrderfullfillment']=$idFullfil;
				$sql = new Sql($this->adapter);
				$update = $sql->update();
				$update->table('orders');
				$update->set($dataupdate);
				$update->where(array('idOrder' => $Orderid));
				$statement  = $sql->prepareStatementForSqlObject($update);
				$results    = $statement->execute();
				$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
				$this->adapter->getDriver()->getConnection()->commit();
			} catch(\Exception $e) {
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
				$this->adapter->getDriver()->getConnection()->rollBack();
			}
		} else {
			$ret_arr=['code'=>'3','status'=>false,'message'=>'Please try again..'];
		}
	}
	return $ret_arr;

}
 public function subcategorylist($param){
 	$userData=$param->userData;
            $userid=$param->userid;
            // $usertype=$userData['user_type'];
            // $idCustomer=$userData['idCustomer'];
       	if($param->action=='getSubcatType') {
			$qry="SELECT c.idCategory as id,c.category as name 
			     FROM category c where c.status=1";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}
		else if($param->action=='list') {
			$qry="SELECT a.idSubCategory as id,CM.category as name,a.subcategory as subname,a.status 
			      FROM subcategory a
			      LEFT JOIN category CM on CM.idCategory =a.idCategory";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			
			if($resultset){
				$ret_arr=['code'=>'1','content'=>$resultset,'status'=>true,'message'=>'No of records'.count($resultset)];
			} else {
				$ret_arr=['code'=>'2','content'=>'','status'=>false,'message'=>'No records to view'];
			}
		}
		else if($param->action=='add'){
          $fiedls=$param->Form;
			$qry="SELECT * FROM subcategory  where subcategory=?";
			$result=$this->adapter->query($qry,array($fiedls['subcategory_name']));
			$resultset=$result->toArray();
			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['idCategory']=$fiedls['category_name'];
					$datainsert['subcategory']=$fiedls['subcategory_name'];
					$datainsert['status']=$fiedls['selectedstatus'];
					$datainsert['created_by']=1;
					$datainsert['created_at']=date('Y-m-d H:i:s');
					$insert=new Insert('subcategory');
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
		}
		else if($param->action=='editview') {
			$editid=$param->id;
			$qry="SELECT a.idSubCategory,CM.category as cname,CM.idCategory as name,a.subcategory as subname,a.status 
			      FROM subcategory a 
			      LEFT JOIN category CM on CM.idCategory =a.idCategory
			      where a.idSubCategory=?";
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
			$userid=$param->userid;
			$editid=$fiedls['idSubCategory'];
			$qry="SELECT a.idSubCategory,a.subcategory 
			      FROM subcategory a 
			      where a.subcategory=? and a.idSubCategory!=?";
			$result=$this->adapter->query($qry,array($fiedls['subname'],$editid));
			$resultset=$result->toArray();
			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try{
					$datainsert['idCategory']=$fiedls['name'];
					$datainsert['subcategory']=$fiedls['subname'];
					$datainsert['status']=$fiedls['status'];
					$datainsert['updated_by']=1;
					$datainsert['updated_at']=date('Y-m-d H:i:s');
					$sql = new Sql($this->adapter);
					$update = $sql->update();
					$update->table('subcategory');
					$update->set($datainsert);
					$update->where(array('idSubCategory' => $editid));
					$statement  = $sql->prepareStatementForSqlObject($update);
					$results    = $statement->execute();
					
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				} catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
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

/*-------------------------------Nive functions--------------------------------------------------*/

		public function subpackageadd($param){
		if($param->action =='list'){
			$qry="SELECT * FROM sub_packaging";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			}else{
				$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'message'=>'System config information'];
			}

		}else if($param->action=='add') {
			$fiedls=$param->Form;
			$userid=$param->userid;
			$qry="SELECT * FROM sub_packaging where subpackname=?";
			$result=$this->adapter->query($qry,array($fiedls['subpackage']));
			$resultset=$result->toArray();
			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['subpackname']=$fiedls['subpackage'];
					$datainsert['status']=$fiedls['subpackgestatus'];
					$datainsert['created_by']=1;
					$datainsert['created_at']=date('Y-m-d H:i:s');
					$insert=new Insert('sub_packaging');
					$insert->values($datainsert);
					$statement=$this->adapter->createStatement();
					$insert->prepareStatement($this->adapter, $statement);
					$insertresult=$statement->execute();
					$question_id=$this->adapter->getDriver()->getLastGeneratedValue();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				}catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			} else {
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
			}
		}else if($param->action=='editview'){
			$editid=$param->id;
			$qry="SELECT idSubPackaging as id,subpackname as subpackage,status as subpackgestatus FROM sub_packaging where idSubPackaging=?";
			$result=$this->adapter->query($qry,array($editid));
			$resultset=$result->toArray();
			if(!$resultset){
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			}else{
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='update'){
			$fiedls=$param->Form;
			$userid=$param->userid;
			$editid=$fiedls['id'];
			$qry="SELECT * FROM sub_packaging where subpackname=? and idSubPackaging!=?";
			$result=$this->adapter->query($qry,array($fiedls['subpackage'],$editid));
			$resultset=$result->toArray();
			if(!$resultset) {
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$data['subpackname']=$fiedls['subpackage'];
					$data['status']=$fiedls['subpackgestatus'];
					$data['updated_by']=1;
					$data['updated_at']=date('Y-m-d H:i:s');
					$sql = new Sql($this->adapter);
					$update = $sql->update();
					$update->table('sub_packaging');
					$update->set($data);
					$update->where( array('idSubPackaging' => $editid));
					$statement  = $sql->prepareStatementForSqlObject($update);
					$results    = $statement->execute();
					$this->adapter->getDriver()->getConnection()->commit();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
				} catch (\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again'];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			} else {
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
			}
		} else {
			$ret_arr=['code'=>'3','content'=>'','status'=>false,'message'=>'Please contact the administrator'];
		}
		return $ret_arr;
	}


	public function productstatusadd($param){
		if($param->action =='list'){
			$qry="SELECT * FROM product_status";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			}else{
				$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'message'=>'System config information'];
			}

		}else if($param->action=='add') {
			$fiedls=$param->Form;
			$userid=$param->userid;
			$qry="SELECT * FROM product_status where productStatus=?";
			$result=$this->adapter->query($qry,array($fiedls['prductstatus']));
			$resultset=$result->toArray();
			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['productStatus']=$fiedls['prductstatus'];
					$datainsert['status']=$fiedls['status'];
					$datainsert['created_by']=1;
					$datainsert['created_at']=date('Y-m-d H:i:s');
					$insert=new Insert('product_status');
					$insert->values($datainsert);
					$statement=$this->adapter->createStatement();
					$insert->prepareStatement($this->adapter, $statement);
					$insertresult=$statement->execute();
					$question_id=$this->adapter->getDriver()->getLastGeneratedValue();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				}catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			} else {
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
			}
		}else if($param->action=='editview'){
			$editid=$param->id;
			$qry="SELECT idProductStatus as id,productStatus as prductstatus,status as status FROM product_status where idProductStatus=?";
			$result=$this->adapter->query($qry,array($editid));
			$resultset=$result->toArray();
			if(!$resultset){
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			}else{
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='update'){
			$fiedls=$param->Form;
			$userid=$param->userid;
			$editid=$fiedls['id'];
			$qry="SELECT * FROM product_status where productStatus=? and idProductStatus!=?";
			$result=$this->adapter->query($qry,array($fiedls['prductstatus'],$editid));
			$resultset=$result->toArray();
			if(!$resultset) {
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$data['productStatus']=$fiedls['prductstatus'];
					$data['status']=$fiedls['status'];
					$data['updated_by']=1;
					$data['updated_at']=date('Y-m-d H:i:s');
					$sql = new Sql($this->adapter);
					$update = $sql->update();
					$update->table('product_status');
					$update->set($data);
					$update->where( array('idProductStatus' => $editid));
					$statement  = $sql->prepareStatementForSqlObject($update);
					$results    = $statement->execute();
					$this->adapter->getDriver()->getConnection()->commit();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
				} catch (\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again'];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			} else {
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
			}
		} else {
			$ret_arr=['code'=>'3','content'=>'','status'=>false,'message'=>'Please contact the administrator'];
		}
		return $ret_arr;
	}

	public function customertypeadd($param){
		if($param->action =='list'){
			$qry="SELECT * FROM customertype";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			}else{
				$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'message'=>'System config information'];
			}

		}else if($param->action=='add') {
			$fiedls=$param->Form;
			$userid=$param->userid;
			$qry="SELECT * FROM customertype where custType=?";
			$result=$this->adapter->query($qry,array($fiedls['custtype']));
			$resultset=$result->toArray();

			$qrylevel="SELECT * FROM customertype where level=? ";
			$resultlevel=$this->adapter->query($qrylevel,array($fiedls['custlevel']));
			$resultsetlevel=$resultlevel->toArray();
//print_r($resultsetlevel);

			if($resultset) {
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Customer type already exists'];
			}else if($resultsetlevel){
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Customer level already exists'];
			}else{
			
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['custType']=$fiedls['custtype'];
					$datainsert['level']=$fiedls['custlevel'];
					$datainsert['status']=$fiedls['custstatus'];
					$datainsert['created_by']=1;
					$datainsert['created_at']=date('Y-m-d H:i:s');
					$insert=new Insert('customertype');
					$insert->values($datainsert);
					$statement=$this->adapter->createStatement();
					$insert->prepareStatement($this->adapter, $statement);
					$insertresult=$statement->execute();
					$question_id=$this->adapter->getDriver()->getLastGeneratedValue();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				}catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			} 
		}else if($param->action=='editview'){
			$editid=$param->id;
			$qry="SELECT idCustomerType as id,custType as custtype,level as custlevel,status as custstatus FROM customertype where idCustomerType=?";
			$result=$this->adapter->query($qry,array($editid));
			$resultset=$result->toArray();
			if(!$resultset){
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			}else{
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='update'){
			$fiedls=$param->Form;
			$editid=$fiedls['id'];
			$userid=$param->userid;
			$qry="SELECT * FROM customertype where custType=? and idCustomerType!=?";
			$result=$this->adapter->query($qry,array($fiedls['custtype'],$editid));
			$resultset=$result->toArray();


			$qrylevel="SELECT * FROM customertype where level=?  and idCustomerType!=?";
			
			$resultlevel=$this->adapter->query($qrylevel,array($fiedls['custlevel'],$editid));
			$resultsetlevel=$resultlevel->toArray();
//print_r($resultsetlevel);

			if($resultset) {
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Customer type already exists'];
			}else if($resultsetlevel){
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Customer level already exists'];
			}else{
			
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$data['custType']=$fiedls['custtype'];
					$data['level']=$fiedls['custlevel'];
					$data['status']=$fiedls['custstatus'];
					$data['updated_by']=1;
					$data['updated_at']=date('Y-m-d H:i:s');
					$sql = new Sql($this->adapter);
					$update = $sql->update();
					$update->table('customertype');
					$update->set($data);
					$update->where( array('idCustomerType' => $editid));
					$statement  = $sql->prepareStatementForSqlObject($update);
					$results    = $statement->execute();
					$this->adapter->getDriver()->getConnection()->commit();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
				} catch (\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again'];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			} 
		} else {
			$ret_arr=['code'=>'3','content'=>'','status'=>false,'message'=>'Please contact the administrator'];
		}
		return $ret_arr;
	}

	public function designation($param){
		if($param->action =='list'){
			$qry="SELECT T1.idDesignation as id,T1.name as name, T1.status as status 
			FROM designation as T1";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			}else{
				$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'message'=>'System config information'];
			}
		}elseif ($param->action =='add') {
			$fiedls=$param->Form;
			$userid=$param->userid;
			$qry="SELECT * FROM designation where name=?";
			$result=$this->adapter->query($qry,array($fiedls['designation']));
			$resultset=$result->toArray();
			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['name']=$fiedls['designation'];
					$datainsert['status']=$fiedls['pstatus'];
					$datainsert['created_by']=1;
					$datainsert['created_at']=date('Y-m-d H:i:s');
					$insert=new Insert('designation');
					$insert->values($datainsert);
					$statement=$this->adapter->createStatement();
					$insert->prepareStatement($this->adapter, $statement);
					$insertresult=$statement->execute();

					$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				}catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			} else {
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
			}

		}elseif ($param->action =='editview') {
			$editid=$param->design_id;
			$qry="SELECT idDesignation as id,name as designation,status as pstatus FROM designation where idDesignation=?";
			$result=$this->adapter->query($qry,array($editid));
			$resultset=$result->toArray();
			if(!$resultset){
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			}else{
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}elseif ($param->action =='update') {
			$fiedls=$param->Form;
			$editid=$fiedls['id'];
			$userid=$param->userid;
			$qry="SELECT * FROM designation where name=? and idDesignation!=?";
			$result=$this->adapter->query($qry,array($fiedls['designation'],$editid));
			$resultset=$result->toArray();
			if(!$resultset) {
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$data['name']=$fiedls['designation'];
					$data['status']=$fiedls['pstatus'];
					$data['updated_by']=1;
					$data['updated_at']=date('Y-m-d H:i:s');
					$sql = new Sql($this->adapter);
					$update = $sql->update();
					$update->table('designation');
					$update->set($data);
					$update->where( array('idDesignation' => $editid));
					$statement  = $sql->prepareStatementForSqlObject($update);
					$results    = $statement->execute();
					$this->adapter->getDriver()->getConnection()->commit();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
				} catch (\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again'];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			} else {
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
			}
		}else {
			$ret_arr=['code'=>'3','content'=>'','status'=>false,'message'=>'Please contact the administrator'];
		}
		return $ret_arr;
	}
	public function chanelcustomeradd($param){
		if($param->action =='list'){
			$qry="SELECT cc.idCustomerChannel as id,ct.custType as custmrtype,c.Channel as  chanelcustmer,cc.status as status 
				  FROM customer_channel as cc
				  JOIN customertype as ct ON ct.idCustomerType=cc.idCustomerType
				  JOIN channel as c ON c.idChannel=cc.idChannel
				  ";

			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			}else{
				$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'message'=>'System config information'];
			}

		}else if($param->action =='channeldropdown'){
			$qry="SELECT * FROM channel";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			}else{
				$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'message'=>'System config information'];
			}

		}
		else if($param->action =='custmrtypedropdown'){
			$qry="SELECT * FROM customertype WHERE status=1";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			}else{
				$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'message'=>'System config information'];
			}

		}
		else if($param->action =='subsidiariedropdown'){
			$qry="SELECT * FROM subsidarygroup_master";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			}else{
				$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'message'=>'System config information'];
			}

		}
		else if($param->action=='add'){
			$fiedls=$param->Form;
			$userid=$param->userid;
		
			$qry="SELECT cc.idCustomerChannel as id,ct.idCustomerType as custmrtype,c.idChannel as  chanelcustmer,cc.status as channelstatus,c.Channel as channel,ct.custType as custtype
				  FROM customer_channel as cc
				  JOIN customertype as ct ON ct.idCustomerType=cc.idCustomerType
				  JOIN channel as c ON c.idChannel=cc.idChannel where c.idChannel=? and ct.idCustomerType=?";
			$result=$this->adapter->query($qry,array($fiedls['chanelcustmer'],$fiedls['custmrtype']));
			$resultset=$result->toArray();
			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['idCustomerType']=$fiedls['custmrtype'];
					$datainsert['idChannel']=$fiedls['chanelcustmer'];
					$datainsert['idSubsidaryGroup']=$fiedls['subdiarie'];
					$datainsert['status']=$fiedls['channelstatus'];
					$datainsert['created_by']=1;
					$datainsert['created_at']=date('Y-m-d H:i:s');
					$insert=new Insert('customer_channel');
					$insert->values($datainsert);
					$statement=$this->adapter->createStatement();
					$insert->prepareStatement($this->adapter, $statement);
					$insertresult=$statement->execute();
					$question_id=$this->adapter->getDriver()->getLastGeneratedValue();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				}catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			} else {
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
			}
		}else if($param->action=='editview'){
			$editid=$param->id;
			$qry="SELECT cc.idCustomerChannel as id,ct.idCustomerType as custmrtype,c.idChannel as  chanelcustmer,cc.status as channelstatus,c.Channel as channel,ct.custType as custtype
				  FROM customer_channel as cc
				  JOIN customertype as ct ON ct.idCustomerType=cc.idCustomerType
				  JOIN channel as c ON c.idChannel=cc.idChannel 
				  
				  where idCustomerChannel=?";
			$result=$this->adapter->query($qry,array($editid));
			$resultset=$result->toArray();
			if(!$resultset){
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			}else{
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='update'){
			$fiedls=$param->Form;
			$editid=$fiedls['id'];
			$userid=$param->userid;
			$qry="SELECT cc.idCustomerChannel as id,ct.idCustomerType as custmrtype,c.idChannel as  chanelcustmer,cc.status as channelstatus,c.Channel as channel,ct.custType as custtype,sm.subsidaryName as subdairyname,sm.idSubsidaryGroup as subdiarie
				  FROM customer_channel as cc
				  JOIN customertype as ct ON ct.idCustomerType=cc.idCustomerType
				  JOIN channel as c ON c.idChannel=cc.idChannel 
				  JOIN subsidarygroup_master as sm ON sm.idSubsidaryGroup=cc.idSubsidaryGroup
				  where c.idChannel=? and ct.idCustomerType=? and sm.idSubsidaryGroup=? and  idCustomerChannel!=?";
			$result=$this->adapter->query($qry,array($fiedls['chanelcustmer'],$fiedls['custmrtype'],$fiedls['subdiarie'],$editid));
			$resultset=$result->toArray();
			if(!$resultset) {
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['idCustomerType']=$fiedls['custmrtype'];
					$datainsert['idChannel']=$fiedls['chanelcustmer'];
					$datainsert['idSubsidaryGroup']=$fiedls['subdiarie'];
					$datainsert['status']=$fiedls['channelstatus'];
					$datainsert['updated_by']=1;
					$datainsert['updated_at']=date('Y-m-d H:i:s');
					$sql = new Sql($this->adapter);
					$update = $sql->update();
					$update->table('customer_channel');
					$update->set($datainsert);
					$update->where( array('idCustomerChannel' => $editid));
					$statement  = $sql->prepareStatementForSqlObject($update);
					$results    = $statement->execute();
					$this->adapter->getDriver()->getConnection()->commit();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
				} catch (\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			} else {
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
			}
		} else {
			$ret_arr=['code'=>'3','content'=>'','status'=>false,'message'=>'Please contact the administrator'];
		}
		return $ret_arr;
	}

/*--------------------------------------------------------------------------------------*/	
	public function employee_details($param) {
		if($param->action=='list') {
		$qry="SELECT A.*,B.tm_group_id,B.tm_group_name,C.name AS reporting_manager,C.idTeamMember AS reporting_manager_id,des.name as designationName FROM team_member_master AS A LEFT JOIN team_member_groups B ON B.tm_group_id=A.designation LEFT JOIN team_member_master C ON C.idTeamMember=A.reportingTo LEFT JOIN designation as des on des.idDesignation=A.designation";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		$ret_arr=['code'=>'1','status'=>true,'message'=>'Employee details','content' =>$resultset];
		} else {
			$ret_arr=['code'=>'2','status'=>false,'message'=>'parameter missing, try again!!!'];
		}
		return $ret_arr;
	}

	public function secondary_package($param) {

        if($param->action =='list'){
			$qry="SELECT sp.secondarypackname as name,sp.status as status,sp.idSecondaryPackaging as id,pp.primarypackname as primarypackname,sub.subpackname as subpackname
			   FROM secondary_packaging as sp
			   LEFT JOIN primary_packaging as pp ON pp.idPrimaryPackaging=sp.idPrimaryPackaging
			   LEFT JOIN sub_packaging as sub ON sub.idSubPackaging=sp.idSubPackaging";

			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if($resultset){
				$ret_arr=['code'=>'1','content'=>$resultset,'status'=>true,'message'=>'No of records'];
			} else {
				$ret_arr=['code'=>'2','content'=>'','status'=>false,'message'=>'No records to view'];
			}

			return $ret_arr;

		}else if($param->action=='subpackagedropdown'){
			$qry="SELECT * FROM sub_packaging where status='1'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			}else{
				$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'message'=>'System config information'];
			}

		}else if($param->action=='primarypackagedropdown'){
			$qry="SELECT * FROM primary_packaging where status='1'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			}else{
				$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'message'=>'System config information'];
			}

		}    
		else if($param->action=='add') {	
			$fiedls=$param->Form;
			$userid=$param->userid;
			$qry="SELECT sp.secondarypackname,sp.status,sp.idSecondaryPackaging,pp.idPrimaryPackaging as primarypackge,sub.idSubPackaging as subpackage
			   FROM secondary_packaging as sp
			   LEFT JOIN primary_packaging as pp ON pp.idPrimaryPackaging=sp.idPrimaryPackaging
			   LEFT JOIN sub_packaging as sub ON sub.idSubPackaging=sp.idSubPackaging 
			   where sp.secondarypackname=? and pp.idPrimaryPackaging=? and sub.idSubPackaging=?";
			$result=$this->adapter->query($qry,array($fiedls['secondary_package'],$fiedls['primarypackge'],$fiedls['subpackage']));
			$resultset=$result->toArray();
			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['idPrimaryPackaging']=$fiedls['primarypackge'];
					$datainsert['secondarypackname']=$fiedls['secondary_package'];
					$datainsert['idSubPackaging']=$fiedls['subpackage'];
					$datainsert['status']=$fiedls['status'];
					$datainsert['created_at']=date('Y-m-d H:i:s');
					$datainsert['created_by']=1;
					$datainsert['updated_at']=date('Y-m-d H:i:s');
					$datainsert['updated_by']=1;
					$insert=new Insert('secondary_packaging');
					$insert->values($datainsert);
					$statement=$this->adapter->createStatement();
					$insert->prepareStatement($this->adapter, $statement);
					$insertresult=$statement->execute();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				} catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			} else {
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
			}
		} else if($param->action=='editview') {
			$editid=$param->id;		

		   $qry="SELECT sp.secondarypackname as second,sp.status as status,sp.idSecondaryPackaging as id,sub.idSubPackaging as subpackage,pp.idPrimaryPackaging as primarypackge,pp.primarypackname as primarypackname,sub.subpackname as subpackname 
			   FROM secondary_packaging as sp 
			   LEFT JOIN primary_packaging as pp ON pp.idPrimaryPackaging=sp.idPrimaryPackaging
			   LEFT JOIN sub_packaging as sub ON sub.idSubPackaging=sp.idSubPackaging 
			   where sp.idSecondaryPackaging=?";

			$result=$this->adapter->query($qry,array($editid));
			$resultset=$result->toArray();
			if(!$resultset){
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		} else if($param->action=='update') {

			$fiedls=$param->forms;
			$userid=$param->userid;
			$editid=$fiedls['id'];
			$qry="SELECT pp.idPrimaryPackaging as primarypackge,sub.idSubPackaging as subpackage,sp.idSecondaryPackaging 
				  FROM secondary_packaging as sp
				  LEFT JOIN primary_packaging as pp ON pp.idPrimaryPackaging=sp.idPrimaryPackaging
			      LEFT JOIN sub_packaging as sub ON sub.idSubPackaging=sp.idSubPackaging  
			      where sp.secondarypackname=? and pp.idPrimaryPackaging=? and sub.idSubPackaging=? and idSecondaryPackaging!=?";
			$result=$this->adapter->query($qry,array($fiedls['second'],$fiedls['primarypackge'],$fiedls['subpackage'],$editid));
			$resultset=$result->toArray();
			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['idSecondaryPackaging']=$fiedls['id'];
					$datainsert['idSubPackaging']=$fiedls['subpackage'];
					$datainsert['secondarypackname']=$fiedls['second'];
					$datainsert['idPrimaryPackaging']=$fiedls['primarypackge'];
					$datainsert['status']=$fiedls['status'];
					$datainsert['created_at']=date('Y-m-d H:i:s');
					$datainsert['created_by']=1;
					$datainsert['updated_at']=date('Y-m-d H:i:s');
					$datainsert['updated_by']=1;
					$sql = new Sql($this->adapter);
					$update = $sql->update();
					$update->table('secondary_packaging');
					$update->set($datainsert);
					$update->where( array('idSecondaryPackaging' => $editid));
					$statement  = $sql->prepareStatementForSqlObject($update);
					$results    = $statement->execute();
					$ret_arr=['code'=>'2','status'=>true,'message'=>' Updated successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				} catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			} else {
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
			}
		} else {
			$ret_arr=['code'=>'3','content'=>'','status'=>false,'message'=>'Please contact the administrator'];
		}
		return $ret_arr;
	}


/*.......Mari.......*/

public function vehiclelist($param){
		if($param->action=='list') {
			$qry="SELECT a.idVehicle as id,a.vehicleName as name,a.vehicleCapacity as capacity,a.vehiclePerKm as perkm,a.vehicleMinCharge as mincharge,a.status FROM vehicle_master a ";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if($resultset){
				$ret_arr=['code'=>'1','content'=>$resultset,'status'=>true,'message'=>'No of records'.count($resultset)];
			} else {
				$ret_arr=['code'=>'2','content'=>'','status'=>false,'message'=>'No records to view'];
			}
		}
		else if($param->action=='add'){
          	$fiedls=$param->Form;
			$userid=$param->userid;
			$qry="SELECT * FROM vehicle_master  where vehicleName=?";
			$result=$this->adapter->query($qry,array($fiedls['vehicle_name']));
			$resultset=$result->toArray();
			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['vehicleName']=$fiedls['vehicle_name'];
					$datainsert['vehicleCapacity']=$fiedls['capacity'];
					$datainsert['vehiclePerKm']=$fiedls['perkm'];
					$datainsert['vehicleMinCharge']=$fiedls['mincharge'];
					$datainsert['status']=$fiedls['selectedstatus'];
					$datainsert['created_by']=1;
					$datainsert['created_at']=date('Y-m-d H:i:s');
					$insert=new Insert('vehicle_master');
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
			$qry="SELECT a.idVehicle as id,a.vehicleName as vehicle_name,a.vehicleCapacity as capacity,a.vehiclePerKm as perkm,a.vehicleMinCharge as mincharge,a.status FROM vehicle_master a where a.idVehicle=?";
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
			
			$userid=$param->userid;
			$editid=$fiedls['id'];
			$qry="SELECT a.idVehicle,a.vehicleName FROM vehicle_master a where a.vehicleName=? and a.idVehicle!=?";
			$result=$this->adapter->query($qry,array($fiedls['vehicle_name'],$editid));
			$resultset=$result->toArray();
			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try{
					$datainsert['vehicleName']=$fiedls['vehicle_name'];
					$datainsert['vehicleCapacity']=$fiedls['capacity'];
					$datainsert['vehiclePerKm']=$fiedls['perkm'];
					$datainsert['vehicleMinCharge']=$fiedls['mincharge'];
					$datainsert['status']=$fiedls['status'];
					$datainsert['updated_by']=1;
					$datainsert['updated_at']=date('Y-m-d H:i:s');
					$sql = new Sql($this->adapter);
					$update = $sql->update();
					$update->table('vehicle_master');
					$update->set($datainsert);
					$update->where(array('idVehicle' => $editid));
					$statement  = $sql->prepareStatementForSqlObject($update);
					$results    = $statement->execute();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				} catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
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

		public function agencylist($param){
		if($param->action=='list') {
			$qry="SELECT a.idAgency as id,a.agencyName as name,a.agencyEmail as email,a.agencyMobileNo as mobno,a.status FROM agency_master a ";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();

			$qry1="SELECT IF(hm.title !='',hm.title,'H1') AS H1 FROM territorytitle_master hm where hm.idTerritoryTitle=1  AND hm.title!=''";
			$result1=$this->adapter->query($qry1,array());
			$resultset1=$result1->toArray();
          
			$qry2="SELECT IF(hm.title !='',hm.title,'H2') AS H2 FROM territorytitle_master hm where hm.idTerritoryTitle=2  AND hm.title!=''";
			$result2=$this->adapter->query($qry2,array());
			$resultset2=$result2->toArray();

			$qry3="SELECT IF(hm.title !='',hm.title,'H3') AS H3 FROM territorytitle_master hm where hm.idTerritoryTitle=3 AND hm.title!=''";
			$result3=$this->adapter->query($qry3,array());
			$resultset3=$result3->toArray();

			$qry4="SELECT IF(hm.title !='',hm.title,'H4') AS H4 FROM territorytitle_master hm where hm.idTerritoryTitle=4 AND hm.title!=''";
			$result4=$this->adapter->query($qry4,array());
			$resultset4=$result4->toArray();

			$qry5="SELECT IF(hm.title !='',hm.title,'H5') AS H5 FROM territorytitle_master hm where hm.idTerritoryTitle=5 AND hm.title!=''";
			$result5=$this->adapter->query($qry5,array());
			$resultset5=$result5->toArray();

			$qry6="SELECT IF(hm.title !='',hm.title,'H6') AS H6 FROM territorytitle_master hm where hm.idTerritoryTitle=6 AND hm.title!=''";
			$result6=$this->adapter->query($qry6,array());
			$resultset6=$result6->toArray();

			$qry7="SELECT IF(hm.title !='',hm.title,'H7') AS H7 FROM territorytitle_master hm where hm.idTerritoryTitle=7 AND hm.title!=''";
			$result7=$this->adapter->query($qry7,array());
			$resultset7=$result7->toArray();

			$qry8="SELECT IF(hm.title !='',hm.title,'H8') AS H8 FROM territorytitle_master hm where hm.idTerritoryTitle=8 AND hm.title!=''";
			$result8=$this->adapter->query($qry8,array());
			$resultset8=$result8->toArray();

			$qry9="SELECT IF(hm.title !='',hm.title,'H9') AS H9 FROM territorytitle_master hm where hm.idTerritoryTitle=9 AND hm.title!=''";
			$result9=$this->adapter->query($qry9,array());
			$resultset9=$result9->toArray();

			$qry10="SELECT IF(hm.title !='',hm.title,'H10') AS H10 FROM territorytitle_master hm where hm.idTerritoryTitle=10 AND hm.title!=''";
			$result10=$this->adapter->query($qry10,array());
			$resultset10=$result10->toArray();
			
			
			if($resultset1){
				$ret_arr=['code'=>'1','content'=>$resultset,'contentlist1'=>$resultset1,'contentlist2'=>$resultset2,'contentlist3'=>$resultset3,'contentlist4'=>$resultset4,'contentlist5'=>$resultset5,'contentlist6'=>$resultset6,'contentlist7'=>$resultset7,'contentlist8'=>$resultset8,'contentlist9'=>$resultset9,'contentlist10'=>$resultset10,'status'=>true,'message'=>'No of records'.count($resultset)];
			} else {
				$ret_arr=['code'=>'2','content'=>'','status'=>false,'message'=>'No records to view'];
			}
		}
		else if($param->action=='add'){
			$userid=$param->userid;
			
			$uploads_dir ='public/uploads/agency';
			//print_r($_FILES);

			if($_FILES) {
				$tmp_name=$_FILES["agencyfile"]["tmp_name"];
				$name =basename($_FILES["agencyfile"]["name"]);
				$imageName ='agency_'.date('dmyHi').'.'.pathinfo($_FILES["agencyfile"]['name'],PATHINFO_EXTENSION);
				//$ext=strtolower(pathinfo($_FILES["agencyfile"]['name'],PATHINFO_EXTENSION));
				// $ext=='jpeg' || $ext=='png' ||  $ext=='jpg'
				if($imageName){
					if(move_uploaded_file($tmp_name,"$uploads_dir/$imageName")==false) {
						$ret_arr=['code'=>'3','status'=>false,'message'=>'Please try again.. Failed to upload agency file..'];
						$rollBack=true;	
					}  else {
						$data['image']=trim($imageName);
					}
				} else {
					$ret_arr=['code'=>'3','status'=>false,'message'=>'Please select valid format for agency file..'];
					$rollBack=true;	
				}
			}

			//print_r($imageName);
			//one state have only one agency
			$qryState="SELECT * FROM agency_master  where t2=?";
			$resultState=$this->adapter->query($qryState,array($param->territory2));
			$resultsetState=$resultState->toArray();

			$qry="SELECT * FROM agency_master  where agencyName=?";
			$result=$this->adapter->query($qry,array($param->agncyname));
			$resultset=$result->toArray();

			$qryEmail="SELECT * FROM agency_master  where agencyEmail=?";
			$resultEmail=$this->adapter->query($qryEmail,array($param->email));
			$resultsetEmail=$resultEmail->toArray();

			$qryMobile="SELECT * FROM agency_master  where agencyMobileNo=?";
			$resultMobile=$this->adapter->query($qryMobile,array($param->mobile_no));
			$resultsetMobile=$resultMobile->toArray();

             if (count($resultsetState)>0) 
             {
             	$ret_arr=['code'=>'1','status'=>false,'message'=>'Territory2 already exist'];
             }
             else if(count($resultset)>0)
             {
               $ret_arr=['code'=>'1','status'=>false,'message'=>'Agency name already exist'];
             }
             else if(count($resultsetEmail)>0)
             {
               $ret_arr=['code'=>'1','status'=>false,'message'=>'Email id already exist'];
             }
              else if(count($resultsetMobile)>0)
             {
               $ret_arr=['code'=>'1','status'=>false,'message'=>'Mobile number already exist'];
             }
             else{
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['agencyName']=$param->agncyname;
					$datainsert['agencyEmail']=$param->email;
					$datainsert['agencyMobileNo']=$param->mobile_no;
					if ($imageName!='') {
					$datainsert['agencyFile']=$imageName;
					$datainsert['agencyFile_path']='uploads/agency/'.$imageName;
					} 	
					$datainsert['t1']=($param->territory1!='' && $param->territory1!=undefined )?$param->territory1:0;
					$datainsert['t2']=($param->territory2!='' && $param->territory2!=undefined )?$param->territory2:0;
					$datainsert['t3']=($param->territory3!='' && $param->territory3!=undefined )?$param->territory3:0;
					$datainsert['t4']=($param->territory4!='' && $param->territory4!=undefined )?$param->territory4:0;
					$datainsert['t5']=($param->territory5!='' && $param->territory5!=undefined )?$param->territory5:0;
					$datainsert['t6']=($param->territory6!='' && $param->territory6!=undefined )?$param->territory6:0;
					$datainsert['t7']=($param->territory7!='' && $param->territory7!=undefined )?$param->territory7:0;
					$datainsert['t8']=($param->territory8!='' && $param->territory8!=undefined )?$param->territory8:0;
					$datainsert['t9']=($param->territory9!='' && $param->territory9!=undefined )?$param->territory9:0;
					$datainsert['t10']=($param->territory10!='' && $param->territory10!=undefined )?$param->territory10:0;	
					
					$datainsert['status']=$param->selectedstatus;
					$datainsert['created_by']=1;
					$datainsert['created_at']=date('Y-m-d H:i:s');
					$insert=new Insert('agency_master');
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
		}
		else if($param->action=='editview') {
			$editid=$param->id;
			$qry="SELECT a.*,a.idAgency as id,a.agencyName as agncyname,a.agencyFile_path as agency_file,a.agencyEmail as email,a.agencyMobileNo as mobile_no,HT1.territoryValue as territory1Sel,HT2.territoryValue as territory2Sel,HT3.territoryValue as territory3Sel,HT4.territoryValue as territory4Sel,HT5.territoryValue as territory5Sel,HT6.territoryValue as territory6Sel,HT7.territoryValue as territory7Sel,HT8.territoryValue as territory8Sel,HT9.territoryValue as territory9Sel,HT10.territoryValue as territory10Sel,a.status
			    FROM agency_master a 
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
			     where a.idAgency=?";
			$result=$this->adapter->query($qry,array($editid));
			$resultset=$result->toArray();

			$qrytery="SELECT * FROM agency_master a where a.idAgency=?";

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
			if(!$resultset){
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'terytitle' =>$resultset_terytitle,'tertitle'=>$tery_title,'status'=>true,'message'=>'Record available'];
			}
		}
		else if($param->action=='update') {
			$userid=$param->userid;
			$editid=$param->agencyid;
			
			// $qry="SELECT a.idAgency,a.agencyName FROM agency_master a where a.idAgency='$editid'";
			// $result=$this->adapter->query($qry,array());
			// $resultset=$result->toArray();
			$uploads_dir ='public/uploads/agency';
			if($_FILES) {
				$tmp_name=$_FILES["agencyfile"]["tmp_name"];
				$name =basename($_FILES["agencyfile"]["name"]);
				$imageName ='agency_'.date('dmyHi').'.'.pathinfo($_FILES["agencyfile"]['name'],PATHINFO_EXTENSION);
				//$ext=strtolower(pathinfo($_FILES["agencyfile"]['name'],PATHINFO_EXTENSION));
				if($imageName){
					if(move_uploaded_file($tmp_name,
						"$uploads_dir/$imageName")==false) {
						$ret_arr=['code'=>'3','status'=>false,'message'=>'Please try again.. Failed to upload agency file..'];
						$rollBack=true;	
					}  else {
						$data['image']=trim($imageName);
					}
				} else {
					$ret_arr=['code'=>'3','status'=>false,'message'=>'Please select valid format for agency file..'];
					$rollBack=true;	
				}
			}
			else{
				$imageName=Null;

			}

			$qryState="SELECT * FROM agency_master  where t2=? AND idAgency!='$editid'";
			$resultState=$this->adapter->query($qryState,array($param->t2));
			$resultsetState=$resultState->toArray();

			$qry="SELECT * FROM agency_master  where agencyName=? AND idAgency!='$editid'";
			$result=$this->adapter->query($qry,array($param->agncyname));
			$resultset=$result->toArray();

			$qryEmail="SELECT * FROM agency_master  where agencyEmail=? AND idAgency!='$editid'";
			$resultEmail=$this->adapter->query($qryEmail,array($param->email));
			$resultsetEmail=$resultEmail->toArray();

			$qryMobile="SELECT * FROM agency_master  where agencyMobileNo=? AND idAgency!='$editid'";
			$resultMobile=$this->adapter->query($qryMobile,array($param->mobile_no));
			$resultsetMobile=$resultMobile->toArray();

             if (count($resultsetState)>0) 
             {
             	$ret_arr=['code'=>'1','status'=>false,'message'=>'Territory2 already exist'];
             }
             else if(count($resultset)>0)
             {
               $ret_arr=['code'=>'1','status'=>false,'message'=>'Agency name already exist'];
             }
             else if(count($resultsetEmail)>0)
             {
               $ret_arr=['code'=>'1','status'=>false,'message'=>'Email id already exist'];
             }
              else if(count($resultsetMobile)>0)
             {
               $ret_arr=['code'=>'1','status'=>false,'message'=>'Mobile number already exist'];
             }
             else{
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try{
				    $datainsert['agencyName']=$param->agncyname;
					$datainsert['agencyEmail']=$param->email;
					$datainsert['agencyMobileNo']=$param->mobile_no;
					if ($imageName!='') {
					$datainsert['agencyFile']=$imageName;
					$datainsert['agencyFile_path']='uploads/agency/'.$imageName;
					} 	
					$datainsert['t1']=($param->t1!='' && $param->t1!=undefined )?$param->t1:0;
					$datainsert['t2']=($param->t2!='' && $param->t2!=undefined )?$param->t2:0;
					$datainsert['t3']=($param->t3!='' && $param->t3!=undefined )?$param->t3:0;
					$datainsert['t4']=($param->t4!='' && $param->t4!=undefined )?$param->t4:0;
					$datainsert['t5']=($param->t5!='' && $param->t5!=undefined )?$param->t5:0;
					$datainsert['t6']=($param->t6!='' && $param->t6!=undefined )?$param->t6:0;
					$datainsert['t7']=($param->t7!='' && $param->t7!=undefined )?$param->t7:0;
					$datainsert['t8']=($param->t8!='' && $param->t8!=undefined )?$param->t8:0;
					$datainsert['t9']=($param->t9!='' && $param->t9!=undefined )?$param->t9:0;
					$datainsert['t10']=($param->t10!='' && $param->t10!=undefined )?$param->t10:0;
					$datainsert['status']=$param->status;
					$datainsert['updated_by']=1;
					$datainsert['updated_at']=date('Y-m-d H:i:s');
					
					$sql = new Sql($this->adapter);
					$update = $sql->update();
					$update->table('agency_master');
					$update->set($datainsert);
					$update->where(array('idAgency' => $editid));
					$statement  = $sql->prepareStatementForSqlObject($update);
					$results    = $statement->execute();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				} catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			} 
		} 
		else if($param->action=='removelFile'){
			$agency_id=$param->agency_id;
			$qry="SELECT * FROM agency_master";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if($resultset){
				$data['agencyFile']=''; 
				$data['agencyFile_path']=''; 
				$sql = new Sql($this->adapter );
				$update = $sql->update();
				$update->table('agency_master');
				$update->set($data);
				$update->where( array('idAgency' =>$agency_id));
				$statement  = $sql->prepareStatementForSqlObject($update);
				$results    = $statement->execute();
				$ret_arr=['code'=>'2','status'=>true,'message'=>'Agency file removed successfully..'];
			}
			else{
				$ret_arr=['code'=>'2','content'=>'','status'=>false,'message'=>'No Agency file to remove..'];
			}
		} 
		else {
			$ret_arr=['code'=>'3','content'=>'','status'=>false,'message'=>'Please contact the administrator'];
		}
		return $ret_arr;
		}

 public function getterritoryfunction($param){
      if($param->action=='getHiearchy1') {
			$qry="SELECT idTerritory, territoryValue, territoryCode FROM  territory_master a WHERE idTerritoryTitle='1' and status='1'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='getHiearchy2') {
			$qry="SELECT idTerritory, territoryValue, territoryCode FROM  territory_master a WHERE idTerritoryTitle='2' and status='1'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='getHiearchy3') {
			$qry="SELECT idTerritory, territoryValue, territoryCode FROM  territory_master a WHERE idTerritoryTitle='3'  and status='1'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='getHiearchy4') {
			$qry="SELECT idTerritory, territoryValue, territoryCode FROM  territory_master a WHERE idTerritoryTitle='4'  and status='1'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='getHiearchy5') {
			$qry="SELECT idTerritory, territoryValue, territoryCode FROM  territory_master a WHERE idTerritoryTitle='5' and status='1'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='getHiearchy6') {
			$qry="SELECT idTerritory, territoryValue, territoryCode FROM  territory_master a WHERE idTerritoryTitle='6' and status='1'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='getHiearchy7') {
			$qry="SELECT idTerritory, territoryValue, territoryCode FROM  territory_master a WHERE idTerritoryTitle='7' and status='1'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='getHiearchy8') {
			$qry="SELECT idTerritory, territoryValue, territoryCode FROM  territory_master a WHERE idTerritoryTitle='8' and status='1'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}
		else if($param->action=='getHiearchy9') {
			$qry="SELECT idTerritory, territoryValue, territoryCode FROM  territory_master a WHERE idTerritoryTitle='9' and status='1'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}
		else if($param->action=='getHiearchy10') {
			$qry="SELECT idTerritory, territoryValue, territoryCode FROM  territory_master a WHERE idTerritoryTitle='10' and status='1'";
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

public function getgeographyfunction($param){
      if($param->action=='getHiearchy1') {
			$qry="SELECT idGeography, geoValue, geoCode FROM geography a WHERE idGeographyTitle='1' and status='1'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='getHiearchy2') {
			$qry="SELECT idGeography, geoValue, geoCode FROM geography a WHERE idGeographyTitle='2' and status='1'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='getHiearchy3') {
			$qry="SELECT idGeography, geoValue, geoCode FROM geography a WHERE idGeographyTitle='3' and status='1'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='getHiearchy4') {
			$qry="SELECT idGeography, geoValue, geoCode FROM geography a WHERE idGeographyTitle='4' and status='1'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='getHiearchy5') {
			$qry="SELECT idGeography, geoValue, geoCode FROM geography a WHERE idGeographyTitle='5' and status='1'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='getHiearchy6') {
		$qry="SELECT idGeography, geoValue, geoCode FROM geography a WHERE idGeographyTitle='6' and status='1'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='getHiearchy7') {
			$qry="SELECT idGeography, geoValue, geoCode FROM geography a WHERE idGeographyTitle='7' and status='1'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='getHiearchy8') {
			$qry="SELECT idGeography, geoValue, geoCode FROM geography a WHERE idGeographyTitle='8' and status='1'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}
		else if($param->action=='getHiearchy9') {
			$qry="SELECT idGeography, geoValue, geoCode FROM geography a WHERE idGeographyTitle='9' and status='1'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}
		else if($param->action=='getHiearchy10') {
			$qry="SELECT idGeography, geoValue, geoCode FROM geography a WHERE idGeographyTitle='10' and status='1'";
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
/*.......Muthu........*/

public function Transporter_pdf_remove($param) {
	   if($param->action=='removepdf') {
        $editid=$param->id;
	 	$pdfname=$param->pdfname;
	 	$userid='1';
		$this->adapter->getDriver()->getConnection()->beginTransaction();
		try {
              if($pdfname!=''){
			 	$datainsert['contractPDF']=''; 
			 	unlink('public/'.$pdfname);
	           }
				$datainsert['updated_by']=1;
				$datainsert['updated_at']=date('Y-m-d H:i:s');
				$sql = new Sql($this->adapter);
				$update = $sql->update();
				$update->table('transporter_master');
				$update->set($datainsert);
				$update->where( array('idTransporter'=>$editid));
				$statement  = $sql->prepareStatementForSqlObject($update);
				$results    = $statement->execute();
				$ret_arr=['code'=>'2','status'=>true,'message'=>'File removed successfully'];
				$this->adapter->getDriver()->getConnection()->commit();
		} catch(\Exception $e) {
			$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			$this->adapter->getDriver()->getConnection()->rollBack();
		}
	 	return $ret_arr;
	 }
}

public function Transporter_type($param) {

if($param->action=='list') {

    $qry="SELECT SUM(tvm.vehicleCount) as vehicle,tm.idTransporter as id,tm.transporterName as name,tm.transporterMobileNo as mobile,tm.status as status
                FROM transporter_vehicle_master as tvm 
                left join transporter_master as tm on tvm.idTransporter=tm.idTransporter 
                GROUP BY tvm.idTransporter";

			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();

	$qry_list="SELECT a.idVehicle as id,a.vehicleName as name,a.vehicleCapacity as capacity,a.vehiclePerKm as perkm,a.vehicleMinCharge as mincharge,a.status ,0 as vcount
	        FROM vehicle_master a where status!='2'";

	        $result_list=$this->adapter->query($qry_list,array());
	 		$resultset_list=$result_list->toArray();	

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

			if($resultset1) {
				$ret_arr=['code'=>'1','content'=>$resultset,'vehicle'=>$resultset_list,'contentlist1'=>$resultset1,'contentlist2'=>$resultset2,'contentlist3'=>$resultset3,'contentlist4'=>$resultset4,'contentlist5'=>$resultset5,'contentlist6'=>$resultset6,'contentlist7'=>$resultset7,'contentlist8'=>$resultset8,'contentlist9'=>$resultset9,'contentlist10'=>$resultset10,'status'=>true,'message'=>'No of records'.count($resultset)];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
            return $ret_arr;

		}else if($param->action=='add') {
			
			$vcount=(array)json_decode($param->vehicle_count,true);
            $userid=$param->userid;

            $fdate=$param->from_date;
			$startdate = trim(preg_replace('/\s*\([^)]*\)/', '', $fdate));
			$from_date=date('Y-m-d', strtotime($startdate));

			$tdate=$param->to_date;
			$endDate = trim(preg_replace('/\s*\([^)]*\)/', '', $tdate));
			$to_date=date('Y-m-d', strtotime($endDate));
			
			$checkfrom=date('d-m-Y', strtotime($startdate));
			$checkto=date('d-m-Y', strtotime($endDate));
            $fromdate=(strtotime($checkfrom));
            $todate=(strtotime($checkto));
	            
	            if($fromdate > $todate){
	            	$ret_arr=['code'=>'3','status'=>false,'message'=>'To date must be greater than from date'];
	            }else if($todate == $fromdate ){
	            	$ret_arr=['code'=>'3','status'=>false,'message'=>'To date must be greater than from date'];
	            }else{
			
             		
			$qry="SELECT * FROM transporter_master where transporterName =? and transporterMobileNo	=?";
			$result=$this->adapter->query($qry,array($param->name,$param->mobile));
			$resultset=$result->toArray();      
	
			$uploads_dir ='public/uploads/contract';
		
			if($_FILES) {
			$tmp_name=$_FILES["contract_details"]["tmp_name"];
			$name =basename($_FILES["contract_details"]["name"]);
			$imageName ='contract_'.date('dmyHi').'.'.pathinfo($_FILES["contract_details"]['name'],PATHINFO_EXTENSION);
		 
				if($imageName){
					if(move_uploaded_file($tmp_name,"$uploads_dir/$imageName")==false) {
						$ret_arr=['code'=>'3','status'=>false,'message'=>'Please try again.. Failed to upload agency file..'];
						$rollBack=true;	
					}  else {
						$data['image']=trim($imageName);
					}
				} else {
					$ret_arr=['code'=>'3','status'=>false,'message'=>'Please select valid format for agency file..'];
					$rollBack=true;	
				}
			}			
                	
			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {

                    $datainsert['transporterName']=$param->name;
					$datainsert['transporterMobileNo']=$param->mobile;
					$datainsert['t1']=($param->territory1!='' && $param->territory1!=undefined)?$param->territory1:0;
					$datainsert['t2']=($param->territory2!='' && $param->territory2!=undefined)?$param->territory2:0;
					$datainsert['t3']=($param->territory3!='' && $param->territory3!=undefined)?$param->territory3:0;
					$datainsert['t4']=($param->territory4!='' && $param->territory4!=undefined)?$param->territory4:0;
					$datainsert['t5']=($param->territory5!='' && $param->territory5!=undefined)?$param->territory5:0;
					$datainsert['t6']=($param->territory6!='' && $param->territory6!=undefined)?$param->territory6:0;
					$datainsert['t7']=($param->territory7!='' && $param->territory7!=undefined)?$param->territory7:0;
					$datainsert['t8']=($param->territory8!='' && $param->territory8!=undefined)?$param->territory8:0;
					$datainsert['t9']=($param->territory9!='' && $param->territory9!=undefined)?$param->territory9:0;
					$datainsert['t10']=($param->territory10!='' && $param->territory10!=undefined)?$param->territory10:0;
					$datainsert['status']=$param->status;
					if ($param->contact_name1!='' && $param->contact_name1!=undefined) 
					{
						$datainsert['transporterName1']=$param->contact_name1;
					}
					if ($param->contact_mobile1!='' && $param->contact_mobile1!=undefined) 
					{
						$datainsert['transporterMobile1']=$param->contact_mobile1;
					}
					if ($param->contact_email1!='' && $param->contact_email1!=undefined) 
					{
						$datainsert['transporterMail1']=$param->contact_email1;
					}
					if ($param->contact_name2!='' && $param->contact_name2!=undefined) 
					{
						$datainsert['transporterName2']=$param->contact_name2;
					}
					if ($param->contact_mobile2!='' && $param->contact_mobile2!=undefined) 
					{
						$datainsert['transporterMobile2']=$param->contact_mobile2;
					}
					if ($param->contact_email2!='' && $param->contact_email2!=undefined) 
					{
							$datainsert['transporterMail2']=$param->contact_email2;
					}
					
					$datainsert['contractPDFFromDate']=$from_date;
					$datainsert['contractPDFToDate']=$to_date;
					$datainsert['contractPDF']=$imageName;		
					// $datainsert['contractPDF']='uploads/contract/'.'contract_'.date('dmyHi').'.'.$check[1][2];		
					$datainsert['created_at']=date('Y-m-d H:i:s');
					$datainsert['created_by']=1;
					$datainsert['updated_at']=date('Y-m-d H:i:s');
					$datainsert['updated_by']=1;
					
				
					$insert=new Insert('transporter_master');
					$insert->values($datainsert);
					$statement=$this->adapter->createStatement();
					$insert->prepareStatement($this->adapter, $statement);
					$insertresult=$statement->execute();	

					$Transporterid=$this->adapter->getDriver()->getLastGeneratedValue();
					$vehicleinsert['idTransporter']=$Transporterid;	
				
		            for($i=0;$i<count($vcount);$i++){
		            	 $vehicle_model=$vcount[$i]['vcount'];
		            	 $vehicleinsert['idVehicle']=$vcount[$i]['id'];	            	      
		            	if($vehicle_model!=''){		            	                
                            $vehicleinsert['vehicleCount']=$vehicle_model; 
                           
		            	}else{
		            		$vehicleinsert['vehicleCount']='0';

		            	}
                          
                        $insertt=new Insert('transporter_vehicle_master');
					    $insertt->values($vehicleinsert);
						$statementt=$this->adapter->createStatement();
						$insertt->prepareStatement($this->adapter, $statementt);
						$insertresultt=$statementt->execute();		          
 	            
					}					

					$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				} catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			} else {
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
			}
		}

		} else if($param->action=='editview') {
			$editid=$param->id;		

	$qry="SELECT tm.transporterMobileNo as mobile,tm.t1,tm.t2,tm.t3,tm.t4,tm.t5,tm.t6,tm.t7,tm.t8,tm.t9,tm.t10,tm.status as status,IF(tm.transporterName1!='',tm.transporterName1,'') as name1,IF(tm.transporterName2!='',tm.transporterName2,'') as name2,IF(tm.transporterMobile1!='',tm.transporterMobile1,'') as mobile1,IF(tm.transporterMobile2!='',tm.transporterMobile2,'') as mobile2,IF(tm.transporterMail1!='',tm.transporterMail1,'') as email1,IF(tm.transporterMail2!='',tm.transporterMail2,'') as email2, DATE_FORMAT(tm.contractPDFFromDate,'%d-%m-%Y') as fromdate, DATE_FORMAT(tm.contractPDFToDate,'%d-%m-%Y') as todate,tm.contractPDF as contract_file,tvm.idTransporterVehicle as vid,tm.idTransporter as id,tm.transporterName as trans_name,tvm.vehicleCount as count,tvm.idVehicle as idVehicle,HT1.territoryValue as territory1Sel,HT2.territoryValue as territory2Sel,HT3.territoryValue as territory3Sel,HT4.territoryValue as territory4Sel,HT5.territoryValue as territory5Sel,HT6.territoryValue as territory6Sel,HT7.territoryValue as territory7Sel,HT8.territoryValue as territory8Sel,HT9.territoryValue as territory9Sel,HT10.territoryValue as territory10Sel
			FROM transporter_master as tm 
			LEFT JOIN transporter_vehicle_master as tvm on tvm.idTransporter=tm.idTransporter 
			LEFT JOIN territory_master HT1 ON HT1.idTerritory=tm.t1 
			LEFT JOIN territory_master HT2 ON HT2.idTerritory=tm.t2 
			LEFT JOIN territory_master HT3 ON HT3.idTerritory=tm.t3 
			LEFT JOIN territory_master HT4 ON HT4.idTerritory=tm.t4 
			LEFT JOIN territory_master HT5 ON HT5.idTerritory=tm.t5 
			LEFT JOIN territory_master HT6 ON HT6.idTerritory=tm.t6 
			LEFT JOIN territory_master HT7 ON HT7.idTerritory=tm.t7 
			LEFT JOIN territory_master HT8 ON HT8.idTerritory=tm.t8
			LEFT JOIN territory_master HT9 ON HT9.idTerritory=tm.t9 
			LEFT JOIN territory_master HT10 ON HT10.idTerritory=tm.t10
            where tm.idTransporter=?";

			$result=$this->adapter->query($qry,array($editid));
			$resultset=$result->toArray();

	        $qry_list="SELECT a.idVehicle as auto_id,a.vehicleName as name,a.status,tvm.idVehicle as idVehicle,a.vehicleCapacity as capacity,if(vehicleCount!='0', tvm.vehicleCount,'') as count
	        FROM vehicle_master as a 
            LEFT JOIN transporter_vehicle_master as tvm on tvm.idVehicle=a.idVehicle
	        WHERE status!='2' and tvm.idTransporter=?";

	        $result_list=$this->adapter->query($qry_list,array($editid));
			$resultset_list=$result_list->toArray();

			$qryTeri="SELECT 
						A.idTerritoryTitle as id,
						A.title,
						'0' as default_territory,
						A.hierarchy as ter_name
						FROM territorytitle_master A WHERE A.title!=''";
		$resultTeri=$this->adapter->query($qryTeri,array());
		$resultsetTeri=$resultTeri->toArray();
		if(!$resultsetTeri) {
			$resultsetTeri=[];
		} else {
			for($i=0;$i<count($resultsetTeri);$i++) {
				$t1=$resultset[0]['t1'];
				$t2=$resultset[0]['t2'];
				$t3=$resultset[0]['t3'];
				$t4=$resultset[0]['t4'];
				$t5=$resultset[0]['t5'];
				$t6=$resultset[0]['t6'];
				$t7=$resultset[0]['t7'];
				$t8=$resultset[0]['t8'];
				$t9=$resultset[0]['t9'];
				$t10=$resultset[0]['t10'];
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
				$resultsetTeri[$i]['territory_status']="1";
				$resultsetTeri[$i]['territory_value']=$resultset_geo1;
				}
				if($i==1){
				$resultsetTeri[$i]['territory_status']="1";
				$resultsetTeri[$i]['territory_value']=$resultset_geo2;
				}
				if($i==2){
				$resultsetTeri[$i]['territory_status']="1";
				$resultsetTeri[$i]['territory_value']=$resultset_geo3;
				}
				if($i==3){
				$resultsetTeri[$i]['territory_status']="1";
				$resultsetTeri[$i]['territory_value']=$resultset_geo4;
				}
				if($i==4){
				$resultsetTeri[$i]['territory_status']="1";
				$resultsetTeri[$i]['territory_value']=$resultset_geo5;
				}
				if($i==5){
				$resultsetTeri[$i]['territory_status']="1";
				$resultsetTeri[$i]['territory_value']=$resultset_geo6;
				}
				if($i==6){
				$resultsetTeri[$i]['territory_status']="1";
				$resultsetTeri[$i]['territory_value']=$resultset_geo7;
				}
				if($i==7){
				$resultsetTeri[$i]['territory_status']="1";
				$resultsetTeri[$i]['territory_value']=$resultset_geo8;
				}
				if($i==8){
				$resultsetTeri[$i]['territory_status']="1";
				$resultsetTeri[$i]['territory_value']=$resultset_geo9;
				}
				if($i==9){
				$resultsetTeri[$i]['territory_status']="1";
				$resultsetTeri[$i]['territory_value']=$resultset_geo10;
				}
				//}
			}
			//print_r($resultset);exit;
		}
  
			if(!$resultset){
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'content_list'=>$resultset_list ,'terytitle'=>$resultsetTeri,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='update') {
			 
				$editid=$param->editid;
				$transporterName=$param->name;
				$mobile=$param->mobile;
				$fdate=$param->from_date;
				$startdate = trim(preg_replace('/\s*\([^)]*\)/', '', $fdate));
				$from_date=date('Y-m-d', strtotime($startdate));

				$tdate=$param->to_date;
				$endDate = trim(preg_replace('/\s*\([^)]*\)/', '', $tdate));
				$to_date=date('Y-m-d', strtotime($endDate));
				
				$checkfrom=date('d-m-Y', strtotime($startdate));
				$checkto=date('d-m-Y', strtotime($endDate));
	            $fromdate=(strtotime($checkfrom));
	            $todate=(strtotime($checkto));
	            
	            if($fromdate > $todate){
	            	$ret_arr=['code'=>'3','status'=>false,'message'=>'To date must be greater than from date'];
	            }else if($todate == $fromdate ){
	            	$ret_arr=['code'=>'3','status'=>false,'message'=>'To date must be greater than from date'];
	            }else{
	            	
	           
			// $fiedls=$param->Form;
			// $userid=$param->userid;
			// $editid=$fiedls['id'];
			// $edit_get=$param->file;
   //          $edit_check[1] =explode(".",$edit_get);	
			// $vehicle=$param->vehicle;
			//$vehicle_count=$param->vehicle_count;

             $vehicle_count=(array)json_decode($param->vehicle_count,true);
	    $qry="SELECT * FROM transporter_master where transporterName =? and transporterMobileNo =? and idTransporter!=?";
			$result=$this->adapter->query($qry,array($name,$mobile,$editid));
			$resultset=$result->toArray();

		    $qry_list="SELECT tvm.idTransporterVehicle as id FROM transporter_vehicle_master as tvm where tvm.idTransporter =?";
			$result1=$this->adapter->query($qry_list,array($editid));
			$resultset1=$result1->toArray();

            $uploads_dir ='public/uploads/contract';
			if($_FILES) {
			$tmp_name=$_FILES["contract_file_edit"]["tmp_name"];
			$name =basename($_FILES["contract_file_edit"]["name"]);
		
			$imageName ='contract_'.date('dmyHi').'.'.pathinfo($_FILES["contract_file_edit"]['name'],PATHINFO_EXTENSION);
				
				if($imageName){
					if(move_uploaded_file($tmp_name,"$uploads_dir/$imageName")==false) {
						$ret_arr=['code'=>'3','status'=>false,'message'=>'Please try again.. Failed to upload agency file..'];
						$rollBack=true;	
					}  else {
						$data['image']=trim($imageName);
					}
				} else {
					$ret_arr=['code'=>'3','status'=>false,'message'=>'Please select valid format for agency file..'];
					$rollBack=true;	
				}
			}
			else{
				$imageName=Null;

			}

			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$dataupdate['transporterName']=$transporterName;
					$dataupdate['transporterMobileNo']=$mobile;
					$dataupdate['t1']=($param->territory1!='' && $param->territory1!=undefined)?$param->territory1:0;
					$dataupdate['t2']=($param->territory2!='' && $param->territory2!=undefined)?$param->territory2:0;
					$dataupdate['t3']=($param->territory3!='' && $param->territory3!=undefined)?$param->territory3:0;
					$dataupdate['t4']=($param->territory4!='' && $param->territory4!=undefined)?$param->territory4:0;
					$dataupdate['t5']=($param->territory5!='' && $param->territory5!=undefined)?$param->territory5:0;
					$dataupdate['t6']=($param->territory6!='' && $param->territory6!=undefined)?$param->territory6:0;
					$dataupdate['t7']=($param->territory7!='' && $param->territory7!=undefined)?$param->territory7:0;
					$dataupdate['t8']=($param->territory8!='' && $param->territory8!=undefined)?$param->territory8:0;
					$dataupdate['t9']=($param->territory9!='' && $param->territory9!=undefined)?$param->territory9:0;
					$dataupdate['t10']=($param->territory10!='' && $param->territory10!=undefined)?$param->territory10:0;
					if ($param->contact_name1!='' && $param->contact_name1!=undefined) 
					{
						$dataupdate['transporterName1']=$param->contact_name1;
					}
					if ($param->contact_mobile1!='' && $param->contact_mobile1!=undefined) 
					{
						$dataupdate['transporterMobile1']=$param->contact_mobile1;
					}
					if ($param->contact_email1!='' && $param->contact_email1!=undefined) 
					{
						$dataupdate['transporterMail1']=$param->contact_email1;
					}
					if ($param->contact_name2!='' && $param->contact_name2!=undefined) 
					{
						$dataupdate['transporterName2']=$param->contact_name2;
					}
					if ($param->contact_mobile2!='' && $param->contact_mobile2!=undefined) 
					{
						$dataupdate['transporterMobile2']=$param->contact_mobile2;
					}
					if ($param->contact_email2!='' && $param->contact_email2!=undefined) 
					{
							$dataupdate['transporterMail2']=$param->contact_email2;
					}
					$dataupdate['status']=$param->status;
					
					$dataupdate['contractPDFFromDate']=$from_date;
					$dataupdate['contractPDFToDate']=$to_date;
					if ($imageName!='' && $imageName!=Null) 
					{
						$dataupdate['contractPDF']=$imageName;
					}
					// print_r($dataupdate);
					$dataupdate['created_at']=date('Y-m-d H:i:s');
					$dataupdate['created_by']=1;
					$dataupdate['updated_at']=date('Y-m-d H:i:s');
					$dataupdate['updated_by']=1;
			    	$sql = new Sql($this->adapter);
					$update = $sql->update();
					$update->table('transporter_master');
					$update->set($dataupdate);
					$update->where( array('idTransporter' => $editid));
					$statement  = $sql->prepareStatementForSqlObject($update);
					$results    = $statement->execute();

					$vehicleupdate['idTransporter']=$editid;	
           

				   for($i=0;$i<count($vehicle_count);$i++){	
			            $vehicleupdate['idVehicle']=$vehicle_count[$i]['id'];
		           	    //$edit_vehicle=$vehicle[$i]['vcount'];

                            $vehicleupdate['vehicleCount']=($vehicle_count[$i]['vcount']!='' && $vehicle_count[$i]['vcount']!=undefined)?$vehicle_count[$i]['vcount']:0;

		          
                        $first_edit=$resultset1[$i]['id'];
                        $sql1 = new Sql($this->adapter);
				        $update1 = $sql1->update();
				    	$update1->table('transporter_vehicle_master');
						$update1->set($vehicleupdate);
						
						$update1->where(array('idTransporterVehicle'=>$first_edit));

						$statement1  = $sql1->prepareStatementForSqlObject($update1);
						$results1    = $statement1->execute();	    	            
				
				   }

					$ret_arr=['code'=>'2','status'=>true,'message'=>' Updated successfully'];
					$this->adapter->getDriver()->getConnection()->commit();

				} catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			} else {
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
			}
		}
		} 
		return $ret_arr;
	}

public function hsncode_list($param){
		if($param->action=='list') {
			$qry="SELECT ad.idHsncode as id,ad.hsn_code as code,ad.description as description,ad.status as status FROM hsn_details as ad ";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if($resultset){
				$ret_arr=['code'=>'1','content'=>$resultset,'status'=>true,'message'=>'No of records'.count($resultset)];
			} else {
				$ret_arr=['code'=>'2','content'=>'','status'=>false,'message'=>'No records to view'];
			}
		}
		else if($param->action=='add'){
			$userid=$param->userid;
			$qry="SELECT * FROM hsn_details where hsn_code=? and description=?";
			$result=$this->adapter->query($qry,array($param->hsn_code,$param->description));
			$resultset=$result->toArray();

			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
		
					$datainsert['hsn_code']=$param->hsn_code;
					$datainsert['description']=$param->description;
					$datainsert['status']=$param->status;
					$datainsert['created_at']=date('Y-m-d H:i:s');
					$datainsert['created_by']=1;			
					$datainsert['updated_at']=date('Y-m-d H:i:s');
					$datainsert['updated_by']=1;
					$insert=new Insert('hsn_details');
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
			$qry="SELECT hd.idHsncode as id,hd.hsn_code as code,hd.description as description,hd.status as status FROM hsn_details hd where hd.idHsncode=?";
			$result=$this->adapter->query($qry,array($editid));
			$resultset=$result->toArray();
			if(!$resultset){
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}
		else if($param->action=='update') {
			$userid=$param->userid;
			$editid= $param->id;
			$qry="SELECT hd.hsn_code,hd.description FROM hsn_details hd where hd.hsn_code=? and hd.description=? and hd.idHsncode!=?";
			$result=$this->adapter->query($qry,array($param->hsn_code,$param->description,$editid));
			$resultset=$result->toArray();
			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try{
					$datainsert['hsn_code']=$param->code;
					$datainsert['description']=$param->description;
					$datainsert['status']=$param->status;
					$datainsert['created_at']=date('Y-m-d H:i:s');
					$datainsert['created_by']=1;			
					$datainsert['updated_at']=date('Y-m-d H:i:s');
					$datainsert['updated_by']=1;
					$sql = new Sql($this->adapter);
					$update = $sql->update();
					$update->table('hsn_details');
					$update->set($datainsert);
					$update->where(array('idHsncode' => $editid));
					$statement  = $sql->prepareStatementForSqlObject($update);
					$results    = $statement->execute();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				} catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
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

public function taxheads_list($param){
		if($param->action=='list') {
			$qry="SELECT td.idTaxheads as id,td.taxheadsName as name,td.status as status FROM taxheads_details as td ";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if($resultset){
				$ret_arr=['code'=>'1','content'=>$resultset,'status'=>true,'message'=>'No of records'.count($resultset)];
			} else {
				$ret_arr=['code'=>'2','content'=>'','status'=>false,'message'=>'No records to view'];
			}
		}
		else if($param->action=='add'){
			$userid=$param->userid;
			$qry="SELECT * FROM taxheads_details where taxheadsName=?";
			$result=$this->adapter->query($qry,array($param->tax_heads));
			$resultset=$result->toArray();

			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
		
					$datainsert['taxheadsName']=$param->tax_heads;
					$datainsert['status']=$param->status;
					$datainsert['created_at']=date('Y-m-d H:i:s');
					$datainsert['created_by']=1;			
					$datainsert['updated_at']=date('Y-m-d H:i:s');
					$datainsert['updated_by']=1;
					$insert=new Insert('taxheads_details');
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
			$qry="SELECT td.idTaxheads as id,td.taxheadsName as tax,td.status as status FROM taxheads_details as td 
			where td.idTaxheads=?";
			$result=$this->adapter->query($qry,array($editid));
			$resultset=$result->toArray();
			if(!$resultset){
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}
		else if($param->action=='update') {
          $userid=$param->userid;
			$editid= $param->id;
			$qry="SELECT td.taxheadsName FROM taxheads_details as td 
			where td.taxheadsName =? and td.idTaxheads !=?";
			$result=$this->adapter->query($qry,array($param->tax,$editid));
			$resultset=$result->toArray();
			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try{
					$datainsert['taxheadsName']=$param->tax;
					$datainsert['status']=$param->status;
					$datainsert['created_at']=date('Y-m-d H:i:s');
					$datainsert['created_by']=1;			
					$datainsert['updated_at']=date('Y-m-d H:i:s');
					$datainsert['updated_by']=1;
					$sql = new Sql($this->adapter);
					$update = $sql->update();
					$update->table('taxheads_details');
					$update->set($datainsert);
					$update->where(array('idTaxheads' => $editid));
					$statement  = $sql->prepareStatementForSqlObject($update);
					$results    = $statement->execute();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				} catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
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


public function GST_list($param){

		if($param->action=='list') {
			$qry="SELECT gm.idGst as id,gm.gstValue as value,hd.hsn_code as code,gm.status as status
			 FROM gst_master as gm  
			 LEFT JOIN hsn_details as hd on hd.idHsncode=gm.idHsncode";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if($resultset){
				$ret_arr=['code'=>'1','content'=>$resultset,'status'=>true,'message'=>'No of records'.count($resultset)];
			} else {
				$ret_arr=['code'=>'2','content'=>'','status'=>false,'message'=>'No records to view'];
			}
		}else if($param->action=='HSN_code_details'){
			$qry="SELECT * FROM hsn_details where status='1'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			}else{
				$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'message'=>'System config information'];
			}

		}else if($param->action=='add'){
			$userid=$param->userid;
			$qry="SELECT * FROM gst_master where idHsncode=?";
			$result=$this->adapter->query($qry,array($param->code));
			$resultset=$result->toArray();

			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
		
					$datainsert['idHsncode']=$param->code;
					$datainsert['gstValue']=$param->rate;
					$datainsert['status']=$param->status;
					$datainsert['created_at']=date('Y-m-d H:i:s');
					$datainsert['created_by']=1;			
					$datainsert['updated_at']=date('Y-m-d H:i:s');
					$datainsert['updated_by']=1;
					$insert=new Insert('gst_master');
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
	$qry="SELECT gm.idGst as id,gm.gstValue as gstvalue,gm.idHsncode as hsncode,gm.status as status,hd.hsn_code as code
			 FROM gst_master as gm  
			 LEFT JOIN hsn_details as hd on hd.idHsncode=gm.idHsncode WHERE gm.idGst=?";

			$result=$this->adapter->query($qry,array($editid));
			$resultset=$result->toArray();
			if(!$resultset){
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}
		else if($param->action=='update') {
			$userid=$param->userid;
			$editid= $param->id;
			$qry="SELECT gm.idHsncode,gm.gstValue FROM gst_master as gm 
			where gm.idHsncode=?  and gm.idGst!=?";
			$result=$this->adapter->query($qry,array($param->hsncode,$editid));
			$resultset=$result->toArray();
			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try{
					$datainsert['idHsncode']=$param->hsncode;
					$datainsert['gstValue']=$param->gstvalue;
					$datainsert['status']=$param->status;
					$datainsert['created_at']=date('Y-m-d H:i:s');
					$datainsert['created_by']=1;			
					$datainsert['updated_at']=date('Y-m-d H:i:s');
					$datainsert['updated_by']=1;
					$sql = new Sql($this->adapter);
					$update = $sql->update();
					$update->table('gst_master');
					$update->set($datainsert);
					$update->where(array('idGst' => $editid));
					$statement  = $sql->prepareStatementForSqlObject($update);
					$results    = $statement->execute();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				} catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
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
		public function get_segment_list($param) {
			$qry="SELECT A.segmentName as name,A.idsegmentType as id FROM segment_type A WHERE A.status=1";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'3','content'=>'','status'=>false,'message'=>'Please contact the administrator'];
			} else {
				$ret_arr=['code'=>'1','content'=>$resultset,'status'=>true,'message'=>'Segment list'];
			}
			return $ret_arr;
		}

public function fullfilladd($param){
		if($param->action=='list') {
			$qry="SELECT a.idFulfillment as id,a.fulfillmentName as fulfillmentName,a.fulfillmentMobileno as fulfillmentMobileno,a.fulfillmentEmail as fulfillmentEmail,a.status as status FROM fulfillment_master a ";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();

			if($resultset){
				$ret_arr=['code'=>'1','content'=>$resultset,'status'=>true,'message'=>'No of records'.count($resultset)];
			} else {
				$ret_arr=['code'=>'2','content'=>'','status'=>false,'message'=>'No records to view'];
			}
		}
		else if($param->action=='add'){
			$userid=$param->userid;
            $fiedls=$param->Form;
			$qry="SELECT * FROM fulfillment_master  where fulfillmentName=?";
			$result=$this->adapter->query($qry,array($fiedls['name']));
			$resultset=$result->toArray();
			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['fulfillmentName']=$fiedls['name'];
					$datainsert['fulfillmentEmail']=$fiedls['email'];
					$datainsert['fulfillmentMobileno']=$fiedls['mobileno'];
					$datainsert['t1']=($fiedls['H1']!='' && $fiedls['H1']!=undefined)?$fiedls['H1']:0;
					$datainsert['t2']=($fiedls['H2']!='' && $fiedls['H2']!=undefined)?$fiedls['H2']:0;
					$datainsert['t3']=($fiedls['H3']!='' && $fiedls['H3']!=undefined)?$fiedls['H3']:0;
					$datainsert['t4']=($fiedls['H4']!='' && $fiedls['H4']!=undefined)?$fiedls['H4']:0;
					$datainsert['t5']=($fiedls['H5']!='' && $fiedls['H5']!=undefined)?$fiedls['H5']:0;
					$datainsert['t6']=($fiedls['H6']!='' && $fiedls['H6']!=undefined)?$fiedls['H6']:0;
					$datainsert['t7']=($fiedls['H7']!='' && $fiedls['H7']!=undefined)?$fiedls['H7']:0;
					$datainsert['t8']=($fiedls['H8']!='' && $fiedls['H8']!=undefined)?$fiedls['H8']:0;
					$datainsert['t9']=($fiedls['H9']!='' && $fiedls['H9']!=undefined)?$fiedls['H9']:0;
					$datainsert['t10']=($fiedls['H10']!='' && $fiedls['H10']!=undefined)?$fiedls['H10']:0;
					$datainsert['status']=$fiedls['status'];
					$datainsert['created_by']=1;
					$datainsert['created_at']=date('Y-m-d H:i:s');					
					$insert=new Insert('fulfillment_master');
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
         
			$qry="SELECT a.*,a.idFulfillment as id,a.fulfillmentName as name,a.fulfillmentEmail as email,a.fulfillmentMobileno as mobileno,
			     HT1.territoryValue as territory1Sel,
			     HT2.territoryValue as territory2Sel,
			     HT3.territoryValue as territory3Sel,
			     HT4.territoryValue as territory4Sel,
			     HT5.territoryValue as territory5Sel,
			     HT6.territoryValue as territory6Sel,
			     HT7.territoryValue as territory7Sel,
			     HT8.territoryValue as territory8Sel,
			     HT9.territoryValue as territory9Sel,
			     HT10.territoryValue as territory10Sel,a.status
			     FROM fulfillment_master a 
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
			     where a.idFulfillment=?";
			$result=$this->adapter->query($qry,array($editid));
			$resultset=$result->toArray();
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
			
			if(!$resultset){
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'terytitle' =>$resultset_terytitle,'status'=>true,'message'=>'Record available'];
			}
		}
		else if($param->action=='update') {
			$fiedls=$param->Form;
			$userid=$param->userid;
			$editid=$fiedls['id'];
			
			$qry="SELECT a.idFulfillment,a.fulfillmentName FROM fulfillment_master a where a.fulfillmentName=? and a.idFulfillment!='$editid'";
			$result=$this->adapter->query($qry,array($fiedls['name']));
			$resultset=$result->toArray();
			
			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try{
				    $datainsert['fulfillmentName']=$fiedls['name'];
					$datainsert['fulfillmentEmail']=$fiedls['email'];
					$datainsert['fulfillmentMobileno']=$fiedls['mobileno'];
					$datainsert['t1']=($fiedls['t1']!='' && $fiedls['t1']!=undefined)?$fiedls['t1']:0;
					$datainsert['t2']=($fiedls['t2']!='' && $fiedls['t2']!=undefined)?$fiedls['t2']:0;
					$datainsert['t3']=($fiedls['t3']!='' && $fiedls['t3']!=undefined)?$fiedls['t3']:0;
					$datainsert['t4']=($fiedls['t4']!='' && $fiedls['t4']!=undefined)?$fiedls['t4']:0;
					$datainsert['t5']=($fiedls['t5']!='' && $fiedls['t5']!=undefined)?$fiedls['t5']:0;
					$datainsert['t6']=($fiedls['t6']!='' && $fiedls['t6']!=undefined)?$fiedls['t6']:0;
					$datainsert['t7']=($fiedls['t7']!='' && $fiedls['t7']!=undefined)?$fiedls['t7']:0;
					$datainsert['t8']=($fiedls['t8']!='' && $fiedls['t8']!=undefined)?$fiedls['t8']:0;
					$datainsert['t9']=($fiedls['t9']!='' && $fiedls['t9']!=undefined)?$fiedls['t9']:0;
					$datainsert['t10']=($fiedls['t10']!='' && $fiedls['t10']!=undefined)?$fiedls['t10']:0;
					$datainsert['status']=$fiedls['status'];
					$datainsert['updated_by']=1;
					$datainsert['updated_at']=date('Y-m-d H:i:s');
					$sql = new Sql($this->adapter);
					$update = $sql->update();
					$update->table('fulfillment_master');
					$update->set($datainsert);
					$update->where(array('idFulfillment' => $editid));
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
		
		return $ret_arr;
}

public function add_credit($param){
	if($param->action=='list') {
			$crditdata=$param->data;
			$qry="SELECT a.idCreditRating as id,a.days as days,a.amount as amount,a.creditType as creditType
				 FROM creditrating a ";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset){
				for($i=0;$i<count($crditdata);$i++){
				 	$data[$i]['creditType']=$crditdata[$i];
				 	$data[$i]['days']=0;
				 	$data[$i]['amount']=0;
				}
			}else{
				$qry1="SELECT a.idCreditRating as id,a.days as days,a.amount as amount,a.creditType as creditType
				   FROM creditrating a";
					$result1=$this->adapter->query($qry1,array());
					$resultset1=$result1->toArray();
					for($i=0;$i<count($resultset1);$i++){
				 	$data[$i]['creditType']=$resultset1[$i]['creditType'];
				 	$data[$i]['days']=($resultset1[$i]['days'])?$resultset1[$i]['days']:0;
				 	$data[$i]['amount']=($resultset1[$i]['amount'])?$resultset1[$i]['amount']:0;
				}

			}
			if($data){
				$ret_arr=['code'=>'1','content'=>$data,'status'=>true,'message'=>'No of records'.count($data)];
			} else {
				$ret_arr=['code'=>'2','content'=>'','status'=>false,'message'=>'No records to view'];
			}
		}

		else if($param->action=='add'){
			$cType=($param->cType)?implode(',', $param->cType):'';
			$cType2=$param->cType;
            $cDay=$param->cDay;
			$cAmt=$param->cAmt;
			$qry="SELECT * FROM creditrating WHERE creditType in ($cType)";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					for ($k=0; $k <count($cType2); $k++) { 
					$datainsert['creditType']=$cType2[$k];
					$datainsert['days']=($cDay[$k])?$cDay[$k]:0;
					$datainsert['amount']=($cAmt[$k])?$cAmt[$k]:0;
					$insert=new Insert('creditrating');
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
				try{
               for ($k=0; $k <count($cType2); $k++) { 
					$dataupdate['days']=($cDay[$k])?$cDay[$k]:0;
					$dataupdate['amount']=($cAmt[$k])?$cAmt[$k]:0;
					$sql = new Sql($this->adapter);
					$update = $sql->update();
					$update->table('creditrating');
					$update->set($dataupdate);
					$update->where(array('creditType' => $cType2[$k]));
					$statement  = $sql->prepareStatementForSqlObject($update);
					$results    = $statement->execute();
				}
				$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				} catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
					
                       
			}
		}
		return $ret_arr;
}
public function login_authentication($param) {
	$bcrypt = new Bcrypt();
	if($param->action=='auth') {
			$username=$param->username;
			$password=$param->password;
			$checklogin = "SELECT 
				a.idLogin,
				a.idCustomer,
				a.idCustomerType,
				a.customer_name,
				a.customer_password,
				(select currencyName from sys_config) as currency,
				(select companyLogo from sys_config) as companyLogo,
				 LOWER(LEFT(a.customer_name,1)) as startLetter
				FROM user_login a WHERE a.customer_name=? and a.status=?";
			$qryform = $this->adapter->query($checklogin, array($username,'1'));
			$resultarr = $qryform->toArray();
			$securePass=$resultarr[0]['customer_password'];
		if ($bcrypt->verify($password,$securePass)) {
			$ret_arr=['code'=>'1','status'=>true,'message'=>'Welcome to sales','content' =>$resultarr[0]];
		} else {
			$ret_arr=['code'=>'2','status'=>false,'message'=>'Incorrect password'];
		}
	} else {
		$ret_arr=['code'=>'2','status'=>false,'message'=>'Request details missing Please try again'];
	}
	return $ret_arr;
}



    public function transporter_claim_list($param) {
    	if($param->action=='customer_list') {
    		$id=$param->customer_id;
			$qry="SELECT idCustomer,cs_name,cs_type from customer WHERE cs_type='$id' AND cs_status=1";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}
		else if($param->action=='list'){

		$qry="SELECT DATE_FORMAT(dv.deliveryDate,'%d-%m-%Y') as do_date ,dv.dc_no as delivery_no ,dv.vehicleCapacity,dv.idCustomer,dp.idProduct,dpb.idWhStockItem,vm.vehicleName,dv.totalKM as kilometer,round(dc.totalWeight/1000,2
		) as total,((round(dc.totalWeight/1000,2)/dv.vehicleCapacity)*100) as utilized,dc.invoice_amt as invoice_value,
        dv.perKMamount,(round(round(dc.totalWeight/1000,2)*dv.perKMamount,2)) as perkm,c.cs_transport_type,(dc.invoice_amt/c.cs_transport_amt*100) as invoice,IF(c.cs_transport_amt,c.cs_transport_amt,'-') as cs_transport_amt
		FROM dispatch_vehicle as dv 
		LEFT JOIN dispatch_customer as dc on dc.idDispatchVehicle=dv.idDispatchVehicle
		LEFT JOIN dispatch_product as dp on dp.idDispatchcustomer=dc.idDispatchcustomer
		LEFT JOIN dispatch_product_batch as dpb on dpb.idDispatchProduct=dp.idDispatchProduct
		LEFT JOIN vehicle_master as vm on vm.idVehicle=dv.idVechileType 
		LEFT JOIN customer as c on c.idCustomer=dv.idCustomer 
		GROUP BY dv.idDispatchVehicle";

		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();

	   if($resultset){

		$ret_arr=['code'=>'1','status'=>true,'message'=>'Employee details','content' =>$resultset];
		
		}else {
			$ret_arr=['code'=>'2','status'=>false,'message'=>'parameter missing, try again!!!'];
		}

		}
           return $ret_arr; 
		
	}

public function get_selected_territory($param){

        if($param->action=="getHiearchy2"){

            $territory1=$param->territory1;

            $qry="SELECT tmm.t2,tm.territoryValue,tm.idTerritory 
            FROM territorymapping_master tmm 
	        LEFT JOIN territory_master as tm on tm.idTerritory=tmm.t2 WHERE tmm.t1='$territory1' GROUP BY tm.territoryValue";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset){
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			}else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}            
	        
        }else if($param->action=="getHiearchy3"){

        	$territory2=$param->territory2;

            $qry="SELECT tmm.t3,tm.territoryValue,tm.idTerritory 
            FROM territorymapping_master tmm 
	        LEFT JOIN territory_master as tm on tm.idTerritory=tmm.t3 WHERE tmm.t2='$territory2' GROUP BY tm.territoryValue";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset){
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			}else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
 

            }else if($param->action=="getHiearchy4"){

        	$territory3=$param->territory3;

            $qry="SELECT tmm.t4,tm.territoryValue,tm.idTerritory 
            FROM territorymapping_master tmm 
	        LEFT JOIN territory_master as tm on tm.idTerritory=tmm.t4 WHERE tmm.t3='$territory3' GROUP BY tm.territoryValue";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset){
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			}else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
 

            }else if($param->action=="getHiearchy5"){

        	$territory4=$param->territory4;

            $qry="SELECT tmm.t5,tm.territoryValue,tm.idTerritory 
            FROM territorymapping_master tmm 
	        LEFT JOIN territory_master as tm on tm.idTerritory=tmm.t5 WHERE tmm.t4='$territory4' GROUP BY tm.territoryValue";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset){
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			}else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
 

            }else if($param->action=="getHiearchy6"){

        	$territory5=$param->territory5;

            $qry="SELECT tmm.t6,tm.territoryValue,tm.idTerritory 
            FROM territorymapping_master tmm 
	        LEFT JOIN territory_master as tm on tm.idTerritory=tmm.t6 WHERE tmm.t5='$territory5' GROUP BY tm.territoryValue";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset){
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			}else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
 

            }else if($param->action=="getHiearchy7"){

        	$territory6=$param->territory6;

            $qry="SELECT tmm.t7,tm.territoryValue,tm.idTerritory 
            FROM territorymapping_master tmm 
	        LEFT JOIN territory_master as tm on tm.idTerritory=tmm.t7 WHERE tmm.t6='$territory6' GROUP BY tm.territoryValue";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset){
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			}else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
 

            }else if($param->action=="getHiearchy8"){

        	$territory7=$param->territory7;

            $qry="SELECT tmm.t8,tm.territoryValue,tm.idTerritory 
            FROM territorymapping_master tmm 
	        LEFT JOIN territory_master as tm on tm.idTerritory=tmm.t8 WHERE tmm.t7='$territory7' GROUP BY tm.territoryValue";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset){
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			}else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
 

            }else if($param->action=="getHiearchy9"){

        	$territory8=$param->territory8;

            $qry="SELECT tmm.t9,tm.territoryValue,tm.idTerritory 
            FROM territorymapping_master tmm 
	        LEFT JOIN territory_master as tm on tm.idTerritory=tmm.t9 WHERE tmm.t8='$territory8' GROUP BY tm.territoryValue";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset){
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			}else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
 

            }else if($param->action=="getHiearchy10"){

        	$territory9=$param->territory9;

            $qry="SELECT tmm.t10,tm.territoryValue,tm.idTerritory 
            FROM territorymapping_master tmm 
	        LEFT JOIN territory_master as tm on tm.idTerritory=tmm.t10 WHERE tmm.t9='$territory9' GROUP BY tm.territoryValue";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset){
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			}else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
 

            }

			return $ret_arr;
	}

public function getterritoryagency($param){

      if($param->action=='getHiearchy1') {
			$qry="SELECT idTerritory, territoryValue, territoryCode FROM  territory_master a WHERE idTerritoryTitle='1' and status='1'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='getHiearchy2') {
			$t1=$param->t1;
			$qry="SELECT tmm.t2,tm.territoryValue,tm.idTerritory 
            FROM territorymapping_master tmm 
	        LEFT JOIN territory_master as tm on tm.idTerritory=tmm.t2 WHERE tmm.t1='$t1' GROUP BY tm.territoryValue";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='getHiearchy3') {
			// $qry="SELECT idTerritory, territoryValue, territoryCode FROM  territory_master a WHERE idTerritoryTitle='3'  and status='1'";
			$t2=$param->t2;
			$qry="SELECT tmm.t3,tm.territoryValue,tm.idTerritory 
            FROM territorymapping_master tmm 
	        LEFT JOIN territory_master as tm on tm.idTerritory=tmm.t3 WHERE tmm.t2='$t2' GROUP BY tm.territoryValue";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='getHiearchy4') {
			// $qry="SELECT idTerritory, territoryValue, territoryCode FROM  territory_master a WHERE idTerritoryTitle='4'  and status='1'";
			$t3=$param->t3;
			$qry="SELECT tmm.t4,tm.territoryValue,tm.idTerritory 
            FROM territorymapping_master tmm 
	        LEFT JOIN territory_master as tm on tm.idTerritory=tmm.t4 WHERE tmm.t3='$t3' GROUP BY tm.territoryValue";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='getHiearchy5') {
			$t4=$param->t4;
			$qry="SELECT tmm.t5,tm.territoryValue,tm.idTerritory 
            FROM territorymapping_master tmm 
	        LEFT JOIN territory_master as tm on tm.idTerritory=tmm.t5 WHERE tmm.t4='$t4' GROUP BY tm.territoryValue";
			// $qry="SELECT idTerritory, territoryValue, territoryCode FROM  territory_master a WHERE idTerritoryTitle='5' and status='1'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='getHiearchy6') {
			// $qry="SELECT idTerritory, territoryValue, territoryCode FROM  territory_master a WHERE idTerritoryTitle='6' and status='1'";
			$t5=$param->t5;
			$qry="SELECT tmm.t6,tm.territoryValue,tm.idTerritory 
            FROM territorymapping_master tmm 
	        LEFT JOIN territory_master as tm on tm.idTerritory=tmm.t6 WHERE tmm.t5='$t5' GROUP BY tm.territoryValue";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='getHiearchy7') {
			// $qry="SELECT idTerritory, territoryValue, territoryCode FROM  territory_master a WHERE idTerritoryTitle='7' and status='1'";
			$t6=$param->t6;
			$qry="SELECT tmm.t7,tm.territoryValue,tm.idTerritory 
            FROM territorymapping_master tmm 
	        LEFT JOIN territory_master as tm on tm.idTerritory=tmm.t7 WHERE tmm.t6='$t6' GROUP BY tm.territoryValue";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}else if($param->action=='getHiearchy8') {
			// $qry="SELECT idTerritory, territoryValue, territoryCode FROM  territory_master a WHERE idTerritoryTitle='8' and status='1'";
			$t7=$param->t7;
			$qry="SELECT tmm.t8,tm.territoryValue,tm.idTerritory 
            FROM territorymapping_master tmm 
	        LEFT JOIN territory_master as tm on tm.idTerritory=tmm.t8 WHERE tmm.t7='$t7' GROUP BY tm.territoryValue";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}
		else if($param->action=='getHiearchy9') {
			// $qry="SELECT idTerritory, territoryValue, territoryCode FROM  territory_master a WHERE idTerritoryTitle='9' and status='1'";
			$t8=$param->t8;
			$qry="SELECT tmm.t9,tm.territoryValue,tm.idTerritory 
            FROM territorymapping_master tmm 
	        LEFT JOIN territory_master as tm on tm.idTerritory=tmm.t9 WHERE tmm.t8='$t8' GROUP BY tm.territoryValue";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}
		else if($param->action=='getHiearchy10') {
			// $qry="SELECT idTerritory, territoryValue, territoryCode FROM  territory_master a WHERE idTerritoryTitle='10' and status='1'";
			$t9=$param->t9;
			$qry="SELECT tmm.t10,tm.territoryValue,tm.idTerritory 
            FROM territorymapping_master tmm 
	        LEFT JOIN territory_master as tm on tm.idTerritory=tmm.t10 WHERE tmm.t9='$t9' GROUP BY tm.territoryValue";
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



     public function saleshierarchy($param) {

		if($param->action=='add') {
			
			$fiedls=$param->Form;
			$userid=$param->userid;
			
			$qry="SELECT * FROM sales_hierarchy where saleshierarchyType=?";
			$result=$this->adapter->query($qry,array($fiedls['territory1']));
			$resultset=$result->toArray();	
				
			
			$qry1="SELECT * FROM sales_hierarchy";
			$result1=$this->adapter->query($qry1,array());
			$resultset1=$result1->toArray();	
			for ($i=0; $i <count($resultset1) ; $i++) { 
			$test=$resultset1[$i]['saleshierarchyName'];
			
			if($test!=""){
				$statusqry=1;
				break;
				}else{
				$statusqry=0;
				}
			}
			
			if(!$resultset1){

				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					for($i=1;$i<=10;$i++){

							$hierarchy_type='S'.$i;
						    $hierarchy_Title=$fiedls['territory'.$i];		
							$datainsert['saleshierarchyType']=$hierarchy_type;
							$datainsert['saleshierarchyName']=$hierarchy_Title;
							$insert=new Insert('sales_hierarchy');
							$insert->values($datainsert);
							$statement=$this->adapter->createStatement();
							$insert->prepareStatement($this->adapter, $statement);
							$insertresult=$statement->execute();		
					} 														
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				} catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			}
		}if($resultset1) {
				$fiedls=$param->Form;
				$userid=$param->userid;

					$this->adapter->getDriver()->getConnection()->beginTransaction();
					try {
						$count_contentid=count($param->content_id);
						for($i=0;$i<$count_contentid;$i++) {

						$hierarchy_Title=$fiedls['territory'.$param->content_id[$i]['id']];
					    $datainsert['saleshierarchyName']=$hierarchy_Title;
						
						$sql = new Sql($this->adapter);
						$update = $sql->update();
						$update->table('sales_hierarchy');
						$update->set($datainsert);
						$update->where( array('idSaleshierarchy' =>$param->content_id[$i]['id']));
						$statement  = $sql->prepareStatementForSqlObject($update);
						$results    = $statement->execute();
					}
					if($statusqry==0){
						$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
					}else{
						$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
					}
						
						$this->adapter->getDriver()->getConnection()->commit();
					} catch(\Exception $e) {
						$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
						$this->adapter->getDriver()->getConnection()->rollBack();
					}		
			}
			else if($param->action=='editview') {
				$fiedls=$param->Form;
				$userid=$param->userid;
				for($i=1;$i<=10;$i++) {
					$hierarchyName=$fiedls['territory'.$i];	
				}
				$qry="SELECT tm.idSaleshierarchy as id,tm.saleshierarchyName as name FROM sales_hierarchy tm ";
				$result=$this->adapter->query($qry,array($i));
				$resultset=$result->toArray();
				$qry="SELECT a.idSaleshierarchy as id FROM sales_hierarchy a";
				$resultid=$this->adapter->query($qry,array($i));
				$resultsetid=$resultid->toArray();
				if(!$resultset){
					$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
				} else {
					$ret_arr=['code'=>'2','content'=>$resultset,'contentid'=>$resultsetid, 'status'=>true,'message'=>'Record available'];
				}
			}	
			
		return $ret_arr;
	}
	public function sys_setting($param)
	{
		//print_r($param); 
		if ($param->action=="list") 
		{
			$qry="SELECT * FROM `sys_config`";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();

			if(count($resultset)>0){
				$ret_arr=['code'=>'2','content'=>$resultset, 'status'=>true,'message'=>'Record available'];

			} else {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			}
		}
		return $ret_arr;
	}
    //this function used for common configuration for whole application
	public function sys_setting_add($param)
	{
		//print_r($param); 
		 if($param->action=="add")
		{
			$data=$param->data;
			$currency=$param->currency;
			$companyName=$param->companyName;
			$companyLandline=$param->companyLandline;
			$companyWebsite=$param->companyWebsite;
			$companyAddress=$param->companyAddress;
			$currency=$param->currency;
			$currency=$param->currency;
			//$fields=$param->Form;
			$userid=$param->userid;
		
			$uploads_dir ='public/uploads/logo';
			if ($_FILES) {
				$tmp_name=$_FILES["cmpnylogo"]["tmp_name"];
			$name =basename($_FILES["cmpnylogo"]["name"]);
			$imageName ='logo_'.date('dmyHi').'.'.pathinfo($_FILES["cmpnylogo"]['name'],PATHINFO_EXTENSION);
			}
			else
			{
				$imageName='';
			}
			
			//$ext=strtolower(pathinfo($_FILES["agencyfile"]['name'],PATHINFO_EXTENSION));
			// $ext=='jpeg' || $ext=='png' ||  $ext=='jpg'
			// print_r($param);
			// print_r($_FILES);
			// echo $imageName;
		
				$qry="SELECT * FROM `sys_config`";
				$result=$this->adapter->query($qry,array());
				$resultset=$result->toArray();

				$qryCurrency="SELECT * FROM `currency` WHERE code='$currency'";
				$resultCurrency=$this->adapter->query($qryCurrency,array());
				$resultsetCurrency=$resultCurrency->toArray();
				if (count($resultsetCurrency)>0) 
				{
					if($imageName)
					{
						if(move_uploaded_file($tmp_name,"$uploads_dir/$imageName")==false) 
						{
						$ret_arr=['code'=>'3','status'=>false,'message'=>'Please try again.. Failed to upload logo..'];
						$rollBack=true;	
						}  
						else {
						$imageName=trim($imageName);
						}
					}
					if(count($resultset)>0)
					{
						$this->adapter->getDriver()->getConnection()->beginTransaction();
						try {

							$dataupdate['currencyName']=$currency;
							if ($imageName!='')
							{
							 $dataupdate['companyLogo']=$imageName;	
							}
							$dataupdate['companyName']=$companyName;
							$dataupdate['companyLandline']=$companyLandline;
							$dataupdate['companyWebsite']=$companyWebsite;
							$dataupdate['companyAddress']=$companyAddress;	
							$dataupdate['updated_by']=1;
							$dataupdate['updated_at']=date('Y-m-d H:i:s');

							$sql = new Sql($this->adapter);
							$update = $sql->update();
							$update->table('sys_config');
							$update->set($dataupdate);
							$update->where( array('idSysconfig' =>$resultset[0]['idSysconfig']));
							$statement  = $sql->prepareStatementForSqlObject($update);
							$results    = $statement->execute();

							$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
							$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
							$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
							$this->adapter->getDriver()->getConnection()->rollBack();
						}		
					}
					else
					{
						$this->adapter->getDriver()->getConnection()->beginTransaction();
						try {


							$datainsert['currencyName']=$currency;
							$datainsert['companyLogo']=$imageName;
							$datainsert['companyName']=$companyName;
							$datainsert['companyLandline']=$companyLandline;
							$datainsert['companyWebsite']=$companyWebsite;
							$datainsert['companyAddress']=$companyAddress;
							$datainsert['created_by']=1;
							$datainsert['created_at']=date('Y-m-d H:i:s');	
							$insert=new Insert('sys_config');
							$insert->values($datainsert);
							$statement=$this->adapter->createStatement();
							$insert->prepareStatement($this->adapter, $statement);
							$insertresult=$statement->execute();		

							$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
							$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
							$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
							$this->adapter->getDriver()->getConnection()->rollBack();
						}
					}
				}
				else
				{
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Invalid currency code'];
					
				}

			
           
		}
		else if($param->action=="removeimage")
		{
          $idsysConfig=$param->id;
          $userid=$param->userid;
			$qry="SELECT companyLogo,currencyName,idSysconfig FROM `sys_config` WHERE idSysconfig='$idsysConfig'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
				$imgnm=$resultset[0]['companyLogo'];
				if ($imgnm!='' && $imgnm!=null) 
				{
					if(unlink('public/uploads/logo/'.$imgnm))
                	{ 
                      $imagremovestatus=true;
                	}
				}
                
                         $this->adapter->getDriver()->getConnection()->beginTransaction();
						try {
                            $imageupdate['companyLogo']='NULL';
							$imageupdate['currencyName']=$resultset[0]['currencyName'];		
							$imageupdate['updated_by']=1;
							$imageupdate['updated_at']=date('Y-m-d H:i:s');
                         
							$sql = new Sql($this->adapter);
							$update = $sql->update();
							$update->table('sys_config');
							$update->set($imageupdate);
							$update->where( array('idSysconfig' =>$resultset[0]['idSysconfig']));
							$statement  = $sql->prepareStatementForSqlObject($update);
							$results    = $statement->execute();

							$ret_arr=['code'=>'2','status'=>true,'message'=>'Logo removed successfully'];
							$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
							$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
							$this->adapter->getDriver()->getConnection()->rollBack();
						}
                	
                	
           	
		}
		
       return $ret_arr;
	}

}