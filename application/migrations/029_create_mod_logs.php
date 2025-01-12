<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property mixed $dbforge
 */
class Migration_create_mod_logs extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field(array(
            'id'         => array(
                'type'           => 'INT',
                'constraint'     => '10',
                'unsigned'       => true,
                'auto_increment' => true
            ),
            'userid'     => array(
                'type'       => 'INT',
                'constraint' => '10',
                'unsigned'   => true
            ),
            'type'       => array(
                'type'       => 'INT',
                'constraint' => '10',
                'unsigned'   => true
            ),
            'idtopic'    => array(
                'type'       => 'INT',
                'constraint' => '10',
                'unsigned'   => true
            ),
            'function'   => array(
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'unsigned'   => true
            ),
            'annotation' => array(
                'type' => 'TEXT',
            ),
            'datetime'   => array(
                'type'       => 'INT',
                'constraint' => '10',
                'unsigned'   => true
            ),
        ));
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('mod_logs');
    }

    public function down()
    {
        $this->dbforge->drop_table('mod_logs');
    }
}
