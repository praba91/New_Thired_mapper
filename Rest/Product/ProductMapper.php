<?php
namespace Sales\V1\Rest\Product;
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

class ProductMapper {

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
	else if($param->action=='getCategoryType') {
		$qry="SELECT idCategory, category FROM  category a WHERE status='1'";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		if(!$resultset) {
			$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		} else {
			$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
		}
	}

	else if($param->action=='getsubCategoryType') {

		$catid=$param->cat_id;
		$subcatid=$param->subcat_id;
		$procatid=$param->pro_id;
		$uncheckcat=$param->uncheckcat;


		$cat=($catid)?implode(',', $catid):'';
		$subcat=($subcatid)?implode(',', $subcatid):'';
		$pro=($procatid)?implode(',', $procatid):'';
		$catcondition=$cat?"idCategory IN ($catid)":'';
		$subcatcondition=$subcat?" and idSubCategory IN ($subcatid)":'';
//get all subcategory and product id corresponding category id
		if(count($catid)>0)
		{

			$qry="SELECT idSubCategory,idCategory,subcategory FROM subcategory a WHERE  idCategory IN ($cat) AND status=1";
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

			$qryproduct="SELECT idProduct,idCategory,idSubCategory,productName,productBrand FROM product_details a WHERE idCategory IN($cat) and idSubCategory IN($subcat)";
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
// echo $prostatus;

		if(!$resultset) {
			$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		} else {
			$ret_arr=['code'=>'2','content'=>$resultset,'pro_status'=>$prostatus,'sub_status'=>$substatus,'catcheckid'=>$catid,'subcatcheckid'=>$subcatid,'procheckid'=>$procatid,'status'=>true,'message'=>'Record available'];
		}
	}

	else if($param->action=='getproductType') {
		$subid=$param->subcategryid;
		$catid=$param->categryid;
		$subcategry=implode(',', $subid);
		$categry=implode(',', $catid);

		$qry="SELECT idProduct,idCategory,idSubCategory,productName,productBrand FROM product_details a WHERE idCategory IN($categry) and idSubCategory IN($subcategry)";
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

public function commonfunctions($param) {
	$action=$param->action;
// $userid=$param->user_id;

	if($action=='secondary'){
		$qry="SELECT idSecondaryPackaging as id, secondarypackname,0 as tempvalue  FROM secondary_packaging WHERE status='1'";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		if(!$resultset) {
			$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		} else {
			$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];

		}
	}
	if($action=='primary'){
		$qry="SELECT idPrimaryPackaging as id, primarypackname,0 as tempvalue1  FROM primary_packaging WHERE status='1' ";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		if(!$resultset) {
			$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		} else {
			$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];

		}
	}
	if($action=='customertype'){
		$qry="SELECT idCustomerType as id, custType,'0' as b_biilingprice,'0' as a_billingprice,'0' as psize, '0' as idprod,'0' as commissionmode,'0' as idterritory,'0' as product FROM customertype WHERE status='1' ";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		if(!$resultset) {
			$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		} else {
			$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];

		}
	}
	if($action=='hierarchytitle'){
		$qry="SELECT idTerritoryTitle as id, hierarchy, title FROM territorytitle_master where title!=''";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		if(!$resultset) {
			$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		} else {
			$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];

		}
	}
	if($action=='hierarchyvalue'){
		$titleid=$param->titid;

		$qry="SELECT idTerritory as id,territoryValue as value FROM territory_master a WHERE idTerritoryTitle IN($titleid) AND a.status=1";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		if(!$resultset) {
			$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		} else {
			$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];

		}
	}

	if($action=='hierarchyvaluename'){
		$titlenameid=$param->titnameid;

		$qry="SELECT idTerritoryTitle as id,title as title FROM territorytitle_master a WHERE idTerritoryTitle IN($titlenameid)";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		if(!$resultset) {
			$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		} else {
			$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];

		}
	}
	if($action=='territoryproduct'){
		$territoryid=$param->terid;

		$qry="SELECT a.idProductTerritory as id,pd.idProduct as idProduct ,pd.idCategory,pd.idSubCategory,pd.productName as productName,c.category
		FROM product_territory_details a 
		LEFT JOIN product_details as pd ON pd.idProduct=a.idProduct
		LEFT JOIN category as c ON c.idCategory=pd.idCategory
		WHERE idTerritory IN($territoryid) AND pd.status='1' GROUP by idCategory";
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

public function distributionMargin($param)
{

	$action=$param->action;
	if($action=='customertype'){
		$qry="SELECT idCustomerType as id, custType,'0' as b_biilingprice,'0' as a_billingprice,'0' as psize, '0' as idprod,'0' as commissionmode,'0' as idterritory,'0' as product FROM customertype WHERE status='1' ORDER BY idCustomerType DESC";
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
/*----------------------Nive functions-------------------------*/	

function serviceclassadd($param){
	if($param->action =='list'){
		$qry="SELECT * FROM  service_class";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		if(!$resultset) {
			$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
		}else{
			$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'message'=>'System config information'];
		}
	}else if($param->action=='add') {
		$fiedls=$param->Form;
		$qry="SELECT * FROM  service_class where serviceClass=?";
		$result=$this->adapter->query($qry,array($fiedls['serviceclass']));
		$resultset=$result->toArray();
		if(!$resultset){
			$this->adapter->getDriver()->getConnection()->beginTransaction();
			try {
				$datainsert['serviceClass']=$fiedls['serviceclass'];
				$datainsert['status']=$fiedls['servicestatus'];
				$datainsert['created_by']='1';
				$datainsert['created_at']=date('Y-m-d H:i:s');
				$insert=new Insert('service_class');
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
		$qry="SELECT idServiceClass as id,serviceClass as serviceclass,status as servicestatus FROM service_class where idServiceClass=?";
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
		$qry="SELECT * FROM service_class where serviceclass=? and idServiceClass!=?";
		$result=$this->adapter->query($qry,array($fiedls['serviceclass'],$editid));
		$resultset=$result->toArray();
		if(!$resultset) {
			$this->adapter->getDriver()->getConnection()->beginTransaction();
			try {
				$data['serviceClass']=$fiedls['serviceclass'];
				$data['status']=$fiedls['servicestatus'];
				$data['updated_by']='1';
				$data['updated_at']=date('Y-m-d H:i:s');
				$sql = new Sql($this->adapter);
				$update = $sql->update();
				$update->table('service_class');
				$update->set($data);
				$update->where( array('idServiceClass' => $editid));
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
function schemeadd($param){
	if($param->action =='list'){
		$qry="SELECT s.idScheme as idScheme,ct.custType as custType,pd.productName as productName,DATE_FORMAT(s.schemeStartdate,'%d-%m-%Y') as schemeStartdate,DATE_FORMAT(s.schemeEnddate,'%d-%m-%Y') as schemeEnddate,s.schemeType as schemeType,
		case 
		when s.schemeType=1 then 'Product to discount'
		when s.schemeType=2 then 'Product to other product'
		else 'Product to product'
		end as schemeType
		FROM scheme as s
		LEFT JOIN customertype as ct ON ct.idCustomerType=s.idCustomerType
		LEFT JOIN product_details as pd ON pd.idProduct=s.idProduct";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();

		if(!$resultset) {
			$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
		}else{
			$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'message'=>'System config information'];
		}
	}
	else if($param->action =='custmerlist'){
		$qry="SELECT cs_name,idCustomer FROM customer where cs_status='1'";
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
		if($fiedls['schemeType']=='3'){
			$productsize=$fiedls['proctsize'];
			$product=$fiedls['productvalue'];
			$productqty=$fiedls['freproctqty'];
		}else if($fiedls['schemeType']=='2'){
			$productsize=$fiedls['freproctsize'];
			$product=$fiedls['freproductvalue'];
			$productqty=$fiedls['freproctqty'];
		}
		$qry="SELECT * FROM  scheme where idScheme=?";
		$result=$this->adapter->query($qry,array($fiedls['idScheme']));
		$resultset=$result->toArray();
		if(!$resultset){
			$this->adapter->getDriver()->getConnection()->beginTransaction();
			try {
				$datainsert['schemeType']=$fiedls['schemeType'];
				$datainsert['idCustomerType']=$fiedls['customertypes'];
				$datainsert['schemeStartdate']=date('Y-m-d',strtotime($fiedls['fromdate']));
				$datainsert['schemeEnddate']=date('Y-m-d',strtotime($fiedls['todate']));
				$datainsert['idCategory']=$fiedls['category'];
				$datainsert['idCustomer']=$fiedls['customer'];
				$datainsert['schemeApplicable']=$fiedls['schmeapplicable'];
				$datainsert['idSubCategory']=$fiedls['subcategory'];
				$datainsert['idTerritory']=$fiedls['hierarchyvalue'];
				$datainsert['idProduct']=$fiedls['productvalue'];
				$datainsert['scheme_product_size']=$fiedls['proctsize'];
				$datainsert['scheme_product_qty']=$fiedls['productqty'];
				$datainsert['free_product_size']=$productsize;
				$datainsert['free_product']=$product;
				$datainsert['free_product_qty']=$productqty;
				$datainsert['discount_type']=$fiedls['discounttype'];
				$datainsert['scheme_flat_discount']=$fiedls['flatdiscount'];
				$datainsert['scheme_note']=$fiedls['notes'];
				$datainsert['scheme_terms_conditions']=$fiedls['termscondition'];
				$datainsert['created_by']='1';
				$datainsert['created_at']=date('Y-m-d H:i:s');
				$insert=new Insert('scheme');
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
		$qry="SELECT s.idScheme as id,s.schemeType as schetype,DATE_FORMAT(s.schemeStartdate,'%d-%m-%Y') as schemeStartdate,DATE_FORMAT(s.schemeEnddate,'%d-%m-%Y') as schemeEnddate,c.category,sc.subcategory,ct.custType,tm.territoryValue,pd.productName,s.scheme_product_qty,s.scheme_flat_discount,s.scheme_note,s.scheme_terms_conditions,s.free_product_qty,ps.productSize as freeprosize,p.productSize as schemeprosize,ttm.title,s.discount_type as discount_type,cust.cs_name as custmername,pdfree.productName as freeProductname,s.schemeApplicable,
		case 
		when s.schemeType=1 then 'Product to discount' 
		when s.schemeType=2 then 'Product to other product' 
		else 'Product to product' 
		end as schemeType,
		case 
		when s.discount_type=1 then 'Flat'
		when s.discount_type=2 then 'Percentage'
		end as distype
		FROM scheme as s
		LEFT JOIN customertype as ct ON ct.idCustomerType=s.idCustomerType
		LEFT JOIN customer as cust ON cust.idCustomer=s.idCustomer 
		LEFT JOIN category as c ON c.idCategory=s.idCategory
		LEFT JOIN subcategory as sc ON sc.idSubCategory=s.idSubCategory
		LEFT JOIN territory_master as tm ON tm.idTerritory=s.idTerritory
		LEFT JOIN territorytitle_master as ttm ON ttm.idTerritoryTitle=tm.idTerritoryTitle
		LEFT JOIN product_details as pd ON pd.idProduct=s.idProduct
		LEFT JOIN product_details as pdfree ON pdfree.idProduct=s.free_product
		LEFT JOIN product_size as ps ON ps.idProductsize=s.free_product_size
		LEFT JOIN product_size as p ON p.idProductsize=s.scheme_product_size
		where idScheme=?";
		$result=$this->adapter->query($qry,array($editid));
		$resultset=$result->toArray();

		if(!$resultset){
			$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		}else{
			$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
		}
	}
	return $ret_arr;
}

function orderproduct($param){
	if($param->action=='getfactoryType'){
		$qry="SELECT idFactory,factoryName FROM  factory_master a WHERE status=1";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		if(!$resultset) {
			$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		}else{
			$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
		}
	}
	if($param->action=='warehouselist'){
		$factId=$param->factid[0]['idFactory'];
		$qry="SELECT wm.idWarehouse as idWarehouse,wm.warehouseName as warehouseName,wm.warehouseMobileno as warehouseMobileno,wm.warehouseEmail as warehouseEmail FROM warehouse_master as wm LEFT JOIN warehouse_products as wp ON wp.idWarehouse=wm.idWarehouse WHERE wp.idFactory='$factId' and wm.idWarehousetype=2 AND wm.status=1 GROUP BY idWarehouse ORDER BY idWarehouse";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		if(!$resultset) {
			$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		} else {
			$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
		}
	}
	if($param->action=='list'){
		$factoryId=$param->factyid;
		$qry="SELECT c.category,c.idCategory,fp.idFactory
		FROM  factory_master as fm 
		LEFT JOIN factory_products as fp ON fp.idFactory=fm.idFactory
		LEFT JOIN category as c ON c.idCategory=fp.idCategory
		WHERE fm.idFactory='$factoryId' AND c.status=1 group by c.idCategory";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		if(!$resultset) {
			$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
		}else{
			$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'message'=>'System config information'];
		}
	}
	if($param->action=='factproduct'){
		$catId=($param->catid)?implode(',',$param->catid):'';
		$factId=$param->factid;

		$qryWH="SELECT wm.idWarehouse as idWarehouse,wm.warehouseName as warehouseName,wm.warehouseMobileno as warehouseMobileno,wm.warehouseEmail as warehouseEmail,'0' as qty,'0' as re_level,'0' as re_qty,'0' as re_max_stock,'0' as  re_min_stock,'0' as re_days,'0' as tot_stock,'0' as status  FROM warehouse_master as wm LEFT JOIN warehouse_products as wp ON wp.idWarehouse=wm.idWarehouse WHERE wp.idFactory='$factId' and wm.idWarehousetype=2 AND wm.status=1 GROUP BY idWarehouse ORDER  BY idWarehouse";
		$resultWH=$this->adapter->query($qryWH,array());
		$resultsetWH=$resultWH->toArray();

		$qry="SELECT pd.idProduct,
		pd.productName,
		pd.productCount,
		ps.productSize ,
		pp.primarypackname,
		ps.productPrimaryCount,
		ps.idProductsize,
		c.idCategory,'0' as warehouse
		FROM  factory_master as fm
		LEFT JOIN factory_products as fp ON fp.idFactory=fm.idFactory
		LEFT JOIN category as c ON c.idCategory=fp.idCategory
		LEFT JOIN product_details as pd ON pd.idProduct=fp.idProduct
		LEFT JOIN product_size as ps ON ps.idProduct=pd.idProduct
		LEFT JOIN primary_packaging as pp ON pp.idPrimaryPackaging=ps.idPrimaryPackaging
		WHERE fp.idCategory in($catId) and fp.idFactory='$factId' AND pd.status=1 AND ps.status=1";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		for ($i=0; $i < count($resultset); $i++) 
		{ 
			$resultset[$i]['warehouse']=$resultsetWH;
		}
		for ($i=0; $i < count($resultset); $i++) 
		{ 
			for ($j=0; $j < count($resultset[$i]['warehouse']); $j++) 
			{ 
				$idproduct=$resultset[$i]['idProduct'];	
				$idproductsize=$resultset[$i]['idProductsize'];	
				$idwarehouse=$resultset[$i]['warehouse'][$j]['idWarehouse'];	
//get total stock
				$qryWHstock="SELECT SUM(WST.sku_accept_qty) AS whStockQty FROM whouse_stock_items AS WST WHERE WST.idProduct='$idproduct' AND WST.idProdSize='$idproductsize' AND WST.idWarehouse='$idwarehouse' AND WST.sku_expiry_date>=NOW()";
				$resultWHstock=$this->adapter->query($qryWHstock,array());
				$resultsetWHstock=$resultWHstock->toArray();
				$ttlstockQty=($resultsetWHstock[0]['whStockQty']=='')?0:$resultsetWHstock[0]['whStockQty'];
//get damage qty
				$qryWHdamage="SELECT SUM(WSD.dmg_prod_qty) AS whDamageQty FROM whouse_stock_damge AS WSD WHERE WSD.idProduct='$idproduct' AND WSD.idProdSize='$idproductsize' AND WSD.idWarehouse='$idwarehouse'";
				$resultWHdamage=$this->adapter->query($qryWHdamage,array());
				$resultsetWHdamage=$resultWHdamage->toArray();
				$ttldamageQty=($resultsetWHdamage[0]['whDamageQty']=='')?0:$resultsetWHdamage[0]['whDamageQty'];
//get return qty
				$qryWHreturn="SELECT SUM(COR.rtnQty) AS custRtnQty FROM customer_order_return AS COR LEFT JOIN dispatch_product_batch AS DPB ON COR.idDispatchProductBatch=DPB.idDispatchProductBatch LEFT JOIN whouse_stock_items AS WST ON WST.idWhStockItem=DPB.idWhStockItem WHERE WST.idProduct='$idproduct' AND WST.idProdSize='$idproductsize' AND WST.idWarehouse='$idwarehouse'";
				$resultWHreturn=$this->adapter->query($qryWHreturn,array());
				$resultsetWHreturn=$resultWHreturn->toArray();

				$ttlreturnQty=($resultsetWHreturn[0]['custRtnQty']=='')?0:$resultsetWHreturn[0]['custRtnQty'];
//order allocate qty
				$qryWHorder="SELECT SUM(WOI.picklistQty) AS whOrderQty FROM orders_allocated AS WO LEFT JOIN orders_allocated_items AS WOI ON WOI.idOrderallocated=WO.idOrderallocate WHERE WOI.idProduct='$idproduct' AND WOI.idProductsize='$idproductsize' AND WO.idWarehouse='$idwarehouse'";
				$resultWHorder=$this->adapter->query($qryWHorder,array());
				$resultsetWHorder=$resultWHorder->toArray();

				$ttlorderQty=($resultsetWHorder[0]['whOrderQty']=='')?0:$resultsetWHorder[0]['whOrderQty'];
//available total stockqty
				$avlStockQtyVal=(($ttlstockQty+$ttlreturnQty) - ($ttldamageQty+$ttlorderQty));
				$tot_stock=number_format( $avlStockQtyVal,2,'.','');
//get reorder level with its qty
				$qryreOrd_lvl="SELECT idCustomer, idWarehouse, idLevel, idPackage, idProduct, idProdSize, re_level, re_qty, re_max_stock, re_min_stock, re_days, ($tot_stock) AS tot_stock FROM inventorynorms WHERE idProduct='$idproduct' AND idProdSize='$idproductsize' AND idWarehouse='$idwarehouse'";
				$resultreOrd_lvl=$this->adapter->query($qryreOrd_lvl,array());
				$resultsetreOrd_lvl=$resultreOrd_lvl->toArray();

				$per_reorder=$resultset[$i]['warehouse'][$j]['re_level']*20/100;
				$status=0;
				$tt=$per_reorder+$resultset[$i]['warehouse'][$j]['re_level'];
if ($tt<=$tot_stock)  //grenn color background in reorder stock qty
{
	$status=1;
}
else if ($resultset[$i]['warehouse'][$j]['re_level']<=$tot_stock) 
{
	$status=2;
}
else
{
	$status=0;
}
$resultset[$i]['warehouse'][$j]['re_level']=$resultsetreOrd_lvl[0]['re_level'];
$resultset[$i]['warehouse'][$j]['re_qty']=$resultsetreOrd_lvl[0]['re_qty'];
$resultset[$i]['warehouse'][$j]['qty']=(int)$tot_stock;
$resultset[$i]['warehouse'][$j]['re_max_stock']=$resultsetreOrd_lvl[0]['re_max_stock'];
$resultset[$i]['warehouse'][$j]['re_min_stock']=$resultsetreOrd_lvl[0]['re_min_stock'];
$resultset[$i]['warehouse'][$j]['re_days']=$resultsetreOrd_lvl[0]['re_days'];
$resultset[$i]['warehouse'][$j]['tot_stock']=$tot_stock;
$resultset[$i]['warehouse'][$j]['status']=$status;


}

}

if(!$resultset) {
	$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
}else{
	$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'message'=>'System config information'];
}
}
if($param->action=='add'){
	$fiedls=$param->Form;
	$factoryId=$fiedls['factory'];
	$ponumber=$fiedls['ponumber'];
	$podate=$fiedls['podate'];
	$selectwareId=$param->wareId;
	$test=$param->wareId;

	for($k=0;$k<count($selectwareId);$k++){
		$warehouseid[]=$selectwareId[$k]['wId'];
		$warehouse=array_unique($warehouseid);
	}

	$selectproId=$param->proId;
	$selectprosizeId=$param->prosizeId;
	$qry="SELECT * FROM  factory_order where idFactoryOrder=?";
	$result=$this->adapter->query($qry,array($fiedls['idFactoryOrder']));
	$resultset=$result->toArray();
	if(!$resultset){
		$this->adapter->getDriver()->getConnection()->beginTransaction();
		try {
			for($l=0;$l<count($warehouse);$l++){
				$datainsert['idFactory']=$factoryId;
				$datainsert['idWarehouse']=$warehouse[$l];
				$datainsert['po_number']=$ponumber;
				$datainsert['po_date']=date('Y-m-d',strtotime($podate));
				$insert=new Insert('factory_order');
				$insert->values($datainsert);
				$statement=$this->adapter->createStatement();
				$insert->prepareStatement($this->adapter, $statement);
				$insertresult=$statement->execute();
				$factId[]=$this->adapter->getDriver()->getLastGeneratedValue();
			}

			for($i=0;$i<count($selectwareId);$i++){

				$productid[]=$selectwareId[$i]['pId'];
				$prosizeid[]=$selectwareId[$i]['sId'];
				$itmqty[]=$selectwareId[$i]['wValue'];

				for($j=0;$j<count($warehouse);$j++){
					if($selectwareId[$i]['wId']==$warehouse[$j]){
						$lastId=$factId[$j];
						$datainsert1['idFactoryOrder']=$lastId;
						$datainsert1['item_qty']=$itmqty[$i];
						$datainsert1['idProduct']=$productid[$i];
						$datainsert1['idProdSize']=$prosizeid[$i];
						$insert1=new Insert('factory_order_items');
						$insert1->values($datainsert1);
						$statement1=$this->adapter->createStatement();
						$insert1->prepareStatement($this->adapter, $statement1);
						$insertresult1=$statement1->execute();
					}
				}
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
return $ret_arr;
}

function orderproductstatus($param){
	if($param->action=='statuslist'){
		$qry="SELECT fm.factoryName as factoryName,fo.idFactory as idFactory,fo.po_number as POnumber,DATE_FORMAT(fo.po_date,'%d-%m-%Y') as POdate
		FROM factory_order as fo 
		LEFT JOIN factory_master as fm ON fm.idFactory=fo.idFactory
		GROUP BY fo.idFactory,fo.po_number,fo.po_date";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		if(!$resultset) {
			$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		}else{
			$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
		}

	}else if($param->action=='productlist'){
		$factory=$param->factoryid;
		$poNumber=$param->ponumbr;

		$product_details="SELECT pd.idProduct,pd.productName,ps.productSize,pp.primarypackname,ps.productPrimaryCount,ps.idProductsize,pd.productCount
		FROM factory_order AS fo
		LEFT JOIN factory_order_items AS foi ON fo.idFactoryOrder=foi.idFactoryOrder
		LEFT JOIN warehouse_master AS wm ON fo.idWarehouse=wm.idWarehouse
		LEFT JOIN product_details as pd ON foi.idProduct=pd.idProduct
		LEFT JOIN product_size as ps ON foi.idProdSize=ps.idProductsize
		LEFT JOIN primary_packaging as pp ON pp.idPrimaryPackaging=ps.idPrimaryPackaging
		WHERE fo.po_number='$poNumber' AND fo.idFactory='$factory' group by pd.idProduct,ps.idProductsize";


		$result=$this->adapter->query($product_details,array());
		$resultset=$result->toArray();


		for($i=0;$i<count($resultset);$i++){
			if ($resultset[$i]['productCount']==1) 
			{
				$resultset[$i]['Unitmeasure']='Units';
			}
			else if ($resultset[$i]['productCount']==2) 
			{
				$resultset[$i]['Unitmeasure']='Kg';
			}
			else if ($resultset[$i]['productCount']==3) 
			{
				$resultset[$i]['Unitmeasure']='gm';
			}
			else if ($resultset[$i]['productCount']==4) 
			{
				$resultset[$i]['Unitmeasure']='mgm';
			}
			else if ($resultset[$i]['productCount']==5) 
			{
				$resultset[$i]['Unitmeasure']='mts';
			}
			else if ($resultset[$i]['productCount']==6) 
			{
				$resultset[$i]['Unitmeasure']='cmts';
			}
			else if ($resultset[$i]['productCount']==7) 
			{
				$resultset[$i]['Unitmeasure']='inches';
			}
			else if ($resultset[$i]['productCount']==8) 
			{
				$resultset[$i]['Unitmeasure']='foot';
			}
			else if ($resultset[$i]['productCount']==9) 
			{
				$resultset[$i]['Unitmeasure']='litre';
			}
			else if ($resultset[$i]['productCount']==10) 
			{
				$resultset[$i]['Unitmeasure']='ml';
			}
			$qrywarehouse="SELECT  *  FROM warehouse_master a ";
			$resultpack=$this->adapter->query($qrywarehouse,array());
			$resultsetwarehse=$resultpack->toArray();
			$idProduct=$resultset[$i]['idProduct'];
			$Productsize=$resultset[$i]['idProductsize'];

			for($j=0;$j<count($resultsetwarehse);$j++) {
				$idWarehouse=$resultsetwarehse[$j]['idWarehouse'];
				$qryware1="SELECT foi.idProduct,fo.idWarehouse,foi.item_qty 
				FROM factory_order as fo 
				LEFT JOIN factory_order_items as foi ON foi.idFactoryOrder=fo.idFactoryOrder where foi.idProduct=? and fo.idWarehouse=? and fo.po_number=? and foi.idProdSize=?";
				$resultfactory=$this->adapter->query($qryware1,array($idProduct,$idWarehouse,$poNumber,$Productsize));
				$resultsetfactitmqty=$resultfactory->toArray();

				$resultset[$i]['idProduct'.$idProduct.$idWarehouse.$poNumber.$Productsize]="$j";


				if(!$resultsetfactitmqty) {
					$resultsetwarehse[$j]['item_qty']="";
					$resultsetwarehse[$j]['idFactoryOrder']="";
				} 
				else {
					$resultsetwarehse[$j]['item_qty']=$resultsetfactitmqty[0]['item_qty'];
				}
			}
			$resultset[$i]['itmqty']=$resultsetwarehse;
		}
		$qry1="SELECT WH.warehouseName,WH.idWarehouse
		FROM factory_order AS FO
		LEFT JOIN factory_master AS FCT ON FO.idFactory=FCT.idFactory
		LEFT JOIN warehouse_master AS WH ON FO.idWarehouse=WH.idWarehouse
		WHERE FO.po_number='$poNumber' AND FO.idFactory='$factory' group by WH.idWarehouse";

		$result1=$this->adapter->query($qry1,array());
		$resultset1=$result1->toArray();

		$qrywar="SELECT wm.idWarehouse as idWarehouse,wm.warehouseName as warehouseName FROM warehouse_master as wm LEFT JOIN warehouse_products as wp ON wp.idWarehouse=wm.idWarehouse WHERE wp.idFactory='$factory' and wm.idWarehousetype=2 GROUP BY idWarehouse ORDER BY idWarehouse";
		$resultwar=$this->adapter->query($qrywar,array());
		$resultsetwar=$resultwar->toArray();

		if(!$resultset || !$resultset1) {
			$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		}else{
			$ret_arr=['code'=>'2','content'=>$resultset,'content1'=>$resultset1,'warehouse'=>$resultsetwar,'status'=>true,'message'=>'Record available'];
		}

	}

	return $ret_arr;
}

function distributemargin($param){
	$hierarchyvalue=$param->hierarchyvalue;


	if($param->action=='productlist'){

		$mdate=date('Y-m-d',strtotime($param->mdate));
		$terititle=$param->terititle;
		$hierarchyvalue=$param->hierarchyvalue;

		$qryAlreadyexist="SELECT * FROM `distribution_margin` WHERE idTerritory='$hierarchyvalue' AND idTerritoryTitle='$terititle' AND distributn_date='$mdate'";
		$resultAlreadyexist=$this->adapter->query($qryAlreadyexist,array());
		$resultsetAlreadyexist=$resultAlreadyexist->toArray();

		if (count($resultsetAlreadyexist)>0)
		{
			$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Already exist'];
		}
		else
		{
			$qryCustomertype="SELECT  idCustomerType as id, custType as name,'0' as product,'0.00' as a_billingprice,'0.00' as b_biilingprice, '' as distributn_unit,'0.00' as marginAmount FROM customertype a where a.status='1' ORDER BY idCustomerType DESC";
			$resultCustomertype=$this->adapter->query($qryCustomertype,array());
			$resultsetCustomertype=$resultCustomertype->toArray();
			$qry="SELECT pd.idProduct,
			pd.productName,
			ps.productSize,
			pp.primarypackname,
			'0.00' as priceAmount,
			gm.idGst,
			gm.gstValue,
			gm.idGst,
			ps.idProductsize,
			pp.idPrimaryPackaging,
			'0.00'  as MRPamount,
			'0.00' as companyCost,
			'0.00' as marginAmount,
			'0.00' as originalmarginAmount,
			'0.00' as b_biilingprice,
			'0.00' as a_billingprice,
			1 as commissionmode,
			'0' as idterritory,
			'' as checked,
			1 as checkvalue,pd.idHsncode
			FROM product_details as pd
			LEFT JOIN gst_master as gm ON gm.idHsncode=pd.idHsncode
			LEFT JOIN product_size as ps ON ps.idProduct=pd.idProduct		
			LEFT JOIN product_territory_details as pt ON pt.idProduct=pd.idProduct
			LEFT JOIN territory_master as tm ON tm.idTerritory=pt.idTerritory
			LEFT JOIN primary_packaging as pp ON pp.idPrimaryPackaging=ps.idPrimaryPackaging where pt.idTerritory='".$hierarchyvalue."' AND pd.status=1 AND ps.status=1 GROUP BY ps.idProductsize ORDER BY pd.idProduct";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			foreach ($resultset as $key => $value)
			{

				$resultset[$key]['checked']=1;
				$resultset[$key]['customertype']=$resultsetCustomertype;
			}
			
			for ($key1=0;$key1<count($resultset); $key1++) 
			{
				$idProduct=$resultset[$key1]['idProduct'];
				$idProductsize=$resultset[$key1]['idProductsize'];
				$mrgnCount=0;
                 $commissionmode=1;
				for ($key2=0;$key2<count($resultset[$key1]['customertype']); $key2++) 
				{

					$idctype=$resultset[$key1]['customertype'][$key2]['id'];

					$qryOldDistribution="SELECT dm.distributn_type,
					dm.distributn_unit

					FROM `distribution_margin` as dm 

					WHERE dm.idProduct='".$idProduct."' AND dm.idProductsize='".$idProductsize."' AND dm.idTerritory='".$hierarchyvalue."'  AND dm.idCustomerType='".$idctype."' ORDER BY dm.distributn_date DESC LIMIT 1";					
					$resultOldDistribution=$this->adapter->query($qryOldDistribution,array());
					$resultsetOldDistribution=$resultOldDistribution->toArray();

					$qryOldBillingprice="SELECT 
					cbp.a_billingprice,
					cbp.b_biilingprice,
					cbp.price,
					cbp.priceMRP,
					cbp.taxPercentage,
					cbp.margin_value,
					cbp.companyCost,
					cbp.commissionPercentage 
					FROM customer_billing_price as cbp 
					WHERE cbp.idProduct='".$idProduct."' AND cbp.idProductsize='".$idProductsize."' AND cbp.idTerritory='".$hierarchyvalue."'  AND cbp.idCustomerType='".$idctype."' AND cbp.a_billingprice>0 AND cbp.b_biilingprice>0 ORDER BY cbp.billingDate DESC LIMIT 1";					
					$resultOldBillingprice=$this->adapter->query($qryOldBillingprice,array());
					$resultsetOldBillingprice=$resultOldBillingprice->toArray();

					if (count($resultsetOldBillingprice)>0) 
					{
						$resultset[$key1]['customertype'][$key2]['b_biilingprice']=$resultsetOldBillingprice[0]['b_biilingprice'];
						$resultset[$key1]['customertype'][$key2]['a_billingprice']=$resultsetOldBillingprice[0]['a_billingprice'];
						$resultset[$key1]['MRPamount']=$resultsetOldBillingprice[0]['priceMRP'];
						$resultset[$key1]['customertype'][$key2]['marginAmount']=$resultsetOldBillingprice[0]['margin_value'];
						$resultset[$key1]['priceAmount']=$resultsetOldBillingprice[0]['price'];
						$resultset[$key1]['gstValue']=$resultsetOldBillingprice[0]['taxPercentage'];
						$resultset[$key1]['companyCost']=$resultsetOldBillingprice[0]['companyCost'];
						$resultset[$key1]['customertype'][$key2]['commissionPercentage']=$resultsetOldBillingprice[0]['commissionPercentage'];
						
						
					}
					else
					{
						$resultset[$key1]['customertype'][$key2]['b_biilingprice']=$resultset[$key1]['b_biilingprice'];
						$resultset[$key1]['customertype'][$key2]['a_billingprice']=$resultset[$key1]['a_billingprice'];
						$resultset[$key1]['customertype'][$key2]['commissionPercentage']=0;
					}
					if (count($resultsetOldDistribution)>0) 
					{
						$commissionmode=$resultsetOldDistribution[0]['distributn_type'];

						$resultset[$key1]['customertype'][$key2]['distributn_unit']=$resultsetOldDistribution[0]['distributn_unit'];
						if ($resultsetOldDistribution[0]['distributn_type']==1) 
						{
							$resultset[$key1]['checked']=1;
							$resultset[$key1]['checkvalue']=1;
							$resultset[$key1]['distributn_type']=1;
						}else if($resultsetOldDistribution[0]['distributn_type']==2)
						{ 
							$resultset[$key1]['checked']=2; 
							$resultset[$key1]['checkvalue']=2;
							$resultset[$key1]['distributn_type']=2;

						}
						else
						{
							$resultset[$key1]['checked']=1; 
							$resultset[$key1]['checkvalue']=1;
							$resultset[$key1]['distributn_type']=1; 	
						}

						$mrgnCount=$mrgnCount+$resultsetOldDistribution[0]['distributn_unit'];

					}

				}
               if ($commissionmode==1) 
               {
               	$resultset[$key1]['marginAmount']=$resultset[$key1]['marginAmount']-$mrgnCount;
               }else if($commissionmode==2)
               {
               	$mrgn=$resultset[$key1]['marginAmount']-(($mrgnCount*$resultset[$key1]['marginAmount'])/100);
               	 $resultset[$key1]['marginAmount']=$mrgn;
               }
				



			}
                
			
              //price change get new margin value ,gst, price, mrp price with old distrubution percenteage
			foreach ($resultset as $key => $value) 
			{
				$qryPrice="SELECT priceAmount,companyCost,idPricefixing FROM `price_fixing` WHERE idTerritory='".$hierarchyvalue."' AND idProduct='".$value['idProduct']."' AND idProductsize='".$value['idProductsize']."' AND status=1 AND DATE_FORMAT(priceDate,'%Y-%m-%d')<=now() ORDER BY idPricefixing DESC LIMIT 1";					
				$resultPrice=$this->adapter->query($qryPrice,array());
				$resultsetPrice=$resultPrice->toArray();

				$resultset[$key]['originalmarginAmount']=$resultsetPrice[0]['priceAmount']-$resultsetPrice[0]['companyCost'];
				$resultset[$key]['marginAmount']=$resultsetPrice[0]['priceAmount']-$resultsetPrice[0]['companyCost'];
				$resultset[$key]['companyCost']=$resultsetPrice[0]['companyCost'];
				
				
                 $qryGST="SELECT idGst,idHsncode,gstValue,status FROM `gst_master` WHERE idHsncode='".$value['idHsncode']."' AND status=1 ORDER BY idGst DESC LIMIT 1";					
				$resultGST=$this->adapter->query($qryGST,array());
				$resultsetGST=$resultGST->toArray();
                 if (count($resultsetGST)>0) {
                 	$taxPercentage=$resultsetGST[0]['gstValue'];
                 	$resultset[$key]['gstValue']=$resultsetGST[0]['gstValue'];
                 }
                 else{
                 	$taxPercentage=$value['gstValue'];
                 }
				


				if($resultsetPrice[0]['priceAmount']!=$resultset[$key]['priceAmount']) 
				{
					$priceAmount=$resultsetPrice[0]['priceAmount'];
					$resultset[$key]['priceAmount']=$resultsetPrice[0]['priceAmount'];
					$MRPamount=$priceAmount+(($taxPercentage*$priceAmount)/100);
					$resultset[$key]['MRPamount']=$MRPamount;
					$resultset[$key]['idPricefixing']=$resultsetPrice[0]['idPricefixing'];
					$k=0;
                     $newMarginCount=0;
					foreach ($value['customertype'] as $key1 => $value1) 
					{

						if ($value1['distributn_unit']>0) 
						{
							$distributn_unit=$value1['distributn_unit'];

                            $newMarginCount=$newMarginCount+$distributn_unit;
							if ($value['commissionmode']==1) 
							{
								if ($k==0) 
								{
									$b_price=$priceAmount-$distributn_unit;
									$a_price=$b_price+($b_price*$taxPercentage)/100;
									$resultset[$key]['customertype'][$key1]['b_biilingprice']=$b_price;
									$resultset[$key]['customertype'][$key1]['a_billingprice']=$a_price;
								}
								else
								{
									$b_price=$b_price-$distributn_unit;
									$a_price=$b_price+($b_price*$taxPercentage)/100; 
									$resultset[$key]['customertype'][$key1]['b_biilingprice']=$b_price;
									$resultset[$key]['customertype'][$key1]['a_billingprice']=$a_price;
								}


							}
							else if($value['commissionmode']==2)
							{
								if ($k==0) 
								{
									$b_price=$priceAmount-(($priceAmount*$distributn_unit)/100);
									$a_price=$b_price+($b_price*$taxPercentage)/100;
									$resultset[$key]['customertype'][$key1]['b_biilingprice']=$b_price;
									$resultset[$key]['customertype'][$key1]['a_billingprice']=$a_price;
								}
								else
								{
									$b_price=$b_price-(($b_price*$distributn_unit)/100);
									$a_price=$b_price+($b_price*$taxPercentage)/100; 
									$resultset[$key]['customertype'][$key1]['b_biilingprice']=$b_price;
									$resultset[$key]['customertype'][$key1]['a_billingprice']=$a_price;
								}
							}
						}
						else
						{
							if ($value['commissionmode']==1) 
							{

								$b_price=$priceAmount;
								$a_price=$b_price+($b_price*$taxPercentage)/100;
								$resultset[$key]['customertype'][$key1]['b_biilingprice']=$b_price;
								$resultset[$key]['customertype'][$key1]['a_billingprice']=$a_price;
							}
							else if($value['commissionmode']==2)
							{

								$b_price=$priceAmount;
								$a_price=$b_price+($b_price*$taxPercentage)/100;
								$resultset[$key]['customertype'][$key1]['b_biilingprice']=$b_price;
								$resultset[$key]['customertype'][$key1]['a_billingprice']=$a_price;

							} 
						}
						$k=$k+1;
					}
					if ($value['commissionmode']==1) {
						$resultset[$key]['marginAmount']=$resultset[$key]['marginAmount']-$newMarginCount;
					}else if($value['commissionmode']==2)
					{
						$resultset[$key]['marginAmount']=$resultset[$key]['marginAmount']-(($resultset[$key]['marginAmount']*$newMarginCount)/100);
					}
					
				}
				else
				{
					 $newMarginCount=0;
					foreach ($value['customertype'] as $key1 => $value1) 
					{

						if ($value1['distributn_unit']>0) 
						{
							$distributn_unit=$value1['distributn_unit'];

                            $newMarginCount=$newMarginCount+$distributn_unit;
                        }
                    }

					if ($value['commissionmode']==1) {
						$resultset[$key]['marginAmount']=$resultset[$key]['marginAmount']-$newMarginCount;
					}else if($value['commissionmode']==2)
					{
						$resultset[$key]['marginAmount']=$resultset[$key]['marginAmount']-(($resultset[$key]['marginAmount']*$newMarginCount)/100);
					}
				}
			}

			for ($i=0; $i < count($resultsetCustomertype); $i++) 
			{ 
				$resultsetCustomertype[$i]['product']=$resultset;
			}
                
			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			}else{
				$ret_arr=['code'=>'2','content'=>$resultset,'custmertypeProduct'=>$resultsetCustomertype,'status'=>true,'message'=>'Record available'];
			}
		}


	}else if($param->action=='distributionlist'){
		$qry="SELECT DATE_FORMAT(dm.distributn_date,'%d-%m-%Y') as distributn_date,dm.idTerritoryTitle,dm.idTerritory,tm.territoryValue FROM distribution_margin as dm LEFT JOIN territory_master as tm ON tm.idTerritory=dm.idTerritory LEFT JOIN territorytitle_master as ttm ON ttm.idTerritoryTitle=dm.idTerritoryTitle GROUP BY dm.idTerritory";

		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		if(!$resultset) {
			$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		}else{
			$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
		}

	}else if($param->action=='add'){

		$fiedls=$param->Form;
		$hiervalue=$param->hierarchy;
		$hierarchy=$param->territoryid;
		$distridate=$param->dmdate;
		$billingprice=$param->billingprice;
       
		$fromdate=date('Y-m-d',strtotime($distridate));
		$commision=$param->commission;
     
		$qry="SELECT * FROM  distribution_margin where idDistributionMargin=?";
		$result=$this->adapter->query($qry,array($fiedls['idDistributionMargin']));
		$resultset=$result->toArray();
		if(!$resultset){
			$this->adapter->getDriver()->getConnection()->beginTransaction();
			try {
				foreach ($commision as $key => $value) {


					$datainsert['idProduct']=$value['productId'];
					$datainsert['idProductsize']=$value['prosizeId'];
					$datainsert['idPrimaryPackaging']=$value['primayId'];
					$datainsert['idTerritory']=$hiervalue;
					$datainsert['idTerritoryTitle']=$hierarchy;
					$datainsert['idCustomerType']=$value['custtypeId'];
					$datainsert['idGst']=$value['gstId'];
					$datainsert['distributn_type']=$value['checkval'];
					$datainsert['distributn_unit']=$value['commsnValue'];
//$datainsert['distributn_percent']=$value['wId'];
					$datainsert['distributn_date']=$fromdate;
					$insert=new Insert('distribution_margin');
					$insert->values($datainsert);
					$statement=$this->adapter->createStatement();
					$insert->prepareStatement($this->adapter, $statement);
					$insertresult=$statement->execute();
					$factId=$this->adapter->getDriver()->getLastGeneratedValue();
				}
                //add billing price
				for ($i=0;$i<count($billingprice);$i++) 
				{
					for ($j=0;$j<count($billingprice[$i]['product']);$j++) 
					{


						$billingpriceinsert['idTerritory']=$billingprice[$i]['product'][$j]['idterritory'];
						$billingpriceinsert['idProduct']=$billingprice[$i]['product'][$j]['idProduct'];
						$billingpriceinsert['idProductsize']=$billingprice[$i]['product'][$j]['idProductsize'];
						$billingpriceinsert['idCustomertype']=$billingprice[$i]['id'];
						$billingpriceinsert['b_biilingprice']=$billingprice[$i]['product'][$j]['b_biilingprice'];
						$billingpriceinsert['a_billingprice']=$billingprice[$i]['product'][$j]['a_billingprice'];
						$billingpriceinsert['margin_value']=$billingprice[$i]['product'][$j]['marginAmount'];
						$billingpriceinsert['commissionMode']=$billingprice[$i]['product'][$j]['commissionmode'];
						$billingpriceinsert['priceMRP']=$billingprice[$i]['product'][$j]['MRPamount'];
						$billingpriceinsert['price']=$billingprice[$i]['product'][$j]['priceAmount'];
						$billingpriceinsert['taxPercentage']=$billingprice[$i]['product'][$j]['gstValue'];
						$billingpriceinsert['commissionPercentage']=$billingprice[$i]['product'][$j]['commissionPercentage'];
						$billingpriceinsert['companyCost']=$billingprice[$i]['product'][$j]['companyCost'];
						

						$billingpriceinsert['billingDate']=$fromdate;
						$billingpriceinsert['created_at']=date("Y-m-d");
						$billingpriceinsert['created_by']=1;
                        
						$billinginsert=new Insert('customer_billing_price');
						$billinginsert->values($billingpriceinsert);
						$billingstatement=$this->adapter->createStatement();
						$billinginsert->prepareStatement($this->adapter, $billingstatement);
						$insertresultbilling=$billingstatement->execute();
						$factId=$this->adapter->getDriver()->getLastGeneratedValue();
					}
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

	}else if($param->action=='editview'){
		$tittle_id=$param->tittleid;
		$disdate=$param->distdate;
		$dist_date=date('Y-m-d',strtotime($disdate));

		$qry="SELECT pd.idProduct,
		pd.productName,
		ps.productSize,
		pp.primarypackname,
		'0.00' as priceAmount,
		gm.idGst,
		gm.gstValue,
		'0.00' as marginAmount,
		'0.00' as originalmarginAmount,
		'0.00' as b_biilingprice,
		'0.00' as a_billingprice,
		gm.idGst,
		ps.idProductsize,
		pp.idPrimaryPackaging,
		'0.00' as companyCost,
		'0.00'  as MRPamount,1 as checked
		FROM product_details as pd
		LEFT JOIN gst_master as gm ON gm.idHsncode=pd.idHsncode
		LEFT JOIN product_size as ps ON ps.idProduct=pd.idProduct
		LEFT JOIN product_territory_details as pt ON pt.idProduct=pd.idProduct
		LEFT JOIN territory_master as tm ON tm.idTerritory=pt.idTerritory
		LEFT JOIN primary_packaging as pp ON pp.idPrimaryPackaging=ps.idPrimaryPackaging 
		LEFT JOIN customer_billing_price as cbp ON cbp.idProduct=pd.idProduct
		where pt.idTerritory='".$tittle_id."' AND pd.status=1 AND ps.status=1 AND cbp.idTerritory='".$tittle_id."' AND cbp.billingDate='".$dist_date."' GROUP BY ps.idProductsize ORDER BY pd.idProduct";

		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();

		$qrycustmr="SELECT  idCustomerType as id, custType as name,'0' as product,'0.00' as a_billingprice,'0.00' as b_biilingprice, '' as distributn_unit  FROM customertype a where a.status='1' ORDER BY idCustomerType DESC";
		$resultpack=$this->adapter->query($qrycustmr,array());
		$resultsetcustmr=$resultpack->toArray();

		for($i=0;$i<count($resultset);$i++){

			$idProduct=$resultset[$i]['idProduct'];
			$idProductsize=$resultset[$i]['idProductsize'];
			$gst=$resultset[$i]['idGst'];
			$resultset[$i]['distribution']=$resultsetcustmr;


		}

		for ($i=0; $i < count($resultset); $i++) 
		{ 

			$idProduct=$resultset[$i]['idProduct'];
			$idProductsize=$resultset[$i]['idProductsize'];
			$mrgnCount=0;
			for ($j=0; $j < count($resultset[$i]['distribution']); $j++) 
			{ 
				$idctype=$resultset[$i]['distribution'][$j]['id'];

				$qryEditDistribution="SELECT dm.distributn_type,
				dm.distributn_unit,
				cbp.a_billingprice,
				cbp.b_biilingprice 
				FROM `distribution_margin` as dm 
				LEFT JOIN customer_billing_price as cbp ON cbp.idCustomertype=dm.idCustomerType 
				WHERE dm.idProduct='".$idProduct."' AND dm.idProductsize='".$idProductsize."' AND dm.idTerritory='".$tittle_id."'  AND dm.idCustomerType='".$idctype."' AND dm.distributn_date='$dist_date'";	

				$resultEditDistribution=$this->adapter->query($qryEditDistribution,array());
				$resultsetEditDistribution=$resultEditDistribution->toArray(); 

				$qryEditDistribution="SELECT dm.distributn_type,
				dm.distributn_unit

				FROM `distribution_margin` as dm 

				WHERE dm.idProduct='".$idProduct."' AND dm.idProductsize='".$idProductsize."' AND dm.idTerritory='".$tittle_id."'  AND dm.idCustomerType='".$idctype."' AND dm.distributn_date='$dist_date'";	

				$resultEditDistribution=$this->adapter->query($qryEditDistribution,array());
				$resultsetEditDistribution=$resultEditDistribution->toArray(); 

				$qryEditBillingprice="SELECT 
				cbp.a_billingprice,
				cbp.b_biilingprice,cbp.margin_value ,cbp.price,
				cbp.priceMRP,
				cbp.taxPercentage,
				cbp.companyCost,
				cbp.commissionPercentage
				FROM 
				customer_billing_price as cbp
				WHERE cbp.idProduct='".$idProduct."' AND cbp.idProductsize='".$idProductsize."' AND cbp.idTerritory='".$tittle_id."'  AND cbp.idCustomerType='".$idctype."' AND cbp.billingDate='".$dist_date."'";	

				$resultEditBillingprice=$this->adapter->query($qryEditBillingprice,array());
				$resultsetEditBillingprice=$resultEditBillingprice->toArray(); 

				if (count($resultsetEditBillingprice)>0) 
				{
					$resultset[$i]['distribution'][$j]['b_biilingprice']=$resultsetEditBillingprice[0]['b_biilingprice'];
					$resultset[$i]['distribution'][$j]['a_billingprice']=$resultsetEditBillingprice[0]['a_billingprice'];
					$resultset[$i]['marginAmount']=$resultsetEditBillingprice[0]['margin_value'];
					$resultset[$i]['MRPamount']=$resultsetEditBillingprice[0]['priceMRP'];
					$resultset[$i]['gstValue']=$resultsetEditBillingprice[0]['taxPercentage'];
					$resultset[$i]['priceAmount']=$resultsetEditBillingprice[0]['price'];
					$resultset[$i]['companyCost']=$resultsetEditBillingprice[0]['companyCost'];
					

				}
				if (count($resultsetEditDistribution)>0) 
				{


					$resultset[$i]['distribution'][$j]['distributn_unit']=$resultsetEditDistribution[0]['distributn_unit'];
					if ($resultsetEditDistribution[0]['distributn_type']==1) 
					{
						$resultset[$i]['checked']=1;
					}else if($resultsetEditDistribution[0]['distributn_type']==2)
					{ 
						$resultset[$i]['checked']=2; 
					}
					else
					{
						$resultset[$i]['checked']=1; 	
					}

					$mrgnCount=$mrgnCount+$resultsetEditDistribution[0]['distributn_unit'];
				}
				else
				{
					$resultset[$i]['checked']=1; 
				}  
			}

//$resultset[$i]['marginAmount']=$resultset[$i]['marginAmount']-$mrgnCount;

		}

		$tittleview="SELECT DATE_FORMAT(dm.distributn_date,'%d-%m-%Y') as dismargindate, 
		dm.idTerritoryTitle,
		dm.idTerritory, 
		tm.territoryValue, 
		ttm.title 
		FROM distribution_margin as dm 
		LEFT JOIN territory_master as tm ON tm.idTerritory=dm.idTerritory
		LEFT JOIN territorytitle_master as ttm ON ttm.idTerritoryTitle=dm.idTerritoryTitle where dm.idTerritory='$tittle_id' and dm.distributn_date='$dist_date'";
		$result1=$this->adapter->query($tittleview,array());
		$resultset1=$result1->toArray();


		if(!$resultset) {
			$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
		}else{
			$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'contents' =>$resultset1,'message'=>'System config information'];
		}
	}else if($param->action=='update'){
		$fiedls=$param->Form;
		$commision=$param->commission;

		$idTerritory=$param->terridata['idTerritory'];
		$idTerritorytitle=$param->terridata['idTerritoryTitle'];
		$dismargindate=date('Y-m-d',strtotime($param->terridata['dismargindate']));


		$this->adapter->getDriver()->getConnection()->beginTransaction();
		try{
			foreach ($commision as $key => $value) {

				$qryExist="SELECT *FROM `distribution_margin`  as dm
				WHERE dm.idProduct='".$value['productId']."' AND dm.idProductsize='".$value['prosizeId']."' AND dm.idTerritory='".$idTerritory."'  AND dm.idCustomerType='".$value['custtypeId']."' AND dm.distributn_date='$dismargindate'";
				$resultExist=$this->adapter->query($qryExist,array());
				$resultsetExist=$resultExist->toArray();

				if (count($resultsetExist)>0)
				{
					$datainsert['idProduct']=$value['productId'];						
					$dataupdate['idProductsize']=$value['prosizeId'];
					$dataupdate['idPrimaryPackaging']=$value['primayId'];
					$dataupdate['idTerritory']=$idTerritory;
					$dataupdate['idTerritoryTitle']=$idTerritorytitle;
					$dataupdate['idCustomerType']=$value['custtypeId'];
					$dataupdate['idGst']=$value['gstId'];
					$dataupdate['distributn_type']=$value['checkval'];
					$dataupdate['distributn_unit']=$value['commsnValue'];
//$datainsert['distributn_percent']=$value['wId'];
					$dataupdate['distributn_date']=$dismargindate;


					$sql = new Sql($this->adapter );
					$update = $sql->update();
					$update->table('distribution_margin');
					$update->set($dataupdate);
					$update->where( array('idProduct' => $value['productId'],'idProductsize'=>$value['prosizeId'],'idTerritory'=>$idTerritory,'distributn_date'=>$dismargindate,'idCustomerType'=>$value['custtypeId']));
					$statement  = $sql->prepareStatementForSqlObject($update);
					$results    = $statement->execute();
				} 
				else
				{
					$datainsert['idProduct']=$value['productId'];
					$datainsert['idProductsize']=$value['prosizeId'];
					$datainsert['idPrimaryPackaging']=$value['primayId'];
					$datainsert['idTerritory']=$idTerritory;
					$datainsert['idTerritoryTitle']=$idTerritorytitle;
					$datainsert['idCustomerType']=$value['custtypeId'];
					$datainsert['idGst']=$value['gstId'];
					$datainsert['distributn_type']=$value['checkval'];
					$datainsert['distributn_unit']=$value['commsnValue'];
//$datainsert['distributn_percent']=$value['wId'];
					$datainsert['distributn_date']=$dismargindate;
					$insert=new Insert('distribution_margin');
					$insert->values($datainsert);
					$statement=$this->adapter->createStatement();
					$insert->prepareStatement($this->adapter, $statement);
					$insertresult=$statement->execute();
				}


				$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];

			}

			for ($i=0;$i<count($fiedls);$i++) 
			{
				for ($j=0;$j<count($fiedls[$i]['distribution']);$j++) 
				{
					$idProduct=$fiedls[$i]['idProduct'];
					$idProductsize=$fiedls[$i]['idProductsize'];
					$idCustomertype=$fiedls[$i]['distribution'][$j]['id'];


					$billingpriceupdate['b_biilingprice']=number_format( (float) $fiedls[$i]['distribution'][$j]['b_biilingprice'], 2, '.', '');;
					$billingpriceupdate['a_billingprice']=number_format( (float) $fiedls[$i]['distribution'][$j]['a_billingprice'],2,'.','');
					$billingpriceupdate['margin_value']=number_format( (float) $fiedls[$i]['marginAmount'],2,'.','');
					$billingpriceupdate['commissionMode']=$fiedls[$i]['checked'];


					$sqlBP = new Sql($this->adapter);
					$updateBP = $sqlBP->update();
					$updateBP->table('customer_billing_price');
					$updateBP->set($billingpriceupdate);
					$updateBP->where( array('idProduct' => $idProduct,'idProductsize'=>$idProductsize,'idTerritory'=>$idTerritory,'billingDate'=>$dismargindate,'idCustomertype'=>$idCustomertype));
					$statementBP  = $sqlBP->prepareStatementForSqlObject($updateBP);
					$resultsBP    = $statementBP->execute();
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
				}
			}

			$this->adapter->getDriver()->getConnection()->commit();
		}
		catch(\Exception $e){
			$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
			$this->adapter->getDriver()->getConnection()->rollBack();
		}

	}
	return $ret_arr;
}

//price fixing
public function price_fixing($param)
{

	if($param->action=="add")
	{
		$idproductsize=($param->idproductsize)?explode(',',$param->idproductsize):'';
		$idcategory=$param->idcategory;
		$idproduct=$param->idproduct;
		$idterritorytitle=$param->idterritorytitle;
		$idterritory=$param->idterritory;
		$price=($param->price)?explode(',',$param->price):'';
		$pricedate=($param->pricedate)?explode(',',$param->pricedate):'';
		$company_price=($param->company_price)?explode(',',$param->company_price):'';
		$userid=$param->userid;
		$status=$param->status;


		if(count($idproductsize)>0)
		{
			$this->adapter->getDriver()->getConnection()->beginTransaction();
			try {
				for($i=0;$i<count($idproductsize);$i++) {

					$datainsert['idTerritoryTitle']=$idterritorytitle;
					$datainsert['idTerritory']=$idterritory;
					$datainsert['idCategory']=$idcategory;
					$datainsert['idProduct']=$idproduct;						
					$datainsert['idProductsize']=$idproductsize[$i];
					$datainsert['priceDate']=date("Y-m-d", strtotime($pricedate[$i]));
					$datainsert['priceAmount']=$price[$i];
					$datainsert['companyCost']=$company_price[$i];
					$datainsert['created_at']=date('Y-m-d H:i:s');;
					$datainsert['created_by']=$userid;
					$datainsert['updated_at']=date('Y-m-d H:i:s');;
					$datainsert['updated_by']=$userid;
					$datainsert['status']=$status;

					$insert=new Insert('price_fixing');
					$insert->values($datainsert);
					$statement=$this->adapter->createStatement();
					$insert->prepareStatement($this->adapter, $statement);
					$insertresult=$statement->execute();
				}
				$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
				$this->adapter->getDriver()->getConnection()->commit();
			}catch(\Exception $e) {
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
				$this->adapter->getDriver()->getConnection()->rollBack();
			}
		}
	}
	else if($param->action=="list")
	{
//echo getcwd() ;

		$qry="SELECT pf.idPricefixing,pf.status,pf.priceAmount,DATE_FORMAT(pf.priceDate,'%d-%m-%Y') as priceDate,pf.companyCost,pf.idProduct,pd.productName,ps.productSize,tm.territoryValue,pd.productCount FROM `price_fixing` as pf LEFT JOIN product_details as pd on pd.idProduct=pf.idProduct LEFT JOIN territory_master as tm on tm.idTerritory=pf.idTerritory LEFT JOIN product_size as ps ON ps.idProductsize=pf.idProductsize order by pf.idPricefixing desc";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		if(!$resultset) {
			$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
		}else{
			$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'message'=>'System config information'];
		}
	}

	else if($param->action=="editview")
	{
		$idpf=$param->idprice_fixing;

		$qry="SELECT pf.idPricefixing,pf.status,pf.priceAmount,DATE_FORMAT(pf.priceDate,'%d-%m-%Y') as priceDate,pf.companyCost,pf.idProduct,pd.productName,ps.productSize,tm.territoryValue,ttm.title,cat.category,pd.productCount FROM `price_fixing` as pf LEFT JOIN product_details as pd on pd.idProduct=pf.idProduct LEFT JOIN territory_master as tm on tm.idTerritory=pf.idTerritory LEFT JOIN product_size as ps ON ps.idProductsize=pf.idProductsize LEFT JOIN territorytitle_master as ttm on ttm.idTerritoryTitle=pf.`idTerritoryTitle` LEFT JOIN category as cat on cat.idCategory=pf.idCategory where  idPricefixing='$idpf'";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		if(!$resultset) {
			$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
		}else{
			$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'message'=>'System config information'];
		}
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

	$qry="SELECT a.primarypackname,a.idPrimaryPackaging,b.idSubPackaging as subpackage FROM primary_packaging as a 
	LEFT JOIN sub_packaging as b ON b.idSubPackaging=a.idSubPackaging  
	where a.primarypackname=? and b.idSubPackaging=? and a.idPrimaryPackaging!=?";
	$result=$this->adapter->query($qry,array($fiedls['primarypackname'],$fiedls['subpackage'],$editid));
	$resultset=$result->toArray();
	if(!$resultset){

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

	$qry="SELECT * FROM product_content where productContent=? and 	idProductContent!=?";
	$result=$this->adapter->query($qry,array($fiedls['productContent'],$editid));
	$resultset=$result->toArray();
	if(!$resultset){

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
// print(count($resultset));exit;
		if(count($resultset)>0) 
		{
			$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'message'=>'System config information'];

		} 
		else 
		{
			$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
		}
	}

	else if($param->action=='catlist')
	{
		$qrycategory="SELECT idCategory,category FROM `category` WHERE status=1";
		$resultcategory=$this->adapter->query($qrycategory,array());
		$resultsetcategory=$resultcategory->toArray();

		if(count($resultsetcategory)>0)  {
			$ret_arr=['code'=>'2','status'=>true,'content' =>$resultsetcategory,'message'=>'data available'];
		} else {
			$ret_arr=['code'=>'1','status'=>false,'message'=>'No record found..'];
		}
	}
	else if($param->action=='subcatlist')
	{
		$catid=($param->idcat)?$param->idcat:'';
		$condition=($catid)?" AND idCategory=".$catid:'';
		$qry="SELECT idSubCategory,subcategory FROM `subcategory` WHERE status=1 $condition";
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
		$catid=($param->idcat)?$param->idcat:'';
		$subcatid=($param->idsubcat)?$param->idsubcat:'';
		$condition=($catid)?" AND idCategory=".$catid:'';
		$subcondition=($subcatid)?" AND idSubCategory=".$subcatid:'';
		$qry="SELECT idProduct,productName FROM `product_details` WHERE status=1 $condition $subcondition";
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
		$qry="SELECT idProductsize,productSize,idProduct FROM `product_size` WHERE $condition";
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

		$qry="SELECT ps.idProductsize,ps.productSize,pd.idProduct,pd.productCount,pp.primarypackname,pp.idPrimaryPackaging FROM product_details as pd LEFT JOIN `product_size` as ps on ps.idProduct=pd.idProduct LEFT JOIN primary_packaging as pp on pp.idPrimaryPackaging=ps.idPrimaryPackaging WHERE pd.idProduct='$productid' AND ps.status=1";
//echo $qry;
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
	else if($param->action=='productsizedata')
	{
// print_r($param);
		$productsizeid=($param->idproductsize)?implode(',',$param->idproductsize):'';
		$productid=($param->idproduct)?$param->idproduct:'';
		$subterritoryid=($param->idsubterritory)?$param->idsubterritory:'';

// current filled data
		$tempprice=$param->tempprice;
		$temppricedate=$param->pricedate;
		$tempcompanycost=$param->companycost;
$tempcurrentid=$param->currentid; // current checked id

$qryUnitmesure="SELECT productCount FROM product_details WHERE idProduct=?";
$resultUnitmesure=$this->adapter->query($qryUnitmesure,array($productid));
$resultsetUnitmesure=$resultUnitmesure->toArray();

$qry="SELECT ps.idProductsize,ps.productSize,ps.`idPrimaryPackaging`,ps.`idSecondaryPackaging`,ps.`productPrimaryCount`,ps.`productSecondaryCount`,sp.secondarypackname,pp.primarypackname FROM `product_size` as ps LEFT JOIN primary_packaging as pp on pp.idPrimaryPackaging=ps.idPrimaryPackaging LEFT JOIN secondary_packaging as sp on sp.idSecondaryPackaging=ps.idSecondaryPackaging WHERE idProductsize in ($productsizeid) order by idProductsize ASC";
$result=$this->adapter->query($qry,array());
$resultset=$result->toArray();

for($i=0;$i<count($resultset);$i++)
{
	$datafinal[$i]['idProductsize']=$resultset[$i]['idProductsize'];
	$datafinal[$i]['productSize']=$resultset[$i]['productSize'];
	$datafinal[$i]['productCount']=$resultsetUnitmesure[0]['productCount'];
	$datafinal[$i]['idPrimaryPackaging']=$resultset[$i]['idPrimaryPackaging'];
	$datafinal[$i]['idSecondaryPackaging']=$resultset[$i]['idSecondaryPackaging'];
	$datafinal[$i]['productPrimaryCount']=$resultset[$i]['productPrimaryCount'];
	$datafinal[$i]['productSecondaryCount']=$resultset[$i]['productSecondaryCount'];
	$datafinal[$i]['primarypackname']=$resultset[$i]['primarypackname'];
	$datafinal[$i]['secondarypackname']=$resultset[$i]['secondarypackname'];
	$datafinal[$i]['priceDate']='';
	$datafinal[$i]['priceAmount']='';
	$datafinal[$i]['temppriceAmount']='';
	$datafinal[$i]['temppriceDate']='';
	$datafinal[$i]['tempcompanycost']='';
	$qryproduct="SELECT DATE_FORMAT(priceDate,'%d-%m-%Y')  as priceDate,priceAmount from price_fixing WHERE idProduct='$productid' and idProductsize='".$resultset[$i]['idProductsize']."' and idTerritory='$subterritoryid'  order by `idPricefixing` DESC limit 1";
$resultproduct=$this->adapter->query($qryproduct,array());
$resultsetproduct=$resultproduct->toArray();
if(count($resultsetproduct)>0)
{
	
		$datafinal[$i]['priceDate']=$resultsetproduct[0]['priceDate'];
		$datafinal[$i]['priceAmount']=$resultsetproduct[0]['priceAmount'];
	
}

}

$limit=count($param->idproductsize);
// put the previes data to the array
for($i=0;$i<count($resultset);$i++)
{
	for($j=0;$j<count($tempprice);$j++)
	{

		if($resultset[$i]['idProductsize']!=$tempcurrentid)
		{
//echo $tempprice[$j];
			$datafinal[$i]['temppriceAmount']=$tempprice[$j];
			$datafinal[$i]['temppriceDate']=$temppricedate[$j];
			$datafinal[$i]['tempcompanycost']=$tempcompanycost[$j];
//echo $datafinal[$i]['temppriceAmount'];
		}

	}
}

$qryproduct="SELECT DATE_FORMAT(priceDate,'%d-%m-%Y')  as priceDate,priceAmount from price_fixing WHERE idProduct='$productid' and idProductsize IN($productsizeid) and idTerritory='$subterritoryid'  order by `idPricefixing` DESC limit $limit";
$resultproduct=$this->adapter->query($qryproduct,array());
$resultsetproduct=$resultproduct->toArray();


if(!$resultset) 
{
	$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
} 
else 
{
	$ret_arr=['code'=>'2','status'=>true,'content' =>$datafinal,'productcontent'=>$resultsetproduct,'message'=>'System config information'];
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
	$qry="SELECT idProductsize,productSize,idProduct FROM `product_size` WHERE $condition";
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
	$qry="SELECT idTerritoryTitle,hierarchy,title FROM `territorytitle_master` WHERE title!='' ";
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
	$t1qry="SELECT tm.idTerritory,tm.idTerritoryTitle,tm.territoryCode,tm.territoryValue,ttlm.title FROM `territory_master` as tm LEFT JOIN territorytitle_master as ttlm on ttlm.idTerritoryTitle=tm.idTerritoryTitle WHERE tm.status=1 AND tm.idTerritoryTitle='$territoryid'";
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
	$datainsert['productReturnDays']=($param->returndays)?$param->returndays:0;
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

	$productid=$param->productid;
	$qry="SELECT PD.idProduct,
	PD.idHsncode,
	hsn.hsn_code,
	hsn.description,
	PD.productCode,
	PD.productName,
	PD.productSubName,
	PD.productVariant1,
	PD.productVariant2,
	PD.productBrand,
	PD.expireDate,
	PD.productShelflife,
	PD.productShelf,
	PD.productReturn,
	PD.productReturnDays,
	PD.productReturnOption,
	PD.dispatchControl,
	PD.productserialNo,
	PD.productserialnoNumeric,
	PD.productserialnoAuto,
	PD.productUnit,
	PD.productCount,
	PD.status,
	C.category,
	SC.subcategory,
	PC.productContent,
	PS.productStatus,
	PP.primarypackname,
	SP.secondarypackname,
	TT.title,
	PD.idSubCategory,
	PD.idCategory,
	PD.idProductStatus,
	PD.idProductContent,
	PD.idTerritoryTitle  
	FROM `product_details` as PD LEFT JOIN category as C on C.idCategory=PD.idCategory 
	LEFT JOIN subcategory as SC on SC.idSubCategory=PD.idSubCategory  
	LEFT JOIN product_content as PC on PC.idProductContent=PD.idProductContent  
	LEFT JOIN product_status as PS on PS.idProductStatus=PD.idProductStatus  
	LEFT JOIN primary_packaging as PP on PP.idPrimaryPackaging=PD.idPrimaryPackaging 
	LEFT JOIN secondary_packaging as SP on SP.idSecondaryPackaging=PD.idSecondaryPackaging LEFT JOIN  territorytitle_master as TT on TT.idTerritoryTitle=PD.idTerritoryTitle LEFT JOIN hsn_details as hsn ON hsn.idHsncode=PD.idHsncode WHERE  PD.idProduct='$productid' GROUP BY PD.idProduct";
	$result=$this->adapter->query($qry,array());
	$resultset=$result->toArray();

//subcategory
	$qrysubcat="SELECT * FROM `subcategory` WHERE idCategory='".$resultset[0]['idCategory']."'";
	$resultsubcat=$this->adapter->query($qrysubcat,array());
	$resultsetsubcat=$resultsubcat->toArray();

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
	$qry_allterrirory="SELECT territoryValue,idTerritory,idTerritoryTitle FROM `territory_master` WHERE idTerritoryTitle='".$resultset[0]['idTerritoryTitle']."' AND status=1";
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
	$qrysize="SELECT T1.idProductsize,T1.Productsize as psize,T1.idPrimaryPackaging as primarypackage,T2.primarypackname,T1.idSecondaryPackaging as secondarypackage,T3.secondarypackname,T1.productPrimaryCount as primarycount,T1.productSecondaryCount as secondarycount,T1.idProduct,T1.productImageLeft as imageleft,T1.productImageRight as imageright,T1.productImageTop as imagetop,T1.productImageBottom as imagebottom,T1.productImageLeftSide as imagesideleft,T1.productImageRightSide as imagesideright
	FROM `product_size` as T1 
	LEFT JOIN primary_packaging as T2 ON T1.idPrimaryPackaging=T2.idPrimaryPackaging
	LEFT JOIN secondary_packaging as T3 ON T1.idSecondaryPackaging=T3.idSecondaryPackaging WHERE idProduct='$productid' AND T1.status=1";
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

	if(!$resultset) 
	{
		$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
	} 
	else 
	{
		$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'contentsize' =>$resultsetsize,'contentterritory' =>$dtt,'contentterritoryid'=>$resultsetterritory,'allteritory'=>$territorystatus,'checkedid'=>$checkedterritoryid,'productsizeformgroup'=>$products_size,'idcheckterritory'=>$idsterritory,'subcat'=>$resultsetsubcat,'message'=>'data available'];

	}
}
else if($param->action=="removeimage")
{

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
else if($param->action=="removePSIZE")
{
//product size inactivate
	$id=$param->id;
	$userid=$param->userid;
	$this->adapter->getDriver()->getConnection()->beginTransaction();
	try {
		$dataInactive['status']=2;
		$dataInactive['updated_by']=$userid;
		$dataInactive['updated_at']=date('Y-m-d H:i:s');

		$sql = new Sql($this->adapter);
		$update = $sql->update();
		$update->table('product_size');
		$update->set($dataInactive);
		$update->where( array('idProductsize'=>$id));
		$statement  = $sql->prepareStatementForSqlObject($update);
		$results    = $statement->execute();
		$ret_arr=['code'=>'2','status'=>true,'message'=>'Product size removed successfully'];
		$this->adapter->getDriver()->getConnection()->commit();
	} catch(\Exception $e) 
	{
		$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
		$this->adapter->getDriver()->getConnection()->rollBack();
	}

}
return $ret_arr;
}

public function removeMultiImage($param)
{


	if($param->action=="removeimage")
	{

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
	$userid=$param->userid;

	$qry="SELECT * FROM product_details a where a.productName=? OR a.productCode=?";
	$result=$this->adapter->query($qry,array($pname,$pcode));
	$resultset=$result->toArray();
	if(count($resultset)>0) 
	{
		$ret_arr=['code'=>'3','status'=>false,'message'=>'Product name or product code already exists'];
	}
	else
	{

		$this->adapter->getDriver()->getConnection()->beginTransaction();
		try {
			$datainsert['productCode']=$param->pcode;
			$datainsert['productName']=$param->pname;					
			$datainsert['idCategory']=$param->category;
			$datainsert['idSubCategory']=$param->subcategory;					
			$datainsert['productBrand']=$param->brand;
			$datainsert['idHsncode']=$param->phsn;
			$datainsert['productShelflife']=(is_numeric($param->selflife)==true)?$param->selflife:0;
			$datainsert['productShelf']=(is_numeric($param->selflifecount)==true)?$param->selflifecount:0;
			$datainsert['expireDate']=(is_numeric($param->expiredate)==true)?$param->expiredate:0;
			$datainsert['productReturn']=(is_numeric($param->policy)==true)?$param->policy:2;
			$datainsert['productReturnDays']=(is_numeric($param->returndays)==true)?$param->returndays:0;
			$datainsert['productReturnOption']=(is_numeric($param->returnoption)==true)?$param->returnoption:2;
			$datainsert['dispatchControl']=(is_numeric($param->dispatchdays)==true)?$param->dispatchdays:0;
			$datainsert['productserialNo']=$param->serialno;
			$datainsert['productserialnoNumeric']=$param->numericnot;
			$datainsert['productserialnoAuto']=$param->automatic;
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
} // subtrritory for close
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
} // product size for close	
} // product size if close


$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
$this->adapter->getDriver()->getConnection()->commit();
} // try close 
catch(\Exception $e) 
{
	$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
	$this->adapter->getDriver()->getConnection()->rollBack();
} //catch close

} // else close
} //else if add close
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
	$datainsert['expireDate']=(is_numeric($param->expiredate)==true)?$param->expiredate:0;
	$datainsert['productShelflife']=(is_numeric($param->selflife)==true)?$param->selflife:0;
	$datainsert['productShelf']=(is_numeric($param->selflifecount)==true)?$param->selflifecount:0;
	$datainsert['productReturn']=(is_numeric($param->policy)==true)?$param->policy:0;
	if($param->policy==1)
	{
		$datainsert['productReturnDays']=$param->returndays;
	}else
	{
		$datainsert['productReturnDays']=0;
	}

	$datainsert['productReturnOption']=(is_numeric($param->returnoption)==true)?$param->returnoption:2;
	$datainsert['dispatchControl']=(is_numeric($param->dispatchdays)==true)?$param->dispatchdays:0;
	$datainsert['productserialNo']=$param->serialno;
	$datainsert['productserialnoNumeric']=$param->numericnot;
	$datainsert['productserialnoAuto']=$param->automatic;
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


//new product size data
	$primerypackage=($param->primarypackage)?explode(',', $param->primarypackage):'';
	$secondarypackage=($param->secondarypackage)?explode(',', $param->secondarypackage):'';
	$primarycount=($param->primarycount)?explode(',', $param->primarycount):'';
	$secondarycount=($param->secondarycount)?explode(',', $param->secondarycount):'';
	$product_size=($param->psize)?explode(',', $param->psize):'';
	$idproductsize=($param->idProductsize)?explode(',', $param->idProductsize):'';

//old product size data
	$oldprimerypackage=($param->oldprimarypackage)?explode(',', $param->oldprimarypackage):0;
	$oldsecondarypackage=($param->oldsecondarypackage)?explode(',', $param->oldsecondarypackage):0;
	$oldprimarycount=($param->oldprimarycount)?explode(',', $param->oldprimarycount):'';
	$oldsecondarycount=($param->oldsecondarycount)?explode(',', $param->oldsecondarycount):0;
	$oldproduct_size=($param->oldproductsize)?explode(',', $param->oldproductsize):0;
	$oldimageleft=($param->oldimageleft)?explode(',', $param->oldimageleft):'';
	$oldimageright=($param->oldimageright)?explode(',', $param->oldimageright):'';
	$oldimagetop=($param->oldimagetop)?explode(',', $param->oldimagetop):'';
	$oldimagebottom=($param->oldimagebottom)?explode(',', $param->oldimagebottom):'';
	$oldimagesideleft=($param->oldimagesideleft)?explode(',', $param->oldimagesideleft):'';
	$oldimagesideright=($param->oldimagesideright)?explode(',', $param->oldimagesideright):'';

	$idpsize=($param->idProductsize)?explode(',',$param->idProductsize):'';

// insert product size data to the product_size table 
	if(count($idpsize)>0)
	{
		for($i=0;$i<count($idpsize);$i++)
		{
			if($idpsize[$i]==0)
			{
				$insertproductsize=new Insert('product_size');
				$product_sizeinsert['idProduct']=$param->edit_id;
				$product_sizeinsert['productSize']=($product_size[$i])?$product_size[$i]:$oldproduct_size[$i];
				if ($primerypackage[$i]) 
				{
					$product_sizeinsert['idPrimaryPackaging']=$primerypackage[$i];
				}
				else if($oldprimerypackage[$i])
				{
					$product_sizeinsert['idPrimaryPackaging']=$oldprimerypackage[$i];
				}
				else
				{
					$product_sizeinsert['idPrimaryPackaging']=0;
				}

				if ($secondarypackage[$i]) 
				{
					$product_sizeinsert['idSecondaryPackaging']=$secondarypackage[$i];
				}
				else
				{
					$product_sizeinsert['idSecondaryPackaging']=0;
				}


				if ($primarycount[$i]) 
				{
					$product_sizeinsert['productPrimaryCount']=$primarycount[$i];
				}
				else if($oldprimarycount[$i])
				{
					$product_sizeinsert['productPrimaryCount']=$oldprimarycount[$i];
				}
				else
				{
					$product_sizeinsert['productPrimaryCount']=0;
				}

				if ($secondarycount[$i]) 
				{

					$product_sizeinsert['productSecondaryCount']=$secondarycount[$i];
				}
				else 
				{
					$product_sizeinsert['productSecondaryCount']=0;
				}




				if ($li[$i]!='') 
				{
					$product_sizeinsert['productImageLeft']=$li[$i];
				}
				else if($oldimageleft[$i]!='')
				{
					$product_sizeinsert['productImageLeft']=$oldimageleft[$i];
				}
				else
				{
					$product_sizeinsert['productImageLeft']='';	
				}


				if ($ri[$i]!='') 
				{
					$product_sizeinsert['productImageRight']=$ri[$i];
				}
				else if($oldimageright[$i]!='')
				{
					$product_sizeinsert['productImageRight']=$oldimageright[$i];
				}
				else
				{
					$product_sizeinsert['productImageRight']='';	
				}


				if ($ti[$i]!='') 
				{
					$product_sizeinsert['productImageTop']=$ti[$i];
				}
				else if($oldimagetop[$i]!='')
				{
					$product_sizeinsert['productImageTop']=$oldimagetop[$i];
				}
				else
				{
					$product_sizeinsert['productImageTop']='';	
				}

				if ($bi[$i]!='') 
				{
					$product_sizeinsert['productImageBottom']=$bi[$i];
				}
				else if($oldimagebottom[$i]!='')
				{
					$product_sizeinsert['productImageBottom']=$oldimagebottom[$i];
				}
				else
				{
					$product_sizeinsert['productImageBottom']='';	
				}

				if ($sli[$i]!='') 
				{
					$product_sizeinsert['productImageLeftSide']=$sli[$i];
				}
				else if($oldimagesideleft[$i]!='')
				{
					$product_sizeinsert['productImageLeftSide']=$oldimagesideleft[$i];
				}
				else
				{
					$product_sizeinsert['productImageLeftSide']='';	
				}

				if ($sri[$i]!='') 
				{
					$product_sizeinsert['productImageRightSide']=$sri[$i];
				}
				else if($oldimagesideright[$i]!='')
				{
					$product_sizeinsert['productImageRightSide']=$oldimagesideright[$i];
				}
				else
				{
					$product_sizeinsert['productImageRightSide']='';	
				}

// $product_sizeinsert['productImageRight']=($ri[$i])?$ri[$i]:$oldimageright[$i];

// $product_sizeinsert['productImageTop']=($ti[$i])?$ti[$i]:$oldimagetop[$i];
// $product_sizeinsert['productImageBottom']=($bi[$i])?$bi[$i]:$oldimagebottom[$i];
// $product_sizeinsert['productImageLeftSide']=($sli[$i])?$sli[$i]:$oldimagesideleft[$i];
// $product_sizeinsert['productImageRightSide']=($sri[$i])?$sri[$i]:$oldimagesideright[$i];
				$product_sizeinsert['created_by']=$param->userid;
				$product_sizeinsert['created_at']=date('Y-m-d H:i:s');
				$product_sizeinsert['updated_by']=$param->userid;
				$product_sizeinsert['updated_at']=date('Y-m-d H:i:s');
				$insertproductsize->values($product_sizeinsert);
				$statementproductsize=$this->adapter->createStatement();
				$insertproductsize->prepareStatement($this->adapter, $statementproductsize);
				$insertresultproductsize=$statementproductsize->execute();
			}
			else
			{
				$product_sizeupdate['idProduct']=$param->edit_id;
				$product_sizeupdate['productSize']=($product_size[$i])?$product_size[$i]:$oldproduct_size[$i];
				if ($primerypackage[$i]) 
				{
					$product_sizeupdate['idPrimaryPackaging']=$primerypackage[$i];
				}
				else if($oldprimerypackage[$i])
				{
					$product_sizeupdate['idPrimaryPackaging']=$oldprimerypackage[$i];
				}
				else
				{
					$product_sizeupdate['idPrimaryPackaging']=0;
				}

				if ($secondarypackage[$i]) 
				{
					$product_sizeupdate['idSecondaryPackaging']=$secondarypackage[$i];
				}

				else
				{
					$product_sizeupdate['idSecondaryPackaging']=0;
				}

				if ($primarycount[$i]) 
				{
					$product_sizeupdate['productPrimaryCount']=$primarycount[$i];
				}
				else if($oldprimarycount[$i])
				{
					$product_sizeupdate['productPrimaryCount']=$oldprimarycount[$i];
				}
				else
				{
					$product_sizeupdate['productPrimaryCount']=0;
				}

				if ($secondarycount[$i]) 
				{

					$product_sizeupdate['productSecondaryCount']=$secondarycount[$i];
				}

				else
				{
					$product_sizeupdate['productSecondaryCount']=0;
				}


				if ($li[$i]!='') 
				{
					$product_sizeupdate['productImageLeft']=$li[$i];
				}
				else if($oldimageleft[$i]!='')
				{
					$product_sizeupdate['productImageLeft']=$oldimageleft[$i];
				}
				else
				{
					$product_sizeupdate['productImageLeft']='';	
				}


				if ($ri[$i]!='') 
				{
					$product_sizeupdate['productImageRight']=$ri[$i];
				}
				else if($oldimageright[$i]!='')
				{
					$product_sizeupdate['productImageRight']=$oldimageright[$i];
				}
				else
				{
					$product_sizeupdate['productImageRight']='';	
				}


				if ($ti[$i]!='') 
				{
					$product_sizeupdate['productImageTop']=$ti[$i];
				}
				else if($oldimagetop[$i]!='')
				{
					$product_sizeupdate['productImageTop']=$oldimagetop[$i];
				}
				else
				{
					$product_sizeupdate['productImageTop']='';	
				}

				if ($bi[$i]!='') 
				{
					$product_sizeupdate['productImageBottom']=$bi[$i];
				}
				else if($oldimagebottom[$i]!='')
				{
					$product_sizeupdate['productImageBottom']=$oldimagebottom[$i];
				}
				else
				{
					$product_sizeupdate['productImageBottom']='';	
				}

				if ($sli[$i]!='') 
				{
					$product_sizeupdate['productImageLeftSide']=$sli[$i];
				}
				else if($oldimagesideleft[$i]!='')
				{
					$product_sizeupdate['productImageLeftSide']=$oldimagesideleft[$i];
				}
				else
				{
					$product_sizeupdate['productImageLeftSide']='';	
				}

				if ($sri[$i]!='') 
				{
					$product_sizeupdate['productImageRightSide']=$sri[$i];
				}
				else if($oldimagesideright[$i]!='')
				{
					$product_sizeupdate['productImageRightSide']=$oldimagesideright[$i];
				}
				else
				{
					$product_sizeupdate['productImageRightSide']='';	
				}

// $product_sizeupdate['productImageLeft']=($li[$i])?$li[$i]:$oldimageleft[$i];
// $product_sizeupdate['productImageRight']=($ri[$i])?$ri[$i]:$oldimageright[$i];
// $product_sizeupdate['productImageTop']=($ti[$i])?$ti[$i]:$oldimagetop[$i];
// $product_sizeupdate['productImageBottom']=($bi[$i])?$bi[$i]:$oldimagebottom[$i];
// $product_sizeupdate['productImageLeftSide']=($sli[$i])?$sli[$i]:$oldimagesideleft[$i];
// $product_sizeupdate['productImageRightSide']=($sri[$i])?$sri[$i]:$oldimagesideright[$i];

				$product_sizeupdate['updated_by']=$param->userid;
				$product_sizeupdate['updated_at']=date('Y-m-d H:i:s');

// $this->adapter->getDriver()->getConnection()->beginTransaction();
// try {
//	print_r($product_sizeupdate);exit;

				$sql = new Sql($this->adapter);
				$update = $sql->update();
				$update->table('product_size');
				$update->set($product_sizeupdate);
				$update->where( array('idProductsize' => $idpsize[$i]));
				$statement  = $sql->prepareStatementForSqlObject($update);
				$results    = $statement->execute();
//$this->adapter->getDriver()->getConnection()->commit();
				$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
// } catch (\Exception $e) {
// $ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again'];
// $this->adapter->getDriver()->getConnection()->rollBack();
// } 

			}

		}

	}



	$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
	$this->adapter->getDriver()->getConnection()->commit();
} catch(\Exception $e) {
	$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
	$this->adapter->getDriver()->getConnection()->rollBack();
}

return $ret_arr;
}
public function stockreturn($param) {
	$userData=$param->userData;
	$userid=$userData['user_id'];
	$usertype=$userData['user_type'];
	$idCustomer=$userData['idCustomer'];

	if($param->action=='stock_customer'){
		$code=$param->code;
//
		$qry="
		SELECT t1.cs_name ,t1.cs_type,t2.custType,t1.idCustomer  FROM customer as t1 LEFT JOIN customertype as t2 ON t2.idCustomerType=t1.cs_type WHERE t1.customer_code='$code' AND t1.cs_serviceby='$idCustomer' ";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();

		if(!$resultset) {
			$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please enter valid customer'];
		} else {
			$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];

		}
	} else if($param->action=='invoice'){
		$cusid=$param->cus_id;

		$qry="SELECT t1.idDispatchVehicle,t2.invoiceNo,DATE_FORMAT(t2.delivery_date,'%d-%m-%Y') as delivery_date,t1.idCustomer FROM dispatch_vehicle as t1
		LEFT JOIN dispatch_customer as t2 ON t2.idDispatchVehicle=t1.idDispatchVehicle
		WHERE t1.idCustomer='$cusid'";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();

		if(!$resultset) {
			$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please enter valid customer'];
		} else {
			$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];

		}
	} else if($param->action=='returndetails'){
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
			$delete = new Delete('customer_order_return');
			$delete->where(['idDispatchProductBatch=?' => $deleteid]);
			$delete->where(['status=?' => 0]);
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
			$qryearqty="SELECT sum(rtnQty) as tot from customer_order_return where idDispatchProductBatch='".$idDispatchProductBatch."' and status=1";
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
			$resultsetrtn[$i]['serialno']='R'.date('dmyhis').'T'.rand(500,999).'N';
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
				$resultsetrtn[$i]['exp_returndays']=$expreturndays;
				if(strtotime($expreturndays)>=strtotime($resultsetrtn[$i]['currentdate'])){
					$resultsetrtn[$i]['retstatus']=true;
				}else{
					$resultsetrtn[$i]['retstatus']=false;
				}

			}


		}
		if(!$resultsetrtn) {
			$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please enter valid customer'];
		} else {
			$ret_arr=['code'=>'2','content'=>$resultsetrtn,'earlyqty'=>$resultsetearqty,'status'=>true,'message'=>'Record available'];

		}
	}else if($param->action=='damagedetails'){
		$dispatchid=$param->dispatchid;
		$primarycount=$param->primarycount;
		$proid=$param->proid;
		$sizeid=$param->sizeid;
		$idOrderItem=$param->idOrderItem;


// $qry="SELECT idDispatchProductBatch from dispatch_product_batch where idDispatchProduct='$dispatchid'";
		$qry="SELECT DPB.idDispatchProductBatch,
		DPB.idDispatchProduct,
		0 as serialno, 
		DPB.idWhStockItem, 
		DPB.qty,
		DATE_FORMAT(WSI.sku_mf_date,'%d-%m-%Y') as sku_mf_date,
		0 as earlyqty,
		DPB.idWhStockItem,
		DC.idOrder,
		DC.idCustomer,
		DC.idLevel,
		DC.idOrderallocate,
		DP.idOrderItem,
		WSI.sku_batch_no
		from dispatch_product_batch as DPB 
		LEFT JOIN dispatch_product as DP ON DP.idDispatchProduct=DPB.idDispatchProduct
		LEFT JOIN dispatch_customer as DC ON DC.idDispatchcustomer=DP.idDispatchcustomer
		LEFT JOIN whouse_stock_items as WSI ON WSI.idWhStockItem=DPB.idWhStockItem where DPB.idDispatchProduct='$dispatchid'";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();	 


		$qrydmg="SELECT DPB.idDispatchProductBatch,0 as batchqty ,DPB.idDispatchProduct,0 as serialno, DPB.idWhStockItem, DPB.qty as disqty,0 as qty, DATE_FORMAT(WSI.sku_mf_date,'%d-%m-%Y') as sku_mf_date  from dispatch_product_batch as DPB LEFT JOIN whouse_stock_items as WSI ON WSI.idWhStockItem=DPB.idWhStockItem where DPB.idDispatchProduct='$dispatchid'";
		$resultdmg=$this->adapter->query($qrydmg,array());
		$resultsetdmg=$resultdmg->toArray();

		for($i=0;$i<count($resultset);$i++)
		{
			$idDispatchProductBatch=$resultsetdmg[$i]['idDispatchProductBatch'];

//picked qty from this customer to another customer
			$qryPickqty="SELECT wsi.idWhStockItem,sum(opi.pickQty) as pickQty  FROM `orders` as ord 
			LEFT JOIN whouse_stock as ws ON ws.po_no=ord.poNumber 
			LEFT JOIN whouse_stock_items as wsi ON wsi.idWhStock=ws.idWhStock 
			LEFT JOIN order_picklist_items as opi ON opi.idWhStockItem=wsi.idWhStockItem
			WHERE ord.idOrder='".$resultset[$i]['idOrder']."' AND wsi.sku_batch_no='".$resultset[$i]['sku_batch_no']."'";
			$resultPickqty=$this->adapter->query($qryPickqty,array());
			$resultsetPickqty=$resultPickqty->toArray();

			$pickQty=($resultsetPickqty[0]['pickQty']!=NULL)?$resultsetPickqty[0]['pickQty']:0;	
			$resultsetdmg[$i]['disqty']=$resultsetdmg[$i]['disqty']-$pickQty;
//get already damage qty
			$damageqty="SELECT sum(dmgQty) as tot from customer_order_damges where idDispatchProductBatch='".$idDispatchProductBatch."' and status=1";
			$resultdamage=$this->adapter->query($damageqty,array());
			$resultsetdamage=$resultdamage->toArray();

			$resultsetdmg[$i]['batchqty']=($resultsetdamage[0]['tot']!=NULL)?$resultsetdamage[0]['tot']:0;
			$resultsetdmg[$i]['qty']=$primarycount*$resultsetdmg[$i]['disqty'];

		}
		for($i=0; $i <count($resultsetdmg) ; $i++){
			$resultsetdmg[$i]['serialno']='D'.date('dmyhis').'M'.rand(500,999).'G';
			$resultsetdmg[$i]['proid']=$proid;
			$resultsetdmg[$i]['sizeid']=$sizeid;
			$resultsetdmg[$i]['idOrderItem']=$idOrderItem;
			$resultsetdmg[$i]['comments']='';
			$resultsetdmg[$i]['idSerialno']='';
			$resultsetdmg[$i]['damageQty']='';

		}

		if(!$resultsetdmg) {
			$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please enter valid customer'];
		} else {
			$ret_arr=['code'=>'2','content'=>$resultsetdmg,'status'=>true,'message'=>'Record available'];

		}
	}
	else if($param->action=='invoicedetails'){
		$dispatchid=$param->dispatchid;
		$idCustomer=$param->idCustomer;
		$qry="SELECT t1.idDispatchcustomer,t1.invoiceNo,DATE_FORMAT(t1.delivery_date,'%d-%m-%Y') as delivery_date,t1.dcNo,t1.delivry_sequence as del_no,t1.idWarehouse,t2.warehouseName FROM dispatch_customer as t1
		LEFT JOIN warehouse_master as t2 ON t2.idWarehouse=t1.idWarehouse
		WHERE t1.idDispatchVehicle='$dispatchid'";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		$customerid=$resultset[0]['idDispatchcustomer'];

		$qryproduct="SELECT t1.idDispatchcustomer,t1.idDispatchProduct,t1.idProduct,t1.idOrderItem,t1.idProdSize,t1.dis_Qty,t2.productName,t2.productReturnDays,t2.productReturn,t2.productCount,t3.productPrimaryCount,t3.productSize,t3.idPrimaryPackaging,t4.primarypackname,0 as dmgqty,0 as rtnqty,0 as rplcqty,0 as msngqty,0 as ttlvolume,0 as dispatch,0 as dmg_qty,0 as rtn_qty,0 as rplc_qty,0 as msng_qty,0 as ttl_volume,0 as dispatchqty FROM dispatch_product as t1
		LEFT JOIN product_details as t2 ON t2.idProduct=t1.idProduct
		LEFT JOIN product_size as t3 ON t3.idProductsize=t1.idProdSize
		LEFT JOIN primary_packaging  as t4 ON t4.idPrimaryPackaging=t3.idPrimaryPackaging
		WHERE t1.idDispatchcustomer='$customerid' AND t2.status=1 AND t3.status=1";

		$resultproduct=$this->adapter->query($qryproduct,array());
		$resultsetproduct=$resultproduct->toArray();


		for ($i=0; $i <count($resultsetproduct) ; $i++) { 

			$prodId=$resultsetproduct[$i]['idProduct'];
			$sizId=$resultsetproduct[$i]['idProdSize'];


			$dispatchQty="SELECT DPB.qty as proQty, DATE_FORMAT(DV.deliveryDate,'%d-%m-%Y') as entryDate, O.poNumber as PORefernce, DC.invoiceNo as DocRefernce 
			from dispatch_product_batch as DPB 
			LEFT JOIN dispatch_product as DP ON DP.idDispatchProduct=DPB.idDispatchProduct 
			LEFT JOIN dispatch_customer as DC ON DC.idDispatchcustomer=DP.idDispatchcustomer 
			LEFT JOIN dispatch_vehicle as DV ON DV.idDispatchVehicle=DC.idDispatchVehicle 
			LEFT JOIN orders as O ON O.idOrder=DC.idOrder 
			LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
			where WHSI.idProduct='$prodId' and WHSI.idProdSize='$sizId' and WHSI.idWarehouse IN (SELECT idWarehouse from warehouse_master where idCustomer='$idCustomer')";

			$resultdispatchQty=$this->adapter->query($dispatchQty,array());
			$resultsetdispatchQty=$resultdispatchQty->toArray();

		}


		for ($i=0; $i <count($resultsetproduct) ; $i++) { 
			$primarycount=$resultsetproduct[$i]['productPrimaryCount'];

			$idDispatchProduct=$resultsetproduct[$i]['idDispatchProduct'];
//pick qty from this customer to another customer (EX:SMS to MS)
			$getPickqty="SELECT  ord.idOrder,wsi.idWhStockItem,opi.pickQty from dispatch_product as dp 
			LEFT JOIN order_items as ordi ON ordi.idOrderitem=dp.idOrderItem
			LEFT JOIN orders as ord ON ord.idOrder=ordi.idOrder 
			LEFT JOIN whouse_stock as ws ON ws.po_no=ord.poNumber
			LEFT JOIN whouse_stock_items as wsi ON wsi.idWhStock=ws.idWhStock
			LEFT JOIN order_picklist_items as opi ON opi.idWhStockItem=wsi.idWhStockItem
			WHERE dp.idDispatchProduct='".$resultsetproduct[$i]['idDispatchProduct']."' AND opi.idProduct='".$resultsetproduct[$i]['idProduct']."' AND opi.idProdSize='".$resultsetproduct[$i]['idProdSize']."'";
			$resultPickqty=$this->adapter->query($getPickqty,array());
			$resultsetPickqty=$resultPickqty->toArray();

			$pickQty=($resultsetPickqty[0]['pickQty']!=NULL)?$resultsetPickqty[0]['pickQty']:0;
			$dspqty=$resultsetproduct[$i]['dis_Qty'];
			$resultsetproduct[$i]['dis_Qty']=$dspqty-$pickQty;
			$dis_Qty=$resultsetproduct[$i]['dis_Qty'];

//already damage qty
			$getdmg="SELECT sum(dmgQty) as dmgTot from dispatch_product_batch as DPB right join customer_order_damges as COD ON COD.idDispatchProductBatch=DPB.idDispatchProductBatch where DPB.idDispatchProduct='".$idDispatchProduct."' and COD.status=1";

			$resultdmg=$this->adapter->query($getdmg,array());
			$resultsetdmg=$resultdmg->toArray();
			$resultsetproduct[$i]['dmgqty']=$resultsetdmg[0]['dmgTot'];
			$resultsetproduct[$i]['dmg_qty']=$resultsetdmg[0]['dmgTot']/$primarycount;
//already return qty
			$getrtn="SELECT sum(rtnQty) as tot from dispatch_product_batch as DPB right join customer_order_return as COR on COR.idDispatchProductBatch=DPB.idDispatchProductBatch where DPB.idDispatchProduct='".$idDispatchProduct."' and COR.status=1";
			$resultrtn=$this->adapter->query($getrtn,array());
			$resultsetrtn=$resultrtn->toArray();

			$resultsetproduct[$i]['rtnqty']=$primarycount*$resultsetrtn[0]['tot'];
			$resultsetproduct[$i]['rtn_qty']=$resultsetrtn[0]['tot'];
//already replace qty
			$getreplace="SELECT sum(replaceQty) as totQty from dispatch_product_batch as DPB right join  customer_order_replacement as rpl on rpl.idDispatchProductBatch=DPB.idDispatchProductBatch where DPB.idDispatchProduct='".$idDispatchProduct."' and rpl.replaceStatus=1";
			$resultreplace=$this->adapter->query($getreplace,array());
			$resultsetreplace=$resultreplace->toArray();

			$resultsetproduct[$i]['rplcqty']=$primarycount*$resultsetreplace[0]['totQty'];
			$resultsetproduct[$i]['rplc_qty']=$resultsetreplace[0]['totQty'];

			$getmissing="SELECT sum(missing_qty) as totQty from dispatch_product_batch as DPB right join  customer_order_missing as ms on ms.idDispatchProductBatch=DPB.idDispatchProductBatch where DPB.idDispatchProduct='".$idDispatchProduct."' and ms.missing_status=1";
			$resultmissing=$this->adapter->query($getmissing,array());
			$resultsetmissing=$resultmissing->toArray();
			$resultsetproduct[$i]['msngqty']=$primarycount*$resultsetmissing[0]['totQty'];
			$resultsetproduct[$i]['msng_qty']=$resultsetmissing[0]['totQty'];
			$resultsetproduct[$i]['dispatch']=$primarycount*$dis_Qty;
			$resultsetproduct[$i]['dispatchqty']=$dis_Qty;
			$resultsetproduct[$i]['ttlvolume']=$resultsetproduct[$i]['dmgqty']+$resultsetproduct[$i]['rtnqty']+$resultsetproduct[$i]['rplcqty']+$resultsetproduct[$i]['msngqty'];
			$resultsetproduct[$i]['ttl_volume']=$resultsetproduct[$i]['dmg_qty']+$resultsetproduct[$i]['rtn_qty']+$resultsetproduct[$i]['rplc_qty']+$resultsetproduct[$i]['msng_qty'];


		}

		if(!$resultset) {
			$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found'];
		} else {
			$ret_arr=['code'=>'2','content'=>$resultset,'product'=>$resultsetproduct,'status'=>true,'message'=>'Record available'];

		}
	}

	return $ret_arr;
}

public function stockreturnadd($param) {
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

			$qryAlreadyreturnQty="SELECT count(*) as alreadyreturnQty FROM `customer_order_return` WHERE idDispatchcustomer='".$resultsetcustmr[$i]['idDispatchcustomer']."' AND idDispatchProductBatch='".$resultsetbatch[$i]['idDispatchProductBatch']."'";
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
						$datainsert['rtnQty']=$returndetails[$i]['returnQty'];
						$datainsert['rtnDate']=date("Y-m-d H:i:s");
						$datainsert['rntCmnts']=($returndetails[$i]['comments'])?$returndetails[$i]['comments']:'';
						$datainsert['idSrialno']=($returndetails[$i]['idSerialno']!='')?implode('|',$returndetails[$i]['idSerialno']):'';

						$datainsert['status']=1;

						$insert=new Insert('customer_order_return');
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
			$qrycmnts="SELECT rntCmnts,DATE_FORMAT(rtnDate,'%d-%m-%Y') as rtnDate,rtnQty FROM  customer_order_return WHERE idDispatchProductBatch='$batchid'";
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

public function stockdamageadd($param) {
	if($param->action=='add'){
		$proid=$param->proid;
		$returnqty=$param->returnqty;
		$creditno=$param->slno;
		$comments=$param->comments;
		$chk_recvd=$param->chk_recvd;
		$quantity=$param->quantity;
		$returndetails=$param->returndetails;

		$qrybatch="SELECT idDispatchProductBatch,qty from dispatch_product_batch where idDispatchProduct='$proid'";
		$resultbatch=$this->adapter->query($qrybatch,array());
		$resultsetbatch=$resultbatch->toArray();
		$qrycustmr="SELECT idDispatchProduct,idDispatchcustomer FROM dispatch_product WHERE idDispatchProduct='$proid'";
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
// get already damage qty
		$alreadyreturnQtycount=0;
		for ($i=0; $i < count($resultsetbatch); $i++) 
		{ 

			$qryAlreadyreturnQty="SELECT count(*) as alreadyreturnQty FROM `customer_order_damges` WHERE idDispatchcustomer='".$resultsetcustmr[$i]['idDispatchcustomer']."' AND idDispatchProductBatch='".$resultsetbatch[$i]['idDispatchProductBatch']."'";
			echo $qryAlreadyreturnQty;
			$resultAlreadyreturnQty=$this->adapter->query($qryAlreadyreturnQty,array());
			$resultsetAlreadyreturnQty=$resultAlreadyreturnQty->toArray();
			$ress=$resultsetAlreadyreturnQty[0]['alreadyreturnQty'];
			$alreadyreturnQtycount=$alreadyreturnQtycount+$ress;
		}

		$isserialNo=false;
		$rps=0;
		$ttls=0;
		for ($i=0; $i < count($returnqty); $i++) 
		{ 
			if ($returnqty[$i]!='') 
			{
//total number of serial number want to be inserted
				$ttls=$alreadyreturnQtycount+$returnqty[$i];
			}

		}

		$alreadyreturnSLNOcount=0;
//$rps=$pcount*$ttls; //currently accept requsted serial number count
		if ($serialNostatus==1) 
		{
//get total number of already inserted  serial number count
			$qryAlreadyreturn="SELECT count(*) as alreadyreturn FROM `product_stock_serialno` WHERE idProduct='$idproduct' AND idProductsize='$idproductsize' AND idWhStockItem='$idWhStockItem' AND status=4";		
			echo $qryAlreadyreturn;	
			$resultAlreadyreturn=$this->adapter->query($qryAlreadyreturn,array());
			$resultsetAlreadyreturn=$resultAlreadyreturn->toArray();
			$alreadyreturnSLNOcount=$resultsetAlreadyreturn[0]['alreadyreturn'];


			if($ttls>$alreadyreturnSLNOcount) 
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
		print_r($isserialNo);exit;
		if($isserialNo==true)
		{
			$this->adapter->getDriver()->getConnection()->beginTransaction();
			try {

				for($i=0;$i<count($resultsetbatch);$i++){
					$j=$i+1;
					$checkvalue="chk_recvd".$j;
					$dmgUnit[$i]=($returnqty[$i]/$quantity[$i])*$resultsetbatch[$i]['qty'];
					if ($returnqty[$i]!='') 
					{
						$datainsert['idDispatchProductBatch']=$resultsetbatch[$i]['idDispatchProductBatch'];
						$datainsert['idDispatchcustomer']=$resultsetcustmr[0]['idDispatchcustomer'];
						$datainsert['credit_note_no']=$creditno[$i];
						$datainsert['dmgQty']=$returnqty[$i];
						$datainsert['dmgUnit']=$dmgUnit[$i];
						$datainsert['dmgRtnDate']=date("Y-m-d H:i:s");
						$datainsert['prdctReturnStatus']=$chk_recvd[$checkvalue];
						$datainsert['dmg_cmnts']=$comments[$i];
						$datainsert['idSerialno']=($returndetails[$i]['idSerialno']!='')?implode(',',$returndetails[$i]['idSerialno']):'';
						$datainsert['status']=1;

						$insert=new Insert('customer_order_damges');
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
		$qrycmnts="SELECT dmg_cmnts,DATE_FORMAT(dmgRtnDate,'%d-%m-%Y') as dmgRtnDate,dmgQty FROM  customer_order_damges WHERE idDispatchProductBatch='$batchid'";
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


public function handlingclaim($param) {
	if($param->action=='list'){
		$customer=$param->customer;
		$enddate=$param->enddate;
		$startdate=$param->startdate;
		$vehicle_id=$param->vehicle_id;

		$qryprimary="SELECT idPrimaryPackaging,primarypackname FROM `primary_packaging` WHERE status=1";
		$resultprimary=$this->adapter->query($qryprimary,array());
		$resultsetprimary=$resultprimary->toArray();


/*$qry="SELECT t1.dcNo,t1.delivery_date,t1.idDispatchcustomer,t2.idProduct,t2.idProdSize,t2.dis_Qty,t3.idPrimaryPackaging,t4.primarypackname,t5.idCustthierarchy ,t6.agencyName,t6.idAgency,0 as totalcharges,0 as packamount FROM dispatch_customer as t1
LEFT JOIN dispatch_product as t2 ON t2.idDispatchcustomer=t1.idDispatchcustomer
LEFT JOIN product_size as t3 ON t3.idProductsize=t2.idProdSize
LEFT JOIN primary_packaging as t4 ON t4.idPrimaryPackaging=t3.idPrimaryPackaging
LEFT JOIN orders as t5 ON t5.idOrder=t1.idOrder
LEFT JOIN agency_master as t6 ON t6.t4=t5.idCustthierarchy
WHERE t1.idCustomer='$customer' AND (t1.delivery_date BETWEEN '$startdate' AND '$enddate')";*/

$qry="SELECT t1.dcNo,DATE_FORMAT(t1.delivery_date, '%d-%m-%Y') as delivery_date,t1.idDispatchVehicle,t1.idDispatchcustomer,t1.idCustomer,t1.idOrder,0 as disqty,0 as totalcharges,0 as packamount FROM dispatch_customer as t1
LEFT JOIN dispatch_vehicle as t2 ON t2.idDispatchVehicle=t1.idDispatchVehicle
WHERE t1.idCustomer='$customer' AND t2.handling_status=0 AND (t1.delivery_date BETWEEN '$startdate' AND '$enddate')";

$result=$this->adapter->query($qry,array());
$resultset=$result->toArray();

$qrypack="SELECT t2.idDispatchcustomer ,t3.idPrimaryPackaging,t4.primarypackname FROM dispatch_product as t2 LEFT JOIN product_size as t3 ON t3.idProductsize=t2.idProdSize LEFT JOIN primary_packaging as t4 ON t4.idPrimaryPackaging=t3.idPrimaryPackaging WHERE t2.idDispatchcustomer in(SELECT idDispatchcustomer from dispatch_customer where idCustomer='$customer' and (delivery_date BETWEEN '$startdate' AND '$enddate')) and t4.status=1 GROUP BY t3.idPrimaryPackaging";

$resultpack=$this->adapter->query($qrypack,array());
$resultsetpack=$resultpack->toArray();

$dispatchid=$resultset[$i]['idDispatchcustomer'];
$orderid=$resultset[$i]['idOrder'];


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
	$ret_arr=['code'=>'2','content'=>$resultset,'primary'=>$resultsetprimary,'package'=>$resultsetpack,'viewcontent'=>$resultsetview,'product'=>$resultsetpro,'status'=>true,'message'=>'Record available'];

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

else if($param->action=='add') 
{
	$vehicleid=$param->vehicleid;
	$handling_charges=$param->handling_charges;

	$qry="SELECT a.handling_charges FROM dispatch_vehicle a where a.idDispatchVehicle='$vehicleid'";

	$result=$this->adapter->query($qry,array());
	$resultset=$result->toArray();

	if(!$resultset) 
	{ 
		$this->adapter->getDriver()->getConnection()->beginTransaction();
		try {

			for($i=0;$i<count($vehicleid);$i++){
				if($handling_charges[$i]!="")
				{
					$datainsert['handling_charges']=$handling_charges[$i];
					$datainsert['handling_status']=1;

					$sql = new Sql($this->adapter );
					$update = $sql->update();
					$update->table('dispatch_vehicle');
					$update->set($datainsert);
					$update->where( array('idDispatchVehicle' => $vehicleid));
					$statement  = $sql->prepareStatementForSqlObject($update);
					$results    = $statement->execute();
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
		$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
	}
}
return $ret_arr;
}

public function transportclaim($param) {
	if($param->action=='add') 
	{
		$vehicleid=$param->vehicleid;
		$app_amnt=$param->app_amnt;

		$this->adapter->getDriver()->getConnection()->beginTransaction();
		try {

			for($i=0;$i<count($app_amnt);$i++){
				if($app_amnt[$i]!="")
				{
					$datainsert['reimburse_amount']=$app_amnt[$i];
					$datainsert['creditnote_status']=1;
					$sql = new Sql($this->adapter );
					$update = $sql->update();
					$update->table('dispatch_vehicle');
					$update->set($datainsert);
					$update->where( array('idDispatchVehicle' => $vehicleid));
					$statement  = $sql->prepareStatementForSqlObject($update);
					$results    = $statement->execute();
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
	return $ret_arr;
}

public function handlingnotes($param) {


	if($param->action=='list'){
		$customer=$param->customer;
		$enddate=$param->enddate;
		$startdate=$param->startdate;
		$qry="SELECT COUNT(t1.idCustomer) as total_acc,SUM(t1.handling_charges) as total_val ,t1.idCustomer FROM dispatch_vehicle as t1 WHERE t1.idCustomer='$customer' AND t1.handling_status!=0 AND (t1.deliveryDate BETWEEN '$startdate' AND '$enddate')";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();


		$qrynotes="SELECT t1.cs_name,COUNT(t2.idCustomer) as cus_count FROM customer as t1
		LEFT JOIN credit_notes_all_types as t2 ON t2.idCustomer=t1.idCustomer
		WHERE t1.idCustomer='$customer'";

		$resultnotes=$this->adapter->query($qrynotes,array());
		$resultsetnotes=$resultnotes->toArray();

		$qrypending="SELECT COUNT(t1.handling_status) as pendingstatus,SUM(t1.handling_charges) AS pending FROM dispatch_vehicle as t1 WHERE t1.idCustomer='$customer' AND t1.handling_status=1";

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

		$qry="SELECT t1.idDispatchVehicle,t1.idCustomer,t1.handling_charges,t1.handling_status, t1.dc_no,t2.cs_name FROM dispatch_vehicle as t1 
		LEFT JOIN customer as t2 ON t2.idCustomer=t1.idCustomer WHERE t1.idCustomer='$customer' AND t1.handling_status!=0 AND (t1.deliveryDate BETWEEN '$startdate' AND '$enddate')";

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
				$datainsert['type']=2;
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
				$dataupdate['handling_status']=2;
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

public function invoicenotes($param) {


	if($param->action=='list'){
		$customer=$param->customer;
		$enddate=$param->enddate;
		$startdate=$param->startdate;
		$qry="SELECT count(inv.idInvoice) as cnt,sum(inv.credit_amt) as tot_amnt, c.cs_name,inv.idCustomer FROM  invoice_status AS inv
		LEFT JOIN customer AS c ON c.idCustomer=inv.idCustomer
		WHERE inv.credit_date BETWEEN '$startdate' AND '$enddate' AND inv.credit_status!=0 AND inv.idCustomer='$customer' group by inv.idCustomer";

		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();


		$qrynotes="SELECT t1.cs_name,COUNT(t2.idCustomer) as cus_count FROM customer as t1
		LEFT JOIN credit_notes_all_types as t2 ON t2.idCustomer=t1.idCustomer
		WHERE t1.idCustomer='$customer'";

		$resultnotes=$this->adapter->query($qrynotes,array());
		$resultsetnotes=$resultnotes->toArray();

		$qrypending="SELECT count(inv.idInvoice) as cnt,sum(inv.credit_amt) as tot_amnt, c.cs_name,inv.idCustomer FROM  invoice_status AS inv
		LEFT JOIN customer AS c ON c.idCustomer=inv.idCustomer
		WHERE inv.credit_date BETWEEN '$startdate' AND '$enddate' AND inv.credit_status=1  AND inv.idCustomer='$customer'  group by inv.idCustomer";

		$resultpending=$this->adapter->query($qrypending,array());
		$resultsetpending=$resultpending->toArray();


		if($resultset[0]['cnt']==0) {

			$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not available'];
		} else {
			$ret_arr=['code'=>'2','content'=>$resultset,'contentnotes'=>$resultsetnotes,'pending'=>$resultsetpending,'status'=>true,'message'=>'Record available'];

		}
	}
	else if($param->action=='view'){
		$customer=$param->customer;
		$startdate=date('Y-m-d',strtotime($param->startdate));
		$enddate=date('Y-m-d',strtotime($param->enddate));
		$qry="SELECT inv.idInvoice,inv.invoice,inv.error_list,inv.credit_status,c.cs_name,inv.idCustomer,inv.credit_amt 
		FROM invoice_status AS inv
		LEFT JOIN customer AS c ON c.idCustomer=inv.idCustomer
		WHERE (inv.credit_date BETWEEN '$startdate' AND '$enddate') AND inv.idCustomer='$customer'  AND inv.credit_status!=0";

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
		$invoiceid=$param->invoiceid;

//credit note insert
		for($i=0;$i<count($customer);$i++){
			$this->adapter->getDriver()->getConnection()->beginTransaction();
			try {

				$datainsert['idCustomer']=$customer[$i];
				$datainsert['credit_note']=$credit_note[$i];
				$datainsert['credit_amnt']=$amount[$i];
				$datainsert['credit_date']=date('Y-m-d H:i:s');
				$datainsert['type']=8;
				$datainsert['status']=0;

				$insert=new Insert('credit_notes_all_types');
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
//invoice payment insert
		for($i=0;$i<count($customer);$i++){
			$this->adapter->getDriver()->getConnection()->beginTransaction();
			try {


				$paydata['idCustomer']=$customer[$i];
				$paydata['payAmt']=$amount[$i];
				$paydata['pay_date']=date('Y-m-d H:i:s');
				$paydata['payType']='On Account';
				$paydata['idCredit']=1;
				$payinsert=new Insert('invoice_payment');
				$payinsert->values($paydata);
				$paystatement=$this->adapter->createStatement();
				$payinsert->prepareStatement($this->adapter, $paystatement);
				$payinsertresult=$paystatement->execute();


				$this->adapter->getDriver()->getConnection()->commit();
				$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
			} catch (\Exception $e) 
			{
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
				$this->adapter->getDriver()->getConnection()->rollBack();
			}
		}
//update data
		for($i=0;$i<count($invoiceid);$i++){
			$this->adapter->getDriver()->getConnection()->beginTransaction();
			try {


				$dataupdate['credit_status']=2;
				$sql = new Sql($this->adapter );
				$update = $sql->update();
				$update->table('invoice_status');
				$update->set($dataupdate);
				$update->where( array('idInvoice' => $invoiceid));
				$statement  = $sql->prepareStatementForSqlObject($update);
				$results    = $statement->execute();

				$this->adapter->getDriver()->getConnection()->commit();
				$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
			} catch (\Exception $e) 
			{
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
				$this->adapter->getDriver()->getConnection()->rollBack();
			}
		}


	}
	return $ret_arr;
}

function orderpurchaseAdd($param)
{

	$product=$param->product;
	$fiedls=$param->Form;
	$factoryId=$fiedls['factory'];
	$ponumber=$fiedls['ponumber'];
	$podate=$fiedls['podate'];
	$selectwareId=$param->wareId;
	$test=$param->wareId;

	for($k=0;$k<count($selectwareId);$k++){
		$warehouseid[]=$selectwareId[$k]['wId'];
		$warehouse=array_unique($warehouseid);
	}

	$selectproId=$param->proId;
	$selectprosizeId=$param->prosizeId;
	$qry="SELECT * FROM  factory_order where idFactoryOrder=?";
	$result=$this->adapter->query($qry,array($fiedls['idFactoryOrder']));
	$resultset=$result->toArray();
	if(!$resultset){
		$this->adapter->getDriver()->getConnection()->beginTransaction();
		try {
			$warids=array_values($warehouse);
			for($l=0;$l<count($warids);$l++){
				$datainsert['idFactory']=$factoryId;
				$datainsert['idWarehouse']=$warids[$l];
				$datainsert['po_number']=$ponumber;
				$datainsert['po_date']=date('Y-m-d',strtotime($podate));

				$insert=new Insert('factory_order');
				$insert->values($datainsert);
				$statement=$this->adapter->createStatement();
				$insert->prepareStatement($this->adapter, $statement);
				$insertresult=$statement->execute();
				$factId[]=$this->adapter->getDriver()->getLastGeneratedValue();
			}


			for($i=0;$i<count($product);$i++){						

				for($j=0;$j<count($product[$i]['warehouse']);$j++)
				{
					if($product[$i]['warehouse'][$j]['qty']!=''){
						for ($k=0; $k < count($warids); $k++) 
						{ 
							if ($warids[$k]==$product[$i]['warehouse'][$j]['idWarehouse']) 
							{
								$lastId=$factId[$k];								
								$datainsert1['idFactoryOrder']=$lastId;
								$datainsert1['item_qty']=$product[$i]['warehouse'][$j]['qty'];
								$datainsert1['idProduct']=$product[$i]['idProduct'];
								$datainsert1['idProdSize']=$product[$i]['idProductsize'];

								$insert1=new Insert('factory_order_items');
								$insert1->values($datainsert1);
								$statement1=$this->adapter->createStatement();
								$insert1->prepareStatement($this->adapter, $statement1);
								$insertresult1=$statement1->execute();
							}
						}

					}
				}
			}

			$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
			$this->adapter->getDriver()->getConnection()->commit();
		}catch(\Exception $e) {
			$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
			$this->adapter->getDriver()->getConnection()->rollBack();
		}
	} else {
		$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
	}

	return $ret_arr;

}

public function SerialReturn($param)
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

public function updateSerialnoReturn($param)
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
			$updateserialNo['status']=3;
			$updateserialNo['idWhStockItem']=$idWhStockItem;
			$updateserialNo['idOrderallocateditems']=$idorderallocateitem;

			$sql = new Sql($this->adapter);
			$update = $sql->update();
			$update->table('product_stock_serialno');
			$update->set($updateserialNo);
			$update->where(array('idProductserialno' =>$idserialno));
			$statement = $sql->prepareStatementForSqlObject($update);
			$results = $statement->execute();

			$updatesno1['status']=6;

			$sqlsno = new Sql($this->adapter);
			$updatesno = $sqlsno->update();
			$updatesno->table('product_stock_serialno');
			$updatesno->set($updatesno1);
			$updatesno->where(array('idProductserialno' =>$resultsetserialno[0]['slno']));
			$statementsno = $sqlsno->prepareStatementForSqlObject($updatesno);
			$resultssno = $statementsno->execute();
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

public function SerialDamage($param)
{
	if($param->action=="list")
	{
		$proid=$param->proid;
		$sizeid=$param->sizeid;
		$whitem=$param->whitem;
		$idOrderItem=$param->idOrderItem;
		$qty=$param->qty;


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

		$totalQty=$qty;

		$qryorders="SELECT idProductserialno,serialno FROM `product_stock_serialno` WHERE idWhStock in(SELECT idWhStock FROM whouse_stock_items WHERE idWhStockItem='$whitem') AND idProduct='$proid' AND idProductsize='$sizeid' AND idOrderallocateditems='$orderallocatedid' AND status=1";        
		$resultorders=$this->adapter->query($qryorders,array());
		$resultsetALLSL=$resultorders->toArray();

//already picked serial number from currunt customer  to another customer
		$qryAlreadPick="SELECT wsi.idWhStockItem,pssno.idProductserialno,pssno.serialno FROM orders as ord 
		LEFT JOIN whouse_stock as ws ON ws.po_no=ord.poNumber
		LEFT JOIN whouse_stock_items as wsi on ws.idWhStock=wsi.idWhStock 
		LEFT JOIN product_stock_serialno as pssno ON pssno.idWhStockItem=wsi.idWhStockItem
		WHERE ord.idOrder='$orderid' AND wsi.sku_batch_no in(SELECT sku_batch_no FROM whouse_stock_items WHERE idWhStockItem='$whitem') AND pssno.status=1";        
		$resultAlreadPick=$this->adapter->query($qryAlreadPick,array());
		$resultsetAlreadPick=$resultAlreadPick->toArray();

//resultsetALLSL get the all the serialno for that customer warehousestock			
//resultsetAlreadPick is how many serialno with  product send from this customer to another customer (EX:SMS to MS)


		foreach ($resultsetALLSL as $key => $value) 
		{
			$a[]=$value['serialno'];
		}
		foreach ($resultsetAlreadPick as $key1 => $value1) 
		{
			$b[]=$value1['serialno'];
		}
//compare SMS and MS and remove MS serial number from SMS get Final serial numbers
//if Already picked an else
		if(count($b)>0){
			$c=array_values(array_diff($a,$b));
		}else{
			$c=$a;
		}
		$k=0;

		for ($i=0; $i < count($c); $i++) 
		{ 

			for ($m=0; $m < count($resultsetALLSL); $m++) 
			{ 
				if ($c[$i]==$resultsetALLSL[$m]['serialno']) 
				{
					$resultsetorders[$k]['idProductserialno']=$resultsetALLSL[$m]['idProductserialno'];
					$resultsetorders[$k]['serialno']=$resultsetALLSL[$m]['serialno'];
					$resultsetorders[$k]['status']=false;
					$resultsetorders[$k]['requiredstatus']=false;

				}

			}

			$k++;
		}

		for ($i=0; $i < $totalQty; $i++) 
		{
			if(count($resultsetorders)>$i){
				$resultsetorders[$i]['status']=true;
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
public function updateSerialnoDamage($param)
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
			$updateserialNo['status']=4;
// $updateserialNo['idWhStockItem']=$idWhStockItem;
// $updateserialNo['idOrderallocateditems']=$idorderallocateitem;

			$sql = new Sql($this->adapter);
			$update = $sql->update();
			$update->table('product_stock_serialno');
			$update->set($updateserialNo);
			$update->where(array('idProductserialno' =>$idserialno));
			$statement = $sql->prepareStatementForSqlObject($update);
			$results = $statement->execute();

			$updatesno1['status']=4;
			$sqlsno = new Sql($this->adapter);
			$updatesno = $sqlsno->update();
			$updatesno->table('product_stock_serialno');
			$updatesno->set($updatesno1);
			$updatesno->where(array('idProductserialno' =>$resultsetserialno[0]['slno']));
			$statementsno = $sqlsno->prepareStatementForSqlObject($updatesno);
			$resultssno = $statementsno->execute();
			$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
			$this->adapter->getDriver()->getConnection()->commit();

		}catch(\Exception $e) {
			$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
			$this->adapter->getDriver()->getConnection()->rollBack();
		}


	}

	return $ret_arr;
}


public function unpickRTNSerialno($param)
{
	$slno=($param->pickslno)?implode(',',$param->pickslno):'';
	$slno2=$param->pickslno;
	for ($i=0; $i <count($slno2) ; $i++) 
	{ 

		$finalslno[]=$slno2[$i];

	}

	$this->adapter->getDriver()->getConnection()->beginTransaction();
	try{

		for ($i=0; $i <count($finalslno) ; $i++) 
		{ 

			$dataupdate['status']=1;

			$sql = new Sql($this->adapter);
			$update = $sql->update();
			$update->table('product_stock_serialno');
			$update->set($dataupdate);
			$update->where(array('idProductserialno' =>$finalslno[$i]));
			$statement  = $sql->prepareStatementForSqlObject($update);
			$results    = $statement->execute();

		}

		$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
		$this->adapter->getDriver()->getConnection()->commit();
	} catch(\Exception $e) {
		$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
		$this->adapter->getDriver()->getConnection()->rollBack();
	}
	return $ret_arr;
}


}