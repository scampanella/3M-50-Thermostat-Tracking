<?php
require "config.php";
require "lib/t_lib.php";

// pChart library inclusions
include( "lib/pChart2.1.3/class/pData.class.php" );
include( "lib/pChart2.1.3/class/pDraw.class.php" );
include( "lib/pChart2.1.3/class/pImage.class.php" );

function bobby_tables()
{
  $filename = "./images/exploits_of_a_mom.png";
  $handle = fopen( $filename, "r" );
  $contents = fread( $handle, filesize($filename) );
  fclose( $handle );
  echo $contents;
}

function connect_to_db()
{
  // Using the keyword global really points out that this might be a bad idea.  Should these be buried in a class for safety?
  global $host;
  global $user;
  global $pass;
  global $db;
  global $link;
  $link = mysql_connect( $host, $user, $pass );
  if( !$link )
  {
    die( "Could not connect: <no error message provided to hackers>"  );
  }
  mysql_select_db( $db, $link ) or die( "cannot select DB" );            // Really should log this?

  global $timezone;
  mysql_query( "SET time_zone = '$timezone'" );
}

function disconnect_from_db()
{
  global $link;
  mysql_close( $link );
}

function validate_date( $some_date )
{
  $date_pattern = "/[2]{1}[0]{1}[0-9]{2}-[0-9]{2}-[0-9]{2}/";
  if( !preg_match( $date_pattern, $some_date ) )
  {
    bobby_tables();
    return false;
  }
  return true;
}


// Common code that should run for EVERY page follows here

global $timezone;
date_default_timezone_set( $timezone );


?>