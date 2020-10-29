--
-- Table structure for table tblproduct
--

CREATE TABLE discounts (
  id int(8) NOT NULL,
  product_id int(11),
  percentage int(11)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table tblproduct
--

INSERT INTO discounts (id, product_id, percentage) VALUES
(1, 4, 10);


--
-- Indexes for table tblproduct
--
ALTER TABLE discounts
  ADD PRIMARY KEY (id);
  


--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table tblproduct
--
ALTER TABLE discounts
  MODIFY id int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;