<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\models\entities\Site;
use cmsgears\core\common\models\entities\User;
use cmsgears\core\common\models\resources\Form;
use cmsgears\core\common\models\resources\FormField;

use cmsgears\core\common\utilities\DateUtil;

/**
 * The sms migration inserts the base data required to manage sms.
 *
 * @since 1.0.0
 */
class m161101_001281_msg91 extends \cmsgears\core\common\base\Migration {

	// Public Variables

	// Private Variables

	private $prefix;

	private $site;
	private $master;

	public function init() {

		// Table prefix
		$this->prefix	= Yii::$app->migration->cmgPrefix;

		$this->site		= Site::findBySlug( CoreGlobal::SITE_MAIN );
		$this->master	= User::findByUsername( Yii::$app->migration->getSiteMaster() );

		Yii::$app->core->setSite( $this->site );
	}

	public function up() {

		// Create various config
		$this->insertSmsConfig();

		// Init default config
		$this->insertDefaultConfig();
	}

	private function insertSmsConfig() {

		$this->insert( $this->prefix . 'core_form', [
			'siteId' => $this->site->id,
			'createdBy' => $this->master->id, 'modifiedBy' => $this->master->id,
			'name' => 'Config SMS', 'slug' => 'config-sms',
			'type' => CoreGlobal::TYPE_SYSTEM,
			'description' => 'SMS configuration form.',
			'success' => 'All configurations saved successfully.',
			'captcha' => false,
			'visibility' => Form::VISIBILITY_PROTECTED,
			'status' => Form::STATUS_ACTIVE, 'userMail' => false, 'adminMail' => false,
			'createdAt' => DateUtil::getDateTime(),
			'modifiedAt' => DateUtil::getDateTime()
		] );

		$config = Form::findBySlugType( 'config-sms', CoreGlobal::TYPE_SYSTEM );

		$columns = [ 'formId', 'name', 'label', 'type', 'compress', 'meta', 'active', 'validators', 'order', 'icon', 'htmlOptions' ];

		$fields = [
			[ $config->id, 'active', 'Active', FormField::TYPE_TOGGLE, false, true, true, 'required', 0, NULL, '{"title":"Active"}' ],
			[ $config->id, 'auth_key', 'Auth Key', FormField::TYPE_TEXT, false, true, true, 'string', 0, NULL, '{"title":"Auth Key", "placeholder":"Auth Key"}' ],
			[ $config->id, 'sender', 'Sender', FormField::TYPE_TEXT, false, true, true, 'string', 0, NULL, '{"title":"Sender", "placeholder":"Sender"}' ]
		];

		$this->batchInsert( $this->prefix . 'core_form_field', $columns, $fields );
	}

	private function insertDefaultConfig() {

		$columns = [ 'modelId', 'name', 'label', 'type', 'active', 'valueType', 'value', 'data' ];

		$metas = [
			[ $this->site->id, 'active', 'Active', 'sms', 1, 'flag', '1', NULL ],
			[ $this->site->id, 'auth_key', 'Auth Key', 'sms', 1, 'text', NULL, NULL ],
			[ $this->site->id, 'sender', 'Sender', 'sms', 1, 'text', NULL, NULL ]
		];

		$this->batchInsert( $this->prefix . 'core_site_meta', $columns, $metas );
	}

	public function down() {

		echo "m161101_001281_msg91 will be deleted with m160621_014408_core.\n";

		return true;
	}

}
