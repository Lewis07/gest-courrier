<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210825083446 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE partage_courrier (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partage_courrier_user (partage_courrier_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_D1FADDD9BE150C3B (partage_courrier_id), INDEX IDX_D1FADDD9A76ED395 (user_id), PRIMARY KEY(partage_courrier_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE partage_courrier_user ADD CONSTRAINT FK_D1FADDD9BE150C3B FOREIGN KEY (partage_courrier_id) REFERENCES partage_courrier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE partage_courrier_user ADD CONSTRAINT FK_D1FADDD9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partage_courrier_user DROP FOREIGN KEY FK_D1FADDD9BE150C3B');
        $this->addSql('DROP TABLE partage_courrier');
        $this->addSql('DROP TABLE partage_courrier_user');
    }
}
