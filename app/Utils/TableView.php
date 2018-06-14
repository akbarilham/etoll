<?php

namespace App\Utils;

use Request;

class TableView {
protected $tableHead;
	protected $tableBody;
	protected $filter;
	protected $edit = true;
	protected $delete = true;
	protected $primaryKey = 'id';

	public function setTableHead($tableHead)
	{
		$this->tableHead = json_decode(json_encode( $tableHead ), false );

	}

	public function setTableBody($tableBody)
	{
		$this->tableBody = $tableBody;
	}
	public function setfilter($filter)
	{
		$this->filter = $filter;
	}
	public function allowEdit($boolean)
	{
		$this->edit = $boolean;
	}
	public function allowDelete($boolean)
	{
		$this->delete = $boolean;
	}
	public function setTableField($tableField)
	{
		$this->tableField = $tableField;
	}
	public function setEmailField($emailField)
	{
		$this->emailField = $emailField;
	}
	public function setPrimaryKey($primaryKey)
	{
		$this->primaryKey = $primaryKey;
	}	
	

	public function buildTable()
	{
		$primaryKey = $this->primaryKey;

		$table = '
		<div class="">
		<div class="data-info">
		
			<h5 class="table-title">Transactions</h5>
			<table class="table table-hover display widget datatable dataTable no-footer dtr-inline" role="grid">
	    
	       	<thead>
	            <tr role="row">';

	            $table .= '<th colspan="1" rowspan="1"> No <th>';

	            if($this->tableHead != null)
	            {
	            	foreach($this->tableHead as $key=>$value)
	            	{
	            		$table .= '<th colspan="1" rowspan="1">'.$value->head.'</th>';
	            	}
	            }

	            $table .= '<th colspan="1" rowspan="1"> Action <th>';
	            


      	$table .= '</tr>
	      	</thead>
	      	<tbody>';
	      	//echo "<pre>", print_r($this->tableBody); die();
	      		if($this->tableBody != null )
	      		{
	      			if(isset($this->currentpage)){
	      			$no = ($this->tableBody->currentPage-1) * $this->tableBody->perpage+1;
	      			}
	      			else{
	      				$no=1;
	      			}	
	      			foreach($this->tableBody as $rowKey=>$row)
	      			{
	      				 $table .= '<tr>';

	      				 $table .= '<td>'.$no.'.<td>';

	      				if($this->tableHead != null && $row !=null)
			            {
			            	foreach($this->tableHead as $headKey=>$head)
			            	{
			            		$table .= '<td>'.$row->$headKey.'</td>';
			            	}
			            

			            $table .= '<td>
			            	<button class="btn btn-sm btn-primary edit link" onclick="doDetail()">Detail</button>
			            	
			            <td>';

			           }else{

			           	foreach($this->tableHead as $headKey=>$head)
			            	{
			            		$table .= '<td>  hw_New_Document(object_record, document_data, document_size)o Data</td>';
			            	}
			            

			            $table .= '<td>
			            	<button class="btn btn-sm btn-primary edit link" onclick="">No Action</button>
			            	
			            <td>';
			           } 	

			            $table .= '</tr>';

			            $no++;
	      			}
	      		}
			$table .= '</tbody>
	  	</table>
	  	</div>
	  	
	  	</div>
	  	';

	  	/* Pagination */
	  	if(isset($this->tableBody->currentpage)){
	  	$currentPage = $this->tableBody->currentPage;
	  	$lastPage = $this->tableBody->lastPage;
	  	$nextPage = $currentPage == $lastPage ? $currentPage : $currentPage + 1;
	  	$previousPage = $currentPage == 1 ? 1 : $currentPage - 1;

	  	$table .= '<ul class="pagination pagination-sm no-margin pull-right">';

	  	$table .= $previousPage == $currentPage ? '' : '<li onclick="setList(\'list\', \''.$previousPage.'\')"><a href="#">«</a></li>';

	  	$lastPage = $lastPage == 1 ? 0 : $lastPage; // prevent display pagination if only have 1 page

	  	for ($i = 1; $i <= $lastPage; $i++) {

	  		if($i == $currentPage)
	  		{	
	  			$table .= '<li class="active" onclick="setList(\'list\', \''.$i.'\')"><a href="#">'.$i.'</a></li>';
	  		}else{
	  			$table .= '<li onclick="setList(\'list\', \''.$i.'\')"><a href="#">'.$i.'</a></li>';
	  		}
		    
		}

		$table .= $nextPage == $currentPage ? '' : '<li onclick="setList(\'list\', \''.$nextPage.'\')"><a href="#">»</a></li>';

		$table .= '</ul>';
		}
		/* Pagination end */

	  	return $table;
	}

}

?>