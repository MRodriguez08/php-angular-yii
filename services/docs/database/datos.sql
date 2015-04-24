USE `curvometal_web`;

INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('administrativo',2,'','','');
INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('administrador',2,'','','');

INSERT INTO `AuthAssignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES ('administrador','mrodriguez',NULL,NULL);

INSERT INTO `users` (`nick`, `email`, `password`, `name`, `surname`, `last_login`, `enabled`, `role`) 
VALUES ('mrodriguez','mrodriguez@gmail.com','$1$UQuRVKk0$wUrX3YsP6/bxHFKToL.7i.','Mauricio','Rodriguez',NULL,NULL,'administrador');

INSERT INTO `sysparams` (`name`, `description`, `value`, `type`, `visible`, `editable` ) 
VALUES ('defaultPassword','Clave que se utilizara cuando se resetea la contrasenia de un usuario','cambiame','string', 1, 0);

INSERT INTO `sysparams` (`name`, `description`, `value`, `type`, `visible`, `editable` ) 
VALUES ('appFilesDirectory','Ruta base para las imagenes subidas en el sistema de archivos','/opt/lampp/htdocs/files/curvometal','string', 1, 0);

INSERT INTO `notification_types` VALUES (1,'Notificacion para contratar servicio','Tipo de notificacion para contratar los servicios de la empresa.',1),(3,'Petición de información','Petición de información',1);

INSERT INTO `notification_states` VALUES (1,'state 1','asdasdsad',0),(2,'state 2','s',0);
update notification_states set enabled = 1;