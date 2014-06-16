CREATE TABLE xi_filelib_file (id INT AUTO_INCREMENT NOT NULL, folder_id INT NOT NULL, resource_id INT NOT NULL, data LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', fileprofile VARCHAR(255) NOT NULL, filename VARCHAR(255) NOT NULL, date_created DATETIME NOT NULL, status INT NOT NULL, uuid VARCHAR(36) NOT NULL, UNIQUE INDEX UNIQ_E8606524D17F50A6 (uuid), INDEX IDX_E8606524162CB942 (folder_id), INDEX IDX_E860652489329D25 (resource_id), UNIQUE INDEX folderid_filename_unique (folder_id, filename), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE xi_filelib_folder (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, data LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', foldername VARCHAR(255) NOT NULL, folderurl VARCHAR(5000) NOT NULL, uuid VARCHAR(36) NOT NULL, UNIQUE INDEX UNIQ_A5EA9E8BD17F50A6 (uuid), INDEX IDX_A5EA9E8B727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE xi_filelib_resource (id INT AUTO_INCREMENT NOT NULL, data LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', hash VARCHAR(255) NOT NULL, mimetype VARCHAR(255) NOT NULL, filesize INT NOT NULL, exclusive TINYINT(1) NOT NULL, date_created DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE xi_filelib_file ADD CONSTRAINT FK_E8606524162CB942 FOREIGN KEY (folder_id) REFERENCES xi_filelib_folder (id);
ALTER TABLE xi_filelib_file ADD CONSTRAINT FK_E860652489329D25 FOREIGN KEY (resource_id) REFERENCES xi_filelib_resource (id);
ALTER TABLE xi_filelib_folder ADD CONSTRAINT FK_A5EA9E8B727ACA70 FOREIGN KEY (parent_id) REFERENCES xi_filelib_folder (id);
