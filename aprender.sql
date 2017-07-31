-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 31-07-2017 a las 07:56:43
-- Versión del servidor: 5.7.18
-- Versión de PHP: 7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `aprender`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lkw_coursecategories`
--

CREATE TABLE `lkw_coursecategories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tag` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `lkw_coursecategories`
--

INSERT INTO `lkw_coursecategories` (`id`, `name`, `tag`) VALUES
(1, 'Diseño', 'diseno'),
(2, 'Mecánica', 'mecanica'),
(123, 'Idiomas', 'idiomas'),
(124, 'Informática', 'informatica'),
(125, 'Internet', 'internet'),
(126, 'Manualidades', 'manualidades'),
(127, 'Autoayuda', 'autoayuda'),
(128, 'Empresa', 'empresa'),
(129, 'Cocina', 'cocina'),
(130, 'Ciencia', 'ciencia'),
(131, 'Arte/Humanidades', 'arte-humanidades'),
(132, 'Aficiones', 'aficiones'),
(133, 'Salud', 'salud'),
(134, 'Deporte', 'deporte'),
(135, 'Dibujo/Pintura', 'dibujo-pintura'),
(136, 'Docencia', 'docencia'),
(137, 'Decoración', 'decoracion'),
(138, 'Belleza', 'belleza'),
(139, 'Bricolaje', 'bricolaje'),
(140, 'Bebé', 'bebe'),
(141, 'Psicología', 'psicologia'),
(142, 'Primaria', 'primaria'),
(143, 'Secundaria', 'secundaria'),
(144, 'Bachillerato', 'bachillerato'),
(145, 'Seguridad', 'seguridad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lkw_coursecosts`
--

CREATE TABLE `lkw_coursecosts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `currency_id` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `lkw_coursecosts`
--

INSERT INTO `lkw_coursecosts` (`id`, `name`, `currency_id`, `price`) VALUES
(1, 'Gratis', 1, 0),
(2, 'Básico', 1, 1),
(3, 'Premier', 1, 10),
(4, 'Free', 2, 0),
(5, 'Basic', 2, 1),
(6, 'Premier', 2, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lkw_courses`
--

