<?php

class mainClass
{

    public function getStates()
    {
        try {
            $db = getDB();
            $stmt = $db->prepare("SELECT id, name, short_name, team_price, personal_price, status FROM states ORDER BY id ASC");

            $stmt->execute();
            $data = $stmt->fetchAll(); //User data

            //print_r($data);
            $data_new = [];
            foreach ($data as $d) {
                $data_new[$d['id']] = $d;
            }
            //print_r($data_new);
            return $data_new;

        } catch (PDOException $e) {
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

    public function getActiveStates()
    {
        try {
            $db = getDB();
            $stmt = $db->prepare("SELECT id, name, short_name, team_price, personal_price, status FROM states where status=TRUE ORDER BY id ASC");

            $stmt->execute();
            $data = $stmt->fetchAll(); //User data

            //print_r($data);
            $data_new = [];
            foreach ($data as $d) {
                $data_new[$d['id']] = $d;
            }
            //print_r($data_new);
            return $data_new;

        } catch (PDOException $e) {
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }


    public function updateState_status($state_id, $data)
    {
        try {

            if (key_exists('status', $data)) {

                $status = ($data['status']) ? TRUE : FALSE;
                $db = getDB();
                //update status
                $stmt = $db->prepare("UPDATE states SET status=:status WHERE id=:sid");
                $stmt->bindParam("sid", $state_id, PDO::PARAM_INT);
                $stmt->bindParam("status", $status, PDO::PARAM_BOOL);
                $stmt->execute();
                $db = null;
                return true;
            } else {
                return "Status Not Defined";
            }

        } catch (PDOException $e) {
            return $e->getMessage();
        }

    }

    public function remove_state($state_id)
    {
        try {

            $db = getDB();
            //update status
            $stmt = $db->prepare("DELETE FROM states WHERE id=:sid");
            $stmt->bindParam("sid", $state_id, PDO::PARAM_INT);
            $stmt->execute();
            $db = null;
            return true;


        } catch (PDOException $e) {
            return $e->getMessage();
        }

    }

    public function updateState($state_id, $data)
    {
        try {

            $status = ($data['status']) ? TRUE : FALSE;

            $db = getDB();
            $stmt = $db->prepare("UPDATE states SET name=:state_name,short_name=:short_name, team_price=:team_price, personal_price=:personal_price, status=:status WHERE id=:sid");
            $stmt->bindParam("sid", $state_id, PDO::PARAM_INT);
            $stmt->bindParam("state_name", $data['name'], PDO::PARAM_STR);
            $stmt->bindParam("short_name", $data['short_name'], PDO::PARAM_STR);
            $stmt->bindParam("team_price", $data['team_price'], PDO::PARAM_STR);
            $stmt->bindParam("personal_price", $data['personal_price'], PDO::PARAM_STR);
            $stmt->bindParam("status", $status, PDO::PARAM_BOOL);
            $stmt->execute();
            $db = null;
            return true;

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function createState($data)
    {
        try {

            $status = ($data['status']) ? TRUE : FALSE;
            $db = getDB();
            $stmt = $db->prepare("INSERT INTO states(name, short_name, team_price, personal_price, status) VALUES (:state_name, :short_name, :team_price, :personal_price, :status)");
            $stmt->bindParam("state_name", $data['name'], PDO::PARAM_STR);
            $stmt->bindParam("short_name", $data['short_name'], PDO::PARAM_STR);
            $stmt->bindParam("team_price", $data['team_price'], PDO::PARAM_STR);
            $stmt->bindParam("personal_price", $data['personal_price'], PDO::PARAM_STR);
            $stmt->bindParam("status", $status, PDO::PARAM_BOOL);
            $stmt->execute();
            $db = null;
            return true;

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }


    public function getExtraUsersTiers()
    {
        return [0, 5, 10, 20, 50, 100];
    }

    public function alert($type, $text)
    {
        $types = array('error' => 'danger', 'success' => 'success', 'warning' => 'warning');
        return '<div class="alert alert-' . $types[$type] . '" role="alert">' . $text . '</div>';
    }

    public function getFilesArray(&$file_post)
    {
        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);

        for ($i = 0; $i < $file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }
        return $file_ary;
    }

    private function getPaginationPages($page_count, $page_limit, $page_current, $adjacents)
    {
        if ($page_count == 0)
            return array(1);

        $result = array();
        if (isset($page_count, $page_limit) === true) {
            $result = range(1, ceil($page_count / $page_limit));
            if (isset($page_current, $adjacents) === true) {
                if (($adjacents = floor($adjacents / 2) * 2 + 1) >= 1) {
                    $result = array_slice($result, max(0, min(count($result) - $adjacents, intval($page_current) - ceil($adjacents / 2))), $adjacents);
                }
            }
        }
        return $result;
    }

    public function getPagination($table_name, $limit, $conditions = [])
    {
        $db = getDB();


        /*$conditions_string = implode(' AND ', array_map(function ($entry) {
            return $entry[0] . ' ' . $entry[1] . ' :' . $entry[0];
        }, $conditions));*/
        $conditions_array = [];
        for ($i = 0; $i < sizeof($conditions); $i++) {
            $condition_string = $conditions[$i][0] . ' ' . $conditions[$i][1] . ' :' . $conditions[$i][0] . '_' . $i;
            array_push($conditions_array, $condition_string);
        }
        $conditions_string = implode(' AND ', $conditions_array);

        if (sizeof($conditions) == 0) {
            $stmt = $db->prepare("SELECT COUNT(*) FROM " . $table_name);
        } else {
            $stmt = $db->prepare("SELECT COUNT(*) FROM " . $table_name . ' WHERE ' . $conditions_string);
            $cond_i = 0;
            foreach ($conditions as $condition)
                $stmt->bindParam(':' . $condition[0] . '_' . $cond_i++, $condition[2], $condition[3]);;
        }

        $stmt->execute();
        $total = $stmt->fetchColumn();


        $pages = ceil($total / $limit);

        $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
            'options' => array(
                'default' => 1,
                'min_range' => 1,
            ),
        )));


        $offset = ($page - 1) * $limit;
        if ($offset < 0)
            $offset = 0;
        if ($page < 1)
            $page = 1;

        $pagination_html = '<div class="text-center"><ul class="pagination">';
        $adjacent_links = 4;

        unset($_GET['page']);
        $params_urls = http_build_query($_GET);

        $pagination = $this->getPaginationPages($total, $limit, $page, $adjacent_links);
        //first page
        $pagination_html .= $page > 1 ? '<li><a href="?' . $params_urls . '&page=1">&laquo;</a></li>' : '<li class="disabled"><a>&laquo;</a></li>';
        //previous page
        $pagination_html .= $page > 1 ? '<li><a href="?' . $params_urls . '&page=' . ($page - 1) . '">&lsaquo;</a></li>' : '<li class="disabled"><a>&lsaquo;</a></li>';
        for ($i = 0; $i < sizeof($pagination); $i++) {
            $pagination_html .= '<li' . ($pagination[$i] == $page ? ' class="active"' : '') . '><a href="?' . $params_urls . '&page=' . $pagination[$i] . '">' . $pagination[$i] . '</a></li>';
        }
        //next page
        $pagination_html .= $page < $pages ? '<li><a href="?' . $params_urls . '&page=' . ($page + 1) . '">&rsaquo;</a></li>' : '<li class="disabled"><a>&rsaquo;</a></li>';
        //last page
        $pagination_html .= $page < $pages ? '<li><a href="?' . $params_urls . '&page=' . $pages . '">&raquo;</a></li>' : '<li class="disabled"><a>&raquo;</a></li>';

        $pagination_html .= '</ul></div>';

        return array('html' => $pagination_html, 'page' => $page, 'offset' => $offset, 'limit' => $limit, 'conditions' => $conditions, 'table_name' => $table_name);
    }
}

?>