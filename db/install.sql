CREATE TABLE unit (
  unit_name varchar(140) NOT NULL,
  type enum('image','html') NOT NULL,
  title varchar(255) NOT NULL,
  weight int(11) NOT NULL DEFAULT '1',
  link varchar(512) NOT NULL,
  status enum('active','delete') NOT NULL,
  image_url varchar(512) DEFAULT NULL,
  html text,
  PRIMARY KEY (unit_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE placement (
  placement_name varchar(140) NOT NULL,
  title varchar(255) NOT NULL,
  width int(11) NOT NULL DEFAULT '0',
  height int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (placement_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE bindings (
  placement_name varchar(140) NOT NULL,
  unit_name varchar(140) NOT NULL,
  KEY placement_name (placement_name),
  KEY unit_name (unit_name),
  CONSTRAINT bindings_placement FOREIGN KEY (placement_name) REFERENCES placement (placement_name) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT bindings_unit FOREIGN KEY (unit_name) REFERENCES unit (unit_name) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
