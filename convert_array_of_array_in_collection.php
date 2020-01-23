<?php
$response['comissionados']  = collect($this->apiGetAllComissoesFuncionarios())->map(function ($comissionado) {
    return (object) $comissionado;
});