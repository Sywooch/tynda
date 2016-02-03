<?php
/**
 * Created by denoll.
 * User: Администратор
 * Date: 30.01.2016
 * Time: 22:28
 */

namespace app\modules\profile\yandex;

use app\modules\profile\yandex\Utils;
use app\modules\profile\yandex\Log;
use app\modules\profile\yandex\Settings as Settings;
use DateTime;
/**
 * The implementation of payment notification methods.
 */
class YaMoneyCommonHttpProtocol {

	private $settings;
	private $log;

	public function __construct(Settings $settings) {

		$this->log = new Log($settings);
	}

	/**
	 * CheckOrder request processing. We suppose there are no item with price less
	 * than 30 rubles in the shop.
	 * @param  array $request payment parameters
	 * @return string prepared XML response
	 */
	public function checkOrder($request) {
		$response = null;
		if ($this->checkMD5($request)){
			$code = 1;
		}
		else {
			$code = 0;
		}
		$response .= '<?xml version="1.0" encoding="UTF-8"?>';
		$response .= '<checkOrderResponse performedDatetime="'. $request['requestDatetime'] .'" code="'.$code.'"'. ' invoiceId="'. $request['invoiceId'] .'" shopId="'. $this->settings->SHOP_ID .'"/>';
		return $this->sendResponse($response);
	}

	/**
	 * PaymentAviso request processing.
	 * @param  array $request payment parameters
	 * @return string prepared response in XML format
	 */
	public function paymentAviso($request) {
		$response = null;
		if ($this->checkMD5($request)){
			$code = 1;
		}
		else {
			$code = 0;
		}
		$response .= '<?xml version="1.0" encoding="UTF-8"?>';
		$response .= '<paymentAvisoResponse performedDatetime="'. $request['requestDatetime'] .'" code="'.$code.'"'. ' invoiceId="'. $request['invoiceId'] .'" shopId="'. $this->settings->SHOP_ID .'"/>';
		return $this->sendResponse($response);
	}

	/**
	 * Checking the MD5 sign.
	 * @param  array $request payment parameters
	 * @return bool true if MD5 hash is correct
	 */
	private function checkMD5($request) {
		$str = $request['action'] . ";" .
			$request['orderSumAmount'] . ";" . $request['orderSumCurrencyPaycash'] . ";" .
			$request['orderSumBankPaycash'] . ";" . $request['shopId'] . ";" .
			$request['invoiceId'] . ";" . $request['customerNumber'] . ";" . $this->settings->SHOP_PASSWORD;
		$this->log("String to md5: " . $str);
		$md5 = strtoupper(md5($str));

		if ($md5 != strtoupper($request['md5'])) {
			$this->log("Wait for md5:" . $md5 . ", recieved md5: " . $request['md5']);
			return false;
		}
		return true;
	}

	private function log($str) {
		$this->log->info($str);
	}

	private function sendResponse($responseBody) {
		$this->log("Response: " . $responseBody);
		header("HTTP/1.0 200");
		header("Content-Type: application/xml");
		return $responseBody;
	}
}