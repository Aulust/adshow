<?php

$app->post('/upload/image', function () use($app, $fileService, $fileDao) {
    $imageFile = isset($_FILES['imageFile']) ? $_FILES['imageFile'] : null;
    $response = array('status' => 200, 'data' => '');

    $imageUrl = $fileService->uploadImage($imageFile, $fileDao);
    if($imageUrl === null) {
        $response['status'] = 400;
    }

    $response['data'] = $imageUrl;
    $app->response()->write(json_encode($response));
});
