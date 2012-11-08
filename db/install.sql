-- phpMyAdmin SQL Dump
-- version 3.2.3
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Ноя 08 2012 г., 20:48
-- Версия сервера: 5.1.40
-- Версия PHP: 5.3.18

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- База данных: `adshow`
--

-- --------------------------------------------------------

--
-- Структура таблицы `bindings`
--

CREATE TABLE IF NOT EXISTS `bindings` (
  `placement_name` varchar(140) NOT NULL,
  `unit_name` varchar(140) NOT NULL,
  KEY `placement_name` (`placement_name`),
  KEY `unit_name` (`unit_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `placement`
--

CREATE TABLE IF NOT EXISTS `placement` (
  `placement_name` varchar(140) NOT NULL,
  `title` varchar(255) NOT NULL,
  `width` int(11) NOT NULL DEFAULT '0',
  `height` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`placement_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `unit`
--

CREATE TABLE IF NOT EXISTS `unit` (
  `unit_name` varchar(140) NOT NULL,
  `type` enum('image','html') NOT NULL,
  `title` varchar(255) NOT NULL,
  `weight` int(11) NOT NULL DEFAULT '1',
  `link` varchar(512) NOT NULL,
  `status` enum('active','delete') NOT NULL,
  `image_url` varchar(512) DEFAULT NULL,
  `html` text,
  `shows` int(10) NOT NULL,
  `clicks` int(10) NOT NULL,
  `views_limit` int(10) NOT NULL,
  `clicks_limit` int(10) NOT NULL,
  `time_limit` date NOT NULL,
  PRIMARY KEY (`unit_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
