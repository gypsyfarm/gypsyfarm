<?php

$system_message = $HTTP_POST_VARS['system_message'];


if ($HTTP_POST_VARS['SUBMIT'] == 'copytotest'){

# connect to database
  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('greenbeans', $db_conn);

  if (!$db_conn)
  {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }



  #1
#  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "truncate table tst_auth;";
  $backup_files = mysql_query($query, $db_conn);

 # $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "insert into tst_auth select * from  auth;";
  $backup_files = mysql_query($query, $db_conn);

  #2
#  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "truncate table tst_coop_commited;";
  $backup_files = mysql_query($query, $db_conn);

#  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "INSERT  INTO tst_coop_commited select *  FROM coop_commited;";
  $backup_files = mysql_query($query, $db_conn);

  #3
#  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "truncate table tst_coop_item;";
  $backup_files = mysql_query($query, $db_conn);

 # $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "INSERT  INTO tst_coop_item select *  FROM coop_item;";
  $backup_files = mysql_query($query, $db_conn);
  
  
    #3A
 # $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "truncate table tst_coop_item_last_maint;";
  $backup_files = mysql_query($query, $db_conn);

#  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "INSERT  INTO tst_coop_item_last_maint select *  FROM coop_item_last_maint;";
  $backup_files = mysql_query($query, $db_conn);


  #4
#  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "truncate table tst_lot_item;";
  $backup_files = mysql_query($query, $db_conn);

 # $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = " INSERT  INTO tst_lot_item select  *  FROM lot_item;";
  $backup_files = mysql_query($query, $db_conn);

  #5
#  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "truncate table tst_order_header;";
  $backup_files = mysql_query($query, $db_conn);

#  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "INSERT  INTO tst_order_header select  *  FROM order_header;";
  $backup_files = mysql_query($query, $db_conn);


  #6
#  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "truncate table tst_order_item;";
  $backup_files = mysql_query($query, $db_conn);

#  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "INSERT  INTO tst_order_item select  *  FROM order_item;";
  $backup_files = mysql_query($query, $db_conn);


  #7
#  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "truncate table tst_coop_warehouse;";
  $backup_files = mysql_query($query, $db_conn);

#  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "INSERT  INTO tst_coop_warehouse select  *  FROM coop_warehouse;";
  $backup_files = mysql_query($query, $db_conn);
  
  
  #8
 # $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "truncate table tst_contact_contact;";
  $backup_files = mysql_query($query, $db_conn);

#  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "INSERT  INTO tst_contact_contact select *  FROM contact_contact;";
  $backup_files = mysql_query($query, $db_conn);  


  #9
 # $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "truncate table tst_contact_notes;";
  $backup_files = mysql_query($query, $db_conn);

 # $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "INSERT  INTO tst_contact_notes select *  FROM contact_notes;";
  $backup_files = mysql_query($query, $db_conn);



  #10
 # $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "truncate table tst_coop_contact;";
  $backup_files = mysql_query($query, $db_conn);

#  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "INSERT  INTO tst_coop_contact select *  FROM coop_contact;";
  $backup_files = mysql_query($query, $db_conn);
  
  
  #11
 # $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "truncate table tst_coop_message;";
  $backup_files = mysql_query($query, $db_conn);

 # $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "INSERT  INTO tst_coop_message select *  FROM coop_message;";
  $backup_files = mysql_query($query, $db_conn);
  
  
    #12
 # $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "truncate table tst_events;";
  $backup_files = mysql_query($query, $db_conn);

 # $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "INSERT  INTO tst_events select *  FROM events;";
  $backup_files = mysql_query($query, $db_conn);
  
  #13
 # $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "truncate table tst_item_description;";
  $backup_files = mysql_query($query, $db_conn);

 # $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "INSERT  INTO tst_item_description select *  FROM item_description;";
  $backup_files = mysql_query($query, $db_conn);
  
  
  
  
  #14
 # $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "truncate table tst_transfer_detail;";
  $backup_files = mysql_query($query, $db_conn);

#  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "INSERT  INTO tst_transfer_detail select *  FROM transfer_detail;";
  $backup_files = mysql_query($query, $db_conn); 
  
    
  
  #15
#  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "truncate table tst_item_yr_balance ;";
  $backup_files = mysql_query($query, $db_conn);

#  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "INSERT  INTO tst_item_yr_balance  select *  FROM coop_item_yr_balance ;";
  $backup_files = mysql_query($query, $db_conn); 
      
    

    #    if ($backup_files ) {
          echo '<font color=red><br>Database files copied to test system! </font> <br>';

   #    }


}   



