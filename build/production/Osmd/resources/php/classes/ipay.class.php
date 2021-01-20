<?php

class iPay
{
	private $_MCH_ID;
	
	private $_MKEY;
	
	private $_SKEY;
	
	private $_LANG;
	
	private $_LT;
	
	private $_URL_G;
	
	private $_URL_B;
	
	private $_TRNS;
	
	private $_VER;
	
	private $_REQARR;
	
	private $_SRVURL;
	
	function __construct( $MCH_ID, $MKEY, $SKEY ) {

		$this->_MCH_ID = $MCH_ID;
		$this->_MKEY   = $MKEY;
		$this->_SKEY   = $SKEY;
		$this->_LANG   = 'ru';
		$this->_LT     = 24;
		$this->_VER    = '3.00';
		$this->_SRVURL = 'https://api.sandbox.ipay.ua/';

	}
	
	function create_sign() {
		
		$response[0] = sha1( microtime( TRUE ) );
		$response[1] = hash_hmac( 'sha512' , $response[0] , $this->_MKEY );
		
		return $response;
		
	}
	
	function check_sign( $SALT, $SIGN ) {

		return ( hash_hmac( 'sha512' , $SALT , $this->_SKEY ) == $SIGN );

	}
	
	function set_lang( $LANG ) {
		
		$this->_LANG = $LANG;
		
	}
	
	function set_lifetime( $HOURS ) {
		
		$this->_LT = $HOURS;
		
	}
	
	function set_version( $VER ) {
		
		$this->_VER = $VER;
		
	}
	
	function set_urls( $GOOD, $BAD ) {
		
		$this->_URL_G = $GOOD;
		$this->_URL_B = $BAD;

	}
	
	function set_transaction($MCH_ID, $AMOUNT, $DESC, $INFO='[]', $NOTE=NULL, $TYPE='11', $SRV_ID=0, $FEE=NULL, $CUR='UAH' ) {
		
		$MCH_ID = ($MCH_ID == NULL)?$this->_MCH_ID:$MCH_ID;

		$TRN['mch_id']   = $MCH_ID;
		$TRN['srv_id']   = $SRV_ID;
		$TRN['type']     = $TYPE;
		$TRN['amount']   = $AMOUNT;
		
		if($FEE != NULL) $TRN['fee'] = $FEE;		
		
		$TRN['currency'] = $CUR;
		$TRN['desc']     = $DESC;
		
		if($NOTE != NULL) $TRN['note'] = $NOTE;
		
		$TRN['info']     = $INFO;

		$this->_TRNS[] = $TRN;
	}
	
	function set_mode( $MODE ) {
		
		switch( $MODE ) {

			case 'test': $this->_SRVURL = 'https://api.sandbox.ipay.ua/'; break;
			case 'real': $this->_SRVURL = 'https://api.ipay.ua/'; break;

		}
		
	}
	
	private function _build_create_array() {
		
		$req['auth']['mch_id'] = $this->_MCH_ID;
		list($req['auth']['salt'], $req['auth']['sign']) = $this->create_sign();
		
		$req['urls']['good'] = $this->_URL_G;
		$req['urls']['bad']  = $this->_URL_B;
		
		$req['transactions'] = $this->_TRNS;
		
		$req['lifetime'] = $this->_LT;
		$req['version']  = $this->_VER;
		$req['lang']     = $this->_LANG;
		
		$this->_REQARR = $req;
	}
	
	private function _xml_check_sign( $XML ) {
		
		preg_match('|\<salt\>(.*?)\<\/salt\>|ism', $XML, $res);
		
		$salt = $res[1];
		
		preg_match('|\<sign\>(.*?)\<\/sign\>|ism', $XML, $res);
		
		$sign = $res[1];
		
		if( ! $this->check_sign($salt,$sign) ) {

			die('ERROR: System SIGN is incorrect!');

		}
		
		return TRUE;
		
	}
	
	function create_payment() {
		
		$this->_build_create_array();
		
		$xmldata = iPay::toXml( $this->_REQARR );
		
		
		$this->outdata = $xmldata; // ========================================================
		
		
		$api_responce_raw = $this->_curl_request( $xmldata );
		
		$this->_xml_check_sign( $api_responce_raw );

		return $api_responce_raw;
		


	}
	
	function _build_finish_array( $PMT_ID, $MODE ) {
		
		$req['auth']['mch_id'] = $this->_MCH_ID;
		list($req['auth']['salt'], $req['auth']['sign']) = $this->create_sign();
		
		$req['pid'] = $PMT_ID;
		$req['action'] = $MODE;
		$req['version']  = $this->_VER;
		
		$this->_REQARR = $req;
		
	}

	function reverse_payment( $PMT_ID ) {

		$this->complete_payment( $PMT_ID , 'reversal' );

	}
	
	function complete_payment( $PMT_ID , $MODE='complete' ) {
		
		$this->_build_finish_array( $PMT_ID, $MODE );
		
		$xmldata = iPay::toXml( $this->_REQARR );
		
		$api_responce_raw = $this->_curl_request( $xmldata );

		$this->_xml_check_sign( $api_responce_raw );

		return $api_responce_raw;

	}

	
	private function _curl_request( $DATA ) {
		
		$channel = curl_init();
		curl_setopt($channel, CURLOPT_POST, TRUE);
		curl_setopt($channel, CURLOPT_POSTFIELDS, 'data='.$DATA );
		curl_setopt($channel, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($channel, CURLOPT_SSL_VERIFYPEER, FALSE);					
		curl_setopt($channel, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($channel, CURLOPT_MAXREDIRS,      1);
		curl_setopt($channel, CURLOPT_URL, $this->_SRVURL );

		$result = curl_exec( $channel );

		curl_close( $channel );
		
		return $result;		
	}
	
	
	
	public static function toXml($data, $rootNodeName = 'payment', $xml=null)
	{
		if (ini_get('zend.ze1_compatibility_mode') == 1)
		{
			ini_set ('zend.ze1_compatibility_mode', 0);
		}
 
		if ($xml == null)
		{
			$xml = simplexml_load_string("<?xml version='1.0' encoding='utf-8'?><$rootNodeName />");
		}
 
		foreach($data as $key => $value)
		{
			if (is_numeric($key))
			{
				$key = "transaction";
			}
 
			if (is_array($value))
			{
				$node = $xml->addChild($key);
				iPay::toXml($value, $rootNodeName, $node);
			}
			else 
			{
                $value = trim($value);
				$xml->addChild($key,$value);
			}
 
		}
		return $xml->asXML();
	}
}