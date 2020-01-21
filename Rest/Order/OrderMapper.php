<?php
namespace Sales\V1\Rest\Order;
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

class OrderMapper {

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

	public function orderEntryCat($param) {
		if ($param->action=='categoryList') {
			$qrycat="SELECT A.idCategory as id, A.category AS name FROM category AS  A WHERE A.status=?";
			$resultcat=$this->adapter->query($qrycat,array('1'));
			$resultsetcat=$resultcat->toArray();

			$ret_arr=['code'=>'1','status'=>true,'message'=>'Category records','content' =>$resultsetcat];
		} else {
			$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please try again..'];
		}
		return $ret_arr;	
	}
	

	public function orderEntrySubCat($param) {
		if($param->action=='list') {
			$qry="SELECT a.idCategory as id,a.category as name,a.status FROM category a ";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();

			for($i=0;$i<count($resultset);$i++) 
			{
				$cat_id=$resultset[$i]['id'];
				if($cat_id=='') 
				{
				  $resultset[$i]['tax_other']=='';
				} 
				else 
				{
				$qry1="SELECT a.idSubCategory as subid,a.idCategory as catid,a.subcategory as subname,a.status 
			      FROM subcategory a
			      WHERE a.idCategory in ($cat_id)";
				$res=$this->adapter->query($qry1,array());
				$resulttax=$res->toArray();
				$resultset[$i]['tax_other']=$resulttax;
                
                for ($m=0; $m <count($resultset[$i]['tax_other']) ; $m++) 
                { 
                	$catid=$resultset[$i]['tax_other'][$m]['catid'];
                	$subid=$resultset[$i]['tax_other'][$m]['subid'];

                	if($catid=='' && $subid=='') {
				      $resultset[$i]['tax_other'][$m]['pro_other']=='';
				} 
				else 
				{
					$qry2="SELECT a.idProduct as proid,a.productName as prodname,s.productSize as size,a.productUnit as unit,a.productShelf as qty,a.productSize as stock,f.priceAmount as price
				      FROM product_details a
				      LEFT JOIN product_size s on s.idProduct=a.idProduct
				      LEFT JOIN price_fixing f on f.idProduct=a.idProduct
				      WHERE a.idCategory in ($catid) and a.idSubCategory in ($subid)";
					$res1=$this->adapter->query($qry2,array());
					$resulttax1=$res1->toArray();
					$resultset[$i]['tax_other'][$m]['pro_other']=$resulttax1;
					
               }
                }

				}
				
			}

			if($resultset){
				$ret_arr=['code'=>'1','content'=>$resultset,'status'=>true,'message'=>'No of records'.count($resultset)];
			} else {
				$ret_arr=['code'=>'2','content'=>'','status'=>false,'message'=>'No records to view'];
			}
		}
		else if ($param->action=='getcustomer') 
		{
			
				$cstype=0;
				$userid=$param->userid;
				$customer_code=$param->customercode;
		        $status=false;

					//check the login customer service provide or not  that customer code entered
					$qryLogin="SELECT idCustomer FROM user_login WHERE idLogin=?";
					$resultLogin=$this->adapter->query($qryLogin,array($userid));
					$resultsetLogin=$resultLogin->toArray();
                    
					$qryEntrycustomer="SELECT idCustomer,cs_name FROM customer WHERE customer_code=? AND cs_status=1";
					$resultEntrycustomer=$this->adapter->query($qryEntrycustomer,array($customer_code));
					$resultsetEntrycustomer=$resultEntrycustomer->toArray(); 
		if(count($resultsetEntrycustomer)>0)
		{


		     if ($resultsetLogin[0]['idCustomer']==0) 
		     {
		     	$status=true;
		     }
		     else if($resultsetLogin[0]['idCustomer']==$resultsetEntrycustomer[0]['idCustomer'])
		     {
		        $status=true;
		     }
		     else 
		     {
		     	$qryLogincustomer="SELECT idCustomer,cs_type FROM customer WHERE customer_code=? AND cs_serviceby=? AND cs_status=1";
				$resultLogincustomer=$this->adapter->query($qryLogincustomer,array($customer_code,$resultsetLogin[0]['idCustomer']));
				$resultsetLogincustomer=$resultLogincustomer->toArray(); 
				if (count($resultsetLogincustomer)>0) 
				{
					$status=true;
				}
				else
				{
					$status=false;
				}
		     }
		      if ($status==true) 
        {
        	$qrycustomer="SELECT cus.idCustomer,cus.customer_code,cus.cs_name,cus.G1,cus.G2,cus.G3,cus.G4,cus.G5,cus.G6,cus.G7,cus.G8,cus.G9,cus.G10,cus.cs_tinno,cus.cs_potential_value,cus.cs_type,cus.idPreferredwarehouse,wm.t2,tm.territoryUnion,
geo1.geoValue as h1,
geo2.geoValue as h2,
geo3.geoValue as h3,
geo4.geoValue as h4,
geo5.geoValue as h5,
geo6.geoValue as h6,
geo7.geoValue as h7,
geo8.geoValue as h8,
geo9.geoValue as h9,
geo10.geoValue as h10,
ca.warehouse_ids,
ca.territory_ids,
ca.category_ids,
ca.channel_ids,count(ord.idOrder)+1 as ordcount,c.custType
FROM `customer` as cus  
LEFT JOIN customer_allocation as ca on ca.customer_id=cus.idCustomer
LEFT JOIN customertype as c on c.idCustomerType=cus.cs_type
LEFT JOIN `geography` as geo1 ON geo1.idGeography=cus.G1
LEFT JOIN `geography` as geo2 ON geo2.idGeography=cus.G2
LEFT JOIN `geography` as geo3 ON geo3.idGeography=cus.G3
LEFT JOIN `geography` as geo4 ON geo4.idGeography=cus.G4
LEFT JOIN `geography` as geo5 ON geo5.idGeography=cus.G5
LEFT JOIN `geography` as geo6 ON geo6.idGeography=cus.G6
LEFT JOIN `geography` as geo7 ON geo7.idGeography=cus.G7
LEFT JOIN `geography` as geo8 ON geo8.idGeography=cus.G8
LEFT JOIN `geography` as geo9 ON geo9.idGeography=cus.G9
LEFT JOIN `geography` as geo10 ON geo10.idGeography=cus.G10
LEFT JOIN warehouse_master as wm on wm.idWarehouse=cus.idPreferredwarehouse
LEFT JOIN territory_master as tm on tm.idTerritory=wm.t2
LEFT JOIN orders as ord on ord.idCustomer=cus.idCustomer
WHERE cus.customer_code=? AND cus.cs_status=1";
			$resultcustomer=$this->adapter->query($qrycustomer,array($customer_code));
			$resultsetcustomer=$resultcustomer->toArray();
        
			
            // SELECT idTerritory,territoryValue,territoryUnion FROM `territory_master` WHERE idTerritory IN(2,3,4)
            if(count($resultsetcustomer)>0)
            {

            	$warehouseid = ($resultsetcustomer[0]['warehouse_ids'])?unserialize($resultsetcustomer[0]['warehouse_ids']):'';
			$warehouseidfinal=($warehouseid)?implode(',',$warehouseid):'';
			$territoryid =($resultsetcustomer[0]['territory_ids'])? unserialize($resultsetcustomer[0]['territory_ids']):'';
			$territoryidfinal=($territoryid)?implode(',',$territoryid):'';
			$categoryid = ($resultsetcustomer[0]['category_ids'])?unserialize($resultsetcustomer[0]['category_ids']):'';
			$channel_id = ($resultsetcustomer[0]['channel_ids'])?unserialize($resultsetcustomer[0]['channel_ids']):'';
			if($warehouseidfinal!='')
			{
              $qrywarehouse="SELECT wm.warehouseName,
wm.idWarehouse,
wm.t1,
wm.t2,
wm.t3,
wm.t4,
wm.t5,
wm.t6,
wm.t7,
wm.t8,
wm.t9,
wm.t10,
tm2.territoryUnion as tm2union,
tm1.territoryValue as tm1value,
tm2.territoryValue  as tm2value,
tm3.territoryValue  as tm3value,
tm4.territoryValue  as tm4value,
tm5.territoryValue  as tm5value,
tm6.territoryValue  as tm6value,
tm7.territoryValue  as tm7value,
tm8.territoryValue  as tm8value,
tm9.territoryValue  as tm9value,
tm10.territoryValue  as tm10value
FROM `warehouse_master` as wm 
LEFT JOIN territory_master as tm1 on tm1.idTerritory=wm.t1 
LEFT JOIN territory_master as tm2 on tm2.idTerritory=wm.t2
LEFT JOIN territory_master as tm3 on tm3.idTerritory=wm.t3
LEFT JOIN territory_master as tm4 on tm4.idTerritory=wm.t4
LEFT JOIN territory_master as tm5 on tm5.idTerritory=wm.t5
LEFT JOIN territory_master as tm6 on tm6.idTerritory=wm.t6
LEFT JOIN territory_master as tm7 on tm7.idTerritory=wm.t7
LEFT JOIN territory_master as tm8 on tm8.idTerritory=wm.t8
LEFT JOIN territory_master as tm9 on tm9.idTerritory=wm.t9
LEFT JOIN territory_master as tm10 on tm10.idTerritory=wm.t10
WHERE idWarehouse in($warehouseidfinal) AND wm.status=1";
			$resultwarehouse=$this->adapter->query($qrywarehouse,array());
			$resultsetwarehouse=$resultwarehouse->toArray();
			}
			else
			{
				$resultsetwarehouse=[];
			}
			
            if($territoryidfinal!='')
            {
               $qryterritory="SELECT idTerritory,territoryValue,territoryUnion FROM `territory_master` WHERE idTerritory IN($territoryidfinal) AND status=1";
			$resultterritory=$this->adapter->query($qryterritory,array());
			$resultsetterritory=$resultterritory->toArray();
            }
            else
            {
            	$resultsetterritory=[];
            }
			
			if(count($resultsetwarehouse)>0)
			{
               $ret_arr=['code'=>'1','status'=>true,'message'=>' customer records ','content' =>$resultsetcustomer,'warehouse'=>$resultsetwarehouse,'territory'=>$resultsetterritory];
			}
			else
			{
				 $ret_arr=['code'=>'1','status'=>false,'message'=>' Please allocate delivery point to the customer '];
			}

            	
            } //status true if statement close
            else
            {
              $ret_arr=['code'=>'1','status'=>false,'message'=>'You not able to provide service for this customer'];
            }
        }
				
		}	
       
        else
        {
        	$ret_arr=['code'=>'1','status'=>false,'message'=>'Invalid customer code '];
        }
			
			
			
		} 
        else if($param->action=='getproduct')
        {
			$territory_code=$param->territorycode;
			$customertype=$param->customertype;
		     $customerid=$param->customerid;
		     $podate=$param->podate;
		     
			$qryterritory="SELECT pd.idProduct,
			pd.idSubCategory,
			pd.productCode,
			pd.productName,
			pd.idCategory,
			pd.productUnit,
			pd.productCount,
			pp.idPrimaryPackaging,
			ps.productSize,
			ps.idProductsize,
			pp.primarypackname,
			cat.category,
			subcat.subcategory 
			FROM product_details as pd 
			LEFT JOIN product_size as ps on ps.idProduct=pd.idProduct 
			LEFT JOIN primary_packaging as pp on pp.idPrimaryPackaging=ps.idPrimaryPackaging 
			LEFT JOIN category as cat on cat.idCategory=pd.idCategory
			LEFT JOIN subcategory as subcat on subcat.idSubCategory=pd.idSubCategory
			WHERE pd.idProduct IN(SELECT idProduct FROM `product_territory_details` WHERE idTerritory='$territory_code') AND pd.status=1 AND ps.status=1";
			$resultterritory=$this->adapter->query($qryterritory,array());
			$resultsetterritory=$resultterritory->toArray();
                //get state is union territory or state
				$qrystateUnion="SELECT tmm.t2,tm.idTerritory,tm.territoryValue,tm.territoryUnion FROM `territorymapping_master` as tmm LEFT JOIN territory_master as tm on tm.idTerritory=tmm.t2 WHERE tmm.t1='$territory_code' or tmm.t2='$territory_code' or tmm.t3='$territory_code' or tmm.t4='$territory_code' or tmm.t5='$territory_code' or tmm.t6='$territory_code' or tmm.t7='$territory_code' or tmm.t8='$territory_code' or tmm.t9='$territory_code' or tmm.t10='$territory_code' AND tm.status=1";
			$resultstateUnion=$this->adapter->query($qrystateUnion,array());
			$resultsetstateUnion=$resultstateUnion->toArray();

			

			//get discount
			$qryDiscount="SELECT idScheme,schemeType,idCustomerType,schemeStartdate,schemeEnddate,idCategory,idSubCategory,idProduct,scheme_product_size,scheme_product_qty,scheme_flat_discount,discount_type,free_product_size,free_product_qty,free_product FROM `scheme` WHERE idTerritory='$territory_code'  and schemeStartdate<=CURRENT_DATE and schemeEnddate>=CURRENT_DATE";
			$resultDiscount=$this->adapter->query($qryDiscount,array());
			$resultsetDiscount=$resultDiscount->toArray();

			
			for($i=0;$i<count($resultsetterritory);$i++) 
			{
				$catids[]=$resultsetterritory[$i]['idCategory'];
				$subcatids[]=$resultsetterritory[$i]['idSubCategory'];	
			}
			$catids_final=($catids)?implode(',',array_unique($catids)):'';
			$subcatids_final=($subcatids)?implode(',',array_unique($subcatids)):'';
			$qry="SELECT a.idCategory as id,a.category as name,a.status FROM category a WHERE a.idCategory in($catids_final) AND a.status=1";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
		


			for($i=0;$i<count($resultset);$i++) 
			{
				$cat_id=$resultset[$i]['id'];
				$subcat_id=$resultset[$i]['id'];
				if($cat_id=='') 
				{
					$resultset[$i]['sub_cat']=='';
					$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Category not avail corresponding territory..'];
				} 
				else 
				{
					$qry3="SELECT pd.idSubCategory as subid,subcat.subcategory as subname ,subcat.idCategory as catid,subcat.status
					FROM product_details as pd 
					LEFT JOIN category as cat on cat.idCategory=pd.idCategory 
					LEFT JOIN subcategory as subcat on subcat.idSubCategory=pd.idSubCategory 
					WHERE pd.idProduct IN(SELECT idProduct FROM `product_territory_details` WHERE idTerritory='$territory_code') and subcat.idCategory IN ($cat_id) GROUP BY pd.idSubCategory";

				
					$res=$this->adapter->query($qry3,array());
					$resultsubcat=$res->toArray();
					$resultset[$i]['sub_cat']=$resultsubcat;

					for ($m=0; $m <count($resultset[$i]['sub_cat']) ; $m++) 
					{ 
						$catid=$resultset[$i]['sub_cat'][$m]['catid'];
						$subid=$resultset[$i]['sub_cat'][$m]['subid'];

						if($catid=='' && $subid=='') 
						{
							$resultset[$i]['sub_cat'][$m]['product_data']=='';
							$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'subcategory not avail corresponding territory..'];
						} 
						else 
						{

						
                             //get product price and commission details
							$qrycommissionAmount="SELECT pd.idProduct as proid, 
							pd.idCategory,
							pd.idSubCategory, 
							pd.productName as prodname, 
							dm.distributn_unit as commissionPercent, 
							pf.priceAmount as normalPrice, 
							ps.productSize as size, 
							dm.idCustomerType, 
							ps.productPrimaryCount as qty, 
							ps.idProductsize as psizeid, 
							ROUND((dm.distributn_unit*pf.priceAmount/100),2) as commisionAmount, 
							ROUND((pf.priceAmount-(dm.distributn_unit*pf.priceAmount/100)),2) as originalPrice 
							from product_details as pd 
							LEFT JOIN gst_master as gm on gm.idHsncode=pd.idHsncode 
							LEFT JOIN product_size as ps on ps.idProduct=pd.idProduct 
							LEFT JOIN price_fixing as pf on pf.idProductsize=ps.idProductsize 
							LEFT JOIN distribution_margin as dm on dm.idProductsize=ps.idProductsize where pd.idCategory in($catid) and pd.idSubCategory in($subid) and pd.status=1 and ps.status=1 and dm.idCustomerType='$customertype'";
							$rescommissionAmount=$this->adapter->query($qrycommissionAmount,array());
							$resultcommissionAmount=$rescommissionAmount->toArray();
                            //get product with discount and gst details
							$qryProduct="SELECT pd.idProduct as proid, 
							pd.productName as prodname, 
							pd.productUnit as unitmeasure, pd.productCount, 
							gm.gstValue as gstPercent, 
							pf.priceAmount as normalPrice, 
							ps.productSize as size, ps.productPrimaryCount as qty, 
							ps.idProductsize as psizeid, '0' as stock, '0' as status,
							pp.primarypackname as unitname, 
							0 as discount, 
							0 as discountproductQty, 
							0 as discountType, 
							0 as free_product_size,
							0 as free_product_qty,
							0 as free_product,0 as idScheme,
							now() as disFromdate, 
							now() as disTodate,
							pd.expireDate,'' as originalPrice
							from product_details as pd 
							LEFT JOIN gst_master as gm on gm.idHsncode=pd.idHsncode 
							LEFT JOIN product_size as ps on ps.idProduct=pd.idProduct 
							LEFT JOIN primary_packaging as pp on pp.idPrimaryPackaging=ps.idPrimaryPackaging 
							LEFT JOIN price_fixing as pf on pf.idProductsize=ps.idProductsize 
							
							where pd.idCategory in($catid) and pd.idSubCategory in($subid) and pd.status=1 and ps.status=1 group by ps.idProductsize";
							$resProduct=$this->adapter->query($qryProduct,array());
							$resultProduct=$resProduct->toArray();

							for($p=0;$p<count($resultProduct);$p++)
							{
							//original billing proce for the corresponding product	

							$qryPrice="SELECT `b_biilingprice` as originalPrice FROM `customer_billing_price` WHERE idProduct='".$resultProduct[$p]['proid']."' AND idProductsize='".$resultProduct[$p]['psizeid']."' AND idTerritory='".$territory_code."' AND idCustomertype='".$customertype."' AND billingDate<=CURRENT_DATE ORDER BY created_at desc LIMIT 1";
							$resPrice=$this->adapter->query($qryPrice,array());
							$resultPrice=$resPrice->toArray();

							if(count($resultPrice)>0)
							{
                               $resultProduct[$p]['originalPrice']=$resultPrice[0]['originalPrice'];
							}
								//combine commission to product array
                              for($q=0;$q<count($resultcommissionAmount);$q++)
                              {
                                  if ($resultcommissionAmount[$q]['proid']==$resultProduct[$p]['proid'] && $resultcommissionAmount[$q]['psizeid']==$resultProduct[$p]['psizeid']) 
                                  {
                                  	$resultProduct[$p]['commissionPercent']=$resultcommissionAmount[$q]['commissionPercent'];
                                  	$resultProduct[$p]['commisionAmount']=$resultcommissionAmount[$q]['commisionAmount'];
                                  	// $resultProduct[$p]['originalPrice']=$resultcommissionAmount[$q]['originalPrice'];
                                  }
                              }
                              //combine stock to product array
                               //get total stock
                              if ($resultProduct[$p]['expireDate']==1) 
                              {
                              	 $qryWHstock="SELECT SUM(WST.sku_accept_qty) AS whStockQty FROM whouse_stock_items AS WST 
					WHERE WST.idProduct='".$resultProduct[$p]['proid']."' AND 
					WST.idProdSize='".$resultProduct[$p]['psizeid']."' 
					AND WST.idWarehouse 
					in(SELECT idWarehouse FROM `warehouse_master` WHERE 
					t1='$territory_code' OR 
					t2='$territory_code' OR 
					t3='$territory_code' OR 
					t4='$territory_code' OR 
					t5='$territory_code' OR 
					t6='$territory_code' OR 
					t7='$territory_code' OR 
					t8='$territory_code' OR 
					t9='$territory_code' OR 
					t10='$territory_code') AND 
					WST.sku_expiry_date>=NOW()";
                              }
                              else
                              {
                              	$qryWHstock="SELECT SUM(WST.sku_accept_qty) AS whStockQty FROM whouse_stock_items AS WST 
					WHERE WST.idProduct='".$resultProduct[$p]['proid']."' AND 
					WST.idProdSize='".$resultProduct[$p]['psizeid']."' 
					AND WST.idWarehouse 
					in(SELECT idWarehouse FROM `warehouse_master` WHERE 
					t1='$territory_code' OR 
					t2='$territory_code' OR 
					t3='$territory_code' OR 
					t4='$territory_code' OR 
					t5='$territory_code' OR 
					t6='$territory_code' OR 
					t7='$territory_code' OR 
					t8='$territory_code' OR 
					t9='$territory_code' OR 
					t10='$territory_code')";
                              }
					
					$resultWHstock=$this->adapter->query($qryWHstock,array());
					$resultsetWHstock=$resultWHstock->toArray();
					$ttlstockQty=($resultsetWHstock[0]['whStockQty']=='' || $resultsetWHstock[0]['whStockQty']==null)?0:$resultsetWHstock[0]['whStockQty'];
                    //get damage qty
					$qryWHdamage="SELECT SUM(WSD.dmg_prod_qty) AS whDamageQty FROM whouse_stock_damge AS WSD WHERE WSD.idProduct='".$resultProduct[$p]['proid']."' AND WSD.idProdSize='".$resultProduct[$p]['psizeid']."' AND WSD.idWarehouse in(SELECT idWarehouse FROM `warehouse_master` WHERE 
					t1='$territory_code' OR 
					t2='$territory_code' OR 
					t3='$territory_code' OR 
					t4='$territory_code' OR 
					t5='$territory_code' OR 
					t6='$territory_code' OR 
					t7='$territory_code' OR 
					t8='$territory_code' OR 
					t9='$territory_code' OR 
					t10='$territory_code')";
					$resultWHdamage=$this->adapter->query($qryWHdamage,array());
					$resultsetWHdamage=$resultWHdamage->toArray();
                    $ttldamageQty=($resultsetWHdamage[0]['whDamageQty']=='' || $resultsetWHdamage[0]['whDamageQty']==null)?0:$resultsetWHdamage[0]['whDamageQty'];
                      //get return qty
					$qryWHreturn="SELECT SUM(COR.rtnQty) AS custRtnQty FROM customer_order_return AS COR LEFT JOIN dispatch_product_batch AS DPB ON COR.idDispatchProductBatch=DPB.idDispatchProductBatch LEFT JOIN whouse_stock_items AS WST ON WST.idWhStockItem=DPB.idWhStockItem WHERE WST.idProduct='".$resultProduct[$p]['proid']."' AND WST.idProdSize='".$resultProduct[$p]['psizeid']."' AND WST.idWarehouse in(SELECT idWarehouse FROM `warehouse_master` WHERE 
					t1='$territory_code' OR 
					t2='$territory_code' OR 
					t3='$territory_code' OR 
					t4='$territory_code' OR 
					t5='$territory_code' OR 
					t6='$territory_code' OR 
					t7='$territory_code' OR 
					t8='$territory_code' OR 
					t9='$territory_code' OR 
					t10='$territory_code')";
					$resultWHreturn=$this->adapter->query($qryWHreturn,array());
					$resultsetWHreturn=$resultWHreturn->toArray();

					  $ttlreturnQty=($resultsetWHreturn[0]['custRtnQty']=='')?0:$resultsetWHreturn[0]['custRtnQty'];
                     //order allocate qty
					$qryWHorder="SELECT SUM(WOI.picklistQty) AS whOrderQty FROM orders_allocated AS WO LEFT JOIN orders_allocated_items AS WOI ON WOI.idOrderallocated=WO.idOrderallocate WHERE WOI.idProduct='".$resultProduct[$p]['proid']."' AND WOI.idProductsize='".$resultProduct[$p]['psizeid']."' AND WO.idWarehouse in(SELECT idWarehouse FROM `warehouse_master` WHERE 
					t1='$territory_code' OR 
					t2='$territory_code' OR 
					t3='$territory_code' OR 
					t4='$territory_code' OR 
					t5='$territory_code' OR 
					t6='$territory_code' OR 
					t7='$territory_code' OR 
					t8='$territory_code' OR 
					t9='$territory_code' OR 
					t10='$territory_code')";
					$resultWHorder=$this->adapter->query($qryWHorder,array());
					$resultsetWHorder=$resultWHorder->toArray();

					  $ttlorderQty=($resultsetWHorder[0]['whOrderQty']=='' || $resultsetWHorder[0]['whOrderQty']==null)?0:$resultsetWHorder[0]['whOrderQty'];
                       //available total stockqty
						$avlStockQtyVal=(($ttlstockQty+$ttlreturnQty) - ($ttldamageQty+$ttlorderQty));
	                    $tot_stock=number_format( $avlStockQtyVal,2,'.','');

	                    $resultProduct[$p]['stock']=$tot_stock;	
                        //re-order level calculation
	                    $qryreOrd_lvl="SELECT idCustomer, idWarehouse, idLevel, idPackage, idProduct, idProdSize, re_level, re_qty, re_max_stock, re_min_stock, re_days, ($tot_stock) AS tot_stock FROM inventorynorms WHERE idProduct='".$resultProduct[$p]['proid']."' AND idProdSize='".$resultProduct[$p]['psizeid']."' AND idWarehouse in(SELECT idWarehouse FROM `warehouse_master` WHERE 
					t1='$territory_code' OR 
					t2='$territory_code' OR 
					t3='$territory_code' OR 
					t4='$territory_code' OR 
					t5='$territory_code' OR 
					t6='$territory_code' OR 
					t7='$territory_code' OR 
					t8='$territory_code' OR 
					t9='$territory_code' OR 
					t10='$territory_code')";
					$resultreOrd_lvl=$this->adapter->query($qryreOrd_lvl,array());
					$resultsetreOrd_lvl=$resultreOrd_lvl->toArray();
					$status=0;
                   if (count($resultsetreOrd_lvl)>0) 
                   {
                   	$per_reorder=$resultset[$i]['warehouse'][$j]['re_level']*20/100;
                     
                     $tt=$per_reorder+$resultset[$i]['warehouse'][$j]['re_level'];
                     if ($tt<=$tot_stock)  //green color background in reorder stock qty
                     {
                     	$status=1;
                     }
                     else if ($resultset[$i]['warehouse'][$j]['re_level']<=$tot_stock)  //light orange color
                     {
                     	$status=2;
                     }
                     else
                     {
                        $status=0; // red color
                     }

                   }
                   else
                   {
                   	 $status=0;  // red color
                   }
                     
                       $resultProduct[$p]['status']=$status;
       //discount date get each product
                              
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
free_product FROM `scheme` WHERE idTerritory='$territory_code' AND idProduct='".$resultProduct[$p]['proid']."' AND scheme_product_size='".$resultProduct[$p]['psizeid']."' AND schemeStartdate<=CURRENT_DATE and schemeEnddate>=CURRENT_DATE AND (idCustomer='$customerid' OR idCustomerType='$customertype')";
			$resultDiscount=$this->adapter->query($qryDiscount,array());
			$resultsetDiscount=$resultDiscount->toArray();

			//offer message creation

                              
                               //combine discount to product array
                              for ($d=0; $d<count($resultsetDiscount) ; $d++) 
                              { 
                              	
                              		$resultProduct[$p]['disFromdate']=$resultsetDiscount[$d]['schemeStartdate'];
                              		$resultProduct[$p]['disTodate']=$resultsetDiscount[$d]['schemeEnddate'];
                              		if ($resultsetDiscount[$d]['scheme_flat_discount']!=null && $resultsetDiscount[$d]['scheme_flat_discount']!=0) 
                              		{
                                        $resultProduct[$p]['idScheme']=$resultsetDiscount[$d]['idScheme'];
                              			$resultProduct[$p]['discount']=$resultsetDiscount[$d]['scheme_flat_discount'];
                              			$resultProduct[$p]['discountproductQty']=$resultsetDiscount[$d]['scheme_product_qty'];
                              			$resultProduct[$p]['discountType']=$resultsetDiscount[$d]['discount_type'];
                              		}

                              		if ($resultsetDiscount[$d]['free_product_size']!=null && $resultsetDiscount[$d]['free_product_size']!=0) 
                              		{
                              			  $resultProduct[$p]['idScheme']=$resultsetDiscount[$d]['idScheme'];
                              			$resultProduct[$p]['discount']=$resultsetDiscount[$d]['scheme_flat_discount'];
                              			$resultProduct[$p]['discountproductQty']=$resultsetDiscount[$d]['scheme_product_qty'];
                              			$resultProduct[$p]['discountType']=$resultsetDiscount[$d]['discount_type'];
                              			$resultProduct[$p]['free_product_size']=$resultsetDiscount[$d]['free_product_size'];
                              			$resultProduct[$p]['free_product_qty']=$resultsetDiscount[$d]['free_product_qty'];
                              			$resultProduct[$p]['free_product']=$resultsetDiscount[$d]['free_product'];
                              		}

                              	
                              }

                             
							}
							
							if (count($resultProduct)>0) {
								$resultset[$i]['sub_cat'][$m]['product_data']=$resultProduct;
							}
							else
							{
								$resultset[$i]['sub_cat'][$m]['product_data']='';
								$ret_arr=['code'=>'2','status'=>false,'message'=>' Product not avail corresponding territory '];
							}
							
							
						}
					}

				}
			
			}

			if(count($resultsetterritory)>0)
			{
			$ret_arr=['code'=>'1','status'=>true,'message'=>' product records ','content' =>$resultsetterritory,'productdata'=>$resultset,'discountData'=>$resultsetDiscount,'stateunion'=>$resultsetstateUnion];
			}
			else
			{
			$ret_arr=['code'=>'1','status'=>false,'message'=>' no record found '];
			}
        }
		else {
			$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please try again..'];
		}
		return $ret_arr;	
	}

	public function getGSTsplit($param)
	{
		$taxtype=$param->taxtype;
		$qrytaxsplit="SELECT idTaxSplit,cgst,sgst,igst,utgst FROM `tax_split` WHERE taxtype=?";
		$restaxsplit=$this->adapter->query($qrytaxsplit,array($taxtype));
		$resulttaxsplit=$restaxsplit->toArray();

       
		if(count($resulttaxsplit)>0)
			{
			$ret_arr=['code'=>'1','status'=>true,'message'=>' product records ','content' =>$resulttaxsplit];
			}
			else
			{
			$ret_arr=['code'=>'1','status'=>false,'message'=>' no record found '];
			}
;
			return $ret_arr; 
	}

	public function orderentryAdd($param)
	{
     
		$salescode=$param->salescode;
		$customerid=$param->customerid;
		$pono=$param->pono;
		$podate=$param->podate;
		$territory=$param->territory;
		$totalnetpay=($param->totalnetpay)?explode(',',$param->totalnetpay):'';
		$totalpay=($param->totalpay)?explode(',',$param->totalpay):'';
		$discount=($param->discount)?explode(',',$param->discount):'';
		$productprice=($param->productprice)?explode(',',$param->productprice):'';
		
		$overalltotal=$param->overalltotal;
		$cgstAmount=($param->cgstAmount!=0)?explode(',',$param->cgstAmount):0.00;
		$sgstAmount=($param->sgstAmount!=0)?explode(',',$param->sgstAmount):0.00;
		$igstAmount=($param->igstAmount!=0)?explode(',',$param->igstAmount):0.00;
		$utgstAmount=($param->utgstAmount!=0)?explode(',',$param->utgstAmount):0.00;
		$overallCGST=$param->overalltotalCGST;
		$overallSGST=$param->overalltotalSGST;
		$overallIGST=$param->overalltotalIGST;
		$overallUTGST=$param->overalltotalUTGST;
		$overalltax=$param->overalltax;
		$overallgrandtotal=$param->overallgrandtotal;
		$productids=($param->productids)?explode(',',$param->productids):'';
		$productsizeids=($param->productsizeids)?explode(',',$param->productsizeids):'';
		$orderqty=($param->orderqty)?explode(',',$param->orderqty):'';
		
		$offerQTY=($param->offerQty)?explode(',',$param->offerQty):'';
		$offerID=($param->offerID)?explode(',',$param->offerID):'';
		$offerPID=($param->offerPID)?explode(',',$param->offerPID):'';

		$this->adapter->getDriver()->getConnection()->beginTransaction();
				         try 
				          {
							$orderInsert['salesCode']=$salescode;
							$orderInsert['idCustomer']=$customerid;
							$orderInsert['poNumber']=$pono;
							$orderInsert['poDate']=date('Y-m-d',strtotime($podate));
							$orderInsert['idCustthierarchy']=$territory;
							$orderInsert['totalAmount']=round($overalltotal,2);
							$orderInsert['totalCGST']=round($overallCGST,2);
							$orderInsert['totalSGST']=round($overallSGST,2);
							$orderInsert['totalIGST']=round($overallIGST,2);
							$orderInsert['totalUTGST']=round($overallUTGST,2);
							$orderInsert['totalTax']=round($overalltax,2);
							$orderInsert['grandtotalAmount']=round($overallgrandtotal,2);	
							$orderInsert['billingAddress']=$param->billingAddress;				
							$orderInsert['created_by']=$param->userid;
							$orderInsert['created_at']=date('Y-m-d H:i:s');
							$orderInsert['update_by']=$param->userid;
							$orderInsert['updated_at']=date('Y-m-d H:i:s');
							$orderInsert['status']=1;
                         

							$insertorder=new Insert('orders');
							$insertorder->values($orderInsert);
							$statementorder=$this->adapter->createStatement();
							$insertorder->prepareStatement($this->adapter, $statementorder);
							$insertresultorder=$statementorder->execute();
                            $orderid=$this->adapter->getDriver()->getLastGeneratedValue();

                            for ($j=0; $j <count($productids) ; $j++) 
						{ 
							if($orderqty[$j]!='' and $orderqty[$j]!=0 and $orderqty[$j]!=null)
							{
                               $orderitemInsert['idOrder']=$orderid;
							$orderitemInsert['idProduct']=$productids[$j];
							$orderitemInsert['idProductsize']=$productsizeids[$j];
							$orderitemInsert['orderQty']=$orderqty[$j];
							$orderitemInsert['price']=$productprice[$j];
							$orderitemInsert['totalAmount']=$totalpay[$j];
							$orderitemInsert['cgstAmount']=round($cgstAmount[$j],2);
							$orderitemInsert['sgstAmount']=round($sgstAmount[$j],2);
							$orderitemInsert['igstAmount']=round($igstAmount[$j],2);
							$orderitemInsert['utgstAmount']=round($utgstAmount[$j],2);
							$orderitemInsert['cgstPercent']=round($param->cgstPercent,2);
							$orderitemInsert['sgstPercent']=round($param->sgstPercent,2);
							$orderitemInsert['igstPercent']=round($param->igstPercent,2);
							$orderitemInsert['utgstPercent']=round($param->utgstPercent,2);
							$orderitemInsert['discountAmount']=round($discount[$j],2);
							$orderitemInsert['NetAmount']=round($totalnetpay[$j],2);
							$orderitemInsert['idScheme']=($offerID[$j])?$offerID[$j]:0;
							$orderitemInsert['discountQty']=($offerQTY[$j])?$offerQTY[$j]:0;
							$orderitemInsert['discountJoinid']=($offerPID[$j])?$offerPID[$j]:0;
                         
							$insertorderitem=new Insert('order_items');
							$insertorderitem->values($orderitemInsert);
							$statementorderitem=$this->adapter->createStatement();
							$insertorderitem->prepareStatement($this->adapter, $statementorderitem);
							$insertresultorderitem=$statementorderitem->execute();
							}
							
							
							
						  }
                        
							$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
							$this->adapter->getDriver()->getConnection()->commit();
				       } 
				       catch(\Exception $e) 
				       {
						$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
						$this->adapter->getDriver()->getConnection()->rollBack();
				       }

                    
				        
						  
							
						
              
        return $ret_arr;
	}

    public function getOrderlist($param)
    {
    	$id=$param->userid;
    	$usertype=$param->usertype;
    	$condition=($usertype==0)?'':'WHERE ord.created_by='.$id;
         $qryorders="SELECT  ord.idOrder,ord.salesCode,ord.idCustomer,ord.poNumber, DATE_FORMAT(ord.poDate, '%d-%m-%Y') as poDate,ord.totalAmount,ord.grandtotalAmount,c.cs_name,geo1.geoValue as g1,geo2.geoValue as g2,geo3.geoValue as g3,geo4.geoValue as g4,geo5.geoValue as g5,geo6.geoValue as g6,geo7.geoValue as g7,geo8.geoValue as g8,geo9.geoValue as g9,geo10.geoValue as g10 FROM `orders` as ord
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
        	LEFT JOIN geography as geo10 on geo10.idGeography=c.G10 $condition";
        	$resultorders=$this->adapter->query($qryorders,array());
			$resultsetorders=$resultorders->toArray();
			
			if(count($resultsetorders)>0)
			{
              $ret_arr=['code'=>'2','status'=>true,'content' =>$resultsetorders,'message'=>'records available'];
			}
			else
			{
				$ret_arr=['code'=>'1','status'=>false,'message'=>'no records..'];
			}
			return $ret_arr;
    }

    public function getOrderlistview($param)
    {
        $orderid=$param->order_id;
        $qryCompany="SELECT companyName as name,companyLandline as mobile,companyWebsite as website,companyAddress,companyLogo FROM sys_config";
			$resultCompany=$this->adapter->query($qryCompany,array());
			$resultsetCompany=$resultCompany->toArray();
			// $url="public/uploads/logo/".$resultsetCompany[0]['companyLogo'];
			// $cmpnylogoB64=base64_encode($url);
			

			$path = "public/uploads/logo/".$resultsetCompany[0]['companyLogo'].'';
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data11 = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data11);
            $resultsetCompany[0]['cmpnylogoB64']=$base64;

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
					pp.primarypackname,
					prd.idProduct 
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
              $ret_arr=['code'=>'2','status'=>true,'content' =>$resss,'message'=>'records available'];
			}
			else
			{
				$ret_arr=['code'=>'1','status'=>false,'message'=>'no records..'];
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
		$fields=$param->FORM;
		$idFullfil=$fields['fullfillmentid'];
		$Orderid=$fields['orderids'];
		
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

public function SerialPicklist($param)
	{
        if($param->action=="list")
        {
        	$proid=$param->proid;
        	$sizeid=$param->sizeid;
        	$whitem=$param->whitem;
        	$qty=$param->qty;
        	$batchno=$param->batchno;
            $userData=$param->userData;

			$qryPrimaryQty="SELECT ps.productPrimaryCount,pp.primarypackname FROM `product_size` as ps LEFT JOIN primary_packaging as pp on pp.idPrimaryPackaging=ps.idPrimaryPackaging WHERE ps.idProduct='$proid' AND ps.idProductsize='$sizeid'";
			$resultPrimaryQty=$this->adapter->query($qryPrimaryQty,array());
			$resultsetPrimaryQty=$resultPrimaryQty->toArray();
			$ppname=$resultsetPrimaryQty[0]['primarypackname'];
			$ppcount=$resultsetPrimaryQty[0]['productPrimaryCount'];	

               $totalQty=$ppcount*$qty;
               //admin or company login get serial number pick (EX:COmpany to SMS)
				if ($userData['user_type']==0 AND $userData['idCustomer']==0) 
				{				
        	$qryorders="SELECT idProductserialno,serialno FROM `product_stock_serialno` WHERE idWhStock in(SELECT idWhStock FROM whouse_stock_items WHERE idWhStockItem='$whitem') AND idProduct='$proid' AND idProductsize='$sizeid' AND status=2";  
        	$resultorders=$this->adapter->query($qryorders,array());
			$resultsetorders=$resultorders->toArray();      
				}
				else
				{
					//customer level get pick serial number(EX:SMS to MS)
					//get all serialno
					$qrySLALL="SELECT idProductserialno,serialno FROM `product_stock_serialno` WHERE idWhStock in(SELECT idWhStock FROM whouse_stock_items WHERE idWhStockItem='$whitem') AND idProduct='$proid' AND idProductsize='$sizeid' AND status=2";  
        	$resultSLALL=$this->adapter->query($qrySLALL,array());
			$resultsetSLALL=$resultSLALL->toArray();
					//get order ids
				$qryidORders="SELECT idOrder FROM orders WHERE poNumber in(SELECT po_no from whouse_stock WHERE idWhStock in(SELECT idWhStock FROM whouse_stock_items WHERE idWhStockItem='$whitem'))";
				$resultidORders=$this->adapter->query($qryidORders,array());
				$resultsetidORders=$resultidORders->toArray();
				$idorders=$resultsetidORders[0]['idOrder'];
				//get serialno ids
				$qrySLids="SELECT idSerialno from order_picklist_items WHERE idWhStockItem in(SELECT idWhStockItem FROM `whouse_stock_items` WHERE sku_batch_no='$batchno' AND idWhStock in (SELECT idWhStock FROM product_stock_serialno WHERE idOrder='$idorders')) AND idOrder='$idorders' AND idProduct='$proid' AND idProdSize='$sizeid'";
				$resultSLids=$this->adapter->query($qrySLids,array());
				$resultsetSLids=$resultSLids->toArray();
				$idslnos=($resultsetSLids[0]['idSerialno'])?explode('|',$resultsetSLids[0]['idSerialno']):'';
               for ($i=0; $i < count($idslnos); $i++) 
               { 
               	 //already recieved from Company to SMS or MS or DS SLNO
				$qrycmpny="SELECT idProductserialno,serialno FROM `product_stock_serialno` WHERE idProductserialno='".$idslnos[$i]."'"; 
				$resultcmpny=$this->adapter->query($qrycmpny,array());
				$resultsetcmpny=$resultcmpny->toArray(); 

			     $slnos[]=$resultsetcmpny[0];
               }
               for ($i=0; $i <count($resultsetSLALL); $i++) 
               { 
               	 for ($j=0; $j < count($slnos); $j++) 
               	 { 
               	 	if ($resultsetSLALL[$i]['serialno']==$slnos[$j]['serialno']) 
               	 	{
               	 		$resultsetorders[]=$resultsetSLALL[$i];
               	 	}
               	 }
               }
				 
               
				}
        	
			
			for ($i=0; $i < count($resultsetorders); $i++) 
			{
				$resultsetorders[$i]['status']=false;

				
			}
			for ($i=0; $i < $totalQty; $i++) 
			{
				if (count($resultsetorders)>$i) 
                {
					$resultsetorders[$i]['status']=true;
				}
			}
           
			if(count($resultsetorders)>0)
			{
              $ret_arr=['code'=>'2','status'=>true,'content' =>$resultsetorders,'totalQty'=>$totalQty,'message'=>'records available'];
			}
			else
			{
				$ret_arr=['code'=>'1','status'=>false,'message'=>'no records..'];
			}
        }
        return $ret_arr;	
    }

	public function orderDistribution($param)
	{
        if($param->action=="list")
        {
        	$qryorders="SELECT  ord.idOrder,ord.salesCode,ord.idCustomer,ord.poNumber,DATE_FORMAT(ord.poDate, '%d-%m-%Y') as poDate,ord.totalAmount,ord.grandtotalAmount,c.cs_name,geo1.geoValue as g1,geo2.geoValue as g2,geo3.geoValue as g3,geo4.geoValue as g4,geo5.geoValue as g5,geo6.geoValue as g6,geo7.geoValue as g7,geo8.geoValue as g8,geo9.geoValue as g9,geo10.geoValue as g10 FROM `orders` as ord
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
        	LEFT JOIN geography as geo10 on geo10.idGeography=c.G10 WHERE idOrderfullfillment=0 AND order_cancel=0";
        	$resultorders=$this->adapter->query($qryorders,array());
			$resultsetorders=$resultorders->toArray();

			if(count($resultsetorders)>0)
			{
              $ret_arr=['code'=>'2','status'=>true,'content' =>$resultsetorders,'message'=>'records available'];
			}
			else
			{
				$ret_arr=['code'=>'1','status'=>false,'message'=>'no records..'];
			}
        }
        else if($param->action=="editview")
        {
            $orderid=$param->order_id;
            $qryeditvieworders="SELECT  ord.idOrder,ord.salesCode,ord.idCustomer,ord.poNumber,DATE_FORMAT(ord.poDate, '%d-%m-%Y') as poDate,ord.totalAmount AS TotAmt,ord.grandtotalAmount AS grandTot, ord.totalTax  AS TotTax ,c.cs_name,geo1.geoValue as g1,geo2.geoValue as g2,geo3.geoValue as g3,geo4.geoValue as g4,geo5.geoValue as g5,geo6.geoValue as g6,geo7.geoValue as g7,geo8.geoValue as g8,geo9.geoValue as g9,geo10.geoValue as g10,orditem.idProduct,orditem.idProductsize,orditem.orderQty,orditem.totalAmount,orditem.discountAmount,orditem.NetAmount,prd.productName,psize.productSize, psize.productPrimaryCount, prd.productCount, orditem.orderQty, orditem.totalAmount
            ,pp.primarypackname ,pf.priceAmount,orditem.discountAmount ,orditem.idScheme,
            orditem.discountQty,orditem.price,
            orditem.discountJoinid,(IF(orditem.discountQty>0,'1','0')) as discountStatus,'1' as offer_flog
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
			foreach ($resultseteditvieworders as $key => $value) 
{
$resss[]=$value;
}
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
					prd.productName, 
					psize.productSize, 
					psize.productPrimaryCount, 
					psize.idProductsize,
					prd.productCount,
					prd.idProduct,'2' as offer_flog 
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
              $ret_arr=['code'=>'2','status'=>true,'content' =>$resss,'message'=>'records available'];
			}
			else
			{
				$ret_arr=['code'=>'1','status'=>false,'message'=>'no records..'];
			}

        }

		return $ret_arr;	
	}

	public function getorderProcessing($param)
	{

		if($param->action=="list")
		{
           $qryorderprocess="SELECT ord.idOrder,
ord.poNumber,
ord.poDate,
ord.grandtotalAmount,
c.cs_name,
c.idCustomer,
c.cs_segment_type,
c.cs_stock_payment_type,
c.cs_credit_ratingstatus,
c.cs_credit_types,
st.segmentName,
cs_payment_type,
0 as postdues,
fm.fulfillmentName,
0 as status 
FROM `orders` as ord LEFT JOIN customer as c on c.idCustomer=ord.idCustomer 
LEFT JOIN fulfillment_master as fm on fm.idFulfillment=ord.idOrderfullfillment 
LEFT JOIN segment_type as st on st.idsegmentType=c.cs_segment_type 
WHERE ord.idOrderfullfillment!=0 AND ord.order_cancel=0";
		$resorderprocess=$this->adapter->query($qryorderprocess,array());
		$resultorderprocess=$resorderprocess->toArray();
       for ($i=0; $i < count($resultorderprocess); $i++) 
       { 
       	$TotalOrderQty=0;
       	$TotalAllocateQty=0;
			$qryorderStatus="SELECT  idOrder,status FROM orders_allocated WHERE idOrder=?";
			$resorderStatus=$this->adapter->query($qryorderStatus,array($resultorderprocess[$i]['idOrder']));
			$resultorderStatus=$resorderStatus->toArray();
			$resultorderprocess[$i]['status']=$resultorderStatus[0]['status'];
             //total order qty for each order
             $qryTotalOrderQty="SELECT sum(ordi.orderQty) as totalOrderQty FROM `orders` as ord LEFT JOIN order_items as ordi ON ord.idOrder=ordi.idOrder WHERE ord.idOrder=?";
			$resTotalOrderQty=$this->adapter->query($qryTotalOrderQty,array($resultorderprocess[$i]['idOrder']));
			$resultTotalOrderQty=$resTotalOrderQty->toArray();
			$TotalOrderQty=$resultTotalOrderQty[0]['totalOrderQty'];
             //total allocate qty for each order
			$qryTotalAllocateQty="SELECT sum(picklistQty) as totalAllocateQty FROM `orders_allocated` as orda LEFT JOIN orders_allocated_items as ordai ON orda.idOrderallocate=ordai.idOrderallocated WHERE orda.idOrder=?";
			$resTotalAllocateQty=$this->adapter->query($qryTotalAllocateQty,array($resultorderprocess[$i]['idOrder']));
			$resultTotalAllocateQty=$resTotalAllocateQty->toArray();
			$TotalAllocateQty=$resultTotalAllocateQty[0]['totalAllocateQty'];
			//set the allocation status 
             if ($TotalOrderQty==$TotalAllocateQty) {
             	$resultorderprocess[$i]['allocateStatus']=1;
             }else{ $resultorderprocess[$i]['allocateStatus']=0; }

            $qryCurrentbalance="SELECT sum(invcds.invoiceAmt) as total_invoiceAmt,sum(ip.payAmt-ip.paidAmount) as total_paidAmt,invcds.invoiceDate FROM `invoice_details` as invcds LEFT JOIN invoice_payment as ip ON ip.idCustomer=invcds.idCustomer WHERE invcds.idCustomer='".$resultorderprocess[$i]['idCustomer']."'";
		$resCurrentbalance=$this->adapter->query($qryCurrentbalance,array());
		$resultCurrentbalance=$resCurrentbalance->toArray();
          //current account balance for customer
		 $qryOnaccountbalance="SELECT sum(ip.payAmt-ip.paidAmount) as totalOnaccount FROM  invoice_payment as ip   WHERE ip.idCustomer='".$resultorderprocess[$i]['idCustomer']."' AND ip.payType='On Account'";
		$resOnaccountbalance=$this->adapter->query($qryOnaccountbalance,array());
		$resultOnaccountbalance=$resOnaccountbalance->toArray();

         $accountAmt=$resultOnaccountbalance[0]['totalOnaccount'];
         $cs_stock_payment_type=$resultorderprocess[$i]['cs_stock_payment_type'];
         $totalOrderAmt=$resultorderprocess[$i]['grandtotalAmount'];
         $stocktransferStatus=0;
         $creditRating=$resultorderprocess[$i]['cs_credit_ratingstatus'];
         $creditTypes=$resultorderprocess[$i]['cs_credit_types'];

         $total_invoiceAmt=($resultCurrentbalance[0]['total_invoiceAmt']!=null)?$resultCurrentbalance[0]['total_invoiceAmt']:0;
		$total_paidAmt=($resultCurrentbalance[0]['total_paidAmt']!=null)?$resultCurrentbalance[0]['total_paidAmt']:0;
         //past due amount
		$currentBalance=$total_invoiceAmt-$total_paidAmt;

         //stock transfer rule 1.Stock Transfer on Full advance Payment
         if ($cs_stock_payment_type==1) 
         {
         	if ($totalOrderAmt<=$accountAmt) 
         	{
         		$stocktransferStatus=1; //allow to transfer stock
         		$stocktransferMSG="Success";
         	}
         	else
         	{
         		$stocktransferStatus=2;
         		$stocktransferMSG="Full advance payment ₹.".$totalOrderAmt." not paid";
         	}
         }//stock transfer rule 1.Stock transfer on part advance payment
         else if($cs_stock_payment_type==2)
         {
            $partOrderAmt=$totalOrderAmt/2;
            if ($partOrderAmt<=$accountAmt) 
         	{
         		$stocktransferStatus=1; //allow to transfer stock
         		$stocktransferMSG="Success";
         	}
         	else
         	{
         		$stocktransferStatus=3; // not allow to transfer stock
         		$stocktransferMSG="Part advance payment ₹.".$partOrderAmt." not paid";
         	}

         }
         else if($cs_stock_payment_type==3 AND $currentBalance>0)
         {
             
			$qryCreditrate=" SELECT idCreditRating,creditType,days,amount FROM `creditrating` WHERE `creditType`='".$creditRating."'";
			$resCreditrate=$this->adapter->query($qryCreditrate,array());
			$resultCreditrate=$resCreditrate->toArray();
			$creditDays=$resultCreditrate[0]['days'];
			$creditAmount=$resultCreditrate[0]['amount'];
            //amounts
             if ($creditTypes==1) 
             {
             	//due amount less then credit amount
                if ($creditAmount>$currentBalance) 
                {
                 	$stocktransferStatus=1; //allow to transfer stock
                 	$stocktransferMSG="Success";

                }
                else
                {
                	$stocktransferStatus=4; //not allow to transfer stock
                	$stocktransferMSG="Credit amount ₹.".$creditAmount." not paid.Your due amount ₹. ".$currentBalance." also pending";
                } 	
             } //days
             else if($creditTypes==2)
             {
                $todayDate=date('d-m-Y');
                //previous order dispatch date
                
                $c=' + '.$creditDays.' days';
  
                $lastDispatchDate=date('d-m-Y',strtotime($resultCurrentbalance[0]['invoiceDate']. $c));
              
                if ($lastDispatchDate>=$todayDate) 
                {
                	$stocktransferStatus=5; // not allow to transfer stock
                	$stocktransferMSG="Credit days exceed.Pay due amount ₹.".$currentBalance;
                }
                else
                {
                	 $stocktransferStatus=1; // allow to transfer stock
                	 $stocktransferMSG="Success";
                }
             }


         }
         else
         {
         	$stocktransferStatus=1; // allow to transfer stock
         	$stocktransferMSG="Success";
         }

		
			
			 $resultorderprocess[$i]['postdues']=$currentBalance;
			 $resultorderprocess[$i]['stocktransforRule']=$stocktransferStatus;
			 $resultorderprocess[$i]['stocktransforMSG']=$stocktransferMSG;

       }
		

		if(count($resultorderprocess)>0)
		{
           $ret_arr=['code'=>'2','status'=>true,'content' =>$resultorderprocess,'message'=>'records available'];
		}
		else
		{
			$ret_arr=['code'=>'1','status'=>false,'message'=>'no records..'];
		}  
		}
		return $ret_arr;
		

	}

