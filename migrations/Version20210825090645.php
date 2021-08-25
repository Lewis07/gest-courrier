<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210825090645 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partage_courrier ADD sender_id INT NOT NULL');
        $this->addSql('ALTER TABLE partage_courrier ADD CONSTRAINT FK_32BF4631F624B39D FOREIGN KEY (sender_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_32BF4631F624B39D ON partage_courrier (sender_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partage_courrier DROP FOREIGN KEY FK_32BF4631F624B39D');
        $this->addSql('DROP INDEX IDX_32BF4631F624B39D ON partage_courrier');
        $this->addSql('ALTER TABLE partage_courrier DROP sender_id');
    }
}
