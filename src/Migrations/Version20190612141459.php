<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190612141459 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE solicitud_usuario (id_solicitud_usuario INT AUTO_INCREMENT NOT NULL, id_entidad_federativa INT DEFAULT NULL, id_municipio_entidad_federativa INT DEFAULT NULL, id_municipio INT DEFAULT NULL, id_user INT DEFAULT NULL, apellido_paterno VARCHAR(50) NOT NULL, apellido_materno VARCHAR(50) DEFAULT NULL, nombre VARCHAR(70) NOT NULL, rfc VARCHAR(13) NOT NULL, curp VARCHAR(18) NOT NULL, edad INT DEFAULT NULL, calle VARCHAR(150) NOT NULL, no_exterior VARCHAR(20) NOT NULL, no_interior VARCHAR(20) DEFAULT NULL, telefono_fijo VARCHAR(15) DEFAULT NULL, telefono_celular VARCHAR(15) DEFAULT NULL, nivel_convocatoria VARCHAR(15) NOT NULL, codigo_postal VARCHAR(5) DEFAULT NULL, colonia VARCHAR(200) DEFAULT NULL, INDEX fk_solicitud_usuario_fos_user1_idx (id_user), INDEX fk_solicitud_usuario_municipios (id_municipio_entidad_federativa, id_municipio), INDEX fk_solicitud_usuario_entidad_federativa (id_entidad_federativa), PRIMARY KEY(id_solicitud_usuario)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE municipios (id_municipios INT NOT NULL, id_entidad_federativa INT NOT NULL, nombre_municipios VARCHAR(150) NOT NULL, INDEX fk_municipios_entidades_federativas (id_entidad_federativa), PRIMARY KEY(id_municipios, id_entidad_federativa)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entidades_federativas (id_entidad_federativa INT AUTO_INCREMENT NOT NULL, nombre_entidad_federativa VARCHAR(50) NOT NULL, PRIMARY KEY(id_entidad_federativa)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fos_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_957A647992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_957A6479A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_957A6479C05FB297 (confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nivel_convocatoria (id_nivel_convocatoria INT AUTO_INCREMENT NOT NULL, curp VARCHAR(18) NOT NULL, nivel_convocatoria VARCHAR(15) NOT NULL, UNIQUE INDEX CURP_NIVEL (curp, nivel_convocatoria), PRIMARY KEY(id_nivel_convocatoria)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE solicitud_usuario ADD CONSTRAINT FK_6F3C3DC29C56C91 FOREIGN KEY (id_entidad_federativa) REFERENCES entidades_federativas (id_entidad_federativa)');
        $this->addSql('ALTER TABLE solicitud_usuario ADD CONSTRAINT FK_6F3C3DCACFD51FC7EAD49C7 FOREIGN KEY (id_municipio_entidad_federativa, id_municipio) REFERENCES municipios (id_entidad_federativa, id_municipios)');
        $this->addSql('ALTER TABLE solicitud_usuario ADD CONSTRAINT FK_6F3C3DC6B3CA4B FOREIGN KEY (id_user) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE municipios ADD CONSTRAINT FK_BBFAB58629C56C91 FOREIGN KEY (id_entidad_federativa) REFERENCES entidades_federativas (id_entidad_federativa)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE solicitud_usuario DROP FOREIGN KEY FK_6F3C3DCACFD51FC7EAD49C7');
        $this->addSql('ALTER TABLE solicitud_usuario DROP FOREIGN KEY FK_6F3C3DC29C56C91');
        $this->addSql('ALTER TABLE municipios DROP FOREIGN KEY FK_BBFAB58629C56C91');
        $this->addSql('ALTER TABLE solicitud_usuario DROP FOREIGN KEY FK_6F3C3DC6B3CA4B');
        $this->addSql('DROP TABLE solicitud_usuario');
        $this->addSql('DROP TABLE municipios');
        $this->addSql('DROP TABLE entidades_federativas');
        $this->addSql('DROP TABLE fos_user');
        $this->addSql('DROP TABLE nivel_convocatoria');
    }
}
