<?php
use Illuminate\Support\Facades\DB;

function d($arr) {
    echo "<pre>";print_r($arr);echo "</pre>";die;
}

function isAdmin() {
    if(Auth::user()->role=='admin') {
        return true;
    }
    return false;
}