<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProducts extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'qty' => [
                'type' => 'INT',
                'constraint' => 5,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('products');

        $data = [
            ['name' => 'Mouse', 'qty' => 100],
            ['name' => 'Keyboard', 'qty' => 100],
            ['name' => 'Monitor', 'qty' => 100],
            ['name' => 'CPU', 'qty' => 100],
            ['name' => 'Harddisk', 'qty' => 100],
        ];
        $this->db->table('products')->insertBatch($data);
    }

    public function down()
    {
        $this->forge->dropTable('products');
    }
}
