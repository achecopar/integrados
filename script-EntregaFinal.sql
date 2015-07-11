-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-11-2014 a las 21:35:31
-- Versión del servidor: 5.5.39
-- Versión de PHP: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `social_network`
--
CREATE DATABASE IF NOT EXISTS `social_network` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `social_network`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `adv`
--

CREATE TABLE IF NOT EXISTS `adv` (
`id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Volcado de datos para la tabla `adv`
--

INSERT INTO `adv` (`id`, `date`, `message`) VALUES
(10, '2014-11-18 11:19:24', 'Integra CCS tiene el agrado de comunicarle a sus empleados que el prÃ³ximo 24 no estÃ¡n obligados a asistir al trabajo.'),
(11, '2014-11-20 16:53:55', 'Integra CCS celebrarÃ¡ su aniversario con un asado el prÃ³ximo viernes a las 21:00hs. EstÃ¡n todos invitados.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
`id_comment` int(11) NOT NULL,
  `message` varchar(200) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT NULL,
  `id_wall_entry` int(11) NOT NULL,
  `user_email` varchar(45) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Volcado de datos para la tabla `comment`
--

INSERT INTO `comment` (`id_comment`, `message`, `date`, `deleted`, `id_wall_entry`, `user_email`) VALUES
(17, 'Comentario de admin', '2014-11-20 18:11:04', 0, 26, 'admin@integraccs.com'),
(18, 'Comentario de amigo', '2014-11-20 18:12:14', 0, 27, 'amigodetodos@integraccs.com'),
(19, 'Comentario de amigo', '2014-11-20 18:12:28', 0, 22, 'amigodetodos@integraccs.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `friendship`
--

CREATE TABLE IF NOT EXISTS `friendship` (
  `email_adder` varchar(45) NOT NULL,
  `email_added` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `friendship`
--

INSERT INTO `friendship` (`email_adder`, `email_added`) VALUES
('amigodetodos@integraccs.com', 'admin@integraccs.com'),
('user@integraccs.com', 'admin@integraccs.com'),
('user@integraccs.com', 'amigodetodos@integraccs.com'),
('amigodetodos@integraccs.com', 'user@integraccs.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gallery`
--

CREATE TABLE IF NOT EXISTS `gallery` (
  `id_media` varchar(200) NOT NULL,
  `media_name` varchar(200) NOT NULL,
  `media_date` datetime NOT NULL,
  `media_owner` varchar(100) NOT NULL,
  `count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `gallery`
--

INSERT INTO `gallery` (`id_media`, `media_name`, `media_date`, `media_owner`, `count`) VALUES
('g1', 'Foto de perfil', '2014-11-20 17:03:13', 'admin@integraccs.com', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `like_wall`
--

CREATE TABLE IF NOT EXISTS `like_wall` (
  `user_email` varchar(45) NOT NULL,
  `id_wall_entry` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `email` varchar(45) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `position` varchar(45) DEFAULT NULL,
  `sector` varchar(45) DEFAULT NULL,
  `country` varchar(45) DEFAULT NULL,
  `phone` int(11) DEFAULT NULL,
  `job_place_x` double DEFAULT NULL,
  `job_place_y` double DEFAULT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT NULL,
  `password` varchar(20) NOT NULL,
  `image` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`email`, `name`, `position`, `sector`, `country`, `phone`, `job_place_x`, `job_place_y`, `admin`, `deleted`, `password`, `image`) VALUES
('admin@integraccs.com', 'Admin', 'Administrador', 'Gerencia', 'Uruguay', 2147483647, -56, -32.6, 1, 0, 'Admin1234', 'img/g1.jpg'),
('amigodetodos@integraccs.com', 'Amigo', 'Amigo de todos', 'Recursos Humanos', 'Uruguay', 2147483647, -56, -32.6, 0, 0, 'Amigo1234', 'img/user.jpg'),
('user@integraccs.com', 'User', 'Usuario', 'Soporte', 'Uruguay', 2147483647, -56, -32.6, 0, 0, 'User1234', 'img/user.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wall_entry`
--

CREATE TABLE IF NOT EXISTS `wall_entry` (
`id_wall_entry` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `message` varchar(500) DEFAULT NULL,
  `visibility` varchar(7) DEFAULT NULL,
  `image` int(11) DEFAULT NULL,
  `image_name` varchar(100) DEFAULT NULL,
  `video` varchar(200) DEFAULT NULL,
  `email_owner` varchar(45) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Volcado de datos para la tabla `wall_entry`
--

INSERT INTO `wall_entry` (`id_wall_entry`, `date`, `message`, `visibility`, `image`, `image_name`, `video`, `email_owner`) VALUES
(22, '2014-11-20 17:14:50', 'PublicaciÃ³n privada', 'FRIENDS', NULL, '', NULL, 'user@integraccs.com'),
(23, '2014-11-20 17:15:03', 'PublicaciÃ³n pÃºblica', 'ALL', NULL, '', NULL, 'user@integraccs.com'),
(25, '2014-11-20 17:22:03', 'PubilicaciÃ³n pÃºblica', 'ALL', NULL, '', NULL, 'amigodetodos@integraccs.com'),
(26, '2014-11-20 17:22:08', 'PublicaciÃ³n privada', 'FRIENDS', NULL, '', NULL, 'amigodetodos@integraccs.com'),
(27, '2014-11-20 17:23:08', 'PublicaciÃ³n pÃºblica', 'ALL', NULL, '', NULL, 'admin@integraccs.com'),
(28, '2014-11-20 17:23:13', 'PublicaciÃ³n privada', 'FRIENDS', NULL, '', NULL, 'admin@integraccs.com'),
(30, '2014-11-20 18:23:18', 'Miren todos este video! Jaja', 'ALL', NULL, '', 'http://youtu.be/iEzrlLIPkas', 'amigodetodos@integraccs.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `adv`
--
ALTER TABLE `adv`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comment`
--
ALTER TABLE `comment`
 ADD PRIMARY KEY (`id_comment`), ADD KEY `fk_comment_entry_wall_entry1_idx` (`id_wall_entry`), ADD KEY `fk_comment_entry_user1_idx` (`user_email`);

--
-- Indices de la tabla `friendship`
--
ALTER TABLE `friendship`
 ADD PRIMARY KEY (`email_adder`,`email_added`), ADD KEY `fk_user_has_user_user1_idx` (`email_added`), ADD KEY `fk_user_has_user_user_idx` (`email_adder`);

--
-- Indices de la tabla `gallery`
--
ALTER TABLE `gallery`
 ADD PRIMARY KEY (`count`), ADD UNIQUE KEY `id_media` (`id_media`);

--
-- Indices de la tabla `like_wall`
--
ALTER TABLE `like_wall`
 ADD PRIMARY KEY (`user_email`,`id_wall_entry`), ADD KEY `fk_like_user1_idx` (`user_email`), ADD KEY `fk_like_wall_entry1_idx` (`id_wall_entry`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`email`), ADD KEY `name` (`name`), ADD KEY `sector` (`sector`), ADD KEY `country` (`country`), ADD KEY `email` (`email`);

--
-- Indices de la tabla `wall_entry`
--
ALTER TABLE `wall_entry`
 ADD PRIMARY KEY (`id_wall_entry`), ADD KEY `fk_wall_entry_user1_idx` (`email_owner`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `adv`
--
ALTER TABLE `adv`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT de la tabla `comment`
--
ALTER TABLE `comment`
MODIFY `id_comment` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT de la tabla `wall_entry`
--
ALTER TABLE `wall_entry`
MODIFY `id_wall_entry` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comment`
--
ALTER TABLE `comment`
ADD CONSTRAINT `fk_comment_entry_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_comment_entry_wall_entry1` FOREIGN KEY (`id_wall_entry`) REFERENCES `wall_entry` (`id_wall_entry`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `friendship`
--
ALTER TABLE `friendship`
ADD CONSTRAINT `fk_user_has_user_user` FOREIGN KEY (`email_adder`) REFERENCES `user` (`email`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_user_has_user_user1` FOREIGN KEY (`email_added`) REFERENCES `user` (`email`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `like_wall`
--
ALTER TABLE `like_wall`
ADD CONSTRAINT `fk_like_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_like_wall_entry1` FOREIGN KEY (`id_wall_entry`) REFERENCES `wall_entry` (`id_wall_entry`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `wall_entry`
--
ALTER TABLE `wall_entry`
ADD CONSTRAINT `fk_wall_entry_user1` FOREIGN KEY (`email_owner`) REFERENCES `user` (`email`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
