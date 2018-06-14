<?php

namespace App\Utils;

use Request;
use Illuminate\Support\Facades\Lang;

class TableCustomerCareCheck {

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
	public function setHPField($HPField)
	{
		$this->HPField = $HPField;
	}
	public function setOwnerField($ownerField)
	{
		$this->ownerField = $ownerField;
	}	
	public function setSTNKField($STNKField)
	{
		$this->STNKField = $STNKField;
	}	
	public function setPlatField($platField)
	{
		$this->platField = $platField;
	}
	public function setRangkaField($rangkaField)
	{
		$this->rangkaField = $rangkaField;
	}		
	public function setMesinField($mesinField)
	{
		$this->mesinField = $mesinField;
	}
	public function setMerkKendField($merkKendField)
	{
		$this->merkKendField = $merkKendField;
	}		
	public function setModelKendField($modelKendField)
	{
		$this->modelKendField = $modelKendField;
	}		
	public function setOwnerAddrField($ownerAddrField)
	{
		$this->ownerAddrField = $ownerAddrField;
	}	


	public function buildTable()
	{
		$primaryKey = $this->primaryKey;
		
		$table = '
		<table class="table table-hover">
	       	<thead>
	            <tr>';

	            $table .= '<th> No <th>';

	            if($this->tableHead != null)
	            {
	            	foreach($this->tableHead as $key=>$value)
	            	{
	            		$table .= '<th>'.$value->head.'</th>';
	            	}
	            }
	            
	            	$table .= '<th> Action <th>';
	        	

      	$table .= '</tr>
	      	</thead>
	      	<tbody>';
	      		if($this->tableBody != null)
	      		{
	      			$no = ($this->tableBody->currentpage()-1)*$this->tableBody->perpage()+1;

	      			foreach($this->tableBody as $rowKey=>$row)
	      			{
	      				 $table .= '<tr>';

	      				 $table .= '<td>'.$no.'.<td>';

	      				if($this->tableHead != null)
			            {
			            	foreach($this->tableHead as $headKey=>$head)
			            	{
			            		$table .= '<td>'.$row->$headKey.'</td>';
			            	}
			            }

			            $table .= '<td>';
			            	
		            	$table .= '<button class="btn btn-sm btn-primary edit link btn-sm-c-1" data-toggle="tooltip" title="'. trans('general.view').'" onclick="doEdit(\'view\', \''.$row->$primaryKey.'\')"><i class="zmdi zmdi-edit"></i></button>&nbsp;';

			            $table .= '</td>';

			            $table .= '</tr>';

			            $no++;
	      			}
	      		}
			$table .= '</tbody>
	  	</table>
	  	';

	  	/* Pagination */
	  	$currentPage = $this->tableBody->currentPage();
	  	$lastPage = $this->tableBody->lastPage();
	  	$nextPage = $currentPage == $lastPage ? $currentPage : $currentPage + 1;
	  	$previousPage = $currentPage == 1 ? 1 : $currentPage - 1;

	  	/* Total page information */

	  	$table .='<span class="pagination text-muted">'.$lastPage.' Pages in total&nbsp;</span>'; 

	  	$table .= '<ul class="pagination pagination-sm no-margin pull-right">';

	  	$table .= $previousPage == $currentPage ? '' : '<li onclick="setList(\'list\', \''.$previousPage.'\')"><a href="#" data-toggle="tooltip" title="'.trans('general.prev-page').'">«</a></li>';


	  	/* prevent display pagination if only have 1 page; pagination loop if only has more than 1 page */
	  	if($lastPage > 1)
	  	{

	  		/* Pagination Core Loop goes here */
		  	$spareNext = ($lastPage - $currentPage) > 3 ? $currentPage + 3 : ($currentPage + ($lastPage - $currentPage));

	  		$sparePrev = $currentPage > 3 ? $currentPage - 3 : 1 ;

	  		for ($i = $sparePrev; $i <= $spareNext; $i++) {

		  		if($i == $currentPage)
		  		{	
		  			$table .= '<li class="active" onclick="setList(\'list\', \''.$i.'\')"><a href="#">'.$i.'</a></li>';
		  		}else{
		  			$table .= '<li onclick="setList(\'list\', \''.$i.'\')"><a href="#" data-toggle="tooltip" title="'.trans('general.page').$i.'">'.$i.'</a></li>';
		  		}
			    
			}
			/* Pagination Core Loop ends here */

	  	}

		$table .= $nextPage == $currentPage ? '' : '<li onclick="setList(\'list\', \''.$nextPage.'\')"><a href="#" data-toggle="tooltip" title="'.trans('general.next-page').'">»</a></li>';

		$table .= '</ul>';

		/* Pagination end */

		/* Table script */

		$table .= '<script>
			$(\'[data-toggle="tooltip"]\').tooltip(); 
		</script>';

	  	return $table;
	}

}

?>