<?php
    function listObject2Json($listObj){
        $json = '';
        foreach($listObj as $obj){
            $json .= $obj->toJson();
            $json .= ',';
        }
        $json = substr($json, 0, -1);
        return '['.$json.']';
    }
?>