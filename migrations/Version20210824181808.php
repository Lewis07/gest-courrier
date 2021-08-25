<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210824181808 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Courrier ADD is_archived TINYINT(1) DEFAULT NULL, ADD is_in_trashed TINYINT(1) DEFAULT NULL, ADD is_send TINYINT(1) DEFAULT NULL, CHANGE est_valid_e is_valid TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Courrier DROP is_archived, DROP is_in_trashed, DROP is_send, CHANGE is_valid est_valid_e TINYINT(1) NOT NULL');
    }
}
