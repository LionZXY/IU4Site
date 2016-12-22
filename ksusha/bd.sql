 CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` text,
  `login` text NOT NULL,
  `password` text NOT NULL,
  `perm` int(11) NOT NULL DEFAULT '0'
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `items` (
 `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
 `title` text,
 `by_user` int NOT NULL,
 `descr` text,
 `price` int,
 `image` text,
 `time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `comments` (
 `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
 `text` text,
 `by_user` int NOT NULL,
 `to_product` int,
 `time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;