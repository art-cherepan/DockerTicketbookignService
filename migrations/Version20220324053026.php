<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220324053026 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booked_ticket_record ADD client_id VARCHAR(255) DEFAULT NULL, ADD session_id VARCHAR(255) DEFAULT NULL, ADD ticket_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE booked_ticket_record ADD CONSTRAINT FK_110826019EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE booked_ticket_record ADD CONSTRAINT FK_1108260613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE booked_ticket_record ADD CONSTRAINT FK_1108260700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_110826019EB6921 ON booked_ticket_record (client_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1108260613FECDF ON booked_ticket_record (session_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1108260700047D2 ON booked_ticket_record (ticket_id)');
        $this->addSql('ALTER TABLE client ADD client_name VARCHAR(255) NOT NULL, ADD phone_number VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE session ADD number_of_tickets INT NOT NULL, ADD film_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE ticket ADD session_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3613FECDF ON ticket (session_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booked_ticket_record DROP FOREIGN KEY FK_110826019EB6921');
        $this->addSql('ALTER TABLE booked_ticket_record DROP FOREIGN KEY FK_1108260613FECDF');
        $this->addSql('ALTER TABLE booked_ticket_record DROP FOREIGN KEY FK_1108260700047D2');
        $this->addSql('DROP INDEX UNIQ_110826019EB6921 ON booked_ticket_record');
        $this->addSql('DROP INDEX UNIQ_1108260613FECDF ON booked_ticket_record');
        $this->addSql('DROP INDEX UNIQ_1108260700047D2 ON booked_ticket_record');
        $this->addSql('ALTER TABLE booked_ticket_record DROP client_id, DROP session_id, DROP ticket_id');
        $this->addSql('ALTER TABLE client DROP client_name, DROP phone_number');
        $this->addSql('ALTER TABLE session DROP number_of_tickets, DROP film_name');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3613FECDF');
        $this->addSql('DROP INDEX IDX_97A0ADA3613FECDF ON ticket');
        $this->addSql('ALTER TABLE ticket DROP session_id');
    }
}
