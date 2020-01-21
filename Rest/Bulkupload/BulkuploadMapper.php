<?php
namespace Sales\V1\Rest\Bulkupload;
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


class BulkuploadMapper {

	protected $mapper;
	public function __construct(AdapterInterface $adapter) {
		// date_default_timezone_set("Asia/Manila");
		$this->adapter=$adapter;
        $this->commonfunctions  = new CommonFunctionsMapper($this->adapter);
	}

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
	

    public function validate ($cnt_date){

              list($dd,$mm,$yyyy) = explode('-',$cnt_date);

                if (!checkdate($dd,$mm,$yyyy)) {
                        $error = true;   
                }else{
                        $error = false; 
                } 

    }

	public function uploadfulfillment($param) {
		$userid=$param->userid;
		ini_set('display_errors',true);
		$Uploads_dir = 'public/uploads/csv';
		$tmp_name=$_FILES["myFile"]["tmp_name"]; 
		$name = basename($_FILES["myFile"]["name"]); 
		$imageName = rand(6,66666).'.'. pathinfo($_FILES["myFile"]['name'],PATHINFO_EXTENSION);
    	if(move_uploaded_file($tmp_name, "$Uploads_dir/$imageName")) {
			$r="public/uploads/csv/$imageName";
			$file = fopen($r, "r",FILE_SKIP_EMPTY_LINES);
			$emapData = fgetcsv($file, 10000, ","); 
				$row=0;
				$size=sizeof($emapData);
				if($size=='14' && $emapData !=null) {

				$fulfillment=array();
				$no_fulfillment=array();

				while (($record = fgetcsv($file)) !== FALSE) {
					$row++;
					array_push($fulfillment,$record);
				}

        $territory1=0;
        $territory2=0;
        $territory3=0;
        $territory4=0;
        $territory5=0;
        $territory6=0;
        $territory7=0;
        $territory8=0;
        $territory9=0;
        $territory10=0;

        $ter_map_value0=0;
        $ter_map_value1=0;
        $ter_map_value2=0;
        $ter_map_value3=0;
        $ter_map_value4=0;
        $ter_map_value5=0;
        $ter_map_value6=0;
        $ter_map_value7=0;
        $ter_map_value8=0;
        $ter_map_value9=0;
        $ter_map_value10=0;

        $insert_count=0;
        $reject_count=0;
        $reject_value=0; 
        $insert_value=0;  

    for($k=0; $k<count($fulfillment);$k++) {


        if($fulfillment[$k][13]=='' || $fulfillment[$k][13]=="null"){
                $status=0;    
                $no_fulfillment[]=$status;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status empty'];    
            }else if($fulfillment[$k][13]=="Active" || $fulfillment[$k][13]=="active"){

                $status=1;
                $no_fulfillment[]=$status;
            }else if($fulfillment[$k][13]=="Inactive" || $fulfillment[$k][13]=="inactive"){

                $status=2;
                $no_fulfillment[]=$status;
            }else{
                $status=0; 
                $no_fulfillment[]=$status;    
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status data'];    
            }


        if($fulfillment[$k][12]=='' || $fulfillment[$k][12]=="null"){
                $email_id=0;   
                $no_fulfillment[]=$email_id; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the email id empty'];

        }else if($fulfillment[$k][12]!='' || $fulfillment[$k][12]!="null"){
            if (!filter_var($fulfillment[$k][12], FILTER_VALIDATE_EMAIL)) {
             $email_id=0;   
                $no_fulfillment[]=$email_id;  
            $ret_arr=['code'=>'3','status'=>false,'message'=>'Please enter valid email id'];
        }else{
           
                $email_id=1;   
                $no_fulfillment[]=$email_id;    
            }
        }   

        if($fulfillment[$k][11]=='' || $fulfillment[$k][11]=="null"){
            $mobile=0;  
            $no_fulfillment[]=$mobile;
            $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the mobile empty'];

        }else if(!is_numeric($fulfillment[$k][11])){
                $mobile=0; 
                $no_fulfillment[]=$mobile;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Mobile no numeric only'];  

        }else if((strlen($fulfillment[$k][11])<10) || (strlen($fulfillment[$k][11])>10)){
                $mobile=0; 
                $no_fulfillment[]=$mobile;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please enter valid mobile number'];  
        }else if($fulfillment[$k][11]!='' || $fulfillment[$k][11]!="null"){
                $mobile=1; 
                $no_fulfillment[]=$mobile; 
                 
        }

        if($fulfillment[$k][10]=='' || $fulfillment[$k][10]=="null"){
                $name=0;  
                $no_fulfillment[]=$name; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the factory name empty'];

        }else if($fulfillment[$k][10]!='' || $fulfillment[$k][10]!="null"){
                $name=1;  
                $no_fulfillment[]=$name;  
                 
        } 

         if($fulfillment[$k][9]!=''){      
                $ter_value10=$fulfillment[$k][9];           
                $qry10="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value10' AND idTerritoryTitle ='10'";
                $result10=$this->adapter->query($qry10,array());
                $resultset10=$result10->toArray();  

                if(!$resultset10){ 
                    $ter_map_value10=0;
                    $no_fulfillment[]=$ter_map_value10;
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory10 value mismatch'];            
                }else{  
                   $ter_map_value10=1;
                   $no_fulfillment[]=$ter_map_value10;
                   }    
        }

        if($fulfillment[$k][8]!=''){ 
        
                $ter_value9=$fulfillment[$k][8];        
                $qry9="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value9' AND idTerritoryTitle ='9'";
                $result9=$this->adapter->query($qry9,array());
                $resultset9=$result9->toArray();    

                if(!$resultset9){ 
                    $ter_map_value9=0;
                    $no_fulfillment[]=$ter_map_value9;
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory9 value mismatch'];

                 
                }else{  
                   $ter_map_value9=1;
                   $no_fulfillment[]=$ter_map_value9;
                   }    
        }

        if($fulfillment[$k][7]!=''){ 
        
                $ter_value8=$fulfillment[$k][7];        
                $qry8="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value8' AND idTerritoryTitle ='8'";
                $result8=$this->adapter->query($qry8,array());
                $resultset8=$result8->toArray();    

                if(!$resultset8){
                    $ter_map_value8=0;
                    $no_fulfillment[]=$ter_map_value8;
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory8 value mismatch'];
                 
                }else{  
                   $ter_map_value8=1;
                   $no_fulfillment[]=$ter_map_value8;
                   }    
        }

        if($fulfillment[$k][6]!=''){ 
        
                $ter_value7=$fulfillment[$k][6];        
                $qry7="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value7' AND idTerritoryTitle ='7'";
                $result7=$this->adapter->query($qry7,array());
                $resultset7=$result7->toArray();    

                if(!$resultset7){
                    $ter_map_value7=0;
                    $no_fulfillment[]=$ter_map_value7;
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory7 value mismatch'];

                 
                }else{ 
                   $ter_map_value7=1;
                   $no_fulfillment[]=$ter_map_value7;
                   }    
        }

        if($fulfillment[$k][5]!=''){ 
        
                $ter_value6=$fulfillment[$k][5];         
                $qry6="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value6' AND idTerritoryTitle ='6'";
                $result6=$this->adapter->query($qry6,array());
                $resultset6=$result6->toArray();    

                if(!$resultset6){ 
                    $ter_map_value6=0;
                    $no_fulfillment[]=$ter_map_value6;
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory6 value mismatch'];                
                }else{  
                   $ter_map_value6=1;
                   $no_fulfillment[]=$ter_map_value6;
                   }    
        }

        if($fulfillment[$k][4]!=''){          
                $ter_value5=$fulfillment[$k][4];         
                $qry5="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value5' AND idTerritoryTitle ='5'";
                $result5=$this->adapter->query($qry5,array());
                $resultset5=$result5->toArray();    

                if(!$resultset5){ 
                    $ter_map_value5=0;
                    $no_fulfillment[]=$ter_map_value5;
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory5 value mismatch'];

                 
                }else{  
                   $ter_map_value5=1;
                   $no_fulfillment[]=$ter_map_value5;
                   }    
        }

        if($fulfillment[$k][3]!=''){ 
        
                $ter_value4=$fulfillment[$k][3];         
                $qry4="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value4' AND idTerritoryTitle ='4'";
                $result4=$this->adapter->query($qry4,array());
                $resultset4=$result4->toArray();    

                if(!$resultset4){ 
                    $ter_map_value4=0;
                    $no_fulfillment[]=$ter_map_value4;
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory4 value mismatch'];
                 
                }else{ 
                   $ter_map_value4=1;
                   $no_fulfillment[]=$ter_map_value4;
                   }    
        }

        if($fulfillment[$k][2]!=''){ 
        
                $ter_value3=$fulfillment[$k][2];         
                $qry3="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value3' AND idTerritoryTitle ='3'";
                $result3=$this->adapter->query($qry3,array());
                $resultset3=$result3->toArray();    

                if(!$resultset3){  
                    $ter_map_value3=0;
                    $no_fulfillment[]=$ter_map_value3;
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory3 value mismatch'];

                 
                }else{  
                   $ter_map_value3=1;
                   $no_fulfillment[]=$ter_map_value3;
                   }    
        }

        if($fulfillment[$k][1]!=''){ 
        
                $ter_value2=$fulfillment[$k][1];         
                $qry2="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value2' AND idTerritoryTitle ='2'";
                $result2=$this->adapter->query($qry2,array());
                $resultset2=$result2->toArray();    

                if(!$resultset2){  
                    $ter_map_value2=0;
                    $no_fulfillment[]=$ter_map_value2;
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory2 value mismatch'];
                 
                }else{  
                   $ter_map_value2=1;
                   $no_fulfillment[]=$ter_map_value2;
                   }    
        }

        if($fulfillment[$k][0]!=''){ 
        
                $ter_value1=$fulfillment[$k][0];         
                $qry1="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value1' AND idTerritoryTitle ='1'";
                $result1=$this->adapter->query($qry1,array());
                $resultset1=$result1->toArray();    

                if(!$resultset1){   
                    $ter_map_value1=0;
                    $no_fulfillment[]=$ter_map_value1;
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory1 value mismatch'];
                 
                }else{  
                   $ter_map_value1=1;
                   $no_fulfillment[]=$ter_map_value1;
                   }    
        }

    }// close loop



if(count($no_fulfillment)!=0){

    for($j=0; $j<count($no_fulfillment);$j++){ 
            $zero=0;
            if(in_array($zero,$no_fulfillment)){

               $check=0;
            }else{
               $check=1;

            }         
     }

    }else{
          $check=0;
          $ret_arr=['code'=>'3','status'=>false,'message'=>'Excel data is empty'];
    }  

if($check!=0){

		for($i=0; $i<count($fulfillment);$i++){

              if($fulfillment[$i][0]!=''){      
                    $ter_value1=$fulfillment[$i][0];           
                    $qry1="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value1' AND idTerritoryTitle ='1'";
                    $result1=$this->adapter->query($qry1,array());
                    $resultset1=$result1->toArray();
                    $territory1=$resultset1[0]['idTerritory'];
                }else{
                    $territory1=0;
                }
                if($fulfillment[$i][1]!=''){
                    $ter_value2=$fulfillment[$i][1];       
                    $qry2="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value2' AND idTerritoryTitle ='2'";
                    $result2=$this->adapter->query($qry2,array());
                    $resultset2=$result2->toArray();    
                    $territory2=$resultset2[0]['idTerritory'];
                }else{
                    $territory2=0;
                }
                if($fulfillment[$i][2]!=''){
                    $ter_value3=$fulfillment[$i][2];           
                    $qry3="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value3' AND idTerritoryTitle ='3'";
                    $result3=$this->adapter->query($qry3,array());
                    $resultset3=$result3->toArray();
                    $territory3=$resultset3[0]['idTerritory'];
                }else{
                    $territory3=0;
                }
                if($fulfillment[$i][3]!=''){
                    $ter_value4=$fulfillment[$i][3];       
                    $qry4="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value4' AND idTerritoryTitle ='4'";
                    $result4=$this->adapter->query($qry4,array());
                    $resultset4=$result4->toArray();    

                    $territory4=$resultset4[0]['idTerritory'];
                }else{
                    $territory4=0;
                }
                if($fulfillment[$i][4]!=''){
                    $ter_value5=$fulfillment[$i][4];   
                    $qry5="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value5' AND idTerritoryTitle ='5'";
                    $result5=$this->adapter->query($qry5,array());
                    $resultset5=$result5->toArray();
                    $territory5=$resultset5[0]['idTerritory'];
                }else{
                    $territory5=0;
                }
                if($fulfillment[$i][5]!=''){
                    $ter_value6=$fulfillment[$i][5];       
                    $qry6="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value6' AND idTerritoryTitle ='6'";
                    $result6=$this->adapter->query($qry6,array());
                    $resultset6=$result6->toArray();    
                    $territory6=$resultset6[0]['idTerritory'];
                }else{
                    $territory6=0;
                }
                if($fulfillment[$i][6]!=''){
                    $ter_value7=$fulfillment[$i][6];           
                    $qry7="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value7' AND idTerritoryTitle ='7'";
                    $result7=$this->adapter->query($qry7,array());
                    $resultset7=$result7->toArray();    
                    $territory7=$resultset7[0]['idTerritory'];
                }else{
                    $territory7=0;
                }
                if($fulfillment[$i][7]!=''){
                    $ter_value8=$fulfillment[$i][7];          
                    $qry8="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value8' AND idTerritoryTitle ='8'";
                    $result8=$this->adapter->query($qry8,array());
                    $resultset8=$result8->toArray();    
                    $territory8=$resultset8[0]['idTerritory'];
                }else{
                    $territory8=0;
                }
                if($fulfillment[$i][8]!=''){
                    $ter_value9=$fulfillment[$i][8];      
                    $qry9="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value9' AND idTerritoryTitle ='9'";
                    $result9=$this->adapter->query($qry9,array());
                    $resultset9=$result9->toArray();
                    $territory9=$resultset9[0]['idTerritory'];
                }else{
                    $territory9=0;
                }
                if($fulfillment[$i][9]!=''){
                    $ter_value10=$fulfillment[$i][9];     
                    $qry10="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value10' AND idTerritoryTitle ='10'";
                    $result10=$this->adapter->query($qry10,array());
                    $resultset10=$result10->toArray();
                    $territory10=$territory10[0]['idTerritory'];
                }else{
                    $territory10=0;
                }

            if($fulfillment[$i][13]=="Active" || $fulfillment[$i][13]=="active"){

            $status=1;
            $no_fulfillment[]=$status;
            }else if($fulfillment[$i][13]=="Inactive" || $fulfillment[$i][13]=="inactive"){

                $status=2;
                $no_fulfillment[]=$status;
            }

	  $qry="SELECT * FROM fulfillment_master where fulfillmentName=? and fulfillmentMobileno=? and fulfillmentEmail=?";
			$result=$this->adapter->query($qry,array($fulfillment[$i][10],$fulfillment[$i][11],$fulfillment[$i][12]));
			$resultset=$result->toArray();
					
					if(!$resultset){
    						$this->adapter->getDriver()->getConnection()->beginTransaction();
    						try {
    							$data['fulfillmentName']=$fulfillment[$i][10];
    							$data['fulfillmentMobileno']=$fulfillment[$i][11];
    							$data['fulfillmentEmail']=$fulfillment[$i][12];
    							$data['t1']=(($fulfillment[$i][0]!='')? $resultset1[0]['idTerritory']:0);
                                $data['t2']=(($fulfillment[$i][1]!='')? $resultset2[0]['idTerritory']:0);
                                $data['t3']=(($fulfillment[$i][2]!='')? $resultset3[0]['idTerritory']:0);
                                $data['t4']=(($fulfillment[$i][3]!='')? $resultset4[0]['idTerritory']:0);
                                $data['t5']=(($fulfillment[$i][4]!='')? $resultset5[0]['idTerritory']:0);
                                $data['t6']=(($fulfillment[$i][5]!='')? $resultset6[0]['idTerritory']:0);
                                $data['t7']=(($fulfillment[$i][6]!='')? $resultset7[0]['idTerritory']:0);
                                $data['t8']=(($fulfillment[$i][7]!='')? $resultset8[0]['idTerritory']:0);
                                $data['t9']=(($fulfillment[$i][8]!='')? $resultset9[0]['idTerritory']:0);
                                $data['t10']=(($fulfillment[$i][9]!='')? $resultset10[0]['idTerritory']:0);
    							$data['status']=$status;
    							$data['created_at']=date('Y-m-d H:i:s');
    							$data['created_by']=1;
    							$insert=new Insert('fulfillment_master');
    							$insert->values($data);
    							$statement=$this->adapter->createStatement();
    							$insert->prepareStatement($this->adapter, $statement);
    							$insertresult=$statement->execute();
    		                    $insert_value +=$insert_count+1;
    							$this->adapter->getDriver()->getConnection()->commit();

    						}catch(\Exception $e) {
    							$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
    							$this->adapter->getDriver()->getConnection()->rollBack();
    						}
					}else{

                        $reject_value += $reject_count+1;
				    }
		} 

    if($insert_value!=0 && $reject_value==0){

        $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];

     }else if($insert_value ==0 && $reject_value !=0){

        $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];

    }else if($insert_value!=0 && $reject_value!=0){

    $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists  '.$reject_value.'Uploaded  '.$insert_value];
        }
	}
			}else {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please verify the csv file'];
			}
			
		}
        return $ret_arr;

	} // close func


public function uploadproductdetails($param){

	  ini_set('display_errors',true);
		$Uploads_dir = 'public/uploads/csv';
		$tmp_name=$_FILES["myFile"]["tmp_name"]; 
		$name = basename($_FILES["myFile"]["name"]); 
		$imageName = rand(6,66666).'.'. pathinfo($_FILES["myFile"]['name'],PATHINFO_EXTENSION);
    	if(move_uploaded_file($tmp_name, "$Uploads_dir/$imageName")) {
			$r="public/uploads/csv/$imageName";
			$file = fopen($r, "r",FILE_SKIP_EMPTY_LINES);
			$emapData = fgetcsv($file, 10000, ","); 
			$row=0;
			$size=sizeof($emapData);
       
	    if($size=='21' && $emapData !=null){
			    $product_details=array();
				$no_product_details=array();
				while (($record = fgetcsv($file)) !== FALSE){
					$row++;
					array_push($product_details,$record);
				}

	
 	    $insert_count=0;
        $reject_count=0;
        $reject_value=0; 
        $insert_value=0; 
        $serial=0; 

        for($k=0; $k<count($product_details);$k++){

        	if($product_details[$k][20]=="Active" || $product_details[$k][20]=="active"){
                $status=1;
                $no_product_details[]=$status;
        	}else if($product_details[$k][20]=="Inactive" || $product_details[$k][20]=="inactive"){
        		$status=2;
        		$no_product_details[]=$status;
        	}else if($product_details[$k][20]=='' || $product_details[$k][20]=="null"){
                $status=0; 
                $no_product_details[]=$status;
   
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status empty'];    
        	}else{
                $status=0; 
                $no_product_details[]=$status;  
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status data'];    
        	}

        	if($product_details[$k][19]=='' || $product_details[$k][19]=='null'){
         		$base_count=0;
         		$no_product_details[]=$base_count; 
         	 	$ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the base unit count empty'];
         	}else if($product_details[$k][19]!='' || $product_details[$k][19]!='null'){

         		if($product_details[$k][19]=="Units" || $product_details[$k][19] =="units"){
        	    $base_count=1;
        		$no_product_details[]=$base_count;
              	}else if($product_details[$k][19]=="Kg" || $product_details[$k][19]=="kg"){
        		$base_count=2;
        		$no_product_details[]=$base_count;
              	}else if($product_details[$k][19]=="Gm" || $product_details[$k][19]=="gm"){
        		$base_count=3;
        		$no_product_details[]=$base_count;
              	}else if($product_details[$k][19]=="Mgm" || $product_details[$k][19]=="mgm"){
        		$base_count=4;
        		$no_product_details[]=$base_count;
              	}else if($product_details[$k][19]=="Mts" || $product_details[$k][19]=="mts"){
        		$base_count=5;
        		$no_product_details[]=$base_count;
              	}else if($product_details[$k][19]=="Cmts" || $product_details[$k][19]=="cmts"){
        		$base_count=6;
        		$no_product_details[]=$base_count;
              	}else if($product_details[$k][19]=="Inches" || $product_details[$k][19]=="inches"){
        		$base_count=7;
        		$no_product_details[]=$base_count;
              	}else if($product_details[$k][19]=="Foot" || $product_details[$k][19]=="foot"){
        		$base_count=8;
        		$no_product_details[]=$base_count;
              	}else if($product_details[$k][19]=="Litre" || $product_details[$k][19]=="litre"){
        		$base_count=9;
        		$no_product_details[]=$base_count;
              	}else if($product_details[$k][19]=="Ml" || $product_details[$k][19]=="ml"){
        		$base_count=10;
        		$no_product_details[]=$base_count;
              	}else{
              	$base_count=0;
         	    $no_product_details[]=$base_count; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the base unit count mismatch'];

              	}
               
         	}

        	if($product_details[$k][18]=='' || $product_details[$k][18]=='null'){
         		$base_unit=0;
         		$no_product_details[]=$base_unit; 
         	 	$ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the base unit empty'];
         	}else if($product_details[$k][18]!='' || $product_details[$k][18]!='null'){

         		if($product_details[$k][18]=="Unit" || $product_details[$k][18]=="unit"){
        	    $base_unit=1;
        		$no_product_details[]=$base_unit;
              	}else if($product_details[$k][18]=="Weight" || $product_details[$k][18]=="weight"){
        		$base_unit=2;
        		$no_product_details[]=$base_unit;
              	}else if($product_details[$k][18]=="Area" || $product_details[$k][18]=="area"){
        		$base_unit=3;
        		$no_product_details[]=$base_unit;
              	}else{
              	$base_unit=0;
         	    $no_product_details[]=$base_unit; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the base unit mismatch'];

              	}
               
         	}

        	if($product_details[$k][17]=='' || $product_details[$k][17]=='null'){
         		$product_status=0;
         		$no_product_details[]=$product_status; 
         	 	$ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the product status empty'];
         	}else if($product_details[$k][17]!='' || $product_details[$k][17]!='null'){
         		$product=$product_details[$k][17];		   
		        $qry5="SELECT idProductStatus,productStatus FROM product_status WHERE productStatus='$product' AND status ='1'";
				$result5=$this->adapter->query($qry5,array());
			    $resultset5=$result5->toArray();

			    if(!$resultset5){
			    	$product_status=0;
         		    $no_product_details[]=$product_status; 
         		    $ret_arr=['code'=>'3','status'=>false,'message'=>'Product status value mismatch'];  

			    }else{
			    	$product_status=1;
         		    $no_product_details[]=$product_status;

			    }
         	}

            
        	if($product_details[$k][16] =='' || $product_details[$k][16] =='null'){
         		$content=0;
         		$no_product_details[]=$content; 
         	 	$ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the product content empty'];
         	}else if($product_details[$k][16] !='' || $product_details[$k][16] !='null'){
         		$product_content=$product_details[$k][16];		   
		        $qry4="SELECT idProductContent,productContent FROM product_content WHERE productContent='$product_content' AND status ='1'";
				$result4=$this->adapter->query($qry4,array());
			    $resultset4=$result4->toArray();


			    if(!$resultset4){
			    	$content=0;
         		    $no_product_details[]=$content; 
         		    $ret_arr=['code'=>'3','status'=>false,'message'=>'Product content value mismatch'];  

			    }else{
			    	$content=1;
         		    $no_product_details[]=$content;

			    }
         	}


              if($product_details[$k][13]=='Required'){
              	$serial=1;

              }else if($product_details[$k][13]=='Not required'){
                $serial=2;
              }

             if($serial==1){

            if($product_details[$k][15] =='' || $product_details[$k][15] =='null'){
                $auto=0;
                $no_product_details[]=$auto;
            	$ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the serial no auto empty'];

            }else if($product_details[$k][15] =="Automatic" || $product_details[$k][15] =="automatic"){
        	    $auto=1;
        		$no_product_details[]=$auto;
              	}else if($product_details[$k][15] =="Manual" || $product_details[$k][15] =="manual"){
        		$auto=2;
        		$no_product_details[]=$auto;
              	}else{
              	$auto=0;
         	    $no_product_details[]=$auto; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the serial no auto mismatch'];

              	}

         	}else if($serial==2){
               $auto=2;
         	   $no_product_details[]=$auto; 

         	}
                 
         	if($serial==1){

            if($product_details[$k][14] =='' || $product_details[$k][14]== 'null'){
                $numeric=0;
                $no_product_details[]=$numeric;
            	$ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the serial no numeric empty'];

            }else{

                if($product_details[$k][14] =="Numeric" || $product_details[$k][14] =="numeric"){
        	    $numeric=1;
        		$no_product_details[]=$numeric;
        			
              	}else if($product_details[$k][14] =="Alphanumeric" || $product_details[$k][14] =="alphanumeric"){
        		$numeric=2;
        		$no_product_details[]=$numeric;
        			
              	}else{

              	$numeric=0;
         	    $no_product_details[]=$numeric; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the serial no numeric mismatch'];

              	}
              }
            
            }else if($serial==2){
               $numeric=2;
         	   $no_product_details[]=$numeric; 

         	}



        	if($product_details[$k][13] =='' ||$product_details[$k][13] =='null'){

            	$serial_no=0;
            	$no_product_details[]=$serial_no;
         	    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the serial no empty'];

            }else if($product_details[$k][13] !='' || $product_details[$k][13] !='null'){

         		if($product_details[$k][13] =="Required" || $product_details[$k][13] =="required"){
        	    $serial_no=1;
        		$no_product_details[]=$serial_no;
              	}else if($product_details[$k][13]=="Not required" || $product_details[$k][13] =="not required"){
        		$serial_no=2;
        		$no_product_details[]=$serial_no;
              	}else{

              	$serial_no=0;
         	    $no_product_details[]=$serial_no; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the serial no mismatch'];

              	}
               
         	}

          // print_r($product_details);
            if($product_details[$k][12]!='' AND $product_details[$k][12]!='null'){
                if(!is_numeric($product_details[$k][12])){
                $dipatch=0;
                $no_product_details[]=$dipatch; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Dispatch control allows numeric only'];  

            }else{
         		$dipatch=1;
         		$no_product_details[]=$dipatch; 
            }
               
         	}
      if($product_details[$k][9]=="Yes" || $product_details[$k][9]=="yes"){
        	if($product_details[$k][11] =='' || $product_details[$k][11] =='null'){
            	 $option=0;
            	 $no_product_details[]=$option;
         	     $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the return option empty'];

            }else if($product_details[$k][11]!='' || $product_details[$k][11]!='null'){

         		if($product_details[$k][11]=="Alert" || $product_details[$k][11]=="alert"){
        	    $option=1;
        		$no_product_details[]=$option;
              	}else if($product_details[$k][11] =="Stop" ||$product_details[$k][11]=="stop"){
        		$option=2;
        		$no_product_details[]=$option;
              	}else{

              	$option=0;
         	    $no_product_details[]=$option; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the return option mismatch'];

              	}
               
         	}       	
        	  
        		if($product_details[$k][10] =='' || $product_details[$k][10] == "null"){
        			$days=0;
        		    $no_product_details[]=$days;
        		    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the return days empty'];

        		}else if($product_details[$k][10]!='' || $product_details[$k][10]!='null'){
	         		$days=1;
	         		$no_product_details[]=$days; 
	               
	         	}else if(!is_numeric($product_details[$k][10])){
	                $days=0;
	                $no_product_details[]=$days; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Return days numeric only'];  

	        	}
            }
            else
            {
                $option=2;
                $days=1;
                $policy=1; 
                $no_product_details[]=$policy;
                  $no_product_details[]=$days;
                  $no_product_details[]=$option; 
            }

        	if($product_details[$k][9] =='' || $product_details[$k][9] =='null'){
            	 $policy=0; 
            	 $no_product_details[]=$policy;
         	     $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the return policy empty'];

            }else if($product_details[$k][9]== "Yes" || $product_details[$k][9]== "yes")
            {
        	    $policy=1;
        		$no_product_details[]=$policy;
            }else if($product_details[$k][9]== "No" || $product_details[$k][9]== "no")
            {
        		$policy=2; 
        		$no_product_details[]=$policy;
            }else if($product_details[$k][9]!='Yes' && $product_details[$k][9]!='yes' && $product_details[$k][9]!='No' && $product_details[$k][9]!='no')
            {
                  
              	$policy=0; 
         	    $no_product_details[]=$policy; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the return policy mismatch'];

            }
               
         	
            
            if ($product_details[$k][6]=="Yes" || $product_details[$k][6]=="yes") 
            {
                if($product_details[$k][8] == '' || $product_details[$k][8] == 'null'){
                    $shelf_count=0;
                    $no_product_details[]=$shelf_count;
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check shelf life count empty'];

                }else if(!is_numeric($product_details[$k][8])){
                    $shelf_count=0;
                    $no_product_details[]=$shelf_count; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Shelf life count numeric only'];  

                }else if($product_details[$k][7]!='' || $product_details[$k][7]!='null'){
                    $shelf_count=1;
                    $no_product_details[]=$shelf_count; 

                }


                if($product_details[$k][7] =='' || $product_details[$k][7] =='null'){
                    $life=0;
                    $no_product_details[]=$life;      
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the shelf life empty'];

                }else if($product_details[$k][7] !='' || $product_details[$k][7] !='null'){

                    if($product_details[$k][7] =="Days" || $product_details[$k][7] =="days"){
                        $life=1;
                        $no_product_details[]=$life;
                    }else if($product_details[$k][7] =="Months" || $product_details[$k][7] =="months"){
                        $life=2;
                        $no_product_details[]=$life;
                    }else if($product_details[$k][7] =="Years" || $product_details[$k][7] =="years"){
                        $life=3;
                        $no_product_details[]=$life;
                    }else{

                        $life=0;
                        $no_product_details[]=$life; 
                        $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the shelf life mismatch'];
                    }

                } 
            }
            else
            {
               $life=1;
               $shelf_count=1; 
               $no_product_details[]=$life; 
               $no_product_details[]=$shelf_count; 
            }

            if ($product_details[$k][6]=='' || $product_details[$k][6]=='null') 
            {
                $exp_date=0;
                    $no_product_details[]=$exp_date;
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check expire date empty'];
            }else if($product_details[$k][6]=='Yes' || $product_details[$k][6]=='yes')
            {
                $exp_date=1;
                    $no_product_details[]=$exp_date; 
            }
            else if($product_details[$k][6]=='No' || $product_details[$k][6]=='no')
            {
                 $exp_date=2;
                    $no_product_details[]=$exp_date; 
            }
            else
            {
                $exp_date=0;
                    $no_product_details[]=$exp_date;
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check expire date mismatch'];  
            }

        	if($product_details[$k][5]=='' || $product_details[$k][5]=='null'){
         		$hsn=0;
         		$no_product_details[]=$hsn; 
         	 	$ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the hsn code empty'];
         	}
            /*else if(!is_numeric($product_details[$k][5])){
                $hsn=0;
                $no_product_details[]=$hsn; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Hsn code numeric only'];  

        	}*/
            else if($product_details[$k][5]!='' || $product_details[$k][5]!='null'){
         		$hsn_code=$product_details[$k][5];		   
		        $qry3="SELECT idHsncode,hsn_code FROM hsn_details WHERE hsn_code='$hsn_code' AND status ='1'";
				$result3=$this->adapter->query($qry3,array());
			    $resultset3=$result3->toArray();


			    if(!$resultset3){
			    	$hsn=0;
         		    $no_product_details[]=$hsn; 
         		    $ret_arr=['code'=>'3','status'=>false,'message'=>'Hsn code mismatch'];  

			    }else{
			    	$hsn=1;
         		    $no_product_details[]=$hsn;

			    }
         	}

         	if($product_details[$k][4]=='' || $product_details[$k][4]=='null'){
	     		$name=0;
	        	$no_product_details[]=$name;      
	     	 	$ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the product name empty'];

         	}else if($product_details[$k][4]!='' || $product_details[$k][4]!='null'){
         		$name=1;
         	    $no_product_details[]=$name; 
               
         	}

     		if($product_details[$k][3]=='' || $product_details[$k][3]=='null'){
     		$code=0;
        	$no_product_details[]=$code;      
     	 	$ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the product code empty'];

         	}
         //    else if(!is_numeric($product_details[$k][3])){
         //        $code=0;
         //        $no_product_details[]=$code; 
         //        $ret_arr=['code'=>'3','status'=>false,'message'=>'Product code numeric only'];  

        	// }
            else if($product_details[$k][3]!='' || $product_details[$k][3]!='null'){
         		$code=1;
         	    $no_product_details[]=$code; 

         	    $product_code=$product_details[$k][3];		   
		        $qry_list="SELECT idProduct,productCode FROM product_details WHERE productCode='$product_code' AND status ='1'";
				$result_list=$this->adapter->query($qry_list,array());
			    $resultset_list=$result_list->toArray();


			    if(!$resultset_list){
			    	$code=1;
         		    $no_product_details[]=$code;   

			    }else{
			    	$code=0;
         		    $no_product_details[]=$code;
         		    $ret_arr=['code'=>'3','status'=>false,'message'=>'Product code already exist'];

			    }
               
         	}

     		if($product_details[$k][2] =='' || $product_details[$k][2] =='null'){
	     		$brand=0;
	        	$no_product_details[]=$brand;      
	     	 	$ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the brand name empty'];

         	}else if($product_details[$k][2]!='' || $product_details[$k][2]!='null'){
         		$brand=1;
         	    $no_product_details[]=$brand; 
               
         	}

         	if($product_details[$k][1]=='' || $product_details[$k][1]=='null'){
         		$category=0;
         		$no_product_details[]=$category; 
         	 	$ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the sub category empty'];

            }else if($product_details[$k][1]!='' || $product_details[$k][1]!='null'){
         		$subcategory_name=$product_details[$k][1];
         		$category_name=$product_details[$k][0];		 

		        $qry1="SELECT idCategory,category FROM category WHERE category='$category_name' AND status='1'";
				$result1=$this->adapter->query($qry1,array());
			    $resultset1=$result1->toArray();

		        $qry2="SELECT idSubCategory,subcategory FROM subcategory WHERE subcategory='$subcategory_name' AND idCategory='".$resultset1[0]['idCategory']."' AND status ='1'";
				$result2=$this->adapter->query($qry2,array());
			    $resultset2=$result2->toArray();

			    if(!$resultset2){
			    	$subcategory=0;
         		    $no_product_details[]=$subcategory; 
         		    $ret_arr=['code'=>'3','status'=>false,'message'=>'Subcategory value mismatch'];

			    }else{
			    	$subcategory=1;
         		    $no_product_details[]=$subcategory;

			    }
         	}

         	if($product_details[$k][0]=='' || $product_details[$k][0]=='null'){
         		$category=0;
         		$no_product_details[]=$category; 
         	 	$ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the category empty'];
         	}else if($product_details[$k][0]!='' || $product_details[$k][0]!='null'){
         		$category_name=$product_details[$k][0];		   
		        $qry1="SELECT idCategory,category FROM category WHERE category='$category_name' AND status ='1'";
				$result1=$this->adapter->query($qry1,array());
			    $resultset1=$result1->toArray();

			    if(!$resultset1){
			    	$category=0;
         		    $no_product_details[]=$category; 
         		    $ret_arr=['code'=>'3','status'=>false,'message'=>'Category value mismatch'];  

			    }else{
			    	$category=1;
         		    $no_product_details[]=$category;

			    }
         	}


        } // close loop


if(count($no_product_details)!=0){

    for($m=0; $m<count($no_product_details);$m++){ 
            $zero=0;
        if(in_array($zero,$no_product_details)){
           $check=0;
        }else{
           $check=1;

        }
      
    }
}else{
	      $check=0;
	      $ret_arr=['code'=>'3','status'=>false,'message'=>'Excel data is empty'];
}

if($check!=0){

    for($i=0; $i<count($product_details);$i++) {	
      
      	$category_name=$product_details[$i][0];		   
		        $qry1="SELECT idCategory,category FROM category WHERE category='$category_name' AND status ='1'";
				$result1=$this->adapter->query($qry1,array());
			    $resultset1=$result1->toArray();

			    $subcategory_name=$product_details[$i][1];		   
		        $qry2="SELECT idSubCategory,subcategory FROM subcategory WHERE subcategory='$subcategory_name' AND idCategory='".$resultset1[0]['idCategory']."' AND status ='1'";
				$result2=$this->adapter->query($qry2,array());
			    $resultset2=$result2->toArray();

			    $hsn_code=$product_details[$i][5];		   
		        $qry3="SELECT idHsncode,hsn_code FROM hsn_details WHERE hsn_code='$hsn_code' AND status ='1'";
				$result3=$this->adapter->query($qry3,array());
			    $resultset3=$result3->toArray();

			    $product_content=$product_details[$i][16];		   
		        $qry4="SELECT idProductContent,productContent FROM product_content WHERE productContent='$product_content' AND status ='1'";
				$result4=$this->adapter->query($qry4,array());
			    $resultset4=$result4->toArray();

			    $product=$product_details[$i][17];		   
		        $qry5="SELECT idProductStatus,productStatus FROM product_status WHERE productStatus='$product' AND status ='1'";
				$result5=$this->adapter->query($qry5,array());
			    $resultset5=$result5->toArray();

                if($product_details[$i][6]=="Yes" || $product_details[$i][6]=="yes"){
                $exp_date=1;
                }else if($product_details[$i][6]=="No" || $product_details[$i][6]=="no"){
                $exp_date=2;
                }

			    if($product_details[$i][7]=="Days" || $product_details[$i][7]=="days"){
        	    $life=1;
              	}else if($product_details[$i][7]=="Months" || $product_details[$i][7]=="months"){
        		$life=2;
              	}else if($product_details[$i][7]=="Years" || $product_details[$i][7]=="years"){
        		$life=3;
              	}
                else
                {
                  $life=0;  
                }

              	if($product_details[$i][9]=="Yes" || $product_details[$i][9]=="yes"){
        	    $policy=1;
              	}else if($product_details[$i][9]=="No" || $product_details[$i][9]=="no"){
        		$policy=2;
    
              	}

              	if($product_details[$i][11]=="Alert" || $product_details[$i][11]=="alert"){
        	    $option=1;

              	}else if($product_details[$i][11]=="Stop" || $product_details[$i][11]=="stop"){
        		$option=2;

              	}

              	if($product_details[$i][13]=="Required" || $product_details[$i][13]=="required"){
        	    $serial_no=1;

              	}else if($product_details[$i][13]=="Not required" || $product_details[$i][13]=="not required"){
        		$serial_no=2;

              	}

              	if($product_details[$i][14]=="Numeric" || $product_details[$i][14]=="numeric"){
        	    $numeric=1;

              	}else if($product_details[$i][14]=="Alphanumeric" || $product_details[$i][14]=="alphanumeric"){
        		$numeric=2;

              	}

              	 if($product_details[$i][15]=="Automatic" || $product_details[$i][15]=="automatic"){
        	    $auto=1;
     
              	}else if($product_details[$i][15]=="Manual" || $product_details[$i][15]=="manual"){
        		$auto=2;

              	}

              	if($product_details[$i][18]=="Unit" || $product_details[$i][18]=="unit"){
        	    $base_unit=1;
    
              	}else if($product_details[$i][18]=="Weight" || $product_details[$i][18]=="weight"){
        		$base_unit=2;

              	}else if($product_details[$i][18]=="Area" || $product_details[$i][18]=="area"){
        		$base_unit=3;
   
              	}

              	if($product_details[$i][19]=="Units" || $product_details[$i][19]=="units"){
        	    $base_count=1;

              	}else if($product_details[$i][19]=="Kg" || $product_details[$i][19]=="kg"){
        		$base_count=2;

              	}else if($product_details[$i][19]=="Gm" || $product_details[$i][19]=="gm"){
        		$base_count=3;

              	}else if($product_details[$i][19]=="Mgm" || $product_details[$i][19]=="mgm"){
        		$base_count=4;

              	}else if($product_details[$i][19]=="Mts" || $product_details[$i][19]=="mts"){
        		$base_count=5;

              	}else if($product_details[$i][19]=="Cmts" || $product_details[$i][19]=="cmts"){
        		$base_count=6;

              	}else if($product_details[$i][19]=="Inches" || $product_details[$i][19]=="inches"){
        		$base_count=7;
     
              	}else if($product_details[$i][19]=="Foot" || $product_details[$i][19]=="foot"){
        		$base_count=8;

              	}else if($product_details[$i][19]=="Litre" || $product_details[$i][19]=="litre"){
        		$base_count=9;
 
              	}else if($product_details[$i][19]=="Ml" || $product_details[$i][19]=="ml"){
        		$base_count=10;
        
              	}
	   
			    if($product_details[$i][20]=="Active" || $product_details[$i][20]=="active"){
                $status=1;
	        	}else if($product_details[$i][20]=="Inactive" || $product_details[$i][20]=="inactive"){
	        	$status=2;
	        	}

    $qry="SELECT *FROM product_details where productCode=? and productName=? ";
    $result=$this->adapter->query($qry,array($product_details[$i][3],$product_details[$i][4]));
    $resultset=$result->toArray();

            if(!$resultset){
            	 $this->adapter->getDriver()->getConnection()->beginTransaction();
            	 try {

						    $data['idCategory']=$resultset1[0]['idCategory'];
							$data['idSubCategory']=$resultset2[0]['idSubCategory'];
							$data['productBrand']=$product_details[$i][2];
							$data['productCode']=$product_details[$i][3];
							$data['productName']=$product_details[$i][4];
							$data['idHsncode']=$resultset3[0]['idHsncode'];
                            $data['expireDate']=$exp_date;
							$data['productShelflife']=$life;
							$data['productShelf']=$product_details[$i][8];
							$data['productReturn']=$policy;
							$data['productReturnDays']=($product_details[$i][10]!='')?$product_details[$i][10]:0;
							$data['productReturnOption']=$option;
							$data['dispatchControl']=$product_details[$i][12]?$product_details[$i][12]:0;
							$data['productserialNo']=$serial_no;
							$data['productserialnoNumeric']=($product_details[$i][14]!=''? $numeric : 2);
							$data['productserialnoAuto']=($product_details[$i][15]!=''? $auto : 2);
							$data['idProductContent']=$resultset4[0]['idProductContent'];
							$data['idProductStatus']=$resultset5[0]['idProductStatus'];		
							$data['productUnit']=$base_unit;
							$data['productCount']=$base_count;	
							$data['idTerritoryTitle']=0;					
							$data['status']=$status;
							$data['created_by']=$param->userid;
							$data['created_at']=date('Y-m-d H:i:s');
							$data['updated_by']=$param->userid;
							$data['updated_at']=date('Y-m-d H:i:s');
                           
							$insert=new Insert('product_details');
							$insert->values($data);
							$statement=$this->adapter->createStatement();
							$insert->prepareStatement($this->adapter, $statement);
							$insertresult=$statement->execute();
					        $insert_value +=$insert_count+1;
							$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
							$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
							$this->adapter->getDriver()->getConnection()->rollBack();
						}

            }else {
                 $reject_value += $reject_count+1;        
		
	 		    }
	       

       }
  

    if($insert_value!=0 && $reject_value==0)
    {

    $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
        }else if($insert_value ==0 && $reject_value !=0){

    $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];

        }else if($insert_value!=0 && $reject_value!=0){

    $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists  '.$reject_value.'Uploaded  '.$insert_value];
        }
   
    }

 	    }else{
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please verify the csv file'];
		 }
	
    }
      return $ret_arr;
							
} //close func


public function uploadproductsize($param) {
		 $userid=$param->userid;
		ini_set('display_errors',true);
		$Uploads_dir = 'public/uploads/csv';
		$tmp_name=$_FILES["myFile"]["tmp_name"]; 
		$name = basename($_FILES["myFile"]["name"]); 
		$imageName = rand(6,66666).'.'. pathinfo($_FILES["myFile"]['name'],PATHINFO_EXTENSION);
    	if(move_uploaded_file($tmp_name, "$Uploads_dir/$imageName")) {
			$r="public/uploads/csv/$imageName";
			$file = fopen($r, "r",FILE_SKIP_EMPTY_LINES);
			$emapData = fgetcsv($file, 10000, ","); 
				$row=0;
				$size=sizeof($emapData);
				if($size=='6' && $emapData !=null) {
				$product_size=array();
				$no_product_size=array();
				while (($record = fgetcsv($file)) !== FALSE) {
					$row++;
					array_push($product_size,$record);
				}


		$insert_count=0;
        $reject_count=0;
        $reject_value=0; 
        $insert_value=0; 


    for($k=0; $k<count($product_size);$k++) {
               
               // if($product_size[$k][5]=='' || $product_size[$k][5]=='null' && $product_size[$k][4]!='')
               //      {

               //          $second_unit=0;
               //          $no_product_size[]=$second_unit; 
               //          $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check Secondary package Unit is empty'];  
               //      }
               //      else if(is_numeric($product_size[$k][5])==false && $product_size[$k][4]!='')
               //      {
               //          $second_unit=0;
               //          $no_product_size[]=$second_unit; 
               //          $ret_arr=['code'=>'3','status'=>false,'message'=>'Secondary package Unit numeric only'];  

               //      }
               //      else if($product_size[$k][5]!='' && $product_size[$k][4]!='')
               //      {
               //          $second_unit=1;
               //          $no_product_size[]=$second_unit; 
               //      }

           
    	    if($product_size[$k][4]!='' && $product_size[$k][4]!='null')
            {
         		$secondary_name=$product_size[$k][4];		   
		        $qry3="SELECT idSecondaryPackaging FROM secondary_packaging WHERE secondarypackname='$secondary_name' AND status ='1'";
				$result3=$this->adapter->query($qry3,array());
			    $resultset3=$result3->toArray();
               
			    if(!$resultset3){
			    	$secondary=0;
         		    $no_product_size[]=$secondary; 
         		    $ret_arr=['code'=>'3','status'=>false,'message'=>'Secondary package value mismatch'];  

			    }else{
			    	$secondary=1;
         		    $no_product_details[]=$secondary;

                    if($product_size[$k][5]=='' || $product_size[$k][5]=='null')
                    {
                        $second_unit=0;
                        $no_product_size[]=$second_unit; 
                        $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check Secondary package Unit is empty'];  
                    }
                    else if(is_numeric($product_size[$k][5])==false)
                    {
                        $second_unit=0;
                        $no_product_size[]=$second_unit; 
                        $ret_arr=['code'=>'3','status'=>false,'message'=>'Secondary package Unit numeric only'];  

                    }
                    else if($product_size[$k][5]!='')
                    {
                        $second_unit=1;
                        $no_product_size[]=$second_unit; 
                    }

			    }
         	}
            else
            {
                $secondary=1;
                $no_product_details[]=$secondary;
                $second_unit=1;
                $no_product_size[]=$second_unit; 
            }

         	if($product_size[$k][3]=='' || $product_size[$k][3]=='null'){
	     		$first_unit=0;
	        	$no_product_size[]=$first_unit;      
	     	 	$ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the unit empty'];

         	}else if(!is_numeric($product_size[$k][3])){
                $first_unit=0;
                $no_product_size[]=$first_unit; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Unit numeric only'];  

        	}else if($product_size[$k][3]!='' || $product_size[$k][3]!='null'){
         		$first_unit=1;
         	    $no_product_size[]=$first_unit; 
               
         	}

         	if($product_size[$k][2]=='' || $product_size[$k][2]=='null'){
         		$primary=0;
         		$no_product_size[]=$primary; 
         	 	$ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the primary package empty'];
         	}else if($product_size[$k][2]!='' && $product_size[$k][2]!='null'){
         		$primary_name=$product_size[$k][2];		   
		        $qry2="SELECT idPrimaryPackaging FROM primary_packaging WHERE primarypackname='$primary_name' AND status ='1'";
				$result2=$this->adapter->query($qry2,array());
			    $resultset2=$result2->toArray();

			    if(!$resultset2){

			    	$primary=0;
         		    $no_product_size[]=$primary; 
         		    $ret_arr=['code'=>'3','status'=>false,'message'=>'Primary package value mismatch'];  

			    }else{
			    	$primary=1;
         		    $no_product_size[]=$primary;

			    }
         	}

            if($product_size[$k][1]=='' || $product_size[$k][1]=='null'){
	     		$size=0;
	        	$no_product_size[]=$size;      
	     	 	$ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the product size empty'];

         	}else if(!is_numeric($product_size[$k][1])){
                $size=0;
                $no_product_size[]=$size; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Product size numeric only'];  

        	}else if($product_size[$k][1]!='' || $product_size[$k][1]!='null'){
         		$size=1;
         	    $no_product_size[]=$size; 
               
         	}

            if($product_size[$k][0]=='' || $product_size[$k][0]=='null'){
         		$product_code=0;
         		$no_product_size[]=$product_code; 
         	 	$ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the product code empty'];
         	}else if($product_size[$k][0]!='' || product_size[$k][0]!='null'){
         	$product_code=$product_size[$k][0];		   
		     $qry1="SELECT idProduct,productCode FROM product_details WHERE productCode='$product_code' ";

				$result1=$this->adapter->query($qry1,array());
			    $resultset1=$result1->toArray();

			    if(!$resultset1){

			    	$product_code=0;
         		    $no_product_size[]=$product_code; 
         		    $ret_arr=['code'=>'3','status'=>false,'message'=>'Product code value mismatch'];  

			    }else{
			    	$product_code=1;
         		    $no_product_size[]=$product_code;

			    }
         	}

    }



 if(count($no_product_size)!=0){
    for($m=0; $m<count($no_product_size);$m++){ 
            $zero=0;
        if(in_array($zero,$no_product_size)){
           $check=0;
        }else{
           $check=1;

        }
       //print_r($no_product_details);
    }
}else{
	      $check=0;
	      $ret_arr=['code'=>'3','status'=>false,'message'=>'Excel data is empty'];
}

 
  if($check!=0){

				for($i=0; $i<count($product_size);$i++) {
                    //get product id for corresponding product code
                    $prdcode=$product_size[$i][0];   
                    $qryidProduct="SELECT idProduct,productCode FROM product_details WHERE productCode='$prdcode' ";
                    $resultidProduct=$this->adapter->query($qryidProduct,array());
                    $resultsetidProduct=$resultidProduct->toArray();
                    $idProduct=(count($resultsetidProduct)>0)?$resultsetidProduct[0]['idProduct']:0;
                     $pname=$product_size[$i][2]; 
                    //primary package id 
                      $qryidPrimary=" SELECT idPrimaryPackaging FROM primary_packaging WHERE primarypackname='$pname' AND status ='1' ";
                    $resultidPrimary=$this->adapter->query($qryidPrimary,array());
                    $resultsetidPrimary=$resultidPrimary->toArray();
                      $idPrimary=(count($resultsetidPrimary)>0)?$resultsetidPrimary[0]['idPrimaryPackaging']:0;
                     $sname=$product_size[$i][4]; 
                     //secondary package id
                     $qryidSecondary="SELECT idSecondaryPackaging FROM secondary_packaging WHERE secondarypackname='$sname' AND status ='1'";
                    $resultidSecondary=$this->adapter->query($qryidSecondary,array());
                    $resultsetidSecondary=$resultidSecondary->toArray();
                    $idSecondary=(count($resultsetidSecondary)>0)?$resultsetidSecondary[0]['idSecondaryPackaging']:0;

                            $pcount=($product_size[$i][3]!='' && is_numeric($product_size[$i][3])==true)?$product_size[$i][3]:0;
                            $scount=($product_size[$i][5]!='' && is_numeric($product_size[$i][5])==true)?$product_size[$i][5]:0;
                    //check already exist data
					$qry="SELECT * FROM product_size where idProduct=? AND productSize=? AND idPrimaryPackaging=? AND idSecondaryPackaging=? AND productPrimaryCount=? AND productSecondaryCount=?";
					$result=$this->adapter->query($qry,array($idProduct,$product_size[$i][1],$idPrimary,$pcount,$idSecondary,$scount));
					$resultset=$result->toArray();

					if(!$resultset) {
						$this->adapter->getDriver()->getConnection()->beginTransaction();
						try {

							$data['productSize']=$product_size[$i][1];
							$data['idPrimaryPackaging']=$idPrimary;
							$data['idSecondaryPackaging']=$idSecondary;
							$data['productPrimaryCount']=$pcount;
							$data['productSecondaryCount']=$scount;
							$data['idProduct']=$idProduct;
							$data['productImageLeft']='';
							$data['productImageRight']='';
							$data['productImageTop']='';
							$data['productImageBottom']='';
							$data['productImageLeftSide']='';
							$data['productImageRightSide']='';
							$data['created_at']=date('Y-m-d H:i:s');
							$data['created_by']=1;
							$data['updated_at']=date('Y-m-d H:i:s');
							$data['updated_by']=1;
							$insert=new Insert('product_size');
							$insert->values($data);
							$statement=$this->adapter->createStatement();
							$insert->prepareStatement($this->adapter, $statement);
							$insertresult=$statement->execute();
                             $insert_value +=$insert_count+1;
							$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
							$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
							$this->adapter->getDriver()->getConnection()->rollBack();
						}

					 }else {
                        $reject_value += $reject_count+1;        
		
	 		          }
					
				}

	    if($insert_value!=0 && $reject_value==0){

	  $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
	        }else if($insert_value ==0 && $reject_value !=0){

	  $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];

	        }else if($insert_value!=0 && $reject_value!=0){

	  $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists  '.$reject_value.' and Uploaded  '.$insert_value];
	        }

        }

			} else {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please verify the csv file'];
			}
			
		}
		return $ret_arr;

	}  // close fun


public function uploadtransporter($param){
        ini_set('display_errors',true);
		$Uploads_dir = 'public/uploads/csv';
		$tmp_name=$_FILES["myFile"]["tmp_name"]; 
		$name = basename($_FILES["myFile"]["name"]); 
		$imageName = rand(6,66666).'.'. pathinfo($_FILES["myFile"]['name'],PATHINFO_EXTENSION);

    	if(move_uploaded_file($tmp_name, "$Uploads_dir/$imageName")){
			$r="public/uploads/csv/$imageName";
			$file = fopen($r, "r",FILE_SKIP_EMPTY_LINES);
			$emapData = fgetcsv($file, 10000, ","); 
				$row=0;
				$size=sizeof($emapData);

	    if($size=='21' && $emapData !=null){
			    $transporter=array();
				$no_transporter=array();
				while (($record = fgetcsv($file)) !== FALSE){
					$row++;
					array_push($transporter,$record);
				}

		$territory1=0;
	    $territory2=0;
	    $territory3=0;
	    $territory4=0;
	    $territory5=0;
	    $territory6=0;
	    $territory7=0;
	    $territory8=0;
        $territory9=0;
	    $territory10=0;

        $ter_map_value0=0;
	    $ter_map_value1=0;
	    $ter_map_value2=0;
	    $ter_map_value3=0;
	    $ter_map_value4=0;
	    $ter_map_value5=0;
	    $ter_map_value6=0;
	    $ter_map_value7=0;
	    $ter_map_value8=0;
	    $ter_map_value9=0;
	    $ter_map_value10=0;

	    $array_condition=array();
	    $date=date("d-m-Y");

 	    $insert_count=0;
        $reject_count=0;
        $reject_value=0; 
        $insert_value=0;  

     for($k=0; $k<count($transporter);$k++){

         if($transporter[$k][20]!=''){    

		        $ter_value10=$transporter[$k][20];		   
		        $qry10="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value10' AND idTerritoryTitle ='10'";
				$result10=$this->adapter->query($qry10,array());
			    $resultset10=$result10->toArray();	

			    if(!$resultset10){
			    	$no_factory[]=0; 
	                $ter_map_value10=0;
	                $no_transporter[]=$ter_map_value10;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory10 value mismatch'];            
			    }else{  
			       $ter_map_value10=1;
			       $no_transporter[]=$ter_map_value10;
	               }    
        }

       if($transporter[$k][19]!=''){   
       	
                $ter_value9=$transporter[$k][19];		   
		        $qry9="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value9' AND idTerritoryTitle ='9'";
				$result9=$this->adapter->query($qry9,array());
			    $resultset9=$result9->toArray();	

			    if(!$resultset9){ 
	                $ter_map_value9=0;
	                $no_transporter[]=$ter_map_value9;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory9 value mismatch'];

	             
			    }else{  
			       $ter_map_value9=1;
			       $no_transporter[]=$ter_map_value9;
	               }    
        }

         if($transporter[$k][18]!=''){   
       	
                $ter_value8=$transporter[$k][18];		   
		        $qry8="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value8' AND idTerritoryTitle ='8'";
				$result8=$this->adapter->query($qry8,array());
			    $resultset8=$result8->toArray();	

			    if(!$resultset8){
	                $ter_map_value8=0;
	                $no_transporter[]=$ter_map_value8;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory8 value mismatch'];
	             
			    }else{  
			       $ter_map_value8=1;
			       $no_transporter[]=$ter_map_value8;
	               }    
        }

       if($transporter[$k][17]!=''){      
       	
                $ter_value7=$transporter[$k][17];		   
		        $qry7="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value7' AND idTerritoryTitle ='7'";
				$result7=$this->adapter->query($qry7,array());
			    $resultset7=$result7->toArray();	

			    if(!$resultset7){
	                $ter_map_value7=0;
	                $no_transporter[]=$ter_map_value7;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory7 value mismatch'];

	             
			    }else{ 
			       $ter_map_value7=1;
			       $no_transporter[]=$ter_map_value7;
	               }    
        }

       if($transporter[$k][16]!=''){      
       	
                $ter_value6=$transporter[$k][16];		   
		        $qry6="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value6' AND idTerritoryTitle ='6'";
				$result6=$this->adapter->query($qry6,array());
			    $resultset6=$result6->toArray();	

			    if(!$resultset6){ 
	                $ter_map_value6=0;
	                $no_transporter[]=$ter_map_value6;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory6 value mismatch'];

	             
			    }else{  
			       $ter_map_value6=1;
			       $no_transporter[]=$ter_map_value6;
	               }    
        }

       if($transporter[$k][15]!=''){      
                $ter_value5=$transporter[$k][15];		   
		        $qry5="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value5' AND idTerritoryTitle ='5'";
				$result5=$this->adapter->query($qry5,array());
			    $resultset5=$result5->toArray();	

			    if(!$resultset5){ 
	                $ter_map_value5=0;
	                $no_transporter[]=$ter_map_value5;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory5 value mismatch'];

	             
			    }else{  
			       $ter_map_value5=1;
			       $no_transporter[]=$ter_map_value5;
	               }    
        }

        if($transporter[$k][14]!=''){       	
       	
                $ter_value4=$transporter[$k][14];		   
		        $qry4="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value4' AND idTerritoryTitle ='4'";
				$result4=$this->adapter->query($qry4,array());
			    $resultset4=$result4->toArray();	

			    if(!$resultset4){ 
	                $ter_map_value4=0;
	                $no_transporter[]=$ter_map_value4;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory4 value mismatch'];
	             
			    }else{ 
			       $ter_map_value4=1;
			       $no_transporter[]=$ter_map_value4;
	               }    
        }

        if($transporter[$k][13]!=''){ 
       	
                $ter_value3=$transporter[$k][13];		   
		        $qry3="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value3' AND idTerritoryTitle ='3'";
				$result3=$this->adapter->query($qry3,array());
			    $resultset3=$result3->toArray();	

			    if(!$resultset3){  
	                $ter_map_value3=0;
	                $no_transporter[]=$ter_map_value3;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory3 value mismatch'];

	             
			    }else{  
			       $ter_map_value3=1;
			       $no_transporter[]=$ter_map_value3;
	               }    
        }

         if($transporter[$k][12]!=''){ 
       	
                $ter_value2=$transporter[$k][12];		   
		        $qry2="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value2' AND idTerritoryTitle ='2'";
				$result2=$this->adapter->query($qry2,array());
			    $resultset2=$result2->toArray();	

			    if(!$resultset2){  
	                $ter_map_value2=0;
	                $no_transporter[]=$ter_map_value2;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory2 value mismatch'];
	             
			    }else{  
			       $ter_map_value2=1;
			       $no_transporter[]=$ter_map_value2;
	               }    
        }

        if($transporter[$k][11]!=''){ 
     	
                $ter_value1=$transporter[$k][11];		   
		        $qry1="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value1' AND idTerritoryTitle ='1'";
				$result1=$this->adapter->query($qry1,array());
			    $resultset1=$result1->toArray();	

			    if(!$resultset1){   
	                $ter_map_value1=0;
	                $no_transporter[]=$ter_map_value1;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory1 value mismatch'];
	             
			    }else{  
			       $ter_map_value1=1;
			       $no_transporter[]=$ter_map_value1;
	               }    
        }
             
            // if($transporter[$k][10]!=''){
            //   $no_transporter[]=$transporter[$k][10];   
            // }else{
            //     $no_transporter[]=0;   
            // }

             if($transporter[$k][9]!=''){
              
               if(!is_numeric($transporter[$k][9])){
                  	$mobile2=0;
	                $no_transporter[]=$mobile2; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Mobile2 number numeric only'];  
	 
        	    }
	        	if((strlen($transporter[$k][6])<10) || (strlen($transporter[$k][6])>10)){

		                $mobile2=0; 
		                $no_transporter[]=$mobile2; 
		                $ret_arr=['code'=>'3','status'=>false,'message'=>'Mobile2 number length 10 allowed'];  
	        	}

            }

            else{
            	$mobile2=1;
                $no_transporter[]=$mobile2;   

            }
            //  if($transporter[$k][8]!=''){
            //   $no_transporter[]=$transporter[$k][8];   
            // }else{
            //     $no_transporter[]=0;            

            // }

            // if($transporter[$k][7]!=''){
            //   $no_transporter[]=$transporter[$k][7];   
            // }else{
            //     $no_transporter[]=0;   

            // }


            if($transporter[$k][6]!=''){
              $no_transporter[]=$transporter[$k][6];   

            if(!is_numeric($transporter[$k][6])){
                 	$mobile1=0;
	                $no_transporter[]=$mobile1; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Mobile1 number numeric only'];  

        	}
        	if((strlen($transporter[$k][6])<10) || (strlen($transporter[$k][6])>10)){
                 	$mobile1=0;
	                $no_transporter[]=$mobile1; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Mobile1 number length 10 allowed'];  
        	}

            }else{
            	$mobile1=1;
                $no_transporter[]=$mobile1;   

            }

            // if($transporter[$k][5]!=''){
            //   $no_transporter[]=$transporter[$k][5];   
            // }else{
            //     $no_transporter[]=0;     

            // }

            if($transporter[$k][4]=="Active" || $transporter[$k][4]=="active"){
                $status=1;
                $no_transporter[]=$status;
        	}else if($transporter[$k][4]=="Inactive" || $transporter[$k][4]=="inactive"){
        		$status=2;
        		 $no_transporter[]=$status;
        	}else if($transporter[$k][4]=='' ||$transporter[$k][4]=="null"){
                $status=0; 
                 $no_transporter[]=$status;
   
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status empty'];    
        	}else{
                $status=0; 
                 $no_transporter[]=$status;  
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status data'];    
        	}

           /* if($transporter[$k][2]==$transporter[$k][3]){
            	$same_date=0;
            	 $no_transporter[]=$same_date;
         	 	$ret_arr=['code'=>'3','status'=>false,'message'=>'Please change same dates not allowed'];

            }*/

           /* if($transporter[$k][2]>$transporter[$k][3]){
            	$great_date=0;
            	 $no_transporter[]=$great_date;
         	 	$ret_arr=['code'=>'3','status'=>false,'message'=>'Please change the date'];

            }*/

            $current_date=(strtotime($date));
            $fromdate=(strtotime($transporter[$k][2]));
            $todate=(strtotime($transporter[$k][3]));
           


            if($fromdate < $current_date){
               
                $past_date2=0;
            	$no_transporter[]=$past_date2;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'From date not allows past date'];
            }else{
                $past_date2=1;
            	$no_transporter[]=$past_date2;        	
            }
 
            if($todate < $fromdate ){
                $past_date1=0;
            	$no_transporter[]=$past_date1;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'To date should be greater than to from date'];
            }else if($todate == $fromdate ){
                $past_date1=0;
                $no_transporter[]=$past_date1;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'To date should be greater than to from date'];
            }else{
                $past_date1=1;
            	$no_transporter[]=$past_date1;      	
            }


         	if($transporter[$k][3]=='' || $transporter[$k][3]=='null'){
         		$to_date=0;
            	$no_transporter[]=$to_date;      
         	 	$ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the todate empty'];

         	}else if($transporter[$k][3]!='' || $transporter[$k][3]!='null'){
         		
                 if(!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/",$transporter[$k][3])
){

                  $to_date=0;
                  $no_transporter[]=$to_date; 

                  $ret_arr=['code'=>'3','status'=>false,'message'=>'To date invalid date format'];
                  
                }
                // else if(!is_numeric($transporter[$k][6])){
                //     $to_date=0;
                //     $no_transporter[]=$to_date; 
                //     $ret_arr=['code'=>'3','status'=>false,'message'=>'Todate invalid date format'];  

                // }else if(($this->validate($transporter[$k][2]))==true){

                //     $to_date=0;
                //     $no_transporter[]=$to_date; 
                //     $ret_arr=['code'=>'3','status'=>false,'message'=>'Todate format worng'];  
                        
                // }
                else{
                
                   $to_date=1;
                   $no_transporter[]=$to_date; 
                }                
               
         	}


         	if($transporter[$k][2]=='' || $transporter[$k][2]=='null'){
         		$from_date=0;
         		$no_transporter[]=$from_date; 
         	 	$ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the from date empty'];

         	}else if($transporter[$k][2]!='' || $transporter[$k][2]!='null'){

                if(!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/",$transporter[$k][2])
){

                    $from_date=0;
                    $no_transporter[]=$from_date; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'From date invalid date format'];
                  
                }
                // else if(!is_numeric($transporter[$k][6])){
                //     $from_date=0;
                //     $no_transporter[]=$from_date; 
                //     $ret_arr=['code'=>'3','status'=>false,'message'=>'Fromdate invalid date format'];  

                // }else if(($this->validate($transporter[$k][2]))==true){

                //     $from_date=0;
                //     $no_transporter[]=$from_date; 
                //     $ret_arr=['code'=>'3','status'=>false,'message'=>'Fromdate format worng'];  
                        
                // }
                else{
                
                    $from_date=1;
                    $no_transporter[]=$from_date; 
                }                               
               
         	}


         	if($transporter[$k][1]=='' || $transporter[$k][1]=='null'){
         		$mobile=0;
         		$no_transporter[]=$mobile; 
         	 	$ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the mobile empty'];
         	}else if(!is_numeric($transporter[$k][1])){
                $mobile=0;
                $no_transporter[]=$mobile; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Mobile number numeric only'];  

        	}else if((strlen($transporter[$k][1])<10) || (strlen($transporter[$k][1])>10)){
                $mobile=0;
                $no_transporter[]=$mobile; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please enter valid mobile number'];  
        	}else{
         		$mobile=1;
         		$no_transporter[]=$mobile; 
        
         	}

         	if($transporter[$k][0]=='' || $transporter[$k][0]=='null'){
         		$name=0;
         		$no_transporter[]=$name; 
         	 	$ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the name empty'];
         	}else if($transporter[$k][0]!='' || $transporter[$k][0]!='null'){
         		$name=1;
         		$no_transporter[]=$name; 
         	}


 } // close loop


 if(count($no_transporter)!=0){
    for($m=0; $m<count($no_transporter);$m++){ 
            $zero=0;
        if(in_array($zero,$no_transporter)){
           $check=0;
        }else{
           $check=1;

        }
       
    }
}else{
	      $check=0;
	      $ret_arr=['code'=>'3','status'=>false,'message'=>'Excel data is empty'];
}




if($check!=0){

	 for($i=0; $i<count($transporter);$i++) {	

			    if($transporter[$i][11]!=''){    	
			    	$ter_value1=$transporter[$i][11];		   
			        $qry1="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value1' AND idTerritoryTitle ='1'";
					$result1=$this->adapter->query($qry1,array());
				    $resultset1=$result1->toArray();
				    $territory1=$resultset1[0]['idTerritory'];
			    }else{
			    	$territory1=0;
			    }
			    if($transporter[$i][12]!=''){
			    	$ter_value2=$transporter[$i][12];	   
			        $qry2="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value2' AND idTerritoryTitle ='2'";
					$result2=$this->adapter->query($qry2,array());
				    $resultset2=$result2->toArray();	
			    	$territory2=$resultset2[0]['idTerritory'];
			    }else{
			    	$territory2=0;
			    }
			    if($transporter[$i][13]!=''){
			    	$ter_value3=$transporter[$i][13];		   
			        $qry3="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value3' AND idTerritoryTitle ='3'";
					$result3=$this->adapter->query($qry3,array());
				    $resultset3=$result3->toArray();
			    	$territory3=$resultset3[0]['idTerritory'];
			    }else{
			    	$territory3=0;
			    }
			    if($transporter[$i][14]!=''){
			    	$ter_value4=$transporter[$i][14];	   
			        $qry4="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value4' AND idTerritoryTitle ='4'";
					$result4=$this->adapter->query($qry4,array());
				    $resultset4=$result4->toArray();	

			    	$territory4=$resultset4[0]['idTerritory'];
			    }else{
			    	$territory4=0;
			    }
			    if($transporter[$i][15]!=''){
			    	$ter_value5=$transporter[$i][15];   
			        $qry5="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value5' AND idTerritoryTitle ='5'";
					$result5=$this->adapter->query($qry5,array());
				    $resultset5=$result5->toArray();
			    	$territory5=$resultset5[0]['idTerritory'];
			    }else{
			    	$territory5=0;
			    }
			    if($transporter[$i][16]!=''){
			    	$ter_value6=$transporter[$i][16];	   
			        $qry6="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value6' AND idTerritoryTitle ='6'";
					$result6=$this->adapter->query($qry6,array());
				    $resultset6=$result6->toArray();	
			    	$territory6=$resultset6[0]['idTerritory'];
			    }else{
			    	$territory6=0;
			    }
			    if($transporter[$i][17]!=''){
			    	$ter_value7=$transporter[$i][17];		   
			        $qry7="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value7' AND idTerritoryTitle ='7'";
					$result7=$this->adapter->query($qry7,array());
				    $resultset7=$result7->toArray();	
			    	$territory7=$resultset7[0]['idTerritory'];
			    }else{
			    	$territory7=0;
			    }
			    if($transporter[$i][18]!=''){
			    	$ter_value8=$transporter[$i][18];		   
			        $qry8="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value8' AND idTerritoryTitle ='8'";
					$result8=$this->adapter->query($qry8,array());
				    $resultset8=$result8->toArray();	
			    	$territory8=$resultset8[0]['idTerritory'];
			    }else{
			    	$territory8=0;
			    }
			    if($transporter[$i][19]!=''){
			    	$ter_value9=$transporter[$i][19];	   
			        $qry9="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value9' AND idTerritoryTitle ='9'";
					$result9=$this->adapter->query($qry9,array());
				    $resultset9=$result9->toArray();
			    	$territory9=$resultset9[0]['idTerritory'];
			    }else{
			    	$territory9=0;
			    }
			    if($transporter[$i][20]!=''){
				    $ter_value10=$transporter[$i][20];	   
			        $qry10="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value10' AND idTerritoryTitle ='10'";
					$result10=$this->adapter->query($qry10,array());
				    $resultset10=$result10->toArray();
			    	$territory10=$territory10[0]['idTerritory'];
			    }else{
			    	$territory10=0;
			    }

			    if($transporter[$i][4]=="Active" || $transporter[$i][4]=="active"){
                $status=1;
	        	}else if($transporter[$i][4]=="Inactive" || $transporter[$i][4]=="inactive"){
	        	$status=2;
	        	}

    $qry_list="SELECT a.idVehicle as id,a.vehicleName as name,a.vehicleCapacity as capacity,a.vehiclePerKm as perkm,a.vehicleMinCharge as mincharge,a.status 
	        FROM vehicle_master a where status!='2'";
	$result_list=$this->adapter->query($qry_list,array());
	$resultset_list=$result_list->toArray();

    $qry="SELECT idTransporter FROM transporter_master where transporterName=? and transporterMobileNo=?";
    $result=$this->adapter->query($qry,array($transporter[$i][0],$transporter[$i][1]));
    $resultset=$result->toArray();

            if(!$resultset){
            	 $this->adapter->getDriver()->getConnection()->beginTransaction();
            	 try {
						$data['transporterName']=$transporter[$i][0];
						$data['transporterMobileNo']=$transporter[$i][1];
						$data['t1']=(($transporter[$i][11]!='')? $resultset1[0]['idTerritory']:0);
						$data['t2']=(($transporter[$i][12]!='')? $resultset2[0]['idTerritory']:0);
						$data['t3']=(($transporter[$i][13]!='')? $resultset3[0]['idTerritory']:0);
						$data['t4']=(($transporter[$i][14]!='')? $resultset4[0]['idTerritory']:0);
						$data['t5']=(($transporter[$i][15]!='')? $resultset5[0]['idTerritory']:0);
						$data['t6']=(($transporter[$i][16]!='')? $resultset6[0]['idTerritory']:0);
						$data['t7']=(($transporter[$i][17]!='')? $resultset7[0]['idTerritory']:0);
						$data['t8']=(($transporter[$i][18]!='')? $resultset8[0]['idTerritory']:0);
						$data['t9']=(($transporter[$i][19]!='')? $resultset9[0]['idTerritory']:0);
						$data['t10']=(($transporter[$i][20]!='')? $resultset10[0]['idTerritory']:0);
						$data['status']=$status;
						$data['transporterName1']=$transporter[$i][5];
						$data['transporterMobile1']=$transporter[$i][6];
						$data['transporterMail1']=$transporter[$i][7];
						$data['transporterName2']=$transporter[$i][8];
						$data['transporterMobile2']=$transporter[$i][9];
						$data['transporterMail2']=$transporter[$i][10];
						$data['contractPDFFromDate']=date('Y-m-d',strtotime($transporter[$i][2]));
						$data['contractPDFToDate']=date('Y-m-d',strtotime($transporter[$i][3]));
						$data['contractPDF']='';
						$data['created_at']=date('Y-m-d H:i:s');
						$data['created_by']=1;
						$data['updated_at']=date('Y-m-d H:i:s');
						$data['updated_by']=1;
						$insert=new Insert('transporter_master');
						$insert->values($data);
						$statement=$this->adapter->createStatement();
						$insert->prepareStatement($this->adapter, $statement);
						$insertresult=$statement->execute();

						$Transporterid=$this->adapter->getDriver()->getLastGeneratedValue();
				    	$vehicleinsert['idTransporter']=$Transporterid;	
				
		            for($a=0;$a<count($resultset_list);$a++){
		   
		            	$vehicleinsert['idVehicle']=$resultset_list[$a]['id'];	            	      
		                $vehicleinsert['vehicleCount']='0';    
                        $insertt=new Insert('transporter_vehicle_master');
					    $insertt->values($vehicleinsert);
						$statementt=$this->adapter->createStatement();
						$insertt->prepareStatement($this->adapter, $statementt);
						$insertresultt=$statementt->execute();		          
 	            
					}

				        $insert_value +=$insert_count+1;
						$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
							$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
							$this->adapter->getDriver()->getConnection()->rollBack();
						}

            }else {
                 $reject_value += $reject_count+1;        
		
	 		    }

       }
  
    if($insert_value!=0 && $reject_value==0){

    $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
        }else if($insert_value ==0 && $reject_value !=0){

    $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];

        }else if($insert_value!=0 && $reject_value!=0){

    $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists  '.$reject_value.'Uploaded  '.$insert_value];
        }
   
    }

	    }else{
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please verify the csv file'];
		 }
	
    }
      return $ret_arr;

}  // close func


public function uploadsubsidiaries($param) {

	    ini_set('display_errors',true);
		$Uploads_dir = 'public/uploads/csv';
		$tmp_name=$_FILES["myFile"]["tmp_name"]; 
		$name = basename($_FILES["myFile"]["name"]); 
		$imageName = rand(6,66666).'.'. pathinfo($_FILES["myFile"]['name'],PATHINFO_EXTENSION);
    	if(move_uploaded_file($tmp_name, "$Uploads_dir/$imageName")) {
			$r="public/uploads/csv/$imageName";
			$file = fopen($r, "r",FILE_SKIP_EMPTY_LINES);
			$emapData = fgetcsv($file, 10000, ","); 
				$row=0;
				$size=sizeof($emapData);

	 	if($size=='6' && $emapData !=null) {
				$subsidary=array();
				$title=array('SUBSIDIARIES');
				$no_subsidary=array();
				while (($record = fgetcsv($file)) !== FALSE) {
					$row++;
					array_push($subsidary,$record);
				}
        $insert_count=0;
        $reject_count=0;
        $reject_value=0; 
        $insert_value=0; 
       

    for($k=0; $k<count($subsidary);$k++) {

    	    if($subsidary[$k][5]=="Active" || $subsidary[$k][5]=="active"){

                $status=1;
                $no_subsidary[]=$status;
        	}else if($subsidary[$k][5]=="Inactive" || $subsidary[$k][5]=="inactive"){

        		$status=2;
        		$no_subsidary[]=$status;
        	}else if($subsidary[$k][5]=='' || $subsidary[$k][5]=="null"){
                $status=0; 
                $no_subsidary[]=$status;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status empty'];    
        	}else {
                $status=0;
                $no_subsidary[]=$status;   
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status mismatch'];    
        	}

        	if($subsidary[$k][4]=="Consumers"){

                $segment=1;
                $no_subsidary[]=$segment;
        	}else if($subsidary[$k][4]=="Business"){

        		$segment=2;
        		  $no_subsidary[]=$segment;
        	}else if($subsidary[$k][4]=="Consumers and Business"){

        		$segment=3;
        		  $no_subsidary[]=$segment;
        	}else if($subsidary[$k][4]=='' || $subsidary[$k][4]=="null"){
                $segment=0;   
                 $no_subsidary[]=$segment; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the segment empty'];    
        	}else {
                $segment=0;  
                  $no_subsidary[]=$segment; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the segment mismatch'];    
        	}


        	if($subsidary[$k][3]=="Products"){
                $proposition=1;
                 $no_subsidary[]=$proposition;
        	}else if($subsidary[$k][3]=="Services"){

        		$proposition=2;
        		 $no_subsidary[]=$proposition;
        	}else if($subsidary[$k][3]=="Products and services"){

        		$proposition=3;
        		 $no_subsidary[]=$proposition;
        	}else if($subsidary[$k][3]=='' || $subsidary[$k][3]=="null"){
                $proposition=0; 
                 $no_subsidary[]=$proposition;    
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the proposition empty'];    
        	}else{
                 $proposition=0;
                  $no_subsidary[]=$proposition;
        		 $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the proposition mismatch']; 
        	}

           if($subsidary[$k][2]=='' || $subsidary[$k][2]=="null"){
    	    	$subsidary_name=0;   
    	    	 $no_subsidary[]=$subsidary_name;  
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the subsidary empty'];

    	    }else if($subsidary[$k][2]!='' || $subsidary[$k][2]!="null"){

        		$subsidary_name=1;
        		$no_subsidary[]=$subsidary_name; 
        	}

        	if($subsidary[$k][1]=='' || $subsidary[$k][1]=="null"){
                $type=0;  
                $no_subsidary[]=$type;    
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the type empty'];    
        	}else if(($subsidary[$k][1]=="Sub-companies")){
                $type=1;
                $no_subsidary[]=$type; 
        	}else if(($subsidary[$k][1]=="Subsidiaries")){

        		$type=2;
        		$no_subsidary[]=$type; 
        	}else if(($subsidary[$k][1]=="Divisions")){

        		$type=3;
        		$no_subsidary[]=$type; 
        	}else{
                $type=0;
                $no_subsidary[]=$type; 
        		$ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the type mismatch']; 
        	}

        
            if($subsidary[$k][0]=='' || $subsidary[$k][0]=="null"){
    	    	$main_group=0; 
    	    	$no_subsidary[]=$main_group;     
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the main group empty'];

    	    }else if($subsidary[$k][0]!='' || $subsidary[$k][0]!="null"){
    	    	    $main=$subsidary[$k][0];
			        $qry1="SELECT idMainGroup,mainGroupName FROM maingroup_master WHERE mainGroupName='$main'";
				  	$result1=$this->adapter->query($qry1,array());
					$resultset1=$result1->toArray();

					if(!$resultset1){						   
                         	$main_group=0;     
                         	$no_subsidary[]=$main_group;  
                     $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the main group mismatch'];
					}else{
						$main_group=1;  
						$no_subsidary[]=$main_group;     
	                        

					}

	       }
    }

if(count($no_subsidary)!=0){
    for($j=0; $j<count($no_subsidary);$j++){ 
            $zero=0;
        if(in_array($zero,$no_subsidary)){

           $check=0;
        }else{
           $check=1;

        }      
    }
}else{
	  $check=0;
	  $ret_arr=['code'=>'3','status'=>false,'message'=>'Excel data is empty'];
}

         
    if($check!=0){   

	   for($i=0; $i<count($subsidary);$i++) {
					
	     $main=$subsidary[$i][0];
         $qry1="SELECT idMainGroup,mainGroupName FROM maingroup_master WHERE mainGroupName='$main'";
	     $result1=$this->adapter->query($qry1,array());
		 $resultset1=$result1->toArray();

		   if(($subsidary[$i][1]=="Sub-companies")){
                $type=1;
        	}else if(($subsidary[$i][1]=="Subsidiaries")){

        		$type=2;
        	}else if(($subsidary[$i][1]=="Divisions")){

        		$type=3;
        	}

	    	if($subsidary[$i][3]=="Products"){

                $proposition=1;
        	}else if($subsidary[$i][3]=="Services"){

        		$proposition=2;
        	}else if($subsidary[$i][3]=="Products and services"){

        		$proposition=3;
        	}

        	if($subsidary[$i][4]=="Consumers"){

                $segment=1;
        	}else if($subsidary[$i][4]=="Business"){

        		$segment=2;
        	}else if($subsidary[$i][4]=="Consumers and Business"){

        		$segment=3;
        	}

        	if($subsidary[$i][5]=="Active" || $subsidary[$i][5]=="active"){
		         $status=1;
        	}else if($subsidary[$i][5]=="Inactive" || $subsidary[$i][5]=="inactive"){

        		$status=2;
		    }

        $qry="SELECT idMainGroup,subsidaryName,proposition,segment FROM subsidarygroup_master where subsidaryName=? and proposition=? and segment=?";

		$result=$this->adapter->query($qry,array($subsidary[$i][2],$proposition,$segment));
		$resultset=$result->toArray();

            if(!$resultset){
            	 $this->adapter->getDriver()->getConnection()->beginTransaction();
            	 try {
						$data['idMainGroup']=$resultset1[0]['idMainGroup'];
						$data['idSubsidiariestype']=$type;
						$data['subsidaryName']=$subsidary[$i][2];	
						$data['proposition']=$proposition;
						$data['segment']=$segment;
						$data['status']=$status;
						$data['created_at']=date('Y-m-d H:i:s');
						$data['created_by']=1;
						$data['updated_at']=date('Y-m-d H:i:s');
						$data['updated_by']=1;
						$insert=new Insert('subsidarygroup_master');
						$insert->values($data);
						$statement=$this->adapter->createStatement();
						$insert->prepareStatement($this->adapter, $statement);
						$insertresult=$statement->execute();
				        $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
				        $insert_value +=$insert_count+1;
						$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
							$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
							$this->adapter->getDriver()->getConnection()->rollBack();
						}

            }else {
                 $reject_value += $reject_count+1;        
                   //      $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
		
	 		    }

    
        }

        if($insert_value!=0 && $reject_value==0){

            //  $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully '.$insert_value .' data'];
              $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
        }else if($insert_value ==0 && $reject_value !=0){

        	// $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists '.$reject_value.' data'];
        	 $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists data'];

        }else if($insert_value!=0 && $reject_value!=0){

        $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists  '.$reject_value.'Uploaded  '.$insert_value];
        }
     }     
		
    }else{
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please verify the csv file'];
		 }
	}


	return $ret_arr;

    }  // close func


    public function uploadcustomertype($param) {

		ini_set('display_errors',true);
		$Uploads_dir = 'public/uploads/csv';
		$tmp_name=$_FILES["myFile"]["tmp_name"]; 
		$name = basename($_FILES["myFile"]["name"]); 
		$imageName = rand(6,66666).'.'. pathinfo($_FILES["myFile"]['name'],PATHINFO_EXTENSION);
    	if(move_uploaded_file($tmp_name, "$Uploads_dir/$imageName")) {
			$r="public/uploads/csv/$imageName";
			$file = fopen($r, "r",FILE_SKIP_EMPTY_LINES);
			$emapData = fgetcsv($file, 10000, ","); 
				$row=0;
				$size=sizeof($emapData);

				if($size=='3' && $emapData !=null) {
				$customertype=array();
				$no_customertype=array();
				while (($record = fgetcsv($file)) !== FALSE) {
					$row++;
					array_push($customertype,$record);
				}

		$insert_count=0;
        $reject_count=0;
        $reject_value=0; 
        $insert_value=0;  

	 for($k=0; $k<count($customertype);$k++) {

	 	if($customertype[$k][2]=='' || $customertype[$k][2]=="null"){
                $status=0; 
                $no_customertype[] = $status; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status empty'];    
        	}else if($customertype[$k][2]=="Active" || $customertype[$k][2]=="active"){

                $status=1;
                $no_customertype[] = $status; 
        	}else if($customertype[$k][2]=="Inactive" || $customertype[$k][2]=="inactive"){

        		$status=2;
        		 $no_customertype[] = $status; 
            }else{
                $status=0;  
                 $no_customertype[] = $status;    
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status data'];    
        	}
            $level=$customertype[$k][1];
        if($customertype[$k][1]=='' || $customertype[$k][1]=="null"){
                $customerlevel=0;  
                 $no_customertype[] = $customerlevel;   
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the customer level empty'];
            }else if(!is_numeric($customertype[$k][1])){
                $customerlevel=0;  
                 $no_customertype[] = $customerlevel;    
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Customer level numeric only'];  

            }else if($customertype[$k][1]!='' || $customertype[$k][1]!="null"){
                $qryclevel="SELECT a.level from customertype as a WHERE a.level='$level'";
            $resultclevel=$this->adapter->query($qryclevel,array());
            $resultsetclevel=$resultclevel->toArray();  
            if($resultsetclevel){
                $customerlevel=0;  
                 $no_customertype[] = $customerlevel;   
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Customer level already exists'];
            }else
            {
                $customerlevel=1;    
                 $no_customertype[] = $customerlevel; 
            }
                 
        }

        if($customertype[$k][0]=='' || $customertype[$k][0]=="null"){
		    	$customer1=0;  
		    	 $no_customertype[] = $customer1;   
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the customer type empty'];

		    }else if($customertype[$k][0]!='' || $customertype[$k][0]!="null"){
                $qry1="SELECT idCustomerType,custType FROM customertype where custType=?";
            $result1=$this->adapter->query($qry1,array($customertype[$k][0]));
            $resultset1=$result1->toArray();
            if ($resultset1) {
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Customer type already exists'];
            }else{

                $customer1=1;    
                 $no_customertype[] = $customer1; 
            }
                 
        }

        	
                
	  }

if(count($no_customertype)!=0){
    for($j=0; $j<count($no_customertype);$j++){ 
            $zero=0;
        if(in_array($zero,$no_customertype)){

           $check=0;
        }else{
           $check=1;

        }      
    }
}else{
	  $check=0;
	  $ret_arr=['code'=>'3','status'=>false,'message'=>'Excel data is empty'];
}

	  
 if($check!=0){

	for($i=0; $i<count($customertype);$i++) {
	
	$qry="SELECT idCustomerType,custType FROM customertype where custType=?";
	$result=$this->adapter->query($qry,array($customertype[$i][0]));
	$resultset=$result->toArray();

	    if($customertype[$i][1]=="Active" || $customertype[$i][1]=="active"){
            $status=1;
    	}else if($customertype[$i][1]=="Inactive" || $customertype[$i][1]=="inactive"){

    		$status=2;
        }

					if(!$resultset){
						$this->adapter->getDriver()->getConnection()->beginTransaction();
						try {					
                            $data['custType']=$customertype[$i][0];
                            $data['level']=$customertype[$i][1];
							$data['status']=$status;
							$data['created_at']=date('Y-m-d H:i:s');
							$data['created_by']=1;
							$data['updated_at']=date('Y-m-d H:i:s');
							$data['updated_by']=1;
							$insert=new Insert('customertype');
							$insert->values($data);
							$statement=$this->adapter->createStatement();
							$insert->prepareStatement($this->adapter, $statement);
							$insertresult=$statement->execute();
							$insert_value +=$insert_count+1;
					    //    $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
							$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
							$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
							$this->adapter->getDriver()->getConnection()->rollBack();
						}
					} else {

						$reject_value += $reject_count+1;
						//$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
				
					}

                }

        if($insert_value!=0 && $reject_value==0){

             // $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully '.$insert_value .' data'];
              $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
        }else if($insert_value ==0 && $reject_value !=0){

        	// $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists '.$reject_value.' data'];
        	 $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists data'];

        }else if($insert_value!=0 && $reject_value!=0){

        $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists  '.$reject_value.'Uploaded  '.$insert_value];
        }

		
				}
			} else {
				   $ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please verify the csv file'];
			}

			
		}

		return $ret_arr;

	}  // close func

  public function uploadcardtypemaster($param) {
        $userid=$param->userid;
        ini_set('display_errors',true);
        $Uploads_dir = 'public/uploads/csv';
        $tmp_name=$_FILES["myFile"]["tmp_name"]; 
        $name = basename($_FILES["myFile"]["name"]); 
        $imageName = rand(6,66666).'.'. pathinfo($_FILES["myFile"]['name'],PATHINFO_EXTENSION);
        if(move_uploaded_file($tmp_name, "$Uploads_dir/$imageName")) {
            $r="public/uploads/csv/$imageName";
            $file = fopen($r, "r",FILE_SKIP_EMPTY_LINES);
            $emapData = fgetcsv($file, 10000, ","); 
                $row=0;
                $size=sizeof($emapData);

                if($size=='2' && $emapData !=null) {
                $cardtype=array();
                $no_cardtype=array();
                while (($record = fgetcsv($file)) !== FALSE) {
                    $row++;
                    array_push($cardtype,$record);
                }

        $insert_count=0;
        $reject_count=0;
        $reject_value=0; 
        $insert_value=0;  

     for($k=0; $k<count($cardtype);$k++) {

        if($cardtype[$k][1]=='' || $cardtype[$k][1]=="null"){
                $status=0; 
                $no_cardtype[] = $status; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status empty'];    
            }else if($cardtype[$k][1]=="Active" || $cardtype[$k][1]=="active"){

                $status=1;
                $no_cardtype[] = $status; 
            }else if($cardtype[$k][1]=="Inactive" || $cardtype[$k][1]=="inactive"){

                $status=2;
                 $no_cardtype[] = $status; 
            }else{
                $status=0;  
                 $no_cardtype[] = $status;    
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status data mismatch'];    
            }

        if($cardtype[$k][0]=='' || $cardtype[$k][0]=="null"){
                $customer1=0;  
                 $no_cardtype[] = $customer1;   
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the card type name empty'];

            }else if($cardtype[$k][0]!='' || $cardtype[$k][0]!="null"){
                $customer1=1;    
                 $no_cardtype[] = $customer1; 
                 
        }

            
                
      }

if(count($no_cardtype)!=0){
    for($j=0; $j<count($no_cardtype);$j++){ 
            $zero=0;
        if(in_array($zero,$no_cardtype)){

           $check=0;
        }else{
           $check=1;

        }      
    }
}else{
      $check=0;
      $ret_arr=['code'=>'3','status'=>false,'message'=>'Excel data is empty'];
}

      
 if($check!=0){

    for($i=0; $i<count($cardtype);$i++) {
    
    $qry="SELECT idCardtype,cardtypeName FROM card_type where cardtypeName=?";
    $result=$this->adapter->query($qry,array($cardtype[$i][0]));
    $resultset=$result->toArray();

        if($cardtype[$i][1]=="Active" || $cardtype[$i][1]=="active"){
            $status=1;
        }else if($cardtype[$i][1]=="Inactive" || $cardtype[$i][1]=="inactive"){

            $status=2;
        }

                    if(!$resultset){
                        $this->adapter->getDriver()->getConnection()->beginTransaction();
                        try {                   
                            $data['cardtypeName']=$cardtype[$i][0];
                            $data['status']=$status;
                            $data['created_at']=date('Y-m-d H:i:s');
                            $data['created_by']=1;
                            $data['updated_at']=date('Y-m-d H:i:s');
                            $data['updated_by']=1;
                           
                            $insert=new Insert('card_type');
                            $insert->values($data);
                            $statement=$this->adapter->createStatement();
                            $insert->prepareStatement($this->adapter, $statement);
                            $insertresult=$statement->execute();
                            $insert_value +=$insert_count+1;
                        //    $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
                            $this->adapter->getDriver()->getConnection()->commit();
                        } catch(\Exception $e) {
                            $ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
                            $this->adapter->getDriver()->getConnection()->rollBack();
                        }
                    } else {

                        $reject_value += $reject_count+1;
                        //$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
                
                    }

                }

        if($insert_value!=0 && $reject_value==0){

             // $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully '.$insert_value .' data'];
              $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
        }else if($insert_value ==0 && $reject_value !=0){

            // $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists '.$reject_value.' data'];
             $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists data'];

        }else if($insert_value!=0 && $reject_value!=0){

        $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists  '.$reject_value.'Uploaded  '.$insert_value];
        }

        
                }
            } else {
                   $ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please verify the csv file'];
            }

            
        }

        return $ret_arr;

    }  // close func


    public function uploadbankmaster($param) {
        $userid=$param->userid;
     
        ini_set('display_errors',true);
        $Uploads_dir = 'public/uploads/csv';
        $tmp_name=$_FILES["myFile"]["tmp_name"]; 
        $name = basename($_FILES["myFile"]["name"]); 
        $imageName = rand(6,66666).'.'. pathinfo($_FILES["myFile"]['name'],PATHINFO_EXTENSION);
        if(move_uploaded_file($tmp_name, "$Uploads_dir/$imageName")) {
            $r="public/uploads/csv/$imageName";
            $file = fopen($r, "r",FILE_SKIP_EMPTY_LINES);
            $emapData = fgetcsv($file, 10000, ","); 
                $row=0;
                $size=sizeof($emapData);

                if($size=='3' && $emapData !=null) {
                $bankdata=array();
                $no_bankdata=array();
                while (($record = fgetcsv($file)) !== FALSE) {
                    $row++;
                    array_push($bankdata,$record);
                }

        $insert_count=0;
        $reject_count=0;
        $reject_value=0; 
        $insert_value=0;
     

     for($k=0; $k<count($bankdata);$k++) {

        if($bankdata[$k][2]=='' || $bankdata[$k][2]=="null"){
                $status=0; 
                $no_bankdata[] = $status; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status is empty'];    
            }else if($bankdata[$k][2]=="Active" || $bankdata[$k][2]=="active"){

                $status=1;
                $no_bankdata[] = $status; 
            }else if($bankdata[$k][2]=="Inactive" || $bankdata[$k][2]=="inactive"){

                $status=2;
                 $no_bankdata[] = $status; 
            }else{
                $status=0;  
                 $no_bankdata[] = $status;    
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status data'];    
            }

        if($bankdata[$k][1]=='' || $bankdata[$k][1]=="null"){
                $customer1=0;  
                 $no_bankdata[] = $customer1;   
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the IFSC code is empty'];

            }else if($bankdata[$k][1]!='' || $bankdata[$k][1]!="null"){

                /*$ifsc=$bankdata[$k][1];
                $qry1="SELECT bankIFSC FROM bank WHERE bankIFSC='$ifsc'";
                $result1=$this->adapter->query($qry1,array());
                $resultset1=$result1->toArray();
                print_r($resultset1);exit;*/
               
                /*if($resultsetIfsc){
                    $customer1=0;  
                    $no_bankdata[] = $customer1;  
                     $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the IFSC code already exists']; 
                }else{*/
                    $customer1=1;    
                    $no_bankdata[] = $customer1; 
                //}
                 
        }

        if($bankdata[$k][0]=='' || $bankdata[$k][0]=="null"){
            $customer1=0;  
            $no_bankdata[] = $customer1;   
            $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the Bank name is empty'];

        }else if($bankdata[$k][0]!='' || $bankdata[$k][0]!="null"){
            $customer1=1;    
            $no_bankdata[] = $customer1; 

        }

            
                
      }

if(count($no_bankdata)!=0){
    for($j=0; $j<count($no_bankdata);$j++){ 
            $zero=0;
        if(in_array($zero,$no_bankdata)){

           $check=0;
        }else{
           $check=1;

        }      
    }
}else{
      $check=0;
      $ret_arr=['code'=>'3','status'=>false,'message'=>'Excel data is empty'];
}

      
 if($check!=0){
     

    for($i=0; $i<count($bankdata);$i++) {
    
    $qry="SELECT * FROM bank WHERE bankIFSC=?";
    $result=$this->adapter->query($qry,array($bankdata[$i][1]));
    $resultset=$result->toArray();
    
        if($bankdata[$i][1]=="Active" || $bankdata[$i][1]=="active"){
            $status=1;
        }else if($bankdata[$i][1]=="Inactive" || $bankdata[$i][1]=="inactive"){

            $status=2;
        }

                    if(!$resultset){
                        $this->adapter->getDriver()->getConnection()->beginTransaction();
                        try {                   
                            $data['bankName']=$bankdata[$i][0];
                            $data['bankIFSC']=$bankdata[$i][1];
                            $data['status']=$status;
                            $data['created_at']=date('Y-m-d H:i:s');
                            $data['created_by']=1;
                            $data['updated_at']=date('Y-m-d H:i:s');
                            $data['updated_by']=1;
                            
                            $insert=new Insert('bank');
                            $insert->values($data);
                            $statement=$this->adapter->createStatement();
                            $insert->prepareStatement($this->adapter, $statement);
                            $insertresult=$statement->execute();
                            $insert_value +=$insert_count+1;
                        //    $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
                            $this->adapter->getDriver()->getConnection()->commit();
                        } catch(\Exception $e) {
                            $ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
                            $this->adapter->getDriver()->getConnection()->rollBack();
                        }
                    } else {

                        $reject_value += $reject_count+1;
                        $ret_arr=['code'=>'3','status'=>false,'message'=>'IFSC code already exists'];
                
                    }

                }

        if($insert_value!=0 && $reject_value==0){

             // $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully '.$insert_value .' data'];
              $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
        }else if($insert_value ==0 && $reject_value !=0){

            // $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists '.$reject_value.' data'];
             $ret_arr=['code'=>'3','status'=>false,'message'=>'IFSC code already exists'];

        }else if($insert_value!=0 && $reject_value!=0){

        $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists  '.$reject_value.'Uploaded  '.$insert_value];
        }

        
                }
            } else {
                   $ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please verify the csv file'];
            }

            
        }

        return $ret_arr;

    }  // close func

	public function uploadchannelcustomer($param) {

		ini_set('display_errors',true);
		$Uploads_dir = 'public/uploads/csv';
		$tmp_name=$_FILES["myFile"]["tmp_name"]; 
		$name = basename($_FILES["myFile"]["name"]); 
		$imageName = rand(6,66666).'.'. pathinfo($_FILES["myFile"]['name'],PATHINFO_EXTENSION);
    	if(move_uploaded_file($tmp_name, "$Uploads_dir/$imageName")) {
			$r="public/uploads/csv/$imageName";
			$file = fopen($r, "r",FILE_SKIP_EMPTY_LINES);
			$emapData = fgetcsv($file, 10000, ","); 
				$row=0;
				$size=sizeof($emapData);

				if($size=='3' && $emapData !=null) {
				$customer=array();
				$no_customer=array();
				while (($record = fgetcsv($file)) !== FALSE) {
					$row++;
					array_push($customer,$record);
				}

		$insert_count=0;
        $reject_count=0;
        $reject_value=0; 
        $insert_value=0; 		
    
	 for($k=0; $k<count($customer);$k++) {
         
            if($customer[$k][2]=='' || $customer[$k][2]=="null"){
                $status=0; 
                $no_customer[]= $status;  
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Status is empty'];    
        	}else if($customer[$k][2] =="Active" || $customer[$k][2]=="active"){

                $status=1;
                $no_customer[]= $status;  
        	}else if($customer[$k][2]=="Inactive" || $customer[$k][2]=="inactive"){

        		$status=2;
        		$no_customer[]= $status;  
        	}else {
                $status=0;  
                $no_customer[]= $status;     
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status data'];    
        	}


        	if($customer[$k][1]=='' || $customer[$k][1]=="null"){
                $customer_type=0; 
                $no_customer[]= $customer_type;     
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Customer type is empty'];    
        	}else {

        		$customertype=$customer[$k][1];
        		$qry2="SELECT idCustomerType FROM customertype WHERE custType='$customertype'";
				$result2=$this->adapter->query($qry2,array());
			    $resultset2=$result2->toArray();
            
                if(!$resultset2){

                 $customer_type=0; 
		         $no_customer[]= $customer_type;  

		         $ret_arr=['code'=>'3','status'=>false,'message'=>'Customer type data mismatch'];

			    }else{
		         $customer_type=1; 
		         $no_customer[]= $customer_type;  
			    	 
			    }
             
              
        	}

            if($customer[$k][0] =='' ||$customer[$k][0]=="null"){
		    	$channel=0; 
		    	$no_customer[]= $channel;       
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Channel customer is empty'];

		    }else{

		    	$customername =$customer[$k][0];
                $qry1="SELECT idChannel FROM channel WHERE Channel='$customername'";
				$result1=$this->adapter->query($qry1,array());
			    $resultset1=$result1->toArray();

               if(!$resultset1){
	           $channel=0;   
	           $no_customer[]= $channel;      
	           $ret_arr=['code'=>'3','status'=>false,'message'=>'Channel data mismatch'];

			    }else{
		           $channel=1; 
		           $no_customer[]= $channel;
		          	    	 
			    }           
        	}
              
	  }


if(count($no_customer)!=0){
    for($j=0; $j<count($no_customer);$j++){ 
            $zero=0;
        if(in_array($zero,$no_customer)){

           $check=0;
        }else{
           $check=1;

        }      
    }
}else{
	  $check=0;
	  $ret_arr=['code'=>'3','status'=>false,'message'=>'Excel data is empty'];
}

	  
   if($check!=0){ 

	 for($i=0; $i<count($customer);$i++) {

	    $customername=$customer[$i][0];
        $customertype=$customer[$i][1];

	 	$qry1="SELECT idChannel FROM channel WHERE Channel='$customername'";
		$result1=$this->adapter->query($qry1,array());
  
	    $resultset1=$result1->toArray();

	    $qry2="SELECT idCustomerType FROM customertype WHERE custType='$customertype'";
                $result2=$this->adapter->query($qry2,array());
	    $resultset2=$result2->toArray();
      $chann=$resultset1[0]['idChannel'];
      $cus=$resultset2[0]['idCustomerType'];

	$qry="SELECT idCustomerChannel,idCustomerType,idChannel FROM customer_channel where idCustomerType='$cus' and idChannel='$chann'";
   
	$result=$this->adapter->query($qry,array());
	$resultset=$result->toArray();

	    if($customer[$i][2]=="Active" || $customer[$i][2]=="active"){
            $status=1;
    	}else if($customer[$i][2]=="Inactive" || $customer[$i][2]=="inactive"){
    		$status=2;
        }
					if(!$resultset){
						$this->adapter->getDriver()->getConnection()->beginTransaction();
						try {
						
							$data['idCustomerType']=$resultset2[0]['idCustomerType'];
							$data['idChannel']=$resultset1[0]['idChannel'];
							$data['status']=$status;
							$data['created_at']=date('Y-m-d H:i:s');
							$data['created_by']=1;
							$data['updated_at']=date('Y-m-d H:i:s');
							$data['updated_by']=1;
							$insert=new Insert('customer_channel');
							$insert->values($data);
							$statement=$this->adapter->createStatement();
							$insert->prepareStatement($this->adapter, $statement);
							$insertresult=$statement->execute();
							$insert_value += $insert_count+1;
					     //   $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
							$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
							$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
							$this->adapter->getDriver()->getConnection()->rollBack();
						}
					} else {
                        $reject_value += $reject_count+1;
						//$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
					}
                }

        if($insert_value!=0 && $reject_value==0){

              $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
        }else if($insert_value ==0 && $reject_value !=0){

        	 $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists data'];

        }else if($insert_value!=0 && $reject_value!=0){

        $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists  '.$reject_value.' Uploaded  '.$insert_value];
        }
           
		
				}

			} else {
				   $ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please verify the csv file'];
			}

			
		}

		return $ret_arr;

	}  // close func

	public function uploadgeographytitle($param) {

		ini_set('display_errors',true);
		$Uploads_dir = 'public/uploads/csv';
		$tmp_name=$_FILES["myFile"]["tmp_name"]; 
		$name = basename($_FILES["myFile"]["name"]); 
		$imageName = rand(6,66666).'.'. pathinfo($_FILES["myFile"]['name'],PATHINFO_EXTENSION);
    	if(move_uploaded_file($tmp_name, "$Uploads_dir/$imageName")) {
			$r="public/uploads/csv/$imageName";
			$file = fopen($r, "r",FILE_SKIP_EMPTY_LINES);
			$emapData = fgetcsv($file, 10000, ","); 
				$row=0;
				$size=sizeof($emapData);

				if($size=='4' && $emapData !=null) {
				$geographytitle=array();
				$no_geographytitle=array();
				while (($record = fgetcsv($file)) !== FALSE) {
					$row++;
					array_push($geographytitle,$record);
				}
        
    	$insert_count=0;
        $reject_count=0;
        $reject_value=0; 
        $insert_value=0; 
				
    
	 for($k=0; $k<count($geographytitle);$k++) {

        	if($geographytitle[$k][3]=='' || $geographytitle[$k][3]=="null"){
                $status=0;    
                $no_geographytitle[]=$status;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Status is empty'];    
        	}else if($geographytitle[$k][3]=="Active" || $geographytitle[$k][3]=="active"){

                $status=1;
                $no_geographytitle[]=$status;
        	}else if($geographytitle[$k][3]=="Inactive" || $geographytitle[$k][3]=="inactive"){

        		$status=2;
        		$no_geographytitle[]=$status;
        	}else{

        		$status=0; 
        		$no_geographytitle[]=$status;   
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status data'];  
        	}

        	if($geographytitle[$k][2]=='' || $geographytitle[$k][2]=="null"){
                $geography_value=0;    
                $no_geographytitle[]=$geography_value;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography value is empty'];    
        	}else {
                $geography_value=1;  
                 $no_geographytitle[]=$geography_value;   
                  
        	}

        	
        	if($geographytitle[$k][1]=='' || $geographytitle[$k][1]=="null"){
                $geography_code=0;    
                $no_geographytitle[]=$geography_code;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography code is empty'];    
        	}
           /* else if(!is_numeric($geographytitle[$k][1])){
                 $geography_code=0;  
                 $no_geographytitle[]=$geography_code;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography code numeric only'];  

        	}*/
            else {
                $geography_code=1;     
                $no_geographytitle[]=$geography_code;
              
        	}

        	if($geographytitle[$k][0]=='' || $geographytitle[$k][0]=="null"){
		    	$geography=0;   
		        $no_geographytitle[]=$geography; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography type is empty'];

		    }else{
                $geography=1;    
                $no_geographytitle[]=$geography; 

                $geographyname=$geographytitle[$k][0];
			 	$qry1="SELECT idGeographyTitle FROM geographytitle_master WHERE title='$geographyname'";
				$result1=$this->adapter->query($qry1,array());
			    $resultset1=$result1->toArray();

					if(!$resultset1){
			           $geography=0; 
			           $no_geographytitle[]=$geography;
			           $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography data mismatch'];

			       }else{

		            $geography=1; 
		            $no_geographytitle[]=$geography;
			    	 
			        }
        	}              
	    }


 if(count($no_geographytitle)!=0){
    for($j=0; $j<count($no_geographytitle);$j++){ 
            $zero=0;
        if(in_array($zero,$no_geographytitle)){

           $check=0;
        }else{
           $check=1;

        }      
    }
}else{
	  $check=0;
	  $ret_arr=['code'=>'3','status'=>false,'message'=>'Excel data is empty'];
}

    if($check!=0){

	for($i=0; $i<count($geographytitle);$i++) {

        $geographyname=$geographytitle[$i][0];
	 	$qry1="SELECT idGeographyTitle FROM geographytitle_master WHERE title='$geographyname'";
		$result1=$this->adapter->query($qry1,array());
	    $resultset1=$result1->toArray();

		if($geographytitle[$i][3]=="Active" || $geographytitle[$i][3]=="active"){
            $status=1;
    	}else if($geographytitle[$i][3]=="Inactive" || $geographytitle[$i][3]=="inactive"){
    		$status=2;
        }

	$qry="SELECT idGeographyTitle,geoCode,geoValue FROM geography where idGeographyTitle=? and geoCode=? and geoValue=?";
	$result=$this->adapter->query($qry,array($resultset1[0]['idGeographyTitle'],$geographytitle[$i][1],$geographytitle[$i][2]));
	$resultset=$result->toArray();

					if(!$resultset){
						$this->adapter->getDriver()->getConnection()->beginTransaction();
						try {	
								
							$data['idGeographyTitle']=$resultset1[0]['idGeographyTitle'];
							$data['geoCode']=$geographytitle[$i][1];
							$data['geoValue']=$geographytitle[$i][2];
							$data['status']=$status;
							$data['created_at']=date('Y-m-d H:i:s');
							$data['created_by']=1;
							$data['updated_at']=date('Y-m-d H:i:s');
							$data['updated_by']=1;
							$insert=new Insert('geography');
							$insert->values($data);
							$statement=$this->adapter->createStatement();
							$insert->prepareStatement($this->adapter, $statement);
							$insertresult=$statement->execute();
							$insert_value += $insert_count+1;
					      //  $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
							$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
							$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
							$this->adapter->getDriver()->getConnection()->rollBack();
						}
					} else {
						$reject_value += $reject_count+1;
						//$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
				
					}
 
                }

        if($insert_value!=0 && $reject_value==0){

              $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
        }else if($insert_value ==0 && $reject_value !=0){

        	 $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists data'];

        }else if($insert_value!=0 && $reject_value!=0){

        $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists  '.$reject_value.'Uploaded  '.$insert_value];
        }
           
		
	 }

			} else {
				   $ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please verify the csv file'];
			}

			
		}

		return $ret_arr;

	} // close func

	public function uploadgeographymapping($param){

        ini_set('display_errors',true);
		$Uploads_dir = 'public/uploads/csv';
		$tmp_name=$_FILES["myFile"]["tmp_name"]; 
		$name = basename($_FILES["myFile"]["name"]); 
		$imageName = rand(6,66666).'.'. pathinfo($_FILES["myFile"]['name'],PATHINFO_EXTENSION);
    	if(move_uploaded_file($tmp_name, "$Uploads_dir/$imageName")) {
			$r="public/uploads/csv/$imageName";
			$file = fopen($r, "r",FILE_SKIP_EMPTY_LINES);
			$emapData = fgetcsv($file, 10000, ","); 
				$row=0;
				$size=sizeof($emapData);

		if($size=='10' && $emapData !=null) {
				$geographymapping=array();
				$no_geographymapping=array();
				while (($record = fgetcsv($file)) !== FALSE) {
					$row++;
					array_push($geographymapping,$record);
				}

		$geography1=0;
	    $geography2=0;
	    $geography3=0;
	    $geography4=0;
	    $geography5=0;
	    $geography6=0;
	    $geography7=0;
	    $geography8=0;
        $geography9=0;
	    $geography10=0;

        $geo_map_value0=0;
	    $geo_map_value1=0;
	    $geo_map_value2=0;
	    $geo_map_value3=0;
	    $geo_map_value4=0;
	    $geo_map_value5=0;
	    $geo_map_value6=0;
	    $geo_map_value7=0;
	    $geo_map_value8=0;
	    $geo_map_value9=0;
	    $check_value=array();
	    $array_condition=array();

	    $insert_count=0;
        $reject_count=0;
        $reject_value=0; 
        $insert_value=0;  
	   
	 	$qry="SELECT idGeographyTitle,title FROM geographytitle_master WHERE title!='' AND idGeographyTitle!=''";
		$result=$this->adapter->query($qry,array());
	    $resultset=$result->toArray();	
 

	for($k=0; $k<count($geographymapping);$k++) {

	    if(count($resultset)==10){

	        if($geographymapping[$k][9]!=''){  

	            $geo_value10=$geographymapping[$k][9];
		        $qry10="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value10'
		        AND idGeographyTitle ='10'";
				$result10=$this->adapter->query($qry10,array());
			    $resultset10=$result10->toArray();	

			    if(!$resultset10){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;   
	                $geo_map_value10=0;
	                $array_condition[]=$geo_map_value10;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography10 value mismatch'];

	             
			    }else{  
			       $check_value[]=$resultset10[0]['idGeography'];
			       $geo_map_value10=1;
			       $array_condition[]=$geo_map_value10;
	               
			    }  
	              
	        }

	       if($geographymapping[$k][8]!=''){  

	            $geo_value9=$geographymapping[$k][8];
		        $qry9="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value9'
		        AND idGeographyTitle ='9'";
				$result9=$this->adapter->query($qry9,array());
			    $resultset9=$result9->toArray();	

			    if(!$resultset9){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value9=0;
	                $array_condition[]=$geo_map_value9;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography9 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset9[0]['idGeography'];
	               $geo_map_value9=1;
	               $array_condition[]=$geo_map_value9;
			    }  
	              
	        }

	        if($geographymapping[$k][7]!=''){  

	            $geo_value8=$geographymapping[$k][7];
		        $qry8="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value8'
		        AND idGeographyTitle ='8'";
				$result8=$this->adapter->query($qry8,array());
			    $resultset8=$result8->toArray();	

			    if(!$resultset8){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value8=0;
	                $array_condition[]=$geo_map_value8;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography8 value mismatch'];
	             
			    }else{
			       $check_value[]=$resultset8[0]['idGeography'];
	               $geo_map_value8=1;
	               $array_condition[]=$geo_map_value8;
			    }  
	              
	        }

	        if($geographymapping[$k][6]!=''){  

	            $geo_value7=$geographymapping[$k][6];	   
		        $qry7="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value7'
		        AND idGeographyTitle ='7'";
				$result7=$this->adapter->query($qry7,array());
			    $resultset7=$result7->toArray();	

			    if(!$resultset7){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;   
	                $geo_map_value7=0;
	                $array_condition[]=$geo_map_value7;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography7 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset7[0]['idGeography'];
	               $geo_map_value7=1;
	               $array_condition[]=$geo_map_value7;
			    }  
	              
	        }

	        if($geographymapping[$k][5]!=''){

	            $geo_value6=$geographymapping[$k][5];
		   
		        $qry6="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value6' AND idGeographyTitle ='6'";

				$result6=$this->adapter->query($qry6,array());
			    $resultset6=$result6->toArray();	

			    if(!$resultset6){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value6=0;
	                 $array_condition[]=$geo_map_value6; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography6 value mismatch'];
	             
			    }else{  
			       $check_value[]=$resultset6[0]['idGeography'];
	               $geo_map_value6=1;
	               $array_condition[]=$geo_map_value6; 
			    }  
	              
	        }

	       if($geographymapping[$k][4]!=''){
	            $geo_value5=$geographymapping[$k][4];
		        $qry5="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value5'
		        AND idGeographyTitle ='5'";
				$result5=$this->adapter->query($qry5,array());
			    $resultset5=$result5->toArray();	

			    if(!$resultset5){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value5=0;
	                $array_condition[]=$geo_map_value5; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography5 value mismatch'];
	             
			    }else{
			       $check_value[]=$resultset5[0]['idGeography'];
	               $geo_map_value5=1;
	               $array_condition[]=$geo_map_value5; 
			    }  
	              
	        }

	        if($geographymapping[$k][3]!=''){  

	            $geo_value4=$geographymapping[$k][3];	   
		        $qry4="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value4'
		        AND idGeographyTitle ='4'";
				$result4=$this->adapter->query($qry4,array());
			    $resultset4=$result4->toArray();	
			    if(!$resultset4){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value4=0;
	                $array_condition[]=$geo_map_value4; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography4 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset4[0]['idGeography'];
	               $geo_map_value4=1;
	               $array_condition[]=$geo_map_value4; 
			    }  
	              
	        }

	            if($geographymapping[$k][2]==''){ 
                    $check_value[]=0; 
                    $geo_value=$check_value;  
                    $geo_map_value3=0;
                    $array_condition[]=$geo_map_value3;   
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check geography3 is empty'];
                 }else  if($geographymapping[$k][2]!=''){  
	            $geo_value3=$geographymapping[$k][2];   
		        $qry3="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value3'
		        AND idGeographyTitle ='3'";
				$result3=$this->adapter->query($qry3,array());
			    $resultset3=$result3->toArray();	

			    if(!$resultset3){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value3=0;
	                $array_condition[]=$geo_map_value3; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography3 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset3[0]['idGeography'];
	               $geo_map_value3=1;
	               $array_condition[]=$geo_map_value3; 
			    }  
	              
	        }

	        if($geographymapping[$k][1]==''){ 
                    $check_value[]=0; 
                    $geo_value=$check_value;  
                    $geo_map_value2=0;
                    $array_condition[]=$geo_map_value2;  
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check geography2 is empty'];
                 }else if($geographymapping[$k][1]!=''){

	            $geo_value2=$geographymapping[$k][1];		   
		        $qry2="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value2'
		        AND idGeographyTitle ='2'";
				$result2=$this->adapter->query($qry2,array());
			    $resultset2=$result2->toArray();	

			    if(!$resultset2){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value2=0;
	                $array_condition[]=$geo_map_value2; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography2 value mismatch'];
	             
			    }else{
			       $check_value[]=$resultset2[0]['idGeography'];
	               $geo_map_value2=1;
	               $array_condition[]=$geo_map_value2; 
			    }  
	              
	        }

	         if($geographymapping[$k][0]==''){ 
                    $check_value[]=0; 
                    $geo_value=$check_value;  
                    $geo_map_value1=0;
                    $array_condition[]=$geo_map_value1; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check geography1 is empty'];
                 }else if($geographymapping[$k][0]!=''){ 

	            $geo_value1=$geographymapping[$k][0];	   
		        $qry1="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value1'
		        AND idGeographyTitle ='1'";
				$result1=$this->adapter->query($qry1,array());
			    $resultset1=$result1->toArray();	

			    if(!$resultset1){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value1=0;
	                $array_condition[]=$geo_map_value1; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography1 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset1[0]['idGeography'];
	               $geo_map_value1=1;
	               $array_condition[]=$geo_map_value1; 
			    }  
	              
	        }
           

	    }
	     if(count($resultset)==9){

    
	       if($geographymapping[$k][8]!=''){  

	            $geo_value9=$geographymapping[$k][8];
		        $qry9="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value9'
		        AND idGeographyTitle ='9'";
				$result9=$this->adapter->query($qry9,array());
			    $resultset9=$result9->toArray();	

			    if(!$resultset9){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value9=0;
	                $array_condition[]=$geo_map_value9;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography9 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset9[0]['idGeography'];
	               $geo_map_value9=1;
	               $array_condition[]=$geo_map_value9;
			    }  
	              
	        }

	        if($geographymapping[$k][7]!=''){  

	            $geo_value8=$geographymapping[$k][7];
		        $qry8="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value8'
		        AND idGeographyTitle ='8'";
				$result8=$this->adapter->query($qry8,array());
			    $resultset8=$result8->toArray();	

			    if(!$resultset8){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value8=0;
	                $array_condition[]=$geo_map_value8;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography8 value mismatch'];
	             
			    }else{
			       $check_value[]=$resultset8[0]['idGeography'];
	               $geo_map_value8=1;
	               $array_condition[]=$geo_map_value8;
			    }  
	              
	        }

	        if($geographymapping[$k][6]!=''){  

	            $geo_value7=$geographymapping[$k][6];	   
		        $qry7="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value7'
		        AND idGeographyTitle ='7'";
				$result7=$this->adapter->query($qry7,array());
			    $resultset7=$result7->toArray();	

			    if(!$resultset7){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;   
	                $geo_map_value7=0;
	                $array_condition[]=$geo_map_value7;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography7 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset7[0]['idGeography'];
	               $geo_map_value7=1;
	               $array_condition[]=$geo_map_value7;
			    }  
	              
	        }

	        if($geographymapping[$k][5]!=''){

	            $geo_value6=$geographymapping[$k][5];
		   
		        $qry6="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value6' AND idGeographyTitle ='6'";

				$result6=$this->adapter->query($qry6,array());
			    $resultset6=$result6->toArray();	

			    if(!$resultset6){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value6=0;
	                 $array_condition[]=$geo_map_value6; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography6 value mismatch'];
	             
			    }else{  
			       $check_value[]=$resultset6[0]['idGeography'];
	               $geo_map_value6=1;
	               $array_condition[]=$geo_map_value6; 
			    }  
	              
	        }

	       if($geographymapping[$k][4]!=''){
	            $geo_value5=$geographymapping[$k][4];
		        $qry5="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value5'
		        AND idGeographyTitle ='5'";
				$result5=$this->adapter->query($qry5,array());
			    $resultset5=$result5->toArray();	

			    if(!$resultset5){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value5=0;
	                $array_condition[]=$geo_map_value5; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography5 value mismatch'];
	             
			    }else{
			       $check_value[]=$resultset5[0]['idGeography'];
	               $geo_map_value5=1;
	               $array_condition[]=$geo_map_value5; 
			    }  
	              
	        }

	        if($geographymapping[$k][3]!=''){  

	            $geo_value4=$geographymapping[$k][3];	   
		        $qry4="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value4'
		        AND idGeographyTitle ='4'";
				$result4=$this->adapter->query($qry4,array());
			    $resultset4=$result4->toArray();	
			    if(!$resultset4){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value4=0;
	                $array_condition[]=$geo_map_value4; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography4 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset4[0]['idGeography'];
	               $geo_map_value4=1;
	               $array_condition[]=$geo_map_value4; 
			    }  
	              
	        }

	         if($geographymapping[$k][2]==''){ 
                    $check_value[]=0; 
                    $geo_value=$check_value;  
                    $geo_map_value3=0;
                    $array_condition[]=$geo_map_value3;   
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check geography3 is empty'];
                 }else if($geographymapping[$k][2]!=''){  
	            $geo_value3=$geographymapping[$k][2];   
		        $qry3="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value3'
		        AND idGeographyTitle ='3'";
				$result3=$this->adapter->query($qry3,array());
			    $resultset3=$result3->toArray();	

			    if(!$resultset3){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value3=0;
	                $array_condition[]=$geo_map_value3; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography3 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset3[0]['idGeography'];
	               $geo_map_value3=1;
	               $array_condition[]=$geo_map_value3; 
			    }  
	              
	        }

	        if($geographymapping[$k][1]==''){ 
                    $check_value[]=0; 
                    $geo_value=$check_value;  
                    $geo_map_value2=0;
                    $array_condition[]=$geo_map_value2;  
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check geography2 is empty'];
                 }else if($geographymapping[$k][1]!=''){

	            $geo_value2=$geographymapping[$k][1];		   
		        $qry2="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value2'
		        AND idGeographyTitle ='2'";
				$result2=$this->adapter->query($qry2,array());
			    $resultset2=$result2->toArray();	

			    if(!$resultset2){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value2=0;
	                $array_condition[]=$geo_map_value2; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography2 value mismatch'];
	             
			    }else{
			       $check_value[]=$resultset2[0]['idGeography'];
	               $geo_map_value2=1;
	               $array_condition[]=$geo_map_value2; 
			    }  
	              
	        }

	         if($geographymapping[$k][0]==''){ 
                    $check_value[]=0; 
                    $geo_value=$check_value;  
                    $geo_map_value1=0;
                    $array_condition[]=$geo_map_value1; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check geography1 is empty'];
                 }else if($geographymapping[$k][0]!=''){ 

	            $geo_value1=$geographymapping[$k][0];	   
		        $qry1="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value1'
		        AND idGeographyTitle ='1'";
				$result1=$this->adapter->query($qry1,array());
			    $resultset1=$result1->toArray();	

			    if(!$resultset1){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value1=0;
	                $array_condition[]=$geo_map_value1; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography1 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset1[0]['idGeography'];
	               $geo_map_value1=1;
	               $array_condition[]=$geo_map_value1; 
			    }  
	              
	        }

	    }
	     if(count($resultset)==8){

	        if($geographymapping[$k][7]!=''){  

	            $geo_value8=$geographymapping[$k][7];
		        $qry8="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value8'
		        AND idGeographyTitle ='8'";
				$result8=$this->adapter->query($qry8,array());
			    $resultset8=$result8->toArray();	

			    if(!$resultset8){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value8=0;
	                $array_condition[]=$geo_map_value8;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography8 value mismatch'];
	             
			    }else{
			       $check_value[]=$resultset8[0]['idGeography'];
	               $geo_map_value8=1;
	               $array_condition[]=$geo_map_value8;
			    }  
	              
	        }

	        if($geographymapping[$k][6]!=''){  

	            $geo_value7=$geographymapping[$k][6];	   
		        $qry7="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value7'
		        AND idGeographyTitle ='7'";
				$result7=$this->adapter->query($qry7,array());
			    $resultset7=$result7->toArray();	

			    if(!$resultset7){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;   
	                $geo_map_value7=0;
	                $array_condition[]=$geo_map_value7;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography7 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset7[0]['idGeography'];
	               $geo_map_value7=1;
	               $array_condition[]=$geo_map_value7;
			    }  
	              
	        }

	        if($geographymapping[$k][5]!=''){

	            $geo_value6=$geographymapping[$k][5];
		   
		        $qry6="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value6' AND idGeographyTitle ='6'";

				$result6=$this->adapter->query($qry6,array());
			    $resultset6=$result6->toArray();	

			    if(!$resultset6){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value6=0;
	                 $array_condition[]=$geo_map_value6; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography6 value mismatch'];
	             
			    }else{  
			       $check_value[]=$resultset6[0]['idGeography'];
	               $geo_map_value6=1;
	               $array_condition[]=$geo_map_value6; 
			    }  
	              
	        }

	       if($geographymapping[$k][4]!=''){
	            $geo_value5=$geographymapping[$k][4];
		        $qry5="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value5'
		        AND idGeographyTitle ='5'";
				$result5=$this->adapter->query($qry5,array());
			    $resultset5=$result5->toArray();	

			    if(!$resultset5){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value5=0;
	                $array_condition[]=$geo_map_value5; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography5 value mismatch'];
	             
			    }else{
			       $check_value[]=$resultset5[0]['idGeography'];
	               $geo_map_value5=1;
	               $array_condition[]=$geo_map_value5; 
			    }  
	              
	        }

	        if($geographymapping[$k][3]!=''){  

	            $geo_value4=$geographymapping[$k][3];	   
		        $qry4="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value4'
		        AND idGeographyTitle ='4'";
				$result4=$this->adapter->query($qry4,array());
			    $resultset4=$result4->toArray();	
			    if(!$resultset4){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value4=0;
	                $array_condition[]=$geo_map_value4; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography4 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset4[0]['idGeography'];
	               $geo_map_value4=1;
	               $array_condition[]=$geo_map_value4; 
			    }  
	              
	        }

	         if($geographymapping[$k][2]==''){ 
                    $check_value[]=0; 
                    $geo_value=$check_value;  
                    $geo_map_value3=0;
                    $array_condition[]=$geo_map_value3;   
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check geography3 is empty'];
                 }else if($geographymapping[$k][2]!=''){  
	            $geo_value3=$geographymapping[$k][2];   
		        $qry3="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value3'
		        AND idGeographyTitle ='3'";
				$result3=$this->adapter->query($qry3,array());
			    $resultset3=$result3->toArray();	

			    if(!$resultset3){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value3=0;
	                $array_condition[]=$geo_map_value3; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography3 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset3[0]['idGeography'];
	               $geo_map_value3=1;
	               $array_condition[]=$geo_map_value3; 
			    }  
	              
	        }

	        if($geographymapping[$k][1]==''){ 
                    $check_value[]=0; 
                    $geo_value=$check_value;  
                    $geo_map_value2=0;
                    $array_condition[]=$geo_map_value2;  
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check geography2 is empty'];
                 }else if($geographymapping[$k][1]!=''){

	            $geo_value2=$geographymapping[$k][1];		   
		        $qry2="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value2'
		        AND idGeographyTitle ='2'";
				$result2=$this->adapter->query($qry2,array());
			    $resultset2=$result2->toArray();	

			    if(!$resultset2){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value2=0;
	                $array_condition[]=$geo_map_value2; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography2 value mismatch'];
	             
			    }else{
			       $check_value[]=$resultset2[0]['idGeography'];
	               $geo_map_value2=1;
	               $array_condition[]=$geo_map_value2; 
			    }  
	              
	        }

	         if($geographymapping[$k][0]==''){ 
                    $check_value[]=0; 
                    $geo_value=$check_value;  
                    $geo_map_value1=0;
                    $array_condition[]=$geo_map_value1; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check geography1 is empty'];
                 }else if($geographymapping[$k][0]!=''){ 

	            $geo_value1=$geographymapping[$k][0];	   
		        $qry1="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value1'
		        AND idGeographyTitle ='1'";
				$result1=$this->adapter->query($qry1,array());
			    $resultset1=$result1->toArray();	

			    if(!$resultset1){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value1=0;
	                $array_condition[]=$geo_map_value1; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography1 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset1[0]['idGeography'];
	               $geo_map_value1=1;
	               $array_condition[]=$geo_map_value1; 
			    }  
	              
	        }

	    }
	     if(count($resultset)==7){

            if($geographymapping[$k][6]!=''){  

	            $geo_value7=$geographymapping[$k][6];	   
		        $qry7="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value7'
		        AND idGeographyTitle ='7'";
				$result7=$this->adapter->query($qry7,array());
			    $resultset7=$result7->toArray();	

			    if(!$resultset7){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;   
	                $geo_map_value7=0;
	                $array_condition[]=$geo_map_value7;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography7 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset7[0]['idGeography'];
	               $geo_map_value7=1;
	               $array_condition[]=$geo_map_value7;
			    }  
	              
	        }

	        if($geographymapping[$k][5]!=''){

	            $geo_value6=$geographymapping[$k][5];
		   
		        $qry6="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value6' AND idGeographyTitle ='6'";

				$result6=$this->adapter->query($qry6,array());
			    $resultset6=$result6->toArray();	

			    if(!$resultset6){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value6=0;
	                 $array_condition[]=$geo_map_value6; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography6 value mismatch'];
	             
			    }else{  
			       $check_value[]=$resultset6[0]['idGeography'];
	               $geo_map_value6=1;
	               $array_condition[]=$geo_map_value6; 
			    }  
	              
	        }

	       if($geographymapping[$k][4]!=''){
	            $geo_value5=$geographymapping[$k][4];
		        $qry5="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value5'
		        AND idGeographyTitle ='5'";
				$result5=$this->adapter->query($qry5,array());
			    $resultset5=$result5->toArray();	

			    if(!$resultset5){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value5=0;
	                $array_condition[]=$geo_map_value5; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography5 value mismatch'];
	             
			    }else{
			       $check_value[]=$resultset5[0]['idGeography'];
	               $geo_map_value5=1;
	               $array_condition[]=$geo_map_value5; 
			    }  
	              
	        }

	        if($geographymapping[$k][3]!=''){  

	            $geo_value4=$geographymapping[$k][3];	   
		        $qry4="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value4'
		        AND idGeographyTitle ='4'";
				$result4=$this->adapter->query($qry4,array());
			    $resultset4=$result4->toArray();	
			    if(!$resultset4){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value4=0;
	                $array_condition[]=$geo_map_value4; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography4 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset4[0]['idGeography'];
	               $geo_map_value4=1;
	               $array_condition[]=$geo_map_value4; 
			    }  
	              
	        }

	         if($geographymapping[$k][2]==''){ 
                    $check_value[]=0; 
                    $geo_value=$check_value;  
                    $geo_map_value3=0;
                    $array_condition[]=$geo_map_value3;   
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check geography3 is empty'];
                 }else if($geographymapping[$k][2]!=''){  
	            $geo_value3=$geographymapping[$k][2];   
		        $qry3="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value3'
		        AND idGeographyTitle ='3'";
				$result3=$this->adapter->query($qry3,array());
			    $resultset3=$result3->toArray();	

			    if(!$resultset3){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value3=0;
	                $array_condition[]=$geo_map_value3; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography3 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset3[0]['idGeography'];
	               $geo_map_value3=1;
	               $array_condition[]=$geo_map_value3; 
			    }  
	              
	        }

	        if($geographymapping[$k][1]==''){ 
                    $check_value[]=0; 
                    $geo_value=$check_value;  
                    $geo_map_value2=0;
                    $array_condition[]=$geo_map_value2;  
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check geography2 is empty'];
                 }else if($geographymapping[$k][1]!=''){

	            $geo_value2=$geographymapping[$k][1];		   
		        $qry2="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value2'
		        AND idGeographyTitle ='2'";
				$result2=$this->adapter->query($qry2,array());
			    $resultset2=$result2->toArray();	

			    if(!$resultset2){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value2=0;
	                $array_condition[]=$geo_map_value2; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography2 value mismatch'];
	             
			    }else{
			       $check_value[]=$resultset2[0]['idGeography'];
	               $geo_map_value2=1;
	               $array_condition[]=$geo_map_value2; 
			    }  
	              
	        }

	         if($geographymapping[$k][0]==''){ 
                    $check_value[]=0; 
                    $geo_value=$check_value;  
                    $geo_map_value1=0;
                    $array_condition[]=$geo_map_value1; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check geography1 is empty'];
                 }else if($geographymapping[$k][0]!=''){ 

	            $geo_value1=$geographymapping[$k][0];	   
		        $qry1="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value1'
		        AND idGeographyTitle ='1'";
				$result1=$this->adapter->query($qry1,array());
			    $resultset1=$result1->toArray();	

			    if(!$resultset1){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value1=0;
	                $array_condition[]=$geo_map_value1; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography1 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset1[0]['idGeography'];
	               $geo_map_value1=1;
	               $array_condition[]=$geo_map_value1; 
			    }  
	              
	        }

	    }
	     if(count($resultset)==6){

            if($geographymapping[$k][5]!=''){

	            $geo_value6=$geographymapping[$k][5];
		   
		        $qry6="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value6' AND idGeographyTitle ='6'";

				$result6=$this->adapter->query($qry6,array());
			    $resultset6=$result6->toArray();	

			    if(!$resultset6){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value6=0;
	                 $array_condition[]=$geo_map_value6; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography6 value mismatch'];
	             
			    }else{  
			       $check_value[]=$resultset6[0]['idGeography'];
	               $geo_map_value6=1;
	               $array_condition[]=$geo_map_value6; 
			    }  
	              
	        }

	       if($geographymapping[$k][4]!=''){
	            $geo_value5=$geographymapping[$k][4];
		        $qry5="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value5'
		        AND idGeographyTitle ='5'";
				$result5=$this->adapter->query($qry5,array());
			    $resultset5=$result5->toArray();	

			    if(!$resultset5){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value5=0;
	                $array_condition[]=$geo_map_value5; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography5 value mismatch'];
	             
			    }else{
			       $check_value[]=$resultset5[0]['idGeography'];
	               $geo_map_value5=1;
	               $array_condition[]=$geo_map_value5; 
			    }  
	              
	        }

	        if($geographymapping[$k][3]!=''){  

	            $geo_value4=$geographymapping[$k][3];	   
		        $qry4="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value4'
		        AND idGeographyTitle ='4'";
				$result4=$this->adapter->query($qry4,array());
			    $resultset4=$result4->toArray();	
			    if(!$resultset4){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value4=0;
	                $array_condition[]=$geo_map_value4; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography4 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset4[0]['idGeography'];
	               $geo_map_value4=1;
	               $array_condition[]=$geo_map_value4; 
			    }  
	              
	        }

	         if($geographymapping[$k][2]==''){ 
                    $check_value[]=0; 
                    $geo_value=$check_value;  
                    $geo_map_value3=0;
                    $array_condition[]=$geo_map_value3;   
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check geography3 is empty'];
                 }else if($geographymapping[$k][2]!=''){  
	            $geo_value3=$geographymapping[$k][2];   
		        $qry3="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value3'
		        AND idGeographyTitle ='3'";
				$result3=$this->adapter->query($qry3,array());
			    $resultset3=$result3->toArray();	

			    if(!$resultset3){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value3=0;
	                $array_condition[]=$geo_map_value3; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography3 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset3[0]['idGeography'];
	               $geo_map_value3=1;
	               $array_condition[]=$geo_map_value3; 
			    }  
	              
	        }

	        if($geographymapping[$k][1]==''){ 
                    $check_value[]=0; 
                    $geo_value=$check_value;  
                    $geo_map_value2=0;
                    $array_condition[]=$geo_map_value2;  
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check geography2 is empty'];
                 }else if($geographymapping[$k][1]!=''){

	            $geo_value2=$geographymapping[$k][1];		   
		        $qry2="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value2'
		        AND idGeographyTitle ='2'";
				$result2=$this->adapter->query($qry2,array());
			    $resultset2=$result2->toArray();	

			    if(!$resultset2){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value2=0;
	                $array_condition[]=$geo_map_value2; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography2 value mismatch'];
	             
			    }else{
			       $check_value[]=$resultset2[0]['idGeography'];
	               $geo_map_value2=1;
	               $array_condition[]=$geo_map_value2; 
			    }  
	              
	        }

	         if($geographymapping[$k][0]==''){ 
                    $check_value[]=0; 
                    $geo_value=$check_value;  
                    $geo_map_value1=0;
                    $array_condition[]=$geo_map_value1; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check geography1 is empty'];
                 }else if($geographymapping[$k][0]!=''){ 

	            $geo_value1=$geographymapping[$k][0];	   
		        $qry1="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value1'
		        AND idGeographyTitle ='1'";
				$result1=$this->adapter->query($qry1,array());
			    $resultset1=$result1->toArray();	

			    if(!$resultset1){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value1=0;
	                $array_condition[]=$geo_map_value1; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography1 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset1[0]['idGeography'];
	               $geo_map_value1=1;
	               $array_condition[]=$geo_map_value1; 
			    }  
	              
	        }
          
	    }
	     if(count($resultset)==5){
            if($geographymapping[$k][4]!=''){
	            $geo_value5=$geographymapping[$k][4];
		        $qry5="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value5'
		        AND idGeographyTitle ='5'";
				$result5=$this->adapter->query($qry5,array());
			    $resultset5=$result5->toArray();	

			    if(!$resultset5){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value5=0;
	                $array_condition[]=$geo_map_value5; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography5 value mismatch'];
	             
			    }else{
			       $check_value[]=$resultset5[0]['idGeography'];
	               $geo_map_value5=1;
	               $array_condition[]=$geo_map_value5; 
			    }  
	              
	        }

	        if($geographymapping[$k][3]!=''){  

	            $geo_value4=$geographymapping[$k][3];	   
		        $qry4="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value4'
		        AND idGeographyTitle ='4'";
				$result4=$this->adapter->query($qry4,array());
			    $resultset4=$result4->toArray();	
			    if(!$resultset4){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value4=0;
	                $array_condition[]=$geo_map_value4; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography4 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset4[0]['idGeography'];
	               $geo_map_value4=1;
	               $array_condition[]=$geo_map_value4; 
			    }  
	              
	        }

	         if($geographymapping[$k][2]==''){ 
                    $check_value[]=0; 
                    $geo_value=$check_value;  
                    $geo_map_value3=0;
                    $array_condition[]=$geo_map_value3;   
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check geography3 is empty'];
                 }else if($geographymapping[$k][2]!=''){  
	            $geo_value3=$geographymapping[$k][2];   
		        $qry3="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value3'
		        AND idGeographyTitle ='3'";
				$result3=$this->adapter->query($qry3,array());
			    $resultset3=$result3->toArray();	

			    if(!$resultset3){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value3=0;
	                $array_condition[]=$geo_map_value3; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography3 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset3[0]['idGeography'];
	               $geo_map_value3=1;
	               $array_condition[]=$geo_map_value3; 
			    }  
	              
	        }

	        if($geographymapping[$k][1]==''){ 
                    $check_value[]=0; 
                    $geo_value=$check_value;  
                    $geo_map_value2=0;
                    $array_condition[]=$geo_map_value2;  
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check geography2 is empty'];
                 }else if($geographymapping[$k][1]!=''){

	            $geo_value2=$geographymapping[$k][1];		   
		        $qry2="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value2'
		        AND idGeographyTitle ='2'";
				$result2=$this->adapter->query($qry2,array());
			    $resultset2=$result2->toArray();	

			    if(!$resultset2){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value2=0;
	                $array_condition[]=$geo_map_value2; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography2 value mismatch'];
	             
			    }else{
			       $check_value[]=$resultset2[0]['idGeography'];
	               $geo_map_value2=1;
	               $array_condition[]=$geo_map_value2; 
			    }  
	              
	        }

	         if($geographymapping[$k][0]==''){ 
                    $check_value[]=0; 
                    $geo_value=$check_value;  
                    $geo_map_value1=0;
                    $array_condition[]=$geo_map_value1; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check geography1 is empty'];
                 }else if($geographymapping[$k][0]!=''){ 

	            $geo_value1=$geographymapping[$k][0];	   
		        $qry1="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value1'
		        AND idGeographyTitle ='1'";
				$result1=$this->adapter->query($qry1,array());
			    $resultset1=$result1->toArray();	

			    if(!$resultset1){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value1=0;
	                $array_condition[]=$geo_map_value1; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography1 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset1[0]['idGeography'];
	               $geo_map_value1=1;
	               $array_condition[]=$geo_map_value1; 
			    }  
	              
	        }
         
	    }

	    if(count($resultset)==4){
            if($geographymapping[$k][3]!=''){  

	            $geo_value4=$geographymapping[$k][3];	   
		        $qry4="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value4'
		        AND idGeographyTitle ='4'";
				$result4=$this->adapter->query($qry4,array());
			    $resultset4=$result4->toArray();	
			    if(!$resultset4){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value4=0;
	                $array_condition[]=$geo_map_value4; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography4 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset4[0]['idGeography'];
	               $geo_map_value4=1;
	               $array_condition[]=$geo_map_value4; 
			    }  
	              
	        }

	         if($geographymapping[$k][2]==''){ 
                    $check_value[]=0; 
                    $geo_value=$check_value;  
                    $geo_map_value3=0;
                    $array_condition[]=$geo_map_value3;   
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check geography3 is empty'];
                 }else if($geographymapping[$k][2]!=''){  
	            $geo_value3=$geographymapping[$k][2];   
		        $qry3="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value3'
		        AND idGeographyTitle ='3'";
				$result3=$this->adapter->query($qry3,array());
			    $resultset3=$result3->toArray();	

			    if(!$resultset3){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value3=0;
	                $array_condition[]=$geo_map_value3; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography3 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset3[0]['idGeography'];
	               $geo_map_value3=1;
	               $array_condition[]=$geo_map_value3; 
			    }  
	              
	        }

	        if($geographymapping[$k][1]==''){ 
                    $check_value[]=0; 
                    $geo_value=$check_value;  
                    $geo_map_value2=0;
                    $array_condition[]=$geo_map_value2;  
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check geography2 is empty'];
                 }else if($geographymapping[$k][1]!=''){

	            $geo_value2=$geographymapping[$k][1];		   
		        $qry2="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value2'
		        AND idGeographyTitle ='2'";
				$result2=$this->adapter->query($qry2,array());
			    $resultset2=$result2->toArray();	

			    if(!$resultset2){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value2=0;
	                $array_condition[]=$geo_map_value2; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography2 value mismatch'];
	             
			    }else{
			       $check_value[]=$resultset2[0]['idGeography'];
	               $geo_map_value2=1;
	               $array_condition[]=$geo_map_value2; 
			    }  
	              
	        }

	         if($geographymapping[$k][0]==''){ 
                    $check_value[]=0; 
                    $geo_value=$check_value;  
                    $geo_map_value1=0;
                    $array_condition[]=$geo_map_value1; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check geography1 is empty'];
                 }else if($geographymapping[$k][0]!=''){ 

	            $geo_value1=$geographymapping[$k][0];	   
		        $qry1="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value1'
		        AND idGeographyTitle ='1'";
				$result1=$this->adapter->query($qry1,array());
			    $resultset1=$result1->toArray();	

			    if(!$resultset1){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value1=0;
	                $array_condition[]=$geo_map_value1; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography1 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset1[0]['idGeography'];
	               $geo_map_value1=1;
	               $array_condition[]=$geo_map_value1; 
			    }  
	              
	        }
   

	    }
	     if(count($resultset)==3){

                if($geographymapping[$k][2]==''){ 
                    $check_value[]=0; 
                    $geo_value=$check_value;  
                    $geo_map_value3=0;
                    $array_condition[]=$geo_map_value3;   
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check geography3 is empty'];
                 }else if($geographymapping[$k][2]!=''){  
	            $geo_value3=$geographymapping[$k][2];   
		        $qry3="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value3'
		        AND idGeographyTitle ='3'";
				$result3=$this->adapter->query($qry3,array());
			    $resultset3=$result3->toArray();	

			    if(!$resultset3){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value3=0;
	                $array_condition[]=$geo_map_value3; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography3 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset3[0]['idGeography'];
	               $geo_map_value3=1;
	               $array_condition[]=$geo_map_value3; 
			    }  
	              
	        }

	        if($geographymapping[$k][1]==''){ 
                    $check_value[]=0; 
                    $geo_value=$check_value;  
                    $geo_map_value2=0;
                    $array_condition[]=$geo_map_value2;  
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check geography2 is empty'];
                 }else if($geographymapping[$k][1]!=''){

	            $geo_value2=$geographymapping[$k][1];		   
		        $qry2="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value2'
		        AND idGeographyTitle ='2'";
				$result2=$this->adapter->query($qry2,array());
			    $resultset2=$result2->toArray();	

			    if(!$resultset2){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value2=0;
	                $array_condition[]=$geo_map_value2; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography2 value mismatch'];
	             
			    }else{
			       $check_value[]=$resultset2[0]['idGeography'];
	               $geo_map_value2=1;
	               $array_condition[]=$geo_map_value2; 
			    }  
	              
	        }

	         if($geographymapping[$k][0]==''){ 
                    $check_value[]=0; 
                    $geo_value=$check_value;  
                    $geo_map_value1=0;
                    $array_condition[]=$geo_map_value1; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check geography1 is empty'];
                 }else if($geographymapping[$k][0]!=''){ 

	            $geo_value1=$geographymapping[$k][0];	   
		        $qry1="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value1'
		        AND idGeographyTitle ='1'";
				$result1=$this->adapter->query($qry1,array());
			    $resultset1=$result1->toArray();	

			    if(!$resultset1){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value1=0;
	                $array_condition[]=$geo_map_value1; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography1 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset1[0]['idGeography'];
	               $geo_map_value1=1;
	               $array_condition[]=$geo_map_value1; 
			    }  
	              
	        }

	    }
	     if(count($resultset)==2){

            if($geographymapping[$k][1]==''){ 
                    $check_value[]=0; 
                    $geo_value=$check_value;  
                    $geo_map_value2=0;
                    $array_condition[]=$geo_map_value2;  
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check geography2 is empty'];
                 }else if($geographymapping[$k][1]!=''){

	            $geo_value2=$geographymapping[$k][1];		   
		        $qry2="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value2'
		        AND idGeographyTitle ='2'";
				$result2=$this->adapter->query($qry2,array());
			    $resultset2=$result2->toArray();	

			    if(!$resultset2){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value2=0;
	                $array_condition[]=$geo_map_value2; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography2 value mismatch'];
	             
			    }else{
			       $check_value[]=$resultset2[0]['idGeography'];
	               $geo_map_value2=1;
	               $array_condition[]=$geo_map_value2; 
			    }  
	              
	        }

	         if($geographymapping[$k][0]==''){ 
                    $check_value[]=0; 
                    $geo_value=$check_value;  
                    $geo_map_value1=0;
                    $array_condition[]=$geo_map_value1; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check geography1 is empty'];
                 }else if($geographymapping[$k][0]!=''){ 

	            $geo_value1=$geographymapping[$k][0];	   
		        $qry1="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value1'
		        AND idGeographyTitle ='1'";
				$result1=$this->adapter->query($qry1,array());
			    $resultset1=$result1->toArray();	

			    if(!$resultset1){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value1=0;
	                $array_condition[]=$geo_map_value1; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography1 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset1[0]['idGeography'];
	               $geo_map_value1=1;
	               $array_condition[]=$geo_map_value1; 
			    }  
	              
	        }

	    }
	     if(count($resultset)==1){
                if($geographymapping[$k][0]==''){ 
                    $check_value[]=0; 
                    $geo_value=$check_value;  
                    $geo_map_value1=0;
                    $array_condition[]=$geo_map_value1; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check geography1 is empty'];
		         }else if($geographymapping[$k][0]!=''){ 
	            $geo_value1=$geographymapping[$k][0];	   
		        $qry1="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value1'
		        AND idGeographyTitle ='1'";
				$result1=$this->adapter->query($qry1,array());
			    $resultset1=$result1->toArray();	

			    if(!$resultset1){
			    	$check_value[]=0; 
			    	$geo_value=$check_value;  
	                $geo_map_value1=0;
	                $array_condition[]=$geo_map_value1; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography1 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset1[0]['idGeography'];
	               $geo_map_value1=1;
	               $array_condition[]=$geo_map_value1; 
			    }  
	              
	        }


	    }

    }  // close the loop 

 if(count($array_condition)!=0){
 	
    for($j=0; $j<count($array_condition);$j++){ 
            $zero=0;
        if(in_array($zero,$array_condition)){

            $check=0;
        }else{
            $check=1;

        }
                   
    }
}else{

	 $check=0;
	 $ret_arr=['code'=>'3','status'=>false,'message'=>'Excel data is empty'];
}

  
if($check!=0){ 

    for($m=0; $m<count($geographymapping);$m++){

                 if($geographymapping[$m][0]!=''){
			    
			    	$geo_value1=$geographymapping[$m][0];	   
			        $qry1="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value1'
			        AND idGeographyTitle ='1'";
					$result1=$this->adapter->query($qry1,array());
				    $resultset1=$result1->toArray();
				    $geography1=$resultset1[0]['idGeography'];

			    }else{
			    	$geography1=0;
			    }
			    if($geographymapping[$m][1]!=''){
			    	$geo_value2=$geographymapping[$m][1];		   
			        $qry2="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value2'
			        AND idGeographyTitle ='2'";
					$result2=$this->adapter->query($qry2,array());
				    $resultset2=$result2->toArray();
			    	$geography2=$resultset2[0]['idGeography'];
			    }else{
			    	$geography2=0;
			    }
			    if($geographymapping[$m][2]!=''){
			    	$geo_value3=$geographymapping[$m][2];   
			        $qry3="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value3'
			        AND idGeographyTitle ='3'";
					$result3=$this->adapter->query($qry3,array());
				    $resultset3=$result3->toArray();
			    	$geography3=$resultset3[0]['idGeography'];
			    }else{
			    	$geography3=0;
			    }
			    if($geographymapping[$m][3]!=''){
			    	$geo_value4=$geographymapping[$m][3];	   
			        $qry4="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value4'
			        AND idGeographyTitle ='4'";
					$result4=$this->adapter->query($qry4,array());
				    $resultset4=$result4->toArray();	
			    	$geography4=$resultset4[0]['idGeography'];
			    }else{
			    	$geography4=0;
			    }
			    if($geographymapping[$m][4]!=''){
			    	$geo_value5=$geographymapping[$m][4];
			        $qry5="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value5'
			        AND idGeographyTitle ='5'";
					$result5=$this->adapter->query($qry5,array());
				    $resultset5=$result5->toArray();	
			    	$geography5=$resultset5[0]['idGeography'];
			    }else{
			    	$geography5=0;
			    }
			    if($geographymapping[$m][5]!=''){
			    	$geo_value6=$geographymapping[$m][5];
			        $qry6="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value6'
			        AND idGeographyTitle ='6'";
					$result6=$this->adapter->query($qry6,array());
				    $resultset6=$result6->toArray();	
			    	$geography6=$resultset6[0]['idGeography'];
			    }else{
			    	$geography6=0;
			    }
			    if($geographymapping[$m][6]!=''){
			    	$geo_value7=$geographymapping[$m][6];
			        $qry7="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value7'
			        AND idGeographyTitle ='7'";
					$result7=$this->adapter->query($qry7,array());
				    $resultset7=$result7->toArray();	
			    	$geography7=$resultset7[0]['idGeography'];
			    }else{
			    	$geography7=0;
			    }
			    if($geographymapping[$m][7]!=''){
			    	$geo_value8=$geographymapping[$m][7];
			        $qry8="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value8'
			        AND idGeographyTitle ='8'";
					$result8=$this->adapter->query($qry8,array());
				    $resultset8=$result8->toArray();	
			    	$geography8=$resultset8[0]['idGeography'];
			    }else{
			    	$geography8=0;
			    }
			    if($geographymapping[$m][8]!=''){
			    	$geo_value9=$geographymapping[$m][8];
			        $qry9="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_valu9'
			        AND idGeographyTitle ='9'";
					$result9=$this->adapter->query($qry9,array());
				    $resultset9=$result9->toArray();	
			    	$geography9=$resultset9[0]['idGeography'];
			    }else{
			    	$geography9=0;
			    }
			    if($geographymapping[$m][9]!=''){
			    	$geo_value10=$geographymapping[$m][9];
			        $qry10="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value10'
			        AND idGeographyTitle ='10'";
					$result10=$this->adapter->query($qry10,array());
				    $resultset10=$result10->toArray();	
			    	$geography10=$territory10[0]['idGeography'];
			    }else{
			    	$geography10=0;
			    }


        $qry_list="SELECT idGeographyMapping FROM geographymapping_master where g1=? and g2=? and g3=? and g4=? and g5=? and g6=? and g7=? and g8=? and g9=? and g10=?";
	    $result_list=$this->adapter->query($qry_list,array($geography1,$geography2,$geography3,$geography4,$geography5,$geography6,$geography7,$geography8,$geography9,$geography10));
		$resultset_list=$result_list->toArray();

			if(!$resultset_list){
						$this->adapter->getDriver()->getConnection()->beginTransaction();
						try {
					    	$data['g1']=(($geographymapping[$m][0]!='')? $resultset1[0]['idGeography']:0);
							$data['g2']=(($geographymapping[$m][1]!='')? $resultset2[0]['idGeography']:0);
							$data['g3']=(($geographymapping[$m][2]!='')? $resultset3[0]['idGeography']:0);
							$data['g4']=(($geographymapping[$m][3]!='')? $resultset4[0]['idGeography']:0);
							$data['g5']=(($geographymapping[$m][4]!='')? $resultset5[0]['idGeography']:0);
							$data['g6']=(($geographymapping[$m][5]!='')? $resultset6[0]['idGeography']:0);
							$data['g7']=(($geographymapping[$m][6]!='')? $resultset7[0]['idGeography']:0);
							$data['g8']=(($geographymapping[$m][7]!='')? $resultset8[0]['idGeography']:0);
							$data['g9']=(($geographymapping[$m][8]!='')? $resultset9[0]['idGeography']:0);
							$data['g10']=(($geographymapping[$m][9]!='')? $resultset10[0]['idGeography']:0);
							$data['created_at']=date('Y-m-d H:i:s');
							$data['created_by']=1;
							$data['updated_at']=date('Y-m-d H:i:s');
							$data['updated_by']=1;
							$insert=new Insert('geographymapping_master');
							$insert->values($data);
							$statement=$this->adapter->createStatement();
							$insert->prepareStatement($this->adapter, $statement);
							$insertresult=$statement->execute();
                            $insert_value += $insert_count+1;	
							$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
							$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
							$this->adapter->getDriver()->getConnection()->rollBack();
						}
			}else{
					$reject_value += $reject_count+1;
			
				
			     }          

    }

    if($insert_value!=0 && $reject_value==0){

        $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];

    }else if($insert_value ==0 && $reject_value !=0){

    	$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists data'];

    }else if($insert_value!=0 && $reject_value!=0){

        $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists  '.$reject_value.'Uploaded '.$insert_value];

    }
   
}
	}else{

			$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please verify the csv file'];

	    }

    }       

    return  $ret_arr;


    } // close func 

public function uploadterritorytitle($param) {

		ini_set('display_errors',true);
		$Uploads_dir = 'public/uploads/csv';
		$tmp_name=$_FILES["myFile"]["tmp_name"]; 
		$name = basename($_FILES["myFile"]["name"]); 
		$imageName = rand(6,66666).'.'. pathinfo($_FILES["myFile"]['name'],PATHINFO_EXTENSION);
    	if(move_uploaded_file($tmp_name, "$Uploads_dir/$imageName")) {
			$r="public/uploads/csv/$imageName";
			$file = fopen($r, "r",FILE_SKIP_EMPTY_LINES);
			$emapData = fgetcsv($file, 10000, ","); 
				$row=0;
				$size=sizeof($emapData);

				if($size=='5' && $emapData !=null) {
				$territorytitle=array();
				$no_territorytitle=array();
				while (($record = fgetcsv($file)) !== FALSE) {
					$row++;
					array_push($territorytitle,$record);
				}

        $insert_count=0;
        $reject_count=0;
        $reject_value=0; 
        $insert_value=0;  
				
    
	 for($k=0; $k<count($territorytitle);$k++) {

        	if($territorytitle[$k][3]=='' || $territorytitle[$k][3]=="null"){
                $status=0;   
                $no_territorytitle[]= $status;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Status is empty'];    
        	}else if($territorytitle[$k][3]=="Active" || $territorytitle[$k][3]=="active"){

                $status=1;
                $no_territorytitle[]= $status;
        	}else if($territorytitle[$k][3]=="Inactive" || $territorytitle[$k][3]=="inactive"){

        		$status=2;
        		$no_territorytitle[]= $status;
        	}else{

        		$status=0;   
        		$no_territorytitle[]= $status; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status data'];  

        	}

        	if($territorytitle[$k][2]=='' || $territorytitle[$k][2]=="null"){
                $territory_value=0;  
                $no_territorytitle[]= $territory_value;  
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory value is empty'];    
        	}else {
                $territory_value=1;     
                $no_territorytitle[]= $territory_value;  
                  
        	}

        	
        	if($territorytitle[$k][1]=='' || $territorytitle[$k][1]=="null"){
                $territory_code=0; 
                 $no_territorytitle[]= $territory_code;     
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory code is empty'];    
        	}
            /*else if(!is_numeric($territorytitle[$k][1])){
                 $territory_code=0; 
                   $no_territorytitle[]= $territory_code;      
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory code numeric only'];  

        	}*/
            else {
                $territory_code=1; 
                  $no_territorytitle[]= $territory_code;         
              
        	}

        	if($territorytitle[$k][0]=='' || $territorytitle[$k][0]=="null"){
		    	$territory=0;  
		    	 $no_territorytitle[]= $territory;       
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory type is empty'];

		    }else if($territorytitle[$k][0]!='' || $territorytitle[$k][0]!="null"){

		    	$territoryname=$territorytitle[$k][0];
			 	$qry1="SELECT idTerritoryTitle FROM territorytitle_master WHERE title='$territoryname'";
				$result1=$this->adapter->query($qry1,array());
			    $resultset1=$result1->toArray();

			    if(!$resultset1){
                  $territory=0; 
                   $no_territorytitle[]= $territory;   
                 $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory data mismatch'];

			    }else if($resultset1){
		            $territory=1; 
		            $no_territorytitle[]= $territory;  

		            if($resultset1[0]['idTerritoryTitle']==2){

				        if($territorytitle[$k][4]=='' || $territorytitle[$k][4]=="null"){
				           	$union=0; 
				            $no_territorytitle[]= $union;   
		                    $ret_arr=['code'=>'3','status'=>false,'message'=>'State column enter the union territory'];

				        }else{
				           		$union=1; 
				                $no_territorytitle[]= $union; 

				        }
		                        

				    } 
			    	 
			    }
            }           
	    }



if(count($no_territorytitle)!=0){
 	
    for($j=0; $j<count($no_territorytitle);$j++){ 
            $zero=0;
        if(in_array($zero,$no_territorytitle)){

            $check=0;
        }else{
            $check=1;

        }
                   
    }
}else{
	 $check=0;
	 $ret_arr=['code'=>'3','status'=>false,'message'=>'Excel data is empty'];
}

	  
    if($check!=0){

	for($i=0; $i<count($territorytitle);$i++) {

		$territorytitle1=$territorytitle[$i][0];
       // print_r($territorytitle);
		$qry1="SELECT idTerritoryTitle FROM territorytitle_master WHERE title='$territorytitle1'";
		$result1=$this->adapter->query($qry1,array());
		$resultset1=$result1->toArray();
 //print_r($resultset1);
		if($territorytitle[$i][3]=="Active" || $territorytitle[$i][3]=="active"){
                $status=1;
        }else if($territorytitle[$i][3]=="Inactive" || $territorytitle[$i][3]=="inactive"){

        		$status=2;
        }	


        if($territorytitle[$i][4]=="Yes" || $territorytitle[$i][4]=="yes"){
                $union=1;
        }else if($territorytitle[$i][4]=="No" || $territorytitle[$i][4]=="no"){

        		$union=2;
        }else{
        	    $union=2;
        }	

	$qry="SELECT idTerritory,territoryCode,territoryValue FROM territory_master where idTerritoryTitle=? and territoryCode=? and territoryValue=?";
	$result=$this->adapter->query($qry,array($resultset1[0]['idTerritoryTitle'],$territorytitle[$i][1],$territorytitle[$i][2]));
	$resultset=$result->toArray();

			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {							
							$data['idTerritoryTitle']=$resultset1[0]['idTerritoryTitle'];
							$data['territoryCode']=$territorytitle[$i][1];
							$data['territoryValue']=$territorytitle[$i][2];
							$data['territoryUnion']=$union;
							$data['status']=$status;
							$data['created_at']=date('Y-m-d H:i:s');
							$data['created_by']=1;
							$data['updated_at']=date('Y-m-d H:i:s');
							$data['updated_by']=1;
                           // print_r($data);
							$insert=new Insert('territory_master');
							$insert->values($data);
							$statement=$this->adapter->createStatement();
							$insert->prepareStatement($this->adapter, $statement);
							$insertresult=$statement->execute();
							$insert_value += $insert_count+1;
					        $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
							$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
							$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
							$this->adapter->getDriver()->getConnection()->rollBack();
						}
					} else {
						$reject_value += $reject_count+1;
						
					}
 
                }

        if($insert_value!=0 && $reject_value==0){

              $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
        }else if($insert_value ==0 && $reject_value !=0){

        	 $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists data'];

        }else if($insert_value!=0 && $reject_value!=0){

       $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists  '.$reject_value.'Uploaded  '.$insert_value];
        }
           
		
	}

			} else {
				   $ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please verify the csv file'];
			}

			
		}

		return $ret_arr;
	} // close loop

	public function uploadterritorymapping($param){

        ini_set('display_errors',true);
		$Uploads_dir = 'public/uploads/csv';
		$tmp_name=$_FILES["myFile"]["tmp_name"]; 
		$name = basename($_FILES["myFile"]["name"]); 
		$imageName = rand(6,66666).'.'. pathinfo($_FILES["myFile"]['name'],PATHINFO_EXTENSION);
    	if(move_uploaded_file($tmp_name, "$Uploads_dir/$imageName")) {
			$r="public/uploads/csv/$imageName";
			$file = fopen($r, "r",FILE_SKIP_EMPTY_LINES);
			$emapData = fgetcsv($file, 10000, ","); 
				$row=0;
				$size=sizeof($emapData);

		if($size=='10' && $emapData !=null) {
				$territorymapping=array();
				$no_territorymapping=array();
				while (($record = fgetcsv($file)) !== FALSE) {
					$row++;
					array_push($territorymapping,$record);
				}

		$territory1=0;
	    $territory2=0;
	    $territory3=0;
	    $territory4=0;
	    $territory5=0;
	    $territory6=0;
	    $territory7=0;
	    $territory8=0;
        $territory9=0;
	    $territory10=0;

	    $ter_map_value1=0;
	    $ter_map_value2=0;
	    $ter_map_value3=0;
	    $ter_map_value4=0;
	    $ter_map_value5=0;
	    $ter_map_value6=0;
	    $ter_map_value7=0;
	    $ter_map_value8=0;
	    $ter_map_value9=0;
	    $ter_map_value10=0;
	    $check_value=array();
	    $array_condition=array();

	    $insert_count=0;
        $reject_count=0;
        $reject_value=0; 
        $insert_value=0;  
	   
	 	$qry="SELECT idTerritoryTitle,title FROM territorytitle_master WHERE title!='' AND idTerritoryTitle!=''";
		$result=$this->adapter->query($qry,array());
	    $resultset=$result->toArray();	
 

	for($k=0; $k<count($territorymapping);$k++) {

	    if(count($resultset)==10){

	    if($territorymapping[$k][9]!=''){  

	            $ter_value10=$territorymapping[$k][9];
		   
		        $qry10="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value10' AND idTerritoryTitle ='10'";

				$result10=$this->adapter->query($qry10,array());
			    $resultset10=$result10->toArray();	

			    if(!$resultset10){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;   
	                $ter_map_value10=0;
	                $array_condition[]=$ter_map_value10;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory10 value mismatch'];
	             
			    }else{  
			       $check_value[]=$resultset10[0]['idTerritory'];
			       $ter_map_value10=1;
			       $array_condition[]=$ter_map_value10;
	               
                
			    }  
	              
	        }

	        if($territorymapping[$k][8]!='' ){  

	         $ter_value9=$territorymapping[$k][8];
		     $qry9="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value9' AND idTerritoryTitle ='9'";
				$result9=$this->adapter->query($qry9,array());
			    $resultset9=$result9->toArray();	

			    if(!$resultset9){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value9=0;
	                $array_condition[]=$ter_map_value9;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory9 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset9[0]['idTerritory'];
	               $ter_map_value9=1;
	               $array_condition[]=$ter_map_value9;
			    }  
	              
	        }

            if($territorymapping[$k][7]!=''){  

	            $ter_value8=$territorymapping[$k][7];
		        $qry8="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value8' AND idTerritoryTitle ='8'";
				$result8=$this->adapter->query($qry8,array());
			    $resultset8=$result8->toArray();	

			    if(!$resultset8){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value8=0;
	                $array_condition[]=$ter_map_value8;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory8 value mismatch'];
	             
			    }else{
			       $check_value[]=$resultset8[0]['idTerritory'];
	               $ter_map_value8=1;
	               $array_condition[]=$ter_map_value8;
			    }  
	              
	        }

	        if($territorymapping[$k][6]!=''){
	            $ter_value7=$territorymapping[$k][6];	   
		        $qry7="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value7' AND idTerritoryTitle ='7'";
				$result7=$this->adapter->query($qry7,array());
			    $resultset7=$result7->toArray();	

			    if(!$resultset7){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;   
	                $ter_map_value7=0;
	                $array_condition[]=$ter_map_value7;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory7 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset7[0]['idTerritory'];
	               $ter_map_value7=1;
	               $array_condition[]=$ter_map_value7;
			    }  
	              
	        }

            if($territorymapping[$k][5]!=''){
	            $ter_value6=$territorymapping[$k][5];
		   
		       $qry6="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value6' AND idTerritoryTitle ='6'";

				$result6=$this->adapter->query($qry6,array());
			    $resultset6=$result6->toArray();	

			    if(!$resultset6){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value6=0;
	                $array_condition[]=$ter_map_value6; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory6 value mismatch'];
	             
			    }else{  
			       $check_value[]=$resultset6[0]['idTerritory'];
	               $ter_map_value6=1;
	               $array_condition[]=$ter_map_value6; 
			    }  
	              
	        }

	        if($territorymapping[$k][4]!=''){  
	            $ter_value5=$territorymapping[$k][4];
		        $qry5="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value5' AND idTerritoryTitle ='5'";
				$result5=$this->adapter->query($qry5,array());
			    $resultset5=$result5->toArray();	

			    if(!$resultset5){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value5=0;
	                $array_condition[]=$ter_map_value5; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory5 value mismatch'];
	             
			    }else{
			       $check_value[]=$resultset5[0]['idTerritory'];
	               $ter_map_value5=1;
	               $array_condition[]=$ter_map_value5; 
			    }  
	              
	        }


            if($territorymapping[$k][3]!=''){  
	            
	          $ter_value4=$territorymapping[$k][3];	   
		      $qry4="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value4' AND idTerritoryTitle ='4'";
				$result4=$this->adapter->query($qry4,array());
			    $resultset4=$result4->toArray();	
			    if(!$resultset4){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value4=0;
	                $array_condition[]=$ter_map_value4; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory4 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset4[0]['idTerritory'];
	               $ter_map_value4=1;
	               $array_condition[]=$ter_map_value4; 
			    }  
	              
	        }

            if($territorymapping[$k][2]==''){
                $check_value[]=0; 
                $ter_value=$check_value;  
                $ter_map_value3=0;
                $array_condition[]=$ter_map_value3; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check territory3 is empty'];
            }else if($territorymapping[$k][2]!=''){
	            $ter_value3=$territorymapping[$k][2];   
		        $qry3="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value3' AND idTerritoryTitle ='3'";
				$result3=$this->adapter->query($qry3,array());
			    $resultset3=$result3->toArray();	

			    if(!$resultset3){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value3=0;
	                $array_condition[]=$ter_map_value3; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory3 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset3[0]['idTerritory'];
	               $ter_map_value3=1;
	               $array_condition[]=$ter_map_value3; 
			    }  
	              
	        }

	        if($territorymapping[$k][1]==''){
                $check_value[]=0; 
                    $ter_value=$check_value;  
                    $ter_map_value2=0;
                    $array_condition[]=$ter_map_value2; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check territory2 is empty'];
            }else if($territorymapping[$k][1]!=''){

	            $ter_value2=$territorymapping[$k][1];		   
		        $qry2="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value2' AND idTerritoryTitle ='2'";
				$result2=$this->adapter->query($qry2,array());
			    $resultset2=$result2->toArray();	

			    if(!$resultset2){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value2=0;
	                $array_condition[]=$ter_map_value2; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory2 value mismatch'];
	             
			    }else{
			       $check_value[]=$resultset2[0]['idTerritory'];
	               $ter_map_value2=1;
	               $array_condition[]=$ter_map_value2; 
			    }  
	              
	        }

	        if($territorymapping[$k][0]==''){
                $check_value[]=0; 
                    $ter_value=$check_value;  
                    $ter_map_value1=0;
                    $array_condition[]=$ter_map_value1; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check territory1 is empty'];
            }else if($territorymapping[$k][0]!=''){
	            $ter_value1=$territorymapping[$k][0];	   
		        $qry1="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value1' AND idTerritoryTitle ='1'";
				$result1=$this->adapter->query($qry1,array());
			    $resultset1=$result1->toArray();	

			    if(!$resultset1){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value1=0;
	                $array_condition[]=$ter_map_value1; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory1 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset1[0]['idTerritory'];
	               $ter_map_value1=1;
	               $array_condition[]=$ter_map_value1; 
			    }  
	              
	        }
	    }

       if(count($resultset)==9){
            
	        if($territorymapping[$k][8]!='' ){  

	         $ter_value9=$territorymapping[$k][8];
		     $qry9="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value9' AND idTerritoryTitle ='9'";
				$result9=$this->adapter->query($qry9,array());
			    $resultset9=$result9->toArray();	

			    if(!$resultset9){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value9=0;
	                $array_condition[]=$ter_map_value9;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory9 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset9[0]['idTerritory'];
	               $ter_map_value9=1;
	               $array_condition[]=$ter_map_value9;
			    }  
	              
	        }

            if($territorymapping[$k][7]!=''){  

	            $ter_value8=$territorymapping[$k][7];
		        $qry8="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value8' AND idTerritoryTitle ='8'";
				$result8=$this->adapter->query($qry8,array());
			    $resultset8=$result8->toArray();	

			    if(!$resultset8){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value8=0;
	                $array_condition[]=$ter_map_value8;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory8 value mismatch'];
	             
			    }else{
			       $check_value[]=$resultset8[0]['idTerritory'];
	               $ter_map_value8=1;
	               $array_condition[]=$ter_map_value8;
			    }  
	              
	        }

	        if($territorymapping[$k][6]!=''){
	            $ter_value7=$territorymapping[$k][6];	   
		        $qry7="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value7' AND idTerritoryTitle ='7'";
				$result7=$this->adapter->query($qry7,array());
			    $resultset7=$result7->toArray();	

			    if(!$resultset7){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;   
	                $ter_map_value7=0;
	                $array_condition[]=$ter_map_value7;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory7 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset7[0]['idTerritory'];
	               $ter_map_value7=1;
	               $array_condition[]=$ter_map_value7;
			    }  
	              
	        }

            if($territorymapping[$k][5]!=''){
	            $ter_value6=$territorymapping[$k][5];
		   
		       $qry6="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value6' AND idTerritoryTitle ='6'";

				$result6=$this->adapter->query($qry6,array());
			    $resultset6=$result6->toArray();	

			    if(!$resultset6){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value6=0;
	                $array_condition[]=$ter_map_value6; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory6 value mismatch'];
	             
			    }else{  
			       $check_value[]=$resultset6[0]['idTerritory'];
	               $ter_map_value6=1;
	               $array_condition[]=$ter_map_value6; 
			    }  
	              
	        }

	        if($territorymapping[$k][4]!=''){  
	            $ter_value5=$territorymapping[$k][4];
		        $qry5="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value5' AND idTerritoryTitle ='5'";
				$result5=$this->adapter->query($qry5,array());
			    $resultset5=$result5->toArray();	

			    if(!$resultset5){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value5=0;
	                $array_condition[]=$ter_map_value5; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory5 value mismatch'];
	             
			    }else{
			       $check_value[]=$resultset5[0]['idTerritory'];
	               $ter_map_value5=1;
	               $array_condition[]=$ter_map_value5; 
			    }  
	              
	        }


            if($territorymapping[$k][3]!=''){  
	            
	          $ter_value4=$territorymapping[$k][3];	   
		      $qry4="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value4' AND idTerritoryTitle ='4'";
				$result4=$this->adapter->query($qry4,array());
			    $resultset4=$result4->toArray();	
			    if(!$resultset4){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value4=0;
	                $array_condition[]=$ter_map_value4; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory4 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset4[0]['idTerritory'];
	               $ter_map_value4=1;
	               $array_condition[]=$ter_map_value4; 
			    }  
	              
	        }

            if($territorymapping[$k][2]==''){
                $check_value[]=0; 
                $ter_value=$check_value;  
                $ter_map_value3=0;
                $array_condition[]=$ter_map_value3; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check territory3 is empty'];
            }else if($territorymapping[$k][2]!=''){
	            $ter_value3=$territorymapping[$k][2];   
		        $qry3="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value3' AND idTerritoryTitle ='3'";
				$result3=$this->adapter->query($qry3,array());
			    $resultset3=$result3->toArray();	

			    if(!$resultset3){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value3=0;
	                $array_condition[]=$ter_map_value3; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory3 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset3[0]['idTerritory'];
	               $ter_map_value3=1;
	               $array_condition[]=$ter_map_value3; 
			    }  
	              
	        }

	        if($territorymapping[$k][1]==''){
                $check_value[]=0; 
                    $ter_value=$check_value;  
                    $ter_map_value2=0;
                    $array_condition[]=$ter_map_value2; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check territory2 is empty'];
            }else if($territorymapping[$k][1]!=''){

	            $ter_value2=$territorymapping[$k][1];		   
		        $qry2="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value2' AND idTerritoryTitle ='2'";
				$result2=$this->adapter->query($qry2,array());
			    $resultset2=$result2->toArray();	

			    if(!$resultset2){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value2=0;
	                $array_condition[]=$ter_map_value2; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory2 value mismatch'];
	             
			    }else{
			       $check_value[]=$resultset2[0]['idTerritory'];
	               $ter_map_value2=1;
	               $array_condition[]=$ter_map_value2; 
			    }  
	              
	        }

	        if($territorymapping[$k][0]==''){
                $check_value[]=0; 
                    $ter_value=$check_value;  
                    $ter_map_value1=0;
                    $array_condition[]=$ter_map_value1; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check territory1 is empty'];
            }else if($territorymapping[$k][0]!=''){
	            $ter_value1=$territorymapping[$k][0];	   
		        $qry1="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value1' AND idTerritoryTitle ='1'";
				$result1=$this->adapter->query($qry1,array());
			    $resultset1=$result1->toArray();	

			    if(!$resultset1){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value1=0;
	                $array_condition[]=$ter_map_value1; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory1 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset1[0]['idTerritory'];
	               $ter_map_value1=1;
	               $array_condition[]=$ter_map_value1; 
			    }  
	              
	        }
      
        }

       if(count($resultset)==8){
          
            if($territorymapping[$k][7]!=''){  

	            $ter_value8=$territorymapping[$k][7];
		        $qry8="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value8' AND idTerritoryTitle ='8'";
				$result8=$this->adapter->query($qry8,array());
			    $resultset8=$result8->toArray();	

			    if(!$resultset8){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value8=0;
	                $array_condition[]=$ter_map_value8;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory8 value mismatch'];
	             
			    }else{
			       $check_value[]=$resultset8[0]['idTerritory'];
	               $ter_map_value8=1;
	               $array_condition[]=$ter_map_value8;
			    }  
	              
	        }

	        if($territorymapping[$k][6]!=''){
	            $ter_value7=$territorymapping[$k][6];	   
		        $qry7="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value7' AND idTerritoryTitle ='7'";
				$result7=$this->adapter->query($qry7,array());
			    $resultset7=$result7->toArray();	

			    if(!$resultset7){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;   
	                $ter_map_value7=0;
	                $array_condition[]=$ter_map_value7;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory7 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset7[0]['idTerritory'];
	               $ter_map_value7=1;
	               $array_condition[]=$ter_map_value7;
			    }  
	              
	        }

            if($territorymapping[$k][5]!=''){
	            $ter_value6=$territorymapping[$k][5];
		   
		       $qry6="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value6' AND idTerritoryTitle ='6'";

				$result6=$this->adapter->query($qry6,array());
			    $resultset6=$result6->toArray();	

			    if(!$resultset6){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value6=0;
	                $array_condition[]=$ter_map_value6; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory6 value mismatch'];
	             
			    }else{  
			       $check_value[]=$resultset6[0]['idTerritory'];
	               $ter_map_value6=1;
	               $array_condition[]=$ter_map_value6; 
			    }  
	              
	        }

	        if($territorymapping[$k][4]!=''){  
	            $ter_value5=$territorymapping[$k][4];
		        $qry5="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value5' AND idTerritoryTitle ='5'";
				$result5=$this->adapter->query($qry5,array());
			    $resultset5=$result5->toArray();	

			    if(!$resultset5){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value5=0;
	                $array_condition[]=$ter_map_value5; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory5 value mismatch'];
	             
			    }else{
			       $check_value[]=$resultset5[0]['idTerritory'];
	               $ter_map_value5=1;
	               $array_condition[]=$ter_map_value5; 
			    }  
	              
	        }


            if($territorymapping[$k][3]!=''){  
	            
	          $ter_value4=$territorymapping[$k][3];	   
		      $qry4="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value4' AND idTerritoryTitle ='4'";
				$result4=$this->adapter->query($qry4,array());
			    $resultset4=$result4->toArray();	
			    if(!$resultset4){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value4=0;
	                $array_condition[]=$ter_map_value4; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory4 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset4[0]['idTerritory'];
	               $ter_map_value4=1;
	               $array_condition[]=$ter_map_value4; 
			    }  
	              
	        }

            if($territorymapping[$k][2]==''){
                $check_value[]=0; 
                $ter_value=$check_value;  
                $ter_map_value3=0;
                $array_condition[]=$ter_map_value3; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check territory3 is empty'];
            }else if($territorymapping[$k][2]!=''){
	            $ter_value3=$territorymapping[$k][2];   
		        $qry3="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value3' AND idTerritoryTitle ='3'";
				$result3=$this->adapter->query($qry3,array());
			    $resultset3=$result3->toArray();	

			    if(!$resultset3){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value3=0;
	                $array_condition[]=$ter_map_value3; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory3 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset3[0]['idTerritory'];
	               $ter_map_value3=1;
	               $array_condition[]=$ter_map_value3; 
			    }  
	              
	        }

	        if($territorymapping[$k][1]==''){
                $check_value[]=0; 
                    $ter_value=$check_value;  
                    $ter_map_value2=0;
                    $array_condition[]=$ter_map_value2; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check territory2 is empty'];
            }else if($territorymapping[$k][1]!=''){

	            $ter_value2=$territorymapping[$k][1];		   
		        $qry2="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value2' AND idTerritoryTitle ='2'";
				$result2=$this->adapter->query($qry2,array());
			    $resultset2=$result2->toArray();	

			    if(!$resultset2){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value2=0;
	                $array_condition[]=$ter_map_value2; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory2 value mismatch'];
	             
			    }else{
			       $check_value[]=$resultset2[0]['idTerritory'];
	               $ter_map_value2=1;
	               $array_condition[]=$ter_map_value2; 
			    }  
	              
	        }

	        if($territorymapping[$k][0]==''){
                $check_value[]=0; 
                    $ter_value=$check_value;  
                    $ter_map_value1=0;
                    $array_condition[]=$ter_map_value1; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check territory1 is empty'];
            }else if($territorymapping[$k][0]!=''){
	            $ter_value1=$territorymapping[$k][0];	   
		        $qry1="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value1' AND idTerritoryTitle ='1'";
				$result1=$this->adapter->query($qry1,array());
			    $resultset1=$result1->toArray();	

			    if(!$resultset1){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value1=0;
	                $array_condition[]=$ter_map_value1; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory1 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset1[0]['idTerritory'];
	               $ter_map_value1=1;
	               $array_condition[]=$ter_map_value1; 
			    }  
	              
	        }
        }

       if(count($resultset)==7){
            
	        if($territorymapping[$k][6]!=''){
	            $ter_value7=$territorymapping[$k][6];	   
		        $qry7="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value7' AND idTerritoryTitle ='7'";
				$result7=$this->adapter->query($qry7,array());
			    $resultset7=$result7->toArray();	

			    if(!$resultset7){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;   
	                $ter_map_value7=0;
	                $array_condition[]=$ter_map_value7;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory7 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset7[0]['idTerritory'];
	               $ter_map_value7=1;
	               $array_condition[]=$ter_map_value7;
			    }  
	              
	        }

            if($territorymapping[$k][5]!=''){
	            $ter_value6=$territorymapping[$k][5];
		   
		       $qry6="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value6' AND idTerritoryTitle ='6'";

				$result6=$this->adapter->query($qry6,array());
			    $resultset6=$result6->toArray();	

			    if(!$resultset6){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value6=0;
	                $array_condition[]=$ter_map_value6; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory6 value mismatch'];
	             
			    }else{  
			       $check_value[]=$resultset6[0]['idTerritory'];
	               $ter_map_value6=1;
	               $array_condition[]=$ter_map_value6; 
			    }  
	              
	        }

	        if($territorymapping[$k][4]!=''){  
	            $ter_value5=$territorymapping[$k][4];
		        $qry5="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value5' AND idTerritoryTitle ='5'";
				$result5=$this->adapter->query($qry5,array());
			    $resultset5=$result5->toArray();	

			    if(!$resultset5){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value5=0;
	                $array_condition[]=$ter_map_value5; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory5 value mismatch'];
	             
			    }else{
			       $check_value[]=$resultset5[0]['idTerritory'];
	               $ter_map_value5=1;
	               $array_condition[]=$ter_map_value5; 
			    }  
	              
	        }


            if($territorymapping[$k][3]!=''){  
	            
	          $ter_value4=$territorymapping[$k][3];	   
		      $qry4="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value4' AND idTerritoryTitle ='4'";
				$result4=$this->adapter->query($qry4,array());
			    $resultset4=$result4->toArray();	
			    if(!$resultset4){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value4=0;
	                $array_condition[]=$ter_map_value4; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory4 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset4[0]['idTerritory'];
	               $ter_map_value4=1;
	               $array_condition[]=$ter_map_value4; 
			    }  
	              
	        }

            if($territorymapping[$k][2]==''){
                $check_value[]=0; 
                $ter_value=$check_value;  
                $ter_map_value3=0;
                $array_condition[]=$ter_map_value3; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check territory3 is empty'];
            }else if($territorymapping[$k][2]!=''){
	            $ter_value3=$territorymapping[$k][2];   
		        $qry3="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value3' AND idTerritoryTitle ='3'";
				$result3=$this->adapter->query($qry3,array());
			    $resultset3=$result3->toArray();	

			    if(!$resultset3){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value3=0;
	                $array_condition[]=$ter_map_value3; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory3 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset3[0]['idTerritory'];
	               $ter_map_value3=1;
	               $array_condition[]=$ter_map_value3; 
			    }  
	              
	        }

	        if($territorymapping[$k][1]==''){
                $check_value[]=0; 
                    $ter_value=$check_value;  
                    $ter_map_value2=0;
                    $array_condition[]=$ter_map_value2; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check territory2 is empty'];
            }else if($territorymapping[$k][1]!=''){

	            $ter_value2=$territorymapping[$k][1];		   
		        $qry2="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value2' AND idTerritoryTitle ='2'";
				$result2=$this->adapter->query($qry2,array());
			    $resultset2=$result2->toArray();	

			    if(!$resultset2){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value2=0;
	                $array_condition[]=$ter_map_value2; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory2 value mismatch'];
	             
			    }else{
			       $check_value[]=$resultset2[0]['idTerritory'];
	               $ter_map_value2=1;
	               $array_condition[]=$ter_map_value2; 
			    }  
	              
	        }

	        if($territorymapping[$k][0]==''){
                $check_value[]=0; 
                    $ter_value=$check_value;  
                    $ter_map_value1=0;
                    $array_condition[]=$ter_map_value1; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check territory1 is empty'];
            }else if($territorymapping[$k][0]!=''){
	            $ter_value1=$territorymapping[$k][0];	   
		        $qry1="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value1' AND idTerritoryTitle ='1'";
				$result1=$this->adapter->query($qry1,array());
			    $resultset1=$result1->toArray();	

			    if(!$resultset1){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value1=0;
	                $array_condition[]=$ter_map_value1; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory1 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset1[0]['idTerritory'];
	               $ter_map_value1=1;
	               $array_condition[]=$ter_map_value1; 
			    }  
	              
	        }
        
        }

       if(count($resultset)==6){
            
            if($territorymapping[$k][5]!=''){
	            $ter_value6=$territorymapping[$k][5];
		   
		       $qry6="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value6' AND idTerritoryTitle ='6'";

				$result6=$this->adapter->query($qry6,array());
			    $resultset6=$result6->toArray();	

			    if(!$resultset6){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value6=0;
	                $array_condition[]=$ter_map_value6; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory6 value mismatch'];
	             
			    }else{  
			       $check_value[]=$resultset6[0]['idTerritory'];
	               $ter_map_value6=1;
	               $array_condition[]=$ter_map_value6; 
			    }  
	              
	        }

	        if($territorymapping[$k][4]!=''){  
	            $ter_value5=$territorymapping[$k][4];
		        $qry5="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value5' AND idTerritoryTitle ='5'";
				$result5=$this->adapter->query($qry5,array());
			    $resultset5=$result5->toArray();	

			    if(!$resultset5){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value5=0;
	                $array_condition[]=$ter_map_value5; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory5 value mismatch'];
	             
			    }else{
			       $check_value[]=$resultset5[0]['idTerritory'];
	               $ter_map_value5=1;
	               $array_condition[]=$ter_map_value5; 
			    }  
	              
	        }


            if($territorymapping[$k][3]!=''){  
	            
	          $ter_value4=$territorymapping[$k][3];	   
		      $qry4="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value4' AND idTerritoryTitle ='4'";
				$result4=$this->adapter->query($qry4,array());
			    $resultset4=$result4->toArray();	
			    if(!$resultset4){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value4=0;
	                $array_condition[]=$ter_map_value4; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory4 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset4[0]['idTerritory'];
	               $ter_map_value4=1;
	               $array_condition[]=$ter_map_value4; 
			    }  
	              
	        }

            if($territorymapping[$k][2]==''){
                $check_value[]=0; 
                $ter_value=$check_value;  
                $ter_map_value3=0;
                $array_condition[]=$ter_map_value3; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check territory3 is empty'];
            }else if($territorymapping[$k][2]!=''){
	            $ter_value3=$territorymapping[$k][2];   
		        $qry3="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value3' AND idTerritoryTitle ='3'";
				$result3=$this->adapter->query($qry3,array());
			    $resultset3=$result3->toArray();	

			    if(!$resultset3){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value3=0;
	                $array_condition[]=$ter_map_value3; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory3 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset3[0]['idTerritory'];
	               $ter_map_value3=1;
	               $array_condition[]=$ter_map_value3; 
			    }  
	              
	        }

	        if($territorymapping[$k][1]==''){
                $check_value[]=0; 
                    $ter_value=$check_value;  
                    $ter_map_value2=0;
                    $array_condition[]=$ter_map_value2; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check territory2 is empty'];
            }else if($territorymapping[$k][1]!=''){

	            $ter_value2=$territorymapping[$k][1];		   
		        $qry2="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value2' AND idTerritoryTitle ='2'";
				$result2=$this->adapter->query($qry2,array());
			    $resultset2=$result2->toArray();	

			    if(!$resultset2){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value2=0;
	                $array_condition[]=$ter_map_value2; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory2 value mismatch'];
	             
			    }else{
			       $check_value[]=$resultset2[0]['idTerritory'];
	               $ter_map_value2=1;
	               $array_condition[]=$ter_map_value2; 
			    }  
	              
	        }

	        if($territorymapping[$k][0]==''){
                $check_value[]=0; 
                    $ter_value=$check_value;  
                    $ter_map_value1=0;
                    $array_condition[]=$ter_map_value1; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check territory1 is empty'];
            }else if($territorymapping[$k][0]!=''){
	            $ter_value1=$territorymapping[$k][0];	   
		        $qry1="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value1' AND idTerritoryTitle ='1'";
				$result1=$this->adapter->query($qry1,array());
			    $resultset1=$result1->toArray();	

			    if(!$resultset1){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value1=0;
	                $array_condition[]=$ter_map_value1; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory1 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset1[0]['idTerritory'];
	               $ter_map_value1=1;
	               $array_condition[]=$ter_map_value1; 
			    }  
	              
	        }     

        }

       if(count($resultset)==5){
        if($territorymapping[$k][4]!=''){  
	            $ter_value5=$territorymapping[$k][4];
		        $qry5="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value5' AND idTerritoryTitle ='5'";
				$result5=$this->adapter->query($qry5,array());
			    $resultset5=$result5->toArray();	

			    if(!$resultset5){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value5=0;
	                $array_condition[]=$ter_map_value5; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory5 value mismatch'];
	             
			    }else{
			       $check_value[]=$resultset5[0]['idTerritory'];
	               $ter_map_value5=1;
	               $array_condition[]=$ter_map_value5; 
			    }  
	              
	        }


            if($territorymapping[$k][3]!=''){  
	            
	          $ter_value4=$territorymapping[$k][3];	   
		      $qry4="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value4' AND idTerritoryTitle ='4'";
				$result4=$this->adapter->query($qry4,array());
			    $resultset4=$result4->toArray();	
			    if(!$resultset4){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value4=0;
	                $array_condition[]=$ter_map_value4; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory4 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset4[0]['idTerritory'];
	               $ter_map_value4=1;
	               $array_condition[]=$ter_map_value4; 
			    }  
	              
	        }

            if($territorymapping[$k][2]==''){
                $check_value[]=0; 
                $ter_value=$check_value;  
                $ter_map_value3=0;
                $array_condition[]=$ter_map_value3; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check territory3 is empty'];
            }else if($territorymapping[$k][2]!=''){
	            $ter_value3=$territorymapping[$k][2];   
		        $qry3="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value3' AND idTerritoryTitle ='3'";
				$result3=$this->adapter->query($qry3,array());
			    $resultset3=$result3->toArray();	

			    if(!$resultset3){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value3=0;
	                $array_condition[]=$ter_map_value3; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory3 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset3[0]['idTerritory'];
	               $ter_map_value3=1;
	               $array_condition[]=$ter_map_value3; 
			    }  
	              
	        }

	        if($territorymapping[$k][1]==''){
                $check_value[]=0; 
                    $ter_value=$check_value;  
                    $ter_map_value2=0;
                    $array_condition[]=$ter_map_value2; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check territory2 is empty'];
            }else if($territorymapping[$k][1]!=''){

	            $ter_value2=$territorymapping[$k][1];		   
		        $qry2="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value2' AND idTerritoryTitle ='2'";
				$result2=$this->adapter->query($qry2,array());
			    $resultset2=$result2->toArray();	

			    if(!$resultset2){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value2=0;
	                $array_condition[]=$ter_map_value2; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory2 value mismatch'];
	             
			    }else{
			       $check_value[]=$resultset2[0]['idTerritory'];
	               $ter_map_value2=1;
	               $array_condition[]=$ter_map_value2; 
			    }  
	              
	        }

	        if($territorymapping[$k][0]==''){
                $check_value[]=0; 
                    $ter_value=$check_value;  
                    $ter_map_value1=0;
                    $array_condition[]=$ter_map_value1; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check territory1 is empty'];
            }else if($territorymapping[$k][0]!=''){
	            $ter_value1=$territorymapping[$k][0];	   
		        $qry1="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value1' AND idTerritoryTitle ='1'";
				$result1=$this->adapter->query($qry1,array());
			    $resultset1=$result1->toArray();	

			    if(!$resultset1){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value1=0;
	                $array_condition[]=$ter_map_value1; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory1 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset1[0]['idTerritory'];
	               $ter_map_value1=1;
	               $array_condition[]=$ter_map_value1; 
			    }  
	              
	        }
        }

       if(count($resultset)==4){

       	    if($territorymapping[$k][3]!=''){  
	            
	          $ter_value4=$territorymapping[$k][3];	   
		      $qry4="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value4' AND idTerritoryTitle ='4'";
				$result4=$this->adapter->query($qry4,array());
			    $resultset4=$result4->toArray();	
			    if(!$resultset4){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value4=0;
	                $array_condition[]=$ter_map_value4; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory4 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset4[0]['idTerritory'];
	               $ter_map_value4=1;
	               $array_condition[]=$ter_map_value4; 
			    }  
	              
	        }

            if($territorymapping[$k][2]==''){
                $check_value[]=0; 
                $ter_value=$check_value;  
                $ter_map_value3=0;
                $array_condition[]=$ter_map_value3; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check territory3 is empty'];
            }else if($territorymapping[$k][2]!=''){
	            $ter_value3=$territorymapping[$k][2];   
		        $qry3="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value3' AND idTerritoryTitle ='3'";
				$result3=$this->adapter->query($qry3,array());
			    $resultset3=$result3->toArray();	

			    if(!$resultset3){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value3=0;
	                $array_condition[]=$ter_map_value3; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory3 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset3[0]['idTerritory'];
	               $ter_map_value3=1;
	               $array_condition[]=$ter_map_value3; 
			    }  
	              
	        }

	        if($territorymapping[$k][1]==''){
                $check_value[]=0; 
                    $ter_value=$check_value;  
                    $ter_map_value2=0;
                    $array_condition[]=$ter_map_value2; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check territory2 is empty'];
            }else if($territorymapping[$k][1]!=''){

	            $ter_value2=$territorymapping[$k][1];		   
		        $qry2="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value2' AND idTerritoryTitle ='2'";
				$result2=$this->adapter->query($qry2,array());
			    $resultset2=$result2->toArray();	

			    if(!$resultset2){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value2=0;
	                $array_condition[]=$ter_map_value2; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory2 value mismatch'];
	             
			    }else{
			       $check_value[]=$resultset2[0]['idTerritory'];
	               $ter_map_value2=1;
	               $array_condition[]=$ter_map_value2; 
			    }  
	              
	        }

	        if($territorymapping[$k][0]==''){
                $check_value[]=0; 
                    $ter_value=$check_value;  
                    $ter_map_value1=0;
                    $array_condition[]=$ter_map_value1; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check territory1 is empty'];
            }else if($territorymapping[$k][0]!=''){
	            $ter_value1=$territorymapping[$k][0];	   
		        $qry1="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value1' AND idTerritoryTitle ='1'";
				$result1=$this->adapter->query($qry1,array());
			    $resultset1=$result1->toArray();	

			    if(!$resultset1){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value1=0;
	                $array_condition[]=$ter_map_value1; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory1 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset1[0]['idTerritory'];
	               $ter_map_value1=1;
	               $array_condition[]=$ter_map_value1; 
			    }  
	              
	        }
          
        }

       if(count($resultset)==3){
 
	        if($territorymapping[$k][2]==''){
                $check_value[]=0; 
                $ter_value=$check_value;  
                $ter_map_value3=0;
                $array_condition[]=$ter_map_value3; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check territory3 is empty'];
            }else if($territorymapping[$k][2]!=''){
	            $ter_value3=$territorymapping[$k][2];   
		        $qry3="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value3' AND idTerritoryTitle ='3'";
				$result3=$this->adapter->query($qry3,array());
			    $resultset3=$result3->toArray();	

			    if(!$resultset3){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value3=0;
	                $array_condition[]=$ter_map_value3; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory3 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset3[0]['idTerritory'];
	               $ter_map_value3=1;
	               $array_condition[]=$ter_map_value3; 
			    }  
	              
	        }

	        if($territorymapping[$k][1]==''){
                $check_value[]=0; 
                    $ter_value=$check_value;  
                    $ter_map_value2=0;
                    $array_condition[]=$ter_map_value2; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check territory2 is empty'];
            }else if($territorymapping[$k][1]!=''){

	            $ter_value2=$territorymapping[$k][1];		   
		        $qry2="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value2' AND idTerritoryTitle ='2'";
				$result2=$this->adapter->query($qry2,array());
			    $resultset2=$result2->toArray();	

			    if(!$resultset2){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value2=0;
	                $array_condition[]=$ter_map_value2; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory2 value mismatch'];
	             
			    }else{
			       $check_value[]=$resultset2[0]['idTerritory'];
	               $ter_map_value2=1;
	               $array_condition[]=$ter_map_value2; 
			    }  
	              
	        }

	        if($territorymapping[$k][0]==''){
                $check_value[]=0; 
                    $ter_value=$check_value;  
                    $ter_map_value1=0;
                    $array_condition[]=$ter_map_value1; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check territory1 is empty'];
            }else if($territorymapping[$k][0]!=''){
	            $ter_value1=$territorymapping[$k][0];	   
		        $qry1="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value1' AND idTerritoryTitle ='1'";
				$result1=$this->adapter->query($qry1,array());
			    $resultset1=$result1->toArray();	

			    if(!$resultset1){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value1=0;
	                $array_condition[]=$ter_map_value1; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory1 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset1[0]['idTerritory'];
	               $ter_map_value1=1;
	               $array_condition[]=$ter_map_value1; 
			    }  
	              
	        }

        }

       if(count($resultset)==2){

       	        if($territorymapping[$k][1]==''){
                $check_value[]=0; 
                    $ter_value=$check_value;  
                    $ter_map_value2=0;
                    $array_condition[]=$ter_map_value2; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check territory2 is empty'];
                }else if($territorymapping[$k][1]!=''){

	            $ter_value2=$territorymapping[$k][1];		   
		        $qry2="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value2' AND idTerritoryTitle ='2'";
				$result2=$this->adapter->query($qry2,array());
			    $resultset2=$result2->toArray();	

			    if(!$resultset2){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value2=0;
	                $array_condition[]=$ter_map_value2; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory2 value mismatch'];
	             
			    }else{
			       $check_value[]=$resultset2[0]['idTerritory'];
	               $ter_map_value2=1;
	               $array_condition[]=$ter_map_value2; 
			    }  	              
	        }

	        if($territorymapping[$k][0]==''){
                $check_value[]=0; 
                    $ter_value=$check_value;  
                    $ter_map_value1=0;
                    $array_condition[]=$ter_map_value1; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check territory1 is empty'];
            }else if($territorymapping[$k][0]!=''){
	            $ter_value1=$territorymapping[$k][0];	   
		        $qry1="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value1' AND idTerritoryTitle ='1'";
				$result1=$this->adapter->query($qry1,array());
			    $resultset1=$result1->toArray();	

			    if(!$resultset1){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value1=0;
	                $array_condition[]=$ter_map_value1; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory1 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset1[0]['idTerritory'];
	               $ter_map_value1=1;
	               $array_condition[]=$ter_map_value1; 
			    }  
	              
	        }
          
        }

       if(count($resultset)==1){

  	        if($territorymapping[$k][0]==''){
                $check_value[]=0; 
                    $ter_value=$check_value;  
                    $ter_map_value1=0;
                    $array_condition[]=$ter_map_value1; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check territory1 is empty'];
            }else if($territorymapping[$k][0]!=''){
	            $ter_value1=$territorymapping[$k][0];	   
		        $qry1="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value1' AND idTerritoryTitle ='1'";
				$result1=$this->adapter->query($qry1,array());
			    $resultset1=$result1->toArray();	

			    if(!$resultset1){
			    	$check_value[]=0; 
			    	$ter_value=$check_value;  
	                $ter_map_value1=0;
	                $array_condition[]=$ter_map_value1; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory1 value mismatch'];
	             
			    }else{ 
			       $check_value[]=$resultset1[0]['idTerritory'];
	               $ter_map_value1=1;
	               $array_condition[]=$ter_map_value1; 
			    }  
	              
	        }
        }


    }  // close the loop 

if(count($array_condition)!=0){
    for($j=0; $j<count($array_condition);$j++){ 
            $zero=0;
        if(in_array($zero,$array_condition)){

           $check=0;
        }else{
           $check=1;

        }
                   
    }
}else{
	$check=0;
	 $ret_arr=['code'=>'3','status'=>false,'message'=>'Excel data is empty'];
}

  

if($check!=0){ 

    for($m=0; $m<count($territorymapping);$m++){

	    if($territorymapping[$m][0]!=''){

	    $ter_value1=$territorymapping[$m][0];		   
        $qry1="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value1' AND idTerritoryTitle ='1'";
		$result1=$this->adapter->query($qry1,array());
	    $resultset1=$result1->toArray();
	    $territory1=$resultset1[0]['idTerritory'];

	    }else{
	    	$territory1=0;
	    }
	    if($territorymapping[$m][1]!=''){
	    $ter_value2=$territorymapping[$m][1];		   
        $qry2="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value2' AND idTerritoryTitle ='2'";
		$result2=$this->adapter->query($qry2,array());
	    $resultset2=$result2->toArray();	
	    $territory2=$resultset2[0]['idTerritory'];

	    }else{
	    	$territory2=0;
	    }
	    if($territorymapping[$m][2]!=''){
    	$ter_value3=$territorymapping[$m][2];		   
        $qry3="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value3' AND idTerritoryTitle ='3'";
		$result3=$this->adapter->query($qry3,array());
	    $resultset3=$result3->toArray();	
	    $territory3=$resultset3[0]['idTerritory'];

	    }else{
	    	$territory3=0;
	    }
	    if($territorymapping[$m][3]!=''){
	    	  $ter_value4=$territorymapping[$m][3];		   
        $qry4="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value4' AND idTerritoryTitle ='4'";
		$result4=$this->adapter->query($qry4,array());
	    $resultset4=$result4->toArray();	
	    $territory4=$resultset4[0]['idTerritory'];

	    }else{
	    	$territory4=0;
	    }
	    if($territorymapping[$m][4]!=''){
	    	  $ter_value5=$territorymapping[$m][4];		   
        $qry5="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value5' AND idTerritoryTitle ='5'";
		$result5=$this->adapter->query($qry5,array());
	    $resultset5=$result5->toArray();	
	    	$territory5=$resultset5[0]['idTerritory'];
	    }else{
	    	$territory5=0;
	    }
	    if($territorymapping[$m][5]!=''){
	     $ter_value6=$territorymapping[$m][5];		   
        $qry6="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value6' AND idTerritoryTitle ='6'";
		$result6=$this->adapter->query($qry6,array());
	    $resultset6=$result6->toArray();
	    	$territory6=$resultset6[0]['idTerritory'];
	    }else{
	    	$territory6=0;
	    }
	    if($territorymapping[$m][6]!=''){
	    $ter_value7=$territorymapping[$m][6];		   
        $qry7="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value7' AND idTerritoryTitle ='7'";
		$result7=$this->adapter->query($qry7,array());
	    $resultset7=$result7->toArray();
	    	$territory7=$resultset7[0]['idTerritory'];
	    }else{
	    	$territory7=0;
	    }
	    if($territorymapping[$m][7]!=''){
	    $ter_value8=$territorymapping[$m][7];		   
        $qry8="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value8' AND idTerritoryTitle ='8'";
		$result8=$this->adapter->query($qry8,array());
	    $resultset8=$result8->toArray();	
	    	$territory8=$resultset8[0]['idTerritory'];
	    }else{
	    	$territory8=0;
	    }
	    if($territorymapping[$m][8]!=''){
	    $ter_value9=$territorymapping[$m][8];		   
        $qry9="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value9' AND idTerritoryTitle ='9'";
		$result9=$this->adapter->query($qry9,array());
	    $resultset9=$result9->toArray();
	    	$territory9=$resultset9[0]['idTerritory'];
	    }else{
	    	$territory9=0;
	    }
	    if($territorymapping[$m][9]!=''){
	    $ter_value10=$territorymapping[$m][9];		   
        $qry10="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value10' AND idTerritoryTitle ='10'";
		$result10=$this->adapter->query($qry10,array());
	    $resultset10=$result10->toArray();	
	    	$territory10=$territory10[0]['idTerritory'];
	    }else{
	    	$territory10=0;
	    }



    	$qry_list="SELECT idTerritoryMapping FROM territorymapping_master where t1=? and t2=? and t3=? and t4=? and t5=? and t6=? and t7=? and t8=? and t9=? and t10=?";       
	    $result_list=$this->adapter->query($qry_list,array($territory1,$territory2,$territory3,$territory4,$territory5,$territory6,$territory7,$territory8,$territory9,$territory10));
		$resultset_list=$result_list->toArray();

			if(!$resultset_list){
						$this->adapter->getDriver()->getConnection()->beginTransaction();
						try {		
							$data['t1']=(($territorymapping[$m][0]!='')? $resultset1[0]['idTerritory']:0);
							$data['t2']=(($territorymapping[$m][1]!='')? $resultset2[0]['idTerritory']:0);
							$data['t3']=(($territorymapping[$m][2]!='')? $resultset3[0]['idTerritory']:0);
							$data['t4']=(($territorymapping[$m][3]!='')? $resultset4[0]['idTerritory']:0);
							$data['t5']=(($territorymapping[$m][4]!='')? $resultset5[0]['idTerritory']:0);
							$data['t6']=(($territorymapping[$m][5]!='')? $resultset6[0]['idTerritory']:0);
							$data['t7']=(($territorymapping[$m][6]!='')? $resultset7[0]['idTerritory']:0);
							$data['t8']=(($territorymapping[$m][7]!='')? $resultset8[0]['idTerritory']:0);
							$data['t9']=(($territorymapping[$m][8]!='')? $resultset9[0]['idTerritory']:0);
							$data['t10']=(($territorymapping[$m][9]!='')? $resultset10[0]['idTerritory']:0);
							$data['created_at']=date('Y-m-d H:i:s');
							$data['created_by']=1;
							$data['updated_at']=date('Y-m-d H:i:s');
							$data['updated_by']=1;
							$insert=new Insert('territorymapping_master');
							$insert->values($data);
							$statement=$this->adapter->createStatement();
							$insert->prepareStatement($this->adapter, $statement);
							$insertresult=$statement->execute();
                            $insert_value += $insert_count+1;	
							$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
							$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
							$this->adapter->getDriver()->getConnection()->rollBack();
						}
			}else{
					$reject_value += $reject_count+1;
							
			     }          

    }

    if($insert_value!=0 && $reject_value==0){

        $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];

    }else if($insert_value ==0 && $reject_value !=0){

    	$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists data'];

    }else if($insert_value!=0 && $reject_value!=0){

        $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists  '.$reject_value.'Uploaded '.$insert_value];

    }
   
}
	}else{

			$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please verify the csv file'];

	    }

    }       

    return  $ret_arr;

   } // close func

public function uploadcategroy($param) {
	
		ini_set('display_errors',true);
		$Uploads_dir = 'public/uploads/csv';
		$tmp_name=$_FILES["myFile"]["tmp_name"]; 
		$name = basename($_FILES["myFile"]["name"]); 
		$imageName = rand(6,66666).'.'. pathinfo($_FILES["myFile"]['name'],PATHINFO_EXTENSION);
    	if(move_uploaded_file($tmp_name, "$Uploads_dir/$imageName")) {
			$r="public/uploads/csv/$imageName";
			$file = fopen($r, "r",FILE_SKIP_EMPTY_LINES);
			$emapData = fgetcsv($file, 10000, ","); 
				$row=0;
				$size=sizeof($emapData);
				if($size=='2' && $emapData !=null) {
				$categorys=array();
				$no_categorys=array();
				while (($record = fgetcsv($file)) !== FALSE) {
					$row++;
					array_push($categorys,$record);
				}

        $insert_count=0;
        $reject_count=0;
        $reject_value=0; 
        $insert_value=0;  

    for($k=0; $k<count($categorys);$k++) {

        if($categorys[$k][1]=='' || $categorys[$k][1]=="null"){
                $status=0;   
                $no_categorys[]=$status; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Status is empty'];    
        }else if($categorys[$k][1]=="Active" || $categorys[$k][1]=="active"){

                $status=1;
                $no_categorys[]=$status; 
        }else if($categorys[$k][1]=="Inactive" || $categorys[$k][1]=="inactive"){

        		$status=2;
        		$no_categorys[]=$status; 
        }else{

        		$status=0;  
        		$no_categorys[]=$status;   
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status data'];  

        }

    	if($categorys[$k][0]=='' || $categorys[$k][0]=="null"){
            $categorys_name=0; 
            $no_categorys[]=$categorys_name;      
            $ret_arr=['code'=>'3','status'=>false,'message'=>'Category name is empty'];    
    	}else {
            $categorys_name=1;  
            $no_categorys[]=$categorys_name;      
              
    	}

	}


if(count($no_categorys)!=0){
 	
    for($j=0; $j<count($no_categorys);$j++){ 
            $zero=0;
        if(in_array($zero,$no_categorys)){

            $check=0;
        }else{
            $check=1;

        }
                   
    }
}else{
	 $check=0;
	 $ret_arr=['code'=>'3','status'=>false,'message'=>'Excel data is empty'];
}


 if($check!=0){

		for($i=0; $i<count($categorys);$i++){

			if($categorys[$i][1]=="Active" || $categorys[$i][1]=="active"){
                $status=1;
        	}else if($categorys[$i][1]=="Inactive" || $categorys[$i][1]=="inactive"){

        		$status=2;
            }
					$qry="SELECT * FROM category where category=?";
					$result=$this->adapter->query($qry,array($categorys[$i][0]));
					$resultset=$result->toArray();
					if(!$resultset){
						$this->adapter->getDriver()->getConnection()->beginTransaction();
						try {		
							$data['category']=$categorys[$i][0];
							$data['status']=$status;
							$data['created_at']=date('Y-m-d H:i:s');
							$data['created_by']=1;
							$insert=new Insert('category');
							$insert->values($data);
							$statement=$this->adapter->createStatement();
							$insert->prepareStatement($this->adapter, $statement);
							$insertresult=$statement->execute();
							$insert_value += $insert_count+1;
					       // $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
							$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
							$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
							$this->adapter->getDriver()->getConnection()->rollBack();
						}
					} else {
						$reject_value += $reject_count+1;
			       
					}
				}

       if($insert_value!=0 && $reject_value==0){

              $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
        }else if($insert_value ==0 && $reject_value !=0){

        	 $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];

        }else if($insert_value!=0 && $reject_value!=0){

        $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists  '.$reject_value.'Uploaded  '.$insert_value];
        }


    }

			} else {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please verify the csv file'];
			}
			
		}
		return $ret_arr;

	} // close func
public function uploadsubcategroy($param) {
		ini_set('display_errors',true);
		$Uploads_dir = 'public/uploads/csv';
		$tmp_name=$_FILES["myFile"]["tmp_name"]; 
		$name = basename($_FILES["myFile"]["name"]); 
		$imageName = rand(6,66666).'.'. pathinfo($_FILES["myFile"]['name'],PATHINFO_EXTENSION);
    	if(move_uploaded_file($tmp_name, "$Uploads_dir/$imageName")) {
			$r="public/uploads/csv/$imageName";
			$file = fopen($r, "r",FILE_SKIP_EMPTY_LINES);
			$emapData = fgetcsv($file, 10000, ","); 
				$row=0;
				$size=sizeof($emapData);
				if($size=='3' && $emapData !=null && $emapData[0]=='Category' && $emapData[1]=='Subcategory') {
				$subcategorys=array();
				$no_subcategorys=array();
				while (($record = fgetcsv($file)) !== FALSE) {
					$row++;
					array_push($subcategorys,$record);
				}

		$insert_count=0;
        $reject_count=0;
        $reject_value=0; 
        $insert_value=0; 

	for($k=0; $k<count($subcategorys);$k++) {

	 	if($subcategorys[$k][2]=='' || $subcategorys[$k][2]=="null"){
                $status=0;    
                $no_subcategorys[]=$status;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status empty'];    
        	}else if($subcategorys[$k][2]=="Active" || $subcategorys[$k][2]=="active"){

                $status=1;
                $no_subcategorys[]=$status;
        	}else if($subcategorys[$k][2]=="Inactive" || $subcategorys[$k][2]=="inactive"){

        		$status=2;
        		$no_subcategorys[]=$status;
            }else{
                $status=0; 
                $no_subcategorys[]=$status;    
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status data'];    
        	}

        if($subcategorys[$k][1]=='' || $subcategorys[$k][1]=="null"){
		    	$sub_category=0;   
		    	$no_subcategorys[]=$sub_category; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Sub category is empty'];

		}else if($subcategorys[$k][1]!='' || $subcategorys[$k][1]!="null"){
                $sub_category=1;   
                $no_subcategorys[]=$sub_category;  
                 
        }


        if($subcategorys[$k][0]=='' || $subcategorys[$k][0]=="null"){
		    	$category=0;  
		    	$no_subcategorys[]=$category;   
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Category is empty'];


		}else if($subcategorys[$k][0]!='' || $subcategorys[$k][0]!="null"){

	            $subcategory_name =$subcategorys[$k][0];
		        $qry1="SELECT idCategory FROM category WHERE category='$subcategory_name'";
				$result1=$this->adapter->query($qry1,array());
			    $resultset1=$result1->toArray();
		  
		    if(!$resultset1){

	          $category=0; 
              $no_subcategorys[]=$category;   
	          $ret_arr=['code'=>'3','status'=>false,'message'=>'category data mismatch'];

		    }else if($resultset1){

	           $category=1; 
	           $no_subcategorys[]=$category;   
		    	 
		    } 		
                 
        }      	
                
	}

if(count($no_subcategorys)!=0){
 	
    for($j=0; $j<count($no_subcategorys);$j++){ 
            $zero=0;
        if(in_array($zero,$no_subcategorys)){

            $check=0;
        }else{
            $check=1;

        }
                   
    }
}else{
	 $check=0;
	 $ret_arr=['code'=>'3','status'=>false,'message'=>'Excel data is empty'];
}

    if($check!=0){

	for($i=0; $i<count($subcategorys);$i++) {

        $subcategory_name =$subcategorys[$i][0];
        $qry1="SELECT idCategory FROM category WHERE category='$subcategory_name'";
		$result1=$this->adapter->query($qry1,array());
	    $resultset1=$result1->toArray();

	    if($subcategorys[$i][1]=="Active" || $subcategorys[$i][1]=="active"){
                $status=1;
        }else if($subcategorys[$i][1]=="Inactive" || $subcategorys[$i][1]=="inactive"){
        		$status=2;
        }
      
		$qry="SELECT * FROM subcategory where idCategory=? and subcategory=?";
		$result=$this->adapter->query($qry,array($resultset1[0]['idCategory'],$subcategorys[$i][1]));
		$resultset=$result->toArray();

		if(!$resultset) {
			$this->adapter->getDriver()->getConnection()->beginTransaction();
			try {
							$data['idCategory']=$resultset1[0]['idCategory'];
							$data['subcategory']=$subcategorys[$i][1];
							$data['status']= $status;
							$data['created_at']=date('Y-m-d H:i:s');
							$data['created_by']=1;
							$insert=new Insert('subcategory');
							$insert->values($data);
							$statement=$this->adapter->createStatement();
							$insert->prepareStatement($this->adapter, $statement);
							$insertresult=$statement->execute();
							$insert_value += $insert_count+1;
		
							$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
							$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'];
							$this->adapter->getDriver()->getConnection()->rollBack();
						}
					} else {
						$reject_value += $reject_count+1;
						//array_push($no_subcategorys,$subcategorys[$i]);
			
				        
					}
				}

		if($insert_value!=0 && $reject_value==0){

              $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
        }else if($insert_value ==0 && $reject_value !=0){

        	 $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists data'];

        }else if($insert_value!=0 && $reject_value!=0){

        $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists  '.$reject_value.'Uploaded  '.$insert_value];
        }

    }


			} else {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please verify the csv file'];
			}
			
		}
		return $ret_arr;

	} // close func


public function uploadesignation($param) {
		ini_set('display_errors',true);
		$Uploads_dir = 'public/uploads/csv';
		$tmp_name=$_FILES["myFile"]["tmp_name"]; 
		$name = basename($_FILES["myFile"]["name"]); 
		$imageName = rand(6,66666).'.'. pathinfo($_FILES["myFile"]['name'],PATHINFO_EXTENSION);
    	if(move_uploaded_file($tmp_name, "$Uploads_dir/$imageName")) {
			$r="public/uploads/csv/$imageName";
			$file = fopen($r, "r",FILE_SKIP_EMPTY_LINES);
			$emapData = fgetcsv($file, 10000, ","); 
				$row=0;
				$size=sizeof($emapData);
				if($size=='2' && $emapData !=null) {
				$designation=array();
				$no_designation=array();
				while (($record = fgetcsv($file)) !== FALSE) {
					$row++;
					array_push($designation,$record);
				}

        $insert_count=0;
        $reject_count=0;
        $reject_value=0; 
        $insert_value=0;  

    for($k=0; $k<count($designation);$k++) {

        if($designation[$k][1]=='' || $designation[$k][1]=="null"){
                $status=0;   
                $no_designation[]=$status; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Status is empty'];    
        }else if($designation[$k][1] =="Active" || $designation[$k][1] =="active"){

                $status=1;
                $no_designation[]=$status; 
        }else if($designation[$k][1] =="Inactive" || $designation[$k][1] =="inactive"){

        		$status=2;
        		$no_designation[]=$status; 
        }else{

        		$status=0;  
        		$no_designation[]=$status;   
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status data'];  

        }

    	if($designation[$k][0]=='' || $designation[$k][0]=="null"){
            $designation_name=0; 
            $no_designation[]=$designation_name;     
            $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the category name empty'];    
    	}else {
            $designation_name[]=1;  
            $no_designation[]=$designation_name;      
              
    	}

	}


if(count($no_designation)!=0){
 	
    for($j=0; $j<count($no_designation);$j++){ 
            $zero=0;
        if(in_array($zero,$no_designation)){

            $check=0;
        }else{
            $check=1;

        }
                   
    }
}else{
	 $check=0;
	 $ret_arr=['code'=>'3','status'=>false,'message'=>'Excel data is empty'];
}


 if($check!=0){

		for($i=0; $i<count($designation);$i++){

			if($designation[$i][1]=="Active" || $designation[$i][1]=="active"){
                $status=1;
        	}else if($designation[$i][1]=="Inactive" || $designation[$i][1]=="inactive"){

        		$status=2;
            }
					$qry="SELECT * FROM designation where name=?";
					$result=$this->adapter->query($qry,array($designation[$i][0]));
					$resultset=$result->toArray();
					if(!$resultset){
						$this->adapter->getDriver()->getConnection()->beginTransaction();
						try {		
							$data['name']=$designation[$i][0];
							$data['status']=$status;
							$data['created_at']=date('Y-m-d H:i:s');
							$data['created_by']=1;
							$data['updated_at']=date('Y-m-d H:i:s');
							$data['updated_by']=1;
							$insert=new Insert('designation');
							$insert->values($data);
							$statement=$this->adapter->createStatement();
							$insert->prepareStatement($this->adapter, $statement);
							$insertresult=$statement->execute();
							$insert_value += $insert_count+1;
					       // $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
							$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
							$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
							$this->adapter->getDriver()->getConnection()->rollBack();
						}
					} else {
						$reject_value += $reject_count+1;
			       
					}
				}

       if($insert_value!=0 && $reject_value==0){

              $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
        }else if($insert_value ==0 && $reject_value !=0){

        	 $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];

        }else if($insert_value!=0 && $reject_value!=0){

        $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists  '.$reject_value.'Uploaded  '.$insert_value];
        }


    }

			} else {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please verify the csv file'];
			}
			
		}
		return $ret_arr;

	} // close func


public function uploadteamhierarchy($param) {
		ini_set('display_errors',true);
		$Uploads_dir = 'public/uploads/csv';
		$tmp_name=$_FILES["myFile"]["tmp_name"]; 
		$name = basename($_FILES["myFile"]["name"]); 
		$imageName = rand(6,66666).'.'. pathinfo($_FILES["myFile"]['name'],PATHINFO_EXTENSION);
    	if(move_uploaded_file($tmp_name, "$Uploads_dir/$imageName")) {
			$r="public/uploads/csv/$imageName";
			$file = fopen($r, "r",FILE_SKIP_EMPTY_LINES);
			$emapData = fgetcsv($file, 10000, ","); 
				$row=0;
				$size=sizeof($emapData);
				if($size=='15' && $emapData !=null) {
				$teamhierarchy=array();
				$no_teamhierarchy=array();
				while (($record = fgetcsv($file)) !== FALSE) {
					$row++;
					array_push($teamhierarchy,$record);
				}
                //print_r($teamhierarchy);
		$insert_count=0;
        $reject_count=0;
        $reject_value=0; 
        $insert_value=0; 
	for($k=0; $k<count($teamhierarchy);$k++) {


        if($teamhierarchy[$k][14]=='' || $teamhierarchy[$k][14]=="null"){
                $status=0;   
                $no_teamhierarchy[]=$status; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Status is empty'];    
        }else if($teamhierarchy[$k][14] =="Active" || $teamhierarchy[$k][14] =="active"){

                $status=1;
                $no_teamhierarchy[]=$status; 
        }else if($teamhierarchy[$k][14] =="Inactive" || $teamhierarchy[$k][14] =="inactive"){

                $status=2;
                $no_teamhierarchy[]=$status; 
        }else{

                $status=0;  
                $no_teamhierarchy[]=$status;   
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status data'];  

        }

         if($teamhierarchy[$k][13]=='' || $teamhierarchy[$k][13]=="null"){
            $sales_hierarchy=0; 
             $no_teamhierarchy[]=$sales_hierarchy;
            $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the sales hierarchy is empty'];

        }else if($teamhierarchy[$k][13]!='' || $teamhierarchy[$k][13]!="null"){

            $saleshr =$teamhierarchy[$k][13];
            $qry3="SELECT idSaleshierarchy FROM sales_hierarchy WHERE saleshierarchyName='$saleshr'";
            $result3=$this->adapter->query($qry3,array());
            $resultset3=$result3->toArray();
          
            if(!$resultset3){

            $sales_hierarchy=0; 
             $no_teamhierarchy[]=$sales_hierarchy;

             $ret_arr=['code'=>'3','status'=>false,'message'=>'Sales hierarchy data mismatch'];

            }else{

             $sales_hierarchy=1; 
             $no_teamhierarchy[]=$sales_hierarchy;
                 
            }       
                 
        }
       
		 if($teamhierarchy[$k][12]=='' || $teamhierarchy[$k][12]=="null"){
        	$segment_type=0; 
        	$no_teamhierarchy[]=$segment_type;
            $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the segment type empty'];
            
        }else if($teamhierarchy[$k][12]!='' || $teamhierarchy[$k][12]!="null"){

            $segment_name =$teamhierarchy[$k][12];


            if($segment_name=='Consumers'){
            	$segmenttype=1;
            }else if($segment_name=='Business'){
            	$segmenttype=2;
            }else if($segment_name=='Consumers and Business'){
            	$segmenttype=3;   	
            }else{
            	$segment_type=0;
            	$no_teamhierarchy[]=$segment_type;
            	$ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the segment type mismatch'];
            }	

             $proposition_type = $teamhierarchy[$k][11];

            if($proposition_type=='Products'){
                $propos=1;
            }else if($proposition_type=='Services'){
                $propos=2;
            }else if($proposition_type=='Products and services'){
                $propos=3;   
            }

             $subsidiary_name =$teamhierarchy[$k][10];
            $qry3="SELECT idSubsidaryGroup FROM subsidarygroup_master WHERE subsidaryName='$subsidiary_name' AND proposition='$propos' AND segment='$segmenttype'";
            $result3=$this->adapter->query($qry3,array());
            $resultset3=$result3->toArray();
            if(!$resultset3){
                $segment_type=0;
                $no_teamhierarchy[]=$segment_type;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Segment type is not mapped with given proposition type'];
            }else{
                $segment_type=$segmenttype;
                $no_teamhierarchy[]=$segment_type;
            }
        }

        if($teamhierarchy[$k][11] =='' || $teamhierarchy[$k][11] =="null"){
            $proposition=0; 
            $no_teamhierarchy[]= $proposition;
            $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the proposition type empty'];
        }else if($teamhierarchy[$k][11] !='' || $teamhierarchy[$k][11] !="null"){

            $proposition_type = $teamhierarchy[$k][11];

            if($proposition_type=='Products'){
            	$propos=1;
            }else if($proposition_type=='Services'){
            	$propos=2;
            }else if($proposition_type=='Products and services'){
            	$propos=3;   
            }else{
               $proposition=0;
                $no_teamhierarchy[]=$proposition;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the proposition type mismatch'];
            }

             $subsidiary_name =$teamhierarchy[$k][10];
            $qry3="SELECT idSubsidaryGroup FROM subsidarygroup_master WHERE subsidaryName='$subsidiary_name' AND proposition='$propos'";
            $result3=$this->adapter->query($qry3,array());
            $resultset3=$result3->toArray();
            if(!$resultset3){
                $proposition=0;
                $no_teamhierarchy[]=$proposition;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Proposition type is not mapped with given subsidiary'];
            }else{
                $proposition=$propos;
                $no_teamhierarchy[]=$proposition;
            }
                 
        } 

         if($teamhierarchy[$k][10]=='' || $teamhierarchy[$k][10]=="null"){
        	$subsidiary=0; 
        	 $no_teamhierarchy[]=$subsidiary;
            $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the subsidiary empty'];

        }else if($teamhierarchy[$k][10]!='' || $teamhierarchy[$k][10]!="null"){

            $subsidiary_name =$teamhierarchy[$k][10];
	        $qry3="SELECT idSubsidaryGroup FROM subsidarygroup_master WHERE subsidaryName='$subsidiary_name'";
			$result3=$this->adapter->query($qry3,array());
		    $resultset3=$result3->toArray();
		  
		    if(!$resultset3){

	        $subsidiary=0; 
	         $no_teamhierarchy[]=$subsidiary;

	         $ret_arr=['code'=>'3','status'=>false,'message'=>'Subsidiary data mismatch'];

		    }else{

	         $subsidiary=1; 
	         $no_teamhierarchy[]=$subsidiary;
		    	 
		    } 		
                 
        }

         if($teamhierarchy[$k][9]=='' || $teamhierarchy[$k][9]=="null"){
        	$maingroup_name=0; 
        	$no_teamhierarchy[]=$maingroup_name;
            $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the maingroup empty'];

        }else if($teamhierarchy[$k][9]!='' || $teamhierarchy[$k][9]!="null"){

            $maingroup_name =$teamhierarchy[$k][9];
	        $qry2="SELECT idMainGroup FROM maingroup_master WHERE mainGroupName='$maingroup_name'";
			$result2=$this->adapter->query($qry2,array());
		    $resultset2=$result2->toArray();
		  
		    if(!$resultset2){

	          $maingroup_name=0; 
	          $no_teamhierarchy[]=$maingroup_name;

	         $ret_arr=['code'=>'3','status'=>false,'message'=>'Maingroup data mismatch'];

		    }else{
	           $maingroup_name=1; 
	           $no_teamhierarchy[]=$maingroup_name;
		    	 
		    } 		
                 
        }

        if($teamhierarchy[$k][8]!='' && $teamhierarchy[$k][8]!='null'){
            $reporting_emp =$teamhierarchy[$k][8];
            $qry4="SELECT idTeamMember FROM team_member_master WHERE name='$reporting_emp' AND isRepManager=1";
			$result4=$this->adapter->query($qry4,array());
		    $resultset4=$result4->toArray();

			    if(!$resultset4){     
		           $reporting=0; 
		           $no_teamhierarchy[]=$reporting;  

		         $ret_arr=['code'=>'3','status'=>false,'message'=>'Reportingto data mismatch'];

			    }else{
		            $reporting=1; 
		            $no_teamhierarchy[]=$reporting;  
			    	 
			    } 		
        }

    

	
        if($teamhierarchy[$k][7]=='' || $teamhierarchy[$k][7]=="null"){
		    	$manager=0; 
		    	$no_teamhierarchy[]=$manager;     
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the manager empty'];

		}else if($teamhierarchy[$k][7]=='Yes' || $teamhierarchy[$k][7]=='yes'){
                $manager=1;  
                $no_teamhierarchy[]=$manager;      
                 
        }else if($teamhierarchy[$k][7]=='No'  || $teamhierarchy[$k][7]=='no'){
                $manager=2;   
                $no_teamhierarchy[]=$manager;     
                 
        }else{

            $manager=0;    
	    	$no_teamhierarchy[]=$manager;    
            $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the manager mismatch'];

        }



        if($teamhierarchy[$k][6]=='' || $teamhierarchy[$k][6]=="null"){
	    	$address=0;    
	    	$no_teamhierarchy[]=$address;    
            $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the address empty'];

		}else{
            $address=1; 
            $no_teamhierarchy[]=$address;    
		} 
		if($teamhierarchy[$k][5]=='' || $teamhierarchy[$k][5]=="null"){
	    	$email_id=0; 
	    	$no_teamhierarchy[]=$email_id;       
            $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the email id empty'];

        }else if (!filter_var($teamhierarchy[$k][5], FILTER_VALIDATE_EMAIL)) {
            $ret_arr=['code'=>'3','status'=>false,'message'=>'Please enter valid email id'];
        }else {
            $mail=$teamhierarchy[$k][5];          
                $qry_mob="SELECT idTeamMember FROM team_member_master WHERE emailId='$mail'";
                $result_mob=$this->adapter->query($qry_mob,array());
                $resultset_mob=$result_mob->toArray();
               
               if(!$resultset_mob){
                $email_id=1; 
            $no_teamhierarchy[]=$email_id;  

               }else{
               $email_id=0; 
            $no_teamhierarchy[]=$email_id;  
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Email id already exist'];  

               }
                 
		} 

        if($teamhierarchy[$k][4]=='' || $teamhierarchy[$k][4] =="null"){
	    	$landline_no=0;    
	    	 $no_teamhierarchy[]=$landline_no;     
            $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the landline no empty'];

		}else if(!is_numeric($teamhierarchy[$k][4])){
                $landline_no=0;  
                 $no_teamhierarchy[]=$landline_no;     
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Landline no numeric only'];  
        }else if((strlen($teamhierarchy[$k][4])<13) || (strlen($teamhierarchy[$k][4])>13)){
                $landline_no=0; 
                 $no_teamhierarchy[]=$landline_no;     
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please enter valid landline number'];  
        }else {
             $land=$teamhierarchy[$k][4];          
                $qry_mob="SELECT idTeamMember FROM team_member_master WHERE landline='$land'";
                $result_mob=$this->adapter->query($qry_mob,array());
                $resultset_mob=$result_mob->toArray();
               
               if(!$resultset_mob){
                 $landline_no=1; 
                 $no_teamhierarchy[]=$landline_no; 

               }else{
                $landline_no=0; 
                $no_teamhierarchy[]=$landline_no;  
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Landline no already exist'];  

               }
               
		} 
// $mobile= preg_match('/^[0-9]{10}+$/', $teamhierarchy[$k][3]);
/*print_r($mobile);exit;*/
        if($teamhierarchy[$k][3] =='' || $teamhierarchy[$k][3] == "null"){
	    	$mobile_no=0; 
	    	 $no_teamhierarchy[]=$mobile_no;      
            $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the mobile no empty'];

		}else if(!is_numeric($teamhierarchy[$k][3])){
                $mobile_no=0;  
                 $no_teamhierarchy[]=$mobile_no; 
             
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Mobile no numeric only'];  
       
        }else if((strlen($teamhierarchy[$k][3])<10) || (strlen($teamhierarchy[$k][3])>10)){
                $mobile_no=0; 
                 $no_teamhierarchy[]=$mobile_no;     
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please enter valid mobile number'];  
        }else {
            $mob=$teamhierarchy[$k][3];          
                $qry_mob="SELECT idTeamMember FROM team_member_master WHERE mobileno='$mob'";
                $result_mob=$this->adapter->query($qry_mob,array());
                $resultset_mob=$result_mob->toArray();
               
               if(!$resultset_mob){
                $mobile_no=1; 
                $no_teamhierarchy[]=$mobile_no;     

               }else{
                $mobile_no=0; 
                $no_teamhierarchy[]=$mobile_no;     
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Mobile no already exist'];  

               }
              
		}

		if($teamhierarchy[$k][2] =='' || $teamhierarchy[$k][2] =="null"){
            $designation=0; 
        	$ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the designation empty'];

        }else if($teamhierarchy[$k][2]!='' || $teamhierarchy[$k][2]!="null"){

            $designation_name =ltrim($teamhierarchy[$k][2]);
	        $qry1="SELECT idDesignation,name FROM designation WHERE name='$designation_name'";
         
			$result1=$this->adapter->query($qry1,array());
		    $resultset1=$result1->toArray();

		    if(!$resultset1){
      
	           $designation=0; 
	           $no_teamhierarchy[]=$designation;     

	         $ret_arr=['code'=>'3','status'=>false,'message'=>'Designation data mismatch'];

		    }else{
	            $designation=1; 
	            $no_teamhierarchy[]=$designation;     
		    	 
		    } 		
                 
        }


        if($teamhierarchy[$k][1] =='' || $teamhierarchy[$k][1] =="null"){

            $empolyee_name=0; 
            $no_teamhierarchy[]=$empolyee_name;        
            $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the employee name empty'];		
                 
        }else if($teamhierarchy[$k][1] !='' || $teamhierarchy[$k][1] !="null"){
        	$empolyee_name=1;
        	$no_teamhierarchy[]=$empolyee_name;      
        }

        if($teamhierarchy[$k][0] =='' || $teamhierarchy[$k][0] =="null"){

            $empolyee_id=0;   
            $no_teamhierarchy[]=$empolyee_id;       
            $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the employee id empty'];		
                 
        }
        /*else if(!is_numeric($teamhierarchy[$k][0])){
                $empolyee_id=0;  
                $no_teamhierarchy[]=$empolyee_id;     
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Employee id numeric only'];  

        }*/
        /*else if($teamhierarchy[$k][0]!='' || $teamhierarchy[$k][0]!="null"){
        	$empolyee_code=$teamhierarchy[$k][0];
        	$empolyee_id=1; 
        	$no_teamhierarchy[]=$empolyee_id;     
         
            $qry_list="SELECT code FROM team_member_master where code='$empolyee_code'";
           
            $result_list=$this->adapter->query($qry_list,array());
		    $resultset_list=$result_list->toArray();
            print_r($resultset_list);

		    if(!count($resultset_list){ 
		       $empolyee_id=1;     
	           $no_teamhierarchy[]=$empolyee_id;     
	         
		    }else{
	            $empolyee_id=1; 
	            $no_teamhierarchy[]=$empolyee_id;     
		    	 $ret_arr=['code'=>'3','status'=>false,'message'=>'Employee id already exist '];

		    } 	
 

       }  */      	
                
	}// close loop

if(count($no_teamhierarchy)!=0){
 	
    for($j=0; $j<count($no_teamhierarchy);$j++){ 
            $zero=0;
        if(in_array($zero,$no_teamhierarchy)){

            $check=0;
        }else{
            $check=1;

        }
                   
    }
}else{
	 $check=0;
	 $ret_arr=['code'=>'3','status'=>false,'message'=>'Excel data is empty'];
}

    if($check!=0){
	
		for($i=0; $i<count($teamhierarchy);$i++) {

            if($designation[$i][14]=="Active" || $designation[$i][14]=="active"){
                $status=1;
            }else if($designation[$i][14]=="Inactive" || $designation[$i][14]=="inactive"){

                $status=2;
            }

            $designation_name =ltrim($teamhierarchy[$i][2]);
	        $qry1="SELECT idDesignation,name FROM designation WHERE name='$designation_name'";

			$result1=$this->adapter->query($qry1,array());
		    $resultset1=$result1->toArray();

            $maingroup_name =ltrim($teamhierarchy[$i][9]);
	        $qry2="SELECT idMainGroup FROM maingroup_master WHERE mainGroupName='$maingroup_name'";
			$result2=$this->adapter->query($qry2,array());
		    $resultset2=$result2->toArray();

		    $subsidiary_name =ltrim($teamhierarchy[$i][10]);
	        $qry3="SELECT idSubsidaryGroup FROM subsidarygroup_master WHERE subsidaryName='$subsidiary_name'";
			$result3=$this->adapter->query($qry3,array());
		    $resultset3=$result3->toArray();

		    $reporting_emp =ltrim($teamhierarchy[$i][8]);
            if($reporting_emp!='' && $reporting_emp!=null){
            $qry4="SELECT idTeamMember FROM team_member_master WHERE name='$reporting_emp' AND isRepManager=1";
            $result4=$this->adapter->query($qry4,array());
            $resultset4=$result4->toArray();
            $final_reportingto=$resultset4[0]['idTeamMember'];
            }else{
             $final_reportingto=0;
            }
            
            $sales =ltrim($teamhierarchy[$i][13]);
            $qrysales="SELECT idSaleshierarchy FROM sales_hierarchy WHERE saleshierarchyName='$sales'";
            $resultsales=$this->adapter->query($qrysales,array());
            $resultsetsales=$resultsales->toArray();

		    $segment_name =$teamhierarchy[$i][12];

            if($segment_name=='Consumers'){
            	$segment_type=1;
            	$no_teamhierarchy[]=$segment_type;
            }else if($segment_name=='Business'){
            	$segment_type=2;
            	$no_teamhierarchy[]=$segment_type;
            }else if($segment_name=='Consumers and Business'){
            	$segment_type=3;   	
            	$no_teamhierarchy[]=$segment_type;
            }

            $proposition_type =$teamhierarchy[$i][11];

            if($proposition_type=='Products'){
            	$proposition=1;
            	 $no_teamhierarchy[]=$proposition;
            }else if($proposition_type=='Services'){
            	$proposition=2;
            	 $no_teamhierarchy[]=$proposition;
            }else if($proposition_type=='Products and services'){
            	$proposition=3;   
            	 $no_teamhierarchy[]=$proposition;	
            }

            if($teamhierarchy[$i][7]=='Yes' || $teamhierarchy[$i][7]=='yes'){
	                $manager=1;   
	        }else if($teamhierarchy[$i][7]=='No' || $teamhierarchy[$i][7]=='no'){
	                $manager=2;  
	        }

         //   print_r($teamhierarchy);
            $cd=ltrim($teamhierarchy[$i][0]);
            $nm=ltrim($teamhierarchy[$i][1]);
            $des=ltrim($teamhierarchy[$i][2]);
            $mbl=ltrim($teamhierarchy[$i][3]);
            $ld=ltrim($teamhierarchy[$i][4]);
            $em=ltrim($teamhierarchy[$i][5]);
            $ad=ltrim($teamhierarchy[$i][6]);
            $man=ltrim($teamhierarchy[$i][7]);
            $rpto=ltrim($teamhierarchy[$i][8]);
            $main=ltrim($teamhierarchy[$i][9]);
            $subs=ltrim($teamhierarchy[$i][10]);
            $protype=ltrim($teamhierarchy[$i][11]);
            $segtype=ltrim($teamhierarchy[$i][12]);

			/*$qry="SELECT * FROM team_member_master where code='$cd' and name='$nm' and mobileno='$mbl' and landline='$ld' and  emailId='$em' and address='$ad' and designation='$des' and isRepManager='$manager' and idMainGroup='$main' and idSubsidaryGroup='$subs' and proposition='$proposition' and segment='$segment_type'";*/
            $qry="SELECT * FROM team_member_master where code='$cd'";
			$result=$this->adapter->query($qry,array());
          //  echo $qry;
			$resultset=$result->toArray();
          //  print_r($resultset);

					if(!$resultset){
						$this->adapter->getDriver()->getConnection()->beginTransaction();
						try { 
							$data['code']=$cd;
                            $data['name']=$nm;
                            $data['mobileno']=$mbl;
                            $data['landline']=$ld;
                            $data['emailId']=$em;
                            $data['address']=$ad;
                            $data['designation']=$resultset1[0]['idDesignation'];
                            $data['photo']='0';
                            $data['isRepManager']=$manager;
                            $data['reportingTo']=$final_reportingto;
                            $data['reportingTo2']=0;
                            $data['reportingTo3']=0;    
                            $data['idMainGroup']=$resultset2[0]['idMainGroup'];
                            $data['idSubsidaryGroup']=$resultset3[0]['idSubsidaryGroup'];
                            $data['idSaleshierarchy']=$resultsetsales[0]['idSaleshierarchy'];
                            $data['proposition']=$proposition;
                            $data['segment']= $segment_type;
                            $data['status']= $status;
                            $data['created_at']=date('Y-m-d H:i:s');
                            $data['created_by']=1;
                            $data['updated_at']=date('Y-m-d H:i:s');
                            $data['updated_by']=1;
                            
							$insert=new Insert('team_member_master');
							$insert->values($data);
							$statement=$this->adapter->createStatement();
							$insert->prepareStatement($this->adapter, $statement);
							$insertresult=$statement->execute();
							$insert_value += $insert_count+1;
							$this->adapter->getDriver()->getConnection()->commit();
			         	} catch(\Exception $e) {
							$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
							$this->adapter->getDriver()->getConnection()->rollBack();
						}
					} else {
						$reject_value += $reject_count+1;

					}
	        }

		if($insert_value!=0 && $reject_value==0){

              $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
        }else if($insert_value ==0 && $reject_value !=0){

        	 $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists data'];

        }else if($insert_value!=0 && $reject_value!=0){

        $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists  '.$reject_value.'Uploaded  '.$insert_value];
        }

    }

			} else {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please verify the csv file'];
			}
			
		}
		return $ret_arr;

	} // close func

	public function uploadproductstatus($param) {

		ini_set('display_errors',true);
		$Uploads_dir = 'public/uploads/csv';
		$tmp_name=$_FILES["myFile"]["tmp_name"]; 
		$name = basename($_FILES["myFile"]["name"]); 
		$imageName = rand(6,66666).'.'. pathinfo($_FILES["myFile"]['name'],PATHINFO_EXTENSION);
    	if(move_uploaded_file($tmp_name, "$Uploads_dir/$imageName")) {
			$r="public/uploads/csv/$imageName";
			$file = fopen($r, "r",FILE_SKIP_EMPTY_LINES);
			$emapData = fgetcsv($file, 10000, ","); 
				$row=0;
				$size=sizeof($emapData);

				if($size=='2' && $emapData !=null) {
				$productstatus=array();
				$no_productstatus=array();
				while (($record = fgetcsv($file)) !== FALSE) {
					$row++;
					array_push($productstatus,$record);
				}

 	    $insert_count=0;
        $reject_count=0;
        $reject_value=0; 
        $insert_value=0; 

	 for($k=0; $k<count($productstatus);$k++) {

	 	if($productstatus[$k][1]=='' || $productstatus[$k][1]=="null"){
                $status=0;  
                $no_productstatus[]= $status; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status empty'];    
        	}else if($productstatus[$k][1]=="Active" || $productstatus[$k][1]=="active"){

                $status=1;
                $no_productstatus[]= $status;
        	}else if($productstatus[$k][1]=="Inactive" || $productstatus[$k][1]=="inactive"){

        		$status=2;
        		$no_productstatus[]= $status;
            }else{
                $status=0;  
                $no_productstatus[]= $status;   
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status data'];    
        	}

        if($productstatus[$k][0]=='' || $productstatus[$k][0]=="null"){
		    	$product=0; 
		    	$no_productstatus[]= $product;   
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the product empty'];

		    }else if($productstatus[$k][1]!='' || $productstatus[$k][1]!="null"){
                $product=1; 
                $no_productstatus[]= $product;   
                 
        }
                
	}  // close loop



if(count($no_productstatus)!=0){
 	
    for($j=0; $j<count($no_productstatus);$j++){ 
            $zero=0;
        if(in_array($zero,$no_productstatus)){

            $check=0;
        }else{
            $check=1;

        }
                   
    }
}else{
	 $check=0;
	 $ret_arr=['code'=>'3','status'=>false,'message'=>'Excel data is empty'];
}


	  
 if($check!=0){ 

	for($i=0; $i<count($productstatus);$i++) {
	
		$qry="SELECT idProductStatus FROM product_status where productStatus=?";
		$result=$this->adapter->query($qry,array($productstatus[$i][0]));
		$resultset=$result->toArray();

		if(!$resultset){
			$this->adapter->getDriver()->getConnection()->beginTransaction();
			try {
	    if($productstatus[$i][1]=="Active" || $productstatus[$i][1]=="active"){
            $status=1;
    	}else if($productstatus[$i][1]=="Inactive" || $productstatus[$i][1]=="inactive"){

    		$status=2;
        }						
							$data['productStatus']=$productstatus[$i][0];
							$data['status']=$status;
							$data['created_at']=date('Y-m-d H:i:s');
							$data['created_by']=1;
							$data['updated_at']=date('Y-m-d H:i:s');
							$data['updated_by']=1;
							$insert=new Insert('product_status');
							$insert->values($data);
							$statement=$this->adapter->createStatement();
							$insert->prepareStatement($this->adapter, $statement);
							$insertresult=$statement->execute();
							$insert_value +=$insert_count+1;
					    //    $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
							$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
							$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
							$this->adapter->getDriver()->getConnection()->rollBack();
						}
					} else {

						$reject_value += $reject_count+1;
						//$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
				
					}

                }

        if($insert_value!=0 && $reject_value==0){

              $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
        }else if($insert_value ==0 && $reject_value !=0){

        	 $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists data'];

        }else if($insert_value!=0 && $reject_value!=0){

        $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists  '.$reject_value.'Uploaded  '.$insert_value];
        }

		
				}
			} else {
				   $ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please verify the csv file'];
			}

			
		}

		return $ret_arr;

	} // close func

	public function uploadproductcontent($param) {

		ini_set('display_errors',true);
		$Uploads_dir = 'public/uploads/csv';
		$tmp_name=$_FILES["myFile"]["tmp_name"]; 
		$name = basename($_FILES["myFile"]["name"]); 
		$imageName = rand(6,66666).'.'. pathinfo($_FILES["myFile"]['name'],PATHINFO_EXTENSION);
    	if(move_uploaded_file($tmp_name, "$Uploads_dir/$imageName")) {
			$r="public/uploads/csv/$imageName";
			$file = fopen($r, "r",FILE_SKIP_EMPTY_LINES);
			$emapData = fgetcsv($file, 10000, ","); 
				$row=0;
				$size=sizeof($emapData);

				if($size=='2' && $emapData !=null) {
				$productcontent=array();
				$no_productcontent=array();
				while (($record = fgetcsv($file)) !== FALSE) {
					$row++;
					array_push($productcontent,$record);
				}

 	    $insert_count=0;
        $reject_count=0;
        $reject_value=0; 
        $insert_value=0;  

	 for($k=0; $k<count($productcontent);$k++) {

	 	if($productcontent[$k][1]=='' || $productcontent[$k][1]=="null"){
                $status=0; 
                $no_productcontent[]=$status;   
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status empty'];    
        	}else if($productcontent[$k][1]=="Active" || $productcontent[$k][1]=="active"){
                $status=1;
                 $no_productcontent[]=$status;   
        	}else if($productcontent[$k][1]=="Inactive" || $productcontent[$k][1]=="inactive"){

        		$status=2;
        		 $no_productcontent[]=$status;   
            }else{
                $status=0;  
                 $no_productcontent[]=$status;      
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status data'];    
        	}

        if($productcontent[$k][0]=='' || $productcontent[$k][0]=="null"){
		    	$content=0;   
		    	 $no_productcontent[]=$content;    
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the product content empty'];

		    }else if($productcontent[$k][1]!='' || $productcontent[$k][1]!="null"){
                $content=1;  
                 $no_productcontent[]=$content;     
                 
        }

        	
                
	  }

	  if(count($no_productcontent)!= 0){

	    for($j=0; $j<count($no_productcontent);$j++){ 
            $zero=0;
        if(in_array($zero,$no_productcontent)){

           $check=0;
        }else{
           $check=1;

        }
                   
    }

}else{

	  $check=0;
	  $ret_arr=['code'=>'3','status'=>false,'message'=>'Excel data is empty'];
}

  
 if($check!=0){

	for($i=0; $i<count($productcontent);$i++) {
	
			$qry="SELECT idProductContent FROM product_content where productContent=?";
			$result=$this->adapter->query($qry,array($productcontent[$i][0]));
			$resultset=$result->toArray();

			if(!$resultset){
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {

			if($productcontent[$i][1]=="Active" || $productcontent[$i][1]=="active"){
                $status=1;
        	}else if($productcontent[$i][1]=="Inactive" || $productcontent[$i][1]=="inactive"){
        		$status=2;
            }
						
							$data['productContent']=$productcontent[$i][0];
							$data['status']=$status;
							$data['created_at']=date('Y-m-d H:i:s');
							$data['created_by']=1;
							$data['updated_at']=date('Y-m-d H:i:s');
							$data['updated_by']=1;
							$insert=new Insert('product_content');
							$insert->values($data);
							$statement=$this->adapter->createStatement();
							$insert->prepareStatement($this->adapter, $statement);
							$insertresult=$statement->execute();
							$insert_value +=$insert_count+1;
				
							$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
							$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
							$this->adapter->getDriver()->getConnection()->rollBack();
						}
					} else {

						$reject_value += $reject_count+1;
				
					}

                }

        if($insert_value!=0 && $reject_value==0){

              $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
        }else if($insert_value ==0 && $reject_value !=0){

        	 $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists data'];

        }else if($insert_value!=0 && $reject_value!=0){

        $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists  '.$reject_value.'Uploaded  '.$insert_value];
        }

		
				}
			} else {
				   $ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please verify the csv file'];
			}

			
		}

		return $ret_arr;

	} // close func


	public function uploadpackagetype($param) {

		ini_set('display_errors',true);
		$Uploads_dir = 'public/uploads/csv';
		$tmp_name=$_FILES["myFile"]["tmp_name"]; 
		$name = basename($_FILES["myFile"]["name"]); 
		$imageName = rand(6,66666).'.'. pathinfo($_FILES["myFile"]['name'],PATHINFO_EXTENSION);
    	if(move_uploaded_file($tmp_name, "$Uploads_dir/$imageName")) {
			$r="public/uploads/csv/$imageName";
			$file = fopen($r, "r",FILE_SKIP_EMPTY_LINES);
			$emapData = fgetcsv($file, 10000, ","); 
				$row=0;
				$size=sizeof($emapData);

				if($size=='2' && $emapData !=null) {
				$packagetype=array();
				$no_packagetype=array();
				while (($record = fgetcsv($file)) !== FALSE) {
					$row++;
					array_push($packagetype,$record);
				}


 	    $insert_count=0;
        $reject_count=0;
        $reject_value=0; 
        $insert_value=0;  

	 for($k=0; $k<count($packagetype);$k++) {

	 	if($packagetype[$k][1]=='' || $packagetype[$k][1]=="null"){
                $status=0;  
                $no_packagetype[]=$status;  
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status empty'];    
        	}else if($packagetype[$k][1]=="Active" || $packagetype[$k][1]=="active"){
                $status=1;
                $no_packagetype[]=$status;  
        	}else if($packagetype[$k][1]=="Inactive" || $packagetype[$k][1]=="inactive"){

        		$status=2;
        		$no_packagetype[]=$status;  
            }else{
                $status=0;   
                $no_packagetype[]=$status;    
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status data'];    
        	}

        if($packagetype[$k][0]=='' || $packagetype[$k][0]=="null"){
		    	$package=0; 
		    	$no_packagetype[]=$package;     
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the package type empty'];

		    }else if($packagetype[$k][1]!='' || $packagetype[$k][1]!="null"){
                $package=1; 
                $no_packagetype[]=$package;      
                 
        }     	
                
	  }

if(count($no_packagetype)!= 0){

	    for($j=0; $j<count($no_packagetype);$j++){ 
            $zero=0;
        if(in_array($zero,$no_packagetype)){

           $check=0;
        }else{
           $check=1;

        }
                   
    }

}else{

	  $check=0;
	  $ret_arr=['code'=>'3','status'=>false,'message'=>'Excel data is empty'];
}
  
 if($check!=0){

	for($i=0; $i<count($packagetype);$i++) {
	
	$qry="SELECT idSubPackaging FROM sub_packaging where subpackname=?";
	$result=$this->adapter->query($qry,array($packagetype[$i][0]));
	$resultset=$result->toArray();

			if(!$resultset){
						$this->adapter->getDriver()->getConnection()->beginTransaction();
						try {

				if($packagetype[$i][1]=="Active" || $packagetype[$i][1]=="active"){
	                $status=1;
	        	}else if($packagetype[$i][1]=="Inactive" || $packagetype[$i][1]=="inactive"){

	        		$status=2;
	            }
						
							$data['subpackname']=$packagetype[$i][0];
							$data['status']=$status;
							$data['created_at']=date('Y-m-d H:i:s');
							$data['created_by']=1;
							$data['updated_at']=date('Y-m-d H:i:s');
							$data['updated_by']=1;
							$insert=new Insert('sub_packaging');
							$insert->values($data);
							$statement=$this->adapter->createStatement();
							$insert->prepareStatement($this->adapter, $statement);
							$insertresult=$statement->execute();
							$insert_value +=$insert_count+1;
							$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
							$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
							$this->adapter->getDriver()->getConnection()->rollBack();
						}
					} else {
						$reject_value += $reject_count+1;
				
					}

                }

        if($insert_value!=0 && $reject_value==0){

              $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
        }else if($insert_value ==0 && $reject_value !=0){

        	 $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists data'];

        }else if($insert_value!=0 && $reject_value!=0){

        $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists  '.$reject_value.'Uploaded  '.$insert_value];
        }

		
				}
			} else {
				   $ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please verify the csv file'];
			}

			
		}

		return $ret_arr;

	} // close func

	public function uploadprimarypackage($param) {

		ini_set('display_errors',true);
		$Uploads_dir = 'public/uploads/csv';
		$tmp_name=$_FILES["myFile"]["tmp_name"]; 
		$name = basename($_FILES["myFile"]["name"]); 
		$imageName = rand(6,66666).'.'. pathinfo($_FILES["myFile"]['name'],PATHINFO_EXTENSION);
    	if(move_uploaded_file($tmp_name, "$Uploads_dir/$imageName")) {
			$r="public/uploads/csv/$imageName";
			$file = fopen($r, "r",FILE_SKIP_EMPTY_LINES);
			$emapData = fgetcsv($file, 10000, ","); 
				$row=0;
				$size=sizeof($emapData);

				if($size=='3' && $emapData !=null) {
				$primary=array();
				$no_primary=array();
				while (($record = fgetcsv($file)) !== FALSE) {
					$row++;
					array_push($primary,$record);
				}


 	    $insert_count=0;
        $reject_count=0;
        $reject_value=0; 
        $insert_value=0;  

	 for($k=0; $k<count($primary);$k++) {

	 	if($primary[$k][2]=='' || $primary[$k][2]=="null"){
                $status=0;
                $no_primary[]=$status;    
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status empty'];    
        	}else if($primary[$k][2]=="Active" || $primary[$k][2]=="active"){
                $status=1;
                 $no_primary[]=$status;    
        	}else if($primary[$k][2]=="Inactive" || $primary[$k][2]=="inactive"){

        		$status=2;
        		 $no_primary[]=$status;    
            }else{
                $status=0; 
                 $no_primary[]=$status;        
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status data'];    
        	}

          if($primary[$k][1]=='' || $primary[$k][1]=="null"){
            $packagetype=0; 
             $no_primary[]=$packagetype;  
        	$ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the package type empty'];
           }else if($primary[$k][1]!='' || $primary[$k][1]!="null"){

            $package =$primary[$k][1];
	        $qry1="SELECT idSubPackaging FROM sub_packaging WHERE subpackname='$package' AND status!='2'";
			$result1=$this->adapter->query($qry1,array());
		    $resultset1=$result1->toArray();
		    if(!$resultset1){
      
	           $packagetype=0; 
	           $no_primary[]=$packagetype;  

	         $ret_arr=['code'=>'3','status'=>false,'message'=>'Package type data mismatch'];

		    }else if($resultset1){
	            $packagetype=1; 
	            $no_primary[]=$packagetype;  
		    	 
		    } 		
                 
        }

        if($primary[$k][0]=='' || $primary[$k][0]=="null"){
		    	$primary_package=0; 
		    	 $no_primary[]=$primary_package;     
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the primary package empty'];

		}if($primary[$k][0]!='' || $primary[$k][0]!="null"){
                $primary_package=1;   
                $no_primary[]=$primary_package;   
                 
        }   	
                
	}


	if(count($no_primary)!= 0){

	    for($j=0; $j<count($no_primary);$j++){ 
            $zero=0;
        if(in_array($zero,$no_primary)){

           $check=0;
        }else{
           $check=1;

        }
                   
    }

}else{

	  $check=0;
	  $ret_arr=['code'=>'3','status'=>false,'message'=>'Excel data is empty'];
}

 if($check!=0){

	for($i=0; $i<count($primary);$i++) {

    $package =$primary[$i][1];
    $qry1="SELECT idSubPackaging FROM sub_packaging WHERE subpackname='$package' AND status!='2'";
	$result1=$this->adapter->query($qry1,array());
    $resultset1=$result1->toArray();
	
	$qry="SELECT idPrimaryPackaging FROM primary_packaging where primarypackname=?";
	$result=$this->adapter->query($qry,array($primary[$i][0]));
	$resultset=$result->toArray();

			if(!$resultset){
						$this->adapter->getDriver()->getConnection()->beginTransaction();
						try {

				if($primary[$i][2]=="Active" || $primary[$i][2]=="active"){
	                $status=1;
	        	}else if($primary[$i][2]=="Inactive" || $primary[$i][2]=="inactive"){

	        		$status=2;
	            }
						
							$data['primarypackname']=$primary[$i][0];
							$data['idSubPackaging']=$resultset1[0]['idSubPackaging'];
							$data['status']=$status;
							$data['created_at']=date('Y-m-d H:i:s');
							$data['created_by']=1;
							$data['updated_at']=date('Y-m-d H:i:s');
							$data['updated_by']=1;
							$insert=new Insert('primary_packaging');
							$insert->values($data);
							$statement=$this->adapter->createStatement();
							$insert->prepareStatement($this->adapter, $statement);
							$insertresult=$statement->execute();
							$insert_value +=$insert_count+1;
							$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
							$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
							$this->adapter->getDriver()->getConnection()->rollBack();
						}
					} else {

						$reject_value += $reject_count+1;
						//$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
				
					}

                }

        if($insert_value!=0 && $reject_value==0){

              $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
        }else if($insert_value ==0 && $reject_value !=0){

        	 $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists data'];

        }else if($insert_value!=0 && $reject_value!=0){

        $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists  '.$reject_value.'Uploaded  '.$insert_value];
        }

		
				}
			} else {
				   $ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please verify the csv file'];
			}

			
		}

		return $ret_arr;

	}  // close func 

	public function uploadsecondarypackage($param) {

		ini_set('display_errors',true);
		$Uploads_dir = 'public/uploads/csv';
		$tmp_name=$_FILES["myFile"]["tmp_name"]; 
		$name = basename($_FILES["myFile"]["name"]); 
		$imageName = rand(6,66666).'.'. pathinfo($_FILES["myFile"]['name'],PATHINFO_EXTENSION);
    	if(move_uploaded_file($tmp_name, "$Uploads_dir/$imageName")) {
			$r="public/uploads/csv/$imageName";
			$file = fopen($r, "r",FILE_SKIP_EMPTY_LINES);
			$emapData = fgetcsv($file, 10000, ","); 
				$row=0;
				$size=sizeof($emapData);

				if($size=='4' && $emapData !=null) {
				$secondary=array();
				$no_secondary=array();
				while (($record = fgetcsv($file)) !== FALSE) {
					$row++;
					array_push($secondary,$record);
				}
            
 	    $insert_count=0;
        $reject_count=0;
        $reject_value=0; 
        $insert_value=0;  

	for($k=0; $k<count($secondary);$k++){

	 	if($secondary[$k][3]=='' || $secondary[$k][3]=="null"){
                $status=0;  
                $no_secondary[]= $status; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status empty'];    
        	}else if($secondary[$k][3]=="Active" || $secondary[$k][3]=="active"){
                $status=1;
                 $no_secondary[]= $status; 
        	}else if($secondary[$k][3]=="Inactive" || $secondary[$k][3]=="inactive"){

        		$status=2;
        		 $no_secondary[]= $status; 
            }else{
                $status=0;  
                 $no_secondary[]= $status;    
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status data'];    
        	}

         if($secondary[$k][2]=='' || $secondary[$k][2]=="null"){
             $packagetype=0;
             $no_secondary[]= $packagetype;  
        	$ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the package type empty'];
           }else if($secondary[$k][2]!='' || $secondary[$k][2]!="null"){

            $package =$secondary[$k][2];
	        $qry2="SELECT idSubPackaging FROM sub_packaging WHERE subpackname='$package' AND status!='2'";
			$result2=$this->adapter->query($qry2,array());
		    $resultset2=$result2->toArray();

		    if(!$resultset2){
      
	          $packagetype=0;
	          $no_secondary[]= $packagetype;   

	         $ret_arr=['code'=>'3','status'=>false,'message'=>'Package type data mismatch'];

		    }else if($resultset2){
	           $packagetype=1; 
	           $no_secondary[]= $packagetype;  
		    	 
		    } 		
                 
        }

        if ($secondary[$k][1]=='' || $secondary[$k][1]=="null"){
            $primary_package=0; 
            $no_secondary[]= $primary_package;  
        	$ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the primary package empty'];
           }else if($secondary[$k][1]!='' || $secondary[$k][1]!="null"){

            $primary =$secondary[$k][1];
	        $qry1="SELECT idPrimaryPackaging FROM primary_packaging WHERE primarypackname='$primary' AND status!='2'";
			$result1=$this->adapter->query($qry1,array());
		    $resultset1=$result1->toArray();

		    if(!$resultset1){
      
	          $primary_package=0;
	          $no_secondary[]= $primary_package;   

	         $ret_arr=['code'=>'3','status'=>false,'message'=>'Primary package data mismatch'];

		    }else if($resultset1){
	           $primary_package=1; 
	           $no_secondary[]= $primary_package;  
		    	 
		    } 		
                 
        }

        if($secondary[$k][0] =='' || $secondary[$k][0] =="null"){
		    	$secondary_package=0;
		    	$no_secondary[]= $secondary_package;      
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the secondary package empty'];

		}if($secondary[$k][0] !='' || $secondary[$k][0] !="null"){
                $secondary_package=1;
                $no_secondary[]= $secondary_package;           
                 
        }   	
                
	}


if(count($no_secondary)!= 0){

	    for($j=0; $j<count($no_secondary);$j++){ 
            $zero=0;
        if(in_array($zero,$no_secondary)){

           $check=0;
        }else{
           $check=1;

        }
                   
    }

}else{

	  $check=0;
	  $ret_arr=['code'=>'3','status'=>false,'message'=>'Excel data is empty'];
}

 if($check!=0){

	for($i=0; $i<count($secondary);$i++) {
	

	$primary =$secondary[$i][1];
    $qry1="SELECT idPrimaryPackaging FROM primary_packaging WHERE primarypackname='$primary' AND status!='2'";
	$result1=$this->adapter->query($qry1,array());
    $resultset1=$result1->toArray();

    $package =$secondary[$i][2];
    $qry2="SELECT idSubPackaging FROM sub_packaging WHERE subpackname='$package' AND status!='2'";
	$result2=$this->adapter->query($qry2,array());
    $resultset2=$result2->toArray();

	$qry="SELECT idPrimaryPackaging FROM secondary_packaging where idPrimaryPackaging=? AND secondarypackname=? AND idSubPackaging=?";
	$result=$this->adapter->query($qry,array($resultset1[0]['idPrimaryPackaging'],$secondary[$i][0],$resultset2[0]['idSubPackaging']));
	$resultset=$result->toArray();

			if(!$resultset){
						$this->adapter->getDriver()->getConnection()->beginTransaction();
						try {

				if($secondary[$i][2]=="Active" || $secondary[$i][2]=="active"){
	                $status=1;
	        	}else if($secondary[$i][2]=="Inactive" || $secondary[$i][2]=="inactive"){

	        		$status=2;
	            }					
							$data['idPrimaryPackaging']=$resultset1[0]['idPrimaryPackaging'];
							$data['secondarypackname']=$secondary[$i][0];
							$data['idSubPackaging']=$resultset2[0]['idSubPackaging'];
							$data['status']=$status;
							$data['created_at']=date('Y-m-d H:i:s');
							$data['created_by']=1;
							$data['updated_at']=date('Y-m-d H:i:s');
							$data['updated_by']=1;
							$insert=new Insert('secondary_packaging');
							$insert->values($data);
							$statement=$this->adapter->createStatement();
							$insert->prepareStatement($this->adapter, $statement);
							$insertresult=$statement->execute();
							$insert_value +=$insert_count+1;
					    //    $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
							$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
							$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
							$this->adapter->getDriver()->getConnection()->rollBack();
						}
					} else {

						$reject_value += $reject_count+1;
						//$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
				
					}

                }

        if($insert_value!=0 && $reject_value==0){

        $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
        }else if($insert_value ==0 && $reject_value !=0){

        $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists data'];

        }else if($insert_value!=0 && $reject_value!=0){

       $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists  '.$reject_value.'Uploaded  '.$insert_value];
        }

		
				}
			} else {
				   $ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please verify the csv file'];
			}

			
		}

		return $ret_arr;

	}  // close func 

public function uploadvehicle($param){

		ini_set('display_errors',true);
		$Uploads_dir = 'public/uploads/csv';
		$tmp_name=$_FILES["myFile"]["tmp_name"]; 
		$name = basename($_FILES["myFile"]["name"]); 
		$imageName = rand(6,66666).'.'. pathinfo($_FILES["myFile"]['name'],PATHINFO_EXTENSION);
    	if(move_uploaded_file($tmp_name, "$Uploads_dir/$imageName")) {
			$r="public/uploads/csv/$imageName";
			$file = fopen($r, "r",FILE_SKIP_EMPTY_LINES);
			$emapData = fgetcsv($file, 10000, ","); 
				$row=0;
				$size=sizeof($emapData);

				if($size=='5' && $emapData !=null) {
				$vehicle=array();
				$no_vehicle=array();
				while (($record = fgetcsv($file)) !== FALSE) {
					$row++;
					array_push($vehicle,$record);
				}

 	    $insert_count=0;
        $reject_count=0;
        $reject_value=0; 
        $insert_value=0;  


	for($k=0; $k<count($vehicle);$k++){

	 	if($vehicle[$k][4]=='' || $vehicle[$k][4]=="null"){
                $status=0;
                $no_vehicle[]=$status;    
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status empty'];    
        	}else if($vehicle[$k][4]=="Active" || $vehicle[$k][4]=="active"){
                $status=1;
                $no_vehicle[]=$status;   
        	}else if($vehicle[$k][4]=="Inactive" || $vehicle[$k][4]=="inactive"){

        		$status=2;
        		$no_vehicle[]=$status;   
            }else{
                $status=0;
                $no_vehicle[]=$status;        
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status data'];    
        	}

        	if($vehicle[$k][3]=='' || $vehicle[$k][3]=="null"){
	            $minimum=0;    
	            $no_vehicle[]=$minimum;   
	            $ret_arr=['code'=>'3','status'=>false,'message'=>'Minimum charge is empty'];    
	    	}else if(!is_numeric($vehicle[$k][3])){
	            $minimum=0;
	            $no_vehicle[]=$minimum;     
	            $ret_arr=['code'=>'3','status'=>false,'message'=>'Minimum charge allow to numeric only'];  

	    	}else {
	            $minimum=1; 
	            $no_vehicle[]=$minimum;       
	          
	    	}  


	        if($vehicle[$k][2]=='' || $vehicle[$k][2]=="null"){
	            $kilometer=0;   
	            $no_vehicle[]=$kilometer;    
	            $ret_arr=['code'=>'3','status'=>false,'message'=>'Per kilometer is empty'];    
	    	}else if(!is_numeric($vehicle[$k][2])){
	            $kilometer=0;  
	            $no_vehicle[]=$kilometer;  
	            $ret_arr=['code'=>'3','status'=>false,'message'=>'Per kilometer allow to numeric only'];  

	    	}else {
	            $kilometer=1;
	            $no_vehicle[]=$kilometer;       
	          
	    	} 

	       if($vehicle[$k][1]=='' || $vehicle[$k][1]=="null"){
	            $capacity=0; 
	            $no_vehicle[]=$capacity;     
	            $ret_arr=['code'=>'3','status'=>false,'message'=>'Capacity is empty'];    
	    	}else if(!is_numeric($vehicle[$k][1])){
	            $capacity=0; 
	            $no_vehicle[]=$capacity;  
	            $ret_arr=['code'=>'3','status'=>false,'message'=>'Capacity allow to numeric only'];  

	    	}else {
	            $capacity=1;
	            $no_vehicle[]=$capacity;      
	          
	    	}    

	        if($vehicle[$k][0]=='' || $vehicle[$k][0]=="null"){
			    	$vehicle_name=0; 
			    	$no_vehicle[]=$vehicle_name;    
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the vehicle name empty'];

			}if($vehicle[$k][0]!='' || $vehicle[$k][0]!="null"){
	                $vehicle_name=1;  
	                $no_vehicle[]=$vehicle_name;      
	                 
	        }   	
                
	}

if(count($no_vehicle)!= 0){

	    for($j=0; $j<count($no_vehicle);$j++){ 
            $zero=0;
        if(in_array($zero,$no_vehicle)){

           $check=0;
        }else{
           $check=1;

        }
                   
    }

}else{

	  $check=0;
	  $ret_arr=['code'=>'3','status'=>false,'message'=>'Excel data is empty'];
}

 if($check!=0){

	for($i=0; $i<count($vehicle);$i++) {

	
	$qry="SELECT idVehicle FROM vehicle_master where vehicleName=? AND vehicleCapacity=? AND vehiclePerKm=? AND vehicleMinCharge=?";
	$result=$this->adapter->query($qry,array($vehicle[$i][0],$vehicle[$i][1],$vehicle[$i][2],$vehicle[$i][3]));
	$resultset=$result->toArray();

			if(!$resultset){
						$this->adapter->getDriver()->getConnection()->beginTransaction();
						try {

				if($vehicle[$i][3]=="Active" || $vehicle[$i][3]=="active"){
	                $status=1;
	        	}else if($vehicle[$i][3]=="Inactive" || $vehicle[$i][3]=="inactive"){

	        		$status=2;
	            }
						
							$data['vehicleName']=$vehicle[$i][0];
							$data['vehicleCapacity']=$vehicle[$i][1];
							$data['vehiclePerKm']=$vehicle[$i][2];
							$data['vehicleMinCharge']=$vehicle[$i][3];
							$data['status']=$status;
							$data['created_at']=date('Y-m-d H:i:s');
							$data['created_by']=1;
							$data['updated_at']=date('Y-m-d H:i:s');
							$data['updated_by']=1;
							$insert=new Insert('vehicle_master');
							$insert->values($data);
							$statement=$this->adapter->createStatement();
							$insert->prepareStatement($this->adapter, $statement);
							$insertresult=$statement->execute();
							$insert_value +=$insert_count+1;
					    //    $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
							$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
							$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
							$this->adapter->getDriver()->getConnection()->rollBack();
						}
					} else {

						$reject_value += $reject_count+1;
						//$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
				
					}

                }

        if($insert_value!=0 && $reject_value==0){

              $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
        }else if($insert_value ==0 && $reject_value !=0){

        	 $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];

        }else if($insert_value!=0 && $reject_value!=0){

        $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists  '.$reject_value.'Uploaded  '.$insert_value];
        }

		
	}
			} else {
				   $ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please verify the csv file'];
			}

			
		}

		return $ret_arr;
	} // close func 

	public function uploadwarehouse($param) {
    $userData=$param->userData;
    $userid=$param->userid;
    $usertype=$userData['user_type'];
    $idCustomer=$userData['idCustomer'];
		ini_set('display_errors',true);
		$Uploads_dir = 'public/uploads/csv';
		$tmp_name=$_FILES["myFile"]["tmp_name"]; 
		$name = basename($_FILES["myFile"]["name"]); 
		$imageName = rand(6,66666).'.'. pathinfo($_FILES["myFile"]['name'],PATHINFO_EXTENSION);
    	if(move_uploaded_file($tmp_name, "$Uploads_dir/$imageName")) {
			$r="public/uploads/csv/$imageName";
			$file = fopen($r, "r",FILE_SKIP_EMPTY_LINES);
			$emapData = fgetcsv($file, 10000, ","); 
				$row=0;
				$size=sizeof($emapData);

				if($size=='15' && $emapData !=null) {
				$warehouse=array();
				$no_warehouse=array();
				
				while (($record = fgetcsv($file)) !== FALSE) {
					$row++;
					array_push($warehouse,$record);
				}

	    $territory1=0;
	    $territory2=0;
	    $territory3=0;
	    $territory4=0;
	    $territory5=0;
	    $territory6=0;
	    $territory7=0;
	    $territory8=0;
        $territory9=0;
	    $territory10=0;

        $ter_map_value0=0;
	    $ter_map_value1=0;
	    $ter_map_value2=0;
	    $ter_map_value3=0;
	    $ter_map_value4=0;
	    $ter_map_value5=0;
	    $ter_map_value6=0;
	    $ter_map_value7=0;
	    $ter_map_value8=0;
	    $ter_map_value9=0;
	    $ter_map_value10=0;

 	    $insert_count=0;
        $reject_count=0;
        $reject_value=0; 
        $insert_value=0;  

	for($k=0; $k<count($warehouse);$k++){

        if($warehouse[$k][14]=='' || $warehouse[$k][14]=="null"){
                $status=0; 
                $no_factory[]=0;   
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status empty'];    
            }else if($warehouse[$k][14]=="Active" || $warehouse[$k][14]=="active"){

                $status=1;
                $no_factory[]=1;   
            }else if($warehouse[$k][14]=="Inactive" || $warehouse[$k][14]=="inactive"){

                $status=2;
                $no_factory[]=2;   
            }else{
                $status=0;  
                $no_factory[]=0;      
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status data'];    
            }
         if($warehouse[$k][13]!=''){      
		        $ter_value10=$warehouse[$k][13];		   
		        $qry10="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value10' AND idTerritoryTitle ='10'";
				$result10=$this->adapter->query($qry10,array());
			    $resultset10=$result10->toArray();	

			    if(!$resultset10){
			    	$no_factory[]=0; 
	                $ter_map_value10=0;
	                $no_warehouse[]=$ter_map_value10;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory10 value mismatch'];            
			    }else{  
			       $ter_map_value10=1;
			       $no_warehouse[]=$ter_map_value10;
	               }    
        }

        if($warehouse[$k][12]!=''){ 
       	
                $ter_value9=$warehouse[$k][12];		   
		        $qry9="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value9' AND idTerritoryTitle ='9'";
				$result9=$this->adapter->query($qry9,array());
			    $resultset9=$result9->toArray();	

			    if(!$resultset9){ 
	                $ter_map_value9=0;
	                $no_warehouse[]=$ter_map_value9;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory9 value mismatch'];

	             
			    }else{  
			       $ter_map_value9=1;
			       $no_warehouse[]=$ter_map_value9;
	               }    
        }

        if($warehouse[$k][11]!=''){ 
       	
                $ter_value8=$warehouse[$k][11];		   
		        $qry8="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value8' AND idTerritoryTitle ='8'";
				$result8=$this->adapter->query($qry8,array());
			    $resultset8=$result8->toArray();	

			    if(!$resultset8){
	                $ter_map_value8=0;
	                $no_warehouse[]=$ter_map_value8;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory8 value mismatch'];
	             
			    }else{  
			       $ter_map_value8=1;
			       $no_warehouse[]=$ter_map_value8;
	               }    
        }

        if($warehouse[$k][10]!=''){ 
       	
                $ter_value7=$warehouse[$k][10];		   
		        $qry7="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value7' AND idTerritoryTitle ='7'";
				$result7=$this->adapter->query($qry7,array());
			    $resultset7=$result7->toArray();	

			    if(!$resultset7){
	                $ter_map_value7=0;
	                $no_warehouse[]=$ter_map_value7;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory7 value mismatch'];

	             
			    }else{ 
			       $ter_map_value7=1;
			       $no_warehouse[]=$ter_map_value7;
	               }    
        }

        if($warehouse[$k][9]!=''){ 
       	
                $ter_value6=$warehouse[$k][9];		   
		        $qry6="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value6' AND idTerritoryTitle ='6'";
				$result6=$this->adapter->query($qry6,array());
			    $resultset6=$result6->toArray();	

			    if(!$resultset6){ 
	                $ter_map_value6=0;
	                $no_warehouse[]=$ter_map_value6;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory6 value mismatch'];

	             
			    }else{  
			       $ter_map_value6=1;
			       $no_warehouse[]=$ter_map_value6;
	               }    
        }

        if($warehouse[$k][8]!=''){       	
                $ter_value5=$warehouse[$k][8];		   
		        $qry5="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value5' AND idTerritoryTitle ='5'";
				$result5=$this->adapter->query($qry5,array());
			    $resultset5=$result5->toArray();	

			    if(!$resultset5){ 
	                $ter_map_value5=0;
	                $no_warehouse[]=$ter_map_value5;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory5 value mismatch'];

	             
			    }else{  
			       $ter_map_value5=1;
			       $no_warehouse[]=$ter_map_value5;
	               }    
        }

        if($warehouse[$k][7]!=''){ 
       	
                $ter_value4=$warehouse[$k][7];		   
		        $qry4="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value4' AND idTerritoryTitle ='4'";
				$result4=$this->adapter->query($qry4,array());
			    $resultset4=$result4->toArray();	

			    if(!$resultset4){ 
	                $ter_map_value4=0;
	                $no_warehouse[]=$ter_map_value4;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory4 value mismatch'];
	             
			    }else{ 
			       $ter_map_value4=1;
			       $no_warehouse[]=$ter_map_value4;
	               }    
        }

        if($warehouse[$k][6]!=''){ 
       	
                $ter_value3=$warehouse[$k][6];		   
		        $qry3="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value3' AND idTerritoryTitle ='3'";
				$result3=$this->adapter->query($qry3,array());
			    $resultset3=$result3->toArray();	

			    if(!$resultset3){  
	                $ter_map_value3=0;
	                $no_warehouse[]=$ter_map_value3;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory3 value mismatch'];

	             
			    }else{  
			       $ter_map_value3=1;
			       $no_warehouse[]=$ter_map_value3;
	               }    
        }

        if($warehouse[$k][5]!=''){ 
       	
                $ter_value2=$warehouse[$k][5];		   
		        $qry2="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value2' AND idTerritoryTitle ='2'";
				$result2=$this->adapter->query($qry2,array());
			    $resultset2=$result2->toArray();	

			    if(!$resultset2){  
	                $ter_map_value2=0;
	                $no_warehouse[]=$ter_map_value2;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory2 value mismatch'];
	             
			    }else{  
			       $ter_map_value2=1;
			       $no_warehouse[]=$ter_map_value2;
	               }    
        }

        if($warehouse[$k][4]!=''){ 
     	
                $ter_value1=$warehouse[$k][4];		   
		        $qry1="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value1' AND idTerritoryTitle ='1'";
				$result1=$this->adapter->query($qry1,array());
			    $resultset1=$result1->toArray();	

			    if(!$resultset1){   
	                $ter_map_value1=0;
	                $no_warehouse[]=$ter_map_value1;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory1 value mismatch'];
	             
			    }else{  
			       $ter_map_value1=1;
			       $no_warehouse[]=$ter_map_value1;
	               }    
        }
       

        if($warehouse[$k][3]=='' || $warehouse[$k][3]=="null"){
          
		    	$email_id=0;   
		    	$no_warehouse[]=$email_id; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the email id empty'];

		}else if (!filter_var($warehouse[$k][3], FILTER_VALIDATE_EMAIL)) {
            $email_id=0;   
            $no_warehouse[]=$email_id; 
            $ret_arr=['code'=>'3','status'=>false,'message'=>'Please enter valid email id'];
        } else{
          
                $email_id=1;    
                $no_warehouse[]=$email_id;
        }  


        if($warehouse[$k][2]=='' || $warehouse[$k][2]=="null"){
		    	$mobile=0; 
		    	$no_warehouse[]=$mobile;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the mobile empty'];

		}else if(!is_numeric($warehouse[$k][2])){
                $mobile=0; 
                $no_warehouse[]=$mobile; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Mobile no numeric only'];  

        }else if((strlen($warehouse[$k][2])<10) || (strlen($warehouse[$k][2])>10)){
                $mobile=1; 
                $no_warehouse[]=$mobile;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please enter valid mobile number'];  
        }else if($warehouse[$k][2]!='' || $warehouse[$k][2]!="null"){
                $mobile=1;  
                $no_warehouse[]=$mobile;              
        } 

        if($warehouse[$k][1]=='' || $warehouse[$k][1]=="null"){
		    	$name=0;  
		    	$no_warehouse[]=$name;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the Name empty'];

		}if($warehouse[$k][1]!='' || $warehouse[$k][1]!="null"){
                $name=1; 
                $no_warehouse[]=$name;
                 
        }

         if($warehouse[$k][0]=='' || $warehouse[$k][0]=="null"){
                 $type=0;
                 $no_warehouse[]=$type; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the warehouse type empty'];

        }else if($warehouse[$k][0]!='' || $warehouse[$k][0]!="null"){
                
                 if($warehouse[$k][0]=='Customer' || $warehouse[$k][0]=='customer'){
                 $type=1;
                 $no_warehouse[]=$type;

                 }else if ($warehouse[$k][0]=='Company' || $warehouse[$k][0]=='company'){
                 $type=2;
                 $no_warehouse[]=$type;

                 }else{
                 
                 $type=0;
                 $no_warehouse[]=$type;

                   $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the warehouse type'];
                 }
        }   
               
	} // close loop $no_warehouse;

	if(count($no_warehouse)!= 0){

	    for($j=0; $j<count($no_warehouse);$j++){ 
            $zero=0;
        if(in_array($zero,$no_warehouse)){

           $check=0;
        }else{
           $check=1;

        }
                   
    }

	}else{
		  $check=0;
		  $ret_arr=['code'=>'3','status'=>false,'message'=>'Excel data is empty'];
	}


 if($check!=0){

	for($i=0; $i<count($warehouse);$i++) {   

                if($warehouse[$i][4]!=''){    	
			    	$ter_value1=$warehouse[$i][4];		   
			        $qry1="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value1' AND idTerritoryTitle ='1'";
					$result1=$this->adapter->query($qry1,array());
				    $resultset1=$result1->toArray();
				    $territory1=$resultset1[0]['idTerritory'];
			    }else{
			    	$territory1=0;
			    }
			    if($warehouse[$i][5]!=''){
			    	$ter_value2=$warehouse[$i][5];	   
			        $qry2="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value2' AND idTerritoryTitle ='2'";
					$result2=$this->adapter->query($qry2,array());
				    $resultset2=$result2->toArray();	
			    	$territory2=$resultset2[0]['idTerritory'];
			    }else{
			    	$territory2=0;
			    }
			    if($warehouse[$i][6]!=''){
			    	$ter_value3=$warehouse[$i][6];		   
			        $qry3="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value3' AND idTerritoryTitle ='3'";
					$result3=$this->adapter->query($qry3,array());
				    $resultset3=$result3->toArray();
			    	$territory3=$resultset3[0]['idTerritory'];
			    }else{
			    	$territory3=0;
			    }
			    if($warehouse[$i][7]!=''){
			    	$ter_value4=$warehouse[$i][7];	   
			        $qry4="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value4' AND idTerritoryTitle ='4'";
					$result4=$this->adapter->query($qry4,array());
				    $resultset4=$result4->toArray();	

			    	$territory4=$resultset4[0]['idTerritory'];
			    }else{
			    	$territory4=0;
			    }
			    if($warehouse[$i][8]!=''){
			    	$ter_value5=$warehouse[$i][8];   
			        $qry5="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value5' AND idTerritoryTitle ='5'";
					$result5=$this->adapter->query($qry5,array());
				    $resultset5=$result5->toArray();
			    	$territory5=$resultset5[0]['idTerritory'];
			    }else{
			    	$territory5=0;
			    }
			    if($warehouse[$i][9]!=''){
			    	$ter_value6=$warehouse[$i][9];	   
			        $qry6="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value6' AND idTerritoryTitle ='6'";
					$result6=$this->adapter->query($qry6,array());
				    $resultset6=$result6->toArray();	
			    	$territory6=$resultset6[0]['idTerritory'];
			    }else{
			    	$territory6=0;
			    }
			    if($warehouse[$i][10]!=''){
			    	$ter_value7=$warehouse[$i][10];		   
			        $qry7="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value7' AND idTerritoryTitle ='7'";
					$result7=$this->adapter->query($qry7,array());
				    $resultset7=$result7->toArray();	
			    	$territory7=$resultset7[0]['idTerritory'];
			    }else{
			    	$territory7=0;
			    }
			    if($warehouse[$i][11]!=''){
			    	$ter_value8=$warehouse[$i][11];		   
			        $qry8="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value8' AND idTerritoryTitle ='8'";
					$result8=$this->adapter->query($qry8,array());
				    $resultset8=$result8->toArray();	
			    	$territory8=$resultset8[0]['idTerritory'];
			    }else{
			    	$territory8=0;
			    }
			    if($warehouse[$i][12]!=''){
			    	$ter_value9=$warehouse[$i][12];	   
			        $qry9="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value9' AND idTerritoryTitle ='9'";
					$result9=$this->adapter->query($qry9,array());
				    $resultset9=$result9->toArray();
			    	$territory9=$resultset9[0]['idTerritory'];
			    }else{
			    	$territory9=0;
			    }
			    if($warehouse[$i][13]!=''){
				    $ter_value10=$warehouse[$i][13];	   
			        $qry10="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value10' AND idTerritoryTitle ='10'";
					$result10=$this->adapter->query($qry10,array());
				    $resultset10=$result10->toArray();
			    	$territory10=$territory10[0]['idTerritory'];
			    }else{
			    	$territory10=0;
			    }

			     if($warehouse[$i][0]=='Customer' || $warehouse[$i][0]=='customer'){
			     $type=1;
			     $no_warehouse[]=$type;

			     }else if ($warehouse[$i][0]=='Company' || $warehouse[$i][0]=='customer'){
			     $type=2;
			     $no_warehouse[]=$type;

			     }
                 if($warehouse[$i][14]=="Active" || $warehouse[$i][14]=="active"){

                $status=1;
         
                    }else if($warehouse[$i][14]=="Inactive" || $warehouse[$i][14]=="inactive"){

                        $status=2;  
                    }
                

 $qry_list="SELECT idWarehouse FROM warehouse_master where warehouseName=? and warehouseMobileno=? and warehouseEmail=?";
 $result_list=$this->adapter->query($qry_list,array($warehouse[$i][1],$warehouse[$i][2],$warehouse[$i][3]));
 $resultset_list=$result_list->toArray();

			if(!$resultset_list){
						$this->adapter->getDriver()->getConnection()->beginTransaction();
						try {					
							$data['warehouseName']=$warehouse[$i][1];
							$data['warehouseMobileno']=$warehouse[$i][2];
							$data['warehouseEmail']=$warehouse[$i][3];						
				    		$data['t1']=(($warehouse[$i][4]!='')? $resultset1[0]['idTerritory']:0);
							$data['t2']=(($warehouse[$i][5]!='')? $resultset2[0]['idTerritory']:0);
							$data['t3']=(($warehouse[$i][6]!='')? $resultset3[0]['idTerritory']:0);
							$data['t4']=(($warehouse[$i][7]!='')? $resultset4[0]['idTerritory']:0);
							$data['t5']=(($warehouse[$i][8]!='')? $resultset5[0]['idTerritory']:0);
							$data['t6']=(($warehouse[$i][9]!='')? $resultset6[0]['idTerritory']:0);
							$data['t7']=(($warehouse[$i][10]!='')? $resultset7[0]['idTerritory']:0);
							$data['t8']=(($warehouse[$i][11]!='')? $resultset8[0]['idTerritory']:0);
							$data['t9']=(($warehouse[$i][12]!='')? $resultset9[0]['idTerritory']:0);
							$data['t10']=(($warehouse[$i][13]!='')? $resultset10[0]['idTerritory']:0);
                            $data['idWarehousetype']=$type;     
                            $data['status']=$status;     
							$data['created_at']=date('Y-m-d H:i:s');
							$data['created_by']=$userid;
							$data['updated_at']=date('Y-m-d H:i:s');
							$data['updated_by']=$userid;
							$insert=new Insert('warehouse_master');
							$insert->values($data);
							$statement=$this->adapter->createStatement();
							$insert->prepareStatement($this->adapter, $statement);
							$insertresult=$statement->execute();
							$insert_value +=$insert_count+1;
					    //    $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
							$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
							$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
							$this->adapter->getDriver()->getConnection()->rollBack();
						}
					} else {

						$reject_value += $reject_count+1;
						//$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
				
					}

                }

        if($insert_value!=0 && $reject_value==0){

              $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
        }else if($insert_value ==0 && $reject_value !=0){

        	 $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];

        }else if($insert_value!=0 && $reject_value!=0){

        $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists  '.$reject_value.'Uploaded  '.$insert_value];
        }

		
				}
			} else {
				   $ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please verify the csv file'];
			}

			
		}

		return $ret_arr;

	}	// close func

public function uploadfactory($param) {
            $userData=$param->userData;
            $userid=$param->userid;
            $usertype=$userData['user_type'];
            $idCustomer=$userData['idCustomer'];
		ini_set('display_errors',true);
		$Uploads_dir = 'public/uploads/csv';
		$tmp_name=$_FILES["myFile"]["tmp_name"]; 
		$name = basename($_FILES["myFile"]["name"]); 
		$imageName = rand(6,66666).'.'. pathinfo($_FILES["myFile"]['name'],PATHINFO_EXTENSION);
    	if(move_uploaded_file($tmp_name, "$Uploads_dir/$imageName")) {
			$r="public/uploads/csv/$imageName";
			$file = fopen($r, "r",FILE_SKIP_EMPTY_LINES);
			$emapData = fgetcsv($file, 10000, ","); 
				$row=0;
				$size=sizeof($emapData);

				if($size=='14' && $emapData !=null) {
				$factory=array();
				$no_factory=array();
				
				while (($record = fgetcsv($file)) !== FALSE) {
					$row++;
					array_push($factory,$record);
				}

		$territory1=0;
	    $territory2=0;
	    $territory3=0;
	    $territory4=0;
	    $territory5=0;
	    $territory6=0;
	    $territory7=0;
	    $territory8=0;
        $territory9=0;
	    $territory10=0;

        $ter_map_value0=0;
	    $ter_map_value1=0;
	    $ter_map_value2=0;
	    $ter_map_value3=0;
	    $ter_map_value4=0;
	    $ter_map_value5=0;
	    $ter_map_value6=0;
	    $ter_map_value7=0;
	    $ter_map_value8=0;
	    $ter_map_value9=0;
	    $ter_map_value10=0;

	    $check_value=array();
	    $array_condition=array();
	    $no_factory=array();

 	    $insert_count=0;
        $reject_count=0;
        $reject_value=0; 
        $insert_value=0;  

	for($k=0; $k<count($factory);$k++){

        if($factory[$k][13]=='' || $factory[$k][13]=="null"){
                $status=0; 
                $no_factory[]=0;   
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status empty'];    
            }else if($factory[$k][13]=="Active" || $factory[$k][13]=="active"){

                $status=1;
                $no_factory[]=1;   
            }else if($factory[$k][13]=="Inactive" || $factory[$k][13]=="inactive"){

                $status=2;
                $no_factory[]=2;   
            }else{
                $status=0;  
                $no_factory[]=0;      
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status data'];    
            }
       if($factory[$k][12]!=''){      

		        $ter_value10=$factory[$k][12];		   
		        $qry10="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value10' AND idTerritoryTitle ='10'";
				$result10=$this->adapter->query($qry10,array());
			    $resultset10=$result10->toArray();	

			    if(!$resultset10){
			    	$no_factory[]=0; 
	                $ter_map_value10=0;
	                $no_factory[]=$ter_map_value10;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory10 value mismatch'];            
			    }else{  
			       $ter_map_value10=1;
			       $no_factory[]=$ter_map_value10;
	               }    
        }

        if($factory[$k][11]!=''){ 
       	
                $ter_value9=$factory[$k][11];		   
		        $qry9="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value9' AND idTerritoryTitle ='9'";
				$result9=$this->adapter->query($qry9,array());
			    $resultset9=$result9->toArray();	

			    if(!$resultset9){ 
	                $ter_map_value9=0;
	                $no_factory[]=$ter_map_value9;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory9 value mismatch'];

	             
			    }else{  
			       $ter_map_value9=1;
			       $no_factory[]=$ter_map_value9;
	               }    
        }

        if($factory[$k][10]!=''){ 
       	
                $ter_value8=$factory[$k][10];		   
		        $qry8="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value8' AND idTerritoryTitle ='8'";
				$result8=$this->adapter->query($qry8,array());
			    $resultset8=$result8->toArray();	

			    if(!$resultset8){
	                $ter_map_value8=0;
	                $no_factory[]=$ter_map_value8;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory8 value mismatch'];
	             
			    }else{  
			       $ter_map_value8=1;
			       $no_factory[]=$ter_map_value8;
	               }    
        }

        if($factory[$k][9]!=''){ 
       	
                $ter_value7=$factory[$k][9];		   
		        $qry7="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value7' AND idTerritoryTitle ='7'";
				$result7=$this->adapter->query($qry7,array());
			    $resultset7=$result7->toArray();	

			    if(!$resultset7){
	                $ter_map_value7=0;
	                $no_factory[]=$ter_map_value7;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory7 value mismatch'];

	             
			    }else{ 
			       $ter_map_value7=1;
			       $no_factory[]=$ter_map_value7;
	               }    
        }

        if($factory[$k][8]!=''){ 
       	
                $ter_value6=$factory[$k][8];		   
		        $qry6="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value6' AND idTerritoryTitle ='6'";
				$result6=$this->adapter->query($qry6,array());
			    $resultset6=$result6->toArray();	

			    if(!$resultset6){ 
	                $ter_map_value6=0;
	                $no_factory[]=$ter_map_value6;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory6 value mismatch'];

	             
			    }else{  
			       $ter_map_value6=1;
			       $no_factory[]=$ter_map_value6;
	               }    
        }

        if($factory[$k][7]!=''){       	
                $ter_value5=$factory[$k][7];		   
		        $qry5="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value5' AND idTerritoryTitle ='5'";
				$result5=$this->adapter->query($qry5,array());
			    $resultset5=$result5->toArray();	

			    if(!$resultset5){ 
	                $ter_map_value5=0;
	                $no_factory[]=$ter_map_value5;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory5 value mismatch'];

	             
			    }else{  
			       $ter_map_value5=1;
			       $no_factory[]=$ter_map_value5;
	               }    
        }

        if($factory[$k][6]!=''){ 
       	
                $ter_value4=$factory[$k][6];		   
		        $qry4="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value4' AND idTerritoryTitle ='4'";
				$result4=$this->adapter->query($qry4,array());
			    $resultset4=$result4->toArray();	

			    if(!$resultset4){ 
	                $ter_map_value4=0;
	                $no_factory[]=$ter_map_value4;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory4 value mismatch'];
	             
			    }else{ 
			       $ter_map_value4=1;
			       $no_factory[]=$ter_map_value4;
	               }    
        }

        if($factory[$k][5]!=''){ 
       	
                $ter_value3=$factory[$k][5];		   
		        $qry3="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value3' AND idTerritoryTitle ='3'";
				$result3=$this->adapter->query($qry3,array());
			    $resultset3=$result3->toArray();	

			    if(!$resultset3){  
	                $ter_map_value3=0;
	                $no_factory[]=$ter_map_value3;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory3 value mismatch'];

	             
			    }else{  
			       $ter_map_value3=1;
			       $no_factory[]=$ter_map_value3;
	               }    
        }

        if($factory[$k][4]!=''){ 
       	
                $ter_value2=$factory[$k][4];		   
		        $qry2="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value2' AND idTerritoryTitle ='2'";
				$result2=$this->adapter->query($qry2,array());
			    $resultset2=$result2->toArray();	

			    if(!$resultset2){  
	                $ter_map_value2=0;
	                $no_factory[]=$ter_map_value2;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory2 value mismatch'];
	             
			    }else{  
			       $ter_map_value2=1;
			       $no_factory[]=$ter_map_value2;
	               }    
        }

        if($factory[$k][3]!=''){ 
     	
                $ter_value1=$factory[$k][3];		   
		        $qry1="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value1' AND idTerritoryTitle ='1'";
				$result1=$this->adapter->query($qry1,array());
			    $resultset1=$result1->toArray();	

			    if(!$resultset1){   
	                $ter_map_value1=0;
	                $no_factory[]=$ter_map_value1;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory1 value mismatch'];
	             
			    }else{  
			       $ter_map_value1=1;
			       $no_factory[]=$ter_map_value1;
	               }    
        }

       if($factory[$k][2]=='' || $factory[$k][2]=="null"){
    	$mobile=0;  
    	$no_factory[]=$mobile;
        $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the mobile empty'];

		}else if(!is_numeric($factory[$k][2])){
                $mobile=0; 
                $no_factory[]=$mobile;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Mobile no numeric only'];  

        }else if((strlen($factory[$k][2])<10) || (strlen($factory[$k][2])>10)){
                $mobile=0; 
                $no_factory[]=$mobile;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please enter valid mobile number'];  
        }else if($factory[$k][2]!='' || $factory[$k][2]!="null"){
                $mobile=1; 
                $no_factory[]=$mobile; 
                 
        }

        if($factory[$k][1]=='' || $factory[$k][1]=="null"){
		    	$email_id=0;   
		    	$no_factory[]=$email_id; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the email id empty'];
		}else if (!filter_var($factory[$k][1], FILTER_VALIDATE_EMAIL)) {
            $email_id=0;   
                $no_factory[]=$email_id;
            $ret_arr=['code'=>'3','status'=>false,'message'=>'Please enter valid email id'];
        }if($factory[$k][1]!='' || $factory[$k][1]!="null"){
                $email_id=1;   
                $no_factory[]=$email_id;  
        }   

        if($factory[$k][0]=='' || $factory[$k][0]=="null"){
		    	$name=0;  
		    	$no_factory[]=$name; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the factory name empty'];

		}if($factory[$k][0]!='' || $factory[$k][0]!="null"){
                $name=1;  
                $no_factory[]=$name;  
                 
        }           
                
	} // close loop $no_warehouse;

	if(count($no_factory)!= 0){

	    for($j=0; $j<count($no_factory);$j++){ 
            $zero=0;
        if(in_array($zero,$no_factory)){

           $check=0;
        }else{
           $check=1;

        }
                   
    }

	}else{

		  $check=0;
		  $ret_arr=['code'=>'3','status'=>false,'message'=>'Excel data is empty'];
	}


 if($check!=0){

	for($i=0; $i<count($factory);$i++) {

                if($factory[$i][3]!=''){    	
			    	$ter_value1=$factory[$i][3];		   
			        $qry1="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value1' AND idTerritoryTitle ='1'";
					$result1=$this->adapter->query($qry1,array());
				    $resultset1=$result1->toArray();
				    $territory1=$resultset1[0]['idTerritory'];
			    }else{
			    	$territory1=0;
			    }
			    if($factory[$i][4]!=''){
			    	$ter_value2=$factory[$i][4];	   
			        $qry2="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value2' AND idTerritoryTitle ='2'";
					$result2=$this->adapter->query($qry2,array());
				    $resultset2=$result2->toArray();	
			    	$territory2=$resultset2[0]['idTerritory'];
			    }else{
			    	$territory2=0;
			    }
			    if($factory[$i][5]!=''){
			    	$ter_value3=$factory[$i][5];		   
			        $qry3="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value3' AND idTerritoryTitle ='3'";
					$result3=$this->adapter->query($qry3,array());
				    $resultset3=$result3->toArray();
			    	$territory3=$resultset3[0]['idTerritory'];
			    }else{
			    	$territory3=0;
			    }
			    if($factory[$i][6]!=''){
			    	$ter_value4=$factory[$i][6];	   
			        $qry4="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value4' AND idTerritoryTitle ='4'";
					$result4=$this->adapter->query($qry4,array());
				    $resultset4=$result4->toArray();	

			    	$territory4=$resultset4[0]['idTerritory'];
			    }else{
			    	$territory4=0;
			    }
			    if($factory[$i][7]!=''){
			    	$ter_value5=$factory[$i][7];   
			        $qry5="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value5' AND idTerritoryTitle ='5'";
					$result5=$this->adapter->query($qry5,array());
				    $resultset5=$result5->toArray();
			    	$territory5=$resultset5[0]['idTerritory'];
			    }else{
			    	$territory5=0;
			    }
			    if($factory[$i][8]!=''){
			    	$ter_value6=$factory[$i][8];	   
			        $qry6="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value6' AND idTerritoryTitle ='6'";
					$result6=$this->adapter->query($qry6,array());
				    $resultset6=$result6->toArray();	
			    	$territory6=$resultset6[0]['idTerritory'];
			    }else{
			    	$territory6=0;
			    }
			    if($factory[$i][9]!=''){
			    	$ter_value7=$factory[$i][9];		   
			        $qry7="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value7' AND idTerritoryTitle ='7'";
					$result7=$this->adapter->query($qry7,array());
				    $resultset7=$result7->toArray();	
			    	$territory7=$resultset7[0]['idTerritory'];
			    }else{
			    	$territory7=0;
			    }
			    if($factory[$i][10]!=''){
			    	$ter_value8=$factory[$i][10];		   
			        $qry8="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value8' AND idTerritoryTitle ='8'";
					$result8=$this->adapter->query($qry8,array());
				    $resultset8=$result8->toArray();	
			    	$territory8=$resultset8[0]['idTerritory'];
			    }else{
			    	$territory8=0;
			    }
			    if($factory[$i][11]!=''){
			    	$ter_value9=$factory[$i][11];	   
			        $qry9="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value9' AND idTerritoryTitle ='9'";
					$result9=$this->adapter->query($qry9,array());
				    $resultset9=$result9->toArray();
			    	$territory9=$resultset9[0]['idTerritory'];
			    }else{
			    	$territory9=0;
			    }
			    if($factory[$i][12]!=''){
				    $ter_value10=$factory[$i][12];	   
			        $qry10="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value10' AND idTerritoryTitle ='10'";
					$result10=$this->adapter->query($qry10,array());
				    $resultset10=$result10->toArray();
			    	$territory10=$territory10[0]['idTerritory'];
			    }else{
			    	$territory10=0;
			    }
                if($factory[$i][13]=="Active" || $factory[$i][13]=="active"){

                $status=1;
         
            }else if($factory[$i][13]=="Inactive" || $factory[$i][13]=="inactive"){

                $status=2;  
            }
                


          $qry_list="SELECT idFactory FROM factory_master where factoryName=? and factoryEmail=? and factoryMobileno=?";

			$result_list=$this->adapter->query($qry_list,array($factory[$i][0],$factory[$i][1],$factory[$i][2]));
			$resultset_list=$result_list->toArray();

			if(!$resultset_list){
						$this->adapter->getDriver()->getConnection()->beginTransaction();
						try {					
							$data['factoryName']=$factory[$i][0];
							$data['factoryEmail']=$factory[$i][1];
							$data['factoryMobileno']=$factory[$i][2];						
				    		$data['t1']=(($factory[$i][3]!='')? $resultset1[0]['idTerritory']:0);
							$data['t2']=(($factory[$i][4]!='')? $resultset2[0]['idTerritory']:0);
							$data['t3']=(($factory[$i][5]!='')? $resultset3[0]['idTerritory']:0);
							$data['t4']=(($factory[$i][6]!='')? $resultset4[0]['idTerritory']:0);
							$data['t5']=(($factory[$i][7]!='')? $resultset5[0]['idTerritory']:0);
							$data['t6']=(($factory[$i][8]!='')? $resultset6[0]['idTerritory']:0);
							$data['t7']=(($factory[$i][9]!='')? $resultset7[0]['idTerritory']:0);
							$data['t8']=(($factory[$i][10]!='')? $resultset8[0]['idTerritory']:0);
							$data['t9']=(($factory[$i][11]!='')? $resultset9[0]['idTerritory']:0);
							$data['t10']=(($factory[$i][12]!='')? $resultset10[0]['idTerritory']:0);
                            $data['status']=$status;
							$data['created_at']=date('Y-m-d H:i:s');
							$data['created_by']=$userid;
							$data['updated_at']=date('Y-m-d H:i:s');
							$data['updated_by']=$userid;
							$insert=new Insert('factory_master');
							$insert->values($data);
							$statement=$this->adapter->createStatement();
							$insert->prepareStatement($this->adapter, $statement);
							$insertresult=$statement->execute();
							$insert_value +=$insert_count+1;
							$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
							$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
							$this->adapter->getDriver()->getConnection()->rollBack();
						}
					} else {

						$reject_value += $reject_count+1;
				
					}

                }

        if($insert_value!=0 && $reject_value==0){

              $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
        }else if($insert_value ==0 && $reject_value !=0){

        	 $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists data'];

        }else if($insert_value!=0 && $reject_value!=0){

        $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists  '.$reject_value.'Uploaded  '.$insert_value];
        }

				}
			} else {
				   $ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please verify the csv file'];
			}

			
		}

		return $ret_arr;

	} // close func

	public function uploadhsncode($param) {

		ini_set('display_errors',true);
		$Uploads_dir = 'public/uploads/csv';
		$tmp_name=$_FILES["myFile"]["tmp_name"]; 
		$name = basename($_FILES["myFile"]["name"]); 
		$imageName = rand(6,66666).'.'. pathinfo($_FILES["myFile"]['name'],PATHINFO_EXTENSION);
    	if(move_uploaded_file($tmp_name, "$Uploads_dir/$imageName")) {
			$r="public/uploads/csv/$imageName";
			$file = fopen($r, "r",FILE_SKIP_EMPTY_LINES);
			$emapData = fgetcsv($file, 10000, ","); 
				$row=0;
				$size=sizeof($emapData);
				if($size=='3' && $emapData !=null) {
				$hsncode=array();
				$no_hsncode=array();
				while (($record = fgetcsv($file)) !== FALSE) {
					$row++;
					array_push($hsncode,$record);
				}
        

        $insert_count=0;
        $reject_count=0;
        $reject_value=0; 
        $insert_value=0; 
        $status_array=array(); 

	 for($k=0; $k<count($hsncode);$k++) {

	 	if($hsncode[$k][2]=='' || $hsncode[$k][2]=="null"){
                $status=0; 
                $status_array[]=0;   
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status empty'];    
        	}else if($hsncode[$k][2]=="Active" || $hsncode[$k][2]=="active"){

                $status=1;
                $status_array[]=1;   
        	}else if($hsncode[$k][2]=="Inactive" || $hsncode[$k][2]=="inactive"){

        		$status=2;
        		$status_array[]=2;   
            }else{
                $status=0;  
                $status_array[]=0;      
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status data'];    
        	}

        if($hsncode[$k][1]=='' || $hsncode[$k][1]=="null"){
		    	$descript=0;    
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the description empty'];

		}else if($hsncode[$k][1]!='' || $hsncode[$k][1]!="null"){
                $descript=1;    
                 
        }

        if($hsncode[$k][0]=='' || $hsncode[$k][0]=="null"){
		    	$hsn=0;    
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the hsncode empty'];

		}else if(!is_numeric($hsncode[$k][0])){
                $hsn=0; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Hsn code numeric only'];  

        }else if((strlen($hsncode[$k][0])>6)){
                $hsn=0; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Hsn code length minmum 6'];  
        }else if($hsncode[$k][0]!='' || $hsncode[$k][0]!="null"){
                $hsn=1;    
                 
        }

        	
                
	  }


if($hsn!=0 && $descript!=0 && $status!=0){

		for($i=0; $i<count($hsncode);$i++) {

					$qry="SELECT * FROM hsn_details where hsn_code=? and description=?";
					$result=$this->adapter->query($qry,array($hsncode[$i][0],$hsncode[$i][1]));
					$resultset=$result->toArray();
					if(!$resultset) {
						$this->adapter->getDriver()->getConnection()->beginTransaction();
						try {

			if($hsncode[$i][2]=="Active" || $hsncode[$i][2]=="active"){

                $status=1;
         
        	}else if($hsncode[$i][2]=="Inactive" || $hsncode[$i][2]=="inactive"){

        		$status=2;  
            }
							$datapros['hsn_code']=$hsncode[$i][0];
							$datapros['description']=$hsncode[$i][1];
							$datapros['status']=$status;  
							$datapros['created_at']=date('Y-m-d H:i:s');
							$datapros['created_by']=1;
							$datapros['updated_at']=date('Y-m-d H:i:s');
							$datapros['updated_by']=1;
							$insert=new Insert('hsn_details');
							$insert->values($datapros);
							$statement=$this->adapter->createStatement();
							$insert->prepareStatement($this->adapter, $statement);
							$insertresult=$statement->execute();
					        $insert_value += $insert_count+1;	
							$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
							$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
							$this->adapter->getDriver()->getConnection()->rollBack();
						}
					}else{
						$reject_value += $reject_count+1;
				        
					}
				}


        if($insert_value!=0 && $reject_value==0){

              $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully '.$insert_value .' data'];
        }else if($insert_value ==0 && $reject_value !=0){

        	 $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists '.$reject_value.' data'];

        }else if($insert_value!=0 && $reject_value!=0){

        $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists  '.$reject_value.'Uploaded  '.$insert_value];
        }

    }

			}else {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please verify the csv file'];
			}
			
		}
		return $ret_arr;

	} // close func

public function uploadgstmaster($param) {

		ini_set('display_errors',true);
		$Uploads_dir = 'public/uploads/csv';
		$tmp_name=$_FILES["myFile"]["tmp_name"]; 
		$name = basename($_FILES["myFile"]["name"]); 
		$imageName = rand(6,66666).'.'. pathinfo($_FILES["myFile"]['name'],PATHINFO_EXTENSION);
    	if(move_uploaded_file($tmp_name, "$Uploads_dir/$imageName")) {
			$r="public/uploads/csv/$imageName";
			$file = fopen($r, "r",FILE_SKIP_EMPTY_LINES);
			$emapData = fgetcsv($file, 10000, ","); 
				$row=0;
				$size=sizeof($emapData);
				if($size=='3' && $emapData !=null) {
				$gstmaster=array();
				$no_gstmaster=array();
				while (($record = fgetcsv($file)) !== FALSE) {
					$row++;
					array_push($gstmaster,$record);
				}
        

        $insert_count=0;
        $reject_count=0;
        $reject_value=0; 
        $insert_value=0; 
        $status_array=array(); 

	 for($k=0; $k<count($gstmaster);$k++) {

	 	if($gstmaster[$k][2]=='' || $gstmaster[$k][2]=="null"){
                $status=0; 
                $status_array[]=0;   
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status empty'];    
        	}else if($gstmaster[$k][2]=="Active" || $gstmaster[$k][2]=="active"){

                $status=1;
                $status_array[]=1;   
        	}else if($gstmaster[$k][2]=="Inactive" || $gstmaster[$k][2]=="inactive"){

        		$status=2;
        		$status_array[]=2;   
            }else{
                $status=0;  
                $status_array[]=0;      
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status data'];    
        	}

        if($gstmaster[$k][1]=='' || $gstmaster[$k][1]=="null"){
		    	$gst=0;    
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the GST empty'];

		}else if(!is_numeric($gstmaster[$k][1])){
                $gst=0; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'GST no numeric only'];  

        }
        /*else if((strlen($gstmaster[$k][1])>2)){

              
                $ret_arr=['code'=>'3','status'=>false,'message'=>'GST length minmum 2'];  
        }*/
       
       
        else if($gstmaster[$k][1]!='' || $gstmaster[$k][1]!="null"){
             if(preg_match('/^(?:100|\d{1,2})(?:\.\d{1,2})?$/', $gstmaster[$k][1])){
            
                  $gst=1; 
                }
                else {
                      $gst=0; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'GST rate should be below or equal to 100'];  
                }
                  
                 
        }
      //  print_r($gstmaster);
        if($gstmaster[$k][0]=='' || $gstmaster[$k][0]=="null"){
		    	$hsn=0;    
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the hsncode empty'];

		}else if(!is_numeric($gstmaster[$k][0])){
                $hsn=0; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'HSN code numeric only'];  

        }else if((strlen($gstmaster[$k][0])>6)){
                $hsn=0; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'HSN code length minmum 6'];  
        }else if($gstmaster[$k][0]!='' || $gstmaster[$k][0]!="null"){
                $hsncode=$gstmaster[$k][0];	   
		        $qry1="SELECT idHsncode,hsn_code,description FROM hsn_details WHERE hsn_code='$hsncode' AND status ='1'";
				$result1=$this->adapter->query($qry1,array());
			    $resultset1=$result1->toArray();	

			    if(!$resultset1){
	                $hsn=0;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'HSN code mismatch'];
	             
			    }else{ 
	               $hsn=1;
			    }     
                 
        }

        	
                
	  }


if($hsn!=0 && $gst!=0 && $status!=0){

		for($i=0; $i<count($gstmaster);$i++) {

			$hsncode=$gstmaster[$i][0];	   
	        $qry1="SELECT idHsncode,hsn_code,description FROM hsn_details WHERE hsn_code='$hsncode' AND status ='1'";
			$result1=$this->adapter->query($qry1,array());
		    $resultset1=$result1->toArray();

					$qry="SELECT * FROM gst_master where idHsncode=?";
					$result=$this->adapter->query($qry,array($resultset1[0]['idHsncode']));
					$resultset=$result->toArray();
					if(!$resultset) {
						$this->adapter->getDriver()->getConnection()->beginTransaction();
						try {

			if($gstmaster[$i][2]=="Active" || $gstmaster[$i][2]=="active"){

                $status=1;
         
        	}else if($gstmaster[$i][2]=="Inactive" || $gstmaster[$i][2]=="inactive"){

        		$status=2;  
            }
							$data['idHsncode']=$resultset1[0]['idHsncode'];
							$data['gstValue']=$gstmaster[$i][1];
							$data['status']=$status;
							$data['created_at']=date('Y-m-d H:i:s');
							$data['created_by']=1;
							$data['updated_at']=date('Y-m-d H:i:s');
							$data['updated_by']=1;
							$insert=new Insert('gst_master');
							$insert->values($data);
							$statement=$this->adapter->createStatement();
							$insert->prepareStatement($this->adapter, $statement);
							$insertresult=$statement->execute();
					        $insert_value += $insert_count+1;	
							$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
							$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
							$this->adapter->getDriver()->getConnection()->rollBack();
						}
					}else{
						$reject_value += $reject_count+1;
				        
					}
				}


        if($insert_value!=0 && $reject_value==0){

              $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully '.$insert_value .' data'];
        }else if($insert_value ==0 && $reject_value !=0){

        	 $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists '.$reject_value.' data'];

        }else if($insert_value!=0 && $reject_value!=0){

        $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists  '.$reject_value.'Uploaded  '.$insert_value];
        }

    }

			}else {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please verify the csv file'];
			}
			
		}
		return $ret_arr;

	} // close func 

public function uploadtaxheads($param){

		ini_set('display_errors',true);
		$Uploads_dir = 'public/uploads/csv';
		$tmp_name=$_FILES["myFile"]["tmp_name"]; 
		$name = basename($_FILES["myFile"]["name"]); 
		$imageName = rand(6,66666).'.'. pathinfo($_FILES["myFile"]['name'],PATHINFO_EXTENSION);
    	if(move_uploaded_file($tmp_name, "$Uploads_dir/$imageName")) {
			$r="public/uploads/csv/$imageName";
			$file = fopen($r, "r",FILE_SKIP_EMPTY_LINES);
			$emapData = fgetcsv($file, 10000, ","); 
				$row=0;
				$size=sizeof($emapData);
				if($size=='2' && $emapData !=null) {
				$taxhead=array();
				$no_taxhead=array();
				while (($record = fgetcsv($file)) !== FALSE) {
					$row++;
					array_push($taxhead,$record);
				}
        

        $insert_count=0;
        $reject_count=0;
        $reject_value=0; 
        $insert_value=0; 
        $status_array=array(); 

	 for($k=0; $k<count($taxhead);$k++) {

	 	if($taxhead[$k][1]=='' || $taxhead[$k][1]=="null"){
                $status=0; 
                $status_array[]=0;   
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status empty'];    
        	}else if($taxhead[$k][1]=="Active" || $taxhead[$k][1]=="active"){

                $status=1;
                $status_array[]=1;   
        	}else if($taxhead[$k][1]=="Inactive" || $taxhead[$k][1]=="inactive"){

        		$status=2;
        		$status_array[]=2;   
            }else{
                $status=0;  
                $status_array[]=0;      
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status data'];    
        	}


        if($taxhead[$k][0]=='' || $taxhead[$k][0]=="null"){
		    	$tax=0;    
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the taxhead empty'];

		}else if($taxhead[$k][0]!='' || $taxhead[$k][0]!="null"){ 
               $tax=1;      
        }

        	
                
	  }


if($tax!=0 && $status!=0){

		for($i=0; $i<count($taxhead);$i++) {

					$qry="SELECT * FROM taxheads_details where taxheadsName=?";
					$result=$this->adapter->query($qry,array($taxhead[$i][0]));
					$resultset=$result->toArray();
					if(!$resultset) {
						$this->adapter->getDriver()->getConnection()->beginTransaction();
						try {
                            
            if($taxhead[$i][1]=="Active" || $taxhead[$i][1]=="active"){

                $status=1;
         
        	}else if($taxhead[$i][1]=="Inactive" || $taxhead[$i][1]=="inactive"){

        		$status=2;  
            }

							$data['taxheadsName']=$taxhead[$i][0];
							$data['status']=$status;
							$data['created_at']=date('Y-m-d H:i:s');
							$data['created_by']=1;
							$data['updated_at']=date('Y-m-d H:i:s');
							$data['updated_by']=1;
							$insert=new Insert('taxheads_details');
							$insert->values($data);
							$statement=$this->adapter->createStatement();
							$insert->prepareStatement($this->adapter, $statement);
							$insertresult=$statement->execute();
					        $insert_value += $insert_count+1;	
							$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
							$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
							$this->adapter->getDriver()->getConnection()->rollBack();
						}
					}else{
						$reject_value += $reject_count+1;
				        
					}
				}


        if($insert_value!=0 && $reject_value==0){

              $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully '.$insert_value .' data'];
        }else if($insert_value ==0 && $reject_value !=0){

        	 $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists '.$reject_value.' data'];

        }else if($insert_value!=0 && $reject_value!=0){

        $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists  '.$reject_value.'Uploaded  '.$insert_value];
        }

    }

			}else {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please verify the csv file'];
			}
			
		}
		return $ret_arr;

	}  // close func

public function uploadserviceclass($param){

		ini_set('display_errors',true);
		$Uploads_dir = 'public/uploads/csv';
		$tmp_name=$_FILES["myFile"]["tmp_name"]; 
		$name = basename($_FILES["myFile"]["name"]); 
		$imageName = rand(6,66666).'.'. pathinfo($_FILES["myFile"]['name'],PATHINFO_EXTENSION);
    	if(move_uploaded_file($tmp_name, "$Uploads_dir/$imageName")) {
			$r="public/uploads/csv/$imageName";
			$file = fopen($r, "r",FILE_SKIP_EMPTY_LINES);
			$emapData = fgetcsv($file, 10000, ","); 
				$row=0;
				$size=sizeof($emapData);
				if($size=='2' && $emapData !=null) {
				$serviceclass=array();
				$no_serviceclass=array();
				while (($record = fgetcsv($file)) !== FALSE) {
					$row++;
					array_push($serviceclass,$record);
				}
        

        $insert_count=0;
        $reject_count=0;
        $reject_value=0; 
        $insert_value=0; 
        $status_array=array(); 

	 for($k=0; $k<count($serviceclass);$k++) {

	 	if($serviceclass[$k][1]=='' || $serviceclass[$k][1]=="null"){
                $status=0; 
                $no_serviceclass[]=$status;   
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status empty'];    
        	}else if($serviceclass[$k][1]=="Active" || $serviceclass[$k][1]=="active"){

                $status=1;
              $no_serviceclass[]=$status;  
        	}else if($serviceclass[$k][1]=="Inactive" || $serviceclass[$k][1]=="inactive"){

        		$status=2;
        		$no_serviceclass[]=$status;  
            }else{
                $status=0;  
                $no_serviceclass[]=$status;     
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status data'];    
        	}


        if($serviceclass[$k][0]=='' || $serviceclass[$k][0]=="null"){
		    	$service=0;  
		    	$no_serviceclass[]=$service;    
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the taxhead empty'];

		}else if($serviceclass[$k][0]!='' || $serviceclass[$k][0]!="null"){ 
               $service=1; 
               $no_serviceclass[]=$service;         
        }

        	
                
	  }

if(count($no_serviceclass)!= 0){

	    for($j=0; $j<count($no_serviceclass);$j++){ 
            $zero=0;
        if(in_array($zero,$no_serviceclass)){

           $check=0;
        }else{
           $check=1;

        }
                   
    }

}else{

	  $check=0;
	  $ret_arr=['code'=>'3','status'=>false,'message'=>'Excel data is empty'];
}


if($check!=0){

		for($i=0; $i<count($serviceclass);$i++) {

			$qry="SELECT * FROM service_class where serviceClass=?";
			$result=$this->adapter->query($qry,array($serviceclass[$i][0]));
			$resultset=$result->toArray();

			if(!$resultset) {
				$this->adapter->getDriver()->getConnection()->beginTransaction();
				try {
                            
            if($serviceclass[$i][1]=="Active" || $serviceclass[$i][1]=="active"){
                $status=1;
         
        	}else if($serviceclass[$i][1]=="Inactive" || $serviceclass[$i][1]=="inactive"){
        		$status=2;  
            }
							$data['serviceClass']=$serviceclass[$i][0];
							$data['status']=$status;
							$data['created_at']=date('Y-m-d H:i:s');
							$data['created_by']=1;
							$data['updated_at']=date('Y-m-d H:i:s');
							$data['updated_by']=1;
							$insert=new Insert('service_class');
							$insert->values($data);
							$statement=$this->adapter->createStatement();
							$insert->prepareStatement($this->adapter, $statement);
							$insertresult=$statement->execute();
					        $insert_value += $insert_count+1;	
							$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
							$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
							$this->adapter->getDriver()->getConnection()->rollBack();
						}
					}else{
						$reject_value += $reject_count+1;
				        
					}
				}


        if($insert_value!=0 && $reject_value==0){

              $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
        }else if($insert_value ==0 && $reject_value !=0){

        	 $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];

        }else if($insert_value!=0 && $reject_value!=0){

        $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists  '.$reject_value.'Uploaded  '.$insert_value];
        }

    }

			}else {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please verify the csv file'];
			}
			
		}
		return $ret_arr;

	} // close func


public function uploadservicedefinition($param){

		ini_set('display_errors',true);
		$Uploads_dir = 'public/uploads/csv';
		$tmp_name=$_FILES["myFile"]["tmp_name"]; 
		$name = basename($_FILES["myFile"]["name"]); 
		$imageName = rand(6,66666).'.'. pathinfo($_FILES["myFile"]['name'],PATHINFO_EXTENSION);
    	if(move_uploaded_file($tmp_name, "$Uploads_dir/$imageName")) {
			$r="public/uploads/csv/$imageName";
			$file = fopen($r, "r",FILE_SKIP_EMPTY_LINES);
			$emapData = fgetcsv($file, 10000, ","); 
				$row=0;
				$size=sizeof($emapData);
				if($size=='7' && $emapData !=null) {
				$servicedefinition=array();
				$no_servicedefinition=array();
				while (($record = fgetcsv($file)) !== FALSE) {
					$row++;
					array_push($servicedefinition,$record);
				}
        

        $insert_count=0;
        $reject_count=0;
        $reject_value=0; 
        $insert_value=0; 
        $status_array=array(); 

	 for($k=0; $k<count($servicedefinition);$k++){

	 	if($servicedefinition[$k][6]=='' || $servicedefinition[$k][6]=="null"){
            $status=0; 
            $status_array[]=0;   
            $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status empty'];    
    	}else if($servicedefinition[$k][6]=="Active" || $servicedefinition[$k][6]=="active"){

            $status=1;
            $status_array[]=1;   
    	}else if($servicedefinition[$k][6] =="Inactive" || $servicedefinition[$k][6]=="inactive"){

    		$status=2;
    		$status_array[]=2;   
        }else{
            $status=0;  
            $status_array[]=0;      
            $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status data'];    
    	}
         

        if($servicedefinition[$k][5]=='' || $servicedefinition[$k][5]=="null"){
		    	$class=0;    
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the service class empty'];

		}else if($servicedefinition[$k][5]!='' || $servicedefinition[$k][5]!="null"){
                $ser_class=$servicedefinition[$k][5];	   
		        $qry3="SELECT idServiceClass FROM service_class WHERE serviceClass='$ser_class' AND status ='1'";
				$result3=$this->adapter->query($qry3,array());
			    $resultset3=$result3->toArray();	

			    if(!$resultset3){
	                $class=0;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Service class mismatch'];
	             
			    }else{ 
	               $class=1;
			    }     
                 
        }


        if($servicedefinition[$k][4]=='' || $servicedefinition[$k][4]=="null"){
		    $nature=0;    
            $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the nature service empty'];
		}else if($servicedefinition[$k][4]=="Standard" || $servicedefinition[$k][4]=="standard"){
            $nature=1; 
    	}else if($servicedefinition[$k][4]=="Customized" || $servicedefinition[$k][4]=="customized"){
    		$nature=2;
        }else if($servicedefinition[$k][4]=="Variable" || $servicedefinition[$k][4]=="variable"){
    		$nature=3; 
        }else{
        	$nature=0; 
            $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the nature of service mismatch'];
        }


        if($servicedefinition[$k][3]=='' || $servicedefinition[$k][3]=="null"){
		    $unit=0;    
         $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the service unit empty'];
		}else if($servicedefinition[$k][3]=="Order based" || $servicedefinition[$k][3]=="order based"){
            $unit=1; 
    	}else if($servicedefinition[$k][3]=="Manpower based" || $servicedefinition[$k][3]=="manpower based"){
    		$unit=2;
        }else if($servicedefinition[$k][3]=="Duration based" || $servicedefinition[$k][3]=="duration based"){

    		$unit=3; 
        }else if($servicedefinition[$k][3]=="Variable based" || $servicedefinition[$k][3]=="variable based"){

    		$unit=4; 
        }else if($servicedefinition[$k][3]=="Activation based" || $servicedefinition[$k][3]=="activation based"){

    		$unit=5; 
        }else{
        	$unit=0; 
               $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the service unit mismatch'];
        }



        if($servicedefinition[$k][2]=='' || $servicedefinition[$k][2]=="null"){
		    	$name=0;    
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the service name empty'];

		}else if($servicedefinition[$k][2]!='' || $servicedefinition[$k][2]!="null"){ 
               $name=1;      
        }


        if($servicedefinition[$k][1]=='' || $servicedefinition[$k][1]=="null"){
		    	$sub=0;    
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the sub category empty'];

		}else if($servicedefinition[$k][1]!='' || $servicedefinition[$k][1]!="null"){
                $sub_category=$servicedefinition[$k][1];	   
		        $qry2="SELECT idSubCategory FROM subcategory WHERE subcategory='$sub_category' AND status ='1'";
				$result2=$this->adapter->query($qry2,array());
			    $resultset2=$result2->toArray();	

			    if(!$resultset2){
	                $sub=0;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Sub category mismatch'];
	             
			    }else{ 
	               $sub=1;
			    }     
                 
        }

       
        if($servicedefinition[$k][0]=='' || $servicedefinition[$k][0]=="null"){
		    	$category=0;    
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the category empty'];

		}else if($servicedefinition[$k][0]!='' || $servicedefinition[$k][0]!="null"){
                $category_name=$servicedefinition[$k][0];	   
		        $qry1="SELECT idCategory FROM  category WHERE category='$category_name' AND status ='1'";
				$result1=$this->adapter->query($qry1,array());
			    $resultset1=$result1->toArray();	

			    if(!$resultset1){
	                $category=0;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'category mismatch'];
	             
			    }else{ 
	               $category=1;
			    }     
                 
        }
        	
                

	  }


if($category!=0 && $sub!=0 && $name!=0 && $unit!=0 && $nature!=0  && $class!=0  && $status!=0){

		for($i=0; $i<count($servicedefinition);$i++) {

		    $category_name=$servicedefinition[$i][0];	   
	        $qry1="SELECT idCategory FROM  category WHERE category='$category_name' AND status ='1'";
			$result1=$this->adapter->query($qry1,array());
		    $resultset1=$result1->toArray();

		    $sub_category=$servicedefinition[$i][1];	   
	        $qry2="SELECT idSubCategory FROM subcategory WHERE subcategory='$sub_category' AND status ='1'";
			$result2=$this->adapter->query($qry2,array());
		    $resultset2=$result2->toArray();

		    $ser_class=$servicedefinition[$i][5];	   
	        $qry3="SELECT idServiceClass FROM service_class WHERE serviceClass='$ser_class' AND status ='1'";
			$result3=$this->adapter->query($qry3,array());
		    $resultset3=$result3->toArray();	

		if($servicedefinition[$i][3]=="Order based" || $servicedefinition[$i][3]=="order based"){
            $unit=1; 
    	}else if($servicedefinition[$i][3]=="Manpower based" || $servicedefinition[$i][3]=="manpower based"){
    		$unit=2;
        }else if($servicedefinition[$i][3]=="Duration based" || $servicedefinition[$i][3]=="duration based"){

    		$unit=3; 
        }else if($servicedefinition[$i][3]=="Variable based" || $servicedefinition[$i][3]=="variable based"){

    		$unit=4; 
        }else if($servicedefinition[$i][3]=="Activation based" || $servicedefinition[$i][3]=="activation based"){

    		$unit=5; 
        }

        if($servicedefinition[$i][4]=="Standard" || $servicedefinition[$i][4]=="standard"){
            $nature=1; 
    	}else if($servicedefinition[$i][4]=="Customized" || $servicedefinition[$i][4]=="customized"){
    		$nature=2;
        }else if($servicedefinition[$i][4]=="Variable" || $servicedefinition[$i][4]=="variable"){
    		$nature=3; 
        }
                            
		if($servicedefinition[$i][6]=="Active" || $servicedefinition[$i][6]=="active"){
            $status=1;        
    	}else if($servicedefinition[$i][6]=="Inactive" || $servicedefinition[$i][6]=="inactive"){
    		$status=2;  
        }  


					$qry="SELECT * FROM service_master where serviceCat=? and serviceSubcat=? and serviceName=? and serviceUnit=? and serviceNature=? and serviceClass=?";
					$result=$this->adapter->query($qry,array($resultset1[0]['idCategory'],$resultset2[0]['idSubCategory'],$servicedefinition[$i][2],$unit,$nature,$resultset3[0]['idServiceClass']));
					$resultset=$result->toArray();
					if(!$resultset) {
						$this->adapter->getDriver()->getConnection()->beginTransaction();
						try {           
                            $data['serviceCat']=$resultset1[0]['idCategory'];
				            $data['serviceSubcat']=$resultset2[0]['idSubCategory'];
				            $data['serviceName']=$servicedefinition[$i][2];
				            $data['serviceUnit']=$unit;
				            $data['serviceNature']=$nature;
							$data['serviceClass']=$resultset3[0]['idServiceClass'];
							$data['status']=$status;
							$data['created_at']=date('Y-m-d H:i:s');
							$data['created_by']=1;
							$data['updated_at']=date('Y-m-d H:i:s');
							$data['updated_by']=1;
							$insert=new Insert('service_master');
							$insert->values($data);
							$statement=$this->adapter->createStatement();
							$insert->prepareStatement($this->adapter, $statement);
							$insertresult=$statement->execute();
					        $insert_value += $insert_count+1;	
							$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
							$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
							$this->adapter->getDriver()->getConnection()->rollBack();
						}
					}else{
						$reject_value += $reject_count+1;
				        
					}
				}

	    if($insert_value!=0 && $reject_value==0){

	          $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
	    }else if($insert_value ==0 && $reject_value !=0){

	    	 $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];

	    }else if($insert_value!=0 && $reject_value!=0){

	    $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists  '.$reject_value.'Uploaded  '.$insert_value];
	    }

    }

			}else {
				$ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please verify the csv file'];
			}
			
		}

		return $ret_arr;

	} // close func


	public function uploadservicepartner($param) {

		ini_set('display_errors',true);
		$Uploads_dir = 'public/uploads/csv';
		$tmp_name=$_FILES["myFile"]["tmp_name"]; 
		$name = basename($_FILES["myFile"]["name"]); 
		$imageName = rand(6,66666).'.'. pathinfo($_FILES["myFile"]['name'],PATHINFO_EXTENSION);
    	if(move_uploaded_file($tmp_name, "$Uploads_dir/$imageName")) {
			$r="public/uploads/csv/$imageName";
			$file = fopen($r, "r",FILE_SKIP_EMPTY_LINES);
			$emapData = fgetcsv($file, 10000, ","); 
				$row=0;
				$size=sizeof($emapData);

				if($size=='27' && $emapData !=null) {
				$service_partner=array();
				
				while (($record = fgetcsv($file)) !== FALSE) {
					$row++;
					array_push($service_partner,$record);
				}

		$geography1=0;   $territory1=0;    
	    $geography2=0;   $territory2=0;    
	    $geography3=0;   $territory3=0;    
	    $geography4=0;   $territory4=0;    
	    $geography5=0;   $territory5=0;    
	    $geography6=0;   $territory6=0;    
	    $geography7=0;   $territory7=0;    
	    $geography8=0;   $territory8=0;    
        $geography9=0;   $territory9=0;    
	    $geography10=0;  $territory10=0;    

        $geo_map_value0=0;   $ter_map_value0=0;
	    $geo_map_value1=0;   $ter_map_value1=0;
	    $geo_map_value2=0;   $ter_map_value2=0;
	    $geo_map_value3=0;   $ter_map_value3=0;
	    $geo_map_value4=0;   $ter_map_value4=0;
	    $geo_map_value5=0;   $ter_map_value5=0;
	    $geo_map_value6=0;   $ter_map_value6=0;
	    $geo_map_value7=0;   $ter_map_value7=0;
	    $geo_map_value8=0;   $ter_map_value8=0;
	    $geo_map_value9=0;   $ter_map_value9=0;
	    $geo_map_value10=0;  $ter_map_value10=0;
     
	    $check_value1=array();
	    $array_condition1=array();
	    $check_value2=array();
	    $array_condition2=array();
	    $no_service_partner=array();

	    $insert_count=0;
        $reject_count=0;
        $reject_value=0; 
        $insert_value=0;  

	for($k=0; $k<count($service_partner);$k++){

	    if($service_partner[$k][26]=='' || $service_partner[$k][26]=="null"){
            $status=0; 
            $no_service_partner[]=0;   
            $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status empty'];    
    	}else if($service_partner[$k][26]=="Active" || $service_partner[$k][26]=="active"){

            $status=1;
            $no_service_partner[]=1;   
    	}else if($service_partner[$k][26]=="Inactive" || $service_partner[$k][26]=="inactive"){

    		$status=2;
    		$no_service_partner[]=2;   
        }else{
            $status=0;  
            $no_service_partner[]=0;      
            $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status data'];    
    	}



        if($service_partner[$k][25]=='' || $service_partner[$k][25]=="null"){
		    	$category=0;  
		    	$no_service_partner[]=0;  
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the service category empty'];

		}if($service_partner[$k][25]!=''){

            $cate_string=array();
		    $category=$service_partner[$k][25];	
		    $cate_str= explode(',', $category);
   
		        for($a=0;$a<count($cate_str);$a++){

		    $qry21="SELECT sm.idService,sm.serviceCat,ca.category,ca.idCategory 
		                        FROM service_master as sm
	                         	LEFT JOIN category as ca ON ca.idCategory=sm.serviceCat WHERE sm.status='1' AND ca.category='$cate_str[$a]'";
            
            $result21=$this->adapter->query($qry21,array());
		    $resultset21=$result21->toArray();	

			    if(!$resultset21){
				    	$no_service_partner[]=0;
		                $ret_arr=['code'=>'3','status'=>false,'message'=>'service category value mismatch'];
	             
			    }else{  
			    	
                        $cate_string[]=$resultset21[0]['idCategory'];
                        $category_type=implode(',', $cate_string);
				    //    $no_service_partner[]=$resultset21[0]['idCategory'];
				        $check_value1[]=$resultset21[0]['idCategory'];

	            } 
	              
		    }
             
        }  

      

	    if($service_partner[$k][24]=='' || $service_partner[$k][24]=="null"){
		    	$rendered=0;  
		    	$no_service_partner[]=0;  
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the service partner empty'];

		}if($service_partner[$k][24]!=''){
                $type=array();
                $partner_type = explode(',',$service_partner[$k][24]);
                      
		          if(in_array("Sales Partner", $partner_type)){
				       $type[]=1;
				  } if (in_array("Service Fulfillment Partner", $partner_type)){
		               $type[]=2;
		          } if (in_array("Collections Partner", $partner_type)){
                       $type[]=3;  
		          } if (in_array("Distribution Partner", $partner_type)){
		          	   $type[]=4;
		          }

                $service_type=implode(',', $type);

                 if(!$type){
                 	    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the partner type mismatched'];
                  }
                 
        }   


	    if($service_partner[$k][23]=='' || $service_partner[$k][23]=="null"){
		    	$rendered=0;  
		    	$no_service_partner[]=0;  
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the service rendered empty'];

		}if($service_partner[$k][23]!=''){
                $service_render='0';
                $no_service = explode(',',$service_partner[$k][23]);
                    $render=array();
		          if(in_array("Sales", $no_service)){
				       $render[]=1;
				  } if (in_array("Service Fulfillment", $no_service)){
		               $render[]=2;
		          } if (in_array("Collections", $no_service)){
                       $render[]=3;  
		          } if (in_array("Distribution", $no_service)){
		          	   $render[]=4;
		          }
                 
                  $service_render=implode(',', $render);

                 if(!$render){
                 	    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the service rendered mismatched'];
                  }
                         
        }   


        if($service_partner[$k][22]!=''){ 

            $ter_value20=$service_partner[$k][22];		   
	        $qry20="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value20' AND idTerritoryTitle ='10'";

				$result20=$this->adapter->query($qry20,array());
			    $resultset20=$result20->toArray();	

			    if(!$resultset20){
				    	$no_service_partner[]=0;
				    	$check_value1[]=0; 
		                $ter_map_value10=0;
		                $array_condition1[]=$ter_map_value10;
		                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory10 value mismatch'];
	             
			    }else{  
				       $no_service_partner[]=$resultset20[0]['idTerritory'];
				       $check_value1[]=$resultset20[0]['idTerritory'];
				       $ter_map_value10=1;
				       $array_condition1[]=$ter_map_value10;

	               }    
        }else{
        	$no_service_partner[]=0;
        } 


	    if($service_partner[$k][21]!=''){ 

            $ter_value9=$service_partner[$k][21];		   
	        $qry19="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value9' AND idTerritoryTitle ='9'";

				$result19=$this->adapter->query($qry19,array());
			    $resultset19=$result19->toArray();	

			    if(!$resultset19){
				    	$no_service_partner[]=0;
				    	$check_value1[]=0; 
		                $ter_map_value9=0;
		                $array_condition1[]=$ter_map_value9;
		                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory9 value mismatch'];
	             
			    }else{  
				       $no_service_partner[]=$resultset19[0]['idTerritory'];
				       $check_value1[]=$resultset19[0]['idTerritory'];
				       $ter_map_value9=1;
				       $array_condition1[]=$ter_map_value9;

	               }    
        }else{
        	$no_service_partner[]=0;
        }

		if($service_partner[$k][20]!=''){ 

            $ter_value8=$service_partner[$k][20];		   
	        $qry18="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value8' AND idTerritoryTitle ='8'";

				$result18=$this->adapter->query($qry18,array());
			    $resultset18=$result18->toArray();	

			    if(!$resultset18){
				    	$no_service_partner[]=0;
				    	$check_value1[]=0; 
		                $ter_map_value8=0;
		                $array_condition1[]=$ter_map_value8;
		                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory8 value mismatch'];
	             
			    }else{  
				       $no_service_partner[]=$resultset18[0]['idTerritory'];
				       $check_value1[]=$resultset18[0]['idTerritory'];
				       $ter_map_value8=1;
				       $array_condition1[]=$ter_map_value8;

	               }    
        }else{
        	$no_service_partner[]=0;
        }
        
        if($service_partner[$k][19]!=''){ 

            $ter_value7=$service_partner[$k][19];		   
	        $qry17="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value7' AND idTerritoryTitle ='7'";

				$result17=$this->adapter->query($qry17,array());
			    $resultset17=$result17->toArray();	

			    if(!$resultset17){
				    	$no_service_partner[]=0;
				    	$check_value1[]=0; 
		                $ter_map_value7=0;
		                $array_condition1[]=$ter_map_value7;
		                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory7 value mismatch'];
	             
			    }else{  
				       $no_service_partner[]=$resultset17[0]['idTerritory'];
				       $check_value1[]=$resultset17[0]['idTerritory'];
				       $ter_map_value7=1;
				       $array_condition1[]=$ter_map_value7;

	               }    
        }else{
        	$no_service_partner[]=0;
        }

        if($service_partner[$k][18]!=''){ 

            $ter_value6=$service_partner[$k][18];		   
	        $qry16="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value6' AND idTerritoryTitle ='6'";

				$result16=$this->adapter->query($qry16,array());
			    $resultset16=$result16->toArray();	

			    if(!$resultset16){
				    	$no_service_partner[]=0;
				    	$check_value1[]=0; 
		                $ter_map_value6=0;
		                $array_condition1[]=$ter_map_value6;
		                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory6 value mismatch'];
	             
			    }else{  
				       $no_service_partner[]=$resultset16[0]['idTerritory'];
				       $check_value1[]=$resultset16[0]['idTerritory'];
				       $ter_map_value6=1;
				       $array_condition1[]=$ter_map_value6;

	               }    
        }else{
        	$no_service_partner[]=0;
        }

	    if($service_partner[$k][17]!=''){ 

            $ter_value5=$service_partner[$k][17];		   
	        $qry15="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value5' AND idTerritoryTitle ='5'";

				$result15=$this->adapter->query($qry15,array());
			    $resultset15=$result15->toArray();	

			    if(!$resultset15){
				    	$no_service_partner[]=0;
				    	$check_value1[]=0; 
		                $ter_map_value5=0;
		                $array_condition1[]=$ter_map_value5;
		                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory5 value mismatch'];
	             
			    }else{  
				       $no_service_partner[]=$resultset15[0]['idTerritory'];
				       $check_value1[]=$resultset15[0]['idTerritory'];
				       $ter_map_value5=1;
				       $array_condition1[]=$ter_map_value5;

	               }    
        }else{
        	$no_service_partner[]=0;
        }

		if($service_partner[$k][16]!=''){ 

            $ter_value4=$service_partner[$k][16];		   
	        $qry14="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value4' AND idTerritoryTitle ='4'";

				$result14=$this->adapter->query($qry14,array());
			    $resultset14=$result14->toArray();	

			    if(!$resultset14){
				    	$no_service_partner[]=0;
				    	$check_value1[]=0; 
		                $ter_map_value4=0;
		                $array_condition1[]=$ter_map_value4;
		                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory4 value mismatch'];
	             
			    }else{  
				       $no_service_partner[]=$resultset14[0]['idTerritory'];
				       $check_value1[]=$resultset14[0]['idTerritory'];
				       $ter_map_value4=1;
				       $array_condition1[]=$ter_map_value4;

	               }    
        }else{
        	$no_service_partner[]=0;
        }

		if($service_partner[$k][15]!=''){ 

            $ter_value3=$service_partner[$k][15];		   
	        $qry13="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value3' AND idTerritoryTitle ='3'";

				$result13=$this->adapter->query($qry13,array());
			    $resultset13=$result13->toArray();	

			    if(!$resultset13){
				    	$no_service_partner[]=0;
				    	$check_value1[]=0;  
		                $ter_map_value3=0;
		                $array_condition1[]=$ter_map_value3;
		                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory3 value mismatch'];
	             
			    }else{  
				       $no_service_partner[]=$resultset13[0]['idTerritory'];
				       $check_value1[]=$resultset13[0]['idTerritory'];
				       $ter_map_value3=1;
				       $array_condition1[]=$ter_map_value3;

	               }    
        }else{
        	$no_service_partner[]=0;
        }

		if($service_partner[$k][14]!=''){ 

            $ter_value2=$service_partner[$k][14];		   
	        $qry12="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value2' AND idTerritoryTitle ='2'";

				$result12=$this->adapter->query($qry12,array());
			    $resultset12=$result12->toArray();	

			    if(!$resultset12){
				    	$no_service_partner[]=0;
				    	$check_value1[]=0; 
		                $ter_map_value2=0;
		                $array_condition1[]=$ter_map_value2;
		                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory2 value mismatch'];
	             
			    }else{  
				       $no_service_partner[]=$resultset12[0]['idTerritory'];
				       $check_value1[]=$resultset12[0]['idTerritory'];
				       $ter_map_value2=1;
				       $array_condition1[]=$ter_map_value2;

	               }    
        }else{
        	$no_service_partner[]=0;
        }

		if($service_partner[$k][13]!=''){ 
                $ter_value1=$service_partner[$k][13];		   
		        $qry11="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value1' AND idTerritoryTitle ='1'";

				$result11=$this->adapter->query($qry11,array());
			    $resultset11=$result11->toArray();	

			    if(!$resultset11){
				    	$no_service_partner[]=0;
				    	$check_value1[]=0;  
		                $ter_map_value1=0;
		                $array_condition1[]=$ter_map_value1;
		                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory1 value mismatch'];
	             
			    }else{  
				       $no_service_partner[]=$resultset11[0]['idTerritory'];
				       $check_value1[]=$resultset11[0]['idTerritory'];
				       $ter_map_value1=1;
				       $array_condition1[]=$ter_map_value1;

	               }    
        }else{
        	$no_service_partner[]=0;
        }

       if($service_partner[$k][12]!=''){ 
                $geo_value10=$service_partner[$k][12];		   
		        $qry10="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value10'
		        AND idGeographyTitle ='10'";

				$result10=$this->adapter->query($qry10,array());
			    $resultset10=$result10->toArray();	

			    if(!$resultset10){
			    	$no_service_partner[]=0;
			    	$check_value1[]=0; 
			    	$geo_value=$check_value1;   
	                $geo_map_value10=0;
	                $array_condition1[]=$geo_map_value10;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography10 value mismatch'];

	             
			    }else{  
			       $no_service_partner[]=$resultset10[0]['idGeography'];
			       $check_value1[]=$resultset10[0]['idGeography'];
			       $geo_map_value10=1;
			       $array_condition1[]=$geo_map_value10;
	               }    
        }else{
        	$no_service_partner[]=0;
        }

        if($service_partner[$k][11]!=''){ 
       	
                $geo_value9=$service_partner[$k][11];		   
		        $qry9="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value9'
		        AND idGeographyTitle ='9'";

				$result9=$this->adapter->query($qry9,array());
			    $resultset9=$result9->toArray();	

			    if(!$resultset9){
			    	$no_service_partner[]=0;
			    	$check_value1[]=0; 
			    	$geo_value=$check_value1;   
	                $geo_map_value9=0;
	                $array_condition1[]=$geo_map_value9;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography9 value mismatch'];

	             
			    }else{  
			       $no_service_partner[]=$resultset9[0]['idGeography'];
			       $check_value1[]=$resultset9[0]['idGeography'];
			       $geo_map_value9=1;
			       $array_condition1[]=$geo_map_value9;
	               }    
        }else{
        	$no_service_partner[]=0;
        }

        if($service_partner[$k][10]!=''){ 
       	
                $geo_value8=$service_partner[$k][10];		   
		        $qry8="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value8'
		        AND idGeographyTitle ='8'";

				$result8=$this->adapter->query($qry8,array());
			    $resultset8=$result8->toArray();	

			    if(!$resultset8){
			    	$no_service_partner[]=0;
			    	$check_value1[]=0; 
			    	$geo_value=$check_value1;   
	                $geo_map_value8=0;
	                $array_condition1[]=$geo_map_value8;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography8 value mismatch'];

	             
			    }else{  
			       $no_service_partner[]=$resultset8[0]['idGeography'];
			       $check_value1[]=$resultset8[0]['idGeography'];
			       $geo_map_value8=1;
			       $array_condition1[]=$geo_map_value8;
	               }    
        }else{
        	$no_service_partner[]=0;
        }

        if($service_partner[$k][9]!=''){ 
       	
                $geo_value7=$service_partner[$k][9];		   
		        $qry7="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value7'
		        AND idGeographyTitle ='7'";

				$result7=$this->adapter->query($qry7,array());
			    $resultset7=$result7->toArray();	

			    if(!$resultset7){
			    	$no_service_partner[]=0;
			    	$check_value1[]=0; 
			    	$geo_value=$check_value1;   
	                $geo_map_value7=0;
	                $array_condition1[]=$geo_map_value7;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography7 value mismatch'];

	             
			    }else{ 
			       $no_service_partner[]=$resultset7[0]['idGeography'];
			       $check_value1[]=$resultset7[0]['idGeography'];
			       $geo_map_value7=1;
			       $array_condition1[]=$geo_map_value7;
	               }    
        }else{
        	$no_service_partner[]=0;
        }

        if($service_partner[$k][8]!=''){ 
       	
                $geo_value6=$service_partner[$k][8];		   
		        $qry6="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value6'
		        AND idGeographyTitle ='6'";

				$result6=$this->adapter->query($qry6,array());
			    $resultset6=$result6->toArray();	

			    if(!$resultset6){
			    	$no_service_partner[]=0;
			    	$check_value1[]=0; 
			    	$geo_value=$check_value1;   
	                $geo_map_value6=0;
	                $array_condition1[]=$geo_map_value6;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography6 value mismatch'];

	             
			    }else{  
			       $no_service_partner[]=$resultset6[0]['idGeography'];
			       $check_value1[]=$resultset6[0]['idGeography'];
			       $geo_map_value6=1;
			       $array_condition1[]=$geo_map_value6;
	               }    
        }else{
        	$no_service_partner[]=0;
        }

        if($service_partner[$k][7]!=''){ 
       	
                $geo_value5=$service_partner[$k][7];		   
		        $qry5="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value5'
		        AND idGeographyTitle ='5'";

				$result5=$this->adapter->query($qry5,array());
			    $resultset5=$result5->toArray();	

			    if(!$resultset5){
			    	$no_service_partner[]=0;
			    	$check_value1[]=0; 
			    	$geo_value=$check_value1;   
	                $geo_map_value5=0;
	                $array_condition1[]=$geo_map_value5;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography5 value mismatch'];

	             
			    }else{  
			       $no_service_partner[]=$resultset5[0]['idGeography'];
			       $check_value1[]=$resultset5[0]['idGeography'];
			       $geo_map_value5=1;
			       $array_condition1[]=$geo_map_value5;
	               }    
        }else{
        	$no_service_partner[]=0;
        }

        if($service_partner[$k][6]!=''){ 
       	
                $geo_value4=$service_partner[$k][6];		   
		        $qry4="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value4'
		        AND idGeographyTitle ='4'";

				$result4=$this->adapter->query($qry4,array());
			    $resultset4=$result4->toArray();	

			    if(!$resultset4){
			    	$no_service_partner[]=0;
			    	$check_value1[]=0; 
			    	$geo_value=$check_value1;   
	                $geo_map_value4=0;
	                $array_condition1[]=$geo_map_value4;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography4 value mismatch'];

	             
			    }else{ 
			       $no_service_partner[]=$resultset4[0]['idGeography'];
			       $check_value1[]=$resultset4[0]['idGeography'];
			       $geo_map_value4=1;
			       $array_condition1[]=$geo_map_value4;
	               }    
        }else{
        	$no_service_partner[]=0;
        }

        if($service_partner[$k][5]!=''){ 
       	
                $geo_value3=$service_partner[$k][5];		   
		        $qry3="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value3'
		        AND idGeographyTitle ='3'";

				$result3=$this->adapter->query($qry3,array());
			    $resultset3=$result3->toArray();	

			    if(!$resultset3){
			    	$no_service_partner[]=0;
			    	$check_value1[]=0; 
			    	$geo_value=$check_value1;   
	                $geo_map_value3=0;
	                $array_condition1[]=$geo_map_value3;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography3 value mismatch'];

	             
			    }else{  
			       $no_service_partner[]=$resultset3[0]['idGeography'];
			       $check_value1[]=$resultset3[0]['idGeography'];
			       $geo_map_value3=1;
			       $array_condition1[]=$geo_map_value3;
	               }    
        }else{
        	$no_service_partner[]=0;
        }

        if($service_partner[$k][4]!=''){ 
       	
                $geo_value2=$service_partner[$k][4];		   
		        $qry2="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value2'
		        AND idGeographyTitle ='2'";
				$result2=$this->adapter->query($qry2,array());
			    $resultset2=$result2->toArray();	

			    if(!$resultset2){
			    	$no_service_partner[]=0;
			    	$check_value1[]=0; 
			    	$geo_value=$check_value1;   
	                $geo_map_value2=0;
	                $array_condition1[]=$geo_map_value2;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography2 value mismatch'];

	             
			    }else{  
			       $no_service_partner[]=$resultset2[0]['idGeography'];
			       $check_value1[]=$resultset2[0]['idGeography'];
			       $geo_map_value2=1;
			       $array_condition1[]=$geo_map_value2;
	               }    
        }else{
        	$no_service_partner[]=0;
        }

        if($service_partner[$k][3]!=''){ 
       	
                $geo_value1=$service_partner[$k][3];		   
		        $qry1="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value1'
		        AND idGeographyTitle ='1'";

				$result1=$this->adapter->query($qry1,array());
			    $resultset1=$result1->toArray();	

			    if(!$resultset1){
			    	$no_service_partner[]=0;
			    	$check_value1[]=0; 
			    	$geo_value=$check_value1;   
	                $geo_map_value1=0;
	                $array_condition1[]=$geo_map_value1;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography1 value mismatch'];

	             
			    }else{  
			       $no_service_partner[]=$resultset1[0]['idGeography'];
			       $check_value1[]=$resultset1[0]['idGeography'];
			       $geo_map_value1=1;
			       $array_condition1[]=$geo_map_value1;
	               }    
        }else{
        	$no_service_partner[]=0;
        }

       if($service_partner[$k][2]=='' || $service_partner[$k][2]=="null"){
    	$mobile=0; 
    	$no_service_partner[]=0;   
        $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the mobile empty'];

		}else if(!is_numeric($service_partner[$k][2])){
                $mobile=0; 
                $no_service_partner[]=0; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Mobile no numeric only'];  

        }else if((strlen($service_partner[$k][2])<10) || (strlen($service_partner[$k][2])>10)){
                $mobile=0; 
                 $no_service_partner[]=0; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please enter valid mobile number'];  
        }else if($service_partner[$k][2]!='' || $service_partner[$k][2]!="null"){
                $mobile=1;  
                $no_service_partner[]=$service_partner[$k][2];  
                 
        }

        if($service_partner[$k][1]=='' || $service_partner[$k][1]=="null"){
		    	$email_id=0;   
		    	$no_service_partner[]=0; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the email id empty'];

		}if($service_partner[$k][1]!='' || $service_partner[$k][1]!="null"){
                $email_id=1;    
                $no_service_partner[]=$service_partner[$k][1]; 
        }   

        if($service_partner[$k][0]=='' || $service_partner[$k][0]=="null"){
		    	$name=0;  
		    	$no_service_partner[]=0;  
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the factory name empty'];

		}if($service_partner[$k][0]!='' || $service_partner[$k][0]!="null"){
                $name=1; 
                $no_service_partner[]=$service_partner[$k][0];   
                 
        }   


         
                
	} // close loop $no_warehouse;


	if(count($array_condition1)!= 0){

	    for($j=0; $j<count($array_condition1);$j++){ 
            $zero=0;
        if(in_array($zero,$array_condition1)){

           $geography=0;
        }else{
           $geography=1;

        }
                   
    }

	}else{

		  $geography=1;
	}


   $number=$no_service_partner;
   $check= array_reverse($no_service_partner);


 if($name!=0 && $mobile!=0 && $email_id!=0 && $geography!=0 && $status!=0){

 	    $insert_count=0;
        $reject_count=0;
        $reject_value=0; 
        $insert_value=0;  

	for($i=0; $i<count($service_partner);$i++){

		        $geo_value1=$service_partner[$i][3];		   
		        $qry1="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value1'
		        AND idGeographyTitle ='1'";
				$result1=$this->adapter->query($qry1,array());
			    $resultset1=$result1->toArray();

			    $geo_value2=$service_partner[$i][4];		   
		        $qry2="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value2'
		        AND idGeographyTitle ='2'";
				$result2=$this->adapter->query($qry2,array());
			    $resultset2=$result2->toArray();

			    $geo_value3=$service_partner[$i][5];		   
		        $qry3="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value3'
		        AND idGeographyTitle ='3'";
				$result3=$this->adapter->query($qry3,array());
			    $resultset3=$result3->toArray();

			    $geo_value4=$service_partner[$i][6];		   
		        $qry4="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value4'
		        AND idGeographyTitle ='4'";
				$result4=$this->adapter->query($qry4,array());
			    $resultset4=$result4->toArray();

			    $geo_value5=$service_partner[$i][7];		   
		        $qry5="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value5'
		        AND idGeographyTitle ='5'";
				$result5=$this->adapter->query($qry5,array());
			    $resultset5=$result5->toArray();

			    $geo_value6=$service_partner[$i][8];		   
		        $qry6="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value6'
		        AND idGeographyTitle ='6'";
				$result6=$this->adapter->query($qry6,array());
			    $resultset6=$result6->toArray();

			    $geo_value7=$service_partner[$i][9];	
		        $qry7="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value7'
		        AND idGeographyTitle ='7'";
				$result7=$this->adapter->query($qry7,array());
			    $resultset7=$result7->toArray();

			    $geo_value8=$service_partner[$i][10];		   
		        $qry8="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value8'
		        AND idGeographyTitle ='8'";
				$result8=$this->adapter->query($qry8,array());
			    $resultset8=$result8->toArray();

			    $geo_value9=$service_partner[$i][11];		   
		        $qry9="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value9'
		        AND idGeographyTitle ='9'";
				$result9=$this->adapter->query($qry9,array());
			    $resultset9=$result9->toArray();

			    $geo_value10=$service_partner[$i][12];		   
		        $qry10="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value10'
		        AND idGeographyTitle ='10'";
				$result10=$this->adapter->query($qry10,array());
			    $resultset10=$result10->toArray();
                
                $ter_value11=$service_partner[$i][13];		   
		        $qry11="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value11' AND idTerritoryTitle ='1'";
				$result11=$this->adapter->query($qry11,array());
			    $resultset11=$result11->toArray();

			    $ter_value12=$service_partner[$i][14];		   
		        $qry12="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value12' AND idTerritoryTitle ='2'";
				$result12=$this->adapter->query($qry12,array());
			    $resultset12=$result12->toArray();	

			    $ter_value13=$service_partner[$i][15];		   
		        $qry13="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value13' AND idTerritoryTitle ='3'";
				$result13=$this->adapter->query($qry13,array());
			    $resultset13=$result13->toArray();	

			    $ter_value14=$service_partner[$i][16];		   
		        $qry14="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value14' AND idTerritoryTitle ='4'";
				$result14=$this->adapter->query($qry14,array());
			    $resultset14=$result14->toArray();	

			    $ter_value15=$service_partner[$i][17];		   
		        $qry15="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value15' AND idTerritoryTitle ='5'";
				$result15=$this->adapter->query($qry15,array());
			    $resultset15=$result15->toArray();	

			    $ter_value16=$service_partner[$i][18];		   
		        $qry16="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value16' AND idTerritoryTitle ='6'";
				$result16=$this->adapter->query($qry16,array());
			    $resultset16=$result16->toArray();	

			    $ter_value17=$service_partner[$i][19];		   
		        $qry17="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value17' AND idTerritoryTitle ='7'";
				$result17=$this->adapter->query($qry17,array());
			    $resultset17=$result17->toArray();	

			    $ter_value18=$service_partner[$i][20];		   
		        $qry18="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value18' AND idTerritoryTitle ='8'";
				$result18=$this->adapter->query($qry18,array());
			    $resultset18=$result18->toArray();	

			    $ter_value19=$service_partner[$i][21];		   
		        $qry19="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value19' AND idTerritoryTitle ='9'";
				$result19=$this->adapter->query($qry19,array());
			    $resultset19=$result19->toArray();

	            $ter_value20=$service_partner[$i][22];		   
		        $qry20="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value20' AND idTerritoryTitle ='10'";
				$result20=$this->adapter->query($qry20,array());
			    $resultset20=$result20->toArray();	
	
            $qry_list="SELECT idServicePartner,ContactName,ContactEmail,ContactMobile FROM service_partner WHERE ContactName =? and ContactEmail =? and ContactMobile =?";
			 $result_list=$this->adapter->query($qry_list,array($service_partner[$i][0],$service_partner[$i][1],$service_partner[$i][2]));
			 $resultset_list=$result_list->toArray();

        if($service_partner[$i][26]=="Active" || $service_partner[$i][26]=="active"){

            $status=1;
    	}else if($service_partner[$i][26]=="Inactive" || $service_partner[$i][26]=="inactive"){

    		$status=2;  
        }

        if($service_partner[$i][25]!=''){

            $cate_string=array();
		    $category=$service_partner[$i][25];	
		    $cate_str= explode(',', $category);
   
		        for($a=0;$a<count($cate_str);$a++){

		    $qry21="SELECT sm.idService,sm.serviceCat,ca.category,ca.idCategory 
		                        FROM service_master as sm
	                         	LEFT JOIN category as ca ON ca.idCategory=sm.serviceCat WHERE sm.status='1' AND ca.category='$cate_str[$a]'";
            
	            $result21=$this->adapter->query($qry21,array());
			    $resultset21=$result21->toArray();	 
			    	
                $cate_string[]=$resultset21[0]['idCategory'];
                $category_type=implode(',', $cate_string);
		       	              
		    }
             
        } 

        if($service_partner[$i][24]!=''){
                $type=array();
                $partner_type = explode(',',$service_partner[$i][24]);
                      
		          if(in_array("Sales Partner", $partner_type)){
				       $type[]=1;
				  } if (in_array("Service Fulfillment Partner", $partner_type)){
		               $type[]=2;
		          } if (in_array("Collections Partner", $partner_type)){
                       $type[]=3;  
		          } if (in_array("Distribution Partner", $partner_type)){
		          	   $type[]=4;
		          }
                $service_type=implode(',', $type);
                 
        } 
        if($service_partner[$i][23]!=''){
                $service_render='0';
                $no_service = explode(',',$service_partner[$i][23]);
                    $render=array();
		          if(in_array("Sales", $no_service)){
				       $render[]=1;
				  } if (in_array("Service Fulfillment", $no_service)){
		               $render[]=2;
		          } if (in_array("Collections", $no_service)){
                       $render[]=3;  
		          } if (in_array("Distribution", $no_service)){
		          	   $render[]=4;
		          }
                 
                  $service_render=implode(',', $render);                        
        }


			if(!$resultset_list){
						$this->adapter->getDriver()->getConnection()->beginTransaction();
						try {					
							$data['ContactName']=$service_partner[$i][0];
							$data['ContactEmail']=$service_partner[$i][1];
							$data['ContactMobile']=$service_partner[$i][2];							
							$data['g1']=(($service_partner[$i][3]!='')? $resultset1[0]['idGeography']:0);
							$data['g2']=(($service_partner[$i][4]!='')? $resultset2[0]['idGeography']:0);
							$data['g3']=(($service_partner[$i][5]!='')? $resultset3[0]['idGeography']:0);
							$data['g4']=(($service_partner[$i][6]!='')? $resultset4[0]['idGeography']:0);
							$data['g5']=(($service_partner[$i][7]!='')? $resultset5[0]['idGeography']:0);
							$data['g6']=(($service_partner[$i][8]!='')? $resultset6[0]['idGeography']:0);
							$data['g7']=(($service_partner[$i][9]!='')? $resultset7[0]['idGeography']:0);
							$data['g8']=(($service_partner[$i][10]!='')? $resultset8[0]['idGeography']:0);
							$data['g9']=(($service_partner[$i][11]!='')? $resultset9[0]['idGeography']:0);
							$data['g10']=(($service_partner[$i][12]!='')? $resultset10[0]['idGeography']:0);
							$data['t1']=(($service_partner[$i][13]!='')? $resultset11[0]['idTerritory']:0);
							$data['t2']=(($service_partner[$i][14]!='')? $resultset12[0]['idTerritory']:0);
							$data['t3']=(($service_partner[$i][15]!='')? $resultset13[0]['idTerritory']:0);
							$data['t4']=(($service_partner[$i][16]!='')? $resultset14[0]['idTerritory']:0);
							$data['t5']=(($service_partner[$i][17]!='')? $resultset15[0]['idTerritory']:0);
							$data['t6']=(($service_partner[$i][18]!='')? $resultset16[0]['idTerritory']:0);
							$data['t7']=(($service_partner[$i][19]!='')? $resultset17[0]['idTerritory']:0);
							$data['t8']=(($service_partner[$i][20]!='')? $resultset18[0]['idTerritory']:0);
							$data['t9']=(($service_partner[$i][21]!='')? $resultset19[0]['idTerritory']:0);
							$data['t10']=(($service_partner[$i][22]!='')? $resultset20[0]['idTerritory']:0);
							$data['ServiceRendered']=$service_render;
							$data['ServicePartner']=$service_type;
							$data['ServiceCategory']=$category_type;
							$data['status']=$status;
							$data['created_at']=date('Y-m-d H:i:s');
							$data['created_by']=1;
							$data['updated_at']=date('Y-m-d H:i:s');
							$data['updated_by']=1;
							$insert=new Insert('service_partner');
							$insert->values($data);
							$statement=$this->adapter->createStatement();
							$insert->prepareStatement($this->adapter, $statement);
							$insertresult=$statement->execute();
							$insert_value +=$insert_count+1;
							$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
							$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
							$this->adapter->getDriver()->getConnection()->rollBack();
						}
					} else {

						$reject_value += $reject_count+1;
				
					}

                }

        if($insert_value!=0 && $reject_value==0){

              $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully '.$insert_value .' data'];
        }else if($insert_value ==0 && $reject_value !=0){

        	 $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists '.$reject_value.' data'];

        }else if($insert_value!=0 && $reject_value!=0){

        $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists  '.$reject_value.'Uploaded  '.$insert_value];
        }
	
				}
			} else {
				   $ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please verify the csv file'];
			}

			
		}

		return $ret_arr;
	} // close func

	public function uploadsegmenttype($param) {

		ini_set('display_errors',true);
		$Uploads_dir = 'public/uploads/csv';
		$tmp_name=$_FILES["myFile"]["tmp_name"]; 
		$name = basename($_FILES["myFile"]["name"]); 
		$imageName = rand(6,66666).'.'. pathinfo($_FILES["myFile"]['name'],PATHINFO_EXTENSION);
    	if(move_uploaded_file($tmp_name, "$Uploads_dir/$imageName")) {
			$r="public/uploads/csv/$imageName";
			$file = fopen($r, "r",FILE_SKIP_EMPTY_LINES);
			$emapData = fgetcsv($file, 10000, ","); 
				$row=0;
				$size=sizeof($emapData);

				if($size=='2' && $emapData !=null) {
				$segmenttype=array();
				$no_segmenttype=array();
				while (($record = fgetcsv($file)) !== FALSE) {
					$row++;
					array_push($segmenttype,$record);
				}

	    $insert_count=0;
        $reject_count=0;
        $reject_value=0; 
        $insert_value=0;  

	for($k=0; $k<count($segmenttype);$k++) {

	 	if($segmenttype[$k][1]=='' || $segmenttype[$k][1]=="null"){
                $status=0; 
                $no_segmenttype[]=$status;   
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status empty'];    
        	}else if($segmenttype[$k][1]=="Active" || $segmenttype[$k][1]=="active"){

                $status=1;
                 $no_segmenttype[]=$status;   
        	}else if($segmenttype[$k][1]=="Inactive" || $segmenttype[$k][1]=="inactive"){

        		$status=2;
        		 $no_segmenttype[]=$status;   
            }else{
                $status=0; 
                 $no_segmenttype[]=$status;       
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status data'];    
        	}

        if($segmenttype[$k][0]=='' || $segmenttype[$k][0]=="null"){
		    	$segment=0;  
		    	 $no_segmenttype[]=$segment;     
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the segment type empty'];

		    }else if($segmenttype[$k][0]!='' || $segmenttype[$k][0]!="null"){
                $segment=1;   
                 $no_segmenttype[]=$segment;    
                 
        }
                   
	}

if(count($no_segmenttype)!= 0){

	for($j=0; $j<count($no_segmenttype);$j++){ 
            $zero=0;
        if(in_array($zero,$no_segmenttype)){

           $check=0;
        }else{
           $check=1;

        }
                   
    }

	}else{

		  $check=0;
		  $ret_arr=['code'=>'3','status'=>false,'message'=>'Excel data is empty'];
	}

	  
 if($check!=0){

	for($i=0; $i<count($segmenttype);$i++) {

	    if($segmenttype[$i][1]=="Active" || $segmenttype[$i][1]=="active"){
                $status=1;
        }else if($segmenttype[$i][1]=="Inactive" || $segmenttype[$i][1]=="inactive"){

        		$status=2;
        }
						
	
	$qry="SELECT idsegmentType,segmentName FROM segment_type where segmentName=?";
	$result=$this->adapter->query($qry,array($segmenttype[$i][0]));
	$resultset=$result->toArray();

					if(!$resultset){
						$this->adapter->getDriver()->getConnection()->beginTransaction();
						try {
				
							$data['segmentName']=$segmenttype[$i][0];
							$data['status']=$status;
							$data['created_at']=date('Y-m-d H:i:s');
							$data['created_by']=1;
							$data['updated_at']=date('Y-m-d H:i:s');
							$data['updated_by']=1;
							$insert=new Insert('segment_type');
							$insert->values($data);
							$statement=$this->adapter->createStatement();
							$insert->prepareStatement($this->adapter, $statement);
							$insertresult=$statement->execute();
							$insert_value +=$insert_count+1;
					    //    $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
							$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
							$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
							$this->adapter->getDriver()->getConnection()->rollBack();
						}
					} else {

						$reject_value += $reject_count+1;
						//$ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];
				
					}

                }

        if($insert_value!=0 && $reject_value==0){

              $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
        }else if($insert_value ==0 && $reject_value !=0){

        	 $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists data'];

        }else if($insert_value!=0 && $reject_value!=0){

        $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists  '.$reject_value.'Uploaded  '.$insert_value];
        }
		
	}
			} else {
				   $ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please verify the csv file'];
			}

			
		}

		return $ret_arr;

	} // close func


	public function uploadcustomerdefinition($param){

		ini_set('display_errors',true);
		$Uploads_dir = 'public/uploads/csv';
		$tmp_name=$_FILES["myFile"]["tmp_name"]; 
		$name = basename($_FILES["myFile"]["name"]); 
		$imageName = rand(6,66666).'.'. pathinfo($_FILES["myFile"]['name'],PATHINFO_EXTENSION);
    	if(move_uploaded_file($tmp_name, "$Uploads_dir/$imageName")){
			$r="public/uploads/csv/$imageName";
			$file = fopen($r, "r",FILE_SKIP_EMPTY_LINES);
			$emapData = fgetcsv($file, 10000, ","); 
				$row=0;
				$size=sizeof($emapData);

				if($size=='38' && $emapData !=null) {
				$customer_diff=array();
				$no_customer_diff=array();
				
				while (($record = fgetcsv($file)) !== FALSE) {
					$row++;
					array_push($customer_diff,$record);
				}


	    $array_condition=array();

	    $insert_count=0;
        $reject_count=0;
        $reject_value=0; 
        $insert_value=0;  
      
	 for($k=0; $k<count($customer_diff);$k++){

		if($customer_diff[$k][37]=='' || $customer_diff[$k][37]=="null"){
                $status=0;  
                  $no_customer_diff[]=$status;      
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status empty'];    
        	}else if($customer_diff[$k][37]=="Active" || $customer_diff[$k][37]=="active"){

                $status=1;

                 $no_customer_diff[]=$status;   
        	}else if($customer_diff[$k][37]=="Inactive" || $customer_diff[$k][37]=="inactive"){

        		$status=2;
     
        		 $no_customer_diff[]=$status;    
            }else{
                $status=0;    
    
                $no_customer_diff[]=$status;  
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status data'];    
        	}
            // check sales employee
            if($customer_diff[$k][36]=='' || $customer_diff[$k][36]=="null"){
                $employee=0;  
                  $no_customer_diff[]=$employee;      
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the employee name'];    
            }else if($customer_diff[$k][36]!='' && $customer_diff[$k][36]!="null"){

                $qry35="SELECT * FROM `team_member_master` as tm LEFT JOIN sales_hierarchy as sl ON sl.idSaleshierarchy=tm.idSaleshierarchy WHERE tm.name='".$customer_diff[$k][36]."' AND tm.idSaleshierarchy in(SELECT idSaleshierarchy FROM sales_hierarchy WHERE saleshierarchyName='".$customer_diff[$k][35]."')";

                $result35=$this->adapter->query($qry35,array());
                $resultset35=$result35->toArray(); 
                if (!$resultset35)
                 {
                      $employee=0; 
                $no_customer_diff[]=$employee;  
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the employee data']; 
                }
                else
                {
                    $employee=1; 
                $no_customer_diff[]=$employee;    
                }
                  
            }
            
            //sales hierarchy
            if($customer_diff[$k][35]=='' || $customer_diff[$k][35]=="null"){
                $sl=0;  
                  $no_customer_diff[]=$sl;      
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the sales hierarchy empty'];    
            }else if($customer_diff[$k][35]!='' && $customer_diff[$k][35]!="null")
            {

                $qry34="SELECT idSaleshierarchy,saleshierarchyType,saleshierarchyName FROM sales_hierarchy WHERE saleshierarchyName='".$customer_diff[$k][35]."'";
                $result34=$this->adapter->query($qry34,array());
                $resultset34=$result34->toArray(); 
                if(!$resultset34)
                {
                   $sl=0;    
    
                $no_customer_diff[]=$sl;  
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check sales hierarchy data']; 
                } 
                else
                {
                     $sl=1; 
                     $no_customer_diff[]=$sl; 
                }
                  
            }
                



		if($customer_diff[$k][34]=='' || $customer_diff[$k][34]=="null"){
	    	$stock_payment_type=0;  
	
	    	 $no_customer_diff[]=$stock_payment_type;
        $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the payment type value empty'];

		}else if($customer_diff[$k][34]!='' || $customer_diff[$k][34]!="null"){
           
     
             if($customer_diff[$k][34]=='Payment on delivery'){
               $stock_payment_type=1;  
          
                $no_customer_diff[]=$stock_payment_type;
             }else if ($customer_diff[$k][34]=='Advance payment'){
               $stock_payment_type=2; 
   
                 $no_customer_diff[]=$stock_payment_type;
             }else if ($customer_diff[$k][34]=='Payment on Service completion'){
               $stock_payment_type=3; 
             
                   $no_customer_diff[]=$stock_payment_type;
             }else{
                $stock_payment_type=0;
         
                     $no_customer_diff[]=$stock_payment_type;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the payment type value mismatch'];
             }  
        }  
         
        
         
          if($customer_diff[$k][31] =='Stock transfer on Credit')
         {
            if($customer_diff[$k][33]=='' || $customer_diff[$k][33]=="null"){
                $credit_type=0;  

                $no_customer_diff[]=$credit_type;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the credit type value empty'];

            }else if($customer_diff[$k][33]!='' || $customer_diff[$k][33]!="null"){


                if($customer_diff[$k][33]=='Amount'){
                    $credit_type=1; 

                    $no_customer_diff[]=$credit_type;
                }else if ($customer_diff[$k][33]=='Days'){
                    $credit_type=2; 

                    $no_customer_diff[]=$credit_type;
                }else{
                    $credit_type=0;

                    $no_customer_diff[]=$credit_type;
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the credit type value mismatch'];
                }  
            }

            if($customer_diff[$k][32]=='' || $customer_diff[$k][32]=="null"){
            $rating=0;  
            $no_customer_diff[]=$rating;
        $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the credit rating value empty'];

        }else if($customer_diff[$k][32]!='' || $customer_diff[$k][32]!="null"){
             
             if($customer_diff[$k][32]=='High'){
               $rating=1;  
     
                $no_customer_diff[]=$rating;
             }else if ($customer_diff[$k][32]=='Normal'){
               $rating=2; 
              $no_customer_diff[]=$rating;
             }else if ($customer_diff[$k][32]=='Low'){
               $rating=3; 
                 $no_customer_diff[]=$rating;
             }else if ($customer_diff[$k][32]=='Risk'){
               $rating=4; 
               $no_customer_diff[]=$rating;
             }else{
                $rating=0;
                 $no_customer_diff[]=$rating;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the credit rating value mismatch'];
             }  
        } 
      } else
      {
          $credit_type=1; 
          $no_customer_diff[]=$credit_type;
          $rating=1;
          $no_customer_diff[]=$rating;
      }

        


        if($customer_diff[$k][31] =='' || $customer_diff[$k][31] =="null"){
	    	$payment_type=0;  
	    	 $no_customer_diff[]=$payment_type;
        $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the stock payment value empty'];

		}else if($customer_diff[$k][31]!='' || $customer_diff[$k][31]!="null"){
           
             if($customer_diff[$k][31] == 'Stock Transfer on Full advance Payment'){
               $payment_type=1;  
                  $no_customer_diff[]= $payment_type;
             }else if ($customer_diff[$k][31] == 'Stock transfer on part advance payment'){
               $payment_type=2; 
                  $no_customer_diff[]=$payment_type;
             }else if ($customer_diff[$k][31] == 'Stock transfer on Credit'){
               $payment_type=3; 
                  $no_customer_diff[]=$payment_type;
             }else if ($customer_diff[$k][31] == 'Payment on delivery'){
               $payment_type=4; 
                  $no_customer_diff[]=$payment_type;
             }else{
                $payment_type=0;
                  $no_customer_diff[]=$payment_type;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the stock payment value mismatch'];
             }  
        }

		if($customer_diff[$k][30]=='' || $customer_diff[$k][30]=="null"){
	    	$rights=0;  
	    	  $no_customer_diff[]=$rights;
        $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the raising rights value empty'];

		}else if($customer_diff[$k][30]!='' || $customer_diff[$k][30]!="null"){
 
             if($customer_diff[$k][30] =='Single' || $customer_diff[$k][30] =='single'){
               $rights=1;  
                $no_customer_diff[]=$rights;
  
             }else if ($customer_diff[$k][30] =='Multiple' || $customer_diff[$k][30] =='multiple'){
               $rights=2; 
                 $no_customer_diff[]=$rights;
             }else{
                 $rights=0;
                  $no_customer_diff[]=$rights;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the raising rights value mismatch'];
             }  
        } 

         if($customer_diff[$k][29] =='' || $customer_diff[$k][29] =='null'){
             $segment=0;
               $no_customer_diff[]=$segment;
         	 $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check segment type empty'];

         }else if($customer_diff[$k][29] !=''){ 
                $segment_type=$customer_diff[$k][29];		   
		        $qry12="SELECT idsegmentType,segmentName FROM segment_type WHERE segmentName='$segment_type'
		        AND status ='1'";

				$result12=$this->adapter->query($qry12,array());
			    $resultset12=$result12->toArray();	

			    if(!$resultset12){  
	                $segment=0;
	                 $no_customer_diff[]=$segment;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Segment type value mismatch'];             
			    }else{  
			       $segment=1;
			       $no_customer_diff[]=$segment;		
	               }    
        }

    //      if($customer_diff[$k][26]=='' || $customer_diff[$k][26]=='null'){
    //          $group=0;
    //      	 $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check customer group empty'];

    //      }if($customer_diff[$k][26]!=''){ 
    //             $customer_group=$customer_diff[$k][26];		   
		  //       $qry11="SELECT idGeography,idGeographyTitle,geoValue FROM customer WHERE geoValue='$customer_group'
		  //       AND idGeographyTitle ='10'";

				// $result11=$this->adapter->query($qry11,array());
			 //    $resultset11=$result11->toArray();	

			 //    if(!$resultset11){
			 //    	$no_factory[]=0;
			 //    	$check_value[]=0; 
			 //    	$geo_value=$check_value;   
	   //              $group=0;
	   //              $array_condition[]=$geo_map_value10;
	   //              $ret_arr=['code'=>'3','status'=>false,'message'=>'customer group value mismatch'];

	             
			 //    }else{  
			 //       $no_factory[]=$resultset11[0]['idGeography'];
			 //       $check_value[]=$resultset11[0]['idGeography'];
			 //       $group=1;
			 //       $array_condition[]=$geo_map_value10;
	   //             }    
    //     }

	 	    if($customer_diff[$k][27]!=''){ 
                $geo_value10=$customer_diff[$k][27];		   
		        $qry10="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value10'
		        AND idGeographyTitle ='10'";

				$result10=$this->adapter->query($qry10,array());
			    $resultset10=$result10->toArray();	

			    if(!$resultset10){
			    	$geo10=0;
			    	$no_customer_diff[]=$geo10;			 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography10 value mismatch'];
	             
			    }else{  
			        $geo10=1;
			    	$no_customer_diff[]=$geo10;				     

	               }    
        }

        if($customer_diff[$k][26]!=''){ 
       	
                $geo_value9=$customer_diff[$k][26];		   
		        $qry9="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value9'
		        AND idGeographyTitle ='9'";

				$result9=$this->adapter->query($qry9,array());
			    $resultset9=$result9->toArray();	

			    if(!$resultset9){
			    	$geo9=0;
			    	$no_customer_diff[]=$geo9;			
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography9 value mismatch'];
	             
			    }else{  
			        $geo9=1;
			    	$no_customer_diff[]=$geo9;	

	               }    
        }

        if($customer_diff[$k][25]!=''){ 
       	
                $geo_value8=$customer_diff[$k][25];		   
		        $qry8="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value8'
		        AND idGeographyTitle ='8'";

				$result8=$this->adapter->query($qry8,array());
			    $resultset8=$result8->toArray();	

			    if(!$resultset8){
			    	$geo8=0;
			    	$no_customer_diff[]=$geo8;	

	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography8 value mismatch'];             
			    }else{  
			        $geo8=1;
			    	$no_customer_diff[]=$geo8;	
		
	               }    
        }

        if($customer_diff[$k][24]!=''){ 
       	
                $geo_value7=$customer_diff[$k][24];		   
		        $qry7="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value7'
		        AND idGeographyTitle ='7'";

				$result7=$this->adapter->query($qry7,array());
			    $resultset7=$result7->toArray();	

			    if(!$resultset7){
			    	$geo7=0;
			    	$no_customer_diff[]=$geo7;	
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography7 value mismatch'];
	             
			    }else{ 
			        $geo7=1;
			    	$no_customer_diff[]=$geo7;	
	
	               }    
        }

        if($customer_diff[$k][23]!=''){ 
       	
                $geo_value6=$customer_diff[$k][23];		   
		        $qry6="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value6'
		        AND idGeographyTitle ='6'";

				$result6=$this->adapter->query($qry6,array());
			    $resultset6=$result6->toArray();	

			    if(!$resultset6){
			    	$geo6=0;
			    	$no_customer_diff[]=$geo6;	
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography6 value mismatch'];
	             
			    }else{  
			        $geo6=1;
			    	$no_customer_diff[]=$geo6;
	
	               }    
        }

        if($customer_diff[$k][22]!=''){ 
       	
                $geo_value5=$customer_diff[$k][22];		   
		        $qry5="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value5'
		        AND idGeographyTitle ='5'";

				$result5=$this->adapter->query($qry5,array());
			    $resultset5=$result5->toArray();	

			    if(!$resultset5){
			    	$geo5=0;
			    	$no_customer_diff[]=$geo5;

	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography5 value mismatch'];	             
			    }else{  
			        $geo5=1;
			    	$no_customer_diff[]=$geo5;

	               }    
        }

        if($customer_diff[$k][21]!=''){ 
       	
                $geo_value4=$customer_diff[$k][21];		   
		        $qry4="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value4'
		        AND idGeographyTitle ='4'";

				$result4=$this->adapter->query($qry4,array());
			    $resultset4=$result4->toArray();	

			    if(!$resultset4){
			        $geo4=0;
			    	$no_customer_diff[]=$geo4;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography4 value mismatch'];             
			    }else{
			       $geo4=1;
			       $no_customer_diff[]=$geo4; 
	
	               }    
        }

        if($customer_diff[$k][20]!=''){ 
       	
                $geo_value3=$customer_diff[$k][20];		   
		        $qry3="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value3'
		        AND idGeographyTitle ='3'";

				$result3=$this->adapter->query($qry3,array());
			    $resultset3=$result3->toArray();	

			    if(!$resultset3){
			    	$geo3=0;
			    	$no_customer_diff[]=$geo3; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography3 value mismatch'];
	             
			    }else{  
			        $geo3=1;
			    	$no_customer_diff[]=$geo3; 
	
	               }    
        }

        if($customer_diff[$k][19]!=''){ 
       	
                $geo_value2=$customer_diff[$k][19];		   
		        $qry2="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value2'
		        AND idGeographyTitle ='2'";

				$result2=$this->adapter->query($qry2,array());
			    $resultset2=$result2->toArray();	

			    if(!$resultset2){
			        $geo2=0;
			    	$no_customer_diff[]=$geo2; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography2 value mismatch'];
	             
			    }else{  
			        $geo2=1;
			    	$no_customer_diff[]=$geo2; 
		
	               }    
        }


        if($customer_diff[$k][18]!=''){ 
       	
                $geo_value1=$customer_diff[$k][18];		   
		        $qry1="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value1'
		        AND idGeographyTitle ='1'";
				$result1=$this->adapter->query($qry1,array());
			    $resultset1=$result1->toArray();	

			    if(!$resultset1){
			    	$geo1=0;
			    	$no_customer_diff[]=$geo1; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Geography1 value mismatch'];

	             
			    }else{  
			        $geo1=1;
			    	$no_customer_diff[]=$geo1;
			
	               }    
        }
        if($customer_diff[$k][16]=='Invoice' || $customer_diff[$k][16]=='invoice'){
            if($customer_diff[$k][17]=='' || $customer_diff[$k][17]=="null"){
                $trans_invoice=0;   
                $no_customer_diff[]=$trans_invoice;  
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the invoice percentage empty'];

        }else if(!is_numeric($customer_diff[$k][17])){
                $trans_invoice=0; 
                $no_customer_diff[]=$trans_invoice;  
                $ret_arr=['code'=>'3','status'=>false,'message'=>'invoice percentage numeric only'];  

        }
        else if($customer_diff[$k][17]!='' || $customer_diff[$k][17]!="null"){
             if(preg_match('/^(?:100|\d{1,2})(?:\.\d{1,2})?$/', $customer_diff[$k][17])){
            
                  $trans_invoice=1; 
                $no_customer_diff[]=$trans_invoice;  
                }
                else {
                $trans_invoice=0; 
                $no_customer_diff[]=$trans_invoice;  
                $ret_arr=['code'=>'3','status'=>false,'message'=>'invoice percentage should be below or equal to 100'];  
                }
                  
                 
        }
    }

        if($customer_diff[$k][16] =='' || $customer_diff[$k][16]=="null"){
	    	$transport=0;  
	        $no_customer_diff[]=$transport;  
        $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the transport value empty'];

		}else if($customer_diff[$k][16] !='' || $customer_diff[$k][16] !="null"){
  
            if($customer_diff[$k][16]=='Per km'){
                $transport=1; 
                  $no_customer_diff[]=$transport; 
            }else if($customer_diff[$k][16]=='Invoice'){
                 $transport=2;
                  $no_customer_diff[]=$transport;  
            }else{
            	 $transport=0;
            	    $no_customer_diff[]=$transport;      
            	 $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the transport value mismatch'];
            }
                 
        } 

        if($customer_diff[$k][15]=='' || $customer_diff[$k][15]=="null"){
	    	$potential=0;  
	    	   $no_customer_diff[]=$potential;  
        $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the potential value empty'];

		}else if(!is_numeric($customer_diff[$k][15])){
                $potential=0; 
                       $no_customer_diff[]=$potential;      
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Potential numeric only'];  
        }else if((strlen($customer_diff[$k][15])>6)){
                $potential=0;    
                     $no_customer_diff[]=$potential;   
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Potential maximum length is 6'];  
        }else if($customer_diff[$k][15]!='' || $customer_diff[$k][15]!="null"){
            $potential=1; 
               $no_customer_diff[]=$potential;  
                 
        } 

        if($customer_diff[$k][14] =='' || $customer_diff[$k][14] =="null"){
	    	$warehouse=0;  
	    	   $no_customer_diff[]=$warehouse;  
        $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the warehouse empty'];

		}else if($customer_diff[$k][14] !='' || $customer_diff[$k][14] !="null"){
     
               $perferred=$customer_diff[$k][14];		   
		        $qry11="SELECT idWarehouse,warehouseName FROM warehouse_master WHERE warehouseName='$perferred'";
				$result11=$this->adapter->query($qry11,array());
			    $resultset11=$result11->toArray();	

			    if(!$resultset11){			  
	                $warehouse=0;
	                   $no_customer_diff[]=$warehouse;  
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Warehouse value mismatch'];

	             
			    }else{  	 
			       $warehouse=1;
			       $no_customer_diff[]=$warehouse;   
	               }    
        } 

        

        if($customer_diff[$k][13]=='' || $customer_diff[$k][13]=="null"){
	    	  $population=0;   
	    	       $no_customer_diff[]=$population;  
        $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the population empty'];

		}else if(!is_numeric($customer_diff[$k][13])){
                $population=0; 
                       $no_customer_diff[]=$population;      
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Population numeric only'];  

        }else if((strlen($customer_diff[$k][13])>6)){
                $population=0;    
                     $no_customer_diff[]=$population;   
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Population maximum length is 6'];  
        } 

        if($customer_diff[$k][12]=='' || $customer_diff[$k][12]=="null"){
		    	$amount=0;  
		    	     $no_customer_diff[]=$amount;   
		        $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the credit amount empty'];

		}else if(!is_numeric($customer_diff[$k][12])){
                $amount=0; 
                     $no_customer_diff[]=$amount;      
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Credit amount numeric only'];  

        }else if((strlen($customer_diff[$k][12])>6)){
                $amount=0; 
                     $no_customer_diff[]=$amount;    
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Credit amount maximum length is 6'];  
        }else if($customer_diff[$k][12] !='' || $customer_diff[$k][12] !="null"){
                $amount=1;  
                $no_customer_diff[]=$amount;           
                  
        }     
        

        if($customer_diff[$k][11]=='' || $customer_diff[$k][11]=="null"){
	    	$business=0;  
	    	  $no_customer_diff[]=$business;           
                  
        $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check how long in business is empty'];

		}else if(!is_numeric($customer_diff[$k][11])){
                $business=0; 
                 $no_customer_diff[]=$business;      
                $ret_arr=['code'=>'3','status'=>false,'message'=>'How long in business allows numeric only'];  
         }else if((strlen($customer_diff[$k][11])>6)){
                $amount=0; 
                     $no_customer_diff[]=$amount;    
                $ret_arr=['code'=>'3','status'=>false,'message'=>'How long in business maximum length is 6'];  

        }else if($customer_diff[$k][11]!='' || $customer_diff[$k][11]!="null"){
            $business=1; 
               $no_customer_diff[]=$business;           
                 
        } 

        if($customer_diff[$k][10]=='' || $customer_diff[$k][10]=="null"){
	    	$entroll=0;  
	    	     $no_customer_diff[]=$entroll;        
        $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the enrollment empty'];

		}else if($customer_diff[$k][10]!='' || $customer_diff[$k][10]!="null"){ 
           
                 if(!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/",$customer_diff[$k][10])){

                    $entroll=0; 
                    $no_customer_diff[]=$entroll; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Enrollment invalid date format'];
                  
                }
                // else if(!is_numeric($customer_diff[$k][10])){
                //      $entroll=0; 
                //      $no_customer_diff[]=$entroll; 
                //     $ret_arr=['code'=>'3','status'=>false,'message'=>'Enrollment invalid date format'];  

                // }else if(($this->validate($customer_diff[$k][10]))==true){

                //    $entroll=0; 
                //    $no_customer_diff[]=$entroll; 

                //     $ret_arr=['code'=>'3','status'=>false,'message'=>'Enrollment format worng'];  
                        
                // }
                else{
                
                   $entroll=1; 
                   $no_customer_diff[]=$entroll; 

                }             
                 
        } 

        if($customer_diff[$k][9]=='' || $customer_diff[$k][9]=="null"){
	    	$validity=0;  
	    	     $no_customer_diff[]=$validity;       
        $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the tin no validity empty'];

		}else if($customer_diff[$k][9]!='' || $customer_diff[$k][9]!="null"){

              if(!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/",$customer_diff[$k][9])){

                    $validity=0; 
                    $no_customer_diff[]=$validity; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Tin no invalid date format'];
                  
                }
                // else if(!is_numeric($customer_diff[$k][9])){
                //      $validity=0; 
                //      $no_customer_diff[]=$validity; 
                //     $ret_arr=['code'=>'3','status'=>false,'message'=>'Tin no invalid date format'];  

                // }else if(($this->validate($customer_diff[$k][9]))==true){

                //    $validity=0; 
                //    $no_customer_diff[]=$validity; 

                //     $ret_arr=['code'=>'3','status'=>false,'message'=>'Tin no format worng'];  
                        
                // }
                else{
                
                   $validity=1; 
                   $no_customer_diff[]=$validity; 

                }         
                 
        } 

        if($customer_diff[$k][8]=='' || $customer_diff[$k][8]=="null"){
    	    $tin=0; 
              $no_customer_diff[]=$tin; 
        $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the tin empty'];

        }else if((strlen($customer_diff[$k][8])>12)){
 
                    $no_customer_diff[]=$tin;  
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Tin number maximum length is 12'];  
        }else if($customer_diff[$k][8]!='' || $customer_diff[$k][8]!="null"){
                $tin=1;  
  
                 $no_customer_diff[]=$tin;
                 
        }


        if($customer_diff[$k][7]=='' || $customer_diff[$k][7]=="null"){
	    	$martial=0;  
	    	 $no_customer_diff[]=$martial;  
            $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the martial empty'];

		}else if($customer_diff[$k][7]!='' || $customer_diff[$k][7]!="null"){
            $martial=1;  
             $no_customer_diff[]=$martial; 

            if($customer_diff[$k][7]=='single' || $customer_diff[$k][7]=='Single'){
               $martial=1;  
                 $no_customer_diff[]=$martial;
            }else if($customer_diff[$k][7]=='married' || $customer_diff[$k][7]=='Married'){
                $martial=2;

                 $no_customer_diff[]=$martial;  
            }else{
            	 $martial=0;
  
            	 $no_customer_diff[]=$martial;
            	 $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the martial mismatch'];
            }
                 
        } 
        if($customer_diff[$k][6]=='' || $customer_diff[$k][6]=="null"){
	    	$dob=0;  
	        $no_customer_diff[]=$dob;     
        $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the dob empty'];

		}else if($customer_diff[$k][6]!='' || $customer_diff[$k][6]!="null"){
          
            if(!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/",$customer_diff[$k][6])){

                    $dob=0; 
                    $no_customer_diff[]=$dob; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Dob invalid date format'];
                  
                }
                // else if(!is_numeric($customer_diff[$k][6])){
                //      $dob=0; 
                //      $no_customer_diff[]=$dob; 
                //     $ret_arr=['code'=>'3','status'=>false,'message'=>'Dob invalid date format'];  

                // }
                // else if(($this->validate($customer_diff[$k][6]))==true){

                //    $dob=0; 
                //    $no_customer_diff[]=$dob; 

                //     $ret_arr=['code'=>'3','status'=>false,'message'=>'Dob format worng'];  
                        
                // }
                else{
                
                   $dob=1; 
                   $no_customer_diff[]=$dob; 

                } 
 
                 
        } 

        
        if($customer_diff[$k][5]=='' || $customer_diff[$k][5]=="null"){
    	$mobile=0; 
    	$no_customer_diff[]=$mobile;   
        $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the mobile empty'];

		}else if(!is_numeric($customer_diff[$k][5])){
                $mobile=0; 
                $no_customer_diff[]=$mobile;   
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Mobile no numeric only'];  

        }else if((strlen($customer_diff[$k][5])<10) || (strlen($customer_diff[$k][5])>10)){
        	    $mobile=0;
                $no_customer_diff[]=$mobile;   
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please enter valid mobile number'];  
        }else if($customer_diff[$k][5] !='' || $customer_diff[$k][5] !="null"){

             $mob=$customer_diff[$k][5];          
                $qry_mob="SELECT idCustomer FROM customer WHERE cs_mobno='$mob' AND cs_status ='1'";
                $result_mob=$this->adapter->query($qry_mob,array());
                $resultset_mob=$result_mob->toArray();
               
               if(!$resultset_mob){
                $mobile=1;  
                $no_customer_diff[]=$mobile;

               }else{
                $mobile=0;  
                $no_customer_diff[]=$mobile;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Mobile no already exist'];  

               }
                
                 
        }

        if($customer_diff[$k][4]=='' || $customer_diff[$k][4]=="null"){
    	$email=0;   
        $no_customer_diff[]=$email; 
        $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the email id empty'];

		}else if($customer_diff[$k][4]!='' || $customer_diff[$k][4]!="null")
        {
            if (!filter_var($customer_diff[$k][4], FILTER_VALIDATE_EMAIL)) 
            {
                $email=0;   
            $no_customer_diff[]=$email; 
            }
            else
            {
                 $mail=$customer_diff[$k][4];          
                $qry_mail="SELECT idCustomer FROM customer WHERE cs_mail='$mail' AND cs_status ='1'";
                $result_mail=$this->adapter->query($qry_mail,array());
                $resultset_mail=$result_mail->toArray();
               
               if(!$resultset_mail){
                $email=1;  
                $no_customer_diff[]=$email;

               }else{
                $email=0;  
                $no_customer_diff[]=$email;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Email already exist'];  

               }
            }
                 
        } 

        if($customer_diff[$k][3]=='' || $customer_diff[$k][3]=="null"){
    	$name=0;  
        $no_customer_diff[]=$name; 
        $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the customer name empty'];

		}else if($customer_diff[$k][3]!='' || $customer_diff[$k][3]!="null"){
                $name=1;  
                $no_customer_diff[]=$name; 
                 
        } 


        if($customer_diff[$k][2] =='' || $customer_diff[$k][2]=="null"){
	    	  $code=0; 
	    	  $no_customer_diff[]=$code;  
	          $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the customer code empty'];

		}
        /*else if(!is_numeric($customer_diff[$k][2])){
                $code=0; 
                $no_customer_diff[]=$code; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'customer code numeric only'];  

        }*/
        else if((strlen($customer_diff[$k][2])>10)){
                $code=0; 
                $no_customer_diff[]=$code;  
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Customer code 10 allowed'];  
        }else if($customer_diff[$k][2]!='' || $customer_diff[$k][2]!="null"){
                
                $code=$customer_diff[$k][2];		   
		        $qry_code="SELECT idCustomer FROM customer WHERE customer_code='$code' AND cs_status ='1'";
				$result_code=$this->adapter->query($qry_code,array());
			    $resultset_code=$result_code->toArray();
			   
			   if(!$resultset_code){
			   	$customer_code=1;  
                $no_customer_diff[]=$customer_code;

			   }else{
                $customer_code=0;  
                $no_customer_diff[]=$customer_code;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Customer code already exist'];  

			   }

                 
        }
        $ctype=$customer_diff[$k][0];
         $qryclevel="SELECT a.level from customertype as a WHERE a.status=1 ORDER BY a.level ASC LIMIT 1";
            $resultclevel=$this->adapter->query($qryclevel,array());
            $resultsetclevel=$resultclevel->toArray();  
            $clevel=$resultsetclevel[0]['level'];
        $qryctype="SELECT idCustomerType,custType FROM customertype WHERE custType='$ctype' AND status ='1' AND level ='$clevel'";
            $resultctype=$this->adapter->query($qryctype,array());
            $resultsetctype=$resultctype->toArray();  
         if(!$resultsetctype){

            if($customer_diff[$k][1]=='' || $customer_diff[$k][1]=="null"){
            $serviceby=0;  
             $no_customer_diff[]=$serviceby; 
            $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check service by empty'];

        }else if($customer_diff[$k][1]!='' || $customer_diff[$k][1]!="null"){
               
            $customer_type=$customer_diff[$k][0];  
             $customer_type=$customer_diff[$k][0];         
            $qry14="SELECT idCustomerType,custType FROM customertype WHERE custType='$customer_type'
            AND status ='1'";

            $result14=$this->adapter->query($qry14,array());
            $resultset14=$result14->toArray();          
            $customer=$customer_diff[$k][1];  
            $cstype=$resultset14[0]['idCustomerType'];        
            $qryser="SELECT idCustomer FROM customer WHERE cs_type!='$cstype' AND cs_name='$customer' AND cs_status ='1'";

            $resultser=$this->adapter->query($qryser,array());
            $resultsetser=$resultser->toArray();  

            if(!$resultsetser){             
                $serviceby=0; 
                $no_customer_diff[]=$serviceby; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Service by value mismatch'];             
            }else{  
               $serviceby=1; 
               $no_customer_diff[]=$serviceby;   
               }    
        }            
                
    }


        if($customer_diff[$k][0]=='' || $customer_diff[$k][0]=="null"){
		    	$type=0;  
		    	 $no_customer_diff[]=$type; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the customer type empty'];

		}else if($customer_diff[$k][0]!='' || $customer_diff[$k][0]!="null"){
               
                $customer_type=$customer_diff[$k][0];		   
		        $qry14="SELECT idCustomerType,custType FROM customertype WHERE custType='$customer_type'
		        AND status ='1'";

				$result14=$this->adapter->query($qry14,array());
			    $resultset14=$result14->toArray();	

			    if(!$resultset14){			   
	                $type=0; 
	                $no_customer_diff[]=$type; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Customer type value mismatch'];             
			    }else{  
			       $type=1; 
			       $no_customer_diff[]=$type;   
	               }    
        }            
                
	} // close loop;

if(count($no_customer_diff)!=0){

    for($j=0; $j<count($no_customer_diff);$j++){ 
            $zero=0;
        if(in_array($zero,$no_customer_diff)){

           $check=0;
        }else{
           $check=1;

        }       
    }
}else{
    	 $check=0;
    	 $ret_arr=['code'=>'3','status'=>false,'message'=>'Excel file empty']; 
    }

if($check!=0){

for($i=0; $i<count($customer_diff);$i++){

	           	if($customer_diff[$i][18]!=''){ 
			    $geo_value1=$customer_diff[$i][18];		      	
			    	 $qry1="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value1'
		        AND idGeographyTitle ='1'";
				$result1=$this->adapter->query($qry1,array());
			    $resultset1=$result1->toArray();
				    $geography1=$resultset1[0]['idGeography'];
			    }else{
			    	$geography1=0;
			    }
                 
                if($customer_diff[$i][19]!=''){ 
			    $geo_value2=$customer_diff[$i][19];		   
		        $qry2="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value2'
		        AND idGeographyTitle ='2'";
				$result2=$this->adapter->query($qry2,array());
			    $resultset2=$result2->toArray();
			    $geography2=$resultset2[0]['idGeography'];
			    }else{
			    	$geography2=0;
			    }

                if($customer_diff[$i][20]!=''){ 
			    $geo_value3=$customer_diff[$i][20];		   
		        $qry3="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value3'
		        AND idGeographyTitle ='3'";
				$result3=$this->adapter->query($qry3,array());
			    $resultset3=$result3->toArray();
			    $geography3=$resultset3[0]['idGeography'];
			    }else{
			    	$geography3=0;
			    }

                if($customer_diff[$i][21]!=''){ 
			    $geo_value4=$customer_diff[$i][21];		   
		        $qry4="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value4'
		        AND idGeographyTitle ='4'";
				$result4=$this->adapter->query($qry4,array());
			    $resultset4=$result4->toArray();
			    $geography4=$resultset4[0]['idGeography'];
			    }else{
			    	$geography4=0;
			    }

			    if($customer_diff[$i][22]!=''){ 

			    $geo_value5=$customer_diff[$i][22];		   
		        $qry5="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value5'
		        AND idGeographyTitle ='5'";
				$result5=$this->adapter->query($qry5,array());
			    $resultset5=$result5->toArray();
			    $geography5=$resultset5[0]['idGeography'];
			    }else{
			    	$geography5=0;
			    }

			    if($customer_diff[$i][23]!=''){

			    $geo_value6=$customer_diff[$i][23];		   
		        $qry6="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value6'
		        AND idGeographyTitle ='6'";
				$result6=$this->adapter->query($qry6,array());
			    $resultset6=$result6->toArray();
			    $geography6=$resultset6[0]['idGeography'];
			    }else{
			    	$geography6=0;
			    }

			    if($customer_diff[$i][24]!=''){

			    $geo_value7=$customer_diff[$i][24];	
		        $qry7="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value7'
		        AND idGeographyTitle ='7'";
				$result7=$this->adapter->query($qry7,array());
			    $resultset7=$result7->toArray();
			    $geography7=$resultset7[0]['idGeography'];
			    }else{
			    	$geography7=0;
			    }

			    if($customer_diff[$i][25]!=''){
			    $geo_value8=$customer_diff[$i][25];		   
		        $qry8="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value8'
		        AND idGeographyTitle ='8'";
				$result8=$this->adapter->query($qry8,array());
			    $resultset8=$result8->toArray();
			    $geography8=$resultset8[0]['idGeography'];
			    }else{
			    	$geography8=0;
			    }
                
                if($customer_diff[$i][26]!=''){
			    $geo_value9=$customer_diff[$i][26];		   
		        $qry9="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value9'
		        AND idGeographyTitle ='9'";
				$result9=$this->adapter->query($qry9,array());
			    $resultset9=$result9->toArray();
			    $geography9=$resultset9[0]['idGeography'];
			    }else{
			    	$geography9=0;
			    }

                if($customer_diff[$i][27]!=''){
			    $geo_value10=$customer_diff[$i][27];		   
		        $qry10="SELECT idGeography,idGeographyTitle,geoValue FROM geography WHERE geoValue='$geo_value10'
		        AND idGeographyTitle ='10'";
				$result10=$this->adapter->query($qry10,array());
			    $resultset10=$result10->toArray();
			    $geography10=$resultset10[0]['idGeography'];
			    }else{
			    	$geography9=0;
			    }

			    $perferred=$customer_diff[$i][14];		   
		        $qry11="SELECT idWarehouse,warehouseName FROM warehouse_master WHERE warehouseName='$perferred'";
				$result11=$this->adapter->query($qry11,array());
			    $resultset11=$result11->toArray();	

                $segment_type=$customer_diff[$i][29];		   
		        $qry12="SELECT idsegmentType,segmentName FROM segment_type WHERE segmentName='$segment_type'
		        AND status ='1'";
				$result12=$this->adapter->query($qry12,array());
			    $resultset12=$result12->toArray();	

			    $customer_type=$customer_diff[$i][0];		   
		        $qry14="SELECT idCustomerType,custType FROM customertype WHERE custType='$customer_type'
		        AND status ='1'";
				$result14=$this->adapter->query($qry14,array());
			    $resultset14=$result14->toArray();	

                $customer=$customer_diff[$i][1]; 
                    $cstype =  $resultset14[0]['idCustomerType'];      
                    $qrycus="SELECT idCustomer FROM customer WHERE cs_type!='$cstype' AND cs_name='$customer' AND cs_status ='1'";
                    $resultcus=$this->adapter->query($qrycus,array());
                    $resultsetcus=$resultcus->toArray();  
                if($customer!=''){
                    $ctype=$resultsetcus[0]['idCustomer'];
                }else{
                    $ctype=0;
                }
                

			    if(($customer_diff[$i][7]=='single') || ($customer_diff[$i][7]=='Single')){
                 $martial=1; 
	            }else if(($customer_diff[$i][7]=='married') || ($customer_diff[$i][7]=='Married')){
	             $martial=2;
	              
	            }          

	            if($customer_diff[$i][16]=='Per km'){
	                $transport=1;
                      $trans_invoice=0.00;
	            }else if($customer_diff[$i][16]=='Invoice'){
	                 $transport=2;
                     $trans_invoice=$customer_diff[$i][17];
	            }


				if(($customer_diff[$i][30]=='Single')|| $customer_diff[$i][30]=='single'){
	               $rights=1;    
	            }else if (($customer_diff[$i][30]=='Multiple') || $customer_diff[$i][30]=='multiple'){
	               $rights=2; 
	            }

	            if(($customer_diff[$i][31]=='Stock Transfer on Full advance Payment')){
	               $stock_payment_type=1;  
	            }else if (($customer_diff[$i][31]=='Stock transfer on part advance payment')){
	               $stock_payment_type=2; 
	            }else if (($customer_diff[$i][31]=='Stock transfer on Credit')){
	               $stock_payment_type=3; 
	            }else if (($customer_diff[$i][31]=='Payment on delivery')){
	               $stock_payment_type=4; 
	            }


	            if(($customer_diff[$i][32]=='High')){
	               $rating=1;  
	            }else if (($customer_diff[$i][32]=='Normal')){
	               $rating=2; 
	            }else if (($customer_diff[$i][32]=='Low')){
	               $rating=3; 
	            }else if (($customer_diff[$i][32]=='Risk')){
	               $rating=4; 
	            }


	            if(($customer_diff[$i][33]=='Amount')){
	               $credit_type=1; 
	            }else if (($customer_diff[$i][33]=='Days')){
	               $credit_type=2; 
	            }


	            if(($customer_diff[$i][34]=='Payment on delivery')){
	               $payment_type=1;  
	            }else if (($customer_diff[$i][34]=='Advance payment')){
	               $payment_type=2; 
	            }else if (($customer_diff[$i][34]=='Payment on Service completion')){
	               $payment_type=3; 
	            }

			    if($customer_diff[$i][37]=="Active" || $customer_diff[$i][37]=="active"){
	                $status=1;
	        	}else if($customer_diff[$i][37]=="Inactive" || $customer_diff[$i][37]=="inactive"){
	        		$status=2;
	            }

            $qry_list="SELECT idCustomer,cs_name FROM customer where customer_code =? and cs_name =? and cs_mail =? and cs_mobno=? and cs_dob=?";
	        $result_list=$this->adapter->query($qry_list,array($customer_diff[$i][2],$customer_diff[$i][3],$customer_diff[$i][4],$customer_diff[$i][5],date('Y-m-d',strtotime($customer_diff[$i][6]))));
	        $resultset_list=$result_list->toArray();

			if(!$resultset_list){
						$this->adapter->getDriver()->getConnection()->beginTransaction();
						try {					
							$data['customer_code']=$customer_diff[$i][2];
							$data['G1']=(($customer_diff[$i][18]!='')? $resultset1[0]['idGeography']:0);
							$data['G2']=(($customer_diff[$i][19]!='')? $resultset2[0]['idGeography']:0);
							$data['G3']=(($customer_diff[$i][20]!='')? $resultset3[0]['idGeography']:0);
							$data['G4']=(($customer_diff[$i][21]!='')? $resultset4[0]['idGeography']:0);
							$data['G5']=(($customer_diff[$i][22]!='')? $resultset5[0]['idGeography']:0);
							$data['G6']=(($customer_diff[$i][23]!='')? $resultset6[0]['idGeography']:0);
							$data['G7']=(($customer_diff[$i][24]!='')? $resultset7[0]['idGeography']:0);
							$data['G8']=(($customer_diff[$i][25]!='')? $resultset8[0]['idGeography']:0);
							$data['G9']=(($customer_diff[$i][26]!='')? $resultset9[0]['idGeography']:0);
							$data['G10']=(($customer_diff[$i][27]!='')? $resultset10[0]['idGeography']:0);
							$data['idCustClass']='0';
						    $data['idCustRetailerCat']='0';
							$data['cs_name']=$customer_diff[$i][3];
							$data['cs_mail']=$customer_diff[$i][4];
							$data['cs_serviceby']=$ctype;
							$data['cs_type']=$resultset14[0]['idCustomerType'];
						    $data['cs_status']=$status;
							$data['cs_mobno']=$customer_diff[$i][5];
							$data['cs_dob']=date('Y-m-d',strtotime($customer_diff[$i][6]));
							$data['cs_martialStatus']=$martial;
							$data['cs_payment_type']=$payment_type;
							$data['cs_credit_ratingstatus']=$rating;
							$data['cs_credit_types']=$credit_type;					
							$data['cs_date_enrollment']=date('Y-m-d',strtotime($customer_diff[$i][10]));
						    $data['cs_creditAmount']=$customer_diff[$i][12];
							$data['cs_long_bsns']=$customer_diff[$i][11];	
							$data['cs_a_stores']=0;	
							$data['idPreferredwarehouse']= $resultset11[0]['idWarehouse'];
							$data['cs_supermarkets']=0;
							$data['cs_tinno']=$customer_diff[$i][8];
							$data['cs_tindate']=date('Y-m-d',strtotime($customer_diff[$i][9]));
							$data['cs_cmsn_type']=0;
							$data['cs_transport_type']=$transport;
							$data['cs_transport_amt']=$trans_invoice;	
							$data['cs_population']=$customer_diff[$i][13];
							$data['cs_potential_value']=$customer_diff[$i][15];
							$data['cs_segment_type']=$resultset12[0]['idsegmentType'];
							$data['cs_customer_group']=0;
							$data['cs_raising_rights']=$rights;
				            $data['cs_stock_payment_type']=$stock_payment_type;
                           /* $data['part_paymentPercent']=($customer_diff[$i][32]!='')?$customer_diff[$i][32]:0;*/
                              $data['idSalesHierarchy']=($resultset34[0]['idSaleshierarchy']!='')?$resultset34[0]['idSaleshierarchy']:0;
                                $data['sales_hrchy_name']=($resultset35[0]['idTeamMember']!='')?$resultset35[0]['idTeamMember']:0;
                            
                            
							$data['customer_logo']='';
							$data['created_at']=date('Y-m-d H:i:s');
							$data['created_by']=1;		
							$insert=new Insert('customer');
							$insert->values($data);
							$statement=$this->adapter->createStatement();
							$insert->prepareStatement($this->adapter, $statement);
							$insertresult=$statement->execute();
							$insert_value +=$insert_count+1;
							$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
							$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
							$this->adapter->getDriver()->getConnection()->rollBack();
						}
					} else {

						$reject_value += $reject_count+1;
				
					}

                }

        if($insert_value!=0 && $reject_value==0){

              $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
        }else if($insert_value ==0 && $reject_value !=0){

        	 $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists data'];

        }else if($insert_value!=0 && $reject_value!=0){

        $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists  '.$reject_value.'Uploaded  '.$insert_value];
        }

    }
			}else{
				   $ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please verify the csv file'];
			}
			
	 	}
	 	return $ret_arr;

	}  // close func

public function uploadproductpricefixing($param){

		ini_set('display_errors',true);
		$Uploads_dir = 'public/uploads/csv';
		$tmp_name=$_FILES["myFile"]["tmp_name"]; 
		$name = basename($_FILES["myFile"]["name"]); 
		$imageName = rand(6,66666).'.'. pathinfo($_FILES["myFile"]['name'],PATHINFO_EXTENSION);
    	if(move_uploaded_file($tmp_name, "$Uploads_dir/$imageName")) {
			$r="public/uploads/csv/$imageName";
			$file = fopen($r, "r",FILE_SKIP_EMPTY_LINES);
			$emapData = fgetcsv($file, 10000, ","); 
				$row=0;
				$size=sizeof($emapData);

				if($size=='9' && $emapData !=null) {
				$pricefixing=array();
				$no_pricefixing=array();
				while (($record = fgetcsv($file)) !== FALSE) {
					$row++;
					array_push($pricefixing,$record);
				}


		$array_condition=array();		
 	    $insert_count=0;
        $reject_count=0;
        $reject_value=0; 
        $insert_value=0; 

	for($k=0; $k<count($pricefixing);$k++){

	if($pricefixing[$k][8]=='' || $pricefixing[$k][8]=="null"){
	    	  $company=0; 
	    	  $array_condition[]=$company; 
	          $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the company cost empty'];

			}else if(!is_numeric($pricefixing[$k][8])){
	                $company=0; 
	                $array_condition[]=$company; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Company cost numeric only'];  

	        }else if($pricefixing[$k][8]!='' || $pricefixing[$k][8]!="null"){
	                $company=1;  
	                $array_condition[]=$company;    
	                 
	        }


			if($pricefixing[$k][7]=='' || $pricefixing[$k][7]=="null"){
		    	  $price=0; 
		    	  $array_condition[]=$price; 
		          $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the new price empty'];

			}else if(!is_numeric($pricefixing[$k][7])){
	                $price=0; 
	                $array_condition[]=$price; 
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'New price numeric only'];  

	        }else if($pricefixing[$k][7]!='' || $pricefixing[$k][7]!="null"){
	                $price=1;  
	                $array_condition[]=$price;    
	                 
	        }

	        if($pricefixing[$k][6] =='' || $pricefixing[$k][6]=="null"){
		    	  $date=0; 
		    	  $array_condition[]=$date; 
		          $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the new date empty'];

			}else if($pricefixing[$k][6]!='' || $pricefixing[$k][6]!="null"){

                  if(!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/", $pricefixing[$k][6])){

                    $date=0;
                    $array_condition[]=$date; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'From date invalid date format'];
                  
              /*  }else if(!is_numeric($pricefixing[$k][6])){
                    $date=0;
                    $array_condition[]=$date; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Fromdate invalid date format'];  */

                }else if(($this->validate($pricefixing[$k][6]))==true){

                    $date=0;
                    $array_condition[]=$date; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'From date format worng'];  
                        
                }else{
                
                    $date=1;
                    $array_condition[]=$date; 
                } 

			}

           if($pricefixing[$k][5]=='' ||  $pricefixing[$k][5]=="null"){
		    	$product_size=0;  
		    	$array_condition[]=$product_size;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the product size value empty'];

		    }else if(!is_numeric($pricefixing[$k][5])){
                $product_size=0; 
                $array_condition[]=$product_size; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Product size numeric only'];  

            }
            if($pricefixing[$k][5]!='' || $pricefixing[$k][5]!="null"){ 

                $size=$pricefixing[$k][5];		   
		        $qry5="SELECT idProductsize,productSize FROM product_size WHERE productSize='$size'";
			    $result5=$this->adapter->query($qry5,array());
			    $resultset5=$result5->toArray();
			    if(!$resultset5){			   
	                $product_size=0; 
	                $array_condition[]=$product_size;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Product value mismatch'];             
			    }else{  
			        $product_size=1; 
			        $array_condition[]=$product_size;
	               }    
            } 

	    	if($pricefixing[$k][4]=='' || $pricefixing[$k][4]=="null"){
                $status=0;    
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status empty'];    
        	}else if($pricefixing[$k][4]=="Active" || $pricefixing[$k][4]=="active"){

                $status=1;
        	}else if($pricefixing[$k][4]=="Inactive" || $pricefixing[$k][4]=="inactive"){

        		$status=2;
            }else{
                $status=0;     
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status data'];    
        	}

        	if($pricefixing[$k][3]=='' || $pricefixing[$k][3]=="null"){
		    	$product_name=0;  
		    	$array_condition[]=$product_name;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the product value empty'];

		    }else if($pricefixing[$k][3]!='' || $pricefixing[$k][3]!="null"){
               
                $product=$pricefixing[$k][3];		   
		        $qry4="SELECT idProduct,productName FROM product_details WHERE productName='$product' AND status!='2'";
				$result4=$this->adapter->query($qry4,array());
			    $resultset4=$result4->toArray();
			    if(!$resultset4){			   
	                $product_name=0; 
	                $array_condition[]=$product_name;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Product value mismatch'];             
			    }else{  
			        $product_name=1; 
			        $array_condition[]=$product_name;
	               }    
            } 


            	if($pricefixing[$k][2]=='' || $pricefixing[$k][2]=="null"){
		    	$category_type=0;  
		    	$array_condition[]=$category_type;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the category value empty'];

	     	    }else if($pricefixing[$k][2]!='' || $pricefixing[$k][2]!="null"){
               
                $category=$pricefixing[$k][2];		   
		        $qry3="SELECT idCategory,category FROM category WHERE category='$category' AND status!='2'";
				$result3=$this->adapter->query($qry3,array());
			    $resultset3=$result3->toArray();
			    if(!$resultset3){			   
	                $category_type=0; 
	                $array_condition[]=$category_type;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Category value mismatch'];             
			    }else{  
			       $category_type=1; 
			       $array_condition[]=$category_type;
	               }    
                } 

		        if($pricefixing[$k][1]=='' || $pricefixing[$k][1]=="null"){
		    	$state=0;  
		    	$array_condition[]=$state;  
		        $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the state empty'];

				}else if($pricefixing[$k][1]!='' || $pricefixing[$k][1]!="null"){
               
                $ter_value2=$pricefixing[$k][1];	
                $ter_value1=$pricefixing[$k][0];	

                $qry1="SELECT idTerritoryTitle FROM territorytitle_master WHERE title='$ter_value1' AND title!=''";
				$result1=$this->adapter->query($qry1,array());
			    $resultset1=$result1->toArray();

		        $qry2="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='".$ter_value2."' AND idTerritoryTitle='".$resultset1[0]['idTerritoryTitle']."'";

				$result2=$this->adapter->query($qry2,array());
			    $resultset2=$result2->toArray();
			    if(!$resultset2){			   
	                $state=0; 
	                $array_condition[]=$state;  
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'State value mismatch'];             
			    }else{  
			       $state=1; 
			       $array_condition[]=$state;  
	               }    
                }

                if($pricefixing[$k][0]=='' || $pricefixing[$k][0]=="null"){
		    	$terrritory=0;  
		    	$array_condition[]=$terrritory;  
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the terrritory value empty'];

	        	}else if($pricefixing[$k][0]!='' || $pricefixing[$k][0]!="null"){
               
                $ter_value1=$pricefixing[$k][0];		   
		        $qry1="SELECT idTerritoryTitle FROM territorytitle_master WHERE title='$ter_value1' AND title!=''";
				$result1=$this->adapter->query($qry1,array());
			    $resultset1=$result1->toArray();
			    if(!$resultset1){			   
	                $terrritory=0; 
	                $array_condition[]=$terrritory;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Terrritory value mismatch'];             
			    }else{  
			       $terrritory=1; 
			       $array_condition[]=$terrritory;
	               }    
        }    
                   
	}// close loop 

if(count($array_condition)!=0){

    for($j=0; $j<count($array_condition);$j++){ 
            $zero=0;
        if(in_array($zero,$array_condition)){

           $fixing=0;
        }else{
           $fixing=1;

        }
                   
    }
}else{
          $fixing=0;

}

	  
 if($fixing!=0){
 
	for($i=0; $i<count($pricefixing);$i++){

		        $ter_value1=$pricefixing[$i][0];		   
		        $qry1="SELECT idTerritoryTitle FROM territorytitle_master WHERE title='$ter_value1' AND title!=''";
				$result1=$this->adapter->query($qry1,array());
			    $resultset1=$result1->toArray();

                $ter_value2=$pricefixing[$i][1];	
			    $qry2="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='".$ter_value2."' AND idTerritoryTitle='".$resultset1[0]['idTerritoryTitle']."'";
				$result2=$this->adapter->query($qry2,array());
			    $resultset2=$result2->toArray();

			    $category=$pricefixing[$i][2];		   
		        $qry3="SELECT idCategory,category FROM category WHERE category='$category' AND status!='2'";
				$result3=$this->adapter->query($qry3,array());
			    $resultset3=$result3->toArray();

			    $product=$pricefixing[$i][3];		   
		        $qry4="SELECT idProduct,productName FROM product_details WHERE productName='$product' AND status!='2'";
				$result4=$this->adapter->query($qry4,array());
			    $resultset4=$result4->toArray();

			    $size=$pricefixing[$i][5];		   
		        $qry5="SELECT idProductsize,productSize FROM product_size WHERE productSize='$size'";
			    $result5=$this->adapter->query($qry5,array());
			    $resultset5=$result5->toArray();

			    if($pricefixing[$i][4]=="Active" || $pricefixing[$i][4]=="active"){
                    $status=1;
	        	}else if($pricefixing[$i][4]=="Inactive" || $pricefixing[$i][4]=="inactive"){
	        		$status=2;
	            }

		    $qry_list="SELECT * FROM price_fixing where idPricefixing =?";
	        $result_list=$this->adapter->query($qry_list,array(0));
	        $resultset_list=$result_list->toArray();

			if(!$resultset_list){
						$this->adapter->getDriver()->getConnection()->beginTransaction();
						try {					
							$data['idTerritoryTitle']=(($pricefixing[$i][0]!='')? $resultset1[0]['idTerritoryTitle']:0);
							$data['idTerritory']=(($pricefixing[$i][1]!='')? $resultset2[0]['idTerritory']:0);
							$data['idCategory']=(($pricefixing[$i][2]!='')? $resultset3[0]['idCategory']:0);
						    $data['idProduct']=(($pricefixing[$i][3]!='')? $resultset4[0]['idProduct']:0);
							$data['idProductsize']=(($pricefixing[$i][5]!='')? $resultset5[0]['idProductsize']:0);
							$data['priceDate']=date('Y-m-d',strtotime($pricefixing[$i][6]));
							$data['priceAmount']=$pricefixing[$i][7];
							$data['companyCost']=$pricefixing[$i][8];
						    $data['status']=$status;													
							$data['created_at']=date('Y-m-d H:i:s');
							$data['created_by']=1;		
							$data['updated_at']=date('Y-m-d H:i:s');
							$data['updated_by']=1;					
							$insert=new Insert('price_fixing');
							$insert->values($data);
							$statement=$this->adapter->createStatement();
							$insert->prepareStatement($this->adapter, $statement);
							$insertresult=$statement->execute();
							$insert_value +=$insert_count+1;
							$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
							$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
							$this->adapter->getDriver()->getConnection()->rollBack();
						}
					} else {

						$reject_value += $reject_count+1;
				
					}


                }

        if($insert_value!=0 && $reject_value==0){

              $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully '.$insert_value .' data'];
        }else if($insert_value ==0 && $reject_value !=0){

        	 $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists '.$reject_value.' data'];

        }else if($insert_value!=0 && $reject_value!=0){

        $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists  '.$reject_value.'Uploaded  '.$insert_value];
        }
		
	}
			} else {
				   $ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please verify the csv file'];
			}		
		}

		return $ret_arr;

	}// close func 
public function uploadagencymaster($param) {

		ini_set('display_errors',true);
		$Uploads_dir = 'public/uploads/csv';
		$tmp_name=$_FILES["myFile"]["tmp_name"]; 
		$name = basename($_FILES["myFile"]["name"]); 
		$imageName = rand(6,66666).'.'. pathinfo($_FILES["myFile"]['name'],PATHINFO_EXTENSION);
    	if(move_uploaded_file($tmp_name, "$Uploads_dir/$imageName")) {
			$r="public/uploads/csv/$imageName";
			$file = fopen($r, "r",FILE_SKIP_EMPTY_LINES);
			$emapData = fgetcsv($file, 10000, ","); 
				$row=0;
				$size=sizeof($emapData);

				if($size=='14' && $emapData !=null) {
				$agencymaster=array();
				$no_agencymaster=array();
				
				while (($record = fgetcsv($file)) !== FALSE) {
					$row++;
					array_push($agencymaster,$record);
				}

		$territory1=0;
	    $territory2=0;
	    $territory3=0;
	    $territory4=0;
	    $territory5=0;
	    $territory6=0;
	    $territory7=0;
	    $territory8=0;
        $territory9=0;
	    $territory10=0;

        $ter_map_value0=0;
	    $ter_map_value1=0;
	    $ter_map_value2=0;
	    $ter_map_value3=0;
	    $ter_map_value4=0;
	    $ter_map_value5=0;
	    $ter_map_value6=0;
	    $ter_map_value7=0;
	    $ter_map_value8=0;
	    $ter_map_value9=0;
	    $ter_map_value10=0;

	    $check_value=array();
	    $array_condition=array();
	    $no_factory=array();

 	    $insert_count=0;
        $reject_count=0;
        $reject_value=0; 
        $insert_value=0;  

	for($k=0; $k<count($agencymaster);$k++){

       if($agencymaster[$k][13]!=''){      

		        $ter_value10=$agencymaster[$k][13];		   
		        $qry10="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value10' AND idTerritoryTitle ='10'";
				$result10=$this->adapter->query($qry10,array());
			    $resultset10=$result10->toArray();	

			    if(!$resultset10){
			    	$no_factory[]=0; 
	                $ter_map_value10=0;
	                $array_condition[]=$ter_map_value10;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory10 value mismatch'];            
			    }else{  
			       $ter_map_value10=1;
			       $array_condition[]=$ter_map_value10;
	               }    
        }

        if($agencymaster[$k][12]!=''){ 
       	
                $ter_value9=$agencymaster[$k][12];		   
		        $qry9="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value9' AND idTerritoryTitle ='9'";
				$result9=$this->adapter->query($qry9,array());
			    $resultset9=$result9->toArray();	

			    if(!$resultset9){ 
	                $ter_map_value9=0;
	                $array_condition[]=$ter_map_value9;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory9 value mismatch'];

	             
			    }else{  
			       $ter_map_value9=1;
			       $array_condition[]=$ter_map_value9;
	               }    
        }

        if($agencymaster[$k][11]!=''){ 
       	
                $ter_value8=$agencymaster[$k][11];		   
		        $qry8="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value8' AND idTerritoryTitle ='8'";
				$result8=$this->adapter->query($qry8,array());
			    $resultset8=$result8->toArray();	

			    if(!$resultset8){
	                $ter_map_value8=0;
	                $array_condition[]=$ter_map_value8;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory8 value mismatch'];
	             
			    }else{  
			       $ter_map_value8=1;
			       $array_condition[]=$ter_map_value8;
	               }    
        }

        if($agencymaster[$k][10]!=''){ 
       	
                $ter_value7=$agencymaster[$k][10];		   
		        $qry7="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value7' AND idTerritoryTitle ='7'";
				$result7=$this->adapter->query($qry7,array());
			    $resultset7=$result7->toArray();	

			    if(!$resultset7){
	                $ter_map_value7=0;
	                $array_condition[]=$ter_map_value7;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory7 value mismatch'];

	             
			    }else{ 
			       $ter_map_value7=1;
			       $array_condition[]=$ter_map_value7;
	               }    
        }

        if($agencymaster[$k][9]!=''){ 
       	
                $ter_value6=$agencymaster[$k][9];		   
		        $qry6="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value6' AND idTerritoryTitle ='6'";
				$result6=$this->adapter->query($qry6,array());
			    $resultset6=$result6->toArray();	

			    if(!$resultset6){ 
	                $ter_map_value6=0;
	                $array_condition[]=$ter_map_value6;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory6 value mismatch'];

	             
			    }else{  
			       $ter_map_value6=1;
			       $array_condition[]=$ter_map_value6;
	               }    
        }

        if($agencymaster[$k][8]!=''){       	
                $ter_value5=$agencymaster[$k][8];		   
		        $qry5="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value5' AND idTerritoryTitle ='5'";
				$result5=$this->adapter->query($qry5,array());
			    $resultset5=$result5->toArray();	

			    if(!$resultset5){ 
	                $ter_map_value5=0;
	                $array_condition[]=$ter_map_value5;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory5 value mismatch'];

	             
			    }else{  
			       $ter_map_value5=1;
			       $array_condition[]=$ter_map_value5;
	               }    
        }

        if($agencymaster[$k][7]!=''){ 
       	
                $ter_value4=$agencymaster[$k][7];		   
		        $qry4="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value4' AND idTerritoryTitle ='4'";
				$result4=$this->adapter->query($qry4,array());
			    $resultset4=$result4->toArray();	

			    if(!$resultset4){ 
	                $ter_map_value4=0;
	                $array_condition[]=$ter_map_value4;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory4 value mismatch'];
	             
			    }else{ 
			       $ter_map_value4=1;
			       $array_condition[]=$ter_map_value4;
	               }    
        }

       if($agencymaster[$k][6] =='' || $agencymaster[$k][6] =="null"){
                $ter_map_value3=0;
                $array_condition[]=$ter_map_value3;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check territory3 is empty'];  

       }else if($agencymaster[$k][6]!=''){ 
       	
                $ter_value3=$agencymaster[$k][6];		   
		        $qry3="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value3' AND idTerritoryTitle ='3'";
				$result3=$this->adapter->query($qry3,array());
			    $resultset3=$result3->toArray();	

			    if(!$resultset3){  
	                $ter_map_value3=0;
	                $array_condition[]=$ter_map_value3;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory3 value mismatch'];

	             
			    }else{  
			       $ter_map_value3=1;
			       $array_condition[]=$ter_map_value3;
	               }    
        }

        if($agencymaster[$k][5] =='' || $agencymaster[$k][5] =="null"){
                $ter_map_value2=0;
                $array_condition[]=$ter_map_value2;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check territory2 is empty'];  

       }else if($agencymaster[$k][5]!=''){ 
       	
                $ter_value2=$agencymaster[$k][5];		   
		        $qry2="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value2' AND idTerritoryTitle ='2'";
				$result2=$this->adapter->query($qry2,array());
			    $resultset2=$result2->toArray();
                $ter2=$resultset2[0]['idTerritory'];
                $qryagency="SELECT idAgency FROM agency_master WHERE t2='$ter2'";
                $resultagency=$this->adapter->query($qryagency,array());
                $resultsetagency=$resultagency->toArray();  

			    if(!$resultset2){  
	                $ter_map_value2=0;
	                $array_condition[]=$ter_map_value2;
	                $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory2 value mismatch'];
	             
			    }elseif($resultsetagency){  
                    $ter_map_value2=0;
                    $array_condition[]=$ter_map_value2;
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory2 already exist'];
                }else{  
			       $ter_map_value2=1;
			       $array_condition[]=$ter_map_value2;
	               }    
        }

        if($agencymaster[$k][4] =='' || $agencymaster[$k][4] =="null"){
               $ter_map_value1=0;
            $array_condition[]=$ter_map_value1;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check territory1 is empty'];  

       }else if($agencymaster[$k][4]!=''){ 
     	
        $ter_value1=$agencymaster[$k][4];		   
        $qry1="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value1' AND idTerritoryTitle ='1'";
		$result1=$this->adapter->query($qry1,array());
	    $resultset1=$result1->toArray();	

	    if(!$resultset1){   
            $ter_map_value1=0;
            $array_condition[]=$ter_map_value1;
            $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory1 value mismatch'];
         
	    }else{  
	       $ter_map_value1=1;
	       $array_condition[]=$ter_map_value1;
           }    
        }

        if($agencymaster[$k][3] =='' || $agencymaster[$k][3] =="null"){
                $status=0; 
                $array_condition[]=$status;   
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status empty'];    
        	}else if($agencymaster[$k][3] == "Active" || $agencymaster[$k][3] =="active"){
                $status=1;
                $array_condition[]=$status; 
        	}else if($agencymaster[$k][3] == "Inactive" || $agencymaster[$k][3] =="inactive"){
        		$status=2;
        		$array_condition[]=$status; 
            }else{
                $status=0; 
                $array_condition[]=$status;     
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the status data'];    
        }

       if($agencymaster[$k][2]=='' || $agencymaster[$k][2]=="null"){
            	$mobile=0;
            	$array_condition[]=$mobile;   
        $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the mobile empty'];

		}else if(!is_numeric($agencymaster[$k][2])){
                $mobile=0; 
                $array_condition[]=$mobile;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Mobile no numeric only'];  

        }else if((strlen($agencymaster[$k][2])<10) || (strlen($agencymaster[$k][2])>10)){
                $mobile=0;
                $array_condition[]=$mobile; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please enter valid mobile number'];  
        }else if($agencymaster[$k][2]!='' || $agencymaster[$k][2]!="null"){
            $mail=$agencymaster[$k][2];          
                $qry_mob="SELECT idAgency FROM agency_master WHERE agencyMobileNo='$mail'";
                $result_mob=$this->adapter->query($qry_mob,array());
                $resultset_mob=$result_mob->toArray();
               
               if(!$resultset_mob){
               $mobile=1; 
                $array_condition[]=$mobile;  

               }else{
               $mobile=0; 
                $array_condition[]=$mobile; 
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Mobile no already exist'];  

               }
                
                 
        }

        if($agencymaster[$k][1]=='' || $agencymaster[$k][1]=="null"){
		    	$email_id=0; 
		    	$array_condition[]=$email_id;  
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the email id empty'];

		}else if (!filter_var($agencymaster[$k][1], FILTER_VALIDATE_EMAIL)) {
            $email_id=0;  
                $array_condition[]=$email_id; 
            $ret_arr=['code'=>'3','status'=>false,'message'=>'Please enter valid email id'];
        }if($agencymaster[$k][1]!='' || $agencymaster[$k][1]!="null"){

             $mail=$agencymaster[$k][1];          
                $qry_mob="SELECT idAgency FROM agency_master WHERE agencyEmail='$mail'";
                $result_mob=$this->adapter->query($qry_mob,array());
                $resultset_mob=$result_mob->toArray();
               
               if(!$resultset_mob){
                $email_id=1;  
                $array_condition[]=$email_id;  

               }else{
               $email_id=0;  
                $array_condition[]=$email_id;  
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Email id already exist'];  

               }

                
        }   

        if($agencymaster[$k][0]=='' || $agencymaster[$k][0]=="null"){
		    	$name=0;  
		    	$array_condition[]=$name;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the Name empty'];

		}if($agencymaster[$k][0]!='' || $agencymaster[$k][0]!="null"){
                $name=1;  
                $array_condition[]=$name; 
                 
        }           
                
	} // close loop $no_warehouse;

	if(count($array_condition)!= 0){

	    for($j=0; $j<count($array_condition);$j++){ 
            $zero=0;
        if(in_array($zero,$array_condition)){

           $check=0;
        }else{
           $check=1;

        }
                   
    }

	}else{

		  $check=0;
		  $ret_arr=['code'=>'3','status'=>false,'message'=>'Excel data is empty'];
	}


 if($check!=0){

	for($i=0; $i<count($agencymaster);$i++) {

			    if($agencymaster[$i][4]!=''){    	
			    	$ter_value1=$agencymaster[$i][4];		   
			        $qry1="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value1' AND idTerritoryTitle ='1'";
					$result1=$this->adapter->query($qry1,array());
				    $resultset1=$result1->toArray();
				    $territory1=$resultset1[0]['idTerritory'];
			    }else{
			    	$territory1=0;
			    }
			    if($agencymaster[$i][5]!=''){
			    	$ter_value2=$agencymaster[$i][5];	   
			        $qry2="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value2' AND idTerritoryTitle ='2'";
					$result2=$this->adapter->query($qry2,array());
				    $resultset2=$result2->toArray();	
			    	$territory2=$resultset2[0]['idTerritory'];
			    }else{
			    	$territory2=0;
			    }
			    if($agencymaster[$i][6]!=''){
			    	$ter_value3=$agencymaster[$i][6];		   
			        $qry3="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value3' AND idTerritoryTitle ='3'";
					$result3=$this->adapter->query($qry3,array());
				    $resultset3=$result3->toArray();
			    	$territory3=$resultset3[0]['idTerritory'];
			    }else{
			    	$territory3=0;
			    }
			    if($agencymaster[$i][7]!=''){
			    	$ter_value4=$agencymaster[$i][7];	   
			        $qry4="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value4' AND idTerritoryTitle ='4'";
					$result4=$this->adapter->query($qry4,array());
				    $resultset4=$result4->toArray();	

			    	$territory4=$resultset4[0]['idTerritory'];
			    }else{
			    	$territory4=0;
			    }
			    if($agencymaster[$i][8]!=''){
			    	$ter_value5=$agencymaster[$i][8];   
			        $qry5="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value5' AND idTerritoryTitle ='5'";
					$result5=$this->adapter->query($qry5,array());
				    $resultset5=$result5->toArray();
			    	$territory5=$resultset5[0]['idTerritory'];
			    }else{
			    	$territory5=0;
			    }
			    if($agencymaster[$i][9]!=''){
			    	$ter_value6=$agencymaster[$i][9];	   
			        $qry6="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value6' AND idTerritoryTitle ='6'";
					$result6=$this->adapter->query($qry6,array());
				    $resultset6=$result6->toArray();	
			    	$territory6=$resultset6[0]['idTerritory'];
			    }else{
			    	$territory6=0;
			    }
			    if($agencymaster[$i][10]!=''){
			    	$ter_value7=$agencymaster[$i][10];		   
			        $qry7="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value7' AND idTerritoryTitle ='7'";
					$result7=$this->adapter->query($qry7,array());
				    $resultset7=$result7->toArray();	
			    	$territory7=$resultset7[0]['idTerritory'];
			    }else{
			    	$territory7=0;
			    }
			    if($agencymaster[$i][11]!=''){
			    	$ter_value8=$agencymaster[$i][11];		   
			        $qry8="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value8' AND idTerritoryTitle ='8'";
					$result8=$this->adapter->query($qry8,array());
				    $resultset8=$result8->toArray();	
			    	$territory8=$resultset8[0]['idTerritory'];
			    }else{
			    	$territory8=0;
			    }
			    if($agencymaster[$i][12]!=''){
			    	$ter_value9=$agencymaster[$i][12];	   
			        $qry9="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value9' AND idTerritoryTitle ='9'";
					$result9=$this->adapter->query($qry9,array());
				    $resultset9=$result9->toArray();
			    	$territory9=$resultset9[0]['idTerritory'];
			    }else{
			    	$territory9=0;
			    }
			    if($agencymaster[$i][13]!=''){
				    $ter_value10=$agencymaster[$i][13];	   
			        $qry10="SELECT idTerritory,idTerritoryTitle,territoryValue FROM territory_master WHERE territoryValue='$ter_value10' AND idTerritoryTitle ='10'";
					$result10=$this->adapter->query($qry10,array());
				    $resultset10=$result10->toArray();
			    	$territory10=$territory10[0]['idTerritory'];
			    }else{
			    	$territory10=0;
			    }

			    if($agencymaster[$i][3]=="Active" || $agencymaster[$i][3]=="active"){
                $status=1;
	        	}else if($agencymaster[$i][3]=="Inactive" || $agencymaster[$i][3]=="inactive"){
	        	$status=2;
	            }


            $qry_list="SELECT idAgency FROM agency_master where agencyName=? and agencyEmail=? and agencyMobileNo=? and t1=? and t2=? and t3=? and t4=? and t5=? and t6=? and t7=? and t8=? and t9=? and t10=?";

			$result_list=$this->adapter->query($qry_list,array($agencymaster[$i][0],$agencymaster[$i][1],$agencymaster[$i][2],$territory1,$territory2,$territory3,$territory4,$territory5,$territory6,$territory7,$territory8,$territory9,$territory10));
			$resultset_list=$result_list->toArray();

			if(!$resultset_list){
						$this->adapter->getDriver()->getConnection()->beginTransaction();
						try {					
							$data['agencyName']=$agencymaster[$i][0];
							$data['agencyEmail']=$agencymaster[$i][1];
							$data['agencyMobileNo']=$agencymaster[$i][2];						
				    		$data['t1']=(($agencymaster[$i][4]!='')? $resultset1[0]['idTerritory']:0);
							$data['t2']=(($agencymaster[$i][5]!='')? $resultset2[0]['idTerritory']:0);
							$data['t3']=(($agencymaster[$i][6]!='')? $resultset3[0]['idTerritory']:0);
							$data['t4']=(($agencymaster[$i][7]!='')? $resultset4[0]['idTerritory']:0);
							$data['t5']=(($agencymaster[$i][8]!='')? $resultset5[0]['idTerritory']:0);
							$data['t6']=(($agencymaster[$i][9]!='')? $resultset6[0]['idTerritory']:0);
							$data['t7']=(($agencymaster[$i][10]!='')? $resultset7[0]['idTerritory']:0);
							$data['t8']=(($agencymaster[$i][11]!='')? $resultset8[0]['idTerritory']:0);
							$data['t9']=(($agencymaster[$i][12]!='')? $resultset9[0]['idTerritory']:0);
							$data['t10']=(($agencymaster[$i][13]!='')? $resultset10[0]['idTerritory']:0);
							$data['status']=$status;
							$data['created_at']=date('Y-m-d H:i:s');
							$data['created_by']=1;
							$data['updated_at']=date('Y-m-d H:i:s');
							$data['updated_by']=1;
							$insert=new Insert('agency_master');
							$insert->values($data);
							$statement=$this->adapter->createStatement();
							$insert->prepareStatement($this->adapter, $statement);
							$insertresult=$statement->execute();
							$insert_value +=$insert_count+1;
							$this->adapter->getDriver()->getConnection()->commit();
						} catch(\Exception $e) {
							$ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
							$this->adapter->getDriver()->getConnection()->rollBack();
						}
					} else {

						$reject_value += $reject_count+1;
				
					}

                }

        if($insert_value!=0 && $reject_value==0){

              $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
        }else if($insert_value ==0 && $reject_value !=0){

        	 $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists'];

        }else if($insert_value!=0 && $reject_value!=0){

       $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists  '.$reject_value.'Uploaded  '.$insert_value];
        }

		
				}
			} else {
				   $ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please verify the csv file'];
			}

			
		}

		return $ret_arr;
	} // close func	


public function uploadscheme($param){
         $userid=$param->userid;
        ini_set('display_errors',true);
        $Uploads_dir = 'public/uploads/csv';
        $tmp_name=$_FILES["myFile"]["tmp_name"]; 
        $name = basename($_FILES["myFile"]["name"]); 
        $imageName = rand(6,66666).'.'. pathinfo($_FILES["myFile"]['name'],PATHINFO_EXTENSION);
        if(move_uploaded_file($tmp_name, "$Uploads_dir/$imageName")) {
            $r="public/uploads/csv/$imageName";
            $file = fopen($r, "r",FILE_SKIP_EMPTY_LINES);
            $emapData = fgetcsv($file, 10000, ","); 
                $row=0;
                $size=sizeof($emapData);
        
                if($size=='20' && $emapData !=null) {
                $scheme=array();
                $no_scheme=array();
                while (($record = fgetcsv($file)) !== FALSE) {
                   $row++;
                    array_push($scheme,$record);
                     
                }
    
        $insert_count=0;
        $reject_count=0;
        $reject_value=0; 
        $insert_value=0; 
       
    for($k=0; $k<count($scheme);$k++)
    {


        //Product to product
        if ($scheme[$k][0]=='Product to product' || $scheme[$k][0]=='product to product') 
        {
            if ($scheme[$k][16] =='' || $scheme[$k][16]=="null") 
            {
                $freeproductsize=0; 
                    $no_scheme[]=$freeproductsize;
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Free product size value empty'];   
            }else if($scheme[$k][16] !='' || $scheme[$k][16]!="null")
            {
                 $freeproductsize=$scheme[$k][16];          
                /*$qry16="SELECT idProductsize,productSize FROM product_size WHERE productSize='$freeproductsize'";
                $result16=$this->adapter->query($qry16,array());
                $resultset16=$result16->toArray();*/
                if($scheme[$k][11]==$scheme[$k][16]){              
                    $freeproductsize=1; 
                    $no_scheme[]=$freeproductsize;
                }else{  
                    $freeproductsize=0; 
                    $no_scheme[]=$freeproductsize;
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Free product size value mismatch'];             

                   }    
            }

            if ($scheme[$k][15] =='' || $scheme[$k][15]=="null") 
            {
                    $freeproduct_name=0; 
                    $no_scheme[]=$freeproduct_name;
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Free product value empty'];             
            }else if($scheme[$k][15] !='' || $scheme[$k][15]!="null")
            {
                 $freeproduct=$scheme[$k][15];          
                /*$qry15="SELECT idProduct,productName FROM product_details WHERE productName='$freeproduct' AND status!='2'";
                $result15=$this->adapter->query($qry15,array());
                $resultset15=$result15->toArray();*/
                if($scheme[$k][10]==$scheme[$k][15]){              
                    $freeproduct_name=1; 
                    $no_scheme[]=$freeproduct_name;
                }else{  
                    $freeproduct_name=0; 
                    $no_scheme[]=$freeproduct_name;
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Free product value mismatch'];             
                   }    
            } 

            if($scheme[$k][17] =='' || $scheme[$k][17]=="null" || $scheme[$k][17] ==0){
                  $freequantity=0; 
                  $no_scheme[]=$freequantity; 
                  $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the Free product quantity empty'];

            }else if(!is_numeric($scheme[$k][17])){
                  $freequantity=0; 
                  $no_scheme[]=$freequantity;
                  $ret_arr=['code'=>'3','status'=>false,'message'=>'Free product quantity allows numeric only'];
            }else if(strlen($scheme[$k][17])>5){
              $freequantity=0; 
              $no_scheme[]=$freequantity;
              $ret_arr=['code'=>'3','status'=>false,'message'=>'Free product quantity allows 5 digit only'];

            }else if($scheme[$k][17]!='' || $scheme[$k][17]!="null"){
                  $freequantity=1; 
                  $no_scheme[]=$freequantity;
            }
        }

     //'Product to other product

        if ($scheme[$k][0]=='Product to other product' || $scheme[$k][0]=='product to other product') 
        {
            if ($scheme[$k][16] =='' || $scheme[$k][16]=="null") 
            {
                $freeproductsize=0; 
                $no_scheme[]=$freeproductsize;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Free product size value empty'];   
            }else if($scheme[$k][16] !='' || $scheme[$k][16]!="null")
            {
                 $freeproductsize=$scheme[$k][16];          
                $qry16="SELECT idProductsize,productSize FROM product_size WHERE productSize='$freeproductsize'";
                $result16=$this->adapter->query($qry16,array());
                $resultset16=$result16->toArray();
                if(!$resultset16){              
                    $freeproductsize=0; 
                    $no_scheme[]=$freeproductsize;
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Free product size value mismatch'];             
                }else{  
                     $product=$scheme[$k][15];  
                    $sizeid= $resultset16[0]['idProductsize'];
                $qry6="SELECT b.idProduct,a.productName FROM product_details AS a
                LEFT JOIN product_size AS b ON b.idProduct=a.idProduct
                 WHERE a.productName='$product' AND b.idProductsize='$sizeid' AND status!='2'";
                $result6=$this->adapter->query($qry6,array());
                $resultset6=$result6->toArray();
                if(!$resultset6){
                   $freeproductsize=0; 
                    $no_scheme[]=$freeproductsize;
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Free product is not available on this size'];    
                }else{
                    $freeproductsize=1; 
                    $no_scheme[]=$freeproductsize;
                }
                }    
            }

            if ($scheme[$k][15] =='' || $scheme[$k][15]=="null") 
            {
                    $freeproduct_name=0; 
                    $no_scheme[]=$freeproduct_name;
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Free product value empty'];             
            }else if($scheme[$k][15] !='' || $scheme[$k][15]!="null")
            {
                 $freeproduct=$scheme[$k][15];          
                $qry15="SELECT idProduct,productName FROM product_details WHERE productName='$freeproduct' AND status!='2'";
                $result15=$this->adapter->query($qry15,array());
                $resultset15=$result15->toArray();
                if(!$resultset15){              
                    $freeproduct_name=0; 
                    $no_scheme[]=$freeproduct_name;
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Free product value mismatch'];             
                }else{  
                    $ter_type=$scheme[$k][7];    
                    $territory=$scheme[$k][6];    

                    $qry2="SELECT idTerritoryTitle FROM territorytitle_master WHERE title='$territory' AND title!=''";
                    $result2=$this->adapter->query($qry2,array());
                    $resultset2=$result2->toArray();

                    $qry3="SELECT idTerritory,territoryValue FROM territory_master WHERE territoryValue='".$ter_type."' AND idTerritoryTitle='".$resultset2[0]['idTerritoryTitle']."' AND status=1";
                    $result3=$this->adapter->query($qry3,array());
                    $resultset3=$result3->toArray();

                  if(count($resultset3)>0){
                     $terval=$resultset3[0]['idTerritory'];
                    }else{
                         $terval=0;
                    }
                         $qry33="SELECT idProductTerritory FROM product_territory_details WHERE idTerritory='$terval'";
                        $result33=$this->adapter->query($qry33,array());
                        $resultset33=$result33->toArray();

                    $product=$resultset15[0]['idProduct']; 
                   // $terid=$resultset33[0]['idProductTerritory']; 

                    $qry="SELECT a.idProductTerritory as id,pd.idProduct as idProduct ,pd.idCategory,pd.idSubCategory,pd.productName as productName
                    FROM product_territory_details a 
                    LEFT JOIN product_details as pd ON pd.idProduct=a.idProduct
                    WHERE idTerritory IN($terval) AND pd.idProduct='$product' AND pd.status='1'";
                    $result=$this->adapter->query($qry,array());
                    $resultset=$result->toArray();
                    if(!$resultset6){
                     $freeproduct_name=0; 
                    $no_scheme[]=$freeproduct_name;
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Free product is not available on this subcategory'];    
                }else{
                    $freeproduct_name=1; 
                    $no_scheme[]=$freeproduct_name;
                }
                   }    
            }

             if($scheme[$k][17] =='' || $scheme[$k][17]=="null" || $scheme[$k][17] ==0){
                  $freequantity=0; 
                  $no_scheme[]=$freequantity; 
                  $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the quantity empty'];

            }else if(!is_numeric($scheme[$k][17])){
                  $freequantity=0; 
                  $no_scheme[]=$freequantity;
                  $ret_arr=['code'=>'3','status'=>false,'message'=>'Quantity allows numeric only'];
            }else if(strlen($scheme[$k][17])>5){
              $freequantity=0; 
              $no_scheme[]=$freequantity;
              $ret_arr=['code'=>'3','status'=>false,'message'=>'Quantity allows 5 digit only'];

            }else if($scheme[$k][17]!='' || $scheme[$k][17]!="null"){
                  $freequantity=1; 
                  $no_scheme[]=$freequantity;
            }
        }

     //Product to discount
        
        if ($scheme[$k][0]=='Product to discount' || $scheme[$k][0]=='product to discount') 
        {
            if($scheme[$k][14] =='' || $scheme[$k][14]=="null" || $scheme[$k][14]==0){
                  $discountvalue=0; 
                  $no_scheme[]=$discountvalue; 
                  $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the discount value empty'];

            }else if(!is_numeric($scheme[$k][14]))
            {
                
                   $discountvalue=0; 
                  $no_scheme[]=$discountvalue;
                  $ret_arr=['code'=>'3','status'=>false,'message'=>'Discount value allows numeric only'];
                 
            }
            else if($scheme[$k][14]!='' && $scheme[$k][14]!="null" && $scheme[$k][14]!=0)
            {
                   $discountvalue=1; 
                  $no_scheme[]=$discountvalue;
                
                 
            }
            if($scheme[$k][13] =='' || $scheme[$k][13]=="null"){
                  $discounttype=0; 
                  $no_scheme[]=$discounttype; 
                  $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the discount type empty'];

            }
            else if($scheme[$k][13]!='' || $scheme[$k][13]!="null")
            {
                if ($scheme[$k][13]=='Flat' || $scheme[$k][13]=='flat') 
                {
                   $discounttype=1; 
                  $no_scheme[]=$discounttype;
                }
                else if($scheme[$k][13]=='Percentage' || $scheme[$k][13]=='percentage')
                {
                    $discounttype=1; 
                  $no_scheme[]=$discounttype;
                }
                else
                {
                     $discounttype=0; 
                  $no_scheme[]=$discounttype;
                   $ret_arr=['code'=>'3','status'=>false,'message'=>'Discount type mismatch'];
                }
                 
            }
         }
        //Quantity validation
            if($scheme[$k][12] =='' || $scheme[$k][12]=="null" || $scheme[$k][12] ==0){
                  $quantity=0; 
                  $no_scheme[]=$quantity; 
                  $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the quantity empty'];

            }else if(!is_numeric($scheme[$k][12])){
                  $quantity=0; 
                  $no_scheme[]=$quantity;
                  $ret_arr=['code'=>'3','status'=>false,'message'=>'Quantity allows numeric only'];
            }else if(strlen($scheme[$k][12])>5){
              $quantity=0; 
              $no_scheme[]=$quantity;
              $ret_arr=['code'=>'3','status'=>false,'message'=>'Quantity allows 5 digit only'];

            }else if($scheme[$k][12]!='' || $scheme[$k][12]!="null"){
                  $quantity=1; 
                  $no_scheme[]=$quantity;
            }
             //Product size validation
             if($scheme[$k][11]=='' || $scheme[$k][11]=="null"){
                $product_size=0;  
                $no_scheme[]=$product_size;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the product size empty'];

            }else if($scheme[$k][11]!='' || $scheme[$k][11]!="null"){ 

                $size=$scheme[$k][11];         
                $qry7="SELECT idProductsize,productSize FROM product_size WHERE productSize='$size'";
                $result7=$this->adapter->query($qry7,array());
                $resultset7=$result7->toArray();
                if(!$resultset7){              
                    $product_size=0; 
                    $no_scheme[]=$product_size;
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Product size mismatch'];             
                }else{  
                    $product=$scheme[$k][10];  
                    $sizeid= $resultset7[0]['idProductsize'];
                $qry6="SELECT b.idProduct,a.productName FROM product_details AS a
                LEFT JOIN product_size AS b ON b.idProduct=a.idProduct
                 WHERE a.productName='$product' AND b.productSize='$size' AND b.status!='2'";

                $result6=$this->adapter->query($qry6,array());
                $resultset6=$result6->toArray();
             
                if(!$resultset6){
                    $product_size=0; 
                    $no_scheme[]=$product_size;
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Product is not available on this size'];    
                }else{
                    $product_size=1; 
                    $no_scheme[]=$product_size;
                }
                    
                   }    
            } 
             //Product validation

            if($scheme[$k][10]=='' || $scheme[$k][10]=="null"){
                $product_name=0;  
                $no_scheme[]=$product_name;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the product value empty'];

            }else if($scheme[$k][10]!='' || $scheme[$k][10]!="null"){
               
                $product=$scheme[$k][10];          
                $qry6="SELECT idProduct,productName FROM product_details WHERE productName='$product' AND status!='2'";
                $result6=$this->adapter->query($qry6,array());
                $resultset6=$result6->toArray();
                if(!$resultset6){              
                    $product_name=0; 
                    $no_scheme[]=$product_name;
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Product value mismatch'];             
                }else{  

                    $ter_type=$scheme[$k][7];    
                $territory=$scheme[$k][6]; 
                 $cate=$scheme[$k][8]; 
                 $sub_category=$scheme[$k][9];         
                $qry5="SELECT idSubCategory FROM subcategory WHERE subcategory='$sub_category' AND status!='2'";
                $result5=$this->adapter->query($qry5,array());
                $resultset5=$result5->toArray();        
                $qry4="SELECT idCategory FROM category WHERE category='$cate' AND status!='2'";
                $result4=$this->adapter->query($qry4,array());
                $resultset4=$result4->toArray();   

                $qry2="SELECT idTerritoryTitle FROM territorytitle_master WHERE title='$territory' AND title!=''";
                $result2=$this->adapter->query($qry2,array());
                $resultset2=$result2->toArray();

                $qry3="SELECT idTerritory,territoryValue FROM territory_master WHERE territoryValue='".$ter_type."' AND idTerritoryTitle='".$resultset2[0]['idTerritoryTitle']."' AND status=1";
                $result3=$this->adapter->query($qry3,array());
                $resultset3=$result3->toArray();
                if(count($resultset3)>0){
                     $terval=$resultset3[0]['idTerritory'];
                }else{
                     $terval=0;
                }
               
                     $qry33="SELECT idProductTerritory FROM product_territory_details WHERE idTerritory='$terval'";
                    $result33=$this->adapter->query($qry33,array());
                    $resultset33=$result33->toArray();
                    /*print_r($resultset2);
                    print_r($resultset3);
                    print_r($terval);
                    print_r($resultset33);*/

                $catid=$resultset4[0]['idCategory']; 
               
                $subcatid=$resultset5[0]['idSubCategory']; 
                $proid=$resultset6[0]['idProduct']; 

                $qry="SELECT a.idProductTerritory as id,pd.idProduct as idProduct ,pd.idCategory,pd.idSubCategory,pd.productName as productName
                FROM product_territory_details a 
                LEFT JOIN product_details as pd ON pd.idProduct=a.idProduct
                WHERE idTerritory IN($terval) AND pd.idCategory='$catid' AND pd.idSubCategory='$subcatid' AND pd.idProduct='$proid' AND pd.status='1'";
                $result=$this->adapter->query($qry,array());
                $resultset=$result->toArray();
                    if(!$resultset){              
                    $product_name=0; 
                    $no_scheme[]=$product_name;
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Product is not available on this subcategory'];             
                }else{ 
                       $product_name=1; 
                    $no_scheme[]=$product_name;
                    }
                    
                   }    
            } 
              //Subcategory validation
            if($scheme[$k][9]=='' || $scheme[$k][9]=="null"){

                $sub_cate=0;  
                $no_scheme[]=$sub_cate;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the subcategory value empty'];

                }else if($scheme[$k][9]!='' || $scheme[$k][9]!="null"){
               
                $sub_category=$scheme[$k][9];         
                $qry5="SELECT idSubCategory FROM subcategory WHERE subcategory='$sub_category' AND status!='2'";
                $result5=$this->adapter->query($qry5,array());
                $resultset5=$result5->toArray();
                if(!$resultset5){              
                    $sub_cate=0; 
                    $no_scheme[]=$sub_cate;
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Subcategory value mismatch'];             
                }else{  

                $ter_type=$scheme[$k][7];    
                $territory=$scheme[$k][6]; 
                 $cate=$scheme[$k][8];         
                $qry4="SELECT idCategory FROM category WHERE category='$cate' AND status!='2'";
                $result4=$this->adapter->query($qry4,array());
                $resultset4=$result4->toArray();   

                $qry2="SELECT idTerritoryTitle FROM territorytitle_master WHERE title='$territory' AND title!=''";
                $result2=$this->adapter->query($qry2,array());
                $resultset2=$result2->toArray();

                $qry3="SELECT idTerritory,territoryValue FROM territory_master WHERE territoryValue='".$ter_type."' AND idTerritoryTitle='".$resultset2[0]['idTerritoryTitle']."' AND status=1";
                $result3=$this->adapter->query($qry3,array());
                $resultset3=$result3->toArray();

                if(count($resultset3)>0){
                     $terval=$resultset3[0]['idTerritory'];
                }else{
                     $terval=0;
                }
                     $qry33="SELECT idProductTerritory FROM product_territory_details WHERE idTerritory='$terval'";
                    $result33=$this->adapter->query($qry33,array());
                    $resultset33=$result33->toArray();

                $catid=$resultset4[0]['idCategory']; 
              //  $terid=$resultset33[0]['idProductTerritory']; 
                $subcatid=$resultset5[0]['idSubCategory']; 

                $qry="SELECT a.idProductTerritory as id,pd.idProduct as idProduct ,pd.idCategory,pd.idSubCategory,pd.productName as productName
                FROM product_territory_details a 
                LEFT JOIN product_details as pd ON pd.idProduct=a.idProduct
                WHERE idTerritory IN($terval) AND pd.idCategory='$catid' AND pd.idSubCategory='$subcatid' AND pd.status='1'";
                $result=$this->adapter->query($qry,array());
                $resultset=$result->toArray();
                    if(!$resultset){              
                    $sub_cate=0; 
                    $no_scheme[]=$sub_cate;
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Product is not available on this subcategory'];             
                }else{ 
                       $sub_cate=1; 
                       $no_scheme[]=$sub_cate;
                    }
                   }    
                } 
                 //Category validation
                if($scheme[$k][8]=='' || $scheme[$k][8]=="null"){
                $category=0;  
                $no_scheme[]=$category;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the category value empty'];

                }else if($scheme[$k][8]!='' || $scheme[$k][8]!="null"){
                $cate=$scheme[$k][8];         
                $qry4="SELECT idCategory FROM category WHERE category='$cate' AND status!='2'";
                $result4=$this->adapter->query($qry4,array());
                $resultset4=$result4->toArray();

                
                if(!$resultset4){              
                    $category=0; 
                    $no_scheme[]=$category;
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Category value mismatch'];             
                }else{ 

                 $ter_type=$scheme[$k][7];    
                $territory=$scheme[$k][6];    

                $qry2="SELECT idTerritoryTitle FROM territorytitle_master WHERE title='$territory' AND title!=''";
                $result2=$this->adapter->query($qry2,array());
                $resultset2=$result2->toArray();

                $qry3="SELECT idTerritory,territoryValue FROM territory_master WHERE territoryValue='".$ter_type."' AND idTerritoryTitle='".$resultset2[0]['idTerritoryTitle']."' AND status=1";
                $result3=$this->adapter->query($qry3,array());
                $resultset3=$result3->toArray();

                if(count($resultset3)>0){
                     $terval=$resultset3[0]['idTerritory'];
                }else{
                     $terval=0;
                }
                     $qry33="SELECT idProductTerritory FROM product_territory_details WHERE idTerritory='$terval'";
                    $result33=$this->adapter->query($qry33,array());
                    $resultset33=$result33->toArray();

                $catid=$resultset4[0]['idCategory']; 
              //  $terid=$resultset33[0]['idProductTerritory']; 

                $qry="SELECT a.idProductTerritory as id,pd.idProduct as idProduct ,pd.idCategory,pd.idSubCategory,pd.productName as productName
                FROM product_territory_details a 
                LEFT JOIN product_details as pd ON pd.idProduct=a.idProduct
                WHERE idTerritory IN($terval) AND pd.idCategory='$catid' AND pd.status='1'";
                $result=$this->adapter->query($qry,array());
                $resultset=$result->toArray();
                if(!$resultset){              
                    $category=0; 
                    $no_scheme[]=$category;
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Product is not available on this category'];             
                }else{ 
                   $category=1; 
                   $no_scheme[]=$category;
               }
                   }    
                } 
                 //Territory type validation
                if($scheme[$k][7]=='' || $scheme[$k][7]=="null"){

                $territory_type=0;  
                $no_scheme[]=$territory_type;  
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the territory type empty'];

                }else if($scheme[$k][7]!='' || $scheme[$k][7]!="null"){
               
                $ter_type=$scheme[$k][7];    
                $territory=$scheme[$k][6];    

                $qry2="SELECT idTerritoryTitle FROM territorytitle_master WHERE title='$territory' AND title!=''";
                $result2=$this->adapter->query($qry2,array());
                $resultset2=$result2->toArray();

                $qry3="SELECT idTerritory,territoryValue FROM territory_master WHERE territoryValue='".$ter_type."' AND idTerritoryTitle='".$resultset2[0]['idTerritoryTitle']."' AND status=1";
                $result3=$this->adapter->query($qry3,array());
                $resultset3=$result3->toArray();
                if(!$resultset3){              
                    $territory_type=0; 
                    $no_scheme[]=$territory_type;  
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory type value mismatch'];             
                }else {
                    $terval=$resultset3[0]['idTerritory'];
                     $qry33="SELECT idProductTerritory FROM product_territory_details WHERE idTerritory='$terval'";
                    $result33=$this->adapter->query($qry33,array());
                    $resultset33=$result33->toArray();
                    if(!$resultset33){              
                            $territory_type=0; 
                            $no_scheme[]=$territory_type;  
                            $ret_arr=['code'=>'3','status'=>false,'message'=>'Product is not available on this territory type value'];             
                        }else{  
                           $territory_type=1; 
                           $no_scheme[]=$territory_type;  
                        }    
                    }
                }
                 //Territory validation

                if($scheme[$k][6]=='' || $scheme[$k][6]=="null"){

                $title=0;  
                $no_scheme[]=$title;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the territory value empty'];

                }else if($scheme[$k][6]!='' || $scheme[$k][6]!="null"){
               
                $territory=$scheme[$k][6];         
                $qry2="SELECT idTerritoryTitle FROM territorytitle_master WHERE title='$territory' AND title!=''";
                $result2=$this->adapter->query($qry2,array());
                $resultset2=$result2->toArray();
                if(!$resultset2){              
                    $title=0; 
                    $no_scheme[]=$title;
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Territory value mismatch'];             
                }else {
                    $tertitle= $resultset2[0]['idTerritoryTitle'];
                     $qry22="SELECT idProduct FROM product_details WHERE idTerritoryTitle='$tertitle'";
                $result22=$this->adapter->query($qry22,array());
                $resultset22=$result22->toArray();
                    if(!$resultset22){              
                            $title=0; 
                            $no_scheme[]=$title;
                            $ret_arr=['code'=>'3','status'=>false,'message'=>'Product is not available on this territory'];             
                        }else{  
                           $title=1; 
                           $no_scheme[]=$title;
                        }  
                    }
                } 

                //To date validation
                if($scheme[$k][5] == '' || $scheme[$k][5] == "null"){
                    $to_date=0; 
                    $no_scheme[]=$to_date; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the to date empty'];

                }else if($scheme[$k][5]!='' || $scheme[$k][5]!="null"){
                 

                    if(!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/",$scheme[$k][5])){

                    $to_date=0;
                    $no_scheme[]=$to_date; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'To date invalid date format'];
                }
                else{
                
                    $to_date=1;
                    $no_scheme[]=$to_date; 
                } 
                }

                 if($scheme[$k][4] == '' || $scheme[$k][4] == "null"){
                    $from_date=0; 
                    $no_scheme[]=$from_date; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the from date empty'];
                    

                }else if($scheme[$k][4]!='' || $scheme[$k][4]!="null"){

                    if(!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/",$scheme[$k][4])){
                   
                     $from_date=0; 
                    $no_scheme[]=$from_date; 
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'From date invalid date format'];  
                    
                } else
                {
                    $from_date=1;
                    $no_scheme[]=$from_date; 
                    
                  
                }
            }
             //From date validation

            if($scheme[$k][3]=='' || $scheme[$k][3]=="null"){
                $customertype=0;  
                $no_scheme[]=$customertype;  
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the customer levels value empty'];

            }else if($scheme[$k][3]!='' || $scheme[$k][3]!="null"){
           
            $customer_type=$scheme[$k][3];           
            $qry1="SELECT idCustomerType FROM customertype WHERE custType='$customer_type' AND status!='2'";
            $result1=$this->adapter->query($qry1,array());
            $resultset1=$result1->toArray();
            if(!$resultset1){              
                $customertype=0; 
                $no_scheme[]=$customertype;
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Customer levels value mismatch'];             
            }else{  
               $customertype=1; 
               $no_scheme[]=$customertype;
               }    
            } 

         //  when the scheme applicability is customized then choose customer name
          if ($scheme[$k][1]=='Customized' || $scheme[$k][1]=='customized') 
          {
              if($scheme[$k][2]=='' || $scheme[$k][2]=="null"){
                $name=0;  
                $no_scheme[]=$name;  
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please customer name empty'];

                }else if($scheme[$k][2]!='' || $scheme[$k][2]!="null"){
               
                $customer_name=$scheme[$k][2];           
                $qry="SELECT idCustomer FROM customer WHERE cs_name='$customer_name' AND cs_status!='2'";
                $result=$this->adapter->query($qry,array());
                $resultset=$result->toArray();
                if(!$resultset){              
                    $name=0; 
                    $no_scheme[]=$name;
                    $ret_arr=['code'=>'3','status'=>false,'message'=>'Customer name mismatch'];             
                }else{  
                   $name=1; 
                   $no_scheme[]=$name;
                   }    
                } 
          }
          else
          {
            $name=1; 
            $no_scheme[]=$name;
          }
              //Scheme applicability validation
            if(trim($scheme[$k][1])=='' || trim($scheme[$k][1])=="null"){
                $applicability=0; 
                $no_scheme[]=$applicability;   
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the scheme applicability empty'];    
            }else if(trim($scheme[$k][1])=="Standard" || trim($scheme[$k][1])=="standard"){
                $applicability=1;
                $no_scheme[]=$applicability;   
            }else if(trim($scheme[$k][1])=="Customized" || trim($scheme[$k][1])=="customized"){
                $applicability=2;
                $no_scheme[]=$applicability;   
            }else{
                $applicability=0;   
                $no_scheme[]=$applicability;     
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the scheme applicability data'];    
            }
              //Scheme type validation
           if(trim($scheme[$k][0])=='' || trim($scheme[$k][0])=="null"){
                $type=0; 
                $no_scheme[]=$type;   
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the scheme type empty'];    
            }else if(trim($scheme[$k][0])=="Product to discount" || trim($scheme[$k][0])=="product to discount"){
                $type=1;
                $no_scheme[]=$type;   
            }else if(trim($scheme[$k][0])=="Product to other product" || trim($scheme[$k][0])=="product to other product"){
                $type=2;
                $no_scheme[]=$type;   
            }else if(trim($scheme[$k][0])=="Product to product" || trim($scheme[$k][0])=="product to product"){
                $type=3;
                $no_scheme[]=$type;   
            }else{
                $type=0;   
                $no_scheme[]=$type;     
                $ret_arr=['code'=>'3','status'=>false,'message'=>'Please check the scheme type data'];    
            }   
                   
    }// close loop 
  
if(count($no_scheme)!=0){

    for($j=0; $j<count($no_scheme);$j++){ 
            $zero=0;
        if(in_array($zero,$no_scheme)){

           $check=0;
        }else{
           $check=1;

        }
                   
    }
}else{
          $check=0;

}
     
 if($check!=0)
 {
  
    for($i=0; $i<count($scheme);$i++)
    {

                if ($scheme[$i][2]!='' && $scheme[$i][2]!='null') 
                {
                        $customer_name=$scheme[$i][2];           
                    $qry="SELECT idCustomer FROM customer WHERE cs_name='$customer_name' AND cs_status!='2'";
                    $result=$this->adapter->query($qry,array());
                    $resultset=$result->toArray();
                    if ($resultset) 
                    {
                         $idCustomer=$resultset[0]['idCustomer'];
                    }else
                    {
                        $idCustomer=0;
                    }
                   
                }
                else
                {
                    $idCustomer=0;
                }
               

                $customer=$scheme[$i][3];           
                $qry1="SELECT idCustomerType FROM customertype WHERE custType='$customer' AND status!='2'";
                $result1=$this->adapter->query($qry1,array());
                $resultset1=$result1->toArray();

                $territory=$scheme[$i][6];         
                $qry2="SELECT idTerritoryTitle FROM territorytitle_master WHERE title='$territory' AND title!=''";
                $result2=$this->adapter->query($qry2,array());
                $resultset2=$result2->toArray();

                $qry3="SELECT idTerritory,territoryValue FROM territory_master WHERE territoryValue='".$ter_type."' AND idTerritoryTitle='".$resultset2[0]['idTerritoryTitle']."'";
                $result3=$this->adapter->query($qry3,array());
                $resultset3=$result3->toArray();

                $cate=$scheme[$i][8];         
                $qry4="SELECT idCategory FROM category WHERE category='$cate' AND status!='2'";
                $result4=$this->adapter->query($qry4,array());
                $resultset4=$result4->toArray();

                $sub_category=$scheme[$i][9];         
                $qry5="SELECT idSubCategory FROM subcategory WHERE subcategory='$sub_category' AND status!='2'";
                $result5=$this->adapter->query($qry5,array());
                $resultset5=$result5->toArray();

                $product=$scheme[$i][10];          
                $qry6="SELECT idProduct,productName FROM product_details WHERE productName='$product' AND status!='2'";
                $result6=$this->adapter->query($qry6,array());
                $resultset6=$result6->toArray();

                $size=$scheme[$i][11];         
                $qry7="SELECT idProductsize,productSize FROM product_size WHERE productSize='$size'";
                $result7=$this->adapter->query($qry7,array());
                $resultset7=$result7->toArray();

              if(trim($scheme[$i][13])=="Flat" || trim($scheme[$i][13])=="flat"){
            $discountType=1;
          
            }else if(trim($scheme[$i][13])=="Percentage" || trim($scheme[$i][13])=="percentage"){
                $discountType=2;
                   
            }else
            {
                $discountType=0;
            }
             if ($scheme[$i][15]!='' && $scheme[$i][15]!='null') 
             {
                $freeproduct=$scheme[$i][15];          
                $qry15="SELECT idProduct,productName FROM product_details WHERE productName='$freeproduct' AND status!='2'";
                $result15=$this->adapter->query($qry15,array());
                $resultset15=$result15->toArray();
                if ($resultset15) 
                {
                   $freeidProduct=$resultset15[0]['idProduct'];
                }
                else
                {
                   $freeidProduct=0;
                }
             }else
             {
                 $freeidProduct=0;
             }
             
              if ($scheme[$i][16]!='' && $scheme[$i][16]!='null') 
              {
                 $freesize=$scheme[$i][16];         
                $qry16="SELECT idProductsize,productSize FROM product_size WHERE productSize='$freesize'";
                $result16=$this->adapter->query($qry16,array());
                $resultset16=$result16->toArray();
                if ($resultset16) 
                {
                   $freeidProductsize=$resultset16[0]['idProductsize'];
                }else
                {
                   $freeidProductsize=0;  
                }
              }
              else
              {
                $freeidProductsize=0;
              }
                

            if(trim($scheme[$i][1])=="Standard" || trim($scheme[$i][1])=="standard"){
            $applicability=1;
          
            }else if(trim($scheme[$i][1])=="Customized" || trim($scheme[$i][1])=="customized"){
                $applicability=2;
                   
            }


            if(trim($scheme[$i][0])=="Product to discount" || trim($scheme[$i][0])=="product to discount"){
                $type=1;
               
            }else if(trim($scheme[$i][0])=="Product to other product" || trim($scheme[$i][0])=="product to other product"){
                $type=2;
             
            }else if(trim($scheme[$i][0])=="Product to product" || trim($scheme[$i][0])=="product to product"){
                $type=3;
                  
            }

            $qry_list="SELECT * FROM scheme where idCustomer='$idCustomer' AND schemeStartdate='".date('Y-m-d',strtotime($scheme[$i][4]))."' AND schemeEnddate='".date('Y-m-d',strtotime($scheme[$i][5]))."' AND schemeApplicable='$applicability' AND idProduct='".$resultset6[0]['idProduct']."' AND scheme_product_size='".$resultset7[0]['idProductsize']."'";
            $result_list=$this->adapter->query($qry_list,array());
            $resultset_list=$result_list->toArray();

            if(!$resultset_list)
            {
                        $this->adapter->getDriver()->getConnection()->beginTransaction();
                        try {  

                            $data['schemeType']=$type; 
                            $data['idCustomerType']=(($scheme[$i][3]!='')? $resultset1[0]['idCustomerType']:0);
                              $data['idCustomer']=$idCustomer;                            
                            $data['schemeStartdate']=date('Y-m-d',strtotime($scheme[$i][4])); 
                            $data['schemeEnddate']=date('Y-m-d',strtotime($scheme[$i][5]));
                            $data['idCategory']=(($scheme[$i][8]!='')? $resultset4[0]['idCategory']:0);    
                            $data['idCustomer']= (($scheme[$i][2]!='')? $resultset[0]['idCustomer']:0);      
                            $data['schemeApplicable']=$applicability;
                            $data['idSubCategory']=(($scheme[$i][9]!='')? $resultset5[0]['idSubCategory']:0);  
                            $data['idTerritory']=(($scheme[$i][7]!='')? $resultset3[0]['idTerritory']:0);  
                            $data['idProduct']=(($scheme[$i][10]!='')? $resultset6[0]['idProduct']:0);  
                            $data['scheme_product_size']=(($scheme[$i][11]!='')? $resultset7[0]['idProductsize']:0); 
                            $data['scheme_product_qty']=$scheme[$i][12];  
                            $data['free_product_size']=$freeidProductsize;  
                            $data['free_product_qty']=($scheme[$i][17]!='')?$scheme[$i][17]:0;  
                            $data['free_product']=$freeidProduct;   
                            $data['discount_type']=$discountType;  
                            $data['scheme_flat_discount']=($scheme[$i][14]!='')?$scheme[$i][14]:0;   
                            $data['scheme_note']=($scheme[$i][18]!='')?$scheme[$i][18]:'';
                            $data['scheme_terms_conditions']=($scheme[$i][19]!='')?$scheme[$i][19]:''; 
                            $data['created_at']=date('Y-m-d H:i:s');
                            $data['created_by']=$userid; 
                                
              
                            $insert=new Insert('scheme');
                            $insert->values($data);
                            $statement=$this->adapter->createStatement();
                            $insert->prepareStatement($this->adapter, $statement);
                            $insertresult=$statement->execute();
                            $insert_value +=$insert_count+1;
                            $this->adapter->getDriver()->getConnection()->commit();
                        } catch(\Exception $e) {
                            $ret_arr=['code'=>'1','status'=>false,'message'=>'Please try again..'.$e];
                            $this->adapter->getDriver()->getConnection()->rollBack();
                        }
                    } else {

                        $reject_value += $reject_count+1;
                
                    } // resultset_list close


                } // for loop close

        if($insert_value!=0 && $reject_value==0)
        {

              $ret_arr=['code'=>'2','status'=>true,'message'=>'Uploaded successfully'];
        }else if($insert_value ==0 && $reject_value !=0)
        {

             $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists data'];

        }else if($insert_value!=0 && $reject_value!=0)
        {

        $ret_arr=['code'=>'3','status'=>false,'message'=>'Already exists  '.$reject_value.'Uploaded  '.$insert_value];
        }
        
    } // check close
    // else
    // {
    //   $ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'File is empty'];  
    // }
        } 
        else 
        {
                   $ret_arr=['code'=>'1','content'=>false,'status'=>false,'message'=>'Please verify the csv file'];
            
        }       
   }

        return $ret_arr;

    }// close func 
}