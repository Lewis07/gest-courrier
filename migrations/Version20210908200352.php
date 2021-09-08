<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210908200352 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE courrier ADD type_courrier_id INT NOT NULL, DROP type_courrier');
        $this->addSql('ALTER TABLE courrier ADD CONSTRAINT FK_BEF47CAAC0EDCA56 FOREIGN KEY (type_courrier_id) REFERENCES type_courrier (id)');
        $this->addSql('CREATE INDEX IDX_BEF47CAAC0EDCA56 ON courrier (type_courrier_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE courrier DROP FOREIGN KEY FK_BEF47CAAC0EDCA56');
        $this->addSql('DROP INDEX IDX_BEF47CAAC0EDCA56 ON courrier');
        $this->addSql('ALTER TABLE courrier ADD type_courrier VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP type_courrier_id');
    }
}