CREATE TABLE `lkw_courses` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `currency_id` int(11) NOT NULL,
  `cost` decimal(19,2) NOT NULL,
  `type_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `resume` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `video` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `place` int(11) DEFAULT NULL,
  `province` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avenue` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `minstudent` int(11) DEFAULT NULL,
  `maxstudent` int(11) DEFAULT NULL,
  `star_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `days` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hour` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `knowledge` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tool` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `register_date` datetime NOT NULL,
  `update_date` datetime DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `lkw_courses`
--

INSERT INTO `lkw_courses` (`id`, `category_id`, `currency_id`, `cost`, `type_id`, `title`, `description`, `resume`, `photo`, `video`, `place`, `province`, `avenue`, `address`, `minstudent`, `maxstudent`, `star_date`, `end_date`, `days`, `hour`, `country`, `knowledge`, `tool`, `status`, `user_id`, `register_date`, `update_date`, `update_by`) VALUES
(8, 129, 2, '5.00', 2, 'Aprende cómo hacer una paella profesional', 'La paella es una receta de cocina con base de arroz cocinado con otras viandas en el utensilio denominado paellera, muy popular en Valencia.', 'La paella es una receta de cocina con base de arroz cocinado con otras viandas en el utensilio denominado paellera, muy popular en Valencia. Es uno de los platos estrella de la gastronomía española. \r\n\r\nEn este curso aprenderá todos los trucos para hacer', 'e7928f0ee11663814e26d7d91c2dfcce.jpeg', 'https://lib.tutellus.com/libraries/21/97/02/lib/1446117172372_2-480.mp4', 1, 'MD', 'Condimentum placerat urna', 'Condimentum placerat urna', 3, 50, '2017-03-10 18:37:55', '2017-03-24 18:37:55', 'MI', '11:00 AM', 'ES', 'Condimentum placerat urna', 'Condimentum placerat urna', 1, 3, '2017-06-01 00:00:00', NULL, NULL),
(9, 124, 2, '5.00', 2, 'Programación para niños con Scratch', 'Scratch es un \"framework\" de desarrollado creado desde el MIT que ayuda a cualquier persona los principios de la programación', 'En este videocurso online podrás aprender a programar sin necesidad de aprender complicado código, simplemente tendrás que posicionar fichas de colores como si de un lego se tratase, está indicado especialmente para niños y para gente que da sus primeros', 'fea0c667f560f18c0eb2163c6653d57e.jpeg', 'https://lib.tutellus.com/libraries/47/26/lib/1399316054788-480.mp4', 2, 'DI', 'Condimentum placerat urna', 'Condimentum placerat urna', 2, 8, '2017-03-08 22:26:54', '2017-03-08 22:26:54', 'MI', '12:00 PM', 'VE', 'Condimentum placerat urna', 'Condimentum placerat urna', 1, 3, '2017-06-01 00:00:00', '2017-07-09 22:26:54', 3),
(10, 127, 1, '2.00', 1, 'Coaching personal: Cómo lograr tus objetivos y tener el estilo de vida que deseas', 'Vivir Enfocados es un modelo de pensamiento que integra diferentes estrategias de Desarrollo Personal y Coaching para el Exito', 'Vivir Enfocados es un modelo de pensamiento y de vida , que integra diferentes estrategias de Desarrollo Personal y Coaching de Vida, para poder comenzar a crear un estilo de vida enfocada en la conquista de objetivos personales. \r\n\r\nLa empresa interna es', '6c90105583131b3e519de2d0b6d5b137.jpeg', 'https://lib.tutellus.com/libraries/80/38/08/lib/1470867304673_3-480.mp4', 2, 'SAN', 'Condimentum placerat urna', 'Condimentum placerat urna', 4, 6, '2017-04-25 18:08:57', '2017-05-06 18:08:57', 'MA,MI', '8:00 AM', 'GI', 'Condimentum placerat urna', 'Condimentum placerat urna', 1, 3, '2017-06-01 00:00:00', NULL, NULL),
(11, 138, 1, '2.00', 1, 'No make up II', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum euismod justo justo, at ullamcorper ligula tincidunt id. Lorem ipsum do', 'Duis ultrices nunc elementum, pulvinar felis quis, lacinia odio. Donec metus erat, commodo sit amet commodo sed, sollicitudin sit amet mauris. Proin vel ullamcorper mauris, in scelerisque ipsum. Ut eu placerat nisl. Nullam scelerisque porta rhoncus. Maece', 'a8c8b46d2fb57879ca0e5d3b7267fc93.jpeg', 'https://www.youtube.com/watch?v=Bf3O8oBT5sM', 2, 'AN', 'Av Univerisitaria', 'Proin vel ullamcorper mauris, in scelerisque ipsum.', 2, 4, '2017-04-04 17:10:26', '2017-04-06 17:10:26', 'MI,JU', '5:00 PM', 'VE', 'Integer ornare ultrices purus malesuada fermentum. Donec eget arcu ullamcorper, porttitor urna a, laoreet ipsum. Vestibulum egestas dapibus sodales. In mattis ultrices egestas. Proin tellus turpis, semper sed maximus at, tincidunt vel justo. Duis at viver', 'Proin condimentum tellus sit amet dolor vestibulum commodo. Phasellus efficitur vitae ligula quis viverra. Curabitur quis est massa. Nulla ultricies, arcu eget bibendum semper, mi arcu elementum ipsum, at sollicitudin enim magna et ipsum. Proin nec nunc a', 1, 3, '2017-06-01 00:00:00', NULL, NULL),
(12, 138, 1, '15402.67', 1, 'MI Belleza', 'Lorem ipsum dolor sit amet, ancillae salutatus has ea, sed at paulo invenire. Est integre iuvaret torquatos in. Eu eos quot aliquip, albuciu', 'Lorem ipsum dolor sit amet, ancillae salutatus has ea, sed at paulo invenire. Est integre iuvaret torquatos in. Eu eos quot aliquip, albucius accusamus imperdiet eos in. Harum delicatissimi an mei. Te dolore assentior ius.\r\n\r\nLorem ipsum dolor sit amet, a', 'b88df75a619f3ae84490a8c1a5917e4c.jpeg', NULL, 1, 'DI', 'Las Adjuntas', 'Lorem ipsum dolor sit amet, ancillae salutatus has ea, sed at paulo invenire. Est integre iuvaret torquatos in. Eu eos quot aliquip, albucius accusamus imperdiet eos in. Harum delicatissimi an mei. Te dolore assentior ius.', 1, 5, '2017-06-01 15:20:49', '2017-06-03 15:20:49', 'LU,MA,MI', '9:00 AM', 'VE', 'Lorem ipsum dolor sit amet, ancillae salutatus has ea, sed at paulo invenire. Est integre iuvaret torquatos in. Eu eos quot aliquip, albucius accusamus imperdiet eos in. Harum delicatissimi an mei. Te dolore assentior ius.', 'Lorem ipsum dolor sit amet, ancillae salutatus has ea, sed at paulo invenire. Est integre iuvaret torquatos in. Eu eos quot aliquip, albucius accusamus imperdiet eos in. Harum delicatissimi an mei. Te dolore assentior ius.', 1, 1, '2017-06-01 00:00:00', '2017-07-23 15:20:49', 1),
(13, 130, 1, '1.00', 1, 'La economía del absurdo', 'El impacto de la Globalización económica y sus efectos en forma de deslocalización de las actividades industriales y de servicios. En el mundo', 'Curso destinado a estudiantes universitarios, a graduados y a personas interesadas en general, para conocer y reflexionar sobre algunas de las pricipales claves que explican una sociedad actual, cada vez en una situación de crisis más profunda, donde lo social, lo económico, lo político y lo medioambiental se interrelacionan de manera bastante perversa y dónde queda en cuestión el sentido de la economía. La pretensión del curso es proporcionar una visión interdisciplinaria e interrelacionadas.', '27392ae92d6872adae7fdbaf78692ca2.jpeg', 'https://www.youtube.com/embed/YWQLcryuP2s', 1, 'TR', 'Carache', 'Edif. Recreo. Piso 4. Ofic. 3', 2, 4, '2017-07-01 20:48:31', '2017-07-08 20:48:31', 'LU,MA,MI,JU,VI,SA', '9:00 AM', 'VE', 'Titulación universitaria, especialmente en grados de Ciencias Sociales y Humanidades. Estudiantes universitarios interesados e iniciados en estos temas.', 'Ninguna', 1, 1, '2017-06-01 00:00:00', '2017-06-18 20:48:31', 9),
(14, 140, 2, '320.25', 2, 'Vestibulum dapibus erat a neque venenatis, a sagittis massa laoreet.', 'Vestibulum dapibus erat a neque venenatis, a sagittis massa laoreet. Mauris vehicula, tellus at rhoncus dignissim, dolor quam semper diam.', 'Vestibulum dapibus erat a neque venenatis, a sagittis massa laoreet. Mauris vehicula, tellus at rhoncus dignissim, dolor quam semper diam, vel euismod tellus libero id massa. Vivamus eu nibh mattis, imperdiet arcu at, aliquam nunc. Nullam tincidunt vestibulum vestibulum. Pellentesque fringilla est aliquet augue congue, sit amet tincidunt sem ornare. Praesent sit amet ullamcorper urna, id varius sem. Aliquam augue eros, rutrum eleifend enim ac, maximus sodales libero.', 'e66cc31182346a0f3528ed9257811975.jpeg', NULL, 2, 'AR', 'Vestibulum dapibus erat a neque venenatis', 'Vestibulum dapibus erat a neque venenatis. Vestibulum dapibus erat a neque venenatis', 1, 4, '2017-07-01 20:59:08', '2017-08-05 20:59:08', NULL, '8:50 AM', 'VE', 'Vestibulum dapibus erat a neque venenatis. Vestibulum dapibus erat a neque venenatis', 'Vestibulum dapibus erat a neque venenatis', 1, 1, '2017-06-18 20:53:41', '2017-06-18 20:59:08', 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lkw_currency`
--

