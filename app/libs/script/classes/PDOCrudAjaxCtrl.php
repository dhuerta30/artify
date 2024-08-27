<?php

Class PDOCrudAjaxCtrl {

    public function handleRequest() {
        $instanceKey = isset($_REQUEST["pdocrud_instance"]) ? filter_var($_REQUEST["pdocrud_instance"], FILTER_SANITIZE_STRING) : null;
        
        if(!isset($_SESSION["pdocrud_sess"][$instanceKey])){
            die("La sesión ha caducado. Actualice su página para continuar.");
        }

        $pdocrud = @unserialize($_SESSION["pdocrud_sess"][$instanceKey]);
        if ($pdocrud === false) {
            die("Ocurrió un error. Por favor, inténtelo de nuevo más tarde.");
        }

        $action = isset($_POST["pdocrud_data"]["action"]) ? filter_var($_POST["pdocrud_data"]["action"], FILTER_SANITIZE_STRING) : null;
        $data = isset($_POST["pdocrud_data"]) ? filter_var_array($_POST["pdocrud_data"], FILTER_SANITIZE_STRING) : [];
        $post = $_POST;
        if (isset($_FILES)) {
            $post = array_merge($_FILES, $post);
        }
        $data["post"] = $post;
        switch (strtoupper($action)) {
            case "VIEW":
                echo $pdocrud->render("VIEWFORM", $data);
                break;
            case "SORT":
                $pdocrud->setBackOperation();
                $data["action"] = "asc";
                echo $pdocrud->render("CRUD", $data);
                break;
            case "ASC":
                $pdocrud->setBackOperation();
                echo $pdocrud->render("CRUD", $data);
                break;
            case "DESC":
                $pdocrud->setBackOperation();
                echo $pdocrud->render("CRUD", $data);
                break;
            case "ADD":
                echo $pdocrud->render("INSERTFORM", $data);
                break;
            case "INSERT":
                $pdocrud->render("INSERT", $post);
                break;
            case "INSERT_CLOSE":
                $pdocrud->setBackOperation();
                $pdocrud->render("INSERT", $post);
                break;
            case "INSERT_BACK":
                $pdocrud->setBackOperation();
                $pdocrud->render("INSERT", $post);
                $pdocrud->setBackOperation();
                echo $pdocrud->render("CRUD", $data);
                break;
            case "BACK":
                $pdocrud->setBackOperation();
                echo $pdocrud->render("CRUD", $data);
                break;
            case "EDIT":
                $pdocrud->setInlineEdit(false);
                echo $pdocrud->render("EDITFORM", $data);
                break;
            case "INLINE_EDIT":
                $pdocrud->setBackOperation();
                $pdocrud->setInlineEdit(true);
                echo $pdocrud->render("EDITFORM", $data);
                break;
            case "ONEPAGEEDIT":
                $pdocrud->setBackOperation();
                $pdocrud->setInlineEdit(false);
                echo $pdocrud->render("ONEPAGE", $data);
                break;
            case "ONEPAGEVIEW":
                $pdocrud->setBackOperation();
                echo $pdocrud->render("ONEPAGE", $data);
                break;
            case "QUICK_VIEW":
                echo $pdocrud->render("QUICKVIEW", $data);
                break;
            case "RELATED_TABLE":
                echo $pdocrud->render("RELATED_TABLE", $data);
                break;
            case "INLINE_BACK":
                $pdocrud->render("UPDATE", $post);
                echo $pdocrud->render("CRUD", $data);
                break;
            case "UPDATE":
                $pdocrud->render("UPDATE", $post);
                break;
            case "UPDATE_BACK":
                $pdocrud->setBackOperation();
                $pdocrud->render("UPDATE", $post);
                $pdocrud->setBackOperation();
                echo $pdocrud->render("CRUD", $data);
                break;
            case "UPDATE_CLOSE":
                $pdocrud->setBackOperation();
                $pdocrud->render("UPDATE", $post);
                break;
            case "DELETE":
                $pdocrud->render("DELETE", $data);
                $pdocrud->setBackOperation();
                echo $pdocrud->render("CRUD", $data);
                break;
            case "DELETE_SELECTED":
                $pdocrud->render("DELETE_SELECTED", $data);
                $pdocrud->setBackOperation();
                echo $pdocrud->render("CRUD", $data);
                break;
            case "PAGINATION":
                if($data["rendertype"] == "CRUD"){
                    $pdocrud->setBackOperation();
                    $pdocrud->currentPage($data["page"]);
                    echo $pdocrud->render("CRUD", $data);
                } else {
                    $pdocrud->currentPage($data["page"]);
                    echo $pdocrud->render("SQL", $data);
                }
                break;
            case "RECORDS_PER_PAGE":
                if($data["rendertype"] == "CRUD"){
                    $pdocrud->currentPage(1);
                    $pdocrud->recordsPerPage($data["records"]);
                    echo $pdocrud->render("CRUD", $data);
                } else {
                    $pdocrud->currentPage(1);
                    $pdocrud->recordsPerPage($data["records"]);
                    echo $pdocrud->render("SQL", $data);
                }
                break;
            case "SEARCH":
                if($data["rendertype"] == "CRUD"){
                    $pdocrud->currentPage(1);
                    echo $pdocrud->render("CRUD", $data);
                } else {
                    $pdocrud->currentPage(1);
                    echo $pdocrud->render("SQL", $data);
                }
                break;
            case "AUTOSUGGEST":
                if (isset($_GET["callback"])) {
                    $data["callback"] = filter_var($_GET["callback"], FILTER_SANITIZE_STRING);
                }
                echo $pdocrud->render("AUTOSUGGEST", $data);
                break;
            case "EXPORTTABLE":
                echo $pdocrud->render("EXPORTTABLE", $data);
                break;
            case "EXPORTFORM":
                $pdocrud->render("EXPORTFORM", $data);
                break;
            case "SWITCH":
                $pdocrud->setBackOperation();
                $pdocrud->render("SWITCH", $data);
                echo $pdocrud->render("CRUD", $data);
                break;
            case "BTNSWITCH":
                $pdocrud->setBackOperation();
                $pdocrud->render("BTNSWITCH", $data);
                echo $pdocrud->render("CRUD", $data);
                break;
            case "LOADDEPENDENT":
                echo $pdocrud->render("LOADDEPENDENT", $data);
                break;
            case "EMAIL" : echo $pdocrud->render("EMAIL", $post);
                break;
            case "SELECT":
                $pdocrud->setBackOperation();
                echo $pdocrud->render("CRUD", $data);
                break;
            case "SELECTFORM":
                echo $pdocrud->render("SELECT", $post);
                break;
            case "FILTER":
                $pdocrud->setBackOperation();
                $pdocrud->currentPage(1);
                echo $pdocrud->render("CRUD", $data);
                break;
            case "REFRESH":
                if($data["rendertype"] == "CRUD"){
                    echo $pdocrud->render("CRUD", $data);
                } else {
                    echo $pdocrud->render("SQL", $data);
                }
                break;
            case "RELOAD":
                $pdocrud->setBackOperation();
                echo $pdocrud->render("CRUD", $data);
                break;
            case "SAVE_CRUD_TABLE_DATA":
                $pdocrud->setBackOperation();
                $pdocrud->render("SAVE_CRUD_DATA", $data);
                echo $pdocrud->render("CRUD", $data);
                break;
            case "RENDER_ADV_SEARCH":
                $pdocrud->currentPage(1);
                echo $pdocrud->render("CRUD", $data);
                break;
            case "DATE_RANGE_REPORT":
                $pdocrud->setBackOperation();
                $pdocrud->currentPage(1);
                echo $pdocrud->render("CRUD", $data);
                break;
            case "CLONE":
                echo $pdocrud->render("CLONEFORM", $data);
                break;
            case "CELL_UPDATE":
                $updateData[$data["column"]] = $data["content"];
                 if (isset($data["id"]))
                    $pdocrud->setPrimarykeyValue($data["id"]);
                $pdocrud->render("UPDATE", $updateData);
                break;
            case "AJAX_ACTION":
                echo $pdocrud->render("AJAX_ACTION", $data);
                break;   
            case "PRINTPDF":
                echo $pdocrud->render("PRINT_PDF", $data);
                break;   
            default:
                break;
        }
    }
}