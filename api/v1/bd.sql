CREATE TABLE `user` (
 `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
 `login` text,
 `password_md5` text,
 `permission` int,
 `name` text,
 `avatar` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `image` (
 `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
 `login_id` int,
 `type` tinyint,
 `permission` int
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `dialogs` ( `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, `user1` int, `user2` int ) ENGINE=InnoDB DEFAULT CHARSET=utf8
