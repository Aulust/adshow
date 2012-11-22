CREATE TABLE IF NOT EXISTS bindings (
  placement_name varchar(140) NOT NULL,
  unit_name varchar(140) NOT NULL,
  KEY placement_name (placement_name),
  KEY unit_name (unit_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS placement (
  placement_name varchar(140) NOT NULL,
  title varchar(255) NOT NULL,
  width int(11) NOT NULL DEFAULT '0',
  height int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (placement_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS statistics (
  unit_name varchar(140) NOT NULL,
  date date NOT NULL,
  shows int(11) NOT NULL,
  clicks int(11) NOT NULL,
  UNIQUE KEY unit_name_date (unit_name,date),
  KEY date (date),
  KEY unit_name (unit_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS statistics_cache (
  unit_name varchar(140) NOT NULL,
  date date NOT NULL,
  shows int(11) NOT NULL DEFAULT '0',
  clicks int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (unit_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS unit (
  unit_name varchar(140) NOT NULL,
  type enum('image','html') NOT NULL,
  title varchar(255) NOT NULL,
  weight int(11) NOT NULL DEFAULT '1',
  link varchar(512) NOT NULL,
  status enum('active','delete','inactive') NOT NULL,
  image_url varchar(512) DEFAULT NULL,
  image_type enum('local','remote') NOT NULL,
  html text,
  shows_limit int(11) DEFAULT NULL,
  clicks_limit int(11) DEFAULT NULL,
  time_limit date DEFAULT NULL,
  PRIMARY KEY (unit_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE bindings
  ADD CONSTRAINT bindings_placement FOREIGN KEY (placement_name) REFERENCES placement (placement_name) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT bindings_unit FOREIGN KEY (unit_name) REFERENCES unit (unit_name) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE statistics
  ADD CONSTRAINT statistics_unit FOREIGN KEY (unit_name) REFERENCES unit (unit_name) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE statistics_cache
  ADD CONSTRAINT statistics_unit_cache FOREIGN KEY (unit_name) REFERENCES unit (unit_name) ON DELETE CASCADE ON UPDATE CASCADE;

CREATE EVENT units_inactivation ON SCHEDULE EVERY 5 MINUTE ON COMPLETION NOT PRESERVE ENABLE DO update unit left join statistics_cache on unit.unit_name = statistics_cache.unit_name set status = 'inactive'
where (
(shows_limit IS NOT NULL AND shows_limit <= ifnull(statistics_cache.shows, 0) + (select sum(shows) from statistics where date > ifnull(statistics_cache.date, '1000-01-01') and statistics_cache.unit_name = unit.unit_name))
OR 
(clicks_limit IS NOT NULL AND clicks_limit <= ifnull(statistics_cache.clicks, 0) + (select sum(clicks) from statistics where date > ifnull(statistics_cache.date, '1000-01-01') and statistics_cache.unit_name = unit.unit_name))
OR 
(time_limit IS NOT NULL AND time_limit <= CURDATE())
)
and status = 'active';
