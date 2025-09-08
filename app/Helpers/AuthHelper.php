<?php
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

function createApiToken($model, array $abilities = ['*'])
    {
        $plain = Str::random(60);

        $model->apiTokens()->create([
            'token_hash' => Hash::make($plain),
            'abilities' => $abilities,
        ]);

        return $plain;
    }