CREATE TABLE `lkw_currency` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `lkw_currency`
--

INSERT INTO `lkw_currency` (`id`, `name`) VALUES
(1, 'Bs'),
(2, '$');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lkw_payments`
--

CREATE TABLE `lkw_payments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `amount` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `result` text COLLATE utf8_unicode_ci,
  `pdatetime` datetime DEFAULT CURRENT_TIMESTAMP,
  `currency` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `lkw_payments`
--

INSERT INTO `lkw_payments` (`id`, `user_id`, `course_id`, `amount`, `status`, `result`, `pdatetime`, `currency`) VALUES
(7, 1, 9, 1, 'approved', '{\"id\":\"PAY-7FG828461T159681XLC6IFMA\",\"intent\":\"sale\",\"state\":\"approved\",\"cart\":\"07F97611C4578332R\",\"payer\":{\"payment_method\":\"paypal\",\"status\":\"VERIFIED\",\"payer_info\":{\"email\":\"marianamff-buyer@gmail.com\",\"first_name\":\"test\",\"last_name\":\"buyer\",\"payer_id\":\"J3M72947XXKFS\",\"shipping_address\":{\"recipient_name\":\"test buyer\",\"line1\":\"001\",\"city\":\"San Jose\",\"state\":\"CA\",\"postal_code\":\"50002\",\"country_code\":\"US\"},\"phone\":\"4089893583\",\"country_code\":\"US\"}},\"transactions\":[{\"amount\":{\"total\":\"1.00\",\"currency\":\"USD\",\"details\":{\"subtotal\":\"1.00\"}},\"description\":\"Programación para niños con Scratch\",\"item_list\":{\"items\":[],\"shipping_address\":{\"recipient_name\":\"test buyer\",\"line1\":\"001\",\"city\":\"San Jose\",\"state\":\"CA\",\"postal_code\":\"50002\",\"country_code\":\"US\"}},\"related_resources\":[{\"sale\":{\"id\":\"32D22012HD495774B\",\"state\":\"pending\",\"amount\":{\"total\":\"1.00\",\"currency\":\"USD\",\"details\":{\"subtotal\":\"1.00\"}},\"payment_mode\":\"INSTANT_TRANSFER\",\"reason_code\":\"PAYMENT_REVIEW\",\"protection_eligibility\":\"INELIGIBLE\",\"transaction_fee\":{\"value\":\"0.33\",\"currency\":\"USD\"},\"parent_payment\":\"PAY-7FG828461T159681XLC6IFMA\",\"create_time\":\"2017-03-05T21:27:31Z\",\"update_time\":\"2017-03-05T21:27:31Z\",\"links\":[{\"href\":\"https://api.sandbox.paypal.com/v1/payments/sale/32D22012HD495774B\",\"rel\":\"self\",\"method\":\"GET\"},{\"href\":\"https://api.sandbox.paypal.com/v1/payments/sale/32D22012HD495774B/refund\",\"rel\":\"refund\",\"method\":\"POST\"},{\"href\":\"https://api.sandbox.paypal.com/v1/payments/payment/PAY-7FG828461T159681XLC6IFMA\",\"rel\":\"parent_payment\",\"method\":\"GET\"}]}}]}],\"create_time\":\"2017-03-05T21:27:31Z\",\"links\":[{\"href\":\"https://api.sandbox.paypal.com/v1/payments/payment/PAY-7FG828461T159681XLC6IFMA\",\"rel\":\"self\",\"method\":\"GET\"}]}', '2017-03-05 21:14:34', 'USD'),
(9, 1, 8, 1, 'approved', '{\"id\":\"PAY-03H48657H2722844XLC6LQOQ\",\"intent\":\"sale\",\"state\":\"approved\",\"cart\":\"0D1729060Y193452F\",\"payer\":{\"payment_method\":\"paypal\",\"status\":\"VERIFIED\",\"payer_info\":{\"email\":\"marianamff-buyer@gmail.com\",\"first_name\":\"test\",\"last_name\":\"buyer\",\"payer_id\":\"J3M72947XXKFS\",\"shipping_address\":{\"recipient_name\":\"test buyer\",\"line1\":\"001\",\"city\":\"San Jose\",\"state\":\"CA\",\"postal_code\":\"50002\",\"country_code\":\"US\"},\"phone\":\"4089893583\",\"country_code\":\"US\"}},\"transactions\":[{\"amount\":{\"total\":\"1.00\",\"currency\":\"USD\",\"details\":{\"subtotal\":\"1.00\"}},\"description\":\"Aprende cómo hacer una paella profesional\",\"item_list\":{\"items\":[],\"shipping_address\":{\"recipient_name\":\"test buyer\",\"line1\":\"001\",\"city\":\"San Jose\",\"state\":\"CA\",\"postal_code\":\"50002\",\"country_code\":\"US\"}},\"related_resources\":[{\"sale\":{\"id\":\"6S4443272G1422438\",\"state\":\"pending\",\"amount\":{\"total\":\"1.00\",\"currency\":\"USD\",\"details\":{\"subtotal\":\"1.00\"}},\"payment_mode\":\"INSTANT_TRANSFER\",\"reason_code\":\"PAYMENT_REVIEW\",\"protection_eligibility\":\"INELIGIBLE\",\"transaction_fee\":{\"value\":\"0.33\",\"currency\":\"USD\"},\"parent_payment\":\"PAY-03H48657H2722844XLC6LQOQ\",\"create_time\":\"2017-03-06T01:16:06Z\",\"update_time\":\"2017-03-06T01:16:06Z\",\"links\":[{\"href\":\"https://api.sandbox.paypal.com/v1/payments/sale/6S4443272G1422438\",\"rel\":\"self\",\"method\":\"GET\"},{\"href\":\"https://api.sandbox.paypal.com/v1/payments/sale/6S4443272G1422438/refund\",\"rel\":\"refund\",\"method\":\"POST\"},{\"href\":\"https://api.sandbox.paypal.com/v1/payments/payment/PAY-03H48657H2722844XLC6LQOQ\",\"rel\":\"parent_payment\",\"method\":\"GET\"}]}}]}],\"create_time\":\"2017-03-06T01:16:06Z\",\"links\":[{\"href\":\"https://api.sandbox.paypal.com/v1/payments/payment/PAY-03H48657H2722844XLC6LQOQ\",\"rel\":\"self\",\"method\":\"GET\"}]}', '2017-03-05 21:16:04', 'USD');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lkw_reviews`
--

CREATE TABLE `lkw_reviews` (
  `id` int(11) NOT NULL,
  `comment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `score` int(11) NOT NULL,
  `evaluator` int(11) NOT NULL,
  `evaluated` int(11) NOT NULL,
  `type_evaluated` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `lkw_reviews`
