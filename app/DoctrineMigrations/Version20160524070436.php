<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Initial migration
 */
class Version20160524070436 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE DOMAIN TILESET as varchar(255)');

        $this->addSql('CREATE TABLE training (id VARCHAR(255) NOT NULL, started_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, finished_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, score INT DEFAULT 0 NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE colored_tiles_exercise (id VARCHAR(255) NOT NULL, training_id VARCHAR(255) NOT NULL, colored_tiles TILESET NOT NULL, started_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, solved_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, solution_accuracy INT DEFAULT NULL, sequence_number_value INT NOT NULL, difficulty_value INT NOT NULL, grid_size_num_rows INT NOT NULL, grid_size_num_cols INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_59186413BEFD98D1 ON colored_tiles_exercise (training_id)');
        $this->addSql('ALTER TABLE colored_tiles_exercise ADD CONSTRAINT FK_59186413BEFD98D1 FOREIGN KEY (training_id) REFERENCES training (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP DOMAIN TILESET');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE colored_tiles_exercise DROP CONSTRAINT FK_59186413BEFD98D1');
        $this->addSql('DROP TABLE training');
        $this->addSql('DROP TABLE colored_tiles_exercise');
    }
}
