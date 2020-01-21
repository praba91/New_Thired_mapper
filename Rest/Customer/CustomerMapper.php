<?php
namespace Sales\V1\Rest\Customer;
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


class CustomerMapper {

	protected $mapper;
	public function __construct(AdapterInterface $adapter) {
		// date_default_timezone_set("Asia/Manila");
		$this->adapter=$adapter;
		$this->commonfunctions  = new CommonFunctionsMapper($this->adapter);
	}
	/*public function fetchOne($param) {
		$validateToken=$this->commonfunctions->validateToken();
		if($validateToken->success){
			$from=$param->from;
			$action=$param->action;
			$returnval=$this->$from($param);
			return $returnval;
		}else{
			return $validateToken;
		}
	}
*/
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
	public function add_employee($param) {
			if($param->action=='add') {
			$mobile_no=$param->mblno;
			$emailid=$param->emailid;
			$rprtmngr1=$param->rprtmngr1;
			$rprtmngr2=$param->rprtmngr2;
			$rprtmngr3=$param->rprtmngr3;

			
			$qry="SELECT * FROM team_member_master a where a.mobileno=? OR a.emailId=?";
			$result=$this->adapter->query($qry,array($mobile_no,$emailid));
			$resultset=$result->toArray();
			if($resultset) {
				return $ret_arr=['code'=>'3','status'=>false,'message'=>'Emailid or Mobile number already Exists'];
			}
			$uploads_dir ='public/uploads/emp';
			if($_FILES) {
				$tmp_name=$_FILES["profile_image"]["tmp_name"];
				$name =basename($_FILES["profile_image"]["name"]);
				$imageName ='employee_'.date('dmyHi').'.'.pathinfo($_FILES["profile_image"]['name'],PATHINFO_EXTENSION);
				$ext=strtolower(pathinfo($_FILES["profile_image"]['name'],PATHINFO_EXTENSION));
				if($ext=='jpeg' || $ext=='png' ||  $ext=='jpg'){
					if(move_uploaded_file($tmp_name,
						"$uploads_dir/$imageName")==false) {
						$ret_arr=['code'=>'3','status'=>false,'message'=>'Please try again.. Failed to upload logo..'];
						$rollBack=true;	
					}  else {
						$data['image']=trim($imageName);
					}
				} else {
					$ret_arr=['code'=>'3','status'=>false,'message'=>'Please select valid format for logo like (PNG,JPG,JPEG)..'];
					$rollBack=true;	
				}
			}	
				$userid=$param->userid;
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['code']=$param->empid;
					$datainsert['name']=$param->empname;
					$datainsert['mobileno']=$param->mblno;
					$datainsert['landline']=$param->lndline;
					$datainsert['emailId']=$param->emailid;
					$datainsert['address']=$param->address;
					if ($imageName!='') {
					$datainsert['photo']=$imageName;
					} 				
					$datainsert['designation']=$param->designation;
					$datainsert['isRepManager']=$param->repoting_mngrstatus;
					if($rprtmngr1!='undefined') {
					$datainsert['reportingTo']=$param->rprtmngr1;
					} else {
						$datainsert['reportingTo']="0";
					}
					if($rprtmngr2!='undefined') {
					$datainsert['reportingTo2']=$param->rprtmngr2;
					} else {
						$datainsert['reportingTo2']="0";
					}
					if($rprtmngr3!='undefined') {
					$datainsert['reportingTo3']=$param->rprtmngr3;
					} else {
						$datainsert['reportingTo3']="0";
					}
					$datainsert['idMainGroup']=$param->maingroup;
					$datainsert['idSubsidaryGroup']=$param->subsidiary;
					$datainsert['proposition']=$param->proposition_type;
					$datainsert['segment']=$param->segment_type;
					$datainsert['t1']=$param->T1;
					$datainsert['t2']=$param->T2;
					$datainsert['t3']=$param->T3;
					$datainsert['t4']=$param->T4;
					$datainsert['t5']=$param->T5;
					$datainsert['t6']=$param->T6;
					$datainsert['t7']=$param->T7;
					$datainsert['t8']=$param->T8;
					$datainsert['t9']=$param->T9;
					$datainsert['t10']=$param->T10;
					$datainsert['created_by']=$userid;
					$datainsert['created_at']=date('Y-m-d H:i:s');
					$datainsert['updated_by']=$userid;
					$datainsert['updated_at']=date('Y-m-d H:i:s');
					
					
					$insert=new Insert('team_member_master');
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
			} else if($param->action=='update') {
			$userid=$param->userid;
			$editid=$param->idTeamMember;
				$rprtmngr1=$param->rprtmngr1;
			$rprtmngr2=$param->rprtmngr2;
			$rprtmngr3=$param->rprtmngr3;
			$uploads_dir ='public/uploads/emp';
			if($_FILES){
				$tmp_name=$_FILES["profile_image"]["tmp_name"];
				$name =basename($_FILES["profile_image"]["name"]);
				$imageName ='employee_'.date('dmyHi').'.'.pathinfo($_FILES["profile_image"]['name'],PATHINFO_EXTENSION);
				$ext=strtolower(pathinfo($_FILES["profile_image"]['name'],PATHINFO_EXTENSION));
				if($ext=='jpeg' || $ext=='png' ||  $ext=='jpg'){
					if(move_uploaded_file($tmp_name,
						"$uploads_dir/$imageName")==false) {
						$ret_arr=['code'=>'3','status'=>false,'message'=>'Please try again.. Failed to upload logo..'];
						$rollBack=true;	
					} 
					else{
						$data['image']=trim($imageName);
					}
				}
				else{
					$ret_arr=['code'=>'3','status'=>false,'message'=>'Please select valid format for logo like (PNG,JPG,JPEG)..'];
					$rollBack=true;	
				}
			}else{
				$imageName=Null;
			}
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['code']=$param->empid;
					$datainsert['name']=$param->empname;
					$datainsert['mobileno']=$param->mblno;
					$datainsert['landline']=$param->lndline;
					$datainsert['emailId']=$param->emailid;
					$datainsert['address']=$param->address;
					if ($imageName!='') {
					$datainsert['photo']=$imageName;
					} 				
					$datainsert['designation']=$param->designation;
					$datainsert['isRepManager']=$param->rprtmngrstatus;
					//$datainsert['reportingTo']=$param->rprtmngr;
					if($rprtmngr1!='undefined') {
					$datainsert['reportingTo']=$param->rprtmngr1;
					} else {
						$datainsert['reportingTo']="0";
					}
					if($rprtmngr2!='undefined') {
					$datainsert['reportingTo2']=$param->rprtmngr2;
					} else {
						$datainsert['reportingTo2']="0";
					}
					if($rprtmngr3!='undefined') {
					$datainsert['reportingTo3']=$param->rprtmngr3;
					} else {
						$datainsert['reportingTo3']="0";
					}
					$datainsert['idMainGroup']=$param->maingroup;
					$datainsert['idSubsidaryGroup']=$param->subsidiary;
					$datainsert['proposition']=$param->proposition_type;
					$datainsert['segment']=$param->segment_type;
					$datainsert['t1']=$param->T1;
					$datainsert['t2']=$param->T2;
					$datainsert['t3']=$param->T3;
					$datainsert['t4']=$param->T4;
					$datainsert['t5']=$param->T5;
					$datainsert['t6']=$param->T6;
					$datainsert['t7']=$param->T7;
					$datainsert['t8']=$param->T8;
					$datainsert['t9']=$param->T9;
					$datainsert['t10']=$param->T10;
					$datainsert['updated_by']=$userid;
					$datainsert['updated_at']=date('Y-m-d H:i:s');
					$sql = new Sql($this->adapter);
					$update = $sql->update();
					$update->table('team_member_master');
					$update->set($datainsert);
					$update->where( array('idTeamMember'=>$editid));
					$statement  = $sql->prepareStatementForSqlObject($update);
					$results    = $statement->execute();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				} catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			}
			else if($param->action=='edit'){
			$editid=$param->id;
			$tery_title=$param->tery_title;
           
			$qry="SELECT a.*,HT1.territoryValue as territory1Sel,HT2.territoryValue as territory2Sel,HT3.territoryValue as territory3Sel,HT4.territoryValue as territory4Sel,HT5.territoryValue as territory5Sel,HT6.territoryValue as territory6Sel,HT7.territoryValue as territory7Sel,HT8.territoryValue as territory8Sel,HT9.territoryValue as territory9Sel,HT10.territoryValue as territory10Sel,mm.mainGroupName,sm.subsidaryName,st.segmentName,sh.saleshierarchyName,b.name as reportName1,c.name as reportName2,d.name as reportName3,des.name as designationName
			FROM team_member_master a 
            LEFT JOIN maingroup_master as mm ON  mm.idMainGroup=a.idMainGroup
            LEFT JOIN segment_type as st ON st.idsegmentType=a.segment
            LEFT JOIN subsidarygroup_master as sm ON sm.idSubsidaryGroup=a.idSubsidaryGroup
            LEFT JOIN sales_hierarchy as sh ON sh.idSaleshierarchy=a.idSaleshierarchy
            LEFT JOIN team_member_master as b ON b.idTeamMember=a.reportingTo
            LEFT JOIN team_member_master as c ON c.idTeamMember=a.reportingTo2 
            LEFT JOIN team_member_master as d ON d.idTeamMember=a.reportingTo3
            LEFT JOIN designation as des ON des.idDesignation=a.designation
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
			where a.idTeamMember=?";
               // $qry="SELECT * FROM factory_master where idFactory=?";
			$result=$this->adapter->query($qry,array($editid));
			$resultset=$result->toArray();
             //proposition

			$qryProposition="SELECT A.proposition as id from subsidarygroup_master A where A.idSubsidaryGroup='".$resultset[0]['idSubsidaryGroup']."'";              
			$resultProposition=$this->adapter->query($qryProposition,array($editid));
			$resultsetProposition=$resultProposition->toArray();
            //
			$qrySegment="SELECT A.segment as id from subsidarygroup_master A where  A.idSubsidaryGroup='".$resultset[0]['idSubsidaryGroup']."' AND A.proposition='".$resultset[0]['proposition']."'";              
			$resultSegment=$this->adapter->query($qrySegment,array($editid));
			$resultsetSegment=$resultSegment->toArray();
              
			$qrytery="SELECT * FROM team_member_master a where a.idTeamMember=?";
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
				$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'terytitle' =>$resultset_terytitle,'tertitle'=>$tery_title,'proposition'=>$resultsetProposition,'segment'=>$resultsetSegment,'message'=>'data available'];
			}
		}
			return $ret_arr;
	}
	public function removelLogo($param) {
		$editid=$param->employee_id;
		$userid=$param->userid;
		
		$this->adapter->getDriver()->getConnection()->beginTransaction();
		try {
			$datainsert['photo']='0';
			$datainsert['updated_by']=$userid;
			$datainsert['updated_at']=date('Y-m-d H:i:s');
			$sql = new Sql($this->adapter);
			$update = $sql->update();
			$update->table('team_member_master');
			$update->set($datainsert);
			$update->where( array('idTeamMember'=>$editid));
			$statement  = $sql->prepareStatementForSqlObject($update);
			$results    = $statement->execute();
			$ret_arr=['code'=>'2','status'=>true,'message'=>'Profile photo removed successfully'];
			$this->adapter->getDriver()->getConnection()->commit();
		} catch(\Exception $e) {
			$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			$this->adapter->getDriver()->getConnection()->rollBack();
		}
		return $ret_arr;
	}
	

	public function primarypackage($param)
	{
		if($param->action=='list') 
		  {
			    $qry="SELECT a.idPrimaryPackaging,a.primarypackname,a.status,b.subpackname 
			    	  FROM primary_packaging as a  
			    	  LEFT JOIN sub_packaging b ON b.idSubPackaging=a.idSubPackaging";
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
		else if($param->action=='subpackagedropdown'){
			$qry="SELECT * FROM sub_packaging where status='1'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			}else{
				$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'message'=>'System config information'];
			}

		}     
     	else if($param->action=='add') 
     		{
			$fiedls=$param->Form;
			$paktype=$fiedls['paktype'];
			$status=$fiedls['pstatus'];
			$qry="SELECT a.idPrimaryPackaging,a.primarypackname,a.status,b.idSubPackaging,b.subpackname FROM primary_packaging a 
				  LEFT JOIN sub_packaging b ON b.idSubPackaging=a.idSubPackaging	 
				  where a.primarypackname=? and b.idSubPackaging=?";
			$result=$this->adapter->query($qry,array($paktype,$fiedls['subpackage']));
			$resultset=$result->toArray();
			if(!$resultset) 
			{ 
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['primarypackname']=$fiedls['paktype'];
					$datainsert['idSubPackaging']=$fiedls['subpackage'];
					$datainsert['created_at']=date("Y-m-d H:i:s"); 
					$datainsert['created_by']=$param->userid;
					$datainsert['status']=$fiedls['pstatus'];
					$insert=new Insert('primary_packaging');
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
			     $qry="SELECT a.idPrimaryPackaging, a.primarypackname,a.status,b.idSubPackaging as subpackage,b.subpackname as subpackname FROM primary_packaging as a
			     LEFT JOIN sub_packaging as b ON b.idSubPackaging=a.idSubPackaging
			     where idPrimaryPackaging=?";
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
			$editid=$fiedls['idPrimaryPackaging'];
			// print_r($editid);exit;
			$qry="SELECT a.primarypackname,a.idPrimaryPackaging,b.idSubPackaging as subpackage FROM primary_packaging as a 
				   LEFT JOIN sub_packaging as b ON b.idSubPackaging=a.idSubPackaging  
				   where a.primarypackname=? and b.idSubPackaging=? and a.idPrimaryPackaging!=?";
			$result=$this->adapter->query($qry,array($fiedls['primarypackname'],$fiedls['subpackage'],$editid));
			$resultset=$result->toArray();
			if(!$resultset){
				//print_r($fiedls);
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try{
					$datainsert['primarypackname']=$fiedls['primarypackname'];
					$datainsert['idSubPackaging']=$fiedls['subpackage'];
					$datainsert['status']=$fiedls['status'];
					$datainsert['updated_at']=date("Y-m-d H:i:s");
					$datainsert['updated_by']=$param->userid;
					$sql = new Sql($this->adapter );
					$update = $sql->update();
					$update->table('primary_packaging');
					$update->set($datainsert);
					$update->where( array('idPrimaryPackaging' => $editid));
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


	public function productcontent($param)
	{
		if($param->action=='list') 
		  {
			    $qry="SELECT * FROM product_content";
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
			$paktype=$fiedls['productcon'];
			$status=$fiedls['pstatus'];
			$qry="SELECT * FROM product_content a where a.productContent=?";
			$result=$this->adapter->query($qry,array($paktype));
			$resultset=$result->toArray();
			if(!$resultset) 
			{ 
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['productContent']=$fiedls['productcon'];
					$datainsert['created_at']=date("Y-m-d H:i:s"); 
					$datainsert['created_by']=$param->userid;
					$datainsert['status']=$fiedls['pstatus'];
					$insert=new Insert('product_content');
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
			     $qry="SELECT idProductContent,productContent,status  FROM product_content where idProductContent=?";
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
			$editid=$fiedls['idProductContent'];
			// print_r($editid);exit;
			$qry="SELECT * FROM product_content where productContent=? and 	idProductContent!=?";
			$result=$this->adapter->query($qry,array($fiedls['productContent'],$editid));
			$resultset=$result->toArray();
			if(!$resultset){
				//print_r($fiedls);
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try{
					$datainsert['productContent']=$fiedls['productContent'];
					$datainsert['status']=$fiedls['status'];
					$datainsert['updated_at']=date("Y-m-d H:i:s");
					$datainsert['updated_by']=$param->userid;
					$sql = new Sql($this->adapter );
					$update = $sql->update();
					$update->table('product_content');
					$update->set($datainsert);
					$update->where( array('idProductContent' => $editid));
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


	public function add_product($param) 
	{
		 
          if($param->action=='list')
           {
               $qry="SELECT PD.idProduct,PD.productCode,PD.productName,PD.productVariant1,PD.productVariant2,PD.status,C.category,SC.subcategory FROM `product_details` as PD LEFT JOIN category as C on C.idCategory=PD.idCategory LEFT JOIN subcategory as SC on SC.idSubCategory=PD.idSubCategory  GROUP BY PD.idProduct";
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

          else if($param->action=='catlist')
           {
               $qry="SELECT idCategory,category FROM `category` WHERE status=1";
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
           else if($param->action=='subcatlist')
           {
           	    $terid=($param->terid)?$param->terid:'';
           	    $catid=($param->idcat)?$param->idcat:'';
           	    $condition=($catid)?" AND idCategory=".$catid:'';
               $qry="SELECT a.idProductTerritory as id,pd.idProduct as idProduct ,pd.idCategory,pd.idSubCategory,pd.productName as productName,c.subcategory
			FROM product_territory_details a 
			LEFT JOIN product_details as pd ON pd.idProduct=a.idProduct
			LEFT JOIN subcategory as c ON c.idSubCategory=pd.idSubCategory
			WHERE idTerritory IN($terid) AND pd.idCategory='$catid' AND pd.status='1' GROUP by idSubCategory";
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

           else if($param->action=='hsnlist')
           {
           	    
               $qry="SELECT idHsncode,	hsn_code,description FROM `hsn_details` WHERE status=1";
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
           else if($param->action=='productlist')
           {
           	    $terid=($param->terid)?$param->terid:'';
           	    $catid=($param->idcat)?$param->idcat:'';
           	    $subcatid=($param->idsubcat)?$param->idsubcat:'';
           	    $condition=($catid)?" AND idCategory=".$catid:'';
           	    $subcondition=($subcatid)?" AND idSubCategory=".$subcatid:'';
               	$qry="SELECT a.idProductTerritory as id,pd.idProduct as idProduct ,pd.idCategory,pd.idSubCategory,pd.productName as productName
			FROM product_territory_details a 
			LEFT JOIN product_details as pd ON pd.idProduct=a.idProduct
			WHERE idTerritory IN($terid) AND pd.idCategory='$catid' AND pd.idSubCategory='$subcatid' AND pd.status='1'";
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
           }else if($param->action=='productsize')
           {
           	    $productid=($param->idproduct)?$param->idproduct:'';
           	    $condition=($productid)?"idProduct=".$productid:'';
               $qry="SELECT idProductsize,productSize,idProduct FROM `product_size` WHERE $condition AND status=1";
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


           else if($param->action=='productsizelist')
           {
           	    $productid=($param->idproduct)?$param->idproduct:'';
           	   // print_r($productid); 
           	    //$condition=($productid)?"idProduct=".$productid:'';
               $qry="SELECT ps.idProductsize,ps.productSize,pd.idProduct,pd.productCount,pp.primarypackname,pp.idPrimaryPackaging FROM product_details as pd LEFT JOIN `product_size` as ps on ps.idProduct=pd.idProduct LEFT JOIN primary_packaging as pp on pp.idPrimaryPackaging=ps.idPrimaryPackaging WHERE pd.idProduct='$productid'";
               //echo $qry;
			    $result=$this->adapter->query($qry,array());
			    $resultset=$result->toArray();
                 //print_r($resultset);exit;
			     
			    if(!$resultset) 
			    {
				  $ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			    } 
			    else 
			    {
				$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'message'=>'System config information'];
			    }
           }
           else if($param->action=='productsizedata')
           {
           	    $productsizeid=($param->idproductsize)?implode(',',$param->idproductsize):'';
           	     $productid=($param->idproduct)?$param->idproduct:'';
           	    //$condition=($productid)?"idProduct=".$productid:'';
           	     
               $qry="SELECT ps.idProductsize,ps.productSize,ps.`idPrimaryPackaging`,ps.`idSecondaryPackaging`,ps.`productPrimaryCount`,ps.`productSecondaryCount`,sp.secondarypackname,pp.primarypackname FROM `product_size` as ps LEFT JOIN primary_packaging as pp on pp.idPrimaryPackaging=ps.idPrimaryPackaging LEFT JOIN secondary_packaging as sp on sp.idSecondaryPackaging=ps.idSecondaryPackaging WHERE idProductsize in ($productsizeid)";
			    $result=$this->adapter->query($qry,array());
			    $resultset=$result->toArray();
			    for($i=0;$i<count($resultset);$i++)
			    {
					$datafinal[$i]['idProductsize']=$resultset[$i]['idProductsize'];
					$datafinal[$i]['productSize']=$resultset[$i]['productSize'];
					$datafinal[$i]['idPrimaryPackaging']=$resultset[$i]['idPrimaryPackaging'];
					$datafinal[$i]['idSecondaryPackaging']=$resultset[$i]['idSecondaryPackaging'];
					$datafinal[$i]['productPrimaryCount']=$resultset[$i]['productPrimaryCount'];
					$datafinal[$i]['productSecondaryCount']=$resultset[$i]['productSecondaryCount'];
					$datafinal[$i]['primarypackname']=$resultset[$i]['primarypackname'];
					$datafinal[$i]['secondarypackname']=$resultset[$i]['secondarypackname'];
					$datafinal[$i]['priceDate']='';
					$datafinal[$i]['priceAmount']=0;
                       
			    }
			    $limit=count($param->idproductsize);
                   
					$qryproduct="SELECT priceDate,priceAmount from price_fixing WHERE idProduct='$productid' and idProductsize in ($productsizeid) order by `idPricefixing` desc limit $limit";
					$resultproduct=$this->adapter->query($qryproduct,array());
					$resultsetproduct=$resultproduct->toArray();
                 if(count($resultsetproduct)>0)
                 {
                    for($i=0;$i<count($resultsetproduct);$i++)
                    {
                       $datafinal[$i]['priceDate']=$resultsetproduct[$i]['priceDate'];
                       $datafinal[$i]['priceAmount']=$resultsetproduct[$i]['priceAmount'];
                    }
                 }
			  
			    if(!$resultset) 
			    {
				  $ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			    } 
			    else 
			    {
				$ret_arr=['code'=>'2','status'=>true,'content' =>$datafinal,'productcontent'=>$datafinal,'message'=>'System config information'];
			    }
           }
           else if($param->action=='productsizename')
           {
           	    $productsizeid=($param->productsize)?$param->productsize:'';
           	    $condition=($productsizeid)?"idProductsize=".$productsizeid:'';
               $qry="SELECT idProductsize,productSize FROM `product_size` WHERE $condition";
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
           }else if($param->action=='freproductsize')
           {
           	    $freproductid=($param->freproductsize)?$param->freproductsize:'';
           	    $condition=($freproductid)?"idProduct=".$freproductid:'';
               $qry="SELECT idProductsize,productSize,idProduct FROM `product_size` WHERE $condition AND status=1";
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
           else if($param->action=='productname')
           {
           	    $productnameid=($param->productname)?$param->productname:'';
           	    $condition=($productnameid)?"idProduct=".$productnameid:'';
               $qry="SELECT idProduct,productName FROM `product_details` WHERE $condition";
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
           else if($param->action=='packagelist')
           {
           	   $primaryid=($param->idprimary)?$param->idprimary:'';
           	   $condition=($primaryid)?" AND idPrimaryPackaging=".$primaryid:'';
           	   $secondaryid=($param->idsecondary)?$param->idsecondary:'';
           	   $condition2=($secondaryid)?" AND idSecondaryPackaging=".$secondaryid:'';

               $primaryqry="SELECT 	idPrimaryPackaging,primarypackname FROM `primary_packaging` WHERE status=1";
			   $primaryresult=$this->adapter->query($primaryqry,array());
			   $primaryresultset=$primaryresult->toArray();
                
			   $secondaryqry="SELECT idSecondaryPackaging,secondarypackname FROM `secondary_packaging` WHERE status=1";
			   $secondaryresult=$this->adapter->query($secondaryqry,array());
			   $secondaryresultset=$secondaryresult->toArray();


			    $subpackqry="SELECT idSubPackaging,	subpackname FROM `sub_packaging` WHERE status=1";
			    $subpackresult=$this->adapter->query($subpackqry,array());
			    $subpackresultset=$subpackresult->toArray();

			    if(!$primaryresultset and !$secondaryresultset and $subpackresultset) 
			    {
				  $ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			    } 
			    else 
			    {
				$ret_arr=['code'=>'2','status'=>true,'primarycontent' =>$primaryresultset,'secondarycontent' =>$secondaryresultset,'subpackcontent' =>$subpackresultset,'message'=>'System config information'];
			    }
           }

           
           else if($param->action=='productcontentlist')
           {
               $qry="SELECT 	idProductContent,productContent FROM `product_content` WHERE status=1";
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
           else if($param->action=='productstatuslist')
           {
               $qry="SELECT 	idProductStatus,productStatus FROM `product_status` WHERE status=1";
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
            else if($param->action=='territorylist')
           {
               $qry="SELECT idTerritoryTitle,hierarchy,title FROM `territorytitle_master` WHERE title!=''";
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

           else if($param->action=='subterritorylist')
           {
           	    $territoryid=$param->idterritory;
               $t1qry="SELECT 	idTerritory,idTerritoryTitle,territoryCode,territoryValue FROM `territory_master` WHERE status=1 AND idTerritoryTitle='$territoryid'";
			    $t1result=$this->adapter->query($t1qry,array());
			    $t1resultset=$t1result->toArray();
			     for($i=0;$i<count($t1resultset);$i++) 
			    {
			    	
			    	$t1resultset[$i]['checked']=false;
			    	
			    }
			     if(!$t1resultset) 
			    {
				  $ret_arr=['code'=>'1','status'=>false,'message'=>'No data available..'];
			    } 
			    else 
			    {
				$ret_arr=['code'=>'2','status'=>true,'content' =>$t1resultset,'message'=>'data available'];
			    }

		    
           }
			else if($param->action=='add') 
			{
				
			$pcode=$param->pcode;
			$pname=$param->pname;
			//$fields=$param->Form;
			// echo $pcode=$fields['pcode']."<br>";
			// print_r($fields);exit;
			$qry="SELECT * FROM product_details a where a.productName=? OR a.productCode=?";
			$result=$this->adapter->query($qry,array($pname,$pcode));
			$resultset=$result->toArray();
			if($resultset) {
				return $ret_arr=['code'=>'3','status'=>false,'message'=>'Product name or product code already Exists'];
			}
			$uploads_dir ='public/uploads/product';

			if($_FILES) 
			{


				if($_FILES["imageleft"]["tmp_name"]!="")
				{
					
                  $leftimage_name=$_FILES["imageleft"]["tmp_name"];
                  $leftimage_tempname=$_FILES["imageleft"]["name"];
                  	$leftimageName ='leftimage_'.date('dmyHi').'.'.pathinfo($_FILES["imageleft"]['name'],PATHINFO_EXTENSION);
                  	$leftimageext=strtolower(pathinfo($_FILES["imageleft"]['name'],PATHINFO_EXTENSION));
                  	$leftimagetempname =basename($_FILES["imageleft"]["name"]);

                  	if($leftimageext=='jpeg' || $leftimageext=='png' ||  $leftimageext=='jpg')
				    {
					if(move_uploaded_file($leftimage_name,"$uploads_dir/$leftimageName")==false) 
					{
                      $leftimagestatus=false;
                      $leftimagemsg="image not move to folder";
					}
					else
					{
						 $leftimagestatus=true;
						 $leftimagemsg="success";
					}
				    }
				    else
				    {
				    	 $leftimagestatus=false;
						 $leftimagemsg="image file type invalid.Please select valid format for logo like (PNG,JPG,JPEG)..";
				    }
				}
				else
				    {
				    	 $leftimagestatus=false;
						 $leftimagemsg="image not available";
				    }

				if($_FILES["imageright"]["tmp_name"]!="")
				{
                    $rightimage_name=$_FILES["imageright"]["tmp_name"];
                    $rightimage_tempname=$_FILES["imageright"]["name"];
                  
				   $rightimageName ='rightimage_'.date('dmyHi').'.'.pathinfo($_FILES["imageright"]['name'],PATHINFO_EXTENSION);
                  	$rightimageext=strtolower(pathinfo($_FILES["imageright"]['name'],PATHINFO_EXTENSION));
                  	$rightimagetempname =basename($_FILES["imageright"]["name"]);

                  	if($rightimageext=='jpeg' || $rightimageext=='png' ||  $rightimageext=='jpg')
				    {
					if(move_uploaded_file($rightimage_name,"$uploads_dir/$rightimageName")==false) 
					{
                      $rightimagestatus=false;
                      $rightimagemsg="image not move to folder";
					}
					else
					{
						 $rightimagestatus=true;
						 $rightimagemsg="success";
					}
				    }
				    else
				    {
				    	 $rightimagestatus=false;
						 $rightimagemsg="image file type invalid.Please select valid format for logo like (PNG,JPG,JPEG)..";
				    }
				}
				else
				    {
				    	 $rightimagestatus=false;
						 $rightimagemsg="image not available";
				    }

				  if($_FILES["imagetop"]["tmp_name"]!="")
				{
                   $topimage_name=$_FILES["imagetop"]["tmp_name"];
				   $topimage_tempname=$_FILES["imagetop"]["name"];
			       $topimageName ='topimage_'.date('dmyHi').'.'.pathinfo($_FILES["imagetop"]['name'],PATHINFO_EXTENSION);
                   $topimageext=strtolower(pathinfo($_FILES["imagetop"]['name'],PATHINFO_EXTENSION));
                   $topimagetempname =basename($_FILES["imagetop"]["name"]);


                  	if($topimageext=='jpeg' || $topimageext=='png' ||  $topimageext=='jpg')
				    {
					if(move_uploaded_file($topimage_name,"$uploads_dir/$topimageName")==false) 
					{
                      $topimagestatus=false;
                      $topimagemsg="image not move to folder";
					}
					else
					{
						 $topimagestatus=true;
						 $topimagemsg="success";
					}
				    }
				    else
				    {
				    	 $topimagestatus=false;
						 $topimagemsg="image file type invalid.Please select valid format for logo like (PNG,JPG,JPEG)..";
				    }
				}
				else
				    {
				    	 $topimagestatus=false;
						 $topimagemsg="image not available";
				    }  
				
				 if($_FILES["imagebottom"]["tmp_name"]!="")
				{
                  $buttomimage_name=$_FILES["imagebottom"]["tmp_name"];
				$buttomimage_tempname=$_FILES["imagebottom"]["name"];
                $bottomimageName ='bottomimage_'.date('dmyHi').'.'.pathinfo($_FILES["imagebottom"]['name'],PATHINFO_EXTENSION);
                $bottomimageext=strtolower(pathinfo($_FILES["imagebottom"]['name'],PATHINFO_EXTENSION));
                 $bottomimagetempname =basename($_FILES["imagebottom"]["name"]);

                  	if($bottomimageext=='jpeg' || $bottomimageext=='png' ||  $bottomimageext=='jpg')
				    {
					if(move_uploaded_file($buttomimage_name,"$uploads_dir/$bottomimageName")==false) 
					{
                      $bottomimagestatus=false;
                      $bottomimagemsg="image not move to folder";
					}
					else
					{
						 $bottomimagestatus=true;
						 $bottomimagemsg="success";
					}
				    }
				    else
				    {
				    	 $bottomimagestatus=false;
						 $bottomimagemsg="image file type invalid.Please select valid format for logo like (PNG,JPG,JPEG)..";
				    }
				}
				else
				    {
				    	 $bottomimagestatus=false;
						 $bottomimagemsg="image not available";
				    }
				
				 if($_FILES["imagesideleft"]["tmp_name"]!="")
				{
                   $sideleftimage_name=$_FILES["imagesideleft"]["tmp_name"];
				   $sideleftimage_tempname=$_FILES["imagesideleft"]["name"];
                   $sideleftimageName ='sideleftimage_'.date('dmyHi').'.'.pathinfo($_FILES["imagesideleft"]['name'],PATHINFO_EXTENSION);
                  $sideleftimageext=strtolower(pathinfo($_FILES["imagesideleft"]['name'],PATHINFO_EXTENSION));
				  $sideleftimagetempname =basename($_FILES["imagesideleft"]["name"]);
				

                  	if($sideleftimageext=='jpeg' || $sideleftimageext=='png' ||  $sideleftimageext=='jpg')
				    {
					if(move_uploaded_file($sideleftimage_name,"$uploads_dir/$sideleftimageName")==false) 
					{
                      $sideleftimagestatus=false;
                      $sideleftimagemsg="image not move to folder";
					}
					else
					{
						 $sideleftimagestatus=true;
						 $sideleftimagemsg="success";
					}
				    }
				    else
				    {
				    	 $sideleftimagestatus=false;
						 $sideleftimagemsg="image file type invalid.Please select valid format for logo like (PNG,JPG,JPEG)..";
				    }
				}
				else
				    {
				    	 $sideleftimagestatus=false;
						 $sideleftimagemsg="image not available";
				    } 

				 if($_FILES["imagesideright"]["tmp_name"]!="")
				{
                 
				$siderightimage_name=$_FILES["imagesideright"]["tmp_name"];
                $siderightimage_tempname=$_FILES["imagesideright"]["name"];
                $siderightimageName ='siderightimage_'.date('dmyHi').'.'.pathinfo($_FILES["imagesideright"]['name'],PATHINFO_EXTENSION);
                $siderightimageext=strtolower(pathinfo($_FILES["imagesideright"]['name'],PATHINFO_EXTENSION));
				$siderightimagetempname =basename($_FILES["imagesideright"]["name"]);

                  	if($siderightimageext=='jpeg' || $siderightimageext=='png' ||  $siderightimageext=='jpg')
				    {
					if(move_uploaded_file($siderightimage_name,"$uploads_dir/$siderightimageName")==false) 
					{
                      $siderightimagestatus=false;
                      $siderightimagemsg="image not move to folder";
					}
					else
					{
						 $siderightimagestatus=true;
						 $siderightimagemsg="success";
					}
				    }
				    else
				    {
				    	 $siderightimagestatus=false;
						 $siderightimagemsg="image file type invalid.Please select valid format for logo like (PNG,JPG,JPEG)..";
				    }
				}
				else
				    {
				    	 $siderightimagestatus=false;
						 $siderightimagemsg="image not available";
				    }

				
                  if($siderightimagestatus==false && $sideleftimagestatus && $bottomimagestatus==false && $topimagestatus==false && $rightimagestatus==false && $leftimagestatus==false)
                  {
                  	  $ret_arr=['code'=>'3','status'=>false,'message'=>'Please try again.. Failed to upload logo..'];
						$rollBack=true;
                  }
                  else
                  {
                  	  $datainsert['productImageLeft']=trim($leftimageName);
                  	  $datainsert['productImageRight']=trim($rightimageName);
                  	  $datainsert['productImageTop']=trim($topimageName);
                  	  $datainsert['productImageBottom']=trim($bottomimageName);
                  	  $datainsert['productImageLeftSide']=trim($sideleftimageName);
                  	  $datainsert['productImageRightSide']=trim($siderightimageName);
                  }
				

				
			} // file if close	
				$userid=$param->userid;
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['productCode']=$param->pcode;
					$datainsert['productName']=$param->pname;
					$datainsert['productSubName']=$param->spname;
					$datainsert['idCategory']=$param->category;
					$datainsert['idSubCategory']=$param->subcategory;
					$datainsert['productVariant1']=$param->variantone;
					// if ($imageName!='') {
					// $datainsert['photo']=$imageName;
					// } 				
					$datainsert['productVariant2']=$param->varianttwo;
					$datainsert['productBrand']=$param->brand;
					$datainsert['productShelflife']=$param->selflife;
					$datainsert['productShelf']=$param->selflifecount;
					$datainsert['productReturn']=$param->policy;
					$datainsert['productReturnDays']=$param->returndays;
					$datainsert['productReturnOption']=$param->returnoption;
					$datainsert['idProductContent']=$param->productcontent;
					$datainsert['idProductStatus']=$param->productstatus;
					$datainsert['idPrimaryPackaging']=$param->primarypackage;
					$datainsert['idSecondaryPackaging']=$param->secondarypackage;
					$datainsert['productUnit']=$param->baseunit;
					$datainsert['productCount']=$param->unitcount;
					$datainsert['productSize']=$param->psize;
					$datainsert['productPrimaryCount']=$param->primarycount;
					$datainsert['productSecondaryCount']=$param->secondarycount;
					$datainsert['idTerritoryTitle']=$param->territory;					
					$datainsert['status']=$param->status;
					$datainsert['created_by']=$param->userid;
					$datainsert['created_at']=date('Y-m-d H:i:s');
					$datainsert['updated_by']=$param->userid;
					$datainsert['updated_at']=date('Y-m-d H:i:s');

					$insert=new Insert('product_details');
					$insert->values($datainsert);
					$statement=$this->adapter->createStatement();
					$insert->prepareStatement($this->adapter, $statement);
					$insertresult=$statement->execute();
					$productid=$this->adapter->getDriver()->getLastGeneratedValue();
					$territoryinsert['idProduct']=$productid;
					$subterritory=explode(",",$param->subterritory);
					
					$insertt=new Insert('product_territory_details');
					for($i=0;$i<count($subterritory);$i++)
					{
                       $territoryinsert['idTerritory']=$subterritory[$i];
                       $insertt->values($territoryinsert);
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


			}

             else if($param->action=='editview')
           {
           	// print_r($resultset); exit;
           	    $productid=$param->productid;
               $qry="SELECT PD.idProduct,PD.idHsncode,hsn.hsn_code,hsn.description,PD.productCode,PD.productName,PD.productSubName,PD.productVariant1,PD.productVariant2,PD.productBrand,PD.productShelflife,PD.productShelf,PD.productReturn,PD.productReturnDays,PD.productReturnOption,PD.productUnit,PD.productCount,PD.productSize,PD.productPrimaryCount,PD.productSecondaryCount,PD.productImageLeft,PD.productImageRight,PD.productImageTop,PD.productImageBottom,PD.productImageLeftSide,PD.productImageRightSide,PD.status,C.category,SC.subcategory,PC.productContent,PS.productStatus,PP.primarypackname,SP.secondarypackname ,TT.title,PD.idPrimaryPackaging,PD.idSubCategory,PD.idCategory,PD.idSecondaryPackaging,PD.idProductStatus,PD.idProductContent,PD.idTerritoryTitle  FROM `product_details` as PD LEFT JOIN category as C on C.idCategory=PD.idCategory LEFT JOIN subcategory as SC on SC.idSubCategory=PD.idSubCategory  LEFT JOIN product_content as PC on PC.idProductContent=PD.idProductContent  LEFT JOIN product_status as PS on PS.idProductStatus=PD.idProductStatus  LEFT JOIN primary_packaging as PP on PP.idPrimaryPackaging=PD.idPrimaryPackaging LEFT JOIN secondary_packaging as SP on SP.idSecondaryPackaging=PD.idSecondaryPackaging LEFT JOIN  territorytitle_master as TT on TT.idTerritoryTitle=PD.idTerritoryTitle LEFT JOIN hsn_details as hsn ON hsn.idHsncode=PD.idHsncode WHERE  PD.idProduct='$productid' GROUP BY PD.idProduct";
			    $result=$this->adapter->query($qry,array());
			    $resultset=$result->toArray();

			     // print_r($resultset); exit;
                  //checked territory data
                $qryterrirory="SELECT territoryValue,idTerritory,idTerritoryTitle FROM `territory_master` WHERE idTerritory IN(SELECT idTerritory FROM `product_territory_details` WHERE idProduct='$productid')";
			    $resultterritory=$this->adapter->query($qryterrirory,array());
			    $resultsetterritory=$resultterritory->toArray();

                for($i=0;$i<count($resultsetterritory);$i++)
                {
                	$territarydata[]=implode(",", $resultsetterritory[$i]);
                	$checkedterritoryid[]=$resultsetterritory[$i]['idTerritory'];
                }
                $dtt=implode(",", $territarydata);
                //all territory data
                $qry_allterrirory="SELECT territoryValue,idTerritory,idTerritoryTitle FROM `territory_master` WHERE idTerritoryTitle='".$resultset[0]['idTerritoryTitle']."'";
			    $result_allterritory=$this->adapter->query($qry_allterrirory,array());
			    $resultset_allterritory=$result_allterritory->toArray();
			    // get array to all territory with checked status false
			      for($i=0;$i<count($resultsetterritory);$i++) 
			    {
			      for($j=0;$j<count($resultset_allterritory);$j++) 
			       {
                       $territorystatus[$j]['territoryValue']=$resultset_allterritory[$j]['territoryValue'];
			    		$territorystatus[$j]['idTerritory']=$resultset_allterritory[$j]['idTerritory'];
			    		$territorystatus[$j]['idTerritoryTitle']=$resultset_allterritory[$j]['idTerritoryTitle'];
			    	    $territorystatus[$j]['checked']=false;
			    	    $idsterritory[$j]['idTerritory']=$resultset_allterritory[$j]['idTerritory'];
			       }
			   }

			   
			      // change the checked status if checked true
			     for($i=0;$i<count($resultsetterritory);$i++) 
			    {
			    	   
			       for($j=0;$j<count($territorystatus);$j++) 
			       {

			       	
			    	 if($resultsetterritory[$i]['idTerritory']==$territorystatus[$j]['idTerritory']) 
			    	{
			    		
			    	    $territorystatus[$j]['checked']=true;
                      
			    	} 
			    	
			    	
			      }
			   }
			   $qrysize="SELECT T1.idProductsize,T1.Productsize as psize,T2.idPrimaryPackaging as primarypackage,T2.primarypackname,T3.idSecondaryPackaging as secondarypackage,T3.secondarypackname,T1.productPrimaryCount as primarycount,T1.productSecondaryCount as secondarycount,T1.idProduct,T1.productImageLeft as imageleft,T1.productImageRight as imageright,T1.productImageTop as imagetop,T1.productImageBottom as imagebottom,T1.productImageLeftSide as imagesideleft,T1.productImageRightSide as imagesideright
			   			FROM `product_size` as T1 
						LEFT JOIN primary_packaging as T2 ON T1.idPrimaryPackaging=T2.idPrimaryPackaging
						LEFT JOIN secondary_packaging as T3 ON T1.idSecondaryPackaging=T3.idSecondaryPackaging WHERE idProduct='$productid'";
			     $resultsize=$this->adapter->query($qrysize,array());
			    $resultsetsize=$resultsize->toArray();
                
				for($i=0;$i<count($resultsetsize);$i++)
				{
					$products_size[$i]['psize']=$resultsetsize[$i]['psize'];
					$products_size[$i]['primarypackage']=$resultsetsize[$i]['primarypackage'];
					$products_size[$i]['secondarypackage']=$resultsetsize[$i]['secondarypackage'];
					$products_size[$i]['primarycount']=$resultsetsize[$i]['primarycount'];
					$products_size[$i]['secondarycount']=$resultsetsize[$i]['secondarycount'];
					$products_size[$i]['imageleft']=$resultsetsize[$i]['imageleft'];
					$products_size[$i]['imageright']=$resultsetsize[$i]['imageright'];
					$products_size[$i]['imagetop']=$resultsetsize[$i]['imagetop'];
					$products_size[$i]['imagebottom']=$resultsetsize[$i]['imagebottom'];
					$products_size[$i]['imagesideleft']=$resultsetsize[$i]['imagesideleft'];
					$products_size[$i]['imagesideright']=$resultsetsize[$i]['imagesideright'];
					$products_size[$i]['idProductsize']=$resultsetsize[$i]['idProductsize'];
				}
                 //   print_r($products_size);
                 // exit;

			    if(!$resultset) 
			    {
				  $ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			    } 
			    else 
			    {
				$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'contentsize' =>$resultsetsize,'contentterritory' =>$dtt,'contentterritoryid'=>$resultsetterritory,'allteritory'=>$territorystatus,'checkedid'=>$checkedterritoryid,'productsizeformgroup'=>$products_size,'idcheckterritory'=>$idsterritory,'message'=>'data available'];
				
			    }
           }
            else if($param->action=="removeimage")
            {
            	//print_r($param); exit;
                  $editid=$param->productid;
		          $userid=$param->userid;
		          // it is image type like leftimage,right image,topimage,bottomimage,sideleftimage,siderightimage
		          $imgtype=$param->imgtype; 
		          $imgnm=$param->imgnm; // name of the image

		          $this->adapter->getDriver()->getConnection()->beginTransaction();
		          try {
		          	     if($imgtype=="leftimage")
		          	     	{ $datainsert['productImageLeft']=''; unlink('public/uploads/product/'.$imgnm); }
		          	     else if($imgtype=="rightimage")
		          	     	{ $datainsert['productImageRight']=''; unlink('public/uploads/product/'.$imgnm); }
		          	     else if($imgtype=="topimage")
		          	     	{ $datainsert['productImageTop']=''; unlink('public/uploads/product/'.$imgnm); }
		          	     else if($imgtype=="bottomimage")
		          	     	{ $datainsert['productImageBottom']=''; unlink('public/uploads/product/'.$imgnm);}
		          	     else if($imgtype=="sideleftimage")
		          	     	{ $datainsert['productImageLeftSide']=''; unlink('public/uploads/product/'.$imgnm); }
		          	     else if($imgtype=="siderightimage")
		          	     	{ $datainsert['productImageRightSide']='';  unlink('public/uploads/product/'.$imgnm);}
		            	// $datainsert['photo']='';
			            $datainsert['updated_by']=$userid;
			            $datainsert['updated_at']=date('Y-m-d H:i:s');
			            $sql = new Sql($this->adapter);
			            $update = $sql->update();
			            $update->table('product_details');
			            $update->set($datainsert);
			            $update->where( array('idProduct'=>$editid));
			            $statement  = $sql->prepareStatementForSqlObject($update);
			            $results    = $statement->execute();
			            $ret_arr=['code'=>'2','status'=>true,'message'=>'image removed successfully'];
			            $this->adapter->getDriver()->getConnection()->commit();
		              } catch(\Exception $e) 
		              {
			             $ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			             $this->adapter->getDriver()->getConnection()->rollBack();
		              }
		        
            }
			 else if($param->action=='update') {
			 	//  print_r($param); 
			 	// // print_r($_FILES);

			 	//  exit;
          
			$userid=$param->userid;
			$editid=$param->edit_id;
			$uploads_dir ='public/uploads/product';
			if($_FILES) 
			{


				if($_FILES["imageleft"]["tmp_name"]!="")
				{
					
                  $leftimage_name=$_FILES["imageleft"]["tmp_name"];
                  $leftimage_tempname=$_FILES["imageleft"]["name"];
                  	$leftimageName ='leftimage_'.date('dmyHi').'.'.pathinfo($_FILES["imageleft"]['name'],PATHINFO_EXTENSION);
                  	$leftimageext=strtolower(pathinfo($_FILES["imageleft"]['name'],PATHINFO_EXTENSION));
                  	$leftimagetempname =basename($_FILES["imageleft"]["name"]);

                  	if($leftimageext=='jpeg' || $leftimageext=='png' ||  $leftimageext=='jpg')
				    {
					if(move_uploaded_file($leftimage_name,"$uploads_dir/$leftimageName")==false) 
					{
                      $leftimagestatus=false;
                      $leftimagemsg="image not move to folder";
					}
					else
					{
						 $leftimagestatus=true;
						 $leftimagemsg="success";
					}
				    }
				    else
				    {
				    	 $leftimagestatus=false;
						 $leftimagemsg="image file type invalid.Please select valid format for logo like (PNG,JPG,JPEG)..";
				    }
				}
				else
				    {
				    	 $leftimagestatus=false;
						 $leftimagemsg="image not available";
				    }

				if($_FILES["imageright"]["tmp_name"]!="")
				{
                    $rightimage_name=$_FILES["imageright"]["tmp_name"];
                    $rightimage_tempname=$_FILES["imageright"]["name"];
                  
				   $rightimageName ='rightimage_'.date('dmyHi').'.'.pathinfo($_FILES["imageright"]['name'],PATHINFO_EXTENSION);
                  	$rightimageext=strtolower(pathinfo($_FILES["imageright"]['name'],PATHINFO_EXTENSION));
                  	$rightimagetempname =basename($_FILES["imageright"]["name"]);

                  	if($rightimageext=='jpeg' || $rightimageext=='png' ||  $rightimageext=='jpg')
				    {
					if(move_uploaded_file($rightimage_name,"$uploads_dir/$rightimageName")==false) 
					{
                      $rightimagestatus=false;
                      $rightimagemsg="image not move to folder";
					}
					else
					{
						 $rightimagestatus=true;
						 $rightimagemsg="success";
					}
				    }
				    else
				    {
				    	 $rightimagestatus=false;
						 $rightimagemsg="image file type invalid.Please select valid format for logo like (PNG,JPG,JPEG)..";
				    }
				}
				else
				    {
				    	 $rightimagestatus=false;
						 $rightimagemsg="image not available";
				    }

				  if($_FILES["imagetop"]["tmp_name"]!="")
				{
                   $topimage_name=$_FILES["imagetop"]["tmp_name"];
				   $topimage_tempname=$_FILES["imagetop"]["name"];
			       $topimageName ='topimage_'.date('dmyHi').'.'.pathinfo($_FILES["imagetop"]['name'],PATHINFO_EXTENSION);
                   $topimageext=strtolower(pathinfo($_FILES["imagetop"]['name'],PATHINFO_EXTENSION));
                   $topimagetempname =basename($_FILES["imagetop"]["name"]);


                  	if($topimageext=='jpeg' || $topimageext=='png' ||  $topimageext=='jpg')
				    {
					if(move_uploaded_file($topimage_name,"$uploads_dir/$topimageName")==false) 
					{
                      $topimagestatus=false;
                      $topimagemsg="image not move to folder";
					}
					else
					{
						 $topimagestatus=true;
						 $topimagemsg="success";
					}
				    }
				    else
				    {
				    	 $topimagestatus=false;
						 $topimagemsg="image file type invalid.Please select valid format for logo like (PNG,JPG,JPEG)..";
				    }
				}
				else
				    {
				    	 $topimagestatus=false;
						 $topimagemsg="image not available";
				    }  
				
				 if($_FILES["imagebottom"]["tmp_name"]!="")
				{
                  $buttomimage_name=$_FILES["imagebottom"]["tmp_name"];
				$buttomimage_tempname=$_FILES["imagebottom"]["name"];
                $bottomimageName ='bottomimage_'.date('dmyHi').'.'.pathinfo($_FILES["imagebottom"]['name'],PATHINFO_EXTENSION);
                $bottomimageext=strtolower(pathinfo($_FILES["imagebottom"]['name'],PATHINFO_EXTENSION));
                 $bottomimagetempname =basename($_FILES["imagebottom"]["name"]);

                  	if($bottomimageext=='jpeg' || $bottomimageext=='png' ||  $bottomimageext=='jpg')
				    {
					if(move_uploaded_file($buttomimage_name,"$uploads_dir/$bottomimageName")==false) 
					{
                      $bottomimagestatus=false;
                      $bottomimagemsg="image not move to folder";
					}
					else
					{
						 $bottomimagestatus=true;
						 $bottomimagemsg="success";
					}
				    }
				    else
				    {
				    	 $bottomimagestatus=false;
						 $bottomimagemsg="image file type invalid.Please select valid format for logo like (PNG,JPG,JPEG)..";
				    }
				}
				else
				    {
				    	 $bottomimagestatus=false;
						 $bottomimagemsg="image not available";
				    }
				
				 if($_FILES["imagesideleft"]["tmp_name"]!="")
				{
                   $sideleftimage_name=$_FILES["imagesideleft"]["tmp_name"];
				   $sideleftimage_tempname=$_FILES["imagesideleft"]["name"];
                   $sideleftimageName ='sideleftimage_'.date('dmyHi').'.'.pathinfo($_FILES["imagesideleft"]['name'],PATHINFO_EXTENSION);
                  $sideleftimageext=strtolower(pathinfo($_FILES["imagesideleft"]['name'],PATHINFO_EXTENSION));
				  $sideleftimagetempname =basename($_FILES["imagesideleft"]["name"]);
				

                  	if($sideleftimageext=='jpeg' || $sideleftimageext=='png' ||  $sideleftimageext=='jpg')
				    {
					if(move_uploaded_file($sideleftimage_name,"$uploads_dir/$sideleftimageName")==false) 
					{
                      $sideleftimagestatus=false;
                      $sideleftimagemsg="image not move to folder";
					}
					else
					{
						 $sideleftimagestatus=true;
						 $sideleftimagemsg="success";
					}
				    }
				    else
				    {
				    	 $sideleftimagestatus=false;
						 $sideleftimagemsg="image file type invalid.Please select valid format for logo like (PNG,JPG,JPEG)..";
				    }
				}
				else
				    {
				    	 $sideleftimagestatus=false;
						 $sideleftimagemsg="image not available";
				    } 

				 if($_FILES["imagesideright"]["tmp_name"]!="")
				{
                 
				$siderightimage_name=$_FILES["imagesideright"]["tmp_name"];
                $siderightimage_tempname=$_FILES["imagesideright"]["name"];
                $siderightimageName ='siderightimage_'.date('dmyHi').'.'.pathinfo($_FILES["imagesideright"]['name'],PATHINFO_EXTENSION);
                $siderightimageext=strtolower(pathinfo($_FILES["imagesideright"]['name'],PATHINFO_EXTENSION));
				$siderightimagetempname =basename($_FILES["imagesideright"]["name"]);

                  	if($siderightimageext=='jpeg' || $siderightimageext=='png' ||  $siderightimageext=='jpg')
				    {
					if(move_uploaded_file($siderightimage_name,"$uploads_dir/$siderightimageName")==false) 
					{
                      $siderightimagestatus=false;
                      $siderightimagemsg="image not move to folder";
					}
					else
					{
						 $siderightimagestatus=true;
						 $siderightimagemsg="success";
					}
				    }
				    else
				    {
				    	 $siderightimagestatus=false;
						 $siderightimagemsg="image file type invalid.Please select valid format for logo like (PNG,JPG,JPEG)..";
				    }
				}
				else
				    {
				    	 $siderightimagestatus=false;
						 $siderightimagemsg="image not available";
				    }

				
                  if($siderightimagestatus==false && $sideleftimagestatus && $bottomimagestatus==false && $topimagestatus==false && $rightimagestatus==false && $leftimagestatus==false)
                  {
                  	  $ret_arr=['code'=>'3','status'=>false,'message'=>'Please try again.. Failed to upload images..'];
						$rollBack=true;
                  }
                  // else
                  // {
                  // 	  $datainsert['productImageLeft']=trim($leftimageName);
                  // 	  $datainsert['productImageRight']=trim($rightimageName);
                  // 	  $datainsert['productImageTop']=trim($topimageName);
                  // 	  $datainsert['productImageBottom']=trim($bottomimageName);
                  // 	  $datainsert['productImageLeftSide']=trim($sideleftimageName);
                  // 	  $datainsert['productImageRightSide']=trim($siderightimageName);
                  // }

                   if($leftimagestatus==true)
                   {
                     $datainsert['productImageLeft']=trim($leftimageName);
                   }
                   if($rightimagestatus==true)
                   {
                   	 $datainsert['productImageRight']=trim($rightimageName);
                   }
                   if($topimagestatus==true)
                   {
                   	 $datainsert['productImageTop']=trim($topimageName);
                   }
                   if($bottomimagestatus==true)
                   {
                   	 $datainsert['productImageBottom']=trim($bottomimageName);
                   }
                   if($sideleftimagestatus==true)
                   {
                   	 $datainsert['productImageLeftSide']=trim($sideleftimageName);
                   }
                   if($siderightimagestatus==true)
                   {
                   	 $datainsert['productImageRightSide']=trim($siderightimageName);                   	
                   }
				

				
			} // file if close	

			
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['productCode']=$param->pcode;
					$datainsert['productName']=$param->pname;
					$datainsert['productSubName']=$param->spname;
					$datainsert['idCategory']=$param->category;
					$datainsert['idSubCategory']=$param->subcategory;
					$datainsert['productVariant1']=$param->variantone;
					$datainsert['productVariant2']=$param->varianttwo;
					$datainsert['productBrand']=$param->brand;
					$datainsert['productShelflife']=$param->selflife;
					$datainsert['productShelf']=$param->selflifecount;
					$datainsert['productReturn']=$param->policy;
					if($param->policy==1)
					{
                       $datainsert['productReturnDays']=$param->returndays;
					}else
					{
						$datainsert['productReturnDays']=0;
					}
					
					$datainsert['productReturnOption']=$param->returnoption;
					$datainsert['idProductContent']=$param->productcontent;
					$datainsert['idProductStatus']=$param->productstatus;
					$datainsert['idPrimaryPackaging']=$param->primarypackage;
					$datainsert['idSecondaryPackaging']=$param->secondarypackage;
					$datainsert['productUnit']=$param->baseunit;
					$datainsert['productCount']=$param->unitcount;
					$datainsert['productSize']=$param->psize;
					$datainsert['productPrimaryCount']=$param->primarycount;
					$datainsert['productSecondaryCount']=$param->secondarycount;
					$datainsert['idTerritoryTitle']=$param->territory;					
					$datainsert['status']=$param->status;
					$datainsert['updated_by']=$userid;
					$datainsert['updated_at']=date('Y-m-d H:i:s');

					$sql = new Sql($this->adapter);
					$update = $sql->update();
					$update->table('product_details');
					$update->set($datainsert);
					$update->where(array('idProduct'=>$editid));
					$statement  = $sql->prepareStatementForSqlObject($update);
					$results    = $statement->execute();



					 $delete = new Delete('product_territory_details');
                     $delete->where(['idProduct=?' => $editid]);
                     $statement=$this->adapter->createStatement();
                     $delete->prepareStatement($this->adapter, $statement);
                     $resultset=$statement->execute();
                     
                     $territoryinserts['idProduct']=$editid;
                     $subterritorys=explode(",",$param->subterritory);
                    $insertteri=new Insert('product_territory_details');
					for($i=0;$i<count($subterritorys);$i++)
					{
                       $territoryinserts['idTerritory']=$subterritorys[$i];
                       $insertteri->values($territoryinserts);
					$statementteri=$this->adapter->createStatement();
					$insertteri->prepareStatement($this->adapter, $statementteri);
					$insertresultteri=$statementteri->execute();
					}

					$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				} catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			}
			return $ret_arr;
	}
    
    public function removeMultiImage($param)
    {
    	//print_r($param); exit;

    	 if($param->action=="removeimage")
            {
            	//print_r($param); exit;
                  $editid=$param->productsizeid;
		          $userid=$param->userid;
		          // it is image type like leftimage,right image,topimage,bottomimage,sideleftimage,siderightimage
		          $imgtype=$param->imgtype; 
		          $imgnm=$param->imgnm; // name of the image

		          $this->adapter->getDriver()->getConnection()->beginTransaction();
		          try {
		          	     if($imgtype=="leftimage")
		          	     	{ $datainsert['productImageLeft']=''; unlink('public/uploads/product/'.$imgnm); }
		          	     else if($imgtype=="rightimage")
		          	     	{ $datainsert['productImageRight']=''; unlink('public/uploads/product/'.$imgnm); }
		          	     else if($imgtype=="topimage")
		          	     	{ $datainsert['productImageTop']=''; unlink('public/uploads/product/'.$imgnm); }
		          	     else if($imgtype=="bottomimage")
		          	     	{ $datainsert['productImageBottom']=''; unlink('public/uploads/product/'.$imgnm);}
		          	     else if($imgtype=="sideleftimage")
		          	     	{ $datainsert['productImageLeftSide']=''; unlink('public/uploads/product/'.$imgnm); }
		          	     else if($imgtype=="siderightimage")
		          	     	{ $datainsert['productImageRightSide']='';  unlink('public/uploads/product/'.$imgnm);}
		            	// $datainsert['photo']='';
			            $datainsert['updated_by']=$userid;
			            $datainsert['updated_at']=date('Y-m-d H:i:s');
			          //  print_r($datainsert);exit;
			            $sql = new Sql($this->adapter);
			            $update = $sql->update();
			            $update->table('product_size');
			            $update->set($datainsert);
			            $update->where( array('idProductsize'=>$editid));
			            $statement  = $sql->prepareStatementForSqlObject($update);
			            $results    = $statement->execute();
			            $ret_arr=['code'=>'2','status'=>true,'message'=>'image removed successfully'];
			            $this->adapter->getDriver()->getConnection()->commit();
		              } catch(\Exception $e) 
		              {
			             $ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			             $this->adapter->getDriver()->getConnection()->rollBack();
		              }
		        
            }
            return $ret_arr;
    }

	public function product($param)
	{
		
     // print_r($param->imageleft); 
		$uploads_dir ='public/uploads/product';
      if($_FILES)
      	{ 
      		
      		if($_FILES['imageleft'])
      		{
      		   //echo count($_FILES['imageleft']['name']);
      		   for($i=0;$i<count($_FILES['imageleft']['name']);$i++)
      		   {
      		   	 $leftimage_name=$_FILES["imageleft"]["tmp_name"][$i];
                 $leftimage_tempname=$_FILES["imageleft"]["name"][$i];
                 $leftimageName ='leftimage_'.$i.'_'.date('dmyHi').'.'.pathinfo($_FILES["imageleft"]['name'][$i],PATHINFO_EXTENSION);
             
                 $leftimgArray[]=$leftimageName;
                $leftimageext=strtolower(pathinfo($_FILES["imageleft"]['name'][$i],PATHINFO_EXTENSION));
				$leftimagetempname =basename($_FILES["imageleft"]["name"][$i]);

                  	if($leftimageext=='jpeg' || $leftimageext=='png' ||  $leftimageext=='jpg')
				    {
					if(move_uploaded_file($leftimage_name,"$uploads_dir/$leftimageName")==false) 
					{
                      $leftimagestatus[]=false;
                      $leftimagemsg[]="image not move to folder";
					}
					else
					{
						 $leftimagestatus[]=true;
						 $leftimagemsg[]="success";
					}
				    }
                 
      		   }	
      		}
             //rightimage move to folder
      		if($_FILES['imageright'])
      		{
      		   //echo count($_FILES['imageleft']['name']);
      		   for($i=0;$i<count($_FILES['imageright']['name']);$i++)
      		   {
      		   	 $rightimage_name=$_FILES["imageright"]["tmp_name"][$i];
                 $rightimage_tempname=$_FILES["imageright"]["name"][$i];
                 $rightimageName ='rightimage_'.$i.'_'.date('dmyHi').'.'.pathinfo($_FILES["imageright"]['name'][$i],PATHINFO_EXTENSION);
                
                 $rightimgArray[]=$rightimageName;
                $rightimageext=strtolower(pathinfo($_FILES["imageright"]['name'][$i],PATHINFO_EXTENSION));
				$rightimagetempname =basename($_FILES["imageright"]["name"][$i]);

                  	if($rightimageext=='jpeg' || $rightimageext=='png' ||  $rightimageext=='jpg')
				    {
					if(move_uploaded_file($rightimage_name,"$uploads_dir/$rightimageName")==false) 
					{
                      $rightimagestatus[]=false;
                      $rightimagemsg[]="image not move to folder";
					}
					else
					{
						 $rightimagestatus[]=true;
						 $rightimagemsg[]="success";
					}
				    }
                 
      		   }	
      		}
             // top image move to server folder
      		if($_FILES['imagetop'])
      		{
      		   //echo count($_FILES['imageleft']['name']);
      		   for($i=0;$i<count($_FILES['imagetop']['name']);$i++)
      		   {
      		   	 $topimage_name=$_FILES["imagetop"]["tmp_name"][$i];
                 $topimage_tempname=$_FILES["imagetop"]["name"][$i];
                 $topimageName ='topimage_'.$i.'_'.date('dmyHi').'.'.pathinfo($_FILES["imagetop"]['name'][$i],PATHINFO_EXTENSION);
                 
                 $topimgArray[]=$topimageName;
                $topimageext=strtolower(pathinfo($_FILES["imagetop"]['name'][$i],PATHINFO_EXTENSION));
				$topimagetempname =basename($_FILES["imagetop"]["name"][$i]);

                  	if($topimageext=='jpeg' || $topimageext=='png' ||  $topimageext=='jpg')
				    {
					if(move_uploaded_file($topimage_name,"$uploads_dir/$topimageName")==false) 
					{
                      $topimagestatus[]=false;
                      $topimagemsg[]="image not move to folder";
					}
					else
					{
						 $topimagestatus[]=true;
						 $topimagemsg[]="success";
					}
				    }
                 
      		   }	
      		}

      		if($_FILES['imagebottom'])
      		{
      		   
      		   for($i=0;$i<count($_FILES['imagebottom']['name']);$i++)
      		   {
      		   	 $bottomimage_name=$_FILES["imagebottom"]["tmp_name"][$i];
                 $bottomimage_tempname=$_FILES["imagebottom"]["name"][$i];
                 $bottomimageName ='bottomimage_'.$i.'_'.date('dmyHi').'.'.pathinfo($_FILES["imagebottom"]['name'][$i],PATHINFO_EXTENSION);
                
                 $bottomimgArray[]=$bottomimageName;
                $bottomimageext=strtolower(pathinfo($_FILES["imagebottom"]['name'][$i],PATHINFO_EXTENSION));
				$bottomimagetempname =basename($_FILES["imagebottom"]["name"][$i]);

                  	if($bottomimageext=='jpeg' || $bottomimageext=='png' ||  $bottomimageext=='jpg')
				    {
					if(move_uploaded_file($bottomimage_name,"$uploads_dir/$bottomimageName")==false) 
					{
                      $bottomimagestatus[]=false;
                      $bottomimagemsg[]="image not move to folder";
					}
					else
					{
						 $bottomimagestatus[]=true;
						 $bottomimagemsg[]="success";
					}
				    }
                 
      		   }	
      		}


      		if($_FILES['imagesideleft'])
      		{
      		   
      		   for($i=0;$i<count($_FILES['imagesideleft']['name']);$i++)
      		   {
      		   	 $sideleftimage_name=$_FILES["imagesideleft"]["tmp_name"][$i];
                 $sideleftimage_tempname=$_FILES["imagesideleft"]["name"][$i];
                 $sideleftimageName ='sideleftimage_'.$i.'_'.date('dmyHi').'.'.pathinfo($_FILES["imagesideleft"]['name'][$i],PATHINFO_EXTENSION);
                
                 $sideleftimgArray[]=$sideleftimageName;
                $sideleftimageext=strtolower(pathinfo($_FILES["imagesideleft"]['name'][$i],PATHINFO_EXTENSION));
				$sideleftimagetempname =basename($_FILES["imagesideleft"]["name"][$i]);

                  	if($sideleftimageext=='jpeg' || $sideleftimageext=='png' ||  $sideleftimageext=='jpg')
				    {
					if(move_uploaded_file($sideleftimage_name,"$uploads_dir/$sideleftimageName")==false) 
					{
                      $sideleftimagestatus[]=false;
                      $sideleftagemsg[]="image not move to folder";
					}
					else
					{
						 $sideleftimagestatus[]=true;
						 $sideleftimagemsg[]="success";
					}
				    }
                 
      		   }	
      		}


      		if($_FILES['imagesideright'])
      		{
      		   
      		   for($i=0;$i<count($_FILES['imagesideright']['name']);$i++)
      		   {
      		   	 $siderightimage_name=$_FILES["imagesideright"]["tmp_name"][$i];
                 $siderightimage_tempname=$_FILES["imagesideright"]["name"][$i];
                 $siderightimageName ='siderightimage_'.$i.'_'.date('dmyHi').'.'.pathinfo($_FILES["imagesideright"]['name'][$i],PATHINFO_EXTENSION);
                
                 $siderightimgArray[]=$siderightimageName;
                $siderightimageext=strtolower(pathinfo($_FILES["imagesideright"]['name'][$i],PATHINFO_EXTENSION));
				$siderightimagetempname =basename($_FILES["imagesideright"]["name"][$i]);

                  	if($siderightimageext=='jpeg' || $siderightimageext=='png' ||  $siderightimageext=='jpg')
				    {
					if(move_uploaded_file($siderightimage_name,"$uploads_dir/$siderightimageName")==false) 
					{
                      $siderightimagestatus[]=false;
                      $siderightagemsg[]="image not move to folder";
					}
					else
					{
						 $siderightimagestatus[]=true;
						 $siderightimagemsg[]="success";
					}
				    }
                 
      		   }	
      		}

      		// row numbers of images
             $b=$param->lirow;
             $c=$param->rirow;
             $d=$param->tirow;
              $f=$param->birow;
              $g=$param->slirow;
              $h=$param->srirow;
              //final images data
             for($i=0;$i<count($b);$i++)
             {
             	$li[$b[$i]]=$leftimgArray[$i];
             }

              for($i=0;$i<count($c);$i++)
             {
             	$ri[$c[$i]]=$rightimgArray[$i];
             }

              for($i=0;$i<count($d);$i++)
             {
             	$ti[$d[$i]]=$topimgArray[$i];
             }

              for($i=0;$i<count($f);$i++)
             {
             	$bi[$f[$i]]=$bottomimgArray[$i];
             }

              for($i=0;$i<count($g);$i++)
             {
             	$sli[$g[$i]]=$sideleftimgArray[$i];
             }

              for($i=0;$i<count($h);$i++)
             {
             	$sri[$h[$i]]=$siderightimgArray[$i];
             }

      	} // file if close


      if($param->action=="add")
      {
      	     $pcode=$param->pcode;
      	     $pname=$param->pname;
        	$qry="SELECT * FROM product_details a where a.productName=? OR a.productCode=?";
			$result=$this->adapter->query($qry,array($pname,$pcode));
			$resultset=$result->toArray();
			if($resultset) {
				 $ret_arr=['code'=>'3','status'=>false,'message'=>'Product name or product code already Exists'];
			}
			

			$userid=$param->userid;
           
		
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['productCode']=$param->pcode;
					$datainsert['productName']=$param->pname;
					// $datainsert['productSubName']=$param->spname;
					$datainsert['idCategory']=$param->category;
					$datainsert['idSubCategory']=$param->subcategory;
					// $datainsert['productVariant1']=$param->variantone;
					// $datainsert['productVariant2']=$param->varianttwo;
					$datainsert['productBrand']=$param->brand;
					$datainsert['idHsncode']=$param->phsn;
					$datainsert['productShelflife']=$param->selflife;
					$datainsert['productShelf']=$param->selflifecount;
					$datainsert['productReturn']=$param->policy;
					$datainsert['productReturnDays']=$param->returndays;
					$datainsert['productReturnOption']=$param->returnoption;
					$datainsert['idProductContent']=$param->productcontent;
					$datainsert['idProductStatus']=$param->productstatus;					
					$datainsert['productUnit']=$param->baseunit;
					$datainsert['productCount']=$param->unitcount;								
					$datainsert['idTerritoryTitle']=$param->territory;					
					$datainsert['status']=$param->status;
					$datainsert['created_by']=$param->userid;
					$datainsert['created_at']=date('Y-m-d H:i:s');
					$datainsert['updated_by']=$param->userid;
					$datainsert['updated_at']=date('Y-m-d H:i:s');

					$insert=new Insert('product_details');
					$insert->values($datainsert);
					$statement=$this->adapter->createStatement();
					$insert->prepareStatement($this->adapter, $statement);
					$insertresult=$statement->execute();
					$productid=$this->adapter->getDriver()->getLastGeneratedValue();
					$territoryinsert['idProduct']=$productid;
					$subterritory=explode(",",$param->subterritory);
					
					$insertt=new Insert('product_territory_details');
					for($i=0;$i<count($subterritory);$i++)
					{
                       $territoryinsert['idTerritory']=$subterritory[$i];
                       $insertt->values($territoryinsert);
					$statementt=$this->adapter->createStatement();
					$insertt->prepareStatement($this->adapter, $statementt);
					$insertresultt=$statementt->execute();
					}
                      //product size data
                     $primerypackage=($param->primarypackage)?explode(',', $param->primarypackage):'';
                     $secondarypackage=($param->secondarypackage)?explode(',', $param->secondarypackage):'';
                     $primarycount=($param->primarycount)?explode(',', $param->primarycount):'';
                     $secondarycount=($param->secondarycount)?explode(',', $param->secondarycount):'';
                     $product_size=($param->psize)?explode(',', $param->psize):'';
                     // insert product size data to the product_size table
					
					if(count($product_size)>0)
					{
						$insertproductsize=new Insert('product_size');
						$product_sizeinsert['idProduct']=$productid;
					  for($i=0;$i<count($product_size);$i++)
					{
                       $product_sizeinsert['productSize']=($product_size[$i])?$product_size[$i]:0;
                       $product_sizeinsert['idPrimaryPackaging']=($primerypackage[$i])?$primerypackage[$i]:0;
                       $product_sizeinsert['idSecondaryPackaging']=($secondarypackage[$i])?$secondarypackage[$i]:0;
                       $product_sizeinsert['productPrimaryCount']=($primarycount[$i])?$primarycount[$i]:0;
                       $product_sizeinsert['productSecondaryCount']=($secondarycount[$i])?$secondarycount[$i]:0;
                       $product_sizeinsert['productImageLeft']=($li[$i])?$li[$i]:'';
                       $product_sizeinsert['productImageRight']=($ri[$i])?$ri[$i]:'';
                       $product_sizeinsert['productImageTop']=($ti[$i])?$ti[$i]:'';
                       $product_sizeinsert['productImageBottom']=($bi[$i])?$bi[$i]:'';
                       $product_sizeinsert['productImageLeftSide']=($sli[$i])?$sli[$i]:'';
                       $product_sizeinsert['productImageRightSide']=($sri[$i])?$sri[$i]:'';
                       $product_sizeinsert['created_by']=$param->userid;
					   $product_sizeinsert['created_at']=date('Y-m-d H:i:s');
					   $product_sizeinsert['updated_by']=$param->userid;
					   $product_sizeinsert['updated_at']=date('Y-m-d H:i:s');
                      
                       $insertproductsize->values($product_sizeinsert);
					   $statementproductsize=$this->adapter->createStatement();
					   $insertproductsize->prepareStatement($this->adapter, $statementproductsize);
					   $insertresultproductsize=$statementproductsize->execute();
					}	
				   }
					
                     
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				} catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}


      }
      return $ret_arr;
	} // product function close

    // product update function
	public function productUpdate($param)
	{
     
            $userid=$param->userid;
			$editid=$param->edit_id;
			$uploads_dir ='public/uploads/product';
			//get product images from file and move to the server
			if($_FILES)
      	   { 
      		
      		if($_FILES['imageleft'])
      		{
      		   //echo count($_FILES['imageleft']['name']);
      		   for($i=0;$i<count($_FILES['imageleft']['name']);$i++)
      		   {
      		   	 $leftimage_name=$_FILES["imageleft"]["tmp_name"][$i];
                 $leftimage_tempname=$_FILES["imageleft"]["name"][$i];
                 $leftimageName ='leftimage_'.$i.'_'.date('dmyHi').'.'.pathinfo($_FILES["imageleft"]['name'][$i],PATHINFO_EXTENSION);
             
                 $leftimgArray[]=$leftimageName;
                $leftimageext=strtolower(pathinfo($_FILES["imageleft"]['name'][$i],PATHINFO_EXTENSION));
				$leftimagetempname =basename($_FILES["imageleft"]["name"][$i]);

                  	if($leftimageext=='jpeg' || $leftimageext=='png' ||  $leftimageext=='jpg')
				    {
					if(move_uploaded_file($leftimage_name,"$uploads_dir/$leftimageName")==false) 
					{
                      $leftimagestatus[]=false;
                      $leftimagemsg[]="image not move to folder";
					}
					else
					{
						 $leftimagestatus[]=true;
						 $leftimagemsg[]="success";
					}
				    }
                 
      		   }	
      		}
             //rightimage move to folder
      		if($_FILES['imageright'])
      		{
      		   //echo count($_FILES['imageleft']['name']);
      		   for($i=0;$i<count($_FILES['imageright']['name']);$i++)
      		   {
      		   	 $rightimage_name=$_FILES["imageright"]["tmp_name"][$i];
                 $rightimage_tempname=$_FILES["imageright"]["name"][$i];
                 $rightimageName ='rightimage_'.$i.'_'.date('dmyHi').'.'.pathinfo($_FILES["imageright"]['name'][$i],PATHINFO_EXTENSION);
                
                 $rightimgArray[]=$rightimageName;
                $rightimageext=strtolower(pathinfo($_FILES["imageright"]['name'][$i],PATHINFO_EXTENSION));
				$rightimagetempname =basename($_FILES["imageright"]["name"][$i]);

                  	if($rightimageext=='jpeg' || $rightimageext=='png' ||  $rightimageext=='jpg')
				    {
					if(move_uploaded_file($rightimage_name,"$uploads_dir/$rightimageName")==false) 
					{
                      $rightimagestatus[]=false;
                      $rightimagemsg[]="image not move to folder";
					}
					else
					{
						 $rightimagestatus[]=true;
						 $rightimagemsg[]="success";
					}
				    }
                 
      		   }	
      		}
             // top image move to server folder
      		if($_FILES['imagetop'])
      		{
      		   //echo count($_FILES['imageleft']['name']);
      		   for($i=0;$i<count($_FILES['imagetop']['name']);$i++)
      		   {
      		   	 $topimage_name=$_FILES["imagetop"]["tmp_name"][$i];
                 $topimage_tempname=$_FILES["imagetop"]["name"][$i];
                 $topimageName ='topimage_'.$i.'_'.date('dmyHi').'.'.pathinfo($_FILES["imagetop"]['name'][$i],PATHINFO_EXTENSION);
                 
                 $topimgArray[]=$topimageName;
                $topimageext=strtolower(pathinfo($_FILES["imagetop"]['name'][$i],PATHINFO_EXTENSION));
				$topimagetempname =basename($_FILES["imagetop"]["name"][$i]);

                  	if($topimageext=='jpeg' || $topimageext=='png' ||  $topimageext=='jpg')
				    {
					if(move_uploaded_file($topimage_name,"$uploads_dir/$topimageName")==false) 
					{
                      $topimagestatus[]=false;
                      $topimagemsg[]="image not move to folder";
					}
					else
					{
						 $topimagestatus[]=true;
						 $topimagemsg[]="success";
					}
				    }
                 
      		   }	
      		}

      		if($_FILES['imagebottom'])
      		{
      		   
      		   for($i=0;$i<count($_FILES['imagebottom']['name']);$i++)
      		   {
      		   	 $bottomimage_name=$_FILES["imagebottom"]["tmp_name"][$i];
                 $bottomimage_tempname=$_FILES["imagebottom"]["name"][$i];
                 $bottomimageName ='bottomimage_'.$i.'_'.date('dmyHi').'.'.pathinfo($_FILES["imagebottom"]['name'][$i],PATHINFO_EXTENSION);
                
                 $bottomimgArray[]=$bottomimageName;
                $bottomimageext=strtolower(pathinfo($_FILES["imagebottom"]['name'][$i],PATHINFO_EXTENSION));
				$bottomimagetempname =basename($_FILES["imagebottom"]["name"][$i]);

                  	if($bottomimageext=='jpeg' || $bottomimageext=='png' ||  $bottomimageext=='jpg')
				    {
					if(move_uploaded_file($bottomimage_name,"$uploads_dir/$bottomimageName")==false) 
					{
                      $bottomimagestatus[]=false;
                      $bottomimagemsg[]="image not move to folder";
					}
					else
					{
						 $bottomimagestatus[]=true;
						 $bottomimagemsg[]="success";
					}
				    }
                 
      		   }	
      		}


      		if($_FILES['imagesideleft'])
      		{
      		   
      		   for($i=0;$i<count($_FILES['imagesideleft']['name']);$i++)
      		   {
      		   	 $sideleftimage_name=$_FILES["imagesideleft"]["tmp_name"][$i];
                 $sideleftimage_tempname=$_FILES["imagesideleft"]["name"][$i];
                 $sideleftimageName ='sideleftimage_'.$i.'_'.date('dmyHi').'.'.pathinfo($_FILES["imagesideleft"]['name'][$i],PATHINFO_EXTENSION);
                
                 $sideleftimgArray[]=$sideleftimageName;
                $sideleftimageext=strtolower(pathinfo($_FILES["imagesideleft"]['name'][$i],PATHINFO_EXTENSION));
				$sideleftimagetempname =basename($_FILES["imagesideleft"]["name"][$i]);

                  	if($sideleftimageext=='jpeg' || $sideleftimageext=='png' ||  $sideleftimageext=='jpg')
				    {
					if(move_uploaded_file($sideleftimage_name,"$uploads_dir/$sideleftimageName")==false) 
					{
                      $sideleftimagestatus[]=false;
                      $sideleftagemsg[]="image not move to folder";
					}
					else
					{
						 $sideleftimagestatus[]=true;
						 $sideleftimagemsg[]="success";
					}
				    }
                 
      		   }	
      		}


      		if($_FILES['imagesideright'])
      		{
      		   
      		   for($i=0;$i<count($_FILES['imagesideright']['name']);$i++)
      		   {
      		   	 $siderightimage_name=$_FILES["imagesideright"]["tmp_name"][$i];
                 $siderightimage_tempname=$_FILES["imagesideright"]["name"][$i];
                 $siderightimageName ='siderightimage_'.$i.'_'.date('dmyHi').'.'.pathinfo($_FILES["imagesideright"]['name'][$i],PATHINFO_EXTENSION);
                
                 $siderightimgArray[]=$siderightimageName;
                $siderightimageext=strtolower(pathinfo($_FILES["imagesideright"]['name'][$i],PATHINFO_EXTENSION));
				$siderightimagetempname =basename($_FILES["imagesideright"]["name"][$i]);

                  	if($siderightimageext=='jpeg' || $siderightimageext=='png' ||  $siderightimageext=='jpg')
				    {
					if(move_uploaded_file($siderightimage_name,"$uploads_dir/$siderightimageName")==false) 
					{
                      $siderightimagestatus[]=false;
                      $siderightagemsg[]="image not move to folder";
					}
					else
					{
						 $siderightimagestatus[]=true;
						 $siderightimagemsg[]="success";
					}
				    }
                 
      		   }	
      		}

      		// row numbers of images
             $b=$param->lirow;
             $c=$param->rirow;
             $d=$param->tirow;
              $f=$param->birow;
              $g=$param->slirow;
              $h=$param->srirow;
              //final images data
             for($i=0;$i<count($b);$i++)
             {
             	$li[$b[$i]]=$leftimgArray[$i];
             }

              for($i=0;$i<count($c);$i++)
             {
             	$ri[$c[$i]]=$rightimgArray[$i];
             }

              for($i=0;$i<count($d);$i++)
             {
             	$ti[$d[$i]]=$topimgArray[$i];
             }

              for($i=0;$i<count($f);$i++)
             {
             	$bi[$f[$i]]=$bottomimgArray[$i];
             }

              for($i=0;$i<count($g);$i++)
             {
             	$sli[$g[$i]]=$sideleftimgArray[$i];
             }

              for($i=0;$i<count($h);$i++)
             {
             	$sri[$h[$i]]=$siderightimgArray[$i];
             }
              

      	} // file if close
    			  // update data get
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['productCode']=$param->pcode;
					$datainsert['productName']=$param->pname;
					$datainsert['idHsncode']=$param->phsn;
					
					$datainsert['idCategory']=$param->category;
					$datainsert['idSubCategory']=$param->subcategory;					
					$datainsert['productBrand']=$param->brand;
					$datainsert['productShelflife']=$param->selflife;
					$datainsert['productShelf']=$param->selflifecount;
					$datainsert['productReturn']=$param->policy;
					if($param->policy==1)
					{
                       $datainsert['productReturnDays']=$param->returndays;
					}else
					{
						$datainsert['productReturnDays']=0;
					}
					
					$datainsert['productReturnOption']=$param->returnoption;
					$datainsert['idProductContent']=$param->productcontent;
					$datainsert['idProductStatus']=$param->productstatus;					
					$datainsert['productUnit']=$param->baseunit;
					$datainsert['productCount']=$param->unitcount;		
					$datainsert['idTerritoryTitle']=$param->territory;					
					$datainsert['status']=$param->status;
					$datainsert['updated_by']=$userid;
					$datainsert['updated_at']=date('Y-m-d H:i:s');
                    //update product data corresponding product id
					$sql = new Sql($this->adapter);
					$update = $sql->update();
					$update->table('product_details');
					$update->set($datainsert);
					$update->where(array('idProduct'=>$editid));
					$statement  = $sql->prepareStatementForSqlObject($update);
					$results    = $statement->execute();


                       // delete old territory data 
					 $delete = new Delete('product_territory_details');
                     $delete->where(['idProduct=?' => $editid]);
                     $statement=$this->adapter->createStatement();
                     $delete->prepareStatement($this->adapter, $statement);
                     $resultset=$statement->execute();
                     
                     $territoryinserts['idProduct']=$editid;
                     $subterritorys=explode(",",$param->subterritory);
                     $insertteri=new Insert('product_territory_details');
					for($i=0;$i<count($subterritorys);$i++)
					{
						$territoryinserts['idTerritory']=$subterritorys[$i];
						$insertteri->values($territoryinserts);
						$statementteri=$this->adapter->createStatement();
						$insertteri->prepareStatement($this->adapter, $statementteri);
						$insertresultteri=$statementteri->execute();
					}
                    
                     // old product size data deleted to corresposnding product id
					 $deleteproduct_size = new Delete('product_size');
                     $deleteproduct_size->where(['idProduct=?' => $editid]);
                     $statementproduct_size=$this->adapter->createStatement();
                     $deleteproduct_size->prepareStatement($this->adapter, $statementproduct_size);
                     $resultsetproduct_size=$statementproduct_size->execute();

					//new product size data
                     $primerypackage=($param->primarypackage)?explode(',', $param->primarypackage):'';
                     $secondarypackage=($param->secondarypackage)?explode(',', $param->secondarypackage):'';
                     $primarycount=($param->primarycount)?explode(',', $param->primarycount):'';
                     $secondarycount=($param->secondarycount)?explode(',', $param->secondarycount):'';
                     $product_size=($param->psize)?explode(',', $param->psize):'';
                     $idproductsize=($param->idProductsize)?explode(',', $param->idProductsize):'';

                     //old product size data
                     $oldprimerypackage=($param->oldprimarypackage)?explode(',', $param->oldprimarypackage):'';
                     $oldsecondarypackage=($param->oldsecondarypackage)?explode(',', $param->oldsecondarypackage):'';
                     $oldprimarycount=($param->oldprimarycount)?explode(',', $param->oldprimarycount):'';
                     $oldsecondarycount=($param->oldsecondarycount)?explode(',', $param->oldsecondarycount):'';
                     $oldproduct_size=($param->oldproductsize)?explode(',', $param->oldproductsize):'';
                     $oldimageleft=($param->oldimageleft)?explode(',', $param->oldimageleft):'';
                     $oldimageright=($param->oldimageright)?explode(',', $param->oldimageright):'';
                     $oldimagetop=($param->oldimagetop)?explode(',', $param->oldimagetop):'';
                     $oldimagebottom=($param->oldimagebottom)?explode(',', $param->oldimagebottom):'';
                     $oldimagesideleft=($param->oldimagesideleft)?explode(',', $param->oldimagesideleft):'';
                     $oldimagesideright=($param->oldimagesideright)?explode(',', $param->oldimagesideright):'';

                     
                     // insert product size data to the product_size table 
						
					if(count($primerypackage)>0)
					{
						$insertproductsize=new Insert('product_size');
						$product_sizeinsert['idProduct']=$param->edit_id;

					  for($i=0;$i<count($primerypackage);$i++)
					{

                         
					   $product_sizeinsert['productSize']=($product_size[$i])?$product_size[$i]:$oldproduct_size[$i];
                       $product_sizeinsert['idPrimaryPackaging']=($primerypackage[$i])?$primerypackage[$i]:$oldprimerypackage[$i];
                       $product_sizeinsert['idSecondaryPackaging']=($secondarypackage[$i])?$secondarypackage[$i]:$oldsecondarypackage[$i];
                       $product_sizeinsert['productPrimaryCount']=($primarycount[$i])?$primarycount[$i]:$oldprimarycount[$i];
                       $product_sizeinsert['productSecondaryCount']=($secondarycount[$i])?$secondarycount[$i]:$oldsecondarycount[$i];
                       $product_sizeinsert['productImageLeft']=($li[$i])?$li[$i]:$oldimageleft[$i];
                       $product_sizeinsert['productImageRight']=($ri[$i])?$ri[$i]:$oldimageright[$i];
                       $product_sizeinsert['productImageTop']=($ti[$i])?$ti[$i]:$oldimagetop[$i];
                       $product_sizeinsert['productImageBottom']=($bi[$i])?$bi[$i]:$oldimagebottom[$i];
                       $product_sizeinsert['productImageLeftSide']=($sli[$i])?$sli[$i]:$oldimagesideleft[$i];
                       $product_sizeinsert['productImageRightSide']=($sri[$i])?$sri[$i]:$oldimagesideright[$i];
                       $product_sizeinsert['created_by']=$param->userid;
					   $product_sizeinsert['created_at']=date('Y-m-d H:i:s');
					   $product_sizeinsert['updated_by']=$param->userid;
					   $product_sizeinsert['updated_at']=date('Y-m-d H:i:s');
						$insertproductsize->values($product_sizeinsert);
						$statementproductsize=$this->adapter->createStatement();
						$insertproductsize->prepareStatement($this->adapter, $statementproductsize);
						$insertresultproductsize=$statementproductsize->execute();
                     
                       
					}	// primerypackage for loop close
				   } // primerypackage if close
					
                       
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				} catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}

				return $ret_arr;
	}
	public function customer_hierarchy($param) {
		if($param->action=="title") {
			$qry="SELECT A.idGeographyTitle as id,
						 A.title,
						 idGeographyTitle as default_status,
						 A.geography as geo_name
						 FROM geographytitle_master A where A.title!=''";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
		if($resultset!=null){
			$fieldNames=array('A_Sales','B_Sales','C_Sales','D_Sales','E_Sales','F_Sales','G_Sales','H_Sales','I_Sales','J_Sales');
			for($j=0;$j<count($resultset);$j++) {
				$resultset[$j]['names']=$fieldNames[$j];
			}
		}
		if(!$resultset) {
			$ret_arr=['code'=>'2','status'=>false,'message'=>'No records found'];
		} else {
			for($i=0;$i<count($resultset);$i++) {
				$title_id=$resultset[$i]['id'];
				$qry_geo="SELECT 
				B.g1,
				A.idGeography as id,
				A.idGeographyTitle,
				A.geoValue,
				A.geoCode,
				A.status
				FROM geographymapping_master as B  
  				LEFT JOIN geography as A ON A.idGeography=B.g1
				where B.g1=? GROUP By B.g1";

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
	public function edit_customer_hierarchy($param) {
		$geography_one=$param->geography_one;
		if($param->action=="title") {
			$qry="SELECT 
						A.idGeographyTitle as id,
						A.title,
						'0' as default_status,
						A.geography as geo_name
						FROM geographytitle_master A where A.title!=''";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		if(!$resultset) {
			$ret_arr=['code'=>'2','status'=>false,'message'=>'No records found'];
		} else {
			for($i=0;$i<count(1);$i++) {
				$title_id=$resultset[$i]['id'];
				$qry_geo="SELECT 
				B.g1,
				A.idGeography as id,
				A.idGeographyTitle,
				A.geoValue,
				A.geoCode,
				A.status
				FROM geographymapping_master B 
				LEFT JOIN geography as A ON A.idGeography=B.g1
				where B.g1=? GROUP By B.g1";

				
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
	public function customer_records($param) {
		if($param->action=="list") {
		$qry="SELECT 
				A.idCustomer as id,
				A.G1 as Country,A.G2 as State,A.G3 as City,A.G4,A.G5,A.G6,A.G6,A.G7,A.G8,A.G9,A.G10,
				A.cs_type as customertype,
				A.cs_mail as email,
				A.cs_dob as date_birth,
				A.cs_tinno as tin_number,
				A.cs_cmsn_type as customer_classify,
				A.cs_long_bsns as years_inbusiness,
				A.cs_creditAmount as credit_amount,
				A.cs_population as population,
				A.cs_potential_value as potential_value,
				A.cs_martialStatus as martialstatus,
				A.cs_status as customer_status,
				A.cs_date_enrollment as date_enrollment,
				A.cs_tindate as tin_validity_date,
				A.customer_code as code,
				A.cs_name as name,
				A.cs_serviceby as serviceby,
				A.cs_mobno as mobileno,
				A.cs_status as status,
				'' as company_name,
				B.idLogin as user_login_id,
				B.idCustomer as customer_id,
				B.idCustomerType as customer_type,
				B.customer_name
				FROM customer A
				LEFT JOIN user_login B ON B.idCustomer=A.idCustomer";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		if(!$resultset) {
			$ret_arr=['code'=>'2','status'=>false,'message'=>'No records found'];
		} else {
			$ret_arr=['code'=>'1','status'=>true,'message'=>'Customer records','content' =>$resultset];
		}
		} else {
			$ret_arr=['code'=>'2','status'=>false,'message'=>'Something wrong please try again'];
		}
		return $ret_arr;
	}
	public function add_customer($param) {
		$fields=$param->records;

		if($param->action=='add') {

			$qryEMPID="SELECT * FROM customer a where  a.customer_code=? ";
			$resultEMPID=$this->adapter->query($qryEMPID,array($fields['code']));
			$resultsetEMPID=$resultEMPID->toArray();

				$qryEmail="SELECT * FROM customer a where  a.cs_mail=? ";
			$resultEmail=$this->adapter->query($qryEmail,array($fields['email']));
			$resultsetEmail=$resultEmail->toArray();

			$qryMobile="SELECT * FROM customer a where a.cs_mobno=?  ";
			$resultMobile=$this->adapter->query($qryMobile,array($fields['mobileno']));
			$resultsetMobile=$resultMobile->toArray();

             if (count($resultsetEMPID)>0) 
             {
             	$ret_arr=['code'=>'1','status'=>false,'message'=>'Customer code already exist'];
             }
            else if (count($resultsetEmail)>0) 
            {
            	$ret_arr=['code'=>'1','status'=>false,'message'=>'Email id already exist'];
            }
            else if(count($resultsetMobile)>0)
            {
              $ret_arr=['code'=>'1','status'=>false,'message'=>'Mobile number already exist'];
            }
            
            else
            {
			$this->adapter->getDriver()->getConnection()->beginTransaction();
					try {
					$datainsert['G1'] = $fields['A_Sales'];
					$datainsert['G2'] = $fields['B_Sales'];
					$datainsert['G3'] = $fields['C_Sales'];
					$datainsert['G4'] = $fields['D_Sales'];
					$datainsert['G5'] = $fields['E_Sales'];
					$datainsert['G6'] = $fields['F_Sales'];
					$datainsert['G7'] = $fields['G_Sales'];
					$datainsert['G8'] = $fields['H_Sales'];
					$datainsert['G9'] = $fields['I_Sales'];
					$datainsert['G10'] = $fields['J_Sales'];
					$datainsert['cs_serviceby'] = $fields['serviceBy'];
					$datainsert['cs_type'] = $fields['customertype'];
					$datainsert['cs_name'] = $fields['name'];
					$datainsert['customer_code'] = $fields['code'];
					$datainsert['cs_mail'] = $fields['email'];
					$datainsert['cs_mobno'] = $fields['mobileno'];
					$datainsert['cs_tinno'] = $fields['tin_number'];
					$datainsert['cs_cmsn_type'] = $fields['customer_classify'];
					$datainsert['cs_long_bsns'] = $fields['years_inbusiness'];
					$datainsert['cs_creditAmount'] = $fields['credit_amount'];
					$datainsert['cs_population'] = $fields['population'];
					$datainsert['idPreferredwarehouse'] = $fields['preferredwarehouse'];
					$datainsert['cs_potential_value'] =$fields['potential_value'];
					$datainsert['cs_martialStatus'] = $fields['martialstatus'];
					$datainsert['cs_payment_type'] = $fields['payment_type'];
					$datainsert['cs_credit_types'] = ($fields['credit_types'])?$fields['credit_types']:0;
					$datainsert['cs_transport_type'] = $fields['transport_reimburse'];
					$datainsert['idStocktransfer'] = ($fields['stock_transfer_rules'])?$fields['stock_transfer_rules']:0;
					$datainsert['part_paymentPercent'] = ($fields['part_advance'])?$fields['part_advance']:0;				
					$datainsert['cs_transport_amt'] = ($fields['transport_reimburse']==2)?$fields['transport_invoice']:0;						
					$datainsert['cs_credit_ratingstatus'] = ($fields['credit_rating_status'])?$fields['credit_rating_status']:0;
					$datainsert['cs_status'] = $fields['customer_status'];
					$datainsert['cs_date_enrollment'] = date('Y-m-d',strtotime($fields['date_enrollment']));
					$datainsert['cs_tindate'] = date('Y-m-d',strtotime($fields['tin_validity_date']));
					$datainsert['cs_dob'] = date('Y-m-d',strtotime($fields['date_birth']));
					$datainsert['cs_segment_type'] = $fields['segment_status'];
					$datainsert['idSalesHierarchy'] = $fields['sales_hry'];
					$datainsert['sales_hrchy_name'] = $fields['employee_id'];
					$datainsert['cs_customer_group'] = $fields['customer_group'];
					$datainsert['cs_raising_rights'] = $fields['raising_rights'];
					$datainsert['cs_stock_payment_type'] = $fields['stockrule_selected'];
					$datainsert['created_by'] = $param->userid;
				//	print_r($datainsert);
					
				$insert = new Insert('customer');
				$insert->values($datainsert);
				$statement = $this->adapter->createStatement();
				$insert->prepareStatement($this->adapter, $statement);
				$insertresult = $statement->execute();
				$customer_id = $this->adapter->getDriver()->getLastGeneratedValue();
				$ret_arr = ['success' => '1','status' =>true, 'message' => 'Added successfully', 'customer_id' => $customer_id];
				$this->adapter->getDriver()->getConnection()->commit();
			} catch (\Exception $e) {
				$ret_arr = ['success' => '3','status' =>false,'message' => 'Please try again Failed!!!'.$e];
				$this->adapter->getDriver()->getConnection()->rollBack();
			}
		}
		} 
		return $ret_arr;
	}
	public function add_user_login($param) {
		if($param->action=='add') {

			$fields=$param->records;
			$bcrypt = new Bcrypt();
			$username=$fields['user_name'];
			$password=$fields['password'];
			$qry="SELECT B.customer_name FROM  user_login B WHERE B.customer_name='$username'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();

			if(!$resultset) {
			
			$createUserinAuth=$this->commonfunctions->createUser($username,$password,2);
			
			if($createUserinAuth->status){
			$this->adapter->getDriver()->getConnection()->beginTransaction();
			try {
				$datainsert['idCustomer'] = $fields['user_id'];
				$datainsert['idCustomerType'] = $fields['user_type'];
				$datainsert['customer_name'] = $fields['user_name'];
				$datainsert['customer_password'] = $bcrypt->create($fields['password']);
				$datainsert['created_by'] = $fields['user_id'];
				//	print_r($datainsert);exit;
				$insert = new Insert('user_login');
				$insert->values($datainsert);
				$statement = $this->adapter->createStatement();
				$insert->prepareStatement($this->adapter, $statement);
				$insertresult = $statement->execute();
				$result = ['success' => '1','status' =>true, 'message' => 'Added successfully','customer_id' => $customer_id];
			$this->adapter->getDriver()->getConnection()->commit();
		} catch (\Exception $e) {
			$result = ['success' => '3','status' =>false,'message' => 'Please try again Failed!!!'.$e];
			$this->adapter->getDriver()->getConnection()->rollBack();
		}
		}
		} else {
			$result = ['success' => '3','status' =>false,'message' => 'User name already exist'];
		}
		} else {
			$result = ['success' => '3','status' =>false,'message' => 'API failed,Please try again'];
		}
		return $result;
	}
	public function customer_update($param) {
		$fields=$param->records;
		$editid=$fields['customer_id'];
		if($param->action=='update') {

			$qryEMPID="SELECT * FROM customer a where  a.customer_code=? AND a.idCustomer!='$editid'";
			$resultEMPID=$this->adapter->query($qryEMPID,array($fields['code']));
			$resultsetEMPID=$resultEMPID->toArray();

				$qryEmail="SELECT * FROM customer a where  a.cs_mail=? AND a.idCustomer!='$editid' ";
			$resultEmail=$this->adapter->query($qryEmail,array($fields['email']));
			$resultsetEmail=$resultEmail->toArray();

			$qryMobile="SELECT * FROM customer a where a.cs_mobno=? AND a.idCustomer!='$editid' ";
			$resultMobile=$this->adapter->query($qryMobile,array($fields['mobileno']));
			$resultsetMobile=$resultMobile->toArray();

             if (count($resultsetEMPID)>0) 
             {
             	$ret_arr=['code'=>'1','status'=>false,'message'=>'Customer code already exist'];
             }
            else if (count($resultsetEmail)>0) 
            {
            	$ret_arr=['code'=>'1','status'=>false,'message'=>'Email id already exist'];
            }
            else if(count($resultsetMobile)>0)
            {
              $ret_arr=['code'=>'1','status'=>false,'message'=>'Mobile number already exist'];
            }
            
            else
            {
			$qry="SELECT A.idGeographyTitle as id,
			A.title,
			idGeographyTitle as default_status,
			A.geography as geo_name
			FROM geographytitle_master A where A.title!=''";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			$this->adapter->getDriver()->getConnection()->beginTransaction();
			try {
				$dataupdate['G1'] = $fields[$resultset[0]['title']];
				$dataupdate['G2'] = $fields[$resultset[1]['title']];
				$dataupdate['G3'] = $fields[$resultset[2]['title']];
				$dataupdate['G4'] = $fields[$resultset[3]['title']];
				$dataupdate['G5'] = $fields[$resultset[4]['title']];
				$dataupdate['G6'] = $fields[$resultset[5]['title']];
				$dataupdate['G7'] = $fields[$resultset[6]['title']];
				$dataupdate['G8'] = $fields[$resultset[7]['title']];
				$dataupdate['G9'] = $fields[$resultset[8]['title']];
				$dataupdate['G10'] = $fields[$resultset[9]['title']];
				$dataupdate['cs_type'] = $fields['customertype'];
				$dataupdate['cs_serviceby'] = $fields['serviceBy'];
				$dataupdate['cs_name'] = $fields['name'];
				$dataupdate['customer_code'] = $fields['code'];
				$dataupdate['cs_mail'] = $fields['email'];
				$dataupdate['cs_mobno'] = $fields['mobileno'];
				$dataupdate['cs_tinno'] = $fields['tin_number'];
				$dataupdate['cs_cmsn_type'] = $fields['customer_classify'];
				$dataupdate['cs_long_bsns'] = $fields['years_inbusiness'];
				$dataupdate['cs_creditAmount'] = $fields['credit_amount'];
				$dataupdate['cs_population'] = $fields['population'];
				$dataupdate['idPreferredwarehouse'] = $fields['preferredwarehouse'];
				$dataupdate['cs_potential_value'] = $fields['potential_value'];
				$dataupdate['cs_martialStatus'] = $fields['martialstatus'];
				$dataupdate['cs_payment_type'] = $fields['payment_type'];
				$dataupdate['idSalesHierarchy'] = $fields['saleshry'];
				$dataupdate['sales_hrchy_name'] = $fields['employeeid'];
				$dataupdate['cs_credit_types'] = ($fields['credit_types'])?$fields['credit_types']:0;
				$dataupdate['cs_transport_type'] = $fields['transport_reimburse'];
				/*$dataupdate['part_paymentPercent'] = ($fields['part_paymentPercent'])?$fields['part_advance']:0;*/
				$dataupdate['idStocktransfer'] = ($fields['stock_transfer_rules'])?$fields['stock_transfer_rules']:0;
				if($fields['transport_reimburse']==2){
					$dataupdate['cs_transport_amt'] = $fields['transport_amount'];
				}else{
					$dataupdate['cs_transport_amt'] =0;
				}
				
				$dataupdate['cs_credit_ratingstatus'] = ($fields['credit_rating_status'])?$fields['credit_rating_status']:0;
				$dataupdate['cs_status'] = $fields['customer_status'];
				$dataupdate['cs_date_enrollment'] = date('Y-m-d',strtotime($fields['date_enrollment']));
				$dataupdate['cs_tindate'] = date('Y-m-d',strtotime($fields['tin_validity_date']));
				$dataupdate['cs_dob'] = date('Y-m-d',strtotime($fields['date_birth']));
				$dataupdate['cs_segment_type'] = $fields['segment_status'];
				$dataupdate['cs_customer_group'] = $fields['customer_group'];
				$dataupdate['cs_raising_rights'] = $fields['raising_rights'];
				$dataupdate['cs_stock_payment_type'] = $fields['stockrule_selected'];
				$dataupdate['created_by'] = $param->userid;
				$sql = new Sql($this->adapter );
				$update = $sql->update();
				$update->table('customer');
				$update->set($dataupdate);
				$update->where(array('idCustomer' => $editid));
				$statement  = $sql->prepareStatementForSqlObject($update);
				$results    = $statement->execute();
				$ret_arr = ['success' => '1','status' =>true, 'message' => 'Updated successfully', 'customer_id' => $customer_id];
				$this->adapter->getDriver()->getConnection()->commit();
			} catch (\Exception $e) {
				$ret_arr = ['success' => '3','status' =>false,'message' => 'Please try again Failed!!!'.$e];
				$this->adapter->getDriver()->getConnection()->rollBack();
			}
		} 
	}
		return $ret_arr;
	}
	public function get_warehouse($param) {
		if($param->action=='get') {
		$territoryid=$param->territoryid;
		$custid=$param->custid;
		$sub_territoried= $param->sub_territory;

		$subinsist=count($sub_territoried);	
		if($subinsist<=1) {
			$sub_territory=$sub_territoried[0];
		} else {
			$temp_territoryid=$territoryid;
			$territoryid="11";
			$sub_territory=implode(',',$sub_territoried);
		}
		
		$qryusertype="SELECT A.cs_type ,A.idCustomer  FROM customer A where A.idCustomer='$custid'";
			$resultusertype=$this->adapter->query($qryusertype,array());
			$resultsetusertype=$resultusertype->toArray();
			$usertype=$resultsetusertype[0]['cs_type'];
			$qry="SELECT A.idWarehouse as id,A.warehouseName as warehouse_name,A.warehouseMobileno as mobileno,A.warehouseEmail as email, A.idLevel FROM warehouse_master A where (A.t1 IN ($sub_territory) or A.t2 IN ($sub_territory)  or A.t3 IN ($sub_territory)  or A.t4 IN ($sub_territory)  or A.t5 IN ($sub_territory)  or A.t6 IN ($sub_territory)  or A.t7 IN ($sub_territory)  or A.t8 IN ($sub_territory)  or A.t9 IN ($sub_territory)  or A.t10 IN ($sub_territory) )and A.idLevel<'$usertype' AND status=1";
			
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
		//print_r($resultset);
		if(!$resultset) {
			$result = ['success' => '2','status' =>false,'message' => 'No records found'];	
		} else {
		$result = ['success' => '1','status' =>true,'content'=>$resultset,'message' => 'Warehouse list are given below'];
		}
		return $result;
		}
	}

	/*public function get_warehouse($param) {
		if($param->action=='get') {
		$territoryid=$param->territoryid;
		$custid=$param->custid;
		$sub_territory= $param->sub_territory;
		//$sub_territoried=($param->sub_territory!=null) ? $param->sub_territory:"0";
		$subinsist=count($sub_territoried);	
		$qryusertype="SELECT A.cs_type ,A.idCustomer  FROM customer A where A.idCustomer='$custid'";
			$resultusertype=$this->adapter->query($qryusertype,array());
			$resultsetusertype=$resultusertype->toArray();
			$usertype=$resultsetusertype[0]['cs_type']-1;
		//print_r($usertype);
		if($subinsist<=1) {
			$sub_territory=$sub_territoried[0];
		} else {
			$temp_territoryid=$territoryid;
			$territoryid="11";
			$sub_territory=implode(',',$sub_territoried);
		}
		switch($territoryid) {
		
			case "1":
			$qry="SELECT A.idWarehouse as id,A.warehouseName as warehouse_name,A.warehouseMobileno as mobileno,A.warehouseEmail as email FROM warehouse_master A where A.t1=? and A.idLevel='$usertype'";
			echo $qry;
			$result=$this->adapter->query($qry,array($sub_territory));
			$resultset=$result->toArray();
			break;
			case "2":
			$qry="SELECT A.idWarehouse as id,A.warehouseName as warehouse_name,A.warehouseMobileno as mobileno,A.warehouseEmail as email FROM warehouse_master A where A.t2=? and A.idLevel='$usertype'";
			echo $qry;
			$result=$this->adapter->query($qry,array($sub_territory));
			$resultset=$result->toArray();
			break;
			case "3":
			$qry="SELECT A.idWarehouse as id,A.warehouseName as warehouse_name,A.warehouseMobileno as mobileno,A.warehouseEmail as email FROM warehouse_master A where A.t3=?  and A.idLevel='$usertype'";
			echo $qry;
			$result=$this->adapter->query($qry,array($sub_territory));
			$resultset=$result->toArray();
			break;
			case "4":
			$qry="SELECT A.idWarehouse as id,A.warehouseName as warehouse_name,A.warehouseMobileno as mobileno,A.warehouseEmail as email FROM warehouse_master A where A.t4=?  and A.idLevel='$usertype'";
			echo $qry;
			$result=$this->adapter->query($qry,array($sub_territory));
			$resultset=$result->toArray();
			break;
			case "5":
			$qry="SELECT A.idWarehouse as id,A.warehouseName as warehouse_name,A.warehouseMobileno as mobileno,A.warehouseEmail as email FROM warehouse_master A where A.t5=?  and A.idLevel='$usertype'";
			echo $qry;
			$result=$this->adapter->query($qry,array($sub_territory));
			$resultset=$result->toArray();
			break;
			case "6":
			$qry="SELECT A.idWarehouse as id,A.warehouseName as warehouse_name,A.warehouseMobileno as mobileno,A.warehouseEmail as email FROM warehouse_master A where A.t6=?  and A.idLevel='$usertype'";
			echo $qry;
			$result=$this->adapter->query($qry,array($sub_territory));
			$resultset=$result->toArray();
			break;
			case "7":
			$qry="SELECT A.idWarehouse as id,A.warehouseName as warehouse_name,A.warehouseMobileno as mobileno,A.warehouseEmail as email FROM warehouse_master A where A.t7=? and A.idLevel='$usertype'";
			echo $qry;
			$result=$this->adapter->query($qry,array($sub_territory));
			$resultset=$result->toArray();
			break;
			case "8":
			$qry="SELECT A.idWarehouse as id,A.warehouseName as warehouse_name,A.warehouseMobileno as mobileno,A.warehouseEmail as email FROM warehouse_master A where A.t8=? and A.idLevel='$usertype'";
			echo $qry;
			$result=$this->adapter->query($qry,array($sub_territory));
			$resultset=$result->toArray();
			break;
			case "9":
			$qry="SELECT A.idWarehouse as id,A.warehouseName as warehouse_name,A.warehouseMobileno as mobileno,A.warehouseEmail as email FROM warehouse_master A where A.t9=? and A.idLevel='$usertype'";
			echo $qry;
			$result=$this->adapter->query($qry,array($sub_territory));
			$resultset=$result->toArray();
			break;
			case "10":
			$qry="SELECT A.idWarehouse as id,A.warehouseName as warehouse_name,A.warehouseMobileno as mobileno,A.warehouseEmail as email FROM warehouse_master A where A.t10=? and A.idLevel='$usertype'";
			echo $qry;
			$result=$this->adapter->query($qry,array($sub_territory));
			$resultset=$result->toArray();
			break;
			case "11":
			$qry="SELECT A.idWarehouse as id,A.warehouseName as warehouse_name,A.warehouseMobileno as mobileno,A.warehouseEmail as email FROM warehouse_master A where A.t$temp_territoryid IN($sub_territory) ";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			break;
		}
		print_r($resultset);
		if(!$resultset) {
			$result = ['success' => '2','status' =>false,'message' => 'No records found'];	
		} else {
		$result = ['success' => '1','status' =>true,'content'=>$resultset,'message' => 'Warehouse list are given below'];
		}
		return $result;
		}
	}*/
	public function get_customer_records($param) {
		if($param->action=='list') {
			$qry="SELECT A.idCustomer as id,A.cs_name as name FROM customer A";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			$result = ['success' => '2','status' =>true,'content'=>$resultset,'message' => 'Customer list are given below'];
		} else {
			$result = ['success' => '3','status' =>false,'message' => 'API failed,Please try again'];
		}
		return $result;
	}
	public function get_employee_records($param) {
		if($param->action=='list') {
			$qry="SELECT A.idTeamMember as id,A.code as name FROM team_member_master A";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			$result = ['success' => '2','status' =>true,'content'=>$resultset,'message' => 'Customer list are given below'];
		} else {
			$result = ['success' => '3','status' =>false,'message' => 'API failed,Please try again'];
		}
		return $result;
	}
	public function Segment_type($param){
		if($param->action=='list') {
			    $qry="SELECT st.segmentName as name,st.idsegmentType as id,st.status
			    	  FROM segment_type as st ";
			    $result=$this->adapter->query($qry,array());
			    $resultset=$result->toArray();
			    if(!$resultset){
				  $ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			    } 
			    else{
				$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'message'=>'System config information'];
			    }
		     }else if($param->action=='add') {
			$fiedls=$param->Form;
			$qry="SELECT st.idsegmentType,st.segmentName,st.status FROM segment_type as st where st.segmentName=?";
			$result=$this->adapter->query($qry,array($fiedls['segment_name']));
			$resultset=$result->toArray();
			if(!$resultset){ 
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['segmentName']=$fiedls['segment_name'];
					$datainsert['status']=$fiedls['status'];
					$datainsert['created_at']=date("Y-m-d H:i:s"); 
					$datainsert['created_by']=$param->userid;
					$datainsert['updated_at']=date("Y-m-d H:i:s"); 
					$datainsert['updated_by']=$param->userid;
					$insert=new Insert('segment_type');
					$insert->values($datainsert);
					$statement=$this->adapter->createStatement();
					$insert->prepareStatement($this->adapter, $statement);
					$insertresult=$statement->execute();
					$this->adapter->getDriver()->getConnection()->commit();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
				    } catch (\Exception $e){
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				     }
			 } 
			 else{
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
			  }
		    }  // add if close
            else if($param->action=='editview'){
			     $editid=$param->id;
			     $qry="SELECT st.segmentName as name,st.idsegmentType as id,st.status
			    	  FROM segment_type as st where idsegmentType=?";
			    
			     $result=$this->adapter->query($qry,array($editid));
			     $resultset=$result->toArray();

			     if(!$resultset){
				   $ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			     } 
			     else{
				   $ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			     }
		    }
		    else if($param->action=='update'){
			$fiedls=$param->Form;
			$editid=$fiedls['id'];
			$qry="SELECT st.segmentName as name,st.idsegmentType as id,st.status FROM segment_type as st where st.segmentName=? and st.idsegmentType!=?";
			$result=$this->adapter->query($qry,array($fiedls['name'],$editid));
			$resultset=$result->toArray();
			if(!$resultset){
				//print_r($fiedls);
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try{
					$datainsert['segmentName']=$fiedls['name'];
					$datainsert['status']=$fiedls['status'];
					$datainsert['updated_at']=date("Y-m-d H:i:s");
					$datainsert['updated_by']=$param->userid;
					$datainsert['updated_at']=date("Y-m-d H:i:s"); 
					$datainsert['updated_by']=$param->userid;
					$sql = new Sql($this->adapter );
					$update = $sql->update();
					$update->table('segment_type');
					$update->set($datainsert);
					$update->where( array('idsegmentType' => $editid));
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
	// public function testing($param) {
	// 	print_r($param);exit;
	// }
	public function designation_list($param) {
			     $qry="";
			     $result=$this->adapter->query($qry,array());
			     $resultset=$result->toArray();

			     if(!$resultset){
				   $ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			     } 
			     else{
				   $ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
				 }
				 return $ret_arr;

	}	
	public function reporting_manager_list($param) {
		$qry="SELECT A.idTeamMember as id,A.code,A.name FROM team_member_master A where A.isRepManager='1'";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		if(!$resultset){
		$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		} 
		else{
		$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
		}
		return $ret_arr;
	}	
	public function subsidiary_list($param) {
		$mainid=$param->mainid;
		$qry="SELECT A.idSubsidaryGroup as id,A.subsidaryName as name from subsidarygroup_master A  WHERE A.status=1";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		if(!$resultset){
		$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		}  else {
		$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
		}
		return $ret_arr;
	}
	public function proposition_type($param) {
		$subid=$param->subid;
		$qry="SELECT A.proposition as id from subsidarygroup_master A where A.idSubsidaryGroup='$subid'";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		if(!$resultset){
		$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		}  else {
		$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
		}
		return $ret_arr;
	}
	public function teamsegment_type($param) {
		$proid=$param->proid;
		$subid=$param->subid;
		$qry="SELECT A.segment as id from subsidarygroup_master A where  A.idSubsidaryGroup='$subid' AND A.proposition='$proid' ";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		if(!$resultset){
		$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		}  else {
		$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
		}
		return $ret_arr;
	}
	public function get_customer_group_list($param) {
		$qry="select A.idCustomer as id,A.cs_name as name from customer A";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		if(!$resultset) {
		$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		}  else {
		$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
		}
		return $ret_arr;
	}
	public function get_saleshr($param) {
		$qry="SELECT A.idSaleshierarchy as id,A.saleshierarchyType as type,A.saleshierarchyName as name from sales_hierarchy A where A.saleshierarchyName!=''";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		if(!$resultset) {
		$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		}  else {
		$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
		}
		return $ret_arr;
	}
	public function get_employee($param) {
		$empid=$param->empid;
		$qry="SELECT A.idTeamMember as id,A.code,A.name from team_member_master A WHERE A.idSaleshierarchy='$empid'";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		if(!$resultset) {
		$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		}  else {
		$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
		}
		return $ret_arr;
	}
	public function customer_type_list($param) {
		$qry="select A.idCustomerType as id,A.custType as name,A.level from customertype A WHERE A.status=1 ORDER BY level ASC";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		if(!$resultset){
		$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		}  else {
		$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
		}
		return $ret_arr;
	}
	public function customerType_service($param) {
		$customerType=$param->customerType;
		$serviceBy=$customerType;
		$qryclevel="SELECT idCustomerType from customertype as a WHERE a.status=1 ORDER BY a.level ASC LIMIT 1";
            $resultclevel=$this->adapter->query($qryclevel,array());
            $resultsetclevel=$resultclevel->toArray();  
            $idCustomerType=$resultsetclevel[0]['idCustomerType'];
           $serviceByStatus=0;
            if($customerType!=$idCustomerType)
            {
            	$serviceByStatus=1;
                //get higher level customertype id
            	$qryctypeID="SELECT idCustomerType FROM customertype WHERE status ='1' AND level<(SELECT a.level from customertype as a WHERE a.status=1 AND idCustomerType=$customerType)";
            $resultctypeID=$this->adapter->query($qryctypeID,array());
            $resultsetctypeID=$resultctypeID->toArray();
           
            if (count($resultsetctypeID)>0) {
            	foreach ($resultsetctypeID as $key => $value) {
            		$idsCType[]=$value['idCustomerType'];
            	}
            	$idCustomerType=implode(',', $idsCType);
            	//get higher level customer data
            	$qry="select A.idCustomer as id,A.cs_name as name from customer A WHERE A.cs_type IN($idCustomerType)";
		$result=$this->adapter->query($qry,array($serviceBy));
		$resultset=$result->toArray();

            	
            }
                
		
            }

		if(!$resultset){
		$ret_arr=['code'=>'1','content'=>false,'status'=>false,'serviceByStatus'=>$serviceByStatus,'message'=>'Record not found..'];
		}  else {
		$ret_arr=['code'=>'2','content'=>$resultset,'serviceByStatus'=>$serviceByStatus,'status'=>true,'message'=>'Record available'];
		}
		return $ret_arr;
	}
	public function team_group_list($param) {
		$qry="select A.idCustomerType as id,A.custType as name from customertype A";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		if(!$resultset){
		$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		}  else {
		$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
		}
		return $ret_arr;
	}
	public function get_main_records($param) {
		$qry="select A.idMainGroup as id,A.mainGroupName as name from maingroup_master A";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		if(!$resultset){
		$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		}  else {
		$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
		}
		return $ret_arr;
	}
	public function customer_edit($param) {
		if($param->action=='edit') {
			$qry="SELECT 
			A.idCustomer as id,
			A.customer_code as code,
			A.cs_name as name,
			A.cs_type as customer_type,
			A.cs_serviceby as service_By,
			A.cs_mail as email,
			A.cs_mobno as mobileno,
			DATE_FORMAT(A.cs_dob, '%d-%m-%Y') as date_birth,
			A.cs_martialStatus as martialstatus,
			A.cs_tinno as tin_number,
			DATE_FORMAT(A.cs_tindate, '%d-%m-%Y') as tin_validity_date,
			DATE_FORMAT(A.cs_date_enrollment, '%d-%m-%Y') as date_enrollment,
			A.cs_long_bsns as years_inbusiness,
			A.idPreferredwarehouse as idWarehouse,
			A.cs_creditAmount as credit_amount,
			A.cs_population as population,
			A.cs_potential_value as potential_value,
			A.cs_transport_type as transport_reimburse,
			IF(A.cs_transport_amt!=0.00,A.cs_transport_amt,'') as transport_amount,
			A.cs_raising_rights as raising_rights,
			A.cs_customer_group as customer_group,
			A.cs_segment_type as segment_status,
			A.cs_stock_payment_type as stockrule_selected,
			A.cs_credit_ratingstatus as credit_rating_status,
			A.cs_payment_type as payment_type,
			A.idSalesHierarchy as saleshry,
			A.sales_hrchy_name as employeeid,
			A.cs_credit_types as credit_types,
			A.cs_status as customer_status,
			A.G1,
			A.G2,
			A.G3,
			A.G4,
			A.G5,
			A.G6,
			A.G7,
			A.G8,
			A.G9,
			A.G10,
			A.part_paymentPercent
			FROM customer A where A.idCustomer=?";
			$result=$this->adapter->query($qry,array($param->customer_id));
			$resultset=$result->toArray();
			$serv=(int)$resultset[0]['customer_type']-1;
			$saleshr=(int)$resultset[0]['saleshry'];
             $servicebyall="SELECT cs_name as name,idCustomer as id FROM customer WHERE cs_type=?";
			$resultserv=$this->adapter->query($servicebyall,array($serv));			
			$resultsetserv=$resultserv->toArray();

			$saleshiry="SELECT name,idTeamMember as id FROM team_member_master WHERE idSaleshierarchy=?";
			$resultsaleshiry=$this->adapter->query($saleshiry,array($saleshr));			
			$resultsetsaleshiry=$resultsaleshiry->toArray();
			$customerType=$resultset[0]['customer_type'];
			$qryclevel="SELECT a.level from customertype as a WHERE a.status=1 ORDER BY a.level ASC LIMIT 1";
            $resultclevel=$this->adapter->query($qryclevel,array());
            $resultsetclevel=$resultclevel->toArray();  
            $clevel=$resultsetclevel[0]['level'];

        	$qryctype="SELECT idCustomerType,custType FROM customertype WHERE idCustomerType='$customerType' AND status ='1' AND level ='$clevel'";
        	
            $resultctype=$this->adapter->query($qryctype,array());
            $resultsetctype=$resultctype->toArray();  
            
            $servby=0;
            if($resultsetctype){
            	$servby=1;
            }else{
            	$servby=0;
            }

			if($resultset) {
			$result = ['success' => '1','status' =>true,'content'=>$resultset[0],'serviceby'=>$resultsetserv,'servbystatus'=>$servby,'saleshiry'=>$resultsetsaleshiry,'message' => 'Customer list are given below'];
			} else {
			$result = ['success' => '2','status' =>false,'message' => 'No customer found'];
			}
		} else {
			$result = ['success' => '3','status' =>false,'message' => 'API failed,Please try again'];
		}
		return $result;
	}
	public function customer_view($param) {
		if($param->action=='edit') {
			$qry="SELECT 
			A.idCustomer as id,
			A.customer_code as code,
			A.cs_name as name,
			A.cs_type as customer_type,
			A.cs_serviceby as service_By,
			B.custType as customer_typeName,
			A.cs_mail as email,
			A.cs_mobno as mobileno,
			DATE_FORMAT(A.cs_dob, '%d-%m-%Y')as date_birth,
			A.cs_martialStatus as martialstatus,
			A.cs_tinno as tin_number,
			DATE_FORMAT(A.cs_tindate, '%d-%m-%Y') as tin_validity_date,
			DATE_FORMAT(A.cs_date_enrollment, '%d-%m-%Y') as date_enrollment,
			A.cs_long_bsns as years_inbusiness,
			A.cs_creditAmount as credit_amount,
			A.cs_population as population,
			A.cs_potential_value as potential_value,
			A.cs_transport_type as transport_reimburse,
			A.cs_transport_amt as transport_amount,
			A.cs_raising_rights as raising_rights,
			A.cs_customer_group as customer_group,
			A.cs_segment_type as segment_status,
			A.cs_stock_payment_type as stockrule_selected,
			A.cs_credit_ratingstatus as credit_rating_status,
			A.cs_payment_type as payment_type,
			A.cs_credit_types as credit_types,
			A.idSalesHierarchy as saleshrid,
			A.sales_hrchy_name as empid,
			A.idPreferredwarehouse as idwarehouse,
			A.cs_status as customer_status,
			A.G1,
			C.geoValue as country_name,
			A.G2,
			D.geoValue as state_name,
			A.G3,
			E.geoValue as city_name,
			A.G4,
			F.geoValue as pincode_name,
			A.G5,
			G.geoValue as zone_name,
			A.G6,
			H.geoValue as region_name,
			A.G7,
			I.geoValue as hub_name,
			A.G8,
			J.geoValue as address_name,
			A.G9,
			K.geoValue as street_name,
			A.G10,
			L.geoValue as outlet_name,
			M.cs_name as group_name,
			N.segmentName,
			O.cs_name as serviceBy_name,
			SL.saleshierarchyName as saleshrname,
			WH.warehouseName as whname,
			TM.name as empname,
			GC.title as G1_title,
			GD.title as G2_title,
			GE.title as G3_title,
			GF.title as G4_title,
			GG.title as G5_title,
			GH.title as G6_title,
			GI.title as G7_title,
			GJ.title as G8_title,
			GK.title as G9_title,
			GL.title as G10_title
			FROM customer A
			LEFT JOIN customertype B ON B.idCustomerType=A.cs_type
			LEFT JOIN geography C ON C.idGeography=A.G1
			LEFT JOIN geographytitle_master GC ON GC.idGeographyTitle=C.idGeographyTitle
			LEFT JOIN geography D ON D.idGeography=A.G2
			LEFT JOIN geographytitle_master GD ON GD.idGeographyTitle=D.idGeographyTitle
			LEFT JOIN geography E ON E.idGeography=A.G3
			LEFT JOIN geographytitle_master GE ON GE.idGeographyTitle=E.idGeographyTitle
			LEFT JOIN geography F ON F.idGeography=A.G4
			LEFT JOIN geographytitle_master GF ON GF.idGeographyTitle=F.idGeographyTitle
			LEFT JOIN geography G ON G.idGeography=A.G5
			LEFT JOIN geographytitle_master GG ON GG.idGeographyTitle=G.idGeographyTitle
			LEFT JOIN geography H ON H.idGeography=A.G6
			LEFT JOIN geographytitle_master GH ON GH.idGeographyTitle=H.idGeographyTitle
			LEFT JOIN geography I ON I.idGeography=A.G7
			LEFT JOIN geographytitle_master GI ON GI.idGeographyTitle=I.idGeographyTitle
			LEFT JOIN geography J ON J.idGeography=A.G8
			LEFT JOIN geographytitle_master GJ ON GJ.idGeographyTitle=J.idGeographyTitle
			LEFT JOIN geography K ON K.idGeography=A.G9
			LEFT JOIN geographytitle_master GK ON GK.idGeographyTitle=K.idGeographyTitle
			LEFT JOIN geography L ON L.idGeography=A.G10
			LEFT JOIN geographytitle_master GL ON GL.idGeographyTitle=L.idGeographyTitle
			LEFT JOIN customer M ON M.idCustomer=A.cs_customer_group
			LEFT JOIN sales_hierarchy SL ON SL.idSaleshierarchy=A.idSaleshierarchy
			LEFT JOIN segment_type N ON N.idsegmentType=A.cs_segment_type
			LEFT JOIN warehouse_master WH ON WH.idWarehouse=A.idPreferredwarehouse
			LEFT JOIN team_member_master TM ON TM.idTeamMember=A.sales_hrchy_name
			LEFT JOIN customer O ON O.idCustomer=A.cs_serviceby
			WHERE A.idCustomer=?";
			$result=$this->adapter->query($qry,array($param->customer_id));
			$resultset=$result->toArray();
			if($resultset) {
				$result = ['success' => '1','status' =>true,'content'=>$resultset[0],'message' => 'Customer list are given below'];
			} else {
				$result = ['success' => '2','status' =>false,'message' => 'No customer found'];
			}
		} else {
			$result = ['success' => '3','status' =>false,'message' => 'API failed,Please try again'];
		}
		return $result;
	}
	public function get_geography_all($param) {
		$geograph_id=$param->geography_id;
		$qry="SELECT A.geography,A.idGeographyTitle as id,A.title FROM geographytitle_master A WHERE A.idGeographyTitle='$geograph_id' and A.title!=''";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		$geography_id=$resultset[0]['id'];
		$geography_title=$resultset[0]['title'];
		if($geography_title!=null) {
		$qrygeo1="SELECT B.idGeography as geo_id,B.geoValue FROM geography B where B.idGeographyTitle=?";
		$resultgeo1=$this->adapter->query($qrygeo1,array($geography_id));
		$resultsetgeo1=$resultgeo1->toArray();
		$resultset[0]['content']=$resultsetgeo1;
		$resultset[0]['status']='1';
		} else {
			$resultset[0]['content']="";
			$resultset[0]['status']="0";
		}
		if($resultset!=null) {
			$result = ['success' => '1','status' =>true,'content'=>$resultset[0],'message' => 'Customer list are given below'];
			} else {
			$result = ['success' => '2','status' =>false,'message' => 'No customer found'];
		}
		return $result;
	}

	public function getwarehouse()
	{
        $qry="SELECT idWarehouse,warehouseName FROM `warehouse_master`";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		if($resultset!=null) {
			$result = ['success' => '1','status' =>true,'content'=>$resultset,'message' => 'Customer list are given below'];
			} else {
			$result = ['success' => '2','status' =>false,'message' => 'No customer found'];
		}
		return $result;
	}

	public function getAllocatedata($param)
	{
		
		$customerid=$param->id;
		$qry="SELECT idStocktransfer,idTerritorytitle,territory_ids,category_ids,warehouse_ids,channel_ids FROM `customer_allocation` WHERE customer_id=?";
		$result=$this->adapter->query($qry,array($customerid));
		$resultset=$result->toArray();
		$idStocktransfer=0;
		$idTerritorytitle=0;
		if (count($resultset)>0) 
		{
			$idTerritorytitle=($resultset[0]['idTerritorytitle'])?$resultset[0]['idTerritorytitle']:0;
		   $territoryids=array_unique(unserialize($resultset[0]['territory_ids']));
		   $channel_ids=unserialize($resultset[0]['channel_ids']);
		   $warehouse_ids=unserialize($resultset[0]['warehouse_ids']);

		   $category_ids=unserialize($resultset[0]['category_ids']);
		   $idStocktransfer=($resultset[0]['idStocktransfer'])?$resultset[0]['idStocktransfer']:0;
		}
         
			$qryCategory="SELECT idCategory,category FROM `category` WHERE status=1";
			$resultCategory=$this->adapter->query($qryCategory,array());
			$resultsetCategory=$resultCategory->toArray();
			for ($i=0; $i < count($resultsetCategory); $i++) 
			{ 
				$category[$i]['id']=$resultsetCategory[$i]['idCategory'];
				$category[$i]['name']=$resultsetCategory[$i]['category'];
				$category[$i]['checked']=false;
			}
            
			for ($i=0; $i < count($category); $i++) 
			{
				for ($j=0; $j < count($category_ids); $j++) 
				{
                   if ($category_ids[$j]==$category[$i]['id']) 
                   {
                      $category[$i]['checked']=true;   	
                   }  
				}
			}
            //get entered user type
			$qryusertype="SELECT A.cs_type ,A.idCustomer  FROM customer A where A.idCustomer='$customerid'";
			$resultusertype=$this->adapter->query($qryusertype,array());
			$resultsetusertype=$resultusertype->toArray();
			$usertype=$resultsetusertype[0]['cs_type'];
			// print_r($territoryids);
             // get warehouse data
			$resultsetWarehouse=array();

             for ($i=0; $i <count($territoryids) ; $i++) 
             { 
             	$idsss=$territoryids[$i];
				$qryWarehouse="SELECT idWarehouse,warehouseName FROM `warehouse_master` WHERE 	idLevel<$usertype AND status=1 AND (t1 IN($idsss) or t2 IN($idsss) or t3 IN($idsss) or t4 IN($idsss) or t5 IN($idsss) or t6 IN($idsss) or t7 IN($idsss) or t8 IN($idsss) or t9 IN($idsss) or t10 IN($idsss))";
				$resultWarehouse=$this->adapter->query($qryWarehouse,array());
				$resultsetWH=$resultWarehouse->toArray();
				//$resultsetWarehouse[]=$resultsetWH;
				
				foreach ($resultsetWH as $key => $values) {
					array_push($resultsetWarehouse,$values);
				}
				
             }
            
             $resultsetWarehouse = array_map("unserialize", array_unique(array_map("serialize", $resultsetWarehouse)));
             
			
           if (count($warehouse_ids)>0) 
           {
	           	for ($i=0; $i < count($resultsetWarehouse); $i++) 
				{ 
					$warehouse[$i]['id']=$resultsetWarehouse[$i]['idWarehouse'];
					$warehouse[$i]['warehouse_name']=$resultsetWarehouse[$i]['warehouseName'];
					$warehouse[$i]['checked']=false;
				}
	          
				for ($i=0; $i < count($warehouse); $i++) 
				{
					for ($j=0; $j < count($warehouse_ids); $j++) 
					{
	                   if ($warehouse_ids[$j]==$warehouse[$i]['id']) 
	                   {
	                      $warehouse[$i]['checked']=true;   	
	                   }  
					}
				}

           }
           else
           {
           	  $warehouse=[];
           }
			
			$qryChannel="SELECT idChannel,Channel FROM channel ";
			$resultChannel=$this->adapter->query($qryChannel,array());
			$resultsetChannel=$resultChannel->toArray();

			for ($i=0; $i < count($resultsetChannel); $i++) 
			{ 
				$channel[$i]['idChannel']=$resultsetChannel[$i]['idChannel'];
				$channel[$i]['Channel']=$resultsetChannel[$i]['Channel'];
				$channel[$i]['checked']=false;
			}
            
			for ($i=0; $i < count($channel); $i++) 
			{
				for ($j=0; $j < count($channel_ids); $j++) 
				{
                   if ($channel_ids[$j]==$channel[$i]['idChannel']) 
                   {
                      $channel[$i]['checked']=true;   	
                   }  
				}
			}

			$qryTerritory="SELECT idTerritory,idTerritoryTitle,territoryValue FROM `territory_master` WHERE idTerritoryTitle=? AND status=1";
			$resultTerritory=$this->adapter->query($qryTerritory,array($idTerritorytitle));
			$resultsetTerritory=$resultTerritory->toArray();
			// print_r($resultsetTerritory);

			for ($i=0; $i < count($resultsetTerritory); $i++) 
			{ 
				$territory[$i]['idTerritory']=$resultsetTerritory[$i]['idTerritory'];
				$territory[$i]['territoryValue']=$resultsetTerritory[$i]['territoryValue'];
				$territory[$i]['checked']=false;
			}
            
            if(count($territoryids)>0)
            {
				for ($i=0; $i < count($territory); $i++) 
				{
					for ($j=0; $j < count($territoryids); $j++) 
					{
					   if ($territoryids[$j]==$territory[$i]['idTerritory']) 
					   {
					      $territory[$i]['checked']=true;   	
					   }  
					}
				}
            }
			
			$ret_arr=['code'=>'2','status'=>true,'message'=>'data available','idterritorytitle'=>$idTerritorytitle,'territory'=>$territory,'category'=>$category,'channel'=>$channel,'warehouse'=>$warehouse,'idStocktransfer'=>$idStocktransfer,'checkedterritoryID'=>$territoryids,'checkedcategoryID'=>$category_ids,'checkedchannelID'=>$channel_ids,'checkedwarehouseID'=>$warehouse_ids];
			return $ret_arr;
            



	}

	public function allocate_customer($param)
	{
      
      $fields=$param->records;
      
		$qry="SELECT * FROM `customer_allocation` WHERE customer_id=?";
		$result=$this->adapter->query($qry,array($fields['customerid']));
		$resultset=$result->toArray();

		if(count($resultset)==0)
		{
            $this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['customer_id']=$fields['customerid'];
					// $datainsert['idStockrule']=$fields['customerid'];
					//$datainsert['idStocktransfer']=$fields['stock_transfer_rules'];
					$datainsert['idTerritorytitle']=$fields['territory'];
					$datainsert['territory_ids']=serialize($param->idterritory);
					$datainsert['category_ids']=serialize($param->idcat);
					$datainsert['warehouse_ids']=serialize($param->idwarehouse);
					//$datainsert['channel_ids']=serialize($param->idchannel);					
					$datainsert['created_by']=$param->userid;
					$datainsert['created_at']=date('Y-m-d H:i:s');
				
					$insert=new Insert('customer_allocation');
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
		else
		{


			$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					//$dataupdate['customer_id']=$fields['customerid'];
					// $datainsert['idStockrule']=$fields['customerid'];
					//$dataupdate['idStocktransfer']=$fields['stock_transfer_rules'];
					$dataupdate['idTerritorytitle']=$fields['territory'];
					$dataupdate['territory_ids']=serialize($param->idterritory);
					$dataupdate['category_ids']=serialize($param->idcat);
					$dataupdate['warehouse_ids']=serialize($param->idwarehouse);
					//$dataupdate['channel_ids']=serialize($param->idchannel);
					$dataupdate['updated_by']=$param->userid;
					$dataupdate['updated_at']=date('Y-m-d H:i:s');
					
					$sql = new Sql($this->adapter);
					$update = $sql->update();
					$update->table('customer_allocation');
					$update->set($dataupdate);
					$update->where( array('customer_id'=>$fields['customerid']));
					$statement  = $sql->prepareStatementForSqlObject($update);
					$results    = $statement->execute();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				} catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			
		}
     
				return $ret_arr;
	}

	public function booknumberadd($param)
	{
		//print_r($param);
      if($param->action=='list') {
      	$qry="SELECT A.idLedgerBook as id,A.ledgerNo,A.recieptFromNo,A.recieptToNo,0 as status from ledger_book A";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();

		for ($i=0; $i <count($resultset) ; $i++) { 
			$ledger_no=$resultset[$i]['ledgerNo'];
			$qryledgerNo="SELECT ledgerNo from ledger_details where ledgerNo=?";
			$resultledgerNo=$this->adapter->query($qryledgerNo,array($ledger_no));
			$resultsetledgerNo=$resultledgerNo->toArray();
			$resultset[$i]['status']=($resultsetledgerNo[0]['ledgerNo'])?$resultsetledgerNo[0]['ledgerNo']:'0';
		}
		
		if(!$resultset){
		$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		}  else {
		$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
		}
      }else if($param->action=='editview'){
			     $editid=$param->id;
			     $qry="SELECT  A.idLedgerBook as id,A.ledgerNo as bookNo,A.recieptFromNo as RcptBookFrom,A.recieptToNo as RcptBookTo from ledger_book as A where A.idLedgerBook=?";
			    
			     $result=$this->adapter->query($qry,array($editid));
			     $resultset=$result->toArray();

			     if(!$resultset){
				   $ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			     } 
			     else{
				   $ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			     }
		}
       else if($param->action=='add') {
      $fields=$param->Form;
      $bookno=$fields['txtbookNo'];
		$qry="SELECT idLedgerBook FROM ledger_book WHERE ledgerNo='$bookno'";
		$result=$this->adapter->query($qry,array($fields['customerid']));
		$resultset=$result->toArray();
      //print_r($resultset); 

		if(count($resultset)==0)
		{
            $this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['ledgerNo']=$fields['txtbookNo'];
					$datainsert['recieptFromNo']=$fields['txtRcptBookFrom'];
					$datainsert['recieptToNo']=$fields['txtRcptBookTo'];
					//print_r($datainsert);
					$insert=new Insert('ledger_book');
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
		}else
		{
			$ret_arr = ['code' => '3','status' =>false,'message' => 'Book no already exists'];
		}
		
     }
				return $ret_arr;
	}

	public function ledgerAction($param)
	{
		$userData=$param->userData;
		$userid=$userData['user_id'];
		$usertype=$userData['user_type'];
		$idCustomer=$userData['idCustomer'];
		if($param->action=='list') 
		  {
			    $qry="SELECT wm.idLedger,wm.ledgerNo,wm.recieptFromNo,wm.recieptToNo,wm.recieptNos,wm.totalReciept,wm.usedReciept,wm.idColEmp,DATE_FORMAT(wm.entryDate, '%d-%m-%Y') as entryDate,tm.name,tm1.territoryValue as t1,tm2.territoryValue as t2,tm3.territoryValue as t3,tm4.territoryValue as t4,tm5.territoryValue as t5,tm6.territoryValue as t6,tm7.territoryValue as t7,tm8.territoryValue as t8,tm9.territoryValue as t9,tm10.territoryValue as t10  FROM ledger_details as wm  
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
			LEFT JOIN team_member_master as tm ON tm.idTeamMember=wm.idColEmp";
			    $result=$this->adapter->query($qry,array());
			    $resultset=$result->toArray();
			    //print_r($resultset);
			    if(!$resultset) 
			    {
				  $ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			    } 
			    else 
			    {
				$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'message'=>'Data available'];
			    }
		     }
		else if($param->action=='ledgercollmember'){
			$territory_id=$param->territory_id;
			$qry="SELECT SE.idTeamMember,SE.code,SE.name FROM team_member_master as SE  where SE.t1='$territory_id' OR SE.t2='$territory_id' OR SE.t3='$territory_id' OR SE.t4='$territory_id' OR SE.t5='$territory_id' OR SE.t6='$territory_id' OR SE.t7='$territory_id' OR SE.t8='$territory_id' OR SE.t9='$territory_id' OR SE.t10='$territory_id' order by SE.name asc";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			}else{
				$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'message'=>'Data available'];
			}

		}     
     	else if($param->action=='add') 
     		{
			$fiedls=$param->Form;
			$ledger_no=$param->ledger_no;
			$from_no=$param->from_no;
			$to_no=$param->to_no;
			$qry="SELECT ledgerNo from ledger_details where ledgerNo=?";
			$result=$this->adapter->query($qry,array($ledger_no));
			$resultset=$result->toArray();
			if(!$resultset) 
			{ 

		$totalReciepts=0;
		$recieptNos='';
		for($i=$from_no;$i<=$to_no;$i++){
			$totalReciepts++;
			$recieptNos.=$i.',';
		}
		
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['ledgerNo']=$ledger_no;
					$datainsert['recieptFromNo']=$from_no;
					$datainsert['recieptToNo']=$to_no;
					$datainsert['totalReciept']=$totalReciepts;
					$datainsert['recieptNos']=$recieptNos;
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
					
					$datainsert['idColEmp']=$fiedls['selCollNameTdId'];
					$datainsert['entryDate']=date("Y-m-d H:i:s"); 
					$datainsert['created_by']=$userid;
					//print_r($datainsert);exit;
					$insert=new Insert('ledger_details');
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
			     $qry="SELECT a.idPrimaryPackaging, a.primarypackname,a.status,b.idSubPackaging as subpackage,b.subpackname as subpackname FROM primary_packaging as a
			     LEFT JOIN sub_packaging as b ON b.idSubPackaging=a.idSubPackaging
			     where idPrimaryPackaging=?";
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
		    

       return $ret_arr;
	}

	public function receiptCancel($param)
	{
		$userData=$param->userData;
		$userid=$userData['user_id'];
		$usertype=$userData['user_type'];
		$idCustomer=$userData['idCustomer'];
		if($param->action=='list') 
		  {
			    $qry="SELECT LC.idLedgerCancel,LC.idColEmp,LC.recptNo,LC.reason,DATE_FORMAT(LC.cancelDate, '%d-%m-%Y') as cancelDate,SH.code,SH.name,LD.ledgerNo from ledger_cancel as LC LEFT JOIN  team_member_master as SH ON SH.idTeamMember=LC.idColEmp LEFT JOIN ledger_details as LD ON LD.idLedger=LC.idLedger";
			    $result=$this->adapter->query($qry,array());
			    $resultset=$result->toArray();
			    if(!$resultset) 
			    {
				  $ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			    } 
			    else 
			    {
				$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'message'=>'Data available'];
			    }
		     }
		else if($param->action=='delete'){
			$id=$param->cancelid;
			$deleteid=$id['cancelid'];
			$qry="SELECT LC.idLedgerCancel from ledger_cancel as LC where LC.idLedgerCancel='$deleteid'";
			
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			//print_r($resultset); exit;
			 
			if($resultset) 
			{ 
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$delete = new Delete('ledger_cancel');
                    $delete->where(['idLedgerCancel=?' => $deleteid]);
                    $statement=$this->adapter->createStatement();
                    $delete->prepareStatement($this->adapter, $statement);
                    $resultset=$statement->execute();
					
					$this->adapter->getDriver()->getConnection()->commit();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Deleted successfully'];
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
		}   
		else if($param->action=='getcollmember'){
			$qry="SELECT SE.idTeamMember,SE.code,SE.name FROM team_member_master as SE order by SE.code asc
			";
			
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			//print_r($resultset);
			if(!$resultset) {
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			}else{
				$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'message'=>'Data available'];
			}
		}    
		else if($param->action=='getbank'){
			$qry="SELECT SE.idBank,SE.bankName FROM bank as SE GROUP by SE.bankName";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			//print_r($resultset);
			if(!$resultset) {
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			}else{
				$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'message'=>'Data available'];
			}
		}    
		else if($param->action=='getifsc'){
			$bankid=$param->bankid;
			$qry="SELECT SE.idBank,SE.bankIFSC FROM bank as SE WHERE SE.idBank='$bankid'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			//print_r($resultset);
			if(!$resultset) {
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			}else{
				$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'message'=>'Data available'];
			}
		}    
		else if($param->action=='getcard'){
			$bankid=$param->bankid;
			$qry="SELECT SE.idCardtype,SE.cardtypeName FROM card_type as SE WHERE SE.status='1'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			//print_r($resultset);
			if(!$resultset) {
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			}else{
				$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'message'=>'Data available'];
			}
		}   else if($param->action=='getbookno'){
			$cusid=$param->cusid;
			$qry="SELECT SE.idLedger as id,SE.ledgerNo FROM ledger_details as SE
			LEFT JOIN customer as CS ON CS.sales_hrchy_name=SE.idColEmp 
			WHERE CS.idCustomer='$cusid'";
			//echo $qry;
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			//print_r($resultset);
			if(!$resultset) {
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			}else{
				$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'message'=>'Data available'];
			}
		}    else if($param->action=='getreceipt'){
			$bookid=$param->bookid;
			$qry="SELECT SE.idLedger as id,SE.recieptNos FROM ledger_details as SE
			WHERE SE.idLedger='$bookid'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			//$recieptNos=array();
			$recieptNos=explode(',',$resultset[0]['recieptNos']);

			$chkInsrtAry="SELECT idLedgerCancel,recptNo from  ledger_cancel where idLedger='$bookid'";
			$resultchkInsrtAry=$this->adapter->query($chkInsrtAry,array());
			$resultsetchkInsrtAry=$resultchkInsrtAry->toArray();

			$receipt_nos=array();
			if(count($resultsetchkInsrtAry)>0){
			for ($i=0; $i <count($recieptNos) ; $i++) { 
				for ($k=0; $k <count($resultsetchkInsrtAry) ; $k++) { 

					if($recieptNos[$i]!=$resultsetchkInsrtAry[$k]['recptNo']){
						$receipt_nos[]=$recieptNos[$i];
					}
				}
				
			}
		}else{
			for ($k=0; $k <count($recieptNos) ; $k++) { 
				if ($recieptNos[$k]!="" && $recieptNos[$k]!=null) {
					
				$receipt_nos[]=$recieptNos[$k];
				}
		}
		}
			if(!$resultset) {
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			}else{
				$ret_arr=['code'=>'2','status'=>true,'content' =>$receipt_nos,'message'=>'Data available'];
			}
		}    
     	else if($param->action=='add') 
     		{
			$fields=$param->Form;
			//print_r($fiedls);exit;
			$member=$fields['sel_CollMemCode'];
			$rcptno=$fields['txtRcptNo'];
			$bookno=$fields['txtBookNo'];
			$cnclrsn=$fields['txtCnclRsn'];
			//print_r($member); exit;
			$getIdLedger="SELECT idLedger from ledger_details where ledgerNo='$bookno'";
			$resultIdLedger=$this->adapter->query($getIdLedger,array());
			$resultsetIdLedger=$resultIdLedger->toArray();

			$idLedger=$resultsetIdLedger[0]['idLedger'];
	
			$chkRecpt="SELECT idLedger,recieptNos from ledger_details where idLedger='$idLedger' and  recieptNos like  '%".$rcptno."%' and idColEmp='$member' order by entryDate desc limit 1";

			
			$resultchkRecpt=$this->adapter->query($chkRecpt,array());
			$resultsetchkRecpt=$resultchkRecpt->toArray();
			$status=false;
			$receipt_nos=explode(',',$resultsetchkRecpt[0]['recieptNos']);
			
			for ($i=0; $i <count($receipt_nos) ; $i++) { 
				if($receipt_nos[$i]==$rcptno){
					$status=true;
				}
			}

	if($status==true){
		$chkInsrtAry="SELECT idLedgerCancel from  ledger_cancel where idLedger='$idLedger' and	recptNo='$rcptno' and idColEmp='$member'";
		$resultchkInsrtAry=$this->adapter->query($chkInsrtAry,array());
			$resultsetchkInsrtAry=$resultchkInsrtAry->toArray();

		
			if(!$resultsetchkInsrtAry) 
			{ 

		
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['idColEmp']=$member;
					$datainsert['idLedger']=$idLedger;
					$datainsert['recptNo']=$rcptno;
					$datainsert['reason']=$cnclrsn;
					$datainsert['cancelDate']=date("Y-m-d"); 
					$insert=new Insert('ledger_cancel');
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
			}else{
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Please enter the correct book and receipt no'];
			}
		  }  
		    
       return $ret_arr;
	}


	public function collectionEntry($param)
	{
		$userData=$param->userData;
		$userid=$userData['user_id'];
		$usertype=$userData['user_type'];
		$idCustomer=$userData['idCustomer'];
		if($param->action=='list') 
		  {
		  	$fields=$param->Form;
		  	$allcustomer=$fields['allcustomer'];
		  	$selCollMember=$fields['selCollMember'];
		  	$member=$param->member;
		  	$memid=implode(',',$member);

		  	if($allcustomer==1){

		  			$qry="SELECT CS.idCustomer,
CS.sales_hrchy_name as ColMemID,
CS.customer_code as code,
CS.idCustomer,
CS.cs_name,
0 as balamt, 
(select sum(invoiceAmt) from invoice_details where idCustomer=CS.idCustomer) as outAmt,
(select sum(payAmt-paidAmount) from invoice_payment where idCustomer=CS.idCustomer) as paidAmt,
(select sum(payAmt-paidAmount) from invoice_payment where idCustomer=CS.idCustomer AND payType='On Account') as OnaccAmt,
(SELECT sum(grandtotalAmount)  FROM orders where idCustomer=CS.idCustomer) as totalOrderamount
from  customer as CS where  CS.sales_hrchy_name IN ($memid) order by CS.idCustomer, CS.cs_name asc";
		  			
		  	}else{
		  		$qry="SELECT CS.idCustomer,
CS.sales_hrchy_name as ColMemID,
CS.customer_code as code,
CS.idCustomer,
CS.cs_name,
0 as balamt, 
0 as outstatndAmt,
(select sum(invoiceAmt) from invoice_details where idCustomer=CS.idCustomer) as outAmt, 
(select sum(payAmt-paidAmount) from invoice_payment where idCustomer=CS.idCustomer) as paidAmt,
(select sum(payAmt-paidAmount) from invoice_payment where idCustomer=CS.idCustomer AND payType='On Account') as OnaccAmt,

(SELECT sum(grandtotalAmount)  FROM orders where idCustomer=CS.idCustomer) as totalOrderamount
from  customer as CS where  CS.sales_hrchy_name='$selCollMember' order by CS.idCustomer, CS.cs_name asc";
		  	}
		   $result=$this->adapter->query($qry,array());
			    $resultset=$result->toArray();
			    for ($i=0; $i <count($resultset) ; $i++) 
			    { 
			    	$resultset[$i]['outstatndAmt']=($resultset[$i]['outAmt'])?$resultset[$i]['outAmt']:'0';
			    	$resultset[$i]['balamt']=$resultset[$i]['outstatndAmt']-$resultset[$i]['paidAmt'];
			    	
			    }
			   
			    if(!$resultset) 
			    {
				  $ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			    } 
			    else 
			    {
				$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'message'=>'Data available'];
			    }
		     }
		else if($param->action=='checkreceiptno') 
		  {
		  	$cusid=$param->custid;
		  	$receiptno=$param->receiptno;
		  	$bookno=$param->bookno;
		  
		  	$qry="SELECT CS.idCustomer,CS.sales_hrchy_name as ColMemID from  customer as CS 
		  	where  CS.idCustomer='$cusid'";
		   	$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			$ColMemID=$resultset[0]['ColMemID'];

			$ledger="SELECT idLedger from ledger_details where idColEmp='$ColMemID' AND idLedger='$bookno' order by entryDate desc limit 1";
		   	$resultledger=$this->adapter->query($ledger,array());
			$resultsetledger=$resultledger->toArray();
			$idLedger=$resultsetledger[0]['idLedger'];

			$val="SELECT idLedgerCancel from ledger_cancel where idLedger='$idLedger' and recptNo='$receiptno'";
			$resultval=$this->adapter->query($val,array());
			$resultsetval=$resultval->toArray();
			$availstatus=0;
			// print_r($resultsetval);exit;
		if(0<count($resultsetval)){
			$availstatus=0;	
		}else{			
			$txtReciptNoVal=$receiptno;
			$colMemLedgerAry="SELECT idLedger, recieptNos, usedReciept from ledger_details where idLedger='$idLedger' and recieptNos like '%".$txtReciptNoVal."%'";
		
			$resultcolMem=$this->adapter->query($colMemLedgerAry,array());
			$resultsetcolMem=$resultcolMem->toArray();

			$getIdLedgerExp=explode(',',$resultsetcolMem[0]['recieptNos']);
			
			if(in_array($txtReciptNoVal,$getIdLedgerExp)){
				$availstatus=1;				
			}else{
				$availstatus=0;
			}
			
		}
		
			    if(!$resultset) 
			    {
				  $ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			    } 
			    else 
			    {
				$ret_arr=['code'=>'2','status'=>true,'memberid' =>$ColMemID,'idLedger' =>$idLedger,'availstatus' =>$availstatus,'invoicecustid' =>$cusid,'message'=>'Data available'];
			    }
		     }
		else if($param->action=='customerdetails') 
			{
			  	$cusid=$param->cusid;
			  	
			  	$qry="SELECT CS.idCustomer,CS.cs_name,CS.cs_mobno,CS.sales_hrchy_name as collmem_code,CS.G1,CS.G2,CS.G3,CS.G4,CS.G5,CS.G6,CS.G7,CS.G8,CS.G9,CS.G10,tm1.geoValue as country,tm2.geoValue as state,tm3.geoValue as city,tm4.geoValue as pincode,tm5.geoValue as region,tm6.geoValue as zone,tm7.geoValue as hub,tm8.geoValue as area,tm9.geoValue as street,tm10.geoValue as outlet from  customer as CS 
			  	LEFT JOIN geography as tm1 ON tm1.idGeography=CS.G1
			LEFT JOIN geography as tm2 ON tm2.idGeography=CS.G2
			LEFT JOIN geography as tm3 ON tm3.idGeography=CS.G3
			LEFT JOIN geography as tm4 ON tm4.idGeography=CS.G4
			LEFT JOIN geography as tm5 ON tm5.idGeography=CS.G5
			LEFT JOIN geography as tm6 ON tm6.idGeography=CS.G6
			LEFT JOIN geography as tm7 ON tm7.idGeography=CS.G7
			LEFT JOIN geography as tm8 ON tm8.idGeography=CS.G8
			LEFT JOIN geography as tm9 ON tm9.idGeography=CS.G9
			LEFT JOIN geography as tm10 ON tm10.idGeography=CS.G10
			  	where CS.idCustomer='$cusid'";
			   $result=$this->adapter->query($qry,array());
				    $resultset=$result->toArray();

			  $qryinvoice="SELECT ID.invoiceAmt, ID.invoiceNo, DATE_FORMAT(ID.invoiceDate, '%d-%m-%Y') as invoiceDate, ID.idInvoice,CS.sales_hrchy_name,0 as balAmt  from invoice_details as ID 
							LEFT JOIN customer as CS ON CS.idCustomer=ID.idCustomer
							LEFT JOIN team_member_master as SH ON SH.idTeamMember=CS.sales_hrchy_name
							where CS.idCustomer='$cusid'";
					$resultinvoice=$this->adapter->query($qryinvoice,array());
				    $resultsetinvoice=$resultinvoice->toArray();
				    $totalBalAmt=0;
				    for($iCont=0; $iCont<count($resultsetinvoice); $iCont++){
					$amtPayAry="SELECT sum(payAmt-paidAmount) as totalInvoicePayAmt from invoice_payment where idInvoice='".$resultsetinvoice[$iCont]['idInvoice']."'";
					$resultamtPay=$this->adapter->query($amtPayAry,array());
					$resultsetamtPay=$resultamtPay->toArray();
					$resultsetinvoice[$iCont]["balAmt"]=$resultsetinvoice[$iCont]["invoiceAmt"]-$resultsetamtPay[0]["totalInvoicePayAmt"];
					$totalBalAmt+=$resultsetinvoice[$iCont]["balAmt"];
					//print_r($resultsetinvoice[$iCont]["balAmt"]);

					if($resultsetinvoice[$iCont]["balAmt"]!=0){
						$finalinvoice[]=$resultsetinvoice[$iCont];

					}
				}
				$totAmnt="SELECT sum(invoiceAmt) as totalAmount FROM invoice_details where idCustomer='$cusid'";
				$resulttotAmnt=$this->adapter->query($totAmnt,array());
				$resultsettotAmnt=$resulttotAmnt->toArray();

				$collctAmnt="SELECT sum(payAmt-paidAmount) as collectionAmount FROM invoice_payment where idCustomer='$cusid'and payType='On Bill'";
				$resultcollctAmnt=$this->adapter->query($collctAmnt,array());
				$resultsetcollctAmnt=$resultcollctAmnt->toArray();

				$OutstandingAmt=0;
				$amtOnAccPayAry="SELECT sum(payAmt-paidAmount) as totalPayOnAccAmt from invoice_payment where idCustomer='".$resultset[0]['idCustomer']."' and payType='On Bill'";
				$resultAccPayAry=$this->adapter->query($amtOnAccPayAry,array());
				$resultsetAccPayAry=$resultAccPayAry->toArray();
				 $OutstandingAmt=$resultsettotAmnt[0]['totalAmount']-$resultsetAccPayAry[0]['totalPayOnAccAmt']; 
				
				    if(!$resultset) 
				    {
					  $ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
				    } 
				    else 
				    {
					$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'invoice' =>$finalinvoice,'totAmnt' =>$resultsettotAmnt,'collctAmnt' =>$resultsetcollctAmnt,'Outstanding' =>$OutstandingAmt,'message'=>'Data available'];
				    }
			}else if($param->action=='onaccountdetails') 
			{
			  	$cusid=$param->cusid;
			  	
			  	$qry="SELECT CS.idCustomer,CS.cs_name,CS.cs_mobno,CS.sales_hrchy_name as collmem_code,CS.G1,CS.G2,CS.G3,CS.G4,CS.G5,CS.G6,CS.G7,CS.G8,CS.G9,CS.G10,tm1.geoValue as country,tm2.geoValue as state,tm3.geoValue as city,tm4.geoValue as pincode,tm5.geoValue as region,tm6.geoValue as zone,tm7.geoValue as hub,tm8.geoValue as area,tm9.geoValue as street,tm10.geoValue as outlet from  customer as CS 
			  	LEFT JOIN geography as tm1 ON tm1.idGeography=CS.G1
			LEFT JOIN geography as tm2 ON tm2.idGeography=CS.G2
			LEFT JOIN geography as tm3 ON tm3.idGeography=CS.G3
			LEFT JOIN geography as tm4 ON tm4.idGeography=CS.G4
			LEFT JOIN geography as tm5 ON tm5.idGeography=CS.G5
			LEFT JOIN geography as tm6 ON tm6.idGeography=CS.G6
			LEFT JOIN geography as tm7 ON tm7.idGeography=CS.G7
			LEFT JOIN geography as tm8 ON tm8.idGeography=CS.G8
			LEFT JOIN geography as tm9 ON tm9.idGeography=CS.G9
			LEFT JOIN geography as tm10 ON tm10.idGeography=CS.G10
			  	where CS.idCustomer='$cusid' and cs_status=1";
			   $result=$this->adapter->query($qry,array());
				    $resultset=$result->toArray();

			  $qryinvoice="SELECT ID.invoiceAmt, ID.invoiceNo, DATE_FORMAT(ID.invoiceDate, '%d-%m-%Y') as invoiceDate, ID.idInvoice,CS.sales_hrchy_name,0 as balAmt  from invoice_details as ID 
							LEFT JOIN customer as CS ON CS.idCustomer=ID.idCustomer
							LEFT JOIN team_member_master as SH ON SH.idTeamMember=CS.sales_hrchy_name
							where CS.idCustomer='$cusid'";
					$resultinvoice=$this->adapter->query($qryinvoice,array());
				    $resultsetinvoice=$resultinvoice->toArray();
				    $totalBalAmt=0;
				    for($iCont=0; $iCont<count($resultsetinvoice); $iCont++){

					$amtPayAry="SELECT sum(payAmt-paidAmount) as totalInvoicePayAmt from invoice_payment where idInvoice='".$resultsetinvoice[$iCont]['idInvoice']."'";
					$resultamtPay=$this->adapter->query($amtPayAry,array());
					$resultsetamtPay=$resultamtPay->toArray();

					$resultsetinvoice[$iCont]["balAmt"]=$resultsetinvoice[$iCont]["invoiceAmt"]-$resultsetamtPay[0]["totalInvoicePayAmt"];
					$totalBalAmt+=$resultsetinvoice[$iCont]["balAmt"];
					if($resultsetinvoice[$iCont]["balAmt"]!=0){
						$finalinvoice[]=$resultsetinvoice[$iCont];

					}
				}
				$totAmnt="SELECT sum(invoiceAmt) as totalAmount FROM invoice_details where idCustomer='$cusid'";
				$resulttotAmnt=$this->adapter->query($totAmnt,array());
				$resultsettotAmnt=$resulttotAmnt->toArray();

				$collctAmnt="SELECT sum(payAmt-paidAmount) as collectionAmount FROM invoice_payment where idCustomer='$cusid' and payType='On Account'";
				$resultcollctAmnt=$this->adapter->query($collctAmnt,array());
				$resultsetcollctAmnt=$resultcollctAmnt->toArray();

				$OutstandingAmt=0;
				$amtOnAccPayAry="SELECT sum(payAmt-paidAmount) as totalPayOnAccAmt from invoice_payment where idCustomer='".$resultset[0]['idCustomer']."'";
				$resultAccPayAry=$this->adapter->query($amtOnAccPayAry,array());
				$resultsetAccPayAry=$resultAccPayAry->toArray();

				 $OutstandingAmt=$resultsettotAmnt[0]['totalAmount']-$resultsetAccPayAry[0]['totalPayOnAccAmt']; 
				// print_r($resultset);exit;
				    
				    if(!$resultset) 
				    {
					  $ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
				    } 
				    else 
				    {
					$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'invoice' =>$finalinvoice,'totAmnt' =>$resultsettotAmnt,'collctAmnt' =>$resultsetcollctAmnt,'Outstanding' =>$OutstandingAmt,'message'=>'Data available'];
				    }
			}
		else if($param->action=='addpay') 
     		{
			$fields=$param->Form;
			// print_r($param);exit;
			$idLedger=$fields['accbookNo'];
			// $idMember=$param->idMember;
			//$totamnt=$param->totamnt;
			$collctamnt=$param->collctamnt;
			//$outstanding=$param->outstanding;
			//$remaining=$param->remaining;
			$custid=$param->custid;
			$receiptno=$fields['receiptno'];
			$paymentmode=$fields['paymentmode'];

			$getIdMember="SELECT sales_hrchy_name from customer where idCustomer='$custid'";
			$resultIdMember=$this->adapter->query($getIdMember,array());
			$resultsetIdMember=$resultIdMember->toArray();

			$idMember=$resultsetIdMember[0]['sales_hrchy_name'];
			
			$getIdLedger="SELECT idLedger, recieptNos, usedReciept from ledger_details where idLedger='$idLedger' and recieptNos like '%".$receiptno."%'";
			$resultIdLedger=$this->adapter->query($getIdLedger,array());
			$resultsetIdLedger=$resultIdLedger->toArray();
			// echo $resultsetIdLedger[0]['recieptNos'];
			$getIdLedgerExp=explode(',',$resultsetIdLedger[0]['recieptNos']);
			for ($i=0; $i <count($getIdLedgerExp); $i++) { 
				$checkReceipt=$getIdLedgerExp[$i];
				if ($receiptno!=$checkReceipt ) {
					$recieptNos.=$getIdLedgerExp[$i].',';
				}
				$checkReceipt='';
			}
			$recieptNos=rtrim($recieptNos,",");
			// print_r($recieptNos);
		// 	$recieptNos=str_replace($receiptno, ',', $resultsetIdLedger[0]["recieptNos"]);
			$usedReciept=$resultsetIdLedger[0]["usedReciept"].','.$receiptno;
		
		// echo '->'.$recieptNos;
		// echo "<br>";
		// print_r($usedReciept);

	if($resultsetIdLedger[0]['idLedger']!=""){
	
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {

					$datainsert['collMemCode']=$idMember;
					$datainsert['idCustomer']=$custid;
					$datainsert['payAmt']=$fields['pay'];
					$datainsert['payType']='On Account';
					$datainsert['payMode']=$fields['paymentmode'];
					if($paymentmode=='Cheque'){
					$datainsert['chequeNo']=$fields['txtChequeNo'];
					$datainsert['chequeDate']=date("Y-m-d",strtotime($fields['txtChequeDate']));
					$datainsert['idBank']=$fields['selChequeBank'];
				}elseif ($paymentmode=='Card') {
					$datainsert['cardNo']=$fields['txtCardNo'];
					$datainsert['cardType']=$fields['radCardType'];
					$datainsert['idBank']=$fields['selCardBank'];
				}elseif ($paymentmode=='RTGS' || $paymentmode=='NEFT') {
					$datainsert['referenceNo']=$fields['txtReferNo'];
				}
					
					$datainsert['idLedger']=$idLedger;
					$datainsert['reciptNo']=$fields['receiptno'];
					//print_r($datainsert);exit;
					$insert=new Insert('invoice_payment');
					$insert->values($datainsert);

					$statement=$this->adapter->createStatement();
					$insert->prepareStatement($this->adapter, $statement);
					$insertresult=$statement->execute();

					$dataupdate['recieptNos']=$recieptNos;
					$dataupdate['usedReciept']=$usedReciept;
					$sql = new Sql($this->adapter);
					$update = $sql->update();
					$update->table('ledger_details');
					$update->set($dataupdate);
					$update->where( array('idLedger'=>$idLedger));
					$updatestatement  = $sql->prepareStatementForSqlObject($update);
					$results    = $updatestatement->execute();

					$this->adapter->getDriver()->getConnection()->commit();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
				    } catch (\Exception $e) 
				    {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				     }
				
		  } else{
		  		$ret_arr=['code'=>'3','status'=>false,'message'=>'Invalid receipt number'];
		  }
		}

		else if($param->action=='addbill') 
     		{
			$fields=$param->Form;

			$idLedger=$fields['billbookNo'];
			
			$totamnt=$param->totamnt;
			$collctamnt=$param->collctamnt;
			$invpay=$param->invpay;
			$custid=$param->custid;
			$outstanding=$param->outstanding;
			$remaining=$param->remaining;
			$receiptno=$fields['bill_receiptno'];
			$paymentmode=$fields['bill_paymentmode'];

			$getIdMember="SELECT sales_hrchy_name from customer where idCustomer='$custid'";
			$resultIdMember=$this->adapter->query($getIdMember,array());
			$resultsetIdMember=$resultIdMember->toArray();

			$idMember=$resultsetIdMember[0]['sales_hrchy_name'];

			$getIdLedger="SELECT idLedger, recieptNos, usedReciept from ledger_details where idLedger='$idLedger' and recieptNos like '%".$receiptno."%'";
			$resultIdLedger=$this->adapter->query($getIdLedger,array());
			$resultsetIdLedger=$resultIdLedger->toArray();

			$getIdLedgerExp=explode(',',$resultsetIdLedger[0]['recieptNos']);
			for ($i=0; $i <count($getIdLedgerExp); $i++) { 
				$checkReceipt=$getIdLedgerExp[$i];
				if ($receiptno!=$checkReceipt ) {
					$recieptNos.=$getIdLedgerExp[$i].',';
				}
				$checkReceipt='';
			}
			$recieptNos=rtrim($recieptNos,",");
			// print_r($recieptNos);
		// 	$recieptNos=str_replace($receiptno, ',', $resultsetIdLedger[0]["recieptNos"]);

			$usedReciept=$resultsetIdLedger[0]["usedReciept"].','.$receiptno;
			

			if($resultsetIdLedger[0]['idLedger']!=""){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {

					$invoicePINAry="SELECT ID.invoiceAmt, ID.invoiceNo, ID.invoiceDate, ID.idInvoice,CS.sales_hrchy_name from invoice_details as ID
					LEFT JOIN customer as CS ON CS.idCustomer=ID.idCustomer
					LEFT JOIN team_member_master as SH ON SH.idTeamMember=CS.sales_hrchy_name
					where SH.idTeamMember='$idMember' and CS.idCustomer='$custid'";
					
					$resultinvoice=$this->adapter->query($invoicePINAry,array());
					$resultsetinvoice=$resultinvoice->toArray();
					for($iCont=0;$iCont<count($resultsetinvoice);$iCont++){
						$idInvoice=$resultsetinvoice[$iCont]['idInvoice'];
						
						$datainsert['idInvoice']=$idInvoice;
						$datainsert['collMemCode']=$idMember;
						$datainsert['idCustomer']=$custid;
						$datainsert['payAmt']=$invpay[$iCont];
						$datainsert['pay_date']=date("Y-m-d"); 
						$datainsert['payType']='On Bill';
						$datainsert['payMode']=$fields['bill_paymentmode'];
						if($paymentmode=='Cheque'){
							$datainsert['chequeNo']=$fields['bill_txtChequeNo'];
							$datainsert['chequeDate']=date("Y-m-d",strtotime($fields['bill_txtChequeDate']));
							$datainsert['idBank']=$fields['bill_selChequeBank'];
						}elseif ($paymentmode=='Card') {
							$datainsert['cardNo']=$fields['bill_txtCardNo'];
							$datainsert['cardType']=$fields['bill_radCardType'];
							$datainsert['idBank']=$fields['bill_selCardBank'];
						}elseif ($paymentmode=='RTGS' || $paymentmode=='NEFT') {
							$datainsert['referenceNo']=$fields['bill_txtReferNo'];
						}
						$datainsert['idLedger']=$idLedger;
						$datainsert['reciptNo']=$fields['bill_receiptno'];
					
						
						$insert=new Insert('invoice_payment');
						$insert->values($datainsert);
						$statement=$this->adapter->createStatement();
						$insert->prepareStatement($this->adapter, $statement);
						$insertresult=$statement->execute();
						
					}

					$dataupdate['recieptNos']=$recieptNos;
					$dataupdate['usedReciept']=$usedReciept;
					
					$sql = new Sql($this->adapter);
					$update = $sql->update();
					$update->table('ledger_details');
					$update->set($dataupdate);
					$update->where( array('idLedger'=>$idLedger));
					$updatestatement  = $sql->prepareStatementForSqlObject($update);
					$results    = $updatestatement->execute();

					$this->adapter->getDriver()->getConnection()->commit();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
				} catch (\Exception $e) 
				{
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
				
			} else{
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Invalid receipt number'];
			}
		}
		      
       return $ret_arr;
	}

	public function CollectionSetoff($param)
	{
		$userData=$param->userData;
		$userid=$userData['user_id'];
		$usertype=$userData['user_type'];
		$idCustomer=$userData['idCustomer'];
		if($param->action=='list') 
		  	{
			    $qry="SELECT IP.idInvoice,CS.customer_code, IP.collMemCode, IP.idCustomer, IP.idLedger, IP.reciptNo, (IP.payAmt-IP.paidAmount) as payAmt, IP.idPayment, CS.cs_name,b.credit_note 
						from invoice_payment as IP 
						LEFT JOIN credit_notes_all_types AS b ON IP.idCredit=b.idCredit
						LEFT JOIN customer as CS ON CS.idCustomer=IP.idCustomer 
						where CS.cs_serviceby='$idCustomer' and  payType='On Account'";
						// echo $qry;
			    $result=$this->adapter->query($qry,array());
			    $resultset=$result->toArray();
			    if(!$resultset) 
			    {
				  $ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			    } 
			    else 
			    {
				$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'message'=>'Data available'];
			    }
			}
		else if($param->action=='invoicedetails') 
		  {
			    $cusid=$param->cusid;
			    $payid=$param->payid;
			  	
			  	$qry="SELECT CS.idCustomer,CS.cs_name,CS.cs_mobno,CS.sales_hrchy_name as collmem_code,CS.G1,CS.G2,CS.G3,CS.G4,CS.G5,CS.G6,CS.G7,CS.G8,CS.G9,CS.G10,tm1.geoValue as country,tm2.geoValue as state,tm3.geoValue as city,tm4.geoValue as pincode,tm5.geoValue as region,tm6.geoValue as zone,tm7.geoValue as hub,tm8.geoValue as area,tm9.geoValue as street,tm10.geoValue as outlet from  customer as CS 
			  	LEFT JOIN geography as tm1 ON tm1.idGeography=CS.G1
			LEFT JOIN geography as tm2 ON tm2.idGeography=CS.G2
			LEFT JOIN geography as tm3 ON tm3.idGeography=CS.G3
			LEFT JOIN geography as tm4 ON tm4.idGeography=CS.G4
			LEFT JOIN geography as tm5 ON tm5.idGeography=CS.G5
			LEFT JOIN geography as tm6 ON tm6.idGeography=CS.G6
			LEFT JOIN geography as tm7 ON tm7.idGeography=CS.G7
			LEFT JOIN geography as tm8 ON tm8.idGeography=CS.G8
			LEFT JOIN geography as tm9 ON tm9.idGeography=CS.G9
			LEFT JOIN geography as tm10 ON tm10.idGeography=CS.G10
			  	where CS.idCustomer='$cusid'";
			    $result=$this->adapter->query($qry,array());
			    $resultset=$result->toArray();
			 $invoiceAmtAry="SELECT invoiceAmt, invoiceNo, DATE_FORMAT(invoiceDate, '%d-%m-%Y') as invoiceDate,idInvoice,0 as balAmt from invoice_details where idCustomer='$cusid'";
			   $resultinvoice=$this->adapter->query($invoiceAmtAry,array());
			    $resultsetinvoice=$resultinvoice->toArray();

			    $paymentAmtAry="SELECT (payAmt-paidAmount) as payAmt from invoice_payment where idPayment='$payid'";
			    $resultpayment=$this->adapter->query($paymentAmtAry,array());
			    $resultsetpayment=$resultpayment->toArray();
			    $payment=$resultsetpayment[0]['payAmt'];

			    for($iCont=0; $iCont<count($resultsetinvoice); $iCont++){
			    	$invoice=$resultsetinvoice[$iCont]['idInvoice'];
						$amtPayAry="SELECT sum(payAmt-paidAmount) as totalInvoicePayAmt from invoice_payment where idInvoice='$invoice'";
					
						  $resultamtPay=$this->adapter->query($amtPayAry,array());
			    $resultsetamtPay=$resultamtPay->toArray();
					$resultsetinvoice[$iCont]['balAmt']=$resultsetinvoice[$iCont]["invoiceAmt"]-$resultsetamtPay[0]["totalInvoicePayAmt"];
					}

			    if(!$resultset) 
			    {
				  $ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			    } 
			    else 
			    {
				$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset ,'invoice' =>$resultsetinvoice,'payment' =>$payment,'message'=>'Data available'];
			    }
		     }
	else if($param->action=='add') 
	{
		$fields=$param->Form;

		$idPayment=$param->idPayment;
		$array1=$param->array1;

				
		$paymentAmtAry="SELECT payAmt, idCustomer, collMemCode, idLedger, reciptNo, payMode, chequeNo, chequeDate, idBank, cardNo, cardType from invoice_payment where idPayment='$idPayment'";
		$resultIdLedger=$this->adapter->query($paymentAmtAry,array());
		$resultsetIdLedger=$resultIdLedger->toArray();

		$custid=$resultsetIdLedger[0]['idCustomer'];

		$invoiceAmtAry="SELECT invoiceAmt, invoiceNo, DATE_FORMAT(invoiceDate, '%d-%m-%Y') as invoiceDate, idInvoice from invoice_details where idCustomer='$custid'";
		$resultinvoiceAmt=$this->adapter->query($invoiceAmtAry,array());
		$resultsetinvoiceAmt=$resultinvoiceAmt->toArray();
 $ttlPaid=0;

		if($resultsetIdLedger){
			$this->adapter->getDriver()->getConnection()->beginTransaction();
			try {
				for($iCont=0; $iCont<count($resultsetinvoiceAmt); $iCont++)
				{
				$idInvoice=$resultsetinvoiceAmt[$iCont]["idInvoice"];
				if($array1[$iCont]!="" && $array1[$iCont]!=0){
	
				$datainsert['idInvoice']=$idInvoice;
				$datainsert['collMemCode']=$resultsetIdLedger[0]['collMemCode'];
				$datainsert['idCustomer']=$resultsetIdLedger[0]['idCustomer'];
				$datainsert['pay_date']=date("Y-m-d");
				$datainsert['payAmt']=$array1[$iCont];
				$datainsert['payType']='On Bill';
				$datainsert['idLedger']=$resultsetIdLedger[0]['idLedger'];
				$datainsert['reciptNo']=$resultsetIdLedger[0]['reciptNo'];
				$datainsert['payMode']=$resultsetIdLedger[0]['payMode'];
				$datainsert['chequeNo']=$resultsetIdLedger[0]['chequeNo'];
				$datainsert['chequeDate']=$resultsetIdLedger[0]['chequeDate'];
				$datainsert['idBank']=$resultsetIdLedger[0]['idBank'];
				$datainsert['cardNo']=$resultsetIdLedger[0]['cardNo'];
				$datainsert['cardType']=$resultsetIdLedger[0]['cardType'];

				$insert=new Insert('invoice_payment');
				$insert->values($datainsert);
				$statement=$this->adapter->createStatement();
				$insert->prepareStatement($this->adapter, $statement);
				$insertresult=$statement->execute();

                $ttlPaid=$ttlPaid+$array1[$iCont];



				}
			}
				

				$dataupdate['paidAmount']=$ttlPaid;
				$dataupdate['entryDateTime']=date("Y-m-d H:i:s");
				$sql = new Sql($this->adapter);
				$update = $sql->update();
				$update->table('invoice_payment');
				$update->set($dataupdate);
				$update->where( array('idPayment'=>$idPayment));
				$updatestatement  = $sql->prepareStatementForSqlObject($update);
				$results    = $updatestatement->execute();

				// $delete = new Delete('invoice_payment');
    //             $delete->where(['idPayment=?' => $idPayment]);
    //             $deletestatement=$this->adapter->createStatement();
    //             $delete->prepareStatement($this->adapter, $deletestatement);
    //             $resultset=$deletestatement->execute();

				$this->adapter->getDriver()->getConnection()->commit();
				$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
			    } catch (\Exception $e) 
			    {
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
				$this->adapter->getDriver()->getConnection()->rollBack();
			     }
				
		} else{
		  		$ret_arr=['code'=>'3','status'=>false,'message'=>'Invalid receipt number'];
			}
		}
		     return $ret_arr;
	}

	public function updatebook($param)
	{
       $bookno=$param->bookno;
       $bookfrom=$param->bookfrom;
       $bookto=$param->bookto;
       $id=$param->id;

       $this->adapter->getDriver()->getConnection()->beginTransaction();
				try {

				
					$dataupdate['ledgerNo']=$bookno;
					$dataupdate['recieptFromNo']=$bookfrom;
					$dataupdate['recieptToNo']=$bookto;
					$sql = new Sql($this->adapter);
					$update = $sql->update();
					$update->table('ledger_book');
					$update->set($dataupdate);
					$update->where( array('idLedgerBook'=>$id));
					$updatestatement  = $sql->prepareStatementForSqlObject($update);
					$results    = $updatestatement->execute();

					$this->adapter->getDriver()->getConnection()->commit();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
				    } catch (\Exception $e) 
				    {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				     }

				     return $ret_arr;
	}

	public function deletebook($param)
	{
       	$deleteid=$param->id;
      
		$this->adapter->getDriver()->getConnection()->beginTransaction();
		try {

		$delete = new Delete('ledger_book');
        $delete->where(['idLedgerBook=?' => $deleteid]);
        $deletestatement=$this->adapter->createStatement();
        $delete->prepareStatement($this->adapter, $deletestatement);
        $resultset=$deletestatement->execute();
		$this->adapter->getDriver()->getConnection()->commit();
		$ret_arr=['code'=>'2','status'=>true,'message'=>'Deleted successfully'];
	    } catch (\Exception $e) 
	    {
		$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
		$this->adapter->getDriver()->getConnection()->rollBack();
	     }

	     return $ret_arr;
	}

	public function state_list($param)
	{
       $qry="SELECT idTerritory,territoryValue FROM territory_master A where A.idTerritoryTitle='2'";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		if(!$resultset) {
		$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		}  else {
		$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
		}
		return $ret_arr;
	}
	public function customerleave($param)
	{
		if($param->action=='list'){
		 	$qry="SELECT A.IdCompanyleave as id,A.IdState, DATE_FORMAT(A.leave_date, '%d-%m-%Y') as leave_date,A.remarks,A.status,B.territoryValue as state FROM company_leave AS A LEFT JOIN territory_master AS B ON B.idTerritory=A.IdState";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
			$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			}  else {
			$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
	 	}else if($param->action=='add'){
      		$fields=$param->Form;
      		$userid=$param->userid;
       		$this->adapter->getDriver()->getConnection()->beginTransaction();
			try {
		
				$datainsert['IdState']=$fields['state'];
				$datainsert['leave_date']=date('Y-m-d',strtotime($fields['leavedate']));
				$datainsert['remarks']=$fields['remarks'];
				$datainsert['status']=$fields['status'];
				$datainsert['created_by']=$userid;
				$datainsert['created_at']=date('Y-m-d H:i:s');
				$datainsert['updated_by']=$userid;
				$datainsert['updated_at']=date('Y-m-d H:i:s');
				$insert=new Insert('company_leave');
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
			} elseif($param->action=='editview'){
				$editid=$param->id;
		 	$qry="SELECT A.IdCompanyleave as id,A.IdState as leave_state, DATE_FORMAT(A.leave_date, '%d-%m-%Y') as leave_date,A.remarks as leave_remarks,A.status as leavestatus,B.territoryValue as state FROM company_leave AS A LEFT JOIN territory_master AS B ON B.idTerritory=A.IdState
		 	WHERE A.IdCompanyleave='$editid'";
		 
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
			$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			}  else {
			$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
	 	}else if($param->action=='update'){
      		$fields=$param->Form;
      		$editid=$fields['id'];
       		$this->adapter->getDriver()->getConnection()->beginTransaction();
			try {
		
				$dataupdate['IdState']=$fields['leave_state'];
				$dataupdate['leave_date']=date('Y-m-d',strtotime($fields['leave_date']));
				$dataupdate['remarks']=$fields['leave_remarks'];
				$dataupdate['status']=$fields['leavestatus'];
				$datainsert['updated_by']=$userid;
				$datainsert['updated_at']=date('Y-m-d H:i:s');

				$sql = new Sql($this->adapter);
				$update = $sql->update();
				$update->table('company_leave');
				$update->set($dataupdate);
				$update->where( array('IdCompanyleave'=>$editid));
				$updatestatement  = $sql->prepareStatementForSqlObject($update);
				$results    = $updatestatement->execute();

				$this->adapter->getDriver()->getConnection()->commit();
				$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
			    } catch (\Exception $e) 
			    {
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
				$this->adapter->getDriver()->getConnection()->rollBack();
			     }
			}
		return $ret_arr;
	}
	public function getempname($param)
	{
		$id=$param->id;
		$qry="SELECT T1.name as empname,T1.idTeamMember as id  FROM  team_member_master AS T1  WHERE T1.code=? AND T1.status=?";

		$result=$this->adapter->query($qry,array($id,1));
		$resultset=$result->toArray();
		
		if(!$resultset)
		{
			$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		} 
		else 
		{
			$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
		}
		return $ret_arr;
	}
		public function employeeleave($param)
		{
			if($param->action=='list'){
			 	$qry="SELECT A.*,B.name as empname,B.code as empcode,DATE_FORMAT(A.from_date, '%d-%m-%Y') AS from_date,DATE_FORMAT(A.to_date, '%d-%m-%Y') AS to_date
			 	FROM  employee_leave AS A 
			 	LEFT JOIN team_member_master AS B ON B.idTeamMember=A.idTeamMember";
				$result=$this->adapter->query($qry,array());
				$resultset=$result->toArray();
				if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
				}  else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
				}
		 	}else if($param->action=='add'){

	      		$fields=$param->Form;
	      		$fdate=$fields['leavefromdate'];
				$startdate = trim(preg_replace('/\s*\([^)]*\)/', '', $fdate));
				$from_date=date('Y-m-d', strtotime($startdate));

				$tdate=$fields['leavetodate'];
				$endDate = trim(preg_replace('/\s*\([^)]*\)/', '', $tdate));
				$to_date=date('Y-m-d', strtotime($endDate));
				
				$checkfrom=date('d-m-Y', strtotime($startdate));
				$checkto=date('d-m-Y', strtotime($endDate));
	            $fromdate=(strtotime($checkfrom));
	            $todate=(strtotime($checkto));

	            if($fromdate > $todate){
	            	$ret_arr=['code'=>'3','status'=>false,'message'=>'To date must be greater than or equal to from date'];
	            }
	            /*else if($todate == $fromdate ){
	            	$ret_arr=['code'=>'3','status'=>false,'message'=>'To date must be greater than from date'];
	            }*/
	            else{
	       		$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['idTeamMember']=$param->empid;
					$datainsert['from_date']=date('Y-m-d',strtotime($fields['leavefromdate']));
					$datainsert['to_date']=date('Y-m-d',strtotime($fields['leavetodate']));
					$datainsert['remarks']=$fields['remarks'];
					$datainsert['status']=$fields['status'];
					$datainsert['created_by']=$param->userid;
					$datainsert['created_at']=date("Y-m-d H:i:s");;
					
					$insert=new Insert('employee_leave');
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
				} elseif($param->action=='editview'){
					$editid=$param->id;
			 	$qry="SELECT A.idTeamMember, A.IdEmployeeLeave AS id, DATE_FORMAT(A.from_date, '%d-%m-%Y') AS from_date, DATE_FORMAT(A.to_date, '%d-%m-%Y') AS to_date, A.remarks, A.status, B.name as empname,B.code as empcode 
			 	FROM  employee_leave AS A 
			 	LEFT JOIN team_member_master AS B ON B.idTeamMember=A.idTeamMember
			 	WHERE A.IdEmployeeLeave='$editid'";
			 
				$result=$this->adapter->query($qry,array());
				$resultset=$result->toArray();
				if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
				}  else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
				}
		 	}else if($param->action=='update'){
	      		$empid=$param->empid;
	      		$fields=$param->Form;
	      		$editid=$fields['id'];
	      		$fdate=$fields['from_date'];
				$startdate = trim(preg_replace('/\s*\([^)]*\)/', '', $fdate));
				$from_date=date('Y-m-d', strtotime($startdate));

				$tdate=$fields['to_date'];
				$endDate = trim(preg_replace('/\s*\([^)]*\)/', '', $tdate));
				$to_date=date('Y-m-d', strtotime($endDate));
				
				$checkfrom=date('d-m-Y', strtotime($startdate));
				$checkto=date('d-m-Y', strtotime($endDate));
	            $fromdate=(strtotime($checkfrom));
	            $todate=(strtotime($checkto));

	            if($fromdate > $todate){
	            	$ret_arr=['code'=>'3','status'=>false,'message'=>'To date must be greater than or equal to from date'];
	            }
	            /*else if($todate == $fromdate ){
	            	$ret_arr=['code'=>'3','status'=>false,'message'=>'To date must be greater than from date'];
	            }*/
	            else{
	       		$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
			
					$dataupdate['idTeamMember']=($empid=='')?$fields['idTeamMember']:$empid;
					$dataupdate['from_date']=date('Y-m-d',strtotime($fields['from_date']));
					$dataupdate['to_date']=date('Y-m-d',strtotime($fields['to_date']));
					$dataupdate['remarks']=$fields['remarks'];
					$dataupdate['status']=$fields['status'];
					$dataupdate['updated_by']=$param->userid;
					$dataupdate['updated_at']=date("Y-m-d H:i:s");;
					$sql = new Sql($this->adapter);
					$update = $sql->update();
					$update->table('employee_leave');
					$update->set($dataupdate);
					$update->where( array('IdEmployeeLeave'=>$editid));
					$updatestatement  = $sql->prepareStatementForSqlObject($update);
					$results    = $updatestatement->execute();

					$this->adapter->getDriver()->getConnection()->commit();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
				    } catch (\Exception $e) 
				    {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				     }
				}
			}
			return $ret_arr;
		}

		public function PJPdefinition($param)
		{
			if($param->action=='list'){
			 	$qry="SELECT A.idpjpdetail,A.idSalesHierarchy,A.idTeamMember,A.idLevel,A.cycle_days,DATE_FORMAT(A.start_date, '%d-%m-%Y') AS start_date,B.name as empname,C.saleshierarchyName as slname,D.custType as cstype
			 	FROM  pjp_detail AS A 
			 	LEFT JOIN team_member_master AS B ON B.idTeamMember=A.idTeamMember
			 	LEFT JOIN sales_hierarchy AS C ON C.idSaleshierarchy=A.idSalesHierarchy
			 	LEFT JOIN customertype AS D ON D.idCustomerType=A.idLevel";
				$result=$this->adapter->query($qry,array());
				$resultset=$result->toArray();
				if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
				}  else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
				}
		 	}else if($param->action=='delete_servicecustomer'){
		 		$editid=$param->editid;
				$deletesub=$param->deletesub;
				$userid=$param->userid;
				$fdate=$param->fdate;
				$user_type=$param->user_type;
				//$cusid=$deletesub[0]['idCustomer'];
				
				$cydate=date("Y-m-d", strtotime($fdate));

			 	$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {

					for ($i=0; $i <count($deletesub) ; $i++) { 
					if($deletesub[$i]['status']==""){
						$cusid= $deletesub[$i]['idCustomer'];
						$delete = new Delete('pjp_detail_list');
				        $delete->where(['idpjpdetail=?' => $editid, 'idCustomer=?' => $cusid,'cycle_day=?' => $cydate]);
				        $deletestatement=$this->adapter->createStatement();
				        $delete->prepareStatement($this->adapter, $deletestatement);
				        $resultset=$deletestatement->execute();
					}
				}

				
				$this->adapter->getDriver()->getConnection()->commit();
				$ret_arr=['code'=>'2','status'=>true,'message'=>'Deleted successfully'];
			    } catch (\Exception $e) 
			    {
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
				$this->adapter->getDriver()->getConnection()->rollBack();
			     }

		 	}
		 	else if($param->action=='get_servicecustomer') {
				$editid=$param->editid;
				$cusid=$param->cusid;
				$userid=$param->userid;
				$fdate=$param->fdate;
				$user_type=$param->user_type;
				$cydate=date("Y-m-d", strtotime($fdate));

				$qry="SELECT CS.idCustomer,CS.cs_name,'' as status,'' as chkdates ,0 as checkedcount FROM customer AS CS
				WHERE CS.cs_serviceby='$cusid'and CS.cs_status=1";
				
				$result=$this->adapter->query($qry,array());
				$resultset=$result->toArray();

				
			$subcheckedcount=0;
			for($i=0; $i<count($resultset); $i++){
				$cus=$resultset[$i]['idCustomer'];
				$qrysubedit="SELECT c.idCustomer,DATE_FORMAT(c.cycle_day, '%d-%m-%Y') AS cycle_day FROM pjp_detail_list as c
					where c.idpjpdetail='$editid' AND c.cycle_day='$cydate' AND c.idCustomer='$cus'";
				$resultsubedit=$this->adapter->query($qrysubedit,array());
				$resultsetsubedit=$resultsubedit->toArray();
				if($resultsetsubedit){
					$resultset[$i]['status']=true;
					$subcheckedcount=$subcheckedcount+1;
					$resultset[0]['checkedcount']=$subcheckedcount;
				}
				
		
					
				}

		
				if(!$resultset) {
					$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
				} else {
					$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
				}
			}else if($param->action=='PJP_edit'){
		 		$editid=$param->editid;
			 	$qryedit="SELECT A.idpjpdetail,A.idSalesHierarchy as sales_hierarchy,A.idTeamMember as employee,A.idLevel as cust_type,A.cycle_days as cycledays,DATE_FORMAT(A.start_date, '%d-%m-%Y') AS startdate,B.name as empname,C.saleshierarchyName as slname,D.custType as cstype
			 	FROM  pjp_detail AS A 
			 	LEFT JOIN team_member_master AS B ON B.idTeamMember=A.idTeamMember
			 	LEFT JOIN sales_hierarchy AS C ON C.idSaleshierarchy=A.idSalesHierarchy
			 	LEFT JOIN customertype AS D ON D.idCustomerType=A.idLevel WHERE A.idpjpdetail='$editid'";
				$resultedit=$this->adapter->query($qryedit,array());
				$resultsetedit=$resultedit->toArray();

				

				$salesshr=$resultsetedit[0]['sales_hierarchy'];
				$employee=$resultsetedit[0]['employee'];
				$custype=$resultsetedit[0]['cust_type'];
				$cycledays=$resultsetedit[0]['cycledays'];
				$startdate=$resultsetedit[0]['startdate'];
				$lastrowdate=array();
				$firstrowdate=array();
				$checkdate=array();
	            $chkcount=0;
	            $countdate=array();
			for($k=0;$k<$cycledays;$k++)
			{
				$getAddDate=date('d-m-Y', strtotime($startdate.'+1 day'));
				$getAddDay=date('D', strtotime($getAddDate));
				$startdate=date('d-M',strtotime($getAddDate));
				$convertdate=date('Y-m-d', strtotime($startdate));
				$count_date=date('Y-m-d', strtotime($startdate.'+1 day'));
				
				
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
						array_push($countdate,$count_date);
                         $checkbox[$chkcount]['date']=$getAddDate;
                         $checkbox[$chkcount]['status']=false;
                         $checkbox[$chkcount]['subcount']=0;
                        
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


			$qrysubedit="SELECT c.idCustomer,DATE_FORMAT(c.cycle_day, '%d-%m-%Y') AS cycle_day FROM pjp_detail_list as c
					where c.idpjpdetail='$editid'";
			$resultsubedit=$this->adapter->query($qrysubedit,array());
			$resultsetsubedit=$resultsubedit->toArray();

				for($i=0; $i<count($resultset); $i++){
					$resultset[$i]['checkdate']=$checkbox;
					$cus=$resultset[$i]['idCustomer'];
					$qrycus="SELECT COUNT(idCustomer) as customers FROM customer WHERE cs_serviceby='$cus'";

					$resultcus=$this->adapter->query($qrycus,array());
					$resultsetcus=$resultcus->toArray();

					$resultset[$i]['servicecustomer']=$resultsetcus[0]['customers'];

					$qrycusdata="SELECT idCustomer,cs_name,'' as checkdate FROM customer WHERE cs_serviceby='$cus'";
				$resultcusdata=$this->adapter->query($qrycusdata,array());
				$resultsetcusdata=$resultcusdata->toArray();
                   for ($k=0; $k < count($resultsetcusdata); $k++) 
                   { 
                   	  $resultsetcusdata[$k]['checkdate']=$checkbox;
                   }
				$resultset[$i]['subcustomer']=$resultsetcusdata;
					
					$chkdt=$resultset[$i]['checkdate'];
					for ($k=0; $k <COUNT($resultsetsubedit); $k++) { 
					if($resultset[$i]['idCustomer']==$resultsetsubedit[$k]['idCustomer']){
						for ($j=0; $j <COUNT($resultset[$i]['checkdate']) ; $j++) { 
							if ($resultset[$i]['checkdate'][$j]['date'] == $resultsetsubedit[$k]['cycle_day']) {
							$resultset[$i]['checkdate'][$j]['status']=true;
							}
						}
					}

					for ($sub=0; $sub <COUNT($resultset[$i]['subcustomer']) ; $sub++) { 

					if($resultset[$i]['subcustomer'][$sub]['idCustomer']==$resultsetsubedit[$k]['idCustomer']){
						$cnt=0;
						for ($chk=0; $chk <COUNT($resultset[$i]['subcustomer'][$sub]['checkdate']) ; $chk++) { 
							if ($resultset[$i]['subcustomer'][$sub]['checkdate'][$chk]['date'] == $resultsetsubedit[$k]['cycle_day']) {
							$resultset[$i]['subcustomer'][$sub]['checkdate'][$chk]['status']=true;
							$cnt=$cnt+1;
							$resultset[$i]['checkdate'][$chk]['subcount']=$cnt;
							}
						}

					}
				}

					
				}
			}
			
			for($i=0; $i<count($resultset); $i++){
				
					$custid=$resultset[$i]['idCustomer'];
					
					$qrysub="SELECT count(c.idCustomer) as cust_count FROM pjp_detail_list as c
					where c.idpjpdetail='$editid'  AND c.idCustomer='$custid'";
				$resultsub=$this->adapter->query($qrysub,array());
				$resultsetsub=$resultsub->toArray();
				$resultset[$i]['checkcount']=$resultsetsub[0]['cust_count'];

				$qrysub1="SELECT c.cycle_day as cust_count FROM pjp_detail_list as c
					where c.idpjpdetail='$editid'  AND c.idCustomer IN (SELECT idCustomer FROM customer WHERE cs_serviceby='$custid') GROUP BY c.cycle_day";
					//echo $qrysub1;
				$resultsub1=$this->adapter->query($qrysub1,array());
				$resultsetsub1=$resultsub1->toArray();
				$scbc=0;
				for ($m=0; $m <count($resultsetsub1) ; $m++) { 
					$scbc=$scbc+1;
				}
				$resultset[$i]['checksubcount']=$scbc;
				
				
			}
			for($i=0; $i<count($resultset); $i++){
				for($i=0; $i<count($checkbox); $i++){
					$chkdate=$checkbox[$i]['date'];
					$chk_date=date('Y-m-d', strtotime($chkdate));
					$qrysub2="SELECT count(c.idCustomer) as cust_count FROM pjp_detail_list as c
					where c.idpjpdetail='$editid'  AND c.cycle_day='$chk_date'";
					
				$resultsub2=$this->adapter->query($qrysub2,array());
				$resultsetsub2=$resultsub2->toArray();
				$lastrow[$i]=$resultsetsub2[0]['cust_count'];

				}
			}
			//	print_r($resultset);
			
				
				/*for($i=0; $i<count($resultset); $i++){

				}*/
				if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
				}  else {
				$ret_arr=['code'=>'2','editcontent'=>$resultsetedit,'lastrow'=>$lastrow,'content'=>$resultset,'lastrowdate'=>$lastrowdate,'firstrowdate'=>$firstrowdate,'checkdate'=>$checkdate,'checkbox'=>$checkbox,'status'=>true,'message'=>'Record available'];
				}
		 	}
		 	return $ret_arr;
		}

		public function ReorderReport($param){
			if($param->action=='get_customerLevel'){
			 	$qry="SELECT idCustomerType,custType FROM customertype AS A WHERE A.status=1";
				$result=$this->adapter->query($qry,array());
				$resultset=$result->toArray();
				if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
				}  else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
				}
			}else if($param->action=='get_customer'){
				$levelid=$param->levelid;
			 	$qry="SELECT idCustomer,cs_name FROM customer AS A WHERE A.cs_status=1 AND A.cs_type='$levelid'";
				$result=$this->adapter->query($qry,array());
				$resultset=$result->toArray();
				if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
				}  else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
				}
			}else if($param->action=='get_warehouse'){
				$cusid=$param->cusid;
			 	$qry="SELECT idWarehouse,warehouseName FROM warehouse_master AS A WHERE A.status=1 AND A.idCustomer='$cusid'";
				$result=$this->adapter->query($qry,array());
				$resultset=$result->toArray();
				if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
				}  else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
				}
			}else if($param->action=='add'){
				$fields=$param->Form;

			 	$qry="SELECT P.*,S.primarypackname,PS.productSize,PS.productPrimaryCount,PS.idProductsize,P.productCount,0 as reorder_lvl,0 as reorder_qty,(
					CASE
					WHEN P.productCount = 1 THEN 'Units'
					WHEN P.productCount = 2 THEN 'kg'
					WHEN P.productCount = 3 THEN 'gm'
					WHEN P.productCount = 4 THEN 'mgm'
					WHEN P.productCount = 5 THEN 'mts'
					WHEN P.productCount = 6 THEN 'cmts'
					WHEN P.productCount = 7 THEN 'inches'
					WHEN P.productCount = 8 THEN 'foot'
					WHEN P.productCount = 9 THEN 'litre'
					WHEN P.productCount = 10 THEN 'ml'

					END) as unitmeasure FROM product_details AS P
						LEFT JOIN product_size AS PS ON P.idProduct =PS.idProduct
						LEFT JOIN primary_packaging AS S ON S.idPrimaryPackaging =PS.idPrimaryPackaging
						WHERE P.status=1 AND PS.status=1";
				$result=$this->adapter->query($qry,array());
				$resultset=$result->toArray();

				for ($i=0; $i <count($resultset) ; $i++) { 
				$prod_id=$resultset[$i]['idProduct'];	
				$prod_sizid=$resultset[$i]['idProductsize'];	
				$re_lvl="SELECT re_level,re_qty FROM inventorynorms WHERE idWarehouse='".$fields['warehouse']."' AND idProduct='".$prod_id."' AND idProdSize='".$prod_sizid."' AND idCustomer='".$fields['customer']."'  AND idLevel='".$fields['cust_type']."' ";
				
				$result_re_lvl=$this->adapter->query($re_lvl,array());
				$resultset_re_lvl=$result_re_lvl->toArray();
				
				$resultset[$i]['reorder_lvl']=$resultset_re_lvl[0]['re_level'];
				$resultset[$i]['reorder_qty']=$resultset_re_lvl[0]['re_qty'];
				}

				for ($i=0; $i < count($resultset); $i++) { 
				$idWarehouse=$fields['warehouse'];
				$prodId=$resultset[$i]['idProduct'];
				$sizId=$resultset[$i]['idProductsize'];
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

				if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
				}  else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
				}
			}
			return $ret_arr;
		}
		public function MRPchargesReport($param){
			if($param->action=='list'){
				$fields=$param->Form;
			 	$qry="SELECT DISTINCT PRC.idPricefixing,PRC.idProduct,PRC.idProductsize,PRC.idTerritory,0 as priceAmount,0 as oldAmount,LOC.territoryValue,PRO.productName,PRO.productCount,SIZE.productSize,PKG.primarypackname,SIZE.productPrimaryCount,(
					CASE
					WHEN PRO.productCount = 1 THEN 'Units'
					WHEN PRO.productCount = 2 THEN 'kg'
					WHEN PRO.productCount = 3 THEN 'gm'
					WHEN PRO.productCount = 4 THEN 'mgm'
					WHEN PRO.productCount = 5 THEN 'mts'
					WHEN PRO.productCount = 6 THEN 'cmts'
					WHEN PRO.productCount = 7 THEN 'inches'
					WHEN PRO.productCount = 8 THEN 'foot'
					WHEN PRO.productCount = 9 THEN 'litre'
					WHEN PRO.productCount = 10 THEN 'ml'

					END) as unitmeasure
					FROM price_fixing AS PRC 
					LEFT JOIN territory_master AS LOC ON PRC.idTerritory=LOC.idTerritory 
					LEFT JOIN product_details AS PRO ON PRC.idProduct=PRO.idProduct 
					LEFT JOIN product_size AS SIZE ON PRC.idProductsize=SIZE.idProductsize 
					LEFT JOIN primary_packaging AS PKG ON SIZE.idPrimaryPackaging=PKG.idPrimaryPackaging 
					WHERE PRC.idTerritory=".$fields['subterritory']." 
					AND (DATE_FORMAT(PRC.priceDate,'%Y-%m-%d') 
					BETWEEN '".date('Y-m-d', strtotime($fields['startdate']))."' AND '".date('Y-m-d', strtotime($fields['lastdate'] . ' +1 day'))."') 
					 GROUP BY idProductsize 
					";
					
				$result=$this->adapter->query($qry,array());
				$resultset=$result->toArray();
				
				for ($i=0; $i <count($resultset); $i++) { 


					

				$qryold="SELECT DISTINCT PRC.idPricefixing,PRC.idProduct,PRC.idProductsize,PRC.idTerritory,DATE_FORMAT( PRC.priceDate,'%d-%m-%Y') as priceDate,PRC.priceAmount,ROUND((PRC.priceAmount+(PRC.priceAmount*gm.gstValue/100)),2)  as MRPamount
				FROM price_fixing AS PRC 
				LEFT JOIN product_details AS pd ON PRC.idProduct=pd.idProduct
				LEFT JOIN gst_master as gm ON gm.idHsncode=pd.idHsncode
				WHERE PRC.idTerritory=".$fields['subterritory']." 
				AND PRC.idProduct=".$resultset[$i]['idProduct']." 
				AND PRC.idProductsize=".$resultset[$i]['idProductsize']." 
				AND (DATE_FORMAT(PRC.priceDate,'%Y%m%d') 
				BETWEEN '".date('Ymd', strtotime($fields['startdate']))."' AND '".date('Ymd', strtotime($fields['lastdate'] . ' +1 day'))."')  ORDER BY PRC.idPricefixing DESC LIMIT 2";
				
				
				$resultold=$this->adapter->query($qryold,array());
				$resultsetold=$resultold->toArray();
				$resultset[$i]['priceAmount']=$resultsetold[0]['priceAmount'];
				$resultset[$i]['MRPamount']=$resultsetold[0]['MRPamount'];
				$resultset[$i]['oldAmount']=$resultsetold[1]['priceAmount'];
				$resultset[$i]['priceDate']=$resultsetold[0]['priceDate'];

				}
				
				if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
				}  else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
				}
			}
			return $ret_arr;
		}

		public function ProductExpiryReport($param){
			if($param->action=='list'){
				$fields=$param->Form;
				$custid=$param->idCustomer;
			 	$qry="SELECT w.idProduct,w.idProdSize,DATE_FORMAT( w.sku_expiry_date,'%d-%m-%Y') as sku_expiry_date,ps.productSize,p.productName,pt.primarypackname,DATE_FORMAT( w.sku_mf_date,'%d-%m%-%Y') as sku_mf_date,w.sku_batch_no,ps.productPrimaryCount,p.productCount,(
					CASE
					WHEN p.productCount = 1 THEN 'Units'
					WHEN p.productCount = 2 THEN 'kg'
					WHEN p.productCount = 3 THEN 'gm'
					WHEN p.productCount = 4 THEN 'mgm'
					WHEN p.productCount = 5 THEN 'mts'
					WHEN p.productCount = 6 THEN 'cmts'
					WHEN p.productCount = 7 THEN 'inches'
					WHEN p.productCount = 8 THEN 'foot'
					WHEN p.productCount = 9 THEN 'litre'
					WHEN p.productCount = 10 THEN 'ml'

					END) as unitmeasure
			 		FROM whouse_stock_items AS w 
 					LEFT JOIN whouse_stock AS ws ON ws.idWhStock=w.idWhStock
					LEFT JOIN product_details AS p ON p.idProduct=w.idProduct 
					LEFT JOIN product_size AS ps ON ps.idProductsize=w.idProdSize
					LEFT JOIN primary_packaging AS pt ON pt.idPrimaryPackaging=ps.idPrimaryPackaging
					WHERE ws.idCustomer='$custid' AND w.sku_expiry_date BETWEEN '".date('Y-m-d',strtotime($fields['startdate']))."' AND '".date('Y-m-d',strtotime($fields['lastdate']))."' ";

				$result=$this->adapter->query($qry,array());
				$resultset=$result->toArray();
				if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
				}  else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
				}
			}
			return $ret_arr;
		}

		public function WarehouseStockListReport($param){
			if($param->action=='warehouselist'){
				$custid=$param->idCustomer;
				$qry="SELECT w.idWarehouse,w.warehouseName
				FROM warehouse_master AS w 
				WHERE w.idCustomer='$custid'";

				$result=$this->adapter->query($qry,array());
				$resultset=$result->toArray();
				if(!$resultset) {
					$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
				}  else {
					$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
				}
			}else if($param->action=='add'){
				$custid=$param->idCustomer;
				$usertype=$param->user_type;
				$fields=$param->Form;
				$warid=$fields['warehouse'];


				$qrypoqty="SELECT t2.idWhStock,t2.idWarehouse,t3.idProduct,t6.primarypackname,t3.idProdSize,SUM(t3.sku_accept_qty) AS qty,t4.productName,t5.productSize,t5.idPrimaryPackaging,t5.productPrimaryCount,t4.productCount,0 as opening_balance,0 as availqty,0 as issueQty 
				FROM whouse_stock as t2
				LEFT JOIN whouse_stock_items as t3 ON t3.idWhStock=t2.idWhStock
				LEFT JOIN product_details as t4 ON t4.idProduct=t3.idProduct
				LEFT JOIN product_size as t5 ON t5.idProductsize=t3.idProdSize
				LEFT JOIN primary_packaging as t6 ON t6.idPrimaryPackaging=t5.idPrimaryPackaging
				WHERE t2.idCustomer='$idCustomer' AND t2.idWarehouse='$warid' AND t4.status=1 AND t5.status=1  GROUP BY idProductsize";


				$resultpoqty=$this->adapter->query($qrypoqty,array());
				$resultset=$resultpoqty->toArray();
				
				//Calculate Opening Balance

			/*	for ($i=0; $i < count($resultset); $i++) { 
					$rtnOp=array();
					$disPatchQtyOp=array();
					$disRplcQtyOp=array();
					$disMissQtyOp=array();
					$idWarehouse=$resultset[$i]['idWarehouse'];
					$prodId=$resultset[$i]['idProduct'];
					$sizId=$resultset[$i]['idProdSize'];
					$whStkItm="SELECT sum(sku_accept_qty) AS qtyCnt FROM whouse_stock_items 
					WHERE idProduct = '".$prodId."' AND idProdSize= '".$sizId."' AND idWarehouse ='".$fields['warehouse']."' AND DATE_FORMAT(sku_entry_date,'%Y%m%d') < '".date('Ymd', strtotime($fields['startdate']))."'";
					
					$resultwhStkItm=$this->adapter->query($whStkItm,array());
					$resultsetwhStkItm=$resultwhStkItm->toArray();

					
					$cstReturnQty="SELECT  COR.rtnQty  from customer_order_return as COR
					LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
					LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
					LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
					LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
					WHERE WHSI.idProduct = '".$prodId."' AND WHSI.idProdSize= '".$sizId."' AND WHSI.idWarehouse ='".$fields['warehouse']."' AND DATE_FORMAT(COR.rtnDate,'%Y%m%d')< '".date('Ymd', strtotime($fields['startdate']))."'";
					
					
					$resultcstReturnQty=$this->adapter->query($cstReturnQty,array());
					$resultsetcstReturnQty=$resultcstReturnQty->toArray();
					if(0<count($resultsetcstReturnQty)){
						for($i=0;$i<count($resultsetcstReturnQty);$i++){
							array_push($rtnOp,$resultsetcstReturnQty[$i]['rtnQty']);
						}
					}
					
					$dispatchQty="SELECT  DPB.qty  from dispatch_product_batch as DPB 
					LEFT JOIN dispatch_product as DP ON DP.idDispatchProduct=DPB.idDispatchProduct 
					LEFT JOIN dispatch_customer as DC ON DC.idDispatchcustomer=DP.idDispatchcustomer 
					LEFT JOIN dispatch_vehicle as DV ON DV.idDispatchVehicle=DC.idDispatchVehicle 
					LEFT JOIN orders as O ON O.idOrder=DC.idOrder 
					LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
					WHERE WHSI.idProduct = '".$prodId."' AND WHSI.idProdSize= '".$sizId."' AND WHSI.idWarehouse ='".$fields['warehouse']."' AND DV.deliveryDate <'".date('Y-m-d', strtotime($fields['startdate']))."'";
					
					$resultdispatchQty=$this->adapter->query($dispatchQty,array());
					$resultsetdispatchQty=$resultdispatchQty->toArray();
					if(0<count($resultsetdispatchQty)){
						for($i=0;$i<count($resultsetdispatchQty);$i++){
							array_push($disPatchQtyOp,$resultsetdispatchQty[$i]['qty']);
						}
					}

				}*/
				

				
				

				if(!$resultset) {
					$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
				}  else {
					$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
				}
			}
			return $ret_arr;

		}

	}