public function orderprodcessView($param)
{
            $orderid=$param->orderid;
            //order data with customer detail
            $qryeditvieworders="SELECT  ord.idOrder,
            ord.salesCode,
            ord.idCustomer,
            ord.poNumber,
            DATE_FORMAT(ord.poDate, '%d-%m-%Y') as poDate,
            ord.totalAmount AS TotAmt,
            ord.grandtotalAmount AS grandTot,
             ord.totalTax  AS TotTax ,
             c.cs_name,
             geo1.geoValue as g1,
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
             orditem.price,
             orditem.totalAmount,
             orditem.discountAmount,
             orditem.NetAmount,
             prd.productName,
             psize.productSize,
             psize.productPrimaryCount, 
             prd.productCount, 
             orditem.orderQty, 
             orditem.totalAmount,
             pp.primarypackname ,
            pf.priceAmount,
            orditem.discountAmount,
            orditem.idScheme,
            orditem.discountQty,
            orditem.discountJoinid,
            0 as allocatestatus,
            0 as whdata,
            1 as status,
            (IF( orditem.discountQty>0,'1','0')) as discountStatus,'0' as offer_flog
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

			foreach ($resultseteditvieworders as $key => $value) 
{
$resss[]=$value;
}  

//offer free product
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
					prd.productName, 
					psize.productSize, 
					psize.productPrimaryCount, 
					psize.idProductsize,
					prd.productCount,
					prd.idProduct,
					 0 as allocatestatus,
                     0 as whdata ,
                     0 as status,'2' as offer_flog
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
            //order allocated data
            $qryeditviewWH="SELECT a.idOrderallocate, a.idOrder,a.status,a.reallocate,a.rplc_misg_status,b.idProduct,b.idProductsize,a.idWarehouse,b.picklistQty FROM `orders_allocated` as a 
LEFT JOIN orders_allocated_items as b on a.idOrderallocate=b.idOrderallocated
WHERE a.idOrder=?";
			 $resulteditviewWH=$this->adapter->query($qryeditviewWH,array($orderid));
			$resultseteditviewWH=$resulteditviewWH->toArray();
            

		$qrywarehouse="SELECT wh.idWarehouse ,wh.warehouseName from orders_allocated as ord LEFT JOIN warehouse_master as wh on wh.idWarehouse=ord.idWarehouse where idOrder='$orderid'";
		$reswarehouse=$this->adapter->query($qrywarehouse,array());
		$resultwarehouse=$reswarehouse->toArray();
//warehouse allocate qty
for ($i=0; $i <count($resss) ; $i++) 
{ 
		$idproduct=$resss[$i]['idProduct'];
		$idproductsize=$resss[$i]['idProductsize'];
		$qryWH="SELECT a.idOrderallocate, a.idOrder,a.status,a.reallocate,a.rplc_misg_status,b.idProduct,b.idProductsize,a.idWarehouse,b.picklistQty FROM `orders_allocated` as a 
		LEFT JOIN orders_allocated_items as b on a.idOrderallocate=b.idOrderallocated
		WHERE a.idOrder='$orderid' and b.idProduct='$idproduct' and b.idProductsize='$idproductsize'";
		$resultWH=$this->adapter->query($qryWH,array());
		$resultsetWH=$resultWH->toArray();
		$resss[$i]['whdata']=$resultsetWH;

}


			
			if(count($resss)>0)
			{
              $ret_arr=['code'=>'2','status'=>true,'content' =>$resss,'warehousedata'=>$resultwarehouse,'orderallocatedata'=>$resultseteditviewWH,'message'=>'records available'];
			}
			else
			{
				$ret_arr=['code'=>'1','status'=>false,'message'=>'no records..'];
			}
			return $ret_arr;
}
	public function order_allocation($param)
	{
		$orderid=$param->orderid;
       $qryorderlist="SELECT  ord.idOrder,
ord.salesCode,
ord.idCustomer,
ord.poNumber,
0 as dispatchQty,
ord.poDate,
ord.totalAmount AS TotAmt,
ord.grandtotalAmount AS grandTot,
'0' as current_balance, 
ord.totalTax  AS TotTax ,
c.cs_name as name,
orditem.idProduct,
orditem.idProductsize,
orditem.orderQty,
orditem.orderQty as approvQty,
'0' as rejectQty,
orditem.totalAmount,
orditem.discountAmount,
orditem.NetAmount,
prd.productName,
prd.expireDate,
psize.productSize, 
psize.productPrimaryCount, 
prd.productCount, 
orditem.orderQty, 
orditem.totalAmount,
pp.primarypackname ,
pf.priceAmount,
orditem.discountAmount,
orditem.idScheme,
orditem.discountQty,
orditem.discountJoinid,'1' as offer_flog,(IF(orditem.discountQty>0,'1','0')) as discountStatus
            FROM `orders` as ord
            LEFT JOIN order_items as orditem on orditem.idOrder=ord.idOrder
            LEFT JOIN product_details as prd on prd.idProduct=orditem.idProduct
            LEFT JOIN product_size as psize on psize.idProductsize=orditem.idProductsize
            LEFT JOIN primary_packaging as pp on pp.idPrimaryPackaging=psize.idPrimaryPackaging
            LEFT JOIN price_fixing as pf on pf.idProductsize=psize.idProductsize
            LEFT JOIN customer as c on c.idCustomer=ord.idCustomer
           WHERE ord.idOrder='$orderid' GROUP BY psize.idProductsize";
		$resorderlist=$this->adapter->query($qryorderlist,array());
		$resultorderlist=$resorderlist->toArray();
$idOrder=$resultorderlist[0]['idOrder'];
		foreach ($resultorderlist as $key => $value) 
		{
			//already allocated qty for each product in that order (ordered product)
			
			$qryAlreadyAllocateQty="SELECT sum(ordai.picklistQty) as picklistQty FROM `orders_allocated` as orda LEFT JOIN orders_allocated_items as ordai ON ordai.idOrderallocated=orda.idOrderallocate WHERE orda.idOrder='".$value['idOrder']."' AND ordai.idProduct='".$value['idProduct']."' AND ordai.idProductsize='".$value['idProductsize']."' AND ordai.idScheme=0 AND ordai.offer_flog=1";
			$resAlreadyAllocateQty=$this->adapter->query($qryAlreadyAllocateQty,array());
			$resultAlreadyAllocateQty=$resAlreadyAllocateQty->toArray();

            $dispatchQty=(is_numeric($resultAlreadyAllocateQty[0]['picklistQty']))?$resultAlreadyAllocateQty[0]['picklistQty']:0;
            $approveQty=$value['orderQty']-$dispatchQty; //aprove qty sub of order qty and already allocate qty(dispatch qty)

			$resultorderlist[$key]['dispatchQty']=$dispatchQty;
			$resultorderlist[$key]['approvQty']=$approveQty;
		
		}  
     //ordered product push into the ress array
	foreach ($resultorderlist as $key => $value) 
	{
	  $resss[]=$value;
	}

//offer free product
			for ($i=0; $i <count($resultorderlist) ; $i++) 
			{ 
				
				if ($resultorderlist[$i]['discountQty']>0) 
				{
					$schemeid=$resultorderlist[$i]['idScheme'];
					$freeQty=$resultorderlist[$i]['discountQty'];
					$qry="SELECT 
					'0' as idOrder,
					'0' as salesCode,
					'0' as idCustomer,
					'0' as poNumber,
					 0 as dispatchQty,
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
					'0' as idScheme,
					'$freeQty' as discountQty,
					'0' as discountJoinid,
					prd.productName, 
					prd.expireDate,
					psize.productSize, 
					psize.productPrimaryCount, 
					psize.idProductsize,
					prd.productCount,
					prd.idProduct,
					 0 as allocatestatus,
                     0 as whdata ,
                     0 as status,
                     '0' as current_balance,
                     '$freeQty' as approvQty,
                     '0' as rejectQty,
                     '2' as offer_flog
					FROM product_details as prd 
					LEFT JOIN product_size as psize on psize.idProduct=prd.idProduct 
					LEFT JOIN primary_packaging as pp on pp.idPrimaryPackaging=psize.idPrimaryPackaging 
					WHERE prd.idProduct in(SELECT free_product as idProduct FROM `scheme` WHERE idScheme='$schemeid') AND psize.idProductsize in(SELECT free_product_size as idProductsize FROM `scheme` WHERE idScheme='$schemeid')";
					$result=$this->adapter->query($qry,array());
					$resultset=$result->toArray();
					$free_products[]=$resultset[0];

					foreach ($resultset as $key => $value) 
					{
						//already allocated qty for each product in that order (free product)
			
			$qryAlreadyAllocateQtyFree="SELECT sum(ordai.picklistQty) as picklistQty FROM `orders_allocated` as orda LEFT JOIN orders_allocated_items as ordai ON ordai.idOrderallocated=orda.idOrderallocate WHERE orda.idOrder='".$idOrder."' AND ordai.idProduct='".$value['idProduct']."' AND ordai.idProductsize='".$value['idProductsize']."' AND ordai.idScheme='".$schemeid."' AND ordai.offer_flog=2";
			$resAlreadyAllocateQtyFree=$this->adapter->query($qryAlreadyAllocateQtyFree,array());
			$resultAlreadyAllocateQtyFree=$resAlreadyAllocateQtyFree->toArray();
			$resultset[$key]['dispatchQty']=(is_numeric($resultAlreadyAllocateQtyFree[0]['picklistQty']))?$resultAlreadyAllocateQtyFree[0]['picklistQty']:0;

			 $dispatchQty=(is_numeric($resultAlreadyAllocateQtyFree[0]['picklistQty']))?$resultAlreadyAllocateQtyFree[0]['picklistQty']:0;
            $approveQty=$value['orderQty']-$dispatchQty; //aprove qty sub of order qty and already allocate qty(dispatch qty)

			$resultorderlist[$key]['dispatchQty']=$dispatchQty;
			$resultorderlist[$key]['approvQty']=$approveQty;
				
						
					}
					//push the free product into the ress array
						foreach ($resultset as $key => $value) 
					{
						$resss[]=$value;
					}
				}
			}

		$qrywarehouseid="SELECT warehouse_ids from customer_allocation where customer_id in(SELECT ord.idCustomer FROM `orders` as ord WHERE ord.idOrder='$orderid')";
		$reswarehouseid=$this->adapter->query($qrywarehouseid,array());
		$resultwarehouseid=$reswarehouseid->toArray();

       $warehouseid=unserialize($resultwarehouseid[0]['warehouse_ids']);
       $warehouseid_final=($warehouseid)?implode(',', $warehouseid):'';

		$qrywarehouse="SELECT idWarehouse,warehouseName,CONCAT('whid', idWarehouse) as whidnm ,'0' as ttlpick FROM `warehouse_master` where idWarehouse in($warehouseid_final)";
		$reswarehouse=$this->adapter->query($qrywarehouse,array());
		$resultwarehouse=$reswarehouse->toArray();


		for ($i=0; $i < count($resss); $i++) 
		{ 
			for ($j=0; $j < count($resultwarehouse); $j++) 
			{ 
				$whname='wh'.$resultwarehouse[$j]['idWarehouse'];
				$whid='whid'.$resultwarehouse[$j]['idWarehouse'];
				$resss[$i][$whname]=0;
				$resss[$i][$whid]=$resultwarehouse[$j]['idWarehouse'];
			}

		}

		$qryallStock="SELECT a.idFactoryOrder, a.idWarehouse, a.idFactory, b.idProduct,b.idProdSize,b.idFactryOrdItem,b.idFactoryOrder,b.idProduct,b.idProdSize,b.item_qty,0 as picklist FROM `factory_order` as a LEFT JOIN factory_order_items as b on b.idFactoryOrder=a.idFactoryOrder WHERE a.idWarehouse in($warehouseid_final)";

		$resallStock=$this->adapter->query($qryallStock,array());
		$resultallStock=$resallStock->toArray();


		for ($i=0; $i < count($resss); $i++) 
		{ 
			$idproduct=$resss[$i]['idProduct'];
			$idproductsize=$resss[$i]['idProductsize'];
			$expireDate=$resss[$i]['expireDate'];
			if($idproduct!='')
			{
				

                 foreach ($warehouseid as $key => $value) {
                 	if($expireDate==1)
                 	{
                       $qryproductStock="SELECT sum(b.sku_accept_qty) as Stockqty,0 as picklist FROM `whouse_stock` as a LEFT JOIN whouse_stock_items as b on b.idWhStock=a.idWhStock WHERE a.idWarehouse='$value' and b.idProduct='$idproduct' and b.idProdSize='$idproductsize' and b.sku_expiry_date>=now()";
                 	}
                 	else
                 	{
                      $qryproductStock="SELECT sum(b.sku_accept_qty) as Stockqty,0 as picklist FROM `whouse_stock` as a LEFT JOIN whouse_stock_items as b on b.idWhStock=a.idWhStock WHERE a.idWarehouse='$value' and b.idProduct='$idproduct' and b.idProdSize='$idproductsize'";
                 	}
                 	
				$resproductStock=$this->adapter->query($qryproductStock,array());
				$resultproductStock=$resproductStock->toArray();
                 $ttlstockQty=($resultproductStock[0]['Stockqty']=='' || $resultproductStock[0]['Stockqty']==null)?0:$resultproductStock[0]['Stockqty'];
				 //get damage qty
					$qryWHdamage="SELECT SUM(WSD.dmg_prod_qty) AS whDamageQty FROM whouse_stock_damge AS WSD WHERE WSD.idProduct='".$idproduct."' AND WSD.idProdSize='".$idproductsize."' AND WSD.idWarehouse='$value'";
					$resultWHdamage=$this->adapter->query($qryWHdamage,array());
					$resultsetWHdamage=$resultWHdamage->toArray();
                    $ttldamageQty=($resultsetWHdamage[0]['whDamageQty']=='' || $resultsetWHdamage[0]['whDamageQty']==null)?0:$resultsetWHdamage[0]['whDamageQty'];
                      //get return qty
					$qryWHreturn="SELECT SUM(COR.rtnQty) AS custRtnQty FROM customer_order_return AS COR LEFT JOIN dispatch_product_batch AS DPB ON COR.idDispatchProductBatch=DPB.idDispatchProductBatch LEFT JOIN whouse_stock_items AS WST ON WST.idWhStockItem=DPB.idWhStockItem WHERE WST.idProduct='".$idproduct."' AND WST.idProdSize='".$resultProduct[$p]['psizeid']."' AND WST.idWarehouse='$value'";
					$resultWHreturn=$this->adapter->query($qryWHreturn,array());
					$resultsetWHreturn=$resultWHreturn->toArray();

					  $ttlreturnQty=($resultsetWHreturn[0]['custRtnQty']=='')?0:$resultsetWHreturn[0]['custRtnQty'];
                     //order allocate qty
					$qryWHorder="SELECT SUM(WOI.picklistQty) AS whOrderQty FROM orders_allocated AS WO LEFT JOIN orders_allocated_items AS WOI ON WOI.idOrderallocated=WO.idOrderallocate WHERE WOI.idProduct='".$idproduct."' AND WOI.idProductsize='".$idproductsize."' AND WO.idWarehouse='$value'";
					$resultWHorder=$this->adapter->query($qryWHorder,array());
					$resultsetWHorder=$resultWHorder->toArray();

					  $ttlorderQty=($resultsetWHorder[0]['whOrderQty']=='' || $resultsetWHorder[0]['whOrderQty']==null)?0:$resultsetWHorder[0]['whOrderQty'];
                       //available total stockqty
						$avlStockQtyVal=(($ttlstockQty+$ttlreturnQty) - ($ttldamageQty+$ttlorderQty));
	                    //$tot_stock=number_format( $avlStockQtyVal,2,'.','');

				$resss[$i]['stock1'][$value]=$avlStockQtyVal;
				$resss[$i]['picklist'][$value]=$resultproductStock[0]['picklist'];

				
                 }
				
               
			}

			

		}
          //currenct due amount
		$qryCurrentbalance="SELECT sum(invcds.invoiceAmt) as total_invoiceAmt,sum(ip.payAmt) as total_paidAmt FROM `invoice_details` as invcds LEFT JOIN invoice_payment as ip ON ip.idCustomer=invcds.idCustomer WHERE invcds.idCustomer in(SELECT idCustomer FROM orders WHERE idOrder='$orderid')";
		$resCurrentbalance=$this->adapter->query($qryCurrentbalance,array());
		$resultCurrentbalance=$resCurrentbalance->toArray();
		$total_invoiceAmt=($resultCurrentbalance[0]['total_invoiceAmt']!=null)?$resultCurrentbalance[0]['total_invoiceAmt']:0;
		$total_paidAmt=($resultCurrentbalance[0]['total_paidAmt']!=null)?$resultCurrentbalance[0]['total_paidAmt']:0;
		$currentBalance=$total_invoiceAmt-$total_paidAmt;



		if(count($resultorderlist)>0)
		{
           $ret_arr=['code'=>'2','status'=>true,'content' =>$resss,'currentBalance'=>$currentBalance,'warehouse'=>$resultwarehouse,'warehouseStock'=>$resultallStock,'message'=>'records available'];
		}
		else
		{
			$ret_arr=['code'=>'1','status'=>false,'message'=>'no records..'];
		}  
		
		return $ret_arr;
	}

	public function order_allocated($param)
	{
      
      $data=$param->datass;

      $orderid=$param->datass[0]['idOrder'];
      $whid=$param->warehouseids;
   
			$this->adapter->getDriver()->getConnection()->beginTransaction();
			try 
			{
				$k=0;
              
                for ($i=0; $i <count($whid) ; $i++) 
                { 
                	if ($whid[$i]['ttlpick']!=0) 
                	{

						$orderallocateInsert['idOrder']=$orderid;	
						$orderallocateInsert['idWarehouse']=$whid[$i]['idWarehouse'];
						$orderallocateInsert['created_by']=$param->userid;
						$orderallocateInsert['created_at']=date('Y-m-d H:i:s');						
                 
						$insertorder=new Insert('orders_allocated');
						$insertorder->values($orderallocateInsert);
						$statementorder=$this->adapter->createStatement();
						$insertorder->prepareStatement($this->adapter, $statementorder);
						$insertresultorder=$statementorder->execute();
						// $orderallocatedid[]=$this->adapter->getDriver()->getLastGeneratedValue();
						$orderallocatedid[$k]['allocateid']=$this->adapter->getDriver()->getLastGeneratedValue();
						$orderallocatedid[$k]['idWarehouse']=$whid[$i]['idWarehouse'];
                	}
				
                	
                }

				$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
				$this->adapter->getDriver()->getConnection()->commit();
			} 
			catch(\Exception $e) 
			{
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
				$this->adapter->getDriver()->getConnection()->rollBack();
			}

			$this->adapter->getDriver()->getConnection()->beginTransaction();
			try 
			{
				
				
                for ($i=0; $i < count($data); $i++) 
                { 
                	
					for ($j=0; $j < count($orderallocatedid); $j++) 
					{ 
						$whids=$orderallocatedid[$j]['idWarehouse'];
						
						if ($data[$i]['picklist'][$whids]!='' && $data[$i]['picklist'][$whids]!=0) 
						{
                            
						 $orderallocateitemInsert['idOrderallocated']=$orderallocatedid[$j]['allocateid'];
						$orderallocateitemInsert['idProduct']=$data[$i]['idProduct'];	
						$orderallocateitemInsert['idProductsize']=$data[$i]['idProductsize'];
						$orderallocateitemInsert['idScheme']=$data[$i]['idScheme'];	
	                    $orderallocateitemInsert['offer_flog']=$data[$i]['offer_flog'];	
						$orderallocateitemInsert['approveQty']=($data[$i]['approvQty']!='')?$data[$i]['approvQty']:0;
						$orderallocateitemInsert['picklistQty']=$data[$i]['picklist'][$whids];
						$orderallocateitemInsert['rejectQty']=($data[$i]['rejectQty']!='')?$data[$i]['rejectQty']:0; 
                          
						$insertallocateitem=new Insert('orders_allocated_items');
						$insertallocateitem->values($orderallocateitemInsert);
						$statementorderallocateitem=$this->adapter->createStatement();
						$insertallocateitem->prepareStatement($this->adapter, $statementorderallocateitem);
						$insertresultorderallocate=$statementorderallocateitem->execute();	
						
                           }
                           
						
						
						
					}
                }
				
			
				$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
				$this->adapter->getDriver()->getConnection()->commit();
			} 
			catch(\Exception $e) 
			{
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
				$this->adapter->getDriver()->getConnection()->rollBack();
			}
      return $ret_arr;
	}


	function orderproductstatus($param){
		if($param->action=='statuslist'){
			$qry="SELECT fm.factoryName as factoryName,fo.idFactory as idFactory,fo.po_number as POnumber,DATE_FORMAT(fo.po_date,'%d-%m-%Y') as POdate,0 as totalQty,0 as status, 0 as matQty
				 FROM factory_order as fo 
				 LEFT JOIN factory_master as fm ON fm.idFactory=fo.idFactory
				 GROUP BY fo.idFactory,fo.po_number,fo.po_date";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
           for ($i=0; $i <count($resultset) ; $i++) 
           { 
              $qryQty="select sum(foi.item_qty) as totalQty FROM factory_order as fo LEFT JOIN factory_order_items as foi on foi.idFactoryOrder=fo.idFactoryOrder WHERE fo.po_number=?";
			$resultQty=$this->adapter->query($qryQty,array($resultset[$i]['POnumber']));
			$resultsetQty=$resultQty->toArray();
			$resultset[$i]['totalQty']=$resultsetQty[0]['totalQty'];

			$qrymatQty="SELECT sum(wsi.sku_accept_qty) as matQty FROM `whouse_stock` as ws LEFT JOIN whouse_stock_items as wsi on wsi.idWhStock=ws.idWhStock WHERE ws.po_no=?";
			$resultmatQty=$this->adapter->query($qrymatQty,array($resultset[$i]['POnumber']));
			$resultsetmatQty=$resultmatQty->toArray();
			$resultset[$i]['matQty']=$resultsetmatQty[0]['matQty'];

			
			
           }

           for ($i=0; $i <count($resultset) ; $i++) 
           { 
              if ($resultset[$i]['matQty']==0 || $resultset[$i]['matQty']==null) 
              {
              	$resultset[$i]['status']=1;
              }
              else if ($resultset[$i]['matQty']<$resultset[$i]['totalQty']) {
              		$resultset[$i]['status']=2;
              }
              else if ($resultset[$i]['matQty']==$resultset[$i]['totalQty']) {
              		$resultset[$i]['status']=3;
              }
           }
			

			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			}else{
				$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
			}

		}else if($param->action=='productlist'){
			$factory=$param->factoryid;
			$poNumber=$param->ponumbr;
			$product_details="SELECT pd.idProduct,pd.productName,ps.productSize,pp.primarypackname,ps.productPrimaryCount,ps.idProductsize
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

			
			if(!$resultset || !$resultset1) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			}else{
				$ret_arr=['code'=>'2','content'=>$resultset,'content1'=>$resultset1,'status'=>true,'message'=>'Record available'];
			}

		}
		return $ret_arr;
	}

