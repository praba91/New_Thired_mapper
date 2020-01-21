<?php
namespace Sales\V1\Rest\CommonFunctions;
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
use Zend\Http\Client;






class CommonFunctionsMapper {

	protected $mapper;
	public $clientId = "122";
	public $authServer = "http://192.168.1.11:";
	public $authPort = "8080/";
	// public $authServer = "http://192.168.1.7:";
	// public $authPort = "8800/";
	public $product = "Sales";
	public $authURL = "OAuth2_Security_Services/";
	public $validateTokenUrl ="thinksynq/validate_user";
	public $createUserCredential ="admin/saveUser/";
	public $changepassCredential ="admin/forgetPassword";
	public $enableuserCredential ="/admin/enableUser";
	public $disableUserCredential ="/admin/disableUser";

	public function __construct(AdapterInterface $adapter){
		$this->adapter=$adapter;
	}

	public function fetchOne($param) {
		return ['success'=>true,'messgage'=>'Function initialization'];
	}

	public function validateToken() {
		
		$client = new Client();
		$authToken = $this->getBearerToken($request);
		$client->setHeaders(array('Authorization'=>$authToken));
		$client->setUri($this->authServer.$this->authPort.$this->authURL.$this->validateTokenUrl);
		// $requestHeaders  = $client->getRequest()->getHeaders();
		$response = $client->send();
	
		if(!$response->getBody()->success){
			$response->setStatusCode(401);
			return json_decode($response->getBody());
		}
		return  json_decode($response->getBody());
		
	}

	public function getBearerToken($request ) {
		$request    = new \Zend\Http\PhpEnvironment\Request();
		$httpAuth   = $request->getServer('HTTP_AUTHORIZATION');
		return $httpAuth;
	}

	public function createUser($username,$password,$role) {

		
		
		$client = new Client();
		$authToken = $this->getBearerToken($request);
		$client->setHeaders(array('Authorization'=>$authToken));
		$client->setUri($this->authServer.$this->authPort.$this->authURL.$this->createUserCredential);
		$client->setMethod('POST');
		$client->setParameterPost(array(
			'Eclientid'  =>  $this->clientId,
			'Ename'  => $username,
			'Epass'   => $password,
			'product'   => $this->product,
			'Erole' =>  ($role == '1' ? 'Admin' : 'User')
		));

		// $requestHeaders  = $client->getRequest()->getHeaders();
		$response = $client->send();
		
	
		if(!$response->getBody()->success){
			$response->setStatusCode(401);
			return json_decode($response->getBody());
		}
		return  json_decode($response->getBody());
	}

	public function changePassword($username,$newpassword) {
		$client = new Client();
		$authToken = $this->getBearerToken($request);
		$client->setHeaders(array('Authorization'=>$authToken));
		$client->setUri($this->authServer.$this->authPort.$this->authURL.$this->changepassCredential);
		$client->setMethod('POST');
		$client->setParameterPost(array(
			'clientid'  =>  $this->clientId,
			'employeename'  => $username,
			'newpass'   => $newpassword
		));

		// $requestHeaders  = $client->getRequest()->getHeaders();
		$response = $client->send();
		// print_r( $response->getBody());
		// exit;
		if(!$response->getBody()->success){
			$response->setStatusCode(401);
			return json_decode($response->getBody());
		}
		return  json_decode($response->getBody());
	}
	
   public function enableUser($username){
   	    $client = new Client();
		$authToken = $this->getBearerToken($request);
		$client->setHeaders(array('Authorization'=>$authToken));
		$client->setUri($this->authServer.$this->authPort.$this->authURL.$this->enableuserCredential);
		$client->setMethod('POST');
		$client->setParameterPost(array(
			'clientid'  =>  $this->clientId,
			'username'  => $username
		));
		$response = $client->send();
		if(!$response->getBody()->success){
			$response->setStatusCode(401);
			return json_decode($response->getBody());
		}
		return  json_decode($response->getBody());
   }
   public function disableUser($username){
   	    $client = new Client();
		$authToken = $this->getBearerToken($request);
		$client->setHeaders(array('Authorization'=>$authToken));
		$client->setUri($this->authServer.$this->authPort.$this->authURL.$this->disableUserCredential);
		$client->setMethod('POST');
		$client->setParameterPost(array(
			'clientid'  =>  $this->clientId,
			'username'  => $username
		));
		$response = $client->send();
		if(!$response->getBody()->success){
			$response->setStatusCode(401);
			return json_decode($response->getBody());
		}
		return  json_decode($response->getBody());
   }
}