<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210909100520 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE courrier ADD CONSTRAINT FK_BEF47CAAC0EDCA56 FOREIGN KEY (type_courrier_id) REFERENCES type_courrier (id)');
        $this->addSql('CREATE INDEX IDX_BEF47CAAC0EDCA56 ON courrier (type_courrier_id)');
        $this->addSql('ALTER TABLE dossier ADD courrier_id INT NOT NULL, ADD typ_dos_id INT NOT NULL, DROP nom_dossier, DROP description');
        $this->addSql('ALTER TABLE dossier ADD CONSTRAINT FK_3D48E0378BF41DC7 FOREIGN KEY (courrier_id) REFERENCES courrier (id)');
        $this->addSql('ALTER TABLE dossier ADD CONSTRAINT FK_3D48E03751688E54 FOREIGN KEY (typ_dos_id) REFERENCES type_dossier (id)');
        $this->addSql('CREATE INDEX IDX_3D48E0378BF41DC7 ON dossier (courrier_id)');
        $this->addSql('CREATE INDEX IDX_3D48E03751688E54 ON dossier (typ_dos_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE courrier DROP FOREIGN KEY FK_BEF47CAAC0EDCA56');
        $this->addSql('DROP INDEX IDX_BEF47CAAC0EDCA56 ON courrier');
        $this->addSql('ALTER TABLE dossier DROP FOREIGN KEY FK_3D48E0378BF41DC7');
        $this->addSql('ALTER TABLE dossier DROP FOREIGN KEY FK_3D48E03751688E54');
        $this->addSql('DROP INDEX IDX_3D48E0378BF41DC7 ON dossier');
        $this->addSql('DROP INDEX IDX_3D48E03751688E54 ON dossier');
        $this->addSql('ALTER TABLE dossier ADD nom_dossier VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP courrier_id, DROP typ_dos_id');
    }
}
