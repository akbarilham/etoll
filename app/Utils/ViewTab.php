<?php

namespace App\Utils;

use Request;
use Illuminate\Support\Facades\Lang;

class ViewTab {

	protected $tableHead;
	protected $tableBody;
	protected $filter;
	protected $edit = true;
	protected $delete = true;
	protected $disabled = true;


	public function setTableHead($tableHead)
	{
		$this->tableHead = json_decode(json_encode( $tableHead ), false );

	}
	public function setTabDisabled($disabled){
		$this->disabled = $disabled;
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


	public function buildTable($check_point)
	{
		$table = '
		<table class="table table-hover">
	       	<thead>
	            <tr>';

	            $table .= '<th> No <th>';

	            $table .= '<th> # <th>';

	            if($this->tableHead != null)
	            {
	            	foreach($this->tableHead as $key=>$value)
	            	{
	            		$table .= '<th>'.$value->head.'</th>';
	            	}
	            }

	            ///$table .= '<th> Action <th>';

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

	      				 if($check_point==$row->customer_info_id){
	      				 	$table .= '<td><input type="radio" name="gone" onclick="cekIDInfo(\''.$row->customer_info_id.'\')" CHECKED/"><td>';
	      				 }
	      				 else
	      				 $table .= '<td><input type="radio" name="gone" onclick="cekIDInfo(\''.$row->customer_info_id.'\')"><td>';

	      				if($this->tableHead != null)
			            {
			            	foreach($this->tableHead as $headKey=>$head)
			            	{
			            		$table .= '<td>'.$row->$headKey.'</td>';
			            	}
			            }

			            $table .= '<td>';
			            	
			            	// if($this->edit == true)
				            // {
				            // 	$table .= '<button class="btn btn-sm btn-primary edit link btn-sm-c-1" data-toggle="tooltip" title="'. trans('general.edit').'" onclick="doEdit(\'edit\', \''.$row->customer_info_id.'\')"><i class="zmdi zmdi-edit"></i></button>&nbsp;';
				            // }
				            // if($this->delete == true)
				            // {
				            // 	// $table .= '<button class="btn btn-sm btn-danger delete link btn-sm-c-1" data-toggle="tooltip" title="'. trans('general.delete').'" _token="'.csrf_token().'" onclick="doDelete($(this),\''.Request::url().'/delete'.'\', \''.$row->customer_info_id.'\')"><i class="zmdi zmdi-delete"></i></button>';
				            // }

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


public function buildTableMaster($check_point)
	{
		            if($this->tableHead != null)
	            {
	            	$table='';
	            	$table .= '<div class="m-b-20">';
	            	$table .= '<ul class="nav nav-tabs">';
	            	$count=1;
	            	
	            	foreach ($this->tableHead as $key => $value) {
	            		
                        
                       if($count==1){
	            		//print_r($value->tableName);
	            		$table .= '<li class="active">';
	            		$table .= '<a href="#tab-'.$count.'" data-toggle="tab" aria-expanded="true">'.$value->tableName.'</a>';
	            		$table .= '</li>';

	            		}
	            		else{
	            		$table .= '<li class="">';
	            		$table .= '<a href="#tab-'.$count.'" data-toggle="tab" aria-expanded="true">'.$value->tableName.'</a>';
	            		$table .= '</li>';
						}
						$count++;		
					}		
					$table .= '</ul>';
					$table .= '<div class="tab-content">';
	            	$count=1;
	            	
	            	if($this->tableBody != null)
			      		{
			      			foreach ($this->tableBody as $keya => $valuea) {
			      				
				      			foreach ($this->tableHead as $key => $value) {
				            		
				            		if($count==1)
				            		{
				            			$table .= '<div class="tab-pane fade active in" id="tab-'.$count.'">';
				            	 	}
				            	 	else
				            	 	{
				            	 		$table .= '<div class="tab-pane fade" id="tab-'.$count.'">';
				            	 	}
				            	 	$res=((array)$value);
					            	
				            	 	foreach ($valuea[$key] as $k => $v) {
				            	 		$cch=0;
					            	 		
					            		foreach ($v as $cc => $vl) {
					            			
					            			$table .= '<div class="form-group col-md-6">';
				                            $table .=   '<label for="last_name">'.$res['head'][$cch].'</label>'; 
											if($this->disabled == false)
												$table .=   '<input type="text" id="'.$res['id'][$cch].'" class="form-control" value="'.$vl.'" id="inputText" placeholder="Some text here">';
											else
												$table .=   '<input type="text" id="'.$res['id'][$cch].'" class="form-control" value="'.$vl.'" id="inputText" placeholder="Some text here" disabled>';	
				                         	$table .= '</div>';
					            			//print_r($vl);
					            			$cch++;
					            		}
					            	}
				            	 	 	
					            	
				            		$table .= '</div>';
				            		$count++;		
				            		
				            	}
			      			}
			      			
			      	}
	            	
	            	$table .= '</div>';
	            	
	            	$table .= '</div>';

	            	
	            }
		

	  	return $table;
	}

public function ret(){
	//       		foreach ($value->head as $rr => $val) {
	      //       			// $table .= '<div class="form-group col-md-6">';
       //          //             $table .=   '<label for="last_name">'.$val.'</label>';
							// $table .=   '<input type="text" class="form-control" id="inputText" placeholder="Some text here">';            
       //                      $table .= '</div>';
       //                      continue;
	      //       		}
}


}

?>