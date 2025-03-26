<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241120174402 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_pack (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, pack_id INT NOT NULL, used_quantity INT DEFAULT NULL, INDEX IDX_ED5F12EAA76ED395 (user_id), INDEX IDX_ED5F12EA1919B217 (pack_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_pack ADD CONSTRAINT FK_ED5F12EAA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE user_pack ADD CONSTRAINT FK_ED5F12EA1919B217 FOREIGN KEY (pack_id) REFERENCES pack (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_pack DROP FOREIGN KEY FK_ED5F12EAA76ED395');
        $this->addSql('ALTER TABLE user_pack DROP FOREIGN KEY FK_ED5F12EA1919B217');
        $this->addSql('DROP TABLE user_pack');
    }
}
