<?php

namespace App\Services;

class CheckExtensionServices
{

  public static function checkExtension($fileData, $extension){

    $extension = mb_strtolower($extension); //拡張子が大文字の場合、ここで小文字で変換

    if ($extension === 'jpg'){
      $data_url = 'data:image/jpg;base64,'. base64_encode($fileData);
    }

    if ($extension === 'jpeg'){
      $data_url = 'data:image/jpeg;base64,'. base64_encode($fileData);
    }

    if ($extension === 'png'){
      $data_url = 'data:image/png;base64,'. base64_encode($fileData);
    }

    if ($extension === 'gif'){
      $data_url = 'data:image/gif;base64,'. base64_encode($fileData);
    }

    return $data_url;
  }
}

