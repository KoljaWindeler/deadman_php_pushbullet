SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `data` (
  `id` int(11) NOT NULL,
  `token` text NOT NULL,
  `trigger_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `data`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
