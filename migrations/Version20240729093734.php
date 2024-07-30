<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240729093734 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE remplacement (id INT AUTO_INCREMENT NOT NULL, retrocession DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE remplacement ADD booking_id INT NOT NULL');
        $this->addSql('ALTER TABLE remplacement ADD CONSTRAINT FK_E00CEDDE3301C60 FOREIGN KEY (booking_id) REFERENCES remplacement (id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE3301C60 ON remplacement (booking_id)');
        $this->addSql('ALTER TABLE medecin ADD remplacement_id INT NOT NULL');
        $this->addSql('ALTER TABLE medecin ADD CONSTRAINT FK_1BDA53C66CEB9B4C FOREIGN KEY (remplacement_id) REFERENCES remplacement (id)');
        $this->addSql('CREATE INDEX IDX_1BDA53C66CEB9B4C ON medecin (remplacement_id)');
        $this->addSql('ALTER TABLE user ADD remplacement_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6496CEB9B4C FOREIGN KEY (remplacement_id) REFERENCES remplacement (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6496CEB9B4C ON user (remplacement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE remplacement DROP FOREIGN KEY FK_E00CEDDE3301C60');
        $this->addSql('ALTER TABLE medecin DROP FOREIGN KEY FK_1BDA53C66CEB9B4C');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6496CEB9B4C');
        $this->addSql('DROP TABLE remplacement');
        $this->addSql('DROP INDEX IDX_E00CEDDE3301C60 ON remplacement');
        $this->addSql('ALTER TABLE remplacement DROP booking_id');
        $this->addSql('DROP INDEX IDX_1BDA53C66CEB9B4C ON medecin');
        $this->addSql('ALTER TABLE medecin DROP remplacement_id');
        $this->addSql('DROP INDEX IDX_8D93D6496CEB9B4C ON `user`');
        $this->addSql('ALTER TABLE `user` DROP remplacement_id');
    }
}
