<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230925134527 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE auth_user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE university_student_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE university_university_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE auth_users (id BIGINT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, email VARCHAR(255) NOT NULL, user_roles JSON DEFAULT \'[]\' NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D8A1F49CE7927C74 ON auth_users (email)');
        $this->addSql('COMMENT ON COLUMN auth_users.id IS \'(DC2Type:auth_user_id)\'');
        $this->addSql('COMMENT ON COLUMN auth_users.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN auth_users.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE university_students (id BIGINT NOT NULL, university_id BIGINT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, birth_day TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, middle_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1C74AF18309D1878 ON university_students (university_id)');
        $this->addSql('COMMENT ON COLUMN university_students.id IS \'(DC2Type:university_student_id)\'');
        $this->addSql('COMMENT ON COLUMN university_students.university_id IS \'(DC2Type:university_university_id)\'');
        $this->addSql('COMMENT ON COLUMN university_students.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN university_students.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN university_students.birth_day IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE university_universities (id BIGINT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, description TEXT NOT NULL, max_students INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN university_universities.id IS \'(DC2Type:university_university_id)\'');
        $this->addSql('COMMENT ON COLUMN university_universities.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN university_universities.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE university_students ADD CONSTRAINT FK_1C74AF18309D1878 FOREIGN KEY (university_id) REFERENCES university_universities (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE auth_user_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE university_student_seq CASCADE');
        $this->addSql('DROP SEQUENCE university_university_seq CASCADE');
        $this->addSql('ALTER TABLE university_students DROP CONSTRAINT FK_1C74AF18309D1878');
        $this->addSql('DROP TABLE auth_users');
        $this->addSql('DROP TABLE university_students');
        $this->addSql('DROP TABLE university_universities');
    }
}