--

INSERT INTO `lkw_reviews` (`id`, `comment`, `score`, `evaluator`, `evaluated`, `type_evaluated`) VALUES
(2, 'SA sdfasdf adfg adf', 4, 2, 1, 'estudiante'),
(3, 'DFg adfg sadfg sdfg fdgdfg sdf', 2, 1, 2, 'curso'),
(6, 'Es una maravilla de profesor, material excelente. Lo recomiendo 100%', 5, 3, 13, 'curso');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lkw_tagged`
--

CREATE TABLE `lkw_tagged` (
  `id` int(11) NOT NULL,
  `tag_id` int(11) DEFAULT NULL,
  `class` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_entity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lkw_tags`
--

CREATE TABLE `lkw_tags` (
  `id` int(11) NOT NULL,
  `tag` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lkw_typespublications`
--

CREATE TABLE `lkw_typespublications` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `currency_id` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `lkw_typespublications`
--

INSERT INTO `lkw_typespublications` (`id`, `name`, `currency_id`, `price`) VALUES
(1, 'Gratis 30 días', 1, 0),
(2, 'Free 30 days', 2, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lkw_user`
--

CREATE TABLE `lkw_user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `facebook_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook_access_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `video` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `timezone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subnews` tinyint(1) DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `province` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `lkw_user`
--

INSERT INTO `lkw_user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`, `name`, `last_name`, `facebook_id`, `facebook_access_token`, `website`, `photo`, `video`, `timezone`, `subnews`, `country`, `province`) VALUES
(1, 'ovelasquez', 'ovelasquez', 'velasquez.oscar@gmail.com', 'velasquez.oscar@gmail.com', 1, NULL, '$2y$13$JCFbwBVcQkaxuiC5h1Qa9OSmlxElQvso2cDu20Sis0Dn3cU4eAH0W', '2017-07-23 14:40:42', 'EXRN47aL0RTql2dRgJgGwBc4eOi6O6cLvu2V8jUiwtM', '2017-06-14 05:09:06', 'a:1:{i:0;s:12:\"ROLE_USUARIO\";}', 'Oscar Daniel', 'Velásquez', NULL, NULL, 'http://oscar.somostinn.net', 'cc318c92694ddf8a06153a9dc8f5722f.jpeg', 'https://www.youtube.com/embed/MTnVbFxYgAI', NULL, 0, 'VE', 'DI'),
(3, 'mariana', 'mariana', 'marianamff@gmail.com', 'marianamff@gmail.com', 1, NULL, '$2y$13$tYtiVqvQ/HybVYs/KjlzvOWu8z3Xa0WexjBi/quqNdPpFJCnBh/DW', '2017-07-31 07:51:38', 'dQ0m5g9ijDlnFh88IMigpFdOAIuHRTiQXz4Zhev0E_c', '2017-06-12 20:12:32', 'a:1:{i:0;s:12:\"ROLE_USUARIO\";}', 'Mariana', 'Flores', NULL, NULL, 'http://www.zdfgzsdfgzd.tytt', '445d6055dd9022cd81e936e4a34792ec.png', 'http://www.zdfgzsdfgzd.ty', NULL, 1, 'VE', 'DI'),
(7, 'alessandro', 'alessandro', 'oooooo@ooo.cooof', 'oooooo@ooo.cooof', 0, NULL, '$2y$13$2K6Pc1KIz2NCmRJgxlz9d.sdkKVMQJlGpa6/iXaWtDbyIWMop2idG', NULL, 'Gu2ktO1dw_lOk7nJg6wPRSGduV8LbNupSwrnWFNKSHI', NULL, 'a:1:{i:0;s:12:\"ROLE_USUARIO\";}', 'Alessandro', 'Poti', NULL, NULL, 'http://www.zdfgzsdfgzd.tyttf', '406e8cb85d8465f5d74e84480691aec8.jpeg', 'http://www.zdfgzsdfgzd.tyttf', NULL, 0, 'VA', NULL),
(9, 'admin', 'admin', 'mary.programadora@gmail.com', 'mary.programadora@gmail.com', 1, NULL, '$2y$13$myUHMtrcM2ifxqt279OFLu4aYxGs5FHRftzxYOJGbfd4Y5UnWXVqW', '2017-07-31 07:52:40', NULL, NULL, 'a:1:{i:0;s:16:\"ROLE_SUPER_ADMIN\";}', 'Super', 'Admin', NULL, NULL, 'www.letsknow.net', '5b291d09bf640bad845a4ff85679715c.png', NULL, NULL, 1, 'VE', 'DI');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lkw_user_coursecategories`
--

CREATE TABLE `lkw_user_coursecategories` (
  `user_id` int(11) NOT NULL,
  `coursecategory_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `lkw_user_coursecategories`
