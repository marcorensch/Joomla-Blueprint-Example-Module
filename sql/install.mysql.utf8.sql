CREATE TABLE IF NOT EXISTS `#__mod_blueprint_data`
(
    `id`           int(11)                                                NOT NULL AUTO_INCREMENT,
    `title`        varchar(255)                                           NOT NULL DEFAULT '',
    `alias`        varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
    `params`       text                                                   NOT NULL DEFAULT '',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  DEFAULT COLLATE = utf8mb4_unicode_ci;