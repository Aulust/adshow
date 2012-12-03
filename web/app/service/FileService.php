<?php

class FileService {
    static private $uploadDir = 'uploads/';
    static private $supportedImageTypes = array('image/gif' => 'gif',
                                                'image/jpeg' => 'jpg',
                                                'image/png' => 'png');

    public function uploadImage($file, $fileDao) {
        if($file !== null && $file['error'] === UPLOAD_ERR_OK) {
            $info = getimagesize($file['tmp_name']);

            if($info != false && array_key_exists($info['mime'], FileService::$supportedImageTypes)) {
                $name = $fileDao->getUniqueName();

                if($name !== null) {
                    $fileName = $name . '.' . FileService::$supportedImageTypes[$info['mime']];

                    if($name !== null && move_uploaded_file($file['tmp_name'], FileService::$uploadDir . $fileName) === true) {
                        return $fileName;
                    }
                }
            }
        }

        return null;
    }
}
