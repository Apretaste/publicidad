--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `id` int(11) NOT NULL,
  `owner` char(100) NOT NULL,
  `icon` varchar(10) DEFAULT NULL,
  `title` varchar(40) NOT NULL,
  `description` varchar(500) NOT NULL,
  `image` varchar(40) DEFAULT NULL,
  `clicks` int(7) NOT NULL DEFAULT '0',
  `impressions` int(7) NOT NULL DEFAULT '0',
  `expires` timestamp NULL DEFAULT NULL,
  `inserted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `paid` tinyint(1) NOT NULL DEFAULT '1',
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