--

INSERT INTO `lkw_user_coursecategories` (`user_id`, `coursecategory_id`) VALUES
(1, 124),
(1, 125),
(1, 128),
(1, 130),
(1, 134),
(3, 1),
(3, 125),
(3, 130),
(7, 1),
(7, 143);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lkw_user_courses`
--

CREATE TABLE `lkw_user_courses` (
  `course_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `lkw_user_courses`
--

INSERT INTO `lkw_user_courses` (`course_id`, `user_id`, `status`, `id`) VALUES
(9, 1, 0, 7),
(8, 1, 0, 9),
(12, 1, 1, 10),
(13, 3, 1, 14);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `lkw_coursecategories`
--
ALTER TABLE `lkw_coursecategories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lkw_coursecosts`
--
ALTER TABLE `lkw_coursecosts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `currency_id` (`currency_id`);

--
-- Indices de la tabla `lkw_courses`
--
ALTER TABLE `lkw_courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_344380D012469DE2` (`category_id`),
  ADD KEY `IDX_344380D0C54C8C93` (`type_id`),
  ADD KEY `IDX_344380D0A76ED395` (`user_id`),
  ADD KEY `currency_id` (`currency_id`),
  ADD KEY `update-by` (`update_by`) USING BTREE;

--
-- Indices de la tabla `lkw_currency`
--
ALTER TABLE `lkw_currency`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lkw_payments`
--
ALTER TABLE `lkw_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9CF6A287A76ED395` (`user_id`),
  ADD KEY `IDX_9CF6A287591CC992` (`course_id`);

