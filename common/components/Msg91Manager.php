<?php
/**
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 * @license https://www.cmsgears.org/license/
 * @package module
 * @subpackage core
 */
namespace cmsgears\sms\common\components;

// CMG Imports
use cmsgears\sms\common\config\SmsProperties;

use cmsgears\core\common\base\Component;

/**
 * The MSG91 Manager component provides methods to trigger message and OTP.
 *
 * @since 1.0.0
 */
class Msg91Manager extends Component {

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

	public function sendOtp( $number, $message, $otp ) {

		$authKey	= SmsProperties::getInstance()->getMsg91Auth();
		$length		= 6;
		$expiry		= 10; // Expires in 10 minutes
		$message	= urlencode( $message );

		$curl = curl_init();

		curl_setopt_array( $curl, [
			CURLOPT_URL => "http://control.msg91.com/api/sendotp.php?authkey=$authKey&message=$message&sender=VCMSGC&mobile=$number&otp=$otp&otp_length=$length&otp_expiry=$expiry",
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

		$response	= curl_exec( $curl );
		$err		= curl_error( $curl );

		curl_close( $curl );

		if( $err ) {

			echo "cURL Error #:" . $err;
		}
		else {

			echo $response;
		}
	}

	public function reSendOtp( $number, $message, $otp ) {

	}

}
