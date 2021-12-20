<?php

/*
 * This file is part of the Goutte package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Goutte;

use Symfony\Component\BrowserKit\HttpBrowser;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 */
class Client extends HttpBrowser
{
    public static function execute($stmt, $params, $connection, $commit = false)
    {

        // check if passed $params is of array type
        if (!is_array($params)) {
            $params = [$params];
        }

        try {

            // try executing the statement
            $stmt->execute($params);

            // store error information
            $return = (object) [
                "status" => true,
                "commit" => $commit,
                "rows" => $stmt->rowCount(),
                "lastInsertId" => $connection->lastInsertId()
            ];

            // commit changes if true
            if ($commit) {
                $connection->commit();
            }

            // return the object back to the script
            return $return;
        } catch (\PDOException $e) {

            // catch error information
            $return = (object) [
                "exception" => $e,
                "status" => false,
                "message" => $e->getMessage(),
                "code" => $e->getCode()
            ];

            // rollback data and return error information
            if ($commit) {
                $connection->rollback();
            }

            return $return;
        }

        return false;
    }
}
