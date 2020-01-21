<?php
namespace Sales\V1\Rest\Reports;
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


class ReportsMapper {

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
		//print_r($param);exit;
	}

	public function getCustomerType($param)
	{
       $qry="SELECT * FROM customertype WHERE status=1";
			$result=$this->adapter->query($qry,array());
			$resultset=$result->toArray();
			if(!$resultset) {
				$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
			}else{
				$ret_arr=['code'=>'2','status'=>true,'content' =>$resultset,'message'=>'System config information'];
			}
			return $ret_arr;
	}
	public function getCustomer($param)
	{
		$id=$param->customer_id;
		$qry="SELECT idCustomer,cs_name,cs_type from customer WHERE cs_type='$id' AND cs_status=1";
		$result=$this->adapter->query($qry,array());
		$resultset=$result->toArray();
		if(!$resultset) {
		$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		} else {
		$ret_arr=['code'=>'2','content'=>$resultset,'status'=>true,'message'=>'Record available'];
		}
		return $ret_arr; 
	}
	public function stockistPerformance($param)
	{
      
        $idCustomer=$param->customer;
        $idCustomerType=$param->custype;
        $startDate=date('Y-m-d',strtotime($param->startdate));
        $enddate=date('Y-m-d',strtotime($param->enddate));
        $qryCustomer="SELECT c.idCustomer,c.cs_name,c.cs_type,emp.idTeamMember,emp.name as inChargeName from customer as c LEFT JOIN team_member_master as emp ON emp.idTeamMember=c.sales_hrchy_name WHERE idCustomer='".$idCustomer."' AND cs_status=1";
		$resultCustomer=$this->adapter->query($qryCustomer,array());
		$resultsetCustomer=$resultCustomer->toArray();
         //total orders and it's amount
		$qryTotalOrders="SELECT count(idOrder) as totalOrders,sum(grandtotalAmount) as grandtotalAmount FROM `orders` WHERE idCustomer='".$idCustomer."' AND DATE_FORMAT(created_at,'%Y-%m-%d')  BETWEEN '".$startDate."' AND '".$enddate."'";
		$resultTotalOrders=$this->adapter->query($qryTotalOrders,array());
		$resultsetTotalOrders=$resultTotalOrders->toArray();

		$resultsetCustomer[0]['ordersTotal']=($resultsetTotalOrders[0])?$resultsetTotalOrders[0]:'';

		$qryLastOrderDate="SELECT DATE_FORMAT(poDate,'%d-%m-%Y') as lastOrderDate FROM `orders` WHERE idCustomer='".$idCustomer."' AND DATE_FORMAT(created_at,'%Y-%m-%d')  BETWEEN '".$startDate."' AND '".$enddate."' ORDER BY poDate DESC LIMIT 1";
		$resultLastOrderDate=$this->adapter->query($qryLastOrderDate,array());
		$resultsetLastOrderDate=$resultLastOrderDate->toArray();
		$resultsetCustomer[0]['lastOrderDate']=($resultsetLastOrderDate)?$resultsetLastOrderDate[0]['lastOrderDate']:'';
          //total dispatch and it's amount
		$qryTotalDispatch="SELECT count(idDispatchcustomer) as totalDispatch,sum(dc.invoice_amt) as totalInvoiceAmount FROM  dispatch_customer as dc 
		WHERE  DATE_FORMAT(dc.delivery_date,'%Y-%m-%d')  BETWEEN '".$startDate."' AND '".$enddate."' AND dc.idCustomer='".$idCustomer."'";
		$resultTotalDispatch=$this->adapter->query($qryTotalDispatch,array());
		$resultsetTotalDispatch=$resultTotalDispatch->toArray();

		$resultsetCustomer[0]['dispatchTotal']=($resultsetTotalDispatch[0])?$resultsetTotalDispatch[0]:'';
		//get customer warehouse and it's stock level
		
		$qryWarehouse="SELECT idWarehouse,warehouseName,warehouseMobileno,warehouseEmail FROM `warehouse_master` WHERE idCustomer='".$idCustomer."'";
		$resultWarehouse=$this->adapter->query($qryWarehouse,array());
		$resultsetWarehouse=$resultWarehouse->toArray();
		$resultsetCustomer[0]['stockLevel']=($resultsetWarehouse)?$resultsetWarehouse:'';
        $idWarehouse=($resultsetWarehouse[0]['idWarehouse'])?$resultsetWarehouse[0]['idWarehouse']:'';
        $warehouseName=($resultsetWarehouse[0]['warehouseName'])?$resultsetWarehouse[0]['warehouseName']:'';
		//first warehouse product with stock data
		$qryWarehouseProduct="SELECT wsi.idProduct,wsi.idProdSize,wsi.idWarehouse, pd.productName,ps.productSize,pd.productCount,(
		CASE
		WHEN pd.productCount = 1 THEN 'Units'
		WHEN pd.productCount = 2 THEN 'kg'
		WHEN pd.productCount = 3 THEN 'gm'
		WHEN pd.productCount = 4 THEN 'mgm'
		WHEN pd.productCount = 5 THEN 'mts'
		WHEN pd.productCount = 6 THEN 'cmts'
		WHEN pd.productCount = 7 THEN 'inches'
		WHEN pd.productCount = 8 THEN 'foot'
		WHEN pd.productCount = 9 THEN 'litre'
		WHEN pd.productCount = 10 THEN 'ml'

		END) as unitmeasure,pd.expireDate,ps.productPrimaryCount FROM `whouse_stock_items` as wsi 
        LEFT JOIN   `product_details` as pd ON pd.idProduct=wsi.idProduct 
        LEFT JOIN product_size as ps ON wsi.idProdSize=ps.idProductsize
        WHERE idWarehouse='".$idWarehouse."' 
		   GROUP BY idProduct,idProdSize ORDER BY pd.idProduct,ps.idProductsize";
		$resultWarehouseProduct=$this->adapter->query($qryWarehouseProduct,array());
		$resultsetWarehouseProduct=$resultWarehouseProduct->toArray();
		foreach ($resultsetWarehouseProduct as $key => $value) 
		{
			$idProduct=$value['idProduct'];
			$idProductsize=$value['idProdSize'];
		
		$resultsetWarehouseProduct[$key]['productSize']=$resultsetWarehouseProduct[$key]['productSize'].''.$resultsetWarehouseProduct[$key]['unitmeasure'];

			//get total stock
			if ($resultsetWarehouseProduct[$key]['expireDate']==1) 
			{
			$qryWHstock="SELECT SUM(WST.sku_accept_qty) AS whStockQty FROM whouse_stock_items AS WST 
			WHERE WST.idProduct='".$resultsetWarehouseProduct[$key]['idProduct']."' AND 
			WST.idProdSize='".$resultsetWarehouseProduct[$key]['idProdSize']."' 
			AND WST.idWarehouse='".$resultsetWarehouseProduct[$key]['idWarehouse']."' AND WST.sku_expiry_date>=NOW()";
			}
			else
			{
			$qryWHstock="SELECT SUM(WST.sku_accept_qty) AS whStockQty FROM whouse_stock_items AS WST 
			WHERE WST.idProduct='".$resultsetWarehouseProduct[$key]['idProduct']."' AND 
			WST.idProdSize='".$resultsetWarehouseProduct[$key]['idProdSize']."' 
			AND WST.idWarehouse='".$resultsetWarehouseProduct[$key]['idWarehouse']."'";
			}

			$resultWHstock=$this->adapter->query($qryWHstock,array());
			$resultsetWHstock=$resultWHstock->toArray();
			$ttlstockQty=($resultsetWHstock[0]['whStockQty']=='' || $resultsetWHstock[0]['whStockQty']==null)?0:$resultsetWHstock[0]['whStockQty'];
	        //get damage qty
			$qryWHdamage="SELECT SUM(WSD.dmg_prod_qty) AS whDamageQty FROM whouse_stock_damge AS WSD WHERE WSD.idProduct='".$resultsetWarehouseProduct[$key]['idProduct']."' AND WSD.idProdSize='".$resultsetWarehouseProduct[$key]['idProdSize']."'  AND WSD.idWarehouse='".$resultsetWarehouseProduct[$key]['idWarehouse']."'";
			$resultWHdamage=$this->adapter->query($qryWHdamage,array());
			$resultsetWHdamage=$resultWHdamage->toArray();
	        $ttldamageQty=($resultsetWHdamage[0]['whDamageQty']=='' || $resultsetWHdamage[0]['whDamageQty']==null)?0:$resultsetWHdamage[0]['whDamageQty'];
	        $finalDamageQty=0;
	        //damage qty convert into cases
             if ($ttldamageQty>0) 
             {
             	$primaryPackQty=$resultsetWarehouseProduct[$key]['productPrimaryCount'];
             	$DamageQtyCases=($ttldamageQty/$primaryPackQty);
             	$finalDamageQty=$DamageQtyCases;

             }
	         //get return qty(recieved qty EXample:SMS recieved from MS return qty)
			$qryWHreturn="SELECT SUM(COR.rtnQty) AS custRtnQty FROM customer_order_return AS COR LEFT JOIN dispatch_product_batch AS DPB ON COR.idDispatchProductBatch=DPB.idDispatchProductBatch LEFT JOIN whouse_stock_items AS WST ON WST.idWhStockItem=DPB.idWhStockItem WHERE WST.idProduct='".$resultsetWarehouseProduct[$key]['idProduct']."' AND WST.idProdSize='".$resultsetWarehouseProduct[$key]['idProdSize']."' AND WST.idWarehouse='".$resultsetWarehouseProduct[$key]['idWarehouse']."'";
			$resultWHreturn=$this->adapter->query($qryWHreturn,array());
			$resultsetWHreturn=$resultWHreturn->toArray();

			  $ttlRecievedQty=($resultsetWHreturn[0]['custRtnQty']=='')?0:$resultsetWHreturn[0]['custRtnQty'];

			  //get return qty (Example:return qty from SMS to Company)
				$qrycus="SELECT COR.rtnQty as proQty,DC.idCustomer,DC.idWarehouse from customer_order_return as COR
				LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer  where DC.idCustomer='".$idCustomer."'";

				$resultcus=$this->adapter->query($qrycus,array());
				$resultsetcus=$resultcus->toArray();
				$Customer=$resultsetcus[0]['idCustomer'];
				$war=$resultsetcus[0]['idWarehouse'];
				$cstReturnQty="SELECT 'returncustomer' as dataType,COR.rtnQty as proQty, COR.rtnDate as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce 
							  from customer_order_return as COR
							  LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
							  LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
							  LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
							  LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
							  where WHSI.idProduct='".$resultsetWarehouseProduct[$key]['idProduct']."' and WHSI.idProdSize='".$resultsetWarehouseProduct[$key]['idProdSize']."' and WHSI.idWarehouse='".$war."'";
				$resultcstReturnQty=$this->adapter->query($cstReturnQty,array());
				$resultsetcstReturnQty=$resultcstReturnQty->toArray();
				$ttlReturnQty=($resultsetcstReturnQty[0]['proQty']>0)?$resultsetcstReturnQty[0]['proQty']:0;

			  //order allocate qty
			$qryWHorder="SELECT SUM(WOI.picklistQty) AS whOrderQty FROM orders_allocated AS WO LEFT JOIN orders_allocated_items AS WOI ON WOI.idOrderallocated=WO.idOrderallocate WHERE WOI.idProduct='".$resultsetWarehouseProduct[$key]['idProduct']."' AND WOI.idProductsize='".$resultsetWarehouseProduct[$key]['idProdSize']."' AND WO.idWarehouse='".$resultsetWarehouseProduct[$key]['idWarehouse']."'";
			$resultWHorder=$this->adapter->query($qryWHorder,array());
			$resultsetWHorder=$resultWHorder->toArray();

			  $ttlorderQty=($resultsetWHorder[0]['whOrderQty']=='' || $resultsetWHorder[0]['whOrderQty']==null)?0:$resultsetWHorder[0]['whOrderQty'];
	           //available total stockqty

				$avlStockQtyVal=(($ttlstockQty+$ttlRecievedQty) - ($finalDamageQty+$ttlorderQty+$ttlReturnQty));
	            $tot_stock=number_format( $avlStockQtyVal,2,'.','');
                $resultsetWarehouseProduct[$key]['ttlorderQty']=$ttlorderQty;	
                $resultsetWarehouseProduct[$key]['ttlRecievedQty']=$ttlRecievedQty;	
                $resultsetWarehouseProduct[$key]['finalDamageQty']=$finalDamageQty;	
                $resultsetWarehouseProduct[$key]['ttlReturnQty']=$ttlReturnQty;	
	            $resultsetWarehouseProduct[$key]['stock']=$tot_stock;	
            //get reorder qty and reorder level
			$qryReorder="SELECT re_level,re_qty FROM `inventorynorms` WHERE idWarehouse='".$idWarehouse."' AND idProduct='".$idProduct."' AND idProdSize='".$idProductsize."'";
			$resultReorder=$this->adapter->query($qryReorder,array());
			$resultsetReorder=$resultReorder->toArray();
			$resultsetWarehouseProduct[$key]['re_level']=($resultsetReorder)?$resultsetReorder[0]['re_level']:'';
			$resultsetWarehouseProduct[$key]['re_qty']=($resultsetReorder)?$resultsetReorder[0]['re_qty']:'';
		

		}
		$resultsetCustomer[0]['warehouseProduct']=($resultsetWarehouseProduct)?$resultsetWarehouseProduct:'';
		//service by customers
		

		$qryServiceBy=" SELECT count(c.idCustomer) as customerCount,c.idCustomer,c.cs_name,
		c.G1
		,c.G2
		,c.G3
		,c.G4
		,c.G5
		,c.G6
		,c.G7
		,c.G8
		,c.G9
		,c.G10
		,geo1.geoValue as geo1val
		,geo2.geoValue as geo2val
		,geo3.geoValue as geo3val
		,geo4.geoValue as geo4val
		,geo5.geoValue as geo5val
		,geo6.geoValue as geo6val
		,geo7.geoValue as geo7val
		,geo8.geoValue as geo8val
		,geo9.geoValue as geo9val
		,geo10.geoValue as geo10val
		FROM `customer` AS c 
		LEFT JOIN geography as geo1 ON geo1.idGeography=c.G1
		LEFT JOIN geography as geo2 ON geo2.idGeography=c.G2
		LEFT JOIN geography as geo3 ON geo3.idGeography=c.G3
		LEFT JOIN geography as geo4 ON geo4.idGeography=c.G4
		LEFT JOIN geography as geo5 ON geo5.idGeography=c.G5
		LEFT JOIN geography as geo6 ON geo6.idGeography=c.G6
		LEFT JOIN geography as geo7 ON geo7.idGeography=c.G7
		LEFT JOIN geography as geo8 ON geo8.idGeography=c.G8
		LEFT JOIN geography as geo9 ON geo9.idGeography=c.G9
		LEFT JOIN geography as geo10 ON geo10.idGeography=c.G10
		WHERE cs_serviceby='".$idCustomer."' AND G3!='' AND G3!=0 AND cs_status=1 GROUP BY G2,G3";
				$resultServiceBy=$this->adapter->query($qryServiceBy,array());
				$resultsetServiceBy=$resultServiceBy->toArray();
        $overallOrders=0;
		//given total orders (service by)
		foreach ($resultsetServiceBy as $key => $value) 
		{

			//get same city given orders
			$qryGivenOrders="SELECT count(*) as totalGivenOrder FROM orders WHERE idCustomer in(SELECT idCustomer FROM `customer` WHERE cs_serviceby='".$idCustomer."' AND G3='".$value['G3']."' AND G2='".$value['G2']."')";
			$resultGivenOrders=$this->adapter->query($qryGivenOrders,array());
			$resultsetGivenOrders=$resultGivenOrders->toArray();
			$resultsetServiceBy[$key]['totalGivelOrders']=$resultsetGivenOrders[0];
			$overallOrders=$overallOrders+$resultsetGivenOrders[0]['totalGivenOrder'];
			// customer given total orders and it's amount
			$qryCustomerGivenOrders="SELECT count(idOrder) as totalGivenOrderCustomer,sum(grandtotalAmount) as grandtotalAmountCustomer FROM orders WHERE idCustomer in(SELECT idCustomer FROM `customer` WHERE cs_serviceby='".$idCustomer."' AND G3='".$value['G3']."' AND G2='".$value['G2']."') AND created_by IN(SELECT idLogin from user_login WHERE idCustomer='".$idCustomer."')";
			$resultCustomerGivenOrders=$this->adapter->query($qryCustomerGivenOrders,array());
			$resultsetCustomerGivenOrders=$resultCustomerGivenOrders->toArray();
			$resultsetServiceBy[$key]['totalGivelOrdersCustomer']=($resultsetCustomerGivenOrders[0]['totalGivenOrder']!='')?$resultsetCustomerGivenOrders[0]['totalGivenOrder']:0;
			$resultsetServiceBy[$key]['grandtotalAmountCustomer']=($resultsetCustomerGivenOrders[0]['grandtotalAmountCustomer']!='')?$resultsetCustomerGivenOrders[0]['grandtotalAmountCustomer']:0.00;
			//company given total orders and it's amount
			$qryCompanyGivenOrders="SELECT count(idOrder) as totalGivenOrderCompany ,sum(grandtotalAmount) as grandtotalAmountCompany  FROM orders WHERE idCustomer in(SELECT idCustomer FROM `customer` WHERE cs_serviceby='".$idCustomer."' AND G3='".$value['G3']."' AND G2='".$value['G2']."') AND created_by=1";
			$resultCompanyGivenOrders=$this->adapter->query($qryCompanyGivenOrders,array());
			$resultsetCompanyGivenOrders=$resultCompanyGivenOrders->toArray();
			$resultsetServiceBy[$key]['totalGivenOrderCompany']=($resultsetCompanyGivenOrders[0]['totalGivenOrderCompany']!='')?$resultsetCompanyGivenOrders[0]['totalGivenOrderCompany']:0;
			$resultsetServiceBy[$key]['grandtotalAmountCompany']=($resultsetCompanyGivenOrders[0]['grandtotalAmountCompany']!='')?$resultsetCompanyGivenOrders[0]['grandtotalAmountCompany']:0.00;
               //how many customers(servicebye of searched customer) not given orders
			$qryCustomerList="SELECT idCustomer FROM customer WHERE G3='".$value['G3']."' AND G2='".$value['G2']."' AND cs_serviceby='".$idCustomer."'";
			$resultCustomerList=$this->adapter->query($qryCustomerList,array());
			$resultsetCustomerList=$resultCustomerList->toArray();

			$notgivenOrders=0;
			if (count($resultsetCustomerList)>0)
			 {
			 		
				foreach ($resultsetCustomerList as $key1 => $value1) 
				{
					$qryCustomerOrder="SELECT idOrder,idCustomer FROM orders WHERE idCustomer='".$value1['idCustomer']."'";
			$resultCustomerOrder=$this->adapter->query($qryCustomerOrder,array());
			$resultsetCustomerOrder=$resultCustomerOrder->toArray();
			//this condition check order not given to that curresponding customer
			       if (count($resultsetCustomerOrder)==0) {
			       	$notgivenOrders=$notgivenOrders+1;
			       }
				}
			}
			
			$resultsetServiceBy[$key]['notGivenOrders']=$notgivenOrders;


		}
		$resultsetCustomer[0]['serviceBye']=$resultsetServiceBy;
		$resultsetCustomer[0]['supervisor']['totalCustomer']=count($resultsetServiceBy);
		
		if(!$resultsetCustomer) {
		$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		} else {
		$ret_arr=['code'=>'2','content'=>$resultsetCustomer,'warehouseName'=>$warehouseName,'status'=>true,'message'=>'Record available'];
		}
		return $ret_arr; 

	}

	public function getWarehouseStock($param)
	{
       $idWarehouse=$param->id;
       $idCustomer=$param->idCustomer;
       $qryWarehouse="SELECT idWarehouse,warehouseName,warehouseMobileno,warehouseEmail FROM `warehouse_master` WHERE idWarehouse='".$idWarehouse."'";
		$resultWarehouse=$this->adapter->query($qryWarehouse,array());
		$resultsetWarehouse=$resultWarehouse->toArray();
		$warehouseName=$resultsetWarehouse[0]['warehouseName'];

      $qryWarehouseProduct="SELECT wsi.idProduct,wsi.idProdSize,wsi.idWarehouse, pd.productName,ps.productSize,pd.productCount,(
		CASE
		WHEN pd.productCount = 1 THEN 'Units'
		WHEN pd.productCount = 2 THEN 'kg'
		WHEN pd.productCount = 3 THEN 'gm'
		WHEN pd.productCount = 4 THEN 'mgm'
		WHEN pd.productCount = 5 THEN 'mts'
		WHEN pd.productCount = 6 THEN 'cmts'
		WHEN pd.productCount = 7 THEN 'inches'
		WHEN pd.productCount = 8 THEN 'foot'
		WHEN pd.productCount = 9 THEN 'litre'
		WHEN pd.productCount = 10 THEN 'ml'

		END) as unitmeasure,pd.expireDate,ps.productPrimaryCount FROM `whouse_stock_items` as wsi 
        LEFT JOIN   `product_details` as pd ON pd.idProduct=wsi.idProduct 
        LEFT JOIN product_size as ps ON wsi.idProdSize=ps.idProductsize
        WHERE idWarehouse='".$idWarehouse."' 
		   GROUP BY idProduct,idProdSize ORDER BY pd.idProduct,ps.idProductsize";
		$resultWarehouseProduct=$this->adapter->query($qryWarehouseProduct,array());
		$resultsetWarehouseProduct=$resultWarehouseProduct->toArray();
		foreach ($resultsetWarehouseProduct as $key => $value) 
		{
			$idProduct=$value['idProduct'];
			$idProductsize=$value['idProdSize'];
		
		$resultsetWarehouseProduct[$key]['productSize']=$resultsetWarehouseProduct[$key]['productSize'].''.$resultsetWarehouseProduct[$key]['unitmeasure'];

			//get total stock
			if ($resultsetWarehouseProduct[$key]['expireDate']==1) 
			{
			$qryWHstock="SELECT SUM(WST.sku_accept_qty) AS whStockQty FROM whouse_stock_items AS WST 
			WHERE WST.idProduct='".$resultsetWarehouseProduct[$key]['idProduct']."' AND 
			WST.idProdSize='".$resultsetWarehouseProduct[$key]['idProdSize']."' 
			AND WST.idWarehouse='".$resultsetWarehouseProduct[$key]['idWarehouse']."' AND WST.sku_expiry_date>=NOW()";
			}
			else
			{
			$qryWHstock="SELECT SUM(WST.sku_accept_qty) AS whStockQty FROM whouse_stock_items AS WST 
			WHERE WST.idProduct='".$resultsetWarehouseProduct[$key]['idProduct']."' AND 
			WST.idProdSize='".$resultsetWarehouseProduct[$key]['idProdSize']."' 
			AND WST.idWarehouse='".$resultsetWarehouseProduct[$key]['idWarehouse']."'";
			}

			$resultWHstock=$this->adapter->query($qryWHstock,array());
			$resultsetWHstock=$resultWHstock->toArray();
			$ttlstockQty=($resultsetWHstock[0]['whStockQty']=='' || $resultsetWHstock[0]['whStockQty']==null)?0:$resultsetWHstock[0]['whStockQty'];
	        //get damage qty
			$qryWHdamage="SELECT SUM(WSD.dmg_prod_qty) AS whDamageQty FROM whouse_stock_damge AS WSD WHERE WSD.idProduct='".$resultsetWarehouseProduct[$key]['idProduct']."' AND WSD.idProdSize='".$resultsetWarehouseProduct[$key]['idProdSize']."'  AND WSD.idWarehouse='".$resultsetWarehouseProduct[$key]['idWarehouse']."'";
			$resultWHdamage=$this->adapter->query($qryWHdamage,array());
			$resultsetWHdamage=$resultWHdamage->toArray();
	        $ttldamageQty=($resultsetWHdamage[0]['whDamageQty']=='' || $resultsetWHdamage[0]['whDamageQty']==null)?0:$resultsetWHdamage[0]['whDamageQty'];
	        $finalDamageQty=0;
	        //damage qty convert into cases
             if ($ttldamageQty>0) 
             {
             	$primaryPackQty=$resultsetWarehouseProduct[$key]['productPrimaryCount'];
             	$DamageQtyCases=($ttldamageQty/$primaryPackQty);
             	$finalDamageQty=$DamageQtyCases;

             }
	         //get return qty(recieved qty EXample:SMS recieved from MS return qty)
			$qryWHreturn="SELECT SUM(COR.rtnQty) AS custRtnQty FROM customer_order_return AS COR LEFT JOIN dispatch_product_batch AS DPB ON COR.idDispatchProductBatch=DPB.idDispatchProductBatch LEFT JOIN whouse_stock_items AS WST ON WST.idWhStockItem=DPB.idWhStockItem WHERE WST.idProduct='".$resultsetWarehouseProduct[$key]['idProduct']."' AND WST.idProdSize='".$resultsetWarehouseProduct[$key]['idProdSize']."' AND WST.idWarehouse='".$resultsetWarehouseProduct[$key]['idWarehouse']."'";
			$resultWHreturn=$this->adapter->query($qryWHreturn,array());
			$resultsetWHreturn=$resultWHreturn->toArray();

			  $ttlRecievedQty=($resultsetWHreturn[0]['custRtnQty']=='')?0:$resultsetWHreturn[0]['custRtnQty'];

			  //get return qty (Example:return qty from SMS to Company)
				$qrycus="SELECT COR.rtnQty as proQty,DC.idCustomer,DC.idWarehouse from customer_order_return as COR
				LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer  where DC.idCustomer='".$idCustomer."'";

				$resultcus=$this->adapter->query($qrycus,array());
				$resultsetcus=$resultcus->toArray();
				$Customer=$resultsetcus[0]['idCustomer'];
				$war=$resultsetcus[0]['idWarehouse'];
				$cstReturnQty="SELECT 'returncustomer' as dataType,COR.rtnQty as proQty, COR.rtnDate as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce 
							  from customer_order_return as COR
							  LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
							  LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
							  LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
							  LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
							  where WHSI.idProduct='".$resultsetWarehouseProduct[$key]['idProduct']."' and WHSI.idProdSize='".$resultsetWarehouseProduct[$key]['idProdSize']."' and WHSI.idWarehouse='".$war."'";
				$resultcstReturnQty=$this->adapter->query($cstReturnQty,array());
				$resultsetcstReturnQty=$resultcstReturnQty->toArray();
				$ttlReturnQty=($resultsetcstReturnQty[0]['proQty']>0)?$resultsetcstReturnQty[0]['proQty']:0;

			  //order allocate qty
			$qryWHorder="SELECT SUM(WOI.picklistQty) AS whOrderQty FROM orders_allocated AS WO LEFT JOIN orders_allocated_items AS WOI ON WOI.idOrderallocated=WO.idOrderallocate WHERE WOI.idProduct='".$resultsetWarehouseProduct[$key]['idProduct']."' AND WOI.idProductsize='".$resultsetWarehouseProduct[$key]['idProdSize']."' AND WO.idWarehouse='".$resultsetWarehouseProduct[$key]['idWarehouse']."'";
			$resultWHorder=$this->adapter->query($qryWHorder,array());
			$resultsetWHorder=$resultWHorder->toArray();

			  $ttlorderQty=($resultsetWHorder[0]['whOrderQty']=='' || $resultsetWHorder[0]['whOrderQty']==null)?0:$resultsetWHorder[0]['whOrderQty'];
	           //available total stockqty

				$avlStockQtyVal=(($ttlstockQty+$ttlRecievedQty) - ($finalDamageQty+$ttlorderQty+$ttlReturnQty));
	            $tot_stock=number_format( $avlStockQtyVal,2,'.','');
                $resultsetWarehouseProduct[$key]['ttlorderQty']=$ttlorderQty;	
                $resultsetWarehouseProduct[$key]['ttlRecievedQty']=$ttlRecievedQty;	
                $resultsetWarehouseProduct[$key]['finalDamageQty']=$finalDamageQty;	
                $resultsetWarehouseProduct[$key]['ttlReturnQty']=$ttlReturnQty;	
	            $resultsetWarehouseProduct[$key]['stock']=$tot_stock;	
            //get reorder qty and reorder level
			$qryReorder="SELECT re_level,re_qty FROM `inventorynorms` WHERE idWarehouse='".$idWarehouse."' AND idProduct='".$idProduct."' AND idProdSize='".$idProductsize."'";
			$resultReorder=$this->adapter->query($qryReorder,array());
			$resultsetReorder=$resultReorder->toArray();
			$resultsetWarehouseProduct[$key]['re_level']=($resultsetReorder)?$resultsetReorder[0]['re_level']:'';
			$resultsetWarehouseProduct[$key]['re_qty']=($resultsetReorder)?$resultsetReorder[0]['re_qty']:'';
		

		}

		if(!$resultsetWarehouseProduct) {
		$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		} else {
		$ret_arr=['code'=>'2','content'=>$resultsetWarehouseProduct,'warehouseName'=>$warehouseName,'status'=>true,'message'=>'Record available'];
		}
		return $ret_arr; 


	}

	public function getSixmonthOrders($param)
	{
		$idCustomer=$param->id;
         $MonthProduct=array();
         $qryCustomer="SELECT cs_name,cs_population,cs_potential_value from customer WHERE idCustomer='".$idCustomer."'";
			$resultCustomer=$this->adapter->query($qryCustomer,array());
			$resultsetCustomer=$resultCustomer->toArray();
			for ($i = 0; $i < 6; $i++)
			{
			 // echo date('M-Y', strtotime(-$i . 'month'));
			  $MonthProduct[$i]['Month']=date('M-Y', strtotime(-$i . 'month'));
			   $MonthProduct[$i]['MonthYear']=date('m-Y', strtotime(-$i . 'month'));
			}
		
			foreach ($MonthProduct as $key => $value) {
			$qryOrders="SELECT count(idOrder) as totalOrders,sum(grandtotalAmount) as grandtotalAmount FROM `orders` WHERE idCustomer='".$idCustomer."' AND DATE_FORMAT(poDate,'%m-%Y')  BETWEEN '".$value['MonthYear']."' AND '".$value['MonthYear']."'";
			$resultOrders=$this->adapter->query($qryOrders,array());
			$resultsetOrders=$resultOrders->toArray();
			$MonthProduct[$key]['orderTotal']=($resultsetOrders[0]['totalOrders'])?$resultsetOrders[0]['totalOrders']:0;
			$MonthProduct[$key]['orderAmountTotal']=($resultsetOrders[0]['grandtotalAmount'])?$resultsetOrders[0]['grandtotalAmount']:0;

			$qryDispatch="SELECT count(idDispatchcustomer) as totalDispatch,sum(dc.invoice_amt) as totalInvoiceAmount FROM  dispatch_customer as dc 
		WHERE  dc.idCustomer='".$idCustomer."' AND  DATE_FORMAT(dc.delivery_date,'%m-%Y')  BETWEEN '".$value['MonthYear']."' AND '".$value['MonthYear']."'";
			$resultDispatch=$this->adapter->query($qryDispatch,array());
			$resultsetDispatch=$resultDispatch->toArray();

			 $MonthProduct[$key]['dispatchTotal']=($resultsetDispatch[0]['totalDispatch'])?$resultsetDispatch[0]['totalDispatch']:0;
			$MonthProduct[$key]['dispatchAmountTotal']=($resultsetDispatch[0]['totalInvoiceAmount'])?$resultsetDispatch[0]['totalInvoiceAmount']:0;

			}
			
		

			if(!$MonthProduct) {
		$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		} else {
		$ret_arr=['code'=>'2','content'=>$MonthProduct,'customer'=>$resultsetCustomer,'status'=>true,'message'=>'Record available'];
		}
		return $ret_arr; 

	}
    public function getSixmonthProducts($param)
    {
    	//print_r($param);
    	$idCustomer=$param->id;
    	$MonthProduct=array();
			for ($i = 0; $i < 6; $i++)
			{
			  //echo date('M-Y', strtotime(-$i . 'month'));
			  $MonthProduct[$i]['Month']=date('M-Y', strtotime(-$i . 'month'));
			   $MonthProduct[$i]['MonthYear']=date('m-Y', strtotime(-$i . 'month'));
			    $MonthProduct[$i]['status']=0;
			}

			$qryProduct="SELECT pd.idProduct,pd.productName,pd.productCount,ps.productSize,ps.idProductsize,(
		CASE
		WHEN pd.productCount = 1 THEN 'Units'
		WHEN pd.productCount = 2 THEN 'kg'
		WHEN pd.productCount = 3 THEN 'gm'
		WHEN pd.productCount = 4 THEN 'mgm'
		WHEN pd.productCount = 5 THEN 'mts'
		WHEN pd.productCount = 6 THEN 'cmts'
		WHEN pd.productCount = 7 THEN 'inches'
		WHEN pd.productCount = 8 THEN 'foot'
		WHEN pd.productCount = 9 THEN 'litre'
		WHEN pd.productCount = 10 THEN 'ml'

		END) as unitmeasure FROM `product_details` as pd LEFT JOIN product_size as ps ON pd.idProduct=ps.idProduct WHERE pd.status=1 AND ps.status=1 ORDER BY idProduct";
			$resultProduct=$this->adapter->query($qryProduct,array());
			$resultsetProduct=$resultProduct->toArray();
			foreach ($resultsetProduct as $key => $value) {
				$resultsetProduct[$key]['Month']=$MonthProduct;
			}

			foreach ($resultsetProduct as $key => $value) {
				foreach ($value['Month'] as $key1 => $value1) {
                 $qryOrders="SELECT *FROM `orders` as ord LEFT JOIN order_items as ordi ON ordi.idOrder=ord.idOrder WHERE ord.idCustomer='".$idCustomer."' AND DATE_FORMAT(poDate,'%m-%Y')  BETWEEN '".$value1['MonthYear']."' AND '".$value1['MonthYear']."' AND ordi.idProduct='".$value['idProduct']."' AND ordi.idProductsize='".$value['idProductsize']."'";
			$resultOrders=$this->adapter->query($qryOrders,array());
			$resultsetOrders=$resultOrders->toArray();
				if (count($resultsetOrders)>0) 
				{
					$resultsetProduct[$key]['Month'][$key1]['status']=1;
				}
					
				}
			}

		
			if(!$resultsetProduct) {
		$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		} else {
		$ret_arr=['code'=>'2','content'=>$resultsetProduct,'MonthProduct'=>$MonthProduct,'status'=>true,'message'=>'Record available'];
		}
		return $ret_arr; 
    }

    public function getServiceByCustomer($param)
    {
       
		$idServiceBy=$param->id;
		$geo2=$param->geo2;
		$geo3=$param->geo3;
		$startDate=date('Y-m-d',strtotime($param->startDate));
		$endDate=date('Y-m-d',strtotime($param->endDate));
		$qryCustomer="SELECT c.idCustomer,c.cs_name,count(o.idCustomer) as totalOrders,sum(o.grandtotalAmount) as totalOrderAmount FROM customer AS c 
		LEFT JOIN orders AS o ON o.idCustomer=c.idCustomer
		WHERE o.order_cancel=0 and c.G2='".$geo2."' AND c.G3='".$geo3."'  and o.poDate BETWEEN '".$startDate."' and '".$endDate."' AND c.cs_serviceby='".$idServiceBy."'  group by o.idCustomer";
		$resultCustomer=$this->adapter->query($qryCustomer,array());
		$resultsetCustomer=$resultCustomer->toArray();
		if (count($resultsetCustomer)>0)
		{
		  foreach ($resultsetCustomer as $key => $value) 
		  {
			$qryDispatch="SELECT count(idCustomer) as totalDispatch, sum(invoice_amt) as totalDispatchAmount from dispatch_customer where  idOrder in (SELECT idOrder from orders where idCustomer='".$value['idCustomer']."' and poDate BETWEEN '".$startDate."' and '".$endDate."')";
			$resultDispatch=$this->adapter->query($qryDispatch,array());
			$resultsetDispatch=$resultDispatch->toArray();
			$resultsetCustomer[$key]['totalDispatch']=($resultsetDispatch[0]['totalDispatch']>0)?$resultsetDispatch[0]['totalDispatch']:0;
			$resultsetCustomer[$key]['totalDispatchAmount']=($resultsetDispatch[0]['totalDispatchAmount']>0)?$resultsetDispatch[0]['totalDispatchAmount']:0;
		  }
		}

		if(!$resultsetCustomer) {
		$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		} else {
		$ret_arr=['code'=>'2','content'=>$resultsetCustomer,'status'=>true,'message'=>'Record available'];
		}
		return $ret_arr; 

		
    }

    public function orderNotGivenCustomers($param)
    {
      
		$idServiceBy=$param->id;
		$geo2=$param->geo2;
		$geo3=$param->geo3;
		$startDate=date('Y-m-d',strtotime($param->startDate));
		$endDate=date('Y-m-d',strtotime($param->endDate));
		$qryCustomer="SELECT c.idCustomer,c.cs_name,DATE_FORMAT(o.poDate,'%d-%m-%Y') as poDate,o.idOrder,o.grandtotalAmount,o.poNumber  FROM customer AS c
		LEFT JOIN orders AS o ON c.idCustomer=o.idCustomer
		WHERE c.G2='".$geo2."' AND c.G3='".$geo3."' and c.idCustomer NOT IN(SELECT c.idCustomer  FROM customer AS c LEFT JOIN orders AS o ON c.idCustomer=o.idCustomer WHERE c.G2='".$geo2."' AND c.G3='".$geo3."'  and o.poDate BETWEEN '".$startDate."' and '".$endDate."' and c.cs_serviceby='".$idServiceBy."' group by c.idCustomer) and c.cs_serviceby='".$idServiceBy."'  order by o.idCustomer desc";
		$resultCustomer=$this->adapter->query($qryCustomer,array());
		$resultsetCustomer=$resultCustomer->toArray();
		if(!$resultsetCustomer) {
		$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		} else {
		$ret_arr=['code'=>'2','content'=>$resultsetCustomer,'status'=>true,'message'=>'Record available'];
		}
		return $ret_arr; 
    }

    public function dayWiseStockLevel($param)
    {
     
      $idCustomer=$param->customer;
      $idCustomerType=$param->$custype;
      $startDate=date('Y-m-d',strtotime($param->startdate));
      $endDate=date('Y-m-d',strtotime($param->enddate));
      $header=array('S.No','Product','Size','Unit','UOM');
		$fromDate=date_create($startDate);
		$toDate=date_create($endDate);
		$diff=date_diff($fromDate,$toDate);
		// print_r($diff);
		// echo $diff->days;
		$totalDays=$diff->days;
		$totalDays=$totalDays+1;
		// echo $totalDays;
		//$dates=array();
		$qryProduct="SELECT pd.idProduct,pd.productName,pd.expireDate,pd.productCount ,ps.idProductsize,ps.productSize,pp.idPrimaryPackaging,pp.primarypackname,ps.productPrimaryCount,(
		CASE
		WHEN pd.productCount = 1 THEN 'Units'
		WHEN pd.productCount = 2 THEN 'kg'
		WHEN pd.productCount = 3 THEN 'gm'
		WHEN pd.productCount = 4 THEN 'mgm'
		WHEN pd.productCount = 5 THEN 'mts'
		WHEN pd.productCount = 6 THEN 'cmts'
		WHEN pd.productCount = 7 THEN 'inches'
		WHEN pd.productCount = 8 THEN 'foot'
		WHEN pd.productCount = 9 THEN 'litre'
		WHEN pd.productCount = 10 THEN 'ml'

		END) as unitmeasure FROM product_details as pd 
		LEFT JOIN product_size as ps ON pd.idProduct=ps.idProduct 
		LEFT JOIN primary_packaging as pp ON pp.idPrimaryPackaging=ps.idPrimaryPackaging 
		WHERE pd.status=1 AND ps.status=1  GROUP BY idProductsize ORDER BY idProduct";
		$resultProduct=$this->adapter->query($qryProduct,array());
		$resultsetProduct=$resultProduct->toArray();

		$qryWarehouse="SELECT idWarehouse from warehouse_master WHERE idCustomer='".$idCustomer."'";
		$resultWarehouse=$this->adapter->query($qryWarehouse,array());
		$resultsetWarehouse=$resultWarehouse->toArray();
		if(count($resultsetWarehouse)>0)
		{
			foreach ($resultsetWarehouse as $key => $value) 
			{
				$idWHArray[]=$value['idWarehouse'];
			}
           $idWarehouse=implode(',', $idWHArray); // search customer warehouse
		}
          
		for ($i=0; $i < $totalDays; $i++) 
		{ 
			$dateMonth=date('d-M-Y', strtotime($startDate. ' + '.$i.' days'));
			$dates[$i]['showdate']=$dateMonth;
			$dates[$i]['date']=date('Y-m-d', strtotime($startDate. ' + '.$i.' days'));
			array_push($header, $dateMonth);
		}
		foreach ($resultsetProduct as $key => $value) 
		{
			$resultsetProduct[$key]['prdSize']=$resultsetProduct[$key]['productSize'].''.$resultsetProduct[$key]['unitmeasure'];
			$resultsetProduct[$key]['date']=$dates;
		}


		foreach ($resultsetProduct as $key => $value) 
		{
			foreach ($value['date'] as $key1 => $value1) 
			{
                //get total stock
			if ($resultsetWarehouseProduct[$key]['expireDate']==1) 
			{
			$qryWHstock="SELECT SUM(WST.sku_accept_qty) AS whStockQty FROM whouse_stock_items AS WST 
			WHERE WST.idProduct='".$value['idProduct']."' AND 
			WST.idProdSize='".$value['idProductsize']."' 
			AND WST.idWarehouse IN($idWarehouse) AND DATE_FORMAT(WST.sku_entry_date,'Y-m-d')='".date('Y-m-d',strtotime($value1['date']))."'";
			}
			else
			{
			$qryWHstock="SELECT SUM(WST.sku_accept_qty) AS whStockQty FROM whouse_stock_items AS WST 
			WHERE WST.idProduct='".$value['idProduct']."' AND 
			WST.idProdSize='".$value['idProductsize']."' 
			AND WST.idWarehouse IN($idWarehouse) AND DATE_FORMAT(WST.sku_entry_date,'Y-m-d')='".date('Y-m-d',strtotime($value1['date']))."'";
			}

			$resultWHstock=$this->adapter->query($qryWHstock,array());
			$resultsetWHstock=$resultWHstock->toArray();
			$ttlstockQty=($resultsetWHstock[0]['whStockQty']=='' || $resultsetWHstock[0]['whStockQty']==null)?0:$resultsetWHstock[0]['whStockQty'];
	        //get damage qty
			$qryWHdamage="SELECT SUM(WSD.dmg_prod_qty) AS whDamageQty FROM whouse_stock_damge AS WSD WHERE WSD.idProduct='".$value['idProduct']."' AND WSD.idProdSize='".$value['idProductsize']."'  AND WSD.idWarehouse IN($idWarehouse) AND DATE_FORMAT(WSD.dmg_entry_date,'Y-m-d')='".date('Y-m-d',strtotime($value1['date']))."'";
			$resultWHdamage=$this->adapter->query($qryWHdamage,array());
			$resultsetWHdamage=$resultWHdamage->toArray();
	        $ttldamageQty=($resultsetWHdamage[0]['whDamageQty']=='' || $resultsetWHdamage[0]['whDamageQty']==null)?0:$resultsetWHdamage[0]['whDamageQty'];
	        $finalDamageQty=0;
	        //damage qty convert into cases
             if ($ttldamageQty>0) 
             {
             	$primaryPackQty=$resultsetProduct[$key]['productPrimaryCount'];
             	$DamageQtyCases=($ttldamageQty/$primaryPackQty);
             	$finalDamageQty=$DamageQtyCases;

             }
	         //get return qty(recieved qty EXample:SMS recieved from MS return qty)
			$qryWHreturn="SELECT SUM(COR.rtnQty) AS custRtnQty FROM customer_order_return AS COR LEFT JOIN dispatch_product_batch AS DPB ON COR.idDispatchProductBatch=DPB.idDispatchProductBatch LEFT JOIN whouse_stock_items AS WST ON WST.idWhStockItem=DPB.idWhStockItem WHERE WST.idProduct='".$value['idProduct']."' AND WST.idProdSize='".$value['idProductsize']."' AND WST.idWarehouse IN($idWarehouse)  AND DATE_FORMAT(COR.rtnDate,'Y-m-d')='".date('Y-m-d',strtotime($value1['date']))."'";
			$resultWHreturn=$this->adapter->query($qryWHreturn,array());
			$resultsetWHreturn=$resultWHreturn->toArray();

			  $ttlRecievedQty=($resultsetWHreturn[0]['custRtnQty']=='')?0:$resultsetWHreturn[0]['custRtnQty'];

			  //get return qty (Example:return qty from SMS to Company)
				$qrycus="SELECT COR.rtnQty as proQty,DC.idCustomer,DC.idWarehouse from customer_order_return as COR
				LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer  where DC.idCustomer='".$idCustomer."'";

				$resultcus=$this->adapter->query($qrycus,array());
				$resultsetcus=$resultcus->toArray();
				$Customer=$resultsetcus[0]['idCustomer'];
				$war=$resultsetcus[0]['idWarehouse'];
				$cstReturnQty="SELECT 'returncustomer' as dataType,COR.rtnQty as proQty, COR.rtnDate as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce 
							  from customer_order_return as COR
							  LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
							  LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
							  LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
							  LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
							  where WHSI.idProduct='".$value['idProduct']."' and WHSI.idProdSize='".$value['idProductsize']."' and WHSI.idWarehouse='".$war."' AND DATE_FORMAT(COR.rtnDate,'Y-m-d')='".date('Y-m-d',strtotime($value1['date']))."'";
				$resultcstReturnQty=$this->adapter->query($cstReturnQty,array());
				$resultsetcstReturnQty=$resultcstReturnQty->toArray();
				$ttlReturnQty=($resultsetcstReturnQty[0]['proQty']>0)?$resultsetcstReturnQty[0]['proQty']:0;

			  //order allocate qty
			$qryWHorder="SELECT SUM(WOI.picklistQty) AS whOrderQty FROM orders_allocated AS WO LEFT JOIN orders_allocated_items AS WOI ON WOI.idOrderallocated=WO.idOrderallocate WHERE WOI.idProduct='".$value['idProduct']."' AND WOI.idProductsize='".$value['idProductsize']."' AND WO.idWarehouse IN($idWarehouse)  AND DATE_FORMAT(WO.created_at,'Y-m-d')='".date('Y-m-d',strtotime($value1['date']))."'";
			$resultWHorder=$this->adapter->query($qryWHorder,array());
			$resultsetWHorder=$resultWHorder->toArray();

			  $ttlorderQty=($resultsetWHorder[0]['whOrderQty']=='' || $resultsetWHorder[0]['whOrderQty']==null)?0:$resultsetWHorder[0]['whOrderQty'];
	           //available total stockqty

				$avlStockQtyVal=(($ttlstockQty+$ttlRecievedQty) - ($finalDamageQty+$ttlorderQty+$ttlReturnQty));
	            $tot_stock=number_format( $avlStockQtyVal,2,'.','');
                $resultsetProduct[$key]['date'][$key1]['ttlorderQty']=$ttlorderQty;	
                $resultsetProduct[$key]['date'][$key1]['ttlRecievedQty']=$ttlRecievedQty;	
                $resultsetProduct[$key]['date'][$key1]['finalDamageQty']=$finalDamageQty;	
                $resultsetProduct[$key]['date'][$key1]['ttlReturnQty']=$ttlReturnQty;	
	            $resultsetProduct[$key]['date'][$key1]['stock']=$tot_stock;	  
			}
		}

		if(!$resultsetProduct) {
		$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		} else {
		$ret_arr=['code'=>'2','content'=>$resultsetProduct,'showDate'=>$dates,'header'=>$header,'status'=>true,'message'=>'Record available'];
		}
		return $ret_arr; 
		
			
    }

    public function stockistStockLevel($param)
    {
       
		$idCustomer=$param->customer;
		$idCustomerType=$param->custype;
		$qryProduct="SELECT pd.idProduct,pd.productName,pd.expireDate,pd.productCount ,ps.idProductsize,ps.productSize,pp.idPrimaryPackaging,pp.primarypackname,ps.productPrimaryCount,(
		CASE
		WHEN pd.productCount = 1 THEN 'Units'
		WHEN pd.productCount = 2 THEN 'kg'
		WHEN pd.productCount = 3 THEN 'gm'
		WHEN pd.productCount = 4 THEN 'mgm'
		WHEN pd.productCount = 5 THEN 'mts'
		WHEN pd.productCount = 6 THEN 'cmts'
		WHEN pd.productCount = 7 THEN 'inches'
		WHEN pd.productCount = 8 THEN 'foot'
		WHEN pd.productCount = 9 THEN 'litre'
		WHEN pd.productCount = 10 THEN 'ml'

		END) as unitmeasure FROM product_details as pd 
		LEFT JOIN product_size as ps ON pd.idProduct=ps.idProduct 
		LEFT JOIN primary_packaging as pp ON pp.idPrimaryPackaging=ps.idPrimaryPackaging 
		WHERE pd.status=1 AND ps.status=1  GROUP BY idProductsize ORDER BY idProduct";
		$resultProduct=$this->adapter->query($qryProduct,array());
		$resultsetProduct=$resultProduct->toArray();

		$qryWarehouse="SELECT idWarehouse,warehouseName from warehouse_master WHERE idCustomer='".$idCustomer."'";
		$resultWarehouse=$this->adapter->query($qryWarehouse,array());
		$resultsetWarehouse=$resultWarehouse->toArray();
		if(count($resultsetWarehouse)>0)
		{
			foreach ($resultsetWarehouse as $key => $value) 
			{
				$idWHArray[]=$value['idWarehouse'];

			}
           $idWarehouse=implode(',', $idWHArray); // search customer warehouse
		}
          
		
		foreach ($resultsetProduct as $key => $value) 
		{
			$resultsetProduct[$key]['prdSize']=$resultsetProduct[$key]['productSize'].''.$resultsetProduct[$key]['unitmeasure'];
			$resultsetProduct[$key]['warehouse']=$resultsetWarehouse;
			
		}


		foreach ($resultsetProduct as $key => $value) 
		{

			foreach ($value['warehouse'] as $key1 => $value1) 
			{
				$ttlstockQty=0; 
				$ttlRecievedQty=0; 
				$finalDamageQty=0; 
				$ttlorderQty=0; 
				$ttlReturnQty=0;
				$avlStockQtyVal=0;
				$tot_stock=0;
			
				if ($resultsetWarehouseProduct[$key]['expireDate']==1) 
				{
					$qryWHstock="SELECT SUM(WST.sku_accept_qty) AS whStockQty FROM whouse_stock_items AS WST 
					WHERE WST.idProduct='".$value['idProduct']."' AND 
					WST.idProdSize='".$value['idProductsize']."' 
					AND WST.idWarehouse='".$value1['idWarehouse']."'";
				}
				else
				{
					$qryWHstock="SELECT SUM(WST.sku_accept_qty) AS whStockQty FROM whouse_stock_items AS WST 
					WHERE WST.idProduct='".$value['idProduct']."' AND 
					WST.idProdSize='".$value['idProductsize']."' 
					AND WST.idWarehouse='".$value1['idWarehouse']."' ";
				}

				$resultWHstock=$this->adapter->query($qryWHstock,array());
				$resultsetWHstock=$resultWHstock->toArray();
				$ttlstockQty=($resultsetWHstock[0]['whStockQty']=='' || $resultsetWHstock[0]['whStockQty']==null)?0:$resultsetWHstock[0]['whStockQty'];
				if ($ttlstockQty>0) 
				{
					//get damage qty
				$qryWHdamage="SELECT SUM(WSD.dmg_prod_qty) AS whDamageQty FROM whouse_stock_damge AS WSD WHERE WSD.idProduct='".$value['idProduct']."' AND WSD.idProdSize='".$value['idProductsize']."'  AND WSD.idWarehouse='".$value1['idWarehouse']."'";
				$resultWHdamage=$this->adapter->query($qryWHdamage,array());
				$resultsetWHdamage=$resultWHdamage->toArray();
				$ttldamageQty=($resultsetWHdamage[0]['whDamageQty']=='' || $resultsetWHdamage[0]['whDamageQty']==null)?0:$resultsetWHdamage[0]['whDamageQty'];
				$finalDamageQty=0;
          //damage qty convert into cases
				if ($ttldamageQty>0) 
				{
					$primaryPackQty=$resultsetProduct[$key]['productPrimaryCount'];
					$DamageQtyCases=($ttldamageQty/$primaryPackQty);
					$finalDamageQty=$DamageQtyCases;

				}
          //get return qty(recieved qty EXample:SMS recieved from MS return qty)
				$qryWHreturn="SELECT SUM(COR.rtnQty) AS custRtnQty FROM customer_order_return AS COR LEFT JOIN dispatch_product_batch AS DPB ON COR.idDispatchProductBatch=DPB.idDispatchProductBatch LEFT JOIN whouse_stock_items AS WST ON WST.idWhStockItem=DPB.idWhStockItem WHERE WST.idProduct='".$value['idProduct']."' AND WST.idProdSize='".$value['idProductsize']."' AND WST.idWarehouse='".$value1['idWarehouse']."' ";
				$resultWHreturn=$this->adapter->query($qryWHreturn,array());
				$resultsetWHreturn=$resultWHreturn->toArray();

				$ttlRecievedQty=($resultsetWHreturn[0]['custRtnQty']=='')?0:$resultsetWHreturn[0]['custRtnQty'];

          //get return qty (Example:return qty from SMS to Company)
				$qrycus="SELECT COR.rtnQty as proQty,DC.idCustomer,DC.idWarehouse from customer_order_return as COR
				LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer  where DC.idCustomer='".$idCustomer."'";

				$resultcus=$this->adapter->query($qrycus,array());
				$resultsetcus=$resultcus->toArray();
				$Customer=$resultsetcus[0]['idCustomer'];
				$war=$resultsetcus[0]['idWarehouse'];
				$cstReturnQty="SELECT 'returncustomer' as dataType,COR.rtnQty as proQty, COR.rtnDate as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce 
				from customer_order_return as COR
				LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
				LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
				LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
				LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
				where WHSI.idProduct='".$value['idProduct']."' and WHSI.idProdSize='".$value['idProductsize']."' and WHSI.idWarehouse='".$war."' ";
				$resultcstReturnQty=$this->adapter->query($cstReturnQty,array());
				$resultsetcstReturnQty=$resultcstReturnQty->toArray();
				$ttlReturnQty=($resultsetcstReturnQty[0]['proQty']>0)?$resultsetcstReturnQty[0]['proQty']:0;
           //order allocate qty
				$qryWHorder="SELECT SUM(WOI.picklistQty) AS whOrderQty FROM orders_allocated AS WO LEFT JOIN orders_allocated_items AS WOI ON WOI.idOrderallocated=WO.idOrderallocate WHERE WOI.idProduct='".$value['idProduct']."' AND WOI.idProductsize='".$value['idProductsize']."' AND WO.idWarehouse='".$value1['idWarehouse']."' ";
				$resultWHorder=$this->adapter->query($qryWHorder,array());
				$resultsetWHorder=$resultWHorder->toArray();

				$ttlorderQty=($resultsetWHorder[0]['whOrderQty']=='' || $resultsetWHorder[0]['whOrderQty']==null)?0:$resultsetWHorder[0]['whOrderQty'];
           //available total stockqty

				$avlStockQtyVal=(($ttlstockQty+$ttlRecievedQty) - ($finalDamageQty+$ttlorderQty+$ttlReturnQty));
				$tot_stock=number_format( $avlStockQtyVal,2,'.','');
				$resultsetProduct[$key]['warehouse'][$key1]['ttlorderQty']=$ttlorderQty;	
				$resultsetProduct[$key]['warehouse'][$key1]['ttlRecievedQty']=$ttlRecievedQty;	
				$resultsetProduct[$key]['warehouse'][$key1]['finalDamageQty']=$finalDamageQty;	
				$resultsetProduct[$key]['warehouse'][$key1]['ttlReturnQty']=$ttlReturnQty;	
				$resultsetProduct[$key]['warehouse'][$key1]['stock']=$tot_stock;
				}
				else
				{
					$resultsetProduct[$key]['warehouse'][$key1]['ttlorderQty']=0.00;	
				$resultsetProduct[$key]['warehouse'][$key1]['ttlRecievedQty']=0.00;	
				$resultsetProduct[$key]['warehouse'][$key1]['finalDamageQty']=0.00;	
				$resultsetProduct[$key]['warehouse'][$key1]['ttlReturnQty']=0.00;	
				$resultsetProduct[$key]['warehouse'][$key1]['stock']=0.00;
				}
       

				//get reorder qty and reorder level
			$qryReorder="SELECT re_level,re_qty FROM `inventorynorms` WHERE idWarehouse='".$value1['idWarehouse']."' AND idProduct='".$idProduct."' AND idProdSize='".$idProductsize."'";
			$resultReorder=$this->adapter->query($qryReorder,array());
			$resultsetReorder=$resultReorder->toArray();
			$resultsetProduct[$key]['warehouse'][$key1]['re_level']=($resultsetReorder)?$resultsetReorder[0]['re_level']:'';
			$resultsetProduct[$key]['warehouse'][$key1]['re_qty']=($resultsetReorder)?$resultsetReorder[0]['re_qty']:'';	
			}
     


		}


		if(!$resultsetProduct) {
		$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		} else {
		$ret_arr=['code'=>'2','content'=>$resultsetProduct,'warehouse'=>$resultsetWarehouse,'status'=>true,'message'=>'Record available'];
		}
		return $ret_arr; 
    }

    public function warehouseList($param)
    {
    	$idCustomer=$param->idCustomer;
		$qryWarehouse="SELECT *FROM warehouse_master WHERE idCustomer='".$idCustomer."'";
		$resultWarehouse=$this->adapter->query($qryWarehouse,array());
		$resultsetWarehouse=$resultWarehouse->toArray();

		if(!$resultsetWarehouse) {
		$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		} else {
		$ret_arr=['code'=>'2','content'=>$resultsetWarehouse,'status'=>true,'message'=>'Record available'];
		}
		return $ret_arr; 	
    }

    public function warehouseStockLevel($param)
    {
    	$idCustomer=$param->idCustomer;
		$idCustomerType=$param->user_type;
		$fields=$param->Form;
		$idWarehouse=$fields['warehouse'];
		$startDate=date('Y-m-d',strtotime($fields['startdate']));
		$endDate=date('Y-m-d',strtotime($fields['lastdate']));
		
	
		$qryProduct="SELECT pd.idProduct,pd.productName,pd.expireDate,pd.productCount ,ps.idProductsize,ps.productSize,pp.idPrimaryPackaging,pp.primarypackname,ps.productPrimaryCount,(
		CASE
		WHEN pd.productCount = 1 THEN 'Units'
		WHEN pd.productCount = 2 THEN 'kg'
		WHEN pd.productCount = 3 THEN 'gm'
		WHEN pd.productCount = 4 THEN 'mgm'
		WHEN pd.productCount = 5 THEN 'mts'
		WHEN pd.productCount = 6 THEN 'cmts'
		WHEN pd.productCount = 7 THEN 'inches'
		WHEN pd.productCount = 8 THEN 'foot'
		WHEN pd.productCount = 9 THEN 'litre'
		WHEN pd.productCount = 10 THEN 'ml'

		END) as unitmeasure FROM product_details as pd 
		LEFT JOIN product_size as ps ON pd.idProduct=ps.idProduct 
		LEFT JOIN primary_packaging as pp ON pp.idPrimaryPackaging=ps.idPrimaryPackaging 
		WHERE pd.status=1 AND ps.status=1  GROUP BY idProductsize ORDER BY idProduct";
		$resultProduct=$this->adapter->query($qryProduct,array());
		$resultsetProduct=$resultProduct->toArray();

		$qryWarehouse="SELECT idWarehouse,warehouseName from warehouse_master WHERE idWarehouse='".$idWarehouse."'";
		$resultWarehouse=$this->adapter->query($qryWarehouse,array());
		$resultsetWarehouse=$resultWarehouse->toArray();
		
		
		foreach ($resultsetProduct as $key => $value) 
		{
			$resultsetProduct[$key]['prdSize']=$resultsetProduct[$key]['productSize'].''.$resultsetProduct[$key]['unitmeasure'];
			
			
		}


		foreach ($resultsetProduct as $key => $value) 
		{

			
				$ttlstockQty=0; 
				$ttlRecievedQty=0; 
				$finalDamageQty=0; 
				$ttlorderQty=0; 
				$ttlReturnQty=0;
				$avlStockQtyVal=0;
				$tot_stock=0;
			
				if ($resultsetWarehouseProduct[$key]['expireDate']==1) 
				{
					$qryWHstock="SELECT SUM(WST.sku_accept_qty) AS whStockQty FROM whouse_stock_items AS WST 
					WHERE WST.idProduct='".$value['idProduct']."' AND 
					WST.idProdSize='".$value['idProductsize']."' 
					AND WST.idWarehouse='".$idWarehouse."' AND DATE_FORMAT(WST.sku_entry_date,'%Y-%m-%d')  BETWEEN '".$startDate."' AND '".$endDate."'";
				}
				else
				{
					$qryWHstock="SELECT SUM(WST.sku_accept_qty) AS whStockQty FROM whouse_stock_items AS WST 
					WHERE WST.idProduct='".$value['idProduct']."' AND 
					WST.idProdSize='".$value['idProductsize']."' 
					AND WST.idWarehouse='".$idWarehouse."' AND DATE_FORMAT(WST.sku_entry_date,'%Y-%m-%d')  BETWEEN '".$startDate."' AND '".$endDate."'";
				}

				$resultWHstock=$this->adapter->query($qryWHstock,array());
				$resultsetWHstock=$resultWHstock->toArray();
				$ttlstockQty=($resultsetWHstock[0]['whStockQty']=='' || $resultsetWHstock[0]['whStockQty']==null)?0:$resultsetWHstock[0]['whStockQty'];
			
				if ($ttlstockQty>0) 
				{
					//get damage qty
				$qryWHdamage="SELECT SUM(WSD.dmg_prod_qty) AS whDamageQty FROM whouse_stock_damge AS WSD WHERE WSD.idProduct='".$value['idProduct']."' AND WSD.idProdSize='".$value['idProductsize']."'  AND WSD.idWarehouse='".$idWarehouse."' AND DATE_FORMAT(WSD.dmg_entry_date,'%Y-%m-%d')  BETWEEN '".$startDate."' AND '".$endDate."'";
				$resultWHdamage=$this->adapter->query($qryWHdamage,array());
				$resultsetWHdamage=$resultWHdamage->toArray();
				$ttldamageQty=($resultsetWHdamage[0]['whDamageQty']=='' || $resultsetWHdamage[0]['whDamageQty']==null)?0:$resultsetWHdamage[0]['whDamageQty'];
				$finalDamageQty=0;
          //damage qty convert into cases
				if ($ttldamageQty>0) 
				{
					$primaryPackQty=$resultsetProduct[$key]['productPrimaryCount'];
					$DamageQtyCases=($ttldamageQty/$primaryPackQty);
					$finalDamageQty=$DamageQtyCases;

				}
          //get return qty(recieved qty EXample:SMS recieved from MS return qty)
				$qryWHreturn="SELECT SUM(COR.rtnQty) AS custRtnQty FROM customer_order_return AS COR LEFT JOIN dispatch_product_batch AS DPB ON COR.idDispatchProductBatch=DPB.idDispatchProductBatch LEFT JOIN whouse_stock_items AS WST ON WST.idWhStockItem=DPB.idWhStockItem WHERE WST.idProduct='".$value['idProduct']."' AND WST.idProdSize='".$value['idProductsize']."' AND WST.idWarehouse='".$idWarehouse."' AND DATE_FORMAT(COR.rtnDate,'%Y-%m-%d')  BETWEEN '".$startDate."' AND '".$endDate."'";
				$resultWHreturn=$this->adapter->query($qryWHreturn,array());
				$resultsetWHreturn=$resultWHreturn->toArray();

				$ttlRecievedQty=($resultsetWHreturn[0]['custRtnQty']=='')?0:$resultsetWHreturn[0]['custRtnQty'];

          //get return qty (Example:return qty from SMS to Company)
				$qrycus="SELECT COR.rtnQty as proQty,DC.idCustomer,DC.idWarehouse from customer_order_return as COR
				LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer  where DC.idCustomer='".$idCustomer."'";

				$resultcus=$this->adapter->query($qrycus,array());
				$resultsetcus=$resultcus->toArray();
				$Customer=$resultsetcus[0]['idCustomer'];
				$war=$resultsetcus[0]['idWarehouse'];
				$cstReturnQty="SELECT 'returncustomer' as dataType,COR.rtnQty as proQty, COR.rtnDate as entryDate,O.poNumber as PORefernce, COR.credit_note_no as DocRefernce 
				from customer_order_return as COR
				LEFT JOIN dispatch_product_batch as DPB ON DPB.idDispatchProductBatch=COR.idDispatchProductBatch
				LEFT JOIN dispatch_customer as DC ON COR.idDispatchcustomer=DC.idDispatchcustomer 
				LEFT JOIN orders as O ON DC.idOrder=O.idOrder  
				LEFT JOIN whouse_stock_items as WHSI ON WHSI.idWhStockItem=DPB.idWhStockItem 
				where WHSI.idProduct='".$value['idProduct']."' and WHSI.idProdSize='".$value['idProductsize']."' and WHSI.idWarehouse='".$war."' AND DATE_FORMAT(COR.rtnDate,'%Y-%m-%d')  BETWEEN '".$startDate."' AND '".$endDate."' ";
				$resultcstReturnQty=$this->adapter->query($cstReturnQty,array());
				$resultsetcstReturnQty=$resultcstReturnQty->toArray();
				$ttlReturnQty=($resultsetcstReturnQty[0]['proQty']>0)?$resultsetcstReturnQty[0]['proQty']:0;
           //order allocate qty
				$qryWHorder="SELECT SUM(WOI.picklistQty) AS whOrderQty FROM orders_allocated AS WO LEFT JOIN orders_allocated_items AS WOI ON WOI.idOrderallocated=WO.idOrderallocate WHERE WOI.idProduct='".$value['idProduct']."' AND WOI.idProductsize='".$value['idProductsize']."' AND WO.idWarehouse='".$idWarehouse."' AND DATE_FORMAT(WO.created_at,'%Y-%m-%d')  BETWEEN '".$startDate."' AND '".$endDate."' ";
				$resultWHorder=$this->adapter->query($qryWHorder,array());
				$resultsetWHorder=$resultWHorder->toArray();

				$ttlorderQty=($resultsetWHorder[0]['whOrderQty']=='' || $resultsetWHorder[0]['whOrderQty']==null)?0:$resultsetWHorder[0]['whOrderQty'];
           //available total stockqty

				$avlStockQtyVal=(($ttlstockQty+$ttlRecievedQty) - ($finalDamageQty+$ttlorderQty+$ttlReturnQty));
				$tot_stock=number_format( $avlStockQtyVal,2,'.','');
				
				$resultsetProduct[$key]['openingBalance']=number_format( $ttlstockQty,2,'.',''); //opening balance
				$resultsetProduct[$key]['ttlorderQty']=number_format($ttlorderQty,2,'.','');	//allocate qty
				$resultsetProduct[$key]['ttlRecievedQty']=number_format($ttlRecievedQty,2,'.',''); //recieved qty	
				$resultsetProduct[$key]['DamageQty']=number_format($finalDamageQty,2,'.','');	//damage qty
				$resultsetProduct[$key]['ttlReturnQty']=number_format($ttlReturnQty,2,'.','');	//return qty
				$resultsetProduct[$key]['IssuedQty']=number_format(($ttlReturnQty+$ttlorderQty),2,'.',''); //isued qty
				$resultsetProduct[$key]['closingBalance']=number_format($tot_stock,2,'.','');  //closing balance
				}
				else
				{
				$resultsetProduct[$key]['openingBalance']=number_format( $ttlstockQty,2,'.',''); //opening balancettlorderQty
				$resultsetProduct[$key]['ttlorderQty']=number_format( $ttlorderQty,2,'.','');	
				$resultsetProduct[$key]['ttlRecievedQty']=number_format( $ttlRecievedQty,2,'.',''); //recieved qty	
				$resultsetProduct[$key]['DamageQty']=number_format( $finalDamageQty,2,'.','');	//damage qty
				$resultsetProduct[$key]['ttlReturnQty']=number_format( $ttlReturnQty,2,'.','');	//return qty
				$resultsetProduct[$key]['IssuedQty']=number_format( ($ttlReturnQty+$ttlorderQty),2,'.',''); //isued qty
				$resultsetProduct[$key]['closingBalance']=number_format( $tot_stock,2,'.','');  //closing balance
				}
       

		}


		if(!$resultsetProduct) {
		$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		} else {
		$ret_arr=['code'=>'2','content'=>$resultsetProduct,'status'=>true,'message'=>'Record available'];
		}
		return $ret_arr;
    }

    public function warehouseStockDamage($param)
    {
    	
			$idCustomer=$param->idCustomer;
			$idCustomerType=$param->user_type;
			$fields=$param->Form;
			$idWarehouse=$fields['warehouse'];
			$startDate=date('Y-m-d',strtotime($fields['startdate']));
			$endDate=date('Y-m-d',strtotime($fields['lastdate']));

			$qryDamageStock="SELECT WHD.idProduct,
			WHD.dmg_prod_qty,
			WHD.idProdSize,
			WHD.dmg_batch_no,
			PRO.productName,
			PRO.productUnit,
			SIZE.productSize,
			PKG.primarypackname,
			SIZE.productPrimaryCount,
			WSI.sku_mf_date,
			w.t1 ,w.t2 ,w.t3 ,w.t4 ,w.t5 ,w.t7 ,w.t6 ,w.t8 ,w.t9 ,w.t10 ,(
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
			FROM whouse_stock_damge AS WHD 
			LEFT JOIN product_details AS PRO ON WHD.idProduct=PRO.idProduct 
			LEFT JOIN product_size AS SIZE ON WHD.idProdSize=SIZE.idProductsize 
			LEFT JOIN primary_packaging AS PKG ON SIZE.idPrimaryPackaging=PKG.idPrimaryPackaging 
			LEFT JOIN whouse_stock_items as WSI ON WSI.idWhStockItem=WHD.idWhStockItem 
			LEFT JOIN warehouse_master as w ON WSI.idWarehouse=w.idWarehouse
			WHERE  
			 WHD.idWarehouse='".$idWarehouse."'  AND DATE_FORMAT(WHD.dmg_entry_date,'%Y-%m-%d')  BETWEEN '".$startDate."' AND '".$endDate."'";
			
			$resultDamageStock=$this->adapter->query($qryDamageStock,array());
			$resultsetDamageStock=$resultDamageStock->toArray();
			if (count($resultsetDamageStock)>0) {
				foreach ($resultsetDamageStock as $key => $value) {
					$resultsetDamageStock[$key]['productSize']=$resultsetDamageStock[$key]['productSize']."".$resultsetDamageStock[$key]['unitmeasure'];

					
					$qryPrice="SELECT priceAmount FROM `price_fixing` WHERE idProduct='".$value['idProduct']."' AND idProductsize='".$value['idProdSize']."' AND (idTerritory='".$value['t1']."' OR idTerritory='".$value['t2']."' OR idTerritory='".$value['t3']."' OR idTerritory='".$value['t4']."' OR idTerritory='".$value['t5']."' OR idTerritory='".$value['t6']."' OR idTerritory='".$value['t7']."' OR idTerritory='".$value['t8']."' OR idTerritory='".$value['t9']."' OR idTerritory='".$value['t10']."')  AND priceDate<='".$value['sku_mf_date']."' ORDER BY priceDate DESC  LIMIT 1";
					$resultPrice=$this->adapter->query($qryPrice,array());
					$resultsetPrice=$resultPrice->toArray();

					$dmgQty=$value['dmg_prod_qty']/$value['productPrimaryCount'];
					$subTotal=$dmgQty*$resultsetPrice[0]['priceAmount'];
					$resultsetDamageStock[$key]['damageUnit']=$dmgQty;
					$resultsetDamageStock[$key]['damageCost']=$subTotal;
					$resultsetDamageStock[$key]['unitCost']=($subTotal/$dmgQty);
					$resultsetDamageStock[$key]['sku_mf_date']=date('d-m-Y',strtotime($resultsetDamageStock[$key]['sku_mf_date']));
				}
			}

			if(!$resultsetDamageStock) {
		$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		} else {
		$ret_arr=['code'=>'2','content'=>$resultsetDamageStock,'status'=>true,'message'=>'Record available'];
		}
		return $ret_arr;
    }

    public function warehouseStockRDRMCustomer($param)
    {
      
       $fields=$param->Form;
       $idWarehouse=$fields['warehouse'];
       $startDate=date('Y-m-d',strtotime($fields['startdate']));
       $endDate=date('Y-m-d',strtotime($fields['lastdate'].' +1 day'));
       $RDRM=$fields['returndamage'];
       $idCustomer=$param->idCustomer;

       if($RDRM==1){
			
			$qryRDRM="SELECT cs.cs_name,dc.idDispatchcustomer,cr.credit_note_no FROM customer_order_return as cr LEFT JOIN dispatch_customer as dc ON dc.idDispatchcustomer=cr.idDispatchcustomer  LEFT JOIN customer as cs ON dc.idCustomer=cs.idCustomer  WHERE dc.idWarehouse='".$idWarehouse."' AND (DATE_FORMAT(cr.rtnDate,'%Y-%m-%d')  BETWEEN '".$startDate."' AND '".$endDate."') GROUP by cr.credit_note_no";
			
		}elseif($RDRM==2){
			
			$qryRDRM="SELECT cs.cs_name,dc.idDispatchcustomer,cr.credit_note_no FROM  customer_order_damges as cr LEFT JOIN dispatch_customer as dc ON dc.idDispatchcustomer=cr.idDispatchcustomer  LEFT JOIN customer as cs ON dc.idCustomer=cs.idCustomer  WHERE dc.idWarehouse='".$idWarehouse."' AND (DATE_FORMAT(cr.dmgRtnDate,'%Y-%m-%d')  BETWEEN '".$startDate."' AND '".$endDate."') GROUP by cr.credit_note_no";
			
		}elseif($RDRM==3){
			
			$qryRDRM="SELECT cs.cs_name,dc.idDispatchcustomer,cr.credit_note_no FROM  customer_order_replacement as cr LEFT JOIN dispatch_customer as dc ON dc.idDispatchcustomer=cr.idDispatchcustomer  LEFT JOIN customer as cs ON dc.idCustomer=cs.idCustomer  WHERE dc.idWarehouse='".$idWarehouse."' AND (DATE_FORMAT(cr.replaceDate,'%Y-%m-%d')  BETWEEN '".$startDate."' AND '".$endDate."') GROUP by cr.credit_note_no";
			
		}elseif($RDRM==4){
			
			$qryRDRM="SELECT cs.cs_name,dc.idDispatchcustomer,cr.credit_note_no FROM  customer_order_missing as cr LEFT JOIN dispatch_customer as dc ON dc.idDispatchcustomer=cr.idDispatchcustomer  LEFT JOIN customer as cs ON dc.idCustomer=cs.idCustomer  WHERE dc.idWarehouse='".$idWarehouse."' AND (DATE_FORMAT(cr.missing_entry_date,'%Y-%m-%d')  BETWEEN '".$startDate."' AND '".$endDate."') GROUP by cr.credit_note_no";
			
		}

		$resultRDRM=$this->adapter->query($qryRDRM,array());
		$resultsetRDRM=$resultRDRM->toArray();
 
		if(!$resultsetRDRM) {
		$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		} else {
		$ret_arr=['code'=>'2','content'=>$resultsetRDRM,'status'=>true,'message'=>'Record available'];
		}
		return $ret_arr;

    }

    public function warehouseStockRDRMProduct($param)
    {

    	$creditNoteNo=$param->credinote;
    	$idDispatchCustomer=$param->id;
    	$chooseRDRM=$param->RDRM;
       if($chooseRDRM==1){	
		
		$qryRDRMProduct="SELECT dp.idDispatchProduct,
db.idDispatchProductBatch,sum(rt.rtnQty) AS dmgUnit,
credit_note_no,
rt.rtnDate, 
pr.productName, 
pr.productUnit, 
ps.productSize, 
pt.primarypackname,ps.productPrimaryCount,
dc.invoiceNo, 
dc.idOrder,
cs.cs_name, 
cs.cs_tinno,
dp.idProduct,
dp.idProdSize 
,ps.idPrimaryPackaging,
cs.G1,cs.G2,cs.G3,cs.G4,cs.G5,cs.G6 ,cs.G7,cs.G8,cs.G9,cs.G10,cs.cs_type,cs.cs_cmsn_type,
dc.tax_status AS t_status,pr.idHsncode,(
			CASE
			WHEN pr.productCount = 1 THEN 'Units'
			WHEN pr.productCount = 2 THEN 'kg'
			WHEN pr.productCount = 3 THEN 'gm'
			WHEN pr.productCount = 4 THEN 'mgm'
			WHEN pr.productCount = 5 THEN 'mts'
			WHEN pr.productCount = 6 THEN 'cmts'
			WHEN pr.productCount = 7 THEN 'inches'
			WHEN pr.productCount = 8 THEN 'foot'
			WHEN pr.productCount = 9 THEN 'litre'
			WHEN pr.productCount = 10 THEN 'ml'

			END) as unitmeasure
from customer_order_return AS rt 
LEFT JOIN dispatch_product_batch AS db ON rt.idDispatchProductBatch=db.idDispatchProductBatch 
LEFT JOIN dispatch_product AS dp ON db.idDispatchProduct=dp.idDispatchProduct
LEFT JOIN dispatch_customer AS dc ON rt.idDispatchcustomer=dc.idDispatchcustomer
LEFT JOIN orders as ord ON dc.idOrder=ord.idOrder
LEFT JOIN customer as cs ON dc.idCustomer=cs.idCustomer 
LEFT JOIN product_details as pr ON dp.idProduct=pr.idProduct 
LEFT JOIN product_size as ps ON dp.idProdSize=ps.idProductsize 
LEFT JOIN primary_packaging as pt ON ps.idPrimaryPackaging=pt.idPrimaryPackaging 
where rt.idDispatchcustomer='".$idDispatchCustomer."' and rt.credit_note_no='".$creditNoteNo."' group by dp.idDispatchProduct";
	}elseif($chooseRDRM==2){	
	
		$qryRDRMProduct="SELECT dp.idDispatchProduct,db.idDispatchProductBatch,sum(rt.dmgUnit) AS dmgUnit,sum(rt.dmgQty) AS dgQty, rt.credit_note_no,rt.dmgRtnDate, pr.productName, pr.productUnit, ps.productSize, pt.primarypackname,ps.productPrimaryCount,dc.invoiceNo, dc.idOrder,cs.cs_name, cs.cs_tinno,dp.idProduct,dp.idProdSize ,ps.productPrimaryCount,cs.G1,cs.G2,cs.G3,cs.G4,cs.G5,cs.G6 ,cs.G7,cs.G8,cs.G9,cs.G10,cs.cs_type,cs.cs_cmsn_type,dc.tax_status AS t_status,pr.idHsncode,(
			CASE
			WHEN pr.productCount = 1 THEN 'Units'
			WHEN pr.productCount = 2 THEN 'kg'
			WHEN pr.productCount = 3 THEN 'gm'
			WHEN pr.productCount = 4 THEN 'mgm'
			WHEN pr.productCount = 5 THEN 'mts'
			WHEN pr.productCount = 6 THEN 'cmts'
			WHEN pr.productCount = 7 THEN 'inches'
			WHEN pr.productCount = 8 THEN 'foot'
			WHEN pr.productCount = 9 THEN 'litre'
			WHEN pr.productCount = 10 THEN 'ml'

			END) as unitmeasure
								from customer_order_damges AS rt 
								LEFT JOIN dispatch_product_batch AS db ON rt.idDispatchProductBatch=db.idDispatchProductBatch 
								LEFT JOIN dispatch_product AS dp ON db.idDispatchProduct=dp.idDispatchProduct
								LEFT JOIN dispatch_customer AS dc ON rt.idDispatchcustomer=dc.idDispatchcustomer
								LEFT JOIN orders as ord ON dc.idOrder=ord.idOrder
								LEFT JOIN customer as cs ON dc.idCustomer=cs.idCustomer 
								LEFT JOIN product_details as pr ON dp.idProduct=pr.idProduct 
								LEFT JOIN product_size as ps ON dp.idProdSize=ps.idProductsize 
								LEFT JOIN primary_packaging as pt ON ps.idPrimaryPackaging=pt.idPrimaryPackaging 
								where rt.idDispatchcustomer='".$idDispatchCustomer."' and rt.credit_note_no='".$creditNoteNo."' group by dp.idDispatchProduct";
	}elseif($chooseRDRM==3){	
	
		$qryRDRMProduct="SELECT dp.idDispatchProduct,db.idDispatchProductBatch,sum(rt.replaceQty) AS dmgUnit,credit_note_no,rt.replaceDate, pr.productName, pr.productUnit, ps.productSize, pt.primarypackname,dc.invoiceNo, dc.idOrder,cs.cs_name, cs.cs_tinno,dp.idProduct,dp.idProdSize ,ps.productPrimaryCount,cs.G1,cs.G2,cs.G3,cs.G4,cs.G5,cs.G6 ,cs.G7,cs.G8,cs.G9,cs.G10 ,cs.cs_type,cs.cs_cmsn_type,dc.tax_status AS t_status,ps.productPrimaryCount,pr.idHsncode,(
			CASE
			WHEN pr.productCount = 1 THEN 'Units'
			WHEN pr.productCount = 2 THEN 'kg'
			WHEN pr.productCount = 3 THEN 'gm'
			WHEN pr.productCount = 4 THEN 'mgm'
			WHEN pr.productCount = 5 THEN 'mts'
			WHEN pr.productCount = 6 THEN 'cmts'
			WHEN pr.productCount = 7 THEN 'inches'
			WHEN pr.productCount = 8 THEN 'foot'
			WHEN pr.productCount = 9 THEN 'litre'
			WHEN pr.productCount = 10 THEN 'ml'

			END) as unitmeasure
								from customer_order_replacement AS rt 
								LEFT JOIN dispatch_product_batch AS db ON rt.idDispatchProductBatch=db.idDispatchProductBatch 
								LEFT JOIN dispatch_product AS dp ON db.idDispatchProduct=dp.idDispatchProduct
								LEFT JOIN dispatch_customer AS dc ON rt.idDispatchcustomer=dc.idDispatchcustomer
								LEFT JOIN orders as ord ON dc.idOrder=ord.idOrder
								LEFT JOIN customer as cs ON dc.idCustomer=cs.idCustomer 
								LEFT JOIN product_details as pr ON dp.idProduct=pr.idProduct 
								LEFT JOIN product_size as ps ON dp.idProdSize=ps.idProductsize 
								LEFT JOIN primary_packaging as pt ON ps.idPrimaryPackaging=pt.idPrimaryPackaging 
								where rt.idDispatchcustomer='".$idDispatchCustomer."' and rt.credit_note_no='".$creditNoteNo."' group by dp.idDispatchProduct";
	}elseif($chooseRDRM==4){	
	
		$qryRDRMProduct="SELECT dp.idDispatchProduct,db.idDispatchProductBatch,sum(rt.missing_qty) AS dmgUnit,credit_note_no,rt.missing_entry_date, pr.productName, pr.productUnit, ps.productSize, pt.primarypackname,dc.invoiceNo, dc.idOrder,cs.cs_name, cs.cs_tinno,dp.idProduct,dp.idProdSize ,cs.G1,cs.G2,cs.G3,cs.G4,cs.G5,cs.G6 ,cs.G7,cs.G8,cs.G9,cs.G10 ,cs.cs_type,cs.cs_cmsn_type,dc.tax_status AS t_status,pr.idHsncode,ps.productPrimaryCount,(
			CASE
			WHEN pr.productCount = 1 THEN 'Units'
			WHEN pr.productCount = 2 THEN 'kg'
			WHEN pr.productCount = 3 THEN 'gm'
			WHEN pr.productCount = 4 THEN 'mgm'
			WHEN pr.productCount = 5 THEN 'mts'
			WHEN pr.productCount = 6 THEN 'cmts'
			WHEN pr.productCount = 7 THEN 'inches'
			WHEN pr.productCount = 8 THEN 'foot'
			WHEN pr.productCount = 9 THEN 'litre'
			WHEN pr.productCount = 10 THEN 'ml'

			END) as unitmeasure
								from customer_order_missing AS rt 
								LEFT JOIN dispatch_product_batch AS db ON rt.idDispatchProductBatch=db.idDispatchProductBatch 
								LEFT JOIN dispatch_product AS dp ON db.idDispatchProduct=dp.idDispatchProduct
								LEFT JOIN dispatch_customer AS dc ON rt.idDispatchcustomer=dc.idDispatchcustomer
								LEFT JOIN orders as ord ON dc.idOrder=ord.idOrder								 
								LEFT JOIN customer as cs ON dc.idCustomer=cs.idCustomer 
								LEFT JOIN product_details as pr ON dp.idProduct=pr.idProduct 
								LEFT JOIN product_size as ps ON dp.idProdSize=ps.idProductsize 
								LEFT JOIN primary_packaging as pt ON ps.idPrimaryPackaging=pt.idPrimaryPackaging 
								where rt.idDispatchcustomer='".$idDispatchCustomer."' and rt.credit_note_no='".$creditNoteNo."' group by dp.idDispatchProduct";
	}
	
	$resultRDRMProduct=$this->adapter->query($qryRDRMProduct,array());
	$resultsetRDRMProduct=$resultRDRMProduct->toArray();
		
 
		if (count($resultsetRDRMProduct)>0) 
		{
			$totPriceAmnt=array();$taxtotAry=array();
			foreach ($resultsetRDRMProduct as $key => $value) {
				$resultsetRDRMProduct[$key]['psize']=$resultsetRDRMProduct[$key]['productSize'].''.$resultsetRDRMProduct[$key]['unitmeasure'];
				if($chooseRDRM==1){

					$qryProductStock="SELECT ws.sku_mf_date,(rt.rtnQty) as dmgUnit 
						FROM dispatch_product_batch AS db 
						LEFT JOIN customer_order_return AS rt ON db.idDispatchProductBatch=rt.idDispatchProductBatch
						LEFT JOIN whouse_stock_items AS ws ON db.idWhStockItem=ws.idWhStockItem where rt.credit_note_no='".$creditNoteNo."'";

				}elseif($chooseRDRM==2){	
					$qryProductStock="SELECT ws.sku_mf_date,dm.dmgQty,dm.dmgUnit 
						FROM dispatch_product_batch AS db 
						LEFT JOIN customer_order_damges AS dm ON db.idDispatchProductBatch=dm.idDispatchProductBatch
						LEFT JOIN whouse_stock_items AS ws ON db.idWhStockItem=ws.idWhStockItem where dm.credit_note_no='".$creditNoteNo."'";

				}elseif($chooseRDRM==3){	
					$qryProductStock="SELECT ws.sku_mf_date,(dm.replaceQty) as dmgUnit  
						FROM dispatch_product_batch AS db 
						LEFT JOIN customer_order_replacement AS dm ON db.idDispatchProductBatch=dm.idDispatchProductBatch
						LEFT JOIN whouse_stock_items AS ws ON db.idWhStockItem=ws.idWhStockItem where dm.credit_note_no='".$creditNoteNo."'";

				}elseif($chooseRDRM==4){	
					$qryProductStock="SELECT ws.sku_mf_date,(dm.missing_qty) as dmgUnit 
											FROM dispatch_product_batch AS db 
											LEFT JOIN customer_order_missing AS dm ON db.idDispatchProductBatch=dm.idDispatchProductBatch
											LEFT JOIN whouse_stock_items AS ws ON db.idWhStockItem=ws.idWhStockItem where dm.credit_note_no='".$creditNoteNo."'";

				}
				$resultProductStock=$this->adapter->query($qryProductStock,array());
				$resultsetProductStock=$resultProductStock->toArray();
				$totalAry=array();$totCommision=array();	
				foreach ($resultsetProductStock as $key1 => $value1) 
				{
					$qryPrice="SELECT priceAmount,priceDate,DATE_FORMAT(priceDate,'%b %d %Y %h:%i:%s') AS effDate FROM price_fixing WHERE idProduct='".$value['idProduct']."' AND idProductsize='".$value['idProdSize']."' AND (idTerritory='".$value['G1']."' OR idTerritory='".$value['G2']."' OR idTerritory='".$value['G3']."'  OR idTerritory='".$value['G4']."' OR idTerritory='".$value['G5']."' OR idTerritory='".$value['G6']."' OR idTerritory='".$value['G7']."' OR idTerritory='".$value['G8']."' OR idTerritory='".$value['G9']."' OR idTerritory='".$value['G10']."') AND priceDate<='".date('Y-m-d',strtotime($value1['sku_mf_date']))."'  ORDER BY priceDate DESC LIMIT 1";
					$resultPrice=$this->adapter->query($qryPrice,array());
					$resultsetPrice=$resultPrice->toArray();
					$resultsetRDRMProduct[$key]['unitPrice']=$resultsetPrice[0]['priceAmount'];

						$subTotal=$resultsetProductStock[$key1]['dmgUnit']*$resultsetPrice[0]['priceAmount'];
						array_push($totalAry,number_format($subTotal, 2, '.', ''));
					

                     //get commission percentage and calculate commission amount
						$qryCommission="SELECT distributn_unit,distributn_type FROM `distribution_margin` WHERE idProduct='".$value['idProduct']."' AND idProductsize='".$value['idProdSize']."' AND (idTerritory='".$value['G1']."' OR idTerritory='".$value['G2']."' OR idTerritory='".$value['G3']."'  OR idTerritory='".$value['G4']."' OR idTerritory='".$value['G5']."' OR idTerritory='".$value['G6']."' OR idTerritory='".$value['G7']."' OR idTerritory='".$value['G8']."' OR idTerritory='".$value['G9']."' OR idTerritory='".$value['G10']."') AND idCustomerType='".$value['cs_type']."' AND DATE_FORMAT(distributn_date,'%Y-%m-%d')<='".date('Y-m-d',strtotime($value1['sku_mf_date']))."'";
					$resultCommission=$this->adapter->query($qryCommission,array());
					$resultsetCommission=$resultCommission->toArray();

					$totalCommission=($resultsetProductStock[$key1]['dmgUnit']+$subTotal)*($resultsetCommission[0]['distributn_unit']/100);
                    $resultsetRDRMProduct[$key]['totalCommission']=$totalCommission;
                     array_push($totCommision,number_format($totalCommission, 2, '.', ''));

					

				}
					$grandTotal=number_format(array_sum($totalAry), 2, '.', '');
					$totCommission=number_format(array_sum($totCommision), 2, '.', '');

				$PriceAmnt=$grandTotal-$totCommission;
				array_push($totPriceAmnt,number_format($PriceAmnt, 2, '.', ''));
				$unitPriceAmount=$PriceAmnt/$resultsetRDRMProduct[$key]['dmgUnit'];
				$resultsetRDRMProduct[$key]['unitPriceAmount']=$unitPriceAmount;
				$qryTaxPercent="SELECT idGst,gstValue,idHsncode FROM `gst_master` WHERE idHsnCode='".$value['idHsncode']."' AND status=1  ORDER BY created_at  DESC LIMIT 1";
				$resultTaxPercent=$this->adapter->query($qryTaxPercent,array());
				$resultsetTaxPercent=$resultTaxPercent->toArray();
				$resultsetRDRMProduct[$key]['taxPercentage']=$resultsetTaxPercent[0]['gstValue'];
				@$taxAmnt=$PriceAmnt*$resultsetTaxPercent[0]['gstValue']/100;
				$resultsetRDRMProduct[$key]['taxAmount']=$taxAmnt;
				array_push($taxtotAry,number_format($taxAmnt, 2, '.', ''));
				$resultsetRDRMProduct[$key]['finalPriceAmount']=$PriceAmnt*$resultsetRDRMProduct[$key]['dmgUnit'];
			}

					$totTax=array_sum($taxtotAry);
					$totalAmnt=array_sum($totPriceAmnt);
					$grandTotalAmount=$totalAmnt+$totTax;
					
		}
		$overallAmount=array('TotalAmount'=>$totalAmnt,'totalTaxAmount'=>$totTax,'grandTotalAmount'=>$grandTotalAmount);
 
		if(!$resultsetRDRMProduct) {
		$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Record not found..'];
		} else {
		$ret_arr=['code'=>'2','content'=>$resultsetRDRMProduct,'OverallAmount'=>$overallAmount,'status'=>true,'message'=>'Record available'];
		}
		return $ret_arr;

    }
}


