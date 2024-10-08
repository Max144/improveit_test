<?php

require 'src/services/CheckPermissionService.php';

$user1Name = "User 1";
$user2Name = "User 2";
$user3Name = "User 3";
$user4Name = "User 4";

$permission1Name = "Function 1";
$permission2Name = "Function 2";
$permission3Name = "Function 3";
$permission4Name = "Function 4";

displayIfUserHaveAccess($user1Name, $permission1Name);
displayIfUserHaveAccess($user1Name, $permission2Name);
displayIfUserHaveAccess($user1Name, $permission3Name);
displayIfUserHaveAccess($user1Name, $permission4Name);

echo "\n";
echo "-----------------------------------\n";

displayIfUserHaveAccess($user2Name, $permission1Name);
displayIfUserHaveAccess($user2Name, $permission2Name);
displayIfUserHaveAccess($user2Name, $permission3Name);
displayIfUserHaveAccess($user2Name, $permission4Name);

echo "\n";
echo "-----------------------------------\n";

displayIfUserHaveAccess($user3Name, $permission1Name);
displayIfUserHaveAccess($user3Name, $permission2Name);
displayIfUserHaveAccess($user3Name, $permission3Name);
displayIfUserHaveAccess($user3Name, $permission4Name);

echo "\n";
echo "-----------------------------------\n";

displayIfUserHaveAccess($user4Name, $permission1Name);
displayIfUserHaveAccess($user4Name, $permission2Name);
displayIfUserHaveAccess($user4Name, $permission3Name);
displayIfUserHaveAccess($user4Name, $permission4Name);


function displayIfUserHaveAccess(string $userName, string $permissionName): void
{
    if (CheckPermissionService::checkUserHasPermission($userName, $permissionName)) {
        echo "$userName has access to $permissionName\n";
    } else {
        echo "$userName does not have access to $permissionName\n";
    }
}