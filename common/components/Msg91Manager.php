<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\sms\common\components;

// CMG Imports
use cmsgears\sms\common\config\Msg91Properties;

/**
 * The MSG91 Manager component provides methods to trigger message and OTP.
 *
 * @since 1.0.0
 */
class Msg91Manager extends \cmsgears\core\common\components\SmsManager {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Msg91Manager --------------------------

	public function isActive() {

		return Msg91Properties::getInstance()->isActive();
	}

	// OTP --------------

	public function getOtpBalance() {

		$balance = 0;

		$authKey = Msg91Properties::getInstance()->getAuthKey();

		$curl = curl_init();

		curl_setopt_array( $curl, [
			CURLOPT_URL => "https://control.msg91.com/api/balance.php?authkey=$authKey&response=json&type=106",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "",
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => 0,
		]);

		$response = curl_exec( $curl );

		$err = curl_error( $curl );

		curl_close( $curl );

		if( $err ) {

			return 0;
		}
		else {

			$balance = intval( $response );
		}

		return $balance;
	}

	// Expires in 10 minutes
	public function sendOtp( $number, $message, $otp, $templateId, $expiry = 10 ) {

		$authKey	= Msg91Properties::getInstance()->getAuthKey();
		$sender		= Msg91Properties::getInstance()->getSender(); // Must be 6 digits
		$length		= 6;
		$message	= urlencode( $message );

		// Filter Number - Remove +, - and spaces
		$number = preg_replace('/[\+\-\s+]/', '', $number );

		$curl = curl_init();

		curl_setopt_array( $curl, [
			//CURLOPT_URL => "https://api.msg91.com/api/v5/otp?authkey=$authKey&response=json&message=$message&sender=$sender&DLT_TE_ID=$templateId&mobile=$number&otp=$otp&otp_length=$length&otp_expiry=$expiry&country=0",
			CURLOPT_URL => "https://api.msg91.com/api/v5/otp?authkey=$authKey&mobile=$number&template_id=$templateId&otp=$otp&otp_length=$length&otp_expiry=$expiry",
          	CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "",
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => 0,
		]);

		$response = json_decode( curl_exec( $curl ) );

		$err = curl_error( $curl );

		curl_close( $curl );

		if( $err ) {

			// Print error
		}
		else if( $response->type == 'success' ) {

			return true;
		}

		return false;
	}

	public function reSendOtp( $number, $message, $otp ) {

	}

	// SMS --------------

	public function getSmsBalance() {

		$balance = 0;

		$authKey = Msg91Properties::getInstance()->getAuthKey();

		$curl = curl_init();

		curl_setopt_array( $curl, [
			CURLOPT_URL => "https://control.msg91.com/api/balance.php?authkey=$authKey&response=json&type=4",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "",
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => 0,
		]);

		$response = curl_exec( $curl );

		$err = curl_error( $curl );

		curl_close( $curl );

		if( $err ) {

			return 0;
		}
		else {

			$balance = intval( $response );
		}

		return $balance;
	}

	public function sendSms( $number, $message ) {

		$authKey	= Msg91Properties::getInstance()->getAuthKey();
		$sender		= Msg91Properties::getInstance()->getSender(); // Must be 6 digits
		$message	= $message;

		// Filter Number - Remove +, - and spaces
		$number = preg_replace('/[\+\-\s+]/', '', $number );

		// Remove 91
		//$number = substr( $number, 2 );

		$curl = curl_init();

		curl_setopt_array($curl, array(
			//CURLOPT_URL => "https://api.msg91.com/api/v2/sendsms?country=91",
          	CURLOPT_URL => "https://api.msg91.com/api/v2/sendsms?country=0",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			//CURLOPT_POSTFIELDS => "{ \"sender\": \"$sender\", \"route\": \"4\", \"country\": \"91\", \"sms\": [ { \"message\": \"$message\", \"to\": [ \"$number\" ] } ] }",
			CURLOPT_POSTFIELDS => "{ \"sender\": \"$sender\", \"route\": \"4\", \"country\": \"0\", \"sms\": [ { \"message\": \"$message\", \"to\": [ \"$number\" ] } ] }",
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => 0,
			CURLOPT_HTTPHEADER => array(
				"authkey: $authKey",
				"content-type: application/json"
			),
		));

		$response = json_decode( curl_exec( $curl ) );

		$err = curl_error( $curl );

		curl_close( $curl );

		if( $err ) {

			// echo "cURL Error #:" . $err;
		}
		else if( $response->type == 'success' ) {

			return true;
		}

		return false;
	}

}
