<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240729110935 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE remplacement (id INT AUTO_INCREMENT NOT NULL, begin_at DATETIME NOT NULL, end_at DATETIME DEFAULT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medecin (id INT AUTO_INCREMENT NOT NULL, remplacement_id INT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, adresse VARCHAR(255) DEFAULT NULL, code_postal INT DEFAULT NULL, ville VARCHAR(50) DEFAULT NULL, adresse_mail VARCHAR(50) DEFAULT NULL, numero_tel INT DEFAULT NULL, logiciel VARCHAR(50) DEFAULT NULL, secretaire TINYINT(1) DEFAULT NULL, INDEX IDX_1BDA53C66CEB9B4C (remplacement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE remplacement (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE remplacement_booking (remplacement_id INT NOT NULL, booking_id INT NOT NULL, INDEX IDX_ADB449C06CEB9B4C (remplacement_id), INDEX IDX_ADB449C03301C60 (booking_id), PRIMARY KEY(remplacement_id, booking_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, remplacement_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, adresse VARCHAR(255) NOT NULL, codepostal INT NOT NULL, ville VARCHAR(50) NOT NULL, date_creation DATETIME NOT NULL, no_departement INT NOT NULL, INDEX IDX_8D93D6496CEB9B4C (remplacement_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE medecin ADD CONSTRAINT FK_1BDA53C66CEB9B4C FOREIGN KEY (remplacement_id) REFERENCES remplacement (id)');
        $this->addSql('ALTER TABLE remplacement_booking ADD CONSTRAINT FK_ADB449C06CEB9B4C FOREIGN KEY (remplacement_id) REFERENCES remplacement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE remplacement_booking ADD CONSTRAINT FK_ADB449C03301C60 FOREIGN KEY (booking_id) REFERENCES remplacement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D6496CEB9B4C FOREIGN KEY (remplacement_id) REFERENCES remplacement (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE medecin DROP FOREIGN KEY FK_1BDA53C66CEB9B4C');
        $this->addSql('ALTER TABLE remplacement_booking DROP FOREIGN KEY FK_ADB449C06CEB9B4C');
        $this->addSql('ALTER TABLE remplacement_booking DROP FOREIGN KEY FK_ADB449C03301C60');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6496CEB9B4C');
        $this->addSql('DROP TABLE remplacement');
        $this->addSql('DROP TABLE medecin');
        $this->addSql('DROP TABLE remplacement');
        $this->addSql('DROP TABLE remplacement_booking');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
