<?php

// https://laravel-news.com/creating-helpers

if (!function_exists('update')) {
    function update($target, $data, $delete = false, $pivot = "")
    {
        if ($data != null) {
            foreach (json_decode($data, true) as $d) {
                if (!$delete) {
                    if ($pivot === "") {
                        $target->sync($d['id'], false);
                    } else {
                        $target->sync([$d['id'], [$pivot => $d[$pivot]]], false);
                    }
                } else {
                    $target->detach($d['id']);
                }
            }
        }
    }
}

if (!function_exists('attach')) {
    function attach($target, $data, $pivot = "")
    {
        if ($data != null) {
            foreach (json_decode($data, true) as $d) {
                if ($pivot === "") {
                    $target->attach($d['id']);
                } else {
                    $target->attach($d['id'], [$pivot => $d[$pivot]]);
                }
            }
        }
    }
}

if (!function_exists('addLoggedUserToData')) {
    /**
     * Check if $userId is found in the $data array (passed as a string), calls appropriate function and return the data as a string
     */
    function addLoggedUserToData($data, $key, $userId, $onFound, $onNotFound)
    {
        $users = json_decode($data);

        if (!is_array($users)) {
            $users = [];
        }

        $hasLoggedUser = false;

        foreach ($users as $k => $value) {
            if ($value->$key === $userId) {
                $hasLoggedUser = true;
                $onFound($users, $k);
                break;
            }
        }

        if (!$hasLoggedUser) {
            $onNotFound($users);
        }

        // That's not very smart, but that's how the rest of the code works
        return json_encode($users);
    }
}
