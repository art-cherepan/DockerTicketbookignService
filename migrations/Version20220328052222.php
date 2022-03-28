<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220328052222 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booked_ticket_record (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', client_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', session_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', ticket_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_110826019EB6921 (client_id), UNIQUE INDEX UNIQ_1108260613FECDF (session_id), UNIQUE INDEX UNIQ_1108260700047D2 (ticket_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', client_name VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', film_name VARCHAR(255) NOT NULL, date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', start_time DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', end_time DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', session_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_97A0ADA3613FECDF (session_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booked_ticket_record ADD CONSTRAINT FK_110826019EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE booked_ticket_record ADD CONSTRAINT FK_1108260613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE booked_ticket_record ADD CONSTRAINT FK_1108260700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booked_ticket_record DROP FOREIGN KEY FK_110826019EB6921');
        $this->addSql('ALTER TABLE booked_ticket_record DROP FOREIGN KEY FK_1108260613FECDF');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3613FECDF');
        $this->addSql('ALTER TABLE booked_ticket_record DROP FOREIGN KEY FK_1108260700047D2');
        $this->addSql('DROP TABLE booked_ticket_record');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE ticket');
    }
}
