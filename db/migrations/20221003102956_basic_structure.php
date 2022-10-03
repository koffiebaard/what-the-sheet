<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class BasicStructure extends AbstractMigration
{
    public function up() {
        $this->execute("
        create table `sheet` (
            `id` varchar(32) not null,
            `race` varchar(50) null,
            `name` varchar(50) null,
            `class` varchar(50) null,
            `level` integer null,

            `int` integer null,
            `int_mod` varchar(3) null,
            `int_saving_throw` varchar(3) null,
            `wis` integer null,
            `wis_mod` varchar(3) null,
            `wis_saving_throw` varchar(3) null,
            `char` integer null,
            `char_mod` varchar(3) null,
            `char_saving_throw` varchar(3) null,
            `str` integer null,
            `str_mod` varchar(3) null,
            `str_saving_throw` varchar(3) null,
            `dex` integer null,
            `dex_mod` varchar(3) null,
            `dex_saving_throw` varchar(3) null,
            `con` integer null,
            `con_mod` varchar(3) null,
            `con_saving_throw` varchar(3) null,

            `hp_max` integer null,
            `hp_cur` integer null,
            `hp_tmp` integer null,
            `hit_die` varchar(5) null,

            `armor_class` integer null,
            `initiative` varchar(3) null,
            `speed` integer null, 

            `share_token` varchar(40) not null,
            `created_at` datetime null default CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        );
        ");
    }

    public function down() {
        // $this->execute("drop table `sheet`");
    }
}
