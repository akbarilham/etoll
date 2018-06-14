<?php

namespace App\Http\Controllers\Pages\customerCare;

use App\Http\Controllers\Basics\Scaffolding;
use App\Constants\ViewPaths;
use App\Utils\Helper;
use Illuminate\Support\Facades\DB;
use App\Utils\TablecustomerCareCheck;
use Illuminate\Http\Request;
use App\Models\customer_CARE;

class customerCareCheckController extends Scaffolding {

    public function __construct() 
    {
        /* Getting  scaffolding list page filter */
        $this->listFilter = $this->filter();

        /* Setting scaffolding database table */
        $this->DBTableName = 'customer';

        /* Setting scaffolding view path */
        $this->indexView = ViewPaths::costumer_care_check_index;
        $this->listView = ViewPaths::costumer_care_check_list;
        $this->editView = ViewPaths::costumer_care_check_view;

        /* Setting column and searchby option that appear on list page  */
        /*
            select_name as key is Required**
            head's value is Required**

            tableName's value is Optional depending on your data soruce method
            tableField's value is Optional depending on your data soruce method
        */
        $this->listTableHead = [
            'last_name'=>[
                'head' => 'Name',
                'tableName' => 'customer',
                'tableField'=> 'last_name',
            ]
        ];

        parent::__construct();

        $this->listTable = new TablecustomerCareCheck();
        $this->listTable->setPrimaryKey('customer_id');
    }


    /* getIndexData must be implemented due to Scaffolding inheritance. it is containing any data required for scaffolding index page. Feel free to add and customize data source and method here. default method is DB Query */

    public function getIndexData()
    {
        $result = new \stdClass();
            
        return $result;
    }


    /* getListData must be implemented due to Scaffolding inheritance. it is containing any data required for scaffolding list page. Feel free to add and customize data source and method here. default method is DB Query */

    public function getListData()
    {   
        $result = new \stdClass();

        if(isset($this->listFilter['search']) && $this->listFilter['search'] != '')
        {

            /* Put listing query with search here.. */

            $searchby = $this->listTableHead[ $this->listFilter['searchby'] ]['tableName'].'.'.$this->listTableHead[ $this->listFilter['searchby'] ]['tableField'];

            $result->dataQuery = DB::table($this->DBTableName)
                                ->where($searchby, 'like', '%'.$this->listFilter['search'].'%')
                                ->paginate($this->listFilter['perpage']);
        }else{

            /* Put listing query without search word here.. */

            $result->dataQuery = DB::table($this->DBTableName)
                                ->paginate($this->listFilter['perpage']);
        }

        return $result;
        
    }


    /* getNewData must be implemented due to Scaffolding inheritance. it is containing any data required for scaffolding new page. Feel free to add and customize data source and method here. default method is DB Query */

    public function getNewData()
    {   
        $result = new \stdClass();
            
        return $result;
        
    }


    /* getEditData must be implemented due to Scaffolding inheritance. it is containing any data required for scaffolding editing page. Feel free to add and customize data source and method here. default method is DB Query */

    public function getEditData()
    {   
        $result = new \stdClass();

        if(isset($_GET['id']) && $_GET['id'] != '')
        {
            $result->dataQuery =  DB::table($this->DBTableName)->where('id', '=', $_GET['id'] )->first();
        }

            return $result;
        
    }


    /* setSaveBody should be implemented due to Scaffolding saving system. it is building Payload data before inserting to database */

    public function setSaveBody()
    {
        $data = $this->getPostData();

        /* Add payload here */
        $body = [

            'name' => isset($data['name']) ? $data['name'] : '',

        ];
        $this->saveBody = $body;
    }


    /* setUpdateBody should be implemented due to Scaffolding updating system. it is building Payload data before updating to database */

    public function setUpdateBody()
    {
        $data = $this->getPostData();

        /* Add payload here */
        $body = [

            /* Row selector. Default is `id` */
            'id' => isset($data['id']) ? $data['id'] : '', 

            'name' => isset($data['name']) ? $data['name'] : '',
        ];

        $this->updateBody = $body;
    }

}

?>