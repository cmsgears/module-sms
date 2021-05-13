<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

/**
 * The sms migration inserts the base data required to manage sms.
 *
 * @since 1.0.0
 */
class m161101_001005_sms extends \cmsgears\core\common\base\Migration {

	// Public Variables

	public $fk;
	public $options;

	// Private Variables

	private $prefix;

	public function init() {

		// Table prefix
		$this->prefix = Yii::$app->migration->cmgPrefix;

		// Get the values via config
		$this->fk		= Yii::$app->migration->isFk();
		$this->options	= Yii::$app->migration->getTableOptions();

		// Default collation
		if( $this->db->driverName === 'mysql' ) {

			$this->options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}
	}

	public function up() {

		$this->upTemplate();

		if( $this->fk ) {

			$this->generateForeignKeys();
		}
	}

	private function upTemplate() {

		$this->createTable( $this->prefix . 'sms_template', [
			'id' => $this->bigPrimaryKey( 20 ),
			'createdBy' => $this->bigInteger( 20 )->notNull(),
			'modifiedBy' => $this->bigInteger( 20 ),
			'name' => $this->string( Yii::$app->core->xLargeText )->notNull(),
			'slug' => $this->string( Yii::$app->core->xxLargeText )->notNull(),
			'type1' => $this->string( Yii::$app->core->mediumText )->defaultValue( null ),
			'type2' => $this->string( Yii::$app->core->mediumText )->defaultValue( null ),
			'templateId' => $this->string( Yii::$app->core->mediumText )->defaultValue( null ),
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime(),
			'content' => $this->mediumText()
		], $this->options );

		// Index for columns creator and modifier
		$this->createIndex( 'idx_' . $this->prefix . 'sms_template_creator', $this->prefix . 'sms_template', 'createdBy' );
		$this->createIndex( 'idx_' . $this->prefix . 'sms_template_modifier', $this->prefix . 'sms_template', 'modifiedBy' );
	}

	private function generateForeignKeys() {

		// Template
		$this->addForeignKey( 'fk_' . $this->prefix . 'sms_template_creator', $this->prefix . 'sms_template', 'createdBy', $this->prefix . 'core_user', 'id', 'RESTRICT' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'sms_template_modifier', $this->prefix . 'sms_template', 'modifiedBy', $this->prefix . 'core_user', 'id', 'SET NULL' );
	}

	public function down() {

		if( $this->fk ) {

			$this->dropForeignKeys();
		}

		$this->dropTable( $this->prefix . 'sms_template' );
	}

	private function dropForeignKeys() {

		// Template
		$this->dropForeignKey( 'fk_' . $this->prefix . 'sms_template_creator', $this->prefix . 'sms_template' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'sms_template_modifier', $this->prefix . 'sms_template' );
	}

}
