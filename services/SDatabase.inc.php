<?php

/* ---------------------------------------------------------------------------------
   SDatabase Definition
   Copyright 2011 Jim Williams
   Licensed under the lesser GNU copyright as defined at gnu.org/licenses/lgpl.html
   --------------------------------------------------------------------------------- */

class SDatabase {

   // Open the named file and do a json_decode of its contents.
   // Create components $this->data and $this->fileName.
   function __construct ($fileName) {
      $this->fileName = $fileName;
      if ($fileName !== "") {
         $contents = @file_get_contents($fileName);
         if (is_string($contents)) {                      // existing database
            $data = json_decode($contents, true);  // represent JSON objects as associative arrays
            if ($data === NULL) 
               throw new exception('new rsDatabase: JSON - '.SDatabase::json_error().' in file \''.$fileName.'\'. '); 
            if (typeOf($data) !== "object" && $data != array()) 
               throw new exception('new rsDatabase: Corrupted database in file \''.$fileName.'\'. ');
            $this->data = $data;
         } else {                                     // $contents === false, new database
            $this->data = array();
   		      $data = json_encode($this->data);
            if (!$data) 
               throw new exception('new rsDatabase: Error creating new JSON string'); // impossible?
            $tmp = @file_put_contents($this->fileName, $data);
            if (!$tmp) 
               throw new exception ('new rsDatabase: Cannot write to file \''.$fileName.'\'. ');
         }
      } else
         $this->data = array();                     // new temporary in-memory database
   }
   
   // Save the database using its stored file name.
   function save() {
      if (func_num_args() > 0)
         throw new exception('rsDatabase::save: This method takes no arguments.');
   		$data = json_encode($this->data);                  // This is reasonably goof proof
      if (!$data) 
         throw new exception('rsDatabase::save: Error creating JSON string. '); 
      $tmp = @file_put_contents($this->fileName, $data, LOCK_EX);
      if (!$tmp) 
         throw new exception ('rsDatabase::save: Cannot write to file \''.$this->fileName.'\'. ');
   }

    // Save a copy of the database in the named file without changing the file associated with the database
    function savepoint($fileName) {
   		 $data = json_encode($this->data);
       if (!$data) 
          throw new exception('rsDatabase::save: Error creating JSON string. '); 
       $tmp = @file_put_contents($fileName, $data, LOCK_EX);
       if (!$tmp) 
          throw new exception ('rsDatabase::save: Cannot write to file \''.$fileName.'\'. ');
   }
   
   // Delete a saved database or other file 
   function release($fileName) {
      if (is_dir($fileName))
         throw new exception ('rsDatabase::release: File \''.$fileName.'\' is a directory!');
      $tmp = @unlink($fileName);
      if (!$tmp)
         throw new exception ('rsDatabase::release: Unable to unlink file \''.$fileName .'\'. ');
   }
      
   // Restore the contents of the database from the named file without changing the file name associated with the database.
   function rollback($fileName) {
      if ($fileName !== "") {
         $contents = @file_get_contents($fileName);
         if (is_string($contents)) {                      // existing database
            $data = json_decode($contents, true);  // represent JSON objects as associative arrays
            if ($data === NULL) 
               throw new exception('new rsDatabase: JSON - '.SDatabase::json_error().' in file \''.$fileName.'\'. '); 
            if (typeOf($data) !== "object" && $data != array()) 
               throw new exception('new rsDatabase: Corrupted database in file \''.$fileName.'\'. ');
            $this->data = $data;
         } else {                                     // $contents === false, new database
            $this->data = array();
   		      $data = json_encode($this->data);
            if (!$data) 
               throw new exception('new rsDatabase: Error creating new JSON string'); // impossible?
            $tmp = @file_put_contents($this->fileName, $data);
            if (!$tmp) 
               throw new exception ('new rsDatabase: Cannot write to file \''.$fileName.'\'. ');
         }
      } else
         $this->data = array();                     // new temporary in-memory database
   }
   
/* UTILITY ROUTINES -------------------------------------------------- */
   
   private function json_error() {
      switch (json_last_error()) {
         case JSON_ERROR_NONE:
            return 'empty or null contents';
            break;
         case JSON_ERROR_DEPTH:
            return 'maximum stack depth exceeded';
            break;
         case JSON_ERROR_STATE_MISMATCH:
            return 'underflow or modes mismatch';
            break;
         case JSON_ERROR_CTRL_CHAR:
            return 'unexpected control character found';
            break;
         case JSON_ERROR_SYNTAX:
            return 'syntax error';
            break;
         case JSON_ERROR_UTF8:
            return 'malformed UTF-8 character found';
            break;
         default:
            return 'Unknown error';
            break;
      }
   }
      
} // end of class SDatabase

   function typeOf($a) {
     if (!isset($a)) return "undefined";
     if (is_null($a)) return "null";
     if (is_array($a)) {
       if (count($a) === 0) return "object";    // empty array arbitrarily treated as an object
       if (is_string(key($a))) return "object"; // associative array object
       return "array";                          // nonempty array
     }
     if (is_string($a)) return "string";
     if (is_numeric($a)) {
        if (is_integer($a)) return "integer"; // an integer not in floating point format
	      if (fmod($a, 1) == 0) return "integer"; // an integer in floating point format
        return "number";  // numeric and not a string
     }
     if (is_bool($a)) return "boolean"; 
     return "unknown";
   }

?>