<?php

use Phinx\Migration\AbstractMigration;

class CreateTableUsers extends AbstractMigration
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
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('users');
        $table->addColumn('login', 'string', array('limit' => 64))
            ->addColumn('password', 'string', array('limit' => 32))
            ->addColumn('email', 'string', array('limit' => 100))
            ->addColumn('balance', 'integer', array('default' => 0))
            ->addColumn('refer_id', 'integer', array('null' => true))
            ->addColumn('created', 'timestamp', array('default' => 'CURRENT_TIMESTAMP'))
            ->addIndex(array('login', 'email'), array('unique' => true))
            ->addForeignKey('refer_id', 'users', 'id', array('delete'=> 'SET_NULL', 'update'=> 'NO_ACTION'))
            ->create();
    }
}
