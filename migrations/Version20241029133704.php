<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241029133704 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commandes ADD intervention_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commandes ADD CONSTRAINT FK_35D4282C8EAE3863 FOREIGN KEY (intervention_id) REFERENCES intervention (id)');
        $this->addSql('CREATE INDEX IDX_35D4282C8EAE3863 ON commandes (intervention_id)');
        $this->addSql('ALTER TABLE test DROP FOREIGN KEY FK_D87F7E0C8EAE3863');
        $this->addSql('ALTER TABLE test CHANGE intervention_id intervention_id INT NOT NULL');
        $this->addSql('ALTER TABLE test ADD CONSTRAINT FK_D87F7E0C8EAE3863 FOREIGN KEY (intervention_id) REFERENCES intervention (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE test DROP FOREIGN KEY FK_D87F7E0C8EAE3863');
        $this->addSql('ALTER TABLE test CHANGE intervention_id intervention_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE test ADD CONSTRAINT FK_D87F7E0C8EAE3863 FOREIGN KEY (intervention_id) REFERENCES intervention (id)');
        $this->addSql('ALTER TABLE commandes DROP FOREIGN KEY FK_35D4282C8EAE3863');
        $this->addSql('DROP INDEX IDX_35D4282C8EAE3863 ON commandes');
        $this->addSql('ALTER TABLE commandes DROP intervention_id');
    }
}
