--
-- Table structure for table tblproduct
--

CREATE TABLE products (
  id int(8) NOT NULL,
  name varchar(255) NOT NULL,
  price double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table tblproduct
--

INSERT INTO products (id, name, price) VALUES
(1, 'T-shirt', 10.99),
(2, 'Pants', 14.99),
(3, 'Jacket', 19.99),
(4, 'Shoes', 24.99);



--
-- Indexes for table tblproduct
--
ALTER TABLE products
  ADD PRIMARY KEY (id);
  


--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table tblproduct
--
ALTER TABLE products
  MODIFY id int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;