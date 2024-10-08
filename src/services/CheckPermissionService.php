<?php

require_once 'src/database/MySqlDatabaseConnection.php';

class CheckPermissionService
{
    public static function checkUserHasPermission(string $userName, string $permissionName): bool
    {
        /*
            here we make 3 queries and combine the results with UNION:

            the first query checks if the user permission through permission group
            the second query checks if the user permission through user group permissions
            the third query checks if the user permission through user group permission group

            if at least one of the queries returns a result, the user has permission

            if there are a lot of data it could be better to make 3 separate queries instead of one here, also
            we could get user id by name and use it in the query instead of name to improve performance
        */
        $query = "
            SELECT count(1)
                FROM (
                    SELECT permissions.name
                        FROM users
                            INNER JOIN permission_group_users ON users.id = permission_group_users.user_id
                            INNER JOIN permissions ON permission_group_users.permission_group_id = permissions.permission_group_id
                                AND permissions.name = :permissionName
                    WHERE users.name = :userName
                    UNION
                    SELECT permissions.name
                        FROM users
                            INNER JOIN permission_user_groups ON users.group_id = permission_user_groups.user_group_id
                            INNER JOIN permissions ON permission_user_groups.permission_id = permissions.id
                                AND permissions.name = :permissionName
                    WHERE users.name = :userName
                    UNION
                    SELECT permissions.name
                        FROM users
                            INNER JOIN permission_group_user_groups ON users.group_id = permission_group_user_groups.user_group_id
                            INNER JOIN permissions ON permission_group_user_groups.permission_group_id = permissions.permission_group_id
                                AND permissions.name = :permissionName
                     WHERE users.name = :userName
                ) as result;";

        //execute query
        $conn = (new MySqlDatabaseConnection())->connect();
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':permissionName', $permissionName);
        $stmt->bindParam(':userName', $userName);
        $stmt->execute();

        $result = $stmt->fetchColumn();

        return $result > 0;
    }
}