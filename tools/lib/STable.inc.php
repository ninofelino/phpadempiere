<?php

/* ---------------------------------------------------------------------------------
   STable Definition
   Copyright 2011 Jim Williams
   Licensed under the lesser GNU copyright as defined at gnu.org/licenses/lgpl.html
   --------------------------------------------------------------------------------- */

class STable {
   
  private $_keys; // The table's column names
  private $_rows; // Rows of the table
   
   // Construct a table from table rows or construct an emptable from a list of column names
	function __construct($x) {
		if (!isset($x) || !isset($x[0]))
		throw new exception ('new STable: constructor accepts only rows or column names');
		if (is_array($x[0])) { // table rows
			$this->_keys = array_keys($x[0]);
			foreach ($x as $row)
				if (array_keys($row) != $this->_keys)
				throw new exception ('new STable: Not all rows have the same column names.');
			$this->_rows = $x;
		} else { // table columns
			foreach ($x as $key)
				if (!is_string($key))
					throw new exception ('new STable: column namew must be strings.');
			$this->_keys = $x;
			$this->_rows = array();
		}
	}
	
	function rows() { 
		return $this->_rows;
	} 
   
	function columnNames() {
		return $this->_keys;
	}
	
	function export() {
		if ($this->_rows == array()) 
			return $this->_keys;
		else
			return $this->_rows;
	}

   // Append the rows to the table
	function append($newRows) { 
		$rslt = new STable($this->_keys);
		$rslt->_rows = $this->_rows;
		foreach ($newRows as $row){
			if ($this->_keys != array_keys($row))
				throw new Exception('STable::append: Not all rows have correct column names.');
			$rslt->_rows[] = $row;
		}
      return $rslt;
 }
   
   // Remove rows that don't satisfy the filter.
	function select($filter) {
		$rslt = new STable($this->_keys);
		$rslt->_rows = array_values(array_filter($this->_rows, $filter));
		return $rslt;
	}
   
   // Remove rows that do satisfy the filter.
   function sanitize($filter) {
		$negFilter = function($arg) use ($filter) {
			return !$filter($arg);
		};  	
 		$rslt = new STable($this->_keys);
		$rslt->_rows = array_values(array_filter($this->_rows, $negFilter));
		return $rslt;
   }
   
	function selectWhere($expr) {
		$tester = function($row) use ($expr) {
			extract($row);
			return eval('return' . $expr . ';');
		};
		$rslt = new STable($this->_keys);
		$rslt->_rows = array_values(array_filter($this->_rows, $tester));
		return $rslt;
   }

   // Order the rows of $tbl according to their $field values.
	function orderBy($fields) {
 		$rslt = new STable($this->_keys);
		if (is_string($fields)) $fields = array($fields);
		$lexOrder = function($a, $b) use ($fields) {
			foreach ($fields as $field) {
				if ($a[$field] < $b[$field]) return -1;
				if ($a[$field] > $b[$field]) return 1;
			}
			return 0;
		};
      $rslt->_rows = $this->_rows;
      usort($rslt->_rows, $lexOrder);
      return $rslt;
   }

   // remove duplicate entries in a table or other array.
	function removeDuplicates() {
 		$rslt = new STable($this->_keys);
		$rslt->_rows = $this->_rows;
		$count = count($rslt->_rows);
		for ($i = 0; $i<$count-1; $i++)
			if (isset($rslt->_rows[$i]))
				for ($j = $i+1; $j<$count; $j++) 
					if (isset($rslt->_rows[$j]) && $rslt->_rows[$j] == $rslt->_rows[$i]) 
						unset($rslt->_rows[$j]);
		$rslt->_rows = array_values($rslt->_rows);
		return $rslt;
   }
   
   // Select named columns and arrange as ordered in $clns.
	function selectColumns($clns) {
		if (is_string($clns)) $clns = array($clns);
		$rslt = new STable($clns);
		$keys = $this->_keys;
		foreach ($clns as $cln)
			if (!in_array($cln, $keys, true)){
				$exception = 'rsTable::selectColumns: Undefined column name \''.$cln.'\' in new-fields array. ';
				throw new exception($exception);
			}
		$newRows = array();
		$rows = $this->_rows;
		foreach ($rows as $row) {
			$newRow = array();
			foreach ($clns as $cln) {
				$newRow[$cln] = $row[$cln];
			}
			$newRows[] = $newRow;
		}
		$rslt->_rows = $newRows;
		return $rslt;
	}

   // Compute new columns as described in $re.
	function columnMap($re) {
		$newRows = array();
		$rows = $this->_rows;
		foreach ($rows as $row) {
			$newRow = array();
			foreach ($re as $id=>$expr){
				$tmp = STable::localEval($expr, $row); // No error detection protocol!
				$newRow[$id] = $tmp;
			}
			$newRows[] = $newRow;
		}
		$rslt = new STable($this->_keys);
		$rslt->_rows = $newRows;
		return $rslt;
	}

   private static function localEval($expr, $r) {
      extract($r);
      return eval('return' . $expr . ';');
   }

	function naturalJoin($tbl2) {
		$keys1 = $this->_keys; $keys2 = $tbl2->_keys;
		$rows1 = $this->_rows; $rows2 = $tbl2->_rows;
		$duplicates = array();
		foreach ($keys1 as $key1)
			foreach ($keys2 as $key2)
				if ($key1 == $key2) $duplicates[] = $key1;
		$rsltKeys = $keys1;
		foreach ($keys2 as $key2)
			if (array_search($key2, $duplicates, true) === false)
				$rsltKeys[] = $key2;
		$rsltRows = array();
		foreach ($rows1 as $row1)
			foreach ($rows2 as $row2) {
				$keep = true;
				foreach ($duplicates as $key)
					if ($row1[$key] != $row2[$key]) 
						$keep = false;
			if ($keep) {
				$rsltRows[] = $row1 + $row2;
			}
		}
		$rslt = new STable($rsltKeys);
		$rslt->_rows = $rsltRows;
		return $rslt;
 }

   /* Mini-Section on aggregate functions
      ----------------------------------- */
   
   // $clnName is the name of a numeric column in a table.
   // sum($cln) is the aggregate function that sums all of the values in the named column
   static function sum($cln) {
      return function($tbl) use ($cln) {
         $sum = 0;
         $rows = $tbl->rows();
         foreach ($rows as $row) $sum += $row[$cln];
         return $sum;
      };
   }

   // Make count into a function-valued function for compatibility with the above sum function
   static function sCount() { 
      return function($tbl) { return count($tbl->rows()); };
   }

   /* End Mini-Section
      ----------------------------------- */
   
	function regroup($clns, $aggregates) {
		if (is_string($clns)) $clns = array($clns);
		$tbl = $this->orderBy($clns);
		$rows = $tbl->_rows;
		$i = 0; $newRows = array();
		while ($i < count($rows)) {
			$subTbl = array($rows[$i]); // always at least one row
			$j = $i + 1;
			while ($j < count($rows)) {
				foreach ($clns as $cln) 
					if ($rows[$j][$cln] != $rows[$i][$cln]) break 2;
				$subTbl[] = $rows[$j];
				$j = $j + 1;
			}
			$subTbl = new STable($subTbl);
			$row = array();
			foreach ($clns as $cln)
				$row[$cln] = $rows[$i][$cln]; // first items
			foreach ($aggregates as $id=>$g)
				$row[$id] = $g($subTbl);
			$newRows[] = $row;
			$i = $j;
		}
		$rslt = new STable(array_merge($clns, array_keys($aggregates)));
		$rslt->_rows = $newRows;
		return $rslt;
	}




} // End STable
   
?>