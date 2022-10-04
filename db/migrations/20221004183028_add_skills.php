<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddSkills extends AbstractMigration
{
    public function up() {
        $this->execute("
            alter table `sheet`
                add column `acrobatics` varchar(3) after `speed`,
                add column `animal_handling` varchar(3) after `acrobatics`,
                add column `arcana` varchar(3) after `animal_handling`,
                add column `athletics` varchar(3) after `arcana`,
                add column `deception` varchar(3) after `athletics`,
                add column `history` varchar(3) after `deception`,
                add column `insight` varchar(3) after `history`,
                add column `intimidation` varchar(3) after `insight`,
                add column `investigation` varchar(3) after `intimidation`,
                add column `medicine` varchar(3) after `investigation`,
                add column `nature` varchar(3) after `medicine`,
                add column `perception` varchar(3) after `nature`,
                add column `performance` varchar(3) after `perception`,
                add column `persuasion` varchar(3) after `performance`,
                add column `religion` varchar(3) after `persuasion`,
                add column `sleight_of_hand` varchar(3) after `religion`,
                add column `stealth` varchar(3) after `sleight_of_hand`,
                add column `survival` varchar(3) after `stealth`;
        ");
    }

    public function down() {
        $this->execute("
            alter table `sheet`
                drop column `acrobatics`,
                drop column `animal_handling`,
                drop column `arcana`,
                drop column `athletics`,
                drop column `deception`,
                drop column `history`,
                drop column `insight`,
                drop column `intimidation`,
                drop column `investigation`,
                drop column `medicine`,
                drop column `nature`,
                drop column `perception`,
                drop column `performance`,
                drop column `persuasion`,
                drop column `religion`,
                drop column `sleight_of_hand`,
                drop column `stealth`,
                drop column `survival`;
        ");
    }
    
}
