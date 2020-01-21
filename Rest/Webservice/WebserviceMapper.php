<?php
namespace Sales\V1\Rest\Webservice;
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






class WebserviceMapper {

	protected $mapper;
	public function __construct(AdapterInterface $adapter) {
		// date_default_timezone_set("Asia/Manila");
		$this->adapter=$adapter;
	}
	public function fetchOne($param) {
		$from=$param->from;
		$action=$param->action;
		$returnval=$this->$from($param);
		return $returnval; 
	}

	// var beverage = (age >= 21) ? "Beer" : "Juice";

	//Login 
	public function LoginAuth($param){
		if ($param->action=='login') {
			$username = $param->username;
			$password = $param->password;
			$imsi_number = $param->imsi_number;
			if ($username!=null) {
				$bcrypt = new Bcrypt();
				$checklogin = "SELECT * FROM team_member_master WHERE username=? AND status=?";
				$qryform = $this->adapter->query($checklogin, array($username,1));
				$resultarr = $qryform->toArray();

				if (!$resultarr) {
					$result = ['success' => '0', 'message' => 'Login failed'];
				} else {
					$imsi_number_org=$resultarr[0]['imsi_number'];
					$imsi_check=$resultarr[0]['imsi_reset'];
					$securePass = $resultarr[0]['password'];
					$editid = $resultarr[0]['idTeamMember'];

					if ($bcrypt->verify($password, $securePass)) {
						if(($imsi_number_org!='') && ($imsi_number_org!=$imsi_number) && ($imsi_check==0)) {
							$result = ['success' => '2', 'message' => 'Please contact admin'];
						} else {
							$teamMember_id=$resultarr[0]['idTeamMember'];
							$checklogin1 = "SELECT a.idTeamMember as id,a.* FROM team_member_master a WHERE a.imsi_number=? AND a.idTeamMember NOT IN('$teamMember_id')";
							$qryform1 = $this->adapter->query($checklogin1, array($imsi_number));
							$resultarr1 = $qryform1->toArray();

							if($resultarr1) {
								$result = ['success' => '2', 'message' => 'Please contact admin'];
							} else {
								$dataupdate['imsi_number'] = $imsi_number;
								$dataupdate['status'] = '1';
								$dataupdate['imsi_reset'] = '0';
								$sql = new Sql($this->adapter);
								$update = $sql->update();
								$update->table('team_member_master');
								$update->set($dataupdate);
								$update->where(array('idTeamMember' => $teamMember_id));
								$statement = $sql->prepareStatementForSqlObject($update);
								$results = $statement->execute();

								$userdetailsqry = "SELECT T1.idTeamMember, T1.username, T1.code, T1.name, T1.mobileno, T1.emailId, T2.name AS designation ,T1.idSaleshierarchy
									FROM team_member_master  AS T1
									LEFT JOIN designation AS T2 ON T1.designation=T2.idDesignation
									WHERE idTeamMember=?";
								$userdetailsary = $this->adapter->query($userdetailsqry, array($teamMember_id));
								$userdetailsres = $userdetailsary->toArray();

								$sys_config = "SELECT T1.companyLogo, T1.currencyName FROM sys_config  AS T1";
								$sys_configAry = $this->adapter->query($sys_config, array($teamMember_id));
								$sys_configres = $sys_configAry->toArray();
								$sys_configres[0]['companyLogoPath']='uploads/logo/'.$sys_configres[0]['companyLogo'];


								$result = ['success' => '1', 'userdetails' => $userdetailsres, 'sys_config' => $sys_configres, 'message' => 'Login success'];
							}
						}
					}else{
						$result = ['success' => '2', 'message' => 'Invalid password'];
					}
				}
			}else{
				$result = ['success' => '2', 'message' => 'Invalid username'];
			}
		}
		return $result;
	}
	//Profile View
	public function ProfileView($param){
		$idTeamMember = $param->teamMemberId;
		$qry = "SELECT T1.code, T1.idTeamMember, T1.mobileno, T1.landline, T1.emailId, T1.photo, T1.status, T1.address, T1.name AS emp_name, T7.name  AS designation, T2.territoryValue AS state_name, T10.territoryValue AS country_name, T3.territoryValue AS city_name, T4.territoryValue AS pincode, T5.territoryValue AS area, T6.territoryValue AS street,T8.mainGroupName AS main_group_name, T9.subsidaryName AS subsidary_name,
				(CASE
				WHEN T1.isRepManager =1 THEN 'Yes'
				WHEN T1.isRepManager =2 THEN 'No'
				END) AS reporting_manager,
				(CASE
				WHEN T1.proposition =1 THEN 'Product'
				WHEN T1.proposition =2 THEN 'Service'
				WHEN T1.proposition =3 THEN 'Product and service'
				END) AS proposition_type,
				(CASE
				WHEN T1.segment =1 THEN 'Consumer'
				WHEN T1.segment =2 THEN 'Business'
				WHEN T1.segment =3 THEN 'Consumer and business	'
				END) AS segment_type

				FROM team_member_master AS T1 
				LEFT JOIN territory_master AS T2 ON T1.t2=T2.idTerritory
				LEFT JOIN territory_master AS T3 ON T1.t3=T3.idTerritory
				LEFT JOIN territory_master AS T4 ON T1.t4=T4.idTerritory
				LEFT JOIN territory_master AS T5 ON T1.t8=T5.idTerritory
				LEFT JOIN territory_master AS T6 ON T1.t9=T6.idTerritory
				LEFT JOIN designation AS T7 ON T1.designation=T7.idDesignation
				LEFT JOIN maingroup_master AS T8 ON T1.idMainGroup=T8.idMainGroup
				LEFT JOIN subsidarygroup_master AS T9 ON T1.idSubsidaryGroup=T9.idSubsidaryGroup
				LEFT JOIN territory_master AS T10 ON T1.t1=T10.idTerritory
				WHERE T1.idTeamMember=?";
		$result = $this->adapter->query($qry, array($idTeamMember));
		$resultset = $result->toArray();
		if ($resultset[0]['country_name']!='') {
			$addressStr.=$resultset[0]['country_name'].',';
		}
		 if ($resultset[0]['state_name']!='') {
			$addressStr.=$resultset[0]['state_name'].',';
		}
		 if ($resultset[0]['city_name']!='') {
			$addressStr.=$resultset[0]['city_name'].',';
		}
		 if ($resultset[0]['pincode']!='') {
			$addressStr.=$resultset[0]['pincode'].',';
		}
		 if ($resultset[0]['area']!='') {
			$addressStr.=$resultset[0]['area'].',';
		}
		 if ($resultset[0]['street']!='') {
			$addressStr.=$resultset[0]['street'].',';
		}
		$address=rtrim($addressStr, ',');

		$resultset[0]['address']=$address;
		$resultset[0]['profile_photo']='uploads/emp/'.$resultset[0]['photo'];
		if ($resultset != null) {
		    $result = ['success' => '1', 'message' => 'result successfully', 'result' => $resultset];
		} else {
		    $result = ['success' => '2', 'message' => 'result failed'];
		}
		return $result;
	}
	//Customer List
	public function CustomerList($param){
		if ($param->action=='hierarchyList') {
			$qry = "SELECT T1.custType AS customer_type, T1.idCustomerType AS id_customer_type 
					FROM customertype AS T1 
					WHERE T1.status=?";
			$result = $this->adapter->query($qry, array(1));
			$resultset = $result->toArray();
			if ($resultset != null) {
			    $result = ['success' => '1', 'message' => 'result successfully', 'result' => $resultset];
			} else {
			    $result = ['success' => '2', 'message' => 'result failed'];
			}		
		}else if($param->action=='customerList'){
			$idCustomerType = $param->idCustomerType;
			$idUser = $param->idUser;
			$listIndex = 0;
			$listIndex = ($param->listIndex)?$param->listIndex:0;
			$NextIndex = $listIndex+5;
			$TotalData=5;
			//$listIndex=($listIndex>0)?($listIndex+1):$listIndex;
			$limit="LIMIT ".$listIndex.",".$TotalData;
			//total number of customer  assigned in this employee
			$sqlTotalCustomer = "SELECT count(T1.idCustomer) as totalCount 
					FROM customer AS T1 
					LEFT JOIN customertype AS T2 ON T2.idCustomerType=T1.cs_type
					WHERE T1.cs_type=? AND T1.sales_hrchy_name=? AND T1.cs_status=?";
			$resultTotalCustomer = $this->adapter->query($sqlTotalCustomer, array($idCustomerType,$idUser,1));
			$resultsetTotalCustomer = $resultTotalCustomer->toArray();
            $totalCount=$resultsetTotalCustomer[0]['totalCount'];

			$sqlAry = "SELECT T1.idCustomer AS id_customer, T1.cs_name AS name, T1.customer_code AS customer_code, T1.cs_mobno AS mobile_no, T2.custType AS customer_type,
					(CASE
					    WHEN T1.cs_serviceby =0 THEN 'Company'
					    WHEN T1.cs_serviceby !=0 THEN (SELECT A.cs_name FROM customer AS A WHERE A.idCustomer=T1.cs_serviceby)
					END) AS serviceby_name
					FROM customer AS T1 
					LEFT JOIN customertype AS T2 ON T2.idCustomerType=T1.cs_type
					WHERE T1.cs_type=? AND T1.sales_hrchy_name=? AND T1.cs_status=? $limit ";
			$result = $this->adapter->query($sqlAry, array($idCustomerType,$idUser,1));
			$resultset = $result->toArray();

			foreach ($resultset as $key => $value) {

				$sqlOS = "SELECT SUM(T1.invoiceAmt) AS invoiceAmt, 
				(SELECT SUM(A.payAmt) FROM invoice_payment AS A WHERE A.idCustomer=T1.idCustomer AND A.idInvoice!=0) AS payAmt,  
				ABS(SUM(T1.invoiceAmt)-
				(SELECT SUM(A.payAmt) FROM invoice_payment AS A WHERE A.idCustomer=T1.idCustomer AND A.idInvoice!=0)) AS outStanding
						FROM invoice_details AS T1
						WHERE T1.idCustomer=?";
				$resultOS = $this->adapter->query($sqlOS, array($value['id_customer']));
				$resultsetOS = $resultOS->toArray();
				$collectionStatus = ($resultsetOS[$key]['outStanding'] > 0) ? 1 : 0; // 0= No outstandingAmt 

				$resultset[$key]['collectionStatus'] = $collectionStatus;
			}
			

			if ($resultset != null) {
			    $result = ['success' => '1', 'message' => 'result successfully','totalCount'=>$totalCount, 'result' => $resultset];
			} else {
			    $result = ['success' => '2', 'message' => 'result failed'];
			}
		}

		return $result;
	}
	//Order Entry
	public function OrderEntry($param){
		if($param->action=='customerDetails'){
			$idCustomer=$param->idCustomer;

			$orderDetails = "SELECT T1.poNumber	AS po_no FROM orders  AS T1 WHERE T1.idCustomer=? AND T1.status=? ORDER BY T1.poNumber DESC ";
			$orderDetailsRes = $this->adapter->query($orderDetails, array($idCustomer,1));
			$orderDetailsAry = $orderDetailsRes->toArray();
			//Po number Check and Add
			if ($orderDetailsAry) {
				$orderPoNoExp=explode('/', $orderDetailsAry[0]['po_no']);
				$orderNewPoNo=$orderPoNoExp[2]+1;
				$orderPoNo=$orderPoNoExp[0].'/'.$orderPoNoExp[1].'/'.$orderNewPoNo;
			}else{
				$customerDetails = "SELECT T1.cs_name AS name FROM customer  AS T1 WHERE T1.idCustomer=? AND T1.cs_status=?";
				$customerDetailsRes = $this->adapter->query($customerDetails, array($idCustomer,1));
				$customerDetailsAry = $customerDetailsRes->toArray();
				$orderPoNo=$customerDetailsAry[0]['name'].'/ORD/1';
			}
			// Territory title for Delivery point
			$deliverPoint = "SELECT T1.territory_ids, T1.idTerritorytitle FROM customer_allocation  AS T1 WHERE T1.customer_id=?";
			$deliverPointRes = $this->adapter->query($deliverPoint, array($idCustomer));
			$deliverPointAry = $deliverPointRes->toArray();
			$deliverPointUnse=implode(unserialize($deliverPointAry[0]['territory_ids']),',');

			if ($deliverPointUnse) {

				$deliverPointval = "SELECT T1.idTerritory, T1.territoryValue AS delivery_point_value 
				FROM territory_master  AS T1
				WHERE T1.idTerritoryTitle=".$deliverPointAry[0]['idTerritorytitle']." AND T1.idTerritory IN (".$deliverPointUnse.")";
				$deliverPointvalRes = $this->adapter->query($deliverPointval, array());
				$deliverPointvalAry= $deliverPointvalRes->toArray();
			}			
			$sqlAry = "SELECT T1.idCustomer AS id_customer, T1.cs_tinno AS tin_no, T1.cs_name AS name,T1.cs_type AS idCustomerType, T1.customer_code AS customer_code, T1.cs_mobno AS mobile_no, T2.custType AS customer_type,T12.geoValue AS country_name, T11.geoValue AS state_name, T3.geoValue AS city_name, T4.geoValue AS pincode, T8.geoValue AS area, T9.geoValue AS street
			FROM customer AS T1 
			LEFT JOIN customertype AS T2 ON T2.idCustomerType=T1.cs_type
			LEFT JOIN geography AS T12 ON T1.g1=T12.idGeography
			LEFT JOIN geography AS T11 ON T1.g2=T11.idGeography
			LEFT JOIN geography AS T3 ON T1.g3=T3.idGeography
			LEFT JOIN geography AS T4 ON T1.g4=T4.idGeography
			LEFT JOIN geography AS T5 ON T1.g5=T5.idGeography
			LEFT JOIN geography AS T6 ON T1.g6=T6.idGeography
			LEFT JOIN geography AS T7 ON T1.g7=T7.idGeography
			LEFT JOIN geography AS T8 ON T1.g8=T8.idGeography
			LEFT JOIN geography AS T9 ON T1.g9=T9.idGeography
			LEFT JOIN geography AS T10 ON T1.g10=T10.idGeography
			WHERE T1.idCustomer=? AND T1.cs_status=?";
			$result = $this->adapter->query($sqlAry, array($idCustomer,1));
			$resultset = $result->toArray();
			
			foreach ($resultset as $key => $value) {
			if ($value['country_name']!='') {
				$addressStr.=$value['country_name'].',';
			}
			if ($value['state_name']!='') {
				$addressStr.=$value['state_name'].',';
			}
			if ($value['city_name']!='') {
				$addressStr.=$value['city_name'].',';
			}
			if ($value['pincode']!='') {
				$addressStr.=$value['pincode'].',';
			}
			if ($value['area']!='') {
				$addressStr.=$value['area'].',';
			}
			if ($value['street']!='') {
				$addressStr.=$value['street'].',';
			}

			$address=rtrim($addressStr, ',');
			$resultset[$key]['address']=$address;
			}

			if (!$deliverPointvalAry) {
				$deliverPointvalAry="";
			}

			$resultset[0]['orderPoNo']=$orderPoNo;
			if ($resultset != null) {
				$result = ['success' => '1', 'message' => 'result successfully', 'result' => $resultset, 'devliverypoints'=>$deliverPointvalAry];
			} else {
				$result = ['success' => '2', 'message' => 'result failed'];
			}
		}else if($param->action=='productList'){
			$idTerritory=$param->idTerritory;
			$idCustomer=$param->idCustomer;
			$idCustomerType=$param->idCustomerType;

			$sqlAry = "SELECT T1.idProduct AS idVal, T1.idProduct AS idProduct, T3.idProductsize AS idProductsize, T2.productCount AS units, T2.productName AS product_name, T3.productSize AS product_size, T4.primarypackname AS primarypackname, 0 AS check_offer, T3.productPrimaryCount AS qty,2 as checked,0 as orderQty,0 as discountAmount,0 as totalPrice,0 as netPrice,T2.idHsncode,gst.gstValue as gstPercentage
					FROM product_territory_details AS T1 
					LEFT JOIN product_details AS T2 ON T1.idProduct=T2.idProduct
					LEFT JOIN product_size AS T3 ON T1.idProduct=T3.idProduct
					LEFT JOIN primary_packaging AS T4 ON T3.idPrimaryPackaging=T4.idPrimaryPackaging
					INNER JOIN price_fixing AS pf ON pf.idProduct=T2.idProduct
					INNER JOIN gst_master as gst ON gst.idHsncode=T2.idHsncode
					WHERE T1.idTerritory=? AND T2.status=? AND T3.status=? AND pf.priceAmount>0 GROUP BY idProduct,idProductsize ORDER by idProduct ";
				// echo $sqlAry;
			$result = $this->adapter->query($sqlAry, array($idTerritory,1,1));
			$resultset = $result->toArray();
					//Check this product has offer or not

			$productOffer = "SELECT T1.idScheme AS idVal, T1.idProduct AS idProduct, T3.idProductsize AS idProductsize, T2.productCount AS units, T2.productName AS product_name, T3.productSize AS product_size, T4.primarypackname AS primarypackname, 1 AS check_offer, T1.scheme_product_qty AS qty
							FROM scheme AS T1
							LEFT JOIN product_details AS T2 ON T1.idProduct=T2.idProduct
							LEFT JOIN product_size AS T3 ON T1.scheme_product_size=T3.idProductsize
							LEFT JOIN primary_packaging AS T4 ON T3.idPrimaryPackaging=T4.idPrimaryPackaging
							WHERE  T1.idTerritory='".$idTerritory."' AND T2.status=1 AND T3.status=1 AND ((T1.idCustomer IS NULL ) OR (T1.idCustomer='".$idCustomer."')) AND T1.idCustomerType='".$idCustomerType."' AND CURDATE()>=T1.schemeStartdate AND CURDATE()<=T1.schemeEnddate";
			$productOfferRes = $this->adapter->query($productOffer,array());
			$productOfferAry = $productOfferRes->toArray();

			$productPriceQry = "SELECT (pf.priceAmount-(dm.distributn_unit*pf.priceAmount/100)) AS productPrice, pd.idProduct, ps.idProductsize  
								FROM product_details AS pd 
								LEFT JOIN product_size AS ps ON ps.idProduct=pd.idProduct 
								LEFT JOIN price_fixing AS pf ON pf.idProductsize=ps.idProductsize 
								LEFT JOIN distribution_margin AS dm ON dm.idProductsize=ps.idProductsize 
								WHERE pd.status=1 AND ps.status=1 AND dm.idCustomerType='".$idCustomerType."' AND pf.priceAmount>0 GROUP BY idProductsize ORDER BY idProduct";
			$productPriceRes = $this->adapter->query($productPriceQry,array());
			$productPriceAry = $productPriceRes->toArray();



			if ($resultset) {
				foreach ($resultset as $key => $value) {
					// check offer
					foreach ($productOfferAry as $key1 => $value1) {
						if ($value['idProduct']==$value1['idProduct'] && $value['idProductsize']==$value1['idProductsize'] ) {
							$resultset[$key]['check_offer']=1;
						}
					}
				$qryCheckOffer="SELECT * FROM `scheme` WHERE (idCustomer='".$idCustomer."' OR idCustomerType='".$idCustomerType."') AND idTerritory='".$idTerritory."' AND  CURDATE()>=schemeStartdate AND CURDATE()<=schemeEnddate AND idProduct='".$value['idProduct']."' AND scheme_product_size='".$value['idProductsize']."'";
				$resCheckOffer=$this->adapter->query($qryCheckOffer,array());
				$resultCheckOffer=$resCheckOffer->toArray();
				if (count($resultCheckOffer)>0) 
				{
					$resultset[$key]['check_offer']=1;
				}

					$qryPrice="SELECT `b_biilingprice` as originalPrice FROM `customer_billing_price` WHERE idProduct='".$value['idProduct']."' AND idProductsize='".$value['idProductsize']."' AND idTerritory='".$idTerritory."' AND idCustomertype='".$idCustomerType."' AND billingDate<=CURRENT_DATE  AND b_biilingprice>0 ORDER BY created_at desc LIMIT 1";
							$resPrice=$this->adapter->query($qryPrice,array());
							$resultPrice=$resPrice->toArray();
					//Product Price Fixing
							if (count($resultPrice)>0)
							 {
								$resultset[$key]['productPrice']=$resultPrice[0]['originalPrice'];
							}
					// foreach ($productPriceAry as $key2 => $value2) {
					// 	if ($value['idProduct']==$value2['idProduct'] && $value['idProductsize']==$value2['idProductsize'] ) {
					// 		$resultset[$key]['productPrice']=number_format($value2['productPrice'],2);
					// 	}
					// }
				}
			}

		//selected  delivery point is union state or normal state
		$qrystateUnion="SELECT tmm.t2,tm.idTerritory,tm.territoryValue,tm.territoryUnion FROM `territorymapping_master` as tmm LEFT JOIN territory_master as tm on tm.idTerritory=tmm.t2 WHERE tmm.t1='$idTerritory' or tmm.t2='$idTerritory' or tmm.t3='$idTerritory' or tmm.t4='$idTerritory' or tmm.t5='$idTerritory' or tmm.t6='$idTerritory' or tmm.t7='$idTerritory' or tmm.t8='$idTerritory' or tmm.t9='$idTerritory' or tmm.t10='$idTerritory' AND tm.status=1";
			$resultstateUnion=$this->adapter->query($qrystateUnion,array());
			$resultsetstateUnion=$resultstateUnion->toArray();
        
        //prefered warehouse  for tax
			$qrycustomer="SELECT cus.idCustomer,cus.customer_code,cus.cs_name,cus.cs_type,cus.idPreferredwarehouse,wm.t2,tm.territoryUnion
FROM `customer` as cus  
LEFT JOIN warehouse_master as wm on wm.idWarehouse=cus.idPreferredwarehouse
LEFT JOIN territory_master as tm on tm.idTerritory=wm.t2
WHERE cus.idCustomer=? AND cus.cs_status=1";
			$resultcustomer=$this->adapter->query($qrycustomer,array($idCustomer));
			$resultsetcustomer=$resultcustomer->toArray();

			 if($resultsetstateUnion[0]['idTerritory']==$resultsetcustomer[0]['t2'])
          {
             //within state or union territory
             if($resultsetcustomer[0]['territoryUnion']==2 && $resultsetstateUnion[0]['territoryUnion']==2)
             {
               $codestateGST=1; //within state
             }
             else
             {
                $codestateGST=2; //within union territory
             }
          }
          else if($resultsetstateUnion[0]['idTerritory']!=$resultsetcustomer[0]['t2'])
          {
            //state to state or union to state or state to union
             if($resultsetcustomer[0]['territoryUnion']==2 && $resultsetstateUnion[0]['territoryUnion']==2)
             {
               $codestateGST=3; // state to state
             }
             else if($resultsetcustomer[0]['territoryUnion']==1 && $resultsetstateUnion[0]['territoryUnion']==2)
             {
              $codestateGST=4; // state to union
             }
             else if($resultsetcustomer[0]['territoryUnion']==2 && $resultsetstateUnion[0]['territoryUnion']==1)
             {
               $codestateGST=5; // union to state
             }

          }
                
				$cgstPercentage=0;
				$sgstPercentage=0;
				$igstPercentage=0;
				$utgstPercentage=0;
		     $qrytaxsplit="SELECT idTaxSplit,cgst,sgst,igst,utgst FROM `tax_split` WHERE taxtype=?";
		$restaxsplit=$this->adapter->query($qrytaxsplit,array($codestateGST));
		$resulttaxsplit=$restaxsplit->toArray();
		if (count($resulttaxsplit)>0) 
		{
			$cgstPercentage=$resulttaxsplit[0]['cgst'];
			$sgstPercentage=$resulttaxsplit[0]['sgst'];
			$igstPercentage=$resulttaxsplit[0]['igst'];
			$utgstPercentage=$resulttaxsplit[0]['utgst'];
		}
			$overallCGSTamount=0;
			$overallSGSTamount=0;
			$overallIGSTamount=0;
			$overallUTGSTamount=0;
			$overallTotalGST=0;
			$overallTotalprice=0;
			for ($i=0; $i <count($resultset) ; $i++) 
			{ 
				
				$qryproductAddcart = "SELECT orderQty as orderQty,status,idAddcart FROM `empAddcart` WHERE idTerritory='$idTerritory' AND idCustomer='$idCustomer' AND idProduct='".$resultset[$i]['idProduct']."' AND idProductsize='".$resultset[$i]['idProductsize']."' AND status=1";
			$resultproductAddcart = $this->adapter->query($qryproductAddcart,array());
			$resultsetproductAddcart = $resultproductAddcart->toArray();
			
				if (count($resultsetproductAddcart)>0) 
				{
				$resultset[$i]['checked']=($resultsetproductAddcart[0]['status']!='')?$resultsetproductAddcart[0]['status']:2;
				$resultset[$i]['orderQty']=($resultsetproductAddcart[0]['orderQty']!='')?$resultsetproductAddcart[0]['orderQty']:0;
				$resultset[$i]['idAddcart']=($resultsetproductAddcart[0]['idAddcart']!='')?$resultsetproductAddcart[0]['idAddcart']:0;
                    // print_r($resultset[$key]['productPrice']);
				$ttlPrice=$resultsetproductAddcart[0]['orderQty']*$resultset[$i]['productPrice'];
			
				$resultset[$i]['totalPrice']=$ttlPrice;
				$resultset[$i]['netPrice']=$ttlPrice;
                //each product gst calculation
				$totalGSTamount=($ttlPrice*$resultset[$i]['gstPercentage'])/100;
				$cgstOriginalPercentage=($resultset[$i]['gstPercentage']*$cgstPercentage)/100;
				$sgstOriginalPercentage=($resultset[$i]['gstPercentage']*$sgstPercentage)/100;
				$igstOriginalPercentage=($resultset[$i]['gstPercentage']*$igstPercentage)/100;
				$ugstOriginalPercentage=($resultset[$i]['gstPercentage']*$utgstPercentage)/100;

				$cgstAmount=($ttlPrice*$cgstOriginalPercentage)/100;
				$sgstAmount=($ttlPrice*$sgstOriginalPercentage)/100;
				$igstAmount=($ttlPrice*$igstOriginalPercentage)/100;
				$ugstAmount=($ttlPrice*$ugstOriginalPercentage)/100;
                //overall gst calculation
               
				$overallCGSTamount=$overallCGSTamount+$cgstAmount;
				$overallSGSTamount=$overallSGSTamount+$sgstAmount;
				$overallIGSTamount=$overallIGSTamount+$igstAmount;
				$overallUTGSTamount=$overallUTGSTamount+$ugstAmount;
                $overallTotalGST=$overallTotalGST+$totalGSTamount;

				$resultset[$i]['cgstPercent']=$cgstOriginalPercentage;
				$resultset[$i]['sgstPercent']=$sgstOriginalPercentage;
				$resultset[$i]['igstPercent']=$igstOriginalPercentage;
				$resultset[$i]['ugstPercent']=$ugstOriginalPercentage;

				$resultset[$i]['cgstAmount']=$cgstAmount;
				$resultset[$i]['sgstAmount']=$sgstAmount;
				$resultset[$i]['igstAmount']=$igstAmount;
				$resultset[$i]['ugstAmount']=$ugstAmount;

				$resultset[$i]['totalGSTamount']=$totalGSTamount;

                   //discount for ordered ad cart product only
				   $qryDiscount="SELECT idScheme,
schemeType,
idCustomerType,
schemeStartdate,
schemeEnddate,
idCategory,
idSubCategory,
idProduct,
scheme_product_size,
scheme_product_qty,
scheme_flat_discount,
discount_type,
free_product_size,
free_product_qty,
free_product FROM `scheme` WHERE idTerritory='$idTerritory' AND idProduct='".$resultset[$i]['idProduct']."' AND scheme_product_size='".$resultset[$i]['idProductsize']."' AND schemeStartdate<=CURRENT_DATE and schemeEnddate>=CURRENT_DATE AND (idCustomer='$idCustomer' OR idCustomerType='$idCustomerType')";
			$resultDiscount=$this->adapter->query($qryDiscount,array());
			$resultsetDiscount=$resultDiscount->toArray();
			if (count($resultsetDiscount)>0) 
			{

				$Discountprice=$resultsetDiscount[0]['scheme_flat_discount']; //discount amount or percentage
					$discountProductQty= $resultsetDiscount[0]['scheme_product_qty']; //discount qty 
					$orderQty=($resultsetproductAddcart[0]['orderQty']!='')?$resultsetproductAddcart[0]['orderQty']:0;
				if ($resultsetDiscount[0]['schemeType']==1 && $resultsetDiscount[0]['discount_type']==1  ) 
				{
					//discount amount for order qty fullfill  1 discount
					
				  $discountQty=$orderQty/$discountProductQty;
				  $discountAmount=floor($discountQty)*$Discountprice;
				  $resultset[$i]['discountAmount']=$discountAmount;
				  $resultset[$i]['netPrice']=$ttlPrice-$discountAmount;
				}
				else if($resultsetDiscount[0]['schemeType']==1 && $resultsetDiscount[0]['discount_type']==2)
				{
					
					$pricePreProduct=$resultset[$i]['productPrice']; // price for single product

					//$finalprice=$pricePreProduct*$discountProductQty; //total no of set percentage discount
                   $discountCalc=($orderQty/$discountProductQty); //how many time discount
                   $discountQty=floor($discountCalc)*$discountProductQty; // total discount percentage
                   $discountCalcPrice=$discountQty*$discountProductQty/100;

				  $discountAmount=$discountCalcPrice*floor($discountCalc);
				  $resultset[$i]['discountAmount']=$discountAmount;
				   $resultset[$i]['netPrice']=$ttlPrice-$discountAmount;
				}
				else if($resultsetDiscount[0]['schemeType']==2)
				{
					$free_product_qty=$resultsetDiscount[0]['free_product_qty'];
					$freeprdQty=($orderQty)/$discountProductQty;
					$finalFreeqty=floor($freeprdQty)*$free_product_qty;

					$qryFreeproduct="SELECT idProduct,productCode,productName FROM `product_details` WHERE idProduct='".$resultsetDiscount[0]['free_product']."'";
			$resultFreeproduct=$this->adapter->query($qryFreeproduct,array());
			$resultsetFreeproduct=$resultFreeproduct->toArray();
			$resultsetFreeproduct[0]['freeQty']=$finalFreeqty;
			$resultsetFreeproduct[0]['idProductsize']=$resultsetDiscount[0]['free_product_size'];
			$resultsetFreeproduct[0]['idScheme']=$resultsetDiscount[0]['idScheme'];
            
                   $resultset[$i]['offers']=$resultsetFreeproduct;
				}
				else if($resultsetDiscount[0]['schemeType']==3)
				{
					$free_product_qty=$resultsetDiscount[0]['free_product_qty'];
					$freeprdQty=($orderQty)/$discountProductQty;
					$finalFreeqty=floor($freeprdQty)*$free_product_qty;

					$qryFreeproduct="SELECT idProduct,productCode,productName FROM `product_details` WHERE idProduct='".$resultsetDiscount[0]['free_product']."'";
			$resultFreeproduct=$this->adapter->query($qryFreeproduct,array());
			$resultsetFreeproduct=$resultFreeproduct->toArray();
			$resultsetFreeproduct[0]['freeQty']=$finalFreeqty;
			$resultsetFreeproduct[0]['idProductsize']=$resultsetDiscount[0]['free_product_size'];
			$resultsetFreeproduct[0]['idScheme']=$resultsetDiscount[0]['idScheme'];
                   $resultset[$i]['offers']=$resultsetFreeproduct;
				}

			}
				
			 $overallTotalprice=$overallTotalprice+$resultset[$i]['netPrice'];

						
				}


				
             

			}

$grandTotalprice=$overallTotalprice+$overallTotalGST;

			$gstData=array("totalPrice"=>$overallTotalprice,"totalCGST"=>$overallCGSTamount,"totalSGST"=>$overallSGSTamount,"totalIGST"=>$overallIGSTamount,"totalUTGST"=>$overallUTGSTamount,"totalGST"=>$overallTotalGST,"grandTotal"=>$grandTotalprice);
              foreach ($resultset as $key => $value) {
              	$resultset[$key]['productPrice']=number_format($value['productPrice'],2);
              	$resultset[$key]['netPrice']=number_format($value['netPrice'],2);
              	$resultset[$key]['totalPrice']=number_format($value['totalPrice'],2);
              	
              }

             
			if ($resultset != null) {
				$result = ['success' => '1', 'message' => 'result successfully', 'product' => $resultset,'GST'=>$gstData];
			} else {
				$result = ['success' => '2', 'message' => 'result failed'];
			}
		}else if($param->action=='productDetails'){

			$idProduct=$param->idProduct;
			$idProductsize=$param->idProductsize;
			$check_offer=$param->check_offer;
			$idTerritory=$param->idTerritory;
			$idCustomer=$param->idCustomer;
			$idCustomerType=$param->idCustomerType;
			//print_r($param); 
			if($check_offer==1){
				// print_r($param); 
				$sqlAryoffer = "SELECT T1.idProduct AS idProduct, T2.productCount AS order_units, T2.productName AS order_product_name, T3.productSize AS order_product_size, T4.primarypackname AS order_primarypackname, T1.scheme_product_qty AS order_qty, T1.schemeType AS offer_type, T1.free_product_qty AS off_product_qty, 
							(SELECT B.productSize FROM product_size AS B WHERE B.idProductsize=T1.free_product_size AND B.status=1) AS off_product_size, 
							(SELECT A.productCount FROM product_details AS A WHERE A.idProduct=T1.free_product AND A.status=1)  AS off_product_unit, 
							(SELECT A.productName FROM product_details AS A WHERE A.idProduct=T1.free_product AND A.status=1) AS off_product, 
							(CASE 
							WHEN T1.discount_type= 1 THEN 'Flat'
							WHEN T1.discount_type= 2 THEN 'Discount'
							END) AS discount_type,
							T1.scheme_flat_discount, T1.scheme_note, T1.scheme_terms_conditions
							FROM scheme AS T1
							LEFT JOIN product_details AS T2 ON T1.idProduct=T2.idProduct
							LEFT JOIN product_size AS T3 ON T1.scheme_product_size=T3.idProductsize
							LEFT JOIN primary_packaging AS T4 ON T3.idPrimaryPackaging=T4.idPrimaryPackaging
							WHERE  T1.idProduct='".$idProduct."' AND T3.idProductsize= '".$idProductsize."' AND T1.idTerritory='".$idTerritory."' AND T2.status=1 AND ((T1.idCustomerType='".$idCustomerType."') OR (T1.idCustomer='".$idCustomer."'))  AND CURDATE()>=T1.schemeStartdate AND CURDATE()<=T1.schemeEnddate AND T3.status=1";
				$resultoffer = $this->adapter->query($sqlAryoffer, array());
				$resultset= $resultoffer->toArray();
				// echo $sqlAryoffer; exit;
			}

			if ($resultset != null) {
				$result = ['success' => '1', 'message' => 'result successfully', 'result' => $resultset, 'devliverypoints'=>$deliverPointvalAry];
			} else {
				$result = ['success' => '2', 'message' => 'result failed'];
			}
		}
		return $result;
	}
	//Previous Dispatches 
	public function PreviousDisp($param){
		if ($param->action=='previousDispatches') {
			$idCustomer = $param->idCustomer;
			$listIndex = 0;
			$listIndex = ($param->listIndex)?$param->listIndex:0;
			$NextIndex = $listIndex+5;
			$TotalData=5;
			$limit="LIMIT ".$listIndex.",".$TotalData;
             $totalCount=0;
			$qrytotalCount = "SELECT T1.invoiceNo, T1.dcNo, T1.delivery_date, T1.invoice_amt, T2.poNumber, T2.idOrder 
					FROM dispatch_customer AS T1 
					LEFT JOIN orders AS T2 ON T1.idOrder=T2.idOrder
					WHERE T1.idCustomer=?";
			$resulttotalCount = $this->adapter->query($qrytotalCount, array($idCustomer));
			$resultsettotalCount = $resulttotalCount->toArray();
             $totalCount=count($resultsettotalCount);

			$qry = "SELECT T1.invoiceNo, T1.dcNo, T1.delivery_date, T1.invoice_amt, T2.poNumber, T2.idOrder 
					FROM dispatch_customer AS T1 
					LEFT JOIN orders AS T2 ON T1.idOrder=T2.idOrder
					WHERE T1.idCustomer=? $limit";
			$result = $this->adapter->query($qry, array($idCustomer));
			$resultset = $result->toArray();
			if ($resultset != null) {
			    $result = ['success' => '1', 'message' => 'result successfully', 'result' => $resultset,'totalCount'=>$totalCount,'listIndex'=>$NextIndex];
			} else {
			    $result = ['success' => '2', 'message' => 'result failed'];
			}		
		}else if($param->action=='dispatchesStatus'){
			$idCustomer = $param->idCustomer;
			$idOrder = $param->idOrder;
			// $listIndex = 0;
			// $listIndex = ($param->listIndex)?$param->listIndex:0;
			// $NextIndex = $listIndex+3;
			// $TotalData=3;
			// $limit="LIMIT ".$listIndex.",".$TotalData;

			$qry = "SELECT T1.poNumber, T1.poDate, T1.salesCode, T1.totalAmount AS orderTotal, T1.totalTax, T1.grandtotalAmount, T1.idOrder,  T2.price, T2.totalAmount, T2.discountAmount, T2.NetAmount,T2.orderQty AS ordered_qty, T3.productCount AS units, T3.productName AS product_name, T4.productSize AS productSize, T6.dis_Qty AS dispatch_qty, T5.primarypackname AS primarypackname,T4.productPrimaryCount
					FROM orders AS T1 
					LEFT JOIN order_items AS T2 ON T1.idOrder=T2.idOrder
					LEFT JOIN product_details AS T3 ON T2.idProduct=T3.idProduct
					LEFT JOIN product_size AS T4 ON T2.idProductsize=T4.idProductsize
					LEFT JOIN primary_packaging AS T5 ON T4.idPrimaryPackaging=T5.idPrimaryPackaging
					LEFT JOIN dispatch_product AS T6 ON T2.idOrderItem=T6.idOrderItem
					WHERE T1.idCustomer=? AND T3.status=1 AND T4.status=1 AND T1.idOrder=? ";
			$result = $this->adapter->query($qry, array($idCustomer, $idOrder));
			$resultset = $result->toArray();
			if ($resultset != null) {
			    $result = ['success' => '1', 'message' => 'result successfully', 'result' => $resultset, 'totalAmount' => $resultset[0]['orderTotal'], 'totalTax' => $resultset[0]['totalTax'], 'grandtotalAmount' => $resultset[0]['grandtotalAmount'], 'result' => $resultset];
			} else {
			    $result = ['success' => '2', 'message' => 'result failed'];
			}	
		}
		return $result;
	}
	//Customers Serviced  
	public function CustomerServ($param){
		if ($param->action=='customerDetails') {
			$idCustomer = $param->idCustomer;
			$listIndex = 0;
			$listIndex = ($param->listIndex)?$param->listIndex:0;
			$NextIndex = $listIndex+10;
				$TotalData=10;
			$limit="LIMIT ".$listIndex.",".$TotalData;
			$totalCount=0;
			$qrytotalCount = "SELECT count(T1.customer_code) as totalCount
					FROM customer AS T1 
					
					WHERE T1.cs_serviceby=? AND T1.cs_status=?";
			$resulttotalCount = $this->adapter->query($qrytotalCount, array($idCustomer,1));
			$resultsettotalCount = $resulttotalCount->toArray();
            $totalCount=$resultsettotalCount[0]['totalCount'];

			$qry = "SELECT T1.customer_code, T1.cs_name AS customer_name, T1.cs_mail AS customer_mail, T1.cs_mobno AS customer_mobile_no, T2.geoValue AS country_name, T11.geoValue AS state_name, T3.geoValue AS city_name, T4.geoValue AS pincode, T5.geoValue AS region, T6.geoValue AS hub, T7.geoValue AS zone, T8.geoValue AS area, T9.geoValue AS street, T10.geoValue AS outlet 
					FROM customer AS T1 
					LEFT JOIN geography AS T2 ON T1.g1=T2.idGeography
					LEFT JOIN geography AS T11 ON T1.g2=T11.idGeography
					LEFT JOIN geography AS T3 ON T1.g3=T3.idGeography
					LEFT JOIN geography AS T4 ON T1.g4=T4.idGeography
					LEFT JOIN geography AS T5 ON T1.g5=T5.idGeography
					LEFT JOIN geography AS T6 ON T1.g6=T6.idGeography
					LEFT JOIN geography AS T7 ON T1.g7=T7.idGeography
					LEFT JOIN geography AS T8 ON T1.g8=T8.idGeography
					LEFT JOIN geography AS T9 ON T1.g9=T9.idGeography
					LEFT JOIN geography AS T10 ON T1.g10=T10.idGeography
					WHERE T1.cs_serviceby=? AND T1.cs_status=? $limit";
			$result = $this->adapter->query($qry, array($idCustomer,1));
			$resultset = $result->toArray();
			if ($resultset) {
				foreach ($resultset as $key => $value) {
					$addressStr='';
					$address='';
					if ($value['country_name']!='') {
						$addressStr.=$value['country_name'].',';
					}
					if ($value['state_name']!='') {
						$addressStr.=$value['state_name'].',';
					}
					if ($value['city_name']!='') {
						$addressStr.=$value['city_name'].',';
					}
					if ($value['pincode']!='') {
						$addressStr.=$value['pincode'].',';
					}
					if ($value['area']!='') {
						$addressStr.=$value['area'].',';
					}
					if ($value['street']!='') {
						$addressStr.=$value['street'].',';
					}

					$address=rtrim($addressStr, ',');
					$resultset[$key]['address']=$address;
				}
			}
			if ($resultset != null) {
			    $result = ['success' => '1', 'message' => 'result successfully', 'result' => $resultset,'listIndex'=>$NextIndex,'totalCount'=>$totalCount];
			} else {
			    $result = ['success' => '2', 'message' => 'result failed'];
			}	
		}
		return $result;
	}
	//Stock Details
	public function StockDetails($param){
		if ($param->action=='wHouseDetails') {
			$idCustomer = $param->idCustomer;
			$qry = "SELECT T1.idWarehouse, T1.warehouseName, T1.warehouseMobileno, T1.warehouseEmail ,0 as ttlqty
					FROM warehouse_master AS T1 
					WHERE T1.idCustomer=? AND T1.status=?";
			$result = $this->adapter->query($qry, array($idCustomer,1));
			$resultset = $result->toArray();
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
		 	
		 	// if(!$resultset) {
		 	// 	$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found'];
		 	// } else {
		 	// 	$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];

		 	// }
			if ($resultset != null) {
			    $result = ['success' => '1', 'message' => 'result successfully', 'result' => $resultset];
			} else {
			    $result = ['success' => '2', 'message' => 'result failed'];
			}		
		}else if($param->action=='wHouseProducts'){
			$warid=$param->idWarehouse;

			$listIndex = 0;
			$listIndex = ($param->listIndex)?$param->listIndex:0;
			$NextIndex = $listIndex+10;
			$TotalData=10;
			$limit="LIMIT ".$listIndex.",".$TotalData;
			//get total number of product in the warehouse
              $totalCount=0;
			$qrytotalCount="SELECT t2.idWhStock,t2.idWarehouse,t3.idProduct,t6.primarypackname,t3.idProdSize,SUM(t3.sku_accept_qty) AS qty,t4.productName,t5.productSize,t5.idPrimaryPackaging,t5.productPrimaryCount,t4.productCount FROM whouse_stock as t2
						LEFT JOIN whouse_stock_items as t3 ON t3.idWhStock=t2.idWhStock
						LEFT JOIN product_details as t4 ON t4.idProduct=t3.idProduct
						LEFT JOIN product_size as t5 ON t5.idProductsize=t3.idProdSize
						LEFT JOIN primary_packaging as t6 ON t6.idPrimaryPackaging=t5.idPrimaryPackaging
						WHERE t2.idWarehouse='$warid'  AND t4.status=1  AND t5.status=1  GROUP BY idProductsize";
			
			$resulttotalCount=$this->adapter->query($qrytotalCount,array());
			$resultsettotalCount=$resulttotalCount->toArray();
			
			$totalCount=count($resultsettotalCount);
			
			$qrypoqty="SELECT t2.idWhStock,t2.idWarehouse,t3.idProduct,t6.primarypackname,t3.idProdSize,SUM(t3.sku_accept_qty) AS qty,t4.productName,t5.productSize,t5.idPrimaryPackaging,t5.productPrimaryCount,t4.productCount FROM whouse_stock as t2
						LEFT JOIN whouse_stock_items as t3 ON t3.idWhStock=t2.idWhStock
						LEFT JOIN product_details as t4 ON t4.idProduct=t3.idProduct
						LEFT JOIN product_size as t5 ON t5.idProductsize=t3.idProdSize
						LEFT JOIN primary_packaging as t6 ON t6.idPrimaryPackaging=t5.idPrimaryPackaging
						WHERE t2.idWarehouse='$warid'  AND t4.status=1  AND t5.status=1  GROUP BY idProductsize $limit";
			
			$resultpoqty=$this->adapter->query($qrypoqty,array());
			$resultset=$resultpoqty->toArray();
			for ($i=0; $i < count($resultset); $i++) { 
				$idWarehouse=$resultset[$i]['idWarehouse'];
				$prodId=$resultset[$i]['idProduct'];
				$sizId=$resultset[$i]['idProdSize'];
				$dataArray = array();
				$stockEntry="SELECT 'stockEntry' as dataType, WHSI.sku_accept_qty as proQty, WHSI.sku_entry_date as entryDate, WHS.po_no as PORefernce, WHS.grn_no as DocRefernce 
							from whouse_stock_items as WHSI 
							LEFT JOIN whouse_stock as WHS ON WHS.idWhStock=WHSI.idWhStock 
							where WHSI.idProduct='$prodId' and WHSI.idProdSize='$sizId' and WHSI.idWarehouse='$idWarehouse'";
				$resultstockEntry=$this->adapter->query($stockEntry,array());
				$resultsetstockEntry=$resultstockEntry->toArray();
				if(0<count($resultsetstockEntry)){
					foreach($resultsetstockEntry AS $var){
						array_push($dataArray,$var);
					}
				}
				$qrycus="SELECT COR.rtnQty as proQty,DC.idCustomer,DC.idWarehouse 
						from customer_order_return as COR
						LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer  
						where DC.idCustomer='$idCustomer'";
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
				$stkDmg="SELECT 'stockdmg' as dataType, WHSD.dmg_prod_qty as proQty, WHSD.dmg_entry_date as entryDate, WHS.po_no as PORefernce, WHS.grn_no as DocRefernce 
						from whouse_stock_damge as WHSD 
						LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=WHSD.idWhStockItem 
						LEFT JOIN whouse_stock as WHS ON WHSI.idWhStock=WHS.idWhStock 
						where WHSD.idProduct='$prodId' and WHSD.idProdSize='$sizId' and WHSD.idWarehouse='$idWarehouse'";
				$resultstkDmg=$this->adapter->query($stkDmg,array());
				$resultsetstkDmg=$resultstkDmg->toArray();
				if(0<count($resultsetstkDmg)){
					foreach($resultsetstkDmg AS $var)
					{
						array_push($dataArray,$var);
					}
				}
				$cstDmg="SELECT 'damage' as dataType, COR.dmgUnit as proQty, COR.dmgRtnDate as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce 
						from customer_order_damges as COR
						LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
						LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
						LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
						LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
						where WHSI.idProduct='$prodId' and WHSI.idProdSize='$sizId' and WHSI.idWarehouse='$idWarehouse'";
				$resultcstDmg=$this->adapter->query($cstDmg,array());
				$resultsetcstDmg=$resultcstDmg->toArray();
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
						$balanceAmt-=number_format($val["proQty"], 2, '.', '');
					}
				}
				$resultset[$i]['qty']=$balanceAmt;
			}
			if ($resultset != null) {
			    $result = ['success' => '1', 'message' => 'result successfully', 'result' => $resultset,'totalCount'=>$totalCount,'listIndex'=>$NextIndex];
			} else {
			    $result = ['success' => '2', 'message' => 'result failed'];
			}
		}
		return $result;
	}
	//FollowUp Details
	public function FollowUp($param){
		if ($param->action=='addFollwup') {
			$dateAdd=$param->dateAdd;
			$startTime=$param->startTime;
			$endTime=$param->endTime;
			$mobileNo=$param->mobileNo;
			$emailId=$param->emailId;
			$remark=$param->remark;
			$idCustomer=$param->idCustomer;
			$idUser=$param->idUser;
			$idVisit=$param->idVisit;
$qryPJPlist="SELECT follow_status,idpjpList FROM pjp_detail_list WHERE idCustomer='".$idCustomer."' and cycle_day='".date('Y-m-d',strtotime($dateAdd))."'";
$resultPJPlist=$this->adapter->query($qryPJPlist,array());
$resultsetPJPlist=$resultPJPlist->toArray();
			if (count($resultsetPJPlist)>0) 
			{
				 if ($resultsetPJPlist[$i]['follow_status']==0) 
				 {
				 	// update pjp_detail_list SET follow_status='1' , idSalesHirchyEmployee='".$_REQUEST['idSalesHirchyEmployee']."' where idCustomer='".$_REQUEST['idcustomer']."' and cycle_day='".$cycleday."'
			$this->adapter->getDriver()->getConnection()->beginTransaction();
						try {
											$dataupdate['follow_status']=1;
											$dataupdate['idVisit']=$idVisit;
											$dataupdate['idTeamMember']=$idUser;
										

												$sql = new Sql($this->adapter);
												$update = $sql->update();
												$update->table('pjp_detail_list');
												$update->set($dataupdate);
												$update->where(array('idCustomer' => $idCustomer,'cycle_day'=>date('Y-m-d',strtotime($dateAdd))));
												$statement  = $sql->prepareStatementForSqlObject($update);
												$results    = $statement->execute();
												$result = ['success' => '1', 'message' => 'Added successfully'];
							$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
							$result = ['success' => '2', 'message' => 'Please try again...'];
							$this->adapter->getDriver()->getConnection()->rollBack();
						}
				 }
			}

			$this->adapter->getDriver()->getConnection()->beginTransaction();
			try {
				$datainsert['id_customer']=$idCustomer;
				$datainsert['date_add']=$dateAdd;
				$datainsert['start_time']=$startTime;
				$datainsert['end_time']=$endTime;
				$datainsert['mobile_no']=$mobileNo;
				$datainsert['email_id']= $emailId;
				$datainsert['remark']= $remark;
				$datainsert['followup_status']= 1;
				$datainsert['created_by']=$idUser;
				$datainsert['idVisit']=$idVisit;	
				$datainsert['idpjpList']=(is_numeric($resultsetPJPlist[0]['idpjpList']))?$resultsetPJPlist[0]['idpjpList']:0;			
				$datainsert['created_date']=date('Y-m-d H:i:s');
				$insert=new Insert('follwoup');
				$insert->values($datainsert);
				$statement=$this->adapter->createStatement();
				$insert->prepareStatement($this->adapter, $statement);
				$insertresult=$statement->execute();
				$result = ['success' => '1', 'message' => 'Added successfully'];
				$this->adapter->getDriver()->getConnection()->commit();
			} catch(\Exception $e) {
				$result = ['success' => '2', 'message' => 'Please try again...'];
				$this->adapter->getDriver()->getConnection()->rollBack();
			}
		}else if ($param->action=='followUpView') {
			$idFollowUp=$param->idFollowUp;
			$qry = "SELECT T1.* FROM  follwoup AS T1 WHERE T1.id_follow_up=? AND T1.followup_status=? ";
			$result = $this->adapter->query($qry, array($idFollowUp,1));
			$resultset = $result->toArray();
			if ($resultset != null) {
			    $result = ['success' => '1', 'message' => 'result successfully', 'result' => $resultset];
			} else {
			    $result = ['success' => '2', 'message' => 'result failed'];
			}		
		}else if ($param->action=='followUpList') {
			$idUser=$param->idUser;
			$dateVal=$param->dateVal;
			$qry = "SELECT T1.*, T2.cs_name AS customer_name, T2.customer_code AS customer_code, T3.custType AS customer_type, T4.geoValue AS pincode, T5.geoValue AS area,vs.pjp_category as visitCategory
					FROM  follwoup AS T1
					LEFT JOIN customer AS T2 ON T1.id_customer=T2.idCustomer 
					LEFT JOIN customertype AS T3 ON T2.cs_type=T3.idCustomerType 
					LEFT JOIN geography AS T4 ON T2.g4=T4.idGeography
					LEFT JOIN geography AS T5 ON T2.g8=T5.idGeography
					 LEFT JOIN pjp_visit_status as vs ON vs.idVisit=T1.idVisit
					WHERE T1.created_by=? AND T1.date_add=? AND T1.followup_status=? ";
			$result = $this->adapter->query($qry, array($idUser,$dateVal,1));
			$resultset = $result->toArray();

			if ($resultset) {
				$qrygeomas = "SELECT T1.idGeographyTitle AS idGeographyTitle FROM geographytitle_master AS T1 WHERE T1.title !='' ORDER BY T1.idGeographyTitle DESC LIMIT 2";
				$resultgeomas = $this->adapter->query($qrygeomas, array());
				$resultsetgeomas = $resultgeomas->toArray();

				foreach ($resultset as $key => $value) {
					$qrygeo = "SELECT T4.geoValue AS geoValue1, T5.geoValue AS geoValue2
					FROM customer AS T1 
					LEFT JOIN geography AS T4 ON T1.g".$resultsetgeomas[0]['idGeographyTitle']."=T4.idGeography
					LEFT JOIN geography AS T5 ON T1.g".$resultsetgeomas[1]['idGeographyTitle']."=T5.idGeography
					WHERE T1.idCustomer=?";
					$resultgeo = $this->adapter->query($qrygeo, array($value['id_customer']));
					$resultsetgeo = $resultgeo->toArray();

					$resultset[$key]['address']=$resultsetgeo[0]['geoValue1'].'-'.$resultsetgeo[0]['geoValue2'];
				}			
			}
			
			if ($resultset != null) {
			    $result = ['success' => '1', 'message' => 'result successfully', 'result' => $resultset];
			} else {
			    $result = ['success' => '2', 'message' => 'result failed'];
			}		
		}else if ($param->action=='updateFollwup') {
			$dateAdd=$param->dateAdd;
			$startTime=$param->startTime;
			$endTime=$param->endTime;
			$mobileNo=$param->mobileNo;
			$emailId=$param->emailId;
			$remark=$param->remark;
			$idUser=$param->idUser;
			$idFollowUp=$param->idFollowUp;

			$idVisit=$param->idVisit;
$qryPJPlist="SELECT follow_status,idpjpList FROM pjp_detail_list WHERE idCustomer='".$idCustomer."' and cycle_day='".date('Y-m-d',strtotime($dateAdd))."'";
$resultPJPlist=$this->adapter->query($qryPJPlist,array());
$resultsetPJPlist=$resultPJPlist->toArray();
			if (count($resultsetPJPlist)>0) 
			{
				 if ($resultsetPJPlist[$i]['follow_status']==0) 
				 {
				 	// update pjp_detail_list SET follow_status='1' , idSalesHirchyEmployee='".$_REQUEST['idSalesHirchyEmployee']."' where idCustomer='".$_REQUEST['idcustomer']."' and cycle_day='".$cycleday."'
			$this->adapter->getDriver()->getConnection()->beginTransaction();
						try {
											$dataupdate['follow_status']=1;
											$dataupdate['idVisit']=$idVisit;
											$dataupdate['idTeamMember']=$idUser;
										

												$sql = new Sql($this->adapter);
												$update = $sql->update();
												$update->table('pjp_detail_list');
												$update->set($dataupdate);
												$update->where(array('idCustomer' => $idCustomer,'cycle_day'=>date('Y-m-d',strtotime($dateAdd))));
												$statement  = $sql->prepareStatementForSqlObject($update);
												$results    = $statement->execute();
												$result = ['success' => '1', 'message' => 'Added successfully'];
							$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
							$result = ['success' => '2', 'message' => 'Please try again...'];
							$this->adapter->getDriver()->getConnection()->rollBack();
						}
				 }
			}

			$this->adapter->getDriver()->getConnection()->beginTransaction();
			try {
				$dataupdate['date_add']=$dateAdd;
				$dataupdate['start_time']=$startTime;
				$dataupdate['end_time']=$endTime;
				$dataupdate['mobile_no']=$mobileNo;
				$dataupdate['remark']=$remark;
				$dataupdate['email_id']= $emailId;
				$dataupdate['followup_status']= 1;
				$dataupdate['idpjpList']=(is_numeric($resultsetPJPlist[0]['idpjpList']))?$resultsetPJPlist[0]['idpjpList']:0;
				$dataupdate['idVisit']=$idVisit;
				$dataupdate['updated_by']=$idUser;
				$dataupdate['updated_date']=date('Y-m-d H:i:s');
				$sql = new Sql($this->adapter);
				$update = $sql->update();
				$update->table('follwoup');
				$update->set($dataupdate);
				$update->where(array('id_follow_up' => $idFollowUp));
				$statement  = $sql->prepareStatementForSqlObject($update);
				$results    = $statement->execute();
				$result = ['success' => '1', 'message' => 'Updated successfully'];
				$this->adapter->getDriver()->getConnection()->commit();
			} catch(\Exception $e) {
				$result = ['success' => '2', 'message' => 'Please try again...'];

				$this->adapter->getDriver()->getConnection()->rollBack();
			}
		}
		return $result;
	}
	//Collection Entry
	public function CollectionEntry($param){
		if ($param->action=='customerDetails') {
			$idCustomer=$param->idCustomer;
			$idUser=$param->idUser;
			$sqlAry = "SELECT T1.customer_code, T1.cs_name, T1.idCustomer, T1.cs_mobno, T1.cs_mail,0 as accountAmount
			FROM customer AS T1 
			WHERE T1.idCustomer=? AND  T1.cs_status=? ";
			$result = $this->adapter->query($sqlAry, array($idCustomer,1));
			$resultset = $result->toArray();

			$sqlOS = "SELECT SUM(T1.invoiceAmt) AS invoiceAmt, 
			(SELECT SUM(A.payAmt) FROM invoice_payment AS A WHERE A.idCustomer=T1.idCustomer AND A.idInvoice!=0) AS payAmt,  
			ABS(SUM(T1.invoiceAmt)-(SELECT SUM(A.payAmt) FROM invoice_payment AS A WHERE A.idCustomer=T1.idCustomer AND A.idInvoice!=0)) AS outStanding
					FROM invoice_details AS T1
					WHERE T1.idCustomer=?";
			$resultOS = $this->adapter->query($sqlOS, array($idCustomer));
			$resultsetOS = $resultOS->toArray();

			$sqlOnaccount = "SELECT SUM(payAmt-paidAmount) as accountAmount FROM invoice_payment WHERE idCustomer='$idCustomer' AND payType='On Account'";
			$resultOnaccount = $this->adapter->query($sqlOnaccount, array($idCustomer));
			$resultsetOnaccount = $resultOnaccount->toArray();
            if (count($resultsetOnaccount)>0) 
            {
            	$resultset[0]['accountAmount']=$resultsetOnaccount[0]['accountAmount'];
            }


			$resultset[0]['totalInvoiceAmt']=number_format($resultsetOS [0]['invoiceAmt'],2);
			$resultset[0]['totalPayAmt']=number_format($resultsetOS [0]['payAmt'],2);
			$resultset[0]['totaloutStanding']=number_format($resultsetOS [0]['outStanding'],2);

			// $invoiceBreakup = "SELECT T1.*, FORMAT(SUM(T2.payAmt),2) AS payAmt, FORMAT(ABS(T1.invoiceAmt-SUM(T2.payAmt)),2)  AS balanceAmt
			// 				FROM invoice_details AS T1 
			// 				LEFT JOIN invoice_payment AS T2 ON T1.idInvoice=T2.idInvoice
			// 				WHERE T1.idCustomer=?  GROUP BY T2.idInvoice HAVING balanceAmt > 0";
			// $invoiceBreakupRes = $this->adapter->query($invoiceBreakup, array($idCustomer));
			// $invoiceBreakupAry = $invoiceBreakupRes->toArray();

			$invoiceBreakup = "SELECT T1.*, '' AS payAmt,''  AS balanceAmt
							FROM invoice_details AS T1 
							
							WHERE T1.idCustomer=?  GROUP BY T1.idInvoice ";
			$invoiceBreakupRes = $this->adapter->query($invoiceBreakup, array($idCustomer));
			$invoiceBreakupAry = $invoiceBreakupRes->toArray();

             for ($i=0; $i < count($invoiceBreakupAry); $i++) 
             { 
             	$idInvoice=$invoiceBreakupAry[$i]['idInvoice'];
             	$invoicepayAmount = "SELECT sum(payAmt) as payAmt FROM `invoice_payment` WHERE payType='On Bill' AND idInvoice='$idInvoice'";
			$invoicepayAmount = $this->adapter->query($invoicepayAmount, array($idCustomer));
			$invoicepayAmount = $invoicepayAmount->toArray();
			   if (count($invoicepayAmount)>0) 
			   {
			   	  $payamt=($invoicepayAmount[0]['payAmt']!='')?$invoicepayAmount[0]['payAmt']:0;

			   }else
			   {
			   	 $payamt=0;
			   }

               $blnceAmt=$invoiceBreakupAry[$i]['invoiceAmt']-$payamt;
                $invoiceBreakupAry[$i]['payAmt']=$payamt;
                $invoiceBreakupAry[$i]['balanceAmt']=number_format($blnceAmt,2);
                if ($invoiceBreakupAry[$i]['balanceAmt']>0) 
                {
                	$invoiceData[]=$invoiceBreakupAry[$i];
                }
                
             }
			
			

			$banksql = "SELECT T1.bankName AS name, T1.idBank AS id
			FROM bank AS T1 
			WHERE T1.status=?  GROUP BY name ";
			$bankresult = $this->adapter->query($banksql, array(1));
			$bankresultset = $bankresult->toArray();

			$cardtypesql = "SELECT T1.cardtypeName AS name, T1.idCardtype AS id
			FROM card_type AS T1 
			WHERE T1.status=? ";
			$cardtyperesult = $this->adapter->query($cardtypesql, array(1));
			$cardtyperesultset = $cardtyperesult->toArray();

			$ledgersql = "SELECT T1.ledgerNo AS ledgerNo, T1.idLedger AS id
			FROM ledger_details AS T1 
			WHERE T1.idColEmp=?";
			$ledgerresult = $this->adapter->query($ledgersql, array($idUser));
			$ledgerresultset = $ledgerresult->toArray();


			if ($resultset != null) {
				$result = ['success' => '1', 'message' => 'result successfully', 'result' => $resultset, 'invoices' => $invoiceData, 'bankName' => $bankresultset, 'cardType' => $cardtyperesultset, 'receiptbook' => $ledgerresultset];
			} else {
				$result = ['success' => '2', 'message' => 'result failed'];
			}		
		}else if($param->action=='collectionSubmit'){
			$idCustomer=$param->idCustomer;
			$idUser=$param->idUser;
			$idLedger=$param->idLedger;
			$reciptNo=$param->reciptNo;
			$paidAmount=$param->paidAmount;
			$pay_date=$param->pay_date;
			$payType=$param->payType;
			$payMode=$param->payMode;
			$chequeNo=$param->chequeNo;
			$chequeDate=$param->chequeDate;
			$idBank=$param->idBank;
			$cardNo=$param->cardNo;
			$cardType=$param->cardType;
			$referenceNo=$param->referenceNo;
			$payee_mobile=$param->payee_mobile;
			$payee_mail=$param->payee_mail;
			$payee_text=$param->payee_text;
			$entryDateTime=date("Y-m-d H:i:s");
			$lattitude_value=$param->lattitude_value;
			$longitude_value=$param->longitude_value;
			$invoicejson=$param->invoiceAry;

			$getIdLedger="SELECT idLedger, recieptNos, usedReciept FROM ledger_details WHERE idLedger='$idLedger' AND FIND_IN_SET($reciptNo, recieptNos) ";
			$resultIdLedger=$this->adapter->query($getIdLedger,array());
			$resultsetIdLedger=$resultIdLedger->toArray();
			$getIdLedgerExp=explode(',',$resultsetIdLedger[0]['recieptNos']);

			for ($i=0; $i <count($getIdLedgerExp); $i++) { 
				$checkReceipt=$getIdLedgerExp[$i];
				if ($reciptNo!=$checkReceipt) {
					$recieptNos.=$getIdLedgerExp[$i].',';
				}
				$checkReceipt='';
			}
			$recieptNos=rtrim($recieptNos,",");
			$usedReciept=$resultsetIdLedger[0]["usedReciept"].','.$reciptNo;
			if ($resultsetIdLedger[0]['idLedger']!="") {
				if ($payType==1) { //On Account
					$this->adapter->getDriver()->getConnection()->beginTransaction();
					try {
						$datainsert['idInvoice']=0; // if payment type is On Account idInvoice Should be ZERO
						$datainsert['collMemCode']=$idUser;
						$datainsert['idCustomer']=$idCustomer;
						$datainsert['idLedger']=$idLedger;
						$datainsert['reciptNo']=$reciptNo;
						$datainsert['payAmt']=$paidAmount; // PayAmount for On Account
						$datainsert['paidAmount']=0;
						$datainsert['pay_date']=date("Y-m-d",strtotime($pay_date));
						$datainsert['payType']= "On Account";
						if ($payMode=="Cash") {
							$datainsert['payMode']= "Cash";
						}else if ($payMode=="Cheque"){
							$datainsert['payMode']= "Cheque";
							$datainsert['chequeNo']=$chequeNo;
							$datainsert['chequeDate']=$chequeDate;
							$datainsert['idBank']=$idBank;
						}elseif ($payMode=="Card") {
							$datainsert['payMode']= "Card";
							$datainsert['cardNo']=$cardNo;
							$datainsert['cardType']=$cardType;
							$datainsert['idBank']=$idBank;
						}elseif ($payMode=="RTGS") {
							$datainsert['payMode']= "RTGS";
							$datainsert['referenceNo']=$referenceNo;
						}elseif ($payMode=="NEFT") {
							$datainsert['payMode']= "NEFT";
							$datainsert['referenceNo']=$referenceNo;
						}
						$datainsert['payee_mobile']= $payee_mobile;
						$datainsert['payee_mail']= $payee_mail;
						$datainsert['payee_text']= $payee_text;
						$datainsert['entryDateTime']=date("Y-m-d H:i:s");
						$datainsert['lattitude_value']=$lattitude_value;
						$datainsert['longitude_value']=$longitude_value;

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

						$result = ['success' => '1', 'message' => 'Added successfully'];
						$this->adapter->getDriver()->getConnection()->commit();
					} catch(\Exception $e) {
						$result = ['success' => '2', 'message' => 'Please try again...'];
						$this->adapter->getDriver()->getConnection()->rollBack();
					}
				}else if ($payType==2) { // On Bill
					$invoiceAry=json_decode($invoicejson, true); // json object to Php Array

					$this->adapter->getDriver()->getConnection()->beginTransaction();

					try {
						for ($i=0; $i < count($invoiceAry); $i++) { 
							$datainsert['idInvoice']=$invoiceAry[$i]['invoice_no'];
							$datainsert['collMemCode']=$idUser;
							$datainsert['idCustomer']=$idCustomer;
							$datainsert['idLedger']=$idLedger;
							$datainsert['reciptNo']=$reciptNo;
							$datainsert['payAmt']=$invoiceAry[$i]['invoice_amt']; // PayAmt for On Bills
							$datainsert['pay_date']=date("Y-m-d",strtotime($pay_date));
							$datainsert['payType']= "On Bill";
							if ($payMode=="Cash") {
								$datainsert['payMode']= "Cash";
							}else if ($payMode=="Cheque"){
								$datainsert['payMode']= "Cheque";
								$datainsert['chequeNo']=$chequeNo;
								$datainsert['chequeDate']=$chequeDate;
								$datainsert['idBank']=$idBank;
							}elseif ($payMode=="Card") {
								$datainsert['payMode']= "Card";
								$datainsert['cardNo']=$cardNo;
								$datainsert['cardType']=$cardType;
								$datainsert['idBank']=$idBank;
							}elseif ($payMode=="RTGS") {
								$datainsert['payMode']= "RTGS";
								$datainsert['referenceNo']=$referenceNo;
							}elseif ($payMode=="NEFT") {
								$datainsert['payMode']= "NEFT";
								$datainsert['referenceNo']=$referenceNo;
							}
							$datainsert['payee_mobile']= $payee_mobile;
							$datainsert['payee_mail']= $payee_mail;
							$datainsert['payee_text']= $payee_text;
							$datainsert['entryDateTime']=date("Y-m-d H:i:s");
							$datainsert['lattitude_value']=$lattitude_value;
							$datainsert['longitude_value']=$longitude_value;

							// print_r($datainsert); exit;

							$insert=new Insert('invoice_payment');
							$insert->values($datainsert);
							$statement=$this->adapter->createStatement();
							$insert->prepareStatement($this->adapter, $statement);
							$insertresult=$statement->execute();						}
						

						$dataupdate['recieptNos']=$recieptNos;
						$dataupdate['usedReciept']=$usedReciept;
						
						$sql = new Sql($this->adapter);
						$update = $sql->update();
						$update->table('ledger_details');
						$update->set($dataupdate);
						$update->where( array('idLedger'=>$idLedger));
						$updatestatement  = $sql->prepareStatementForSqlObject($update);
						$results    = $updatestatement->execute();

						$result = ['success' => '1', 'message' => 'Added successfully'];
						$this->adapter->getDriver()->getConnection()->commit();
					} catch(\Exception $e) {
						$result = ['success' => '2', 'message' => 'Please try again...'.$e];
						$this->adapter->getDriver()->getConnection()->rollBack();
					}
				}
			}else{
				$result=['success'=>'2','message'=>'Invalid receipt number'];
			}
		}else if($param->action=='bankIfsc'){
			$bankName=$param->bankName;

			$ifscql = "SELECT  T1.idBank AS id, T1.bankIFSC AS bankIFSC
					FROM bank AS T1 
					WHERE T1.status=? AND T1.bankName=?";
			$ifscresult = $this->adapter->query($ifscql, array(1,$bankName));
			$resultset = $ifscresult->toArray();
			if ($resultset != null) {
				$result = ['success' => '1', 'message' => 'result successfully', 'result' => $resultset];
			} else {
				$result = ['success' => '2', 'message' => 'result failed'];
			}		
		}
		return $result;	
	}
	//Other Collection  
	public function OtherCollection($param){
		$empCode = $param->empCode;
		$custCode = $param->custCode;
		if ($empCode || $custCode) {
			if ($custCode!='') {
				$wC=" AND T1.customer_code='".trim($custCode)."'";
			}else if($empCode!=''){
				$wC=" AND T1.sales_hrchy_name='".trim($empCode)."'";				
			}
			$qry = "SELECT T1.idCustomer, T1.customer_code, T1.cs_name AS customer_name, T1.cs_mail AS customer_mail, T1.cs_mobno AS customer_mobile_no ,CT.idCustomerType,CT.custType
			FROM customer AS T1 LEFT JOIN customertype AS CT ON CT.idCustomerType=T1.cs_type
			WHERE T1.cs_status=? $wC";
			$result = $this->adapter->query($qry, array(1));
			$resultset = $result->toArray();

			if ($resultset) {
				foreach ($resultset as $key => $value) {
					$sqlOS = "SELECT FORMAT(ABS(SUM(T1.invoiceAmt)-(SELECT SUM(A.payAmt) FROM invoice_payment AS A WHERE A.idCustomer=T1.idCustomer AND A.idInvoice!=0)),2) AS outStanding
					FROM invoice_details AS T1
					WHERE T1.idCustomer=?";
					$resultOS = $this->adapter->query($sqlOS, array($value['idCustomer']));
					$resultsetOS = $resultOS->toArray();
					$emptyValue=0;
					if ($resultsetOS[0]['outStanding'] == $emptyValue) {
						unset($resultset[$key]);
					}else{
						$resultset[$key]['totaloutStanding']=number_format($resultsetOS [0]['outStanding'],2);
					}
				}
			}

			if ($resultset != null) {
				$result = ['success' => '1', 'message' => 'result successfully', 'result' => $resultset];
			} else {
				$result = ['success' => '2', 'message' => 'result failed'];
			}	
		}else{
			$result = ['success' => '2', 'message' => 'result failed'];			
		}
		return $result;
	}
	//Collection  
	public function Collection($param){
		if ($param->action='summary') {
			$idUser = $param->idUser;
			$listIndex = 0;
			$listIndex = ($param->listIndex)?$param->listIndex:0;
			$NextIndex = $listIndex+10;
			$TotalData=10;
			$limit="LIMIT ".$listIndex.",".$TotalData;
			$totalCount=0;
			$sqltotalCount = "SELECT T1.idCustomer, T1.customer_code, T1.cs_name AS customer_name, T1.cs_mail AS customer_mail, T1.cs_mobno AS customer_mobile_no FROM customer AS T1 LEFT JOIN invoice_details as INVC ON INVC.idCustomer=T1.idCustomer WHERE T1.sales_hrchy_name=? AND INVC.invoiceAmt>0 GROUP BY idCustomer";
			$resulttotalCount = $this->adapter->query($sqltotalCount, array($idUser));
			$resultsettotalCount = $resulttotalCount->toArray();
             $totalCount=count($resultsettotalCount);
			$sql = "SELECT T1.idCustomer, T1.customer_code, T1.cs_name AS customer_name, T1.cs_mail AS customer_mail, T1.cs_mobno AS customer_mobile_no FROM customer AS T1 LEFT JOIN invoice_details as INVC ON INVC.idCustomer=T1.idCustomer WHERE T1.sales_hrchy_name=? AND INVC.invoiceAmt>0 GROUP BY idCustomer $limit";
			$result = $this->adapter->query($sql, array($idUser));
			$resultset = $result->toArray();
			foreach ($resultset as $key => $value) {
				$sqlOS = "SELECT SUM(T1.invoiceAmt) AS invoiceAmt, 
				(SELECT SUM(A.payAmt) FROM invoice_payment AS A WHERE A.idCustomer=T1.idCustomer AND A.idInvoice!=0) AS payAmt
				FROM invoice_details AS T1
				WHERE T1.idCustomer=?";
				$resultOS = $this->adapter->query($sqlOS, array($value['idCustomer']));
				$resultsetOS = $resultOS->toArray();
                $outstatnding=$resultsetOS [0]['invoiceAmt']-$resultsetOS [0]['payAmt'];

				$resultset[$key]['totalInvoiceAmt']=number_format($resultsetOS [0]['invoiceAmt'],2);
				$resultset[$key]['totalPayAmt']=number_format($resultsetOS [0]['payAmt'],2);
				$resultset[$key]['totaloutStanding']=number_format($outstatnding,2);

					


			}
               
			if ($resultset != null) {
				$result = ['success' => '1', 'message' => 'result successfully', 'result' => $resultset,'totalCount'=>$totalCount,'listIndex'=>$NextIndex];
			} else {
				$result = ['success' => '2', 'message' => 'result failed'];
			}	
		}
		return $result;
	}

	public function empAddcart($param)
	{
        	$sql = "SELECT * FROM `empAddcart` WHERE idProduct='".$param->idProduct."' AND idProductsize='".$param->idProductsize."' AND idTerritory='".$param->idTerritory."' AND idCustomer='".$param->idCustomer."' AND idTeammember='".$param->idUser."' AND status='1'";
			$result = $this->adapter->query($sql, array());
			$resultset = $result->toArray();
			if (count($resultset)>0) 
			{
				$idaddcart=$resultset[0]['idAddcart'];
				$this->adapter->getDriver()->getConnection()->beginTransaction();
			try {
				$dataupdate['orderQty']=$param->orderQty;
				$dataupdate['created_at']=date("Y-m-d H:i:s");
				$dataupdate['created_by']=$param->idUser;
				
				$sql = new Sql($this->adapter);
				$update = $sql->update();
				$update->table('empAddcart');
				$update->set($dataupdate);
				$update->where(array('idAddcart' => $idaddcart));
				$statement  = $sql->prepareStatementForSqlObject($update);
				$results    = $statement->execute();
				$result = ['success' => '1', 'message' => 'Product Added successfully'];
				$this->adapter->getDriver()->getConnection()->commit();
			} catch(\Exception $e) {
				$result = ['success' => '2', 'message' => 'Please try again...'];

				$this->adapter->getDriver()->getConnection()->rollBack();
			}
			}
			else
			{
				  $this->adapter->getDriver()->getConnection()->beginTransaction();

					try {
						 
							$datainsert['idProduct']=$param->idProduct;
							$datainsert['idProductsize']=$param->idProductsize;
							$datainsert['idCustomer']=$param->idCustomer;
							$datainsert['orderQty']=$param->orderQty;
							$datainsert['idTeammember']=$param->idUser;
							$datainsert['idTerritory']=$param->idTerritory;							
							$datainsert['created_at']=date("Y-m-d H:i:s");
							$datainsert['status']=1;
							$datainsert['created_by']=$param->idUser;
							$insert=new Insert('empAddcart');
							$insert->values($datainsert);
							$statement=$this->adapter->createStatement();
							$insert->prepareStatement($this->adapter, $statement);
							$insertresult=$statement->execute();
						$result = ['success' => '1', 'message' => 'Product Added successfully'];
						$this->adapter->getDriver()->getConnection()->commit();
					} catch(\Exception $e) {
						$result = ['success' => '2', 'message' => 'Please try again...'];
						$this->adapter->getDriver()->getConnection()->rollBack();
					}
			}

      
					return $result;
	}


	public function empRemovecart($param)
	{
		$idaddcart=$param->idAddcart;
		$iduser=$param->idUser;

			$delete = new Delete('empAddcart');
			$delete->where(['idAddcart=?' => $idaddcart]);
			$statement=$this->adapter->createStatement();
			$delete->prepareStatement($this->adapter, $statement);
			$resultset=$statement->execute();
			$result = ['success' => '1', 'message' => 'Removed successfully'];
			return $result;

	}

	public function orderAdd($param)
	{
       
        $userid=$param->idUser;
        $salescode=$param->salesCode;
        $customerid=$param->idCustomer;
        $pono=$param->poNumber;
        $territory=$param->idTerritory;
        $billingAddress=$param->billingAddress;
        $podate=$param->poDate;
        $product=(json_decode($param->product,true));
        $overallData=(json_decode($param->GST,true));
        $totalChecked=0;
         for ($i=0; $i <count($product); $i++) 
         {
              if ($product[$i]['checked']==1) {
              	$totalChecked=$totalChecked+1;
              }
          }
      if ($totalChecked>0) 
      {
      	$this->adapter->getDriver()->getConnection()->beginTransaction();
				         try 
				          {
							$orderInsert['salesCode']=$salescode;
							$orderInsert['idCustomer']=$customerid;
							$orderInsert['poNumber']=$pono;
							$orderInsert['poDate']=date('Y-m-d',strtotime($podate));
							$orderInsert['idCustthierarchy']=$territory;
							$orderInsert['totalAmount']=round($overallData['totalPrice'],2);
							$orderInsert['totalCGST']=round($overallData['totalCGST'],2);
							$orderInsert['totalSGST']=round($overallData['totalSGST'],2);
							$orderInsert['totalIGST']=round($overallData['totalIGST'],2);
							$orderInsert['totalUTGST']=round($overallData['totalUTGST'],2);
							$orderInsert['totalTax']=round($overallData['totalGST'],2);
							$orderInsert['grandtotalAmount']=round($overallData['grandTotal'],2);	
							$orderInsert['billingAddress']=$billingAddress;				
							$orderInsert['created_by']=$userid;
							$orderInsert['created_at']=date('Y-m-d H:i:s');
							$orderInsert['update_by']=$userid;
							$orderInsert['updated_at']=date('Y-m-d H:i:s');
							$orderInsert['status']=1;
							$orderInsert['orderFrom']=2;
                         

							$insertorder=new Insert('orders');
							$insertorder->values($orderInsert);
							$statementorder=$this->adapter->createStatement();
							$insertorder->prepareStatement($this->adapter, $statementorder);
							$insertresultorder=$statementorder->execute();
                            $orderid=$this->adapter->getDriver()->getLastGeneratedValue();

                            for ($i=0; $i <count($product); $i++) 
                            { 
                            	if ($product[$i]['checked']==1) 
                            	{

                            		$orderitemInsert['idOrder']=$orderid;
                            		$orderitemInsert['idProduct']=$product[$i]['idProduct'];
                            		$orderitemInsert['idProductsize']=$product[$i]['idProductsize'];
                            		$orderitemInsert['orderQty']=$product[$i]['orderQty'];
                            		$orderitemInsert['price']=$product[$i]['productPrice'];
                            		$orderitemInsert['totalAmount']=$product[$i]['totalPrice'];
                            		$orderitemInsert['cgstAmount']=round($product[$i]['cgstAmount'],2);
                            		$orderitemInsert['sgstAmount']=round($product[$i]['sgstAmount'],2);
                            		$orderitemInsert['igstAmount']=round($product[$i]['igstAmount'],2);
                            		$orderitemInsert['utgstAmount']=round($product[$i]['ugstAmount'],2);
                            		$orderitemInsert['cgstPercent']=round($product[$i]['cgstPercent'],2);
                            		$orderitemInsert['sgstPercent']=round($product[$i]['sgstPercent'],2);
                            		$orderitemInsert['igstPercent']=round($product[$i]['igstPercent'],2);
                            		$orderitemInsert['utgstPercent']=round($product[$i]['ugstPercent'],2);
                            		$orderitemInsert['discountAmount']=round($product[$i]['discountAmount'],2);
                            		$orderitemInsert['NetAmount']=round($product[$i]['netPrice'],2);
                            		$orderitemInsert['idScheme']=($product[$i]['offers'])?$product[$i]['offers'][0]['idScheme']:0;
                            		$orderitemInsert['discountQty']=($product[$i]['offers'])?$product[$i]['offers'][0]['freeQty']:0;
                            		$orderitemInsert['discountJoinid']=($product[$i]['offers'])?$product[$i]['offers'][0]['idProduct']:0;

                            		$insertorderitem=new Insert('order_items');
                            		$insertorderitem->values($orderitemInsert);
                            		$statementorderitem=$this->adapter->createStatement();
                            		$insertorderitem->prepareStatement($this->adapter, $statementorderitem);
                            		$insertresultorderitem=$statementorderitem->execute();

                            		$idAddcart=$product[$i]['idAddcart'];


									$dataupdate['created_at']=date("Y-m-d H:i:s");
									$dataupdate['created_by']=$param->idUser;
									$dataupdate['status']=2;

									$sql = new Sql($this->adapter);
									$update = $sql->update();
									$update->table('empAddcart');
									$update->set($dataupdate);
									$update->where(array('idAddcart' => $idAddcart));
									$statement  = $sql->prepareStatementForSqlObject($update);
									$results    = $statement->execute();

                            	}

                            }
        
                        
							$ret_arr=['code'=>'2','success'=>'1','message'=>'Order placed successfully'];
							$this->adapter->getDriver()->getConnection()->commit();
				       } 
				       catch(\Exception $e) 
				       {
						$ret_arr=['code'=>'1','success'=>'2','message'=>'Please try again..'];
						$this->adapter->getDriver()->getConnection()->rollBack();
				       }
      }
      else
      {
      	 $ret_arr=['code'=>'1','success'=>'2','message'=>'Please add cart atleast one product'];
      }
        

				       return $ret_arr;
	}

	public function pjpList($param)
	{
       $userid=$param->idUser;
       $cycle_date=date('Y-m-d',strtotime($param->cycle_date));
       $idSaleshierarchy=$param->idSaleshierarchy;
           //list of customer type against the employee or sales hierarchy
		$sqlCtype = " SELECT CT.idCustomerType,CT.custType from customertype as CT 
		LEFT JOIN customer as C ON CT.idCustomerType=C.cs_type
		LEFT JOIN team_member_master as TMM ON TMM.idTeamMember=C.sales_hrchy_name
		LEFT JOIN sales_hierarchy as SH ON SH.idSaleshierarchy=C.idSalesHierarchy WHERE (C.idSalesHierarchy='$idSaleshierarchy' OR C.sales_hrchy_name='$userid') GROUP BY CT.idCustomertype";
		$resultCtype = $this->adapter->query($sqlCtype, array());
		$resultsetCtype = $resultCtype->toArray();
		$data=array();
        for ($i=0; $i <count($resultsetCtype) ; $i++) 
        { 
        	
			$data[$i]["idCustomerType"]=$resultsetCtype[$i]["idCustomerType"];
			$data[$i]["custType"]=$resultsetCtype[$i]["custType"];
			$data[$i]["no_custmer"]=0; //set number of customer in each customer type default 0
			$data[$i]['target']=0; //set number of target each customer type default 0
			//get number of customer in each customer type
           $sqlCcount = " SELECT C.idCustomer,C.cs_type,C.cs_name from  customer as C  WHERE (C.idSalesHierarchy='$idSaleshierarchy' OR C.sales_hrchy_name='$userid') AND C.cs_status=1 AND C.cs_type='".$resultsetCtype[$i]['idCustomerType']."'";
		$resultCcount = $this->adapter->query($sqlCcount, array());
		$resultsetCcount = $resultCcount->toArray();
				$target=array();
				foreach($resultsetCcount as $val){

				array_push($target,$val['idCustomer']);

				}

				$arry_cust_val=implode(',',$target);

				// get target of the each customer type
				$sqlTarget = "Select PJL.idCustomer from  pjp_detail AS PJ LEFT JOIN pjp_detail_list AS PJL ON PJL.idpjpdetail=PJ.idpjpdetail where PJL.cycle_day='".date('Y-m-d',strtotime($cycle_date))."' and PJ.idTeamMember='".$userid."' AND PJL.idCustomer in ($arry_cust_val)";
				$resultTarget = $this->adapter->query($sqlTarget, array());
				$resultsetTarget = $resultTarget->toArray();

            $data[$i]["no_custmer"]=count($resultsetCcount); //set number of customer in each customer type
			$data[$i]['target']=count($resultsetTarget); //set number of target each customer type	
        }
        if(count($data)>0)
        {
             $ret_arr=['code'=>'2','success'=>'1','message'=>'Data available','result'=>$data];
        }
        else
        {
             $ret_arr=['code'=>'2','success'=>'2','message'=>'No data available'];
        }
		
		return $ret_arr;

	}

	public function pjpCustomerlist($param)
	{
        
      $userid=$param->idUser;
      $idSaleshierarchy=$param->idSaleshierarchyidSaleshierarchy;
      $idCustomertype=$param->idCustomertype;
      //get customer list for corresponding customer type and employee
         $sqlCustomer = "SELECT C.idCustomer,C.cs_name,C.cs_serviceby,C.cs_mobno,CT.custType from  customer as C LEFT JOIN customertype as CT ON CT.idCustomerType=C.cs_type WHERE (C.idSalesHierarchy='$idSaleshierarchy' OR C.sales_hrchy_name='$userid') AND C.cs_status=1 AND C.cs_type='".$idCustomertype."'";
		$resultCustomer = $this->adapter->query($sqlCustomer, array());
		$resultsetCustomer = $resultCustomer->toArray();
        $data=array();
		for($iCont=0; $iCont<count($resultsetCustomer); $iCont++)
		{
		    //get cycle date in each customer
			$sqlcycle_dayVal = "SELECT cycle_day FROM pjp_detail_list where idCustomer='".$resultsetCustomer[$iCont]['idCustomer']."' ORDER BY cycle_day DESC";
			$resultcycle_dayVal = $this->adapter->query($sqlcycle_dayVal, array());
			$resultsetcycle_dayVal = $resultcycle_dayVal->toArray();
             //get service provider each customer
			$sqlcustomer_li = "SELECT idCustomer,cs_name FROM customer where idCustomer='".$resultsetCustomer[$iCont]['cs_serviceby']."'";
			$resultcustomer_li = $this->adapter->query($sqlcustomer_li, array());
			$resultsetcustomer_li = $resultcustomer_li->toArray();
			
		
			if(count($resultsetcustomer_li)>0){
				$customer=$resultsetcustomer_li[0]['cs_name'];
				
			}else{	
				$customer='company';
			}
		
		
			$data[$iCont]["idCustomer"]=$resultsetCustomer[$iCont]["idCustomer"];
			$data[$iCont]["cs_name"]=$resultsetCustomer[$iCont]["cs_name"];
			$data[$iCont]["cs_mobileno"]=$resultsetCustomer[$iCont]["cs_mobno"];
			$data[$iCont]["custType"]=$resultsetCustomer[$iCont]["custType"];
			$data[$iCont]["cs_serviceby"]=$customer;
			$data[$iCont]["cycle_day"]=$resultsetcycle_dayVal[0]['cycle_day'];
		
	   }

      if (count($data)>0) 
      {
			 $ret_arr=['code'=>'1','success'=>'1','message'=>'Data available','result'=>$data];
		}else
		{
			 $ret_arr=['code'=>'2','success'=>'2','message'=>'No data available'];
		}
	return $ret_arr;

	}

	public function pjpVisitCategory($param)
	{
           
		$qry=" SELECT idVisit,pjp_category FROM pjp_visit_status WHERE pjp_status='1'";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		if (count($resultset)>0) 
		{
			$ret_arr=['code'=>'1','success'=>'1','message'=>'Data available','result'=>$resultset];
		}else
		{
			$ret_arr=['code'=>'2','success'=>'2','message'=>'No data available'];
		}
		return $ret_arr;


	}
		public function orderList($param)
		{
			$userid=$param->idUser;
			$listIndex = 0;
			$listIndex = ($param->listIndex)?$param->listIndex:0;
			$NextIndex = $listIndex+15;
			$TotalData=15;
			$limit="LIMIT ".$listIndex.",".$TotalData;
			$totalCount=0;

			$qryTotalCount="SELECT ors.idOrder as totalOrder
			FROM orders as ors 
			LEFT JOIN customer as cr ON cr.idCustomer=ors.idCustomer WHERE cr.sales_hrchy_name='$userid' GROUP BY ors.idOrder";

		$resultTotalCount=$this->adapter->query($qryTotalCount,array());
		$resultsetTotalCount=$resultTotalCount->toArray();
		$totalCount=count($resultsetTotalCount);

           $qry="SELECT ors.poNumber as ponumber,ors.idOrder,
           ors.totalAmount,
           ors.totalCGST,
           ors.totalSGST,
           ors.totalIGST,
           ors.totalUTGST,
           ors.totalTax,
           ors.grandtotalAmount,
           ors.idCustomer as customer_id,
           DATE_FORMAT(ors.poDate,'%d-%m-%Y') as poDate,
           cr.cs_name as name,
           ors.idOrderfullfillment,
           IF(oa.idOrderallocate!='','1','0') as allocate,
           oa.status as dispatch_status,
            '' as allocateMsg,
            '' as dispatchMsg, 
            '' as fulfillmentMsg,
            '' as allocateColor,
            '' as fulfillmentColor,
            '' as dispatchColor
			FROM orders as ors 
			LEFT JOIN customer as cr ON cr.idCustomer=ors.idCustomer
			LEFT JOIN orders_allocated as oa ON oa.idOrder=ors.idOrder
			WHERE cr.sales_hrchy_name='$userid' GROUP BY ors.idOrder $limit";

		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		for ($i=0; $i <count($resultset) ; $i++) 
		{ 
			if ($resultset[$i]['idOrderfullfillment']!=0) 
			{
			   $resultset[$i]['fulfillmentMsg']="Completed";
			   $resultset[$i]['fulfillmentColor']="#008000";
			}else
			{
				$resultset[$i]['fulfillmentMsg']="Pending";
			   $resultset[$i]['fulfillmentColor']="#ff0000";
			}	

			if ($resultset[$i]['allocate']!=0) 
			{
			$resultset[$i]['allocateMsg']="Allocated";
			$resultset[$i]['allocateColor']="#008000";
			}else
			{
			$resultset[$i]['allocateMsg']="Not allocated";
			$resultset[$i]['allocateColor']="#ff0000";
			}
			if ($resultset[$i]['dispatch_status']=='' || $resultset[$i]['dispatch_status']==null) 
			{
			$resultset[$i]['dispatchMsg']="Waiting for Picklist";
			$resultset[$i]['dispatchColor']="#800080";
			}else if ($resultset[$i]['dispatch_status']==1) 
			{
			$resultset[$i]['dispatchMsg']="Picklist Ready";
			$resultset[$i]['dispatchColor']="#ca8602";
			}
			else if ($resultset[$i]['dispatch_status']==2) 
			{
			$resultset[$i]['dispatchMsg']="Cancel";
			$resultset[$i]['dispatchColor']="#ff0000";
			}
			else if ($resultset[$i]['dispatch_status']==3) 
			{
			$resultset[$i]['dispatchMsg']="Dispatched";
			$resultset[$i]['dispatchColor']="#ca8602";
			}
			else if ($resultset[$i]['dispatch_status']==4) 
			{
			$resultset[$i]['dispatchMsg']="Partially Dispatched";
			$resultset[$i]['dispatchColor']="#b97b06";
			}
			else if ($resultset[$i]['dispatch_status']==5) 
			{
			$resultset[$i]['dispatchMsg']="Delivered";
			$resultset[$i]['dispatchColor']="#008000";
			}
			else if ($resultset[$i]['dispatch_status']==6) 
			{
			$resultset[$i]['dispatchMsg']="Partially Delivered";
			$resultset[$i]['dispatchColor']="#868480";
			}
		}

		if (count($resultset)>0) 
		{
			$ret_arr=['code'=>'1','success'=>'1','message'=>'Data available','result'=>$resultset,'listIndex'=>$NextIndex,'totalCount'=>$totalCount];
		}else
		{
			$ret_arr=['code'=>'2','success'=>'2','message'=>'No data available'];
		}
		return $ret_arr;

		}

		public function ordersViewCustomer($param)
		{
			$orderid=$param->idOrder;
			//get order product details
            $qryeditvieworders="SELECT  ord.idOrder,
            ord.salesCode,
            ord.idCustomer,
            ord.poNumber,
            ord.billingAddress,
            '' as deliveryAddress,
            DATE_FORMAT(ord.poDate, '%d-%m-%Y') as poDate,
            ord.totalAmount AS TotAmt,
            ord.grandtotalAmount AS grandTot,
             ord.totalTax  AS TotTax ,
             c.cs_name,geo1.geoValue as g1,
             geo2.geoValue as g2,
             geo3.geoValue as g3,
             geo4.geoValue as g4,
             geo5.geoValue as g5,
             geo6.geoValue as g6,
             geo7.geoValue as g7,
             geo8.geoValue as g8,
             geo9.geoValue as g9,
             geo10.geoValue as g10,
             orditem.idProduct,
             orditem.idProductsize,
             orditem.orderQty,
             orditem.totalAmount,
             orditem.discountAmount,
             orditem.NetAmount,
             prd.productName,
             psize.productSize, 
             psize.productPrimaryCount,
             prd.productCount, 
             orditem.orderQty, 
             orditem.price,
             orditem.totalAmount
            ,pp.primarypackname ,
            pf.priceAmount,
            orditem.discountAmount,
            orditem.idScheme,
            orditem.discountQty,
            (orditem.cgstAmount+orditem.sgstAmount+orditem.igstAmount+orditem.utgstAmount) as taxamount,
             (orditem.cgstPercent+orditem.sgstPercent+orditem.igstPercent+orditem.utgstPercent) as taxpercentage,
            orditem.discountJoinid,(IF(orditem.discountQty>0,'1','0')) as discountStatus,'1' as offer_flog,
              (select companyName from sys_config) as companyName,
             (select companyAddress from sys_config) as companyAddress,
              (select companyLandline from sys_config) as companyLandline,
               (select companyWebsite from sys_config) as companyWebsite,
               (select companyLogo from sys_config) as companyLogo
            FROM `orders` as ord
            LEFT JOIN order_items as orditem on orditem.idOrder=ord.idOrder
            LEFT JOIN product_details as prd on prd.idProduct=orditem.idProduct
            LEFT JOIN product_size as psize on psize.idProductsize=orditem.idProductsize
            LEFT JOIN primary_packaging as pp on pp.idPrimaryPackaging=psize.idPrimaryPackaging
            LEFT JOIN price_fixing as pf on pf.idProductsize=psize.idProductsize
            LEFT JOIN customer as c on c.idCustomer=ord.idCustomer
            LEFT JOIN geography as geo1 on geo1.idGeography=c.G1
            LEFT JOIN geography as geo2 on geo2.idGeography=c.G2
            LEFT JOIN geography as geo3 on geo3.idGeography=c.G3
            LEFT JOIN geography as geo4 on geo4.idGeography=c.G4
            LEFT JOIN geography as geo5 on geo5.idGeography=c.G5
            LEFT JOIN geography as geo6 on geo6.idGeography=c.G6
            LEFT JOIN geography as geo7 on geo7.idGeography=c.G7
            LEFT JOIN geography as geo8 on geo8.idGeography=c.G8
            LEFT JOIN geography as geo9 on geo9.idGeography=c.G9
            LEFT JOIN geography as geo10 on geo10.idGeography=c.G10 WHERE ord.idOrder=? GROUP BY psize.idProductsize";
            $resulteditvieworders=$this->adapter->query($qryeditvieworders,array($orderid));
			$resultseteditvieworders=$resulteditvieworders->toArray();
				$customer['idCustomer']=$resultseteditvieworders[0]['idCustomer'];
				$customer['poDate']=$resultseteditvieworders[0]['poDate'];
				$customer['poNumber']=$resultseteditvieworders[0]['poNumber'];
				$customer['Country']=$resultseteditvieworders[0]['g1'];
				$customer['State']=$resultseteditvieworders[0]['g2'];
				$customer['City']=$resultseteditvieworders[0]['g3'];
				$customer['cs_name']=$resultseteditvieworders[0]['cs_name'];
                $customer['idOrder']=$resultseteditvieworders[0]['idOrder'];
				$overAllAmount['totalAmount']=$resultseteditvieworders[0]['TotAmt'];
				$overAllAmount['totalTax']=$resultseteditvieworders[0]['TotTax'];
				$overAllAmount['grandTotal']=$resultseteditvieworders[0]['grandTot'];
			
			$resultseteditvieworders[0]['companyDetails']=$resultsetCompany[0];
			$dlvryadrss='';
foreach ($resultseteditvieworders as $key => $value) 
{
	if ($value['g1']!='') 
	{
		$dlvryadrss=$dlvryadrss.''.$value['g1'];
	}
	if ($value['g2']!='') 
	{
		$dlvryadrss=$dlvryadrss.','.$value['g2'];
	}
	if ($value['g3']!='') 
	{
		$dlvryadrss=$dlvryadrss.','.$value['g3'];
	}
	if ($value['g4']!='') 
	{
		$dlvryadrss=$dlvryadrss.''.$value['g4'];
	}
	if ($value['g5']!='') 
	{
		$dlvryadrss=$dlvryadrss.''.$value['g5'];
	}
	if ($value['g6']!='') 
	{
		$dlvryadrss=$dlvryadrss.''.$value['g6'];
	}
	if ($value['g7']!='') 
	{
		$dlvryadrss=$dlvryadrss.''.$value['g7'];
	}
	if ($value['g8']!='') 
	{
		$dlvryadrss=$dlvryadrss.''.$value['g8'];
	}
	if ($value['g9']!='') 
	{
		$dlvryadrss=$dlvryadrss.''.$value['g9'];
	}
	if ($value['g10']!='') 
	{
		$dlvryadrss=$dlvryadrss.''.$value['g10'];
	}
	$resultseteditvieworders[$key]['deliveryAddress']=$dlvryadrss;
}

foreach ($resultseteditvieworders as $key => $value) 
{
	$resss[]=$value;

}
// get free product details
			for ($i=0; $i <count($resultseteditvieworders) ; $i++) 
			{ 
				
				if ($resultseteditvieworders[$i]['discountQty']>0) 
				{
					$schemeid=$resultseteditvieworders[$i]['idScheme'];
					$freeQty=$resultseteditvieworders[$i]['discountQty'];
					$qry="SELECT 
					'0' as idOrder,
					'0' as salesCode,
					'0' as idCustomer,
					'0' as poNumber,
					'0'  as poDate,
					'0'  AS TotAmt,
					'0'  AS grandTot,
					'0'  AS TotTax ,
					'0'  as g1,
					'0'  as g2,
					'0'  as g3,
					'0' as g4,
					'0' as g5,
					'0' as g6,
					'0' as g7,
					'0' as g8,
					'0' as g9,
					'0' as g10,
					'$freeQty' as orderQty,
					'0' as totalAmount,
					'0' as discountAmount,
					'0' as NetAmount,
					'0' as totalAmount,
					'0' as priceAmount,
					'0' as discountAmount,
					'$schemeid' as idScheme,
					'$freeQty' as discountQty,
					'0' as discountJoinid,
					'2' as offer_flog,
					prd.productName, 
					psize.productSize, 
					psize.productPrimaryCount, 
					psize.idProductsize,
					prd.productCount,
					prd.idProduct ,pp.primarypackname
					FROM product_details as prd 
					LEFT JOIN product_size as psize on psize.idProduct=prd.idProduct 
					LEFT JOIN primary_packaging as pp on pp.idPrimaryPackaging=psize.idPrimaryPackaging 
					WHERE prd.idProduct in(SELECT free_product as idProduct FROM `scheme` WHERE idScheme='$schemeid') AND psize.idProductsize in(SELECT free_product_size as idProductsize FROM `scheme` WHERE idScheme='$schemeid')";
					$result=$this->adapter->query($qry,array());
					$resultset=$result->toArray();
					$free_products[]=$resultset[0];

					foreach ($resultset as $key => $value) 
					{
							$resss[]=$value;
						
					}
				}
			}

			if(count($resss)>0)
			{
              $ret_arr=['code'=>'2','success'=>'1','result' =>$resss,'overallAmount'=>$overAllAmount,'customer'=>$customer,'message'=>'records available'];
			}
			else
			{
				$ret_arr=['code'=>'1','success'=>'2','message'=>'no records..'];
			}
			return $ret_arr;
		}

	public function pjpVisitCount($param)
	{
	     $userid=$param->idUser;
      $idSaleshierarchy=$param->idSaleshierarchy;
      $idCustomertype=$param->idCustomerType;
      $cycle_day=$param->cycle_date;
       //get customer list for corresponding customer type and employee
         $sqlCustomer = "SELECT C.idCustomer,C.cs_name,C.cs_serviceby,C.cs_mobno,CT.custType from  customer as C LEFT JOIN customertype as CT ON CT.idCustomerType=C.cs_type WHERE (C.idSalesHierarchy='$idSaleshierarchy' OR C.sales_hrchy_name='$userid') AND C.cs_status=1 AND C.cs_type='".$idCustomertype."'";
		$resultCustomer = $this->adapter->query($sqlCustomer, array());
		$resultsetCustomer = $resultCustomer->toArray();
		$target=array();	
		$data=array();	
			if(0<count($resultsetCustomer)){
				foreach($resultsetCustomer as $val){				
					array_push($target,$val['idCustomer']);
				}	
				$arry_cust_val=implode(',',$target);		
			}	
		
//SEGMENT TYPE WISE CUSTOMER COUNT
			 $sqlSegment = " SELECT count(a.idCustomer) as cnt,b.cs_segment_type AS idSegmentType,st.segmentName FROM pjp_detail AS PJP 
								LEFT JOIN pjp_detail_list as a ON a.idpjpdetail=PJP.idpjpdetail
								LEFT JOIN customer as b ON a.idCustomer=b.idCustomer
                                LEFT JOIN segment_type as st ON st.idsegmentType=b.cs_segment_type
								where a.cycle_day='".date('Y-m-d',strtotime($cycle_day))."' and PJP.idTeamMember='$userid' and a.idCustomer in ($arry_cust_val) GROUP BY b.cs_segment_type ";
		$resultSegment= $this->adapter->query($sqlSegment, array());
		$resultsetSegment = $resultSegment->toArray();
		
       //get total visit count for each segment type
		for ($i=0; $i <count($resultsetSegment) ; $i++) 
		{ 
			
			$sqlVisitcount = "SELECT COUNT(idpjpList) AS targetCnt,SUM(CASE WHEN idVisit!='0' THEN 1 ELSE 0 END) AS visitCnt FROM pjp_detail_list as a
			LEFT JOIN customer as b ON a.idCustomer=b.idCustomer
			LEFT JOIN segment_type as st ON st.idsegmentType=b.cs_segment_type WHERE a.cycle_day='".date('Y-m-d',strtotime($cycle_day))."' and a.idCustomer in ($arry_cust_val) and b.cs_segment_type='".$resultsetSegment[$i]['idSegmentType']."'";
			$resultVisitcount= $this->adapter->query($sqlVisitcount, array());
			$resultsetVisitcount= $resultVisitcount->toArray();

				$sqlCustomerSegment = "SELECT a.idCustomer  FROM pjp_detail AS PJP 
								LEFT JOIN pjp_detail_list as a ON a.idpjpdetail=PJP.idpjpdetail
								LEFT JOIN customer as b ON a.idCustomer=b.idCustomer
                                LEFT JOIN segment_type as st ON st.idsegmentType=b.cs_segment_type
								where a.cycle_day='".date('Y-m-d',strtotime($cycle_day))."' and PJP.idTeamMember='1' and a.idCustomer in ($arry_cust_val) AND b.cs_segment_type='".$resultsetSegment[$i]['idSegmentType']."'";
			$resultCustomerSegment= $this->adapter->query($sqlCustomerSegment, array());
			$resultsetCustomerSegment= $resultCustomerSegment->toArray();
			
			foreach ($resultsetCustomerSegment as $key => $value) 
			{
				$idCustomer[]=$value['idCustomer'];
			}
            $idCustomers=implode(',', $idCustomer);
			

			$tmp['categoryId']=$resultsetSegment[$i]['idSegmentType'];
				$tmp["category"]=$resultsetSegment[$i]['segmentName'];
				$tmp["NoOfCustomers"]=$resultsetSegment[$i]['cnt'];
				$tmp["Visited"]=$resultsetVisitcount[0]['visitCnt'];
				$tmp["idCustomer"]=$idCustomers;
				
				array_push($data,$tmp);
		}
				if (count($data)>0)
				{
				  $ret_arr=['code'=>'1','success'=>'1','message'=>'Data available','result'=>$data];
				}
				else
				{
				  $ret_arr=['code'=>'2','success'=>'2','message'=>'No data available'];
				}
    return $ret_arr;

	}

	public function pjpVisitCustomer($param)
	{
		$idCustomers=explode(',', $param->idCustomer);
		$idUser=$param->idUser;
		   $sqlCustomer = "SELECT C.idCustomer,
C.cs_name,
C.cs_mobno,
C.cs_mail,
C.customer_code,
C.cs_segment_type,
CT.custType,
CT.idCustomerType,g1.geoValue as g1,
g2.geoValue as g2,
g3.geoValue as g3,
g4.geoValue as g4,
g5.geoValue as g5,
g6.geoValue as g6,
g7.geoValue as g7,
g8.geoValue as g8,
g9.geoValue as g9,
g10.geoValue as g10
FROM `customer`  as C 
LEFT JOIN customertype as CT ON C.cs_type=CT.idCustomerType 
LEFT JOIN geography as g1 ON g1.idGeography=C.G1
LEFT JOIN geography as g2 ON g2.idGeography=C.G2
LEFT JOIN geography as g3 ON g3.idGeography=C.G3
LEFT JOIN geography as g4 ON g4.idGeography=C.G4
LEFT JOIN geography as g5 ON g5.idGeography=C.G5
LEFT JOIN geography as g6 ON g6.idGeography=C.G6
LEFT JOIN geography as g7 ON g7.idGeography=C.G7
LEFT JOIN geography as g8 ON g8.idGeography=C.G8
LEFT JOIN geography as g9 ON g9.idGeography=C.G9
LEFT JOIN geography as g10 ON g10.idGeography=C.G10

WHERE idCustomer in($param->idCustomer)";
		$resultCustomer = $this->adapter->query($sqlCustomer, array());
		$resultsetCustomer = $resultCustomer->toArray();

		for ($i=0; $i < count($resultsetCustomer); $i++) 
		{ 
			$address='';
			if($resultsetCustomer[$i]['g1']!='')
			{
               $address=$resultsetCustomer[$i]['g1'];
			}
			if($resultsetCustomer[$i]['g2']!='')
			{
               $address=$address.', '.$resultsetCustomer[$i]['g2'];
			}
			if($resultsetCustomer[$i]['g3']!='')
			{
               $address=$address.', '.$resultsetCustomer[$i]['g3'];
			}
			if($resultsetCustomer[$i]['g4']!='')
			{
               $address=$address.', '.$resultsetCustomer[$i]['g4'];
			}
			if($resultsetCustomer[$i]['g5']!='')
			{
               $address=$address.', '.$resultsetCustomer[$i]['g5'];
			}
			if($resultsetCustomer[$i]['g6']!='')
			{
               $address=$address.', '.$resultsetCustomer[$i]['g6'];
			}
			if($resultsetCustomer[$i]['g7']!='')
			{
               $address=$address.', '.$resultsetCustomer[$i]['g7'];
			}
			if($resultsetCustomer[$i]['g8']!='')
			{
               $address=$address.', '.$resultsetCustomer[$i]['g8'];
			}
			if($resultsetCustomer[$i]['g9']!='')
			{
               $address=$address.', '.$resultsetCustomer[$i]['g9'];
			}
			if($resultsetCustomer[$i]['g10']!='')
			{
               $address=$address.', '.$resultsetCustomer[$i]['g10'];
			}

			$resultsetCustomer[$i]['address']=$address;

		}

		if (count($resultsetCustomer)>0) 
		{
			$ret_arr=['code'=>'1','success'=>'1','message'=>'Data available','idSegmentType'=>$resultsetCustomer[0]['cs_segment_type'],'result'=>$resultsetCustomer];
		}
		else
		{
			$ret_arr=['code'=>'2','success'=>'2','message'=>'No data available'];
		}
       return $ret_arr;
	}

	public function geographyTitle($param)
	{
		$idUser=$param->idUser;
      
         $sqlGeographytitle = "SELECT * FROM `geographytitle_master`   WHERE title!=''
ORDER BY `geographytitle_master`.`idGeographyTitle` ASC";
		$resultGeographytitle = $this->adapter->query($sqlGeographytitle, array());
		$resultsetGeographytitle = $resultGeographytitle->toArray();
		if (count($resultsetGeographytitle)>0) 
		{
			$ret_arr=['code'=>'1','success'=>'1','message'=>'Data available','result'=>$resultsetGeographytitle];
		}
		else
		{
			$ret_arr=['code'=>'2','success'=>'2','message'=>'No data available'];
		}

		return $ret_arr;
	}

	public function geographyValue($param)
	{
		$idGeographyTitle=$param->idGeographyTitle;
         $idUser=$param->idUser;
         $data=array();
         $sqlGeographyValue = "SELECT `idGeography` ,`idGeographyTitle`,`geoCode`,`geoValue`,`status`FROM `geography` WHERE `idGeographyTitle`='".$idGeographyTitle."' AND status=1 ORDER BY geoValue ASC";
		$resultGeographyValue = $this->adapter->query($sqlGeographyValue, array());
		$resultsetGeographyValue = $resultGeographyValue->toArray();
		// print_r($resultsetGeographyValue);
		for ($i=0; $i < count($resultsetGeographyValue); $i++) 
		{ 
			$idGeography=$resultsetGeographyValue[$i]['idGeography'];

			$sqlInvoiceamount = "SELECT sum(invcdet.invoiceAmt) as invoiceAmount,count(distinct(c.idCustomer)) as totalVenders from customer as c LEFT JOIN invoice_details as invcdet ON invcdet.idCustomer=c.idCustomer
			WHERE (c.G1='$idGeography' or c.G2='$idGeography' or c.G3='$idGeography' or c.G4='$idGeography' or c.G5='$idGeography' or c.G6='$idGeography' or c.G7='$idGeography' or c.G8='$idGeography' or c.G9='$idGeography' or c.G10='$idGeography') AND c.sales_hrchy_name='$idUser'";
			$resultInvoiceamount = $this->adapter->query($sqlInvoiceamount, array());
			$resultsetInvoiceamount = $resultInvoiceamount->toArray();
		
			// print_r($resultsetInvoiceamount);

			$sqlPayamount = "SELECT  sum(ipay.payAmt) as invoicePayamount FROM customer as c LEFT JOIN `invoice_payment` as ipay ON ipay.idCustomer=c.idCustomer WHERE (c.G1='$idGeography' or c.G2='$idGeography' or c.G3='$idGeography' or c.G4='$idGeography' or c.G5='$idGeography' or c.G6='$idGeography' or c.G7='$idGeography' or c.G8='$idGeography' or c.G9='$idGeography' or c.G10='$idGeography') AND c.sales_hrchy_name='$idUser' AND ipay.payType='On Bill'";
			$resultPayamount = $this->adapter->query($sqlPayamount, array());
			$resultsetPayamount = $resultPayamount->toArray();

			$payAmt=($resultsetPayamount[0]['invoicePayamount']!='')?$resultsetPayamount[0]['invoicePayamount']:0;
			$outstandingAmount=$resultsetInvoiceamount[0]['invoiceAmount']-$payAmt;
			if ($outstandingAmount>0) 
			{
				$tmp=array();
			$tmp["geoValue"]=$resultsetGeographyValue[$i]["geoValue"];
			$tmp["no_accounts"]=$resultsetInvoiceamount[0]["totalVenders"];
			$tmp["outstandingAmount"]=number_format($outstandingAmount,2);
			$tmp["idGeography"]=$idGeography;
			array_push($data,$tmp);
			}

			

		}
		if (count($data)>0) 
		{
			$ret_arr=['code'=>'1','success'=>'1','message'=>'Data available','result'=>$data];
		}
		else
		{
			$ret_arr=['code'=>'2','success'=>'2','message'=>'No data available'];
		}
		return $ret_arr;
	}

	public function myCollectionGeography($param)
	{
       $iduser=$param->idUser;
       $idTerritorytitle=$param->idGeographyTitle;
       $idGeography=$param->idGeography;
       $data=array();
       $sqlCustomer = "SELECT c.cs_name,c.idCustomer,c.cs_mobno,c.cs_mail,c.customer_code from customer as c 
WHERE (c.G1='$idGeography' or G2='$idGeography' or G3='$idGeography' or G4='$idGeography' or G5='$idGeography' or G6='$idGeography' or G7='$idGeography' or G8='$idGeography' or G9='$idGeography' or G10='$idGeography') AND c.sales_hrchy_name='$iduser'";
		$resultCustomer = $this->adapter->query($sqlCustomer, array());
		$resultsetCustomer = $resultCustomer->toArray();

         for ($i=0; $i < count($resultsetCustomer); $i++) 
		{
			$idCustomer=$resultsetCustomer[$i]['idCustomer'];
			

$sqlCusAddress = "SELECT g1.geoValue as g1,g2.geoValue as g2,g3.geoValue as g3,g4.geoValue as g4,g5.geoValue as g5,g6.geoValue as g6,g7.geoValue as g7,g8.geoValue as g8,g9.geoValue as g9,g10.geoValue as g10,ct.custType,ct.idCustomerType FROM `customer` as c LEFT JOIN geography as g1 ON g1.idGeography=c.G1
LEFT JOIN geography as g2 ON g2.idGeography=c.G2
LEFT JOIN geography as g3 ON g3.idGeography=c.G3
LEFT JOIN geography as g4 ON g4.idGeography=c.G4
LEFT JOIN geography as g5 ON g5.idGeography=c.G5
LEFT JOIN geography as g6 ON g6.idGeography=c.G6
LEFT JOIN geography as g7 ON g7.idGeography=c.G7
LEFT JOIN geography as g8 ON g8.idGeography=c.G8
LEFT JOIN geography as g9 ON g9.idGeography=c.G9
LEFT JOIN geography as g10 ON g10.idGeography=c.G10
LEFT JOIN customertype as ct ON ct.idCustomerType=c.cs_type
 WHERE c.idCustomer='".$idCustomer."'";
			$resultCusAddress = $this->adapter->query($sqlCusAddress, array());
			$resultsetCusAddress = $resultCusAddress->toArray();
			$address='';
			if($resultsetCusAddress[0]['g1']!='')
			{
               $address=$resultsetCusAddress[0]['g1'];
			}
			if($resultsetCusAddress[0]['g2']!='')
			{
               $address=$address.', '.$resultsetCusAddress[0]['g2'];
			}
			if($resultsetCusAddress[0]['g3']!='')
			{
               $address=$address.', '.$resultsetCusAddress[0]['g3'];
			}
			if($resultsetCusAddress[0]['g4']!='')
			{
               $address=$address.', '.$resultsetCusAddress[0]['g4'];
			}
			if($resultsetCusAddress[0]['g5']!='')
			{
               $address=$address.', '.$resultsetCusAddress[0]['g5'];
			}
			if($resultsetCusAddress[0]['g6']!='')
			{
               $address=$address.', '.$resultsetCusAddress[0]['g6'];
			}
			if($resultsetCusAddress[0]['g7']!='')
			{
               $address=$address.', '.$resultsetCusAddress[0]['g7'];
			}
			if($resultsetCusAddress[0]['g8']!='')
			{
               $address=$address.', '.$resultsetCusAddress[0]['g8'];
			}
			if($resultsetCusAddress[0]['g9']!='')
			{
               $address=$address.', '.$resultsetCusAddress[0]['g9'];
			}
			if($resultsetCusAddress[0]['g10']!='')
			{
               $address=$address.', '.$resultsetCusAddress[0]['g10'];
			}

			$sqlInvoiceamount = "SELECT sum(invcdet.invoiceAmt) as invoiceAmount from  invoice_details as invcdet 
			WHERE invcdet.idCustomer='".$idCustomer."'";
			$resultInvoiceamount = $this->adapter->query($sqlInvoiceamount, array());
			$resultsetInvoiceamount = $resultInvoiceamount->toArray();

		 
			$sqlPayamount = "SELECT sum(payAmt) as payAmt FROM invoice_payment WHERE idCustomer='".$idCustomer."' AND payType='On Bill'";
			$resultPayamount = $this->adapter->query($sqlPayamount, array());
			$resultsetPayamount = $resultPayamount->toArray();

			$payAmt=($resultsetPayamount[0]['payAmt']!='')?$resultsetPayamount[0]['payAmt']:0;
			$outstandingAmount=$resultsetInvoiceamount[0]['invoiceAmount']-$payAmt;

			
		
			if($outstandingAmount>0)
			{
				$tmp=array();
			$tmp["cs_name"]=$resultsetCustomer[$i]["cs_name"];
			$tmp["idCustomer"]=$resultsetCustomer[$i]["idCustomer"];
			$tmp["cs_mobno"]=$resultsetCustomer[$i]["cs_mobno"];
			$tmp["cs_mail"]=$resultsetCustomer[$i]["cs_mail"];
			$tmp["customer_code"]=$resultsetCustomer[$i]["customer_code"];			
			$tmp["payAmt"]=number_format($payAmt,2);
			$tmp["invoiceAmount"]=number_format($resultsetInvoiceamount[0]['invoiceAmount'],2);
			$tmp["outstandingAmount"]=number_format($outstandingAmount,2);
			$tmp["address"]=$address;
			$tmp["idCustomerType"]=$resultsetCusAddress[0]['idCustomerType'];
			$tmp["custType"]=$resultsetCusAddress[0]['custType'];
			   array_push($data,$tmp);	
			}
            

		}
		if (count($data)>0) 
		{
			$ret_arr=['code'=>'1','success'=>'1','message'=>'Data available','result'=>$data];
		}
		else
		{
			$ret_arr=['code'=>'2','success'=>'2','message'=>'No data available'];
		}
		return $ret_arr;
	}

	public function marketingQuestionList($param)
	{
        $idUser=$param->idUser;
         $idCustomer=$param->idCustomer;
        $qryQuestion="SELECT idQuestion,questionType,question,status,'' as answare,'' as idAnsware,option1,option2,option3,option4 FROM `questions`";
		$resultQuestion=$this->adapter->query($qryQuestion,array());
		$resultsetQuestion=$resultQuestion->toArray();
          for ($i=0; $i < count($resultsetQuestion); $i++) 
          { 
          	$idQuestion=$resultsetQuestion[$i]['idQuestion'];
          	 $qryAnsware="SELECT idAnsware,answare FROM `answares` WHERE idQuestion=? AND idCustomer=?";
		$resultAnsware=$this->adapter->query($qryAnsware,array($idQuestion,$idCustomer));
		$resultsetAnsware=$resultAnsware->toArray();
		$resultsetQuestion[$i]['answare']=$resultsetAnsware[0]['answare'];
		$resultsetQuestion[$i]['idAnsware']=$resultsetAnsware[0]['idAnsware'];
          }
		

		if (count($resultsetQuestion)>0) 
		{
			$ret_arr=['code'=>'1','success'=>'1','message'=>'Data available','result'=>$resultsetQuestion];
		}
		else
		{
		   $ret_arr=['code'=>'2','success'=>'2','message'=>'No data available'];
		}	

   return $ret_arr;
	}

	public function answareAdd($param)
	{
      //print_r($param); exit;
		$fiedls=(json_decode($param->result,true));
		$idCustomer=$param->idCustomer;
		$idUser=$param->idUser;
		$ansCount=0;
		//print_r($fiedls); exit;
		foreach ($fiedls as $key => $value) 
		{
			if ($value['answare']!='' && $value['answare']!='null' && $value['answare']!=null) {
				$ansCount=$ansCount+1;
			}

		}

		if($ansCount>0) 
		{ 
			$this->adapter->getDriver()->getConnection()->beginTransaction();
			try {
				foreach ($fiedls as $key => $value) 
				{
					$idQuestion=$value['idQuestion'];
					if ($value['answare']!='' && $value['answare']!='null' && $value['answare']!=null)
					{
						$qryAlreadyAnsware="SELECT * FROM `answares` WHERE idCustomer=? AND idQuestion=?";
						$resultAlreadyAnsware=$this->adapter->query($qryAlreadyAnsware,array($idCustomer,$idQuestion));
						$resultsetAlreadyAnsware=$resultAlreadyAnsware->toArray();
						if (count($resultsetAlreadyAnsware)>0) 
						{

							$dataupdate['idQuestion']=$value['idQuestion'];
							$dataupdate['idCustomer']=$idCustomer;
							$dataupdate['answare']=$value['answare'];
							$dataupdate['updated_at']=date("Y-m-d H:i:s"); 
							$dataupdate['updated_by']=$idUser;
							$sql = new Sql($this->adapter);
							$update = $sql->update();
							$update->table('answares');
							$update->set($dataupdate);
							$update->where(array('idAnsware' => $value['idAnsware']));
							$statement = $sql->prepareStatementForSqlObject($update);
							$results = $statement->execute();
						}
						else
						{
							$datainsert['idQuestion']=$value['idQuestion'];
							$datainsert['idCustomer']=$idCustomer;
							$datainsert['answare']=$value['answare'];
							$datainsert['created_at']=date("Y-m-d H:i:s"); 
							$datainsert['created_by']=$idUser;

							$insert=new Insert('answares');
							$insert->values($datainsert);
							$statement=$this->adapter->createStatement();
							$insert->prepareStatement($this->adapter, $statement);
							$insertresult=$statement->execute();
							
						} 
					}


				}
				$this->adapter->getDriver()->getConnection()->commit();
				$ret_arr=['code'=>'2','success'=>'1','message'=>'Added successfully'];
			} catch (\Exception $e) 
			{
				$ret_arr=['code'=>'1','success'=>'2','message'=>'Please try again..'.$e];
				$this->adapter->getDriver()->getConnection()->rollBack();
			}
		} 
		else 
		{
			$ret_arr=['code'=>'3','success'=>'2','message'=>'Please answare atleast one question'];
		}
		return $ret_arr;
	}

	public function receiptNoStatus($param)
	{
       $qryrecieptData="SELECT ld.idLedger,
ld.ledgerNo,
ld.recieptFromNo,
ld.recieptToNo,
ld.totalReciept,
ld.usedReciept,
ld.idColEmp,
ld.entryDate,
DATE_FORMAT(ld.entryDate, '%d-%m-%Y') as entry_Date,
'0' as totalcancel,'0' as totalmissing,'0' as totalavail,'0' as totalused,
tm1.territoryValue as city,
tm2.territoryValue as pincode,
tm3.territoryValue as area,
tm4.territoryValue as street,
tmm.name,
tmm.code,
tmm.status,
tmc.territoryValue as empCity,
tmc2.territoryValue as empPincode,
tmc3.territoryValue as empArea,
tmc4.territoryValue as empStreet
FROM `ledger_details` as ld 
LEFT JOIN territory_master as tm1 on tm1.idTerritory=ld.t3 
LEFT JOIN territory_master as tm2 on tm2.idTerritory=ld.t4
LEFT JOIN territory_master as tm3 on tm3.idTerritory=ld.t5
LEFT JOIN territory_master as tm4 on tm4.idTerritory=ld.t6
LEFT JOIN team_member_master as tmm on tmm.idTeamMember=ld.idColEmp
LEFT JOIN territory_master as tmc on tmc.idTerritory=tmm.t3
LEFT JOIN territory_master as tmc2 on tmc2.idTerritory=tmm.t4
LEFT JOIN territory_master as tmc3 on tmc3.idTerritory=tmm.t5
LEFT JOIN territory_master as tmc4 on tmc4.idTerritory=tmm.t6
WHERE idLedger='".$param->idLedger."'";
			$resultrecieptData=$this->adapter->query($qryrecieptData,array());
			$resultsetrecieptData=$resultrecieptData->toArray();
			
		
		$totalreciept=$resultsetrecieptData[0]['recieptToNo'];
		//$usedcount=count(explode(',',$resultsetrecieptData[0]['usedReciept']));
		$usedRecieptExp=explode(',',$resultsetrecieptData[0]['usedReciept']);
		$usedReciept=@array_filter($usedRecieptExp);
		$usedcount=count($usedReciept);
		$resultsetrecieptData[0]['totalused']=$usedcount;
		$LedgerCancel=array();
		$qryLedgercancel="SELECT * FROM `ledger_cancel` WHERE idLedger='".$param->idLedger."' AND idColEmp='".$resultsetrecieptData[0]['idColEmp']."'";
		
		$resultLedgercancel=$this->adapter->query($qryLedgercancel,array());
		$resultsetLedgercancel=$resultLedgercancel->toArray();
		for($iCont=0; $iCont<=count($resultsetLedgercancel); $iCont++)
		{
		 $LedgerCancel[]=$resultsetLedgercancel[$iCont]["recptNo"];
		}
		
		$cancelcount=count($resultsetLedgercancel);
		$resultsetrecieptData[0]['totalcancel']=$cancelcount;
		$usedRecieptCount=$totalreciept-$usedcount-$cancelcount;
		$j=0; 
		for($iCont=$resultsetrecieptData[0]["recieptFromNo"]; $iCont<=$usedRecieptCount; $iCont++)
		{
		 $j++;
		}
$k=0;
$totalmissing=0;
$totalcancel=0;
		for($i=$resultsetrecieptData[0]["recieptFromNo"]; $i<=$totalreciept; $i++)
		{

			$recieptstatus[$k]['recieptno']=$i;
			$recieptstatus[$k]['status']=0;
			if($i<=@max($usedReciept))
			{ 
				if(in_array($i, $usedReciept))
				{
				$classVal='divRecieptNoG'; 
				$titleVal='Used';
				$recieptstatus[$k]['status']=1;
				$recieptstatus[$k]['color']='#008000';
				$recieptstatus[$k]['title']='Used';
				}elseif(in_array($i, $LedgerCancel))
				{
				$classVal='divRecieptNoR'; $titleVal='Cancel';
				$recieptstatus[$k]['status']=2;
				$recieptstatus[$k]['color']='#ff0000';
				$recieptstatus[$k]['title']='Cancel';
				$totalcancel=$totalcancel+1;
				}else
				{
				$classVal='divRecieptNoO'; $titleVal='Missed';
				$recieptstatus[$k]['status']=3;
				$recieptstatus[$k]['color']='#800080';
				$recieptstatus[$k]['title']='Missed';
				$totalmissing=$totalmissing+1;
				}
			}
			elseif(in_array($i, $LedgerCancel))
			{
				$classVal='divRecieptNoR'; $titleVal='Cancel';
				$recieptstatus[$k]['status']=2;
				$recieptstatus[$k]['color']='#ff0000';
				$recieptstatus[$k]['title']='Cancel';
				$totalcancel=$totalcancel+1;
			}else
			{
				$classVal='divRecieptNoW'; $titleVal='Available';
				$recieptstatus[$k]['status']=4;
				$recieptstatus[$k]['color']='#868480';
				$recieptstatus[$k]['title']='Available';
			}
			$k=$k+1;
		}

		$resultsetrecieptData[0]['totalmissing']=$totalmissing;
		$resultsetrecieptData[0]['totalcancel']=$totalcancel;
		$resultsetrecieptData[0]['totalavail']=$totalreciept-$cancelcount;
		$resultsetrecieptData[0]['recieptstatus']=$recieptstatus;
			$ret_arr=['code'=>'2','status'=>true,'result'=>$resultsetrecieptData,'message'=>'Data available'];
      return $ret_arr;
	}

	public function customerSearch($param)
	{
      $idUser=$param->idUser;
      $customerType=$param->idCustomerType;
      $customerCodeMobile=$param->customerCodeMobile;
      
		$sqlCustomer = "SELECT T1.idCustomer AS id_customer, T1.cs_name AS name, T1.customer_code AS customer_code, T1.cs_mobno AS mobile_no, T2.custType AS customer_type,
		(CASE
		WHEN T1.cs_serviceby =0 THEN 'Company'
		WHEN T1.cs_serviceby !=0 THEN (SELECT A.cs_name FROM customer AS A WHERE A.idCustomer=T1.cs_serviceby)
		END) AS serviceby_name
		FROM customer AS T1 
		LEFT JOIN customertype AS T2 ON T2.idCustomerType=T1.cs_type
		WHERE T1.cs_type=? AND T1.sales_hrchy_name=? AND T1.cs_status=1 AND (T1.customer_code=? OR T1.cs_mobno=?) ";
		$resultCustomer = $this->adapter->query($sqlCustomer, array($customerType,$idUser,$customerCodeMobile,$customerCodeMobile));
		$resultsetCustomer = $resultCustomer->toArray();

		foreach ($resultsetCustomer as $key => $value) {

				$sqlOS = "SELECT SUM(T1.invoiceAmt) AS invoiceAmt, 
				(SELECT SUM(A.payAmt) FROM invoice_payment AS A WHERE A.idCustomer=T1.idCustomer AND A.idInvoice!=0) AS payAmt,  
				ABS(SUM(T1.invoiceAmt)-
				(SELECT SUM(A.payAmt) FROM invoice_payment AS A WHERE A.idCustomer=T1.idCustomer AND A.idInvoice!=0)) AS outStanding
						FROM invoice_details AS T1
						WHERE T1.idCustomer=?";
				$resultOS = $this->adapter->query($sqlOS, array($value['id_customer']));
				$resultsetOS = $resultOS->toArray();
				$collectionStatus = ($resultsetOS[$key]['outStanding'] > 0) ? 1 : 0; // 0= No outstandingAmt 

				$resultsetCustomer[$key]['collectionStatus'] = $collectionStatus;
			}
			
		if (count($resultsetCustomer)>0) 
		{
			$ret_arr=['code'=>'1','success'=>'1','message'=>'Data available','result'=>$resultsetCustomer];
		}
		else
		{
			$ret_arr=['code'=>'2','success'=>'2','message'=>'No data available'];
		}

		return $ret_arr;
	}

	public function pjpVisitCustomerSearch($param)
	{
		
		$idUser=$param->idUser;
		$customerCodeMobile=$param->customerCodeMobile;
		 $customerType=$param->idCustomerType;
		 $segementType=$param->idSegmentType;
		   $sqlCustomer = "SELECT C.idCustomer,
C.cs_name,
C.cs_mobno,
C.cs_mail,
C.customer_code,
CT.custType,
CT.idCustomerType,g1.geoValue as g1,
g2.geoValue as g2,
g3.geoValue as g3,
g4.geoValue as g4,
g5.geoValue as g5,
g6.geoValue as g6,
g7.geoValue as g7,
g8.geoValue as g8,
g9.geoValue as g9,
g10.geoValue as g10
FROM `customer`  as C 
LEFT JOIN customertype as CT ON C.cs_type=CT.idCustomerType 
LEFT JOIN geography as g1 ON g1.idGeography=C.G1
LEFT JOIN geography as g2 ON g2.idGeography=C.G2
LEFT JOIN geography as g3 ON g3.idGeography=C.G3
LEFT JOIN geography as g4 ON g4.idGeography=C.G4
LEFT JOIN geography as g5 ON g5.idGeography=C.G5
LEFT JOIN geography as g6 ON g6.idGeography=C.G6
LEFT JOIN geography as g7 ON g7.idGeography=C.G7
LEFT JOIN geography as g8 ON g8.idGeography=C.G8
LEFT JOIN geography as g9 ON g9.idGeography=C.G9
LEFT JOIN geography as g10 ON g10.idGeography=C.G10

WHERE (C.customer_code=? OR C.cs_mobno=?) AND C.cs_segment_type=? AND C.sales_hrchy_name=? AND C.cs_type=?";
		$resultCustomer = $this->adapter->query($sqlCustomer, array($customerCodeMobile,$customerCodeMobile,$segementType,$idUser,$customerType));
		$resultsetCustomer = $resultCustomer->toArray();

		for ($i=0; $i < count($resultsetCustomer); $i++) 
		{ 
			$address='';
			if($resultsetCustomer[$i]['g1']!='')
			{
               $address=$resultsetCustomer[$i]['g1'];
			}
			if($resultsetCustomer[$i]['g2']!='')
			{
               $address=$address.', '.$resultsetCustomer[$i]['g2'];
			}
			if($resultsetCustomer[$i]['g3']!='')
			{
               $address=$address.', '.$resultsetCustomer[$i]['g3'];
			}
			if($resultsetCustomer[$i]['g4']!='')
			{
               $address=$address.', '.$resultsetCustomer[$i]['g4'];
			}
			if($resultsetCustomer[$i]['g5']!='')
			{
               $address=$address.', '.$resultsetCustomer[$i]['g5'];
			}
			if($resultsetCustomer[$i]['g6']!='')
			{
               $address=$address.', '.$resultsetCustomer[$i]['g6'];
			}
			if($resultsetCustomer[$i]['g7']!='')
			{
               $address=$address.', '.$resultsetCustomer[$i]['g7'];
			}
			if($resultsetCustomer[$i]['g8']!='')
			{
               $address=$address.', '.$resultsetCustomer[$i]['g8'];
			}
			if($resultsetCustomer[$i]['g9']!='')
			{
               $address=$address.', '.$resultsetCustomer[$i]['g9'];
			}
			if($resultsetCustomer[$i]['g10']!='')
			{
               $address=$address.', '.$resultsetCustomer[$i]['g10'];
			}

			$resultsetCustomer[$i]['address']=$address;

		}

		if (count($resultsetCustomer)>0) 
		{
			$ret_arr=['code'=>'1','success'=>'1','message'=>'Data available','result'=>$resultsetCustomer];
		}
		else
		{
			$ret_arr=['code'=>'2','success'=>'2','message'=>'No data available'];
		}
       return $ret_arr;
	}

	public function myCollectionGeographySearch($param)
	{
		$iduser=$param->idUser;
       $idTerritorytitle=$param->idGeographyTitle;
       $idGeography=$param->idGeography;
       $customerCodeMobile=$param->customerCodeMobile;
       $data=array();
       $sqlCustomer = "SELECT c.cs_name,c.idCustomer,c.cs_mobno,c.cs_mail,c.customer_code from customer as c 
WHERE (c.G1='$idGeography' or G2='$idGeography' or G3='$idGeography' or G4='$idGeography' or G5='$idGeography' or G6='$idGeography' or G7='$idGeography' or G8='$idGeography' or G9='$idGeography' or G10='$idGeography') AND c.sales_hrchy_name='$iduser' AND (c.customer_code='$customerCodeMobile' OR c.cs_mobno='$customerCodeMobile')";
		$resultCustomer = $this->adapter->query($sqlCustomer, array());
		$resultsetCustomer = $resultCustomer->toArray();

         for ($i=0; $i < count($resultsetCustomer); $i++) 
		{
			$idCustomer=$resultsetCustomer[$i]['idCustomer'];
			

$sqlCusAddress = "SELECT g1.geoValue as g1,g2.geoValue as g2,g3.geoValue as g3,g4.geoValue as g4,g5.geoValue as g5,g6.geoValue as g6,g7.geoValue as g7,g8.geoValue as g8,g9.geoValue as g9,g10.geoValue as g10,ct.custType,ct.idCustomerType FROM `customer` as c LEFT JOIN geography as g1 ON g1.idGeography=c.G1
LEFT JOIN geography as g2 ON g2.idGeography=c.G2
LEFT JOIN geography as g3 ON g3.idGeography=c.G3
LEFT JOIN geography as g4 ON g4.idGeography=c.G4
LEFT JOIN geography as g5 ON g5.idGeography=c.G5
LEFT JOIN geography as g6 ON g6.idGeography=c.G6
LEFT JOIN geography as g7 ON g7.idGeography=c.G7
LEFT JOIN geography as g8 ON g8.idGeography=c.G8
LEFT JOIN geography as g9 ON g9.idGeography=c.G9
LEFT JOIN geography as g10 ON g10.idGeography=c.G10
LEFT JOIN customertype as ct ON ct.idCustomerType=c.cs_type
 WHERE c.idCustomer='".$idCustomer."'";
			$resultCusAddress = $this->adapter->query($sqlCusAddress, array());
			$resultsetCusAddress = $resultCusAddress->toArray();
			$address='';
			if($resultsetCusAddress[0]['g1']!='')
			{
               $address=$resultsetCusAddress[0]['g1'];
			}
			if($resultsetCusAddress[0]['g2']!='')
			{
               $address=$address.', '.$resultsetCusAddress[0]['g2'];
			}
			if($resultsetCusAddress[0]['g3']!='')
			{
               $address=$address.', '.$resultsetCusAddress[0]['g3'];
			}
			if($resultsetCusAddress[0]['g4']!='')
			{
               $address=$address.', '.$resultsetCusAddress[0]['g4'];
			}
			if($resultsetCusAddress[0]['g5']!='')
			{
               $address=$address.', '.$resultsetCusAddress[0]['g5'];
			}
			if($resultsetCusAddress[0]['g6']!='')
			{
               $address=$address.', '.$resultsetCusAddress[0]['g6'];
			}
			if($resultsetCusAddress[0]['g7']!='')
			{
               $address=$address.', '.$resultsetCusAddress[0]['g7'];
			}
			if($resultsetCusAddress[0]['g8']!='')
			{
               $address=$address.', '.$resultsetCusAddress[0]['g8'];
			}
			if($resultsetCusAddress[0]['g9']!='')
			{
               $address=$address.', '.$resultsetCusAddress[0]['g9'];
			}
			if($resultsetCusAddress[0]['g10']!='')
			{
               $address=$address.', '.$resultsetCusAddress[0]['g10'];
			}

			$sqlInvoiceamount = "SELECT sum(invcdet.invoiceAmt) as invoiceAmount from  invoice_details as invcdet 
			WHERE invcdet.idCustomer='".$idCustomer."'";
			$resultInvoiceamount = $this->adapter->query($sqlInvoiceamount, array());
			$resultsetInvoiceamount = $resultInvoiceamount->toArray();

		 
			$sqlPayamount = "SELECT sum(payAmt) as payAmt FROM invoice_payment WHERE idCustomer='".$idCustomer."' AND payType='On Bill'";
			$resultPayamount = $this->adapter->query($sqlPayamount, array());
			$resultsetPayamount = $resultPayamount->toArray();

			$payAmt=($resultsetPayamount[0]['payAmt']!='')?$resultsetPayamount[0]['payAmt']:0;
			$outstandingAmount=$resultsetInvoiceamount[0]['invoiceAmount']-$payAmt;

			
		
			if($outstandingAmount>0)
			{
				$tmp=array();
			$tmp["cs_name"]=$resultsetCustomer[$i]["cs_name"];
			$tmp["idCustomer"]=$resultsetCustomer[$i]["idCustomer"];
			$tmp["cs_mobno"]=$resultsetCustomer[$i]["cs_mobno"];
			$tmp["cs_mail"]=$resultsetCustomer[$i]["cs_mail"];
			$tmp["customer_code"]=$resultsetCustomer[$i]["customer_code"];			
			$tmp["payAmt"]=number_format($payAmt,2);
			$tmp["invoiceAmount"]=number_format($resultsetInvoiceamount[0]['invoiceAmount'],2);
			$tmp["outstandingAmount"]=number_format($outstandingAmount,2);
			$tmp["address"]=$address;
			$tmp["idCustomerType"]=$resultsetCusAddress[0]['idCustomerType'];
			$tmp["custType"]=$resultsetCusAddress[0]['custType'];
			   array_push($data,$tmp);	
			}
            

		}
		if (count($data)>0) 
		{
			$ret_arr=['code'=>'1','success'=>'1','message'=>'Data available','result'=>$data];
		}
		else
		{
			$ret_arr=['code'=>'2','success'=>'2','message'=>'No data available'];
		}
		return $ret_arr;
	}

	


}