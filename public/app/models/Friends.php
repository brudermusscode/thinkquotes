<?php

$Friends = new Friends;

class Friends
{

    // check for friendrequests
    public static function getFriendrequests($someid)
    {

        global $pdo;

        $getRequests = $pdo->prepare("SELECT * FROM users_friends_requests WHERE got = ?");
        $getRequests->execute([$someid]);
        $rowCount = $getRequests->rowCount();

        if ($rowCount > 0) {
            return $rowCount;
        } else {
            return false;
        }
    }

    // get all friends array
    public static function getFriends($someid)
    {

        global $pdo;
        $friends = [];

        $getAllFriends = $pdo->prepare("SELECT CASE WHEN uid1 = ? THEN uid2 ELSE uid1 END AS uid FROM users_friends WHERE uid1 = ? OR uid2 = ?");
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

        $getAllFriendsofFriends = $pdo->prepare("SELECT CASE WHEN uid1 = ? THEN uid2 ELSE uid1 END AS uid FROM users_friends WHERE uid1 = ? OR uid2 = ?");
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
