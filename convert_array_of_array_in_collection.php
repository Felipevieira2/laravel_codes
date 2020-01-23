<?php
$response['comissionados']  = collect($this->apiGetAllComissoesFuncionarios())->map(function ($comissionado) {
    return (object) $comissionado;
});

//fonte : https://stackoverflow.com/questions/54042847/laravel-convert-array-into-eloquent-collection