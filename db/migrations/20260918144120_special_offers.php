<?php

use Phinx\Migration\AbstractMigration;

class SpecialOffers extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html
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
        $table = $this->table('special_offers', ['id' => true]);
        $table->addColumn('catalog_id', 'integer')
            ->addColumn('onEveryNItems', 'integer')
            ->addColumn('discountRate', 'float')
            ->create();

        $table->addForeignKey('catalog_id', 'catalog', 'id', [
            'delete'=> 'CASCADE',
            'update'=> 'NO_ACTION',
            'constraint' => 'fk_special_offers_catalog_id'
        ])->update();

        $specialOffersRow = [
            [
                'catalog_id' => 1,
                'onEveryNItems' => 2,
                'discountRate' => 0.5
            ]
        ];
        $this->table('special_offers')->insert($specialOffersRow)->save();
    }
}
