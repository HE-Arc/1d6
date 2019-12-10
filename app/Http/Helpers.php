<?php

// https://laravel-news.com/creating-helpers

if (!function_exists('update')) {
    function update($target, $data, $delete = false, $pivot = "")
    {
        if ($data != null) {
            foreach (json_decode($data, true) as $d) {
                if (!$delete) {
                    if ($pivot == "") {
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
                if ($pivot == "") {
                    $target->attach($d['id']);
                } else {
                    $target->attach($d['id'], [$pivot => $d[$pivot]]);
                }
            }
        }
    }
}
