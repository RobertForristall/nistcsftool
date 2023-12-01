<?php

declare(strict_types=1);

namespace OCA\NistCsfTool\Migration;

use Closure;
use OCP\DB\ISchemaWrapper;
use OCP\DB\Types;
use OCP\Migration\IOutput;
use OCP\Migration\SimpleMigrationStep;

class Version000000Date20181013124731 extends SimpleMigrationStep {

	/**
	 * @param IOutput $output
	 * @param Closure $schemaClosure The `\Closure` returns a `ISchemaWrapper`
	 * @param array $options
	 */
	public function preSchemaChange(IOutput $output, Closure $schemaClosure, array $options) {
	}

	/**
	 * @param IOutput $output
	 * @param Closure $schemaClosure The `\Closure` returns a `ISchemaWrapper`
	 * @param array $options
	 * @return null|ISchemaWrapper
	 */
	public function changeSchema(IOutput $output, Closure $schemaClosure, array $options) {
		/** @var ISchemaWrapper $schema */
		$schema = $schemaClosure();

		if (!$schema->hasTable('Apps')) {
			$table = $schema->createTable('Apps');
			$table->addColumn('id', Types::BIGINT, [
				'autoincrement' => true,
				'notnull' => true,
				'length' => 4,
			]);
			$table->addColumn('user_id', Types::STRING, [
				'notnull' => true,
				'length' => 64,
			]);
			$table->addColumn('name', Types::STRING, [
				'notnull' => true,
				'length' => 300,
			]);
			$table->addColumn('type', Types::STRING, [
				'notnull' => true,
				'length' => 300,
			]);
			$table->setPrimaryKey(['id']);
			$table->addIndex(['user_id'], 'apps_uid');
		}

		// if ($schema->hasTable('ControlCompliance')){
		// 	$schema->dropTable('ControlCompliance')
		// }

		if (!$schema->hasTable('ControlCompliance')) {
			$table = $schema->createTable('ControlCompliance');
			$table->addColumn('id', Types::BIGINT, [
				'autoincrement' => true,
				'notnull' => true,
				'length' => 4
			]);
			$table->addColumn('control_id', Types::STRING, [
				'notnull' => true,
				'length' => 64,
			]);
			$table->addColumn('app_id', Types::BIGINT, [
				'notnull' => true,
				'length' => 4
			]);
			$table->addColumn('compliance_value', Types::INTEGER, [
				'notnull' => true,
				'length' => 4
			]);
			$table->setPrimaryKey(['id']);
			$table->addUniqueIndex(['control_id', 'app_id'], 'control_app_index');
			$table->addForeignKeyConstraint($schema->getTable('Apps'), ['app_id'], ['id'], [], 'fk_control_app');
		}

		return $schema;
	}

	/**
	 * @param IOutput $output
	 * @param Closure $schemaClosure The `\Closure` returns a `ISchemaWrapper`
	 * @param array $options
	 */
	public function postSchemaChange(IOutput $output, Closure $schemaClosure, array $options) {
	}
}