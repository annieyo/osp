<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160905134225 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE advisor (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE group_rating (id INT AUTO_INCREMENT NOT NULL, group_id INT DEFAULT NULL, product INT NOT NULL, documentation INT NOT NULL, UNIQUE INDEX UNIQ_B0FFEF2FE54D947 (group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_class (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_group (id INT AUTO_INCREMENT NOT NULL, class_id INT DEFAULT NULL, advisor_id INT DEFAULT NULL, topic_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_7E954D5BEA000B10 (class_id), INDEX IDX_7E954D5B66D3AD77 (advisor_id), INDEX IDX_7E954D5B1F55203D (topic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE single_rating (id INT AUTO_INCREMENT NOT NULL, student_id INT DEFAULT NULL, discussion INT NOT NULL, presentation INT NOT NULL, total_ihk INT NOT NULL, total_gso INT NOT NULL, UNIQUE INDEX UNIQ_12A260D6CB944F1A (student_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, group_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, INDEX IDX_B723AF33FE54D947 (group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE topic (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE group_rating ADD CONSTRAINT FK_B0FFEF2FE54D947 FOREIGN KEY (group_id) REFERENCES project_group (id)');
        $this->addSql('ALTER TABLE project_group ADD CONSTRAINT FK_7E954D5BEA000B10 FOREIGN KEY (class_id) REFERENCES project_class (id)');
        $this->addSql('ALTER TABLE project_group ADD CONSTRAINT FK_7E954D5B66D3AD77 FOREIGN KEY (advisor_id) REFERENCES advisor (id)');
        $this->addSql('ALTER TABLE project_group ADD CONSTRAINT FK_7E954D5B1F55203D FOREIGN KEY (topic_id) REFERENCES topic (id)');
        $this->addSql('ALTER TABLE single_rating ADD CONSTRAINT FK_12A260D6CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33FE54D947 FOREIGN KEY (group_id) REFERENCES project_group (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE project_group DROP FOREIGN KEY FK_7E954D5B66D3AD77');
        $this->addSql('ALTER TABLE project_group DROP FOREIGN KEY FK_7E954D5BEA000B10');
        $this->addSql('ALTER TABLE group_rating DROP FOREIGN KEY FK_B0FFEF2FE54D947');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33FE54D947');
        $this->addSql('ALTER TABLE single_rating DROP FOREIGN KEY FK_12A260D6CB944F1A');
        $this->addSql('ALTER TABLE project_group DROP FOREIGN KEY FK_7E954D5B1F55203D');
        $this->addSql('DROP TABLE advisor');
        $this->addSql('DROP TABLE group_rating');
        $this->addSql('DROP TABLE project_class');
        $this->addSql('DROP TABLE project_group');
        $this->addSql('DROP TABLE single_rating');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE topic');
    }
}
