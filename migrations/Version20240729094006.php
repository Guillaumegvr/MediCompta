<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240729094006 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE medecin ADD CONSTRAINT FK_1BDA53C66CEB9B4C FOREIGN KEY (remplacement_id) REFERENCES remplacement (id)');
        $this->addSql('CREATE INDEX IDX_1BDA53C66CEB9B4C ON medecin (remplacement_id)');
        $this->addSql('ALTER TABLE user ADD remplacement_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6496CEB9B4C FOREIGN KEY (remplacement_id) REFERENCES remplacement (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6496CEB9B4C ON user (remplacement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE medecin DROP FOREIGN KEY FK_1BDA53C66CEB9B4C');
        $this->addSql('DROP INDEX IDX_1BDA53C66CEB9B4C ON medecin');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6496CEB9B4C');
        $this->addSql('DROP INDEX IDX_8D93D6496CEB9B4C ON `user`');
        $this->addSql('ALTER TABLE `user` DROP remplacement_id');
    }
}
