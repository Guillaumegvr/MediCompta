<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240729102422 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE remplacement DROP FOREIGN KEY FK_E00CEDDE3301C60');
        $this->addSql('DROP INDEX IDX_E00CEDDE3301C60 ON remplacement');
        $this->addSql('ALTER TABLE remplacement DROP booking_id');
        $this->addSql('ALTER TABLE medecin DROP FOREIGN KEY FK_1BDA53C66CEB9B4C');
        $this->addSql('DROP INDEX IDX_1BDA53C66CEB9B4C ON medecin');
        $this->addSql('ALTER TABLE medecin DROP remplacement_id');
        $this->addSql('ALTER TABLE remplacement ADD booking_id INT NOT NULL, ADD user_id INT NOT NULL, ADD medecin_id INT NOT NULL, CHANGE retrocession retrocession INT NOT NULL');
        $this->addSql('ALTER TABLE remplacement ADD CONSTRAINT FK_18EC0D1E3301C60 FOREIGN KEY (booking_id) REFERENCES remplacement (id)');
        $this->addSql('ALTER TABLE remplacement ADD CONSTRAINT FK_18EC0D1EA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE remplacement ADD CONSTRAINT FK_18EC0D1E4F31A84 FOREIGN KEY (medecin_id) REFERENCES medecin (id)');
        $this->addSql('CREATE INDEX IDX_18EC0D1E3301C60 ON remplacement (booking_id)');
        $this->addSql('CREATE INDEX IDX_18EC0D1EA76ED395 ON remplacement (user_id)');
        $this->addSql('CREATE INDEX IDX_18EC0D1E4F31A84 ON remplacement (medecin_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6496CEB9B4C');
        $this->addSql('DROP INDEX IDX_8D93D6496CEB9B4C ON user');
        $this->addSql('ALTER TABLE user DROP remplacement_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE remplacement ADD booking_id INT NOT NULL');
        $this->addSql('ALTER TABLE remplacement ADD CONSTRAINT FK_E00CEDDE3301C60 FOREIGN KEY (booking_id) REFERENCES remplacement (id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE3301C60 ON remplacement (booking_id)');
        $this->addSql('ALTER TABLE medecin ADD remplacement_id INT NOT NULL');
        $this->addSql('ALTER TABLE medecin ADD CONSTRAINT FK_1BDA53C66CEB9B4C FOREIGN KEY (remplacement_id) REFERENCES remplacement (id)');
        $this->addSql('CREATE INDEX IDX_1BDA53C66CEB9B4C ON medecin (remplacement_id)');
        $this->addSql('ALTER TABLE remplacement DROP FOREIGN KEY FK_18EC0D1E3301C60');
        $this->addSql('ALTER TABLE remplacement DROP FOREIGN KEY FK_18EC0D1EA76ED395');
        $this->addSql('ALTER TABLE remplacement DROP FOREIGN KEY FK_18EC0D1E4F31A84');
        $this->addSql('DROP INDEX IDX_18EC0D1E3301C60 ON remplacement');
        $this->addSql('DROP INDEX IDX_18EC0D1EA76ED395 ON remplacement');
        $this->addSql('DROP INDEX IDX_18EC0D1E4F31A84 ON remplacement');
        $this->addSql('ALTER TABLE remplacement DROP booking_id, DROP user_id, DROP medecin_id, CHANGE retrocession retrocession DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE `user` ADD remplacement_id INT NOT NULL');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D6496CEB9B4C FOREIGN KEY (remplacement_id) REFERENCES remplacement (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6496CEB9B4C ON `user` (remplacement_id)');
    }
}
