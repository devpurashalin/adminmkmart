<?php

namespace App\Traits;

trait SystemAddonTrait
{
    /**
     * @return array
     */
    public function get_addons(): array
    {
        $dir = base_path('Modules');
        $directories = self::getDirectories($dir);

        $addons = [];
        foreach ($directories as $directory) {
            $sub_dirs = self::getDirectories($dir . '/' . $directory);
            if (in_array('Addon', $sub_dirs)) {
                $addons[] = $dir . '/' . $directory;
            }
        }

        $array = [];
        foreach ($addons as $item) {
            $infoFile = $item . '/Addon/info.php';
            if (file_exists($infoFile)) {
                $full_data = include($infoFile);
                $array[] = [
                    'addon_name' => $full_data['name'],
                    'software_id' => $full_data['software_id'],
                    'is_published' => $full_data['is_published'],
                ];
            }
        }

        return $array;
    }

    /**
     */
    public function get_addon_admin_routes(): array
    {
        $dir = base_path('Modules');
        $directories = self::getDirectories($dir);
        $addons = [];
        foreach ($directories as $directory) {
            $sub_dirs = self::getDirectories($dir . '/' . $directory);
            if (in_array('Addon', $sub_dirs)) {
                $addons[] = $dir . '/' . $directory;
            }
        }

        $full_data = [];
        foreach ($addons as $item) {
            $infoFile = $item . '/Addon/info.php';
            if (file_exists($infoFile)) {
                $info = include($infoFile);
                if ($info['is_published']) {
                    $adminRoutesFile = $item . '/Addon/admin_routes.php';
                    if (file_exists($adminRoutesFile)) {
                        $full_data[] = include($adminRoutesFile);
                    }
                }
            }
        }

        return $full_data;
    }

    /**
     * @return array
     */
    public function get_payment_publish_status(): array
    {
        $dir = base_path('Modules'); // Adjust the directory path to Modules/Gateways if necessary
        $directories = self::getDirectories($dir);
        $addons = [];
        foreach ($directories as $directory) {
            $sub_dirs = self::getDirectories($dir . '/' . $directory);
            if ($directory == 'Gateways' && in_array('Addon', $sub_dirs)) {
                $addons[] = $dir . '/' . $directory;
            }
        }

        $array = [];
        foreach ($addons as $item) {
            $infoFile = $item . '/Addon/info.php';
            if (file_exists($infoFile)) {
                $full_data = include($infoFile);
                $array[] = [
                    'is_published' => $full_data['is_published'],
                ];
            }
        }

        return $array;
    }

    /**
     * @param string $path
     * @return array
     */
    function getDirectories(string $path): array
    {
        if (!is_dir($path)) {
            return [];
        }

        $directories = [];
        $items = scandir($path);
        foreach ($items as $item) {
            if ($item == '..' || $item == '.')
                continue;
            if (is_dir($path . '/' . $item))
                $directories[] = $item;
        }
        return $directories;
    }
}