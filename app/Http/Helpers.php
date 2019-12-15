<?php

// https://laravel-news.com/creating-helpers

if (!function_exists('addLoggedUserToData')) {
    /**
     * Check if $userId is found in the $data array, calls appropriate function and return the data modified
     */
    function addLoggedUserToData($data, $key, $userId, $onFound, $onNotFound)
    {
        $users = $data;
        $hasLoggedUser = false;

        foreach ($users as $k => $value) {
            if (intval($value->$key) === $userId) {
                $hasLoggedUser = true;
                $onFound($users, $k);
                break;
            }
        }

        if (!$hasLoggedUser) {
            $onNotFound($users);
        }

        return $users;
    }
}

if (!function_exists('jsonDecodeToArray')) {
    /**
     * Decode json, if it fails or is empty, returns an empty array
     */
    function jsonDecodeToArray($data, $assoc = false)
    {
        $data = json_decode($data, $assoc);

        if (!is_array($data)) {
            return [];
        }
        else {
            return $data;
        }
    }
}
