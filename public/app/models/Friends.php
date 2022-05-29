<?php

$Friends = new Friends($pdo);

class Friends extends Thinkquotes
{

    // check for friendrequests
    public function getFriendRequests($someid)
    {

        $q = "SELECT * FROM users_friends_requests WHERE got = ?";
        $stmt = $this->select($this->pdo, $q, [$someid], false);

        return $stmt;
    }

    // get all friends array
    public static function getFriends($someid)
    {

        global $pdo;
        $friends = [];

        $getAllFriends = $pdo->prepare("SELECT CASE WHEN user_1_id = ? THEN user_2_id ELSE user_1_id END AS uid FROM users_friends WHERE user_1_id = ? OR user_2_id = ?");
        $getAllFriends->execute([$someid, $someid, $someid]);

        foreach ($getAllFriends->fetchAll() as $gfr) {

            $friendsuid = $gfr->uid;
            $friends[] = $friendsuid;
        }

        return $friends;
    }

    // get all friends of friends
    public static function getFriendsOfFriends($someid)
    {

        global $pdo;
        $acfr = (array) [];

        $getAllFriendsofFriends = $pdo->prepare("SELECT CASE WHEN user_1_id = ? THEN user_2_id ELSE user_1_id END AS uid FROM users_friends WHERE user_1_id = ? OR user_2_id = ?");
        $getAllFriendsofFriends->execute([$someid, $someid, $someid]);

        foreach ($getAllFriendsofFriends->fetchAll() as $gfrofr) {

            $fruid = $gfrofr->uid;
            $acfr[] = $fruid;
        }

        $fr = (array) [];
        foreach ($acfr as $friendID) {
            $getAllFriendsofFriends->execute([$friendID, $friendID, $friendID]);
            foreach ($getAllFriendsofFriends->fetchAll() as $frofr) {
                $frofruid = $frofr->uid;
                $fr[] = $frofruid;
            }
        }

        if (empty($fr)) {
            return (array) $fr;
        } else {
            (array) $f = array_unique($fr);
            return $f;
        }

        return null;
    }
}