public function orderCancel($param)
{
  
  $data=$param->FORM;
    

   $qry="SELECT T1.idOrder AS id FROM orders AS T1 where  T1.idOrder=?";
		$result=$this->adapter->query($qry,array($data['orderids']));
		$resultset=$result->toArray();
		
		if(count($resultset)>0)
		{

		
			$this->adapter->getDriver()->getConnection()->beginTransaction();
			try{
				
				$idorder=$data['orderids'];
				if ($data['orderact']==1) {
					$dataupdate['order_cancel']=1;
				}
				else
				{
					$dataupdate['order_cancel']=2;
				}
				
				$sql = new Sql($this->adapter);
				$update = $sql->update();
				$update->table('orders');
				$update->set($dataupdate);
				$update->where(array('idOrder' =>$idorder));
				$statement  = $sql->prepareStatementForSqlObject($update);
				$results    = $statement->execute();
				
				$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
				$this->adapter->getDriver()->getConnection()->commit();
			} catch(\Exception $e) {
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
				$this->adapter->getDriver()->getConnection()->rollBack();
			}
		
 
  $this->adapter->getDriver()->getConnection()->beginTransaction();
			try 
			{

				$ordercancelInsert['idOrder']=$data['orderids'];									
				$ordercancelInsert['reason']=$data['reason'];
				$ordercancelInsert['created_by']=$param->iduser;
				$ordercancelInsert['created_at']=date('Y-m-d H:i:s');						

				$insertorder=new Insert('order_cancel_reason');
				$insertorder->values($ordercancelInsert);
				$statementorder=$this->adapter->createStatement();
				$insertorder->prepareStatement($this->adapter, $statementorder);
				$insertresultorder=$statementorder->execute();
				$orderallocatedid=$this->adapter->getDriver()->getLastGeneratedValue();
			
				if ($data['orderact']=="full") {
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Order deleted successfully'];
				$this->adapter->getDriver()->getConnection()->commit();
				}
				else
				{
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Order partially deleted successfully'];
				$this->adapter->getDriver()->getConnection()->commit();
				}
				
			} 
			catch(\Exception $e) 
			{
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
				$this->adapter->getDriver()->getConnection()->rollBack();
			}

			} else {
			$ret_arr=['code'=>'3','status'=>false,'message'=>'order not available..'];
		}

		return $ret_arr;
}

public function getTransporter($param)
{
      $qry="SELECT *FROM transporter_master WHERE status=1";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
    if (count($resultset)>0) 
    {
    	$ret_arr=['code'=>'2','status'=>true,'content'=>$resultset,'message'=>'data available'];
    }
    else{
    	 $ret_arr=['code'=>'3','status'=>false,'message'=>'data not available'];
    }

    return $ret_arr;

}

public function getVehicletype($param)
{
	$idtransport=$param->idtransport;
   $qry="SELECT vm.idVehicle,vm.vehicleName,vm.vehicleCapacity,vm.vehiclePerKm,vm.vehicleMinCharge FROM vehicle_master as vm LEFT JOIN `transporter_vehicle_master` as tvm on tvm.idVehicle=vm.idVehicle WHERE tvm.idTransporter=? AND vm.status='1'";
		$result=$this->adapter->query($qry,array($idtransport));
		$resultset=$result->toArray();
    if (count($resultset)>0) 
    {
    	$ret_arr=['code'=>'2','status'=>true,'content'=>$resultset,'message'=>'data available'];
    }
    else{
    	 $ret_arr=['code'=>'3','status'=>false,'message'=>'data not available'];
    }

    return $ret_arr;
}

