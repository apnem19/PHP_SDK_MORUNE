<?php
namespace Apnem19\Morune;

Class Create {
	private $shop_id;
	private $amount;
	private $order_id;
	private $currency;
	private $hook_url;
	private $custom_fields;
	private $comment;
	private $fail_url;
	private $success_url;
	private $expire;
	private $include_service;
	private $exclude_service;
	private $password;
	
	public function __construct($shop_id, $amount, $order_id, $currency = "RUB", $hook_url = null, $custom_fields = null, $comment = "Оплата счета", $fail_url = null, $success_url = null, $expire = 600, $include_service = [], $exclude_service = [], $password) {
        $this->shop_id = $shop_id;
        $this->amount = $amount;
        $this->order_id = $order_id;
        $this->currency = $currency;
        $this->hook_url = $hook_url;
        $this->custom_fields = $custom_fields;
        $this->comment = $comment;
        $this->fail_url = $fail_url;
		$this->success_url = $success_url;
		$this->expire = $expire;
		$this->include_service = $include_service;
		$this->exclude_service = $exclude_service;
		$this->password = $password;
    }
	
	public function getUrl(){
		$array = array(
			'amount'    => $this->amount,
			'order_id' => "orders_{$this->order_id}",
			'shop_id' => $this->shop_id
		);		
					
		$url = "https://api.morune.com/invoice/create";
			$headers = [
				"accept: application/json",
				"content-type: application/json",
				"x-api-key: {$this->password}"
			];
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($array));
			$result = json_decode(curl_exec($ch), true);
			curl_close($ch);
					
			if($result['status'] != 200){
				return $result['error'];
			}
			
			return $result['data']['url'];
	}

}
?>