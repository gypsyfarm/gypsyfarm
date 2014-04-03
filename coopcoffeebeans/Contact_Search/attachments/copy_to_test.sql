truncate table tst_coop_commited;
INSERT  INTO tst_coop_commited select *  FROM coop_commited;

truncate table tst_coop_item;
INSERT  INTO tst_coop_item select *  FROM coop_item;


truncate table tst_lot_item;
INSERT  INTO tst_lot_item select  *  FROM lot_item;

truncate table tst_order_header;
INSERT  INTO tst_order_header select  *  FROM order_header;

truncate table tst_order_item;
INSERT  INTO tst_order_item select  *  FROM order_item;

truncate table tst_coop_warehouse;
INSERT  INTO tst_coop_warehouse select  *  FROM coop_warehouse;

truncate table tst_transfer_detail;
INSERT  INTO tst_transfer_detail select  *  FROM transfer_detail;