if ($HTTP_POST_VARS['SUBMIT'] == 'backup'){

# connect to database
  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('greenbeans', $db_conn);

  if (!$db_conn)
  {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }

  #1
#  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "truncate table xbkup_auth;";
  $backup_files = mysql_query($query, $db_conn);

#  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "insert into xbkup_auth select * from  auth;";
  $backup_files = mysql_query($query, $db_conn);

  #2
#  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "truncate table xbkup_coop_commited;";
  $backup_files = mysql_query($query, $db_conn);

#  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "INSERT  INTO xbkup_coop_commited select *  FROM coop_commited;";
  $backup_files = mysql_query($query, $db_conn);

  #3
 # $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "truncate table xbkup_coop_item;";
  $backup_files = mysql_query($query, $db_conn);

#  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "INSERT  INTO xbkup_coop_item select *  FROM coop_item;";
  $backup_files = mysql_query($query, $db_conn);
  
    #3A
# $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "truncate table xbkup_coop_item_last_maint;";
  $backup_files = mysql_query($query, $db_conn);

#  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "INSERT  INTO xbkup_coop_item_last_maint select *  FROM coop_item_last_maint;";
  $backup_files = mysql_query($query, $db_conn);


  #4
 # $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "truncate table xbkup_lot_item;";
  $backup_files = mysql_query($query, $db_conn);

 # $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = " INSERT  INTO xbkup_lot_item select  *  FROM lot_item;";
  $backup_files = mysql_query($query, $db_conn);

  #5
 # $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "truncate table xbkup_order_header;";
  $backup_files = mysql_query($query, $db_conn);

#  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "INSERT  INTO xbkup_order_header select  *  FROM order_header;";
  $backup_files = mysql_query($query, $db_conn);


  #6
 # $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "truncate table xbkup_order_item;";
  $backup_files = mysql_query($query, $db_conn);

#  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "INSERT  INTO xbkup_order_item select  *  FROM order_item;";
  $backup_files = mysql_query($query, $db_conn);


  #7
#  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "truncate table xbkup_coop_warehouse;";
  $backup_files = mysql_query($query, $db_conn);

#  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "INSERT  INTO xbkup_coop_warehouse select  *  FROM coop_warehouse;";
  $backup_files = mysql_query($query, $db_conn);





  #8
#  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "truncate table xbkup_contact_contact;";
  $backup_files = mysql_query($query, $db_conn);

 # $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "INSERT  INTO xbkup_contact_contact select *  FROM contact_contact;";
  $backup_files = mysql_query($query, $db_conn);


  #9
#  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "truncate table xbkup_contact_notes;";
  $backup_files = mysql_query($query, $db_conn);

#  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "INSERT  INTO xbkup_contact_notes select *  FROM contact_notes;";
  $backup_files = mysql_query($query, $db_conn);


  #10
 # $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "truncate table xbkup_coop_contact;";
  $backup_files = mysql_query($query, $db_conn);

 # $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "INSERT  INTO xbkup_coop_contact select *  FROM coop_contact;";
  $backup_files = mysql_query($query, $db_conn);


  #11
#  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "truncate table xbkup_coop_message;";
  $backup_files = mysql_query($query, $db_conn);

 # $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "INSERT  INTO xbkup_coop_message select *  FROM coop_message;";
  $backup_files = mysql_query($query, $db_conn);


  #12
#  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "truncate table xbkup_events;";
  $backup_files = mysql_query($query, $db_conn);

#  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "INSERT  INTO xbkup_events select *  FROM events;";
  $backup_files = mysql_query($query, $db_conn);



  #13
#  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "truncate table xbkup_item_description;";
  $backup_files = mysql_query($query, $db_conn);

# $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "INSERT  INTO xbkup_item_description select *  FROM item_description;";
  $backup_files = mysql_query($query, $db_conn);


  #14
#  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "truncate table xbkup_transfer_detail;";
  $backup_files = mysql_query($query, $db_conn);

#  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "INSERT  INTO xbkup_transfer_detail select *  FROM transfer_detail;";
  $backup_files = mysql_query($query, $db_conn);


  #15
#  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "truncate table xbkup_item_yr_balance ;";
  $backup_files = mysql_query($query, $db_conn);

#  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
  $query = "INSERT  INTO xbkup_item_yr_balance  select *  FROM coop_item_yr_balance ;";
  $backup_files = mysql_query($query, $db_conn); 
    

    #    if ($backup_files ) {
          echo '<font color=red><br>Database backed up! </font> <br>';

   #    }


}

?>