<?php

use Phinx\Migration\AbstractMigration;

class ProductsList extends AbstractMigration
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
        $catalogRow = [
            [
                'name' => 'Red Widget',
                'code' => 'R01',
                'price' => 32.95,
                'description' => "A vibrant red widget perfect for any toolkit.\nEngineered for durability and high performance.",
           
            ],
            [
                'name' => 'Green Widget',
                'code' => 'G01',
                'price' => 24.95,
                'description' => "A sleek green widget designed for precision and efficiency.\nBuilt with eco-friendly materials and sustainable practices.",
            ],
            [
                'name' => 'Blue Widget',
                'code' => 'B01',
                'price' => 7.95,
                'description' => "A calming blue widget perfect for relaxation and meditation.\nDesigned to reduce stress and promote inner peace.",
            ]
        ];
        $this->table('catalog')->insert($catalogRow)->save();
    }
}
