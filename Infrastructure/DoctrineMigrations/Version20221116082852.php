<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221116082852 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE cms_content_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE cms_content_block_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE cms_content_template_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE cms_field_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE cms_field_date_time_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE cms_field_integer_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE cms_field_json_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE cms_field_string_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE cms_field_text_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE cms_page_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE cms_widget_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE cms_content (id INT DEFAULT nextval(\'cms_content_id_seq\'), content_block_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A0293FB8BB5A68E3 ON cms_content (content_block_id)');
        $this->addSql('CREATE TABLE cms_content_block (id INT DEFAULT nextval(\'cms_content_block_id_seq\'), page_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, theme VARCHAR(255) NOT NULL, layout VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D8897825C4663E4 ON cms_content_block (page_id)');
        $this->addSql('CREATE TABLE cms_content_template (id INT DEFAULT nextval(\'cms_content_template_id_seq\'), name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, config JSONB DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE cms_field (id INT DEFAULT nextval(\'cms_field_id_seq\'), content_id INT DEFAULT NULL, content_template_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, db_type VARCHAR(255) NOT NULL, config JSONB DEFAULT NULL, field_order INT DEFAULT 1 NOT NULL, provide_theme VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, layout VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7586DE7484A0A3ED ON cms_field (content_id)');
        $this->addSql('CREATE INDEX IDX_7586DE741A445520 ON cms_field (content_template_id)');
        $this->addSql('CREATE TABLE cms_field_date_time_type (id INT DEFAULT nextval(\'cms_field_date_time_type_id_seq\'), field_id INT DEFAULT NULL, value TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9DC9F221443707B0 ON cms_field_date_time_type (field_id)');
        $this->addSql('CREATE TABLE cms_field_integer_type (id INT DEFAULT nextval(\'cms_field_integer_type_id_seq\'), field_id INT DEFAULT NULL, value INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6DE6598D443707B0 ON cms_field_integer_type (field_id)');
        $this->addSql('CREATE TABLE cms_field_json_type (id INT DEFAULT nextval(\'cms_field_json_type_id_seq\'), field_id INT DEFAULT NULL, value JSONB NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_10BD666B443707B0 ON cms_field_json_type (field_id)');
        $this->addSql('CREATE TABLE cms_field_string_type (id INT DEFAULT nextval(\'cms_field_string_type_id_seq\'), field_id INT DEFAULT NULL, value VARCHAR(500) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4E421C5E443707B0 ON cms_field_string_type (field_id)');
        $this->addSql('CREATE TABLE cms_field_text_type (id INT DEFAULT nextval(\'cms_field_text_type_id_seq\'), field_id INT DEFAULT NULL, value TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CE5F4499443707B0 ON cms_field_text_type (field_id)');
        $this->addSql('CREATE TABLE cms_page (id INT DEFAULT nextval(\'cms_page_id_seq\'), name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, theme VARCHAR(255) NOT NULL, layout VARCHAR(255) NOT NULL, status VARCHAR(10) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE cms_widget (id INT DEFAULT nextval(\'cms_widget_id_seq\'), content_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, config JSONB DEFAULT NULL, widget_order INT DEFAULT 1 NOT NULL, provide_theme VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, layout VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B70F01A884A0A3ED ON cms_widget (content_id)');
        $this->addSql('ALTER TABLE cms_content_block ADD CONSTRAINT FK_D8897825C4663E4 FOREIGN KEY (page_id) REFERENCES cms_page (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cms_content ADD CONSTRAINT FK_A0293FB8BB5A68E3 FOREIGN KEY (content_block_id) REFERENCES cms_content_block (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cms_field ADD CONSTRAINT FK_7586DE7484A0A3ED FOREIGN KEY (content_id) REFERENCES cms_content (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cms_field ADD CONSTRAINT FK_7586DE741A445520 FOREIGN KEY (content_template_id) REFERENCES cms_content_template (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cms_field_date_time_type ADD CONSTRAINT FK_9DC9F221443707B0 FOREIGN KEY (field_id) REFERENCES cms_field (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cms_field_integer_type ADD CONSTRAINT FK_6DE6598D443707B0 FOREIGN KEY (field_id) REFERENCES cms_field (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cms_field_json_type ADD CONSTRAINT FK_10BD666B443707B0 FOREIGN KEY (field_id) REFERENCES cms_field (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cms_field_string_type ADD CONSTRAINT FK_4E421C5E443707B0 FOREIGN KEY (field_id) REFERENCES cms_field (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cms_field_text_type ADD CONSTRAINT FK_CE5F4499443707B0 FOREIGN KEY (field_id) REFERENCES cms_field (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cms_widget ADD CONSTRAINT FK_B70F01A884A0A3ED FOREIGN KEY (content_id) REFERENCES cms_content (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE cms_content_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE cms_content_block_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE cms_content_template_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE cms_field_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE cms_field_date_time_type_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE cms_field_integer_type_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE cms_field_json_type_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE cms_field_string_type_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE cms_field_text_type_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE cms_page_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE cms_widget_id_seq CASCADE');
        $this->addSql('ALTER TABLE cms_content DROP CONSTRAINT FK_A0293FB8BB5A68E3');
        $this->addSql('ALTER TABLE cms_field DROP CONSTRAINT FK_7586DE7484A0A3ED');
        $this->addSql('ALTER TABLE cms_field DROP CONSTRAINT FK_7586DE741A445520');
        $this->addSql('ALTER TABLE cms_field_date_time_type DROP CONSTRAINT FK_9DC9F221443707B0');
        $this->addSql('ALTER TABLE cms_field_integer_type DROP CONSTRAINT FK_6DE6598D443707B0');
        $this->addSql('ALTER TABLE cms_field_json_type DROP CONSTRAINT FK_10BD666B443707B0');
        $this->addSql('ALTER TABLE cms_field_string_type DROP CONSTRAINT FK_4E421C5E443707B0');
        $this->addSql('ALTER TABLE cms_field_text_type DROP CONSTRAINT FK_CE5F4499443707B0');
        $this->addSql('ALTER TABLE cms_widget DROP CONSTRAINT FK_B70F01A884A0A3ED');
        $this->addSql('ALTER TABLE cms_content_block DROP CONSTRAINT FK_D8897825C4663E4');
        $this->addSql('DROP TABLE cms_content');
        $this->addSql('DROP TABLE cms_content_block');
        $this->addSql('DROP TABLE cms_content_template');
        $this->addSql('DROP TABLE cms_field');
        $this->addSql('DROP TABLE cms_field_date_time_type');
        $this->addSql('DROP TABLE cms_field_integer_type');
        $this->addSql('DROP TABLE cms_field_json_type');
        $this->addSql('DROP TABLE cms_field_string_type');
        $this->addSql('DROP TABLE cms_field_text_type');
        $this->addSql('DROP TABLE cms_page');
        $this->addSql('DROP TABLE cms_widget');
    }
}
