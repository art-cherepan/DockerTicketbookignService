<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220329045851 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booked_ticket_record DROP INDEX IDX_1108260700047D2, ADD UNIQUE INDEX UNIQ_1108260700047D2 (ticket_id)');
        $this->addSql('ALTER TABLE ticket ADD booked_ticket_record_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA33A94E4BC FOREIGN KEY (booked_ticket_record_id) REFERENCES booked_ticket_record (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_97A0ADA33A94E4BC ON ticket (booked_ticket_record_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booked_ticket_record DROP INDEX UNIQ_1108260700047D2, ADD INDEX IDX_1108260700047D2 (ticket_id)');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA33A94E4BC');
        $this->addSql('DROP INDEX UNIQ_97A0ADA33A94E4BC ON ticket');
        $this->addSql('ALTER TABLE ticket DROP booked_ticket_record_id');
    }
}
