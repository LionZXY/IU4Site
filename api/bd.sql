CREATE TABLE `user` (
 `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
 `login` text,
 `password_md5` text,
 `permission` int,
 `name` text,
 `avatar` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;