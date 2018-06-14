<?php

namespace App\Utils;

use Request;
use Illuminate\Support\Facades\Lang;

class TablePlaza {

	protected $tableHead;
	protected $tableBody;
	protected $filter;
	protected $view = true;
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
	public function allowView($boolean)
	{
		$this->view = $boolean;
	}	
	public function setTableField($tableField)
	{
		$this->tableField = $tableField;
	}
	public function setPrimaryKey($primaryKey)
	{
		$this->primaryKey = $primaryKey;
	}
	public function setTableGate($dataGate)
	{
		$this->dataGate = $dataGate;
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
	      			$no = ($this->tableBody->currentPage-1) * $this->tableBody->perpage+1;

	      			foreach($this->tableBody->body as $rowKey=>$row)
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

			            $datak = json_decode(json_encode($row), true);
			            $datas = implode($datak, "|");

			        	$arraydata = (array) $row;
			            $datadel = array_keys($arraydata);

			            $search = "";
			            $searchby = ""; 
			            $perpage  = $this->tableBody->perpage;
			            // $page = $this->tableBody->currentPage;
			            $page = 1;

			            	if($this->view == true)
				            {
				            	$table .= '<button class="btn btn-sm btn-success view link btn-sm-c-1" data-toggle="tooltip" title="'. trans('general.list').'" onclick="doViews(\'view\', \''.$row->$primaryKey.'\', \''.$search.'\', \''.$searchby.'\', \''.$perpage.'\', \''.$page.'\')"><i class="zmdi zmdi-view-list-alt"></i></button>&nbsp;';
				            }			            	
			            	if($this->edit == true)
				            {
				            	$table .= '<button class="btn btn-sm btn-primary edit link btn-sm-c-1" data-toggle="tooltip" title="'. trans('general.edit').'" onclick="doViewTotal(\'viewtotal\', \''.$row->$primaryKey.'\', \''.$datas.'\')"><i class="zmdi zmdi-edit"></i></button>&nbsp;';
				            }
				            if($this->delete == true)
				            {
				            	$table .= '<button class="btn btn-sm btn-danger delete link btn-sm-c-1" data-toggle="tooltip" title="'. trans('general.delete').'" _token="'.csrf_token().'" onclick="doDeletes($(this),\''.Request::url().'/mydelete'.'\', \''.$row->$primaryKey.'\', \''.$datadel[0].'\')"><i class="zmdi zmdi-delete"></i></button>';
				            }

			            $table .= '</td>';

			            $table .= '</tr>';

			            $no++;
	      			}
	      		}
			$table .= '</tbody>
	  	</table>
	  	';

	  	/* Pagination */
	  	$currentPage = $this->tableBody->currentPage;
	  	$lastPage = $this->tableBody->lastPage;
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