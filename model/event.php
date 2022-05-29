<?

class Event {
    static public function getEvents($user_id, $group_id, $where_param, $limit, $offset) {
        global $mysqli;

        $query_array = [];

        $query = $mysqli->query("SELECT * FROM `event` WHERE `author_id` = '$user_id' $offset $where_param UNION SELECT * FROM `event` WHERE `group_id` = '$group_id' $offset $where_param $limit");

        for ($i = 0; $i < $query->num_rows; $i++) {
            $query_array[] = $query->fetch_assoc(); 
        }
        return $query_array;
    }

    static public function createEvent($title, $description, $phone, $color, $day, $month, $year, $time, $author_id, $group_id) {
        global $mysqli;

        if ($group_id) {
            return $mysqli->query("INSERT INTO `event` (`event_id`, `title`, `description`, `phone`, `color`, `day`, `month`, `year`, `time`, `author_id`, `group_id`) VALUES (NULL, '$title', '$description', '$phone', '$color', '$day', '$month', '$year', '$time', '$author_id', '$group_id')");
        }

        return $mysqli->query("INSERT INTO `event` (`event_id`, `title`, `description`, `phone`, `color`, `day`, `month`, `year`, `time`, `author_id`, `group_id`) VALUES (NULL, '$title', '$description', '$phone', '$color', '$day', '$month', '$year', '$time', '$author_id', NULL)");
    }

    static public function updateEvent($event_id, $title, $description, $phone, $color, $day, $month, $year, $time, $author_id, $group_id) {
        global $mysqli;

        if ($group_id) {
            return $mysqli->query("UPDATE `event` SET `title` = '$title', `description` = '$description', `phone` = '$phone', `color` = '$color', `day` = '$day', `month` = '$month', `year` = '$year', `time` = '$time' WHERE `event_id` = '$event_id' AND (`author_id` = '$author_id' OR `group_id` = '$group_id')");
        }

        return $mysqli->query("UPDATE `event` SET `title` = '$title', `description` = '$description', `phone` = '$phone', `color` = '$color', `day` = '$day', `month` = '$month', `year` = '$year', `time` = '$time' WHERE `event_id` = '$event_id' AND `author_id` = '$author_id'");
    }

    static public function deleteEvent($event_id, $author_id, $group_id) {
        global $mysqli;

        return $mysqli->query("DELETE FROM `event` WHERE `event_id` = '$event_id' AND (`author_id` = '$author_id' OR `group_id` = '$group_id')");
    }
}

?>