public function getVehicle($param)
{

	$idvehicle=$param->idvehicle;
   $qry="SELECT vm.idVehicle,vm.vehicleName,vm.vehicleCapacity,vm.vehiclePerKm,vm.vehicleMinCharge FROM vehicle_master as vm WHERE vm.idVehicle=? AND vm.status='1'";
		$result=$this->adapter->query($qry,array($idvehicle));
		$resultset=$result->toArray();
    if (count($resultset)>0) 
    {
    	$ret_arr=['code'=>'2','status'=>true,'content'=>$resultset,'message'=>'data available'];
    }
    else{
    	 $ret_arr=['code'=>'3','status'=>false,'message'=>'data not available'];
    }

    return $ret_arr;
}

 public function pending_dispatch_list($param){

	if($param->action=='list'){	

		$qry="SELECT ors.poNumber as ponumber,ors.idCustomer as customer_id,DATE_FORMAT(ors.poDate,'%d-%m-%Y') as poDate,cr.cs_name as name,fm.fulfillmentName,wm.warehouseName,ora.idOrderallocate as id,ora.idOrder as order_id
		FROM orders_allocated_items as oai 
		LEFT JOIN orders_allocated as ora ON ora.idOrderallocate=oai.idOrderallocated
		LEFT JOIN orders as ors ON ors.idOrder=ora.idOrder
		LEFT JOIN warehouse_master as wm ON wm.idWarehouse=ora.idWarehouse		
		LEFT JOIN fulfillment_master as fm ON fm.idFulfillment=ors.idOrderfullfillment
		LEFT JOIN customer as cr ON cr.idCustomer=ors.idCustomer							
		WHERE ora.idOrder!='' AND oai.pickqty!='0' GROUP BY ora.idOrder";

		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		if(!$resultset){
			$ret_arr=['code'=>'3','content'=>'','status'=>false,'message'=>'Please contact the administrator'];
		} else {
			$ret_arr=['code'=>'1','content'=>$resultset,'status'=>true,'message'=>'Order list'];
		}
		return $ret_arr;
	}else if($param->action=='add'){

		    $fiedls=$param->Form;
			$userid=$param->userid;
			$pending_count=$param->pending_count;
			$orderid=($param->checkedid)?$param->checkedid:'';
			$sequenceno=($param->sequence)?$param->sequence:'';
         
			
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['created_at']=date('Y-m-d H:i:s');
					$datainsert['created_by']=$userid;
					$insert=new Insert('dc_sequence');
					$insert->values($datainsert);
					$statement=$this->adapter->createStatement();
					$insert->prepareStatement($this->adapter, $statement);
					$insertresult=$statement->execute();
					$idsequence=$this->adapter->getDriver()->getLastGeneratedValue();
		            		

					$ret_arr=['code'=>'2','status'=>true,'sequenceid'=>$idsequence,'message'=>'Added successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				} catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}

				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
						
				
		             for($i=0;$i<count($orderid);$i++){
		             	// $orderid=$pending_count[$i]['order_id'];		             	
		             	// $sequence='sequence_order_'.$orderid;
		             	$sequencyinsert['idDCsequence']=$idsequence;	
		            	$sequencyinsert['idOrder']=$orderid[$i];	 
		            	$sequencyinsert['Sequenceno']=$sequenceno[$i];	
		            	           
                        $insertt=new Insert('dcsequence_items');
					    $insertt->values($sequencyinsert);
						$statementt=$this->adapter->createStatement();
						$insertt->prepareStatement($this->adapter, $statementt);
						$insertresultt=$statementt->execute();		          
 	            
					 }					

					$ret_arr=['code'=>'2','status'=>true,'sequenceid'=>$idsequence,'message'=>'Added successfully'];
					$this->adapter->getDriver()->getConnection()->commit();
				} catch(\Exception $e) {
					$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
					$this->adapter->getDriver()->getConnection()->rollBack();
				}
			

	}
		else if($param->action=='canceldispatch'){	

        $fiedls=$param->form;
		$userid=$param->userid;

		$order_reason=$fiedls['reason'];
		$editid=$fiedls['orderid'];

	    	$qry="SELECT ora.idOrderallocate as id,ora.idOrder as order_id
								FROM orders_allocated as ora 
								LEFT JOIN order_picklist_items as opi ON opi.idAllocateOrder=ora.idOrderallocate	
								WHERE opi.idOrder =? GROUP BY opi.idAllocateOrder";
			$result=$this->adapter->query($qry,array($editid));
			$resultset=$result->toArray();		
			if($resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try{
					$datainsert['status']='2';
					$sql = new Sql($this->adapter);
					$update = $sql->update();
					$update->table('orders_allocated');
					$update->set($datainsert);
					$update->where(array('idOrderallocate' => $editid));
					$statement  = $sql->prepareStatementForSqlObject($update);
					$results    = $statement->execute();

					$idOrderallocate=$this->adapter->getDriver()->getLastGeneratedValue();
					$inserdata['idOrderallocate']=$idOrderallocate;	
					$inserdata['idOrder']=$fiedls['orderid'];	 
	            	$inserdata['reason']=$fiedls['reason'];	
	            	$inserdata['created_at']=date('Y-m-d H:i:s');
					$inserdata['created_by']=$userid;                  
                    $insert=new Insert('order_cancel_reason');
				    $insert->values($inserdata);
					$statementt=$this->adapter->createStatement();
					$insert->prepareStatement($this->adapter, $statementt);
					$insertresultt=$statementt->execute();	

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

public function getDCdata($param)
{
    $idsequence=$param->idsequence;
		$qry="SELECT a.*,b.*,'0' as customer,'0' as product,'0' as overallweight FROM dc_sequence as a LEFT JOIN dcsequence_items as b on a.idDCsequence=b.idDCsequence WHERE a.idDCsequence=? order by b.Sequenceno ASC";
		$result=$this->adapter->query($qry,array($idsequence));
		$resultset=$result->toArray();

     $overallweight=0;

		for ($i=0; $i < count($resultset); $i++) 
		{ 
			$orderid=$resultset[$i]['idOrder'];
			$orderids[]=$resultset[$i]['idOrder'];
			
			//customer data
			$qryDatacustomer="SELECT ord.idOrder,
			ord.idCustomer,
			ord.poNumber,
			ord.poDate,
			cus.cs_name,
			cus.cs_serviceby, 
			if( g1.geoValue!='',g1.geoValue,'') as geo1 , 
            if( g2.geoValue!='',g2.geoValue,'') as geo2 ,
            if( g3.geoValue!='',g3.geoValue,'') as geo3 , 
            if( g4.geoValue!='',g4.geoValue,'') as geo4 , 
            if( g5.geoValue!='',g5.geoValue,'') as geo5 , 
            if( g6.geoValue!='',g6.geoValue,'') as geo6 , 
            if( g7.geoValue!='',g7.geoValue,'') as geo7 , 
            if( g8.geoValue!='',g8.geoValue,'') as geo8 , 
            if( g9.geoValue!='',g9.geoValue,'') as geo9 , 
			if( g10.geoValue!='',g10.geoValue,'') as geo10,
			0 as overallTotal,0 as overallTax, 
			0 as overallNetamount,
			0 as totalWeight,
            dc.deliveryAddress,
            dc.delivery_date,
            ord.billingAddress
			FROM orders as ord LEFT JOIN customer as cus on cus.idCustomer=ord.idCustomer
            LEFT JOIN dispatch_customer as dc on dc.idOrder=ord.idOrder
		    LEFT JOIN geography as g1 on g1.idGeography=cus.G1 
		    LEFT JOIN geography as g2 on g2.idGeography=cus.G2 
		    LEFT JOIN geography as g3 on g3.idGeography=cus.G3 
		    LEFT JOIN geography as g4 on g4.idGeography=cus.G4 
		    LEFT JOIN geography as g5 on g5.idGeography=cus.G5 
		    LEFT JOIN geography as g6 on g6.idGeography=cus.G6 
		    LEFT JOIN geography as g7 on g7.idGeography=cus.G7 
		    LEFT JOIN geography as g8 on g8.idGeography=cus.G8 
		    LEFT JOIN geography as g9 on g9.idGeography=cus.G9 
		    LEFT JOIN geography as g10 on g10.idGeography=cus.G10 WHERE ord.idOrder=?";
		$resultDatacustomer=$this->adapter->query($qryDatacustomer,array($orderid));
		$resultsetDatacustomer=$resultDatacustomer->toArray();
		
		if($resultsetDatacustomer[0]['geo1']!=''){
			$delvry=$resultsetDatacustomer[0]['geo1'];
		}
		if($resultsetDatacustomer[0]['geo2']!=''){
			$delvry=$delvry.",".$resultsetDatacustomer[0]['geo2'];
		}
		if($resultsetDatacustomer[0]['geo3']!=''){
			$delvry=$delvry.",".$resultsetDatacustomer[0]['geo3'];
		}
		if($resultsetDatacustomer[0]['geo4']!=''){
			$delvry=$delvry.",".$resultsetDatacustomer[0]['geo4'];
		}
		if($resultsetDatacustomer[0]['geo5']!=''){
			$delvry=$delvry.",".$resultsetDatacustomer[0]['geo5'];
		}
		if($resultsetDatacustomer[0]['geo6']!=''){
			$delvry=$delvry.",".$resultsetDatacustomer[0]['geo6'];
		}
		if($resultsetDatacustomer[0]['geo7']!=''){
			$delvry=$delvry.",".$resultsetDatacustomer[0]['geo7'];
		}
		if($resultsetDatacustomer[0]['geo8']!=''){
			$delvry=$delvry.",".$resultsetDatacustomer[0]['geo8'];
		}
		if($resultsetDatacustomer[0]['geo9']!=''){
			$delvry=$delvry.",".$resultsetDatacustomer[0]['geo9'];
		}
		if($resultsetDatacustomer[0]['geo10']!=''){
			$delvry=$delvry.",".$resultsetDatacustomer[0]['geo10'];
		}

		$resultsetDatacustomer[0]['deliveryAddress']=$delvry;
		 $qryDataproduct="SELECT ord.idOrderallocate,
		 ord.idWarehouse, 
		 ord.idOrder, 
		 ord.idWarehouse, 
		 ord.status,
		 ordi.idOrderallocateditems, 
		 ordi.idProduct, 
		 ordi.idProductsize, 
		 ordi.approveQty, 
		 ordi.rejectQty, 
		 ordi.picklistQty, 
		 ordi.pickqty, 
		 ordi.dispatchQty,
		 prd.idProduct, 
		 prd.productCode, 
		 prd.productName, 
		 prd.idHsncode, 
		 prd.productShelflife, 
		 prd.productShelf, 
		 prd.productReturn, 
		 prd.productReturnDays, 
		 prd.productReturnOption, 
		 prd.dispatchControl,
		 prd.productCount, 
		 psize.productSize,
		 psize.idProductsize,
		 psize.productPrimaryCount,
		 pp.primarypackname,
		 pp.idPrimaryPackaging,
		 '0.00' as price ,
		 0 as orderQty,
		 '0.00' as ttlprice,
		 '0.00' as taxpercent,
		 '0.00' as taxAmount,
		 '0.00' as netAmount, 
		 0 as idOrderitem,
		 0 as idWhStockItem,
		 0 as weights,
		 ordi.idScheme,
		 ordi.offer_flog, 
		 '0.00' as discountAmount,
		 (IF(ordi.idScheme!=0,'1','0')) as discountStatus
		 FROM orders_allocated as ord 
		 LEFT JOIN orders_allocated_items as ordi on ordi.idOrderallocated=ord.idOrderallocate 
		 LEFT JOIN product_details as prd on prd.idProduct=ordi.idProduct 
		 LEFT JOIN product_size as psize on psize.idProductsize=ordi.idProductsize 
		 LEFT JOIN primary_packaging as pp on pp.idPrimaryPackaging=psize.idPrimaryPackaging 
		 WHERE ord.idOrder=? AND ordi.pickqty!=0";
		$resultDataproduct=$this->adapter->query($qryDataproduct,array($orderid));
		$resultsetDataproduct=$resultDataproduct->toArray();
		$overallTotalamount=0;
		$overallTotaltax=0;
		$overallNetamount=0;
		$kgvalue=0;
		$ttlkgvalue=0;
		
	
for ($pp=0; $pp < count($resultsetDataproduct); $pp++) 
{ 
	$pid=$resultsetDataproduct[$pp]['idProduct'];
	$psid=$resultsetDataproduct[$pp]['idProductsize'];
	$ordallocateid=$resultsetDataproduct[$pp]['idOrderallocate'];
	$offer_flog=$resultsetDataproduct[$pp]['offer_flog'];
	//get order price details
	if ($offer_flog==1 or $offer_flog==0) // order product
	 {
		$qryDataPrice="SELECT idOrderitem,orderQty,price,cgstAmount,sgstAmount,igstAmount,utgstAmount,discountAmount,cgstPercent,sgstPercent,igstPercent,utgstPercent FROM `order_items` WHERE idOrder='$orderid' and idProduct='$pid' and idProductsize='$psid'";
	$resultDataPrice=$this->adapter->query($qryDataPrice,array());
	$resultsetDataPrice=$resultDataPrice->toArray();
	}
	else if($offer_flog==2) // discount product or free product
	{
		
		$qryScheme="select `free_product_size` as idProductsize,`free_product` as idProduct,idTerritory from scheme WHERE idScheme in(SELECT idScheme FROM `order_items` WHERE idOrder='$orderid' and discountJoinid='$pid')";
	$resultScheme=$this->adapter->query($qryScheme,array());
	$resultsetScheme=$resultScheme->toArray();
	$resultsetDataproduct[$pp]['idProduct']=$resultsetScheme[0]['idProduct'];
	$resultsetDataproduct[$pp]['idProductsize']=$resultsetScheme[0]['idProductsize'];

       $qryDataPrice="SELECT idOrderitem,discountQty as orderQty,'0.00' as price,'0.00' as cgstAmount,'0.00' as sgstAmount,'0.00' as igstAmount,'0.00' as utgstAmount,'0.00' as discountAmount,'0.00' as cgstPercent,'0.00' as sgstPercent,'0.00' as igstPercent,'0.00' as utgstPercent FROM `order_items` WHERE idOrder='$orderid' and discountJoinid='".$resultsetScheme[0]['idProduct']."' ";
	$resultDataPrice=$this->adapter->query($qryDataPrice,array());
	$resultsetDataPrice=$resultDataPrice->toArray();
	}
	

	$resultsetDataproduct[$pp]['idOrderitem']=$resultsetDataPrice[0]['idOrderitem'];
	$resultsetDataproduct[$pp]['price']=($resultsetDataPrice[0]['price'])?$resultsetDataPrice[0]['price']:'0';
	$resultsetDataproduct[$pp]['orderQty']=($resultsetDataPrice[0]['orderQty'])?$resultsetDataPrice[0]['orderQty']:'0';
	$resultsetDataproduct[$pp]['discountAmount']=($resultsetDataPrice[0]['discountAmount'])?$resultsetDataPrice[0]['discountAmount']:'0';
	//total price
	$ttp=$resultsetDataproduct[$pp]['pickqty']*$resultsetDataPrice[0]['price'];
	$resultsetDataproduct[$pp]['ttlprice']=$ttp;
	//total tax percent 
	$txpercent=$resultsetDataPrice[0]['cgstPercent']+$resultsetDataPrice[0]['sgstPercent']+$resultsetDataPrice[0]['igstPercent']+$resultsetDataPrice[0]['utgstPercent'];
	$resultsetDataproduct[$pp]['taxpercent']=$txpercent;

	//total taxt amount
	$txamt=$resultsetDataPrice[0]['cgstAmount']+$resultsetDataPrice[0]['sgstAmount']+$resultsetDataPrice[0]['igstAmount']+$resultsetDataPrice[0]['utgstAmount'];
	$resultsetDataproduct[$pp]['taxAmount']=$txamt;

	$netamount=($ttp+$txamt)-$resultsetDataPrice[0]['discountAmount']; //net amount calculate

	$resultsetDataproduct[$pp]['netAmount']=ROUND($netamount,2);
	$overallTotalamount=$overallTotalamount+$ttp;
	$overallTotaltax=$overallTotaltax+$txamt;
	$overallNetamount=ROUND($overallNetamount+$netamount,2);

	//weight calculation (convert the product size into kilogram)
	 if ($resultsetDataproduct[$pp]['productCount']==1) 
	 {
	 	$kgvalue=1.66*$resultsetDataproduct[$pp]['productSize']; //ex:1 is units 1Units=1.6605402E-27kg
	 }
	 else if ($resultsetDataproduct[$pp]['productCount']==2) 
	 {
	 	$kgvalue=$resultsetDataproduct[$pp]['productSize']; //ex:2 is kg so 1kg=1kg
	 }
	 else if ($resultsetDataproduct[$pp]['productCount']==3) 
	 {
	 	$kgvalue=$resultsetDataproduct[$pp]['productSize']/1000; //ex:3 is gm 1000gm=1kg
	 }
	 else if ($resultsetDataproduct[$pp]['productCount']==4) 
	 {
	 	$kgvalue=$resultsetDataproduct[$pp]['productSize']/1000000; //ex:4 is mgm so 1000000mgm=1kg
	 }
	 else if ($resultsetDataproduct[$pp]['productCount']==5) 
	 {
	 	$kgvalue=$resultsetDataproduct[$pp]['productSize']/1000; //ex:5 is mts so 1tons=1000kg
	 }
	 else if ($resultsetDataproduct[$pp]['productCount']==6) 
	 {
	 	$kgvalue=$resultsetDataproduct[$pp]['productSize']/5000; //ex:6 is cmts  5,000cmts=1kg
	 }
	 else if ($resultsetDataproduct[$pp]['productCount']==7) 
	 {
	 	$kgvalue=$resultsetDataproduct[$pp]['productSize']/0.45359; //ex:7 is inches (1 lb/inch to kilogram/inch = 0.45359 kilogram/inch)
	 }
	 else if ($resultsetDataproduct[$pp]['productCount']==8) 
	 {
	 	$kgvalue=$resultsetDataproduct[$pp]['productSize']/1.48816; //ex:8 is foot (1 pound/foot to kg/m = 1.48816 kg/m)
	 }
	 else if ($resultsetDataproduct[$pp]['productCount']==9) 
	 {
	 	$kgvalue=$resultsetDataproduct[$pp]['productSize']; //ex:9 is litre so 1litre=1kg
	 }
	 else if ($resultsetDataproduct[$pp]['productCount']==10) 
	 {
	 	$kgvalue=$resultsetDataproduct[$pp]['productSize']/1000; //ex:10 is ml (1 kilogram (kg) = 1000 milliliters (ml))
	 }
     $resultsetDataproduct[$pp]['weights']=ROUND($kgvalue,2);
     $ttlkgvalue=$ttlkgvalue+$kgvalue;
     $resultsetDatacustomer[0]['totalWeight']=ROUND($ttlkgvalue,2);
//get idstock itemid
	$qryWHstock="SELECT idWhStockItem,pickQty FROM `order_picklist_items`  WHERE idOrder='$orderid' and idAllocateOrder='$ordallocateid' and idProduct='$pid' and idProdSize='$psid'";
	$resultWHstock=$this->adapter->query($qryWHstock,array());
	$resultsetWHstock=$resultWHstock->toArray();

	//$resultsetDataproduct[$pp]['idWhStockItem']=$resultsetWHstock[0]['idWhStockItem'];
$resultsetDataproduct[$pp]['idWhStockItem']=$resultsetWHstock;



}
   //overall amount ,tax grand total
   for ($ovl=0; $ovl <count($resultsetDatacustomer) ; $ovl++) 
   { 
   	 $resultsetDatacustomer[$ovl]['overallTotal']=round($overallTotalamount,2);
   	 $resultsetDatacustomer[$ovl]['overallTax']=round($overallTotaltax,2);
   	 $resultsetDatacustomer[$ovl]['overallNetamount']=round($overallNetamount,2);
   }
         $resultset[$i]['customer']=$resultsetDatacustomer;
		 $resultset[$i]['product']=$resultsetDataproduct;
		 $overallweight=ROUND($overallweight+$resultset[$i]['customer'][0]['totalWeight'],2);
		

		
}

 $resultset[0]['overallweight']=$overallweight/1000;
  
    if (count($resultset)>0) 
    {
    	$ret_arr=['code'=>'2','status'=>true,'content'=>$resultset,'message'=>'data available'];
    }
    else{
    	 $ret_arr=['code'=>'3','status'=>false,'message'=>'data not available'];
    }

    return $ret_arr;
}

public function dcAdd($param)
{
  
   $transport=$param->transport;
    $data=$param->data;
   
            // print_r($data); exit;           //dispatch vehicle detail inserted
					for ($i=0; $i <count($data) ; $i++) 
					{ 

						  $this->adapter->getDriver()->getConnection()->beginTransaction();
						try {

						$vehicleinsert['idVechileType']=$transport['vtype'];
						$vehicleinsert['idTransport']=$transport['transport'];
						$vehicleinsert['idLevel']=0;
						$vehicleinsert['idCustomer']=$data[$i]['customer'][0]['idCustomer'];
						$vehicleinsert['idServiceBy']=$data[$i]['customer'][0]['cs_serviceby'];
						$vehicleinsert['vehicleNo']=$transport['vno'];
						$vehicleinsert['vehicleCapacity']=$transport['vcapacity'];
						$vehicleinsert['totalKM']=$transport['ttlkm'];
						$vehicleinsert['perKMamount']=round($transport['perkmAmount'],2);
						$vehicleinsert['totalAmount']=round($transport['ttlamt'],2);
						$vehicleinsert['other_charges']=round($transport['othercharge'],2);
						$vehicleinsert['dc_no']='DCNO'.date('YmdHis');
						$vehicleinsert['reimburse_amount']=0;
						$vehicleinsert['creditnote_status']=0;
						$vehicleinsert['deliveryNo']='DLVRY'.date('YmdHis');
						$vehicleinsert['deliveryDate']=date('Y-m-d H:i:s');
						$vehicleinsert['handling_charges']=0;
						$vehicleinsert['handling_status']=0;
						$vehicleinsert['status']=0;

						$insert=new Insert('dispatch_vehicle');
						$insert->values($vehicleinsert);
						$statement=$this->adapter->createStatement();
						$insert->prepareStatement($this->adapter, $statement);
						$insertresult=$statement->execute();
						$idDispatchvehicle[]=$this->adapter->getDriver()->getLastGeneratedValue();

						$ret_arr=['code'=>'2','status'=>true,'idvehicledispatch'=>$idDispatchvehicle,'message'=>'Added successfully'];
						$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
						$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
						$this->adapter->getDriver()->getConnection()->rollBack();
						}

					}
					    //dispatch customer detail inserted
						for ($j=0; $j <count($data) ; $j++) 
						{ 
							$this->adapter->getDriver()->getConnection()->beginTransaction();
						try {
							$deliveryaddress=$data[$j]['customer'][0]['geo1'].','.$data[$j]['customer'][0]['geo2'].''.$data[$j]['customer'][0]['geo3'].''.$data[$j]['customer'][0]['geo4'].''.$data[$j]['customer'][0]['geo5'].''.$data[$j]['customer'][0]['geo6'].''.$data[$j]['customer'][0]['geo7'].''.$data[$j]['customer'][0]['geo8'].''.$data[$j]['customer'][0]['geo9'].''.$data[$j]['customer'][0]['geo10'];
							$customerinsert['idDispatchVehicle']=$idDispatchvehicle[$j];
							$customerinsert['idWarehouse']=$data[$j]['product'][0]['idWarehouse'];
							$customerinsert['idOrderallocate']=$data[$j]['product'][0]['idOrderallocate'];
							$customerinsert['idOrder']=$data[$j]['idOrder'];
							$customerinsert['idCustomer']=$data[$j]['customer'][0]['idCustomer'];
							$customerinsert['idLevel']=0;
							$customerinsert['deliveryAddress']=$deliveryaddress;
							$customerinsert['delivery_date']=date('Y-m-d H:i:s');
							$customerinsert['dcNo']='DCNO'.date('YmdHis');
							$customerinsert['invoiceNo']='INVC'.date('YmdHis');
							$customerinsert['delivry_sequence']=$data[$j]['Sequenceno'];
							$customerinsert['invoice_amt']=$data[$j]['customer'][0]['overallNetamount'];
							$customerinsert['totalWeight']=$transport['ttlwieght'];
							$customerinsert['rplc_misg_refrence']='0';
							$customerinsert['tax_status']=0;
							$customerinsert['cform_file']=0;

							$insertcustomer=new Insert('dispatch_customer');
							$insertcustomer->values($customerinsert);
							$statementcustomer=$this->adapter->createStatement();
							$insertcustomer->prepareStatement($this->adapter, $statementcustomer);
							$insertresultcustomer=$statementcustomer->execute();
                            $idDispatchcustomer[]=$this->adapter->getDriver()->getLastGeneratedValue();
							$ret_arr=['code'=>'2','status'=>true,'idvehicledispatch'=>$idDispatchvehicle,'message'=>'Added successfully'];
						$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
						$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
						$this->adapter->getDriver()->getConnection()->rollBack();
						}
						}


						 //invoice detail inserted
						for ($j=0; $j <count($data) ; $j++) 
						{ 
							$this->adapter->getDriver()->getConnection()->beginTransaction();
						try {
							
							$invoiceinsert['idCustomer']=$data[$j]['customer'][0]['idCustomer'];
							$invoiceinsert['idLevel']=0;
							$invoiceinsert['uploadDate']=date('Y-m-d H:i:s');
							$invoiceinsert['invoiceDate']=date('Y-m-d H:i:s');						
							$invoiceinsert['idOrder']=$data[$j]['idOrder'];
							$invoiceinsert['invoiceNo']='INVC'.date('YmdHis');						
							$invoiceinsert['invoiceAmt']=$data[$j]['customer'][0]['overallNetamount'];
						

							$insertcustomer=new Insert('invoice_details');
							$insertcustomer->values($invoiceinsert);
							$statementcustomer=$this->adapter->createStatement();
							$insertcustomer->prepareStatement($this->adapter, $statementcustomer);
							$insertresultcustomer=$statementcustomer->execute();
                            $idinvoicecustomer[]=$this->adapter->getDriver()->getLastGeneratedValue();
							$ret_arr=['code'=>'2','status'=>true,'idvehicledispatch'=>$idDispatchvehicle,'message'=>'Added successfully'];
						$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
						$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
						$this->adapter->getDriver()->getConnection()->rollBack();
						}
						}
                        

						 //dispatch product detail inserted
                        for ($k=0; $k<count($data) ; $k++) 
						{ 
							for ($l=0; $l < count($data[$k]['product']); $l++) 
							{ 

									$this->adapter->getDriver()->getConnection()->beginTransaction();
						try {
								$productinsert['idDispatchcustomer']=$idDispatchcustomer[$k];
								$productinsert['idProduct']=$data[$k]['product'][$l]['idProduct'];
								$productinsert['idProdSize']=$data[$k]['product'][$l]['idProductsize'];
								$productinsert['offer_flog']=$data[$k]['product'][$l]['offer_flog'];
								$productinsert['idOffer']=$data[$k]['product'][$l]['idScheme'];
								$productinsert['idOrderItem']=$data[$k]['product'][$l]['idOrderitem'];
								$productinsert['dis_Qty']=$data[$k]['product'][$l]['pickqty'];
								
								$insertproduct=new Insert('dispatch_product');
								$insertproduct->values($productinsert);
								$statementproduct=$this->adapter->createStatement();
								$insertproduct->prepareStatement($this->adapter, $statementproduct);
								$insertresultproduct=$statementproduct->execute();
								// $idDispatchproduct[]=$this->adapter->getDriver()->getLastGeneratedValue();
                             $data[$k]['product'][$l]['idDispatchproduct']=$this->adapter->getDriver()->getLastGeneratedValue();
							$ret_arr=['code'=>'2','status'=>true,'idproductdispatch'=>$idDispatchproduct,'message'=>'Added successfully'];
						$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
						$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
						$this->adapter->getDriver()->getConnection()->rollBack();
						}
							}
							
						
						}


						 //dispatch product patch detail inserted
						for ($n=0; $n<count($data) ; $n++) 
						{ 
							for ($o=0; $o< count($data[$n]['product']); $o++) 
							{ 
								for ($wh=0; $wh< count($data[$n]['product'][$o]['idWhStockItem']); $wh++) 
							    { 
										$this->adapter->getDriver()->getConnection()->beginTransaction();
						try {
								//$WHinsert['idDispatchProduct']=$idDispatchproduct[$o];
							$WHinsert['idDispatchProduct']=$data[$n]['product'][$o]['idDispatchproduct'];
								$WHinsert['idWhStockItem']=$data[$n]['product'][$o]['idWhStockItem'][$wh]['idWhStockItem'];
								$WHinsert['qty']=$data[$n]['product'][$o]['idWhStockItem'][$wh]['pickQty'];

								$insertWH=new Insert('dispatch_product_batch');
								$insertWH->values($WHinsert);
								$statementWH=$this->adapter->createStatement();
								$insertWH->prepareStatement($this->adapter, $statementWH);
								$insertresultWH=$statementWH->execute();
								$idDispatchWH[]=$this->adapter->getDriver()->getLastGeneratedValue();

							$ret_arr=['code'=>'2','status'=>true,'idDispatchWH'=>$idDispatchWH,'message'=>'Added successfully'];
						$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
						$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
						$this->adapter->getDriver()->getConnection()->rollBack();
						}

							}
						}
					}
          //dispatch qty  detail update
						for ($n=0; $n<count($data) ; $n++) 
						{ 
							for ($o=0; $o< count($data[$n]['product']); $o++) 
							{ 
								$this->adapter->getDriver()->getConnection()->beginTransaction();
								try{
									$idorderallocateditem=$data[$n]['product'][$o]['idOrderallocateditems'];

									$dataupdate['dispatchQty']=$data[$n]['product'][$o]['pickqty']+$data[$n]['product'][$o]['dispatchQty'];
									$dataupdate['pickqty']=0;
                                    
									$sql = new Sql($this->adapter);
									$update = $sql->update();
									$update->table('orders_allocated_items');
									$update->set($dataupdate);
									$update->where(array('idOrderallocateditems' => $idorderallocateditem));
									$statement  = $sql->prepareStatementForSqlObject($update);
									$results    = $statement->execute();
									
									$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
									$this->adapter->getDriver()->getConnection()->commit();
								} catch(\Exception $e) {
									$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
									$this->adapter->getDriver()->getConnection()->rollBack();
								}  
							}
						}

 //dispatch status detail updated
							for ($n=0; $n<count($data) ; $n++) 
						{ 
							for ($o=0; $o< count($data[$n]['product']); $o++) 
							{ 
									$idorderallocate=$data[$n]['product'][$o]['idOrderallocate'];
								$qrydeliverystatus="SELECT sum(approveQty) as approveQty, SUM(dispatchQty) AS dispatchQty FROM `orders_allocated_items` WHERE idOrderallocated=?";
								$resultdeliverystatus=$this->adapter->query($qrydeliverystatus,array($idorderallocate));
								$resultsetdeliverystatus=$resultdeliverystatus->toArray();
                                $status=0;
								if ($resultsetdeliverystatus[0]['approveQty']==$resultsetdeliverystatus[0]['dispatchQty']) 
								{
									$status=5;
								}
								else
								{
                                   $status=6;
								}


								$this->adapter->getDriver()->getConnection()->beginTransaction();
								try{
									
									$deliveryupdate['status']=$status;
							
									$sqldelivery = new Sql($this->adapter);
									$updatedelivery = $sqldelivery->update();
									$updatedelivery->table('orders_allocated');
									$updatedelivery->set($deliveryupdate);
									$updatedelivery->where(array('idOrderallocate' => $idorderallocate));
									$statementdelivery  = $sql->prepareStatementForSqlObject($updatedelivery);
									$results    = $statementdelivery->execute();
									$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
									$this->adapter->getDriver()->getConnection()->commit();
								} catch(\Exception $e) {
									$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
									$this->adapter->getDriver()->getConnection()->rollBack();
								} 

							}
						}
				
				return $ret_arr;
}

public function getDispatchorder($param)
{
    $qryDO="SELECT dv.idDispatchVehicle,dv.deliveryNo,date_format(dv.deliveryDate,'%d-%m-%Y') as deliveryDate ,dv.vehicleNo,tm.idTransporter,tm.transporterName,vm.idVehicle,vm.vehicleName FROM `dispatch_vehicle` as dv  LEFT JOIN transporter_master as tm on tm.idTransporter=dv.idTransport LEFT JOIN vehicle_master as vm on vm.idVehicle=dv.idVechileType GROUP BY deliveryNo";
	$resultDO=$this->adapter->query($qryDO,array());
	$resultsetDO=$resultDO->toArray();

	if (count($resultsetDO)>0) 
	{
		$ret_arr=['code'=>'2','status'=>true,'content'=>$resultsetDO,'message'=>'data available'];
	}
	else
	{
		$ret_arr=['code'=>'1','status'=>false,'message'=>'No data available..'];
	}
   return $ret_arr;
}
public function getDCview($param)
{
   $id=$param->id;

    $qryCustomer="SELECT dc.deliveryAddress,
    dc.delivery_date,
    ord.billingAddress,
    c.idCustomer,
    c.cs_name,
    c.cs_tinno,
    ord.idOrder,
    ord.poNumber,
    ord.poDate,
    ord.totalTax,
    ord.totalAmount,
    ord.grandtotalAmount,
    dc.totalWeight,
    dc.idDispatchcustomer,
    dc.invoice_amt,
    dc.invoiceNo,
    dc.dcNo,
    c.cs_tinno,
    dv.idVechileType,
    dc.idWarehouse,
    dv.idTransport,
    dv.vehicleNo,
    '0' as netamountword,
    '0' as product ,'0' as company,'0' as warehouse,'0' as vehicle,'0' as customerAddress
     FROM `dispatch_vehicle` as dv 
     LEFT JOIN dispatch_customer as dc on dc.idDispatchVehicle=dv.idDispatchVehicle 
     LEFT JOIN customer as c on c.idCustomer=dc.idCustomer 
     LEFT JOIN orders as ord on ord.idOrder=dc.idOrder WHERE dv.deliveryNo=? ORDER BY dv.idDispatchVehicle ASC";
	$resultCustomer=$this->adapter->query($qryCustomer,array($id));
	$resultsetCustomer=$resultCustomer->toArray();

	 //company detail
			$qryCompany="SELECT companyName as name,companyLandline as mobile,companyWebsite as website,companyAddress,companyLogo FROM sys_config";
			$resultCompany=$this->adapter->query($qryCompany,array());
			$resultsetCompany=$resultCompany->toArray();
			
    
	for ($i=0; $i <count($resultsetCustomer) ; $i++) 
	{ 
		     //company detail
			$qryCompany="SELECT companyName as name,companyLandline as mobile,companyWebsite as website,companyAddress,companyLogo FROM sys_config";
			$resultCompany=$this->adapter->query($qryCompany,array());
			$resultsetCompany=$resultCompany->toArray();
			// $url="public/uploads/logo/".$resultsetCompany[0]['companyLogo'];
			// $cmpnylogoB64=base64_encode($url);
			

			$path = "public/uploads/logo/".$resultsetCompany[0]['companyLogo'].'';
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data11 = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data11);
            $resultsetCompany[0]['cmpnylogoB64']=$base64;
			$resultsetCustomer[$i]['company']=$resultsetCompany[0];
			//warehouse details
			$qryWarehouse="SELECT wm.warehouseName as name,
wm.warehouseMobileno as mobile,
wm.warehouseEmail as email,
tm1.territoryValue as country,
tm2.territoryValue as state,
tm3.territoryValue as city,
tm4.territoryValue as pincode,
tm5.territoryValue as region,
tm6.territoryValue as zone,
tm7.territoryValue as hub,
tm8.territoryValue as area,
tm9.territoryValue as street,
tm10.territoryValue as outlet,'' as warehouseAddress
FROM `warehouse_master` as wm 
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
WHERE idWarehouse='".$resultsetCustomer[$i]['idWarehouse']."' ";
			$resultWarehouse=$this->adapter->query($qryWarehouse,array());
			$resultsetWarehouse=$resultWarehouse->toArray();
            $whaddress='';
			if ($resultsetWarehouse[0]['country']!='') {
				$whaddress=$whaddress.''.$resultsetWarehouse[0]['country'];
			}
			if ($resultsetWarehouse[0]['state']!='') {
				$whaddress=$whaddress.','.$resultsetWarehouse[0]['state'];
			}
			if ($resultsetWarehouse[0]['city']!='') {
				$whaddress=$whaddress.','.$resultsetWarehouse[0]['city'];
			}
			if ($resultsetWarehouse[0]['pincode']!='') {
				$whaddress=$whaddress.','.$resultsetWarehouse[0]['pincode'];
			}
			if ($resultsetWarehouse[0]['region']!='') {
				$whaddress=$whaddress.','.$resultsetWarehouse[0]['region'];
			}
			if ($resultsetWarehouse[0]['zone']!='') {
				$whaddress=$whaddress.','.$resultsetWarehouse[0]['zone'];
			}
			if ($resultsetWarehouse[0]['hub']!='') {
				$whaddress=$whaddress.''.$resultsetWarehouse[0]['hub'];
			}
			if ($resultsetWarehouse[0]['area']!='') {
				$whaddress=$whaddress.','.$resultsetWarehouse[0]['area'];
			}
			if ($resultsetWarehouse[0]['street']!='') {
				$whaddress=$whaddress.''.$resultsetWarehouse[0]['street'];
			}
			if ($resultsetWarehouse[0]['outlet']!='') {
				$whaddress=$whaddress.','.$resultsetWarehouse[0]['outlet'];
			}
            $resultsetWarehouse[0]['warehouseAddress']=$whaddress;
			$resultsetCustomer[$i]['warehouse']=$resultsetWarehouse[0];
// //customer address
$qryCustomeraddress="SELECT c.cs_name as name,
c.cs_mobno as mobile,
c.cs_mail as email,
tm1.geoValue as country,
tm2.geoValue as state,
tm3.geoValue as city,
tm4.geoValue as pincode,
tm5.geoValue as region,
tm6.geoValue as zone,
tm7.geoValue as hub,
tm8.geoValue as area,
tm9.geoValue as street,
tm10.geoValue as outlet
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
WHERE idCustomer='".$resultsetCustomer[$i]['idCustomer']."' ";
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
			
			$resultsetCustomer[$i]['customerAddress']=$resultsetCustomeraddress[0];


	  //transport and vehicle details
		$qryVehicle="SELECT tm.transporterName as transportName,
		tm.transporterMobileNo as mobile,
		vm.vehicleName as vehicleType,
		'0' as vehicleNo
		FROM `transporter_master`as tm 
		LEFT JOIN transporter_vehicle_master as tvm ON tvm.idTransporter=tm.idTransporter 
		LEFT JOIN vehicle_master as vm ON vm.idVehicle=tvm.idVehicle WHERE tm.idTransporter='".$resultsetCustomer[$i]['idTransport']."' AND vm.idVehicle='".$resultsetCustomer[$i]['idVechileType']."'";

		$resultVehicle=$this->adapter->query($qryVehicle,array());
		$resultsetVehicle=$resultVehicle->toArray();
		$resultsetVehicle[0]['vehicleNo']=$resultsetCustomer[$i]['vehicleNo'];

			$resultsetCustomer[$i]['vehicle']=$resultsetVehicle[0];

        //product details
		$iddispatchcustomer=$resultsetCustomer[$i]['idDispatchcustomer'];
	    $qryProduct="SELECT dp.idDispatchProduct,
	    dp.dis_Qty,
	    pd.productName,
	    pd.idProduct,
	    ps.idProductsize,
	    ps.productSize,
	    pd.productCount,
	    ps.productPrimaryCount,pp.primarypackname,
	    ordi.price,
	    (IF(dp.offer_flog=2, dp.dis_Qty,ordi.orderQty)) as orderQty,
	    (IF(dp.offer_flog=2,'0',ordi.totalAmount)) as totalAmount,
	    (IF(dp.offer_flog=2,'0',ordi.cgstAmount)) as cgstAmount,
	    (IF(dp.offer_flog=2,'0',ordi.sgstAmount)) as sgstAmount,
	    (IF(dp.offer_flog=2,'0',ordi.igstAmount)) as igstAmount,
	    (IF(dp.offer_flog=2,'0',ordi.utgstAmount)) as utgstAmount,
	    (IF(dp.offer_flog=2,'0',ordi.discountAmount)) as discountAmount,
	    (IF(dp.offer_flog=2,'0',ordi.cgstPercent)) as cgstPercent,
	    (IF(dp.offer_flog=2,'0',ordi.sgstPercent)) as sgstPercent,
	    (IF(dp.offer_flog=2,'0',ordi.igstPercent)) as igstPercent,
	    (IF(dp.offer_flog=2,'0',ordi.utgstPercent)) as utgstPercent,
	    dp.offer_flog,
	    dp.idOffer,
	      (IF(dp.offer_flog=2,'0',ordi.NetAmount)) as NetAmount, 
	    (IF( dp.offer_flog=2,'0',dp.dis_Qty*ordi.price)) as ttlprice,
	   (IF(dp.offer_flog=2,'0',ordi.cgstPercent+ordi.sgstPercent+ ordi.igstPercent+ ordi.utgstPercent))  as taxpercent,
	   (IF(dp.offer_flog=2,'0',ordi.cgstAmount+ordi.sgstAmount+ordi.igstAmount+ordi.utgstAmount))  as ttltax 
	    FROM `dispatch_product` as dp 
LEFT JOIN product_details as pd on pd.idProduct=dp.idProduct 
LEFT JOIN product_size as ps on ps.idProductsize=dp.idProdSize 
LEFT JOIN primary_packaging as pp on pp.idPrimaryPackaging=ps.idPrimaryPackaging 
LEFT JOIN order_items as ordi on ordi.idOrderitem=dp.idOrderItem WHERE dp.idDispatchcustomer=?";
	$resultProduct=$this->adapter->query($qryProduct,array($iddispatchcustomer));
	$resultsetProduct=$resultProduct->toArray();

	$resultsetCustomer[$i]['product']=$resultsetProduct;

	}

	if (count($resultsetCustomer)>0) 
	{
		$ret_arr=['code'=>'2','status'=>true,'content'=>$resultsetCustomer,'company'=>$resultsetCompany,'message'=>'data available'];
	}
	else
	{
		$ret_arr=['code'=>'1','status'=>false,'message'=>'No data available..'];
	}
 return $ret_arr;

}

public function getDispatchedview($param)
{
   
		$id=$param->id; // order allocated id
		$iditems=$param->iditem; // order allocated item id
		$idorder=$param->orderid; // order id
		$idorderitem=$param->orderitemid; //order item id
    $qryDispached="SELECT DATE(dc.delivery_date) as dispatchedDate,dp.dis_Qty as dispatchedQty FROM dispatch_customer as dc LEFT JOIN dispatch_product as dp on dp.idDispatchcustomer=dc.idDispatchcustomer WHERE dc.idOrderallocate='$id' and dp.idOrderItem='$idorderitem'";
	$resultDispached=$this->adapter->query($qryDispached,array());
	$resultsetDispached=$resultDispached->toArray();

	if (count($resultsetDispached)>0) 
	{
		$ret_arr=['code'=>'2','status'=>true,'content'=>$resultsetDispached,'message'=>'data available'];
	}
	else
	{
		$ret_arr=['code'=>'1','status'=>false,'message'=>'No data available..'];
	}

	return $ret_arr;

}

public function sendtoDispatch($param)
{
	$pickdisQty=($param->pickdisQty)?explode(',',$param->pickdisQty):'';
	$idallocitems=($param->idallocitems)?explode(',',$param->idallocitems):'';
      
	$qry="SELECT status FROM  orders_allocated where  idOrderallocate=?";
	$result=$this->adapter->query($qry,array($param->idallocate));
	$resultset=$result->toArray();
	if ($resultset[0]['status']!=2 || $resultset[0]['status']!=3) 
	{
		for ($i=0; $i <count($pickdisQty) ; $i++) 
		{
			$alreadypickyQty=0;
			 if ($pickdisQty[$i]>0) {
				$subqry="SELECT pickqty FROM  orders_allocated_items where idOrderallocateditems=?";
				$subresult=$this->adapter->query($subqry,array($idallocitems[$i]));
				$subresultset=$subresult->toArray();

							$this->adapter->getDriver()->getConnection()->beginTransaction();
							try {
								   $alreadypickyQty=($subresultset[0]['pickqty'])?$subresultset[0]['pickqty']:0;
								$dataupdate['pickqty']=$alreadypickyQty+$pickdisQty[$i];
								$sql = new Sql($this->adapter);
								$update = $sql->update();
								$update->table('orders_allocated_items');
								$update->set($dataupdate);
								$update->where(array('idOrderallocateditems' =>$idallocitems[$i]));
								$statement = $sql->prepareStatementForSqlObject($update);
								$results = $statement->execute();

                                $datadispatchupdate['status']=0;
								$sqlDispatch = new Sql($this->adapter);
								$updateDispatch = $sqlDispatch->update();
								$updateDispatch->table('order_picklist_items');
								$updateDispatch->set($datadispatchupdate);
								$updateDispatch->where(array('idAllocateItem' =>$idallocitems[$i]));
								$statementDispatch = $sqlDispatch->prepareStatementForSqlObject($updateDispatch);
								$resultsDispatch = $statementDispatch->execute();
								$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
								$this->adapter->getDriver()->getConnection()->commit();

							}catch(\Exception $e) {
								$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
								$this->adapter->getDriver()->getConnection()->rollBack();
							}
						}
		}
	}

	return $ret_arr;

}
//milligram to kg
public function mgmTokg($mgmvalue)
{
    $kgvalue=$mgmvalue/1000000;
    return $kgvalue;
}
//gram to kg
public function gmTokg($gmvalue)
{
    $kgvalue=$gmvalue/1000;
    return $kgvalue;
}
//tons to kg (1litre is = 1kg)
public function mtsTokg($mtsvalue)
{
    $kgvalue=$mtsvalue*1000;
    return $kgvalue;
}
//millilitre to kg
public function mlitreTokg($mltrvalue)
{
    $kgvalue=$mltrvalue*1000;
    return $kgvalue;
}

public function getRDRMdata($param)
{
		$qryCustomertype="SELECT * FROM `customertype` WHERE status=1 ORDER BY `idCustomerType` ";
		$resultCustomertype=$this->adapter->query($qryCustomertype,array());
		$resultsetCustomertype=$resultCustomertype->toArray(); 

		$qryCustomer="SELECT * FROM `customer` ORDER BY `idCustomer` ASC ";
		$resultCustomer=$this->adapter->query($qryCustomer,array());
		$resultsetCustomer=$resultCustomer->toArray();

		$ret_arr=['code'=>'2','status'=>true,'customertype'=>$resultsetCustomertype,'customer'=>$resultsetCustomer,'message'=>'Data available'];

		return $ret_arr;

}
public function getRDRMcustomer($param)
{
   $idctype=$param->id;
		$qryCustomer="SELECT * FROM `customer` WHERE cs_type='$idctype' ORDER BY `idCustomer` ASC ";
		$resultCustomer=$this->adapter->query($qryCustomer,array());
		$resultsetCustomer=$resultCustomer->toArray();
        if (count($resultsetCustomer)>0) 
        {
        	$ret_arr=['code'=>'2','status'=>true,'customer'=>$resultsetCustomer,'message'=>'Data available'];
        }
        else
        {
        	 $ret_arr=['code'=>'3','status'=>false,'message'=>'no data available'];
        }
		

		return $ret_arr;

}

public function getRDRMamount($param)
{
  
		$idctype=$param->idcstype;
		$idcustomer=$param->idcs;
		$idact=$param->idact;
		$frmdate=$param->frmdate;
		$todate=$param->todate;
		if ($idact==4)  // return detail
		{
		$qryRTN="SELECT RTN.idCreditstatusreturn AS idType,RTN.credit_note_no,RTN.idCustomer,RTN.credit_amount,DATE_FORMAT(RTN.credit_date, '%d-%m-%Y') as credit_date,C.cs_name, '0' as apprvAmount
			FROM customer_order_return_credit_status AS RTN
			LEFT JOIN customer AS C ON C.idCustomer=RTN.idCustomer
			WHERE   RTN.credit_status=0 AND RTN.credit_date BETWEEN '".date('Y-m-d',strtotime($frmdate))."' AND '".date('Y-m-d',strtotime($todate. ' +1 day'))."' AND RTN.approval_amount=0 AND C.idCustomer='$idcustomer'";
		$resultRTN=$this->adapter->query($qryRTN,array());
		$resultsetRTN=$resultRTN->toArray();
		if (count($resultsetRTN)>0) 
		{
			$ret_arr=['code'=>'2','status'=>true,'content'=>$resultsetRTN,'message'=>'Data available'];
		}
		else
		{
			 $ret_arr=['code'=>'3','status'=>false,'message'=>'no data available'];
		}
		
		}
		elseif ($idact==5)  // damage details
		{
			$qryDMG="SELECT CD.idCreditstatusdamage AS idType,CD.credit_note_no,CD.idCustomer,CD.credit_amount,CD.credit_date,C.cs_name, '0' as apprvAmount
			FROM customer_order_damage_credit_status AS CD
			LEFT JOIN customer AS C ON C.idCustomer=CD.idCustomer
			WHERE CD.credit_status=0 AND CD.credit_date BETWEEN '".date('Y-m-d',strtotime($frmdate))."' AND '".date('Y-m-d',strtotime($todate. ' +1 day'))."' AND CD.approval_amount=0 AND C.idCustomer='$idcustomer'";
		$resultDMG=$this->adapter->query($qryDMG,array());
		$resultsetDMG=$resultDMG->toArray();
		if (count($resultsetDMG)>0) 
		{
			$ret_arr=['code'=>'2','status'=>true,'content'=>$resultsetDMG,'message'=>'Data available'];
		}
		else
		{
			 $ret_arr=['code'=>'3','status'=>false,'message'=>'no data available'];
		}
		}
		elseif ($idact==6)   //replace detail
		{
			$qryRPLC="SELECT CR.idCreditstatusreplace AS idType,CR.credit_note_no,CR.idCustomer,CR.credit_amount,CR.credit_date,C.cs_name, '0' as apprvAmount
			FROM customer_order_replace_credit_status AS CR
			LEFT JOIN customer AS C ON C.idCustomer=CR.idCustomer
			WHERE  CR.credit_status=0 AND credit_date BETWEEN '".date('Y-m-d',strtotime($frmdate))."' AND '".date('Y-m-d',strtotime($todate. ' +1 day'))."' AND approval_amount=0 AND C.idCustomer='$idcustomer'";
		$resultRPLC=$this->adapter->query($qryRPLC,array());
		$resultsetRPLC=$resultRPLC->toArray();
		if (count($resultsetRPLC)>0) 
		{
			$ret_arr=['code'=>'2','status'=>true,'content'=>$resultsetRPLC,'message'=>'Data available'];
		}
		else
		{
			 $ret_arr=['code'=>'3','status'=>false,'message'=>'no data available'];
		}
		}
		elseif ($idact==7)  // missing details
		{
			$qryMSNG="SELECT CM.idCreditstatusmissing AS idType,CM.credit_note_no,CM.idCustomer,CM.credit_amount,CM.credit_date,C.cs_name, '0' as apprvAmount
			FROM customer_order_missing_credit_status AS CM
			LEFT JOIN customer AS C ON C.idCustomer=CM.idCustomer
			WHERE  CM.credit_status=0 AND credit_date BETWEEN '".date('Y-m-d',strtotime($frmdate))."' AND '".date('Y-m-d',strtotime($todate. ' +1 day'))."' AND approval_amount=0 AND C.idCustomer='$idcustomer'";
		$resultMSNG=$this->adapter->query($qryMSNG,array());
		$resultsetMSNG=$resultMSNG->toArray();
		if (count($resultsetMSNG)>0) 
		{
			$ret_arr=['code'=>'2','status'=>true,'content'=>$resultsetMSNG,'message'=>'Data available'];
		}
		else
		{
			 $ret_arr=['code'=>'3','status'=>false,'message'=>'no data available'];
		}
		}
		return $ret_arr;
}
public function updateRDRM($param)
{
 
  $approveData=$param->apprvamt;
  $actid=$param->actid;
 
  if ($actid==4) 
  {
 
  	 $this->adapter->getDriver()->getConnection()->beginTransaction();
							try {
								  for ($i=0; $i <count($approveData) ; $i++) 
								  { 
								  	if($approveData[$i]['apprvAmount']!='' && $approveData[$i]['apprvAmount']!=0)
								  	{
										$dataupdate['approval_amount']=$approveData[$i]['apprvAmount'];
										$dataupdate['credit_status']=1;

										$sql = new Sql($this->adapter);
										$update = $sql->update();
										$update->table('customer_order_return_credit_status');
										$update->set($dataupdate);
										$update->where(array('idCreditstatusreturn' =>$approveData[$i]['idType']));
										$statement = $sql->prepareStatementForSqlObject($update);
										$results = $statement->execute();
										$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
										$this->adapter->getDriver()->getConnection()->commit();
								  	}
								  }
								

							}catch(\Exception $e) {
								$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
								$this->adapter->getDriver()->getConnection()->rollBack();
							}
  }
  else if($actid==5)
  {
      $this->adapter->getDriver()->getConnection()->beginTransaction();
							try {
								  for ($i=0; $i <count($approveData) ; $i++) 
								  { 
								  	if($approveData[$i]['apprvAmount']!='' && $approveData[$i]['apprvAmount']!=0)
								  	{
										$DMGupdate['approval_amount']=$approveData[$i]['apprvAmount'];
										$DMGupdate['credit_status']=1;

										$sql = new Sql($this->adapter);
										$update = $sql->update();
										$update->table('customer_order_damage_credit_status');
										$update->set($DMGupdate);
										$update->where(array('idCreditstatusdamage' =>$approveData[$i]['idType']));
										$statement = $sql->prepareStatementForSqlObject($update);
										$results = $statement->execute();
										$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
										$this->adapter->getDriver()->getConnection()->commit();
								  	}
								  }
								

							}catch(\Exception $e) {
								$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
								$this->adapter->getDriver()->getConnection()->rollBack();
							}
  }

  else if($actid==6)
  {
      $this->adapter->getDriver()->getConnection()->beginTransaction();
							try {
								  for ($i=0; $i <count($approveData) ; $i++) 
								  { 
								  	if($approveData[$i]['apprvAmount']!='' && $approveData[$i]['apprvAmount']!=0)
								  	{
										$RPLSupdate['approval_amount']=$approveData[$i]['apprvAmount'];
										$RPLSupdate['credit_status']=1;

										$sql = new Sql($this->adapter);
										$update = $sql->update();
										$update->table('customer_order_replace_credit_status');
										$update->set($RPLSupdate);
										$update->where(array('idCreditstatusreplace' =>$approveData[$i]['idType']));
										$statement = $sql->prepareStatementForSqlObject($update);
										$results = $statement->execute();
										$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
										$this->adapter->getDriver()->getConnection()->commit();
								  	}
								  }
								

							}catch(\Exception $e) {
								$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
								$this->adapter->getDriver()->getConnection()->rollBack();
							}
  }

  else if($actid==7)
  {
      $this->adapter->getDriver()->getConnection()->beginTransaction();
							try {
								  for ($i=0; $i <count($approveData) ; $i++) 
								  { 
								  	if($approveData[$i]['apprvAmount']!='' && $approveData[$i]['apprvAmount']!=0)
								  	{
										$MSNGupdate['approval_amount']=$approveData[$i]['apprvAmount'];
										$MSNGupdate['credit_status']=1;

										$sql = new Sql($this->adapter);
										$update = $sql->update();
										$update->table('customer_order_missing_credit_status');
										$update->set($MSNGupdate);
										$update->where(array('idCreditstatusmissing' =>$approveData[$i]['idType']));
										$statement = $sql->prepareStatementForSqlObject($update);
										$results = $statement->execute();
										$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
										$this->adapter->getDriver()->getConnection()->commit();
								  	}
								  }
								

							}catch(\Exception $e) {
								$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
								$this->adapter->getDriver()->getConnection()->rollBack();
							}
  }
  
							return $ret_arr;

}

public function getcreditRDRMAmount($param)
{
        $idctype=$param->idcstype;
		$idcustomer=$param->idcs;
		$idact=$param->idact;
		$frmdate=$param->frmdate;
		$todate=$param->todate;
		if ($idact==4)  // return detail
		{
		$qryRTN="SELECT count(idCreditstatusreturn) as cntt_t,sum(approval_amount) as amnt, '0' as pending_cntt_t,'0' as pending_amnt  FROM customer_order_return_credit_status
			WHERE   credit_date BETWEEN '".date('Y-m-d',strtotime($frmdate))."' AND '".date('Y-m-d',strtotime($todate. ' +1 day'))."'  AND approval_amount!=0.00 AND idCustomer='$idcustomer'";
		$resultRTN=$this->adapter->query($qryRTN,array());
		$resultsetRTN=$resultRTN->toArray();

		$qrypendingRTN="SELECT count(idCreditstatusreturn) as pending_cntt_t,sum(approval_amount) as pending_amnt FROM customer_order_return_credit_status
			WHERE   credit_date BETWEEN '".date('Y-m-d',strtotime($frmdate))."' AND '".date('Y-m-d',strtotime($todate. ' +1 day'))."' AND credit_status='1'  AND approval_amount!=0.00 AND idCustomer='$idcustomer'";
		$resultpendingRTN=$this->adapter->query($qrypendingRTN,array());
		$resultsetpendingRTN=$resultpendingRTN->toArray();

        $resultsetRTN[0]['pending_cntt_t']=$resultsetpendingRTN[0]['pending_cntt_t'];
         $resultsetRTN[0]['pending_amnt']=$resultsetpendingRTN[0]['pending_amnt'];

         $qrynotes="SELECT t1.cs_name,COUNT(t2.idCustomer) as cus_count FROM customer as t1
			LEFT JOIN credit_notes_all_types as t2 ON t2.idCustomer=t1.idCustomer
			WHERE t1.idCustomer='$idcustomer'";
			$resultnotes=$this->adapter->query($qrynotes,array());
			$resultsetnotes=$resultnotes->toArray();
			//print_r($resultsetRTN);
		
		if ($resultsetRTN[0]['cntt_t']!=0) 
		{
			$ret_arr=['code'=>'2','status'=>true,'count'=>$resultsetnotes,'content'=>$resultsetRTN,'message'=>'Data available'];
		}
		else
		{
			 $ret_arr=['code'=>'3','status'=>false,'message'=>'no data available'];
		}
		
		}
		elseif ($idact==5)  // damage details
		{
			$qryDMG="SELECT count(idCreditstatusdamage) as cntt_t,sum(approval_amount) as amnt, '0' as pending_cntt_t,'0' as pending_amnt  FROM customer_order_damage_credit_status
			WHERE   credit_date BETWEEN '".date('Y-m-d',strtotime($_REQUEST['dmg_frmDate']))."' AND '".date('Y-m-d',strtotime($_REQUEST['dmg_toDate']. ' +1 day'))."'  AND approval_amount!=0.00 AND idCustomer='$idcustomer'";
		$resultDMG=$this->adapter->query($qryDMG,array());
		$resultsetDMG=$resultDMG->toArray();

		$qrypendingDMG="SELECT count(idCreditstatusdamage) as pending_cntt_t,sum(approval_amount) as pending_amnt FROM customer_order_damage_credit_status
			WHERE   credit_date BETWEEN '".date('Y-m-d',strtotime($_REQUEST['dmg_frmDate']))."' AND '".date('Y-m-d',strtotime($_REQUEST['dmg_toDate']. ' +1 day'))."' AND credit_status='1'  AND approval_amount!=0.00 AND idCustomer='$idcustomer'";
		$resultpendingDMG=$this->adapter->query($qrypendingDMG,array());
		$resultsetpendingDMG=$resultpendingDMG->toArray();
		
		$resultsetDMG[0]['pending_cntt_t']=$resultsetpendingDMG[0]['pending_cntt_t'];
		$resultsetDMG[0]['pending_amnt']=$resultsetpendingDMG[0]['pending_amnt'];

		  $qrynotes="SELECT t1.cs_name,COUNT(t2.idCustomer) as cus_count FROM customer as t1
			LEFT JOIN credit_notes_all_types as t2 ON t2.idCustomer=t1.idCustomer
			WHERE t1.idCustomer='$idcustomer'";
			$resultnotes=$this->adapter->query($qrynotes,array());
			$resultsetnotes=$resultnotes->toArray();
		
		if ($resultsetDMG[0]['cntt_t']!=0) 
		{
			$ret_arr=['code'=>'2','status'=>true,'count'=>$resultsetnotes,'content'=>$resultsetDMG,'message'=>'Data available'];
		}
		else
		{
			 $ret_arr=['code'=>'3','status'=>false,'message'=>'no data available'];
		}
		}
		elseif ($idact==6)   //replace detail
		{
			$qryRPLC="SELECT count(idCreditstatusreplace) as cntt_t,sum(approval_amount) as amnt, '0' as pending_cntt_t,'0' as pending_amnt  FROM customer_order_replace_credit_status
			WHERE   credit_date BETWEEN '".date('Y-m-d',strtotime($_REQUEST['dmg_frmDate']))."' AND '".date('Y-m-d',strtotime($_REQUEST['dmg_toDate']. ' +1 day'))."'  AND approval_amount!=0.00 AND idCustomer='$idcustomer'";
		$resultRPLC=$this->adapter->query($qryRPLC,array());
		$resultsetRPLC=$resultRPLC->toArray();

		$qrypendingRPLC="SELECT count(idCreditstatusreplace) as pending_cntt_t,sum(approval_amount) as pending_amnt  FROM customer_order_replace_credit_status
			WHERE   credit_date BETWEEN '".date('Y-m-d',strtotime($_REQUEST['dmg_frmDate']))."' AND '".date('Y-m-d',strtotime($_REQUEST['dmg_toDate']. ' +1 day'))."' AND credit_status='1'  AND approval_amount!=0.00 AND idCustomer='$idcustomer'";
		$resultpendingRPLC=$this->adapter->query($qrypendingRPLC,array());
		$resultsetpendingRPLC=$resultpendingRPLC->toArray();
		
		$resultsetRPLC[0]['pending_cntt_t']=$resultsetpendingRPLC[0]['pending_cntt_t'];
		$resultsetRPLC[0]['pending_amnt']=$resultsetpendingRPLC[0]['pending_amnt'];

		  $qrynotes="SELECT t1.cs_name,COUNT(t2.idCustomer) as cus_count FROM customer as t1
			LEFT JOIN credit_notes_all_types as t2 ON t2.idCustomer=t1.idCustomer
			WHERE t1.idCustomer='$idcustomer'";
			$resultnotes=$this->adapter->query($qrynotes,array());
			$resultsetnotes=$resultnotes->toArray();
		

		if ($resultsetRPLC[0]['cntt_t']!=0) 
		{
			$ret_arr=['code'=>'2','status'=>true,'count'=>$resultsetnotes,'content'=>$resultsetRPLC,'message'=>'Data available'];
		}
		else
		{
			 $ret_arr=['code'=>'3','status'=>false,'message'=>'no data available'];
		}
		}
		elseif ($idact==7)  // missing details
		{
			$qryMSNG="SELECT count(idCreditstatusmissing) as cntt_t,sum(approval_amount) as amnt, '0' as pending_cntt_t,'0' as pending_amnt  FROM customer_order_missing_credit_status
			WHERE   credit_date BETWEEN '".date('Y-m-d',strtotime($_REQUEST['dmg_frmDate']))."' AND '".date('Y-m-d',strtotime($_REQUEST['dmg_toDate']. ' +1 day'))."'  AND approval_amount!=0.00 AND idCustomer='$idcustomer'";
		$resultMSNG=$this->adapter->query($qryMSNG,array());
		$resultsetMSNG=$resultMSNG->toArray();

		$qrypendingMSNG="SELECT count(idCreditstatusmissing) as pending_cntt_t,sum(approval_amount) as pending_amnt  FROM customer_order_missing_credit_status
			WHERE   credit_date BETWEEN '".date('Y-m-d',strtotime($_REQUEST['dmg_frmDate']))."' AND '".date('Y-m-d',strtotime($_REQUEST['dmg_toDate']. ' +1 day'))."' AND credit_status='1'    AND approval_amount!=0.00 AND idCustomer='$idcustomer'";
		$resultpendingMSNG=$this->adapter->query($qrypendingMSNG,array());
		$resultsetpendingMSNG=$resultpendingMSNG->toArray();
		
		$resultsetMSNG[0]['pending_cntt_t']=$resultsetpendingMSNG[0]['pending_cntt_t'];
		$resultsetMSNG[0]['pending_amnt']=$resultsetpendingMSNG[0]['pending_amnt'];

		  $qrynotes="SELECT t1.cs_name,COUNT(t2.idCustomer) as cus_count FROM customer as t1
			LEFT JOIN credit_notes_all_types as t2 ON t2.idCustomer=t1.idCustomer
			WHERE t1.idCustomer='$idcustomer'";
			$resultnotes=$this->adapter->query($qrynotes,array());
			$resultsetnotes=$resultnotes->toArray();
		

		if ($resultsetRPLC[0]['cntt_t']!=0) 
		{
			$ret_arr=['code'=>'2','status'=>true,'count'=>$resultsetnotes,'content'=>$resultsetMSNG,'message'=>'Data available'];
		}
		else
		{
			 $ret_arr=['code'=>'3','status'=>false,'message'=>'no data available'];
		}
		}

		return $ret_arr;
}

public function getgenarateRDRMAmount($param)
{
	if($param->action=='list'){

		$idcustomer=$param->id;
		$actid=$param->idact;
		$frmdate=$param->frmdate;
		$todate=$param->todate;
		

   if ($actid==4) 
   {
   	 $qryRTN="SELECT * from customer_order_return_credit_status AS a
						LEFT JOIN customer AS b ON a.idCustomer=b.idCustomer
						WHERE a.credit_date BETWEEN '".date('Y-m-d',strtotime($frmdate))."' AND '".date('Y-m-d',strtotime($todate. ' +1 day'))."' AND a.approval_amount!=0.00 AND a.idCustomer='$idcustomer'";
						
		$resultRTN=$this->adapter->query($qryRTN,array());
		$resultsetRTN=$resultRTN->toArray();
		
		if ($resultsetRTN) 
		{
			$ret_arr=['code'=>'2','status'=>true,'content'=>$resultsetRTN,'message'=>'Data available'];
		}
		else
		{
			 $ret_arr=['code'=>'3','status'=>false,'message'=>'no data available'];
		}
   }
   else if ($actid==5) 
   {
   	 $qryRTN="SELECT * from customer_order_damage_credit_status AS a
						LEFT JOIN customer AS b ON a.idCustomer=b.idCustomer
						WHERE a.credit_date BETWEEN '".date('Y-m-d',strtotime($frmdate))."' AND '".date('Y-m-d',strtotime($todate. ' +1 day'))."'  AND a.approval_amount!=0.00 AND a.idCustomer='$idcustomer'";
		$resultRTN=$this->adapter->query($qryRTN,array());
		$resultsetRTN=$resultRTN->toArray();
		if (count($resultsetRTN)>0) 
		{
			$ret_arr=['code'=>'2','status'=>true,'content'=>$resultsetRTN,'message'=>'Data available'];
		}
		else
		{
			 $ret_arr=['code'=>'3','status'=>false,'message'=>'no data available'];
		}
   }
    else if ($actid==6) 
   {
   	 $qryRTN="SELECT * from customer_order_replace_credit_status AS a
						LEFT JOIN customer AS b ON a.idCustomer=b.idCustomer
						WHERE a.credit_date BETWEEN '".date('Y-m-d',strtotime($frmdate))."' AND '".date('Y-m-d',strtotime($todate. ' +1 day'))."'  AND a.approval_amount!=0.00 AND a.idCustomer='$idcustomer'";
		$resultRTN=$this->adapter->query($qryRTN,array());
		$resultsetRTN=$resultRTN->toArray();
		if (count($resultsetRTN)>0) 
		{
			$ret_arr=['code'=>'2','status'=>true,'content'=>$resultsetRTN,'message'=>'Data available'];

		}
		else
		{
			 $ret_arr=['code'=>'3','status'=>false,'message'=>'no data available'];
		}
   }
    else if ($actid==7) 
   {
   	 $qryRTN="SELECT * from customer_order_missing_credit_status AS a
						LEFT JOIN customer AS b ON a.idCustomer=b.idCustomer
						WHERE a.credit_date BETWEEN '".date('Y-m-d',strtotime($frmdate))."' AND '".date('Y-m-d',strtotime($todate. ' +1 day'))."'  AND a.approval_amount!=0.00  AND a.idCustomer='$idcustomer'";
		$resultRTN=$this->adapter->query($qryRTN,array());
		$resultsetRTN=$resultRTN->toArray();
		if (count($resultsetRTN)>0) 
		{
			$ret_arr=['code'=>'2','status'=>true,'content'=>$resultsetRTN,'message'=>'Data available'];
		}
		else
		{
			 $ret_arr=['code'=>'3','status'=>false,'message'=>'no data available'];
		}
   }
}
else if ($param->action=='add') 
   {
			$customer=$param->customer;
			$amount=$param->amount;
			$credit_note=$param->credit_note;
			$creditid=$param->creditid;
			$actId=$param->actId;
			
			//Insert Data
				if($actId==4){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {

					for($i=0;$i<count($customer);$i++){
						$datainsert['idCustomer']=$customer[$i];
						$datainsert['credit_note']=$credit_note[$i];
						$datainsert['credit_amnt']=$amount[$i];
						$datainsert['credit_date']=date('Y-m-d H:i:s');
						$datainsert['type']=4;
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
				} else if($actId==5){
					$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {

					for($i=0;$i<count($customer);$i++){
						$datainsert['idCustomer']=$customer[$i];
						$datainsert['credit_note']=$credit_note[$i];
						$datainsert['credit_amnt']=$amount[$i];
						$datainsert['credit_date']=date('Y-m-d H:i:s');
						$datainsert['type']=5;
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

				}else if($actId==6){
					$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {

					for($i=0;$i<count($customer);$i++){
						$datainsert['idCustomer']=$customer[$i];
						$datainsert['credit_note']=$credit_note[$i];
						$datainsert['credit_amnt']=$amount[$i];
						$datainsert['credit_date']=date('Y-m-d H:i:s');
						$datainsert['type']=6;
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

				}else if($actId==7){
					$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {

					for($i=0;$i<count($customer);$i++){
						$datainsert['idCustomer']=$customer[$i];
						$datainsert['credit_note']=$credit_note[$i];
						$datainsert['credit_amnt']=$amount[$i];
						$datainsert['credit_date']=date('Y-m-d H:i:s');
						$datainsert['type']=7;
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

				}


				    //update data
				    if($actId==4){
				    $this->adapter->getDriver()->getConnection()->beginTransaction();
				    try {

					for($i=0;$i<count($creditid);$i++){
					$dataupdate['credit_status']=2;
					$sql = new Sql($this->adapter );
					$update = $sql->update();
					$update->table('customer_order_return_credit_status');
					$update->set($dataupdate);
					$update->where( array('idCreditstatusreturn' => $creditid));
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
				 }else  if($actId==5){
				    $this->adapter->getDriver()->getConnection()->beginTransaction();
				    try {

					for($i=0;$i<count($creditid);$i++){
					$dataupdate['credit_status']=2;
					$sql = new Sql($this->adapter );
					$update = $sql->update();
					$update->table('customer_order_damage_credit_status');
					$update->set($dataupdate);
					$update->where( array('idCreditstatusdamage' => $creditid));
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
				 }else  if($actId==6){
				    $this->adapter->getDriver()->getConnection()->beginTransaction();
				    try {

					for($i=0;$i<count($creditid);$i++){
					$dataupdate['credit_status']=2;
					$sql = new Sql($this->adapter );
					$update = $sql->update();
					$update->table('customer_order_replace_credit_status');
					$update->set($dataupdate);
					$update->where( array('idCreditstatusreplace' => $creditid));
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
				 }else  if($actId==7){
				    $this->adapter->getDriver()->getConnection()->beginTransaction();
				    try {

					for($i=0;$i<count($creditid);$i++){
					$dataupdate['credit_status']=2;
					$sql = new Sql($this->adapter );
					$update = $sql->update();
					$update->table('customer_order_missing_credit_status');
					$update->set($dataupdate);
					$update->where( array('idCreditstatusmissing' => $creditid));
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
			 
		    }
   	return $ret_arr;  
	}
     public function getInvoiceNo($param)
	{
         
	    $qryInvoiceno="SELECT DC.idDispatchcustomer,DC.invoiceNo,DC.idCustomer FROM dispatch_customer as DC LEFT JOIN dispatch_vehicle as DV ON DV.idCustomer=DC.idCustomer WHERE DC.invoiceNo NOT IN(Select invoice from invoice_status) GROUP BY DC.invoiceNo ";
		$resultInvoiceno=$this->adapter->query($qryInvoiceno,array());
		$resultsetInvoiceno=$resultInvoiceno->toArray();
		if (count($resultsetInvoiceno)>0) 
		{
			$ret_arr=['code'=>'2','status'=>true,'content'=>$resultsetInvoiceno,'message'=>'Data available'];
		}
		else
		{
			 $ret_arr=['code'=>'3','status'=>false,'message'=>'no data available'];
		}  
		return $ret_arr;
	}
	public function invoiceRemarkadd($param)
	{
        
				$id=$param->id;
				$invoice=$param->invoice;
				$invoicedate=date('Y-m-d',strtotime($param->invoicedate));
				$errtype=($param->errtype)?implode(',', $param->errtype):'';
				$remark=$param->remark;
                 $idcustomer=$param->idcustomer;
           
					$qryInvoice="select invoiceNo from invoice_details where invoiceNo='$invoice'";
					$resultInvoice=$this->adapter->query($qryInvoice,array());
					$resultsetInvoice=$resultInvoice->toArray();
					if($resultsetInvoice[0]['invoiceNo']!='')
						{ 
                             
							$qryInvoicestatus="select invoice from invoice_status where invoice='$invoice'";
							$resultInvoicestatus=$this->adapter->query($qryInvoicestatus,array());
							$resultsetInvoicestatus=$resultInvoicestatus->toArray();
							if($resultsetInvoicestatus[0]['invoice']=='')
								{
									$this->adapter->getDriver()->getConnection()->beginTransaction();
									try {

									$datainsert['idCustomer']=$idcustomer;
									$datainsert['invoice']=$invoice;
									$datainsert['invoice_date']=$invoicedate;
									$datainsert['error_list']=$errtype;
									// $datainsert['credit_date']=$errtype;
									$datainsert['remarks']=$remark;
                                    	
									$insert=new Insert('invoice_status');
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
							    	$ret_arr=['code'=>'1','status'=>false,'message'=>'Already exist..'];
							    }
						}
						else
						{
						  $ret_arr=['code'=>'1','status'=>false,'message'=>'Invoice number not available..'];	
						}
				
               
               return $ret_arr;
	}

	public function invoiceRemarkview($param)
	{
      
     
		$qryInvoicestatus="SELECT inv.idInvoice,inv.idCustomer,inv.idLevel,inv.invoice,inv.credit_amt,inv.credit_status,DATE_FORMAT(inv.credit_date, '%d-%m-%Y') as credit_date,DATE_FORMAT(inv.invoice_date, '%d-%m-%Y') as invoice_date,inv.error_list,remarks from invoice_status as inv";
		$resultInvoicestatus=$this->adapter->query($qryInvoicestatus,array());
		$resultsetInvoicestatus=$resultInvoicestatus->toArray();
		if (count($resultsetInvoicestatus)>0) 
		{
			$ret_arr=['code'=>'2','status'=>true,'content'=>$resultsetInvoicestatus,'message'=>'Data available'];
		}
		else
		{
             $ret_arr=['code'=>'1','status'=>false,'message'=>'data not available..'];	
		}
		return $ret_arr;
	}

	public function invoicestatusview($param)
	{
     
			$id=$param->id;
			//get invoice data
			$qryInvoicestatus="SELECT invs.idCustomer,invs.invoice,invs.invoice_date,c.idCustomer,c.cs_name,dc.idOrder,ord.poNumber,dc.idOrderallocate,'0' as product,dc.idDispatchcustomer,ord.idCustthierarchy,c.cs_type,'0' as overallAmount,'0' as overalltax,'0' as grandtotal,'0' as a_ttltax,'0' as a_ttlamount, '0' as a_grandtotal FROM `invoice_status` as invs LEFT JOIN customer as c on c.idCustomer=invs.idCustomer LEFT JOIN dispatch_customer as dc on dc.idCustomer=invs.idCustomer LEFT JOIN orders as ord on ord.idOrder=dc.idOrder WHERE invs.idInvoice='$id' GROUP BY invs.idInvoice";
			$resultInvoicestatus=$this->adapter->query($qryInvoicestatus,array());
			$resultsetInvoicestatus=$resultInvoicestatus->toArray();
			
			$idterritory=$resultsetInvoicestatus[0]['idCustthierarchy'];
			$invoiceNo=$resultsetInvoicestatus[0]['invoice'];
			$idorderallocated=$resultsetInvoicestatus[0]['idOrderallocate'];
			$iddispatchcustomer=$resultsetInvoicestatus[0]['idDispatchcustomer'];
			$idcustomertype=$resultsetInvoicestatus[0]['cs_type'];
             //get dispatch customer data
			$qryDispatch="SELECT DC.*, CS.cs_name FROM dispatch_customer AS DC
							LEFT JOIN customer AS CS ON DC.idCustomer=CS.idCustomer WHERE DC.invoiceNo='$invoiceNo'";
			$resultDispatch=$this->adapter->query($qryDispatch,array());
			$resultsetDispatch=$resultDispatch->toArray();

                 //get dispatch product data
				$qryProduct="SELECT dp.idDispatchProduct,
				prd.idProduct,
				prd.productName,
				prd.productCount,
				prd.productUnit,
				ps.productSize,
				ps.idProductsize,
				pp.primarypackname,
				ordi.picklistQty,
				'0' as offer,
				'0' as price,
				'0' as taxpercent ,
				'0' as ttlprice,
				'0' as discount,
			    '0' as netamount,
			    '0' as taxamount,
			    '0' as a_qty,
			    '0' as a_price,
			    '0' as a_taxpercent,
			    '0' as a_taxamount,
			    '0' as a_discount,
			    '0' as a_ttlprice,
			    '0' as a_netamount,
			    '0' as a_changeamount
			     FROM 
				dispatch_product as dp LEFT JOIN product_details as prd ON prd.idProduct=dp.idProduct 
				LEFT JOIN product_size as ps ON ps.idProductsize=dp.idProdSize 
				LEFT JOIN primary_packaging as pp ON pp.idPrimaryPackaging=ps.idPrimaryPackaging 
				LEFT JOIN orders_allocated_items as ordi ON ordi.idOrderallocated='$idorderallocated' AND ordi.idProduct=dp.idProduct AND ordi.idProductsize=dp.idProdSize AND ordi.idOrderallocateditems=dp.idOrderItem WHERE dp.idDispatchcustomer='$iddispatchcustomer'";
			$resultProduct=$this->adapter->query($qryProduct,array());
			$resultsetProduct=$resultProduct->toArray();
			$subTotal=array();
			$taxtotAry=array();
			$totDisCnt=array();
			for ($i=0; $i < count($resultsetProduct); $i++) 
			{ 
				   // stock qty for correspanding dispatch product id in dispatch_product_batch table
				$qrydataItm="SELECT DPB.idWhStockItem, DPB.qty,WSI.idProduct, WSI.idProdSize ,WSI.sku_mf_date, DATE_FORMAT
				(WSI.sku_mf_date ,'%b %d %Y %h:%i:%s') AS entryDate
				FROM dispatch_product_batch AS DPB
				RIGHT JOIN whouse_stock_items AS WSI ON DPB.idWhStockItem=WSI.idWhStockItem
				WHERE DPB.idDispatchProduct=".$resultsetProduct[$i]['idDispatchProduct']."";
				$resultdataItm=$this->adapter->query($qrydataItm,array());
				$resultsetdataItm=$resultdataItm->toArray();

				$priceTotal=array();
				$totCommision=array();
				$disAmnt=0;
				for($cont=0;$cont<$uCnt=count($dataItm);$cont++)
				{
					//get price of the product
					$qryPrice="SELECT priceDate as effect_date, priceAmount as prod_price FROM price_fixing WHERE idProduct=".$dataItm[$cont]['idProduct']." AND idProductsize=".$dataItm[$cont]['idProdSize']." AND idTerritory=".$idterritory." AND priceDate<='".$dataItm[$cont]['sku_mf_date']."' ORDER BY priceDate DESC LIMIT 1";
				$resultPrice=$this->adapter->query($qryPrice,array());
				$resultsetPrice=$resultPrice->toArray();

						if($getPrdctList[$iCont]['offer']!=1){
						$proPrice=$dataItm[$cont]['qty']*$resultsetPrice[0]['prod_price'];
						}else{
						$proPrice=0;
						}
									
									array_push($priceTotal,number_format($proPrice, 2, '.', ''));
                 $resultsetProduct[$i]['price']=$proPrice;
			
				$qryCommission="SELECT sum(distributn_unit) as cmsn_unit_val,sum(distributn_percent) as cmsn_percent_val FROM distribution_margin WHERE idCustomerType>='".$idcustomertype."' AND idProduct='".$dataItm[$cont]['idProduct']."' AND idProductsize='".$dataItm[$cont]['idProdSize']."' and idTerritory='".$idterritory."' and distributn_date<='".date('Y-m-d',strtotime($dataItm[$cont]['sku_mf_date']))."' ORDER BY idDistributionMargin DESC LIMIT ";
				$resultCommission=$this->adapter->query($qryCommission,array());
				$resultsetCommission=$resultCommission->toArray();

				if($getPrdctList[$iCont]['offer']!=1)
				{
				$cmsnTot=$dataItm[$cont]['qty']*$resultsetCommission[0]['cmsn_unit_val']+number_format($proPrice, 2, '.', '')*$resultsetCommission[0]['cmsn_percent_val']/100;
				}else{
				$cmsnTot=0;
				}

				array_push($totCommision,number_format($cmsnTot, 2, '.', ''));
                
				}

                 

				$totCommission=number_format(array_sum($totCommision), 2, '.', '');
								$grandProdTotal=number_format(array_sum($priceTotal), 2, '.', '');
									
								
								if($getDispatchList[$i]['rplc_misg_refrence']==0){
									$priceAmnt=$grandProdTotal-$totCommission;
								}else{
									$priceAmnt=0;
								}
									
									
								array_push($subTotal,number_format($priceAmnt, 2, '.', ''));

			}

			$resultsetInvoicestatus[0]['product']=$resultsetProduct;

		if (count($resultsetInvoicestatus)>0) 
		{
			$ret_arr=['code'=>'2','status'=>true,'content'=>$resultsetInvoicestatus,'message'=>'Data available'];
		}
		else
		{
             $ret_arr=['code'=>'1','status'=>false,'message'=>'data not available..'];	
		}
		return $ret_arr;
	}

	public function invoicenewAdd($param)
	{
		
		$data=$param->datas;
	
		$idinvoice=$param->idinvoice;

		
                 for ($i=0; $i < count($data['product']); $i++) 
                 { 
					$this->adapter->getDriver()->getConnection()->beginTransaction();
					try {


								$invoicenewinsert['idInvoice']=$idinvoice;
								$invoicenewinsert['idDispatchProduct']=$data['product'][$i]['idDispatchProduct'];
								$invoicenewinsert['b_qty']=$data['product'][$i]['picklistQty'];
								$invoicenewinsert['a_qty']=$data['product'][$i]['a_qty'];
								$invoicenewinsert['b_price']=$data['product'][$i]['price'];
								$invoicenewinsert['a_price']=$data['product'][$i]['a_price'];
								$invoicenewinsert['b_tax']=$data['product'][$i]['taxpercent'];
								$invoicenewinsert['a_tax']=$data['product'][$i]['a_taxpercent'];
								$invoicenewinsert['b_tax_amnt']=$data['product'][$i]['taxamount'];
								$invoicenewinsert['a_tax_amnt']=$data['product'][$i]['a_taxamount'];
								$invoicenewinsert['b_tot_amnt']=$data['product'][$i]['ttlprice'];
								$invoicenewinsert['a_tot_amnt']=$data['product'][$i]['a_ttlprice'];
								$invoicenewinsert['b_dis_amnt']=$data['product'][$i]['discount'];
								$invoicenewinsert['a_dis_amnt']=$data['product'][$i]['a_discount'];
								$invoicenewinsert['b_net_amnt']=$data['product'][$i]['netamount'];
								$invoicenewinsert['a_net_amnt']=$data['product'][$i]['a_netamount'];
								$invoicenewinsert['change_price']=$data['product'][$i]['a_changeamount'];
                                    	
									$insert=new Insert('invoice_status_list');
									$insert->values($invoicenewinsert);
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
						
						$this->adapter->getDriver()->getConnection()->beginTransaction();
			try{
				$dataupdate['credit_status']=1;
				$sql = new Sql($this->adapter);
				$update = $sql->update();
				$update->table('invoice_status');
				$update->set($dataupdate);
				$update->where(array('idInvoice' => $idinvoice));
				$statement  = $sql->prepareStatementForSqlObject($update);
				$results    = $statement->execute();
				$ret_arr=['code'=>'2','status'=>true,'message'=>'Added successfully'];
				$this->adapter->getDriver()->getConnection()->commit();
			} catch(\Exception $e) {
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
				$this->adapter->getDriver()->getConnection()->rollBack();
			}		  

      return $ret_arr;
	}

	public function transportClaimlist($param)
	{
		
       	$idcustomer=$param->customer;		
		$frmdate=$param->startdate;
		$todate=$param->enddate;

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
'0' as ttlinvoiceAmount,
'0' as ttlperkmamount,vm.vehicleMinCharge
		FROM dispatch_vehicle as dv 
		LEFT JOIN dispatch_customer as dc on dc.idDispatchVehicle=dv.idDispatchVehicle
		LEFT JOIN dispatch_product as dp on dp.idDispatchcustomer=dc.idDispatchcustomer
		LEFT JOIN dispatch_product_batch as dpb on dpb.idDispatchProduct=dp.idDispatchProduct
		LEFT JOIN vehicle_master as vm on vm.idVehicle=dv.idVechileType 
		LEFT JOIN customer as c on c.idCustomer=dv.idCustomer  WHERE dv.idCustomer='$idcustomer' AND dv.deliveryDate BETWEEN '".date('Y-m-d',strtotime($frmdate))."' AND '".date('Y-m-d',strtotime($todate. ' +1 day'))."' AND dv.creditnote_status=0
		GROUP BY dv.idDispatchVehicle";

		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();

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

        }

	   if($resultset){

		$ret_arr=['code'=>'1','status'=>true,'message'=>'Data available','content' =>$resultset];
		
		}else {
			$ret_arr=['code'=>'2','status'=>false,'message'=>'parameter missing, try again!!!'];
		}
 return $ret_arr;
	}

	public function getPOnumber($param)
	{
	     $userData=$param->userData;
	     $idCustomer=$userData['idCustomer'];
			$qryPONO="SELECT poNumber,idOrder,poDate FROM `orders` WHERE idCustomer=?";
			$resultPONO=$this->adapter->query($qryPONO,array($idCustomer));
			$resultsetPONO=$resultPONO->toArray();
			if (count($resultsetPONO)>0)
			 {
				$ret_arr=['code'=>'1','status'=>true,'message'=>'Data available','content' =>$resultsetPONO];
			 }
			 else
			 {
			 	$ret_arr=['code'=>'2','status'=>false,'message'=>'parameter missing, try again!!!'];
			 }

			 return $ret_arr;

	}

	public function getInvcno($param)
	{
		
            $idorder=$param->idorder;
			$qryInvoiceno="SELECT dv.idDispatchVehicle,dv.vehicleNo,dv.dc_no,dv.idCustomer,dc.idWarehouse,dc.idOrder,dc.invoiceNo,ord.poNumber,ord.poDate FROM `dispatch_vehicle` as dv LEFT JOIN dispatch_customer as dc ON dc.idDispatchVehicle=dv.idDispatchVehicle LEFT JOIN orders as ord ON ord.idOrder=dc.idOrder WHERE dc.idOrder='$idorder'";
			$resultInvoiceno=$this->adapter->query($qryInvoiceno,array());
			$resultsetInvoiceno=$resultInvoiceno->toArray();
			if (count($resultsetInvoiceno)>0)
			 {
				$ret_arr=['code'=>'1','status'=>true,'message'=>'Data available','content' =>$resultsetInvoiceno];
			 }
			 else
			 {
			 	$ret_arr=['code'=>'2','status'=>false,'message'=>'parameter missing, try again!!!'];
			 }

			 return $ret_arr;
	}

	public function getInvoiceproduct($param)
	{
      $iddispatchvehicle=$param->iddispatchvehicle;

       $qryProduct="SELECT dv.idDispatchVehicle, 
       dv.vehicleNo, 
       dv.dc_no, 
       dv.idCustomer, 
       dc.idWarehouse, 
       dc.idOrder, 
       dc.invoiceNo, 
       dp.idProduct, 
       dp.idProdSize,
       dp.dis_Qty,
       pd.productName,
       pd.productCount,
       ps.productSize,
       ps.productPrimaryCount,
       pp.primarypackname,
       dpb.qty as pick_qty,
       dpb.qty as current_accept_qty,
	dpb.qty as current_supply_qty,
	'' as recievedEarly,
       ordi.orderQty as poQty,
       dp.idOrderItem,
       dpb.idWhStockItem,
       ord.poNumber,
       '' as pending_Qty,
		'' as reject_Qty,
		'' as sku_mf_date,
		'' as sku_expiry_date,
		'' as sku_batch_no,
		'' as sku_comments,
		'' as idWhStock,
		'' as idFactryOrdItem,
		dpb.idWhStockItem as idWhStockItem,
		'' as idFactory
       FROM `dispatch_vehicle` as dv 
       LEFT JOIN dispatch_customer as dc ON dc.idDispatchVehicle=dv.idDispatchVehicle 
       LEFT JOIN dispatch_product as dp ON dp.idDispatchcustomer=dc.idDispatchcustomer
       LEFT JOIN dispatch_product_batch as dpb ON dpb.idDispatchProduct=dp.idDispatchProduct
       LEFT JOIN order_items as ordi ON ordi.idOrderitem=dp.idOrderItem
       LEFT JOIN orders as ord ON ord.idOrder=ordi.idOrder
       LEFT JOIN product_details as pd on pd.idProduct=dp.idProduct
       LEFT JOIN product_size as ps on ps.idProductsize=dp.idProdSize
       LEFT JOIN primary_packaging as pp on pp.idPrimaryPackaging=ps.idPrimaryPackaging
       WHERE dv.idDispatchVehicle='$iddispatchvehicle' ";
      
			$resultProduct=$this->adapter->query($qryProduct,array());
			$resultsetProduct=$resultProduct->toArray();
			$finalproduct=array();
			$poQtysum=0;
			$earlyrecievedsum=0;
			for ($i=0; $i < count($resultsetProduct); $i++) 
			{ 
                 $idorder=$resultsetProduct[$i]['idOrder'];
				$idProduct=$resultsetProduct[$i]['idProduct'];
				$idProductsize=$resultsetProduct[$i]['idProdSize'];
				$poNumber=$resultsetProduct[$i]['poNumber'];
				$idWhStockItem=$resultsetProduct[$i]['idWhStockItem'];
				// $qryPickqty="SELECT opi.pickQty,
				// opi.pickQty as current_accept_qty,
				// opi.pickQty as current_supply_qty,
				// '' as recievedEarly,
				// pd.productName,
				// pd.idProduct,
				// pd.productCount,
				// ps.productSize,
				// ps.idProductsize,
				// ps.productPrimaryCount,
				// pp.primarypackname,
				// '' as pending_Qty,
				// '' as reject_Qty,
				// '' as sku_mf_date,
				// '' as sku_expiry_date,
				// '' as sku_batch_no,
				// '' as sku_comments,
				// '' as idWhStock,
				// '' as idFactryOrdItem,
				// '' as idWhStockItem,
				// '' as idFactory,
				// '' as poQty
				// FROM order_picklist_items as opi 
				// LEFT JOIN product_details as pd ON pd.idProduct=opi.idProduct
				// LEFT JOIN product_size as ps ON ps.idProductsize=opi.idProdSize
				// LEFT JOIN primary_packaging as pp ON pp.idPrimaryPackaging=ps.idPrimaryPackaging
				// WHERE opi.idOrder='$idorder' AND opi.idProduct='$idProduct' AND opi.idProdSize='$idProductsize'";
				// $resultPickqty=$this->adapter->query($qryPickqty,array());
				// $resultsetPickqty=$resultPickqty->toArray();

				$qryStock="	SELECT 
				wsi.sku_accept_qty, 
				DATE_FORMAT(wsi.sku_mf_date,'%d-%m-%Y') as sku_mf_date, 
				DATE_FORMAT(wsi.sku_expiry_date,'%d-%m-%Y') as sku_expiry_date, 
				wsi.sku_batch_no, 
				wsi.sku_comments,
				foi.idFactryOrdItem,
				fo.idFactory,
				ws.idWhStock,
				wsi.idWhStockItem
				FROM  whouse_stock_items as wsi 
				LEFT JOIN whouse_stock as ws ON ws.idWhStock=wsi.idWhStock
				LEFT JOIN factory_order_items as foi ON foi.idFactryOrdItem=wsi.idFactryOrdItem
				LEFT JOIN factory_order as fo ON fo.idFactoryOrder=foi.idFactoryOrder WHERE wsi.idWhStockItem='$idWhStockItem'";
				$resultStock=$this->adapter->query($qryStock,array());
				$resultsetStock=$resultStock->toArray();
				
				$resultsetProduct[$i]['sku_mf_date']=$resultsetStock[0]['sku_mf_date'];
				$resultsetProduct[$i]['sku_expiry_date']=$resultsetStock[0]['sku_expiry_date'];
				$resultsetProduct[$i]['sku_batch_no']=$resultsetStock[0]['sku_batch_no'];
				$resultsetProduct[$i]['sku_comments']=$resultsetStock[0]['sku_comments'];
				$resultsetProduct[$i]['idWhStock']=$resultsetStock[0]['idWhStock'];
				$resultsetProduct[$i]['idFactryOrdItem']=$resultsetStock[0]['idFactryOrdItem'];
				$resultsetProductresultsetProduct[$i]['idWhStockItem']=$resultsetStock[0]['idWhStockItem'];
				$resultsetProduct[$i]['idFactory']=$resultsetStock[0]['idFactory'];
                $resultsetProduct[$i]['poQty']=$resultsetProduct[$i]['poQty'];
                
				// $resultsetPickqty[0]['sku_mf_date']=$resultsetStock[0]['sku_mf_date'];
				// $resultsetPickqty[0]['sku_expiry_date']=$resultsetStock[0]['sku_expiry_date'];
				// $resultsetPickqty[0]['sku_batch_no']=$resultsetStock[0]['sku_batch_no'];
				// $resultsetPickqty[0]['sku_comments']=$resultsetStock[0]['sku_comments'];
				// $resultsetPickqty[0]['idWhStock']=$resultsetStock[0]['idWhStock'];
				// $resultsetPickqty[0]['idFactryOrdItem']=$resultsetStock[0]['idFactryOrdItem'];
				// $resultsetPickqty[0]['idWhStockItem']=$resultsetStock[0]['idWhStockItem'];
				// $resultsetPickqty[0]['idFactory']=$resultsetStock[0]['idFactory'];
    //             $resultsetPickqty[0]['poQty']=$resultsetProduct[$i]['poQty'];
                 $qryAlreadyrecieved="SELECT wsi.idWhStockItem,
wsi.idWhStock,
wsi.idCustomer,
wsi.idLevel,
wsi.idProduct,
wsi.idProdSize,
wsi.offer,
wsi.offer_join_id,
wsi.idWarehouse,
wsi.idFactryOrdItem,
sum(wsi.sku_accept_qty) as sku_accept_qty,
wsi.sku_current_supply,
wsi.sku_reject_qty,
wsi.sku_pending_qty,
wsi.sku_mf_date,
wsi.sku_expiry_date,
wsi.sku_batch_no,
wsi.sku_comments 
FROM 
whouse_stock_items as wsi LEFT JOIN 
whouse_stock as ws ON ws.idWhStock=wsi.idWhStock 
LEFT JOIN factory_order_items as foi ON foi.idFactryOrdItem=wsi.idFactryOrdItem 
LEFT JOIN factory_order as fo ON fo.idFactoryOrder=foi.idFactoryOrder 
WHERE ws.po_no='$poNumber' AND wsi.idProduct='$idProduct' AND wsi.idProdSize='$idProductsize'";
				
	$resultAlreadyrecieved=$this->adapter->query($qryAlreadyrecieved,array());
			$resultsetAlreadyrecieved=$resultAlreadyrecieved->toArray();
	
			$resultsetProduct[$i]['recievedEarly']=($resultsetAlreadyrecieved[0]['sku_accept_qty'])?$resultsetAlreadyrecieved[0]['sku_accept_qty']:'';

$resultsetProduct[$i]['current_accept_qty']=$resultsetProduct[$i]['current_accept_qty']-$resultsetProduct[$i]['recievedEarly'];


// $resultsetPickqty[0]['recievedEarly']=($resultsetAlreadyrecieved[0]['sku_accept_qty'])?$resultsetAlreadyrecieved[0]['sku_accept_qty']:'';

// $resultsetPickqty[0]['current_accept_qty']=$resultsetPickqty[0]['current_accept_qty']-$resultsetPickqty[0]['recievedEarly'];

			for ($j=0; $j <count($resultsetPickqty) ; $j++) 
			{ 
				$resultsetPickqty[$j]['poQty']=$resultsetProduct[$i]['poQty'];
              	array_push($finalproduct, $resultsetPickqty[$j]);
			}
			
			

             // $resultsetProduct[$i]['pick_qty']=$resultsetPickqty;
              $poQtysum=$poQtysum+$resultsetProduct[$i]['poQty'];
              $earlyrecievedsum=$earlyrecievedsum+$resultsetPickqty[0]['recievedEarly'];

				
			}
			$updatebtn=0;
			if ($poQtysum==$earlyrecievedsum) 
			{
				$updatebtn=1;
			}
			else
			{
				$updatebtn=0;
			}
		

			if (count($resultsetProduct)>0)
			 {
				$ret_arr=['code'=>'1','status'=>true,'message'=>'Data available','content' =>$finalproduct,'data'=>$resultsetProduct,'btnstatus'=>$updatebtn];
			 }
			 else
			 {
			 	$ret_arr=['code'=>'2','status'=>false,'message'=>'parameter missing, try again!!!'];
			 }

			 return $ret_arr;

	}

	public function addCustomermeterial($param)
	{

		$product=$param->product;
		$dataWS=$param->topData;
		$customer=$param->customer;
		$idCustomer=$customer[0]['idCustomer'];
		$usertype=$param->usertype;
		$userid=$param->id;
		$factoryId=$product[0]['idFactory'];
       // $idwhstock=$product[0]['idWhStock'];
		$this->adapter->getDriver()->getConnection()->beginTransaction();
		try {
			$whstockinsert['idCustomer']=$idCustomer;
			$whstockinsert['idLevel']=$usertype;
			$whstockinsert['idWarehouse']=$dataWS['whs'];
			$whstockinsert['idFactory']=$factoryId;
			$whstockinsert['idTpVechile']=$dataWS['vhno'];
			$whstockinsert['grn_no']=$dataWS['grnno'];
			$whstockinsert['dc_no']=$dataWS['dcno'];
			$whstockinsert['invoice_no']=$dataWS['invcno'];
			$whstockinsert['po_no']=$dataWS['pno'];
			$whstockinsert['po_date']=date('Y-m-d',strtotime($dataWS['podate']));
			$whstockinsert['entry_date']=date('Y-m-d',strtotime($dataWS['dates']));
			$whstockinsert['handling_charges']=0;
			$whstockinsert['handling_status']=0;

			$insert=new Insert('whouse_stock');
			$insert->values($whstockinsert);
			$statement=$this->adapter->createStatement();
			$insert->prepareStatement($this->adapter, $statement);
			$insertresult=$statement->execute();
			$idwhstock=$this->adapter->getDriver()->getLastGeneratedValue();


			for ($i=0; $i < count($product); $i++) 
			{ 
                  if ($product[$i]['current_accept_qty']!=0 AND $product[$i]['current_accept_qty']!='' AND $product[$i]['current_accept_qty']!=null) 
                  {
					$whstockiteminsert['idCustomer']=$idCustomer;
					$whstockiteminsert['idLevel']=$usertype;
					$whstockiteminsert['idWhStock']=$idwhstock;
					$whstockiteminsert['idProduct']=$product[$i]['idProduct'];
					$whstockiteminsert['idProdSize']=$product[$i]['idProdSize'];
					$whstockiteminsert['offer']=0;
					$whstockiteminsert['offer_join_id']=0;
					$whstockiteminsert['idWarehouse']=$dataWS['whs'];
					$whstockiteminsert['idFactryOrdItem']=$product[$i]['idFactryOrdItem'];
					$whstockiteminsert['sku_current_supply']=$product[$i]['current_supply_qty'];
					$whstockiteminsert['sku_reject_qty']=$product[$i]['reject_Qty'];
					$whstockiteminsert['sku_accept_qty']=$product[$i]['current_accept_qty'];
					$whstockiteminsert['sku_pending_qty']=$product[$i]['pending_Qty'];
					$whstockiteminsert['sku_mf_date']=($product[$i]['sku_mf_date']!='')?date('Y-m-d',strtotime($product[$i]['sku_mf_date'])):0;
					$whstockiteminsert['sku_expiry_date']=($product[$i]['sku_expiry_date'])?date('Y-m-d',strtotime($product[$i]['sku_expiry_date'])):0;
					$whstockiteminsert['sku_batch_no']=$product[$i]['sku_batch_no'];
					$whstockiteminsert['sku_comments']=$product[$i]['sku_comments'];
					$whstockiteminsert['sku_entry_date']=date('Y-m-d',strtotime($dataWS['dates']));

					$insertWHS=new Insert('whouse_stock_items');
					$insertWHS->values($whstockiteminsert);
					$statementWHS=$this->adapter->createStatement();
					$insertWHS->prepareStatement($this->adapter, $statementWHS);
					$insertresultWHS=$statementWHS->execute();
                  }
				


										
			}

			$qrySlno="SELECT wsi.idProduct,wsi.sku_accept_qty,ps.productPrimaryCount,(wsi.sku_accept_qty*ps.productPrimaryCount) 
					as totalserialno FROM `whouse_stock` as ws LEFT JOIN whouse_stock_items 
					as wsi ON wsi.idWhStock=ws.idWhStock LEFT JOIN product_details as prd on 
					prd.idProduct=wsi.idProduct LEFT JOIN product_size as ps on 
					ps.idProductsize=wsi.idProdSize WHERE ws.idWhStock='$idwhstock' AND prd.productserialNo=1";
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

			$this->adapter->getDriver()->getConnection()->commit();
			$ret_arr=['code'=>'2','status'=>true,'idWhStock'=>$idwhstock,'total'=>$total,'message'=>'Added successfully'];
		} catch (\Exception $e) 
		{
			$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
			$this->adapter->getDriver()->getConnection()->rollBack();
		} 
		return $ret_arr;									
	}


	public function order_status_list($param){

	if($param->action=='list'){	

		$qry="SELECT ors.poNumber as ponumber,ors.idCustomer as customer_id,DATE_FORMAT(ors.poDate,'%d-%m-%Y') as poDate,cr.cs_name as name,ors.idOrderfullfillment,IF(oa.idOrderallocate!='','1','0') as allocate,oa.status as dispatch_status
								FROM orders as ors 
								LEFT JOIN customer as cr ON cr.idCustomer=ors.idCustomer
								LEFT JOIN orders_allocated as oa ON oa.idOrder=ors.idOrder
								WHERE ors.idOrder!='' GROUP BY ors.idOrder";

		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		if(!$resultset){
			$ret_arr=['code'=>'3','content'=>'','status'=>false,'message'=>'Please contact the administrator'];
		} else {
			$ret_arr=['code'=>'1','content'=>$resultset,'status'=>true,'message'=>'Order list'];
		}
		return $ret_arr;
	}
 }


 public function getLogincustomer($param)
 {
 	$userData=$param->userData;
 	$idcustomer=$userData['idCustomer'];
 	$usertype=$userData['user_type'];
 	if ($usertype!=0) 
 	{
 		$qrycustomer="SELECT cus.idCustomer,cus.customer_code,cus.cs_name,cus.G1,cus.G2,cus.G3,cus.G4,cus.G5,cus.G6,cus.G7,cus.G8,cus.G9,cus.G10,cus.cs_tinno,cus.cs_potential_value,cus.cs_type,cus.idPreferredwarehouse,wm.t2,tm.territoryUnion,
geo1.geoValue as h1,
geo2.geoValue as h2,
geo3.geoValue as h3,
geo4.geoValue as h4,
geo5.geoValue as h5,
geo6.geoValue as h6,
geo7.geoValue as h7,
geo8.geoValue as h8,
geo9.geoValue as h9,
geo10.geoValue as h10,
ca.warehouse_ids,
ca.territory_ids,
ca.category_ids,
ca.channel_ids,count(ord.idOrder)+1 as ordcount,c.custType
FROM `customer` as cus  
LEFT JOIN customer_allocation as ca on ca.customer_id=cus.idCustomer
LEFT JOIN customertype as c on c.idCustomerType=cus.cs_type
LEFT JOIN `geography` as geo1 ON geo1.idGeography=cus.G1
LEFT JOIN `geography` as geo2 ON geo2.idGeography=cus.G2
LEFT JOIN `geography` as geo3 ON geo3.idGeography=cus.G3
LEFT JOIN `geography` as geo4 ON geo4.idGeography=cus.G4
LEFT JOIN `geography` as geo5 ON geo5.idGeography=cus.G5
LEFT JOIN `geography` as geo6 ON geo6.idGeography=cus.G6
LEFT JOIN `geography` as geo7 ON geo7.idGeography=cus.G7
LEFT JOIN `geography` as geo8 ON geo8.idGeography=cus.G8
LEFT JOIN `geography` as geo9 ON geo9.idGeography=cus.G9
LEFT JOIN `geography` as geo10 ON geo10.idGeography=cus.G10
LEFT JOIN warehouse_master as wm on wm.idWarehouse=cus.idPreferredwarehouse
LEFT JOIN territory_master as tm on tm.idTerritory=wm.t2
LEFT JOIN orders as ord on ord.idCustomer=cus.idCustomer
WHERE cus.idCustomer=?";
			$resultcustomer=$this->adapter->query($qrycustomer,array($idcustomer));
			$resultsetcustomer=$resultcustomer->toArray();
        
			
            // SELECT idTerritory,territoryValue,territoryUnion FROM `territory_master` WHERE idTerritory IN(2,3,4)
            if(count($resultsetcustomer)>0)
            {

            	$warehouseid = ($resultsetcustomer[0]['warehouse_ids'])?unserialize($resultsetcustomer[0]['warehouse_ids']):'';
			$warehouseidfinal=($warehouseid)?implode(',',$warehouseid):'';
			$territoryid =($resultsetcustomer[0]['territory_ids'])? unserialize($resultsetcustomer[0]['territory_ids']):'';
			$territoryidfinal=($territoryid)?implode(',',$territoryid):'';
			$categoryid = ($resultsetcustomer[0]['category_ids'])?unserialize($resultsetcustomer[0]['category_ids']):'';
			$channel_id = ($resultsetcustomer[0]['channel_ids'])?unserialize($resultsetcustomer[0]['channel_ids']):'';
			if($warehouseidfinal!='')
			{
              $qrywarehouse="SELECT wm.warehouseName,
wm.idWarehouse,
wm.t1,
wm.t2,
wm.t3,
wm.t4,
wm.t5,
wm.t6,
wm.t7,
wm.t8,
wm.t9,
wm.t10,
tm2.territoryUnion as tm2union,
tm1.territoryValue as tm1value,
tm2.territoryValue  as tm2value,
tm3.territoryValue  as tm3value,
tm4.territoryValue  as tm4value,
tm5.territoryValue  as tm5value,
tm6.territoryValue  as tm6value,
tm7.territoryValue  as tm7value,
tm8.territoryValue  as tm8value,
tm9.territoryValue  as tm9value,
tm10.territoryValue  as tm10value
FROM `warehouse_master` as wm 
LEFT JOIN territory_master as tm1 on tm1.idTerritory=wm.t1 
LEFT JOIN territory_master as tm2 on tm2.idTerritory=wm.t2
LEFT JOIN territory_master as tm3 on tm3.idTerritory=wm.t3
LEFT JOIN territory_master as tm4 on tm4.idTerritory=wm.t4
LEFT JOIN territory_master as tm5 on tm5.idTerritory=wm.t5
LEFT JOIN territory_master as tm6 on tm6.idTerritory=wm.t6
LEFT JOIN territory_master as tm7 on tm7.idTerritory=wm.t7
LEFT JOIN territory_master as tm8 on tm8.idTerritory=wm.t8
LEFT JOIN territory_master as tm9 on tm9.idTerritory=wm.t9
LEFT JOIN territory_master as tm10 on tm10.idTerritory=wm.t10
WHERE idWarehouse in($warehouseidfinal)";
			$resultwarehouse=$this->adapter->query($qrywarehouse,array());
			$resultsetwarehouse=$resultwarehouse->toArray();
			}
			else
			{
				$resultsetwarehouse=[];
			}
			
            if($territoryidfinal!='')
            {
               $qryterritory="SELECT idTerritory,territoryValue,territoryUnion FROM `territory_master` WHERE idTerritory IN($territoryidfinal)";
			$resultterritory=$this->adapter->query($qryterritory,array());
			$resultsetterritory=$resultterritory->toArray();
            }
            else
            {
            	$resultsetterritory=[];
            }
			
			if(count($resultsetwarehouse)>0)
			{
               $ret_arr=['code'=>'1','status'=>true,'message'=>' customer records ','content' =>$resultsetcustomer,'warehouse'=>$resultsetwarehouse,'territory'=>$resultsetterritory];
			}
			else
			{
				 $ret_arr=['code'=>'1','status'=>false,'message'=>' Please allocate delivery point to the customer '];
			}
 	}
 	else
 	{
 		 $ret_arr=['code'=>'1','status'=>false,'message'=>' Admin user '];
 	}
      

			
 	}
 	return $ret_arr;
 }


 function Warehousedropdown($param)
 {
       $userData=$param->userData;
       $idCustomer=$userData['idCustomer'];
		if($param->action=='warehouse'){
			$qry="SELECT idWarehouse,warehouseName FROM  warehouse_master a WHERE idCustomer=? AND a.status=1";
			$result=$this->adapter->query($qry,array($idCustomer));
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
				$usertype=$param->user_type;

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

				if($usertype==0){
					$qry="SELECT T3.idProduct,T1.idFactory,T3.productName,T4.productPrimaryCount,T4.productSize,T4.idProductsize,T4.idPrimaryPackaging,T5.primarypackname 
					 	FROM warehouse_products as T1 
						LEFT JOIN factory_products as T2 ON T1.idFactory=T2.idFactory
						LEFT JOIN product_details as T3 ON T3.idProduct=T2.idProduct
		                LEFT JOIN product_size as T4 ON T4.idProduct=T2.idProduct
		                LEFT JOIN primary_packaging as T5 ON T5.idPrimaryPackaging=T4.idPrimaryPackaging
						WHERE T1.idWarehouse='$warehouse_id' AND T3.status=1 AND T4.status=1 GROUP BY idProduct,idProductsize";
					

				$result=$this->adapter->query($qry,array());
			 	$resultset=$result->toArray();  
			 }else{
			 	$qry="SELECT T3.idProduct,T3.productName,T4.productPrimaryCount,T4.productSize,T4.idProductsize,T4.idPrimaryPackaging,T5.primarypackname 
					 	FROM whouse_stock_items as T1 
						LEFT JOIN product_details as T3 ON T3.idProduct=T1.idProduct
		                LEFT JOIN product_size as T4 ON T4.idProduct=T1.idProduct
		                LEFT JOIN primary_packaging as T5 ON T5.idPrimaryPackaging=T4.idPrimaryPackaging
						WHERE T1.idWarehouse='$warehouse_id' AND T3.status=1 AND T4.status=1 GROUP BY idProduct,idProductsize";

				$result=$this->adapter->query($qry,array());
			 	$resultset=$result->toArray();  
			 }

			 	
			 for($i=0;$i<count($resultset);$i++)
			 	{
				 	$all_inventory[$i]['productName']=$resultset[$i]['productName'];
				 	$all_inventory[$i]['productSize']=$resultset[$i]['productSize'];
				 	$all_inventory[$i]['idProductsize']=$resultset[$i]['idProductsize'];
				 	$all_inventory[$i]['primarypackname']=$resultset[$i]['primarypackname'];
				 	$all_inventory[$i]['productPrimaryCount']=$resultset[$i]['productPrimaryCount'];
				 	$all_inventory[$i]['idPrimaryPackaging']=$resultset[$i]['idPrimaryPackaging'];
				 	$all_inventory[$i]['idProduct']=$resultset[$i]['idProduct'];
				 	$all_inventory[$i]['idFactory']=($resultset[$i]['idFactory'])?$resultset[$i]['idFactory']:0;
				 	$all_inventory[$i]['idInventoryNorms']=0;
				 	$all_inventory[$i]['idWarehouse']=0;
				 	$all_inventory[$i]['re_level']='';
				 	$all_inventory[$i]['re_qty']='';
				 	$all_inventory[$i]['re_max_stock']='';
				 	$all_inventory[$i]['re_min_stock']='';
				 	$all_inventory[$i]['re_days']='';
				}
				
                if($resultsetwar)
                {
                	
                
                for ($i=0; $i <count($resultset) ; $i++) { 
               	 $proId=$resultset[$i]['idProduct'];
               	 $sizeId=$resultset[$i]['idProductsize'];
			    $inventoryqry="SELECT T1.idInventoryNorms,T1.idProdSize,T1.idWarehouse,T1.re_level,T1.re_qty,T1.re_max_stock,T1.re_min_stock,T1.re_days FROM inventorynorms as T1
	    		WHERE T1.idWarehouse='$warehouse_id' AND T1.idProdSize='$sizeId' AND T1.idProduct='$proId'";
	    		//echo   $inventoryqry;
	    		
	             $resultinventory=$this->adapter->query($inventoryqry,array());
				 $resultsetinventory=$resultinventory->toArray(); 
				 // print_r($resultsetinventory);
			      	 
			      	$all_inventory[$i]['idInventoryNorms']=$resultsetinventory[0]['idInventoryNorms'];
			 	    $all_inventory[$i]['idWarehouse']=$resultsetinventory[0]['idWarehouse'];
				 	$all_inventory[$i]['re_level']=$resultsetinventory[0]['re_level'];
				 	$all_inventory[$i]['re_qty']=$resultsetinventory[0]['re_qty'];
				 	$all_inventory[$i]['re_max_stock']=$resultsetinventory[0]['re_max_stock'];
				 	$all_inventory[$i]['re_min_stock']=$resultsetinventory[0]['re_min_stock'];
				 	$all_inventory[$i]['re_days']=$resultsetinventory[0]['re_days'];
            
			      
			    
 
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
			$idCustomer=$param->idCustomer;
			$warehouse=$fiedls['warehouse'];
			$inventory_id=$param->inventory;
			$product=$param->product;
			$warid=$param->houseid;
			$level=$param->level;
			$user_type=$param->user_type;
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
					
					for($i=0;$i<count($product);$i++){
						$datainsert['idWarehouse']=$fiedls['warehouse'];
						$datainsert['idProduct']=$product[$i]['idProduct'];
						$datainsert['idProdSize']=$product[$i]['idProductsize'];
						$datainsert['idCustomer']=$idCustomer;
						$datainsert['idLevel']=$user_type;
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
						$datainsert['idProdSize']=$product[$i]['idProductsize'];
						$datainsert['idCustomer']=$idCustomer;
						$datainsert['idLevel']=$user_type;
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


public function getFreeproduct($param)
{
   $idproduct=$param->idproduct;
   $idproductsize=$param->idproductsize;

	$qryProduct="SELECT pd.idProduct,pd.productName,pd.productCount,ps.idProductsize,ps.idPrimaryPackaging,ps.productSize,pp.primarypackname,ps.productPrimaryCount FROM `product_details` as pd 
	LEFT JOIN product_size as ps ON ps.idProduct=pd.idProduct 
	LEFT JOIN primary_packaging as pp ON pp.idPrimaryPackaging=ps.idPrimaryPackaging WHERE pd.idProduct='$idproduct' AND ps.idProductsize='$idproductsize'";
	$resultProduct=$this->adapter->query($qryProduct,array());
	$resultsetProduct=$resultProduct->toArray(); 
	if (count($resultsetProduct)>0) 
	{
		$ret_arr=['code'=>'2','status'=>true,'content'=>$resultsetProduct,'message'=>'Data availble'];
	}
	else
	{
		$ret_arr=['code'=>'2','status'=>false,'message'=>'No data available'];
	}
  return $ret_arr;
}

public function order_allocated_list($param){
	 if($param->action=='list'){	

		$qry="SELECT oa.idOrderallocate as id,oa.idOrder as order_id,ors.poNumber as ponumber,ors.idCustomer as customer_id,ors.poDate as poDate,ors.grandtotalAmount as amount,cr.cs_name as name,st.segmentName,wm.warehouseName,tm.territoryValue,SUM(oai.picklistQty) as pick_qty,oai.rejectQty,oa.status,0 as pastdues
								FROM orders_allocated as oa
								LEFT JOIN orders_allocated_items as oai ON oai.idOrderallocated=oa.idOrderallocate
								LEFT JOIN warehouse_master as wm ON wm.idWarehouse=oa.idWarehouse
								LEFT JOIN orders as ors ON ors.idOrder=oa.idOrder
								LEFT JOIN customer as cr ON cr.idCustomer=ors.idCustomer
								LEFT JOIN segment_type as st ON st.idsegmentType=cr.cs_segment_type
								LEFT JOIN territory_master as tm ON tm.idTerritory=wm.t3 WHERE tm.idTerritoryTitle='3' GROUP BY oa.idOrderallocate";

		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		for ($i=0; $i <count($resultset) ; $i++) 
		{ 
			$qryPaidamount="SELECT sum(payAmt) as paidAmount FROM `invoice_payment` WHERE idCustomer=?";
			$resPaidamount=$this->adapter->query($qryPaidamount,array($resultset[$i]['idCustomer']));
			$resultPaidamount=$resPaidamount->toArray();
			 $paidamount=($resultPaidamount[0]['paidAmount']!=NULL and $resultPaidamount[0]['paidAmount']!='')?$resultPaidamount[0]['paidAmount']:0;
			 $dueAmount=$resultset[$i]['amount']-$paidamount;
			 $resultset[$i]['pastdues']=round($dueAmount,2);
		}

		if(!$resultset){
			$ret_arr=['code'=>'3','content'=>'','status'=>false,'message'=>'Please contact the administrator'];
		} else {
			$ret_arr=['code'=>'1','content'=>$resultset,'status'=>true,'message'=>'Order list'];
		}
		return $ret_arr;
	}
	 if($param->action=='editview'){	
        $editid=$param->id;
		$qry="SELECT oa.idOrderallocate as id,oa.idOrder as order_id,ors.poNumber as ponumber,ors.idCustomer as customer_id,DATE_FORMAT(ors.poDate,'%d-%m-%Y') as poDate,ors.grandtotalAmount as amount,cr.cs_name as name,g1.geoValue as country,g2.geoValue as state,g3.geoValue as city,oai.rejectQty,oa.status
		FROM orders_allocated as oa
		LEFT JOIN orders_allocated_items as oai ON oai.idOrderallocated=oa.idOrderallocate
		LEFT JOIN orders as ors ON ors.idOrder=oa.idOrder
		LEFT JOIN customer as cr ON cr.idCustomer=ors.idCustomer
		LEFT JOIN geography as g1 ON g1.idGeography=cr.G1 
		LEFT JOIN geography as g2 ON g2.idGeography=cr.G2 
		LEFT JOIN geography as g3 ON g3.idGeography=cr.G3 
		WHERE oa.idOrderallocate =?";
		$result=$this->adapter->query($qry,array($editid));
		$resultset=$result->toArray();

		$qry_list="SELECT oa.idOrderallocate as id,oa.idOrder as order_id,orai.idProduct,orai.idProductsize,pd.productName,orai.approveQty,ps.productPrimaryCount as unit,ps.productSize,pp.primarypackname,pd.productCount,oa.status,orai.offer_flog,(IF(orai.idScheme!=0,'1','0')) as discountStatus
		FROM orders_allocated as oa
		LEFT JOIN orders_allocated_items as orai ON orai.idOrderallocated=oa.idOrderallocate
		LEFT JOIN product_details as pd ON pd.idProduct=orai.idProduct
		LEFT JOIN product_size as ps ON ps.idProductsize=orai.idProductsize
		LEFT JOIN primary_packaging as pp ON pp.idPrimaryPackaging=ps.idPrimaryPackaging
		WHERE orai.idOrderallocated=? GROUP BY orai.idProductsize ";
		

		$result_list=$this->adapter->query($qry_list,array($editid));
		$resultset_list=$result_list->toArray();

		if(!$resultset){
			$ret_arr=['code'=>'3','content'=>'','status'=>false,'message'=>'Please contact the administrator'];
		} else {
			$ret_arr=['code'=>'1','content'=>$resultset,'content_list'=>$resultset_list,'status'=>true,'message'=>'Order list'];
		}
		return $ret_arr;
	}

   }

   function picklist($param){
		if ($param->action=='list') {
			$qry="SELECT T1.idOrderallocate AS id, T1.idWarehouse, T1.status AS status, T2.poNumber AS poNo, T2.poDate AS poDate, T4.fulfillmentName AS fullfillment, T3.cs_name AS customerName, 1  AS OrderStatus,T5.warehouseName AS Whouse
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
			T2.expireDate, 
			T2.productCount, 
			T4.primarypackname, 
			T3.productSize ,
			T1.dispatchQty,
			'0' as orderQty, 
			'0' as pqty,'0' as status, 
			'0' as idOrderitem,
			'0' as idOrder,T2.productserialNo,
			T1.offer_flog,
			(IF(T1.idScheme!=0,'1','0')) as discountStatus,
			'' as sendTodispatch
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
            	if ($resultsetSubQry[$i]['offer_flog']==1)
                {
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
				//already pick qty
				$qryPickqty="SELECT sum(pickQty) as pickQty FROM `order_picklist_items` WHERE idAllocateOrder='$allocateId' AND idProduct='$pid' AND idProdSize='$psid' AND idAllocateItem='".$resultsetSubQry[$i]['idOrderallocateditems']."'";
				$resultPickqty=$this->adapter->query($qryPickqty,array());
				$resultsetPickqty=$resultPickqty->toArray(); 
				$resultsetSubQry[$i]['pqty']=$resultsetPickqty[0]['pickQty']; 
            	}
            	//get offer product qty detials
            	if ($resultsetSubQry[$i]['offer_flog']==2)
                {

                   	$qryOrderqty1="SELECT T1.idOrderallocate AS id, T1.idWarehouse, T1.status AS status, T2.idOrder, ordi.idOrderitem, ordi.discountQty as orderQty, ordi.idProduct, ordai.idProductsize FROM orders_allocated AS T1 LEFT JOIN orders_allocated_items AS ordai ON ordai.idOrderallocated=T1.idOrderallocate LEFT JOIN orders AS T2 ON T1.idOrder = T2.idOrder LEFT JOIN order_items as ordi ON ordi.idOrder=T2.idOrder WHERE T1.idOrderallocate='$allocateId' AND ordi.discountJoinid='$pid' AND ordai.idOrderallocateditems='".$resultsetSubQry[$i]['idOrderallocateditems']."'";
				$resultOrderqty1=$this->adapter->query($qryOrderqty1,array());
				$resultsetOrderqty1=$resultOrderqty1->toArray(); 

				$resultsetSubQry[$i]['orderQty']=$resultsetOrderqty1[0]['orderQty']; 
				$resultsetSubQry[$i]['status']=$resultsetOrderqty1[0]['status']; 
				$resultsetSubQry[$i]['idOrderitem']=$resultsetOrderqty1[0]['idOrderitem'];
				$resultsetSubQry[$i]['idOrder']=$resultsetOrderqty1[0]['idOrder']; 

                   	//already pick qty
                $qryPickqty="SELECT sum(pickQty) as pickQty,sum(status) as sendTodispatch FROM `order_picklist_items` WHERE idAllocateOrder='$allocateId' AND idProduct='$pid' AND idProdSize='$psid' AND idAllocateItem='".$resultsetSubQry[$i]['idOrderallocateditems']."'";
				$resultPickqty=$this->adapter->query($qryPickqty,array());
				$resultsetPickqty=$resultPickqty->toArray(); 
				$resultsetSubQry[$i]['pqty']=$resultsetPickqty[0]['pickQty']; 
				$resultsetSubQry[$i]['sendTodispatch']=$resultsetPickqty[0]['sendTodispatch']; 
                }
            	
                
				
            	
            	$qryAlreadyDispatch="SELECT dc.idWarehouse,dc.idOrderallocate,dc.idOrder,dp.idProduct,dp.idProdSize,dp.idOrderItem,dp.dis_Qty FROM `dispatch_customer` as dc LEFT JOIN dispatch_product as dp on dp.idDispatchcustomer=dc.idDispatchcustomer WHERE dc.idOrderallocate='$allocateId' and dp.idProduct='$pid' and dp.idProdSize='$psid'";
				$resultAlreadyDispatch=$this->adapter->query($qryAlreadyDispatch,array());
				$resultsetAlreadyDispatch=$resultAlreadyDispatch->toArray();

				$qryAlreadyPicklist="SELECT idOrder,idAllocateOrder,idAllocateItem,idWarehouse,idWhStockItem,idProduct,idProdSize,pickQty,status FROM `order_picklist_items` WHERE  idAllocateOrder='$allocateId' and idProduct='$pid' and idProdSize='$psid'";
				$resultAlreadyPicklist=$this->adapter->query($qryAlreadyPicklist,array());
				$resultsetAlreadyPicklist=$resultAlreadyPicklist->toArray();
				if ($resultsetAlreadyDispatch[0]['idOrderallocate']!=$resultsetAlreadyPicklist[0]['idAllocateOrder']) 
				{
					$resultsetSubQry[$i]['pickqty']=$resultsetAlreadyPicklist[0]['pickQty'];
					$resultsetSubQry[$i]['sendTodispatch']=$resultsetAlreadyPicklist[0]['status'];
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
			$customerId=$param->customerId;
			$whouseId=$param->whouseId;
			$userData=$param->userData;
			$idCustomer=$userData['idCustomer'];
			$idLevel=$userData['user_type'];
            $idOrderallocate=$param->idOrderallocate;
             $idallocateitem=$param->idallocateitem;
             $expdate=$param->expdate;
             $qryService="SELECT T1.cs_serviceby  AS cs_serviceby
					FROM customer AS T1
					WHERE T1.idCustomer=?";
			$resultService=$this->adapter->query($qryService,array($customerId));
			$resultsetService=$resultService->toArray();

			$serviceCustomer=$resultsetService[0]['cs_serviceby'];

             //if product expire date available get stock with expire date greater then current date else get all product stock qty
             if ($expdate==1) 
             {
             	$qryWHstock="SELECT idWhStockItem,idWhStock,
			sku_accept_qty, 
			idProduct,
			idProdSize,
			idWarehouse,
			DATE_FORMAT(sku_mf_date, '%d-%m-%Y') as mDate, 
			DATE_FORMAT(sku_expiry_date, '%d-%m-%Y') as eDate, 
			sku_batch_no AS batchNo,
			'0' as availQty ,
			'' as Serialno
			FROM whouse_stock_items WHERE idProduct='".$productId."' AND idProdSize='".$productSize."' AND idWarehouse='".$whouseId."' AND sku_expiry_date>now() AND idCustomer='".$idCustomer."' and idLevel='".$idLevel."'";
             }
             else
             {
             	 $qryWHstock="SELECT idWhStockItem, idWhStock,
			sku_accept_qty, 
			idProduct,
			idProdSize,
			idWarehouse,
			DATE_FORMAT(sku_mf_date, '%d-%m-%Y') as mDate, 
			DATE_FORMAT(sku_expiry_date, '%d-%m-%Y') as eDate, 
			sku_batch_no AS batchNo,
			'0' as availQty ,
			'' as Serialno
			FROM whouse_stock_items
			 WHERE idProduct='".$productId."' AND idProdSize='".$productSize."' AND idWarehouse='".$whouseId."'  AND idCustomer='".$idCustomer."' and idLevel='".$idLevel."'";
             }
			//echo $qryWHstock;
			
			$resultWHstock=$this->adapter->query($qryWHstock,array());
			$resultsetWHstock=$resultWHstock->toArray();
			

			for ($i=0; $i < count($resultsetWHstock); $i++) 
			{ 
				$mfdate=$resultsetWHstock[$i]['mDate'];
				$exdate=$resultsetWHstock[$i]['eDate'];
				$batchno=$resultsetWHstock[$i]['batchNo'];
				$idWhStock=$resultsetWHstock[$i]['idWhStock'];
				$idWhStockItem=$resultsetWHstock[$i]['idWhStockItem'];
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

				//Customer order Return

				$qrycus="SELECT COR.rtnQty as proQty,DC.idCustomer,DC.idWarehouse from customer_order_return as COR
				LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer  where DC.idCustomer='$serviceCustomer'";
				$resultcus=$this->adapter->query($qrycus,array());
				$resultsetcus=$resultcus->toArray();


				$Customer=$resultsetcus[0]['idCustomer'];
				$war=$resultsetcus[0]['idWarehouse'];

				$cstReturnQty="SELECT COR.rtnQty as proQty,  DATE_FORMAT(COR.rtnDate,'%d-%m-%Y') as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce ,0 as pricount,O.idOrder
				  from customer_order_return as COR
				  LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
				  LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
				  LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
				  LEFT JOIN whouse_stock as W ON W.po_no=O.poNumber  
				  LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
				   where WHSI.idProduct='$productId' and WHSI.idProdSize='$productSize' and WHSI.idWarehouse='$war' and WHSI.sku_mf_date='".date("Y-m-d", strtotime($mfdate))."' and WHSI.sku_batch_no='$batchno' and W.idWhStock='$idWhStock' ";
				
										   
				$resultcstReturnQty=$this->adapter->query($cstReturnQty,array());
				$resultsetcstReturnQty=$resultcstReturnQty->toArray();

				/*print_r($resultsetWHreturn);
				echo "-----";
				print_r($resultsetWHdispatch);
				print_r($resultsetWHdamage);
				print_r($resultsetWHpick);*/
				//print_r($resultsetcstReturnQty);

				//Warehouse stock damage

				$stkDmg="SELECT WHSD.idDamage as idwhdamage, WHSD.dmg_prod_qty as proQty,  DATE_FORMAT(WHSD.dmg_entry_date,'%d-%m-%Y') as entryDate, WHS.po_no as PORefernce, WHS.grn_no as DocRefernce,0 as balanceAmt ,0 as pricount,PS.productPrimaryCount as primarycount,WHSI.idWhStockItem
					from whouse_stock_damge as WHSD 
					LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=WHSD.idWhStockItem 
					LEFT JOIN whouse_stock as WHS ON WHSI.idWhStock=WHS.idWhStock 
					LEFT JOIN product_size as PS ON PS.idProductsize=WHSD.idProdSize 
					where WHSD.idProduct='$productId' and WHSD.idProdSize='$productSize' and WHSI.sku_mf_date ='".date("Y-m-d", strtotime($mfdate))."' and WHSD.idWhStockItem='$idWhStockItem'";

				$resultstkDmg=$this->adapter->query($stkDmg,array());
				$resultsetstkDmg=$resultstkDmg->toArray();
				if($resultsetstkDmg){
				$WarehouseDamage=$resultsetstkDmg[0]['proQty']/$resultsetstkDmg[0]['primarycount'];
				}else{
					$WarehouseDamage=0;
				}
					
				
				//Warehouse stock damage
				$cstDmg="SELECT COR.idCustOrderDmgsRtn as idDamage,COR.dmgQty as proQty,  DATE_FORMAT(COR.dmgRtnDate,'%d-%m-%Y') as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce ,O.idOrder,PS.productPrimaryCount as primarycount
				  from customer_order_damges as COR
				  LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
				  LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
				  LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
                  LEFT JOIN orders_allocated as OA ON OA.idOrder=O.idOrder  
                  LEFT JOIN whouse_stock as W ON W.po_no=O.poNumber  
				  LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem
				  LEFT JOIN product_size as PS ON PS.idProductsize=WHSI.idProdSize   
				  where WHSI.idProduct='$productId' and WHSI.idProdSize='$productSize' and WHSI.idWarehouse=OA.idWarehouse and WHSI.sku_mf_date='".date("Y-m-d", strtotime($mfdate))."' and DC.idCustomer='$idCustomer' and W.idWhStock='$idWhStock'";
				 
	$resultcstDmg=$this->adapter->query($cstDmg,array());
	$resultsetcstDmg=$resultcstDmg->toArray();
				if($resultsetcstDmg){
				$ReturnDamage=$resultsetcstDmg[0]['proQty']/$resultsetcstDmg[0]['primarycount'];
				}else{
					$ReturnDamage=0;
				}


			//calculate total available stock 
	$avlStockQtyVal=(($resultsetWHreturn[0]["totalAcceptQty"]+$resultsetWHreturn[0]["totalProReturn"]) - ($resultsetWHdispatch[0]["totalProDispatch"]+$WarehouseDamage+$ReturnDamage+$resultsetWHpick[0]["totalProPickQty"]+$resultsetcstReturnQty[0]['proQty']));

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

		/*foreach ($resultsetWHstock as $key => $value) {
			$resarr[$value['batchNo']]['availQty']+=$value['availQty'];
			$resarr[$value['batchNo']]['sku_accept_qty']+=$value['sku_accept_qty'];
			$resarr[$value['batchNo']]['idProduct']=$value['idProduct'];
			$resarr[$value['batchNo']]['idProdSize']=$value['idProdSize'];
			$resarr[$value['batchNo']]['idWarehouse']=$value['idWarehouse'];
			$resarr[$value['batchNo']]['mDate']=$value['mDate'];
			$resarr[$value['batchNo']]['eDate']=$value['eDate'];
			$resarr[$value['batchNo']]['batchNo']=$value['batchNo'];

		}*/
		

			if(!$resultset) {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
			} else {
				$ret_arr=['code'=>'2','content'=>$resultset,'data'=>$resultsetWHstock,'pickQty'=>$resultsetAlreadyPickQty,'status'=>true,'message'=>'Record available'];
			}
		}elseif($param->action=='pickqtyitems'){
             
				$pickQty=($param->pickQty)?explode(',',$param->pickQty):'';
				$whouseItemId=($param->whouseItemId)?explode(',',$param->whouseItemId):'';
				$serialnostatus=$param->serialnostatus;
				$pickSLNO=($param->whdata)?explode(',',$param->whdata):'';
				$sQty=$param->sQty;
				$idproduct=$param->prodId;
				$idproductsize=$param->prodSiz;
				$alloitmId=$param->alloitmId;
				$alreadypickQty=($param->alreadypickQty)?$param->alreadypickQty:0;
				$ttls=0;
				$qryPS="SELECT productPrimaryCount FROM `product_size` WHERE idProductsize='$idproductsize'";
				$resultPS=$this->adapter->query($qryPS,array());
				$resultsetPS=$resultPS->toArray();
				$pscount=$resultsetPS[0]['productPrimaryCount'];

				for ($i=0; $i <count($pickQty) ; $i++) 
				{
					$ttls=$ttls+$pickQty[$i];
				}
				$rps=0;
				$ttls=$alreadypickQty+$ttls;
				$rps=$pscount*$ttls; //currently accept requsted serial number

			$qry="SELECT idOrder FROM  orders_allocated where idOrderallocate=?";
			$result=$this->adapter->query($qry,array($param->allId));
			$resultset=$result->toArray();
			// isserialNo status is check if the serialno is allocated or not in this product befor pick qty insert
			$isserialNo=false; 
			if($serialnostatus==1)
			{
				$qryWH="SELECT count(*) as ttlcount FROM `product_stock_serialno` WHERE idWhStockItem in($param->whouseItemId) AND idProduct='$idproduct' AND idProductsize='$idproductsize' AND idOrderallocateditems='$alloitmId'";
				$resultWH=$this->adapter->query($qryWH,array());
				$resultsetWH=$resultWH->toArray();
				$ttlcount=$resultsetWH[0]['ttlcount']; //accepted serial number
				
				if($rps==$ttlcount) 
				{
					$isserialNo=true;
				}
			}
			else
			{
				$isserialNo=true;
			}
			  
			if ($isserialNo==true) 
			{
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
							$datainsert['idSerialno']=($pickSLNO[$i])?$pickSLNO[$i]:'';

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
			}
			else
			{
				$ret_arr=['code'=>'3','status'=>false,'message'=>'Please pick the serial number'];
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
	public function recieptbookControlList($param)
	{

		$idcity=$param->idcity;
		$idpincode=$param->idpincode;
		$idarea=$param->idarea;
		$idstreet=$param->idstreet;

            $qryCity="SELECT A.*,B.title FROM `territory_master` AS A LEFT JOIN territorytitle_master AS B ON B.idTerritoryTitle=A.idTerritoryTitle WHERE A.idTerritoryTitle=3 ORDER BY territoryValue ASC";
			$resultCity=$this->adapter->query($qryCity,array());
			$resultsetCity=$resultCity->toArray();

			$qryPincode="SELECT A.*,B.title FROM `territory_master` AS A LEFT JOIN territorytitle_master AS B ON B.idTerritoryTitle=A.idTerritoryTitle WHERE A.idTerritoryTitle=4 ORDER BY territoryValue ASC";
			$resultPincode=$this->adapter->query($qryPincode,array());
			$resultsetPincode=$resultPincode->toArray();

			$qryArea="SELECT A.*,B.title FROM `territory_master` AS A LEFT JOIN territorytitle_master AS B ON B.idTerritoryTitle=A.idTerritoryTitle WHERE A.idTerritoryTitle=5 ORDER BY territoryValue ASC";
			$resultArea=$this->adapter->query($qryArea,array());
			$resultsetArea=$resultArea->toArray();

				$qryStreet="SELECT A.*,B.title FROM `territory_master` AS A LEFT JOIN territorytitle_master AS B ON B.idTerritoryTitle=A.idTerritoryTitle WHERE A.idTerritoryTitle=6 ORDER BY territoryValue ASC";
			$resultStreet=$this->adapter->query($qryStreet,array());
			$resultsetStreet=$resultStreet->toArray();

			if(($idcity!='' AND $idcity!=0) || ($idpincode!='' AND $idpincode!=0) || ($idarea!='' AND $idarea!=0) || ($idstreet!='' AND $idstreet!=0)){
				if($idcity!='' AND $idcity!=0){
				$Condition.=" and A.t3='".$idcity."'";
				}
				if($idpincode!='' AND $idpincode!=0){
				$Condition.=" and A.t4='".$idpincode."'";
				}
				if($idarea!='' AND $idarea!=0){
				$Condition.=" and A.t5='".$idarea."'";
				}
				if($idstreet!='' AND $idstreet!=0){
				$Condition.=" and A.t6='".$idstreet."'";
				}

			    $qryrecieptData="SELECT A.*,DATE_FORMAT(A.entryDate, '%d-%m-%Y') as entry_Date,B.name FROM `ledger_details` AS A
			    LEFT JOIN team_member_master AS B ON B.idTeamMember=A.idColEmp
			     WHERE A.ledgerNo!='' $Condition";
			   // echo $qryrecieptData;
				$resultrecieptData=$this->adapter->query($qryrecieptData,array());
				$resultsetrecieptData=$resultrecieptData->toArray();
				for ($i=0; $i < count($resultsetrecieptData); $i++) 
				{ 
					$ur=0;
				$used=explode(',',$resultsetrecieptData[$i]['usedReciept']);
				for ($v=0; $v <count($used) ; $v++) { 
					if($used[$v]!="" || $used[$v]!=null){
					$ur=$ur+count($used[$v]);
					}
				}
					$resultsetrecieptData[$i]['totalused']=$ur;
				}

			}else{


			$qryrecieptData="SELECT A.*,DATE_FORMAT(A.entryDate, '%d-%m-%Y') as entry_Date,B.name  FROM `ledger_details` AS A
			LEFT JOIN team_member_master AS B ON B.idTeamMember=A.idColEmp";
			$resultrecieptData=$this->adapter->query($qryrecieptData,array());
			$resultsetrecieptData=$resultrecieptData->toArray();
			for ($i=0; $i < count($resultsetrecieptData); $i++) 
				{ 
					$ur=0;
				$used=explode(',',$resultsetrecieptData[$i]['usedReciept']);
				for ($v=0; $v <count($used) ; $v++) { 
					if($used[$v]!="" || $used[$v]!=null){
					$ur=$ur+count($used[$v]);
					}
				}
				$resultsetrecieptData[$i]['totalused']=$ur;
				}
			}
				//print_r($resultsetrecieptData);
			$cityname=$resultsetCity[0]['title'];
			$pincodename=$resultsetPincode[0]['title'];
			$areaname=$resultsetArea[0]['title'];
			$streetname=$resultsetStreet[0]['title'];

			$ret_arr=['code'=>'2','status'=>true,'cityname'=>$cityname,'pincodename'=>$pincodename,'areaname'=>$areaname,'streetname'=>$streetname,'city'=>$resultsetCity,'pincode'=>$resultsetPincode,'area'=>$resultsetArea,'street'=>$resultsetStreet,'recieptData'=>$resultsetrecieptData,'message'=>'Added successfully'];
      return $ret_arr;
	}

	public function stateChange($param)
	{
           

			$qryPincode="SELECT idTerritory,territoryValue FROM `territory_master` WHERE idTerritory in(SELECT tmm.t3 FROM territorymapping_master as tmm WHERE tmm.t2='".$param->id."')";
		
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
           

			$qryPincode="SELECT idTerritory,territoryValue FROM `territory_master` WHERE idTerritory in(SELECT tmm.t4 FROM territorymapping_master as tmm WHERE tmm.t3='".$param->id."')";
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
           

			$qryArea="SELECT idTerritory,territoryValue FROM `territory_master` WHERE idTerritory in(SELECT tmm.t5 FROM territorymapping_master as tmm WHERE tmm.t3='".$param->id."' AND tmm.t4='".$param->pincodeid."')";
			$resultArea=$this->adapter->query($qryArea,array());
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
           

			$qryStreet="SELECT idTerritory,territoryValue FROM `territory_master` WHERE idTerritory in(SELECT tmm.t6 FROM territorymapping_master as tmm WHERE tmm.t3='".$param->id."' AND tmm.t4='".$param->pincodeid."' AND tmm.t5='".$param->areaid."')";
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

	public function getLedger($param)
	{
		 $qryrecieptData="SELECT ld.idLedger,
			ld.ledgerNo,
			ld.recieptFromNo,
			ld.recieptToNo,
			ld.recieptNos,
			ld.totalReciept,
			ld.usedReciept,
			ld.idColEmp,
			ld.entryDate,
			DATE_FORMAT(ld.entryDate, '%d-%m-%Y') as entry_Date,
			'0' as totalcancel,'0' as totalmissing,'0' as totalavail,'0' as totalused,
			ld.t1,
			ld.t2,
			ld.t3,
			ld.t4,
			ld.t5,
			ld.t6,
			ld.t7,
			ld.t8,
			ld.t9,
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
			WHERE idLedger='".$param->ledgerid."'";
			$resultrecieptData=$this->adapter->query($qryrecieptData,array());
			$resultsetrecieptData=$resultrecieptData->toArray();
			
		
		$totalreciept=$resultsetrecieptData[0]['recieptToNo'];
		//$usedcount=count(explode(',',$resultsetrecieptData[0]['usedReciept']));
		$usedRecieptExp=explode(',',$resultsetrecieptData[0]['usedReciept']);
		$usedReciept=@array_filter($usedRecieptExp);
		$usedcount=count($usedReciept);
		$resultsetrecieptData[0]['totalused']=$usedcount;
		$LedgerCancel=array();
		$qryLedgercancel="SELECT * FROM `ledger_cancel` WHERE idLedger='".$param->ledgerid."' AND idColEmp='".$resultsetrecieptData[0]['idColEmp']."'";
		//echo $qryLedgercancel;
		$resultLedgercancel=$this->adapter->query($qryLedgercancel,array());
		$resultsetLedgercancel=$resultLedgercancel->toArray();
		for($iCont=0; $iCont<=count($resultsetLedgercancel); $iCont++)
		{
		 $LedgerCancel[]=$resultsetLedgercancel[$iCont]["recptNo"];
		}
		//print_r($LedgerCancel);
		$cancelcount=count($resultsetLedgercancel);
		$resultsetrecieptData[0]['totalcancel']=$cancelcount;
		$usedRecieptCount=$totalreciept-$usedcount-$cancelcount;
		$j=0; 
		for($iCont=$resultsetrecieptData[0]["recieptFromNo"]; $iCont<=$usedRecieptCount; $iCont++)
		{
		 $j++;
		}
$k=0;
		for($i=$resultsetrecieptData[0]["recieptFromNo"]; $i<=$totalreciept; $i++)
		{

			$recieptstatus[$k]['recieptno']=$i;
			$recieptstatus[$k]['status']=0;
			if($i<=@max($usedReciept))
			{ 
				if(in_array($i, $usedReciept))
				{
				$classVal='divRecieptNoG'; $titleVal='Used';
				$recieptstatus[$k]['status']=1;
				}elseif(in_array($i, $LedgerCancel))
				{
				$classVal='divRecieptNoR'; $titleVal='Cancel';
				$recieptstatus[$k]['status']=2;
				}else
				{
				$classVal='divRecieptNoO'; $titleVal='Missed';
				$recieptstatus[$k]['status']=3;
				}
			}
			elseif(in_array($i, $LedgerCancel))
			{
				$classVal='divRecieptNoR'; $titleVal='Cancel';
				$recieptstatus[$k]['status']=2;
			}else
			{
				$classVal='divRecieptNoW'; $titleVal='Available';
				$recieptstatus[$k]['status']=4;
			}
			$k=$k+1;
		}
		if($recieptstatus[$k]['status']==3){
		$resultsetrecieptData[0]['totalmissing']=count($recieptstatus[$k]);
		}

		$resultsetrecieptData[0]['totalavail']=$totalreciept-$cancelcount;
		$resultsetrecieptData[0]['recieptstatus']=$recieptstatus;





			$ret_arr=['code'=>'2','status'=>true,'ledgerData'=>$resultsetrecieptData,'message'=>'Added successfully'];
      return $ret_arr;
	}

	public function searchLedger($param)
	{
		$idcity=$param->idcity;
		$idpincode=$param->idpincode;
		$idarea=$param->idarea;
		$idstreet=$param->idstreet;
			if($idcity!='' AND $idcity!=0){
			$Condition.=" and t3='".$idcity."'";
			}
			if($idpincode!='' AND $idpincode!=0){
			$Condition.=" and t4='".$idpincode."'";
			}
			if($idarea!='' AND $idarea!=0){
			$Condition.=" and t8='".$idarea."'";
			}
			if($idstreet!='' AND $idstreet!=0){
			$Condition.=" and t9='".$idstreet."'";
			}

		    $qryledgerData="SELECT * FROM `ledger_details`  WHERE ledgerNo!='' $Condition";
			$resultledgerData=$this->adapter->query($qryledgerData,array());
			$resultsetledgerData=$resultledgerData->toArray();
			for ($i=0; $i < count($resultsetledgerData); $i++) 
			{ 
				$resultsetledgerData[$i]['totalused']=count(explode(',',$resultsetledgerData[$i]['usedReciept']));
			}
			if (count($resultsetledgerData)>0) 
			{
				$ret_arr=['code'=>'2','status'=>true,'recieptData'=>$resultsetledgerData,'message'=>'Data available'];

			}
			else
			{
               $ret_arr=['code'=>'2','status'=>false,'message'=>'No Data available'];
			}

			return $ret_arr;
			
	}
    //picked product serialno updated
	public function updateSerialno($param)
	{
       
       $fields=$param->FORM;
       $sno=$param->srno;
       $idWhStockItem=$param->whitem;
       $idorderallocateitem=$param->alloItemId;
      $checkedsno=$param->checkedSNO;
      $orderid=$param->orderid;
       for ($i=0; $i < count($checkedsno); $i++) 
       { 
       	$j=$i+1;
       	$a='serialcheck'.$j;
       	
      
       		 	
        $idserialno=$checkedsno[$i];
       		 	$this->adapter->getDriver()->getConnection()->beginTransaction();
					try {
						$updateserialNo['status']=1;
						$updateserialNo['idWhStockItem']=$idWhStockItem;
						$updateserialNo['idOrderallocateditems']=$idorderallocateitem;
						$updateserialNo['idOrder']=$orderid;
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
       	
           
       }

       return $ret_arr;
	}

	public function picklistCancel($param)
{
  
  $data=$param->FORM;
    $idOrderallocate=$data['orderids'];

   $qry="SELECT T1.idOrderallocate AS id,T1.idOrder AS idorder FROM orders_allocated AS T1 where  T1.idOrderallocate=?";
		$result=$this->adapter->query($qry,array($data['orderids']));
		$resultset=$result->toArray();
    $idorder=$resultset[0]['idorder'];
		if(count($resultset)>0)
		{

		
			$this->adapter->getDriver()->getConnection()->beginTransaction();
			try{
				
				
				$dataupdate['status']=2;
				
				$sql = new Sql($this->adapter);
				$update = $sql->update();
				$update->table('orders_allocated');
				$update->set($dataupdate);
				$update->where(array('idOrderallocate' =>$idOrderallocate));
				$statement  = $sql->prepareStatementForSqlObject($update);
				$results    = $statement->execute();
				
				$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
				$this->adapter->getDriver()->getConnection()->commit();
			} catch(\Exception $e) {
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
				$this->adapter->getDriver()->getConnection()->rollBack();
			}
		
 
  $this->adapter->getDriver()->getConnection()->beginTransaction();
			try 
			{

				$ordercancelInsert['idOrderallocate']=$idOrderallocate;
				$ordercancelInsert['idOrder']=$idorder;
				$ordercancelInsert['reason']=$data['reason'];
				$ordercancelInsert['created_by']=$param->iduser;
				$ordercancelInsert['created_at']=date('Y-m-d H:i:s');						

				$insertorder=new Insert('order_cancel_reason');
				$insertorder->values($ordercancelInsert);
				$statementorder=$this->adapter->createStatement();
				$insertorder->prepareStatement($this->adapter, $statementorder);
				$insertresultorder=$statementorder->execute();
				$orderallocatedid=$this->adapter->getDriver()->getLastGeneratedValue();
			
				if ($data['orderact']=="full") {
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Order deleted successfully'];
				$this->adapter->getDriver()->getConnection()->commit();
				}
				else
				{
					$ret_arr=['code'=>'2','status'=>true,'message'=>'Order partially deleted successfully'];
				$this->adapter->getDriver()->getConnection()->commit();
				}
				
			} 
			catch(\Exception $e) 
			{
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
				$this->adapter->getDriver()->getConnection()->rollBack();
			}

			} else {
			$ret_arr=['code'=>'3','status'=>false,'message'=>'order not available..'];
		}

		return $ret_arr;
}

public function picklist_print($param)
{
   $allocateId=$param->allocateId;
     //echo $allocateId;
    // picklist product details
    $qryProduct="SELECT opi.pickQty,
    prd.idProduct,
    prd.productName,
    prd.productCount,
    ps.idProductsize,
    ps.productSize,
    pp.primarypackname,
    pp.idPrimaryPackaging,
    wsi.sku_batch_no,
    wsi.sku_mf_date FROM order_picklist_items as opi 
LEFT JOIN product_details as prd ON prd.idProduct=opi.idProduct 
LEFT JOIN product_size as ps ON ps.idProductsize=opi.idProdSize 
LEFT JOIN primary_packaging as pp ON pp.idPrimaryPackaging=ps.idPrimaryPackaging
LEFT JOIN whouse_stock_items as wsi ON wsi.idWhStockItem=opi.idWhStockItem
WHERE idAllocateOrder='$allocateId'";
		$resultProduct=$this->adapter->query($qryProduct,array());
		$resultsetProduct=$resultProduct->toArray();
	
//        //picklist customer and warehouse details
		$qryCustomer="SELECT opi.pickQty,
ord.idOrder,
ord.poNumber,
ord.poDate,
cus.cs_name,
wm.warehouseName,
country.territoryValue as country, 
state.territoryValue as state,
city.territoryValue as city,
pincode.territoryValue as pincode,
region.territoryValue as region,
zone.territoryValue as zone,
hub.territoryValue as hub,
area.territoryValue as area,
street.territoryValue as street,
outlet.territoryValue as outlet
FROM `order_picklist_items` as opi 
LEFT JOIN orders as ord ON ord.idOrder=opi.idOrder 
LEFT JOIN customer as cus ON cus.idCustomer=ord.idCustomer 
LEFT JOIN warehouse_master as wm ON wm.idWarehouse=opi.idWarehouse
LEFT JOIN territory_master as country ON country.idTerritory=wm.t1
LEFT JOIN territory_master as state ON state.idTerritory=wm.t2
LEFT JOIN territory_master as city ON city.idTerritory=wm.t3
LEFT JOIN territory_master as pincode ON pincode.idTerritory=wm.t4
LEFT JOIN territory_master as region ON region.idTerritory=wm.t5
LEFT JOIN territory_master as zone ON zone.idTerritory=wm.t6
LEFT JOIN territory_master as hub ON hub.idTerritory=wm.t7
LEFT JOIN territory_master as area ON area.idTerritory=wm.t8
LEFT JOIN territory_master as street ON street.idTerritory=wm.t9
LEFT JOIN territory_master as outlet ON outlet.idTerritory=wm.t10
WHERE idAllocateOrder='$allocateId' GROUP BY idOrder";
		$resultCustomer=$this->adapter->query($qryCustomer,array());
		$resultsetCustomer=$resultCustomer->toArray();

		if (count($resultsetProduct)>0) 
		{
			$ret_arr=['code'=>'3','status'=>true,'content'=>$resultsetProduct,'customer'=>$resultsetCustomer,'message'=>'data available..'];
		}
		else
		{
		   $ret_arr=['code'=>'3','status'=>false,'message'=>'no data available..'];
		}	

   return $ret_arr;
}

public function unpickSerialno($param)
{
  $slno=($param->pickslno)?implode(',',$param->pickslno):'';
  $slno2=$param->pickslno;
  for ($i=0; $i <count($slno2) ; $i++) 
  { 
  	for ($j=0; $j <count($slno2[$i]) ; $j++) { 
  		# code...
  	$finalslno[]=$slno2[$i][$j];
  	}
  }
 
  $this->adapter->getDriver()->getConnection()->beginTransaction();
			try{
				
				for ($i=0; $i <count($finalslno) ; $i++) 
				{ 
					$dataupdate['idWhStockItem']=0;
					$dataupdate['idOrderallocateditems']=0;
					$dataupdate['idOrder']=0;
					$dataupdate['status']=2;

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

public function getProductSerialno($param)
{
	$idProduct=$param->idproduct;
	$idProductsize=$param->idsize;
	$idWhStock=$param->idwhstck;
	$idWhStockItem=$param->idwhstckitem; 
			$qrySerialno="SELECT * FROM `product_stock_serialno` WHERE idWhStock='$idWhStock' AND idProduct='$idProduct' AND idProductsize='$idProductsize' AND idWhStockItem='$idWhStockItem'";

			$resultSerialno=$this->adapter->query($qrySerialno,array());
			$resultsetSerialno=$resultSerialno->toArray();
			

		if (count($resultsetSerialno)>0) 
		{
			$ret_arr=['code'=>'3','status'=>true,'content'=>$resultsetSerialno,'message'=>'data available..'];
		}
		else
		{
		   $ret_arr=['code'=>'3','status'=>false,'message'=>'no data available..'];
		}	

   return $ret_arr;
}

public function questionsList($param)
{
		$qryQuestion="SELECT idQuestion,questionType,question,status FROM `questions`";
		$resultQuestion=$this->adapter->query($qryQuestion,array());
		$resultsetQuestion=$resultQuestion->toArray();

		if (count($resultsetQuestion)>0) 
		{
			$ret_arr=['code'=>'3','status'=>true,'content'=>$resultsetQuestion,'message'=>'data available..'];
		}
		else
		{
		   $ret_arr=['code'=>'3','status'=>false,'message'=>'no data available..'];
		}	

   return $ret_arr;
}

public function questionAdd($param)
{
  // print_r($param); exit;

   $fiedls=$param->Form;
			$userid=$param->userid;
			$question=$fiedls['question'];
			// $subcompany=$fiedls['subcompany'];
			// $status=$fiedls['pstatus'];
			$qry="SELECT idQuestion,questionType,question FROM `questions` WHERE question=?";
			$result=$this->adapter->query($qry,array($question));
			$resultset=$result->toArray();
			if(!$resultset) 
			{ 
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
					$datainsert['question']=$fiedls['question'];
					$datainsert['questionType']=$fiedls['qsntype'];
					$datainsert['option1']=($fiedls['option1'])?$fiedls['option1']:0;
					$datainsert['option2']=($fiedls['option2'])?$fiedls['option2']:0;
					$datainsert['option3']=($fiedls['option3'])?$fiedls['option3']:0;
					$datainsert['option4']=($fiedls['option4'])?$fiedls['option4']:0;				
					$datainsert['created_at']=date("Y-m-d H:i:s"); 
					$datainsert['created_by']=$userid;
					$datainsert['status']=$fiedls['qsnstatus'];
					$insert=new Insert('questions');
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
			  return $ret_arr;
}
public function questionEditView($param)
{
	$idQuestion=$param->qsnid;
    $qryQuestion="SELECT idQuestion,questionType,question,status,option1,option2,option3,option4 FROM `questions` WHERE idQuestion=?";
		$resultQuestion=$this->adapter->query($qryQuestion,array($idQuestion));
		$resultsetQuestion=$resultQuestion->toArray();

		if (count($resultsetQuestion)>0) 
		{
			$ret_arr=['code'=>'3','status'=>true,'content'=>$resultsetQuestion,'message'=>'data available..'];
		}
		else
		{
		   $ret_arr=['code'=>'3','status'=>false,'message'=>'no data available..'];
		}	

   return $ret_arr;
}

public function questionUpdate($param)
{
	
   $fileds=$param->Form;
	$this->adapter->getDriver()->getConnection()->beginTransaction();
	try{

		
			$dataupdate['questionType']=$fileds['questionType'];
			$dataupdate['question']=$fileds['question'];
			$dataupdate['option1']=($fileds['option1'])?$fileds['option1']:0;
			$dataupdate['option2']=($fileds['option2'])?$fileds['option2']:0;
			$dataupdate['option3']=($fileds['option3'])?$fileds['option3']:0;
			$dataupdate['option4']=($fileds['option4'])?$fileds['option4']:0;
			$dataupdate['updated_by']=1;
			$dataupdate['updated_at']=date('Y-m-d h:i:s');			
			$dataupdate['status']=$fileds['status'];

			$sql = new Sql($this->adapter);
			$update = $sql->update();
			$update->table('questions');
			$update->set($dataupdate);
			$update->where(array('idQuestion' =>$fileds['idQuestion']));
			$statement  = $sql->prepareStatementForSqlObject($update);
			$results    = $statement->execute();

	

		$ret_arr=['code'=>'2','status'=>true,'message'=>'Updated successfully'];
		$this->adapter->getDriver()->getConnection()->commit();
	} catch(\Exception $e) {
		$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
		$this->adapter->getDriver()->getConnection()->rollBack();
	}
	return $ret_arr;
}

}