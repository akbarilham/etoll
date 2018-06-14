<?php

namespace App\Utils;

trait Helper {

	public function filter() {
        $body = $_GET;
        $merge_body = [];
        foreach ($body as $key => $value) {
            $exp_post = explode('>', $key);
            if (count($exp_post) >= 2) {
                $merge_body[$exp_post[0]] = array($exp_post[1] => $value);
            } else {
                if ($key == '_token') {
                } else {
                    $merge_body[$key] = $value;
                }
            }
        }
        return $merge_body;
    }

    public function getPostData() {
        $body = $_POST;
        $merge_body = [];
        foreach ($body as $key => $value) {
            $exp_post = explode('>', $key);
            if (count($exp_post) >= 2) {
                $merge_body[$exp_post[0]] = array($exp_post[1] => $value);
            } else {
                if ($key == '_token') {
                } else {
                    $merge_body[$key] = $value;
                }
            }
        }
        return $merge_body;
    }

    public function getSearchOption( $listTableHead )
    {
        $options = [];

        foreach ($listTableHead as $value => $option) {
           $options[$value] = $option['head'];
        }

        return $options;
    }

    public function validateDate($inputDate)
    {
        $date = date('Y-m-d', strtotime( strtr($inputDate, '/', '-')) );
        $tempDate = explode('-', $date);
        return checkdate($tempDate[1], $tempDate[2], $tempDate[0]);
    }

    public function pleaseFixTheMenu($dbResult)
    {

        // echo "<pre>",print_r($dbResult);die();
        $menu = [];

        foreach($dbResult as $key=>$result)
        {
            /* If parent menu */
            if($result->parent_id == '')
            {
                $menu[$result->code] = [];
                
            }

        }

        foreach($dbResult as $key=>$result)
        {
            /* If parent menu */
            if($result->parent_id != '')
            {
                $menu[$result->parent_code][] = [ 'name'=> $result->code, 'route' => $result->file_name ];
                
            }

        }

        return $menu;

    }

    public function in_array_like($needle, $haystack)
    {
        $r = false;
        foreach($haystack as $key=>$val )
        {
            if( strpos($val, $needle) >=0 )
            {
              $r = true;   
            }
        }
        return $r;
    }

    public function in_array_like_reverse($needle, $haystack)
    {
        $r = false;
        foreach($haystack as $key=>$val )
        {
            if( strpos($needle, $val) >=0 )
            {
              $r = true;   
            }
        }
        return $r;
    }

}

?>