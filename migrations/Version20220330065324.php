<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220330065324 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create a tables and links between them.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql($this->createBookedTicketRecordTable());

        $this->addSql($this->createClientTable());

        $this->addSql($this->createSessionTable());

        $this->addSql($this->createTicketTable());

        $this->addSql($this->alterTableBookedTicketRecordReferencesClient());

        $this->addSql($this->alterTableBookedTicketRecordReferencesTicket());

        $this->addSql($this->alterTableTicketReferencesBookedTicketRecord());

        $this->addSql($this->alterTableTicketReferencesSession());
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA33A94E4BC');

        $this->addSql('ALTER TABLE booked_ticket_record DROP FOREIGN KEY FK_110826019EB6921');

        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3613FECDF');

        $this->addSql('ALTER TABLE booked_ticket_record DROP FOREIGN KEY FK_1108260700047D2');

        $this->addSql('DROP TABLE booked_ticket_record');

        $this->addSql('DROP TABLE client');

        $this->addSql('DROP TABLE session');

        $this->addSql('DROP TABLE ticket');
    }

    private function createBookedTicketRecordTable(): string
    {
        return 'CREATE TABLE booked_ticket_record (
                    id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', 
                    client_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', 
                    ticket_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', 
                    INDEX IDX_110826019EB6921 (client_id), 
                    UNIQUE INDEX UNIQ_1108260700047D2 (ticket_id), 
                    PRIMARY KEY(id)
                ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB';
    }

    private function createClientTable(): string
    {
        return 'CREATE TABLE client (
                    id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', 
                    client_name VARCHAR(255) NOT NULL, 
                    phone_number VARCHAR(255) NOT NULL, 
                    PRIMARY KEY(id)
                ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB';
    }

    private function createSessionTable(): string
    {
        return 'CREATE TABLE session (
                    id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', 
                    film_name VARCHAR(255) NOT NULL, 
                    date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', 
                    start_time DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', 
                    end_time DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', 
                    PRIMARY KEY(id)
                ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB';
    }

    private function createTicketTable(): string
    {
        return 'CREATE TABLE ticket (
                    id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', 
                    booked_ticket_record_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', 
                    session_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', 
                    UNIQUE INDEX UNIQ_97A0ADA33A94E4BC (booked_ticket_record_id), 
                    INDEX IDX_97A0ADA3613FECDF (session_id), 
                    PRIMARY KEY(id)
                ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB';
    }

    private function alterTableBookedTicketRecordReferencesClient(): string
    {
        return 'ALTER TABLE booked_ticket_record 
                ADD CONSTRAINT FK_110826019EB6921 
                FOREIGN KEY (client_id) 
                REFERENCES client (id)';
    }

    private function alterTableBookedTicketRecordReferencesTicket(): string
    {
        return 'ALTER TABLE booked_ticket_record 
                ADD CONSTRAINT FK_1108260700047D2
                FOREIGN KEY (ticket_id)
                REFERENCES ticket (id)';
    }

    private function alterTableTicketReferencesBookedTicketRecord(): string
    {
        return 'ALTER TABLE ticket 
                ADD CONSTRAINT FK_97A0ADA33A94E4BC
                FOREIGN KEY (booked_ticket_record_id)
                REFERENCES booked_ticket_record (id)';
    }

    private function alterTableTicketReferencesSession(): string
    {
        return 'ALTER TABLE ticket 
                ADD CONSTRAINT FK_97A0ADA3613FECDF
                FOREIGN KEY (session_id)
                REFERENCES session (id)';
    }
}
