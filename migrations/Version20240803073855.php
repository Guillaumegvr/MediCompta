<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240803073855 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE remplacement CHANGE user_id user_id INT DEFAULT NULL, CHANGE medecin_id medecin_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP remplacements');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE remplacement CHANGE user_id user_id INT NOT NULL, CHANGE medecin_id medecin_id INT NOT NULL');
        $this->addSql('ALTER TABLE `user` ADD remplacements VARCHAR(3) NOT NULL');
    }
}
