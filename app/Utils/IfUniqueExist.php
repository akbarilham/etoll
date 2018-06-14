<?php

namespace App\Utils;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IfUniqueExist {

	public $allowCheck = false;

	public $tableName;

	public $uniqueKey = 'ID'; //default is ID

	public $uniqueValue;

	public $returnValue = 'notif';

	public $uniqueException = null;

	public function allowCheck( $boolean )
	{
		$this->allowCheck = $boolean;
	}

	public function setTableName( $table )
	{
		$this->tableName = $table;
	}

	public function setUniqueKey( $key )
	{
		$this->uniqueKey = $key;
	}

	public function setUniqueValue( $key )
	{
		$this->uniqueValue = $key;
	}
	public function setReturnValue($returnValue){
		$this->returnValue=$returnValue;
	}
	public function checkAnyData(){
		try {

			if($this->allowCheck == true)
			{

				$query = DB::table( $this->tableName )->where( $this->uniqueKey, '=', $this->uniqueValue )->first();

				/* Unique value already exist */
				return $query;
			}

		}catch(\Exception $e){
			echo $e;
		}
	}
	public function check()
	{
		try {

			if($this->allowCheck == true)
			{

				$query = DB::table( $this->tableName )->where( $this->uniqueKey, '=', $this->uniqueValue )->first();

				/* Unique value already exist */
				if(count( $query ) > 0) 
				{
					if($this->returnValue == 'notif')
					{
						echo json_encode(['status'=>'error', 'msg'=> ucfirst($this->uniqueKey).' Already exist!']); exit();

					}else{

						return false;
					}

				}
			}

		}catch(\Exception $e){
			echo $e;
		}
		
	}

	/* This is an additional feature which allow to check unique key for UPDATE purpose. this function requires Primary Key as well as it's field name as parameter. This will check whether input unique is SAME with row selected.   */
	public function checkUpdate( $id = [] )
	{
		try{

			if($this->allowCheck == true)
			{
				$uniqueKey = $this->uniqueKey;

				$queryRow = DB::table( $this->tableName )->where( $id )->first();

				if($queryRow->$uniqueKey == $this->uniqueValue)
				{
					
					return true;

				}else{
					
					$query = DB::table( $this->tableName )->where( $this->uniqueKey, '=', $this->uniqueValue )->first();

					/* Unique value already exist */
					if(count( $query ) > 0) 
					{
						if($this->returnValue == 'notif')
						{
							echo json_encode(['status'=>'error', 'msg'=> ucfirst($this->uniqueKey).' Already exist!']); exit();

						}else{

							return false;
						}

					}

				}

			}

		}catch(\Exception $e){
			echo $e;
		}
		
	}

}