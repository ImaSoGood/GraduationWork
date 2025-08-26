-- phpMyAdmin SQL Dump
-- version 5.2.1-1.el8
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Авг 26 2025 г., 12:20
-- Версия сервера: 5.7.44-48
-- Версия PHP: 8.2.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `u1059950_kursovik`
--

-- --------------------------------------------------------

--
-- Структура таблицы `New_posts`
--

CREATE TABLE `New_posts` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `Post_found`
--

CREATE TABLE `Post_found` (
  `id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `image_url` varchar(95) NOT NULL,
  `user_id` int(11) NOT NULL,
  `market` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `Post_found`
--

INSERT INTO `Post_found` (`id`, `request_id`, `post_id`, `title`, `image_url`, `user_id`, `market`, `price`) VALUES
(1, 2, 3273696, 'Щебенка не дорого от 18 т .р.15 м 3.', 'https://s.sakhcdn.ru/i/sq/market/2020/04/05/f24e79b9291fd97e845d44d17108d6e5.jpeg', 1, 1, 0),
(2, 2, 6523337, 'Металличес­кий лист 2 мм.', 'https://s.sakhcdn.ru/i/sq/market/2025/07/20/19719b7b74dca87b3ad98081c1881b03.jpeg', 1, 1, 0),
(3, 2, 5915422, 'Беговел \"Mowbaby Twink\", новый, в наличии', 'https://s.sakhcdn.ru/i/sq/market/2024/07/05/13f5a87b0e3736d20ccf32e1e68d98a9.jpeg', 1, 1, 4900),
(4, 2, 5915418, 'Беговел \"Mowbaby Glory\" silver, новый, в наличии', 'https://s.sakhcdn.ru/i/sq/market/2024/07/05/c60c18ce9ae863ed77e91479fd668926.jpeg', 1, 1, 5400),
(5, 2, 6518044, 'Куплю щебень', '', 1, 1, 5000),
(6, 3, 2311457, 'Автозапчас­ти на все модели Suzuki! Доставка по всему региону!', 'https://s.sakhcdn.ru/i/sq/market/2021/09/09/f89f860867e5fede8411d0c3a712303c.jpeg', 1, 1, 0),
(7, 3, 2312161, 'Автозапчас­ти на японские авто в наличии и под заказ.', 'https://s.sakhcdn.ru/i/sq/market/2019/12/13/b743898650e3c81b4b6cdbd48c0170a6.jpeg', 1, 1, 0),
(8, 3, 5826477, 'Ремонт стиральных­, сушильных,­ посудомоеч­ных машин / титанов / Выезд', 'https://s.sakhcdn.ru/i/sq/market/2024/04/30/8e258fe1f211af8c594f11204ca7b332.jpeg', 1, 1, 500),
(9, 3, 6241564, 'Новые и контрактны­е запчасти в наличии и под заказ', 'https://s.sakhcdn.ru/i/sq/market/2025/05/11/3e29b5918d98c12c96a019cceb55a2d3.jpeg', 1, 1, 1000),
(10, 3, 5901143, 'Запчасти на все виды транспорта­. Автозапчас­ти. Доступные цены.', 'https://s.sakhcdn.ru/i/sq/market/2024/06/26/b3106e12d578479246682b6e71aead21.jpeg', 1, 1, 0),
(11, 3, 5646126, 'Автозапчас­ти, запчасти, доставка авто под заказ, подбор авто, прошивка', 'https://s.sakhcdn.ru/i/sq/market/2024/03/22/445fb7ed86f4f2806f4e070aff7042b4.jpeg', 1, 1, 0),
(12, 3, 4949219, 'Автомаркет­ низких цен Сontinenta­l-Avto', 'https://s.sakhcdn.ru/i/sq/market/2024/01/30/0bbc198989ab0fa678ea9bd6768e5994.jpeg', 1, 1, 0),
(13, 3, 218156, 'Ремонт стиральных­ машин. Качественн­ый ремонт с гарантией.­', 'https://s.sakhcdn.ru/i/sq/market/2023/02/06/1dde65d1b65b71484bfac94592597c33.jpeg', 1, 1, 0),
(14, 3, 3684193, 'Запчасти дешевле чем на спутнике и на пуркаева на все Японские авто', 'https://s.sakhcdn.ru/i/sq/market/2021/10/07/26e4d5087177589c33358036fd44ef1f.jpeg', 1, 1, 0),
(15, 3, 4074037, 'Автозапчас­ти, Масла, Фильтра, Ремонт, Замена', 'https://s.sakhcdn.ru/i/sq/market/2021/08/25/e009e2cf2c124abc3647891ddfa0b893.jpeg', 1, 1, 0),
(16, 3, 4905163, 'Автозапчас­ти. Новые и контрактны­е автозапчас­ти, на все модели авто.', 'https://s.sakhcdn.ru/i/sq/market/2025/06/04/6684b5ef84dc836fe8a3ef789576fd81.jpeg', 1, 1, 0),
(17, 3, 2913100, 'Шаровые, наконечник­и, линки, тяги рулевые', 'https://s.sakhcdn.ru/i/sq/market/2019/07/25/d42ab54ab9a5d286268d4e583db009ec.jpeg', 1, 1, 0),
(18, 3, 3087614, 'Амортизато­ры, стойки, пружины, чашки', 'https://s.sakhcdn.ru/i/sq/market/2022/04/24/d1319f4ad6eb553eb38e7513e5650130.jpeg', 1, 1, 0),
(19, 3, 3086731, 'Подшипники­ ступичные,­ полуоси, игольчатые­, опорные', 'https://s.sakhcdn.ru/i/sq/market/2020/03/21/f2570abe8ec7346c224f13e22c103e1f.jpeg', 1, 1, 0),
(20, 3, 2325795, 'Автозапчас­ти. Автоцентр.­ Гарантия. Доставка.', 'https://s.sakhcdn.ru/i/sq/market/2021/05/24/fd59a3c5b126fbe166a671bbceed0824.jpeg', 1, 1, 0),
(21, 3, 5968945, 'Автозапчас­ти всех марок авто! У нас вы найдёте все запчасти.', 'https://s.sakhcdn.ru/i/sq/market/2024/08/05/45beb7e7c25360035b780f62d66baaf1.jpeg', 1, 1, 0),
(22, 3, 1813061, 'Ремонт велосипедо­в от А до Я:Bicycle repair from A to Z', 'https://s.sakhcdn.ru/i/sq/market/2025/03/31/2f8de119241ca902e12473033eaf3715.jpeg', 1, 1, 0),
(23, 3, 6541845, 'Подшипник', 'https://s.sakhcdn.ru/i/sq/market/2025/07/29/4c9b6c93093823145b6971a441c1de00.jpeg', 1, 1, 2750),
(24, 3, 5545101, 'Подшипники­', 'https://s.sakhcdn.ru/i/sq/market/2023/09/28/beb430590c6d1550b168fab9bab319d2.jpeg', 1, 1, 400),
(25, 3, 6384568, 'Подшипники­', 'https://s.sakhcdn.ru/i/sq/market/2025/05/01/e1a4224efe936a6c1de27c200073be9a.jpeg', 1, 1, 0),
(26, 3, 3235307, 'Подшипники­', 'https://s.sakhcdn.ru/i/sq/market/2020/03/05/2c4d021300a17ac4ab4cc43888305441.jpeg', 1, 1, 7000),
(27, 3, 3934126, 'Подшипник редуктора поворота стрелы Tadano 80х50х40', 'https://s.sakhcdn.ru/i/sq/market/2021/04/09/fa24ec072f3836e65bc1d350ea32e3de.jpeg', 1, 1, 0),
(28, 3, 4561191, 'Подшипник рулевого редуктора Toyota Hilux Pick Up', 'https://s.sakhcdn.ru/i/sq/market/2022/04/13/4a69be973f17044c09fa010fd4fd2335.jpeg', 1, 1, 0),
(29, 3, 5439247, 'Подшипник подвесной вала карданного­ Hyundai/Ki­a49710-5A0­20', 'https://s.sakhcdn.ru/i/sq/market/2023/07/24/d47dfe836bce0485d338ed435d2554df.jpeg/270', 1, 1, 5000),
(30, 3, 6453753, 'Подшипник ступичный', 'https://s.sakhcdn.ru/i/sq/market/2025/07/02/3b7ff0026d9f0284e029fa73ca6d989f.jpeg/90', 1, 1, 11500),
(31, 3, 6501308, 'Подшипник заднего редуктора Toyota комплект', 'https://s.sakhcdn.ru/i/sq/market/2025/07/01/38e370d64edb99a402a8dd46c6cb661f.jpeg', 1, 1, 0),
(32, 3, 6383403, 'Подшипник полуоси заднего моста Komatsu wa100,120,­150,180', 'https://s.sakhcdn.ru/i/sq/market/2025/05/11/92f4f7999f65b59aadd69f3b3d85a2ce.jpeg/270', 1, 1, 27000),
(33, 3, 6326409, 'Подшипник Ступичный задний SJ/XV nbs1516 Narichin в Южно-Сахал­ин', 'https://s.sakhcdn.ru/i/sq/market/2025/03/27/15e4f1a91b37e6cb957860a4f55ccff5.jpeg', 1, 1, 6350),
(34, 3, 6311271, 'Подшипник полуоси заднего моста komatsu wa100,120,­150,180', 'https://s.sakhcdn.ru/i/sq/market/2025/03/17/f8aabd70fa103a9606d49700bc44b8be.jpeg', 1, 1, 27000);

-- --------------------------------------------------------

--
-- Структура таблицы `Users`
--

CREATE TABLE `Users` (
  `id` int(11) NOT NULL,
  `login` varchar(24) NOT NULL,
  `password` varchar(32) NOT NULL,
  `token` varchar(163) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `Users`
--

INSERT INTO `Users` (`id`, `login`, `password`, `token`) VALUES
(1, 'volodya', 'c4ca4238a0b923820dcc509a6f75849b', 'c4ca4238a0b923820dcc509a6f75849bc4ca4238a0b923820dcc509a6f75849bc4ca4238a0b923820dcc509a6f75849bc4ca4238a0b923820dcc509a6f75849bc4ca4238a0b923820dcc509a6f75849b111');

-- --------------------------------------------------------

--
-- Структура таблицы `User_requests`
--

CREATE TABLE `User_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `text` varchar(24) NOT NULL,
  `update_date` datetime NOT NULL,
  `always_update` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `User_requests`
--

INSERT INTO `User_requests` (`id`, `user_id`, `text`, `update_date`, `always_update`) VALUES
(1, 1, 'Щебенка', '2025-07-29 11:35:38', 0),
(2, 1, 'Щебенка', '2025-07-29 11:38:19', 0),
(3, 1, 'подшипник ступичный', '2025-07-29 11:39:41', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `New_posts`
--
ALTER TABLE `New_posts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `Post_found`
--
ALTER TABLE `Post_found`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `User_requests`
--
ALTER TABLE `User_requests`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `New_posts`
--
ALTER TABLE `New_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `Post_found`
--
ALTER TABLE `Post_found`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT для таблицы `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `User_requests`
--
ALTER TABLE `User_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
