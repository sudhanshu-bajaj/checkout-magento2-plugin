<?php
/**
 * Checkout.com
 * Authorized and regulated as an electronic money institution
 * by the UK Financial Conduct Authority (FCA) under number 900816.
 *
 * PHP version 7
 *
 * @category  Magento2
 * @package   Checkout.com
 * @author    Platforms Development Team <platforms@checkout.com>
 * @copyright 2010-2019 Checkout.com
 * @license   https://opensource.org/licenses/mit-license.html MIT License
 * @link      https://docs.checkout.com/
 */

namespace CheckoutCom\Magento2\Setup;

use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements \Magento\Framework\Setup\UpgradeSchemaInterface
{
    /**
     * Upgrades DB schema for the module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function upgrade(
        \Magento\Framework\Setup\SchemaSetupInterface $setup,
        \Magento\Framework\Setup\ModuleContextInterface $context
    ) {
        $installer = $setup;
        $installer->startSetup();

        // Define the webhooks table
        if (!$installer->getConnection()->isTableExists('checkoutcom_webhooks')) {
            $table1 = $installer->getConnection()
                ->newTable($installer->getTable('checkoutcom_webhooks'))
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    ['identity' => true, 'nullable' => false, 'primary' => true],
                    'Webhook ID'
                )
                ->addColumn('event_id', Table::TYPE_TEXT, 255, ['nullable' => false])
                ->addColumn('event_type', Table::TYPE_TEXT, 255, ['nullable' => false])
                ->addColumn('event_data', Table::TYPE_TEXT, null, ['nullable' => false])
                ->addColumn('action_id', Table::TYPE_TEXT, 255, ['nullable' => false])
                ->addColumn('payment_id', Table::TYPE_TEXT, 255, ['nullable' => false])
                ->addColumn('order_id', Table::TYPE_INTEGER, null, ['nullable' => false])
                ->addIndex($installer->getIdxName('checkoutcom_webhooks_index', ['id']), ['id'])
                ->setComment('Webhooks table');

            // Create the table
            $installer->getConnection()->createTable($table1);
        }
    
        // Create the files table schema
        $tableName2 = 'checkoutcom_logreader_files';
        if (!$installer->getConnection()->isTableExists($tableName2)) {
            $table2 = $installer->getConnection()
                ->newTable($installer->getTable($tableName2))
                ->addColumn(
                    'file_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['identity' => true, 'nullable' => false, 'primary' => true],
                    'File ID'
                )
                ->addColumn('is_readable', Table::TYPE_BOOLEAN, 1, [], 'Boolean')
                ->addColumn('is_writable', Table::TYPE_BOOLEAN, 1, [], 'Boolean')
                ->addColumn('file_path', Table::TYPE_TEXT, 255, ['nullable' => true, 'default' => null])
                ->addColumn('file_content', Table::TYPE_TEXT, null, ['nullable' => true, 'default' => null])
                ->addColumn('rows_count', Table::TYPE_INTEGER, null, ['nullable' => false, 'default' => 0])
                ->addColumn('file_creation_time', Table::TYPE_DATETIME, null, ['nullable' => false], 'Creation Time')
                ->addColumn('file_update_time', Table::TYPE_DATETIME, null, ['nullable' => false], 'Update Time')
                ->addIndex($installer->getIdxName('translation_file_index', ['file_id']), ['file_id']);

            $installer->getConnection()->createTable($table2);
        }

        // Create the logs table schema
        $tableName3 = 'checkoutcom_logreader_logs';
        if (!$installer->getConnection()->isTableExists($tableName3)) {
            $table3 = $installer->getConnection()
                ->newTable($installer->getTable($tableName3))
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    ['auto_increment' => true, 'identity' => true, 'nullable' => false, 'primary' => true],
                    'Record ID'
                )
                ->addColumn('file_id', Table::TYPE_INTEGER, null, ['nullable' => false], 'File ID')
                ->addColumn('row_id', Table::TYPE_INTEGER, null, ['nullable' => true], 'Row ID')
                ->addColumn('comments', Table::TYPE_TEXT, null, ['nullable' => true, 'default' => null]);

            $installer->getConnection()->createTable($table3);
        }

        // End the setup
        $installer->endSetup();
    }
}
