<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateAnimalsTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table('animals', [
            'id' => false,
            'primary_key' => ['id']
        ]);

        $table
            ->addColumn('id', 'char', ['limit' => 36, 'null' => false])
            ->addColumn('farm_id', 'char', ['limit' => 36])
            ->addColumn('code', 'string', ['limit' => 100])
            ->addColumn('name', 'string', ['limit' => 255])
            ->addColumn('sex', 'enum', [
                'values' => [
                    'MALE',
                    'FEMALE'
                ]
            ])
            ->addColumn('breed', 'string', [
                'limit' => 100,
                'null' => true
            ])
            ->addColumn('birth_date', 'date', [
                'null' => true
            ])
            ->addColumn('status', 'enum', [
                'values' => [
                    'ACTIVE',
                    'SOLD',
                    'DEAD',
                    'DISCARDED'
                ],
                'default' => 'ACTIVE'
            ])
            ->addTimestamps()
            ->addIndex(['farm_id'])
            ->addIndex(
                ['farm_id', 'code'],
                ['unique' => true]
            )
            ->addForeignKey(
                'farm_id',
                'farms',
                'id',
                ['delete' => 'CASCADE']
            )
            ->create();
    }
}
