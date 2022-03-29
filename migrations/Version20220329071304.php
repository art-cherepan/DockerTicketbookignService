<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220329071304 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booked_ticket_record DROP INDEX UNIQ_110826019EB6921, ADD INDEX IDX_110826019EB6921 (client_id)');
        $this->addSql('ALTER TABLE booked_ticket_record DROP FOREIGN KEY FK_1108260613FECDF');
        $this->addSql('DROP INDEX UNIQ_1108260613FECDF ON booked_ticket_record');
        $this->addSql('ALTER TABLE booked_ticket_record DROP session_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booked_ticket_record DROP INDEX IDX_110826019EB6921, ADD UNIQUE INDEX UNIQ_110826019EB6921 (client_id)');
        $this->addSql('ALTER TABLE booked_ticket_record ADD session_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE booked_ticket_record ADD CONSTRAINT FK_1108260613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1108260613FECDF ON booked_ticket_record (session_id)');
    }
}