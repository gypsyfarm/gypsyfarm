CREATE TABLE tst_transfer_detail (
  detail_id int(11) NOT NULL auto_increment,
  transfer_amt int(11) NOT NULL,
  item_id_from int(11) NOT NULL,
  item_id_to int(11) NOT NULL,
  transfer_date date default NULL,
   PRIMARY KEY  (detail_id)
) TYPE=MyISAM;


SELECT ci1.item_code, td.transfer_amt,  ci1.warehouse AS warehouse_from, ci2.warehouse AS warehouse_to, ci1.quantity AS from_quantity, ci2.quantity AS to_quantity FROM tst_transfer_detail td, tst_coop_item ci1, tst_coop_item ci2 WHERE td.item_id_from = ci1.item_id AND td.item_id_to = ci2.item_id
