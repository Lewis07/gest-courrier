<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210830163848 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE courrier (id INT AUTO_INCREMENT NOT NULL, sender_id INT NOT NULL, recipient_id INT DEFAULT NULL, date_envoie DATETIME NOT NULL, objet_courrier VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, type_courrier VARCHAR(50) NOT NULL, is_valid TINYINT(1) NOT NULL, is_read TINYINT(1) NOT NULL, is_archived TINYINT(1) DEFAULT NULL, is_in_trashed TINYINT(1) DEFAULT NULL, is_send TINYINT(1) DEFAULT NULL, fichier VARCHAR(255) DEFAULT NULL, reference VARCHAR(10) DEFAULT NULL, INDEX IDX_BEF47CAAF624B39D (sender_id), INDEX IDX_BEF47CAAE92F8F78 (recipient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE courrier_archive (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, courrier_id INT NOT NULL, INDEX IDX_90051080A76ED395 (user_id), INDEX IDX_900510808BF41DC7 (courrier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE departement (id INT AUTO_INCREMENT NOT NULL, direction_id INT NOT NULL, nom_departement VARCHAR(60) NOT NULL, INDEX IDX_C1765B63AF73D997 (direction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE direction (id INT AUTO_INCREMENT NOT NULL, nom_direction VARCHAR(70) NOT NULL, descr_dir VARCHAR(80) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dossier (id INT AUTO_INCREMENT NOT NULL, nom_dossier VARCHAR(50) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fonction (id INT AUTO_INCREMENT NOT NULL, nom_fonction VARCHAR(60) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partage_courrier (id INT AUTO_INCREMENT NOT NULL, sender_id INT NOT NULL, INDEX IDX_32BF4631F624B39D (sender_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partage_courrier_user (partage_courrier_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_D1FADDD9BE150C3B (partage_courrier_id), INDEX IDX_D1FADDD9A76ED395 (user_id), PRIMARY KEY(partage_courrier_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, titre_role VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_dossier (id INT AUTO_INCREMENT NOT NULL, libelle_type_dossier VARCHAR(90) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, fonction_id INT NOT NULL, departement_id INT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, telephone VARCHAR(15) NOT NULL, email VARCHAR(100) NOT NULL, adresse VARCHAR(50) NOT NULL, username VARCHAR(100) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, picture VARCHAR(255) DEFAULT NULL, INDEX IDX_8D93D64957889920 (fonction_id), INDEX IDX_8D93D649CCF9E01E (departement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE courrier ADD CONSTRAINT FK_BEF47CAAF624B39D FOREIGN KEY (sender_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE courrier ADD CONSTRAINT FK_BEF47CAAE92F8F78 FOREIGN KEY (recipient_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE courrier_archive ADD CONSTRAINT FK_90051080A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE courrier_archive ADD CONSTRAINT FK_900510808BF41DC7 FOREIGN KEY (courrier_id) REFERENCES courrier (id)');
        $this->addSql('ALTER TABLE departement ADD CONSTRAINT FK_C1765B63AF73D997 FOREIGN KEY (direction_id) REFERENCES direction (id)');
        $this->addSql('ALTER TABLE partage_courrier ADD CONSTRAINT FK_32BF4631F624B39D FOREIGN KEY (sender_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE partage_courrier_user ADD CONSTRAINT FK_D1FADDD9BE150C3B FOREIGN KEY (partage_courrier_id) REFERENCES partage_courrier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE partage_courrier_user ADD CONSTRAINT FK_D1FADDD9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64957889920 FOREIGN KEY (fonction_id) REFERENCES fonction (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649CCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE courrier_archive DROP FOREIGN KEY FK_900510808BF41DC7');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649CCF9E01E');
        $this->addSql('ALTER TABLE departement DROP FOREIGN KEY FK_C1765B63AF73D997');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64957889920');
        $this->addSql('ALTER TABLE partage_courrier_user DROP FOREIGN KEY FK_D1FADDD9BE150C3B');
        $this->addSql('ALTER TABLE courrier DROP FOREIGN KEY FK_BEF47CAAF624B39D');
        $this->addSql('ALTER TABLE courrier DROP FOREIGN KEY FK_BEF47CAAE92F8F78');
        $this->addSql('ALTER TABLE courrier_archive DROP FOREIGN KEY FK_90051080A76ED395');
        $this->addSql('ALTER TABLE partage_courrier DROP FOREIGN KEY FK_32BF4631F624B39D');
        $this->addSql('ALTER TABLE partage_courrier_user DROP FOREIGN KEY FK_D1FADDD9A76ED395');
        $this->addSql('DROP TABLE courrier');
        $this->addSql('DROP TABLE courrier_archive');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE direction');
        $this->addSql('DROP TABLE dossier');
        $this->addSql('DROP TABLE fonction');
        $this->addSql('DROP TABLE partage_courrier');
        $this->addSql('DROP TABLE partage_courrier_user');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE type_dossier');
        $this->addSql('DROP TABLE user');
    }
}
