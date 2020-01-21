<?php
namespace Sales\V1\Rest\Team;
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
use DateTime;
use Sales\V1\Rest\CommonFunctions\CommonFunctionsMapper;






class TeamMapper {

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
	public function handlingcharges($param) {
		if($param->action=='list') {
				$userid=$param->userid;
				    $qryHandle="SELECT `PackageCount` FROM `handling_charges_master`";
					$resultHandle=$this->adapter->query($qryHandle,array());
					$resultsetHandle=$resultHandle->toArray();
					$alreadyhave=0;
					if (count($resultsetHandle)>0) 
					{
						for ($i=0; $i < count($resultsetHandle); $i++) 
						{ 
							if ($resultsetHandle[$i]['PackageCount']!='') 
							{
							  $alreadyhave=1;
							  break;
							}
						}
					}
					

					$qry="SELECT  idAgency,agencyName  FROM agency_master WHERE status='1'";
					$result=$this->adapter->query($qry,array());
					$resultset=$result->toArray();
				if($resultset!=null) {
					for($i=0;$i<count($resultset);$i++) {
						$qrypack="SELECT  *  FROM primary_packaging a where a.status='1'";
						$resultpack=$this->adapter->query($qrypack,array());
						$resultsetpack=$resultpack->toArray();
						$idAgency=$resultset[$i]['idAgency'];
						for($j=0;$j<count($resultsetpack);$j++) {
							$idPrimaryPackaging=$resultsetpack[$j]['idPrimaryPackaging'];
							$qrychargemaster="SELECT  *  FROM handling_charges_master a where a.idAgency=? and a.packaging_type=? and a.idPackaging=?";
							$resultchargemaster=$this->adapter->query($qrychargemaster,array($idAgency,'1',$idPrimaryPackaging));
							$resultsetchargemaster=$resultchargemaster->toArray();
							$resultset[$i]['idPrimary'.$idAgency.$idPrimaryPackaging]="$j";
							$resultsetpack[$j]['package_name']="RAK_".$idPrimaryPackaging.$idAgency;
							if(!$resultsetchargemaster) {
							$resultsetpack[$j]['package_value']="";
							$resultsetpack[$j]['handling_id']="";
							} else {
							$resultsetpack[$j]['package_value']=$resultsetchargemaster[0]['PackageCount'];
							$resultsetpack[$j]['handling_id']=$resultsetchargemaster[0]['idHandlingCharges'];
							}
							$resultsetpack[$j]['idAgency']="$idAgency";
						}
						$resultset[$i]['package']=$resultsetpack;
						$qrypack2="SELECT  *  FROM secondary_packaging a where a.status='1'";
						$resultpack2=$this->adapter->query($qrypack2,array());
						$resultsetpack2=$resultpack2->toArray();
						for($j=0;$j<count($resultsetpack2);$j++) {
							$idSecondaryPackaging=$resultsetpack2[$j]['idSecondaryPackaging'];
							$qrysecondary="SELECT  *  FROM handling_charges_master a where a.idAgency=? and a.packaging_type=? and a.idPackaging=?";
							$resultsecondary=$this->adapter->query($qrysecondary,array($idAgency,'2',$idSecondaryPackaging));
							$resultsetsecondary=$resultsecondary->toArray();
							$resultset[$i]['idSecondary'.$idAgency.$idSecondaryPackaging]="$j";
							$resultsetpack2[$j]['package_name']="RAK_".$idSecondaryPackaging.$idAgency;
							if(!$resultsetsecondary) {
							$resultsetpack2[$j]['package_value']="";
							$resultsetpack2[$j]['handling_id']="";
							} else {
							$resultsetpack2[$j]['package_value']=$resultsetsecondary[0]['PackageCount'];
							$resultsetpack2[$j]['handling_id']=$resultsetsecondary[0]['idHandlingCharges'];
							}
							$resultsetpack2[$j]['idAgency']="$idAgency";
						}
						$resultset[$i]['package_two']=$resultsetpack2;
					}
				}
				
				if($resultset){
					$ret_arr=['code'=>'1','content'=>$resultset,'AlreadyData'=>$alreadyhave,'status'=>true,'message'=>'No of records'.count($resultset)];
				} else {
					$ret_arr=['code'=>'2','content'=>'','status'=>false,'message'=>'No records to view'];
				}
			} else {
				$ret_arr=['code'=>'3','content'=>'','status'=>false,'message'=>'Please contact the administrator'];
			}
			return $ret_arr;
	}  
	public function add_handlingCharge($param) {
		$multi_records=$param->multi_records;
		if($param->action=='add') {
		for ($i = 0; $i < count($multi_records); $i++) {
			$idAgency=$multi_records[$i]['idAgency'];
			$package=$multi_records[$i]['package'];
			$package_two=$multi_records[$i]['package_two'];
		$this->adapter->getDriver()->getConnection()->beginTransaction();
		for ($j = 0; $j < count($package); $j++) {
			$idHandlingCharges=$package[$j]['handling_id'];
			if($idHandlingCharges=="") {
			try {
				$datainsert['idAgency'] = $package[$j]['idAgency'];
				$datainsert['packaging_type'] ="1";
				$datainsert['PackageCount'] = $package[$j]['package_value'];
				$datainsert['idPackaging'] = $package[$j]['idPrimaryPackaging'];
				$datainsert['created_at'] = date('Y-m-d H:i:s');
				$datainsert['created_by'] = $param->userid;
				$insert = new Insert('handling_charges_master');
				$insert->values($datainsert);
				$statement = $this->adapter->createStatement();
				$insert->prepareStatement($this->adapter, $statement);
				$insertresult = $statement->execute();
			} catch (\Exception $e) {
				$error_catch = 1;
			}
		} else {
			try {
				$dataupdate['PackageCount'] = $package[$j]['package_value'];
				$sql = new Sql($this->adapter);
				$update = $sql->update();
				$update->table('handling_charges_master');
				$update->set($dataupdate);
				$update->where(array('idHandlingCharges' =>$idHandlingCharges));
				$statement = $sql->prepareStatementForSqlObject($update);
				$results = $statement->execute();
			} catch (\Exception $e) {
				$error_catch = 1;
			}
		}
		}
		if ($error_catch) {
			 return $result = ['success' => '2', 'message' => 'Please try again'.$e];
			$this->adapter->getDriver()->getConnection()->rollBack();
		} else {
			$result = ['success' => '1', 'message' => 'Added successfully'];
			$this->adapter->getDriver()->getConnection()->commit();
		}
		$this->adapter->getDriver()->getConnection()->beginTransaction();
		for ($j = 0; $j < count($package_two); $j++) {
			$idHandlingCharges=$package_two[$j]['handling_id'];
			if($idHandlingCharges==null) {
			try {
				$datainsert['idAgency'] = $package_two[$j]['idAgency'];
				$datainsert['packaging_type'] ="2";
				$datainsert['PackageCount'] = $package_two[$j]['package_value'];
				$datainsert['idPackaging'] = $package_two[$j]['idSecondaryPackaging'];
				$datainsert['created_at'] = date('Y-m-d H:i:s');
				$datainsert['created_by'] = $param->userid;
				$insert = new Insert('handling_charges_master');
				$insert->values($datainsert);
				$statement = $this->adapter->createStatement();
				$insert->prepareStatement($this->adapter, $statement);
				$insertresult = $statement->execute();
			} catch (\Exception $e) {
				$error_catch = 1;
			}
			} else {
			try {
				$dataupdate['PackageCount'] = $package_two[$j]['package_value'];
				$sql = new Sql($this->adapter);
				$update = $sql->update();
				$update->table('handling_charges_master');
				$update->set($dataupdate);
				$update->where(array('idHandlingCharges' =>$idHandlingCharges));
				$statement = $sql->prepareStatementForSqlObject($update);
				$results = $statement->execute();
			} catch (\Exception $e) {
				$error_catch = 1;
			}
			}
		}
		if ($error_catch) {
			return $ret_arr=['code'=>'1','status'=>false,'message' => 'Please try again'.$e];
			$this->adapter->getDriver()->getConnection()->rollBack();
		} else {
			$ret_arr=['code'=>'1','status'=>true,'message' => 'Added successfully'];
			$this->adapter->getDriver()->getConnection()->commit();
		}
		}
	  } else {
		$ret_arr=['code'=>'1','status'=>false,'message'=>'API not working, Please try again'];
	  }
	  return $ret_arr;
	}
		public function employee_details($param) {
		if($param->action=='list') {
		$qry="SELECT A.*,B.tm_group_id,B.tm_group_name,C.name AS reporting_manager, D.name AS reporting_manager2,E.name AS reporting_manager3,C.idTeamMember AS reporting_manager_id,des.name as designationName,mg.mainGroupName,sgm.subsidaryName,S.saleshierarchyName 
FROM team_member_master AS A 
LEFT JOIN team_member_groups B ON B.tm_group_id=A.designation 
LEFT JOIN team_member_master C ON C.idTeamMember=A.reportingTo 
LEFT JOIN team_member_master D ON D.idTeamMember=A.reportingTo2 
LEFT JOIN team_member_master E ON E.idTeamMember=A.reportingTo3 
LEFT JOIN designation as des on des.idDesignation=A.designation 
LEFT JOIN maingroup_master as mg on mg.idMainGroup=A.idMainGroup 
LEFT JOIN subsidarygroup_master as sgm on sgm.idSubsidaryGroup=A.idSubsidaryGroup
LEFT JOIN sales_hierarchy AS S on S.idSaleshierarchy=A.idSaleshierarchy";
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
		$ret_arr=['code'=>'1','status'=>true,'message'=>'Employee details','content' =>$resultset,'contentlist1'=>$resultset1,'contentlist2'=>$resultset2,'contentlist3'=>$resultset3,'contentlist4'=>$resultset4,'contentlist5'=>$resultset5,'contentlist6'=>$resultset6,'contentlist7'=>$resultset7,'contentlist8'=>$resultset8,'contentlist9'=>$resultset9,'contentlist10'=>$resultset10];
		} else {
			$ret_arr=['code'=>'2','status'=>false,'message'=>'parameter missing, try again!!!'];
		}
	}
		return $ret_arr;
	}
	public function add_team_allocation($param) {
		if($param->action=='add') {
		
		$territory_id=$param->territory;
		$subterritory_ids=($param->territory_select)?implode(',', $param->territory_select):'';
		$category_ids=($param->category)?implode(',', $param->category):'';
		$channel_ids=($param->channel)?implode(',', $param->channel):'';
		$customer_ids=($param->customer)?implode(',', $param->customer):'';
		$idTeamMember=$param->idTeamMember;
		$qryidTeamMember="SELECT  *  FROM team_member_allocation a where a.team_member_id=?";
		$resultidTeamMember=$this->adapter->query($qryidTeamMember,array($idTeamMember));
		$resultsetidTeamMember=$resultidTeamMember->toArray();
		if($resultsetidTeamMember!=null) {
			$this->adapter->getDriver()->getConnection()->beginTransaction();
			try {
				$datainsert['team_member_id']=$idTeamMember;
				$datainsert['territory_id']=$territory_id;
				$datainsert['subterritory_ids']=$subterritory_ids;
				$datainsert['channel_id']=$channel_ids;
				$datainsert['category_id']=$category_ids;
				$datainsert['customer_ids']=$customer_ids;
				$sql = new Sql($this->adapter);
				$update = $sql->update();
				$update->table('team_member_allocation');
				$update->set($datainsert);
				$update->where(array('team_member_id' =>$idTeamMember));
				$statement = $sql->prepareStatementForSqlObject($update);
				$results = $statement->execute();
				$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
				$this->adapter->getDriver()->getConnection()->commit();
			}catch(\Exception $e) {
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
				$this->adapter->getDriver()->getConnection()->rollBack();
			}
		} else {
		$this->adapter->getDriver()->getConnection()->beginTransaction();
			try {
				$datainsert['team_member_id']=$idTeamMember;
				$datainsert['territory_id']=$territory_id;
				$datainsert['subterritory_ids']=$subterritory_ids;
				$datainsert['channel_id']=$channel_ids;
				$datainsert['category_id']=$category_ids;
				$datainsert['customer_ids']=$customer_ids;
				$datainsert['created_by']=$param->userid;
				$datainsert['created_at']=date('Y-m-d H:i:s');
				$insert=new Insert('team_member_allocation');
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
		} else {
			$ret_arr=['code'=>'1','status'=>false,'message'=>'API not working, Please try again'];
		}
		return $ret_arr;
	}
	public function list_branch($param) {
		if($param->action=='list') {
		$idTeamMember=$param->idTeamMember;
		$result=$this->get_unserialize($param->idTeamMember,'account_ids');
		$selected_account=$result[0];
		$qry="SELECT  a.idAccount as id,a.personName,a.company,false as 'checked'  FROM account_master a  WHERE a.status='1'";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		for($i=0;$i<count($resultset);$i++) {
			$id=$resultset[$i]['id'];
			if(in_array("$id", $selected_account)) {
				$resultset[$i]['checked']=true;
			}
		}
		if(!$resultset) {
			$ret_arr=['code'=>'2','status'=>false,'message'=>'No records found'];
		} else {
			$ret_arr=['code'=>'1','status'=>true,'message'=>'Branch details list','content' =>$resultset];
		}
		} else {
			$ret_arr=['code'=>'1','status'=>false,'message'=>'API not working, Please try again'];
		}
		return $ret_arr;
	}
	public function get_assigned($param) {
		$employee_details=$param->employee;
		$idTeamMember=$employee_details['idTeamMember'];
		if($param->action=="get") {
				$qry="SELECT  *  FROM team_member_allocation a  WHERE a.team_member_id=?";
				$result=$this->adapter->query($qry,array($idTeamMember));
				$resultset=$result->toArray();
				$subterritory_ids=unserialize($resultset[0]['subterritory_ids']);
				$subterritoryids=$subterritory_ids[0];
				$channel_id=unserialize($resultset[0]['channel_id']);
				$channelid=$channel_id[0];
				$category_id=unserialize($resultset[0]['category_id']);
				$categoryid=$category_id[0];
				$account_ids=unserialize($resultset[0]['account_ids']);
				$accountids=$account_ids[0];
				if(!$resultset) {
					$ret_arr=['code'=>'2','status'=>false,'message'=>'No records found'];
				} else {
					$ret_arr=['code'=>'1','status'=>true,'message'=>'Branch details list','content' =>$resultset,
					'territory_id' =>$resultset[0]['territory_id'],
					'subterritoryids'=>$subterritoryids,
					'channelid' =>$channelid,
					'categoryid' =>$categoryid,
					'accountids'=>$accountids
					];
				}
		} else {
			$ret_arr=['code'=>'1','status'=>false,'message'=>'API not working, Please try again'];
		}
		return $ret_arr;
	}
	public function get_territory_select($param) {
		if($param->action=='subterritorylist') {
			$territoryid=$param->idterritory;
			$idTeamMember=$param->idTeamMember;
			$subterritoryids=$this->get_unserialize($idTeamMember,'subterritory_ids');
			$subterrity=$subterritoryids[0];
			$t1qry="SELECT 	idTerritory,idTerritoryTitle,territoryCode,territoryValue FROM `territory_master` WHERE status=1 AND idTerritoryTitle='$territoryid'";
			$t1result=$this->adapter->query($t1qry,array());
			$t1resultset=$t1result->toArray();
				for($i=0;$i<count($t1resultset);$i++) {
					if($t1resultset[$i]['idTerritory']==$subterrity[$i]) {
						$t1resultset[$i]['checked']=true;
					} else {
						$t1resultset[$i]['checked']=false;
					}
				}
				if(!$t1resultset) {
				$ret_arr=['code'=>'1','status'=>false,'message'=>'No data available..'];
			} else {
			$ret_arr=['code'=>'2','status'=>true,'content' =>$t1resultset,'message'=>'data available'];
			}
		}
		return $ret_arr;
	}
	function get_unserialize($idTeamMember,$ids) {
		$qry="SELECT  a.$ids  FROM team_member_allocation a  WHERE a.team_member_id=?";
		$result=$this->adapter->query($qry,array($idTeamMember));
		$resultset=$result->toArray();
		if(!$resultset) {
			return false;
		} else {
			return unserialize($resultset[0]["$ids"]);
		}
	}
	public function get_selected_records($param) {
		$idTeamMember=$param->idTeamMember;
		if($param->action=="get") {
			$qry="SELECT  a.channel_id,a.category_id  FROM team_member_allocation a  WHERE a.team_member_id=?";
			$result=$this->adapter->query($qry,array($idTeamMember));
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'2','status'=>false,'message'=>'API not working, Please try again'];
			} else {
				$result=unserialize($resultset[0]["channel_id"]);
				$category=unserialize($resultset[0]["category_id"]);
			}
			$ret_arr=['code'=>'1','status'=>true,'message'=>'records are found','content' =>$result[0],'category'=>$category[0]];
		} else {
			$ret_arr=['code'=>'2','status'=>false,'message'=>'API not working, Please try again'];
		}
		return $ret_arr;
	}
	public function get_category($param) {
		if($param->action=='catlist') {
               $qry="SELECT idCategory,category,'false' as 'checked' FROM `category` WHERE status=1";
			    $result=$this->adapter->query($qry,array());
				$resultset=$result->toArray();
				$result=$this->get_unserialize($param->idTeamMember,'category_id');
				$category_select=$result[0];
			    if(!$resultset) {
				  $ret_arr=['code'=>'2','status'=>false,'message'=>'Please try again..'];
			    } else {
					for($i=0;$i<count($resultset);$i++) {
						$id=$resultset[$i]['idCategory'];
						if(in_array("$id", $category_select)) {
							$resultset[$i]['checked']='true';
						}
					}
				$ret_arr=['code'=>'1','status'=>true,'content' =>$resultset,'message'=>'System config information'];
			    }
		   } else {
			$ret_arr=['code'=>'2','status'=>false,'message'=>'API not working, Please try again'];
		   }
		   return $ret_arr;
	}
	public function get_customer($param) {
		if($param->action=='customerlist') {
            $qry="SELECT idCustomer,customer_code,cs_name,'false' as 'checked' FROM `customer` WHERE cs_status=1";
		    $result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();				 
			$result=$this->get_unserialize($param->idTeamMember,'customer_ids');
			$customer_select=$result[0];
		    if(!$resultset) {
			  $ret_arr=['code'=>'2','status'=>false,'message'=>'Please try again..'];
		    } else {
				for($i=0;$i<count($resultset);$i++) {
					$id=$resultset[$i]['idCustomer'];
					if(in_array("$id", $customer_select)) {
						// $resultset[$i]['checked']='true';
						$resultscheck[]=$resultset[$i]['idCustomer'];
					}
				}
			$ret_arr=['code'=>'1','status'=>true,'content' =>$resultset,'checkedId'=>$resultscheck,'message'=>'System config information'];
		    }
		} else {
			$ret_arr=['code'=>'2','status'=>false,'message'=>'API not working, Please try again'];
		}
		return $ret_arr;
	}

	public function team_assign_details($param)
	{
        if($param->action=="list")
        {

			$channel_list=array(array('id'=> '1', 'name'=> 'General Trade', 'checked'=> false) ,
			array('id'=> '2', 'name'=> 'Modern Trade', 'checked'=> false ),
			array('id'=> '3', 'name'=> 'Online', 'checked'=> false ),
			array( 'id'=> '4', 'name'=> 'B2C Direct', 'checked'=> false ),
			array('id'=> '5', 'name'=> 'B2B', 'checked'=> false ),
			array( 'id'=> '6', 'name'=> 'Government', 'checked'=> false ),
			array('id'=> '7', 'name'=> 'Institutions', 'checked'=> false ),
			array( 'id'=> '8', 'name'=> 'Franchisee', 'checked'=> false ),
			array('id'=> '9', 'name'=> 'Own', 'checked'=> false ));
        	//get customer data
            $qrycustomer="SELECT idCustomer,customer_code,cs_name FROM `customer` WHERE cs_status=1";
		    $resultcustomer=$this->adapter->query($qrycustomer,array());
			$resultsetcustomer=$resultcustomer->toArray();	

			  $qrycategory="SELECT idCategory,category FROM `category` WHERE status=1";
		    $resultcategory=$this->adapter->query($qrycategory,array());
			$resultsetcategory=$resultcategory->toArray();	
            
             $qryterritorytitle="SELECT *FROM `territorytitle_master` WHERE title!='' ";
		    $resultterritorytitle=$this->adapter->query($qryterritorytitle,array());
			$resultsetterritorytitle=$resultterritorytitle->toArray();

			

			 $qryallocation="SELECT allocation_id,team_member_id,territory_id,subterritory_ids,channel_id,category_id,customer_ids FROM `team_member_allocation` WHERE team_member_id=?";
		    $resultallocation=$this->adapter->query($qryallocation,array($param->idTeamMember));
			$resultsetallocation=$resultallocation->toArray();
			$territoryCheckcount=0;
			$categoryCheckcount=0;
			$channelCheckcount=0;
			$customerCheckcount=0;
			if(count($resultsetallocation)>0)
			{
				$checkeCatid=($resultsetallocation[0]['category_id'])?explode(',',$resultsetallocation[0]['category_id']):'';

				$checkeChannelid=($resultsetallocation[0]['channel_id'])?explode(',',$resultsetallocation[0]['channel_id']):'';

				$checkeCustomerid=($resultsetallocation[0]['customer_ids'])?explode(',',$resultsetallocation[0]['customer_ids']):'';

				$checkeTerritoryid=$resultsetallocation[0]['territory_id'];

				$checkesubTerritoryid=($resultsetallocation[0]['subterritory_ids'])?explode(',',$resultsetallocation[0]['subterritory_ids']):'';

				 $qryterritory="SELECT idTerritory,territoryValue FROM `territory_master` WHERE status=1 AND idTerritoryTitle=?";
		    $resultterritory=$this->adapter->query($qryterritory,array($checkeTerritoryid));
			$resultsetterritory=$resultterritory->toArray();

				 if(count($resultsetcategory)>0)
				 {
				 	for ($i=0; $i < count($resultsetcategory); $i++) 
                   {
                   	  $resultsetcategory[$i]['checked']=false;
                   }

                   for ($i=0; $i < count($resultsetcategory); $i++) 
                   { 
                   	  for ($j=0; $j < count($checkeCatid); $j++) 
                   	  { 
                   	     if($resultsetcategory[$i]['idCategory']==$checkeCatid[$j])
                   	     {
                           $resultsetcategory[$i]['checked']=true; 
                           
			$categoryCheckcount=$categoryCheckcount+1;
			
                   	     }
                   	  }
                   }
				 }

				 if(count($resultsetcustomer)>0)
				 {
				 	for ($i=0; $i < count($resultsetcustomer); $i++) 
                   {
                   	  $resultsetcustomer[$i]['checked']=false;
                   }
                   
                   for ($i=0; $i < count($resultsetcustomer); $i++) 
                   { 
                   	  for ($j=0; $j < count($checkeCustomerid); $j++) 
                   	  { 
                   	     if($resultsetcustomer[$i]['idCustomer']==$checkeCustomerid[$j])
                   	     {
                           $resultsetcustomer[$i]['checked']=true; 
                          
			$customerCheckcount=$customerCheckcount+1;
                   	     }
                   	  }
                   }
				 }

				 if(count($resultsetterritory)>0)
				 {
				 	for ($i=0; $i < count($resultsetterritory); $i++) 
                   {
                   	  $resultsetterritory[$i]['checked']=false;
                   }
                   for ($i=0; $i < count($resultsetterritory); $i++) 
                   { 
                   	  for ($j=0; $j < count($checkesubTerritoryid); $j++) 
                   	  { 
                   	     if($resultsetterritory[$i]['idTerritory']==$checkesubTerritoryid[$j])
                   	     {
                           $resultsetterritory[$i]['checked']=true; 
                           $territoryCheckcount=$territoryCheckcount+1;
                   	     }
                   	  }
                   }
				 }
                 if(count($channel_list)>0)
				 {
                   for ($i=0; $i < count($channel_list); $i++) 
                   { 
                   	  for ($j=0; $j < count($checkeChannelid); $j++) 
                   	  { 
                   	     if($channel_list[$i]['id']==$checkeChannelid[$j])
                   	     {
                           $channel_list[$i]['checked']=true; 
                            $channelCheckcount=$channelCheckcount+1;
                   	     }
                   	  }
                   }
				 }
				 

              
			}
			else
			{
				$checkeTerritoryid=0;
				$checkeCatid=[];
				$checkeChannelid=[];
				$checkeCustomerid=[];				
				$checkesubTerritoryid=[];
			}

			$ret_arr=['code'=>'2',
              'status'=>true,
              'category'=>$resultsetcategory,
              'subterritory'=>$resultsetterritory,
              'selectterritory'=>$checkeTerritoryid,
              'territorytitle'=>$resultsetterritorytitle,
              'customer'=>$resultsetcustomer,
              'channel'=>$channel_list,
              'checkedcustomer'=>$checkeCustomerid,
              'checkedcatid'=>$checkeCatid,
              'checkedchannelid'=>$checkeChannelid,
              'checkedsubterritory'=>$checkesubTerritoryid,
              'catCount'=>$categoryCheckcount,
              'teriCount'=>$territoryCheckcount,
			   'channelCount'=>$channelCheckcount,
			  'cusCount'=>$customerCheckcount,
              'message'=>'Data available...'];
			
        }
       
        return $ret_arr;
	}

	public function getDesignation($param) 
	{
		$qry="SELECT * FROM `designation` WHERE status=1";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		if(count($resultset)>0){
		$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];

		}  else {
		$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			
		}
		return $ret_arr;
	}
	function picklist($param){
		if ($param->action=='list') {
			$qry="SELECT T1.idOrderallocate AS id, T1.idWarehouse, T1.status AS status, T2.poNumber AS poNo, DATE_FORMAT(T2.poDate,'%d-%m-%Y') AS poDate, T4.fulfillmentName AS fullfillment, T3.cs_name AS customerName, 1  AS OrderStatus,T5.warehouseName AS Whouse
					FROM orders_allocated AS T1 
					LEFT JOIN orders AS T2 ON T1.idOrder = T2.idOrder
					LEFT JOIN customer AS T3 ON T3.idCustomer = T2.idCustomer
					LEFT JOIN fulfillment_master AS T4 ON T4.idFulfillment = T2.idOrderfullfillment
					LEFT JOIN warehouse_master AS T5 ON T5.idWarehouse = T1.idWarehouse
					";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();

			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}
		}elseif($param->action=='picklistData'){
			$allocateId=$param->allocateId;
			$qry="SELECT T1.idOrderallocate AS id, T1.idWarehouse, T1.status AS status,T2.idOrder,ordi.idOrderitem,ordi.orderQty,ordi.idProduct,ordi.idProductsize, DATE_FORMAT(T1.created_at, '%d-%m-%Y') AS allocatedDate, T2.idCustomer ,T2.poNumber AS poNo, DATE_FORMAT(T2.poDate, '%d-%m-%Y') AS OrderedDate, T4.fulfillmentName AS fullfillment, T3.cs_name AS customerName, T5.warehouseName AS Whouse
					FROM orders_allocated AS T1 
					LEFT JOIN orders AS T2 ON T1.idOrder = T2.idOrder
                    LEFT JOIN order_items as ordi ON ordi.idOrder=T2.idOrder
					LEFT JOIN customer AS T3 ON T3.idCustomer = T2.idCustomer
					LEFT JOIN fulfillment_master AS T4 ON T4.idFulfillment = T2.idOrderfullfillment 
					LEFT JOIN warehouse_master AS T5 ON T5.idWarehouse = T1.idWarehouse
					WHERE T1.idOrderallocate=?";
			$result=$this->adapter->query($qry,array($allocateId));
			$resultset=$result->toArray();
		
			$subAry="SELECT T1.idOrderallocated, 
			T1.idOrderallocateditems, 
			T1.idProduct, 
			T1.idProductsize,
			T1.pickqty, 
			T1.picklistQty, 
			T2.productName AS productName, 
			T2.productCount, 
			T4.primarypackname, 
			T3.productSize ,
			T1.dispatchQty,
			'0' as orderQty, 
			'0' as pqty,'0' as status, 
			'0' as idOrderitem,
			'0' as idOrder
					FROM orders_allocated_items AS T1 
					LEFT JOIN product_details AS T2 ON T2.idProduct=T1.idProduct
					LEFT JOIN product_size AS T3 ON T3.idProductsize=T1.idProductsize
					LEFT JOIN primary_packaging AS T4 ON T3.idPrimaryPackaging=T4.idPrimaryPackaging
					WHERE T1.idOrderallocated='".$allocateId."'";
			$resultSubQry=$this->adapter->query($subAry,array());
			$resultsetSubQry=$resultSubQry->toArray();	

			
            for ($i=0; $i <count($resultsetSubQry) ; $i++) 
            { 

            	$pid=$resultsetSubQry[$i]['idProduct'];
            	$psid=$resultsetSubQry[$i]['idProductsize'];
            	
                 // get order qty and dispatch status
            	$qryOrderqty="SELECT T1.idOrderallocate AS id, 
            	T1.idWarehouse, 
            	T1.status AS status,
            	T2.idOrder,
            	ordi.idOrderitem,
            	ordi.orderQty,
            	ordi.idProduct,
            	ordi.idProductsize 
            	FROM orders_allocated AS T1 
            	LEFT JOIN orders AS T2 ON T1.idOrder = T2.idOrder 
            	LEFT JOIN order_items as ordi ON ordi.idOrder=T2.idOrder 
            	WHERE T1.idOrderallocate='$allocateId' AND ordi.idProduct='$pid' AND ordi.idProductsize='$psid'";
				$resultOrderqty=$this->adapter->query($qryOrderqty,array());
				$resultsetOrderqty=$resultOrderqty->toArray(); 
                
				$resultsetSubQry[$i]['orderQty']=$resultsetOrderqty[0]['orderQty']; 
				$resultsetSubQry[$i]['status']=$resultsetOrderqty[0]['status']; 
				$resultsetSubQry[$i]['idOrderitem']=$resultsetOrderqty[0]['idOrderitem'];
				$resultsetSubQry[$i]['idOrder']=$resultsetOrderqty[0]['idOrder']; 
                //pick qty
                $qryPickqty="SELECT sum(pickQty) as pickQty FROM `order_picklist_items` WHERE idAllocateOrder='$allocateId' AND idProduct='$pid' AND idProdSize='$psid'";
				$resultPickqty=$this->adapter->query($qryPickqty,array());
				$resultsetPickqty=$resultPickqty->toArray(); 
				$resultsetSubQry[$i]['pqty']=$resultsetPickqty[0]['pickQty']; 
     
            	
            	$qryAlreadyDispatch="SELECT dc.idWarehouse,dc.idOrderallocate,dc.idOrder,dp.idProduct,dp.idProdSize,dp.idOrderItem,dp.dis_Qty FROM `dispatch_customer` as dc LEFT JOIN dispatch_product as dp on dp.idDispatchcustomer=dc.idDispatchcustomer WHERE dc.idOrderallocate='$allocateId' and dp.idProduct='$pid' and dp.idProdSize='$psid'";
				$resultAlreadyDispatch=$this->adapter->query($qryAlreadyDispatch,array());
				$resultsetAlreadyDispatch=$resultAlreadyDispatch->toArray();

				$qryAlreadyPicklist="SELECT idOrder,idAllocateOrder,idAllocateItem,idWarehouse,idWhStockItem,idProduct,idProdSize,pickQty FROM `order_picklist_items` WHERE  idAllocateOrder='$allocateId' and idProduct='$pid' and idProdSize='$psid'";
				$resultAlreadyPicklist=$this->adapter->query($qryAlreadyPicklist,array());
				$resultsetAlreadyPicklist=$resultAlreadyPicklist->toArray();
				if ($resultsetAlreadyDispatch[0]['idOrderallocate']!=$resultsetAlreadyPicklist[0]['idAllocateOrder']) 
				{
					$resultsetSubQry[$i]['pickqty']=$resultsetAlreadyPicklist[0]['pickQty'];
				}
            }
			
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'productData'=>$resultsetSubQry,'status'=>true,'message'=>'Record available'];
			}
		}elseif($param->action=='whouseItemsData'){
			$productId=$param->productId;
			$productSize=$param->productSize;
			$whouseId=$param->whouseId;
			$userData=$param->userData;
			$idCustomer=$userData['idCustomer'];
			$idLevel=$userData['user_type'];
            $idOrderallocate=$param->idOrderallocate;
            $idallocateitem=$param->idallocateitem;
			$qryWHstock="SELECT idWhStockItem, 
			sku_accept_qty, 
			idProduct,
			idProdSize,
			idWarehouse,
			DATE_FORMAT(sku_mf_date, '%d-%m-%Y') as mDate, 
			DATE_FORMAT(sku_expiry_date, '%d-%m-%Y') as eDate, 
			sku_batch_no AS batchNo,
			'0' as availQty 
			FROM whouse_stock_items WHERE idProduct='".$productId."' AND idProdSize='".$productSize."' AND idWarehouse='".$whouseId."' AND sku_expiry_date>now() AND idCustomer='".$idCustomer."' and idLevel='".$idLevel."'";
			$resultWHstock=$this->adapter->query($qryWHstock,array());
			$resultsetWHstock=$resultWHstock->toArray();

			for ($i=0; $i < count($resultsetWHstock); $i++) 
			{ 
				//total accept and  return qty
				$qryWHreturn="SELECT WSI.sku_accept_qty AS totalAcceptQty, SUM(COR.rtnQty) AS totalProReturn FROM whouse_stock_items AS WSI LEFT JOIN dispatch_product_batch AS DPB ON DPB.idWhStockItem=WSI.idWhStockItem LEFT JOIN customer_order_return AS COR ON COR.idDispatchProductBatch=DPB.idDispatchProductBatch WHERE WSI.idWhStockItem='".$resultsetWHstock[$i]['idWhStockItem']."'";
				$resultWHreturn=$this->adapter->query($qryWHreturn,array());
				$resultsetWHreturn=$resultWHreturn->toArray();
				// total accept and damage qty
				$qryWHdamage="SELECT WSI.sku_accept_qty AS totalAcceptQty, SUM(WSD.dmg_prod_qty) AS totalDmgProQty FROM whouse_stock_items AS WSI LEFT JOIN whouse_stock_damge AS WSD ON WSD.idWhStockItem=WSI.idWhStockItem WHERE WSI.idWhStockItem='".$resultsetWHstock[$i]['idWhStockItem']."'";
				$resultWHdamage=$this->adapter->query($qryWHdamage,array());
				$resultsetWHdamage=$resultWHdamage->toArray();
				// dispatch qty
				$qryWHdispatch="SELECT WSI.idWhStockItem , SUM(DPB.qty) AS totalProDispatch FROM whouse_stock_items AS WSI  LEFT JOIN dispatch_product_batch AS DPB ON DPB.idWhStockItem=WSI.idWhStockItem WHERE WSI.idWhStockItem='".$resultsetWHstock[$i]['idWhStockItem']."'";
				$resultWHdispatch=$this->adapter->query($qryWHdispatch,array());
				$resultsetWHdispatch=$resultWHdispatch->toArray();

				//picklist qty
				$qryWHpick="SELECT WSI.idWhStockItem,sum(WHP.pickQty) AS totalProPickQty FROM whouse_stock_items AS WSI LEFT JOIN order_picklist_items AS WHP ON WHP.idWhStockItem=WSI.idWhStockItem LEFT JOIN orders_allocated as OA ON OA.idOrderallocate=WHP.idAllocateOrder WHERE WSI.idWhStockItem='".$resultsetWHstock[$i]['idWhStockItem']."' AND OA.idOrderallocate='".$idOrderallocate."'";
				$resultWHpick=$this->adapter->query($qryWHpick,array());
				$resultsetWHpick=$resultWHpick->toArray();

			//calculate total available stock 
	$avlStockQtyVal=(($resultsetWHreturn[0]["totalAcceptQty"]+$resultsetWHreturn[0]["totalProReturn"]) - ($resultsetWHdispatch[0]["totalProDispatch"]+$resultsetWHdamage[0]["totalDmgProQty"]+$resultsetWHpick[0]["totalProPickQty"]));

	$resultsetWHstock[$i]['availQty']=$avlStockQtyVal;
			}
		//old qry
			$qry="SELECT T1.idWhStockItem, T1.idProduct,T1.idProdSize,T1.idWarehouse, DATE_FORMAT(T1.sku_mf_date, '%d-%m-%Y') AS mDate, DATE_FORMAT(T1.sku_expiry_date, '%d-%m-%Y') AS eDate, T1.sku_batch_no AS batchNo, T1.sku_accept_qty AS availQty, T2.productName AS productName, T3.pickQty
					FROM whouse_stock_items AS T1
					LEFT JOIN product_details AS T2 ON T2.idProduct=T1.idProduct
					LEFT JOIN order_picklist_items AS T3 ON T3.idWhStockItem=T1.idWhStockItem
					WHERE T1.idProduct=? AND T1.idProdSize=? AND T1.idWarehouse=? GROUP BY mDate,eDate";
			$result=$this->adapter->query($qry,array($productId,$productSize,$whouseId));
			$resultset=$result->toArray();

		$qryAlreadyPickQty="SELECT SUM(pickQty) as AlreadypickQty FROM order_picklist_items WHERE idAllocateOrder='$idOrderallocate' AND idAllocateItem='$idallocateitem'";
		$resultAlreadyPickQty=$this->adapter->query($qryAlreadyPickQty,array());
		$resultsetAlreadyPickQty=$resultAlreadyPickQty->toArray();

		$qryAlreadydispatched="SELECT * FROM `dispatch_customer` as dc LEFT JOIN dispatch_product as dp ON dp.idDispatchcustomer=dc.idDispatchcustomer WHERE dc.idWarehouse='$whouseId' AND dp.idProduct='$productId' AND dp.idProdSize='$productSize'";
		$resultAlreadydispatched=$this->adapter->query($qryAlreadydispatched,array());
		$resultsetAlreadydispatched=$resultAlreadydispatched->toArray();
			


			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'data'=>$resultsetWHstock,'pickQty'=>$resultsetAlreadyPickQty,'status'=>true,'message'=>'Record available'];
			}
		}elseif($param->action=='pickqtyitems'){

			$pickQty=($param->pickQty)?explode(',',$param->pickQty):'';
			$whouseItemId=($param->whouseItemId)?explode(',',$param->whouseItemId):'';

			$qry="SELECT idOrder FROM  orders_allocated where idOrderallocate=?";
			$result=$this->adapter->query($qry,array($param->allId));
			$resultset=$result->toArray();
			
			if($resultset){
				$totpickqty='';
				for ($i=0; $i <count($pickQty) ; $i++) { 
					if ($pickQty[$i]>0) {
						$this->adapter->getDriver()->getConnection()->beginTransaction();
						try {

							$datainsert['idOrder']=$resultset[0]['idOrder'];
							$datainsert['idAllocateOrder']=$param->allId;
							$datainsert['idAllocateItem']=$param->alloitmId;
							$datainsert['idWarehouse']=$param->whId;
							$datainsert['idProduct']=$param->prodId;
							$datainsert['idProdSize']=$param->prodSiz;
							$datainsert['idWhStockItem']=$whouseItemId[$i];
							$datainsert['pickQty']=$pickQty[$i];
							$insert=new Insert('order_picklist_items');
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
					}
				}
			} else {
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Please try again..'];
			}
		}elseif($param->action=='dispatchqtyitems'){
			$pickdisQty=($param->pickdisQty)?explode(',',$param->pickdisQty):'';
			$idallocitems=($param->idallocitems)?explode(',',$param->idallocitems):'';
			$qry="SELECT status FROM  orders_allocated where  idOrderallocate=?";
			$result=$this->adapter->query($qry,array($param->idallocate));
			$resultset=$result->toArray();
			if(count($resultset)>0){
				for ($i=0; $i <count($pickdisQty) ; $i++) { 
					$subqry="SELECT dispatchQty, approveQty FROM  orders_allocated_items where idOrderallocateditems=?";
					$subresult=$this->adapter->query($subqry,array($param->idallocitems[$i]));
					$subresultset=$subresult->toArray();
					if ($subresultset[0]['approveQty']>$subresultset[0]['dispatchQty']) {
						
						if ($pickdisQty[$i]>0) {
							$this->adapter->getDriver()->getConnection()->beginTransaction();
							try {
								$dataupdate['dispatchQty']=$subresultset[0]['dispatchQty']+$pickdisQty[$i];
								$dataupdate['pickqty']=0;
								$sql = new Sql($this->adapter);
								$update = $sql->update();
								$update->table('orders_allocated_items');
								$update->set($dataupdate);
								$update->where(array('idOrderallocateditems' =>$idallocitems[$i]));
								$statement = $sql->prepareStatementForSqlObject($update);
								$results = $statement->execute();
								$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
								$this->adapter->getDriver()->getConnection()->commit();

							}catch(\Exception $e) {
								$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
								$this->adapter->getDriver()->getConnection()->rollBack();
							}
						}
					}
				}
				
				if ($resultset[0]['status']!=4) {
					$this->adapter->getDriver()->getConnection()->beginTransaction();
					try {
						$dataupdate1['status']=4;
						$sql = new Sql($this->adapter);
						$update = $sql->update();
						$update->table('orders_allocated');
						$update->set($dataupdate1);
						$update->where(array('idOrderallocate' =>$param->idallocate));
						$statement = $sql->prepareStatementForSqlObject($update);
						$results = $statement->execute();
						$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
						$this->adapter->getDriver()->getConnection()->commit();

					}catch(\Exception $e) {
						$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
						$this->adapter->getDriver()->getConnection()->rollBack();
					}			
				}
			} else {
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Please try again..'];
			}
		}
		return $ret_arr;
	}

	function getCustomerType($param)
	{
		$userid=$param->userid;
		$qry="SELECT T1.idCustomerType AS id, T1.custType AS name 
		 FROM customertype AS T1
		 LEFT JOIN customer AS T2 ON T2.cs_type = T1.idCustomerType
		 WHERE T2.idCustomer=?";
		$result=$this->adapter->query($qry,array($userid));
		$resultset=$result->toArray();

		$qrySub="Select A.idCustomer as id,A.cs_name as name from customer A WHERE A.cs_type=?";
		$resultSub=$this->adapter->query($qrySub,array($resultset[0]['id']));
		$resultsetSub=$resultSub->toArray();
		if(!$resultset){
		$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		}  else {
		$ret_arr=['code'=>'2','content'=>$resultset,'customerData'=>$resultsetSub,'status'=>true,'message'=>'Record available'];
		}



		if(!$resultset) {
			$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		} else {
			$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
		}
		return $ret_arr;

	}

	public function saleshierarchy($param)
	{
         $qry="SELECT * FROM `sales_hierarchy` WHERE  saleshierarchyName!=''";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();

		if(!$resultset){
		$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		}  else {
		$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
		}

       return $ret_arr;
	}

	public function add_employee($param) {
		if($param->action=='add') {
			$mobile_no=$param->mblno;
			$emailid=$param->emailid;
			$rprtmngr1=$param->rprtmngr1;
			$rprtmngr2=$param->rprtmngr2;
			$rprtmngr3=$param->rprtmngr3;
           
			$lastid=1;
			$qryLastdata="SELECT * FROM `team_member_master` ORDER BY `idTeamMember` DESC limit 1";
			$resultLastdata=$this->adapter->query($qryLastdata,array());
			$resultsetLastdata=$resultLastdata->toArray();
			if (count($resultsetLastdata)>0) 
			{
				$lastid=$lastid+$resultsetLastdata[0]['idTeamMember'];
			}
			
			$uploads_dir ='public/uploads/emp';
			if($_FILES) {
				$tmp_name=$_FILES["profile_image"]["tmp_name"];
				$name =basename($_FILES["profile_image"]["name"]);
				$imageName ='employee_'.$lastid.date('dmyHis').'.'.pathinfo($_FILES["profile_image"]['name'],PATHINFO_EXTENSION);
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
				$usertype=$param->usertype;

				$qryEMPID="SELECT * FROM team_member_master a where  a.code=? ";
			$resultEMPID=$this->adapter->query($qryEMPID,array($param->empid));
			$resultsetEMPID=$resultEMPID->toArray();

				$qryEmail="SELECT * FROM team_member_master a where  a.emailId=? ";
			$resultEmail=$this->adapter->query($qryEmail,array($param->emailid));
			$resultsetEmail=$resultEmail->toArray();

			$qryMobile="SELECT * FROM team_member_master a where a.mobileno=?  ";
			$resultMobile=$this->adapter->query($qryMobile,array($param->mblno));
			$resultsetMobile=$resultMobile->toArray();

			$qryLandline="SELECT * FROM team_member_master a where a.landline=?  ";
			$resultLandline=$this->adapter->query($qryLandline,array($param->lndline));
			$resultsetLandline=$resultLandline->toArray();

             if (count($resultsetEMPID)>0) 
             {
             	$ret_arr=['code'=>'1','status'=>false,'message'=>'Employee id already exist'];
             }
            else if (count($resultsetEmail)>0) 
            {
            	$ret_arr=['code'=>'1','status'=>false,'message'=>'Email id already exist'];
            }
            else if(count($resultsetMobile)>0)
            {
              $ret_arr=['code'=>'1','status'=>false,'message'=>'Mobile number already exist'];
            }
            else if(count($resultsetLandline)>0)
            {
               $ret_arr=['code'=>'1','status'=>false,'message'=>'Landline number already exist'];
            }
            else
            {
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['code']=$param->empid;
					$datainsert['name']=$param->empname;
					$datainsert['mobileno']=$param->mblno;
					$datainsert['landline']=$param->lndline;
					$datainsert['emailId']=$param->emailid;
					$datainsert['address']=$param->address;
					$datainsert['idSaleshierarchy']=$param->salesHierachy;
					
					if ($imageName!='') {
					$datainsert['photo']=$imageName;
					} 				
					$datainsert['designation']=$param->designation;
					$datainsert['isRepManager']=$param->repoting_mngrstatus;
					if($rprtmngr1!='undefined') {
					$datainsert['reportingTo']=$param->rprtmngr1;
					} else {
						$datainsert['reportingTo']=0;
					}
					if($rprtmngr2!='undefined') {
					$datainsert['reportingTo2']=$param->rprtmngr2;
					} else {
						$datainsert['reportingTo2']=0;
					}
					if($rprtmngr3!='undefined') {
					$datainsert['reportingTo3']=$param->rprtmngr3;
					} else {
						$datainsert['reportingTo3']=0;
					}
					$datainsert['idMainGroup']=$param->maingroup;
					$datainsert['idSubsidaryGroup']=$param->subsidiary;
					$datainsert['proposition']=$param->proposition_type;
					$datainsert['segment']=$param->segment_type;
					$datainsert['t1']=($param->T1!='' && $param->T1!=undefined )?$param->T1:0;
					$datainsert['t2']=($param->T2!='' && $param->T2!=undefined )?$param->T2:0;
					$datainsert['t3']=($param->T3!='' && $param->T3!=undefined )?$param->T3:0;
					$datainsert['t4']=($param->T4!='' && $param->T4!=undefined )?$param->T4:0;
					$datainsert['t5']=($param->T5!='' && $param->T5!=undefined )?$param->T5:0;
					$datainsert['t6']=($param->T6!='' && $param->T6!=undefined )?$param->T6:0;
					$datainsert['t7']=($param->T7!='' && $param->T7!=undefined )?$param->T7:0;
					$datainsert['t8']=($param->T8!='' && $param->T8!=undefined )?$param->T8:0;
					$datainsert['t9']=($param->T9!='' && $param->T9!=undefined )?$param->T9:0;
					$datainsert['t10']=($param->T10!='' && $param->T10!=undefined )?$param->T10:0;
					$datainsert['created_by']=1;
					$datainsert['idLevel']=1;
					$datainsert['created_at']=date('Y-m-d H:i:s');
					$datainsert['updated_by']=1;
					$datainsert['updated_at']=date('Y-m-d H:i:s');
					$datainsert['status']=$param->status;
					//print_r($datainsert);exit;
					
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
				$imageName ='employee_'.$editid.date('dmyHis').'.'.pathinfo($_FILES["profile_image"]['name'],PATHINFO_EXTENSION);
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
			$usertype=$param->usertype;

            $qryEMPID="SELECT * FROM team_member_master a where  a.code=? AND idTeamMember!='$editid'";
			$resultEMPID=$this->adapter->query($qryEMPID,array($param->empid));
			$resultsetEMPID=$resultEMPID->toArray();

			$qryEmail="SELECT * FROM team_member_master a where  a.emailId=? AND idTeamMember!='$editid'";
			$resultEmail=$this->adapter->query($qryEmail,array($param->emailid));
			$resultsetEmail=$resultEmail->toArray();

			$qryMobile="SELECT * FROM team_member_master a where a.mobileno=?  AND idTeamMember!='$editid'";
			$resultMobile=$this->adapter->query($qryMobile,array($param->mblno));
			$resultsetMobile=$resultMobile->toArray();

			$qryLandline="SELECT * FROM team_member_master a where a.landline=?  AND idTeamMember!='$editid'";
			$resultLandline=$this->adapter->query($qryLandline,array($param->lndline));
			$resultsetLandline=$resultLandline->toArray();

			if (count($resultsetEMPID)>0) {
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Employee id already exist'];
			}

            else if (count($resultsetEmail)>0) 
            {
            	$ret_arr=['code'=>'1','status'=>false,'message'=>'Email id already exist'];
            }
            else if(count($resultsetMobile)>0)
            {
              $ret_arr=['code'=>'1','status'=>false,'message'=>'Mobile number already exist'];
            }
            else if(count($resultsetLandline)>0)
            {
               $ret_arr=['code'=>'1','status'=>false,'message'=>'Landline number already exist'];
            }
            else
            {
               $this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$dataupdate['code']=$param->empid;
					$dataupdate['name']=$param->empname;
					$dataupdate['mobileno']=$param->mblno;
					$dataupdate['landline']=$param->lndline;
					$dataupdate['emailId']=$param->emailid;
					$dataupdate['address']=$param->address;
					if ($imageName!='') {
					$dataupdate['photo']=$imageName;
					} 				
					$dataupdate['designation']=$param->designation;
					$dataupdate['isRepManager']=$param->rprtmngrstatus;
					//$datainsert['reportingTo']=$param->rprtmngr;
					if($rprtmngr1!='undefined') {
					$dataupdate['reportingTo']=$param->rprtmngr1;
					} else {
						$dataupdate['reportingTo']=0;
					}
					if($rprtmngr2!='undefined') {
					$dataupdate['reportingTo2']=$param->rprtmngr2;
					} else {
						$dataupdate['reportingTo2']=0;
					}
					if($rprtmngr3!='undefined') {
					$dataupdate['reportingTo3']=$param->rprtmngr3;
					} else {
						$dataupdate['reportingTo3']=0;
					}
					$dataupdate['idMainGroup']=$param->maingroup;
					$dataupdate['idSubsidaryGroup']=$param->subsidiary;
					$dataupdate['proposition']=$param->proposition_type;
					$dataupdate['segment']=$param->segment_type;
					$dataupdate['idSaleshierarchy']=$param->salesHierachy;
					
					$dataupdate['t1']=($param->T1!='' && $param->T1!=undefined )?$param->T1:0;
					$dataupdate['t2']=($param->T2!='' && $param->T2!=undefined )?$param->T2:0;
					$dataupdate['t3']=($param->T3!='' && $param->T3!=undefined )?$param->T3:0;
					$dataupdate['t4']=($param->T4!='' && $param->T4!=undefined )?$param->T4:0;
					$dataupdate['t5']=($param->T5!='' && $param->T5!=undefined )?$param->T5:0;
					$dataupdate['t6']=($param->T6!='' && $param->T6!=undefined )?$param->T6:0;
					$dataupdate['t7']=($param->T7!='' && $param->T7!=undefined )?$param->T7:0;
					$dataupdate['t8']=($param->T8!='' && $param->T8!=undefined )?$param->T8:0;
					$dataupdate['t9']=($param->T9!='' && $param->T9!=undefined )?$param->T9:0;
					$dataupdate['t10']=($param->T10!='' && $param->T10!=undefined )?$param->T10:0;
					$dataupdate['updated_by']=1;
					$dataupdate['idLevel']=1;
					$dataupdate['updated_at']=date('Y-m-d H:i:s');
					$dataupdate['status']=$param->status;
					
					$sql = new Sql($this->adapter);
					$update = $sql->update();
					$update->table('team_member_master');
					$update->set($dataupdate);
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

				
			}
			else if($param->action=='edit'){
			$editid=$param->id;
			$tery_title=$param->tery_title;
           
			$qry="SELECT a.*,HT1.territoryValue as territory1Sel,HT2.territoryValue as territory2Sel,HT3.territoryValue as territory3Sel,HT4.territoryValue as territory4Sel,HT5.territoryValue as territory5Sel,HT6.territoryValue as territory6Sel,HT7.territoryValue as territory7Sel,HT8.territoryValue as territory8Sel,HT9.territoryValue as territory9Sel,HT10.territoryValue as territory10Sel,s.saleshierarchyName
			FROM team_member_master a 
				LEFT JOIN sales_hierarchy s ON s.idSaleshierarchy=a.idSaleshierarchy 
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
		if(!$resultset) 
			{
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			} 
			else 
			{
				$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'tertitle'=>$tery_title,'message'=>'data available'];
			}
		}
			return $ret_arr;
	}
	public function bank($param){

		if($param->action=='list'){
			$qry="SELECT A.idBank AS id, A.bankName AS name, A.bankIFSC AS ifsc, A.status 
			FROM bank AS A ";
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
			$qryAlreadyexist="SELECT A.idBank AS id, A.bankName AS name, A.bankIFSC AS ifsc, A.status 
			FROM bank AS A WHERE bankIFSC='".$fields['ifsc']."'";
			$resultAlreadyexist=$this->adapter->query($qryAlreadyexist,array());
			$resultsetAlreadyexist=$resultAlreadyexist->toArray();
			if (count($resultsetAlreadyexist)>0) 
			{
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Bank IFSC already exist'];
			}
			else{
					$this->adapter->getDriver()->getConnection()->beginTransaction();
					try {
					$datainsert['bankName']=$fields['name'];
					$datainsert['bankIFSC']=$fields['ifsc'];
					$datainsert['status']=$fields['status'];
					$datainsert['created_by']=$userid;
					$datainsert['created_at']=date('Y-m-d H:i:s');
					$insert=new Insert('bank');
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
			$qry="SELECT A.idBank AS id, A.bankName AS name, A.bankIFSC AS ifsc, A.status 
			FROM bank AS A
			WHERE A.idBank='$editid'";

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

			$qryAlreadyexist="SELECT A.idBank AS id, A.bankName AS name, A.bankIFSC AS ifsc, A.status 
			FROM bank AS A WHERE bankIFSC='".$fields['ifsc']."' AND idBank!='".$editid."'";
			$resultAlreadyexist=$this->adapter->query($qryAlreadyexist,array());
			$resultsetAlreadyexist=$resultAlreadyexist->toArray();

			if (count($resultsetAlreadyexist)>0) 
			{
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Bank IFSC already exist'];
			}
			else{
					$this->adapter->getDriver()->getConnection()->beginTransaction();
					try {

					$dataupdate['bankName']=$fields['name'];
					$dataupdate['bankIFSC']=$fields['ifsc'];
					$dataupdate['status']=$fields['status'];
					$dataupdate['updated_by']=$userid;
					$dataupdate['updated_at']=date('Y-m-d H:i:s');
					$sql = new Sql($this->adapter);
					$update = $sql->update();
					$update->table('bank');
					$update->set($dataupdate);
					$update->where( array('idBank'=>$editid));
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
	public function cardType($param){

		if($param->action=='list'){
			$qry="SELECT A.idCardtype AS id, A.cardtypeName AS name, A.status 
			FROM card_type AS A ";
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

			$qryCardexist="SELECT A.idCardtype AS id, A.cardtypeName AS name, A.status 
			FROM card_type AS A WHERE cardtypeName='".$fields['name']."'";
			$resultCardexist=$this->adapter->query($qryCardexist,array());
			$resultsetCardexist=$resultCardexist->toArray();
			if (count($resultsetCardexist)>0) 
			{
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Card type name already exist'];
			}
			else
			{
               $this->adapter->getDriver()->getConnection()->beginTransaction();
			try {
				$datainsert['cardtypeName']=$fields['name'];
				$datainsert['status']=$fields['status'];
				$datainsert['created_by']=$userid;
				$datainsert['created_at']=date('Y-m-d H:i:s');
				$insert=new Insert('card_type');
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
			$qry="SELECT A.idCardtype AS id, A.cardtypeName AS name, A.status 
			FROM card_type AS A
			WHERE A.idCardtype='$editid'";

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

			$qryCardexist="SELECT A.idCardtype AS id, A.cardtypeName AS name, A.status 
			FROM card_type AS A WHERE cardtypeName='".$fields['name']."' AND idCardtype!='".$editid."'";
			$resultCardexist=$this->adapter->query($qryCardexist,array());
			$resultsetCardexist=$resultCardexist->toArray();
			if (count($resultsetCardexist)>0) 
			{
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Card type name already exist'];
			}
			else
			{
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {

				$dataupdate['cardtypeName']=$fields['name'];
				$dataupdate['status']=$fields['status'];
				$dataupdate['updated_by']=$userid;
				$dataupdate['updated_at']=date('Y-m-d H:i:s');
				$sql = new Sql($this->adapter);
				$update = $sql->update();
				$update->table('card_type');
				$update->set($dataupdate);
				$update->where( array('idCardtype'=>$editid));
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
				$qry_geo="SELECT 
				A.idTerritory as id,
				A.idTerritoryTitle,
				A.territoryValue,
				A.territoryCode,
				A.status
				FROM territory_master A where A.idTerritoryTitle=?";
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
		/*	print_r($current_state);exit;*/
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

	public function addCredentials($param)
	{
		$fields=$param->records;
		
			$bcrypt = new Bcrypt();
			$username=$fields['user_name'];
			$EMP_id=$fields['EMP_id'];
			$qry="SELECT * FROM `team_member_master` WHERE  username='$username'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			
			if(!$resultset) 
			{
			$this->adapter->getDriver()->getConnection()->beginTransaction();
			try {
				
				$dataUpdate['username'] = $fields['user_name'];
				$dataUpdate['password'] = $bcrypt->create($fields['password']);
				$dataUpdate['updated_by'] = 1;
				$dataUpdate['updated_at'] = date('Y-m-d H:i:s');
					
				$sql = new Sql($this->adapter);
				$update = $sql->update();
				$update->table('team_member_master');
				$update->set($dataUpdate);
				$update->where(array('idTeamMember' =>$EMP_id));
				$statement = $sql->prepareStatementForSqlObject($update);
				$results = $statement->execute();
				$result = ['success' => '1','status' =>true, 'message' => 'Added successfully','customer_id' => $customer_id];
			$this->adapter->getDriver()->getConnection()->commit();
		} catch (\Exception $e) {
			$result = ['success' => '3','status' =>false,'message' => 'Please try again Failed!!!'.$e];
			$this->adapter->getDriver()->getConnection()->rollBack();
		}
		} else {
			$result = ['success' => '3','status' =>false,'message' => 'User name already exist'];
		}

		return $result;
		
	}

public function	reeesetIMSI($param)
{
	
	$fields=$param->records;
	$EMP_id=$fields['EMP_id'];
	$this->adapter->getDriver()->getConnection()->beginTransaction();
			try {
				
				$dataUpdate['imsi_number'] = Null;
				$dataUpdate['imsi_reset'] = 0;
				$dataUpdate['updated_by'] = $param->userid;
				$dataUpdate['updated_at'] = date('Y-m-d H:i:s');
					
				$sql = new Sql($this->adapter);
				$update = $sql->update();
				$update->table('team_member_master');
				$update->set($dataUpdate);
				$update->where(array('idTeamMember' =>$EMP_id));
				$statement = $sql->prepareStatementForSqlObject($update);
				$results = $statement->execute();
				$result = ['success' => '1','status' =>true, 'message' => 'IMSI reset successfully','customer_id' => $customer_id];
			$this->adapter->getDriver()->getConnection()->commit();
		} catch (\Exception $e) {
			$result = ['success' => '3','status' =>false,'message' => 'Please try again Failed!!!'.$e];
			$this->adapter->getDriver()->getConnection()->rollBack();
		}
   return $result;
}

public function stateChange($param)
	{
           
			$qryPincode="SELECT idGeography,geoValue FROM `geography` WHERE idGeography in(SELECT tmm.g3 FROM geographymapping_master as tmm WHERE tmm.g2='".$param->id."')";


			$resultPincode=$this->adapter->query($qryPincode,array());
			$resultsetPincode=$resultPincode->toArray();

              
			if (count($resultsetPincode)>0) 
			{
				 $ret_arr=['code'=>'2','status'=>true,'city'=>$resultsetPincode,'message'=>'Data available'];
			}
			else
			{
				 $ret_arr=['code'=>'2','status'=>false,'message'=>'No Data available'];
			}
			
      return $ret_arr;
	}
	public function cityChange($param)
	{
           

			$qryPincode="SELECT idGeography,geoValue FROM `geography` WHERE idGeography in(SELECT tmm.g4 FROM geographymapping_master as tmm WHERE tmm.g3='".$param->id."' AND tmm.g2='".$param->stateid."')";
			$resultPincode=$this->adapter->query($qryPincode,array());
			$resultsetPincode=$resultPincode->toArray();

			
              
			if (count($resultsetPincode)>0) 
			{
				 $ret_arr=['code'=>'2','status'=>true,'pincode'=>$resultsetPincode,'message'=>'Data available'];
			}
			else
			{
				 $ret_arr=['code'=>'2','status'=>false,'message'=>'No Data available'];
			}
			
      return $ret_arr;
	}

	public function pincodeChange($param)
	{
           

			$qryPincode="SELECT idGeography,geoValue FROM `geography` WHERE idGeography in(SELECT tmm.g5 FROM geographymapping_master as tmm WHERE tmm.g3='".$param->id."' AND tmm.g4='".$param->pincodeid."' AND tmm.g2='".$param->stateid."')";

			$resultArea=$this->adapter->query($qryPincode,array());
			$resultsetArea=$resultArea->toArray();

			if (count($resultsetArea)>0) 
			{
				 $ret_arr=['code'=>'2','status'=>true,'area'=>$resultsetArea,'message'=>'Data available'];
			}
			else
			{
				$ret_arr=['code'=>'2','status'=>false,'message'=>'No Data available'];
			}

			
      return $ret_arr;
	}


	public function areaChange($param)
	{
           
			$qryStreet="SELECT idGeography,geoValue FROM `geography` WHERE idGeography in(SELECT tmm.g6 FROM geographymapping_master as tmm WHERE tmm.g3='".$param->id."' AND tmm.g4='".$param->pincodeid."' AND tmm.g5='".$param->areaid."'  AND tmm.g2='".$param->stateid."')";
			$resultStreet=$this->adapter->query($qryStreet,array());
			$resultsetStreet=$resultStreet->toArray();

			if (count($resultsetStreet)>0) 
			{
				$ret_arr=['code'=>'2','status'=>true,'street'=>$resultsetStreet,'message'=>'Data available'];
			}
			else
			{
				$ret_arr=['code'=>'2','status'=>false,'message'=>'No Data available'];
			}

			
      return $ret_arr;
	}
public function	OrderExecutionStatus($param)
{
	if($param->action=='territorylist'){

		$qry="SELECT A.idGeographyTitle AS id, A.title
		FROM geographytitle_master AS A
		WHERE A.title!=''";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		if ($resultset[1]) {
		$statename=$resultset[1]['title'];
		}	
		if ($resultset[2]) {
		$cityname=$resultset[2]['title'];
		}
		if ($resultset[3]) {
		$pincodename=$resultset[3]['title'];
		}
		if ($resultset[4]) {
		$areaname=$resultset[4]['title'];
		}
		if ($resultset[5]) {
		$streetname=$resultset[5]['title'];
		}
		

		$qryState="SELECT A.idGeography AS id, A.geoValue
		FROM geography AS A
		WHERE A.idGeographyTitle=2 AND A.status=1";
		$resultState=$this->adapter->query($qryState,array());
		$resultsetState=$resultState->toArray();
		

		if(count($resultsetState)>0) {
		$ret_arr=['code'=>'2','content'=>$resultset,'cityname'=>$cityname,'pincodename'=>$pincodename,'areaname'=>$areaname,'streetname'=>$streetname,'statename'=>$statename,'state'=>$resultsetState,'status'=>true,'message'=>'Record available'];
		}  else {
		$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		}
	}else if ($param->action=='add') {
		$fields=$param->Form;
		$idCustomer=$param->idCustomer;

		if($fields['state']!='' && $fields['city']!='' && $fields['pincode']!='' && $fields['area']!='' && $fields['street']!='' && $fields['state']!=0 && $fields['city']!=0 && $fields['pincode']!=0 && $fields['area']!=0 && $fields['street']!=0){
		$viewCond=" AND cust.G2=".$fields['state']." ";
		$viewCond.=" AND cust.G3=".$fields['city']." ";
		$viewCond.=" AND cust.G4=".$fields['pincode']." ";
		$viewCond.=" AND cust.G5=".$fields['area']." ";
		$viewCond.=" AND cust.G6=".$fields['street']." ";
	}else if($fields['state']!='' && $fields['city']!='' && $fields['pincode']!='' && $fields['area']!='' && $fields['state']!=0 && $fields['city']!=0 && $fields['pincode']!=0 && $fields['area']!=0){
		$viewCond=" AND cust.G2=".$fields['state']." ";
		$viewCond.=" AND cust.G3=".$fields['city']." ";
		$viewCond.=" AND cust.G4=".$fields['pincode']." ";
		$viewCond.=" AND cust.G5=".$fields['area']." ";
	}else if($fields['state']!='' && $fields['city']!='' && $fields['pincode']!='' && $fields['state']!=0 && $fields['city']!=0 && $fields['pincode']!=0){
		$viewCond=" AND cust.G2=".$fields['state']." ";
		$viewCond.=" AND cust.G3=".$fields['city']." ";
		$viewCond.=" AND cust.G4=".$fields['pincode']." ";
	}else if($fields['state']!='' && $fields['city']!='' && $fields['state']!=0 && $fields['city']!=0){
		$viewCond=" AND cust.G2=".$fields['state']." ";
		$viewCond.=" AND cust.G3=".$fields['city']." ";
	}else if($fields['state']!='' && $fields['state']!=0){
		$viewCond=" AND cust.G2=".$fields['state']." ";
	}

	if($fields['allcustomer']==true){
		
		$qry="SELECT idLogin FROM user_login  WHERE idCustomer='$idCustomer'";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		$viewCond.=" AND ORD.created_by='".$resultset[0]['idLogin']."'";
	}
		$qryState="SELECT cl.custType,ORD.idOrder,ORD.idCustomer,cust.cs_type,cust.cs_name,DATE_FORMAT(ORD.poDate,'%d-%M-%Y') AS poDate
								FROM orders AS ORD 
								LEFT JOIN customer AS cust ON ORD.idCustomer=cust.idCustomer 
								LEFT JOIN customertype AS cl ON cl.idCustomerType=cust.cs_type 
								WHERE (DATE_FORMAT(ORD.poDate,'%Y%m%d') 
								BETWEEN '".date('Ymd', strtotime($fields['startdate']))."' AND '".date('Ymd', strtotime($fields['lastdate'] . ' +1 day'))."') ".
								$viewCond." ORDER BY ORD.idOrder DESC";
								
		$resultState=$this->adapter->query($qryState,array());
		$resultsetState=$resultState->toArray();
		

		if(count($resultsetState)>0) {
		$ret_arr=['code'=>'2','content'=>$resultsetState,'status'=>true,'message'=>'Record available'];
		}  else {
		$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		}
	}else if($param->action=='productlist'){
		$orderid=$param->orderid;
		$qry="SELECT OI.idOrderItem,OI.idOrder,OI.idProduct,OI.idProductsize,OI.orderQty,PRO.productName,SIZE.productPrimaryCount,SIZE.productSize,PKG.primarypackname,0 as dispatchqty
									FROM order_items AS OI 
									LEFT JOIN product_details AS PRO ON OI.idProduct=PRO.idProduct 
									LEFT JOIN product_size AS SIZE ON OI.idProductsize=SIZE.idProductsize 
									LEFT JOIN primary_packaging AS PKG ON SIZE.idPrimaryPackaging=PKG.idPrimaryPackaging 
									WHERE OI.idOrder='$orderid'";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		for ($i=0; $i < count($resultset); $i++) { 
			$orderidItem=$resultset[$i]['idOrderItem'];
			$qryDispatch="SELECT DP.idDispatchProduct,DP.idOrderItem,DP.dis_Qty 
									FROM dispatch_product AS DP 
									WHERE DP.idOrderItem='$orderidItem'";
		$resultDispatch=$this->adapter->query($qryDispatch,array());
		$resultsetDispatch=$resultDispatch->toArray();
		$resultset[$i]['dispatchqty']=$resultsetDispatch[0]['dis_Qty'];
		}

		if(count($resultset)>0) {
		$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
		}  else {
		$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		}
	}else if($param->action=='invoicelist'){
		$orderid=$param->orderid;
		$qry="SELECT DC.idDispatchcustomer,DC.idOrder,DC.invoiceNo,DV.deliveryDate 
									FROM dispatch_customer AS DC 
									LEFT JOIN dispatch_vehicle AS DV ON DC.idDispatchVehicle=DV.idDispatchVehicle 
									WHERE DC.idOrder='$orderid'";
									
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		

		if(count($resultset)>0) {
		$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
		}  else {
		$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		}
	}else if($param->action=='invoiceproductlist'){
		$dispatchcustid=$param->dispatchcustid;
		$qry="SELECT DP.idProduct,DP.idProdSize,DP.dis_Qty,DP.idOffer,DC.idOrder,PRO.productName,SIZE.productPrimaryCount,SIZE.productSize,PKG.primarypackname,0 as orderQty 
									FROM dispatch_product AS DP  
									LEFT JOIN dispatch_customer AS DC ON DP.idDispatchcustomer=DC.idDispatchcustomer 
									LEFT JOIN product_details AS PRO ON DP.idProduct=PRO.idProduct 
									LEFT JOIN product_size AS SIZE ON DP.idProdSize=SIZE.idProductsize 
									LEFT JOIN primary_packaging AS PKG ON SIZE.idPrimaryPackaging=PKG.idPrimaryPackaging 
									
									WHERE DP.idDispatchcustomer=".$dispatchcustid." 
									ORDER BY DP.idDispatchProduct";
									
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		
		for ($i=0; $i < count($resultset); $i++) { 
			$proid=$resultset[$i]['idProduct'];
			$sizeid=$resultset[$i]['idProdSize'];
			$orderid=$resultset[$i]['idOrder'];
			$qryDispatch="SELECT orderQty FROM order_items 
							WHERE idOrder='$orderid' AND idProduct='$proid' AND idProductsize='$sizeid'";
				
		$resultDispatch=$this->adapter->query($qryDispatch,array());
		$resultsetDispatch=$resultDispatch->toArray();
		$resultset[$i]['orderQty']=$resultsetDispatch[0]['orderQty'];
		}
// print_r($resultset)
		if(count($resultset)>0) {
		$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
		}  else {
		$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		}
	}
	return $ret_arr;
}

public function DispatchReport($param)
	{
        if($param->action=='add'){  
        	$fields=$param->Form;
		$qry="SELECT ORC.idOrderallocate,ORC.idWarehouse,ORC.idOrder,ORD.idCustomer,ORD.poNumber,DATE_FORMAT(ORD.poDate,'%d-%m-%Y') AS poDate,CUST.cs_type 
										FROM orders_allocated AS ORC 
										LEFT JOIN orders AS ORD ON ORC.idOrder=ORD.idOrder 
										LEFT JOIN customer AS CUST ON ORD.idCustomer=CUST.idCustomer
										WHERE ORC.idWarehouse=".$fields['warehouse']." 
										AND (DATE_FORMAT(ORD.poDate,'%Y%m%d') 
										BETWEEN '".date('Ymd', strtotime($fields['startdate']))."' AND '".date('Ymd', strtotime($fields['lastdate'] . ' +1 day'))."') group by  ORC.idOrder ";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();

		if (count($resultset)>0) 
		{
			$ret_arr=['code'=>'2','status'=>true,'content'=>$resultset,'message'=>'Data available'];
		}
		else
		{
			$ret_arr=['code'=>'2','status'=>false,'message'=>'No Data available'];
		}
	}else if($param->action=='customerlist'){  
        $customerid=$param->customerid;


		$qryCustomeraddress="SELECT c.cs_name as name,
			c.cs_mobno as mobile,
			c.cs_mail as email,
			c.customer_code as code,
			s.segmentName as cs_classify,
			tm1.geoValue as country,
			tm2.geoValue as state,
			tm3.geoValue as city,
			tm4.geoValue as pincode,
			tm5.geoValue as region,
			tm6.geoValue as zone,
			tm7.geoValue as hub,
			tm8.geoValue as area,
			tm9.geoValue as street,
			tm10.geoValue as outlet,
			'' as customerAddress
			FROM `customer` as c 
			LEFT JOIN geography as tm1 ON tm1.idGeography=c.G1
			LEFT JOIN geography as tm2 ON tm2.idGeography=c.G2
			LEFT JOIN geography as tm3 ON tm3.idGeography=c.G3
			LEFT JOIN geography as tm4 ON tm4.idGeography=c.G4
			LEFT JOIN geography as tm5 ON tm5.idGeography=c.G5
			LEFT JOIN geography as tm6 ON tm6.idGeography=c.G6
			LEFT JOIN geography as tm7 ON tm7.idGeography=c.G7
			LEFT JOIN geography as tm8 ON tm8.idGeography=c.G8
			LEFT JOIN geography as tm9 ON tm9.idGeography=c.G9
			LEFT JOIN geography as tm10 ON tm10.idGeography=c.G10
			LEFT JOIN segment_type as s ON s.idsegmentType=c.cs_segment_type
			WHERE idCustomer='$customerid' ";
			$resultCustomeraddress=$this->adapter->query($qryCustomeraddress,array());
			$resultsetCustomeraddress=$resultCustomeraddress->toArray();
              $cusAddress='';
			if ($resultsetCustomeraddress[0]['country']!='') {
				$cusAddress=$cusAddress.''.$resultsetCustomeraddress[0]['country'];
			}
			if ($resultsetCustomeraddress[0]['state']!='') {
				$cusAddress=$cusAddress.','.$resultsetCustomeraddress[0]['state'];
			}
			if ($resultsetCustomeraddress[0]['city']!='') {
				$cusAddress=$cusAddress.','.$resultsetCustomeraddress[0]['city'];
			}
			if ($resultsetCustomeraddress[0]['pincode']!='') {
				$cusAddress=$cusAddress.','.$resultsetCustomeraddress[0]['pincode'];
			}
			if ($resultsetCustomeraddress[0]['region']!='') {
				$cusAddress=$cusAddress.','.$resultsetCustomeraddress[0]['region'];
			}
			if ($resultsetCustomeraddress[0]['zone']!='') {
				$cusAddress=$cusAddress.','.$resultsetCustomeraddress[0]['zone'];
			}
			if ($resultsetCustomeraddress[0]['hub']!='') {
				$cusAddress=$cusAddress.''.$resultsetCustomeraddress[0]['hub'];
			}
			if ($resultsetCustomeraddress[0]['area']!='') {
				$cusAddress=$cusAddress.','.$resultsetCustomeraddress[0]['area'];
			}
			if ($resultsetCustomeraddress[0]['street']!='') {
				$cusAddress=$cusAddress.''.$resultsetCustomeraddress[0]['street'];
			}
			if ($resultsetCustomeraddress[0]['outlet']!='') {
				$cusAddress=$cusAddress.','.$resultsetCustomeraddress[0]['outlet'];
			}
            $resultsetCustomeraddress[0]['customerAddress']=$cusAddress;
            
			
			//$resultsetCustomer[$i]['customerAddress']=$resultsetCustomeraddress[0];


		if (count($resultsetCustomeraddress)>0) 
		{
			$ret_arr=['code'=>'2','status'=>true,'content'=>$resultsetCustomeraddress,'message'=>'Data available'];
		}
		else
		{
			$ret_arr=['code'=>'2','status'=>false,'message'=>'No Data available'];
		}
	}
	else if($param->action=='dispatchlist'){  
        $orderid=$param->orderid;
        $po_no=$param->po_no;
        $war_id=$param->war_id;
		$qry="SELECT DISP.idDispatchcustomer,DISP.idDispatchVehicle,DISP.dcNo,DISP.invoiceNo,DV.deliveryDate,O.poNumber
										FROM dispatch_customer AS DISP 
										LEFT JOIN dispatch_vehicle AS DV ON DISP.idDispatchVehicle=DV.idDispatchVehicle
										LEFT JOIN orders AS O ON DISP.idOrder=O.idOrder
										WHERE DISP.idOrder='".$orderid."'";
									
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		
	

		if (count($resultset)>0) 
		{
			$ret_arr=['code'=>'2','status'=>true,'content'=>$resultset,'message'=>'Data available'];
		}
		else
		{
			$ret_arr=['code'=>'2','status'=>false,'message'=>'No Data available'];
		}
	}else if($param->action=='invoiceproductlist'){  
      $dispatchcustid=$param->dispatchcustid;
		$qry="SELECT DP.idProduct,DP.idProdSize,DP.dis_Qty,DP.idOffer,DC.idOrder,PRO.productName,SIZE.productPrimaryCount,SIZE.productSize,PKG.primarypackname,0 as orderQty 
									FROM dispatch_product AS DP  
									LEFT JOIN dispatch_customer AS DC ON DP.idDispatchcustomer=DC.idDispatchcustomer 
									LEFT JOIN product_details AS PRO ON DP.idProduct=PRO.idProduct 
									LEFT JOIN product_size AS SIZE ON DP.idProdSize=SIZE.idProductsize 
									LEFT JOIN primary_packaging AS PKG ON SIZE.idPrimaryPackaging=PKG.idPrimaryPackaging 
									
									WHERE DP.idDispatchcustomer=".$dispatchcustid." 
									ORDER BY DP.idDispatchProduct";
									
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		
		for ($i=0; $i < count($resultset); $i++) { 
			$proid=$resultset[$i]['idProduct'];
			$sizeid=$resultset[$i]['idProdSize'];
			$orderid=$resultset[$i]['idOrder'];
			$qryDispatch="SELECT orderQty FROM order_items 
							WHERE idOrder='$orderid' AND idProduct='$proid' AND idProductsize='$sizeid'";
				
		$resultDispatch=$this->adapter->query($qryDispatch,array());
		$resultsetDispatch=$resultDispatch->toArray();
		$resultset[$i]['orderQty']=$resultsetDispatch[0]['orderQty'];
		}

		if (count($resultset)>0) 
		{
			$ret_arr=['code'=>'2','status'=>true,'content'=>$resultset,'message'=>'Data available'];
		}
		else
		{
			$ret_arr=['code'=>'2','status'=>false,'message'=>'No Data available'];
		}
	}
			
      return $ret_arr;
	}
	
	public function transportChargesReport($param)
	{
		$fields=$param->Form;
       	$idcustomer=$fields['customer'];		
		$frmdate=$fields['startdate'];
		$todate=$fields['lastdate'];

		$qry="SELECT 
		DATE_FORMAT(dv.deliveryDate,'%d-%m-%Y') as dc_date ,
		dv.dc_no as dc_no ,
		dv.vehicleCapacity,
		dv.idCustomer,
		dv.idDispatchvehicle,
		dp.idProduct,
		dpb.idWhStockItem,
		vm.vehicleName,
		dc.totalWeight,
		dv.totalKM as totalkilometer,
		'0' as loadcapacity,
		'0' as utilized,
		dc.invoice_amt as invoice_value,
		dv.perKMamount,
		c.cs_transport_type,
		c.cs_transport_amt,
		dv.reimburse_amount,
		'0' as ttlinvoiceAmount,
		'0' as ttlperkmamount,vm.vehicleMinCharge
		FROM dispatch_vehicle as dv 
		LEFT JOIN dispatch_customer as dc on dc.idDispatchVehicle=dv.idDispatchVehicle
		LEFT JOIN dispatch_product as dp on dp.idDispatchcustomer=dc.idDispatchcustomer
		LEFT JOIN dispatch_product_batch as dpb on dpb.idDispatchProduct=dp.idDispatchProduct
		LEFT JOIN vehicle_master as vm on vm.idVehicle=dv.idVechileType 
		LEFT JOIN customer as c on c.idCustomer=dv.idCustomer  WHERE dv.idCustomer='$idcustomer' AND dv.deliveryDate BETWEEN '".date('Y-m-d',strtotime($frmdate))."' AND '".date('Y-m-d',strtotime($todate. ' +1 day'))."'
		GROUP BY dv.idDispatchVehicle";

		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		$tot_rem_value=0;
		for ($i=0; $i < count($resultset); $i++) 
		{ 
			$loadcapacity=$resultset[$i]['totalWeight']/1000; //total weight of product devide by 1000
			$resultset[$i]['loadcapacity']=$loadcapacity;
			$utilizedpercent=($loadcapacity/$resultset[$i]['vehicleCapacity'])*100;

			$resultset[$i]['utilized']=$utilizedpercent;
			if ($resultset[$i]['cs_transport_type']==1) 
			{
				$ttlperkmamount=$resultset[$i]['totalkilometer']*$resultset[$i]['perKMamount'];
				if ($resultset[$i]['vehicleMinCharge']>$ttlperkmamount) 
				{
					$ttlperkmamount=$resultset[$i]['vehicleMinCharge'];
				}
				else
				{
                   $ttlperkmamount=$resultset[$i]['totalkilometer']*$resultset[$i]['perKMamount'];
				}
				$resultset[$i]['ttlperkmamount']=$ttlperkmamount;
			}

			if ($resultset[$i]['cs_transport_type']==2) 
			{
                $ttlinvoiceAmount=($resultset[$i]['invoice_value']*$resultset[$i]['cs_transport_amt'])/100;
                $resultset[$i]['ttlinvoiceAmount']=round($ttlinvoiceAmount,2);
			}

			$tot_rem_value+=$resultset[$i]['reimburse_amount'];

        }
        /*print_r($resultset);*/

	   if($resultset){

		$ret_arr=['code'=>'1','status'=>true,'message'=>'Data available','tot_rem_value'=>$tot_rem_value,'content' =>$resultset];
		
		}else {
			$ret_arr=['code'=>'2','status'=>false,'message'=>'parameter missing, try again!!!'];
		}
 return $ret_arr;
	}

	public function NonprimaryWHDispatchReport($param)
	{
        if ($param->action=='add') {
        	$idCustomer=$param->idCustomer;
        	$userid=$param->userid;
        	$user_type=$param->user_type;
        	$fields=$param->Form;

			$qry="SELECT CUST.idCustomer,CUST.cs_name,CUST.cs_type,CUST.idPreferredwarehouse,CUST.G2,WH.warehouseName,LOC.geoValue as state,ORD.idOrder,ORD.poNumber,WHO.idOrderallocate,WHO.idWarehouse 
					FROM orders_allocated AS WHO 
					RIGHT JOIN orders AS ORD ON ORD.idOrder=WHO.idOrder
					LEFT JOIN customer AS CUST ON CUST.idCustomer=ORD.idCustomer 
					LEFT JOIN warehouse_master AS WH ON CUST.idPreferredwarehouse=WH.idWarehouse 
					LEFT JOIN geography AS LOC ON CUST.G2=LOC.idGeography 
					WHERE CUST.idPreferredwarehouse!=WHO.idWarehouse 
					AND (DATE_FORMAT(ORD.poDate,'%Y%m%d') 
					BETWEEN '".date('Ymd', strtotime($fields['startdate']))."' AND '".date('Ymd', strtotime($fields['lastdate'] . ' +1 day'))."') 
					AND CUST.cs_serviceby='".$user_type."'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			for ($i=0; $i <count($resultset) ; $i++) { 
				$whName="SELECT warehouseName FROM warehouse_master WHERE idWarehouse='".$resultset[$i]['idWarehouse']."'";
				$resultwhName=$this->adapter->query($whName,array());
				$resultsetwhName=$resultwhName->toArray();
				$resultset[$i]['dispathedwarehouse']=$resultsetwhName[0]['warehouseName'];

				$getInvoice="SELECT idDispatchcustomer,invoiceNo
				 		FROM dispatch_customer 
						WHERE idWarehouse='".$resultset[$i]['idWarehouse']."'	
						AND idOrderallocate='".$resultset[$i]['idOrderallocate']."' 
						AND idOrder='".$resultset[$i]['idOrder']."'";
				$resultgetInvoice=$this->adapter->query($getInvoice,array());
				$resultsetgetInvoice=$resultgetInvoice->toArray();
				$resultset[$i]['invoiceData']=$resultsetgetInvoice;
}
		
			if (count($resultset)>0) 
			{
				 $ret_arr=['code'=>'2','status'=>true,'content'=>$resultset,'message'=>'Data available'];
			}
			else
			{
				$ret_arr=['code'=>'2','status'=>false,'message'=>'No Data available'];
			}
        }else if ($param->action=='dispatchlist') {
        	$dispatchid=$param->dispatchid;
        	$qry="SELECT DP.idProduct,DP.idProdSize,DP.dis_Qty,DP.idOffer,DC.idOrder,PRO.productName,SIZE.productPrimaryCount,SIZE.productSize,PKG.primarypackname,0 as orderQty 
									FROM dispatch_product AS DP  
									LEFT JOIN dispatch_customer AS DC ON DP.idDispatchcustomer=DC.idDispatchcustomer 
									LEFT JOIN product_details AS PRO ON DP.idProduct=PRO.idProduct 
									LEFT JOIN product_size AS SIZE ON DP.idProdSize=SIZE.idProductsize 
									LEFT JOIN primary_packaging AS PKG ON SIZE.idPrimaryPackaging=PKG.idPrimaryPackaging 
									
									WHERE DP.idDispatchcustomer=".$dispatchid." 
									ORDER BY DP.idDispatchProduct";

			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();

			for ($i=0; $i < count($resultset); $i++) { 
			$proid=$resultset[$i]['idProduct'];
			$sizeid=$resultset[$i]['idProdSize'];
			$orderid=$resultset[$i]['idOrder'];
			$qryDispatch="SELECT orderQty FROM order_items 
							WHERE idOrder='$orderid' AND idProduct='$proid' AND idProductsize='$sizeid'";
			$resultDispatch=$this->adapter->query($qryDispatch,array());
			$resultsetDispatch=$resultDispatch->toArray();
			$resultset[$i]['orderQty']=$resultsetDispatch[0]['orderQty'];
			}
			if (count($resultset)>0) 
			{
				 $ret_arr=['code'=>'2','status'=>true,'content'=>$resultset,'message'=>'Data available'];
			}
			else
			{
				$ret_arr=['code'=>'2','status'=>false,'message'=>'No Data available'];
			}
		}else if ($param->action=='orderlist') {
        	$orderid=$param->orderid;
			$qry="SELECT OI.idOrderItem,OI.idOrder,OI.idProduct,OI.idProductsize,OI.orderQty,PRO.productName,SIZE.productPrimaryCount,SIZE.productSize,PKG.primarypackname,0 as dispatchqty
										FROM order_items AS OI 
										LEFT JOIN product_details AS PRO ON OI.idProduct=PRO.idProduct 
										LEFT JOIN product_size AS SIZE ON OI.idProductsize=SIZE.idProductsize 
										LEFT JOIN primary_packaging AS PKG ON SIZE.idPrimaryPackaging=PKG.idPrimaryPackaging 
										WHERE OI.idOrder='$orderid'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			for ($i=0; $i < count($resultset); $i++) { 
				$orderidItem=$resultset[$i]['idOrderItem'];
				$qryDispatch="SELECT DP.idDispatchProduct,DP.idOrderItem,DP.dis_Qty 
										FROM dispatch_product AS DP 
										WHERE DP.idOrderItem='$orderidItem'";
			$resultDispatch=$this->adapter->query($qryDispatch,array());
			$resultsetDispatch=$resultDispatch->toArray();
			$resultset[$i]['dispatchqty']=$resultsetDispatch[0]['dis_Qty'];
			}
			if (count($resultset)>0) 
			{
				 $ret_arr=['code'=>'2','status'=>true,'content'=>$resultset,'message'=>'Data available'];
			}
			else
			{
				$ret_arr=['code'=>'2','status'=>false,'message'=>'No Data available'];
			}
        } 
      return $ret_arr;
	}

	public function handlingCharghesReport($param) {
		if($param->action=='list'){
		$fields=$param->Form;
		$customer=$fields['customer'];
		$enddate=$fields['lastdate'];
		$startdate=$fields['startdate'];

		$qryprimary="SELECT idPrimaryPackaging,primarypackname FROM `primary_packaging` WHERE status=1";
			$resultprimary=$this->adapter->query($qryprimary,array());
			$resultsetprimary=$resultprimary->toArray();

			$qry="SELECT t1.dcNo,DATE_FORMAT(t1.delivery_date, '%d-%m-%Y') as delivery_date,t1.idDispatchVehicle,t1.idDispatchcustomer,t1.idCustomer,t1.idOrder,0 as disqty,0 as totalcharges,0 as packamount,t2.handling_charges FROM dispatch_customer as t1
			LEFT JOIN dispatch_vehicle as t2 ON t2.idDispatchVehicle=t1.idDispatchVehicle
			 WHERE t1.idCustomer='$customer'
			 AND (DATE_FORMAT(t1.delivery_date,'%Y%m%d') 
					BETWEEN '".date('Ymd', strtotime($fields['startdate']))."' AND '".date('Ymd', strtotime($fields['lastdate'] . ' +1 day'))."') ";
					

			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();

			$qrypack="SELECT t2.idDispatchcustomer ,t3.idPrimaryPackaging,t4.primarypackname 
			FROM dispatch_product as t2 
			LEFT JOIN product_size as t3 ON t3.idProductsize=t2.idProdSize 
			LEFT JOIN primary_packaging as t4 ON t4.idPrimaryPackaging=t3.idPrimaryPackaging 
			WHERE t2.idDispatchcustomer in(SELECT idDispatchcustomer from dispatch_customer where idCustomer='$customer' and 
			(DATE_FORMAT(delivery_date,'%Y%m%d') BETWEEN '".date('Ymd', strtotime($fields['startdate']))."' AND '".date('Ymd', strtotime($fields['lastdate'] . ' +1 day'))."')) 
			and t4.status=1 GROUP BY t3.idPrimaryPackaging";
			$resultpack=$this->adapter->query($qrypack,array());
			$resultsetpack=$resultpack->toArray();

			$dispatchid=$resultset[$i]['idDispatchcustomer'];
			$orderid=$resultset[$i]['idOrder'];

            $tot_handling_value=0;
			for ($i=0; $i < count($resultset); $i++) { 
				
			$dispatchid=$resultset[$i]['idDispatchcustomer'];
			$orderid=$resultset[$i]['idOrder'];

			$qrypro="SELECT t2.idDispatchcustomer,t2.idProduct,t2.idProdSize,t2.dis_Qty,tp.productName,t3.productSize ,t3.idPrimaryPackaging,t4.primarypackname,t5.idCustthierarchy,t5.idOrder ,0 as totalcharges,0 as packamount 
				FROM  dispatch_product as t2
				LEFT JOIN product_size as t3 ON t3.idProductsize=t2.idProdSize
				LEFT JOIN product_details as tp ON tp.idProduct=t2.idProduct
				LEFT JOIN primary_packaging as t4 ON t4.idPrimaryPackaging=t3.idPrimaryPackaging
				LEFT JOIN orders as t5 ON t5.idOrder='$orderid'
				WHERE t2.idDispatchcustomer='$dispatchid'";
				
			$resultpro=$this->adapter->query($qrypro,array());
			$resultsetpro=$resultpro->toArray();
			$hierarchy=$resultsetpro[0]['idCustthierarchy'];

			$qryagency="SELECT A.idAgency,A.agencyName FROM agency_master as A WHERE A.t2 IN (select B.t2 from territorymapping_master as B where B.t1='$hierarchy' OR B.t2='$hierarchy' OR B.t3='$hierarchy' OR B.t4='$hierarchy' OR B.t5='$hierarchy' OR B.t6='$hierarchy' OR B.t7='$hierarchy' OR B.t8='$hierarchy' OR B.t9='$hierarchy' OR B.t10='$hierarchy')";

			$resultagency=$this->adapter->query($qryagency,array());
			$resultsetagency=$resultagency->toArray();

			$resultsetArr[]=$resultsetpro;
			$resultset[$i]['idAgency']=$resultsetagency[0]['idAgency'];
			$resultset[$i]['agencyName']=$resultsetagency[0]['agencyName'];

				$tot_handling_value+=$resultset[$i]['handling_charges'];
		}
		//total  dispache qty of each dispach customer of idprimary package
		$res  = array();

		foreach($resultsetArr as $vals)
		{
			foreach ($vals as $key => $value) 
			{
			        $res[$value['idDispatchcustomer']][$value['idPrimaryPackaging']]+=$value['dis_Qty'];
			        
			}
		}
	

	for ($i=0; $i < count($resultset); $i++) 
			{ 
				$dis_id=$resultset[$i]['idDispatchcustomer'];
				
			foreach ($res as $key => $value) 
			{ 
			  	if($resultset[$i]['idDispatchcustomer']==$key)
			  	{
                  foreach ($value as $key1 => $v1) 
                  {

                  	for ($k=0; $k < count($resultsetpack); $k++) 
					{
					$primaryid=$resultsetpack[$k]['idPrimaryPackaging'];
					if ($primaryid==$key1) 
					{
						$resultset[$i][$primaryid]=$v1;
					
					}
					
					}
                  }
					
			  }
				
			}
		}
// calculate total charge for the handling
		$ttchg=0;

		for ($i=0; $i < count($resultset); $i++) { 

			$agencyid=$resultset[$i]['idAgency'];
			$ttchg=0;

			for ($l=0; $l < count($resultsetpack); $l++) 
			{ 

				$packid=$resultsetpack[$l]['idPrimaryPackaging'];
                $disqty=$resultset[$i][$packid];
                //print_r($disqty);
               
               
				$qrytotal="SELECT t1.PackageCount,t1.idPackaging FROM handling_charges_master as t1 WHERE t1.idAgency='$agencyid' and t1.packaging_type=1 and t1.idPackaging='$packid'";
				//echo $qrytotal;

				$resulttotal=$this->adapter->query($qrytotal,array());
				$resultsettotal=$resulttotal->toArray();
				$resultset[$i]['packamount']=($resultsettotal[0]['PackageCount'])?$resultsettotal[0]['PackageCount']:0;
				$ttchg=$ttchg+($disqty*$resultset[$i]['packamount']);
					
				$resultset[$i]['totalcharges']=$ttchg;
				
			}

		}
	
			if(count($resultset)>0) {
				$ret_arr=['code'=>'2','content'=>$resultset,'primary'=>$resultsetprimary,'package'=>$resultsetpack,'viewcontent'=>$resultsetview,'tot_handling_value'=>$tot_handling_value,'status'=>true,'message'=>'Record available'];
				
			} else {
				
              $ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found'];
			}
		}


		else if($param->action=='view'){
		$dispatchid=$param->customer;
		$orderid=$param->order;
			
			$qrypro="SELECT t2.idDispatchcustomer,t2.idProduct,t2.idProdSize,t2.dis_Qty,tp.productName,t3.productSize ,t3.idPrimaryPackaging,t4.primarypackname,t5.idCustthierarchy,t5.idOrder ,t6.agencyName,t6.idAgency,0 as totalcharges,0 as packamount FROM  dispatch_product as t2
				LEFT JOIN product_size as t3 ON t3.idProductsize=t2.idProdSize
				LEFT JOIN product_details as tp ON tp.idProduct=t2.idProduct
				LEFT JOIN primary_packaging as t4 ON t4.idPrimaryPackaging=t3.idPrimaryPackaging
				LEFT JOIN orders as t5 ON t5.idOrder='$orderid'
				LEFT JOIN agency_master as t6 ON t6.t4=t5.idCustthierarchy
				WHERE t2.idDispatchcustomer='$dispatchid'";
			$resultpro=$this->adapter->query($qrypro,array());
			$resultsetpro=$resultpro->toArray();
		
			if($resultsetpro) {
				$ret_arr=['code'=>'2','product'=>$resultsetpro,'status'=>true,'message'=>'Record available'];
				
			} else {
				
              $ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found'];
			}
		}
		 return $ret_arr;
	}


	public function stockReplace($param) {
		if($param->action=='replacedetails'){
			$dispatchid=$param->dispatchid;
			$customerid=$param->customerid;
			$proid=$param->proid;
			$sizeid=$param->sizeid;
			$idOrderItem=$param->idOrderItem;
			$returndays=$param->returndays;
			$returnstatus=$param->returnstatus;

			$qry="SELECT idDispatchProductBatch from dispatch_product_batch where idDispatchProduct='$dispatchid'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			
			for($i=0;$i<count($resultset);$i++){
				$deleteid=$resultset[$i]['idDispatchProductBatch'];
				 $delete = new Delete('customer_order_replacement');
                     $delete->where(['idDispatchProductBatch=?' => $deleteid]);
                     $delete->where(['replaceStatus=?' => 0]);
                     $statement=$this->adapter->createStatement();
                     $delete->prepareStatement($this->adapter, $statement);
                     $resultsetdelete=$statement->execute();
				}

			$qryrtn="SELECT DPB.idDispatchProductBatch,
				DPB.idDispatchProduct,
				0 as serialno, 
				false as retstatus,
				CURDATE() as currentdate,
				0 as exp_returndays,
				DPB.idWhStockItem, 
				DPB.qty,
				DATE_FORMAT(WSI.sku_mf_date,'%d-%m-%Y') as sku_mf_date,
				0 as earlyqty,
				DPB.idWhStockItem,
				DC.idOrder,
				ORD.poDate,
				DC.idCustomer,
				DC.idLevel,
				DC.idOrderallocate,
				DP.idOrderItem,
				WSI.sku_batch_no
				from dispatch_product_batch as DPB 
				LEFT JOIN dispatch_product as DP ON DP.idDispatchProduct=DPB.idDispatchProduct
				LEFT JOIN dispatch_customer as DC ON DC.idDispatchcustomer=DP.idDispatchcustomer
				LEFT JOIN orders as ORD ON ORD.idOrder=DC.idOrder
				LEFT JOIN whouse_stock_items as WSI ON WSI.idWhStockItem=DPB.idWhStockItem where DPB.idDispatchProduct='$dispatchid'";
			$resultrtn=$this->adapter->query($qryrtn,array());
			$resultsetrtn=$resultrtn->toArray();

				
			for($i=0; $i <count($resultsetrtn) ; $i++){
				$idDispatchProductBatch=$resultsetrtn[$i]['idDispatchProductBatch'];
				//already return qty
			$qryearqty="SELECT sum(replaceQty) as tot from customer_order_replacement where idDispatchProductBatch='".$idDispatchProductBatch."' and replaceStatus=1";
			$resultearqty=$this->adapter->query($qryearqty,array());
			$resultsetearqty=$resultearqty->toArray();
			//picked qty from this customer to another customer
			$qryPickqty="SELECT wsi.idWhStockItem,sum(opi.pickQty) as pickQty  FROM `orders` as ord 
			LEFT JOIN whouse_stock as ws ON ws.po_no=ord.poNumber 
			LEFT JOIN whouse_stock_items as wsi ON wsi.idWhStock=ws.idWhStock 
			LEFT JOIN order_picklist_items as opi ON opi.idWhStockItem=wsi.idWhStockItem
			WHERE ord.idOrder='".$resultsetrtn[$i]['idOrder']."' AND wsi.sku_batch_no='".$resultsetrtn[$i]['sku_batch_no']."'";
			$resultPickqty=$this->adapter->query($qryPickqty,array());
			$resultsetPickqty=$resultPickqty->toArray();

				$pickQty=($resultsetPickqty[0]['pickQty']!=NULL)?$resultsetPickqty[0]['pickQty']:0;		
                $resultsetrtn[$i]['qty']=$resultsetrtn[$i]['qty']-$pickQty;
				$resultsetrtn[$i]['serialno']='R'.date('dmyhis').'P'.rand(500,999).'C';
				$resultsetrtn[$i]['proid']=$proid;
				$resultsetrtn[$i]['sizeid']=$sizeid;
				$resultsetrtn[$i]['idOrderItem']=$idOrderItem;
				$resultsetrtn[$i]['earlyqty']=$resultsetearqty[0]['tot'];
				$resultsetrtn[$i]['idSerialno']='';
				$resultsetrtn[$i]['returnQty']='';
				$resultsetrtn[$i]['comments']='';
				if($returnstatus==1){
					$a=$returndays.' days';
					$maxreturndays=$resultsetrtn[$i]['poDate'];
					//$expreturndays= date('Y-m-d', strtotime($Date.  '+ 1days'));
					$date=date_create($maxreturndays);
					date_add($date,date_interval_create_from_date_string($a));
					$expreturndays=date_format($date,"Y-m-d");
					/*$resultsetrtn[$i]['exp_returndays']=$expreturndays;
					if(strtotime($expreturndays)>=strtotime($resultsetrtn[$i]['currentdate'])){
						$resultsetrtn[$i]['retstatus']=true;
					}else{
						$resultsetrtn[$i]['retstatus']=false;
					}
*/
				}


			}
			if(!$resultsetrtn) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please enter valid customer'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultsetrtn,'earlyqty'=>$resultsetearqty,'status'=>true,'message'=>'Record available'];

			}
		}
		return $ret_arr;
	}

	public function SerialReplace($param)
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

		$qryitem="SELECT idOrder FROM `order_items` WHERE idOrderitem='$idOrderItem'";
		$resultitem=$this->adapter->query($qryitem,array());
		$resultsetitem=$resultitem->toArray();

		$orderid=$resultsetitem[0]['idOrder'];

		$qry="SELECT idOrderallocate FROM `orders_allocated` WHERE idOrder='$orderid'";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();


		$allocateid=$resultset[0]['idOrderallocate'];

		$qryorder="SELECT idOrderallocateditems FROM `orders_allocated_items` WHERE idOrderallocated='$allocateid' AND idProduct='$proid' AND idProductsize='$sizeid'";

		$resultorder=$this->adapter->query($qryorder,array());
		$resultsetorder=$resultorder->toArray();


		$orderallocatedid= $resultsetorder[0]['idOrderallocateditems'];

		$qryPrimaryQty="SELECT ps.productPrimaryCount,pp.primarypackname FROM `product_size` as ps LEFT JOIN primary_packaging as pp on pp.idPrimaryPackaging=ps.idPrimaryPackaging WHERE ps.idProduct='$proid' AND ps.idProductsize='$sizeid'";
		$resultPrimaryQty=$this->adapter->query($qryPrimaryQty,array());
		$resultsetPrimaryQty=$resultPrimaryQty->toArray();
		$ppname=$resultsetPrimaryQty[0]['primarypackname'];
		$ppcount=$resultsetPrimaryQty[0]['productPrimaryCount'];	

		$totalQty=$ppcount*$qty;
//All serial number data	
		$qryorders="SELECT idProductserialno,serialno FROM `product_stock_serialno` WHERE idWhStock in(SELECT idWhStock FROM whouse_stock_items WHERE idWhStockItem='$whitem') AND idProduct='$proid' AND idProductsize='$sizeid' AND idOrderallocateditems='$orderallocatedid' AND status=1";        
		$resultorders=$this->adapter->query($qryorders,array());
		$resultsetALLSL=$resultorders->toArray();

//current customer picked serial number ids corresponding mf date and batch number
		$qryidserial="SELECT idSerialno FROM `order_picklist_items` WHERE idOrder in(SELECT idOrder FROM product_stock_serialno WHERE idWhStock in(SELECT idWhStock FROM whouse_stock_items WHERE idWhStockItem='$whitem') AND idLevel='".$userData['user_type']."' AND idCustomer='".$userData['idCustomer']."') AND idWhStockItem='".$whitem."' AND `idAllocateItem`='".$orderallocatedid."'";        
		$resultidserial=$this->adapter->query($qryidserial,array());
		$resultsetidserial=$resultidserial->toArray();
		$idSerial=($resultsetidserial)?explode('|',$resultsetidserial[0]['idSerialno']):'';
//already picked serial number from currunt customer  to another customer
		$qryAlreadPick="SELECT pssno.idProductserialno,pssno.serialno FROM orders as ord 
		LEFT JOIN whouse_stock as ws ON ws.po_no=ord.poNumber
		LEFT JOIN whouse_stock_items as wsi on ws.idWhStock=wsi.idWhStock 
		LEFT JOIN product_stock_serialno as pssno ON pssno.idWhStockItem=wsi.idWhStockItem
		WHERE ord.idOrder='$orderid' AND wsi.sku_batch_no='$batchno' AND pssno.status=1";

		$resultAlreadPick=$this->adapter->query($qryAlreadPick,array());
		$resultsetAlreadPick=$resultAlreadPick->toArray();
/*1.resultsetALLSL array first loop get the all the serialno for that customer warehousestock
2.idSerial array second loop is serial number against corrsponding product and batchno in that customer warehousestock
3.resultsetAlreadPick array is how many serialno with  product send from this customer(SMS) to another customer(MS) (EX:SMS to MS)
*/
for ($i=0; $i < count($resultsetALLSL); $i++) 
{ 
	for ($j=0; $j < count($idSerial); $j++) 
	{ 
		if ($idSerial[$j]==$resultsetALLSL[$i]['idProductserialno'] ) 
		{

$resultsetorders1[]=$resultsetALLSL[$i]; //get sms ordered serial number
} 

}
}

foreach ($resultsetorders1 as $key => $value) 
{
	$a[]=$value['serialno'];
}
foreach ($resultsetAlreadPick as $key1 => $value1) 
{
	$b[]=$value1['serialno'];
}
//compare SMS and MS and remove MS serial number from SMS get Final serial numbers
if(count($b)>0){

	$c=array_values(array_diff($a,$b));
}else{
	$c=$a;
}
$k=0;


for ($i=0; $i < count($c); $i++) 
{ 

	for ($m=0; $m < count($resultsetorders1); $m++) 
	{ 
		if ($c[$i]==$resultsetorders1[$m]['serialno']) 
		{
			$resultsetorders[$k]['idProductserialno']=$resultsetorders1[$m]['idProductserialno'];
			$resultsetorders[$k]['serialno']=$resultsetorders1[$m]['serialno'];
			$resultsetorders[$k]['status']=false;
			$resultsetorders[$k]['requiredstatus']=false;

		}

	}

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

if(count($resultsetorders)>0)
{
	$ret_arr=['code'=>'2','status'=>true,'content' =>$resultsetorders,'totalQty'=>$totalQty,'allocateid' => $orderallocatedid,'message'=>'records available'];
}
else
{
	$ret_arr=['code'=>'1','status'=>false,'message'=>'no records..'];
}
}
return $ret_arr;	
}

	public function updateSerialnoReplace($param)
	{
      
       $fields=$param->FORM;
       $sno=$param->srno;
       $idWhStockItem=$param->whitem;

       $idorderallocateitem=$param->alloItemId;
      $checkedsno=$param->checkedSNO;
     
       for ($i=0; $i < count($checkedsno); $i++) 
       { 
       	$j=$i+1;
       	$a='serialcheck'.$j;
       	
       	// if ($fields[$a]==true) 
       	// {
       		 	
        $idserialno=$checkedsno[$i];

        $qry="SELECT serialno FROM `product_stock_serialno` WHERE idProductserialno='$idserialno'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();

			$serialno=$resultset[0]['serialno'];

		 $qryserialno="SELECT max(idProductserialno) as slno FROM `product_stock_serialno` WHERE serialno='$serialno'";
			$resultserialno=$this->adapter->query($qryserialno,array());
			$resultsetserialno=$resultserialno->toArray();

			


       		 	$this->adapter->getDriver()->getConnection()->beginTransaction();
					try {
						$updateserialNo['status']=7;
						$updateserialNo['idWhStockItem']=$idWhStockItem;
						$updateserialNo['idOrderallocateditems']=$idorderallocateitem;
						
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

       return $ret_arr;
	}


	public function stockreplaceadd($param) {
		if($param->action=='add'){
			$proid=$param->proid; //idDispatchProduct
			$returnqty=$param->returnqty;
			$creditno=$param->slno;
			$comments=$param->comments;
			$returndetails=$param->returndetails;

			$qrybatch="SELECT idDispatchProductBatch from dispatch_product_batch where idDispatchProduct='$proid'";
			$resultbatch=$this->adapter->query($qrybatch,array());
			$resultsetbatch=$resultbatch->toArray();
			$qrycustmr="SELECT idDispatchcustomer FROM dispatch_product WHERE idDispatchProduct='$proid'";
			$resultcustmr=$this->adapter->query($qrycustmr,array());
			$resultsetcustmr=$resultcustmr->toArray();
			//get primary count and serialnoi status for that product
			$qryPrimarycount="SELECT dp.idProdSize,ps.productPrimaryCount,ps.idProduct,dpb.idWhStockItem,prd.productserialNo 
			FROM `dispatch_product` as dp 
			LEFT JOIN product_size as ps ON ps.idProductsize=dp.idProdSize 
			LEFT JOIN dispatch_product_batch as dpb ON dpb.idDispatchProduct=dp.idDispatchProduct 
			LEFT JOIN product_details as prd ON prd.idProduct=ps.idProduct
			WHERE dp.idDispatchProduct='$proid'";
			$resultPrimarycount=$this->adapter->query($qryPrimarycount,array());
			$resultsetPrimarycount=$resultPrimarycount->toArray();

			$pcount=$resultsetPrimarycount[0]['productPrimaryCount'];
			$idproduct=$resultsetPrimarycount[0]['idProduct'];
			$idproductsize=$resultsetPrimarycount[0]['idProdSize'];
			$idWhStockItem=$resultsetPrimarycount[0]['idWhStockItem'];
			$serialNostatus=$resultsetPrimarycount[0]['productserialNo'];
			// get already return qty
			$alreadyreturnQtycount=0;
			for ($i=0; $i < count($resultsetbatch); $i++) 
			{ 

				$qryAlreadyreturnQty="SELECT count(*) as alreadyreturnQty FROM `customer_order_replacement` WHERE idDispatchcustomer='".$resultsetcustmr[$i]['idDispatchcustomer']."' AND idDispatchProductBatch='".$resultsetbatch[$i]['idDispatchProductBatch']."'";
				//echo $qryAlreadyreturnQty;
				$resultAlreadyreturnQty=$this->adapter->query($qryAlreadyreturnQty,array());
				$resultsetAlreadyreturnQty=$resultAlreadyreturnQty->toArray();
				$alreadyreturnQtycount=$alreadyreturnQtycount+$resultsetAlreadyreturnQty[0]['alreadyreturnQty'];
			}

			$isserialNo=false;
			$rps=0;
			$ttls=0;
			for ($l=0; $l < count($returnqty); $l++) 
			{ 						
				$ttls=$alreadyreturnQtycount+$returnqty[$l];
			}
			$rps=$pcount*$ttls; //currently accept requsted serial number count
			if ($serialNostatus==1) 
			{
			//get already return serial number count
				$qryAlreadyreturn="SELECT count(*) as alreadyreturn FROM `product_stock_serialno` WHERE idProduct='$idproduct' AND idProductsize='$idproductsize' AND idWhStockItem='$idWhStockItem' AND status=3";
				//echo $qryAlreadyreturn;
				$resultAlreadyreturn=$this->adapter->query($qryAlreadyreturn,array());
				$resultsetAlreadyreturn=$resultAlreadyreturn->toArray();
				$alreadyreturnSLNOcount=$resultsetAlreadyreturn[0]['alreadyreturn'];

				/*if($rps==$alreadyreturnSLNOcount)
				{
					$isserialNo=true;
				}*/

				if($rps<$alreadyreturnSLNOcount) 
				{
					$isserialNo=false;
				}else{
					$isserialNo=true;
				}

			}
			else
			{
				$isserialNo=true;
			}


			if($isserialNo==true)
			{
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {


					for($i=0;$i<count($returndetails);$i++){
						if ($returndetails[$i]['returnQty']!='') 
						{
							$datainsert['idDispatchProductBatch']=$returndetails[$i]['idDispatchProductBatch'];
							$datainsert['idDispatchcustomer']=$resultsetcustmr[0]['idDispatchcustomer'];
							$datainsert['credit_note_no']=$returndetails[$i]['serialno'];
							$datainsert['replaceQty']=$returndetails[$i]['returnQty'];
							$datainsert['replaceDate']=date("Y-m-d H:i:s");
							$datainsert['replaceCmnts']=($returndetails[$i]['comments'])?$returndetails[$i]['comments']:'';
							$datainsert['idSrialno']=($returndetails[$i]['idSerialno']!='')?implode('|',$returndetails[$i]['idSerialno']):'';

							$datainsert['replaceStatus']=1;


							$insert=new Insert('customer_order_replacement');
							$insert->values($datainsert);
							$statement=$this->adapter->createStatement();
							$insert->prepareStatement($this->adapter, $statement);
							$insertresult=$statement->execute();
						}

					}
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
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please pick the serial number..'];
			}

		}else if($param->action=='viewinvoicedetails'){
			$pro_id=$param->pro_id;
			$qry="SELECT idDispatchProductBatch from dispatch_product_batch where idDispatchProduct='$pro_id'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			$batchid=$resultset[0]['idDispatchProductBatch'];
			$qrycmnts="SELECT replaceCmnts,DATE_FORMAT(replaceDate,'%d-%m-%Y') as replaceDate,replaceQty FROM  customer_order_replacement WHERE idDispatchProductBatch='$batchid'";
			$resultcmnts=$this->adapter->query($qrycmnts,array());
			$resultsetcmnts=$resultcmnts->toArray();

			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultsetcmnts,'status'=>true,'message'=>'Record available'];

			}
		}

	return $ret_arr;
}


	public function stockMissing($param) {
		if($param->action=='replacedetails'){
			$dispatchid=$param->dispatchid;
			$customerid=$param->customerid;
			$proid=$param->proid;
			$sizeid=$param->sizeid;
			$idOrderItem=$param->idOrderItem;
			$returndays=$param->returndays;
			$returnstatus=$param->returnstatus;

			$qry="SELECT idDispatchProductBatch from dispatch_product_batch where idDispatchProduct='$dispatchid'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			
			for($i=0;$i<count($resultset);$i++){
				$deleteid=$resultset[$i]['idDispatchProductBatch'];
				 $delete = new Delete('customer_order_missing');
                     $delete->where(['idDispatchProductBatch=?' => $deleteid]);
                     $delete->where(['missing_status=?' => 0]);
                     $statement=$this->adapter->createStatement();
                     $delete->prepareStatement($this->adapter, $statement);
                     $resultsetdelete=$statement->execute();
				}

			$qryrtn="SELECT DPB.idDispatchProductBatch,
				DPB.idDispatchProduct,
				0 as serialno, 
				false as retstatus,
				CURDATE() as currentdate,
				0 as exp_returndays,
				DPB.idWhStockItem, 
				DPB.qty,
				DATE_FORMAT(WSI.sku_mf_date,'%d-%m-%Y') as sku_mf_date,
				0 as earlyqty,
				DPB.idWhStockItem,
				DC.idOrder,
				ORD.poDate,
				DC.idCustomer,
				DC.idLevel,
				DC.idOrderallocate,
				DP.idOrderItem,
				WSI.sku_batch_no
				from dispatch_product_batch as DPB 
				LEFT JOIN dispatch_product as DP ON DP.idDispatchProduct=DPB.idDispatchProduct
				LEFT JOIN dispatch_customer as DC ON DC.idDispatchcustomer=DP.idDispatchcustomer
				LEFT JOIN orders as ORD ON ORD.idOrder=DC.idOrder
				LEFT JOIN whouse_stock_items as WSI ON WSI.idWhStockItem=DPB.idWhStockItem where DPB.idDispatchProduct='$dispatchid'";
			$resultrtn=$this->adapter->query($qryrtn,array());
			$resultsetrtn=$resultrtn->toArray();

				
			for($i=0; $i <count($resultsetrtn) ; $i++){
				$idDispatchProductBatch=$resultsetrtn[$i]['idDispatchProductBatch'];
				//already return qty
			$qryearqty="SELECT sum(missing_qty) as tot from customer_order_missing where idDispatchProductBatch='".$idDispatchProductBatch."' and missing_status=1";
			$resultearqty=$this->adapter->query($qryearqty,array());
			$resultsetearqty=$resultearqty->toArray();
			//picked qty from this customer to another customer
			$qryPickqty="SELECT wsi.idWhStockItem,sum(opi.pickQty) as pickQty  FROM `orders` as ord 
			LEFT JOIN whouse_stock as ws ON ws.po_no=ord.poNumber 
			LEFT JOIN whouse_stock_items as wsi ON wsi.idWhStock=ws.idWhStock 
			LEFT JOIN order_picklist_items as opi ON opi.idWhStockItem=wsi.idWhStockItem
			WHERE ord.idOrder='".$resultsetrtn[$i]['idOrder']."' AND wsi.sku_batch_no='".$resultsetrtn[$i]['sku_batch_no']."'";
			$resultPickqty=$this->adapter->query($qryPickqty,array());
			$resultsetPickqty=$resultPickqty->toArray();

				$pickQty=($resultsetPickqty[0]['pickQty']!=NULL)?$resultsetPickqty[0]['pickQty']:0;		
                $resultsetrtn[$i]['qty']=$resultsetrtn[$i]['qty']-$pickQty;
				$resultsetrtn[$i]['serialno']='M'.date('dmyhis').'S'.rand(500,999).'G';
				$resultsetrtn[$i]['proid']=$proid;
				$resultsetrtn[$i]['sizeid']=$sizeid;
				$resultsetrtn[$i]['idOrderItem']=$idOrderItem;
				$resultsetrtn[$i]['earlyqty']=$resultsetearqty[0]['tot'];
				$resultsetrtn[$i]['idSerialno']='';
				$resultsetrtn[$i]['returnQty']='';
				$resultsetrtn[$i]['comments']='';
				if($returnstatus==1){
					$a=$returndays.' days';
					$maxreturndays=$resultsetrtn[$i]['poDate'];
					//$expreturndays= date('Y-m-d', strtotime($Date.  '+ 1days'));
					$date=date_create($maxreturndays);
					date_add($date,date_interval_create_from_date_string($a));
					$expreturndays=date_format($date,"Y-m-d");
					/*$resultsetrtn[$i]['exp_returndays']=$expreturndays;
					if(strtotime($expreturndays)>=strtotime($resultsetrtn[$i]['currentdate'])){
						$resultsetrtn[$i]['retstatus']=true;
					}else{
						$resultsetrtn[$i]['retstatus']=false;
					}
*/
				}


			}
			if(!$resultsetrtn) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please enter valid customer'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultsetrtn,'earlyqty'=>$resultsetearqty,'status'=>true,'message'=>'Record available'];

			}
		}
		return $ret_arr;
	}

	public function updateSerialnoMissing($param)
	{
      
       $fields=$param->FORM;
       $sno=$param->srno;
       $idWhStockItem=$param->whitem;

       $idorderallocateitem=$param->alloItemId;
      $checkedsno=$param->checkedSNO;
     
       for ($i=0; $i < count($checkedsno); $i++) 
       { 
       	$j=$i+1;
       	$a='serialcheck'.$j;
       	
       	// if ($fields[$a]==true) 
       	// {
       		 	
        $idserialno=$checkedsno[$i];

        $qry="SELECT serialno FROM `product_stock_serialno` WHERE idProductserialno='$idserialno'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();

			$serialno=$resultset[0]['serialno'];

		 $qryserialno="SELECT max(idProductserialno) as slno FROM `product_stock_serialno` WHERE serialno='$serialno'";
			$resultserialno=$this->adapter->query($qryserialno,array());
			$resultsetserialno=$resultserialno->toArray();

			


       		 	$this->adapter->getDriver()->getConnection()->beginTransaction();
					try {
						$updateserialNo['status']=8;
						$updateserialNo['idWhStockItem']=$idWhStockItem;
						$updateserialNo['idOrderallocateditems']=$idorderallocateitem;
						
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

       return $ret_arr;
	}


	public function stockmissingadd($param) {
		if($param->action=='add'){
			$proid=$param->proid; //idDispatchProduct
			$returnqty=$param->returnqty;
			$creditno=$param->slno;
			$comments=$param->comments;
			$returndetails=$param->returndetails;

			$qrybatch="SELECT idDispatchProductBatch from dispatch_product_batch where idDispatchProduct='$proid'";
			$resultbatch=$this->adapter->query($qrybatch,array());
			$resultsetbatch=$resultbatch->toArray();
			$qrycustmr="SELECT idDispatchcustomer FROM dispatch_product WHERE idDispatchProduct='$proid'";
			$resultcustmr=$this->adapter->query($qrycustmr,array());
			$resultsetcustmr=$resultcustmr->toArray();
			//get primary count and serialnoi status for that product
			$qryPrimarycount="SELECT dp.idProdSize,ps.productPrimaryCount,ps.idProduct,dpb.idWhStockItem,prd.productserialNo 
			FROM `dispatch_product` as dp 
			LEFT JOIN product_size as ps ON ps.idProductsize=dp.idProdSize 
			LEFT JOIN dispatch_product_batch as dpb ON dpb.idDispatchProduct=dp.idDispatchProduct 
			LEFT JOIN product_details as prd ON prd.idProduct=ps.idProduct
			WHERE dp.idDispatchProduct='$proid'";
			$resultPrimarycount=$this->adapter->query($qryPrimarycount,array());
			$resultsetPrimarycount=$resultPrimarycount->toArray();

			$pcount=$resultsetPrimarycount[0]['productPrimaryCount'];
			$idproduct=$resultsetPrimarycount[0]['idProduct'];
			$idproductsize=$resultsetPrimarycount[0]['idProdSize'];
			$idWhStockItem=$resultsetPrimarycount[0]['idWhStockItem'];
			$serialNostatus=$resultsetPrimarycount[0]['productserialNo'];
			// get already return qty
			$alreadyreturnQtycount=0;
			for ($i=0; $i < count($resultsetbatch); $i++) 
			{ 

				$qryAlreadyreturnQty="SELECT count(*) as alreadyreturnQty FROM `customer_order_missing` WHERE idDispatchcustomer='".$resultsetcustmr[$i]['idDispatchcustomer']."' AND idDispatchProductBatch='".$resultsetbatch[$i]['idDispatchProductBatch']."'";
				$resultAlreadyreturnQty=$this->adapter->query($qryAlreadyreturnQty,array());
				$resultsetAlreadyreturnQty=$resultAlreadyreturnQty->toArray();
				$alreadyreturnQtycount=$alreadyreturnQtycount+$resultsetAlreadyreturnQty[0]['alreadyreturnQty'];
			}

			$isserialNo=false;
			$rps=0;
			$ttls=0;
			for ($l=0; $l < count($returnqty); $l++) 
			{ 						
				$ttls=$alreadyreturnQtycount+$returnqty[$l];
			}
			$rps=$pcount*$ttls; //currently accept requsted serial number count
			if ($serialNostatus==1) 
			{
			//get already return serial number count
				$qryAlreadyreturn="SELECT count(*) as alreadyreturn FROM `product_stock_serialno` WHERE idProduct='$idproduct' AND idProductsize='$idproductsize' AND idWhStockItem='$idWhStockItem' AND status=3";
				$resultAlreadyreturn=$this->adapter->query($qryAlreadyreturn,array());
				$resultsetAlreadyreturn=$resultAlreadyreturn->toArray();
				$alreadyreturnSLNOcount=$resultsetAlreadyreturn[0]['alreadyreturn'];

				/*if($rps==$alreadyreturnSLNOcount)
				{
					$isserialNo=true;
				}
*/
				if($rps<$alreadyreturnSLNOcount) 
				{
					$isserialNo=false;
				}else{
					$isserialNo=true;
				}
			}
			else
			{
				$isserialNo=true;
			}


			if($isserialNo==true)
			{
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {


					for($i=0;$i<count($returndetails);$i++){
						if ($returndetails[$i]['returnQty']!='') 
						{
							$datainsert['idDispatchProductBatch']=$returndetails[$i]['idDispatchProductBatch'];
							$datainsert['idDispatchcustomer']=$resultsetcustmr[0]['idDispatchcustomer'];
							$datainsert['credit_note_no']=$returndetails[$i]['serialno'];
							$datainsert['missing_qty']=$returndetails[$i]['returnQty'];
							$datainsert['missing_entry_date']=date("Y-m-d H:i:s");
							$datainsert['missing_cmnts']=($returndetails[$i]['comments'])?$returndetails[$i]['comments']:'';
							$datainsert['idSrialno']=($returndetails[$i]['idSerialno']!='')?implode('|',$returndetails[$i]['idSerialno']):'';

							$datainsert['missing_status']=1;


							$insert=new Insert('customer_order_missing');
							$insert->values($datainsert);
							$statement=$this->adapter->createStatement();
							$insert->prepareStatement($this->adapter, $statement);
							$insertresult=$statement->execute();
						}

					}
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
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please pick the serial number..'];
			}

		}else if($param->action=='viewinvoicedetails'){
			$pro_id=$param->pro_id;
			$qry="SELECT idDispatchProductBatch from dispatch_product_batch where idDispatchProduct='$pro_id'";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			$batchid=$resultset[0]['idDispatchProductBatch'];
			$qrycmnts="SELECT missing_cmnts,DATE_FORMAT(missing_entry_date,'%d-%m-%Y') as missing_entry_date,missing_qty FROM  customer_order_missing WHERE idDispatchProductBatch='$batchid'";
			$resultcmnts=$this->adapter->query($qrycmnts,array());
			$resultsetcmnts=$resultcmnts->toArray();

			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultsetcmnts,'status'=>true,'message'=>'Record available'];

			}
		}

	return $ret_arr;
}
}