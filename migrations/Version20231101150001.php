<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231101150001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE base (id INT AUTO_INCREMENT NOT NULL, site_title VARCHAR(255) DEFAULT NULL, header_content LONGTEXT DEFAULT NULL, homepage_word VARCHAR(255) DEFAULT NULL, homepage_image_path VARCHAR(255) DEFAULT NULL, text_footer VARCHAR(255) DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, is_random_image TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_photo (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, photo_cover_path VARCHAR(255) DEFAULT NULL, position INT NOT NULL, deleted_at DATETIME DEFAULT NULL, is_random_image TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mailer (id INT AUTO_INCREMENT NOT NULL, no_reply_email VARCHAR(255) NOT NULL, admin_email VARCHAR(255) NOT NULL, rgpd_text VARCHAR(255) NOT NULL, email_subject VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, category_photo_id INT NOT NULL, title VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, exifs JSON DEFAULT NULL, position INT NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_14B78418C9E4C8F7 (category_photo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B78418C9E4C8F7 FOREIGN KEY (category_photo_id) REFERENCES category_photo (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B78418C9E4C8F7');
        $this->addSql('DROP TABLE base');
        $this->addSql('DROP TABLE category_photo');
        $this->addSql('DROP TABLE mailer');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE `user`');
    }
}
