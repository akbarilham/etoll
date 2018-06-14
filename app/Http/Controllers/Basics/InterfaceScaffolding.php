<?php
namespace App\Http\Controllers\Basics;
use Illuminate\Http\Request;

interface InterfaceScaffolding
{

    public function setIndex();

    public function setList();

    public function setNew();

    public function setEdit();

    public function save(Request $request);

    public function update(Request $request);

    public function delete();

    public function getIndexData();

    public function getListData();

    public function getNewData();

    public function getEditData();

}

?>