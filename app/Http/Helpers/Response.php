<?php
function successResponseWithData($data)
{
    return response()->json($data, 200);
}

function successResponse($message)
{
    $data = [
        'message' => $message,
    ];
    return response()->json($data, 200);
}

function validationErrors($errors)
{
    $data = [
        'errors' => $errors,
    ];

    return response()->json($data, 422);
}

function notFoundResponse($message)
{
    return response()->json(['message' => $message], 404);
}
