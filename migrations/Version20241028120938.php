<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241028120938 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE test_capture DROP FOREIGN KEY FK_57BF722D1E5D0459');
        $this->addSql('DROP TABLE test_capture');
        $this->addSql('ALTER TABLE commandes DROP FOREIGN KEY FK_35D4282C8EAE3863');
        $this->addSql('DROP INDEX IDX_35D4282C8EAE3863 ON commandes');
        $this->addSql('ALTER TABLE commandes DROP intervention_id');
        $this->addSql('ALTER TABLE test ADD photo_name VARCHAR(255) DEFAULT NULL, ADD photo_size INT DEFAULT NULL, CHANGE description description LONGTEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE test_capture (id INT AUTO_INCREMENT NOT NULL, test_id INT DEFAULT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, slug VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, size VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_57BF722D1E5D0459 (test_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE test_capture ADD CONSTRAINT FK_57BF722D1E5D0459 FOREIGN KEY (test_id) REFERENCES test (id)');
        $this->addSql('ALTER TABLE test DROP photo_name, DROP photo_size, CHANGE description description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE commandes ADD intervention_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commandes ADD CONSTRAINT FK_35D4282C8EAE3863 FOREIGN KEY (intervention_id) REFERENCES intervention (id)');
        $this->addSql('CREATE INDEX IDX_35D4282C8EAE3863 ON commandes (intervention_id)');
    }
}
