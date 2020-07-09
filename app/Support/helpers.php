<?php

/**
 * render the variables in views files
 *
 * @param string $view
 * @param array  $data
 */
function view(string $view, array $data = [])
{
    if ($data) extract($data);

    ob_start();

    require base_path() . '/app/views/' . $view . '.php';

    $contentInLayout = ob_get_clean();

    require base_path() . '/app/views/layouts/layout.php';

    exit();
}

/**
 * @param string|null $file
 * @return string
 */
function base_path(string $file = null)
{
    if ($file) {
        return dirname(dirname(dirname(__FILE__))) . '/' . $file;
    }

    return dirname(dirname(dirname(__FILE__)));
}

/**
 * upload a files
 *
 * @param        $dir
 * @param        $filename
 * @param string $format
 * @return array
 */
function uploadFile($dir, $filename, $format = 'csv')
{
    $result = [
        'success' => false,
        'filename' => '',
        'error' => '',
    ];

    $targetFile = $dir . basename($_FILES[$filename]["name"]);

    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    if ($fileType !== $format) {
        $result['success'] = false;
        $result['error'] = "Sorry, file should be csv format";
    }

    if (move_uploaded_file($_FILES[$filename]["tmp_name"], $targetFile)) {
        $result['success'] = true;
        $result['filename'] = basename($_FILES[$filename]["name"]);
    } else {
        $result['success'] = false;
        $result['error'] = "Sorry, there was an error uploading your file.";
    }

    return $result;
}

/**
 * curl helper
 *
 * @param $url
 * @return bool|string
 */
function curlCall($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);

    return $output;
}
