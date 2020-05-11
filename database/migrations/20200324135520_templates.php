<?php

use Phinx\Migration\AbstractMigration;

class Templates extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $templates = $this->table('templates', ['id' => false, 'primary_key' => 'id']);
        $templates->addColumn('id', 'uuid')
            ->addColumn('user_id', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('name', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('captcha_key', 'string', ['limit' => 64, 'null' => true])

            ->addColumn('email_to', 'string', ['limit' => 256, 'null' => false])
            ->addColumn('email_replyTo', 'string', ['limit' => 256, 'null' => true])
            ->addColumn('email_cc', 'string', ['limit' => 256, 'null' => true])
            ->addColumn('email_bcc', 'string', ['limit' => 256, 'null' => true])
            ->addColumn('email_fromName', 'string', ['limit' => 256, 'null' => true])
            ->addColumn('email_subject', 'string', ['limit' => 256, 'null' => false])
            ->addColumn('email_content', 'text', ['null' => true])

            ->addColumn('updated_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->create();
    }
}