--
-- Indices de la tabla `lkw_reviews`
--
ALTER TABLE `lkw_reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lkw_tagged`
--
ALTER TABLE `lkw_tagged`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8B2ABB0BAD26311` (`tag_id`);

--
-- Indices de la tabla `lkw_tags`
--
ALTER TABLE `lkw_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lkw_typespublications`
--
ALTER TABLE `lkw_typespublications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `currency_id` (`currency_id`);

--
-- Indices de la tabla `lkw_user`
--
ALTER TABLE `lkw_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_6B641EB492FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_6B641EB4A0D96FBF` (`email_canonical`),
  ADD UNIQUE KEY `UNIQ_6B641EB4C05FB297` (`confirmation_token`);

--
-- Indices de la tabla `lkw_user_coursecategories`
--
ALTER TABLE `lkw_user_coursecategories`
  ADD PRIMARY KEY (`user_id`,`coursecategory_id`),
  ADD KEY `IDX_617BC9BCA76ED395` (`user_id`),
  ADD KEY `IDX_617BC9BCAEEF2319` (`coursecategory_id`);

--
-- Indices de la tabla `lkw_user_courses`
--
ALTER TABLE `lkw_user_courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C5378FEF591CC992` (`course_id`),
  ADD KEY `IDX_C5378FEFA76ED395` (`user_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `lkw_coursecategories`
--
ALTER TABLE `lkw_coursecategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;
--
-- AUTO_INCREMENT de la tabla `lkw_coursecosts`
--
ALTER TABLE `lkw_coursecosts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `lkw_courses`
--
ALTER TABLE `lkw_courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `lkw_currency`
--
ALTER TABLE `lkw_currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `lkw_payments`
--
ALTER TABLE `lkw_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `lkw_reviews`
--
ALTER TABLE `lkw_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `lkw_tagged`
--
ALTER TABLE `lkw_tagged`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `lkw_tags`
--
ALTER TABLE `lkw_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `lkw_typespublications`
--
ALTER TABLE `lkw_typespublications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `lkw_user`
--
ALTER TABLE `lkw_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `lkw_user_courses`
--
ALTER TABLE `lkw_user_courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `lkw_coursecosts`
--
ALTER TABLE `lkw_coursecosts`
  ADD CONSTRAINT `fk_currency` FOREIGN KEY (`currency_id`) REFERENCES `lkw_currency` (`id`);

--
-- Filtros para la tabla `lkw_courses`
--
ALTER TABLE `lkw_courses`
  ADD CONSTRAINT `FK_344380D012469DE2` FOREIGN KEY (`category_id`) REFERENCES `lkw_coursecategories` (`id`),
  ADD CONSTRAINT `FK_344380D0C54C8C93` FOREIGN KEY (`type_id`) REFERENCES `lkw_typespublications` (`id`),
  ADD CONSTRAINT `curency_id` FOREIGN KEY (`currency_id`) REFERENCES `lkw_currency` (`id`),
  ADD CONSTRAINT `lkw_courses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `lkw_user` (`id`),
  ADD CONSTRAINT `update_by` FOREIGN KEY (`update_by`) REFERENCES `lkw_user` (`id`);

--
-- Filtros para la tabla `lkw_payments`
--
ALTER TABLE `lkw_payments`
  ADD CONSTRAINT `FK_D268F453591CC992` FOREIGN KEY (`course_id`) REFERENCES `lkw_courses` (`id`),
  ADD CONSTRAINT `FK_D268F453A76ED395` FOREIGN KEY (`user_id`) REFERENCES `lkw_user` (`id`);

--
-- Filtros para la tabla `lkw_tagged`
--
ALTER TABLE `lkw_tagged`
  ADD CONSTRAINT `FK_8B2ABB0BAD26311` FOREIGN KEY (`tag_id`) REFERENCES `lkw_tags` (`id`);

--
-- Filtros para la tabla `lkw_typespublications`
--
ALTER TABLE `lkw_typespublications`
  ADD CONSTRAINT `currency_id` FOREIGN KEY (`currency_id`) REFERENCES `lkw_currency` (`id`);

--
-- Filtros para la tabla `lkw_user_coursecategories`
--
ALTER TABLE `lkw_user_coursecategories`
  ADD CONSTRAINT `FK_617BC9BCA76ED395` FOREIGN KEY (`user_id`) REFERENCES `lkw_user` (`id`),
  ADD CONSTRAINT `FK_617BC9BCAEEF2319` FOREIGN KEY (`coursecategory_id`) REFERENCES `lkw_coursecategories` (`id`);

--
-- Filtros para la tabla `lkw_user_courses`
--
ALTER TABLE `lkw_user_courses`
  ADD CONSTRAINT `FK_C5378FEF591CC992` FOREIGN KEY (`course_id`) REFERENCES `lkw_courses` (`id`),
  ADD CONSTRAINT `FK_C5378FEFA76ED395` FOREIGN KEY (`user_id`) REFERENCES `lkw_user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
