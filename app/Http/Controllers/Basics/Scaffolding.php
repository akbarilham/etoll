<?php

namespace App\Http\Controllers\Basics;

use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Utils\Table;
use App\Utils\Helper;
use App\Constants\General;
use App\Http\Controllers\Basics\InterfaceScaffolding;

abstract class Scaffolding extends Controller implements InterfaceScaffolding {

	use Helper;

	protected $DBTableName;

	/* Where you put View path*/
	protected $indexView;
	protected $listView;
	protected $newView;
	protected $editView;

	protected $listFilter;
	protected $listTable;
	protected $listTableHead;

	protected $saveBody;
	protected $updateBody;

	protected $primaryKey = 'id';

	//protected $uniqueKey;

	/* URL for api CRUD operations */
	protected $saveAPIUrl;
	protected $updateAPIUrl;
	protected $deleteAPIUrl;

	public function __construct() {

        $this->listTable =  new Table();
      	//$this->uniqueKey = new IfUniqueExist();
    }

    /* Index Scaffolding handles which VIEW to show based on get parameter  */

	public function index(Request $request)
	{	
		if($request->ajax())
		{
			if(isset($_GET[General::index_controller])) /* if scaffolding controller is set */
			{	
				switch($_GET[General::index_controller])
				{
					case 'list' : /* Displaying list */
						return $this->setList();

						break;
					case 'new' : /* Displaying new form */

						return $this->setNew();

						break;
					case 'edit': /* Displaying edit form */

						return $this->setEdit(); 	
					case 'view': /* Displaying edit form */

						return $this->setView(); 							

						break;
					default: /* Displaying default view */

						return $this->setIndex();

				}
			}else{ /* if scaffolding controller is NOT set */

				//return $this->setIndex();
			}

		}else{

			return $this->setIndex();
		}

	}

	/* Display view controller accessed by GET. Displaying index, list, new form and edit form page */

	public function setIndex()
	{	

		$result =  $this->getIndexData();
		$searchby = $this->getSearchOption($this->listTableHead);

		return view( $this->indexView, compact('result', 'searchby') );
	}

	public function setList()
	{
		$result =  $this->getListData();

		$this->listTable->setTableHead($this->listTableHead);
		$this->listTable->setTableBody($result->dataQuery);
		$this->listTable->setFilter($this->listFilter);
		$table = $this->listTable->buildTable(); 
		
		return view( $this->listView, compact('table') );

	}

	public function setNew()
	{
		$result =  $this->getNewData();

		return view( $this->newView, compact('result'));
	}

	public function setEdit()
	{
		$result =  $this->getEditData();

		return view( $this->editView, compact('result') );
	}

	public function setView()
	{
		$result =  $this->getViewData();

		return view( $this->editView, compact('result') );
	}	


	/* Action controller accessed by POST. save, update, delete */

	public function save(Request $request)
    {
        $this->setSaveBody($request);

        try{

            $response = $this->client->post($this->saveAPIUrl,
                    [
                        'json'    => $this->saveBody,
                        'headers' => [
                            'Accept'     => 'application/json',
                            'x-access-token'      => $this->getToken()
                        ]
                    ]
                );

            $responseBody = json_decode($response->getBody());

            if($responseBody->code == 200)
            {
                echo json_encode(['status'=>'success', 'msg'=>'Success adding data!']);
            }else {
                echo json_encode(['status'=>'error', 'msg'=>'Sorry, Failed to add data.']);
            }

        }catch(\Exception $e){
            echo json_encode(['status'=>'error', 'msg'=>'Sorry, Error to add data.']);

        }
        
    }	

	public function update(Request $request)
    {
        $this->setUpdateBody($request);

        try{

            $response = $this->client->post($this->updateAPIUrl,
                    [
                        'json'    => $this->updateBody,
                        'headers' => [
                            'Accept'     => 'application/json',
                            'x-access-token'      => $this->getToken()
                        ]
                    ]
                );

            $responseBody = json_decode($response->getBody());

            if($responseBody->code == 200)
            {
                echo json_encode(['status'=>'success', 'msg'=>'Success update data!']);
            }else {
                echo json_encode(['status'=>'error', 'msg'=>'Sorry, Failed to update data.']);
            }

        }catch(\Exception $e){

            echo json_encode(['status'=>'error', 'msg'=>'Sorry, Error to update data.']);

        }
        
    }

	public function delete()
    {
        $saveBody = $this->getPostData();

        try{

            $response = $this->client->post($this->deleteAPIUrl,
                    [
                        'json'    => [ $this->primaryKey => $saveBody['id']  ],
                        'headers' => [
                            'Accept'     => 'application/json',
                            'x-access-token'      => $this->getToken()
                        ]
                    ]
                );

            $responseBody = json_decode($response->getBody());

            if($responseBody->code == 200)
            {
                echo json_encode(['status'=>'success', 'msg'=>'Success delete data!']);
            }else {
                echo json_encode(['status'=>'error', 'msg'=>'Sorry, Failed to delete data.']);
            }

        }catch(\Exception $e){
        	
            echo json_encode(['status'=>'error', 'msg'=>'Sorry, Error to delete data.']);

        }
    }

}

?>